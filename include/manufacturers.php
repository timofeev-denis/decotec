<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="bx-socialsidebar">
	<div class="bx-block-title">Производители</div>
</div>

<ul class="sidebar_links">
	<?
	if(CModule::IncludeModule("iblock")) { 
		$IBLOCK_ID = 4; // инфоблок с элементами 
		$arOrder = Array("NAME"=>"ASC"); 
		$arSelect = Array("ID", "NAME"); 
		$arFilter = Array("IBLOCK_ID"=>$IBLOCK_ID, "ACTIVE"=>"Y"); 
		$res = CIBlockElement::GetList($arOrder, $arFilter, false, false, $arSelect); 

		while($ob = $res->GetNextElement()) {
			$arFields = $ob->GetFields(); 
			?>
			<li><a href="/manufacturers/detail.php?element_code=<?=$arFields['ID']?>"><?=$arFields['NAME']?></a></li>
			<?
		} 
	} 
	?>
</ul>
