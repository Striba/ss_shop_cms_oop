<?php 
//FRONT CONTROLLER

// 1. Общие настройки
ini_set('display_errors',1);
error_reporting(E_ALL);
session_start();

// 2. Подключение файлов системы

define('ROOT', dirname(__FILE__));

//Подключаем класс Smatry
require_once (ROOT.'/library/Smarty/libs/Smarty.class.php');
//Подключаем файл с основными функциями
require_once (ROOT . '/library/mainFunctions.php');
//Подключаем файл автозагрузчика
require_once(ROOT.'/components/Autoload.php');

// 3.Подключение шаблонов предствавления и шаблонизатора smarty:

//>исспользуемый шаблон
//$template = 'default';
$template = 'bootstrap4';
$templateAdmin = 'admin';

//Пути к файлам шаблонов (*.tpl)
//define('TemplaxtePrefix', "views/{$template}/");
define('TemplaxtePrefix', "views/{$template}/");//тоже отлично отработала
define('TemplaxteAdminPrefix', "views/{$templateAdmin}/");
define('TemplatePostfix', '.tpl');

//Пути к файлам шаблонов в вебпространстве
define ('TemplateWebPath',  "templates/{$template}/");
define ('TemplateAdminWebPath', "templates/{$templateAdmin}/");
//<



// 4. Определение наличия данных сессии для пользователя и корзины

//Инициализация шаблонизатора SMARTY
$smarty = Smartyload::getSmarty();

$smarty->assign('ROOT', ROOT);

// если в сессии нет массива корзины, то создаем его
if (! isset($_SESSION['cart'])){
    $_SESSION['cart'] = array();
}

//если в сессии есть данные об авторизованно пользователе,
// то передаем их в шаблон
if(isset($_SESSION['user'])){
    $smarty->assign('arUser', $_SESSION['user']);
}

//инициализируем переменную шаблонизатора колличества переменных в корзине
$smarty->assign('cartCntItems', count($_SESSION['cart']));

$_SESSION['smarty'] = $smarty;

// 5. Вызов Router
$router = new Router();
$router->run();



