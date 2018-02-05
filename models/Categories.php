<?php

/* *
 * 
 * Модель для таблицы категорий (categories).
 * 
 */

class Categories {

    /**
     * Получить главные категории с привязками дочерних
     * 
     * @return array массив категорий
     */
    public static function getAllMainCatsWithChildren() {
        
        $db = Db::getConnection();
        
        $sql = 'SELECT * '
                . 'FROM categories '
                . 'WHERE parent_id = 0';

        $result = $db->query($sql);
        
        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            
            $rsChildren = self::getChildrenForCat($row['id']);
            
            if($rsChildren){
               $row['children'] = $rsChildren; 
            }

             $smartyRs[] = $row; 
        }
        
        return $smartyRs;

    }
    
   /**
     * Получить дочернюю категорию для категории $catId
     * 
     * @param integer $catId ID категории
     * @return array массив дочерних категорий
     */
    public static function getChildrenForCat($catId){
        
        $db = Db::getConnection();
        
        $sql = "SELECT * "
                . "FROM categories "
                . "WHERE parent_id = '{$catId}'";

        $rs = $db->query($sql);
        
        $smartyRs = array();
        while($row = $rs->fetch(PDO::FETCH_ASSOC)){
            $smartyRs[] = $row;
        }
        
        return $smartyRs;
    }
    
    /**
     * Получить данные категории по id
     * 
     * @param integer $catId ID категории
     * @return array массив - строка категории
     */
    public static function getCatById($catId) {
        
        //Подключение к БД
        $db = Db::getConnection();

        $catId = intval($catId);
        
        $sql = "SELECT * "
                . "FROM `categories` "
                . "WHERE id='{$catId}'";

        $rs = $db->query($sql);
        
        return $rs->fetch(PDO::FETCH_ASSOC);

    }
  
    
}
