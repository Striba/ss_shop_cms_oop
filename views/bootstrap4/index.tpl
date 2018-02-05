{* шаблон главной страницы *}  

<div class="container p-5">
        <div class="row">
{foreach $rsProducts as $item name=products}

            <div class="col-sm-3" >
                <div class="card" style="width: 10rem;" >
                    <div class="card-body" >
                        <a href="/product/{$item['id']}/">
                            <img src="/images/products/{$item['image']}" class="card-img-top" style="width: 8rem;">
                        </a><br>
                        <h6 class="card-title">
                        <a  href="/product/{$item['id']}/" >{$item['name']}</a>

                        </h6>
                    </div>
                </div>
            </div>

{/foreach}
 </div>
    </div>