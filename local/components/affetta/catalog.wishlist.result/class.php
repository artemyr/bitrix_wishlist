<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main;

class WishlistResultComponent extends CBitrixComponent
{
    public function executeComponent()
    {
        CModule::IncludeModule("sale");
//        global $APPLICATION;
        global $USER;

        if(!$USER->IsAuthorized()){
            foreach ($_SESSION[$this->arParams["NAME"]][$this->arParams["IBLOCK_ID"]]["ITEMS"] as $item){
                $this->arResult['ITEMS']['ID'][] = $item['ID'];
            }
        } else {
            $this->arResult['ITEMS']['ID'] = $this->getDelayProductsIds();
        }

        $this->IncludeComponentTemplate();
    }

    private function  getDelayProductsIds() {
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

            $arBasketItems[] = $arItems['PRODUCT_ID'];
        }

        return $arBasketItems;
    }
}
