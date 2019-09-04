<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$arComponentParameters = array(
	"GROUPS" => array(),
	"PARAMETERS" => array(
        "ID_IBLOCK_PRODUCTION" => array(
            "PARENT" => "BASE",
            "NAME" => GetMessage("T_SIMPLECOMP2_ID_IBLOCK_PRODUCTION"),
            "TYPE" => "STRING",
            "DEFAULT" => "",
        ),
        "ID_IBLOCK_FIRM" => array(
            "PARENT" => "BASE",
            "NAME" => GetMessage("T_SIMPLECOMP2_ID_IBLOCK_FIRM"),
            "TYPE" => "STRING",
            "DEFAULT" => "",
        ),
        "PRODUCTION_PROPERTY_FIRM" => array(
            "PARENT" => "BASE",
            "NAME" => GetMessage("T_SIMPLECOMP2_PRODUCTION_PROPERTY_FIRM"),
            "TYPE" => "STRING",
            "DEFAULT" => "",
        ),
        "URL_DETAIL" => array(
            "PARENT" => "BASE",
            "NAME" => GetMessage("T_SIMPLECOMP2_URL_DETAIL"),
            "TYPE" => "STRING",
            "DEFAULT" => "",
        ),
		"ELEMENTS_ON_PAGE" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("T_SIMPLECOMP2_ELEMENTS_ON_PAGE"),
			"TYPE" => "STRING",
			"DEFAULT" => "10",
		),
        "CACHE_TIME" => array(),
	),
);
?>