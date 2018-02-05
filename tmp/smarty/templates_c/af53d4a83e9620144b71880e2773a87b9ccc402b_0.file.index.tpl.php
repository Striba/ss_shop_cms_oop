<?php
/* Smarty version 3.1.30, created on 2018-02-05 14:10:08
  from "D:\programming\open_server_5_2_6_basic\OS526\OpenServer\domains\ss_shop_cms_oop\views\bootstrap4\index.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a783b90c08204_20195881',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'af53d4a83e9620144b71880e2773a87b9ccc402b' => 
    array (
      0 => 'D:\\programming\\open_server_5_2_6_basic\\OS526\\OpenServer\\domains\\ss_shop_cms_oop\\views\\bootstrap4\\index.tpl',
      1 => 1517504854,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a783b90c08204_20195881 (Smarty_Internal_Template $_smarty_tpl) {
?>
  

<div class="container p-5">
        <div class="row">
<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['rsProducts']->value, 'item', false, NULL, 'products', array (
  'iteration' => true,
));
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['__smarty_foreach_products']->value['iteration']++;
?>
    
    
    
            <div class="col-sm-3" >
                <div class="card" style="width: 10rem;" >
                    <div class="card-body" >
                        <a href="/product/<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
/">
                            <img src="/images/products/<?php echo $_smarty_tpl->tpl_vars['item']->value['image'];?>
" class="card-img-top" style="width: 8rem;">
                        </a><br>
                        <h6 class="card-title">
                       
                        <a  href="/product/<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
/" ><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
</a>

                        </h6>
                        
                    </div>
                </div>
            </div>
       
    
    
    
    
    <?php if ((isset($_smarty_tpl->tpl_vars['__smarty_foreach_products']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_products']->value['iteration'] : null) % 3 == 0) {?>
        
        
        
        
    <?php }?>
        
<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

 </div>
    </div><?php }
}
