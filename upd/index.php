<?
/**
*	TODO:
*	+ получить список коллекций (товаров)
*	+ для каждой коллекции получить значение наценки и список плитки (торговых предложений)
*		+ для каждой плитки получить закупочную цену, умножить её на наценку и записать в базовую цену
*		+ для каждой плитки записать единицу измерения
*		+ для каждой плитки получить длину и ширину, вычислить площадь и записать в коэффициент
*	ограничивать обновляемые коллекции
*
*/

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Обновление цен торговых предложений");

define( "COLLECTIONS", 2 );
define( "TILES", 3 );
define( "DEFAULT_MARGIN", 1.2 );

class Updater {
	public function e( $var ) {
		print( "<pre>\n" );
		var_dump( $var );
		print( "</pre>\n" );
	}
	protected function getMargin( $arGoodsProps ) {
		if( intval( $arGoodsProps[ "ATT_MARGIN" ][ "VALUE" ] ) > 0 ) {
			return $arGoodsProps[ "ATT_MARGIN" ][ "VALUE" ];
		} else {
			return DEFAULT_MARGIN;
		}
	}
	protected function getMeasure( $type ) {
		//$this->e( $type );
		switch( $type )  {
			case "border":
			case "decor":
				return 5;
			default:
				return 6;
		}		
		/*
		$tmp = CIBlockElement::GetByID( $id );
		$item = $tmp->GetNextElement();
		$arSKUProps = $item->GetProperties();
		//$this->e( $arSKUProps );
		switch( $arGoodsProps[ "ATT_TYPE" ][ "VALUE_XML_ID" ] )  {
			case "border":
			case "decor":
				return 5;
			default:
				return 6;
		}
		*/
	}
	function __construct() {
			
		$arSKUInfo = CCatalogSKU::GetInfoByProductIBlock( COLLECTIONS );
		$this->e( $arSKUInfo['SKU_PROPERTY_ID'] );
		//$arSelect = Array( "ID", "NAME", "DATE_ACTIVE_FROM" ); // выбираемые поля либо false
		$arSelect = false; // выбираемые поля либо false
		//$arFilterGoods = Array( "IBLOCK_ID"=>COLLECTIONS, "ACTIVE"=>"Y", "ID" => 187 );
		$arFilterGoods = Array( "IBLOCK_ID"=>COLLECTIONS, "ACTIVE"=>"Y" );

		//$arFilter = Array( "IBLOCK_ID"=>TILES, "ACTIVE"=>"Y", "ID" => 710 );
		$goods = CIBlockElement::GetList( Array( "SORT"=>"ASC" ), $arFilterGoods, false, Array("nTopCount"=>9999) );
		while( $collection = $goods->GetNextElement() ) {
			$arGoodsFields = $collection->GetFields();
			$arGoodsProps = $collection->GetProperties();
			$priceMargin = $this->getMargin( $arGoodsProps );
			print( "<br><strong>[" . $arGoodsFields[ "ID" ] . "] " . $arGoodsFields[ "NAME" ] . "</strong> - " . $priceMargin . "<br>\n" );
			$arFilterSKU = Array( "IBLOCK_ID"=>TILES, "ACTIVE"=>"Y", 'PROPERTY_' . $arSKUInfo['SKU_PROPERTY_ID'] => $arGoodsFields[ "ID" ] );
			$sku = CIBlockElement::GetList( Array( "SORT" => "ASC" ), $arFilterSKU, false, Array("nTopCount" => 9999) );
			//$sku = CCatalogProduct::GetList( Array( "SORT" => "ASC" ), $arFilterSKU, false, Array("nTopCount" => 9999) );
			//while( $tiles = $sku->Fetch() ) {
			while( $tiles = $sku->GetNextElement() ) {
				$arSKUFields = $tiles->GetFields();
				$arSKUProps = $tiles->GetProperties();
				// ATT_TYPE VALUE_XML_ID 
				//print( $tiles[ "ID" ] . "<br>\n" );
				
				//$this->e( $tiles );
				//$this->e( $tiles );
				print( $arSKUFields[ "ID" ] . " " . $arSKUFields[ "NAME" ] . "<br>\n" );
				$SKUitem = CCatalogProduct::GetByID( $arSKUFields[ "ID" ] );
				//$this->e( $SKUitem );
				CPrice::SetBasePrice( $arSKUFields[ "ID" ], $SKUitem[ "PURCHASING_PRICE" ] * $priceMargin, $SKUitem[ "PURCHASING_CURRENCY" ] );
				CCatalogProduct::Update( $arSKUFields[ "ID" ], array( "MEASURE" => $this->getMeasure( $arSKUProps[ "ATT_TYPE" ][ "VALUE_XML_ID" ] ) ) );
				$ratio = $SKUitem[ "LENGTH" ] * $SKUitem[ "WIDTH" ] / 1000000;
				CCatalogMeasureRatio::Update( $this->getMeasure( $arSKUProps[ "ATT_TYPE" ][ "VALUE_XML_ID" ] ), array( "PRODUCT_ID" => $arSKUFields[ "ID" ], "RATIO" => $ratio ) ); 
				/*
				+ CPrice::SetBasePrice( $tiles[ "ID" ], $tiles[ "PURCHASING_PRICE" ] * $priceMargin, $tiles[ "PURCHASING_CURRENCY" ] );
				+ CCatalogProduct::Update( $tiles[ "ID" ], array( "MEASURE" => $this->getMeasure( $tiles[ "ID" ] ) ) );
				$ratio = $tiles[ "LENGTH" ] * $tiles[ "WIDTH" ] / 1000000;
				CCatalogMeasureRatio::Update( $this->getMeasure( $tiles[ "ID" ] ), array( "PRODUCT_ID" => $tiles[ "ID" ], "RATIO" => $ratio ) ); 
				*/
				//$db_res = CPrice::GetList( array(), array( "PRODUCT_ID" => $arSKUFields[ "ID" ], "CATALOG_GROUP_ID" => 1) );
				
				
			}
			//$this->e( $arGoodsProps );
			//e( $arGoodsFields );
			
		}
	}
}

$u = new Updater();

?>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>


