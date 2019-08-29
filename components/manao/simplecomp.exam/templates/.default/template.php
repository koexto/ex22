<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
//echo "<pre>" . print_r($arResult, true) . "</pre>";

foreach ($arResult["NEWS"] as $key => $value)
{
	$sectionNames = implode(', ', $arResult["SECTION_NAMES"][$key]);
	echo "<h2>{$value["NAME"]}</h2>";
	echo "<p>{$value["ACTIVE_FROM"]} ({$sectionNames})</p>";
	echo "<ul>";
	foreach ($value["SECTION_IDS"] as $idSection) {
		foreach ($arResult["PRODUCTION"][$idSection] as $key2 => $value2) {
			echo "<li>{$value2["NAME"]} - {$value2["PRICE"]} - {$value2["MATERIAL"]} - {$value2["ARTNUMBER"]}</li>";
		}
	}
	echo "</ul>";
}

?>