<?php
use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

class DeactiveElement
{
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
}