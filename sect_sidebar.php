<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if ($APPLICATION->GetCurPage(true) == SITE_DIR."index.php"):?>
<div class="bx-sidebar-block">
	<?$APPLICATION->IncludeComponent("bitrix:search.title", "visual", array(
			"NUM_CATEGORIES" => "1",
			"TOP_COUNT" => "5",
			"CHECK_DATES" => "N",
			"SHOW_OTHERS" => "N",
			"PAGE" => SITE_DIR."catalog/",
			"CATEGORY_0_TITLE" => "Товары" ,
			"CATEGORY_0" => array(
				0 => "iblock_catalog",
			),
			"CATEGORY_0_iblock_catalog" => array(
				0 => "all",
			),
			"CATEGORY_OTHERS_TITLE" => "Прочее",
			"SHOW_INPUT" => "Y",
			"INPUT_ID" => "title-search-input",
			"CONTAINER_ID" => "search",
			"PRICE_CODE" => array(
				0 => "BASE",
			),
			"SHOW_PREVIEW" => "Y",
			"PREVIEW_WIDTH" => "75",
			"PREVIEW_HEIGHT" => "75",
			"CONVERT_CURRENCY" => "Y"
		),
		false
	);?>
</div>
<?endif?>
<?$APPLICATION->IncludeComponent(
	"bitrix:main.include", 
	".default", 
	array(
		"COMPONENT_TEMPLATE" => ".default",
		"AREA_FILE_SHOW" => "file",
		"PATH" => SITE_DIR."include/manufacturers.php",
		"EDIT_TEMPLATE" => ""
	),
	false
);?>