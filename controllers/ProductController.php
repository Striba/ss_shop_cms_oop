<?php

/**
 * 
 * Контроллер страницы товара (product/1)
 * 
 */

class ProductController {
    
    /**
     * формирование страницы продукта
     * 
     * @param string $itemId ID продукта, из комендной строки.
     */
    public function actionIndex($itemId){

        // Получить данные продукта:
        $rsProduct = Products::getProductById($itemId);

        //Получить все категории
        $rsCategories = Categories::getAllMainCatsWithChildren();
        
        //Инициализация шаблонизатора SMARTY
        $smarty = $_SESSION['smarty'];

        $smarty->assign('itemInCart',0);
        if (in_array($itemId, $_SESSION['cart'])){
            $smarty->assign('itemInCart',1);
        }

        $smarty->assign('pageTitle', '');
        $smarty->assign('rsCategories', $rsCategories);
        $smarty->assign('rsProduct', $rsProduct);

        loadTemplate($smarty, 'header');
        loadTemplate($smarty, 'product');
        loadTemplate($smarty, 'footer');
        
        return true;

    }
    
}


