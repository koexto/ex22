<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$arComponentParameters = array(
	"GROUPS" => array(),
	"PARAMETERS" => array(
        "ID_IBLOCK_PRODUCTION" => array(
            "PARENT" => "BASE",
            "NAME" => GetMessage("T_SIMPLECOMP_ID_IBLOCK_PRODUCTION"),
            "TYPE" => "STRING",
            "DEFAULT" => "",
        ),
        "ID_IBLOCK_NEWS" => array(
            "PARENT" => "BASE",
            "NAME" => GetMessage("T_SIMPLECOMP_ID_IBLOCK_NEWS"),
            "TYPE" => "STRING",
            "DEFAULT" => "",
        ),
        "ID_PROPERTY_PRODUCTION" => array(
            "PARENT" => "BASE",
            "NAME" => GetMessage("T_SIMPLECOMP_PROPERTY_PRODUCTION"),
            "TYPE" => "STRING",
            "DEFAULT" => "",
        ),
        "SET_TITLE" => array(),
        "CACHE_TIME" => array(),
	),
);
?>