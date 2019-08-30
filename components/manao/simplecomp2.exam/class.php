<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?

class SimpleComp2 extends CBitrixComponent
{
	private $arSelect = array("ID", "IBLOCK_ID", "NAME", "CODE", "DETAIL_PAGE_URL", "PROPERTY_PRICE", "PROPERTY_ARTNUMBER",
		"PROPERTY_MATERIAL", "PROPERTY_FIRM");

	function getResult()
	{
		//$arResult["get"] = $_GET;
		//return $arResult;

		$res = CIBlock::GetByID($this->arParams["ID_IBLOCK_PRODUCTION"])->fetch();
		if ($res)
			$iblockVersion = $res["VERSION"];

		if ($iblockVersion == 1)
			return $this->getFromIblock1();

		if ($iblockVersion == 2)
			return $this->getFromIblock2();
	}

	private function getFromIblock1()
	{
		$arSelect = $this->arSelect;
		$arSelect[] = "PROPERTY_FIRM.NAME";
		$production = $this->getProduction($arSelect);
		$production->SetUrlTemplates($this->arParams["URL_DETAIL"]);

		while ($product = $production->GetNext())
			$arResult["PRODUCTION"][$product["PROPERTY_FIRM_NAME"]][] = $this->getArrayProduct($product);

		$arResult["COUNT"] = count($arResult["PRODUCTION"]);
		return $arResult;
	}

	private function getFromIblock2()
	{

		$arFilterFirm = array(
			'IBLOCK_ID' => $this->arParams["ID_IBLOCK_FIRM"],
			'ACTIVE' => 'Y',
			'CHECK_PERMISSIONS' => 'Y',
		);
		$arSelectFirm = array("ID", "NAME", "ACTIVE_FROM");
		$elementsFirm = CIBlockElement::GetList(array(), $arFilterFirm, false, false, $arSelectFirm);

		while ($elementFirm = $elementsFirm->fetch())
			$arFirm[$elementFirm["ID"]] = $elementFirm["NAME"];

		$production = $this->getProduction($this->arSelect);
		$production->SetUrlTemplates($this->arParams["URL_DETAIL"]);

		while ($product = $production->GetNext()) {
			foreach ($product["PROPERTY_FIRM_VALUE"] as $keyFirm)
				$arResult["PRODUCTION"][$arFirm[$keyFirm]][] = $this->getArrayProduct($product);
		}
		$arResult["COUNT"] = count($arResult["PRODUCTION"]);
		return $arResult;
	}

	private function  getArrayProduct($product)
	{
		return [
			"NAME" => $product["NAME"],
			"PRICE" => $product["PROPERTY_PRICE_VALUE"],
			"MATERIAL" => $product["PROPERTY_MATERIAL_VALUE"],
			"ARTNUMBER" => $product["PROPERTY_ARTNUMBER_VALUE"],
			"DETAIL_PAGE_URL" => $product["DETAIL_PAGE_URL"],
		];
	}

	private function getProduction($arSelect)
	{
		$arOrder = array(
			"NAME" => "ASC",
			"SORT" => "ASC",
		);
		$arFilter = array(
			"IBLOCK_ID" => $this->arParams["ID_IBLOCK_PRODUCTION"],
			"ACTIVE" => "Y",
			"!PROPERTY_FIRM" => false,
			"CHECK_PERMISSIONS" => "Y",

		);
		if (isset($_GET["F"]))
		{
			$arFilter[] = array(
				"LOGIC" => "OR",
				array("<=PROPERTY_PRICE" => 1700, "PROPERTY_MATERIAL" => "Дерево, ткань"),
				array("<PROPERTY_PRICE" => 1500, "PROPERTY_MATERIAL" => "Металл, пластик"),
			);
		}

		return CIBlockElement::GetList($arOrder, $arFilter, false, false, $arSelect);
	}
}

?>