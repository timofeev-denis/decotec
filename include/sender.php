<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="bx-subscribe">
	<div class="bx-block-title">РАССЫЛКА<div class="lower normal">акции и распродажи</div></div>
	<?$APPLICATION->IncludeComponent("decotec:sender.subscribe", "decotec", Array(
	"SET_TITLE" => "N",	// Устанавливать заголовок страницы
		"COMPONENT_TEMPLATE" => ".default",
		"USE_PERSONALIZATION" => "N",	// Определять подписку текущего пользователя
		"CONFIRMATION" => "Y",	// Запрашивать подтверждение подписки по email
		"SHOW_HIDDEN" => "Y",	// Показать скрытые рассылки для подписки
		"AJAX_MODE" => "N",	// Включить режим AJAX
		"AJAX_OPTION_JUMP" => "N",	// Включить прокрутку к началу компонента
		"AJAX_OPTION_STYLE" => "Y",	// Включить подгрузку стилей
		"AJAX_OPTION_HISTORY" => "N",	// Включить эмуляцию навигации браузера
		"AJAX_OPTION_ADDITIONAL" => "undefined",	// Дополнительный идентификатор
		"CACHE_TYPE" => "A",	// Тип кеширования
		"CACHE_TIME" => "3600",	// Время кеширования (сек.)
	),
	false
);?>
</div>