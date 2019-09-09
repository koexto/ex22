<?
// логирование/отладка
define("LOG_FILENAME", $_SERVER["DOCUMENT_ROOT"]."/log.txt");
//AddMessage2Log('var = ' . print_r($var, 1), "my_module_id");

use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);
//include(GetLangFileName(dirname(__FILE__)."/lang/", "/init.php"));

use Bitrix\Main\UserTable;
use Bitrix\Main\Config\Option;
//use Bitrix\Main\Type\DateTime;
use Bitrix\Main\Mail\Event;
function CheckUserCount()
{
	$administrators = CUser::GetList(($by = "NAME"), ($order = "desc"), ["GROUPS_ID" => 1]);
	while ($admin = $administrators->fetch()) {
		$emails[] = $admin["EMAIL"];
	}

	$counter = UserTable::GetActiveUsersCount();
	$counterPrev = Option::get("main", "new_user_registered");
	$newUsers = $counter - $counterPrev;
	Option::set("main", "new_user_registered", $counter);

	$time = new DateTime();
	$timePrev = Option::get("main", "new_user_registered_time");
	$timePrev = new DateTime($timePrev);
	$interval = $time->diff($timePrev)->format("%a");
	Option::set("main", "new_user_registered_time", $time->format("d.m.Y H:i:s"));

	AddMessage2Log('var = ' . print_r($timePrev, 1), "my_module_id");

	//каким образом узнать список параметров
	Event::send([
		"EVENT_NAME" => "NEW_USER_COUNTER",
		"LID" => "s1",
		"C_FIELDS" => [
			"EMAIL_TO" => implode(",", $emails),
			"COUNT" => $newUsers,
			"DAYS" => $interval,
		]
	]);

	return "CheckUserCount();";
}



AddEventHandler("main", "OnAdminTabControlBegin", ["AdvTab", "removeAdvTab"]);

class AdvTab
{
	const FORM_NAME = "form_element_5";
	const DIV_TAB = "seo_adv_seo_adv";

	function removeAdvTab(&$form)
	{
		if ($form->name == self::FORM_NAME)
		{
			foreach ($form->tabs as &$value)
			{
				if ($value["DIV"] == self::DIV_TAB)
					$value = [];
			}
		}
	}
}

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
			$APPLICATION->throwException(Loc::GetMessage("INIT_IMPOSSIBILITY_DEACTIVATE", ["#count#" => $count]));
			return false;
		}
	}
}

AddEventHandler("main", "OnAfterEpilog", "event404Log");

//use Bitrix\Main\Application;

function event404Log()
{
    if (defined("ERROR_404") && ERROR_404 == "Y")
	{
		//старое ядро
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
			$author = "Пользователь авторизован: {$USER->GetID()} {$USER->GetLogin()} {$USER->GetFullName()}, данные из формы: {$arFields["AUTHOR"]}";
		else
			$author = "Пользователь не авторизован, данные из формы: {$arFields["AUTHOR"]}";

		$arFields["AUTHOR"] = $author;

		CEventLog::Add(array(
			"SEVERITY" => "INFO",
			"AUDIT_TYPE_ID" => "FEEDBACK_FORM",
			"MODULE_ID" => "main",
			"DESCRIPTION" => "Замена данных в отсылаемом письме – {$arFields["AUTHOR"]}",
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

/*AddEventHandler("main", "OnPageStart", array("KoeSeoTool", "changeSeoTags"));

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
}*/

