<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$arComponentParameters = array(
	"GROUPS" => array(),
	"PARAMETERS" => array(
        "ID_IBLOCK_PRODUCTION" => array(
            "PARENT" => "BASE",
            "NAME" => GetMessage("T_SIMPLECOMP3_ID_IBLOCK_NEWS"),
            "TYPE" => "STRING",
            "DEFAULT" => "",
        ),
        "ID_IBLOCK_FIRM" => array(
            "PARENT" => "BASE",
            "NAME" => GetMessage("T_SIMPLECOMP3_PROPERTY_AUTHOR"),
            "TYPE" => "STRING",
            "DEFAULT" => "",
        ),
        "PRODUCTION_PROPERTY_FIRM" => array(
            "PARENT" => "BASE",
            "NAME" => GetMessage("T_SIMPLECOMP3_USER_PROPERTY_AUTHOR"),
            "TYPE" => "STRING",
            "DEFAULT" => "",
        ),
        "CACHE_TIME" => array(),
	),
);
?>