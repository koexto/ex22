<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();


//$arResult['DATE'] = date('Y-m-d');
//$arParams["ID_IBLOCK_NEWS"]

/*news
$arFilter = array(
    'IBLOCK_ID' => $arParams["ID_IBLOCK_NEWS"],
    'ACTIVE' => 'Y',
);
$arSelect = array("ID", "NAME");
*/

$arFilter = array(
    'IBLOCK_ID' => $arParams["ID_IBLOCK_NEWS"],
    'ACTIVE' => 'Y',
);
$arSelect = array("ID", "NAME", "IBLOCK_SECTION_ID", "UF_NEWS_LINK");


$elements = CIBlockElement::GetList(array(), $arFilter, false, false, $arSelect);

while ($element = $elements->fetch())
{
    $arResult["NEWS"][] = $element;
}

$arResult["id"] = $arParams["ID_IBLOCK_NEWS"];

$this->IncludeComponentTemplate();
?>