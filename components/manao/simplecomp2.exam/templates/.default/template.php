<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

echo "<pre>" . print_r($arResult, 1) . "</pre>";

echo 'фильтр: <a href="?F=ugu">ex2/simplecomp2/?F=ugu</a>';

foreach ($arResult["PRODUCTION"] as $key=>$production)
{
	echo "<h2>{$key}</h2><ul>";
	foreach ($production as $product)
	{
		$this->AddEditAction($product['ID'] . $key, $product['ADD_LINK'], CIBlock::GetArrayByID($product["IBLOCK_ID"], "ELEMENT_ADD"),
			Array("ICON" => "bx-context-toolbar-create-icon",));
		$this->AddEditAction($product['ID'] . $key, $product['EDIT_LINK'], CIBlock::GetArrayByID($product["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($product['ID'] . $key, $product['DELETE_LINK'], CIBlock::GetArrayByID($product["IBLOCK_ID"],
			"ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

		$link = '<a href="http://' . $product["DETAIL_PAGE_URL"] . '">' . $product["NAME"] . '</a>';
		echo "<li id='". $this->GetEditAreaID($product['ID'] . $key) ."'>" . " {$link} - {$product["PRICE"]} - 
			{$product["MATERIAL"]} - {$product["ARTNUMBER"]} ({$product["DETAIL_PAGE_URL"]})</li>";
	}
	unset($product);
	echo "</ul>";
}
?>