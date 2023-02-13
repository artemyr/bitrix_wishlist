# Bitrix список избранного

---

Работает аналогично со списком сравнения стандартного битрикса. Вся логика похожа на стандартную без приколов в init.php. \
Сердечки у избранных товаров при выводе списка товаров ставит автоматически \
При нажатии сердечка работает коректно `не инкрементирует счетчик в каунтере, а считает имено количество товаров в вишлисте` \
\
Работает в двух режимах:
0. Если пользоваетль не авторизован, то товары сохраняются в сессии
1. Если пользователь авторизован, то сохраняет товары в корзине в разделе отложенное `(при выводе корзины лучше выводить не отложенные товары)`

---

## О структуре
0. `/index.php` - пример использования `catalog.section` без каталога 
1. `/local/templates/markopool/header.php` - использование `affetta:wishlist` для вывода каунтера
2. `/catalog/index.php` - пример использования `catalog` с вишлистом
3. `/local/templates/markopool/components/bitrix/catalog.item/...` `/local/templates/markopool/components/bitrix/catalog.section/...` `/local/templates/markopool/components/bitrix/catalog/...` - в компонентах находятся дополниные переменные для правильной работы вишлиста (формирование путей для отправки ajax, типы экшенов)
4. `/favorites/index.php` - список избранного









компонент result на страницу с избранным
```
<?$APPLICATION->IncludeComponent(
    "custom:catalog.wishlist.result",
    "",
    Array(
        "NAME" => "CATALOG_WISHLIST_LIST",
        "IBLOCK_ID" => CATALOG_IB_ID,

        "USE_WISHLIST" => 'Y',
        "WISHLIST_PATH" => "/catalog/wishlist.php?action=#ACTION_CODE#",
        'WISHLIST_NAME' => 'CATALOG_WISHLIST_LIST',
    )
);?>
```


компонент wishlist в header для вывода цифири и ловли аяксов
```
<?$APPLICATION->IncludeComponent(
    "custom:wishlist",
    "top",
    array(
        "ACTION_VARIABLE" => "action_wish",
        "AJAX_MODE" => "N",
        "AJAX_OPTION_ADDITIONAL" => "",
        "AJAX_OPTION_HISTORY" => "N",
        "AJAX_OPTION_JUMP" => "N",
        "AJAX_OPTION_STYLE" => "N",
        "COMPARE_URL" => "compare.php",
        "DETAIL_URL" => "",
        "IBLOCK_ID" => CATALOG_IB_ID,
        "IBLOCK_TYPE" => CATALOG_CODE,
        "NAME" => "CATALOG_WISHLIST_LIST",
        "POSITION" => "top left",
        "POSITION_FIXED" => "N",
        "PRODUCT_ID_VARIABLE" => "id",
        "COMPONENT_TEMPLATE" => "top"
    ),
    false
);?>
```

/-----
компонент каталог catalog catalog/index.php
параметры
```
"SEF_URL_TEMPLATES" => Array( ... "wishlist"=>"wishlist.php?action=#ACTION_CODE#"),
"USE_WISHLIST" => "Y",
"WISHLIST_NAME" => "CATALOG_WISHLIST_LIST"
```
/-----
компонент списка товаров catalog.section в том числе в catalog - section - section_vertical
параметры
```
"DISPLAY_WISHLIST" => $arParams["USE_WISHLIST"],
'WISHLIST_PATH' => $arResult['FOLDER'] . $arResult['URL_TEMPLATES']['wishlist'],
'WISHLIST_NAME' => $arParams['WISHLIST_NAME'],
```
template.php в переменной $generalParams
```
$add = str_replace("COMPARE","WISHLIST", $arResult['~COMPARE_URL_TEMPLATE']);
$add = str_replace("action","action_wish", $add);
$remove = str_replace("COMPARE","WISHLIST", $arResult['~COMPARE_DELETE_URL_TEMPLATE']);
$remove = str_replace("action","action_wish", $remove);

$generalParams = array(
    'WISHLIST_PATH' => $arParams['WISHLIST_PATH'],
    'DISPLAY_WISHLIST' => $arParams['DISPLAY_WISHLIST'],
    'WISHLIST_NAME' => $arParams['WISHLIST_NAME'],
    '~WISHLIST_URL_TEMPLATE' => $add,
    '~WISHLIST_DELETE_URL_TEMPLATE' => $remove,
```
/----
компонент карточки товара catalog.item
template.php в переменной $itemIds
```
'WISHLIST_LINK' => $areaId.'_wishlist_link',
```
if (!$haveOffers) -> $jsParams['VISUAL']
```
'WISHLIST_LINK_ID' => $itemIds['WISHLIST_LINK'],
```
else -> $jsParams['VISUAL']
```
'WISHLIST_LINK_ID' => $itemIds['WISHLIST_LINK'],
```
после if ($arParams['DISPLAY_COMPARE']){...}
```
$arParams['DISPLAY_WISHLIST'] = true;
if ($arParams['DISPLAY_WISHLIST'])
{
    $jsParams['WISHLIST'] = array(
        'WISHLIST_URL_TEMPLATE' => $arParams['~WISHLIST_URL_TEMPLATE'],
        'WISHLIST_DELETE_URL_TEMPLATE' => $arParams['~WISHLIST_DELETE_URL_TEMPLATE'],
        'WISHLIST_PATH' => $arParams['WISHLIST_PATH']
    );
}
```

card/template.php
```
<?if ($arParams['DISPLAY_WISHLIST']) : ?>
    <a href="javascript:void(0)" id="<?= $itemIds['WISHLIST_LINK'] ?>" class="link-reset">
        <input type="checkbox" data-entity="wishlist-checkbox">
    </a>
<?endif;?>
```

script.js
```
// wishlist
wishlist: function(event)
{
var checkbox = this.obWishlist.querySelector('[data-entity="wishlist-checkbox"]'),
target = BX.getEventTarget(event),
checked = true;

    if (checkbox)
    {
        checked = target === checkbox ? checkbox.checked : !checkbox.checked;
    }

    var url = checked ? this.wishlistData.wishlistUrl : this.wishlistData.wishlistDeleteUrl,
        wishlistLink;

    if (url)
    {
        if (target !== checkbox)
        {
            BX.PreventDefault(event);
            this.setWishlited(checked);
        }

        switch (this.productType)
        {
            case 0: // no catalog
            case 1: // product
            case 2: // set
                wishlistLink = url.replace('#ID#', this.product.id.toString());
                break;
            case 3: // sku
                wishlistLink = url.replace('#ID#', this.offers[this.offerNum].ID);
                break;
        }

        BX.ajax({
            method: 'POST',
            dataType: checked ? 'json' : 'html',
            url: wishlistLink + (wishlistLink.indexOf('?') !== -1 ? '&' : '?') + 'ajax_action=Y',
            onsuccess: checked
                ? BX.proxy(this.wishlistResult, this)
                : BX.proxy(this.wishlistDeleteResult, this)
        });
    }

},

setWishlited: function (state)
{
if (!this.obWishlist)
return;

    var checkbox = this.obWishlist.querySelector('[data-entity="wishlist-checkbox"]');
    var wishlist_icon = this.obWishlist.querySelector('.item-wishlist-svg-icon');
    if (checkbox)
    {
        checkbox.checked = state;
        if(state) wishlist_icon.classList.add('active');
        else wishlist_icon.classList.remove('active');
    }
},

wishlistResult: function(result)
{
BX.onCustomEvent('OnWishlistChange');
},

wishlistDeleteResult: function(result)
{
BX.onCustomEvent('OnWishlistChange');
},
// /wishlist
```

script.js в init() после if (this.useCompare) {...}
```
if (this.useWishlist)
{
    this.obWishlist = BX(this.visual.WISHLIST_LINK_ID);
    if (this.obWishlist)
    {
        BX.bind(this.obWishlist, 'click', BX.proxy(this.wishlist, this));
    }
    //
    // BX.addCustomEvent('onCatalogDeleteCompare', BX.proxy(this.checkDeletedCompare, this));
}
```

script.js в window.JCCatalogItem = function (arParams) после this.compareData = {...}
```
this.wishlistData = {
    wishlistUrl: '',
    wishlistDeleteUrl: '',
    wishlistPath: ''
};
```

script.js в window.JCCatalogItem = function (arParams) после this.obCompare = null;
```
this.obWishlist = null;
```

script.js в window.JCCatalogItem = function (arParams) после this.useCompare = arParams.DISPLAY_COMPARE;
```
this.useWishlist = true;
```

script.js в window.JCCatalogItem = function (arParams) после if (this.useCompare) {...}
```
if (this.useWishlist)
{
    if (arParams.WISHLIST && typeof arParams.WISHLIST === 'object')
    {
        if (arParams.WISHLIST.WISHLIST_PATH)
        {
            this.wishlistData.wishlistPath = arParams.WISHLIST.WISHLIST_PATH;
        }

        if (arParams.WISHLIST.WISHLIST_URL_TEMPLATE)
        {
            this.wishlistData.wishlistUrl = arParams.WISHLIST.WISHLIST_URL_TEMPLATE;
        }
        else
        {
            this.useWishlist = false;
        }

        if (arParams.WISHLIST.WISHLIST_DELETE_URL_TEMPLATE)
        {
            this.wishlistData.wishlistDeleteUrl = arParams.WISHLIST.WISHLIST_DELETE_URL_TEMPLATE;
        }
        else
        {
            this.useWishlist = false;
        }
    }
    else
    {
        this.useWishlist = false;
    }
}
```

component_epilog.php
```
if ($arParams['DISPLAY_WISHLIST'])
{
    $wishlist = false;
    $wishlistIds = array();
    $item = $templateData['ITEM'];

    $arBasketItems = array();

    $dbBasketItems = CSaleBasket::GetList(
        array(
            "NAME" => "ASC",
            "ID" => "ASC"
        ),
        array(
            "FUSER_ID" => CSaleBasket::GetBasketUserID(),
            "LID" => SITE_ID,
            "ORDER_ID" => "NULL",
            'DELAY' => 'Y'
        ),
        false,
        false,
        array("ID", "CALLBACK_FUNC", "MODULE",
            "PRODUCT_ID", "QUANTITY", "DELAY",
            "CAN_BUY", "PRICE", "WEIGHT")
    );
    while ($arItems = $dbBasketItems->Fetch()) {
        if (strlen($arItems["CALLBACK_FUNC"]) > 0) {
            CSaleBasket::UpdatePrice($arItems["ID"],
                $arItems["CALLBACK_FUNC"],
                $arItems["MODULE"],
                $arItems["PRODUCT_ID"],
                $arItems["QUANTITY"]);
            $arItems = CSaleBasket::GetByID($arItems["ID"]);
        }

        if($item['ID'] == $arItems['PRODUCT_ID']){
            $wishlist = true;
            break;
        }
    }

    if ($templateData['JS_OBJ'])
    {
        ?>
        <script>
            BX.ready(BX.defer(function(){
                if (!!window.<?=$templateData['JS_OBJ']?>)
                {
                    window.<?=$templateData['JS_OBJ']?>.setWishlited('<?=$wishlist?>');
                }
            }));
        </script>
        <?
    }
}
```