
        {* левый столбец *}
        <div id="leftColumn" class="col-sm-3 container" style="background-color: #f0c040">
            
            <span >Меню: </span>
            <ul class="nav flex-column">
                  
                    {foreach $rsCategories as $item}
                       
                        {if isset($item['children'])}
                            <li class="nav-item dropdown">
                              <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="/category/{$item['id']}/"  aria-haspopup="true" aria-expanded="false" >{$item['name']}</a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="/category/{$item['id']}/">{$item['name']}</a>
                                <div class="dropdown-divider"></div>
                            {foreach $item['children'] as $itemChild}
                               <a class="dropdown-item" href="/category/{$itemChild['id']}/">{$itemChild['name']}</a>
                            {/foreach}
                            </div>  
                            </li>
                            
                        {else}
                             <li class="nav-item">
                            <a class="nav-link" href="/category/{$item['id']}/">{$item['name']}</a>
                            </li>
                        {/if}
                        
                    {/foreach}
            </ul>
            
            
            
            {if isset($arUser)}
                <div>
                   <a href="/user/" id="userLink">{$arUser['displayName']}</a><br />
                   <a href="/user/logout/" onclick="logout();">Выход</a> 
                </div>
            {else}
            
            <div id="userBox" class="hideme">
                <a href="#" id="userLink"></a><br />
                <a href="/user/logout/" onclick="logout();">Выход</a>
            </div>
                {if ! isset($hideLoginBox)}
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
                {/if}
            {/if}
                
            <div class="menuCaption">Корзина</div>
            <a href="/cart/" title="Перейти в корзину">В корзине</a>
            <span id="cartCntItems">
                {if $cartCntItems > 0}{$cartCntItems}{else}пусто{/if}
            </span>
            
         </div>
