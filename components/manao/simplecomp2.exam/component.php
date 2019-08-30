<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (!CModule::IncludeModule("iblock"))
	return;

$this->AddIncludeAreaIcons(
	array(
		array(
			'URL' => "javascript:alert('Это новая кнопка для ".$this->GetName()."');",
			'SRC' => $this->GetPath().'/images/znak.gif',
			'TITLE' => "Это новая кнопка"
		),
		array(
			'URL' => "javascript:alert('Это ещё одна кнопка для ".$this->GetName()."');",
			'SRC' => $this->GetPath().'/images/znak1.gif',
			'TITLE' => "Это ещё одна кнопка"
		),
	)
);

if (isset($_GET["F"]))
{
	$arResult = $this->getResult();
	$this->IncludeComponentTemplate();
	$APPLICATION->SetTitle("Разделов: {$arResult["COUNT"]}");
	return;
}

if ($this->StartResultCache(false, $USER->GetGroups()))
{
	$arResult = $this->getResult();
	$this->IncludeComponentTemplate();
}

$APPLICATION->SetTitle("Разделов: {$arResult["COUNT"]}");
?>