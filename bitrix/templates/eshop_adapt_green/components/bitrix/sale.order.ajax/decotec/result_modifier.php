<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

for($i = 0; $i < count($arResult["GRID"]["HEADERS"]); $i++) {
	if( $arResult["GRID"]["HEADERS"][$i]["id"] == "DISCOUNT_PRICE_PERCENT_FORMATED" ) {
		array_splice($arResult["GRID"]["HEADERS"], $i, 1 );
		break;
	}
}

?>