<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?

class SimpleComp2 extends CBitrixComponent
{
	private $arSelect = array("ID", "IBLOCK_ID", "NAME", "DETAIL_PAGE_URL", "PROPERTY_PRICE", "PROPERTY_ARTNUMBER",
		"PROPERTY_MATERIAL", "PROPERTY_FIRM");

	function getResult()
	{
		$arParams = $this->arParams;

		$res = CIBlock::GetByID($arParams["ID_IBLOCK_PRODUCTION"])->fetch();
		if ($res)
			$iblockVersion = $res["VERSION"];


		if ($iblockVersion == 1)
		{
			return $this->getFromIblock1($arParams["ID_IBLOCK_PRODUCTION"]);
		}

		if ($iblockVersion == 2)
		{
			return $this->getFromIblock2($arParams["ID_IBLOCK_PRODUCTION"], $arParams["ID_IBLOCK_FIRM"]);
		}

		$arFilterFirm = array(
			'IBLOCK_ID' => $arParams["ID_IBLOCK_FIRM"],
			'ACTIVE' => 'Y',
		);
		$arSelectFirm = array("ID", "NAME", "ACTIVE_FROM");
		$elementsFirm = CIBlockElement::GetList(array(), $arFilterFirm, false, false, $arSelectFirm);

		while ($elementFirm = $elementsFirm->fetch()) {
			$arResult["FIRM"][$elementFirm["ID"]] = ["NAME" => $elementFirm["NAME"]];
		}





		return $arResult;


		$arFilter = array(
			'IBLOCK_ID' => $arParams["ID_IBLOCK_PRODUCTION"],
			'ACTIVE' => 'Y',
		);
		$arSelect = array("ID", "NAME", "IBLOCK_SECTION_ID", "PROPERTY_PRICE", "PROPERTY_ARTNUMBER", "PROPERTY_MATERIAL");

		$elements = CIBlockElement::GetList(array(), $arFilter, false, false, $arSelect);
		$arResult["CNT"] = CIBlockElement::GetList(false, $arFilter, array('ID_IBLOCK_PRODUCTION'))->Fetch();


		while ($element = $elements->fetch()) {
			$arResult["PRODUCTION"][$element["IBLOCK_SECTION_ID"]][] = [
				"NAME" => $element["NAME"],
				"PRICE" => $element["PROPERTY_PRICE_VALUE"],
				"ARTNUMBER" => $element["PROPERTY_ARTNUMBER_VALUE"],
				"MATERIAL" => $element["PROPERTY_MATERIAL_VALUE"],
			];
		}

		return $arResult;

	}

	private function getFromIblock2($idIblock, $idFirm)
	{

		$arFilterFirm = array(
			'IBLOCK_ID' => $idFirm,
			'ACTIVE' => 'Y',
		);
		$arSelectFirm = array("ID", "NAME", "ACTIVE_FROM");
		$elementsFirm = CIBlockElement::GetList(array(), $arFilterFirm, false, false, $arSelectFirm);

		while ($elementFirm = $elementsFirm->fetch()) {
			$arFirm[$elementFirm["ID"]] = $elementFirm["NAME"];
		}

		$elements = $this->getElements($idIblock, $this->arSelect);

		while ($element = $elements->fetch()) {
			//$arResult["PRODUCTION"][] = $element;
			foreach ($element["PROPERTY_FIRM_VALUE"] as $keyFirm)
			{
				$arResult["PRODUCTION"][$arFirm[$keyFirm]][] = [
					"NAME" => $element["NAME"],
					"PRICE" => $element["PROPERTY_PRICE_VALUE"],
					"MATERIAL" => $element["PROPERTY_MATERIAL_VALUE"],
					"ARTNUMBER" => $element["PROPERTY_ARTNUMBER_VALUE"],
				];
			}
		}
		$arResult["COUNT"] = count($arResult["PRODUCTION"]);
		return $arResult;
	}

	private function getFromIblock1($idIblock)
	{
		$arSelect = $this->arSelect;
		$arSelect[] = "PROPERTY_FIRM.NAME";
		$elements = $this->getElements($idIblock, $arSelect);

		while ($element = $elements->fetch()) {
			$arResult["PRODUCTION"][$element["PROPERTY_FIRM_NAME"]][] = [
				"NAME" => $element["NAME"],
				"PRICE" => $element["PROPERTY_PRICE_VALUE"],
				"MATERIAL" => $element["PROPERTY_MATERIAL_VALUE"],
				"ARTNUMBER" => $element["PROPERTY_ARTNUMBER_VALUE"],
			];
		}
		$arResult["COUNT"] = count($arResult["PRODUCTION"]);
		return $arResult;
	}

	private function getElements($idIblock, $arSelect)
	{
		$arFilter = array(
			'IBLOCK_ID' => $idIblock,
			'ACTIVE' => 'Y',
			'!PROPERTY_FIRM' => false,
			'CHECK_PERMISSIONS' => 'Y',
		);
		/*$arSelect = array("ID", "IBLOCK_ID", "NAME", "DETAIL_PAGE_URL", "PROPERTY_PRICE", "PROPERTY_ARTNUMBER",
			"PROPERTY_MATERIAL", "PROPERTY_FIRM", "PROPERTY_FIRM.NAME");*/

		return CIBlockElement::GetList(array(), $arFilter, false, false, $arSelect);
	}
}

?>