<link rel="stylesheet" href="flexslider/flexslider.css" type="text/css" media="screen" />

<script src="bitrix/js/main/jquery/jquery-1.8.3.min.js"></script>
<!--
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
-->
<script defer src="flexslider/jquery.flexslider.js"></script>

<script>
// Can also be used with $(document).ready()
$(window).load(function() {
  $('.flexslider').flexslider({
    animation: "slide",
	controlNav: false
  });
});
</script>
<div class="flexslider" style="width: 100%;">
	<ul class="slides">
		<?
		$arSelect = Array( "ID", "NAME", "DATE_ACTIVE_FROM" );
		$arFilter = Array( "IBLOCK_ID"=>5, "ACTIVE"=>"Y" );
		$res = CIBlockElement::GetList( Array( "SORT"=>"ASC" ), $arFilter, false, false /*, $arSelect */ );
		while( $ob = $res->GetNextElement() ) {
			$arFields = $ob->GetFields();
			//print_r( $arFields );
			$img = CFile::ResizeImageGet($arFields["DETAIL_PICTURE"]);
			//print_r( $img);
			?>
			<li>
				<img src="<?=$img["src"]?>" title="<?=$arFields["NAME"]?>" />
			</li>			
			<?
		}
		?>
	</ul>
</div>