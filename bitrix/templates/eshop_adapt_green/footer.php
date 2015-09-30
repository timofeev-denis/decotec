<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
						<div>
							<?$APPLICATION->IncludeComponent(
	"bitrix:catalog.viewed.products", 
	"decotec", 
	array(
		"COMPONENT_TEMPLATE" => "decotec",
		"IBLOCK_TYPE" => "catalog",
		"IBLOCK_ID" => "2",
		"SHOW_FROM_SECTION" => "Y",
		"SECTION_ID" => "",
		"SECTION_CODE" => "",
		"SECTION_ELEMENT_ID" => "",
		"SECTION_ELEMENT_CODE" => "",
		"DEPTH" => "",
		"HIDE_NOT_AVAILABLE" => "N",
		"SHOW_DISCOUNT_PERCENT" => "Y",
		"PRODUCT_SUBSCRIPTION" => "N",
		"SHOW_NAME" => "Y",
		"SHOW_IMAGE" => "Y",
		"MESS_BTN_BUY" => "Купить",
		"MESS_BTN_DETAIL" => "Подробнее",
		"MESS_BTN_SUBSCRIBE" => "Подписаться",
		"PAGE_ELEMENT_COUNT" => "3",
		"LINE_ELEMENT_COUNT" => "3",
		"TEMPLATE_THEME" => "blue",
		"DETAIL_URL" => "",
		"CACHE_TYPE" => "N",
		"CACHE_TIME" => "36000000",
		"CACHE_GROUPS" => "Y",
		"SHOW_OLD_PRICE" => "N",
		"PRICE_CODE" => array(
			0 => "BASE",
		),
		"SHOW_PRICE_COUNT" => "1",
		"PRICE_VAT_INCLUDE" => "Y",
		"CONVERT_CURRENCY" => "N",
		"BASKET_URL" => "/personal/basket.php",
		"ACTION_VARIABLE" => "action",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRODUCT_QUANTITY_VARIABLE" => "",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"USE_PRODUCT_QUANTITY" => "N",
		"SHOW_PRODUCTS_2" => "Y",
		"PROPERTY_CODE_2" => array(
			0 => "ATT_MANUFACTURER",
			1 => "ATT_COUNTRY",
			2 => "",
		),
		"CART_PROPERTIES_2" => array(
			0 => "",
			1 => "",
		),
		"ADDITIONAL_PICT_PROP_2" => "MORE_PHOTO",
		"LABEL_PROP_2" => "-",
		"PROPERTY_CODE_3" => array(
			0 => "",
			1 => "",
		),
		"CART_PROPERTIES_3" => array(
			0 => "",
			1 => "",
		),
		"ADDITIONAL_PICT_PROP_3" => "",
		"OFFER_TREE_PROPS_3" => array(
			0 => "-",
		)
	),
	false
);?>
						</div>
						<? if ($APPLICATION->GetCurPage(false) === '/'): ?>
						<div class="bx_item_list_new_items">
							<div class="bx_item_list_title">Новые поступления:</div>
							<?$APPLICATION->IncludeComponent(
								"bitrix:catalog.top",
								"decotec",
								Array(
									"COMPONENT_TEMPLATE" => "decotec",
									"IBLOCK_TYPE" => "catalog",
									"IBLOCK_ID" => "2",
									"ELEMENT_SORT_FIELD" => "timestamp_x",
									"ELEMENT_SORT_ORDER" => "desc",
									"ELEMENT_SORT_FIELD2" => "name",
									"ELEMENT_SORT_ORDER2" => "asc",
									"FILTER_NAME" => "",
									"HIDE_NOT_AVAILABLE" => "N",
									"ELEMENT_COUNT" => "3",
									"LINE_ELEMENT_COUNT" => "3",
									"PROPERTY_CODE" => array("ATT_MANUFACTURER","ATT_COUNTRY",""),
									"OFFERS_LIMIT" => "5",
									"VIEW_MODE" => "SECTION",
									"SHOW_DISCOUNT_PERCENT" => "N",
									"SHOW_OLD_PRICE" => "N",
									"SHOW_CLOSE_POPUP" => "N",
									"MESS_BTN_BUY" => "Купить",
									"MESS_BTN_ADD_TO_BASKET" => "В корзину",
									"MESS_BTN_DETAIL" => "Подробнее",
									"MESS_NOT_AVAILABLE" => "Нет в наличии",
									"SECTION_URL" => "",
									"DETAIL_URL" => "",
									"SECTION_ID_VARIABLE" => "SECTION_ID",
									"PRODUCT_QUANTITY_VARIABLE" => "",
									"SEF_MODE" => "N",
									"CACHE_TYPE" => "A",
									"CACHE_TIME" => "36000000",
									"CACHE_GROUPS" => "Y",
									"CACHE_FILTER" => "N",
									"ACTION_VARIABLE" => "action",
									"PRODUCT_ID_VARIABLE" => "id",
									"PRICE_CODE" => array(),
									"USE_PRICE_COUNT" => "N",
									"SHOW_PRICE_COUNT" => "1",
									"PRICE_VAT_INCLUDE" => "Y",
									"CONVERT_CURRENCY" => "N",
									"BASKET_URL" => "/personal/basket.php",
									"USE_PRODUCT_QUANTITY" => "N",
									"ADD_PROPERTIES_TO_BASKET" => "Y",
									"PRODUCT_PROPS_VARIABLE" => "prop",
									"PARTIAL_PRODUCT_PROPERTIES" => "N",
									"PRODUCT_PROPERTIES" => array(),
									"ADD_TO_BASKET_ACTION" => "ADD",
									"DISPLAY_COMPARE" => "N",
									"TEMPLATE_THEME" => "blue",
									"MESS_BTN_COMPARE" => "Сравнить",
									"OFFERS_FIELD_CODE" => array("",""),
									"OFFERS_PROPERTY_CODE" => array("",""),
									"OFFERS_SORT_FIELD" => "sort",
									"OFFERS_SORT_ORDER" => "asc",
									"OFFERS_SORT_FIELD2" => "id",
									"OFFERS_SORT_ORDER2" => "desc",
									"PRODUCT_DISPLAY_MODE" => "N",
									"ADD_PICT_PROP" => "MORE_PHOTO",
									"LABEL_PROP" => "-",
									"OFFERS_CART_PROPERTIES" => array(),
									"SEF_RULE" => ""
								)
							);?>
						</div>
						<? endif; ?>
					</div>
					<?if (/*!$isCatalogPage*/true):?>
					<div class="sidebar col-md-3 col-sm-4">
						<?$APPLICATION->IncludeComponent(
							"bitrix:main.include",
							"",
							Array(
								"AREA_FILE_SHOW" => "sect",
								"AREA_FILE_SUFFIX" => "sidebar",
								"AREA_FILE_RECURSIVE" => "Y",
								"EDIT_MODE" => "html",
							),
							false,
							Array('HIDE_ICONS' => 'Y')
						);?>
					</div><!--// sidebar -->
					<?endif?>
				</div><!--//row-->
			</div><!--//container bx-content-seection-->
		</div><!--//workarea-->

		<footer class="bx-footer">
			<div class="bx-footer-line">
				<div class="bx-footer-section container">
					<?$APPLICATION->IncludeComponent(
						"bitrix:main.include",
						"",
						Array(
							"AREA_FILE_SHOW" => "file",
							"PATH" => SITE_DIR."include/socnet_footer.php",
							"AREA_FILE_RECURSIVE" => "N",
							"EDIT_MODE" => "html",
						),
						false,
						Array('HIDE_ICONS' => 'Y')
					);?>
				</div>
			</div>
			<div class="bx-footer-section container bx-center-section">
				<div class="col-sm-5 col-md-3 col-md-push-6">
					<h4 class="bx-block-title"><?$APPLICATION->IncludeComponent("bitrix:main.include", "", array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR."include/about_title.php"), false);?></h4>
					<?$APPLICATION->IncludeComponent("bitrix:menu", "bottom_menu", array(
							"ROOT_MENU_TYPE" => "bottom",
							"MAX_LEVEL" => "1",
							"MENU_CACHE_TYPE" => "A",
							"CACHE_SELECTED_ITEMS" => "N",
							"MENU_CACHE_TIME" => "36000000",
							"MENU_CACHE_USE_GROUPS" => "Y",
							"MENU_CACHE_GET_VARS" => array(
							),
						),
						false
					);?>
				</div>
				<div class="col-sm-5 col-md-3">
					<h4 class="bx-block-title"><?$APPLICATION->IncludeComponent("bitrix:main.include", "", array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR."include/catalog_title.php"), false);?></h4>
					<?$APPLICATION->IncludeComponent("bitrix:menu", "bottom_menu", array(
							"ROOT_MENU_TYPE" => "left",
							"MENU_CACHE_TYPE" => "A",
							"MENU_CACHE_TIME" => "36000000",
							"MENU_CACHE_USE_GROUPS" => "Y",
							"MENU_CACHE_GET_VARS" => array(
							),
							"CACHE_SELECTED_ITEMS" => "N",
							"MAX_LEVEL" => "1",
							"USE_EXT" => "Y",
							"DELAY" => "N",
							"ALLOW_MULTI_SELECT" => "N"
						),
						false
					);?>
				</div>
				<div class="col-sm-5 col-md-3 col-md-push-3">
					<div style="padding: 20px;background:#eaeaeb">
						<?$APPLICATION->IncludeComponent(
							"bitrix:main.include",
							"",
							Array(
								"AREA_FILE_SHOW" => "file",
								"PATH" => SITE_DIR."include/sender.php",
								"AREA_FILE_RECURSIVE" => "N",
								"EDIT_MODE" => "html",
							),
							false,
							Array('HIDE_ICONS' => 'Y')
						);?>
					</div>
					<div id="bx-composite-banner" style="padding-top: 20px"></div>
				</div>
				<div class="col-sm-5 col-md-3 col-md-pull-9">
					<div class="bx-inclogofooter">
						<div class="bx-inclogofooter-block">
							<a class="bx-inclogofooter-logo" href="<?=SITE_DIR?>">
								<?$APPLICATION->IncludeComponent("bitrix:main.include", "", array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR."include/company_logo_mobile.php"), false);?>
							</a>
						</div>
						<div class="bx-inclogofooter-block">
							<div class="bx-inclogofooter-tel"><?$APPLICATION->IncludeComponent("bitrix:main.include", "", array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR."include/telephone.php"), false);?></div>
							<div class="bx-inclogofooter-worktime"><?$APPLICATION->IncludeComponent("bitrix:main.include", "", array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR."include/schedule.php"), false);?></div>
						</div>
					</div>
				</div>
			</div>
			<div class="bx-footer-bottomline">
				<div class="bx-footer-section container">
					<div class="col-sm-6"><?$APPLICATION->IncludeComponent("bitrix:main.include", "", array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR."include/copyright.php"), false);?></div>
					<div class="col-sm-6 bx-up"><a href="javascript:void(0)" data-role="eshopUpButton"><i class="fa fa-caret-up"></i> <?=GetMessage("FOOTER_UP_BUTTON")?></a></div>
				</div>
			</div>


		</footer>
		<div class="col-xs-12 hidden-lg hidden-md hidden-sm">
			<?$APPLICATION->IncludeComponent("bitrix:sale.basket.basket.line", "", array(
					"PATH_TO_BASKET" => SITE_DIR."personal/cart/",
					"PATH_TO_PERSONAL" => SITE_DIR."personal/",
					"SHOW_PERSONAL_LINK" => "N",
					"SHOW_NUM_PRODUCTS" => "Y",
					"SHOW_TOTAL_PRICE" => "Y",
					"SHOW_PRODUCTS" => "N",
					"POSITION_FIXED" =>"Y",
					"POSITION_HORIZONTAL" => "center",
					"POSITION_VERTICAL" => "bottom",
					"SHOW_AUTHOR" => "Y",
					"PATH_TO_REGISTER" => SITE_DIR."login/",
					"PATH_TO_PROFILE" => SITE_DIR."personal/"
				),
				false,
				array()
			);?>
		</div>
	</div> <!-- //bx-wrapper -->


<script>
	BX.ready(function(){
		var upButton = document.querySelector('[data-role="eshopUpButton"]');
		BX.bind(upButton, "click", function(){
			var windowScroll = BX.GetWindowScrollPos();
			(new BX.easing({
				duration : 500,
				start : { scroll : windowScroll.scrollTop },
				finish : { scroll : 0 },
				transition : BX.easing.makeEaseOut(BX.easing.transitions.quart),
				step : function(state){
					window.scrollTo(0, state.scroll);
				},
				complete: function() {
				}
			})).animate();
		})
	});
</script>
</body>
</html>