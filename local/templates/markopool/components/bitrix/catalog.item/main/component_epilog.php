<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var array $arResult
 * @var array $arParams
 * @var array $templateData
 */

// check compared state
if ($arParams['DISPLAY_COMPARE'])
{
	$compared = false;
	$comparedIds = array();
	$item = $templateData['ITEM'];

	if (!empty($_SESSION[$arParams['COMPARE_NAME']][$item['IBLOCK_ID']]['ITEMS']))
	{
		if (!empty($item['JS_OFFERS']))
		{
			foreach ($item['JS_OFFERS'] as $key => $offer)
			{
				if (array_key_exists($offer['ID'], $_SESSION[$arParams['COMPARE_NAME']][$item['IBLOCK_ID']]['ITEMS']))
				{
					if ($key == $item['OFFERS_SELECTED'])
					{
						$compared = true;
					}

					$comparedIds[] = $offer['ID'];
				}
			}
		}
		elseif (array_key_exists($item['ID'], $_SESSION[$arParams['COMPARE_NAME']][$item['IBLOCK_ID']]['ITEMS']))
		{
			$compared = true;
		}
	}

    if ($templateData['JS_OBJ'])
	{
		?>
		<script>
			BX.ready(BX.defer(function(){
				if (!!window.<?=$templateData['JS_OBJ']?>)
				{
					window.<?=$templateData['JS_OBJ']?>.setCompared('<?=$compared?>');

					<? if (!empty($comparedIds)): ?>
						window.<?=$templateData['JS_OBJ']?>.setCompareInfo(<?=CUtil::PhpToJSObject($comparedIds, false, true)?>);
					<? endif ?>
				}
			}));
		</script>
		<?
	}
}

if ($arParams['DISPLAY_WISHLIST'])
{
    $wishlist = false;
    $wishlistIds = array();
    $item = $templateData['ITEM'];

    global $USER;
    if (!$USER->IsAuthorized()) {
        if (!empty($_SESSION[$arParams['WISHLIST_NAME']][$item['IBLOCK_ID']]['ITEMS'])) {
            if (!empty($item['JS_OFFERS'])) {
                foreach ($item['JS_OFFERS'] as $key => $offer) {
                    if (array_key_exists($offer['ID'], $_SESSION[$arParams['WISHLIST_NAME']][$item['IBLOCK_ID']]['ITEMS'])) {
                        if ($key == $item['OFFERS_SELECTED']) {
                            $wishlist = true;
                        }

                        $wishlistIds[] = $offer['ID'];
                    }
                }
            } elseif (array_key_exists($item['ID'], $_SESSION[$arParams['WISHLIST_NAME']][$item['IBLOCK_ID']]['ITEMS'])) {
                $wishlist = true;
            }
        }
    } else {

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