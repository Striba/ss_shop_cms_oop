<?php

/**
 * Класс методов стартовой страницы сайта
 *
 * @author Strybko SS
 */
class SiteController {
    
    /**
     * Управление стартовой станыцей
     * 
     */
    public function actionIndex() {

        //Инициализация шаблонизатора SMARTY
        $smarty = $_SESSION['smarty'];        

        //Получение переменных категорий и продуктов 
        //для передачи в представления
        $rsCategories = Categories::getAllMainCatsWithChildren();
        $rsProducts = Products::getLastProducts(16);

        //Инициализация переменных шаблонизатора SMARTY
        $smarty->assign('pageTitle', 'Главная страница сайта');
        $smarty->assign('rsCategories', $rsCategories);
        $smarty->assign('rsProducts', $rsProducts);

        //Подключение файллов представления
        loadTemplate($smarty, 'header');
        loadTemplate($smarty, 'index');
        loadTemplate($smarty, 'footer');
        
        return TRUE;
    }

}
