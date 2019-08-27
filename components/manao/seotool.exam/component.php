<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
if (CModule::IncludeModule("iblock"))
{
	global $APPLICATION;
	//если убрать - кеш одинаковый для всех страниц
	$arParams["URI"] = $APPLICATION->GetCurUri();

	if ($this->StartResultCache())
	{
		$arResult = $this->getSeoTags();
		$this->IncludeComponentTemplate();
	}
	
	//echo "<pre>" . print_r($arResult, true) . "</pre>";

	if ($arResult){
		$APPLICATION->SetPageProperty("title", $arResult["TITLE"]);
		$APPLICATION->SetPageProperty("description", $arResult["DESCRIPTION"]);
	}
	
}

?>
