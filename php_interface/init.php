<?
// логирование/отладка
define("LOG_FILENAME", $_SERVER["DOCUMENT_ROOT"]."/log.txt");

AddEventHandler("iblock", "OnBeforeIBlockElementUpdate", "noDeactiveElementProduction");

function noDeactiveElementProduction($arFields)
{
	if ($arFields["IBLOCK_ID"] === 2 && $arFields["ACTIVE"] === "N")
	{

		$arFilter = array(
			'IBLOCK_ID' => $arFields["IBLOCK_ID"],
			'ID' => $arFields["ID"],
			'ACTIVE' => 'Y',
		);
		$arSelect = array("ID", "SHOW_COUNTER");

		$element = CIBlockElement::GetList(array(), $arFilter, false, false, $arSelect)->GetNext();

		$count = $element["SHOW_COUNTER"];

		if ($count > 2)
		{
			global $APPLICATION;
			$APPLICATION->throwException("“овар невозможно деактивировать - у него $count просмотров.");
			return false;
		}
	}
}

AddEventHandler("main", "OnAfterEpilog", "event404Log");

//use Bitrix\Main\Application;

function event404Log()
{
	if (http_response_code() === 404)
	{
		//старое €дро
		//global $APPLICATION;
		//$url = $APPLICATION->GetCurUri();
		//новое
		//$url = Application::getInstance()->getContext()->getRequest()->getDecodedUri();
		$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		CEventLog::Add(array(
			"SEVERITY" => "INFO",
			"AUDIT_TYPE_ID" => "ERROR_404",
			"MODULE_ID" => "main",
			"DESCRIPTION" => $url,
		));
	}

}

AddEventHandler("main", "OnBeforeEventAdd", "changeMacroFeedbackForm");

function changeMacroFeedbackForm(&$event, &$lid, &$arFields)
{
	if ($event === "FEEDBACK_FORM"){
		global $USER;

		if ($USER->IsAuthorized())
			$author = "ѕользователь авторизован: {$USER->GetID()} {$USER->GetLogin()} {$USER->GetFullName()}, данные из формы: {$arFields["AUTHOR"]}";
		else
			$author = "ѕользователь не авторизован, данные из формы: {$arFields["AUTHOR"]}";

		$arFields["AUTHOR"] = $author;

		CEventLog::Add(array(
			"SEVERITY" => "INFO",
			"AUDIT_TYPE_ID" => "FEEDBACK_FORM",
			"MODULE_ID" => "main",
			"DESCRIPTION" => "«амена данных в отсылаемом письме Ц {$arFields["AUTHOR"]}",
		));	
	}
}

AddEventHandler("main", "OnBuildGlobalMenu", array("KoeAdminMenu", "changeMenuForManager"));

class KoeAdminMenu
{
	const MANAGER_GROUP_ID = 5;

	function changeMenuForManager(&$aGlobalMenu, &$aModuleMenu)
	{
		global $USER;
		if ($USER->IsAdmin())
			return;

		if (in_array(self::MANAGER_GROUP_ID, $USER->GetUserGroupArray()))
		{
			$aGlobalMenuContent = $aGlobalMenu["global_menu_content"];
			$aGlobalMenu = [];
			$aGlobalMenu["global_menu_content"] = $aGlobalMenuContent;

			$newsMenu = static::newsMenu($aModuleMenu);
			$aModuleMenu = [];
			$aModuleMenu[] = $newsMenu;
		}
	}

	static function newsMenu($aModuleMenu)
	{
		foreach ($aModuleMenu as $key => $value)
		{
			if ($value["items_id"] === "menu_iblock_/news")
			{
				$newsMenu = $aModuleMenu[$key];
				return $newsMenu;
			}
		}
	}
	
}

AddEventHandler("main", "OnPageStart", array("KoeSeoTool", "changeSeoTags"));

class KoeSeoTool
{
	const ID_IBLOCK_METATAGS = 6;

	function changeSeoTags()
	{
		if (CModule::IncludeModule("iblock"))
			return;


		$arFilter = array(
			'IBLOCK_ID' => self::ID_IBLOCK_METATAGS,
			'NAME' => $_SERVER[REQUEST_URI],
			'ACTIVE' => 'Y',
		);
		$arSelect = array("ID", "PROPERTY_TITLE", "PROPERTY_DESCRIPTION");

		$element = CIBlockElement::GetList(array(), $arFilter, false, false, $arSelect)->fetch();

		global $APPLICATION;
		$APPLICATION->SetPageProperty("title", $element["PROPERTY_TITLE_VALUE"]);
		$APPLICATION->SetPageProperty("description", $element["PROPERTY_DESCRIPTION_VALUE"]);

		$var = $element;
		AddMessage2Log('var = ' . print_r($var, 1), "my_module_id");

	}
}

