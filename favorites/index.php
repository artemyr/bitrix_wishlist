<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Избранное");
?>

<?$APPLICATION->IncludeComponent(
    "affetta:catalog.wishlist.result",
    "",
    Array(
        "NAME" => "CATALOG_WISHLIST_LIST",
        "IBLOCK_ID" => CATALOG_IB,

        "USE_WISHLIST" => 'Y',
        "WISHLIST_PATH" => "/catalog/wishlist.php?action=#ACTION_CODE#",
        'WISHLIST_NAME' => 'CATALOG_WISHLIST_LIST',
    )
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>