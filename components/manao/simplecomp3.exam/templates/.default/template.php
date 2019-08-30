<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

//echo "<pre>" . print_r($arResult, 1) . "</pre>";

foreach ($arResult["AUTHORS"] as $idAuthor => $loginAuthor)
{
	echo "<h2>[{$idAuthor}] {$loginAuthor}</h2>";
	echo "<ul>";
	foreach ($arResult["NEWS"][$idAuthor] as $news)
	{
		echo "<li>{$news["NAME"]} {$news["ACTIVE_FROM"]}</li>";
	}
	echo "</ul>";
}
?>