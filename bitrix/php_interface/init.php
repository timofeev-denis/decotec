<?
AddEventHandler("sale", "OnOrderNewSendEmail", "FunctionName");
function FunctionName($orderID, &$eventName, &$arFields, &$arOrder) {
	$arOrder = CSaleOrder::GetByID( $orderID );
	
	$order_props = CSaleOrderPropsValue::GetOrderProps($orderID);
	$phone = "";
	$index = ""; 
	$country_name = "";
	$city_name = "";  
	$address = "";
	while( $arProps = $order_props->Fetch() ) {
		
		if( $arProps[ "CODE" ] == "PHONE" ) {
		   $phone = htmlspecialchars($arProps[ "VALUE" ]);
		}
		if( $arProps[ "CODE" ] == "LOCATION" ) {
			$arLocs = CSaleLocation::GetByID($arProps[ "VALUE" ]);
			$country_name =  $arLocs[ "COUNTRY_NAME_ORIG" ];
			$city_name = $arLocs[ "CITY_NAME_ORIG" ];
		}
		if( $arProps[ "CODE" ] == "ZIP" ) {
		  $index = $arProps[ "VALUE" ];
		}
		if( $arProps[ "CODE" ] == "ADDRESS" ) {
		  $address = $arProps[ "VALUE" ];
		}
	}

	$full_address = ( isset( $index ) ? ( $index . ", " ) : "" ) . $country_name . ", " . $city_name . ", " . $address;

	// получаем название службы доставки
	$arDeliv = CSaleDelivery::GetByID($arOrder[ "DELIVERY_ID" ]);
	$delivery_name = "";
	if( $arDeliv ) {
		$delivery_name = $arDeliv[ "NAME" ];
	}

	// получаем название платежной системы   
	$arPaySystem = CSalePaySystem::GetByID($arOrder[ "PAY_SYSTEM_ID" ]);
	$pay_system_name = "";
	if( $arPaySystem ) {
		$pay_system_name = $arPaySystem[ "NAME" ];
	}

	// добавляем новые поля в массив результатов
	$arFields[ "ORDER_DESCRIPTION" ] = $arOrder[ "USER_DESCRIPTION" ]; 
	$arFields[ "PHONE" ] =  $phone;
	$arFields[ "DELIVERY_NAME" ] =  $delivery_name;
	$arFields[ "PAY_SYSTEM_NAME" ] =  $pay_system_name;
	$arFields[ "FULL_ADDRESS" ] = $full_address;   

}

AddEventHandler("subscribe", "BeforePostingSendMail", Array("MyClass", "BeforePostingSendMailHandler"));
class MyClass {
    // создаем обработчик события "BeforePostingSendMail"
    function BeforePostingSendMailHandler($arFields) {
		$arFields[ "BODY" ] .= "\r\n";
		$arFields[ "BODY" ] .= file_get_contents( $_SERVER["DOCUMENT_ROOT"] . "/personal/subscribe/unsubscribe.html" );
        return $arFields;
    }
}

?>