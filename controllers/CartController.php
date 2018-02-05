<?php

/**
 * 
 * Контроллер работы с корзиной (/cart/)
 * 
 */

class CartController {
    
    /**
     * Добавление продуктов корзину
     * 
     * @param integer $itemId GET параметр - ID добавляемого продукта
     * @return json информация об операции (успех, кол-во элементов в конзине)
     */
    public function actionAddtocart($itemId){

        $resData = array();

        //если значение не найдено, то добавляем
        if(isset($_SESSION['cart']) && array_search($itemId, $_SESSION['cart']) === FALSE){
            $_SESSION['cart'][] = $itemId;
            $resData['cntItems'] = count($_SESSION['cart']);
            $resData['success'] = 1;
        }  else {
            $resData['success'] = 0;
        }

        echo json_encode($resData);
        return true;
    }
    
    /**
     * Удаление продуктов из корзины
     * 
     * @param integer $itemId GET параметр - ID удаляемого из корзины продукта
     * @return json информация об операции (успех, кол-во элементов в конзине)
     */
    public function actionRemovefromcart($itemId){

        $resData = array();
        $key = array_search($itemId, $_SESSION['cart']);
        //если значение не найдено, то добавляем
        if($key !== FALSE){
            unset($_SESSION['cart'][$key]);
            $resData['cntItems'] = count($_SESSION['cart']);
            $resData['success'] = 1;
        }  else {
            $resData['success'] = 0;
        }

        echo json_encode($resData);
        return true;
    }
    
    /**
     * Формирование страницы корзины
     * 
     * @link /cart/ 
     */
    public function actionIndex(){

        $itemIds = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();

        // Получить данные продуктов из массива:
        $rsProducts = Products::getProductsFromArray($itemIds);

        //Получить все категории
        $rsCategories = Categories::getAllMainCatsWithChildren();
        
        //Инициализация шаблонизатора SMARTY
        $smarty = $_SESSION['smarty'];

        $smarty->assign('pageTitle', 'Корзина');
        $smarty->assign('rsCategories', $rsCategories);
        $smarty->assign('rsProducts', $rsProducts);

        loadTemplate($smarty, 'header');
        loadTemplate($smarty, 'cart');
        loadTemplate($smarty, 'footer');
        
        return TRUE;
    }
    
    
    /**
     * Формирование страницы заказа
     * 
     */
    public function actionOrder(){
        // получаем массив идентификаторов (ID) продуктов корзины:
        $itemsIds = isset($_SESSION['cart']) ? $_SESSION['cart'] : NULL;
        //если корзина пуста, то редиректим в корзину:
        if(!isset($itemsIds)){
            redirect('/cart/');
            return TRUE;
        }
        
        //получаем из массива $_POST колличество покупаемых товаров
        $itemsCnt = array();
        foreach ($itemsIds as $item) {
            //формируем ключ для массива POST:
            $postVar = 'itemCnt_' . $item;
            //создаем элемент массива колличества покупаемого товара
            //ключ массива - ID товара, значение массива - колличество товара
            // $itemsCnt[1] = 3; товар с ID == 1 покупают 3 штуки
            $itemsCnt[$item] = isset($_POST[$postVar]) ? $_POST[$postVar] : null; 
        }

        //получаем список продуктов по массиву корзины
        $rsProducts = Products::getProductsFromArray($itemsIds);

        //добавляем каждому продукту дополнительное поле
        //"realPrice = колличество прдуктов * цену продукта"
        //"cnt" = колличкство покупаемого товара

        //&$item - для того, чтобы при изменении переменной $item
        //менялся и элемент массива $rsProducts
        $i = 0;
        foreach($rsProducts as &$item){
            $item['cnt'] = isset($itemsCnt[$item['id']]) ? $itemsCnt[$item['id']] : 0;
            if ($item['cnt']){
                $item['realPrice'] = $item['cnt'] * $item['price'];
            } else {
                //если получилось так, что товар в корзине есть, а колличество == нулю
                //то удаляем этот товар
                unset($rsProducts[$i]);
            }
            $i++;
        }
        
        //d($rsProducts);

        if(! $rsProducts){
            echo 'Корзина пуста';
            return;
        }

        //полученный массив покупаемых товаров помещаем в сессионную переменную:
        $_SESSION['saleCart'] = $rsProducts;

        //$rsCategories = getAllMainCatsWithChildren();
        $rsCategories = Categories::getAllMainCatsWithChildren();
        
        //Инициализация шаблонизатора SMARTY
        $smarty = $_SESSION['smarty'];

        // hideLoginBox - переменная флаг, для того чтобы спрятать блоки логина и регистрации
        // в боковой панели
        if(! isset($_SESSION['user'])){
            $smarty->assign('hideLoginBox', 1);
        }

        $smarty->assign('pageTitle','Заказ');
        $smarty->assign('rsCategories', $rsCategories);
        $smarty->assign('rsProducts', $rsProducts);

        loadTemplate($smarty, 'header');
        loadTemplate($smarty, 'order');
        loadTemplate($smarty, 'footer');
        
        return TRUE;

    }
    
    /**
     * AJAX функция сохранения заказа
     * 
     * @param array $_SESSION['saleCart'] массив покупаемых продуктов
     * @return json информация о результате выполнения
     */
    public function actionSaveorder(){
        //получаем массив покупаемых товаров
        $cart = isset($_SESSION['saleCart']) ? $_SESSION['saleCart'] : null;

        //если корзина пуста, то формируем ответ с ошибкой, отдаем его
        // в формате json и выходим из функции
        if(! $cart){
            $resData['success'] = 0;
            $resData['message'] = 'Нет товаров для заказа';
            echo json_encode($resData);
            return;
        }

        //после на этом месте еще осуществить проверку на существование
        // ниже перечисленных переменных
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $adress = $_POST['adress'];

        //создаем новый заказ и получаем его ID
        $orderId = makeNewOrder($name, $phone, $adress);

        //если заказ не создан, то выдаем ошибку и звершаем функцию.
        if(! $orderId){
            $resData['success'] = 0;
            $resData['message'] = 'Ошибка создания заказа';
            echo json_encode($resData);
            return;
        }

        //сохраняем товаря для созданного заказа:
        $res = setPurchaseForOrder($orderId, $cart);

        //если успешно, то формируем ответ, удаляем переменные корзины
        if($res){
            $resData['success'] = 1;
            $resData['message'] = 'Заказ сохранен';
            unset($_SESSION['saleCart']);
            unset($_SESSION['cart']);
        } else {
            $resData['success'] = 0;
            $resData['message'] = 'Ошибка внесения данных для заказа №' . $orderId;
        }

        echo json_encode($resData);
    }

    
}
