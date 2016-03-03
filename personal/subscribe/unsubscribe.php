<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Отписка от рассылки");
?><?$APPLICATION->IncludeComponent(
	"decotec:subscribe.unsubscribe",
	"",
	Array(
		"ASD_MAIL_ID" => $_REQUEST["mid"],
		"ASD_MAIL_MD5" => $_REQUEST["mhash"],
		"COMPONENT_TEMPLATE" => ".default"
	)
);?><br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>