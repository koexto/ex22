<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?

class SimpleComp3 extends CBitrixComponent
{
	function getResult()
	{

		$authorType = $this->getAuthorType();

		$authors = $this->getAuthors($authorType);

		//return $this->arParams;

		$arFilter = [
			"IBLOCK_ID" => $this->arParams["ID_IBLOCK_NEWS"],
			"ACTIVE" => "Y",
			//"PROPERTY_AUTHOR" => [4, 5],
			"!PROPERTY_AUTHOR" => [1],
		];

		$arSelect = ["ID", "NAME"];

		$news = CIBlockElement::GetList([], $arFilter, false, false, $arSelect);

		while ($new = $news->fetch())
		{
			$arResult[] = $new;
		}

		return $arResult;


	}

	private function getAuthors($authorType)
	{
		$arFilter = ["UF_AUTHOR_TYPE" => $authorType, "!ID" => 1];

		$obUsers = CUser::GetList($by, $sort, $arFilter);

		while ($curUser = $obUsers->fetch())
		{
			$users[] = $curUser["ID"];
		}

		return $users;
	}

	private function getAuthorType()
	{
		GLOBAL $USER;
		if (!is_object($USER))
			return false;

		$by = 'id';
		$sort = 'desc';
		$arFilter = ["ID" => $USER->GetID()];
		$arParameters["SELECT"] = ["UF_AUTHOR_TYPE"];

		$arUser = CUser::GetList($by, $sort, $arFilter, $arParameters);
		if ($curUser = $arUser->fetch()) {
			return $curUser["UF_AUTHOR_TYPE"];
		}
	}

}

?>