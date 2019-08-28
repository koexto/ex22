<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();


CModule::IncludeModule("iblock");




$arResult = $this->getResult();

$this->IncludeComponentTemplate();

$APPLICATION->SetTitle("Разделов: {$arResult["COUNT"]}");
?>