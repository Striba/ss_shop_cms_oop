<?php

/* 
 * Модель для теблицы пользователей (users)
 *
 */

class Users {
    
    /**
     * Получить данные заказа текущего пользователя
     * 
     * @return array массив заказов с привязкой к продуктам
     */

    public static function getCurUserOrders(){

        $userId = isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : 0;
        $rs = Orders::getOrdersWithProductsByUser($userId);

        return $rs;
    }
    
    /**
     * Авторизация пользователя
     * 
     * @param string $email почта
     * @param string $pwd пароль
     * @return array массив данных пользователя
     */
    public static function loginUser($email, $pwd){
        
        //Подключение к БД
        $db = Db::getConnection();

        $pwd = md5($pwd);
                
        $sql = "SELECT * FROM users "
                . "WHERE "
                . "email = :email AND pwd = :pwd";
        
        //Формируем подготовленный запрос:
        $rs = $db->prepare($sql);
        //Связываем переменные:
        $rs->bindParam(':email', $email, PDO::PARAM_INT);
        $rs->bindParam('pwd', $pwd, PDO::PARAM_INT);
        //Исполняем запрос:
        $rs->execute();

        $rs = createSmartyRsArray($rs);

        if (isset($rs[0])){
            $rs['success'] = 1; 
        } else {
            $rs['success'] = 0;
        }

        return $rs;
    }
    
    /**
     * Изменение данных пользователя
     * 
     * @param type $name имя пользователя
     * @param type $phone телефон
     * @param type $adress адрес
     * @param type $pwd1 новый пароль
     * @param type $pwd2 повтор нового пароля
     * @param type $curPwd текущий пароль
     * @return boolean TRUE в случае успеха
     */
    public static function updateUserData($name, $phone, $adress, $pwd1, $pwd2, $curPwd){
        
        //Подключение к БД
        $db = Db::getConnection();

        $email = $_SESSION['user']['email'];
        $pwd1 = trim($pwd1);
        $pwd2 = trim($pwd2);

        $newPwd = null;
        if($pwd1 && $pwd1 == $pwd2){
            $newPwd = md5($pwd1);
        }

        $sql = "UPDATE users SET";

        if($newPwd){
            $sql .= " `pwd` = :pwd, ";
        }

        $sql .= " `name` = :name,"
        . " `phone` = :phone,"
        . " `adress` = :adress"
        . " WHERE "
                . "`email` = :email and `pwd` = :curPwd"
                . " LIMIT 1";
        
        //Формируем подготовленный запрос:
        $rs = $db->prepare($sql); 
        
        //Связываем переменные:
        if($newPwd){
            $rs->bindParam(':pwd', $newPwd, PDO::PARAM_STR);
        }
        
        $rs->bindParam(':name', $name, PDO::PARAM_STR);
        $rs->bindParam(':phone', $phone, PDO::PARAM_STR);
        $rs->bindParam(':adress', $adress, PDO::PARAM_STR);
        $rs->bindParam(':email', $email, PDO::PARAM_STR);
        $rs->bindParam(':curPwd', $curPwd, PDO::PARAM_STR);
        
        //Выполняем запрос и передаем его в actionApdate UserController:
        return $rs->execute();

    }
    
    /**
     * Проверка параметров для регистрации пользователя.
     * 
     * @param string $email email
     * @param string $pwd1 пароль
     * @param string $pwd2 повтор пароля
     * @return array результат
     */
    public static function checkRegisterParam($email, $pwd1, $pwd2){

        $res = null;// либо array() 

        if(! $email){
            $res['success'] = FALSE;
            $res['message'] = 'Введите email';
        }

        if(! $pwd1){
            $res['success'] = FALSE;
            $res['message'] = 'Введите пароль';
        }

        if(! $pwd2){
            $res['success'] = FALSE;
            $res['message'] = 'Введите повтор пароля';
        }

        if($pwd1 != $pwd2){
            $res['success'] = FALSE;
            $res['message'] = 'Пароли не совпадают';
        }

        return $res;
    }
    
    /**
     * Регистрация нового пользователя
     * 
     * @param string $email почта
     * @param string $pwdMD5 пароль зашифрованный в MD5
     * @param string $name имя пользователя
     * @param string $phone телефон
     * @param string $adress адрес пользователя
     * @return array массив данных нового пользователя
     */
    public static function registerNewUser($email, $pwdMD5, $name, $phone, $adress){
        
        //Подключение к БД:
        $db = Db::getConnection();

        $sql = "INSERT INTO users (`email`, `pwd`, `name`, `phone`, `adress`) "
                . "VALUES "
                . "('{$email}', '{$pwdMD5}', '{$name}', '{$phone}', '{$adress}')";
      
        //Исполняем запрос:
        $rs = $db->query($sql);

        //Проверка успешности запроса:
        if($rs){

            $sql = "SELECT * FROM users "
                    . "WHERE "
                    . "(`email` = :email and `pwd` = :pwdMD5) LIMIT 1";
            
            //Формируем подготовленный запрос:
            $rs = $db->prepare($sql);
            
            //Связываем переменные:
            $rs->bindParam(':email', $email, PDO::PARAM_STR);
            $rs->bindParam(':pwdMD5', $pwdMD5, PDO::PARAM_STR);
            
            //Исполняем запрос:
            $rs->execute();

            $rs = createSmartyRsArray($rs);

            //Проверяем нашли этого пользователя или нет:
            if(isset($rs[0])){
                $rs['success'] = 1;
            } else {
                $rs['success'] = 0;
            }
        } else {
            $rs['success'] = 0;
        }

        return $rs;
    }
    
    /**
     * Проверка почты. Есть ли емейл адрес в БД.
     * 
     * @param string $email
     * @return array массив - строка из таблицы  users, либо пустой массив
     */
    public static function checkUserEmail($email){

        //Подключение к БД
        $db = Db::getConnection();

        $sql = "SELECT id FROM users WHERE email = :email";
        
        //Формирование подготовленного запроса:
        $rs = $db->prepare($sql);
        
        //Связывание переменных:
        $rs->bindParam(':email', $email, PDO::PARAM_STR);
 
        //Исполнение запроса:
        $rs->execute();
        
        //$rs = mysql_query($sql);
        $rs = createSmartyRsArray($rs);

        return $rs;
    }
}
