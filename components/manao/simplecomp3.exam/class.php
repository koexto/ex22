<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?

class SimpleComp3 extends CBitrixComponent
{
	private $idCurUser;

	function getResult()
	{
		GLOBAL $USER;
		if (!$USER->IsAuthorized())
			return false;

		$this->idCurUser = $USER->GetID();

		$authorType = $this->getAuthorType();
		$authors = $this->getAuthors($authorType);

		$arResult["AUTHORS"] = $authors["AUTHORS"];
		$arResult["NEWS"] =  $this->getNews($authors["IDS"]);

		//return $this->getNews3($authors);

		return $arResult;
	}

	//универсальный метод (подходит для 2 типов инфоблоков)
	private function getNews($authors)
	{
		$arFilter = [
			"IBLOCK_ID" => $this->arParams["ID_IBLOCK_NEWS"],
			"ACTIVE" => "Y",
			"PROPERTY_".$this->arParams["CODE_PROPERTY_AUTHOR"] => $authors,
			"!ID" => CIBlockElement::SubQuery("ID", array(
				"IBLOCK_ID" => $this->arParams["ID_IBLOCK_NEWS"],
				"PROPERTY_".$this->arParams["CODE_PROPERTY_AUTHOR"] => $this->idCurUser)),
			//"!PROPERTY_AUTHOR" => [1],
		];

		$arSelect = ["ID", "NAME", "IBLOCK_ID", "ACTIVE_FROM"];

		$news = CIBlockElement::GetList([], $arFilter, false, false, $arSelect);

		$arResult["COUNT"] = 0;
		while ($new = $news->GetNextElement())
		{
			$authorValue = $new->GetProperty($this->arParams["CODE_PROPERTY_AUTHOR"])["VALUE"];
			$arResult["COUNT"]++;
			foreach ($authorValue as $authorId)
			{
				$arResult[$authorId][] = $new->GetFields();
			}
		}
		return $arResult;
	}

	private function getAuthors($authorType)
	{
		$arFilter = [$this->arParams["USER_PROPERTY_AUTHOR"] => $authorType, "!ID" => $this->idCurUser];

		$obAuthors = CUser::GetList($by, $sort, $arFilter);

		while ($author = $obAuthors->fetch())
		{
			$authors["AUTHORS"][$author["ID"]] = $author["LOGIN"];
			$authors["IDS"][] = $author["ID"];
		}

		return $authors;
	}

	private function getAuthorType()
	{

		//$by = 'id';
		//$sort = 'desc';
		$arFilter = ["ID" => $this->idCurUser];
		$arParameters["SELECT"] = [$this->arParams["USER_PROPERTY_AUTHOR"]];

		$arUser = CUser::GetList($by, $sort, $arFilter, $arParameters);
		if ($curUser = $arUser->fetch()) {
			return $curUser[$this->arParams["USER_PROPERTY_AUTHOR"]];
		}
	}

	//для инфоблоков тип 1 простая выборка
	private function getNews2($authors)
	{
		$arFilter = [
			"IBLOCK_ID" => $this->arParams["ID_IBLOCK_NEWS"],
			"ACTIVE" => "Y",
			"PROPERTY_AUTHOR" => $authors,
			//"!PROPERTY_AUTHOR" => [1],
		];

		$arSelect = ["ID", "NAME", "IBLOCK_ID", "PROPERTY_AUTHOR", "PROPERTY_AUTHOR", "ACTIVE_FROM"];

		$news = CIBlockElement::GetList([], $arFilter, false, false, $arSelect);

		while ($new = $news->fetch())
		{
			$arResult[$new["PROPERTY_AUTHOR_VALUE"]][] = $new;
		}
		return $arResult;
	}
}

?>