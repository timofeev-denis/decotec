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
$start_time = time();
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Обновление единиц измерения и розничных цен торговых предложений");
print( "<a href='/upd'>В начало</a><br><br>\n" );

define( "COLLECTIONS", 2 );
define( "TILES", 3 );
define( "DEFAULT_MARGIN", 1.2 );

class Updater {
        var $updatedItemsCounter;
        public function getUpdatedItemsCounter() {
            return $updatedItemsCounter;
        }
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
			case "step":
			case "riser":
				return 5;
			default:
				return 6;
		}		
	}
	protected function getRatioValue( $type, $SKUitem) {
		switch( $type )  {
			case "border":
			case "decor":
			case "step":
			case "riser":
				return 1;
			default:
				return $SKUitem[ "LENGTH" ] * $SKUitem[ "WIDTH" ] / 1000000;
		}	
	}
	protected function getRatioID( $productID ) {
		$result = 0;
		$oldRatios = CCatalogMeasureRatio::GetList( array(), array( "PRODUCT_ID" => $productID ) );
		while( $r = $oldRatios->Fetch() ) {
			if( $result != 0 ) {
				CCatalogMeasureRatio::Delete( $r[ "ID" ] );
			}
			$result = $r[ "ID" ];
		}
		return $result;
	}
	function __construct() {
		$arSKUInfo = CCatalogSKU::GetInfoByProductIBlock( COLLECTIONS );
		$arSelect = false; // выбираемые поля либо false
		$arFilterGoods = Array( "IBLOCK_ID"=>COLLECTIONS, "ACTIVE"=>"Y" );

		//$arFilter = Array( "IBLOCK_ID"=>TILES, "ACTIVE"=>"Y", "ID" => 710 );
		$goods = CIBlockElement::GetList( Array( "SORT"=>"ASC" ), $arFilterGoods, false, Array("nTopCount"=>9999) );
		while( $collection = $goods->GetNextElement() ) {
			$arGoodsFields = $collection->GetFields();
			$arGoodsProps = $collection->GetProperties();
			$priceMargin = $this->getMargin( $arGoodsProps );
			//print( "<br><strong>[" . $arGoodsFields[ "ID" ] . "] " . $arGoodsFields[ "NAME" ] . "</strong> - " . $priceMargin . "<br>\n" );
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
				
				$SKUitem = CCatalogProduct::GetByID( $arSKUFields[ "ID" ] );
				//$this->e( $SKUitem );
				CPrice::SetBasePrice( $arSKUFields[ "ID" ], $SKUitem[ "PURCHASING_PRICE" ] * $priceMargin, $SKUitem[ "PURCHASING_CURRENCY" ] );
				$measure = $this->getMeasure( $arSKUProps[ "ATT_TYPE" ][ "VALUE_XML_ID" ] );
				CCatalogProduct::Update( $arSKUFields[ "ID" ], array( "MEASURE" => $measure ) );
				$ratioValue = $this->getRatioValue( $arSKUProps[ "ATT_TYPE" ][ "VALUE_XML_ID" ], $SKUitem);
				$RatioID = $this->getRatioID( $arSKUFields[ "ID" ] );
				if( $RatioID == 0 ) {
					CCatalogMeasureRatio::Add( array( "PRODUCT_ID" => $arSKUFields[ "ID" ], "RATIO" => $ratioValue ) );
				} else {
					CCatalogMeasureRatio::Update( $RatioID, array( "PRODUCT_ID" => $arSKUFields[ "ID" ], "RATIO" => $ratioValue ) ); 
				}
                                $this->updatedItemsCounter++;
				//print( $arSKUFields[ "ID" ] . " " . $arSKUFields[ "NAME" ] . " ratio ({$RatioID}): " . $ratioValue . " measure: " . $measure . "<br>\n" );
			}
			//$this->e( $arGoodsProps );
			//e( $arGoodsFields );
			
		}
	}
}

$u = new Updater();
$stop_time = time();
print( "Длительность выполнения программы: " . round( $stop_time - $start_time, 3 ) . " сек.<br>\n" . "Количество обновлённый товаров: " . $u->updatedItemsCounter);

?>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>