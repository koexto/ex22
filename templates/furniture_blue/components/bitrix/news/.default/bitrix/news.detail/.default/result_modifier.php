<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die(); ?>

<?
if ($arParams["ID_FOR_CANONICAL"] !== "")
{
	$arFilter = array(
		'IBLOCK_ID' => $arParams["ID_FOR_CANONICAL"],
		'ACTIVE' => 'Y',
		'PROPERTY_LINKED_NEWS' => $arResult["ELEMENT_ID"],
	);
	$arSelect = array("NAME");

	$elements = CIBlockElement::GetList(array(), $arFilter, false, false, $arSelect);


	if ($element = $elements->GetNext()) {
		$arResult["CANONICAL_URL"] = $element["NAME"];
		$this->getComponent()->SetResultCacheKeys(array('CANONICAL_URL'));
	}
}
?>

