<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (!CModule::IncludeModule("iblock"))
	return;

if ($this->StartResultCache())
{
	$arResult = $this->getResult();

	if (empty($arResult))
		$this->AbortResultCache();

	$this->IncludeComponentTemplate();
}

$APPLICATION->SetTitle("В каталоге представлено товаров: " . $arResult["CNT"]);
?>