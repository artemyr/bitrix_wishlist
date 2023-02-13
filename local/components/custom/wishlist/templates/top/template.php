<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */

$whishlistId = "whishlist" . $this->randString();
$obWishlist = 'ob'.$whishlistId;
$itemCount = $arResult['COUNT'];
$needReload = (isset($_REQUEST["whishlist_list_reload"]) && $_REQUEST["whishlist_list_reload"] == "Y");
?>

<div id="<?=$whishlistId; ?>">
    <?

    if ($needReload)
    {
        $APPLICATION->RestartBuffer();
    }

    $frame = $this->createFrame($whishlistId)->begin('');
    if ($itemCount > 0)
    {
    ?>
        <span class="links-bar__count"><?echo $itemCount;?></span><?
}
    $frame->end();

    if ($needReload)
    {
        die();
    }


    $currentPath = CHTTP::urlDeleteParams(
        $APPLICATION->GetCurPageParam(),
        array(
            $arParams['PRODUCT_ID_VARIABLE'],
            $arParams['ACTION_VARIABLE'],
            'ajax_action'
        ),
        array("delete_system_params" => true)
    );

    $jsParams = array(
        'VISUAL' => array(
            'ID' => $whishlistId,
        ),
        'AJAX' => array(
            'url' => $currentPath,
            'params' => array(
                'ajax_action' => 'Y'
            ),
            'reload' => array(
                'whishlist_list_reload' => 'Y'
            ),
            'templates' => array(
                'delete' => (mb_strpos($currentPath, '?') === false ? '?' : '&') . $arParams['ACTION_VARIABLE'] . '=DELETE_FROM_WISHLIST_LIST&' . $arParams['PRODUCT_ID_VARIABLE'] . '='
            )
        ),
        'POSITION' => array(
            'fixed' => $arParams['POSITION_FIXED'] == 'Y',
            'align' => array(
                'vertical' => $arParams['POSITION'][0],
                'horizontal' => $arParams['POSITION'][1]
            )
        )
    );?>
</div>

<script type="text/javascript">
    var <?=$obWishlist; ?> = new Wishlist(<? echo CUtil::PhpToJSObject($jsParams, false, true); ?>)
</script>