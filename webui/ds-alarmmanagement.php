<?php

/** Dunkkis Web User Interface
  * ==========================
  * 
  * Copyright (c) 2009-2010 Nomovok Ltd
  * This software is licensed under The MIT License. See LICENSE for details.
  */

include_once("includes/config.inc.php");
include_once("ds-db.php");
include_once("ds-db_alarm.php");

/* Defines to turn off and on features */
define("DS_DUNKKIS_ALARM_USE_ICONS", 1);
define("DS_DUNKKIS_ALARM_USE_HEADER", 1);
//define("DS_DUNKKIS_ALARM_USE_FOOTER", 1);
define("DS_DUNKKIS_ALARM_FOOTER_ALIGN_START", '<p style="text-align:right">');
define("DS_DUNKKIS_ALARM_FOOTER_ALIGN_END", '</p>');

/** 
 * Alarm management page routines 
 * @author Lars Kinnunen - lars.kinnunen@nomovok.com
 *
 */

/**
 ********************************************************************************************
 * Diff Section
 ********************************************************************************************
 **/

/**
 * udiff_compare_ids
 * Returns the difference of id's between two arrays.
 * @param a First array.
 * @param b Second array.
 */
function udiff_compare_ids($a, $b) {
	return ($a['id'] - $b['id']);
}

/**
 ********************************************************************************************
 * Forms Section
 ********************************************************************************************
 **/

/**
 * add_alarm_form
 * Generates the form to add/edit alarm.
 * @param alarm: int Alarm ID.
 * @return Returns the HTML code generated.
 */
function add_alarm_form($alarm) {	

	// defaults
	$form_alarm_name = "";
	$form_sms_checked = "disabled";
	$form_email_checked = "disabled";
	$form_composite_checked = "disabled";
	$form_smallmessage = "";
	$form_bigmessage = "";
	$form_submit = DS_STRING_ALARM_MNG_NEW;
	$form_type = constant("DS_VAR_ALARM_ADD");

	// Fill form with db information
	if ($alarm != 0)	{
		$uid =  db_get_userid( $_SESSION['user'] );
		$alarm_db = db_get_alarm($alarm);
		$form_alarm_name = htmlspecialchars($alarm_db["name"], ENT_QUOTES);
		$form_smallmessage = htmlspecialchars($alarm_db["small_message"], ENT_QUOTES);
		$form_bigmessage = htmlspecialchars($alarm_db["long_message"], ENT_QUOTES);
		switch ($alarm_db["alert"]) {
			case 'none':
	//			$form_sms_checked = "";
	//			$form_email_checked = "";
	//			$form_composite_checked = "";
				break;
			case 'email':
	//			$form_sms_checked = "";
	//			$form_composite_checked = "";
				break;
			case 'sms':
	//			$form_email_checked = "";
	//			$form_composite_checked = "";
				break;
			case 'composite':
	//			$form_sms_checked = "";
	//			$form_email_checked = "";
				break;
			case 'email_sms':
	//			$form_composite_checked = "";
				break;
			case 'sms_composite':
	//			$form_email_checked = "";
				break;
			case 'email_composite':
	//			$form_sms_checked = "";
				break;
			case 'all':
			default:
				break;
		}
		$form_submit = DS_STRING_ALARM_MNG_SAVE;
		$form_type = constant("DS_VAR_ALARM_EDIT");
	}

	$content = "<table style=\"vertical-align:top;text-align: left; width: 650px%;\" border=\"0\" cellpadding=\"2\" cellspacing=\"0\">\n";
	$content .= "<tbody>\n";
	// Table header line
	$content .= "<tr><th width=\"100\"> </th>
					<th width=\"350\"> </th>
				</tr>\n";

	$content .= '<form name="'.constant("DS_VAR_ALARM_SETTINGS_PAGE").'" '. 
				   constant("DS_VAR_ALARM_SETTINGS_ONSUBMIT").' method="post" action="'. 
				   constant("DS_VAR_TARGET") . '">';
	$content .= '<tr><td align="right" valign="top">'.DS_STRING_ALARM_MNG_ALARM_NAME.'</td><td>';
	$content .= '<input type="text" name="alarmname" size="52" maxlength="250" value="'.$form_alarm_name.'"/>';
	$content .= '</td></tr>';

	$content .= '<tr><td align="right" valign="top">'.DS_STRING_ALARM_MNG_ALARM_TYPE.'</td><td>';
	$content .= '<input type="checkbox" name="sms" '.$form_sms_checked.'><font color="#d3d3d3">'.DS_STRING_ALARM_MNG_SMS.' '."</font>\n";
	$content .= '<input type="checkbox" name="email" '.$form_email_checked.'><font color="#d3d3d3">'.DS_STRING_ALARM_MNG_EMAIL.' '."</font>\n";
	$content .= '<input type="checkbox" name="composite" '.$form_composite_checked.'><font color="#d3d3d3">'.DS_STRING_ALARM_MNG_COMPOSITE.' '."\n";
	$content .= '</font></td></tr>';

	$content .= '<tr><td align="right" valign="top">'.DS_STRING_ALARM_MNG_SMALL_MSG.'<input type="text" name="smallmessage_size" size="6" disabled id="smallmessage_size"></td><td>';
	$content .= '<textarea name="smallmessage" id="smallmessage" onkeypress="textarea_size(\'smallmessage\', \'smallmessage_size\', 160);" onchange="textarea_size(\'smallmessage\', \'smallmessage_size\', 160)" cols="50" rows="5">'.$form_smallmessage.'</textarea>';
	$content .= '</td></tr>';

	$content .= '<tr><td align="right" valign="top">'.DS_STRING_ALARM_MNG_BIG_MSG.'<input type="text" name="bigmessage_size" size="6" disabled id="bigmessage_size"></td><td>';
	$content .= '<textarea name="bigmessage" id="bigmessage" onkeypress="textarea_size(\'bigmessage\', \'bigmessage_size\', 250);" onchange="textarea_size(\'bigmessage\', \'bigmessage_size\', 250)" cols="50" rows="5" >'.$form_bigmessage.'</textarea>';
	$content .= '</td></tr>';
	$content .= '<tr><td></td><td>';
	$content .= '<input type="hidden" name="method" value="'.constant("DS_VAR_ALARM_SETTINGS_PAGE").'">';
	$content .= '<input type="hidden" name="'.constant("DS_VAR_ALARM_ID").'" value="'.$alarm.'">';
	$content .= '<input type="hidden" name="'.$form_type.'">';
	$content .= '<input type="submit" value="'.$form_submit.'">';
	$content .= '</td></tr>';
   	$content .= "</form>\n";
   	$content .= "</tbody>\n";
   	$content .= "</table>\n";
	return $content;
}

/**
 * alarm_schedule_form
 * Generates the form to add a schedule to an alarm.
 * @param alarm: int Alarm ID.
 * @param id: int Schedule ID.
 * @return Returns the HTML code generated.
 */
function alarm_schedule_form($alarm, $id) {

	// defaults
	$form_schedule_name = "";
	$form_min_value = "";
	$form_max_value = "";
	$form_within = "checked";
	$form_outside = "";
	$form_always_checked = "checked";
	$form_months_all = "checked";
	$form_months_selected = "";
	$form_days_all = "checked";
	$form_days_selected = "";
	$form_jan_checked = "checked";
	$form_feb_checked = "checked";
	$form_mar_checked = "checked";
	$form_apr_checked = "checked";
	$form_may_checked = "checked";
	$form_jun_checked = "checked";
	$form_jul_checked = "checked";
	$form_aug_checked = "checked";
	$form_sep_checked = "checked";
	$form_oct_checked = "checked";
	$form_nov_checked = "checked";
	$form_dec_checked = "checked";
	$form_sun_checked = "checked";
	$form_mon_checked = "checked";
	$form_tue_checked = "checked";
	$form_wed_checked = "checked";
	$form_thu_checked = "checked";
	$form_fri_checked = "checked";
	$form_sat_checked = "checked";
	$form_first_day = 1;
	$form_last_day = 31;
	$form_allday_checked = "checked";
	$form_starttime = "";
	$form_endtime = "";
	$form_allyear_checked = "checked";
	$form_startdate = "";
	$form_enddate = "";
	$form_submit = ($id == -1) ? DS_STRING_ALARM_MNG_NEW_CONTACT : DS_STRING_ALARM_MNG_SAVE;
	$form_type = "disabled";
	$const_disable = "disabled";
	$const_empty = "";
	$form_disable = "";

	if( $id == -1 ) {
		
		$form_type = constant("DS_VAR_ALARM_ADD");
		
	}
	else if ($id != 0)	{
		$schedule = db_get_alarm_schedule($id);
		if ($schedule) {
			$form_schedule_name = $schedule['name'];
			$form_min_value = $schedule['value_min'];
			$form_max_value = $schedule['value_max'];

			if ($schedule["always"] != 0) { $form_always_checked = "checked"; }
			else { $form_always_checked = ""; }
			if ($schedule["period"] != 0) { $form_allyear_checked = "checked"; } 
			else { $form_allyear_checked = ""; }
			if ($schedule["all_day"] != 0) { $form_allday_checked = "checked"; } 
			else { $form_allday_checked = ""; }

			if ($schedule["jan"] != 1) $form_jan_checked = "";
			if ($schedule["feb"] != 1) $form_feb_checked = "";
			if ($schedule["mar"] != 1) $form_mar_checked = "";
			if ($schedule["apr"] != 1) $form_apr_checked = "";
			if ($schedule["may"] != 1) $form_may_checked = "";
			if ($schedule["jun"] != 1) $form_jun_checked = "";
			if ($schedule["jul"] != 1) $form_jul_checked = "";
			if ($schedule["aug"] != 1) $form_aug_checked = "";
			if ($schedule["sep"] != 1) $form_sep_checked = "";
			if ($schedule["oct"] != 1) $form_oct_checked = "";
			if ($schedule["nov"] != 1) $form_nov_checked = "";

			if ($schedule["sun"] != 1) $form_sun_checked = "";
			if ($schedule["mon"] != 1) $form_mon_checked = "";
			if ($schedule["tue"] != 1) $form_tue_checked = "";
			if ($schedule["wed"] != 1) $form_wed_checked = "";
			if ($schedule["thu"] != 1) $form_thu_checked = "";
			if ($schedule["fri"] != 1) $form_fri_checked = "";
			if ($schedule["sat"] != 1) $form_sat_checked = "";
			
			$form_first_day = $schedule["first_day"];
			$form_last_day = $schedule["last_day"];

			if ($schedule["startdate"]) { $form_startdate = $schedule["startdate"]; }
			else { $form_startdate = ""; }
			if ($schedule["enddate"]) { $form_enddate = $schedule["enddate"]; }
			else { $form_enddate = ""; }
			if ($schedule["starttime"]) { $form_starttime = $schedule["starttime"]; }
			else { $form_starttime = ""; }
			if ($schedule["endtime"]) { $form_endtime = $schedule["endtime"]; }
			else { $form_endtime = ""; }

			if ($schedule["value_within"] != 0) { 
				$form_within = "checked";
				$form_outside = "";
			} else { 
				$form_within = "";
				$form_outside = "checked";
			}

			if ($schedule["months"] != 0) { 
				$form_months_all = "checked";
				$form_months_selected = "";			
			} else { 
				$form_months_all = "";
				$form_months_selected = "checked";			
			}

			if ($schedule["days"] != 0) { 
				$form_days_all = "checked";
				$form_days_selected = "";
			} else { 
				$form_days_all = "";
				$form_days_selected = "checked";
			}
		}
		$form_type = constant("DS_VAR_ALARM_EDIT");
	}
    $heading = ($id == -1) ? DS_STRING_ALARM_NEW_TRIGGER : DS_STRING_ALARM_EDIT_TRIGGER;
    $content = "<br /><h4 class='DunkkisHeading'>".$heading."</h4>";
	$content .= "<table style=\"vertical-align:top;text-align: left; width: 650px%;\" border=\"0\" cellpadding=\"2\" cellspacing=\"0\">\n";
	$content .= "<tbody>\n";
	// Table header line
	$color = constant("DS_VAR_ALARM_COLOR_A");
	
	$form_disable = ($form_type == constant("DS_VAR_ALARM_ADD") || $form_type == constant("DS_VAR_ALARM_EDIT") ) ? $const_empty : $const_disable;
	
	$content .= "<tr><th width=\"50\"> </th> 
					<th width=\"100\"> </th>
					<th width=\"600\"> </th>
				</tr>\n";
	$content .= '<form name="'.constant("DS_VAR_ALARM_SCHEDULE_PAGE").'" '. 
				   constant("DS_VAR_ALARM_SCHEDULE_ONSUBMIT").' method="post" action="'. 
				   constant("DS_VAR_TARGET") . '">';
	$content .= '<tr><td></td>';
	$content .= '<td align="right" valign="top">'.DS_STRING_ALARM_MNG_SCHEDULE_NAME_EDIT.'</td><td>';
	$content .= '<input type="text" name="name" size="52" maxlength="250" value="'.$form_schedule_name.'" '.$form_disable.'/>';
	$content .= '</td></tr>';

	$content .= '<tr><td>'.DS_STRING_ALARM_MNG_SCHEDULE_VALUES.'</td><td align="right" valign="top"></td><td>';
	$content .= '</td></tr>';

	$content .= '<tr><td></td>';
	$content .= '<td align="right" valign="top">'.DS_STRING_ALARM_MNG_MIN_VALUE.'</td><td>';
	$content .= '<input type="text" name="minvalue" size="10" maxlength="15" value="'.$form_min_value.'" '.$form_disable.'/>';
	$content .= '<input type="radio" name="within" value="1" '.$form_within.' '.$form_disable.'/> '.DS_STRING_ALARM_MNG_TRIGGER_WITHIN;
	$content .= '</td></tr>';
	$content .= '<tr><td></td>';
	$content .= '<td align="right" valign="top">'.DS_STRING_ALARM_MNG_MAX_VALUE.'</td><td>';
	$content .= '<input type="text" name="maxvalue" size="10" maxlength="15" value="'.$form_max_value.'" '.$form_disable.'/>';
	$content .= '<input type="radio" name="within" value="0" '.$form_outside.' '.$form_disable.'/> '.DS_STRING_ALARM_MNG_TRIGGER_OUTSIDE;
	$content .= '</td></tr>';

	$content .= '<tr><td>'.DS_STRING_ALARM_MNG_TIME.'</td><td align="right" valign="top">'.DS_STRING_ALARM_MNG_ALWAYS.'</td><td>';
	$content .= '<input type="checkbox" name="always" id="form_always" onClick="alarm_schedule_form()" '.$form_always_checked.' '.$form_disable.'>'."\n";
	$content .= '</td></tr>';

	$form_disable = (empty($form_always_checked)) ? $const_empty : $const_disable;

	$content .= '<tr><td></td><td align="right" valign="top">'.DS_STRING_ALARM_MNG_MONTHS.'</td><td>';
	$content .= '<input type="radio" name="months" id="form_months1" value="1" onClick="alarm_schedule_form()" '.$form_months_all.' '.$form_disable.'/> '.DS_STRING_ALARM_MNG_ALL_MONTHS;
	$content .= '<input type="radio" name="months" id="form_months2" value="0" onClick="alarm_schedule_form()" '.$form_months_selected.' '.$form_disable.'/> '.DS_STRING_ALARM_MNG_SELECTED_MONTHS;
	$content .= '</td></tr>';

	$form_disable = (empty($form_always_checked) && empty($form_months_all)) ? $const_empty : $const_disable;

	$content .= '<tr><td></td><td align="right" valign="top"></td><td>';
	$content .= '<input type="checkbox" name="jan" id="form_jan" '.$form_jan_checked.' '.$form_disable.'> '.DS_STRING_ALARM_MNG_JAN.' '."\n";
	$content .= '<input type="checkbox" name="feb" id="form_feb" '.$form_feb_checked.' '.$form_disable.'> '.DS_STRING_ALARM_MNG_FEB.' '."\n";
	$content .= '<input type="checkbox" name="mar" id="form_mar" '.$form_mar_checked.' '.$form_disable.'> '.DS_STRING_ALARM_MNG_MAR.' '."\n";
	$content .= '<input type="checkbox" name="apr" id="form_apr" '.$form_apr_checked.' '.$form_disable.'> '.DS_STRING_ALARM_MNG_APR.' '."\n";
	$content .= '<input type="checkbox" name="may" id="form_may" '.$form_may_checked.' '.$form_disable.'> '.DS_STRING_ALARM_MNG_MAY.' '."\n";
	$content .= '<input type="checkbox" name="jun" id="form_jun" '.$form_jun_checked.' '.$form_disable.'> '.DS_STRING_ALARM_MNG_JUN.' '."\n<br/>";	
	$content .= '<input type="checkbox" name="jul" id="form_jul" '.$form_jul_checked.' '.$form_disable.'> '.DS_STRING_ALARM_MNG_JUL.' '."\n";
	$content .= '<input type="checkbox" name="aug" id="form_aug" '.$form_aug_checked.' '.$form_disable.'> '.DS_STRING_ALARM_MNG_AUG.' '."\n";
	$content .= '<input type="checkbox" name="sep" id="form_sep" '.$form_sep_checked.' '.$form_disable.'> '.DS_STRING_ALARM_MNG_SEP.' '."\n";
	$content .= '<input type="checkbox" name="oct" id="form_oct" '.$form_oct_checked.' '.$form_disable.'> '.DS_STRING_ALARM_MNG_OCT.' '."\n";
	$content .= '<input type="checkbox" name="nov" id="form_nov" '.$form_nov_checked.' '.$form_disable.'> '.DS_STRING_ALARM_MNG_NOV.' '."\n";
	$content .= '<input type="checkbox" name="dec" id="form_dec" '.$form_dec_checked.' '.$form_disable.'> '.DS_STRING_ALARM_MNG_DEC.' '."\n";
	$content .= '</td></tr>';

	$form_disable = (empty($form_always_checked)) ? $const_empty : $const_disable;

	$content .= '<tr><td></td><td align="right" valign="top">'.DS_STRING_ALARM_MNG_DAYS.'</td><td>';
	$content .= '<input type="radio" name="days" value="1" id="form_days1" onClick="alarm_schedule_form()" '.$form_days_all.' '.$form_disable.'/> '.DS_STRING_ALARM_MNG_ALL_DAYS;
	$content .= '<input type="radio" name="days" value="0" id="form_days2" onClick="alarm_schedule_form()" '.$form_days_selected.' '.$form_disable.'/> '.DS_STRING_ALARM_MNG_SELECT_DAYS;
	$content .= '</td></tr>';

	$form_disable = (empty($form_always_checked) && empty($form_days_all)) ? $const_empty : $const_disable;

	$content .= '<tr><td></td><td align="right" valign="top"></td><td>';
	$content .= '<input type="checkbox" name="sun" id="form_sun" '.$form_sun_checked.' '.$form_disable.'> '.DS_STRING_ALARM_MNG_SUN.' '."\n";
	$content .= '<input type="checkbox" name="mon" id="form_mon" '.$form_mon_checked.' '.$form_disable.'> '.DS_STRING_ALARM_MNG_MON.' '."\n";
	$content .= '<input type="checkbox" name="tue" id="form_tue" '.$form_tue_checked.' '.$form_disable.'> '.DS_STRING_ALARM_MNG_TUE.' '."\n";
	$content .= '<input type="checkbox" name="wed" id="form_wed" '.$form_wed_checked.' '.$form_disable.'> '.DS_STRING_ALARM_MNG_WED.' '."\n";
	$content .= '<input type="checkbox" name="thu" id="form_thu" '.$form_thu_checked.' '.$form_disable.'> '.DS_STRING_ALARM_MNG_THU.' '."\n";
	$content .= '<input type="checkbox" name="fri" id="form_fri" '.$form_fri_checked.' '.$form_disable.'> '.DS_STRING_ALARM_MNG_FRI.' '."\n";	
	$content .= '<input type="checkbox" name="sat" id="form_sat" '.$form_sat_checked.' '.$form_disable.'> '.DS_STRING_ALARM_MNG_SAT.' '."\n";
	$content .= '</td></tr>';

	$form_disable = (empty($form_always_checked)) ? $const_empty : $const_disable;

	$content .= '<tr><td></td><td align="right" valign="top"></td><td>';
	$content .= '<select name="firstday" id="form_firstday" '.$form_disable.'>';
	for ($i = 1 ; $i <= 31 ; $i++) {
		$selected = "";
		if ($i == $form_first_day) { $selected = "SELECTED"; }
		$content .= "<option value=\"$i\" $selected>$i</option>";
	}
	$content .= '</select> - ';
	$content .= '<select name="lastday" id="form_lastday" '.$form_disable.'>';
	for ($i = 1 ; $i <= 31 ; $i++) {
		$selected = "";
		if ($i == $form_last_day) { $selected = "SELECTED"; }
		$content .= "<option value=\"$i\" $selected>$i</option>";
	}
	$content .= '</select>';
	$content .= '</td></tr>';

	$content .= '<tr><td></td><td align="right" valign="top">'.DS_STRING_ALARM_MNG_ALL_DAY.'</td><td>';
	$content .= '<input type="checkbox" name="allday" id="form_allday" onClick="alarm_schedule_form()" '.$form_allday_checked.' '.$form_disable.'>'."\n";
	$content .= '</td></tr>';

	$form_disable = (empty($form_always_checked) && empty($form_allday_checked)) ? $const_empty : $const_disable;

	$content .= '<tr><td></td>';
	$content .= '<td align="right" valign="top">'.DS_STRING_ALARM_MNG_START_TIME.'</td><td>';
	$content .= '<input type="text" name="starttime" id="form_starttime" size="10" maxlength="8" value="'.$form_starttime.'" '.$form_disable.'/> '.DS_STRING_ALARM_MNG_HH_MM_SS;
	$content .= '</td></tr>';
	$content .= '<tr><td></td>';
	$content .= '<td align="right" valign="top">'.DS_STRING_ALARM_MNG_END_TIME.'</td><td>';
	$content .= '<input type="text" name="endtime" id="form_endtime" size="10" maxlength="8" value="'.$form_endtime.'" '.$form_disable.'/> '.DS_STRING_ALARM_MNG_HH_MM_SS;
	$content .= '</td></tr>';

	$form_disable = (empty($form_always_checked)) ? $const_empty : $const_disable;

	$content .= '<tr><td></td><td align="right" valign="top">'.DS_STRING_ALARM_MNG_ALL_YEAR.'</td><td>';
	$content .= '<input type="checkbox" name="allyear" id="form_allyear" onClick="alarm_schedule_form()" '.$form_allyear_checked.' '.$form_disable.'>'."\n";
	$content .= '</td></tr>';

	$form_disable = (empty($form_always_checked) && empty($form_allyear_checked)) ? $const_empty : $const_disable;

	$content .= '<tr><td></td>';
	$content .= '<td align="right" valign="top">'.DS_STRING_ALARM_MNG_START_DATE.'</td><td>';
	$content .= '<input type="text" name="startdate" id="form_startdate" size="20" maxlength="19" value="'.$form_startdate.'" '.$form_disable.'/> '.DS_STRING_ALARM_MNG_YYYY_MM_DD_HH_MM_SS;
	$content .= '</td></tr>';
	$content .= '<tr><td></td>';
	$content .= '<td align="right" valign="top">'.DS_STRING_ALARM_MNG_END_DATE.'</td><td>';
	$content .= '<input type="text" name="enddate" id="form_enddate" size="20" maxlength="19" value="'.$form_enddate.'" '.$form_disable.'/> '.DS_STRING_ALARM_MNG_YYYY_MM_DD_HH_MM_SS;
	$content .= '</td></tr>';
	
	$form_disable = ($form_type == constant("DS_VAR_ALARM_ADD") || $form_type == constant("DS_VAR_ALARM_EDIT") ) ? $const_empty : $const_disable;	

	$content .= '<tr><td></td><td></td><td>';
	$content .= '<input type="hidden" name="method" value="'.constant("DS_VAR_ALARM_SCHEDULE_PAGE").'">';
	$content .= '<input type="hidden" name="'.constant("DS_VAR_ALARM_ID").'" value="'.$alarm.'">';
	$content .= '<input type="hidden" name="'.constant("DS_VAR_ALARM_SCHEDULE_ID").'" value="'.$id.'">';
	$content .= '<input type="hidden" name="'.$form_type.'">';
	$content .= '<input type="submit" value="'.$form_submit.'" '.$form_disable.'>'."\n";
	$content .= '</td></tr>';
   	$content .= "</form>\n";
   	$content .= "</tbody>\n";
   	$content .= "</table>\n";
	return $content;
}

/**
 * alarm_contact_form
 * Generates the form to add a contact to an alarm.
 * @param alarm: int Alarm ID.
 * @param contact Contact ID.
 * @return Returns the HTML code generated.
 */
function alarm_contact_form($alarm, $contact = 0) {
	/// Defaults
    $form_title = DS_STRING_ALARM_MNG_ADD_NEW_CONTACT;
	$form_name = "";
	$form_email = "";
	$form_phone = "";
	$form_submit = DS_STRING_ALARM_MNG_NEW_CONTACT;
	$form_type = constant("DS_VAR_ALARM_ADD");

	/// Load contact
	if ($contact != 0)	{
		$uid =  db_get_userid( $_SESSION['user'] );
		$contact_db = db_get_alarm_contact($contact);
		if ($contact_db) {
            $form_title = DS_STRING_ALARM_MNG_EDIT_CONTACT;
			$form_name = htmlspecialchars($contact_db["name"], ENT_QUOTES);
			$form_email = htmlspecialchars($contact_db["email"], ENT_QUOTES);
			$form_phone = htmlspecialchars($contact_db["phone"], ENT_QUOTES);
			$form_type = constant("DS_VAR_ALARM_EDIT");
			$form_submit = DS_STRING_ALARM_MNG_SAVE;
		}
	}	

	$content = "<h4 class='DunkkisHeading'>".$form_title."</h4>\n";
	$content .= "<table style=\"vertical-align:top;text-align: left; width: 650px%;\" border=\"0\" cellpadding=\"2\" cellspacing=\"0\">\n";
	$content .= "<tbody>\n";
	// Table header line
	$color = constant("DS_VAR_ALARM_COLOR_A");
	$content .= "<tr><th width=\"100\"></th>
					<th width= \"200\"></th>
				</tr>\n";
	$content .= '<form name="'.constant("DS_VAR_ALARM_CONTACTS_PAGE").'" '. 
				   constant("DS_VAR_ALARM_CONTACT_ONSUBMIT").' method="post" action="'. 
				   constant("DS_VAR_TARGET") . '">';
	$content .= '<tr>';
	$content .= '<td>'.DS_STRING_ALARM_MNG_CONTACT_NAME.'</td>';
	$content .= '<td><input type="text" name="name" value="'.$form_name.'" size="25" maxLength="250" /></td>';
	$content .= '</tr><tr>';
	$content .= '<td>'.DS_STRING_ALARM_MNG_CONTACT_EMAIL.'</td>';
	$content .= '<td><input type="text" name="email" value="'.$form_email.'" size="25" maxLength="250" /></td>';
	$content .= '</tr><tr>';
	$content .= '<td>'.DS_STRING_ALARM_MNG_CONTACT_PHONE.'</td>';
	$content .= '<td><input type="text" name="phone" value="'.$form_phone.'" size="25" maxLength="250" /></td>';
	$content .= '</tr><tr>';
	$content .= '<td></td><td><input type="hidden" name="method" value="'.constant("DS_VAR_ALARM_CONTACTS_PAGE").'">';
	$content .= '<input type="hidden" name="'.constant("DS_VAR_ALARM_ID").'" value="'.$alarm.'">';
	$content .= "<input type=\"hidden\" name=\"".constant("DS_VAR_ALARM_CONTACT_ID")."\" value=\"$contact\">";
	$content .= '<input type="hidden" name="'.$form_type.'">';
	$content .= '<input type="submit" value="'.$form_submit.'"></td>';
	$content .= '</tr>';
   	$content .= "</form>\n";
   	$content .= "</tbody>\n";
   	$content .= "</table>\n";

	return $content;
}

/**
 ********************************************************************************************
 * List Section
 ********************************************************************************************
 **/

/**
 * get_alarms_list
 * Generates the table of all alarms for a specified user.
 * @param user: int User ID.
 * @return Returns the HTML code generated.
 *
 * Revised by Juha Hytonen - juha.hytonen@nomovok.com
 */
function get_alarms_list($user) 
{

    $content = "<h4 class='DunkkisHeading'>".DS_STRING_ALARM_MAINPAGE."</h4>";

    $alarms = db_get_alarms($user);
    $schedules = db_get_alarm_schedules($user);
    $contacts = db_get_alarm_contacts($user);
    $sensors = db_get_all_sensors();

    if( $alarms ) {

        $content .= "<table class='DunkkisTable'>";
        $content .= "<tr class='Header'> 
                     <th>".DS_STRING_ALARM_MNG_NAME."</th>
                     <th>".DS_STRING_ALARM_MNG_SCHEDULE."</th>
                     <th>".DS_STRING_ALARM_MNG_SENSORS."</th>
                     <th>".DS_STRING_ALARM_MNG_CONTACTS."</th>
                     <th colspan='2'>".DS_STRING_ALARM_MNG_MANAGE."</th>
                     </tr> ";

        $row = 1; 
        foreach( $alarms as $alarm ) {
            
            // Define row style depending on whether the row is even or odd.
            $content .= ( $row % 2 == 1 ) ? "<tr class='OddRow'>" : "<tr class='EvenRow'>";
            $content .= "<td class='Data'>".$alarm['name']."</td>
                         <td class='Data'>";

            $triggers = db_get_alarm_triggers( $alarm['id'] );
            if( $triggers && $schedules ) {
                foreach( $triggers as $trigger ) {
                    $content .= $schedules[$trigger['alarmscheduleid']]['name'];
                    $content .= "<br />";
                }
            }

            $content .= "</td><td class='Data'>";
            $alarmsensors = db_get_alarm_sensors( $alarm['id'] );
            if( $alarmsensors && $sensors ) {
                foreach( $alarmsensors as $sensor ) {

                    $name = $sensors[$sensor['sensorid']]['name'];
                    if( empty( $name ) ) {
                        $name = $sensors[$sensor['sensorid']]['sensoridstr'];
                    }
                    $content .= $name;
                
                    if( $sensor['enabled'] ) {
                        $content .= manageButtonImg( "images/sensor_on.png", 16,
                                                     DS_STRING_ALARM_SENSOR_ENABLED,
                                                     DS_VAR_ALARM_MAINPAGE, DS_VAR_ALARM_DISABLE,
                                                     DS_VAR_ALARM_ID, $alarm['id'],
                                                     DS_VAR_ALARM_SENSOR_ID, $sensor['sensorid'] );
                    }   
                    else {
                        $content .= manageButtonImg( "images/sensor_off.png", 16,
                                                     DS_STRING_ALARM_SENSOR_DISABLED,
                                                     DS_VAR_ALARM_MAINPAGE, DS_VAR_ALARM_ENABLE,
                                                     DS_VAR_ALARM_ID, $alarm['id'],
                                                     DS_VAR_ALARM_SENSOR_ID, $sensor['sensorid'] );
                    }

                    $content .= "<br />";

                }
            }

            $content .= "</td><td class='Data'>";
            $actions = db_get_alarm_actions( $alarm['id'] );
            if( $actions && $contacts ) {
                foreach( $actions as $action ) { 
                    $content .= $contacts[$action['alarmcontactsid']]['name'];
                    $content .= "<br />";
                }
            }
            $content .= "</td>";


            $content .= "<td class='ManageImg'>";
            $content .= manageButtonImg( "images/edit.png", 22,
                                         DS_STRING_ALARM_MNG_EDIT_ALARM,
                                         DS_VAR_ALARM_SETTINGS_PAGE, "",
                                         DS_VAR_ALARM_ID, $alarm['id'] );
            $content .= "</td><td class='ManageImg'>";
            $content .= manageButtonImg( "images/history_small.png", 22,
                                         DS_STRING_ALARM_MNG_HISTORY,
                                         DS_VAR_ALARM_HISTORY_PAGE,  "",
                                         DS_VAR_ALARM_ID, $alarm['id'] );
            $content .= "</td><td class='ManageImg'>";
            $content .= manageButtonImg( "images/delete.png", 22,
                                         DS_STRING_ALARM_MNG_DELETE,
                                         DS_VAR_ALARM_MAINPAGE, DS_VAR_ALARM_DELETE, 
                                         DS_VAR_ALARM_ID, $alarm['id'] );
            $content .= "</td></tr>";

            $row++;

        }

        $content .= "</table>";

    }

    return $content;

}

/**
 * get_alarm_schedules_list
 * Generates the table of all schedules for a specified alarm.
 * @param user: int User ID.
 * @param alarm: int Alarm ID.
 * @return Returns the HTML code generated.
 *
 * Revised by Juha Hytonen - juha.hytonen@nomovok.com
 */
function get_alarm_schedules_list( $user, $alarm ) 
{

    $content = "<br /><h4 class='DunkkisHeading'>".DS_STRING_HELP_CAPTION_ALARM_SCHEDULE."</h4>";

    $schedules = db_get_alarm_schedules( $user );
    if( $alarm != 0 ) $triggers = db_get_alarm_triggers( $alarm );

    if( $schedules ) {

        $content .= "<table class='DunkkisTable'>";
        $content .= "<tr class='Header'> 
                     <th>".DS_STRING_ALARM_MNG_SCHEDULE_NAME."</th>
                     <th colspan='3'>".DS_STRING_ALARM_MNG_MANAGE."</th>
                     </tr> ";

        $row = 1; 
        foreach( $schedules as $schedule ) {
            
            // Define row style depending on whether the row is even or odd.
            $content .= ( $row % 2 == 1 ) ? "<tr class='OddRow'>" : "<tr class='EvenRow'>";
            $content .= "<td class='Data'>".$schedule['name']."</td>";

            $content .= "<td class='ManageImg'>";
            $content .= manageButtonImg( "images/edit.png", 22,
                                         DS_STRING_ALARM_SCHEDULE_LINK_EDIT,
                                         DS_VAR_ALARM_SCHEDULE_PAGE, "",
                                         DS_VAR_ALARM_ID, $alarm,
                                         DS_VAR_ALARM_SCHEDULE_ID, $schedule['id'] );

            $hastrigger = false;
            if( $triggers ) {
                foreach( $triggers as $trigger ) {
                    if( $trigger['alarmscheduleid'] == $schedule['id'] ) $hastrigger = true;
                }
            }
            if( $hastrigger ) {
                $content .= "</td><td class='ManageImg'>";
                $content .= manageButtonImg( "images/remove.png", 22,
                                             DS_STRING_ALARM_SCHEDULE_LINK_REM,
                                             DS_VAR_ALARM_SCHEDULE_PAGE, DS_VAR_ALARM_REMOVE, 
                                             DS_VAR_ALARM_ID, $alarm,
                                             DS_VAR_ALARM_SCHEDULE_ID, $schedule['id'] );
            }
            else {
                $content .= "</td><td class='ManageImg'>";
                $content .= manageButtonImg( "images/add.png", 22,
                                             DS_STRING_ALARM_SCHEDULE_LINK_ADD,
                                             DS_VAR_ALARM_SCHEDULE_PAGE, DS_VAR_ALARM_APPEND, 
                                             DS_VAR_ALARM_ID, $alarm,
                                             DS_VAR_ALARM_SCHEDULE_ID, $schedule['id'] );
            }

            $content .= "</td><td class='ManageImg'>";
            $content .= manageButtonImg( "images/delete.png", 22,
                                         DS_STRING_ALARM_SCHEDULE_LINK_DEL,
                                         DS_VAR_ALARM_SCHEDULE_PAGE, DS_VAR_ALARM_DELETE, 
                                         DS_VAR_ALARM_ID, $alarm,
                                         DS_VAR_ALARM_SCHEDULE_ID, $schedule['id'] );
            $content .= "</td></tr>";

            $row++;

        }

        $content .= "</table>";

    }

    return $content;

}

/**
 * get_alarm_sensors_list
 * Generates the table of all sensors for a specified alarm.
 * @param user: int User ID.
 * @param alarm: int Alarm ID.
 * @return Returns the HTML code generated.
 *
 * Revised by Juha Hytonen - juha.hytonen@nomovok.com
 */
function get_alarm_sensors_list( $user, $alarm ) 
{

    $content = "<h4 class='DunkkisHeading'>".DS_STRING_HELP_CAPTION_ALARM_SENSORS."</h4>";

    $sensors = db_get_sensors_by_uid( $user );
    $devices = db_get_all_devices();
    if( $alarm ) $alarmsensors = db_get_alarm_sensors( $alarm );

    if( $sensors ) {

        $content .= "<table class='DunkkisTable'>";
        $content .= "<tr class='Header'> 
                     <th>".DS_STRING_ALARM_MNG_SENSOR_NAME."</th>
                     <th>".DS_STRING_ALARM_MNG_DEVICE_NAME."</th>
                     <th>".DS_STRING_ALARM_MNG_PROFILE_NAME."</th>
                     <th>".DS_STRING_ALARM_MNG_ENABLED."</th>
                     <th>".DS_STRING_ALARM_MNG_AUTOENABLE."</th>
                     <th>".DS_STRING_ALARM_MNG_MANAGE."</th>
                     </tr> ";

        $row = 1; 
        foreach( $sensors as $sensor ) {
            
            if( empty( $sensor['name'] ) ) $sensor['name'] = $sensor['sensoridstr'];
            $hassensor = false;
            $sensorenabled = 0;
            $sensorautoenable = 0;
            if( $alarmsensors ) {
                foreach( $alarmsensors as $alarmsensor ) {
                    if( $sensor['id'] == $alarmsensor['sensorid'] ) {
                        $hassensor = true;
                        $sensorenabled = $alarmsensor['enabled'];
                        $sensorautoenable = $alarmsensor['auto_enable'];
                    }
                }
            }
            $hasdevice = "-";
            if( $devices ) {
                foreach( $devices as $device ) {
                    if( $sensor['devid'] == $device['id'] ) $hasdevice = $device['name'];
                }
            }

            // Define row style depending on whether the row is even or odd.
            $content .= ( $row % 2 == 1 ) ? "<tr class='OddRow'>" : "<tr class='EvenRow'>";
            $content .= "<td class='Data'>".$sensor['name']."</td>
                         <td class='Data'>".$hasdevice."</td>
                         <td class='Data'>".$sensor['profileName']."</td>";

            if( $hassensor ) {

                $content .= "<td class='Data'>";
                if( $sensorenabled ) {
                    $content .= manageButtonImg( "images/sensor_on.png", 16,
                                                 DS_STRING_ALARM_SENSOR_ENABLED,
                                                 DS_VAR_ALARM_SENSORS_PAGE, DS_VAR_ALARM_DISABLE,
                                                 DS_VAR_ALARM_ID, $alarm,
                                                 DS_VAR_ALARM_SENSOR_ID, $sensor['id'] );
                }
                else {
                    $content .= manageButtonImg( "images/sensor_off.png", 16,
                                                 DS_STRING_ALARM_SENSOR_DISABLED,
                                                 DS_VAR_ALARM_SENSORS_PAGE, DS_VAR_ALARM_ENABLE,
                                                 DS_VAR_ALARM_ID, $alarm,
                                                 DS_VAR_ALARM_SENSOR_ID, $sensor['id'] );
                }

                $content .= "</td><td class='Data'>";

                if( $sensorautoenable ) {
                    $content .= manageButtonImg( "", 16,
                                                 DS_STRING_ALARM_SENSOR_AUTOENABLE,
                                                 DS_VAR_ALARM_SENSORS_PAGE, DS_VAR_ALARM_AUTODISABLE,
                                                 DS_VAR_ALARM_ID, $alarm,
                                                 DS_VAR_ALARM_SENSOR_ID, $sensor['id'] );
                }
                else {
                    $content .= manageButtonImg( "", 16,
                                                 DS_STRING_ALARM_SENSOR_NOAUTOENABLE,
                                                 DS_VAR_ALARM_SENSORS_PAGE, DS_VAR_ALARM_AUTOENABLE,
                                                 DS_VAR_ALARM_ID, $alarm,
                                                 DS_VAR_ALARM_SENSOR_ID, $sensor['id'] );
                }

                $content .= "</td><td class='ManageImg'>";
                $content .= manageButtonImg( "images/remove.png", 22,
                                             DS_STRING_ALARM_SENSOR_LINK_DEL,
                                             DS_VAR_ALARM_SENSORS_PAGE, DS_VAR_ALARM_REMOVE, 
                                             DS_VAR_ALARM_ID, $alarm,
                                             DS_VAR_ALARM_SENSOR_ID, $sensor['id'] );
                $content .= "</td></tr>";

            }
            else {

                $content .= "<td class='Data'>&nbsp</td><td class='Data'>&nbsp</td>
                             <td class='ManageImg'>";
                $content .= manageButtonImg( "images/add.png", 22,
                                             DS_STRING_ALARM_SENSOR_LINK_ADD,
                                             DS_VAR_ALARM_SENSORS_PAGE, DS_VAR_ALARM_APPEND, 
                                             DS_VAR_ALARM_ID, $alarm,
                                             DS_VAR_ALARM_SENSOR_ID, $sensor['id'] );
                $content .= "</td></tr>";

            }

            $row++;

        }

        $content .= "</table>";

    }

    return $content;

}

/**
 * get_alarm_history_list
 * Generates the table of all history for a specified alarm.
 * @param user: int User ID.
 * @param alarm: int Alarm ID.
 * @return Returns the HTML code generated.
 */
function get_alarm_history_list( $user, $alarm ) 
{

    $content = "<br /><h4 class='DunkkisHeading'>".DS_STRING_HELP_CAPTION_ALARM_HISTORY."</h4>";

    if ($alarm == 0) {
        $history = db_get_alarm_all_history($user);
    } else {
        $history = db_get_alarm_history($alarm);
    }

    if( $history ) {

        $content .= "<table class='DunkkisTable'>";
        $content .= "<tr class='Header'> 
                     <th>".DS_STRING_ALARM_HISTORY_TIME."</th>
                     <th>".DS_STRING_ALARM_HISTORY_ALARM_NAME."</th>
                     <th>".DS_STRING_ALARM_HISTORY_SCHEDULE_NAME."</th>
                     <th>".DS_STRING_ALARM_HISTORY_SENSOR_NAME."</th>
                     <th>".DS_STRING_ALARM_HISTORY_VALUE."</th>
                     </tr> ";

        $row = 1; 
        foreach( $history as $entry ) {
            
            // Define row style depending on whether the row is even or odd.
            $content .= ( $row % 2 == 1 ) ? "<tr class='OddRow'>" : "<tr class='EvenRow'>";
            $content .= "<td class='Data'>".$entry['logtime']."</td>
                         <td class='Data'>".$entry['alarm_name']."</td>
                         <td class='Data'>".$entry['sensor_name']."</td>
                         <td class='Data'>".$entry['schedule_name']."</td>
                         <td class='Data'>".$entry['value']."</td></tr>";

            $row++;

        }

        $content .= "</table>";

    }

    return $content;

}

/**
 * get_alarm_contacts_list
 * Generates the table of all contacts for a specified alarm.
 * @param alarm: int Alarm ID.
 * @param user: int User ID.
 * @return Returns the HTML code generated.
 */
function get_alarm_contacts_list( $alarm, $user ) 
{

    $content = "<br /><h4 class='DunkkisHeading'>".DS_STRING_HELP_CAPTION_ALARM_CONTACTS."</h4>";

    $actions = db_get_alarm_actions( $alarm );
    $contacts = db_get_alarm_contacts( $user );

    if( $contacts ) {

        $content .= "<table class='DunkkisTable'>";
        $content .= "<tr class='Header'> 
                     <th>".DS_STRING_ALARM_CONTACTS_NAME."</th>
                     <th>".DS_STRING_ALARM_MNG_PHONE."</th>
                     <th>".DS_STRING_ALARM_CONTACTS_EMAIL."</th>
                     <th colspan='4'>".DS_STRING_ALARM_MNG_MANAGE."</th>
                     </tr> ";

        $row = 1; 
        foreach( $contacts as $contact ) {

            $hassmstar = false;
            $hasemailtar = false;
            if( $alarm != 0 && $actions ) {
                foreach( $actions as $action ) {
                    if( $contact['id'] == $action['alarmcontactsid'] && $action['type'] == 'sms' ) $hassmstar = true;
                    if( $contact['id'] == $action['alarmcontactsid'] && $action['type'] == 'email' ) $hasemailtar = true;
                }
            } 
            
            // Define row style depending on whether the row is even or odd.
            $content .= ( $row % 2 == 1 ) ? "<tr class='OddRow'>" : "<tr class='EvenRow'>";
            $content .= "<td class='Data'>".$contact['name']."</td>
                         <td class='Data'>".$contact['phone']."</td>
                         <td class='Data'>".$contact['email']."</td>";

            $content .= "<td class='ManageImg'>";
            if( $hassmstar ) {
                $content .= manageButtonImg( "images/sms_del.png", 22,
                                             DS_STRING_ALARM_CONTACTS_LINK_SMS_DEL,
                                             DS_VAR_ALARM_CONTACTS_PAGE, DS_VAR_ALARM_REMOVE_SMS,
                                             DS_VAR_ALARM_ID, $alarm,
                                             DS_VAR_ALARM_CONTACT_ID, $contact['id'] );
            }
            else { 
                $content .= manageButtonImg( "images/sms_add.png", 22,
                                             DS_STRING_ALARM_CONTACTS_LINK_SMS_ADD,
                                             DS_VAR_ALARM_CONTACTS_PAGE, DS_VAR_ALARM_APPEND_SMS,
                                             DS_VAR_ALARM_ID, $alarm,
                                             DS_VAR_ALARM_CONTACT_ID, $contact['id'] );
            }

            $content .= "</td><td class='ManageImg'>";
            if( $hasemailtar ) {
                $content .= manageButtonImg( "images/email_del.png", 22,
                                             DS_STRING_ALARM_CONTACTS_LINK_EMAIL_DEL,
                                             DS_VAR_ALARM_CONTACTS_PAGE, DS_VAR_ALARM_REMOVE_EMAIL,
                                             DS_VAR_ALARM_ID, $alarm,
                                             DS_VAR_ALARM_CONTACT_ID, $contact['id'] );
            }
            else { 
                $content .= manageButtonImg( "images/email_add.png", 22,
                                             DS_STRING_ALARM_CONTACTS_LINK_EMAIL_ADD,
                                             DS_VAR_ALARM_CONTACTS_PAGE, DS_VAR_ALARM_APPEND_EMAIL,
                                             DS_VAR_ALARM_ID, $alarm,
                                             DS_VAR_ALARM_CONTACT_ID, $contact['id'] );
            }

            $content .= "</td><td class='ManageImg'>";
            $content .= manageButtonImg( "images/edit.png", 22,
                                         DS_STRING_ALARM_CONTACTS_LINK_EDIT,
                                         DS_VAR_ALARM_CONTACTS_PAGE, "",
                                         DS_VAR_ALARM_ID, $alarm,
                                         DS_VAR_ALARM_CONTACT_ID, $contact['id'] );
            $content .= "</td><td class='ManageImg'>";
            $content .= manageButtonImg( "images/delete.png", 22,
                                         DS_STRING_ALARM_CONTACTS_LINK_DEL,
                                         DS_VAR_ALARM_CONTACTS_PAGE, DS_VAR_ALARM_DELETE,
                                         DS_VAR_ALARM_ID, $alarm,
                                         DS_VAR_ALARM_CONTACT_ID, $contact['id'] );
            $content .= "</td></tr>";

            $row++;

        }

        $content .= "</table>";

    }

    return $content;

}

/**
 ********************************************************************************************
 * Footer Section
 ********************************************************************************************
 **/

/**
 * alarm_management_footer
 * Generates the alarm management page footer.
 * @return Returns the HTML code generated.
 */
function alarm_management_footer() {
	$footer  = "<div style='text-align:right; width: 100%;'>";

    $footer .= manageButtonImg( "images/alarm_new.png", 32,
                                DS_STRING_ALARM_SETTINGS_LINK_NEW,
                                DS_VAR_ALARM_SETTINGS_PAGE, DS_VAR_ALARM_NEW,
                                "", "" );

    $footer .= manageButtonImg( "images/history.png", 32,
                                DS_STRING_ALARM_HISTORY_LINK_ALL,
                                DS_VAR_ALARM_HISTORY_PAGE, "",
                                "", "" );

	$footer .= "</div>";
	return $footer;
}

/**
 * alarm_settings_footer
 * Generates the alarm settings footer.
 * @param alarm: int Alarm ID.
 * @return Returns the HTML code generated.
 */
function alarm_settings_footer($alarm) {
	$next = "disabled";
	if ($alarm != 0) $next = "";	
	$footer  = DS_DUNKKIS_ALARM_FOOTER_ALIGN_START;
	$footer .= '<input type="button" value="' . constant("DS_STRING_ALARM_SETTINGS_NAV_BACK") . '" onClick="location.href=\'?method=' .
						    constant("DS_VAR_ALARM_MAINPAGE") . '\';">';
	$footer .= '<input type="button" value="' . constant("DS_STRING_ALARM_SETTINGS_NAV_NEXT") . '" onClick="location.href=\'?method=' .
						    constant("DS_VAR_ALARM_SCHEDULE_PAGE") . "&" . 
						    constant("DS_VAR_ALARM_ID"). "=$alarm';\" $next>";
	$footer .= DS_DUNKKIS_ALARM_FOOTER_ALIGN_END;
	return $footer;
}

/**
 * alarm_schedule_footer
 * Generates the alarm schedules footer.
 * @param alarm: int Alarm ID.
 * @return Returns the HTML code generated.
 */
function alarm_schedule_footer($alarm) {
	$footer = '<table border="0" width="100%"><tr><td>';
    $footer .= manageButtonImg( "images/alarm_new.png", 32,
                                DS_STRING_ALARM_MNG_NEW,
                                "alarmschedules", "",
                                DS_VAR_ALARM_ID, $alarm,
                                "schedule", "-1" );
	$footer .= '</td><td>';
	$footer .= DS_DUNKKIS_ALARM_FOOTER_ALIGN_START;
	$footer .= '<input type="button" value="' . constant("DS_STRING_ALARM_SCHEDULES_NAV_BACK") . '" onClick="location.href=\'?method=' .
						    constant("DS_VAR_ALARM_SETTINGS_PAGE") . "&" . 
						    constant("DS_VAR_ALARM_ID"). "=$alarm';\">";
	$footer .= '<input type="button" value="' . constant("DS_STRING_ALARM_SCHEDULES_NAV_NEXT") . '" onClick="location.href=\'?method=' .
						    constant("DS_VAR_ALARM_SENSORS_PAGE") . "&" . 
						    constant("DS_VAR_ALARM_ID"). "=$alarm';\">";
	$footer .= DS_DUNKKIS_ALARM_FOOTER_ALIGN_END;
	$footer .= '</td></tr></table>';
	return $footer;
}

/**
 * alarm_sensors_footer
 * Generates the alarm sensors footer.
 * @param alarm: int Alarm ID.
 * @return Returns the HTML code generated.
 */
function alarm_sensors_footer($alarm) {	
	$footer  = DS_DUNKKIS_ALARM_FOOTER_ALIGN_START;
	$footer .= '<input type="button" value="' . constant("DS_STRING_ALARM_SENSORS_NAV_BACK") . '" onClick="location.href=\'?method=' .
						    constant("DS_VAR_ALARM_SCHEDULE_PAGE") . "&" . 
						    constant("DS_VAR_ALARM_ID"). "=$alarm';\">";
	$footer .= '<input type="button" value="' . constant("DS_STRING_ALARM_SENSORS_NAV_NEXT") . '" onClick="location.href=\'?method=' .
						    constant("DS_VAR_ALARM_CONTACTS_PAGE") . "&" . 
						    constant("DS_VAR_ALARM_ID"). "=$alarm';\">";
	$footer .= DS_DUNKKIS_ALARM_FOOTER_ALIGN_END;
	return $footer;
}

/**
 * alarm_contacts_footer
 * Generates the alarm contacts footer.
 * @param alarm: int Alarm ID.
 * @return Returns the HTML code generated.
 */
function alarm_contacts_footer($alarm) {
	$footer = '<table border="0" width="100%"><tr><td>';
    $footer .= manageButtonImg( "images/alarm_new.png", 32,
                                DS_STRING_ALARM_MNG_NEW,
                                DS_VAR_ALARM_CONTACTS_PAGE, "",
                                DS_VAR_ALARM_ID, $alarm );
	$footer .= '</td><td>';
	$footer  .= DS_DUNKKIS_ALARM_FOOTER_ALIGN_START;
	$footer .= '<input type="button" value="' . constant("DS_STRING_ALARM_CONTACTS_NAV_BACK") . '" onClick="location.href=\'?method=' .
						    constant("DS_VAR_ALARM_SENSORS_PAGE") . "&" . 
						    constant("DS_VAR_ALARM_ID"). "=$alarm';\">";
	$footer .= '<input type="button" value="' . constant("DS_STRING_ALARM_CONTACTS_NAV_NEXT") . '" onClick="location.href=\'?method=' .
						    constant("DS_VAR_ALARM_MAINPAGE") . '\';">';
	$footer .= DS_DUNKKIS_ALARM_FOOTER_ALIGN_END;
	$footer .= '</td></tr></table>';


	return $footer;
}

/**
 * alarm_history_footer
 * Generates the alarm history footer.
 * @param alarm: int Alarm ID.
 * @return Returns the HTML code generated.
 */
function alarm_history_footer($alarm) {	
	$alarm_string = "";
	if ($alarm != 0) { $alarm_string = "&" . constant("DS_VAR_ALARM_ID"). "=$alarm"; }
	$footer  = DS_DUNKKIS_ALARM_FOOTER_ALIGN_START;
	$footer .= '<input type="button" value="' . constant("DS_STRING_ALARM_SETTINGS_NAV_BACK") . '" onClick="location.href=\'?method=' .
						    constant("DS_VAR_ALARM_MAINPAGE") . '\';">';
	$footer .= '<input type="button" value="' . constant("DS_STRING_ALARM_HISTORY_NAV_CLEAR") . '" onClick="location.href=\'?method=' .
						    constant("DS_VAR_ALARM_HISTORY_PAGE") . "&" .
						    constant("DS_VAR_ALARM_DELETE") . $alarm_string . "';\">";
	$footer .= DS_DUNKKIS_ALARM_FOOTER_ALIGN_END;
	return $footer;
}


/**
 ********************************************************************************************
 * Pages Section
 ********************************************************************************************
 **/

/**
 * alarm_management_page
 * Generates the alarm management page for a specified alarm.
 * @param alarm: int Alarm ID.
 * @return Returns the HTML code generated.
 */
function alarm_management_page($alarm = 0) {
	$msg = "";
	$confirm = constant("DS_VAR_ALARM_DELETE");
	$delete = constant("DS_VAR_ALARM_CONFIRMED");
	$enable = constant("DS_VAR_ALARM_ENABLE");
	$disable = constant("DS_VAR_ALARM_DISABLE");
	$process = constant("DS_VAR_ALARM_PROCESS");
	if( isset($_REQUEST[$process]) ) {
		alarm_process_queue();
		$msg = constant("DS_STRING_ALARM_MSG_PROCCESED");
	}
	if( $alarm != 0 ) { $alarm_db = db_get_alarm($alarm); }
	if( isset($_REQUEST[$confirm]) && $alarm_db) {
		$content = alarm_confirm_page( constant("DS_VAR_ALARM_MAINPAGE")."&".
					       constant("DS_VAR_ALARM_CONFIRMED")."&".
					       constant("DS_VAR_ALARM_ID")."=$alarm", $alarm_db['name']);
	} else {
		$user =  db_get_userid( $_SESSION['user'] ); 

        if( isset($_REQUEST[$delete]) ) {
            db_delete_alarm($user, $alarm);
        } 
        else if ( isset($_REQUEST[$enable]) && $_REQUEST["alarm"] && $_REQUEST["sensor"] ) {
            db_enable_alarm_sensor( $_REQUEST["alarm"], $_REQUEST["sensor"] );
            $msg = constant( "DS_STRING_ALARM_SENSOR_MSG_ENABLED" );
        } 
        else if ( isset( $_REQUEST[$disable]) && $_REQUEST["alarm"] && $_REQUEST["sensor"] ) {
            db_disable_alarm_sensor( $_REQUEST["alarm"], $_REQUEST["sensor"] );
            $msg = constant("DS_STRING_ALARM_SENSOR_MSG_DISABLED");
        }

		if( 0 != db_get_alarms( $user ) ) {
			$content  = sprintf(constant("DS_VAR_ALARM_ERRORS"), $msg);
			if (defined("DS_DUNKKIS_ALARM_USE_HEADER")) $content .= alarm_management_footer();
			//$content .= constant("DS_VAR_ALARM_SEPARATER");
	  		$content .= get_alarms_list($user);
			//$content .= constant("DS_VAR_ALARM_SEPARATER");
			if (defined("DS_DUNKKIS_ALARM_USE_FOOTER")) $content .= alarm_management_footer();
		} else {
			$content = alarm_settings_page(); }	///< Returns page for new alarm if list is empty.	
	}
	return $content;
 }	

/**
 * alarm_settings_page
 * Generates the alarm settings page for a specified alarm.
 * @param alarm: int Alarm ID.
 * @return Returns the HTML code generated.
 */
function alarm_settings_page($alarm = 0) { 
	$msg = "";
	$add  = constant("DS_VAR_ALARM_ADD");
	$edit = constant("DS_VAR_ALARM_EDIT");
	if( isset($_REQUEST[$add]) || isset($_REQUEST[$edit]) ){
		$user =  db_get_userid( $_SESSION['user'] );
		$alarm_db['id'] = $alarm;
		$alarm_db['name'] = stripslashes( $_REQUEST['alarmname'] );
		$alarm_db['small_message'] = stripslashes( $_REQUEST['smallmessage'] );
		$alarm_db['long_message'] = stripslashes( $_REQUEST['bigmessage'] );
		$alertoptions = array(0 =>'none',111=>'all',10=>'email',1=>'sms',100=>'composite',11=>'email_sms',101=>'sms_composite',110=>'email_composite');
		$i = 0;
		$i = $i + ($_REQUEST['sms'] == "on" ? 1 : 0);
		$i = $i + ($_REQUEST['email'] == "on" ? 10 : 0);
		$i = $i + ($_REQUEST['composite'] == "on" ? 100 : 0);	
		$alarm_db['alert'] = $alertoptions[$i];
		if ( isset($_REQUEST[$add]) ) $alarm = db_add_alarm($user,$alarm_db); 
		if ( isset($_REQUEST[$edit]) ) $alarm = db_update_alarm($user,$alarm_db);
	}
	$content  = sprintf(constant("DS_VAR_ALARM_ERRORS"), $msg);
	if (defined("DS_DUNKKIS_ALARM_USE_HEADER")) $content .= alarm_settings_footer($alarm);
	//$content .= constant("DS_VAR_ALARM_SEPARATER");
    if( isset($_REQUEST[DS_VAR_ALARM_NEW]) ) {
        $content .= "<h4 class='DunkkisHeading'>".DS_STRING_ALARM_NEW_PAGE."</h4>";
    }
    else {
        $content .= "<h4 class='DunkkisHeading'>".DS_STRING_ALARM_EDIT_PAGE."</h4>";
    }
	$content .= add_alarm_form($alarm);
	//$content .= constant("DS_VAR_ALARM_SEPARATER");
	if (defined("DS_DUNKKIS_ALARM_USE_FOOTER")) $content .= alarm_settings_footer($alarm);
	return $content;
 }

/**
 * alarm_schedule_page
 * Generates the alarm schedules page for a specified alarm.
 * @param alarm: int Alarm ID.
 * @param schedule: int Schedule ID.
 * @return Returns the HTML code generated.
 */
function alarm_schedule_page($alarm, $schedule = 0) { 
	$msg = "";
	$add = constant("DS_VAR_ALARM_ADD");
	$edit = constant("DS_VAR_ALARM_EDIT");
	$confirm = constant("DS_VAR_ALARM_DELETE");
	$delete = constant("DS_VAR_ALARM_CONFIRMED");
	$append = constant("DS_VAR_ALARM_APPEND");
	$remove = constant("DS_VAR_ALARM_REMOVE");
	$user = db_get_userid( $_SESSION['user'] );
	// Lets not create values twice
	if ( isset($_REQUEST[$add]) || isset($_REQUEST[$edit]) ) {
		$value['id'] = $schedule; 
		$value['uid'] = $user; 
		$value['name'] = stripslashes( (empty($_REQUEST['name'])) ? "" : $_REQUEST['name'] );
		$value['value_min'] = (isset($_REQUEST['minvalue']) && is_numeric($_REQUEST['minvalue'])) ? $_REQUEST['minvalue'] : 0;
		$value['value_max'] = (isset($_REQUEST['maxvalue']) && is_numeric($_REQUEST['maxvalue'])) ? $_REQUEST['maxvalue'] : 0;
		$value['value_within'] = ($_REQUEST['within'] == 1) ? 1 : 0;
		$value['always'] = ($_REQUEST['always'] == "on") ? 1 : 0;
		$value['period'] = ($_REQUEST['allyear'] == "on") ? 1 : 0;
		$value['months'] = ($_REQUEST['months'] == 1) ? 1 : 0;
		$value['jan'] = ($_REQUEST['jan'] == "on") ? 1 : 0;
		$value['feb'] = ($_REQUEST['feb'] == "on") ? 1 : 0;
		$value['mar'] = ($_REQUEST['mar'] == "on") ? 1 : 0;
		$value['apr'] = ($_REQUEST['apr'] == "on") ? 1 : 0;
		$value['may'] = ($_REQUEST['may'] == "on") ? 1 : 0;
		$value['jun'] = ($_REQUEST['jun'] == "on") ? 1 : 0;
		$value['jul'] = ($_REQUEST['jul'] == "on") ? 1 : 0;
		$value['aug'] = ($_REQUEST['aug'] == "on") ? 1 : 0;
		$value['sep'] = ($_REQUEST['sep'] == "on") ? 1 : 0;
		$value['oct'] = ($_REQUEST['oct'] == "on") ? 1 : 0;
		$value['nov'] = ($_REQUEST['nov'] == "on") ? 1 : 0;
		$value['dec'] = ($_REQUEST['dec'] == "on") ? 1 : 0;
		$value['days'] = ($_REQUEST['days'] == 1) ? 1 : 0;
		$value['sun'] = ($_REQUEST['sun'] == "on") ? 1 : 0;
		$value['mon'] = ($_REQUEST['mon'] == "on") ? 1 : 0;
		$value['tue'] = ($_REQUEST['tue'] == "on") ? 1 : 0;
		$value['wed'] = ($_REQUEST['wed'] == "on") ? 1 : 0;
		$value['thu'] = ($_REQUEST['thu'] == "on") ? 1 : 0;
		$value['fri'] = ($_REQUEST['fri'] == "on") ? 1 : 0;
		$value['sat'] = ($_REQUEST['sat'] == "on") ? 1 : 0;
		$value['first_day'] = (isset($_REQUEST['firstday']) && is_numeric($_REQUEST['firstday'])) ? $_REQUEST['firstday'] : 1;
		$value['last_day'] = (isset($_REQUEST['lastday']) && is_numeric($_REQUEST['lastday'])) ? $_REQUEST['lastday'] : 31;
		$value['all_day'] = ($_REQUEST['allday'] == "on") ? 1 : 0;
		$starttime = (isset($_REQUEST['starttime'])) ? $_REQUEST['starttime'] : NULL;
		$endtime = (isset($_REQUEST['endtime'])) ? $_REQUEST['endtime'] : NULL;
		$value['starttime'] = (preg_match('/^\d\d:\d\d/',$starttime)) ? $starttime : NULL;
		$value['endtime'] = (preg_match('/^\d\d:\d\d/',$endtime)) ? $endtime : NULL;
		$startdate = (isset($_REQUEST['startdate'])) ? $_REQUEST['startdate'] : NULL;
		$enddate = (isset($_REQUEST['enddate'])) ? $_REQUEST['enddate'] : NULL;
		$value['startdate'] = (preg_match('/^\d\d\d\d-\d\d-\d\d \d\d:\d\d/',$startdate)) ? $startdate : NULL;
		$value['enddate'] = (preg_match('/^\d\d\d\d-\d\d-\d\d \d\d:\d\d/',$enddate)) ? $enddate : NULL;
	}

	if ( isset($_REQUEST[$add]) && $value ) {
		$schedule = db_add_alarm_schedule($value);
		$msg = constant("DS_STRING_ALARM_SCHEDULE_MSG_ADDED");
	} else if ( isset($_REQUEST[$edit]) && $value && $schedule) {
		$schedule = db_update_alarm_schedule($value);
		$msg = constant("DS_STRING_ALARM_SCHEDULE_MSG_EDITED");
	} else if ( isset($_REQUEST[$confirm]) && $alarm && $schedule) {
		$schedule_db = db_get_alarm_schedule($schedule);
		if ($schedule_db) return $content = alarm_confirm_page( constant("DS_VAR_ALARM_SCHEDULE_PAGE")."&".
					       constant("DS_VAR_ALARM_CONFIRMED")."&".
					       constant("DS_VAR_ALARM_SCHEDULE_ID")."=$schedule&".
					       constant("DS_VAR_ALARM_ID")."=$alarm", $schedule_db['name']);
	} else if ( isset($_REQUEST[$delete]) && $alarm && $schedule) {
		$schedule = db_remove_alarm_schedule($user, $schedule);
		$schedule = 0;
		$msg = constant("DS_STRING_ALARM_SCHEDULE_MSG_DELETED");
	} else if ( isset($_REQUEST[$append]) && $alarm && $schedule) {
		$schedule = db_add_alarm_trigger($alarm, $schedule);
		$schedule = 0;
		$msg = constant("DS_STRING_ALARM_SCHEDULE_MSG_APPEND");
	} else if ( isset($_REQUEST[$remove]) && $alarm && $schedule) {
		$schedule = db_del_alarm_trigger($alarm, $schedule);
		$schedule = 0;
		$msg = constant("DS_STRING_ALARM_SCHEDULE_MSG_REMOVED");
	}
	
	$content  = sprintf(constant("DS_VAR_ALARM_ERRORS"), $msg);
	if (defined("DS_DUNKKIS_ALARM_USE_HEADER")) $content .= alarm_schedule_footer($alarm);
	//$content .= constant("DS_VAR_ALARM_SEPARATER");
	$content .= get_alarm_schedules_list($user, $alarm);
	//$content .= constant("DS_VAR_ALARM_SEPARATER");
	$content .= alarm_schedule_form($alarm, $schedule);
	//$content .= constant("DS_VAR_ALARM_SEPARATER");
	if (defined("DS_DUNKKIS_ALARM_USE_FOOTER")) $content .= alarm_schedule_footer($alarm);
	return $content;
 }

/**
 * alarm_sensors_page
 * Generates the alarm sensors page for a specified alarm.
 * @param alarm: int Alarm ID.
 * @return Returns the HTML code generated.
 */
function alarm_sensors_page($alarm) { 
	$msg = "";
	$append = constant("DS_VAR_ALARM_APPEND");
	$remove = constant("DS_VAR_ALARM_REMOVE");
	$enable = constant("DS_VAR_ALARM_ENABLE");
	$disable = constant("DS_VAR_ALARM_DISABLE");
	$autoenable = constant("DS_VAR_ALARM_AUTOENABLE");
	$autodisable = constant("DS_VAR_ALARM_AUTODISABLE");
	$const_sensor = constant("DS_VAR_ALARM_SENSOR_ID");
	$sensor = ( isset($_REQUEST[$const_sensor]) ? $_REQUEST[$const_sensor] : 0 );
	if ( isset($_REQUEST[$append]) && $alarm && $sensor) {
		db_add_alarm_sensor($alarm, $sensor);
		$msg = constant("DS_STRING_ALARM_SENSOR_MSG_APPEND");
	} else if ( isset($_REQUEST[$remove]) && $alarm && $sensor) {
		db_del_alarm_sensor($alarm, $sensor);
		$msg = constant("DS_STRING_ALARM_SENSOR_MSG_REMOVED");
	} else if ( isset($_REQUEST[$enable]) && $alarm && $sensor) {
		db_enable_alarm_sensor($alarm, $sensor);
		$msg = constant("DS_STRING_ALARM_SENSOR_MSG_ENABLED");
	} else if ( isset($_REQUEST[$disable]) && $alarm && $sensor) {
		db_disable_alarm_sensor($alarm, $sensor);
		$msg = constant("DS_STRING_ALARM_SENSOR_MSG_DISABLED");
	} else if ( isset($_REQUEST[$autoenable]) && $alarm && $sensor) {
		db_autoenable_alarm_sensor( $alarm, $sensor, 1 );
		$msg = constant("DS_STRING_ALARM_SENSOR_MSG_AUTOENABLE");
	} else if ( isset($_REQUEST[$autodisable]) && $alarm && $sensor) {
		db_autoenable_alarm_sensor( $alarm, $sensor, 0 );
		$msg = constant("DS_STRING_ALARM_SENSOR_MSG_NOAUTOENABLE");
	}
	$user = db_get_userid( $_SESSION['user'] );
	$content  = sprintf(constant("DS_VAR_ALARM_ERRORS"), $msg);
	if (defined("DS_DUNKKIS_ALARM_USE_HEADER")) $content .= alarm_sensors_footer($alarm);
	//$content .= constant("DS_VAR_ALARM_SEPARATER");
	$content .= get_alarm_sensors_list($user, $alarm);
	//$content .= constant("DS_VAR_ALARM_SEPARATER");
	if (defined("DS_DUNKKIS_ALARM_USE_FOOTER")) $content .= alarm_sensors_footer($alarm);
	return $content;
 }

/**
 * alarm_contacts_page
 * Generates the alarm contacts page for a specified alarm.
 * @param alarm: int Alarm ID.
 * @return Returns the HTML code generated.
 */
function alarm_contacts_page($alarm) {
	$msg = "";
	$add = constant("DS_VAR_ALARM_ADD");
	$edit = constant("DS_VAR_ALARM_EDIT");
	$confirm = constant("DS_VAR_ALARM_DELETE");
	$delete = constant("DS_VAR_ALARM_CONFIRMED");
	$sms = constant("DS_VAR_ALARM_SMS_ID");
	$email = constant("DS_VAR_ALARM_EMAIL_ID");
	$append = constant("DS_VAR_ALARM_APPEND");
    $appendsms = constant ("DS_VAR_ALARM_APPEND_SMS");
    $appendemail = constant ("DS_VAR_ALARM_APPEND_EMAIL");
    $removesms = constant ("DS_VAR_ALARM_REMOVE_SMS");
    $removeemail = constant ("DS_VAR_ALARM_REMOVE_EMAIL");


	$remove = constant("DS_VAR_ALARM_REMOVE");
	$user =  db_get_userid( $_SESSION['user'] ); 
	$const_contact = constant("DS_VAR_ALARM_CONTACT_ID");
	$contact = ( isset($_REQUEST[$const_contact]) ? $_REQUEST[$const_contact] : 0 );
	if ( isset($_REQUEST[$add]) && isset($_REQUEST['name']) && isset($_REQUEST['email']) && isset($_REQUEST['phone']) ) {
		$value['uid'] = $user;
		$value['name'] = stripslashes( $_REQUEST['name'] );
		$value['email'] = $_REQUEST['email'];
		$value['phone'] = $_REQUEST['phone'];
		$value['createddate'] = date("Y-m-d H:m:s");
		$value['triggercount'] = 0;
		$contact = db_add_alarm_contact($value);
		$msg = constant("DS_STRING_ALARM_CONTACTS_MSG_ADDED");
	} else if ( isset($_REQUEST[$edit]) && $contact && isset($_REQUEST['name']) && isset($_REQUEST['email']) && isset($_REQUEST['phone']) ) {
		$value['id'] = $contact;
		$value['uid'] = $user;
		$value['name'] = stripslashes( $_REQUEST['name'] );
		$value['email'] = $_REQUEST['email'];
		$value['phone'] = $_REQUEST['phone'];
		$contact = db_update_alarm_contact($value);
		$msg = constant("DS_STRING_ALARM_CONTACTS_MSG_EDITED");
	} else if ( isset($_REQUEST[$confirm]) && $alarm && $contact) {
		$contact_db = db_get_alarm_contact($contact);
		if ($contact_db) return $content = alarm_confirm_page( constant("DS_VAR_ALARM_CONTACTS_PAGE")."&".
					       constant("DS_VAR_ALARM_CONFIRMED")."&".
					       constant("DS_VAR_ALARM_CONTACT_ID")."=$contact&".
					       constant("DS_VAR_ALARM_ID")."=$alarm", $contact_db['name']);
	} else if ( isset($_REQUEST[$delete]) && $alarm && $contact) {
		$contact = db_remove_alarm_contact($user, $contact);
		$msg = constant("DS_STRING_ALARM_CONTACTS_MSG_DELETED");
	} else if ( isset($_REQUEST[$appendsms]) && $alarm && $contact ) {
			db_add_alarm_action($alarm, $contact, 'sms');
			$msg = constant("DS_STRING_ALARM_CONTACTS_MSG_APPEND_SMS");
		$contact = 0;
		} else if ( isset($_REQUEST[$appendemail]) && $alarm && $contact ) {
			db_add_alarm_action($alarm, $contact, 'email');
			$msg = constant("DS_STRING_ALARM_CONTACTS_MSG_APPEND_EMAIL");
		$contact = 0;
		}else if ( isset($_REQUEST[$removesms]) && $alarm && $contact) {
			db_del_alarm_action($alarm, $contact, 'sms');
			$msg = constant("DS_STRING_ALARM_CONTACTS_MSG_REMOVED_SMS");
		$contact = 0;
		} else if ( isset($_REQUEST[$removeemail])  && $alarm && $contact) {
			db_del_alarm_action($alarm, $contact, 'email');
			$msg = constant("DS_STRING_ALARM_CONTACTS_MSG_REMOVED_EMAIL");
		$contact = 0;
		}
	$content  = sprintf(constant("DS_VAR_ALARM_ERRORS"), $msg);
	if (defined("DS_DUNKKIS_ALARM_USE_HEADER")) $content .= alarm_contacts_footer($alarm);
	//$content .= constant("DS_VAR_ALARM_SEPARATER");
	$content .= alarm_contact_form($alarm, $contact);
	$content .= get_alarm_contacts_list($alarm, $user);
	//$content .= constant("DS_VAR_ALARM_SEPARATER");
	//$content .= constant("DS_VAR_ALARM_SEPARATER");
	if (defined("DS_DUNKKIS_ALARM_USE_FOOTER")) $content .= alarm_contacts_footer($alarm);
	return $content;
 }

/**
 * alarm_history_page
 * Generates the alarm history page for a specified alarm.
 * @param alarm: int Alarm ID.
 * @return Returns the HTML code generated.
 */
function alarm_history_page($alarm = 0) { 
	$confirm = constant("DS_VAR_ALARM_DELETE");
	$delete = constant("DS_VAR_ALARM_CONFIRMED");
	if( isset($_REQUEST[$confirm]) ) {
		$content = alarm_confirm_page( constant("DS_VAR_ALARM_HISTORY_PAGE")."&".
					       constant("DS_VAR_ALARM_CONFIRMED")."&".
					       constant("DS_VAR_ALARM_ID")."=$alarm", DS_STRING_ALARM_MNG_HISTORY,
					       constant("DS_STRING_ALARM_CONFIRM_QUESTION_HISTORY"));
	} else {
		$user = db_get_userid( $_SESSION['user'] );
		if( isset($_REQUEST[$delete]) && $alarm != 0) { db_delete_alarm_history($user, $alarm); }
		if( isset($_REQUEST[$delete]) && $alarm == 0) { db_delete_alarm_history_all($user); }
		if (defined("DS_DUNKKIS_ALARM_USE_HEADER")) $content = alarm_history_footer($alarm);
		//$content .= constant("DS_VAR_ALARM_SEPARATER");
		$content .= get_alarm_history_list($user, $alarm);
		//$content .= constant("DS_VAR_ALARM_SEPARATER");
		if (defined("DS_DUNKKIS_ALARM_USE_FOOTER")) $content .= alarm_history_footer($alarm);	
	}
	return $content;
 }

/**
 * alarm_confirm_page
 * Generates the alarm confirmation page.
 * @param dest: string Destination.
 * @param target: string Target method.
 * @param question: string Question to be confirmed. Specify empty string to use default question.
 * @return Returns the HTML code generated.
 */
function alarm_confirm_page($dest, $target, $question = "") { 
	if(empty($question)) $question = constant("DS_STRING_ALARM_CONFIRM_QUESTION_DEFAULT");
	$content  = constant("DS_VAR_ALARM_SEPARATER");
	$content .= $question . ' [' . $target . '] <br><input type="button" value="' . 
			constant("DS_STRING_ALARM_CONFIRM_YES") . '" onClick="location.href=\'?method=' .
  			$dest . '\';">' . '<input type="button" value="' . 
			constant("DS_STRING_ALARM_CONFIRM_NO") . '" onClick="location.href=\'?method=' .
  			constant("DS_VAR_ALARM_MAINPAGE") . '\';">';
	$content .= constant("DS_VAR_ALARM_SEPARATER");
	return $content;
 }
	
?>
