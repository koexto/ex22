<?php
class FeedbackForm
{
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
}