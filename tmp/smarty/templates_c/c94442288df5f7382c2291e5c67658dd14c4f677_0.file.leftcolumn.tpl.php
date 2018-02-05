<?php
/* Smarty version 3.1.30, created on 2018-02-05 14:10:08
  from "D:\programming\open_server_5_2_6_basic\OS526\OpenServer\domains\ss_shop_cms_oop\views\bootstrap4\leftcolumn.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a783b90acf9b5_24931647',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c94442288df5f7382c2291e5c67658dd14c4f677' => 
    array (
      0 => 'D:\\programming\\open_server_5_2_6_basic\\OS526\\OpenServer\\domains\\ss_shop_cms_oop\\views\\bootstrap4\\leftcolumn.tpl',
      1 => 1517503992,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a783b90acf9b5_24931647 (Smarty_Internal_Template $_smarty_tpl) {
?>

        
        <div id="leftColumn" class="col-sm-3 container" style="background-color: #f0c040">
             
             
            
            <span >Меню: </span>
            <ul class="nav flex-column">
                  
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['rsCategories']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?>
                       
                        <?php if (isset($_smarty_tpl->tpl_vars['item']->value['children'])) {?>
                            <li class="nav-item dropdown">
                              <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="/category/<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
/"  aria-haspopup="true" aria-expanded="false" ><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
</a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="/category/<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
/"><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
</a>
                                <div class="dropdown-divider"></div>
                            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['item']->value['children'], 'itemChild');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['itemChild']->value) {
?>
                               <a class="dropdown-item" href="/category/<?php echo $_smarty_tpl->tpl_vars['itemChild']->value['id'];?>
/"><?php echo $_smarty_tpl->tpl_vars['itemChild']->value['name'];?>
</a>
                            <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                            </div>  
                            </li>
                            
                        <?php } else { ?>
                             <li class="nav-item">
                            <a class="nav-link" href="/category/<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
/"><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
</a>
                            </li>
                        <?php }?>
                        
                    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

            </ul>
            
            
            
            <?php if (isset($_smarty_tpl->tpl_vars['arUser']->value)) {?>
                <div>
                   <a href="/user/" id="userLink"><?php echo $_smarty_tpl->tpl_vars['arUser']->value['displayName'];?>
</a><br />
                   <a href="/user/logout/" onclick="logout();">Выход</a> 
                </div>
            <?php } else { ?>
            
            <div id="userBox" class="hideme">
                <a href="#" id="userLink"></a><br />
                <a href="/user/logout/" onclick="logout();">Выход</a>
            </div>
                <?php if (!isset($_smarty_tpl->tpl_vars['hideLoginBox']->value)) {?>
                <div id="loginBox">
                    <div class="menuCaption">Авторизация</div>
                    <input type="text" id="loginEmail" name="loginEmail" value=""/><br />
                    <input type="password" id="loginPwd" name="loginPwd" value=""/><br />
                    <input type="button" onclick="login();" value="Войти" />
                </div>

                <div id="registerBox">
                    <div>
                        <a href="#" class="menuCaption showHidden" onclick="showRegisterBox();">Регистрация</a> 
                    </div>
                    <div id="registerBoxHidden" class="hideme">
                        email: <br />
                        <input type="text" id="email" name="email" value=""/><br />
                        пароль: <br />
                        <input type="password" id="pwd1" name="pwd1" value=""/><br />
                        повторить пароль: <br />
                        <input type="password" id="pwd2" name="pwd2" value=""/><br />
                        <input type="button" onclick="registerNewUser();" value="Зарегистрироваться"/>
                    </div>
                </div>  
                <?php }?>
            <?php }?>
                
            <div class="menuCaption">Корзина</div>
            <a href="/cart/" title="Перейти в корзину">В корзине</a>
            <span id="cartCntItems">
                <?php if ($_smarty_tpl->tpl_vars['cartCntItems']->value > 0) {
echo $_smarty_tpl->tpl_vars['cartCntItems']->value;
} else { ?>пусто<?php }?>
            </span>
            
         </div>
<?php }
}
