<?php

/**
 * Модель для таблицы продукции (products)
 * 
 */

class Products {

    /**
     * Получаем последние добавленные товары
     * 
     * @param integer $limit лимит товаров
     * @return array Массив товаров
     */
    public static function getLastProducts($limit = null){

        $db = Db::getConnection();
        
        $sql = "SELECT * FROM `products` ORDER BY id DESC";
        if($limit){
            $sql .= " LIMIT {$limit}";
        }
        
        $rs = $db->query($sql);

        return createSmartyRsArray($rs);
    }
    
    /**
     * Получить продукты для категории $itemId
     * 
     * @param integer $itemId ID категории
     * @return array массив продуктов
     */
    public static function getProductsByCat($itemId) {
        
        //Подключение к БД
        $db = Db::getConnection();

        $itemId = intval($itemId);
        $sql = "SELECT * FROM products WHERE category_id = '{$itemId}'";

        $rs = $db->query($sql);

        return createSmartyRsArray($rs);

    }
    
    /**
     * Получить данные продукта по id
     * 
     * @param integer $itemId ID продукта
     * @return array массив данных продукта
     */
    public static function getProductById($itemId) {
        
        //Подключение к БД
        $db = Db::getConnection();
        
        $sql = "SELECT * "
                . "FROM `products` "
                . "WHERE id='{$itemId}'";
                
        $rs = $db->query($sql);

        return $rs->fetch(PDO::FETCH_ASSOC);

    }
    
    /**
     * Получить список продуктов из массива идентификаторов (ID's)
     * 
     * @param array $itemIds массив идентификаторов продуктов
     * @return array массив данных продуктов
     */
    public static function getProductsFromArray($itemIds){
        
        //Подключение к БД
        $db = Db::getConnection();

        $strIds = implode($itemIds, ', ');
        $sql = "SELECT * FROM products WHERE id in ({$strIds})";

        $rs = $db->query($sql);

        return createSmartyRsArray($rs);
    }


}

