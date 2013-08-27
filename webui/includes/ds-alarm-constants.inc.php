<?php

/** Dunkkis Web User Interface, Dunkkis Server
  * ==========================================
  * Alarm functionality constant definitions.
  * 
  * Copyright (c) 2009-2010 Nomovok Ltd
  * This software is licensed under The MIT License. See LICENSE for details.
  */

define("DS_VAR_ALARM_MAINPAGE", 		"myalarms");
define("DS_VAR_ALARM_SETTINGS_PAGE", 	"alarmsettings");
define("DS_VAR_ALARM_SCHEDULE_PAGE", 	"alarmschedules");
define("DS_VAR_ALARM_SENSORS_PAGE", 		"alarmsensors");
define("DS_VAR_ALARM_CONTACTS_PAGE", 	"alarmcontacts");
define("DS_VAR_ALARM_HISTORY_PAGE", 		"alarmhistory");

define("DS_VAR_ALARM_SEPARATER", 		"<hr>");

define("DS_VAR_ALARM_SETTINGS_ONSUBMIT", 	"onsubmit=\"return alarm_validate_settings(this)\"");
define("DS_VAR_ALARM_SCHEDULE_ONSUBMIT", 	"onsubmit=\"return alarm_validate_schedule(this)\"");
define("DS_VAR_ALARM_CONTACT_ONSUBMIT", 	"onsubmit=\"return alarm_validate_contact(this)\"");

define("DS_VAR_ALARM_ID", 			"alarm");
define("DS_VAR_ALARM_SCHEDULE_ID", 		"schedule");
define("DS_VAR_ALARM_SENSOR_ID", 		"sensor");
define("DS_VAR_ALARM_CONTACT_ID", 		"contact");
define("DS_VAR_ALARM_NAME_ID", 		"name");
define("DS_VAR_ALARM_SMS_ID", 		"sms");
define("DS_VAR_ALARM_EMAIL_ID", 		"email");

define("DS_VAR_ALARM_APPEND_SMS", "appendsms");
define("DS_VAR_ALARM_APPEND_EMAIL", "appendemail");
define("DS_VAR_ALARM_REMOVE_SMS", "removesms");
define("DS_VAR_ALARM_REMOVE_EMAIL", "removeemail");


define("DS_VAR_ALARM_COLOR_A", 		"#AAAAAA");
define("DS_VAR_ALARM_COLOR_B", 		"#DDDDDD");
define("DS_VAR_ALARM_COLOR_C", 		"#CCCCCC");

define("DS_VAR_TARGET", 			"demo.php");

define("DS_VAR_ALARM_ERRORS", 		"<div id='divvalidateerrors'>%s</div>");	///< this needs %s for 1 input.

// Used for links
define("DS_VAR_ALARM_APPEND", 		"append");		///< This will append record to alarm
define("DS_VAR_ALARM_REMOVE", 		"remove");		///< This will remove record from alarm
define("DS_VAR_ALARM_ENABLE", 		"enable");		///< This will remove record from alarm
define("DS_VAR_ALARM_DISABLE",      "disable");
define("DS_VAR_ALARM_AUTOENABLE",   "autoenable");
define("DS_VAR_ALARM_AUTODISABLE",  "autodisable");
define("DS_VAR_ALARM_PROCESS", 		"process");
define("DS_VAR_ALARM_RANDOM", 		"random");

// Used for forms.
define("DS_VAR_ALARM_ADD", 			"add");			///< This will add new record
define("DS_VAR_ALARM_EDIT", 			"edit");		///< This will edit record
define("DS_VAR_ALARM_DELETE",	 	"confirm");		///< This will ask user to confirm removal
define("DS_VAR_ALARM_CONFIRMED", 		"delete");		///< This will remove records
define("DS_VAR_ALARM_NEW", "newalarm");

?>
