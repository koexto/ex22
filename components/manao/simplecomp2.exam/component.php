<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (!CModule::IncludeModule("iblock"))
	return;

$this->AddIncludeAreaIcons(
	array(
		array(
			'URL' => "javascript:alert('��� ����� ������ ��� ".$this->GetName()."');",
			'SRC' => $this->GetPath().'/images/znak.gif',
			'TITLE' => "��� ����� ������"
		),
		array(
			'URL' => "javascript:alert('��� ��� ���� ������ ��� ".$this->GetName()."');",
			'SRC' => $this->GetPath().'/images/znak1.gif',
			'TITLE' => "��� ��� ���� ������"
		),
	)
);

if (isset($_GET["F"]))
{
	$arResult = $this->getResult();
	$this->IncludeComponentTemplate();
	$APPLICATION->SetTitle("��������: {$arResult["COUNT"]}");
	return;
}

if ($this->StartResultCache(false, $USER->GetGroups()))
{
	$arResult = $this->getResult();
	$this->IncludeComponentTemplate();
}

$APPLICATION->SetTitle("��������: {$arResult["COUNT"]}");
?>