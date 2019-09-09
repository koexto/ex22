<?php
class FeedbackForm
{
    function changeMacroFeedbackForm(&$event, &$lid, &$arFields)
    {
        if ($event === "FEEDBACK_FORM"){
            global $USER;

            if ($USER->IsAuthorized())
                $author = "������������ �����������: {$USER->GetID()} {$USER->GetLogin()} {$USER->GetFullName()}, ������ �� �����: {$arFields["AUTHOR"]}";
            else
                $author = "������������ �� �����������, ������ �� �����: {$arFields["AUTHOR"]}";

            $arFields["AUTHOR"] = $author;

            CEventLog::Add(array(
                "SEVERITY" => "INFO",
                "AUDIT_TYPE_ID" => "FEEDBACK_FORM",
                "MODULE_ID" => "main",
                "DESCRIPTION" => "������ ������ � ���������� ������ � {$arFields["AUTHOR"]}",
            ));
        }
    }
}