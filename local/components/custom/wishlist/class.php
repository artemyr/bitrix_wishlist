<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main;

class WishlistComponent extends CBitrixComponent
{
    public function executeComponent()
    {
        global $USER;
        global $APPLICATION;
        CModule::IncludeModule("sale");

        $arBasketItems = $this->authFavs();

        $this->arResult['ITEMS'] = $arBasketItems;
        $this->arResult['COUNT'] = count($arBasketItems);

        $this->IncludeComponentTemplate();
    }

    private function authFavs()
    {
        global $APPLICATION;

        if (isset($_REQUEST[$this->arParams['ACTION_VARIABLE']]) && isset($_REQUEST[$this->arParams['PRODUCT_ID_VARIABLE']])) {
            $successfulAction = true;
            $findMethod = true;
            $actionMessage = '';
            $actionByAjax = isset($_REQUEST['ajax_action']) && $_REQUEST['ajax_action'] == 'Y';

            $productID = (int)$_REQUEST[$this->arParams['PRODUCT_ID_VARIABLE']];
            $resultCount = 0;
            if ($productID > 0) {
                switch (ToUpper($_REQUEST[$this->arParams['ACTION_VARIABLE']])) {
                    case 'ADD_TO_WISHLIST_LIST':
                        $actionMessage = "add to wishlist";

                        $this->addToBasketDelayProduct($productID);
                        $resultCount = count($this->getDelayProducts());
                        break;
                    case 'DELETE_FROM_WISHLIST_LIST':
                        $actionMessage = "remove from wishlist";

                        $this->deleteFromBasketDelayProduct($productID);
                        $resultCount = count($this->getDelayProducts());
                        break;
                    default:
                        $findMethod = false;
                        break;
                }
            } else {
                $successfulAction = false;
                $actionMessage = GetMessage('CP_BCCL_ERR_MESS_PRODUCT_NOT_FOUND');
            }

            if ($actionByAjax && $findMethod) {
                if ($successfulAction)
                    $addResult = array('STATUS' => 'OK', 'MESSAGE' => $actionMessage, 'ID' => $productID, 'COUNT' => $resultCount);
                else
                    $addResult = array('STATUS' => 'ERROR', 'MESSAGE' => $actionMessage);

                $APPLICATION->RestartBuffer();
                header('Content-Type: application/json');
                echo Main\Web\Json::encode($addResult);
                die();
            }
        }



        // if non json response
        return $this->getDelayProducts();
    }

    private function addToBasketDelayProduct($productID){
        $arFields = array(
            "PRODUCT_ID" => $productID,
            "PRODUCT_PRICE_ID" => 0,
            "PRICE" => 0,
            "CURRENCY" => "RUB",
            "WEIGHT" => 0,
            "QUANTITY" => 1,
            "LID" => LANG,
            "DELAY" => "Y",
            "CAN_BUY" => "Y",
            "NAME" => "Чемодан кожаный",
            "CALLBACK_FUNC" => "MyBasketCallback",
            "MODULE" => "wishlist",
            "NOTES" => "Добавлено в избранное",
            "ORDER_CALLBACK_FUNC" => "MyBasketOrderCallback",
            "DETAIL_PAGE_URL" => "/" . LANG . "/detail.php?ID=$productID"
        );

        $arProps = array();

        $arProps[] = array(
            "NAME" => "Избрпннон",
            "CODE" => "favorite",
            "VALUE" => "Да"
        );

        $arFields["PROPS"] = $arProps;

        CSaleBasket::Add($arFields);
    }

    private function deleteFromBasketDelayProduct($productID){
        $favs = $this->getDelayProducts();

        $delId = 0;

        foreach ($favs as $item){
            if($item['PRODUCT_ID'] == $productID){
                $delId = $item['ID'];
                break;
            }
        }

        if (CSaleBasket::Delete($delId))
            return "Запись успешно удалена";
    }

    private function  getDelayProducts() {
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

            $arBasketItems[] = $arItems;
        }
        return $arBasketItems;
    }

    private function nonAuthFavs(){
        global $APPLICATION;

        if (isset($_REQUEST[$this->arParams['ACTION_VARIABLE']]) && isset($_REQUEST[$this->arParams['PRODUCT_ID_VARIABLE']])) {
            $successfulAction = true;
            $findMethod = true;
            $actionMessage = '';
            $actionByAjax = isset($_REQUEST['ajax_action']) && $_REQUEST['ajax_action'] == 'Y';

            $productID = (int)$_REQUEST[$this->arParams['PRODUCT_ID_VARIABLE']];
            $resultCount = 0;
            if ($productID > 0) {
                switch (ToUpper($_REQUEST[$this->arParams['ACTION_VARIABLE']])) {
                    case 'ADD_TO_WISHLIST_LIST':
                        $actionMessage = "add to wishlist";
                        if (!isset($_SESSION[$this->arParams["NAME"]][$this->arParams["IBLOCK_ID"]]["ITEMS"][$productID]))
                        {
                            $_SESSION[$this->arParams['NAME']][$this->arParams['IBLOCK_ID']]['ITEMS'][$productID] = array(
                                'ID' => $productID,
                                'DELETE_URL' => htmlspecialcharsbx($APPLICATION->GetCurPageParam(
                                    $this->arParams['ACTION_VARIABLE'] . "=DELETE_FROM_COMPARE_LIST&" . $this->arParams['PRODUCT_ID_VARIABLE'] . "=" . $productID,
                                    array($this->arParams['ACTION_VARIABLE'], $this->arParams['PRODUCT_ID_VARIABLE'])
                                ))
                            );
                            unset($sectionsList, $arElement);
                            $resultCount = count($_SESSION[$this->arParams['NAME']][$this->arParams['IBLOCK_ID']]['ITEMS']);
                        }
                        break;
                    case 'DELETE_FROM_WISHLIST_LIST':
                        if (isset($_SESSION[$this->arParams["NAME"]][$this->arParams["IBLOCK_ID"]]["ITEMS"][$productID]))
                            unset($_SESSION[$this->arParams["NAME"]][$this->arParams["IBLOCK_ID"]]["ITEMS"][$productID]);
                        $actionMessage = "remove from wishlist";
                        $resultCount = count($_SESSION[$this->arParams["NAME"]][$this->arParams["IBLOCK_ID"]]["ITEMS"]);
                        break;
                    default:
                        $findMethod = false;
                        break;
                }
            } else {
                $successfulAction = false;
                $actionMessage = GetMessage('CP_BCCL_ERR_MESS_PRODUCT_NOT_FOUND');
            }

            if ($actionByAjax && $findMethod) {
                if ($successfulAction)
                    $addResult = array('STATUS' => 'OK', 'MESSAGE' => $actionMessage, 'ID' => $productID, 'COUNT' => $resultCount);
                else
                    $addResult = array('STATUS' => 'ERROR', 'MESSAGE' => $actionMessage);

                $APPLICATION->RestartBuffer();
                header('Content-Type: application/json');
                echo Main\Web\Json::encode($addResult);
                die();
            }
        }

        return $_SESSION[$this->arParams["NAME"]][$this->arParams["IBLOCK_ID"]]["ITEMS"];
    }
}
