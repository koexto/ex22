<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (!CModule::IncludeModule("iblock"))
	return;


$this->AddIncludeAreaIcon(
	array(
		"ID" => "IB_admin",
		"TITLE" => "ИБ в админке",
		"URL" => "http://" . SITE_SERVER_NAME . "/bitrix/admin/iblock_element_admin.php?IBLOCK_ID=" . $arParams["ID_IBLOCK_PRODUCTION"] .
				"&type=products&lang=ru&find_el_y=Y&clear_filter=Y&apply_filter=Y", //или javascript:MyJSFunction ()
		"IN_PARAMS_MENU" => true, //показать в контекстном меню
		//"IN_MENU" => true //показать в подменю компонента
	)
);

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