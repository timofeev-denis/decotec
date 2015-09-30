<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
//$APPLICATION->SetTitle("detail");
?><br>
 <?
//print_r( $arResult );
GLOBAL $arrFilter; 
$arrFilter = array( 
//'PROPERTY_ATT_MANUFACTURER_VALUE' => $_REQUEST[ 'element_code' ], 
//'!PROPERTY_ATT_MANUFACTURER' => 'Cersanit',
'PROPERTY_ATT_COUNTRY' => $_REQUEST[ 'element_code' ], 
); 
?><?$APPLICATION->IncludeComponent(
	"bitrix:catalog.top", 
	"decotec", 
	array(
		"COMPONENT_TEMPLATE" => "decotec",
		"IBLOCK_TYPE" => "catalog",
		"IBLOCK_ID" => "2",
		"ELEMENT_SORT_FIELD" => "sort",
		"ELEMENT_SORT_ORDER" => "asc",
		"ELEMENT_SORT_FIELD2" => "id",
		"ELEMENT_SORT_ORDER2" => "desc",
		"FILTER_NAME" => "arrFilter",
		"HIDE_NOT_AVAILABLE" => "N",
		"ELEMENT_COUNT" => "9",
		"LINE_ELEMENT_COUNT" => "3",
		"PROPERTY_CODE" => array(
			0 => "ATT_MANUFACTURER",
			1 => "ATT_COUNTRY",
			2 => "ATT_TEST",
			3 => "",
		),
		"OFFERS_LIMIT" => "5",
		"VIEW_MODE" => "SECTION",
		"SHOW_DISCOUNT_PERCENT" => "N",
		"SHOW_OLD_PRICE" => "N",
		"SHOW_CLOSE_POPUP" => "N",
		"MESS_BTN_BUY" => "Купить",
		"MESS_BTN_ADD_TO_BASKET" => "В корзину",
		"MESS_BTN_DETAIL" => "Подробнее",
		"MESS_NOT_AVAILABLE" => "Нет в наличии",
		"SECTION_URL" => "",
		"DETAIL_URL" => "",
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"PRODUCT_QUANTITY_VARIABLE" => "",
		"SEF_MODE" => "N",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_GROUPS" => "Y",
		"CACHE_FILTER" => "N",
		"ACTION_VARIABLE" => "action",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRICE_CODE" => array(
			0 => "BASE",
		),
		"USE_PRICE_COUNT" => "N",
		"SHOW_PRICE_COUNT" => "1",
		"PRICE_VAT_INCLUDE" => "Y",
		"CONVERT_CURRENCY" => "N",
		"BASKET_URL" => "/personal/basket.php",
		"USE_PRODUCT_QUANTITY" => "N",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"PRODUCT_PROPERTIES" => array(
			0 => "ATT_MANUFACTURER",
		),
		"ADD_TO_BASKET_ACTION" => "ADD",
		"DISPLAY_COMPARE" => "N",
		"OFFERS_FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"OFFERS_PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"OFFERS_SORT_FIELD" => "sort",
		"OFFERS_SORT_ORDER" => "asc",
		"OFFERS_SORT_FIELD2" => "id",
		"OFFERS_SORT_ORDER2" => "desc",
		"TEMPLATE_THEME" => "blue",
		"PRODUCT_DISPLAY_MODE" => "N",
		"ADD_PICT_PROP" => "-",
		"LABEL_PROP" => "-",
		"MESS_BTN_COMPARE" => "Сравнить",
		"OFFERS_CART_PROPERTIES" => array(
			0 => "ATT_TYPE",
		)
	),
	false
);?><?
?><br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>