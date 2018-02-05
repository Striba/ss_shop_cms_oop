<?php

/* 
 * 
 * Контроллер страницы категории (/category/1)
 * 
 */

class CategoryController {
    
    /**
     * формирование страницы категории
     * 
     * @param string $catId номер-айди катергории(из комендной строки)
     */
    public function actionIndex ($catId){
        
        //Инициализируем наши переменные:
        $rsCategory = null;
        $rsProducts = null;
        $rsChildCats = null;

        $rsCategory = Categories::getCatById($catId);
        
        //если главная категория, то показываем дочернюю категорию,
        //иначе показывает товар
        if($rsCategory['parent_id'] == 0){
             $rsChildCats = Categories::getChildrenForCat($catId);
        } else {
             $rsProducts = Products::getProductsByCat($catId);
        }
        
        $rsCategories = Categories::getAllMainCatsWithChildren();
        
        //Инициализация шаблонизатора SMARTY
        $smarty = $_SESSION['smarty'];

        $smarty->assign('pageTitle', 'Товары категории '.$rsCategory['name']);

        $smarty->assign('rsCategory', $rsCategory);
        $smarty->assign('rsProducts', $rsProducts);
        $smarty->assign('rsChildCats', $rsChildCats);

        $smarty->assign('rsCategories', $rsCategories);

        loadTemplate($smarty, 'header');
        loadTemplate($smarty, 'category');
        loadTemplate($smarty, 'footer');
        
        return TRUE;

    }

}
