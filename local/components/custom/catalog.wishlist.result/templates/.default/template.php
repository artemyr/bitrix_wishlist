<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<?php
if (count($arResult['ITEMS']['ID']) > 0):
    ?>
    <main class="page favourites-page">

        <? $APPLICATION->IncludeComponent("bitrix:breadcrumb", "top", array(
            "PATH" => "",    // Путь, для которого будет построена навигационная цепочка (по умолчанию, текущий путь)
            "SITE_ID" => "s1",    // Cайт (устанавливается в случае многосайтовой версии, когда DOCUMENT_ROOT у сайтов разный)
            "START_FROM" => "0",    // Номер пункта, начиная с которого будет построена навигационная цепочка
        ),
            false
        ); ?>

        <div class="favourites-page__content">
            <div class="main-container max-width">
                <div class="block-title-page">
                    <h1 class="title title-reset">Избранное</h1>
                </div>
                <div class="cards-wrapper cards-wrapper--lots-cards">
                    <?
                    $GLOBALS['arrFilter'] = $arResult['ITEMS'];
                    ?>
                    <?$APPLICATION->IncludeComponent(
                        "bitrix:catalog.section",
                        "main",
                        Array(
                            "DISPLAY_WISHLIST" => $arParams["USE_WISHLIST"],
                            'WISHLIST_PATH' => $arParams['WISHLIST_PATH'],
                            'WISHLIST_NAME' => $arParams['WISHLIST_NAME'],

                            "ACTION_VARIABLE" => "action",
                            "ADD_PICT_PROP" => "-",
                            "ADD_PROPERTIES_TO_BASKET" => "Y",
                            "ADD_SECTIONS_CHAIN" => "N",
                            "ADD_TO_BASKET_ACTION" => "ADD",
                            "AJAX_MODE" => "N",
                            "AJAX_OPTION_ADDITIONAL" => "",
                            "AJAX_OPTION_HISTORY" => "N",
                            "AJAX_OPTION_JUMP" => "N",
                            "AJAX_OPTION_STYLE" => "Y",
                            "BACKGROUND_IMAGE" => "-",
                            "BASKET_URL" => "/basket/",
                            "BROWSER_TITLE" => "-",
                            "CACHE_FILTER" => "N",
                            "CACHE_GROUPS" => "Y",
                            "CACHE_TIME" => "36000000",
                            "CACHE_TYPE" => "A",
                            "COMPARE_NAME" => "CATALOG_COMPARE_LIST",
                            "COMPARE_PATH" => "/catalog/compare.php",
                            "COMPATIBLE_MODE" => "Y",
                            "CONVERT_CURRENCY" => "N",
                            "CUSTOM_FILTER" => "{\"CLASS_ID\":\"CondGroup\",\"DATA\":{\"All\":\"AND\",\"True\":\"True\"},\"CHILDREN\":[]}",
                            "DETAIL_URL" => "",
                            "DISABLE_INIT_JS_IN_COMPONENT" => "N",
                            "DISCOUNT_PERCENT_POSITION" => "bottom-right",
                            "DISPLAY_BOTTOM_PAGER" => "Y",
                            "DISPLAY_COMPARE" => "Y",
                            "DISPLAY_TOP_PAGER" => "N",
                            "ELEMENT_SORT_FIELD" => "sort",
                            "ELEMENT_SORT_FIELD2" => "id",
                            "ELEMENT_SORT_ORDER" => "asc",
                            "ELEMENT_SORT_ORDER2" => "desc",
                            "ENLARGE_PRODUCT" => "STRICT",
                            "FILTER_NAME" => "arrFilter",
                            "HIDE_NOT_AVAILABLE" => "N",
                            "HIDE_NOT_AVAILABLE_OFFERS" => "N",
                            "IBLOCK_ID" => "22",
                            "IBLOCK_TYPE" => "catalog",
                            "INCLUDE_SUBSECTIONS" => "Y",
                            "LABEL_PROP" => array(),
                            "LAZY_LOAD" => "N",
                            "LINE_ELEMENT_COUNT" => "3",
                            "LOAD_ON_SCROLL" => "N",
                            "MESSAGE_404" => "",
                            "MESS_BTN_ADD_TO_BASKET" => "В корзину",
                            "MESS_BTN_BUY" => "Купить",
                            "MESS_BTN_COMPARE" => "Сравнить",
                            "MESS_BTN_DETAIL" => "Подробнее",
                            "MESS_BTN_LAZY_LOAD" => "Показать ещё",
                            "MESS_BTN_SUBSCRIBE" => "Подписаться",
                            "MESS_NOT_AVAILABLE" => "Нет в наличии",
                            "META_DESCRIPTION" => "-",
                            "META_KEYWORDS" => "-",
                            "OFFERS_LIMIT" => "5",
                            "PAGER_BASE_LINK_ENABLE" => "N",
                            "PAGER_DESC_NUMBERING" => "N",
                            "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                            "PAGER_SHOW_ALL" => "N",
                            "PAGER_SHOW_ALWAYS" => "N",
                            "PAGER_TEMPLATE" => "main",
                            "PAGER_TITLE" => "Товары",
                            "PAGE_ELEMENT_COUNT" => "18",
                            "PARTIAL_PRODUCT_PROPERTIES" => "N",
                            "PRICE_CODE" => array("BASE"),
                            "PRICE_VAT_INCLUDE" => "Y",
                            "PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons",
                            "PRODUCT_ID_VARIABLE" => "id",
                            "PRODUCT_PROPS_VARIABLE" => "prop",
                            "PRODUCT_QUANTITY_VARIABLE" => "quantity",
                            "PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false}]",
                            "PRODUCT_SUBSCRIPTION" => "Y",
                            "PROPERTY_CODE_MOBILE" => array(),
                            "RCM_PROD_ID" => $_REQUEST["PRODUCT_ID"],
                            "RCM_TYPE" => "personal",
                            "SECTION_CODE" => "",
                            "SECTION_CODE_PATH" => "",
                            "SECTION_ID" => "#SECTION_CODE#/#ELEMENT_CODE#/",
                            "SHOW_ALL_WO_SECTION" => "Y",
                            "SECTION_ID_VARIABLE" => "SECTION_ID",
                            "SECTION_URL" => "",
                            "SECTION_USER_FIELDS" => array("", ""),
                            "SEF_MODE" => "Y",
                            "SEF_RULE" => "",
                            "SET_BROWSER_TITLE" => "N",
                            "SET_LAST_MODIFIED" => "N",
                            "SET_META_DESCRIPTION" => "Y",
                            "SET_META_KEYWORDS" => "Y",
                            "SET_STATUS_404" => "N",
                            "SET_TITLE" => "N",
                            "SHOW_404" => "N",
                            "SHOW_CLOSE_POPUP" => "N",
                            "SHOW_DISCOUNT_PERCENT" => "Y",
                            "SHOW_FROM_SECTION" => "N",
                            "SHOW_MAX_QUANTITY" => "N",
                            "SHOW_OLD_PRICE" => "Y",
                            "SHOW_PRICE_COUNT" => "1",
                            "SHOW_SLIDER" => "Y",
                            "SLIDER_INTERVAL" => "3000",
                            "SLIDER_PROGRESS" => "N",
                            "TEMPLATE_THEME" => "blue",
                            "USE_COMPARE_LIST" => "N",
                            "USE_ENHANCED_ECOMMERCE" => "N",
                            "USE_MAIN_ELEMENT_SECTION" => "N",
                            "USE_PRICE_COUNT" => "N",
                            "USE_PRODUCT_QUANTITY" => "N"
                        )
                    );?>
                </div>
            </div>
        </div>
    </main>
<? else: ?>
    <main class="page favorites-no-page">

    <? $APPLICATION->IncludeComponent("bitrix:breadcrumb", "top", array(
        "PATH" => "",    // Путь, для которого будет построена навигационная цепочка (по умолчанию, текущий путь)
        "SITE_ID" => "s1",    // Cайт (устанавливается в случае многосайтовой версии, когда DOCUMENT_ROOT у сайтов разный)
        "START_FROM" => "0",    // Номер пункта, начиная с которого будет построена навигационная цепочка
    ),
        false
    ); ?>

    <div class="favorites-no-page__content">
        <div class="main-container max-width">
            <div class="block-title-page">
                <h1 class="title title-reset">Избранное</h1>
            </div>
            <div class="empty bitrix-unset-bootstrap">
                <div class="empty__block-icon">
                    <svg class="empty__icon">
                        <use xlink:href="<?=SITE_TEMPLATE_PATH?>/assets/icons/sprite-svg.svg#big-heart"/>
                    </svg>
                </div>
                <h2 class="title title-reset">В избранном пока ничего нет</h2>
                <span class="empty__subtitle">Перейдите в каталог и сохраните товары в избранное.</span>
                <a href="/catalog/" class="btn btn--size--bg btn--theme--orange">
                    <span class="btn__text">Перейти в каталог</span>
                </a>
            </div>
        </div>
    </div>
</main>
<? endif; ?>