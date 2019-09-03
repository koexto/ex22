<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?

class SimpleComp2 extends CBitrixComponent
{
	function getResult()
	{
		$production = $this->getProduction();
		$production->SetUrlTemplates($this->arParams["URL_DETAIL"]);
		//$arResult["COUNT"] = $production->SelectedRowsCount();

		while ($product = $production->GetNext()){
			$arResult["ITEMS"][] = $this->getArrayProduct($product);
			$firms[$product["PROPERTY_".$this->arParams["PRODUCTION_PROPERTY_FIRM"]."_NAME"]] = 1;
			$arResult["MIN"] = $this->isMin($product["PROPERTY_PRICE_VALUE"], $arResult["MIN"]);
			$arResult["MAX"] = $this->isMax($product["PROPERTY_PRICE_VALUE"], $arResult["MAX"]);
		}
		$arResult["FIRMS"] = count($firms);

		usort($arResult["ITEMS"], [$this, "compareString"]);

		$arPagination = $this->pagination($arResult["ITEMS"]);

		return array_merge($arResult, $arPagination);
	}

	private function pagination($items)
	{

		$rs_ObjectList = new CDBResult;
		$rs_ObjectList->InitFromArray($items);
		$rs_ObjectList->NavStart($this->arParams["ELEMENTS_OF_PAGE"], false);
		$arResult["NAV_STRING"] = $rs_ObjectList->GetPageNavString("", "");
		$arResult["PAGE_START"] = $rs_ObjectList->SelectedRowsCount() - ($rs_ObjectList->NavPageNomer - 1) * $rs_ObjectList->NavPageSize;
		while($ar_Field = $rs_ObjectList->Fetch())
		{
			$arResult['ITEMS'][] = $ar_Field;
		}
		return $arResult;
	}

	private function compareString($a, $b)
	{
		return strnatcmp($a["PROPERTY_".$this->arParams["PRODUCTION_PROPERTY_FIRM"]."_NAME"],
						$b["PROPERTY_".$this->arParams["PRODUCTION_PROPERTY_FIRM"]."_NAME"]);

	}


	private function  getArrayProduct($product)
	{
		$arButtons = CIBlock::GetPanelButtons(
			$product["IBLOCK_ID"],
			$product["ID"],
			0,
			array("SECTION_BUTTONS"=>false, "SESSID"=>false)
		);

		return [
			"ADD_LINK" => $arButtons["edit"]["add_element"]["ACTION_URL"],
			"EDIT_LINK" => $arButtons["edit"]["edit_element"]["ACTION_URL"],
			"DELETE_LINK" => $arButtons["edit"]["delete_element"]["ACTION_URL"],
			"NAME" => $product["NAME"],
			"PRICE" => $product["PROPERTY_PRICE_VALUE"],
			"MATERIAL" => $product["PROPERTY_MATERIAL_VALUE"],
			"ARTNUMBER" => $product["PROPERTY_ARTNUMBER_VALUE"],
			"DETAIL_PAGE_URL" => $product["DETAIL_PAGE_URL"],
			"ID" => $product["ID"],
			"IBLOCK_ID" => $product["IBLOCK_ID"],
			"PROPERTY_FIRM_NAME" => $product["PROPERTY_".$this->arParams["PRODUCTION_PROPERTY_FIRM"]."_NAME"],
		];
	}

	private function getProduction()
	{
		$arSelect = array("ID", "IBLOCK_ID", "NAME", "CODE", "DETAIL_PAGE_URL", "PROPERTY_PRICE", "PROPERTY_ARTNUMBER",
					"PROPERTY_MATERIAL", "PROPERTY_".$this->arParams["PRODUCTION_PROPERTY_FIRM"],
					"PROPERTY_".$this->arParams["PRODUCTION_PROPERTY_FIRM"].".NAME");

		$arOrder = array(
			"NAME" => "ASC",
			"SORT" => "ASC",
		);
		$arFilter = array(
			"IBLOCK_ID" => $this->arParams["ID_IBLOCK_PRODUCTION"],
			"ACTIVE" => "Y",
			"!PROPERTY_".$this->arParams["PRODUCTION_PROPERTY_FIRM"] => false,
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

	private function isMax($price, $max)
	{
		if ($max === NULL)
			return $price;

		if ($price > $max)
			return $price;

		return $max;
	}

	private function isMin($price, $min)
	{
		if ($min === NULL)
			return $price;

		if ($price < $min)
			return $price;

		return $min;
	}
}

?>