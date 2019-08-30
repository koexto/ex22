<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

//echo "<pre>" . print_r($arResult, 1) . "</pre>";

echo 'фильтр: <a href="?F=ugu">ex2/simplecomp2/?F=ugu</a>';

foreach ($arResult["PRODUCTION"] as $key=>$production)
{
	echo "<h2>{$key}</h2><ul>";
	foreach ($production as $product)
	{
		$link = '<a href="http://' . $product["DETAIL_PAGE_URL"] . '">' . $product["NAME"] . '</a>';
		echo "<li>{$link} - {$product["PRICE"]} - {$product["MATERIAL"]} - {$product["ARTNUMBER"]} ({$product["DETAIL_PAGE_URL"]})</li>";
	}
	echo "</ul>";
}
?>