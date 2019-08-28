<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die(); ?>
<?
class SimpleComp extends CBitrixComponent
{
	function getResult()
	{
		$arParams = $this->arParams;
		$arFilterNews = array(
			'IBLOCK_ID' => $arParams["ID_IBLOCK_NEWS"],
			'ACTIVE' => 'Y',
		);
		$arSelectNews = array("ID", "NAME", "ACTIVE_FROM");
		$elementsNews = CIBlockElement::GetList(array(), $arFilterNews, false, false, $arSelectNews);

		while ($elementNews = $elementsNews->fetch())
		{
			$arResult["NEWS"][$elementNews["ID"]] = [$elementNews["NAME"], $elementNews["ACTIVE_FROM"]];
		}


		$arFilterSection = array(
			'IBLOCK_ID' => $arParams["ID_IBLOCK_PRODUCTION"],
			'ACTIVE' => 'Y',
		);
		$arSelectSection = array("ID", "NAME", "IBLOCK_ID", "UF_NEWS_LINK");
		$sections = CIBlockSection::GetList(array(), $arFilterSection, false, $arSelectSection);

		while ($section = $sections->fetch())
		{
			foreach ($section["UF_NEWS_LINK"] as $key => $value) {
				$arResult["SECTION"][$value][$section["ID"]]=$section;
				$arResult["SECTION_NAMES"][$value][] = $section["NAME"];
			}
		}


		$arFilter = array(
			'IBLOCK_ID' => $arParams["ID_IBLOCK_PRODUCTION"],
			'ACTIVE' => 'Y',
		);
		$arSelect = array("ID", "NAME", "IBLOCK_SECTION_ID", "PROPERTY_PRICE", "PROPERTY_ARTNUMBER", "PROPERTY_MATERIAL");

		$elements = CIBlockElement::GetList(array(), $arFilter, false, false, $arSelect);

		while ($element = $elements->fetch())
		{
			$arResult["PRODUCTION"][$element["IBLOCK_SECTION_ID"]][] = [
				"NAME" => $element["NAME"],
				"PRICE" => $element["PROPERTY_PRICE_VALUE"],
				"ARTNUMBER" => $element["PROPERTY_ARTNUMBER_VALUE"],
				"MATERIAL" => $element["PROPERTY_MATERIAL_VALUE"],
			];
		}

		return $arResult;

	}
}
?>