<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (!CModule::IncludeModule("iblock"))
	return;



if (isset($_GET["F"]))
{
	$arResult = $this->getResult();
	$this->IncludeComponentTemplate();
	$APPLICATION->SetTitle("Разделов: {$arResult["COUNT"]}");
	return;
}

if ($this->StartResultCache(false, $USER->GetGroups()))
{
	$arResult = $this->getResult();
	$this->IncludeComponentTemplate();
}

$APPLICATION->SetTitle("Разделов: {$arResult["COUNT"]}");
?>