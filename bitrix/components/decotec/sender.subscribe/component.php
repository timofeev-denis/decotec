<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

/** @global CMain $APPLICATION */
/** @global CUser $USER */

if(!IsModuleInstalled("sender"))
{
	ShowError(GetMessage("SENDER_SUBSCR_MODULE_NOT_INSTALLED"));
	return;
}

if(!isset($arParams["CACHE_TIME"]))
	$arParams["CACHE_TIME"] = 3600;
if($arParams["CACHE_TYPE"] == "N" || ($arParams["CACHE_TYPE"] == "A" && COption::GetOptionString("main", "component_cache_on", "Y") == "N"))
	$arParams["CACHE_TIME"] = 0;

$arParams["SHOW_HIDDEN"] = $arParams["SHOW_HIDDEN"]=="Y";
$arParams["CONFIRMATION"] = $arParams["CONFIRMATION"]!="N";
$arParams["USE_PERSONALIZATION"] = $arParams["USE_PERSONALIZATION"]!="N";

$subscr_EMAIL = '';
$arResult["~FORM_ACTION"] = $APPLICATION->GetCurPageParam('', array('sender_subscription'));
$arResult["FORM_ACTION"] = htmlspecialcharsbx($arResult["~FORM_ACTION"]);

$messageDictionary = array(
	'message_success' => array('TYPE' => 'NOTE', 'TEXT' => GetMessage("SENDER_SUBSCR_NOTE_SUCCESS")),
	'message_confirm' => array('TYPE' => 'NOTE', 'TEXT' => GetMessage("SENDER_SUBSCR_NOTE_CONFIRM")),
	'message_err_sec' => array('TYPE' => 'ERROR', 'TEXT' => GetMessage("SENDER_SUBSCR_ERR_SECURITY")),
	'message_err_email' => array('TYPE' => 'ERROR', 'TEXT' => GetMessage("SENDER_SUBSCR_ERR_EMAIL")),
);

$cookieLifeTime = time() + 60 * 60 * 24 * 30 * 12 * 10; // 30 days * 12 months * 10 ~ 10 years
$file = "/home/decotec/dekotek.ru/docs/debug.log";

if($_SERVER['REQUEST_METHOD'] == 'GET')
{	
	file_put_contents($file, "GET\n", FILE_APPEND);
	file_put_contents($file, var_export( $_GET, true ) . "\n", FILE_APPEND);
	if(isset($_GET['sender_subscription']) && isset($messageDictionary[$_GET['sender_subscription']]))
	{
		$arResult['MESSAGE'] = $messageDictionary[$_GET['sender_subscription']];
		$arResult['MESSAGE']['CODE'] = $_GET['sender_subscription'];
	}

	if(isset($_GET['tag']) && isset($_GET['sender_subscription']) && $_GET['sender_subscription']=='confirm') {
		file_put_contents($file, "_GET['tag'] IS set\n", FILE_APPEND);
		if(!CModule::IncludeModule("sender"))
		{
			$obCache->AbortDataCache();
			ShowError(GetMessage("SENDER_SUBSCR_MODULE_NOT_INSTALLED"));
			return;
		}

		try {
			file_put_contents($file, "TRY\n", FILE_APPEND);
			$arTag = \Bitrix\Main\Mail\Tracking::parseSignedTag($_REQUEST['tag']);
			if($arTag['MODULE_ID'] == 'sender' && check_email($arTag['FIELDS']['EMAIL']) && is_array($arTag['FIELDS']['MAILING_LIST']) && isset($arTag['FIELDS']['SITE_ID']))
			{
				file_put_contents($file, "    Subscription::add\n", FILE_APPEND);
				\Bitrix\Sender\Subscription::add($arTag['FIELDS']['EMAIL'], $arTag['FIELDS']['MAILING_LIST'], $arTag['FIELDS']['SITE_ID']);
				$APPLICATION->set_cookie("SENDER_SUBSCR_EMAIL", $arTag['FIELDS']['EMAIL'], $cookieLifeTime);
				$subscr_EMAIL = $arTag['FIELDS']['EMAIL'];
				unset($_SESSION['SENDER_SUBSCRIBE_LIST']);
				$arResult['MESSAGE'] = array('TYPE' => 'NOTE', 'CODE' => 'message_success');

				if($arParams['AJAX_MODE'] <> 'Y')
				{
					LocalRedirect($APPLICATION->GetCurPageParam('sender_subscription=message_success', array('sender_subscription')));
				}
			}
		} catch (\Bitrix\Main\Security\Sign\BadSignatureException $exception) {
			$arResult['MESSAGE'] = array('TYPE' => 'ERROR', 'CODE' => 'message_err_sec');
		}
	} else {
		file_put_contents($file, "_GET['tag'] is NOT set\n", FILE_APPEND);
	}
}
if($_SERVER['REQUEST_METHOD'] == 'POST' && check_bitrix_sessid() && isset($_POST['sender_subscription']) && $_POST['sender_subscription']=='add')
{
	file_put_contents($file, "POST\n", FILE_APPEND);
	file_put_contents($file, var_export( $_POST, true ) . "\n", FILE_APPEND);
	
	if(check_email($_POST["SENDER_SUBSCRIBE_EMAIL"], true))
	{
		file_put_contents($file, "check_email==true\n", FILE_APPEND);
		if(!CModule::IncludeModule("sender"))
		{
			$obCache->AbortDataCache();
			ShowError(GetMessage("SENDER_SUBSCR_MODULE_NOT_INSTALLED"));
			return;
		}

		$mailingListFromPost = array(0);
		file_put_contents($file, "1-mailingListFromPost" . var_export( $mailingListFromPost, true ) . "\n", FILE_APPEND);
		if(is_array($_POST["SENDER_SUBSCRIBE_RUB_ID"]))
		{
			foreach ($_POST["SENDER_SUBSCRIBE_RUB_ID"] as $mailingId) $mailingListFromPost[] = intval($mailingId);
		}
		file_put_contents($file, "2-mailingListFromPost" . var_export( $mailingListFromPost, true ) . "\n", FILE_APPEND);
		if( $mailingListFromPost[0] == "0" ) {
			$mailingListFromPost[0] = 1;
		}
		
		$arFilter = array("SITE_ID" => SITE_ID);
		if (!$arParams["SHOW_HIDDEN"]) $arFilter["IS_PUBLIC"] = "Y";
		$arFilter["ID"] = $mailingListFromPost;
		$mailingList = \Bitrix\Sender\Subscription::getMailingList($arFilter);
		
		file_put_contents($file, "**** mailingList: \n" . var_export( $mailingList, true ) . "\n", FILE_APPEND);
		file_put_contents($file, "**** arFilter: \n" . var_export( $arFilter, true ) . "\n", FILE_APPEND);

		$mailingIdList = array();
		
		foreach($mailingList as $mailing)
			$mailingIdList[] = $mailing['ID'];

		
			
		if($arParams["CONFIRMATION"])
		{
			file_put_contents($file, "CONFIRMATION\n", FILE_APPEND);
			// check if email already subscribed
			$sendEmailToSubscriber = true;
			if(count($mailingIdList) <= 0) {
				$mailingIdList[] = 1;
			}
			if(count($mailingIdList) > 0)
			{
				file_put_contents($file, "count(mailingIdList) > 0\n", FILE_APPEND);
				$arExistedSubscription = array();
				$subscriptionDb = \Bitrix\Sender\MailingSubscriptionTable::getList(array(
					'select' => array('EXISTED_MAILING_ID' => 'MAILING.ID'),
					'filter' => array('=CONTACT.EMAIL' => strtolower($_POST["SENDER_SUBSCRIBE_EMAIL"]), '!MAILING.ID' => null),
				));
				while(($subscription = $subscriptionDb->fetch()))
				{
					$arExistedSubscription[] = $subscription['EXISTED_MAILING_ID'];
				}

				// send if it have new subscriptions only
				if(count(array_diff($mailingIdList, $arExistedSubscription)) <= 0)
					$sendEmailToSubscriber = false;
			}
			else
			{
				file_put_contents($file, "count(mailingIdList) <= 0\n", FILE_APPEND);
				// do not send if no selected mailings and subscriber existed
				$contactDb = \Bitrix\Sender\ContactTable::getList(array('filter' => array('=EMAIL' => strtolower($_POST["SENDER_SUBSCRIBE_EMAIL"]))));
				if($contact = $contactDb->fetch())
					$sendEmailToSubscriber = false;
			}

			if($sendEmailToSubscriber) {
				file_put_contents($file, "sendEmailToSubscriber == true\n", FILE_APPEND);
				
				ob_start();
				$RUB_ID = array("1");
				$arFields = Array(
					"USER_ID" => ($USER->IsAuthorized()? $USER->GetID():false),
					"FORMAT" => ($FORMAT <> "html"? "text":"html"),
					"EMAIL" => $_POST["SENDER_SUBSCRIBE_EMAIL"],
					"ACTIVE" => "Y",
					"RUB_ID" => $RUB_ID
				);
				CModule::IncludeModule("subscribe");
				$subscr = new CSubscription;

				//can add without authorization
				$ID = $subscr->Add( $arFields );
				/*
				if( $ID > 0 ) {
					echo "id = " . $ID;
					CSubscription::Authorize($ID);
				} else {
					echo "id <= 0";
					$strWarning .= "Error adding subscription: ".$subscr->LAST_ERROR."<br>";
					echo $strWarning . "\n";
				}
				*/
				ob_end_clean();
				
				//\Bitrix\Sender\Subscription::sendEventConfirm($_POST["SENDER_SUBSCRIBE_EMAIL"], $mailingIdList, SITE_ID);
				$APPLICATION->set_cookie("SENDER_SUBSCR_EMAIL", $_POST["SENDER_SUBSCRIBE_EMAIL"], $cookieLifeTime);
				$arResult['MESSAGE'] = array('TYPE' => 'NOTE', 'CODE' => 'message_confirm');
				$subscr_EMAIL = $_POST["SENDER_SUBSCRIBE_EMAIL"];
			} else {
				file_put_contents($file, "sendEmailToSubscriber == false\n", FILE_APPEND);
				$APPLICATION->set_cookie("SENDER_SUBSCR_EMAIL", $_POST["SENDER_SUBSCRIBE_EMAIL"], $cookieLifeTime);
				$arResult['MESSAGE'] = array('TYPE' => 'NOTE', 'CODE' => 'message_success');
				$subscr_EMAIL = $_POST["SENDER_SUBSCRIBE_EMAIL"];
			}
		} else {
			file_put_contents($file, "!CONFIRMATION\n", FILE_APPEND);
			//\Bitrix\Sender\Subscription::add($_POST["SENDER_SUBSCRIBE_EMAIL"], $mailingIdList, SITE_ID);
			$APPLICATION->set_cookie("SENDER_SUBSCR_EMAIL", $_POST["SENDER_SUBSCRIBE_EMAIL"], $cookieLifeTime);
			$arResult['MESSAGE'] = array('TYPE' => 'NOTE', 'CODE' => 'message_success');
			$subscr_EMAIL = $_POST["SENDER_SUBSCRIBE_EMAIL"];
			unset($_SESSION['SENDER_SUBSCRIBE_LIST']);
		}
		//file_put_contents($file, "Subscription::add\n" . var_export($_POST, true), FILE_APPEND);
		//\Bitrix\Sender\Subscription::add($_POST["SENDER_SUBSCRIBE_EMAIL"], $mailingIdList, SITE_ID);

	} else {
		file_put_contents($file, "check_email==false\n", FILE_APPEND);
		$arResult['MESSAGE'] = array('TYPE' => 'ERROR', 'CODE' => 'message_err_email');
	}
}

if(isset($arResult['MESSAGE']) && isset($arResult['MESSAGE']['CODE']))
{
	$arResult['MESSAGE']['TEXT'] = $messageDictionary[$arResult['MESSAGE']['CODE']]['TEXT'];
}

if($_SERVER['REQUEST_METHOD'] == 'POST' && $arParams['AJAX_MODE'] <> 'Y')
{
	if(isset($arResult['MESSAGE']) && $arResult['MESSAGE']['TYPE'] == 'NOTE')
	{
		LocalRedirect(
			$APPLICATION->GetCurPageParam(
				'sender_subscription=' . $arResult['MESSAGE']['CODE'],
				array('sender_subscription')
			)
		);
	}
}

$arSubscriptionRubrics = array();
$arSubscription = array("ID"=>0, "EMAIL"=>"");
if($arParams["USE_PERSONALIZATION"])
{
	global $USER;

	//get current user subscription from cookies
	if(empty($subscr_EMAIL))
	{
		$subscr_EMAIL = $APPLICATION->get_cookie('SENDER_SUBSCR_EMAIL');
	}
	$subscr_EMAIL = strtolower(strlen($subscr_EMAIL) > 0? $subscr_EMAIL : $USER->GetParam("EMAIL"));

	if(isset($_SESSION['SENDER_SUBSCRIBE_LIST']) && is_array($_SESSION['SENDER_SUBSCRIBE_LIST']))
	{
		$arSubscription = $_SESSION['SENDER_SUBSCRIBE_LIST']['SUBSCRIPTION'];
		$arSubscriptionRubrics = $_SESSION['SENDER_SUBSCRIBE_LIST']['RUBRIC'];
	}
	else
	{
		if(!CModule::IncludeModule("sender"))
		{
			$obCache->AbortDataCache();
			ShowError(GetMessage("SENDER_SUBSCR_MODULE_NOT_INSTALLED"));
			return;
		}

		if($subscr_EMAIL <> "")
		{
			$subscriptionDb = \Bitrix\Sender\MailingSubscriptionTable::getList(array(
				'select' => array('ID' => 'CONTACT_ID', 'EMAIL' => 'CONTACT.EMAIL', 'EXISTED_MAILING_ID' => 'MAILING.ID'),
				'filter' => array('=CONTACT.EMAIL' => $subscr_EMAIL, '!MAILING.ID' => null),
			));
			while(($subscription = $subscriptionDb->fetch()))
			{
				$arSubscription = $subscription;

				//get user's newsletter categories
				if(intval($subscription['EXISTED_MAILING_ID'])>0)
					$arSubscriptionRubrics[] = $subscription['EXISTED_MAILING_ID'];
			}
		}

		$_SESSION['SENDER_SUBSCRIBE_LIST']['SUBSCRIPTION'] = $arSubscription;
		$_SESSION['SENDER_SUBSCRIBE_LIST']['RUBRIC'] = $arSubscriptionRubrics;
	}
}


//page title
if($arParams["SET_TITLE"]=="Y")
{
	$APPLICATION->SetTitle(GetMessage("SENDER_SUBSCR_TITLE"), array('COMPONENT_NAME' => $this->GetName()));
}

//get site's newsletter categories
$obCache = new CPHPCache;
$strCacheID = LANG.$arParams["SHOW_HIDDEN"];
if($obCache->StartDataCache($arParams["CACHE_TIME"], $strCacheID, "/".SITE_ID.$this->GetRelativePath()))
{
	if(!CModule::IncludeModule("sender"))
	{
		$obCache->AbortDataCache();
		ShowError(GetMessage("SENDER_SUBSCR_MODULE_NOT_INSTALLED"));
		return;
	}

	$arFilter = array("SITE_ID" => SITE_ID);
	if(!$arParams["SHOW_HIDDEN"]) $arFilter["IS_PUBLIC"]="Y";
	$mailingList = \Bitrix\Sender\Subscription::getMailingList($arFilter);

	$obCache->EndDataCache($mailingList);
}
else
{
	$mailingList = $obCache->GetVars();
}

if(strlen($_REQUEST["SENDER_SUBSCRIBE_EMAIL"])>0)
	$arResult["EMAIL"] = htmlspecialcharsbx($_REQUEST["SENDER_SUBSCRIBE_EMAIL"]);
elseif(strlen($arSubscription["EMAIL"])>0)
	$arResult["EMAIL"] = htmlspecialcharsbx($arSubscription["EMAIL"]);
else
	$arResult["EMAIL"] = "";

if(!is_array($mailingList)) $mailingList = array();
$arResult["RUBRICS"] = array();
foreach($mailingList as $mailing)
{
	$bChecked = (
		// user is already subscribed
		!is_array($_REQUEST["SENDER_SUBSCRIBE_RUB_ID"]) && in_array($mailing["ID"], $arSubscriptionRubrics) ||
		// or there is no information about user subscription
		!is_array($_REQUEST["SENDER_SUBSCRIBE_RUB_ID"]) && intval($arSubscription["ID"])==0 ||
		// or user has checked the category and posted the form
		is_array($_REQUEST["SENDER_SUBSCRIBE_RUB_ID"]) && in_array($mailing["ID"], $_REQUEST["SENDER_SUBSCRIBE_RUB_ID"])
	);

	$arResult["RUBRICS"][]=array(
		"ID"=>$mailing["ID"],
		"NAME"=>$mailing["NAME"],
		"DESCRIPTION"=>$mailing["DESCRIPTION"],
		"CHECKED"=>$bChecked,
	);
}

$this->IncludeComponentTemplate();
?>