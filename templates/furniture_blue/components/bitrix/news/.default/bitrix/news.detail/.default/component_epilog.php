<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<?
use Bitrix\Main\Application;
use Bitrix\Main\Type\DateTime;
$request = Application::getInstance()->getContext()->getRequest();
$complaint = $request->getQuery('j');

if ($complaint == "y")
{
	//var_dump($USER->GetID());
	if ($USER->IsAuthorized())
		$userString = $USER->GetID() . ',' . $USER->GetLogin() . ',' . $USER->GetFullName();
	else
		$userString = '�� �����������';

	$date = new DateTime();

	$arLoad = [
		"NAME" => "������",
		"ACTIVE_FROM" => $date->toString(),
		"IBLOCK_SECTION_ID" => false,
		"IBLOCK_ID" => 11,
		"PROPERTY_VALUES" => [
			"USER" => $userString,
			"NEWS" => 1
		]
	];

	$element = new CIBlockElement;
	$element->add($arLoad);
	if ($productId = $element->add($arLoad))
	{
		ob_start();
		echo "���� ������ ������, �{$productId}";
		$APPLICATION->AddViewContent('complaint', ob_get_clean());

		//��� �������
		//$this->__template->SetViewTarget("complaint");
		//���-�� ���
		//$this->__template->EndViewTarget();
	}

}



if (isset($arResult["CANONICAL_URL"]))
	$APPLICATION->SetPageProperty("canonical", $arResult["CANONICAL_URL"]);
?>