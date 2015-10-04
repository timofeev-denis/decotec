<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

global $APPLICATION;
$aMenuLinksExt = array();

if(CModule::IncludeModule('iblock'))
{
	$arFilter = array(
		"TYPE" => "catalog",
		"SITE_ID" => SITE_ID,
	);

	$dbIBlock = CIBlock::GetList(array('SORT' => 'ASC', 'ID' => 'ASC'), $arFilter);
	$dbIBlock = new CIBlockResult($dbIBlock);

	if ($arIBlock = $dbIBlock->GetNext())
	{
		if(defined("BX_COMP_MANAGED_CACHE"))
			$GLOBALS["CACHE_MANAGER"]->RegisterTag("iblock_id_".$arIBlock["ID"]);

		if($arIBlock["ACTIVE"] == "Y")
		{
			if(CModule::IncludeModule("iblock")) { 
				$IBLOCK_ID = 6; // инфоблок с элементами 
				$arOrder = Array("NAME"=>"ASC"); 
				$arSelect = Array("ID", "NAME", "IBLOCK_ID", "DETAIL_PAGE_URL"); 
				$arFilter = Array("IBLOCK_ID"=>$IBLOCK_ID, "ACTIVE"=>"Y"); 
				$res = CIBlockElement::GetList($arOrder, $arFilter, false, false, $arSelect); 

				while($ob = $res->GetNextElement()) { // наполнение массива меню пунктами меню
					$arFields = $ob->GetFields(); 
					$aMenuLinksExt[] = Array( 
						$arFields['NAME'], 
						$arFields['DETAIL_PAGE_URL'], 
						Array(), 
						Array(), 
						"" 
					); 
				} 
			} 
		}
	}

	if(defined("BX_COMP_MANAGED_CACHE"))
		$GLOBALS["CACHE_MANAGER"]->RegisterTag("iblock_id_new");
}

$aMenuLinks = array_merge($aMenuLinks, $aMenuLinksExt);
?>