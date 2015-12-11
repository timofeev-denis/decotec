<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Заказы");
?><?$APPLICATION->IncludeComponent("bitrix:sale.order.ajax", "decotec", Array(
	"PAY_FROM_ACCOUNT" => "Y",	// Позволять оплачивать с внутреннего счета
		"COUNT_DELIVERY_TAX" => "N",	// Рассчитывать налог для доставки
		"COUNT_DISCOUNT_4_ALL_QUANTITY" => "N",
		"ONLY_FULL_PAY_FROM_ACCOUNT" => "N",	// Позволять оплачивать с внутреннего счета только в полном объеме
		"ALLOW_AUTO_REGISTER" => "Y",	// Оформлять заказ с автоматической регистрацией пользователя
		"SEND_NEW_USER_NOTIFY" => "Y",	// Отправлять пользователю письмо, что он зарегистрирован на сайте
		"DELIVERY_NO_AJAX" => "N",	// Рассчитывать стоимость доставки сразу
		"TEMPLATE_LOCATION" => "popup",	// Шаблон местоположения
		"PROP_1" => "",	// Не показывать свойства для типа плательщика "Физическое лицо" (s1)
		"PATH_TO_BASKET" => "/personal/cart/",	// Страница корзины
		"PATH_TO_PERSONAL" => "/personal/order/",	// Страница персонального раздела
		"PATH_TO_PAYMENT" => "/personal/order/payment/",	// Страница подключения платежной системы
		"PATH_TO_ORDER" => "/personal/order/make/",
		"SET_TITLE" => "Y",	// Устанавливать заголовок страницы
		"DELIVERY2PAY_SYSTEM" => "",
		"SHOW_ACCOUNT_NUMBER" => "Y",
		"DELIVERY_NO_SESSION" => "Y",	// Проверять сессию при оформлении заказа
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>