<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Задать вопрос");
?><h2>Задать вопрос</h2>
		 <?$APPLICATION->IncludeComponent(
	"bitrix:main.feedback",
	"eshop_adapt",
	Array(
		"USE_CAPTCHA" => "Y",
		"OK_TEXT" => "Спасибо, ваше сообщение принято.",
		"EMAIL_TO" => "ishop@decotec.ru",
		"REQUIRED_FIELDS" => array(),
		"EVENT_MESSAGE_ID" => array(),
		"COMPONENT_TEMPLATE" => "eshop_adapt"
	)
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>