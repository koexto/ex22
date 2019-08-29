<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$arComponentParameters = array(
	"GROUPS" => array(),
	"PARAMETERS" => array(
        "ID_IBLOCK_NEWS" => array(
            "PARENT" => "BASE",
            "NAME" => GetMessage("T_SIMPLECOMP3_ID_IBLOCK_NEWS"),
            "TYPE" => "STRING",
            "DEFAULT" => "",
        ),
        "CODE_PROPERTY_AUTHOR" => array(
            "PARENT" => "BASE",
            "NAME" => GetMessage("T_SIMPLECOMP3_PROPERTY_AUTHOR"),
            "TYPE" => "STRING",
            "DEFAULT" => "",
        ),
        "USER_PROPERTY_AUTHOR" => array(
            "PARENT" => "BASE",
            "NAME" => GetMessage("T_SIMPLECOMP3_USER_PROPERTY_AUTHOR"),
            "TYPE" => "STRING",
            "DEFAULT" => "",
        ),
        "CACHE_TIME" => array(),
	),
);
?>