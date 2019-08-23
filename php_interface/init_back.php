<?
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
			$APPLICATION->throwException("Òîâàð íåâîçìîæíî äåàêòèâèðîâàòü - ó íåãî $count ïðîñìîòðîâ.");
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
		//ñòàðîå ÿäðî
		//global $APPLICATION;
		//$url = $APPLICATION->GetCurUri();
		//íîâîå
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
	
	global $USER;
	if ($USER->IsAuthorized())
	{
		$author = "Ïîëüçîâàòåëü àâòîðèçîâàí: {$USER->GetID()} {$USER->GetLogin()} {$USER->GetFullName()}, äàííûå èç ôîðìû: {$arFields["AUTHOR"]}";
	}
	else
	{
		$author = "Ïîëüçîâàòåëü íå àâòîðèçîâàí, äàííûå èç ôîðìû: {$arFields["AUTHOR"]}";
	}
	$arFields["AUTHOR"] = $author;
	CEventLog::Add(array(
		"SEVERITY" => "INFO",
		"AUDIT_TYPE_ID" => "FEEDBACK_FORM",
		"MODULE_ID" => "main",
		"DESCRIPTION" => "Çàìåíà äàííûõ â îòñûëàåìîì ïèñüìå – {$arFields["AUTHOR"]}",
	));

	//$var = $USER->GetID();
	//$var = $event;
	//AddMessage2Log('var = ' . print_r($var, 1), "my_module_id");
}
