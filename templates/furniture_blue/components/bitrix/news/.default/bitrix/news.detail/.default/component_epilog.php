<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<?
use Bitrix\Main\Application;
use Bitrix\Main\Type\DateTime;
$request = Application::getInstance()->getContext()->getRequest();
$complaint = $request->getQuery('plaint');

if ($complaint == "y")
{
	if ($USER->IsAuthorized())
		$userString = $USER->GetID() . ',' . $USER->GetLogin() . ',' . $USER->GetFullName();
	else
		$userString = 'Не авторизован';

	$date = new DateTime();

	$arLoad = [
		"NAME" => "Жалоба",
		"ACTIVE_FROM" => $date->toString(),
		"IBLOCK_SECTION_ID" => false,
		"IBLOCK_ID" => 11,
		"PROPERTY_VALUES" => [
			"USER" => $userString,
			"NEWS" => 1
		]
	];

	$element = new CIBlockElement;
	if ($productId = $element->add($arLoad))
	{
		if ($request->isAjaxRequest())
		{
			$APPLICATION->RestartBuffer();
			echo json_encode(["id" => $productId]);
			die();
		}

		?>
        <script>
            products = BX('complaint');
            products.append("Ваше мнение учтено, №<?=$productId?>");
        </script>
		<?
	}

}

if (isset($arResult["CANONICAL_URL"]))
	$APPLICATION->SetPageProperty("canonical", $arResult["CANONICAL_URL"]);
?>