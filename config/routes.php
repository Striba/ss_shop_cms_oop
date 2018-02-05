<?php

return array (

	'user/update' => 'user/update', //UserController actionUpdate
        'user/register' => 'user/register', //UserController actionRegister
        'user/login' => 'user/login', //UserController actionLogin
        'user/logout' => 'user/logout', //UserController actionLogout
        'user' => 'user/index', // UserController actionIndex
	
        'cart/removefromcart/([0-9]+)' => 'cart/removefromcart/$1', //CartController actionRemovefromcart
        'cart/addtocart/([0-9]+)' => 'cart/addtocart/$1', //CartController actionAddtocart
        'cart' => 'cart/index', //CartController actionIndex
        'cart/order' => 'cart/order', //CartController actionOrder
    
        'product/([0-9]+)' => 'product/index/$1', //ControllerProduct actionIndex
        'category/([0-9]+)' => 'category/index/$1', // actionIndex 
        //в CategoryController значение аргумента $1
        
        '' => 'site/index', // actionIndex в SiteController
	
);
