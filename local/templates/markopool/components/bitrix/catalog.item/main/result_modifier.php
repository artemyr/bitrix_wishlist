<?php
$arFilter = Array('IBLOCK_ID' => CATALOG_IB, 'ID' => $arResult['ITEM']['IBLOCK_SECTION_ID']);
$db_list = CIBlockSection::GetList(Array("SORT"=>"ASC"), $arFilter, true, ['NAME']);
if($ar_result = $db_list->GetNext())
    $arResult['ITEM']['CATALOG_ITEM_CATEGORY_TITLE'] = $ar_result['NAME'];