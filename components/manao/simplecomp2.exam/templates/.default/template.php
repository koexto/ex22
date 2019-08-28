<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

//echo "<pre>" . print_r($arResult, 1) . "</pre>";

foreach ($arResult["PRODUCTION"] as $key=>$production)
{
	echo "<h2>{$key}</h2><ul>";
	foreach ($production as $product)
	{
		echo "<li>{$product["NAME"]} - {$product["PRICE"]} - {$product["MATERIAL"]} - {$product["ARTNUMBER"]}</li>";
	}
	echo "</ul>";
}
?>