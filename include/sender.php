<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="bx-subscribe">
	<div class="bx-block-title">РАССЫЛКА</div>
	<?$APPLICATION->IncludeComponent(
	"bitrix:sender.subscribe", 
	".default", 
	array(
		"SET_TITLE" => "N",
		"COMPONENT_TEMPLATE" => ".default",
		"USE_PERSONALIZATION" => "Y",
		"CONFIRMATION" => "Y",
		"SHOW_HIDDEN" => "Y",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_ADDITIONAL" => "undefined",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600"
	),
	false
);?>
</div>