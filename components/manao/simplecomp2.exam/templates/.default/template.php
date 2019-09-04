<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

//echo "<pre>" . print_r($arResult, 1) . "</pre>";
echo "<pre>" . print_r(time(), 1) . "</pre>";

echo 'фильтр: <a href="?F=ugu">ex2/simplecomp2/?F=ugu</a>';

$items = $arResult["ITEMS"];

for ($i = 0; $i < count($items); $i++)
{
    if ($items[$i]["PROPERTY_FIRM_NAME"] !== $items[$i-1]["PROPERTY_FIRM_NAME"])
        echo "<h2>{$items[$i]["PROPERTY_FIRM_NAME"]}</h2>";


    $this->AddEditAction($items[$i]['ID'] . $items[$i]["PROPERTY_FIRM_NAME"], $items[$i]['ADD_LINK'],
        CIBlock::GetArrayByID($items[$i]["IBLOCK_ID"], "ELEMENT_ADD"),
        Array("ICON" => "bx-context-toolbar-create-icon",));
	$this->AddEditAction($items[$i]['ID'] . $items[$i]["PROPERTY_FIRM_NAME"], $items[$i]['EDIT_LINK'],
        CIBlock::GetArrayByID($items[$i]["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($items[$i]['ID'] . $items[$i]["PROPERTY_FIRM_NAME"], $items[$i]['DELETE_LINK'],
        CIBlock::GetArrayByID($items[$i]["IBLOCK_ID"],"ELEMENT_DELETE"),
        array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

	$link = '<a href="http://' . $items[$i]["DETAIL_PAGE_URL"] . '">' . $items[$i]["NAME"] . '</a>';
	echo "<li id='". $this->GetEditAreaID($items[$i]['ID'] . $items[$i]["PROPERTY_FIRM_NAME"]) ."'>" . " {$link} - {$items[$i]["PRICE"]} - 
			{$items[$i]["MATERIAL"]} - {$items[$i]["ARTNUMBER"]} ({$items[$i]["DETAIL_PAGE_URL"]})</li>";
}
?>

<div style="margin: 34px 15px 35px 15px">
	<?= $arResult["NAV_STRING"] ?>
</div>

<? $this->SetViewTarget('smart-filter');?>
<div style="color:red; margin: 34px 15px 35px 15px">
    <p>Макс. цен - <?=$arResult["MAX"]?></p>
	<p>Мин. цен - <?=$arResult["MIN"]?></p>
</div>
<? $this->EndViewTarget();?>
