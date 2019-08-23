<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<? 
if (isset($arResult["SET_SPECIALDATE"]))
{
	$APPLICATION->SetPageProperty("specialdate", $arResult["SET_SPECIALDATE"]);
}
?>