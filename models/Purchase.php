<?php

/* 
 * Модель для таблицы продукции(purchase)
 * 
 */

class Purchase {
    
    /**
     * Получить данные покупки юзера привязанной к айди заказа
     * 
     * @param integer $orderId
     * @return array
     */
    public static function getPurchaseForOrder($orderId){

        //Подключение к БД
        $db = Db::getConnection();
        
        $sql = "SELECT `pe`.*, `ps`.`name` "
                . "FROM purchase as `pe` JOIN products as `ps` "
                . "ON `pe`.product_id = `ps`.id "
                . "WHERE `pe`.order_id = '{$orderId}'";

        $rs = $db->query($sql);
        
        return createSmartyRsArray($rs);

    }
    
}
