<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arTemplateParameters = array(
	"SET_SPECIALDATE" => Array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_SPECIALDATE"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "N",
	),
	"ID_FOR_CANONICAL" => Array(
		"NAME" => GetMessage("T_IBLOCK_DESC_ID_FOR_CANONICAL"),
		"TYPE" => "STRING",
		"DEFAULT" => "",
	),
);
?>
