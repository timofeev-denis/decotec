<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */

CJSCore::Init(array("jquery"));
$this->setFrameMode(true);
$templateLibrary = array('popup');
$currencyList = '';

if (!empty($arResult['CURRENCIES']))
{
	$templateLibrary[] = 'currency';
	$currencyList = CUtil::PhpToJSObject($arResult['CURRENCIES'], false, true, true);
}
$templateData = array(
	'TEMPLATE_THEME' => $this->GetFolder().'/themes/'.$arParams['TEMPLATE_THEME'].'/style.css',
	'TEMPLATE_CLASS' => 'bx_'.$arParams['TEMPLATE_THEME'],
	'TEMPLATE_LIBRARY' => $templateLibrary,
	'CURRENCIES' => $currencyList
);
unset($currencyList, $templateLibrary);

$strMainID = $this->GetEditAreaId($arResult['ID']);
$arItemIDs = array(
	'ID' => $strMainID,
	'PICT' => $strMainID.'_pict',
	'DISCOUNT_PICT_ID' => $strMainID.'_dsc_pict',
	'STICKER_ID' => $strMainID.'_sticker',
	'BIG_SLIDER_ID' => $strMainID.'_big_slider',
	'BIG_IMG_CONT_ID' => $strMainID.'_bigimg_cont',
	'SLIDER_CONT_ID' => $strMainID.'_slider_cont',
	'SLIDER_LIST' => $strMainID.'_slider_list',
	'SLIDER_LEFT' => $strMainID.'_slider_left',
	'SLIDER_RIGHT' => $strMainID.'_slider_right',
	'OLD_PRICE' => $strMainID.'_old_price',
	'PRICE' => $strMainID.'_price',
	'DISCOUNT_PRICE' => $strMainID.'_price_discount',
	'SLIDER_CONT_OF_ID' => $strMainID.'_slider_cont_',
	'SLIDER_LIST_OF_ID' => $strMainID.'_slider_list_',
	'SLIDER_LEFT_OF_ID' => $strMainID.'_slider_left_',
	'SLIDER_RIGHT_OF_ID' => $strMainID.'_slider_right_',
	'QUANTITY' => $strMainID.'_quantity',
	'QUANTITY_DOWN' => $strMainID.'_quant_down',
	'QUANTITY_UP' => $strMainID.'_quant_up',
	'QUANTITY_MEASURE' => $strMainID.'_quant_measure',
	'QUANTITY_LIMIT' => $strMainID.'_quant_limit',
	'BASIS_PRICE' => $strMainID.'_basis_price',
	'BUY_LINK' => $strMainID.'_buy_link',
	'ADD_BASKET_LINK' => $strMainID.'_add_basket_link',
	'BASKET_ACTIONS' => $strMainID.'_basket_actions',
	'NOT_AVAILABLE_MESS' => $strMainID.'_not_avail',
	'COMPARE_LINK' => $strMainID.'_compare_link',
	'PROP' => $strMainID.'_prop_',
	'PROP_DIV' => $strMainID.'_skudiv',
	'DISPLAY_PROP_DIV' => $strMainID.'_sku_prop',
	'OFFER_GROUP' => $strMainID.'_set_group_',
	'BASKET_PROP_DIV' => $strMainID.'_basket_prop',
);
$strObName = 'ob'.preg_replace("/[^a-zA-Z0-9_]/", "x", $strMainID);
$templateData['JS_OBJ'] = $strObName;

$strTitle = (
	isset($arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"]) && $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"] != ''
	? $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"]
	: $arResult['NAME']
);
$strAlt = (
	isset($arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_ALT"]) && $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_ALT"] != ''
	? $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_ALT"]
	: $arResult['NAME']
);
?><div class="bx_item_detail <? echo $templateData['TEMPLATE_CLASS']; ?>" id="<? echo $arItemIDs['ID']; ?>">
<?
if ('Y' == $arParams['DISPLAY_NAME'])
{
?>
<div class="bx_item_title"><h1><span><?
	echo (
		isset($arResult["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"]) && $arResult["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"] != ''
		? $arResult["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"]
		: $arResult["NAME"]
	); ?>
</span></h1></div>
<?
}
reset($arResult['MORE_PHOTO']);
$arFirstPhoto = current($arResult['MORE_PHOTO']);
?>
	<div class="bx_item_container">
		<div class="bx_lt">
<div class="bx_item_slider" id="<? echo $arItemIDs['BIG_SLIDER_ID']; ?>">
	<div class="bx_bigimages" id="<? echo $arItemIDs['BIG_IMG_CONT_ID']; ?>">
	<div class="bx_bigimages_imgcontainer">
	<span class="bx_bigimages_aligner"><img id="<? echo $arItemIDs['PICT']; ?>" src="<? echo $arFirstPhoto['SRC']; ?>" alt="<? echo $strAlt; ?>" title="<? echo $strTitle; ?>"></span>
<?
//if ('Y' == $arParams['SHOW_DISCOUNT_PERCENT'])
if (false)
{
	if (!isset($arResult['OFFERS']) || empty($arResult['OFFERS']))
	{
		if (0 < $arResult['MIN_PRICE']['DISCOUNT_DIFF'])
		{
?>
	<div class="bx_stick_disc right bottom" id="<? echo $arItemIDs['DISCOUNT_PICT_ID'] ?>"><? echo -$arResult['MIN_PRICE']['DISCOUNT_DIFF_PERCENT']; ?>%</div>
<?
		}
	}
	else
	{
?>
	<div class="bx_stick_disc right bottom" id="<? echo $arItemIDs['DISCOUNT_PICT_ID'] ?>" style="display: none;"></div>
<?
	}
}
if ($arResult['LABEL'])
{
?>
	<div class="bx_stick average left top" id="<? echo $arItemIDs['STICKER_ID'] ?>" title="<? echo $arResult['LABEL_VALUE']; ?>"><? echo $arResult['LABEL_VALUE']; ?></div>
<?
}
?>
	</div>
	</div>
<?
if ($arResult['SHOW_SLIDER'])
{
	//if (!isset($arResult['OFFERS']) || empty($arResult['OFFERS']))
	if (true)
	{
		if (5 < $arResult['MORE_PHOTO_COUNT'])
		{
			$strClass = 'bx_slider_conteiner full';
			$strOneWidth = (100/$arResult['MORE_PHOTO_COUNT']);
			$strWidth = (20*$arResult['MORE_PHOTO_COUNT']).'%';
			$strSlideStyle = '';
		}
		else
		{
			$strClass = 'bx_slider_conteiner';
			$strOneWidth = '20';
			$strWidth = '100%';
			$strSlideStyle = 'display: none;';
		}
		$strOnePadding = $strOneWidth / 1.4 . '%';
		$strOneWidth .= '%';
?>
	<div class="<? echo $strClass; ?>" id="<? echo $arItemIDs['SLIDER_CONT_ID']; ?>">
	<div class="bx_slider_scroller_container">
	<div class="bx_slide">
	<ul style="width: <? echo $strWidth; ?>;" id="<? echo $arItemIDs['SLIDER_LIST']; ?>">
<?
		$i = 0;
		foreach ($arResult['MORE_PHOTO'] as &$arOnePhoto)
		{
?>
	<li class="img_preview<? echo ( $i==0 ? " bx_active" : "") ?>" data-value="<? echo $arOnePhoto['ID']; ?>" style="width: <? echo $strOneWidth; ?>; padding-top: <? echo $strOnePadding; ?>;"><span class="cnt"><span class="cnt_item" style="background-image:url('<? echo $arOnePhoto['SRC']; ?>');"></span></span></li>
<?			$i++;
		}
		unset($arOnePhoto);
?>
	</ul>
	</div>
	<div class="bx_slide_left" id="<? echo $arItemIDs['SLIDER_LEFT']; ?>" style="<? echo $strSlideStyle; ?>"></div>
	<div class="bx_slide_right" id="<? echo $arItemIDs['SLIDER_RIGHT']; ?>" style="<? echo $strSlideStyle; ?>"></div>
	</div>
	</div>
<?
	}
	else
	{
		foreach ($arResult['OFFERS'] as $key => $arOneOffer)
		{
			if (!isset($arOneOffer['MORE_PHOTO_COUNT']) || 0 >= $arOneOffer['MORE_PHOTO_COUNT'])
				continue;
			$strVisible = ($key == $arResult['OFFERS_SELECTED'] ? '' : 'none');
			if (5 < $arOneOffer['MORE_PHOTO_COUNT'])
			{
				$strClass = 'bx_slider_conteiner full';
				$strOneWidth = (100/$arOneOffer['MORE_PHOTO_COUNT']).'%';
				$strWidth = (20*$arOneOffer['MORE_PHOTO_COUNT']).'%';
				$strSlideStyle = '';
			}
			else
			{
				$strClass = 'bx_slider_conteiner';
				$strOneWidth = '20%';
				$strWidth = '100%';
				$strSlideStyle = 'display: none;';
			}
?>
	<div class="<? echo $strClass; ?>" id="<? echo $arItemIDs['SLIDER_CONT_OF_ID'].$arOneOffer['ID']; ?>" style="display: <? echo $strVisible; ?>;">
	<div class="bx_slider_scroller_container">
	<div class="bx_slide">
	<ul style="width: <? echo $strWidth; ?>;" id="<? echo $arItemIDs['SLIDER_LIST_OF_ID'].$arOneOffer['ID']; ?>">
<?
			foreach ($arOneOffer['MORE_PHOTO'] as &$arOnePhoto)
			{
?>
	<li data-value="<? echo $arOneOffer['ID'].'_'.$arOnePhoto['ID']; ?>" style="width: <? echo $strOneWidth; ?>; padding-top: <? echo $strOneWidth; ?>"><span class="cnt"><span class="cnt_item" style="background-image:url('<? echo $arOnePhoto['SRC']; ?>');"></span></span></li>
<?
			}
			unset($arOnePhoto);
?>
	</ul>
	</div>
	<div class="bx_slide_left" id="<? echo $arItemIDs['SLIDER_LEFT_OF_ID'].$arOneOffer['ID'] ?>" style="<? echo $strSlideStyle; ?>" data-value="<? echo $arOneOffer['ID']; ?>"></div>
	<div class="bx_slide_right" id="<? echo $arItemIDs['SLIDER_RIGHT_OF_ID'].$arOneOffer['ID'] ?>" style="<? echo $strSlideStyle; ?>" data-value="<? echo $arOneOffer['ID']; ?>"></div>
	</div>
	</div>
<?
		}
	}
}
?>
</div>
		</div>
		<div class="bx_rt">
<?
$useBrands = ('Y' == $arParams['BRAND_USE']);
$useVoteRating = ('Y' == $arParams['USE_VOTE_RATING']);
if ($useBrands || $useVoteRating)
{
?>
	<div class="bx_optionblock">
<?
	if ($useVoteRating)
	{
		?><?$APPLICATION->IncludeComponent(
			"bitrix:iblock.vote",
			"stars",
			array(
				"IBLOCK_TYPE" => $arParams['IBLOCK_TYPE'],
				"IBLOCK_ID" => $arParams['IBLOCK_ID'],
				"ELEMENT_ID" => $arResult['ID'],
				"ELEMENT_CODE" => "",
				"MAX_VOTE" => "5",
				"VOTE_NAMES" => array("1", "2", "3", "4", "5"),
				"SET_STATUS_404" => "N",
				"DISPLAY_AS_RATING" => $arParams['VOTE_DISPLAY_AS_RATING'],
				"CACHE_TYPE" => $arParams['CACHE_TYPE'],
				"CACHE_TIME" => $arParams['CACHE_TIME']
			),
			$component,
			array("HIDE_ICONS" => "Y")
		);?><?
	}
	if ($useBrands)
	{
		?><?$APPLICATION->IncludeComponent("bitrix:catalog.brandblock", ".default", array(
			"IBLOCK_TYPE" => $arParams['IBLOCK_TYPE'],
			"IBLOCK_ID" => $arParams['IBLOCK_ID'],
			"ELEMENT_ID" => $arResult['ID'],
			"ELEMENT_CODE" => "",
			"PROP_CODE" => $arParams['BRAND_PROP_CODE'],
			"CACHE_TYPE" => $arParams['CACHE_TYPE'],
			"CACHE_TIME" => $arParams['CACHE_TIME'],
			"CACHE_GROUPS" => $arParams['CACHE_GROUPS'],
			"WIDTH" => "",
			"HEIGHT" => ""
			),
			$component,
			array("HIDE_ICONS" => "Y")
		);?><?
	}
?>
	</div>
<?
}
unset($useVoteRating, $useBrands);
?>
<div class="item_info_section">
	<div class="bx_item_description">
		<div class="bx_item_section_name_gray" style="border-bottom: 1px solid #f2f2f2;">Страна</div>
		<?=$arResult["DISPLAY_PROPERTIES"]["ATT_COUNTRY"]["DISPLAY_VALUE"]?>
	</div>
</div>

<div class="item_info_section">
	<div class="bx_item_description">
		<div class="bx_item_section_name_gray" style="border-bottom: 1px solid #f2f2f2;">Производитель</div>
		<?=$arResult["DISPLAY_PROPERTIES"]["ATT_MANUFACTURER"]["DISPLAY_VALUE"]?>
	</div>
</div>

<div class="item_info_section">
	<div class="bx_item_description">
		<div class="bx_item_section_name_gray" style="border-bottom: 1px solid #f2f2f2;">Вид</div>
		<a href="<?=$arResult["SECTION"]["SECTION_PAGE_URL"]?>"><?echo $arResult["SECTION"]["PATH"][0]["NAME"]?></a>
	</div>
</div>

<div class="item_info_section">
	<div class="bx_item_description">
		<div class="bx_item_section_name_gray" style="border-bottom: 1px solid #f2f2f2;">Тематика</div>
		<?=$arResult["DISPLAY_PROPERTIES"]["ATT_THEME"]["DISPLAY_VALUE"]?>
	</div>
</div>

<div class="item_info_section">
<?
	//var_dump( $arResult );
if ('' != $arResult['DETAIL_TEXT'])
{
?>
	<div class="bx_item_description">
		<div class="bx_item_section_name_gray" style="border-bottom: 1px solid #f2f2f2;"><? echo GetMessage('FULL_DESCRIPTION'); ?></div>
<?
	if ('html' == $arResult['DETAIL_TEXT_TYPE'])
	{
		echo $arResult['DETAIL_TEXT'];
	}
	else
	{
		?><p><? echo $arResult['DETAIL_TEXT']; ?></p><?
	}
?>
	</div>
<?
}
?>
</div>


<div class="item_price" style="display: none;">
<?
$minPrice = (isset($arResult['RATIO_PRICE']) ? $arResult['RATIO_PRICE'] : $arResult['MIN_PRICE']);
$boolDiscountShow = (0 < $minPrice['DISCOUNT_DIFF']);
?>
	<div class="item_old_price" id="<? echo $arItemIDs['OLD_PRICE']; ?>" style="display: <? echo ($boolDiscountShow ? '' : 'none'); ?>"><? echo ($boolDiscountShow ? $minPrice['PRINT_VALUE'] : ''); ?></div>
	<div class="item_current_price" id="<? echo $arItemIDs['PRICE']; ?>"><? echo $minPrice['PRINT_DISCOUNT_VALUE']; ?></div>
	<div class="item_economy_price" id="<? echo $arItemIDs['DISCOUNT_PRICE']; ?>" style="display: <? echo ($boolDiscountShow ? '' : 'none'); ?>"><? echo ($boolDiscountShow ? GetMessage('CT_BCE_CATALOG_ECONOMY_INFO', array('#ECONOMY#' => $minPrice['PRINT_DISCOUNT_DIFF'])) : ''); ?></div>

</div>
<?
unset($minPrice);
if (!empty($arResult['DISPLAY_PROPERTIES']) || $arResult['SHOW_OFFERS_PROPS'])
{
}
if ('' != $arResult['PREVIEW_TEXT'])
{
	if (
		'S' == $arParams['DISPLAY_PREVIEW_TEXT_MODE']
		|| ('E' == $arParams['DISPLAY_PREVIEW_TEXT_MODE'] && '' == $arResult['DETAIL_TEXT'])
	)
	{
	}
}
if (isset($arResult['OFFERS']) && !empty($arResult['OFFERS']) && !empty($arResult['OFFERS_PROP']))
{
	$arSkuProps = array();
}
?>

			<div class="clb"></div>
		</div>

		<div class="bx_md">
<div class="item_info_section">
<?
if (isset($arResult['OFFERS']) && !empty($arResult['OFFERS']))
{
	if ($arResult['OFFER_GROUP'])
	{
		foreach ($arResult['OFFER_GROUP_VALUES'] as $offerID)
		{
?>
	<span id="<? echo $arItemIDs['OFFER_GROUP'].$offerID; ?>" style="display: none;">
<?$APPLICATION->IncludeComponent("bitrix:catalog.set.constructor",
	".default",
	array(
		"IBLOCK_ID" => $arResult["OFFERS_IBLOCK"],
		"ELEMENT_ID" => $offerID,
		"PRICE_CODE" => $arParams["PRICE_CODE"],
		"BASKET_URL" => $arParams["BASKET_URL"],
		"OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
		"CACHE_TYPE" => $arParams["CACHE_TYPE"],
		"CACHE_TIME" => $arParams["CACHE_TIME"],
		"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
		"TEMPLATE_THEME" => $arParams['~TEMPLATE_THEME'],
		"CONVERT_CURRENCY" => $arParams['CONVERT_CURRENCY'],
		"CURRENCY_ID" => $arParams["CURRENCY_ID"]
	),
	$component,
	array("HIDE_ICONS" => "Y")
);?><?
?>
	</span>
<?
		}
	}
}
else
{
	if ($arResult['MODULES']['catalog'] && $arResult['OFFER_GROUP'])
	{
?><?$APPLICATION->IncludeComponent("bitrix:catalog.set.constructor",
	".default",
	array(
		"IBLOCK_ID" => $arParams["IBLOCK_ID"],
		"ELEMENT_ID" => $arResult["ID"],
		"PRICE_CODE" => $arParams["PRICE_CODE"],
		"BASKET_URL" => $arParams["BASKET_URL"],
		"CACHE_TYPE" => $arParams["CACHE_TYPE"],
		"CACHE_TIME" => $arParams["CACHE_TIME"],
		"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
		"TEMPLATE_THEME" => $arParams['~TEMPLATE_THEME'],
		"CONVERT_CURRENCY" => $arParams['CONVERT_CURRENCY'],
		"CURRENCY_ID" => $arParams["CURRENCY_ID"]
	),
	$component,
	array("HIDE_ICONS" => "Y")
);?><?
	}
}
?>
</div>
		</div>
		<div class="bx_rb">
		</div>
		<div class="bx_lb">
<div class="tac ovh">
</div>
<div class="tab-section-container">
<?
if ('Y' == $arParams['USE_COMMENTS'])
{
?>
<?$APPLICATION->IncludeComponent(
	"bitrix:catalog.comments",
	"",
	array(
		"ELEMENT_ID" => $arResult['ID'],
		"ELEMENT_CODE" => "",
		"IBLOCK_ID" => $arParams['IBLOCK_ID'],
		"SHOW_DEACTIVATED" => $arParams['SHOW_DEACTIVATED'],
		"URL_TO_COMMENT" => "",
		"WIDTH" => "",
		"COMMENTS_COUNT" => "5",
		"BLOG_USE" => $arParams['BLOG_USE'],
		"FB_USE" => $arParams['FB_USE'],
		"FB_APP_ID" => $arParams['FB_APP_ID'],
		"VK_USE" => $arParams['VK_USE'],
		"VK_API_ID" => $arParams['VK_API_ID'],
		"CACHE_TYPE" => $arParams['CACHE_TYPE'],
		"CACHE_TIME" => $arParams['CACHE_TIME'],
		'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
		"BLOG_TITLE" => "",
		"BLOG_URL" => $arParams['BLOG_URL'],
		"PATH_TO_SMILE" => "",
		"EMAIL_NOTIFY" => $arParams['BLOG_EMAIL_NOTIFY'],
		"AJAX_POST" => "Y",
		"SHOW_SPAM" => "Y",
		"SHOW_RATING" => "N",
		"FB_TITLE" => "",
		"FB_USER_ADMIN_ID" => "",
		"FB_COLORSCHEME" => "light",
		"FB_ORDER_BY" => "reverse_time",
		"VK_TITLE" => "",
		"TEMPLATE_THEME" => $arParams['~TEMPLATE_THEME']
	),
	$component,
	array("HIDE_ICONS" => "Y")
);?>
<?
}
?>
</div>
	</div>
		<div style="clear: both;"></div>
		<div class="item_offers">
			<div class="bx_catalog_list_home col3 bx_green">
			<?php
			if( isset($arResult['OFFERS']) && !empty($arResult['OFFERS'])) {
			//if( false ) {
				foreach ($arResult['OFFERS'] as $key => $arOneOffer) {
					//print_r( $arOneOffer );
				?>
					<div class="bx_catalog_item" data-itemid="<?=$arOneOffer["ID"]?>">
						<form method="GET">
							<div class="bx_catalog_item_container" id="bx_328740560_20">
								<a id="bx_328740560_20_pict" href="#item_dialog" class="bx_catalog_item_images showItemDialog" style="background-image: url('<?=CFile::GetPath($arOneOffer["PREVIEW_PICTURE"])?>')" title="<?=$arOneOffer["NAME"]?>">		</a>
								<a id="bx_328740560_20_secondpict" href="#item_dialog" class="bx_catalog_item_images_double showItemDialog" style="background-image: url('<?=CFile::GetPath($arOneOffer["PREVIEW_PICTURE"])?>');" title="<?=$arOneOffer["NAME"]?>">		</a>
								<div class="bx_catalog_item_title">
									<a class="showItemDialog" href="#item_dialog" title="<?=$arOneOffer["NAME"]?>"><?=$arOneOffer["NAME"]?></a>
								</div>
								<div class="bx_catalog_item_title">
									<a class="showItemDialog" href="#item_dialog" title="<?=$arOneOffer["NAME"]?>"><?=$arOneOffer["PROPERTIES"]["ATT_TYPE"]["VALUE"]?></a>
								</div>
								<div class="bx_catalog_item_price">
									<div id="bx_328740560_20_price" class="bx_price"><?=$arOneOffer["PRICES"]["BASE"]["PRINT_VALUE"]?> за <?=$arOneOffer["CATALOG_MEASURE_NAME"]?></div>
								</div>
									<input type="hidden" name="id" value="<?=$arOneOffer["ID"]?>" />
									<input type="hidden" name="action" value="BUY" />
								
									<div class="bx_catalog_item_controls no_touch">
										<input type="text" name="<?echo $arParams["PRODUCT_QUANTITY_VARIABLE"]?>" value="1" id="<?echo $arParams["PRODUCT_QUANTITY_VARIABLE"]?>" style="width: 40px; text-align: center;">
										<input type="submit" class="bx_bt_button_type_2 bx_medium" value="В корзину" />
									</div>
									<div class="bx_catalog_item_controls touch">
										<input type="submit" class="bx_bt_button_type_2 bx_medium" value="В корзину" />
									</div>
							</div>
						</form>
					</div>
					
				<?
				}
			} else {
			?>
				
			<?}?>
			</div>
		</div>
		<!-- /item_offers -->
		<!-- offer_dialog -->
		
		
		
		
		<link rel="stylesheet" href="/bitrix/css/main/jquery.bootstrap-touchspin.css">
		<script type="text/javascript" src="/bitrix/js/main/jquery/jquery.bootstrap-touchspin.js"></script>
		
		<link rel="stylesheet" href="/remodal/dist/remodal.css">
		<link rel="stylesheet" href="/remodal/dist/remodal-default-theme.css">
		<style>
			.remodal-bg.with-red-theme.remodal-is-opening,
			.remodal-bg.with-red-theme.remodal-is-opened {
			  filter: none;
			}

			.remodal-overlay.with-red-theme {
			  background-color: #f44336;
			}

			.remodal.with-red-theme {
			  background: #fff;
			}
		</style>
		<script src="/remodal/dist/remodal.js"></script>
		
		<script>
			$(function() {
				function round(value, decimals) {
					if( typeof decimals !== 'number' ) {
						decimals = 0;
					}
					return Number(Math.round(value+'e'+decimals)+'e-'+decimals);
				}

				// Подготавливаем диалог
				var dlg = $('#item_dialog').remodal();
				var tileData;
				$( ".showItemDialog" ).click(function( e ) {
					//e.preventDefault();
					var itemid = $( this ).parents( ".bx_catalog_item" ).data( "itemid" );
					$.ajax({
						dataType: "json",
						url: "/get_tile_data.php",
						data: { id: itemid }
					}).done( function( data ) {
						dlg.open();
						data.SQUARE = data.WIDTH * data.LENGTH / 1000000;
						tileData = data;
						$( "input[id='tiles']" ).val( "1" );
						$( "input[id='meters']" ).trigger("touchspin.updatesettings", {min: data.SQUARE});
						$( "input[id='tiles']" ).change();
						$( "#itemId" ).val( itemid );
						$( "#item_price" ).text( data.PRICE + " руб. / шт." );
						$( "#item_price_square" ).html( round( data.PRICE * ( 1 / data.SQUARE ), 2 ) + " руб. / м&sup2;" );
						$( "#item_title" ).text( data.NAME );
						$( "#item_type" ).text( data.ATT_TYPE );
						$( "#item_size" ).text( data.WIDTH + " x " + data.LENGTH + " мм" );
						$( "#item_detail_picture" ).attr("src", data.DETAIL_PICTURE);
					});
				});
				
				function updatePrice() {
					$( "#totalPrice" ).text( tileData.PRICE * $("input[id='tiles']").val() );
				}
				
				$("input[id='tiles']").change(function() {
					$("input[id='meters']").val( $( this ).val() * tileData.SQUARE );
					updatePrice();
				});	
				$("input[id='meters']").change(function() {
					$("input[id='tiles']").val( Math.ceil( $( this ).val() / tileData.SQUARE ) );
					updatePrice();
				});
			});
		</script>
		<div id="item_dialog">
			<form method="GET">
				<div class="row">
					<div id="item_title" class="col-md-12">Детальное описание</div>
				</div>
				<div class="row">
					<!-- image -->
					<div class="col-md-6 col-sm-6">
						<img id="item_detail_picture" src="/images/tile_default.jpg" alt="" title="">
					</div>
					<!-- /image -->
					
					<!-- info -->
					<div class="col-md-6 col-sm-6">
						<div class="item_info">

							<div class="item_info_section">
								<div class="bx_item_description">
									<div class="item_param_name" style="border-bottom: 1px solid #f2f2f2;">Страна</div>
									<div class="item_param_value"><?=$arResult["DISPLAY_PROPERTIES"]["ATT_COUNTRY"]["DISPLAY_VALUE"]?></div>
								</div>
							</div>

							<div class="item_info_section">
								<div class="bx_item_description">
									<div class="item_param_name" style="border-bottom: 1px solid #f2f2f2;">Производитель</div>
									<div class="item_param_value"><?=$arResult["DISPLAY_PROPERTIES"]["ATT_MANUFACTURER"]["DISPLAY_VALUE"]?></div>
								</div>
							</div>

							<div class="item_info_section">
								<div class="bx_item_description">
									<div class="item_param_name" style="border-bottom: 1px solid #f2f2f2;">Вид</div>
									<div class="item_param_value"><a href="<?=$arResult["SECTION"]["SECTION_PAGE_URL"]?>"><?echo $arResult["SECTION"]["PATH"][0]["NAME"]?></a></div>
								</div>
							</div>

							<div class="item_info_section">
								<div class="bx_item_description">
									<div class="item_param_name" style="border-bottom: 1px solid #f2f2f2;">Тематика</div>
									<div class="item_param_value"><?=$arResult["DISPLAY_PROPERTIES"]["ATT_THEME"]["DISPLAY_VALUE"]?></div>
								</div>
							</div>

							<div class="item_info_section">
								<div class="bx_item_description">
									<div class="item_param_name" style="border-bottom: 1px solid #f2f2f2;">Тип</div>
									<div class="item_param_value" id="item_type"></div>
								</div>
							</div>

							<div class="item_info_section">
								<div class="bx_item_description">
									<div class="item_param_name" style="border-bottom: 1px solid #f2f2f2;">Размер</div>
									<div class="item_param_value" id="item_size"></div>
								</div>
							</div>

							<div class="item_info_section">
								<div class="bx_item_description">
									<div class="item_param_name" style="border-bottom: 1px solid #f2f2f2;">Цена</div>
									<div class="item_param_value" id="item_price"></div>
									<div class="item_param_value" id="item_price_square"></div>
								</div>
							</div>
							
							<div class="buy_controls" style = "text-align: center; padding-top: 50px; width: 100%;">
								<div style = "display: inline-block;">
								
									<div class="quantity">
										<span>В штуках</span>
										<input id="tiles" type="text" value="" name="<?echo $arParams["PRODUCT_QUANTITY_VARIABLE"]?>">
										<script>
											$("input[id='tiles']").TouchSpin({
												min: 1,
												initval: 1
											});
										</script>
									</div>
									
									<div class="quantity">
										<span>В метрах<sup>2</sup></span>
										<input id="meters" type="text" value="" name="meters">
										<script>
											$("input[id='meters']").TouchSpin({
												step: 0.01,
												decimals: 4,
											});
										</script>
									</div>
									
								</div>
							</div>

							<div class="item_info_section">
								<div class="bx_item_description bx_item_detail">
									<div id="totalPrice">1820</div>
								</div>
							</div>
							<div class="item_info_section">
								<div class="bx_item_description bx_item_detail ">
									<input type="submit" class="bx_bt_button_type_2 bx_medium" value="В корзину">
								</div>
							</div>

							<div class="item_info_section"></div>
							
							<div class="clb"></div>
						</div>
					</div>
					<!-- /info -->
				</div>
				<input type="hidden" name="id" id="itemId" value="0" />
				<input type="hidden" name="action" value="BUY" />

			</form>
		</div>
		
		
		
		
		
		
		
		
		<!-- /offer_dialog -->
	</div>
	<div class="clb"></div>
</div><?
//if (isset($arResult['OFFERS']) && !empty($arResult['OFFERS']))
if (false)
{
	foreach ($arResult['JS_OFFERS'] as &$arOneJS)
	{
		if ($arOneJS['PRICE']['DISCOUNT_VALUE'] != $arOneJS['PRICE']['VALUE'])
		{
			$arOneJS['PRICE']['DISCOUNT_DIFF_PERCENT'] = -$arOneJS['PRICE']['DISCOUNT_DIFF_PERCENT'];
			$arOneJS['BASIS_PRICE']['DISCOUNT_DIFF_PERCENT'] = -$arOneJS['BASIS_PRICE']['DISCOUNT_DIFF_PERCENT'];
		}
		$strProps = '';
		if ($arResult['SHOW_OFFERS_PROPS'])
		{
			if (!empty($arOneJS['DISPLAY_PROPERTIES']))
			{
				foreach ($arOneJS['DISPLAY_PROPERTIES'] as $arOneProp)
				{
					$strProps .= '<dt>'.$arOneProp['NAME'].'</dt><dd>'.(
						is_array($arOneProp['VALUE'])
						? implode(' / ', $arOneProp['VALUE'])
						: $arOneProp['VALUE']
					).'</dd>';
				}
			}
		}
		$arOneJS['DISPLAY_PROPERTIES'] = $strProps;
	}
	if (isset($arOneJS))
		unset($arOneJS);
	$arJSParams = array(
		'CONFIG' => array(
			'USE_CATALOG' => $arResult['CATALOG'],
			'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
			'SHOW_PRICE' => true,
			'SHOW_DISCOUNT_PERCENT' => ($arParams['SHOW_DISCOUNT_PERCENT'] == 'Y'),
			'SHOW_OLD_PRICE' => ($arParams['SHOW_OLD_PRICE'] == 'Y'),
			'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
			'SHOW_SKU_PROPS' => $arResult['SHOW_OFFERS_PROPS'],
			'OFFER_GROUP' => $arResult['OFFER_GROUP'],
			'MAIN_PICTURE_MODE' => $arParams['DETAIL_PICTURE_MODE'],
			'SHOW_BASIS_PRICE' => ($arParams['SHOW_BASIS_PRICE'] == 'Y'),
			'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
			'SHOW_CLOSE_POPUP' => ($arParams['SHOW_CLOSE_POPUP'] == 'Y')
		),
		'PRODUCT_TYPE' => $arResult['CATALOG_TYPE'],
		'VISUAL' => array(
			'ID' => $arItemIDs['ID'],
		),
		'DEFAULT_PICTURE' => array(
			'PREVIEW_PICTURE' => $arResult['DEFAULT_PICTURE'],
			'DETAIL_PICTURE' => $arResult['DEFAULT_PICTURE']
		),
		'PRODUCT' => array(
			'ID' => $arResult['ID'],
			'NAME' => $arResult['~NAME']
		),
		'BASKET' => array(
			'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
			'BASKET_URL' => $arParams['BASKET_URL'],
			'SKU_PROPS' => $arResult['OFFERS_PROP_CODES'],
			'ADD_URL_TEMPLATE' => $arResult['~ADD_URL_TEMPLATE'],
			'BUY_URL_TEMPLATE' => $arResult['~BUY_URL_TEMPLATE']
		),
		'OFFERS' => $arResult['JS_OFFERS'],
		'OFFER_SELECTED' => $arResult['OFFERS_SELECTED'],
		'TREE_PROPS' => $arSkuProps
	);
	if ($arParams['DISPLAY_COMPARE'])
	{
		$arJSParams['COMPARE'] = array(
			'COMPARE_URL_TEMPLATE' => $arResult['~COMPARE_URL_TEMPLATE'],
			'COMPARE_PATH' => $arParams['COMPARE_PATH']
		);
	}
}
else
{
	$emptyProductProperties = empty($arResult['PRODUCT_PROPERTIES']);
	if ('Y' == $arParams['ADD_PROPERTIES_TO_BASKET'] && !$emptyProductProperties)
	{
?>
<div id="<? echo $arItemIDs['BASKET_PROP_DIV']; ?>" style="display: none;">
<?
		if (!empty($arResult['PRODUCT_PROPERTIES_FILL']))
		{
			foreach ($arResult['PRODUCT_PROPERTIES_FILL'] as $propID => $propInfo)
			{
?>
	<input type="hidden" name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]" value="<? echo htmlspecialcharsbx($propInfo['ID']); ?>">
<?
				if (isset($arResult['PRODUCT_PROPERTIES'][$propID]))
					unset($arResult['PRODUCT_PROPERTIES'][$propID]);
			}
		}
		$emptyProductProperties = empty($arResult['PRODUCT_PROPERTIES']);
		if (!$emptyProductProperties)
		{
?>
	<table>
<?
			foreach ($arResult['PRODUCT_PROPERTIES'] as $propID => $propInfo)
			{
?>
	<tr><td><? echo $arResult['PROPERTIES'][$propID]['NAME']; ?></td>
	<td>
<?
				if(
					'L' == $arResult['PROPERTIES'][$propID]['PROPERTY_TYPE']
					&& 'C' == $arResult['PROPERTIES'][$propID]['LIST_TYPE']
				)
				{
					foreach($propInfo['VALUES'] as $valueID => $value)
					{
						?><label><input type="radio" name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]" value="<? echo $valueID; ?>" <? echo ($valueID == $propInfo['SELECTED'] ? '"checked"' : ''); ?>><? echo $value; ?></label><br><?
					}
				}
				else
				{
					?><select name="<? echo $arParams['PRODUCT_PROPS_VARIABLE']; ?>[<? echo $propID; ?>]"><?
					foreach($propInfo['VALUES'] as $valueID => $value)
					{
						?><option value="<? echo $valueID; ?>" <? echo ($valueID == $propInfo['SELECTED'] ? '"selected"' : ''); ?>><? echo $value; ?></option><?
					}
					?></select><?
				}
?>
	</td></tr>
<?
			}
?>
	</table>
<?
		}
?>
</div>
<?
	}
	if ($arResult['MIN_PRICE']['DISCOUNT_VALUE'] != $arResult['MIN_PRICE']['VALUE'])
	{
		$arResult['MIN_PRICE']['DISCOUNT_DIFF_PERCENT'] = -$arResult['MIN_PRICE']['DISCOUNT_DIFF_PERCENT'];
		$arResult['MIN_BASIS_PRICE']['DISCOUNT_DIFF_PERCENT'] = -$arResult['MIN_BASIS_PRICE']['DISCOUNT_DIFF_PERCENT'];
	}
	$arJSParams = array(
		'CONFIG' => array(
			'USE_CATALOG' => $arResult['CATALOG'],
			'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
			'SHOW_PRICE' => (isset($arResult['MIN_PRICE']) && !empty($arResult['MIN_PRICE']) && is_array($arResult['MIN_PRICE'])),
			'SHOW_DISCOUNT_PERCENT' => ($arParams['SHOW_DISCOUNT_PERCENT'] == 'Y'),
			'SHOW_OLD_PRICE' => ($arParams['SHOW_OLD_PRICE'] == 'Y'),
			'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
			'MAIN_PICTURE_MODE' => $arParams['DETAIL_PICTURE_MODE'],
			'SHOW_BASIS_PRICE' => ($arParams['SHOW_BASIS_PRICE'] == 'Y'),
			'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
			'SHOW_CLOSE_POPUP' => ($arParams['SHOW_CLOSE_POPUP'] == 'Y')
		),
		'VISUAL' => array(
			'ID' => $arItemIDs['ID'],
		),
		'PRODUCT_TYPE' => $arResult['CATALOG_TYPE'],
		'PRODUCT' => array(
			'ID' => $arResult['ID'],
			'PICT' => $arFirstPhoto,
			'NAME' => $arResult['~NAME'],
			'SUBSCRIPTION' => true,
			'PRICE' => $arResult['MIN_PRICE'],
			'BASIS_PRICE' => $arResult['MIN_BASIS_PRICE'],
			'SLIDER_COUNT' => $arResult['MORE_PHOTO_COUNT'],
			'SLIDER' => $arResult['MORE_PHOTO'],
			'CAN_BUY' => $arResult['CAN_BUY'],
			'CHECK_QUANTITY' => $arResult['CHECK_QUANTITY'],
			'QUANTITY_FLOAT' => is_double($arResult['CATALOG_MEASURE_RATIO']),
			'MAX_QUANTITY' => $arResult['CATALOG_QUANTITY'],
			'STEP_QUANTITY' => $arResult['CATALOG_MEASURE_RATIO'],
		),
		'BASKET' => array(
			'ADD_PROPS' => ($arParams['ADD_PROPERTIES_TO_BASKET'] == 'Y'),
			'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
			'PROPS' => $arParams['PRODUCT_PROPS_VARIABLE'],
			'EMPTY_PROPS' => $emptyProductProperties,
			'BASKET_URL' => $arParams['BASKET_URL'],
			'ADD_URL_TEMPLATE' => $arResult['~ADD_URL_TEMPLATE'],
			'BUY_URL_TEMPLATE' => $arResult['~BUY_URL_TEMPLATE']
		)
	);
	if ($arParams['DISPLAY_COMPARE'])
	{
		$arJSParams['COMPARE'] = array(
			'COMPARE_URL_TEMPLATE' => $arResult['~COMPARE_URL_TEMPLATE'],
			'COMPARE_PATH' => $arParams['COMPARE_PATH']
		);
	}
	unset($emptyProductProperties);
}
?>
<?
$arJSParams[ "PRODUCT_TYPE" ] = 1;
?>

<script type="text/javascript">
var <? echo $strObName; ?> = new JCCatalogElement(<? echo CUtil::PhpToJSObject($arJSParams, false, true); ?>);
BX.message({
	ECONOMY_INFO_MESSAGE: '<? echo GetMessageJS('CT_BCE_CATALOG_ECONOMY_INFO'); ?>',
	BASIS_PRICE_MESSAGE: '<? echo GetMessageJS('CT_BCE_CATALOG_MESS_BASIS_PRICE') ?>',
	TITLE_ERROR: '<? echo GetMessageJS('CT_BCE_CATALOG_TITLE_ERROR') ?>',
	TITLE_BASKET_PROPS: '<? echo GetMessageJS('CT_BCE_CATALOG_TITLE_BASKET_PROPS') ?>',
	BASKET_UNKNOWN_ERROR: '<? echo GetMessageJS('CT_BCE_CATALOG_BASKET_UNKNOWN_ERROR') ?>',
	BTN_SEND_PROPS: '<? echo GetMessageJS('CT_BCE_CATALOG_BTN_SEND_PROPS'); ?>',
	BTN_MESSAGE_BASKET_REDIRECT: '<? echo GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_BASKET_REDIRECT') ?>',
	BTN_MESSAGE_CLOSE: '<? echo GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_CLOSE'); ?>',
	BTN_MESSAGE_CLOSE_POPUP: '<? echo GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_CLOSE_POPUP'); ?>',
	TITLE_SUCCESSFUL: '<? echo GetMessageJS('CT_BCE_CATALOG_ADD_TO_BASKET_OK'); ?>',
	COMPARE_MESSAGE_OK: '<? echo GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_OK') ?>',
	COMPARE_UNKNOWN_ERROR: '<? echo GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_UNKNOWN_ERROR') ?>',
	COMPARE_TITLE: '<? echo GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_TITLE') ?>',
	BTN_MESSAGE_COMPARE_REDIRECT: '<? echo GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_COMPARE_REDIRECT') ?>',
	SITE_ID: '<? echo SITE_ID; ?>'
});
</script>