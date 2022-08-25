<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

global $APPLICATION;

$aMenuLinksExt = $APPLICATION->IncludeComponent(
    "bitrix:menu.sections",
    "",
    Array(
        "ID" => "",
        "IBLOCK_TYPE" => "catalog",
        "IBLOCK_ID" => CATALOG_IB,
        "SECTION_PAGE_URL" => "/catalog/#SECTION_CODE#/",
        "DEPTH_LEVEL" => "2",
        "CACHE_TYPE" => "N",
        "CACHE_TIME" => "3600"
    )
);

$aMenuLinks = array_merge($aMenuLinks, $aMenuLinksExt);