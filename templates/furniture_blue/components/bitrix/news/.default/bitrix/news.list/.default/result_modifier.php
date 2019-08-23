<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die(); ?>

<?
if ($arParams["SET_SPECIALDATE"] === "Y" && isset($arResult["ITEMS"][0]["ACTIVE_FROM"]))
{
	$arResult["SET_SPECIALDATE"] = $arResult["ITEMS"][0]["ACTIVE_FROM"];
	$this->getComponent()->SetResultCacheKeys(array('SET_SPECIALDATE'));
}
?>

