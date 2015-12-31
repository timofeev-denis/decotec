<?php

/**
 * 	TASKS:
 * 	+ Найти товар по номенклатору
 * 	+ Обновить закупочную цену
 *      + Обновить валюту
 *      Вывести список файлов из медиабиблиотеки
 *      Считать файл, заполнить массив
 *      
 *
 */

$start_time = time();
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Обновление закупочных цен торговых предложений");
print( "<a href='/upd'>В начало</a><br><br>\n" );
define("COLLECTIONS", 2);
define("TILES", 3);
define("DEFAULT_MARGIN", 1.2);

class Updater {

    public function e($var) {
        print( "<pre>\n");
        var_dump($var);
        print( "</pre>\n");
    }

    protected function getMargin($arGoodsProps) {
        if (intval($arGoodsProps["ATT_MARGIN"]["VALUE"]) > 0) {
            return $arGoodsProps["ATT_MARGIN"]["VALUE"];
        } else {
            return DEFAULT_MARGIN;
        }
    }

    protected function getMeasure($type) {
        //$this->e( $type );
        switch ($type) {
            case "border":
            case "decor":
            case "step":
            case "riser":
                return 5;
            default:
                return 6;
        }
    }

    protected function getRatioValue($type, $SKUitem) {
        switch ($type) {
            case "border":
            case "decor":
            case "step":
            case "riser":
                return 1;
            default:
                return $SKUitem["LENGTH"] * $SKUitem["WIDTH"] / 1000000;
        }
    }

    protected function getRatioID($productID) {
        $result = 0;
        $oldRatios = CCatalogMeasureRatio::GetList(array(), array("PRODUCT_ID" => $productID));
        while ($r = $oldRatios->Fetch()) {
            if ($result != 0) {
                CCatalogMeasureRatio::Delete($r["ID"]);
            }
            $result = $r["ID"];
        }
        return $result;
    }

    function __construct() {
    }
    
    public function updatePrices( $path ) {
        if(!file_exists($path)) {
            return 0;
        }
        $lines = file($path);
        if( $lines == false ) {
            return 0;
        }
        $updatedItemsCounter = 0;
        for($i = 2; $i < count($lines); $i++) {
            $values = explode(";", rtrim($lines[$i]));
            $nomenklator = $values[0];
            $price = $values[1];
            $currency = $values[2];
            $arFilterGoods = Array("IBLOCK_ID" => TILES, "ACTIVE" => "Y", "PROPERTY_ATT_NOMENKLATOR" => $nomenklator);
            $items = CIBlockElement::GetList(Array("SORT" => "ASC"), $arFilterGoods, false);
            while ($tile = $items->GetNextElement()) {
                $arGoodsFields = $tile->GetFields();
                $tile_id = $arGoodsFields[ "ID" ];
                $SKUitem = CCatalogProduct::GetByID( $tile_id );
                //CPrice::SetBasePrice( $tile_id, $price, $currency );
                $arFields = array('PURCHASING_PRICE' => $price, 'PURCHASING_CURRENCY' => $currency);
                CCatalogProduct::Update($tile_id, $arFields);
                $updatedItemsCounter++;
                //echo $arGoodsFields[ "NAME" ] . " - " . $price . " " . $currency . "<br>\n";
            }
        }
        fclose($file);
        return $updatedItemsCounter;
    }

    public function selectFile() {
        $form = "<form method='get'>"
                . "<select name='file'>";
        CModule::IncludeModule("fileman");
        CMedialib::Init(); 

        //$arRes = CMedialib::GetTypes(array("documents"), true);
        //print_r($arRes);

        $arRes = CMedialibCollection::GetList(array('arFilter' => array('NAME' => 'Обновление цен'), 'arOrder' => array('NAME' => 'ASC')));
        //print_r($arRes);
        //var_dump($arRes[0]["ID"]);

        $arRes = CMedialibItem::GetList(array('arCollections' => array($arRes[0]["ID"])));
        
        //print_r($arRes);
        foreach($arRes as $key => $val) {
            $form .= "<option value='{$val["PATH"]}'>" . $val["NAME"] . "\n";
            //print_r($val);
        }
        $form .= "</select>"
                . "<input type='submit' name='go' value='Обновить'>"
                . "<input type='hidden' name='step' value='update'>"
                . "</form>";
    
        print( $form );
    }
}


if(!isset( $_REQUEST[ "step" ]) ) {
    $_REQUEST[ "step" ] = "start";
}
$u = new Updater();
switch ($_REQUEST[ "step" ]) {
    case "start":
    default:
        $u->selectFile();
        break;
    case "update":
        //var_dump($_REQUEST);
        $updatedItemsCounter = $u->updatePrices($_SERVER["DOCUMENT_ROOT"] . $_REQUEST[ "file" ]);
        $stop_time = time();
        print( "Длительность выполнения программы: " . round( $stop_time - $start_time, 3 ) . " сек.<br>\n" . "Количество обновлённый товаров: " . $updatedItemsCounter);
        break;
}
?>


<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>