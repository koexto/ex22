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

$arResult = $this->getResult();


/*foreach ($arResult["NEWS"] as $key => $value) {
	$arResult["NEWS"][$key]["NAME"] = $value;
	$arResult["NEWS"][$key]["SECTION"] = $arResult["SECTION"][$key];
}*/


//$arResult["id"] = $arParams["ID_IBLOCK_NEWS"];

$this->IncludeComponentTemplate();
?>