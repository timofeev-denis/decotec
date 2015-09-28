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

		if($arIBlock["ACTIVE"] == "Y") {
			/*
			if(CModule::IncludeModule("iblock")) { 
				$IBLOCK_ID = 4; // инфоблок с элементами 
				$arOrder = Array("NAME"=>"ASC"); 
				$arSelect = Array("ID", "NAME", "IBLOCK_ID", "DETAIL_PAGE_URL"); 
				$arFilter = Array("IBLOCK_ID"=>$IBLOCK_ID, "ACTIVE"=>"Y"); 
				//$res = CIBlockElement::GetList($arOrder, $arFilter, false, false, $arSelect); 
				$res = CIBlockElement::GetProperty($IBLOCK_ID, "", array("sort" => "asc"), array("CODE" => $code));

				while($ob = $res->Fetch()) { // наполнение массива меню пунктами меню
					$aMenuLinksExt[] = Array( 
						"111", 
						"http://yandex.ru/", 
						Array(), 
						Array(), 
						"" 
					); 

				} 
			}
			*/
			
			/*
			$IBLOCK_ID = 4; // инфоблок с элементами 
			$code = "ATT_THEME"; // код свойства
			CModule::IncludeModule('iblock');
			$db_props = CIBlockElement::GetProperty($IBLOCK_ID, "", array("sort" => "asc"), array("CODE" => $code));
			// если code =M% тогда выберет всё, что начинается на M 
			while($ar_props = $db_props->Fetch()) {
				$property_enums = CIBlockPropertyEnum::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>$IBLOCK_ID, "PROPERTY_ID" => $ar_props["ID"]));
				while($enum_fields = $property_enums->GetNext()) {
					
					$arResult["SERIYA"][] = array(
						"ID" => $enum_fields["ID"],  // id свойства
						"NAME" =>$enum_fields["VALUE"] // значение
					);
					
					//print_r( $enum_fields );
				}
			}
			*/
			
			/*
			$aMenuLinksExt = $APPLICATION->IncludeComponent("bitrix:menu.sections", "", array(
				"IS_SEF" => "Y",
				"SEF_BASE_URL" => "",
				"SECTION_PAGE_URL" => $arIBlock['SECTION_PAGE_URL'],
				"DETAIL_PAGE_URL" => $arIBlock['DETAIL_PAGE_URL'],
				"IBLOCK_TYPE" => $arIBlock['IBLOCK_TYPE_ID'],
				"IBLOCK_ID" => $arIBlock['ID'],
				"DEPTH_LEVEL" => "3",
				"CACHE_TYPE" => "N",
			), false, Array('HIDE_ICONS' => 'Y'));
			*/
			
			
			$aMenuLinksExt = $APPLICATION->IncludeComponent("bitrix:menu.sections", "", array(
				"IS_SEF" => "Y",
				"SEF_BASE_URL" => "",
				//"SECTION_PAGE_URL" => $arIBlock['SECTION_PAGE_URL'],
				//"DETAIL_PAGE_URL" => $arIBlock['DETAIL_PAGE_URL'],
				"SECTION_PAGE_URL" => "/countries/detail.php?element_code=#SECTION_ID#",
				"DETAIL_PAGE_URL" => "#SECTION_ID#/#ELEMENT_ID#.html", 
				"IBLOCK_TYPE" => "directories",
				"IBLOCK_ID" => "4",
				"DEPTH_LEVEL" => "3",
				"CACHE_TYPE" => "N",
			), false, Array('HIDE_ICONS' => 'Y'));
			
			
			/*
			if(CModule::IncludeModule("iblock")) { 
				$IBLOCK_ID = 4; // инфоблок с элементами 
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
			*/
			
			/*
			$aMenuLinksExt = $APPLICATION->IncludeComponent("bitrix:menu.sections", "", array(
				"IS_SEF" => "N",
				"ID" => $_REQUEST["ID"],
				"IBLOCK_TYPE" => "directories",
				"IBLOCK_ID" => "4",
				"SECTION_URL" => "",
				"DEPTH_LEVEL" => "3",
				"CACHE_TYPE" => "N",
				"SEF_BASE_URL" => "/catalog/",
				"SECTION_PAGE_URL" => "#SECTION_CODE_PATH#/",
				"DETAIL_PAGE_URL" => "#SECTION_CODE_PATH#/#CODE#/"
			), false, Array('HIDE_ICONS' => 'Y'));
			*/
		}
	}

	if(defined("BX_COMP_MANAGED_CACHE"))
		$GLOBALS["CACHE_MANAGER"]->RegisterTag("iblock_id_new");
}

$aMenuLinks = array_merge($aMenuLinks, $aMenuLinksExt);
?>