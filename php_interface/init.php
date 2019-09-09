<?
CModule::AddAutoloadClasses(
    '',
    array(
        //load handlers
        'AdvTab' => '/local/php_interface/handlers/advtab.php',
        'DeactiveElement' => '/local/php_interface/handlers/deactiveelement.php',
        'Event404' => '/local/php_interface/handlers/event404.php',
        'FeedbackForm' => '/local/php_interface/handlers/feedbackform.php',
        'KoeAdminMenu' => '/local/php_interface/handlers/koeadminmenu.php',
    )
);

//remove the tab advertising from Iblock Canonical
AddEventHandler("main", "OnAdminTabControlBegin", ["AdvTab", "removeAdvTab"]);
//noDeactiveElementProduction
AddEventHandler("iblock", "OnBeforeIBlockElementUpdate", ["DeactiveElement", "noDeactiveElementProduction"]);
//log 404 error
AddEventHandler("main", "OnAfterEpilog", ["Event404", "event404Log"]);
//change data feedback form
AddEventHandler("main", "OnBeforeEventAdd", ["FeedbackForm", "changeMacroFeedbackForm"]);
//change global menu
AddEventHandler("main", "OnBuildGlobalMenu", ["KoeAdminMenu", "changeMenuForManager"]);


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
















