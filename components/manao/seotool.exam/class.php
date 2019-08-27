<?

class ManaoSeoTool extends CBitrixComponent
{
	const ID_IBLOCK_METATAGS = 6;

	function getSeoTags()
	{
		$arFilter = array(
			'IBLOCK_ID' => self::ID_IBLOCK_METATAGS,
			'NAME' => $_SERVER[REQUEST_URI],
			'ACTIVE' => 'Y',
		);
		$arSelect = array("ID", "PROPERTY_TITLE", "PROPERTY_DESCRIPTION");

		$element = CIBlockElement::GetList(array(), $arFilter, false, false, $arSelect)->fetch();

		if ($element)
		{
			return [
				"TITLE" => $element["PROPERTY_TITLE_VALUE"],
				"DESCRIPTION" => $element["PROPERTY_DESCRIPTION_VALUE"]
			];
		}
		return false;
	}
}
