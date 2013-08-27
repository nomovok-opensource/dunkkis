<?php 

/** Dunkkis Web User Interface
  * ==========================
  * 
  * Copyright (c) 2009-2010 Nomovok Ltd
  * This software is licensed under The MIT License. See LICENSE for details.
  */

// Disable caching.
ob_implicit_flush( true );
while (@ob_end_flush());

session_start(); 

include "ds-db.php";
include "ds-language.php";
include "ds-accesscontrol.php";
include "pChart/pData.class.php";
include "pChart/pChart.class.php";
include "ds-validator.php";
include "ds-profilemanagement.php"; 
include "includes/ds-alarm-constants.inc.php";
include "ds-alarmmanagement.php";
include( "ds-latest-measurements.php" );

if (strlen($_POST['simplelayout'])>0)
{
	$_SESSION['simplelayout'] = $_POST['simplelayout'];
}
if ($_SESSION['simplelayout'] == 'on')
{
	$mobile_layout = TRUE;
}

/** @brief Creates a button for management actions.
  * @param text, (string) Button caption.
  * @param action, (string) The demo.php method to be called.
  * @param pName, (string) Name of param supplied with request.
  * @param pvalue, (string) Value of param supplied with request.
  * @param pName2, (string) Name of additional param supplied with request.
  * @param pValue2, (variant) Value of additional param supplied with request.
  * @return XHTML.
  */
function manageButton( $text, $action, $pName, $pValue, $pName2 = Null, $pValue2 = Null ) 
{

    $content = ""; // Result variable.

    $content .= '<form name="'.$action.'" method="post" action="demo.php" class="ActionTable">
                 <input type="hidden" name="method" value="'.$action.'" />
                 <input type="hidden" name="'.$pName.'" value="'.$pValue.'" />';

    // Add additional parameter, if defined.
    if( $pName2 != Null && $pValue2 != Null ) {
        $content .= '<input type="hidden" name="'.$pName2.'" value="'.$pValue2.'" />';
    }

    $content .= '<input type="submit" value="'.$text.'" class="Button" />
                 </form>';

    return $content;

}

/** @brief Creates a button for management actions.
  * @param text, (string) Button caption.
  * @param action, (string) The demo.php method to be called.
  * @param pName, (string) Name of param supplied with request.
  * @param pvalue, (string) Value of param supplied with request.
  * @param pName2, (string) Name of additional param supplied with request.
  * @param pValue2, (variant) Value of additional param supplied with request.
  * @return XHTML.
  */
function manageButtonImg( $image, $size, $text, $action, $action2, $pName, $pValue, $pName2 = Null, $pValue2 = Null ) 
{

    $content = ""; // Result variable.

    $content .= "<form name='".$action."' method='post' action='demo.php' class='ManagementButton'>
                 <input type='hidden' name='method' value='".$action."' />
                 <input type='hidden' name='".$action2."' />
                 <input type='hidden' name='".$pName."' value='".$pValue."' />";

    // Add additional parameter, if defined.
    if( $pName2 != Null && $pValue2 != Null ) {
        $content .= "<input type='hidden' name='".$pName2."' value='".$pValue2."' />";
    }

    $content .= "<button type='submit' class='Button' title='".$text."' />
                 <img src='".$image."' height='".$size."' width='".$size."' alt='".$text."' />
                 </button></form>";

    return $content;

}

/** @brief Creates a confirmation message.
  * @param actionYes, (string) The demo.php method to be called on "Yes".
  * @param actionNo, (string) The demo.php method to be called on "No".
  * @param pName, (string) Name of param supplied with request.
  * @param pvalue, (string) Value of param supplied with request.
  * @return XHTML.
  */
function confirmation( $message, $actionYes, $actionNo, $pName, $pValue )
{

    $content = "<div class='DunkkisConfirmation'>".$message." 
                <form name='".$actionYes."' method='post' action='demo.php' class='ActionTable'>
                <input type='hidden' name='method' value='".$actionYes."' />
                <input type='hidden' name='".$pName."' value='".$pValue."' />
                <input type='submit' value='".DS_STRING_YES."' class='Button' />
                </form>
                <form name='".$actionNo."' method='post' action='demo.php' class='ActionTable'>
                <input type='hidden' name='method' value='".$actionNo."' />
                <input type='submit' value='".DS_STRING_NO."' class='Button' />
                </form></div>";
    return $content;

}

/**
 * page_header
 * Generates page header.
 */
function page_header() {

	global $mobile_layout;

	echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-gb" lang="en-gb">

		<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="robots" content="index, follow" />
		<title>dunkkis.org - demo</title>
		<link href="favicon.ico" rel="shortcut icon" type="image/x-icon" />';

	echo initializeJavaScript();

    echo '<script type="text/javascript" src="js/mootools.js"></script>
		<script type="text/javascript" src="js/alarm.js"></script>
		<script type="text/javascript" src="js/hide.js"></script>
		<script type="text/javascript" src="js/dunkkis.js"></script>
		<script type="text/javascript" src="js/language.js"></script>	
		<script type="text/javascript" src="js/picture.js"></script>';

	if ($mobile_layout) //Style sheet selection, normal/mobile
	{
		echo '<!-- mobile layout -->
			<link rel="stylesheet" href="css/mobile_system.css" type="text/css" />
			<link rel="stylesheet" href="css/mobile_general.css" type="text/css" />
			<link rel="stylesheet" href="css/mobile_template.css" type="text/css" />';
	}
	else
	{
		echo '<link rel="stylesheet" href="css/system.css" type="text/css" />
			<link rel="stylesheet" href="css/general.css" type="text/css" />
			<link rel="stylesheet" href="css/dunkkis.css" type="text/css" />
			<link rel="stylesheet" href="css/picture.css" type="text/css" />
			<link rel="stylesheet" href="css/template.css" type="text/css" />';
	}
	echo '<script language="javascript" type="text/javascript" src="js/ja.script.js"></script>

		<script language="javascript" type="text/javascript">
		var rightCollapseDefault=\'show\';
	var excludeModules=\'38\';
	</script>

		<link rel="stylesheet" href="css/menu.css" type="text/css" />


		<link rel="stylesheet" href="css/style.css" type="text/css" />

		<!--[if gte IE 7.0]>
		<style type="text/css">
		.clearfix {display: inline-block;}
	</style>
		<![endif]-->

		<style type="text/css">
#ja-header,#ja-mainnav,#ja-container,#ja-botsl,#ja-footer {width: 100%;margin: 0 auto;}
#ja-wrapper {min-width: 100%;}

		</style>
		</head>

		<body id="bd" class="fs4 FF" >
		<div id="ja-wrapper">';
}

/**
 * page_footer
 * Generates page footer.
 */
function page_footer() {

	echo '<!-- BEGIN: FOOTER -->
		<div id="ja-footerwrap">
		<font color="#B22222">'.DS_STRING_LOGIN_DISCLAIMER.'</font>
		<br />'.DS_STRING_LOGIN_INFO.'</i></font>
		<div id="ja-footer" class="clearfix">
		<br />
		</div>
		</div>
		<!-- END: FOOTER -->';

}

/**
 * help_box
 * Generates a help box.
 * @param caption: string Help box caption.
 * @param body: string Help box content.
 * @return Returns the HTML code generated.
 */
function help_box($caption, $body) {
    $content = "<div class=\"teaser\">";
    $content .= "<h3>".$caption."</h3>";
    $content .= "<p>".$body."</p>";
    $content .= "</div>";
    return $content;
}

/**
 * page_tail
 * Generates page tail.
 */
function page_tail() {
	echo "</div>";
	echo "</body>";
	echo "</html>";
}

/**
 * menu_item
 * Generates an item for the navigation menu.
 * @param menumsg: string Menu item text.
 * @param method: string Menu item method.
 * @param class: string Menu item class.
 */
function menu_item($menumsg, $method, $class) {
	//echo "<li id=\"current\" class=\"", $class, "\">";
	echo "<li class=\"", $class, "\">";
	echo "<a href=\"?method=", $method, "\">";
	echo "<span>", $menumsg, "</span>";
	echo "</a></li>";
}

/**
 * show_menu
 * Generates the navigation menu.
 */
function show_menu() {
	// Add menu features here
	echo "<ul class=\"menu\">";
	menu_item(DS_STRING_NAV_MENU_MEASUREMENT, "current", "active item1");
	//menu_item("Draw statistic", "statistic", "active item1");
	//menu_item("Manage boards", "boards", "active item1");
	menu_item(DS_STRING_NAV_MENU_DEVICES, "macdevices", "active item1");
	

	menu_item(constant("DS_STRING_ALARM_MENU"), constant("DS_VAR_ALARM_MAINPAGE"), "active item1");
	
	menu_item(DS_STRING_NAV_MENU_PROFILES, "addnewprofile", "active item1");
	//menu_item("Board management", "boardmanagement", "active item1");
	menu_item(DS_STRING_NAV_MENU_ACCOUNT, DS_MNG_USER_ACCOUNT, "active item1");
	//If user has admin role the menu is different
	$user = $_SESSION["user"];
	$isAdmin = db_get_user_role($user);
	if ( $isAdmin ) {
		menu_item(DS_STRING_NAV_MENU_ADMIN, "admin", "active item2");
	}
	menu_item(DS_STRING_NAV_MENU_LOGOUT, "logout", "active item1");
	echo "</ul>";

    show_language_menu( $_SESSION['ds_language'] );

}

/**
 * main_screen
 * Generates the main page.
 * @param title: string Page title.
 * @param content: string Page content.
 * @param helpTitle: string Help box title. If both help box title and help box content are empty the help box is not displayed.
 * @param helpContent: string Help box content. If both help box title and help box content are empty the help box is not displayed.
 */
function main_screen($title="", $content="", $helpTitle="", $helpContent="") {
	global $mobile_layout;

	echo '
		<!-- BEGIN: HEADER -->
		<div id="ja-headerwrap">
		<div id="ja-header" class="clearfix" style="background: url(images/header2.png) top left;">
		<div class="ja-headermask">&nbsp;
	</div>
		<h1 class="logo-text">
		<a href="/index.php" title="dunkkis.org"><span></span></a>
		</h1>
		<p class="site-slogan">'
        .DS_STRING_MAIN_SLOGAN.
        '</p>

		<ul class="ja-usertools-font">
		<li><img style="cursor: pointer;" title="'.DS_STRING_MAIN_INC_FONT.'" src="images/user-increase.png" alt="'.DS_STRING_MAIN_INC_FONT.'" id="ja-tool-increase" onclick="switchFontSize(\'ja_purity_ja_font\',\'inc\'); return false;" /></li> <li><img style="cursor: pointer;" title="Default font size" src="images/user-reset.png" alt="Default font size" id="ja-tool-reset" onclick="switchFontSize(\'ja_purity_ja_font\',4); return false;" /></li>
		<li><img style="cursor: pointer;" title="'.DS_STRING_MAIN_DEC_FONT.'" src="images/user-decrease.png" alt="'.DS_STRING_MAIN_DEC_FONT.'" id="ja-tool-decrease" onclick="switchFontSize(\'ja_purity_ja_font\',\'dec\'); return false;" /></li>
		</ul>
		<script type="text/javascript">var CurrentFontSize=parseInt(\'4\');</script>	
		</div>
		</div>
		<!-- END: HEADER -->

		<div id="ja-containerwrap-fr">
		<div id="ja-containerwrap2">
		<div id="ja-container">
		<div id="ja-container2" class="clearfix">
		<div id="ja-mainbody-fr" class="clearfix">
		<!-- BEGIN: CONTENT -->
		<div id="ja-contentwrap">
		<div id="ja-content">
		<div class="componentheading">';

	echo $title;

	echo '					</div>
		<table class="blog" cellpadding="0" cellspacing="0">
		<tr>
		<td valign="top">
		<div>
		<div class="contentpaneopen">
		<div class="article-content">';

	echo $content;

	echo '
		</div>
        </div>
		<span class="article_separator">&nbsp;</span>
		</div>
		</td>';

    if ($helpTitle != "" && $helpContent != "") {

        echo '
            <!-- BEGIN: HELP BOX -->
            <td valign="top" style="width:460px">
            '.help_box($helpTitle, $helpContent).'
            </td>
            <!-- END: HELP BOX -->';
    }

    echo '
		</tr>
		</table>
		</div>
		</div>
		<!-- END: CONTENT -->
        <!-- BEGIN: LEFT COLUMN -->
		<div id="ja-col1">
		<div class="moduletable_menu">';

	show_menu();

	echo '
		</div><br />
		<!-- END: LEFT COLUMN -->
		</div>
		</div>
		</div>
		</div>
		</div>
		</div>';
}

/**
 * show_mainpage
 * Generates main page for a specified user.
 * @param user: string User name.
 */
function show_mainpage($user) {

	
	$content = "";
	$temperature = db_get_latest_data_by_type(DS_SENSOR_TYPE_TEMPERATURE);
	$humidity = db_get_latest_data_by_type(DS_SENSOR_TYPE_HUMIDITY);
	$pressure = db_get_latest_data_by_type(DS_SENSOR_TYPE_PRESSURE);

	$content .= '<div class="latest">';

	$content .= '<div class="latest_sensor">';
	$content .= '<div class="latest_sensor_name">';
	$content .= DS_STRING_MAIN_TEMPERATURE;
	$content .= '</div>'; //div latest_temp_sensor
	$content .= '<div class="latest_sensor_name">';
	$content .= DS_STRING_MAIN_HUMIDITY;
	$content .= '</div>'; //div latest_humidity_sensor
	$content .= '<div class="latest_sensor_name">';
	$content .= DS_STRING_MAIN_AIR_PRESSURE;
	$content .= '</div>'; //div latest_pressure_sensor
	$content .= '</div>'; //div latest_sensor

	$content .= '<div class="latest_value">';
	$content .= '<div class="latest_sensor_value">';
	$content .= '<i>' . $temperature[0]["value"] . ' ⁰C</i>';
	$content .= '</div>'; //div latest_temp_sensor
	$content .= '<div class="latest_sensor_value">';
	$content .= '<i>' . $humidity[0]["value"] . ' %</i>';
	$content .= '</div>'; //div latest_humidity_sensor
	$content .= '<div class="latest_sensor_value">';
	$content .= '<i>' . $pressure[0]["value"] . ' mbar</i>';
	$content .= '</div>'; //div latest_pressure_sensor
	$content .= '</div>'; //div latest_sensor

	$content .= '</div>'; //div latest
	$content .= '';

	$content .= latestMeasurementsMenu();

	main_screen(DS_STRING_MAIN_LATEST_MEASUREMENTS, $content, DS_STRING_HELP_CAPTION_LATEST_MEASUREMENTS, DS_STRING_HELP_CONTENT_LATEST_MEASUREMENTS);
}

/** Shows a message box.
  * @param id, (string) Unique XHTML identifier for the box.
  * @param message, (string) Message to be shown in the box.
  *
  * @note This functionality depends on the browser and WWW server used and
  *       thus may not work on all platforms.
  */
function messageBox( $id, $message )
{

    echo( "<div class='MessageBox' id='".$id."'>".$message."</div>" );

}


/** Shows or hides a message box.
  * @param id, (string) Unique XHTML identifier of the box.
  * @param show, (boolean) Whether to show the the box or not.
  *
  * @note This functionality depends on the browser and WWW server used and
  *       thus may not work on all platforms.
  */
function showMessageBox( $id, $show )
{

    if( $show ) {
        echo "<script type='text/javascript'>showMessageBox('".$id."', true);</script>";
    }
    else {
        echo "<script type='text/javascript'>showMessageBox('".$id."', false);</script>";
    }

}

if ($_REQUEST['method'] == 'language') {
    set_language( $_REQUEST['language'] );
}
else {
    set_session_language( $_SESSION['ds_language'] );
}

page_header();

// User logged in.
if ($_SESSION['login'] == true) {


	$alarm_id = constant("DS_VAR_ALARM_ID");//".$_SESSION['ds_language']);
	$schedule_id = constant("DS_VAR_ALARM_SCHEDULE_ID");// _".$_SESSION['ds_language']);

	if ($_REQUEST['method'] == 'current') 
	{
		show_mainpage($_SESSION['user']);
	}

    // Latest measurements
    elseif( $_REQUEST['method'] == DS_LATEST_SHOW ) {

        // Try to show message box. Might not work on all browsers.
        messageBox( "pleasewait", DS_STRING_MSG_WAIT_LOAD ); 
        showMessageBox( "pleasewait", true );

        $device = explode( "#", $_REQUEST['device'] );

        $content .= latestMeasurementsMenu();
        $content .= latestMeasurementsView( $device[0],
                                            $device[1], 
                                            $_REQUEST['period'],
                                            $_SESSION['userid'] );

        main_screen( DS_STRING_MAIN_CAPTION_STATISTICS, 
                     $content, 
                     DS_STRING_HELP_CAPTION_STATISTICS, 
                     DS_STRING_HELP_CONTENT_STATISTICS );

        // Hide message box after done.
        showMessageBox( "pleasewait", false );

    }

    // Logout
    elseif( $_REQUEST['method'] == 'logout' ) {
        $_SESSION['login'] = false;
        $_SESSION['simplelayout'] = 'off';
        print( loginPage() );
    }

    // My Account
    elseif( $_REQUEST['method'] == "account" ) {

        $content = myAccountPage();
        main_screen( DS_STRING_USER_ACCOUNT_CAPTION, 
                     $content, 
                     DS_STRING_USER_ACCOUNT_CAPTION, 
                     DS_STRING_USER_ACCOUNT_HELP );

    }
    elseif( $_REQUEST['method'] == DS_MNG_USER_ACCOUNT_CHANGEPW ) {

        $content = myAccountPage( changePassword( $_SESSION['userid'],
                                                  $_REQUEST['currentpwd'],
                                                  $_REQUEST['newpwd'],
                                                  $_REQUEST['confirmpwd'] ) );
        main_screen( DS_STRING_USER_ACCOUNT_CAPTION, 
                     $content, 
                     DS_STRING_USER_ACCOUNT_CAPTION, 
                     DS_STRING_USER_ACCOUNT_HELP );

    }
    elseif( $_REQUEST['method'] == DS_MNG_USER_ACCOUNT_REMOVE_CONFIRM ) {

        $content = userRemoveConfirmation( $_SESSION['userid'], true );
        main_screen( DS_STRING_USER_ACCOUNT_CAPTION, 
                     $content, 
                     DS_STRING_USER_ACCOUNT_CAPTION, 
                     DS_STRING_USER_ACCOUNT_HELP );

    }
    elseif( $_REQUEST['method'] == DS_MNG_USER_ACCOUNT_REMOVE ) {

        $result = dbRemoveUser( $_SESSION['userid'] );
        if( $result == DS_MNG_USER_REMOVE_SUCCESS ) {
            $_SESSION['login'] = false;
            $_SESSION['simplelayout'] = 'off';
            print( loginPage() );
        }
        else {
            $content = myAccountPage( DS_MNG_USER_ACCOUNT_REMOVE_FAILED );
            main_screen( DS_STRING_USER_ACCOUNT_CAPTION, 
                         $content, 
                         DS_STRING_USER_ACCOUNT_CAPTION, 
                         DS_STRING_USER_ACCOUNT_HELP );
        }

    }

    // Admin
    elseif( $_REQUEST['method'] == "admin" ) {
        
        $content = admin_main_menu();
        main_screen( DS_STRING_MAIN_CAPTION_MANAGE_USERS, 
                     $content, 
                     DS_STRING_HELP_CAPTION_ADMIN, 
                     DS_STRING_HELP_CONTENT_ADMIN );

    }

    // Admin - User management
    elseif( $_REQUEST['method'] == DS_MNG_USER_USERS ) {

        $content = userManagementPage();
        main_screen( DS_STRING_USER_USERS_CAPTION, 
                     $content, 
                     DS_STRING_USER_USERS_CAPTION, 
                     DS_STRING_USER_USERS_HELP );

    }
    elseif( $_REQUEST['method'] == DS_MNG_USER_TOGGLE_STATUS ) {

        $content .= userManagementPage( dbToggleUserStatus( $_REQUEST['uid'] ) );
        main_screen( DS_STRING_USER_USERS_CAPTION, 
                     $content, 
                     DS_STRING_USER_USERS_CAPTION, 
                     DS_STRING_USER_USERS_HELP );

    }
    elseif( $_REQUEST['method'] == DS_MNG_USER_TOGGLE_ROLE ) {

        $content .= userManagementPage( dbToggleUserRole( $_REQUEST['uid'] ) );
        main_screen( DS_STRING_USER_USERS_CAPTION, 
                     $content, 
                     DS_STRING_USER_USERS_CAPTION, 
                     DS_STRING_USER_USERS_HELP );

    }
    elseif( $_REQUEST['method'] == DS_MNG_USER_REMOVE_CONFIRM ) {

        $content .= userRemoveConfirmation( $_REQUEST['uid'] );
        main_screen( DS_STRING_USER_USERS_CAPTION, 
                     $content, 
                     DS_STRING_USER_USERS_CAPTION, 
                     DS_STRING_USER_USERS_HELP );

    }
    elseif( $_REQUEST['method'] == DS_MNG_USER_REMOVE ) {

        $content .= userManagementPage( dbRemoveUser( $_REQUEST['uid'] ) );
        main_screen( DS_STRING_USER_USERS_CAPTION, 
                     $content, 
                     DS_STRING_USER_USERS_CAPTION, 
                     DS_STRING_USER_USERS_HELP );

    }

    // Admin - Account request management
    elseif( $_REQUEST['method'] == DS_MNG_USER_REQUESTS ) {

        $content .= accountRequestsPage();
        main_screen( DS_STRING_USER_REQUESTS_CAPTION, 
                     $content, 
                     DS_STRING_USER_REQUESTS_CAPTION, 
                     DS_STRING_USER_REQUESTS_HELP );

    }
    elseif( $_REQUEST['method'] == DS_MNG_USER_APPROVE_REQUEST ) {

        $content .= accountRequestsPage( approveRequest( $_REQUEST['uid'],
                                                         $_REQUEST['email'] ) );
        main_screen( DS_STRING_USER_REQUESTS_CAPTION, 
                     $content, 
                     DS_STRING_USER_REQUESTS_CAPTION, 
                     DS_STRING_USER_REQUESTS_HELP );

    }
    elseif( $_REQUEST['method'] == DS_MNG_USER_DECLINE_REQUEST_CONFIRM ) {

        $content .= requestDeclineConfirmation( $_REQUEST['uid'] );
        main_screen( DS_STRING_USER_REQUESTS_CAPTION, 
                     $content, 
                     DS_STRING_USER_REQUESTS_CAPTION, 
                     DS_STRING_USER_REQUESTS_HELP );

    }
    elseif( $_REQUEST['method'] == DS_MNG_USER_DECLINE_REQUEST ) {

        $content .= accountRequestsPage( declineRequest( $_REQUEST['uid'],
                                                         $_REQUEST['email'] ) );
        main_screen( DS_STRING_USER_REQUESTS_CAPTION, 
                     $content, 
                     DS_STRING_USER_REQUESTS_CAPTION, 
                     DS_STRING_USER_REQUESTS_HELP );

    }


	/* **************************
	 * alarm management
	 * @author Lars Kinnunen - lars.kinnunen@nomovok.com
	 * */

	else if($_REQUEST['method']==constant("DS_VAR_ALARM_MAINPAGE") &&
			isset($_SESSION['user']) ) {

		
		if (isset($_REQUEST[$alarm_id])) { 
			$content = alarm_management_page($_REQUEST[$alarm_id]); 
		} else { 
			$content = alarm_management_page(); }
		main_screen(constant("DS_STRING_ALARM_MAINPAGE"), $content, DS_STRING_HELP_CAPTION_ALARM_MAIN, DS_STRING_HELP_CONTENT_ALARM_MAIN);
	}

	else if($_REQUEST['method']==constant("DS_VAR_ALARM_SETTINGS_PAGE") && 
			isset($_SESSION['user'])) {
		
		if (isset($_REQUEST[$alarm_id])) { 
			$content = alarm_settings_page($_REQUEST[$alarm_id]); 
		} else { 
			$content = alarm_settings_page(); }
        if( isset($_REQUEST[DS_VAR_ALARM_NEW] ) ) {
		main_screen(DS_STRING_ALARM_NEW_ALARM, $content, DS_STRING_HELP_CAPTION_ALARM_SETTINGS, DS_STRING_HELP_CONTENT_ALARM_SETTINGS);
        } else {
		main_screen(constant("DS_STRING_ALARM_SETTINGS_PAGE"), $content, DS_STRING_HELP_CAPTION_ALARM_SETTINGS, DS_STRING_HELP_CONTENT_ALARM_SETTINGS);
        }
	}

	else if($_REQUEST['method']==constant("DS_VAR_ALARM_SCHEDULE_PAGE") && 
			isset($_SESSION['user']) &&
			isset($_REQUEST[$alarm_id])) {
				
		$heading = constant("DS_STRING_ALARM_SCHEDULE_PAGE");

		if (isset($_REQUEST[$schedule_id])) {
			$content = alarm_schedule_page($_REQUEST[$alarm_id], $_REQUEST[$schedule_id]);
			if( $_REQUEST[$schedule_id] == -1 ) {
				$heading = constant("DS_STRING_ALARM_NEW_SCHEDULE_PAGE");
			}
			else if( !isset( $_REQUEST[constant("DS_VAR_ALARM_DELETE")] ) &&
				!isset( $_REQUEST[constant("DS_VAR_ALARM_APPEND")] ) &&
				!isset( $_REQUEST[constant("DS_VAR_ALARM_CONFIRMED")] ) &&
				!isset( $_REQUEST[constant("DS_VAR_ALARM_REMOVE")] )) {
				$heading = constant("DS_STRING_ALARM_EDIT_SCHEDULE_PAGE");
			}
			
		} else {
			$content = alarm_schedule_page($_REQUEST[$alarm_id]); }
		main_screen($heading, $content, DS_STRING_HELP_CAPTION_ALARM_SCHEDULE, DS_STRING_HELP_CONTENT_ALARM_SCHEDULE);
	}

	else if($_REQUEST['method']==constant("DS_VAR_ALARM_SENSORS_PAGE") && 
			isset($_SESSION['user']) &&
			isset($_REQUEST[$alarm_id])) {

		$content = alarm_sensors_page($_REQUEST[$alarm_id]);
		main_screen(constant("DS_STRING_ALARM_SENSORS_PAGE"), $content, DS_STRING_HELP_CAPTION_ALARM_SENSORS, DS_STRING_HELP_CONTENT_ALARM_SENSORS);
	}

	else if($_REQUEST['method']==constant("DS_VAR_ALARM_CONTACTS_PAGE") && 
			isset($_SESSION['user']) &&
			isset($_REQUEST[$alarm_id])) {

		$content = alarm_contacts_page($_REQUEST[$alarm_id]);
		main_screen(constant("DS_STRING_ALARM_CONTACTS_PAGE"), $content, DS_STRING_HELP_CAPTION_ALARM_CONTACTS, DS_STRING_HELP_CONTENT_ALARM_CONTACTS);
	}

	else if($_REQUEST['method']==constant("DS_VAR_ALARM_HISTORY_PAGE") && 
			isset($_SESSION['user']) ) {

		if ( isset($_REQUEST[$alarm_id]) ) {
			$content = alarm_history_page($_REQUEST[$alarm_id]);
		} else {
			$content = alarm_history_page(); }
		main_screen(constant("DS_STRING_ALARM_HISTORY_PAGE"), $content, DS_STRING_HELP_CAPTION_ALARM_HISTORY, DS_STRING_HELP_CONTENT_ALARM_HISTORY);
	}


	/* **************************
	 * profile management things 
	 * */
	else if($_REQUEST['method']=='macdevices' && 
			isset($_SESSION['user']) ) {
		$content = mac_device_management_page();
		main_screen(DS_STRING_MAIN_CAPTION_MAC_DEVS, $content, DS_STRING_HELP_CAPTION_DEV_MAIN, DS_STRING_HELP_CONTENT_DEV_MAIN);
	}

	/* create profile page */
	else if($_REQUEST['method']=='addnewprofile' && 
			isset($_SESSION['user']) ) {
		$content .= profile_management_form_create($_SESSION['user']);
		$content .= device_list($_SESSION['user']);
		main_screen(DS_STRING_MAIN_CAPTION_PROFILES, $content, DS_STRING_HELP_CAPTION_PROF_MAIN, DS_STRING_HELP_CONTENT_PROF_MAIN);
	}

	/* profile created */
	else if(isset($_REQUEST['profileformcreate']) && 
			isset($_SESSION['user']) ) {
		
		if( empty($_POST['profilename']) ) {
			$info .= "<p style=\"color: red\">".DS_STRING_PROF_MNG_PROFILE_NAME_EMPTY."</p>\n";
		}
		if( (strlen($_POST['profilepw']) < 6) ||
		    $_POST['profilepw'] != $_POST['profilepw2'] ) {
			$info .= "<p style=\"color: red\">".DS_STRING_PROF_MNG_PWD_MISMATCH_OR_SHORT."</p>\n";
		}
		if( empty($info) ) {
			$profileowner = $_POST['profileowner'];
			$profilename  = stripslashes( $_POST['profilename'] );
			$passwd       = $_POST['profilepw'];
            
            if (profile_exists($profileowner, $profilename)) {
                $info = "<p style=\"color: red\">".DS_STRING_PROF_MNG_PROFILE_EXISTS."</p>\n";
            } else {
                $content .= create_profile($profileowner,$profilename,$passwd);
    			$info = "<p style=\"color: green\">".DS_STRING_PROF_MNG_CREATE_SUCC."</p>";
            }
		}            
		$content .= $info . profile_management_form_create($_SESSION['user']);
		$content .= device_list($_SESSION['user']);
		main_screen(DS_STRING_MAIN_CAPTION_PROFILES, $content, DS_STRING_HELP_CAPTION_PROF_MAIN, DS_STRING_HELP_CONTENT_PROF_MAIN);
	}
	
	else if($_REQUEST['method']=='profileedit' && 
			isset($_SESSION['user']) ) {
		$id = $_REQUEST['profile'];
		$content = profile_management_page();
		main_screen(DS_STRING_MAIN_CAPTION_PROFILES, $content, DS_STRING_HELP_CAPTION_PROF_MAIN, DS_STRING_HELP_CONTENT_PROF_MAIN);
	}
	else if($_REQUEST['method']=='profileremove' && 
			isset($_SESSION['user']) ) {
		//echo "X: ".$_REQUEST['profile'];	
		if (!db_remove_profile($_SESSION['user'], $_REQUEST['profile'])) {
			$content = "<p style=\"color: green\">".DS_STRING_PROF_MNG_PROFILE_REMOVED_BEGIN.$_REQUEST['profile'].DS_STRING_PROF_MNG_PROFILE_REMOVED_END."</p>";
		} else { 
			$content = "<p style=\"color: red\">".DS_STRING_PROF_MNG_PROFILE_REMOVE_ERROR_BEGIN.$_REQUEST['profile'].DS_STRING_PROF_MNG_PROFILE_REMOVE_ERROR_END."</p>";
		}
		$content .= profile_management_form_create($_SESSION['user']);
		$content .= profile_create_page($_SESSION['user']);
	
		main_screen(DS_STRING_MAIN_CAPTION_PROFILES, $content, DS_STRING_HELP_CAPTION_PROF_MAIN, DS_STRING_HELP_CONTENT_PROF_MAIN);
	}

	/* remove dunkkis box - save data */
	else if($_REQUEST['method']=='removedunkkisbox' && 
			isset($_SESSION['user']) ) {
		$dboxid = $_REQUEST['dunkkisbox'];
		$dboxmac = $_REQUEST['mac'];
		$dboxname = $_REQUEST['name'];
		if( 0 == db_remove_mac_from_user($dboxid) ) {
			$content .= "<p style=\"color: red\">".DS_STRING_DEV_MNG_DEV_REM_ERR."</p>";
		} else {
			$content .= "<p style=\"color: green\">".DS_STRING_DEV_MNG_DEV_REM_SUCC."</p>";
		}
		$content .= mac_device_management_page();
		main_screen(DS_STRING_MAIN_CAPTION_MAC_DEVS, $content, DS_STRING_HELP_CAPTION_DEV_MAIN, DS_STRING_HELP_CONTENT_DEV_MAIN);
	}

	/* add dbox form */
	else if(($_REQUEST['method']=='addnewmac') && isset($_SESSION['user']) ) {
				main_screen(DS_STRING_MAIN_CAPTION_DEV_ADD, mac_device_management_page(), DS_STRING_HELP_CAPTION_DEV_ADD, DS_STRING_HELP_CONTENT_DEV_ADD);
	}	
	/* adding dunkkis box, MAC address */
	else if(($_REQUEST['method']=='addmac') && isset($_SESSION['user']) ) {
		$mac = $_POST['addmacaddr']; 
		$name = stripslashes( $_POST['addmacname'] );
		$uid = db_get_userid($_SESSION['user']);
		$content ='';

		if( !empty($mac) && !empty($name) ) {
                                if(add_mac_check($mac) ) {
					if( db_is_mac_free($mac, $_SESSION['userid']) ) {
						/* free mac, take in use and bind to user */
						if( db_add_mac_to_user($uid,$mac,$name) ) {
							$content .= "<p style=\"color: green\">".DS_STRING_MAC_MNG_BIND_TO_USER_SUCC. $_SESSION['user'];
							$content .= "<br />". $mac . DS_STRING_MAC_MNG_BIND_TO_USER_AS .$name."</p>";
						} else {
							$content .= "<h3 style=\"color: red\">".DS_STRING_MAC_MNG_BIND_UNKNOWN_ERROR."</h3>";
						}
					} else {
						$content .= "<p style=\"color: red\"><br />".DS_STRING_MAC_MNG_BIND_MAC_IN_USE;
						$content .= $_POST['addmacaddr']."</p>";
					}
				} else {
						$content .= "<p style=\"color: red\"><br />".DS_STRING_MAC_MNG_BIND_MAC_INVALID;
						$content .= $_POST['addmacaddr']."</p>";
				}
				main_screen(DS_STRING_MAIN_CAPTION_MAC_DEVS, $content.mac_device_management_page(), DS_STRING_HELP_CAPTION_DEV_MAIN, DS_STRING_HELP_CONTENT_DEV_MAIN);
		
		} else {
		 $err = "<p style=\"color: red\"> ".DS_STRING_MAC_MNG_BIND_NO_INFO." </p>";	
		 main_screen(DS_STRING_MAIN_CAPTION_MAC_DEVS, $err . mac_device_management_page(), DS_STRING_HELP_CAPTION_DEV_MAIN, DS_STRING_HELP_CONTENT_DEV_MAIN);
		}
	}	

		// adding devices page
	else if($_REQUEST['method'] == 'adddevicetoprofilepage' ) {
			$prfName .= stripslashes( $_REQUEST['name'] );
			main_screen(DS_STRING_MAIN_CAPTION_ADD_DEV_TO_PROF."<b>\"".stripslashes( $prfName )."\"</b>", add_device_to_profile_page($prfName), DS_STRING_HELP_CAPTION_PROF_PROP, DS_STRING_HELP_CONTENT_PROF_PROP);		
	}
	

		// remove selected profile	
	else if( ($_REQUEST['method'] == 'removeprofile') && isset($_SESSION['user']) ) {
			$prfName = stripslashes( $_REQUEST['name'] );
			
			$content .= "";
			if( db_remove_profile($_SESSION['user'], $prfName) ) {
				$content .= "<p style=\"color: green\">".DS_STRING_PROF_MNG_PROFILE_REMOVED_BEGIN.$prfName.DS_STRING_PROF_MNG_PROFILE_REMOVED_END."</p>";
			}
			else {
				$content .= "<p style=\"color: red\">".DS_STRING_PROF_MNG_PROFILE_REMOVE_ERROR_BEGIN.$prfName.DS_STRING_PROF_MNG_PROFILE_REMOVE_ERROR_END."</p>";		
			}
		
			$content .= profile_management_form_create($_SESSION['user']);
			$content .= device_list($_SESSION['user']);

			main_screen(DS_STRING_MAIN_CAPTION_PROFILES, $content, DS_STRING_HELP_CAPTION_PROF_MAIN, DS_STRING_HELP_CONTENT_PROF_MAIN);
	
	}

	/* Update device name*/
	else if( isset($_POST['updatedevname']) && isset($_SESSION['user']) ) {
			$devid = $_POST['devid'];
            $dbox = db_get_dunkkisbox_by_mac($_POST['mac'], $_SESSION['userid']);
            $prfName = stripslashes( $_POST['prfname'] );
            $prfId = db_get_profile_id_by_name($_SESSION['user'], $prfName);
            $fname= stripslashes( $_POST['devicename'] );
			if(db_insert_device_to_profile($devid,$fname,$prfId['id'],
									 $dbox['id'],"")) {
            main_screen(DS_STRING_MAIN_CAPTION_ADD_DEV_TO_PROF."<b>\"".$prfName."\"</b>",
						add_device_to_profile_page($prfName, "<p
												   style=\"color:
												   red\">".DS_STRING_DEV_MNG_DEV_UPD_NAME_ERROR."<b>".$devid."</b></p>"), DS_STRING_HELP_CAPTION_PROF_PROP, DS_STRING_HELP_CONTENT_PROF_PROP);    
            } else {
            main_screen(DS_STRING_MAIN_CAPTION_ADD_DEV_TO_PROF."<b>\"".$prfName."\"</b>",
						add_device_to_profile_page($prfName, "<p
												   style=\"color:
												   green\">".DS_STRING_DEV_MNG_DEV_UPD_NAME_SUCC."<b>".$devid."</b></p>"), DS_STRING_HELP_CAPTION_PROF_PROP, DS_STRING_HELP_CONTENT_PROF_PROP);    
			}
    }

	// adding reguested device to profile
	else if( isset($_POST['adddev2prof']) && isset($_SESSION['user']) ) {
			$devid = $_POST['devid'];
			$dbox = db_get_dunkkisbox_by_mac($_POST['mac'], $_SESSION['userid']);
			$prfName = stripslashes( $_POST['prfname'] );
			$prfId = db_get_profile_id_by_name($_SESSION['user'], $prfName);
			$fname= stripslashes( $_POST['devicename'] );
			
			if(db_insert_device_to_profile($devid,$fname,$prfId["id"],$dbox['id'],"")) {
				$s = db_get_sensors_by_deviceid($devid);

				$id = db_get_id_of_device_by_devidstr($devid,$prfId['id']);
				if( 0 != $id ) {
					for ($i=0;$i<count($s);$i++) {
						db_add_sensor_to_profile($s[$i]['sensorid'],"",$id,db_get_type_by_sensorid($s[$i]['sensorid']));
					}	
				main_screen(DS_STRING_MAIN_CAPTION_ADD_DEV_TO_PROF."<b>\"".$prfName."\"</b>", add_device_to_profile_page($prfName, "<p style=\"color: green\">".DS_STRING_DEV_MNG_DEV_ADD_TO_PROF_SUCC."<b> ".$devid."</b></p>"),
                            DS_STRING_HELP_CAPTION_PROF_PROP, DS_STRING_HELP_CONTENT_PROF_PROP);		
				}
				else {
				main_screen(DS_STRING_MAIN_CAPTION_ADD_DEV_TO_PROF."<b>\"".$prfName."\"</b>",
                            add_device_to_profile_page($prfName, "<p style=\"color: red\">".DS_STRING_DEV_MNG_DEV_ADD_TO_PROF_ERROR_BEGIN.$devid.DS_STRING_DEV_MNG_DEV_ADD_TO_PROF_ERROR_END."</p>"),
                            DS_STRING_HELP_CAPTION_PROF_PROP, DS_STRING_HELP_CONTENT_PROF_PROP);		
				}
			} else {
				main_screen(DS_STRING_MAIN_CAPTION_ADD_DEV_TO_PROF."<b>\"".$prfName."\"</b>",
                            add_device_to_profile_page($prfName, "<p style=\"color: green\">".DS_STRING_DEV_MNG_DEV_ADD_TO_PROF_SUCC_BEGIN.$devid.DS_STRING_DEV_MNG_DEV_ADD_TO_PROF_SUCC_END.$prfName."</p>"),
                            DS_STRING_HELP_CAPTION_PROF_PROP, DS_STRING_HELP_CONTENT_PROF_PROP);		
			}
	}

	// dropping out reguested device from profile
	else if( isset($_POST['remdevfromprf']) && isset($_SESSION['user']) ) {
			$prfName = stripslashes( $_POST['prfname'] );
			$prfId = db_get_profile_id_by_name($_SESSION['user'], $prfName);
			$fname= $_POST['devid'];			
			$devid = db_get_id_of_device_by_devidstr($fname,$prfId['id']);
			if( $devid && db_remove_dev_from_profile($prfId['id'],$fname) ) {
				db_del_sensors_from_device($devid['id']);
				main_screen(DS_STRING_MAIN_CAPTION_ADD_DEV_TO_PROF."<b>\"".$prfName."\"</b>",
                            add_device_to_profile_page($prfName, "<p style=\"color: green\">".DS_STRING_DEV_MNG_DEV_REM_FROM_PROF_SUCC_BEGIN.$fname.DS_STRING_DEV_MNG_DEV_REM_FROM_PROF_SUCC_END.$prfName."</p>"),
                            DS_STRING_HELP_CAPTION_PROF_PROP, DS_STRING_HELP_CONTENT_PROF_PROP);		
			} else {
				main_screen(DS_STRING_MAIN_CAPTION_ADD_DEV_TO_PROF."<b>\"".$prfName."\"</b>",
                            add_device_to_profile_page($prfName, "<p style=\"color: red\">".DS_STRING_DEV_MNG_DEV_REM_FROM_PROF_ERROR_BEGIN.$devid['id'].DS_STRING_DEV_MNG_DEV_REM_FROM_PROF_ERROR_END.$prfName."</p>"),
                            DS_STRING_HELP_CAPTION_PROF_PROP, DS_STRING_HELP_CONTENT_PROF_PROP);		
			}
	}
	else {
		show_mainpage($_SESSION['user']);
	}
}

// User not logged in.
else {

    set_session_language( $_SESSION['ds_language'] );

    if( $_REQUEST['method'] == DS_MNG_USER_LOGIN ) {

        $status = login( $_REQUEST['user'], $_REQUEST['password'] );
        if( $status == DS_MNG_USER_LOGIN_SUCCESS ) {
            show_mainpage( $_SESSION['user'] );
        }
        else {
            print( loginPage( $status ) ); // Login failed.
        }

    }
    else {
        print( loginPage() );
    }



}

ob_flush();
if ($_SESSION['login'] == true) {
	page_footer();
}
page_tail();
ob_flush();
?>
