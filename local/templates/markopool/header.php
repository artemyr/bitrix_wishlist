<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
global $USER;
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <? $APPLICATION->ShowHead() ?>
    <link type="image/x-icon" href="/favicon.ico" rel="shortcut icon">
    <link type="Image/x-icon" href="/favicon.ico" rel="icon">
    <link rel="stylesheet" href="<?= SITE_TEMPLATE_PATH ?>/assets/styles/main.min.css">
    <link rel="stylesheet" href="<?= SITE_TEMPLATE_PATH ?>/assets/styles/dev.css">
    <title><?$APPLICATION->ShowTitle()?></title>
</head>
<body>

<!--break bootstrap classes-->
<style>
    .empty.bitrix-unset-bootstrap {
        width: unset;
        height: unset;
        overflow: unset;
    }
</style>
<!--/interrupt bootstrap classes-->

<header class="header">
    <div id="panel"><?$APPLICATION->ShowPanel();?></div>
    <div class="main-container max-width">
        <a href="/" class="logo">
            <svg class="logo__icon">
                <use xlink:href="<?=SITE_TEMPLATE_PATH?>/assets/icons/sprite-svg.svg#logo"/>
            </svg>
        </a>
        <div class="header__wrapper-info" data-menu="block-menu">
            <div class="header__wrapper-nav" data-menu="content">
                <nav class="nav">
                    <div class="nav__block-title">
                        <span class="nav__title">Покупателям</span>
                    </div>

                    <?
                    $APPLICATION->IncludeComponent(
                        "bitrix:menu",
                        "top",
                        Array(
                            "ALLOW_MULTI_SELECT" => "N",
                            "CHILD_MENU_TYPE" => "top",
                            "DELAY" => "N",
                            "MAX_LEVEL" => "1",
                            "MENU_CACHE_GET_VARS" => array(""),
                            "MENU_CACHE_TIME" => "3600",
                            "MENU_CACHE_TYPE" => "A",
                            "MENU_CACHE_USE_GROUPS" => "Y",
                            "ROOT_MENU_TYPE" => "top",
                            "USE_EXT" => "N"
                        )
                    );
                    ?>

                </nav>
                <div class="header__wrapper-nav-links">
                    <div class="header__block-city">
                        <svg class="header__city-icon">
                            <use xlink:href="<?=SITE_TEMPLATE_PATH?>/assets/icons/sprite-svg.svg#map-pin"/>
                        </svg>
                        <span class="header__city-name">г. Москва</span>
                    </div>
                    <div class="header__block-phone" data-drop-out-phone="block-phone">

                        <?if(!empty($GLOBALS['config']['header_phones'])):?>
                            <?$first_phone = array_shift($GLOBALS['config']['header_phones'])?>
                            <div class="header__block-main-phone">
                                <a href="tel:<?=$first_phone?>" class="header__phone link-reset"><?=$first_phone?></a>
                                <?if(count($GLOBALS['config']['header_phones']) > 0):?>
                                    <svg class="header__phone-icon" data-drop-out-phone="phone-icon">
                                        <use xlink:href="<?=SITE_TEMPLATE_PATH?>/assets/icons/sprite-svg.svg#arrow-down"/>
                                    </svg>
                                <?endif;?>
                            </div>
                            <?unset($first_phone);?>


                            <?if(count($GLOBALS['config']['header_phones']) > 0):?>
                                <div class="header__block-phone-drop-out">
                                    <?foreach ($GLOBALS['config']['header_phones'] as $item):?>
                                        <a href="tel:<?=$item?>" class="header__phone link-reset"><?=$item?></a>
                                    <?endforeach;?>
                                </div>
                            <?endif;?>
                        <?endif;?>

                    </div>

                    <div class="contacts-block">
                        <div class="contacts-block__block-title">
                            <span class="contacts-block__title">Наши контакты</span>
                        </div>
                        <div class="contacts-block__block-contacts">
                            <a href="tel:74957880908" class="contacts-block__phone link-reset">+7 (495) 788-09-08</a>
                            <a href="tel:74957807876" class="contacts-block__phone link-reset">+7 (495) 780-78-76</a>
                            <a href="#" class="contacts-block__mail link-reset">markopool@markopool.ru</a>
                            <a href="#" class="contacts-block__address link-reset">119261, Россия, г. Москва, Ломоносовский проспект, д.5</a>
                            <div class="contacts-block__block-operating-mode">
                                <span class="contacts-block__operating-mode">Пн - Пт: 9:30 - 18:30</span>
                                <span class="contacts-block__operating-mode">Сб - Вс: выходные</span>
                            </div>
                        </div>
                    </div>
                    <a href="#" class="btn btn--size--tiny btn--theme--light-blue" data-hystmodal="#form-callback">
                        <span class="btn__text">Заказать звонок</span>
                    </a>
                    <div class="social-network">
                        <div class="social-network__block-title">
                            <span class="social-network__title">Мы в соцсетях</span>
                        </div>
                        <ul class="social-network__list list-reset">
                            <li class="social-network__li social-network__li--telegram">
                                <a href="#" class="social-network__link">
                                    <svg class="social-network__icon">
                                        <use xlink:href="<?=SITE_TEMPLATE_PATH?>/assets/icons/sprite-svg.svg#telegram"/>
                                    </svg>
                                </a>
                            </li>
                            <li class="social-network__li social-network__li--whats-app">
                                <a href="#" class="social-network__link">
                                    <svg class="social-network__icon">
                                        <use xlink:href="<?=SITE_TEMPLATE_PATH?>/assets/icons/sprite-svg.svg#whatsApp"/>
                                    </svg>
                                </a>
                            </li>
                            <li class="social-network__li social-network__li--viber">
                                <a href="#" class="social-network__link">
                                    <svg class="social-network__icon">
                                        <use xlink:href="<?=SITE_TEMPLATE_PATH?>/assets/icons/sprite-svg.svg#viber"/>
                                    </svg>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="header__wrapper-links">
                <div class="header__wrapper-search">
                    <a href="/catalog/" class="btn btn--size--sm-second btn--theme--orange">
                        <svg class="btn__icon">
                            <use xlink:href="<?=SITE_TEMPLATE_PATH?>/assets/icons/sprite-svg.svg#burger"/>
                        </svg>
                        <span class="btn__text">Каталог</span>
                    </a>
                    <div class="header__burger" data-menu="btn">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                    
                    <?$APPLICATION->IncludeComponent(
                        "bitrix:search.form",
                        "top",
                        Array(
                            "PAGE" => "#SITE_DIR#search/",
                            "USE_SUGGEST" => "N"
                        )
                    );?>

                </div>
                <div class="links-bar">
                    <ul class="links-bar__list list-reset">
                        <li class="links-bar__li <?= ($USER->IsAuthorized() ? "active" : '')?>">
                            <a href="<?= ($USER->IsAuthorized() ? "/user/" : '/auth/')?>" class="links-bar__link link-reset">
                                <svg class="links-bar__icon">
                                    <use xlink:href="<?=SITE_TEMPLATE_PATH?>/assets/icons/sprite-svg.svg#user"/>
                                </svg>
                                <div class="links-bar__block-text">
                                    <span class="links-bar__text">Войти</span>
                                </div>
                            </a>
                        </li>
                        <li class="links-bar__li links-bar__li--theme--orange">
                            <a href="/favorites/" class="links-bar__link link-reset">
                                <svg class="links-bar__icon">
                                    <use xlink:href="<?=SITE_TEMPLATE_PATH?>/assets/icons/sprite-svg.svg#heart"/>
                                </svg>
                                <div class="links-bar__block-text">
                                    <span class="links-bar__text">Избранное</span>
                                    <?$APPLICATION->IncludeComponent(
                                        "affetta:wishlist",
                                        "top",
                                        array(
                                            "ACTION_VARIABLE" => "action",
                                            "AJAX_MODE" => "N",
                                            "AJAX_OPTION_ADDITIONAL" => "",
                                            "AJAX_OPTION_HISTORY" => "N",
                                            "AJAX_OPTION_JUMP" => "N",
                                            "AJAX_OPTION_STYLE" => "N",
                                            "COMPARE_URL" => "compare.php",
                                            "DETAIL_URL" => "",
                                            "IBLOCK_ID" => "22",
                                            "IBLOCK_TYPE" => "catalog",
                                            "NAME" => "CATALOG_WISHLIST_LIST",
                                            "POSITION" => "top left",
                                            "POSITION_FIXED" => "N",
                                            "PRODUCT_ID_VARIABLE" => "id",
                                            "COMPONENT_TEMPLATE" => "top"
                                        ),
                                        false
                                    );?>
                                </div>
                            </a>
                        </li>
                        <li class="links-bar__li links-bar__li--theme--blue">
                            <a href="/catalog/compare.php" class="links-bar__link link-reset">
                                <svg class="links-bar__icon">
                                    <use xlink:href="<?=SITE_TEMPLATE_PATH?>/assets/icons/sprite-svg.svg#compare"/>
                                </svg>
                                <div class="links-bar__block-text">
                                    <span class="links-bar__text">Сравнение</span>
                                    <?$APPLICATION->IncludeComponent(
                                        "bitrix:catalog.compare.list",
                                        "top",
                                        array(
                                            "ACTION_VARIABLE" => "action",
                                            "AJAX_MODE" => "N",
                                            "AJAX_OPTION_ADDITIONAL" => "",
                                            "AJAX_OPTION_HISTORY" => "N",
                                            "AJAX_OPTION_JUMP" => "N",
                                            "AJAX_OPTION_STYLE" => "N",
                                            "COMPARE_URL" => "compare.php",
                                            "DETAIL_URL" => "",
                                            "IBLOCK_ID" => "22",
                                            "IBLOCK_TYPE" => "catalog",
                                            "NAME" => "CATALOG_COMPARE_LIST",
                                            "POSITION" => "top left",
                                            "POSITION_FIXED" => "N",
                                            "PRODUCT_ID_VARIABLE" => "id",
                                            "COMPONENT_TEMPLATE" => "top"
                                        ),
                                        false
                                    );?>
                                </div>
                            </a>
                        </li>
                        <li class="links-bar__li links-bar__li--theme--orange">
                            <a href="/basket/" class="links-bar__link link-reset">
                                <svg class="links-bar__icon">
                                    <use xlink:href="<?=SITE_TEMPLATE_PATH?>/assets/icons/sprite-svg.svg#cart"/>
                                </svg>
                                <div class="links-bar__block-text">
                                    <span class="links-bar__text">Корзина</span>
                                    <?$APPLICATION->IncludeComponent(
                                        "bitrix:sale.basket.basket.line",
                                        "top",
                                        array(
                                            "HIDE_ON_BASKET_PAGES" => "N",
                                            "PATH_TO_AUTHORIZE" => "",
                                            "PATH_TO_BASKET" => SITE_DIR."basket/",
                                            "PATH_TO_ORDER" => SITE_DIR."personal/order/make/",
                                            "PATH_TO_PERSONAL" => SITE_DIR."personal/",
                                            "PATH_TO_PROFILE" => SITE_DIR."personal/",
                                            "PATH_TO_REGISTER" => SITE_DIR."login/",
                                            "POSITION_FIXED" => "N",
                                            "SHOW_AUTHOR" => "N",
                                            "SHOW_EMPTY_VALUES" => "N",
                                            "SHOW_NUM_PRODUCTS" => "Y",
                                            "SHOW_PERSONAL_LINK" => "N",
                                            "SHOW_PRODUCTS" => "N",
                                            "SHOW_REGISTRATION" => "N",
                                            "SHOW_TOTAL_PRICE" => "N",
                                            "COMPONENT_TEMPLATE" => "top"
                                        ),
                                        false
                                    );?>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>