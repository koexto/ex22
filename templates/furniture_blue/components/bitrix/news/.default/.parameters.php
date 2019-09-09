<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

CModule::IncludeModule("iblock");

$dbIBlockType = CIBlockType::GetList(
	array("sort" => "asc"),
	array("ACTIVE" => "Y")
);

while ($arIBlockType = $dbIBlockType->Fetch())
{
	if ($arIBlockTypeLang = CIBlockType::GetByIDLang($arIBlockType["ID"], LANGUAGE_ID))
		$arIblockType[$arIBlockType["ID"]] = "[".$arIBlockType["ID"]."] ".$arIBlockTypeLang["NAME"];
}


$arTemplateParameters = array(
	"SET_SPECIALDATE" => Array(
		"NAME" => GetMessage("T_IBLOCK_DESC_NEWS_SPECIALDATE"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "N",
	),
	"TYPE_IBLOCK_FOR_CANONICAL" => Array(
		"NAME" => GetMessage("T_IBLOCK_DESC_TYPE_IBLOCK_FOR_CANONICAL"),
		"TYPE" => "LIST",
		"VALUES" => $arIblockType,
		"REFRESH" => "Y",
	),
	"COMPLAINT_AJAX" => Array(
		"NAME" => GetMessage("T_IBLOCK_DESC_COMPLAINT_AJAX"),
		"TYPE" => "STRING",
		"DEFAULT" => "N",
	),
);

if ($arCurrentValues['TYPE_IBLOCK_FOR_CANONICAL'] != "")
{
	$res = CIBlock::GetList(
		array(),
		array(
			'TYPE' => $arCurrentValues['TYPE_IBLOCK_FOR_CANONICAL'],
			'ACTIVE' => 'Y',
		),
		false
	);

	while($ar_res = $res->fetch())
	{
		$arIblock[$ar_res["ID"]] = $ar_res["NAME"];
	}

	$arTemplateParameters['ID_FOR_CANONICAL'] = array(
		'NAME' => GetMessage("T_IBLOCK_DESC_IBLOCK_FOR_CANONICAL"),
		'TYPE' => 'LIST',
		'VALUES' => $arIblock,
	);
}
?>
