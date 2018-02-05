<?php

/* 
 *Модель для таблицы заказов(orders)
 * 
 */

class Orders {
    
    /**
     * Получить список заказов с привязкой к продуктам для пользователя $userId
     * 
     * @param integer $userId ID пользователя
     * @return array массив заказов с привязкой к продуктам
     */
    public static function getOrdersWithProductsByUser($userId){

        //Подключение к БД:
        $db = Db::getConnection();
        
        $userId = intval($userId);
        $sql = "SELECT * FROM orders "
                . "WHERE "
                . "`user_id` = '{$userId}' "
                . "ORDER BY id DESC";

        $rs = $db->query($sql);

        $smartyRs = array();
        
        while ($row = $rs->fetch(PDO::FETCH_ASSOC)) {
            $rsChildren = Purchase::getPurchaseForOrder($row['id']);

            if($row['status'] == 0){
                $row['status'] = 'Заказ не оплачен';
            } else {
                $row['status'] = 'Заказ оплачен';
            }

            if($rsChildren){
                $row['children'] = $rsChildren;
                $smartyRs[] = $row;
            }
        }
        
        return $smartyRs;
    }
    
}
