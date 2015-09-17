<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Интернет-магазин \"Одежда\"");
?><?$APPLICATION->IncludeComponent(
	"bitrix:catalog.section.list", 
	"decotec", 
	array(
		"COMPONENT_TEMPLATE" => "decotec",
		"IBLOCK_TYPE" => "catalog",
		"IBLOCK_ID" => "2",
		"SECTION_ID" => $_REQUEST["SECTION_ID"],
		"SECTION_CODE" => "",
		"COUNT_ELEMENTS" => "Y",
		"TOP_DEPTH" => "2",
		"SECTION_FIELDS" => array(
			0 => "SORT",
			1 => "",
		),
		"SECTION_USER_FIELDS" => array(
			0 => "",
			1 => "",
		),
		"VIEW_MODE" => "TILE",
		"SHOW_PARENT_NAME" => "Y",
		"SECTION_URL" => "",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_GROUPS" => "Y",
		"ADD_SECTIONS_CHAIN" => "Y",
		"HIDE_SECTION_NAME" => "N"
	),
	false
);?> <br>
<br>
<?
/*
if(CModule::IncludeModule("iblock")) {
	$IBLOCK_ID = 2; // инфоблок с элементами 
	$arOrder = Array("SORT"=>"ASC"); 
	//$arSelect = Array("ID", "NAME", "IBLOCK_ID", "DETAIL_PAGE_URL"); 
	//$arSelect = Array("ID", "NAME");
	$arFilter = Array("IBLOCK_ID"=>$IBLOCK_ID, "ACTIVE"=>"Y"); 
	$res = CIBlockSection::GetList($arOrder, $arFilter);
	//$res = CIBlockSection::GetList($arOrder,$arFilter);

	while($ob = $res->GetNext()) { // наполнение массива меню пунктами меню
		//$arFields = $ob->GetFields(); 
		print_r( $ob );
	}
}
*/
?>
<h2></h2><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>