<?
/*
----- артикул
* страна
* фирма
* коллекция
* вид (ванная/кухня/...) 
* тематика (однотонная)
+ тип (напольная)
+ размер (Д x Ш)
----- упаковка
+ цена
+ картинка
+ название

*/

// Подключаем API
require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("iblock");
CModule::IncludeModule("catalog");
if( !defined( "B_PROLOG_INCLUDED" ) || B_PROLOG_INCLUDED !== true ) {
	die( "NO PROLOG" );
}

// Проверяем параметр
$tileId = intval( $_REQUEST[ "id" ] );
if( $tileId <= 0 ) {
	die( json_encode( array( "ERROR" => "1", "NAME" => "Некорректный идентификатор" ) ) );
}

// Получаем данные
//$arSelect = Array( "ID", "NAME", "DETAIL_PICTURE" ); // выбираемые поля либо false
$arSelect = false;
$arFilter = Array( "IBLOCK_ID"=>3, "ACTIVE"=>"Y", "ID" => $tileId );
$res = CIBlockElement::GetList( Array( "SORT"=>"ASC" ), $arFilter, false, $arSelect);
if( $res->SelectedRowsCount() == 0 ) {
	die( json_encode( array( "ERROR" => "1", "NAME" => "Плитка не найдена" ) ) );
}
$ob = $res->GetNextElement();
$arFields = $ob->GetFields();
$arProps = $ob->GetProperties();
$tileData = array();		// Массив с итоговыми даными
$tileData[ "ATT_TYPE" ] = $arProps[ "ATT_TYPE" ][ "VALUE" ];
$tileData[ "NAME" ] = $arFields[ "NAME" ];
//$tileData[ "DETAIL_PICTURE" ] = $arFields[ "DETAIL_PICTURE" ];
$tileData[ "DETAIL_PICTURE" ] = CFile::GetPath( $arFields[ "DETAIL_PICTURE" ] );

// Получаем ещё данные
$offer = CCatalogProduct::GetByID( $tileId );
if( $offer == false ) {
	die( json_encode( array( "ERROR" => "1", "NAME" => "Элемент не найден" ) ) );
}
$tileData[ "WIDTH" ] = $offer[ "WIDTH" ];
$tileData[ "LENGTH" ] = $offer[ "LENGTH" ];
$tileData[ "HEIGHT" ] = $offer[ "HEIGHT" ];

// Получаем цену
$tmp = CCatalogProduct::GetOptimalPrice( $tileId );
$tileData[ "PRICE" ] = $tmp[ "RESULT_PRICE" ][ "BASE_PRICE" ];

print( json_encode( $tileData ) );

?>