<?
/** @global CMain $APPLICATION */
use Bitrix\Main;
use Bitrix\Main\Loader;
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");
Loader::includeModule('iblock');
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/iblock/prolog.php");
IncludeModuleLangFile(__FILE__);

$sTableID = "tbl_iblock_reindex_admin";

$adminSort = new CAdminSorting($sTableID, 'ID', 'ASC');
$lAdmin = new CAdminList($sTableID, $adminSort);

$arHeader = array(
	array(
		"id" => "ID",
		"content" => GetMessage("IBLOCK_RADM_ID"),
		"default" => true,
		"sort" => "ID",
		"align" => "right",
	),
	array(
		"id" => "NAME",
		"content" => GetMessage("IBLOCK_RADM_NAME"),
		"sort" => "NAME",
		"default" => true,
	),
	array(
		"id" => "ACTIVE",
		"content" => GetMessage("IBLOCK_RADM_ACTIVE"),
		"sort" => "ACTIVE",
		"default" => true,
	),
	array(
		"id" => "PROPERTY_INDEX",
		"content" => GetMessage("IBLOCK_RADM_PROPERTY_INDEX"),
		"sort" => "PROPERTY_INDEX",
		"default" => true,
	),
);

$lAdmin->AddHeaders($arHeader);

$iblockFilter = array('=PROPERTY_INDEX' => array('I', 'Y'));
if (Loader::includeModule('catalog'))
{
	$OfferIblocks = array();
	$offersIterator = \Bitrix\Catalog\CatalogIblockTable::getList(array(
		'select' => array('IBLOCK_ID'),
		'filter' => array('!PRODUCT_IBLOCK_ID' => 0)
	));
	while ($offer = $offersIterator->fetch())
	{
		$OfferIblocks[] = (int)$offer['IBLOCK_ID'];
	}
	if (!empty($OfferIblocks))
	{
		unset($offer);
		$iblockFilter['!ID'] = $OfferIblocks;
	}
	unset($offersIterator, $OfferIblocks);
}

if (!isset($by))
	$by = 'ID';
if (!isset($order))
	$order = 'ASC';

$usePageNavigation = true;
if (isset($_REQUEST['mode']) && $_REQUEST['mode'] == 'excel')
{
	$usePageNavigation = false;
}
else
{
	$navyParams = CDBResult::GetNavParams(CAdminResult::GetNavSize(
		$sTableID,
		array('nPageSize' => 20, 'sNavID' => $APPLICATION->GetCurPage())
	));
	if ($navyParams['SHOW_ALL'])
	{
		$usePageNavigation = false;
	}
	else
	{
		$navyParams['PAGEN'] = (int)$navyParams['PAGEN'];
		$navyParams['SIZEN'] = (int)$navyParams['SIZEN'];
	}
}
$getListParams = array(
	'select' => array('ID', 'NAME', 'PROPERTY_INDEX', 'ACTIVE'),
	'filter' => $iblockFilter,
	'order' => array($by => $order)
);
unset($iblockFilter);
if ($usePageNavigation)
{
	$getListParams['limit'] = $navyParams['SIZEN'];
	$getListParams['offset'] = $navyParams['SIZEN']*($navyParams['PAGEN']-1);
}

if ($usePageNavigation)
{
	$countQuery = new Main\Entity\Query(\Bitrix\Iblock\IblockTable::getEntity());
	$countQuery->addSelect(new Main\Entity\ExpressionField('CNT', 'COUNT(1)'));
	$countQuery->setFilter($getListParams['filter']);
	$totalCount = $countQuery->setLimit(null)->setOffset(null)->exec()->fetch();
	unset($countQuery);
	$totalCount = (int)$totalCount['CNT'];
	if ($totalCount > 0)
	{
		$totalPages = ceil($totalCount/$navyParams['SIZEN']);
		if ($navyParams['PAGEN'] > $totalPages)
			$navyParams['PAGEN'] = $totalPages;
		$getListParams['limit'] = $navyParams['SIZEN'];
		$getListParams['offset'] = $navyParams['SIZEN']*($navyParams['PAGEN']-1);
	}
	else
	{
		$navyParams['PAGEN'] = 1;
		$getListParams['limit'] = $navyParams['SIZEN'];
		$getListParams['offset'] = 0;
	}
}
$rsIBlocks = new CAdminResult(\Bitrix\Iblock\IblockTable::getList($getListParams), $sTableID);
if ($usePageNavigation)
{
	$rsIBlocks->NavStart($getListParams['limit'], $navyParams['SHOW_ALL'], $navyParams['PAGEN']);
	$rsIBlocks->NavRecordCount = $totalCount;
	$rsIBlocks->NavPageCount = $totalPages;
	$rsIBlocks->NavPageNomer = $navyParams['PAGEN'];
}
else
{
	$rsIBlocks->NavStart();
}
// build list
$lAdmin->NavText($rsIBlocks->GetNavPrint(GetMessage("IBLOCK_RADM_IBLOCKS")));

$invalid = 0;
while($iblockInfo = $rsIBlocks->Fetch())
{
	$row = $lAdmin->AddRow($iblockInfo["ID"], $iblockInfo);

	$row->AddViewField("ID", $iblockInfo["ID"]);
	$row->AddViewField("NAME", $iblockInfo["NAME"]);
	$row->AddViewField('ACTIVE', ($iblockInfo['ACTIVE'] == 'Y' ? GetMessage('IBLOCK_RADM_ACTIVE_YES') : GetMessage('IBLOCK_RADM_ACTIVE_NO')));

	if ($iblockInfo["PROPERTY_INDEX"] == "I")
	{
		$status = 'red';
		$lamp = '<span class="adm-lamp adm-lamp-in-list adm-lamp-'.$status.'"></span>';
		$row->AddViewField("PROPERTY_INDEX", $lamp.'<a href="iblock_reindex.php?IBLOCK_ID='.urlencode($iblockInfo["ID"]).'&lang='.LANGUAGE_ID.'">'.GetMessage("IBLOCK_RADM_REINDEX").'</a>');
	}
	elseif ($iblockInfo["PROPERTY_INDEX"] == "Y")
	{
		$status = 'green';
		$lamp = '<span class="adm-lamp adm-lamp-in-list adm-lamp-'.$status.'"></span>';
		$row->AddViewField("PROPERTY_INDEX", $lamp.GetMessage("IBLOCK_RADM_INDEX_OK"));
	}

	if ($iblockInfo["PROPERTY_INDEX"] == "I")
	{
		$invalid++;

		$arActions = array(
			array(
				"ICON" => "edit",
				"TEXT" => GetMessage("IBLOCK_RADM_REINDEX"),
				"ACTION" => $lAdmin->ActionRedirect("iblock_reindex.php?IBLOCK_ID=".urlencode($iblockInfo["ID"])."&lang=".LANGUAGE_ID),
			),
		);

		$row->AddActions($arActions);
	}
}

if ($invalid)
{
	$aContext = array(
		array(
			"ICON" => "btn_new",
			"TEXT" => GetMessage("IBLOCK_RADM_REINDEX_ALL"),
			"LINK" => "iblock_reindex.php?lang=".LANGUAGE_ID,
		),
	);
	$lAdmin->AddAdminContextMenu($aContext);
}

$lAdmin->CheckListMode();

$APPLICATION->SetTitle(GetMessage("IBLOCK_RADM_TITLE"));

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_after.php");

$lAdmin->DisplayList();

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php");