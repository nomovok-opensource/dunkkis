<?php

/** Dunkkis Web User Interface
  * ==========================
  * English translation
  * 
  * Copyright (c) 2009-2010 Nomovok Ltd
  * This software is licensed under The MIT License. See LICENSE for details.
  *
  * @author Juha Hytonen - juha.hytonen@nomovok.com
  */





include_once( "ds-sensor-strings.inc.php" );





/* General */

define("DS_STRING_MAIN_GENERIC",                "Generic");
define("DS_STRING_MAIN_TEMPERATURE",            "Temperature");
define("DS_STRING_MAIN_HUMIDITY",               "Humidity");
define("DS_STRING_MAIN_AIR_PRESSURE",           "Air pressure");
define("DS_STRING_MAIN_SPECIAL",                "Special");
define("DS_STRING_MAIN_CO2",                    "Carbon dioxide");
define("DS_STRING_MAIN_DOOR",                   "Door");
define("DS_STRING_MAIN_MOTION",                 "Motion detector");
define("DS_STRING_MAIN_SWITCH",                 "Switch");
define("DS_STRING_MAIN_CUSTOM",                 "Custom");
define("DS_STRING_MAIN_LDR",                    "LDR");
define("DS_STRING_MAIN_PICTURE",                "Picture");





/* Login */

define("DS_STRING_USER_LOGIN_USERNAME",             "User name:");
define("DS_STRING_USER_LOGIN_PASSWORD",             "Password:");
define("DS_STRING_USER_LOGIN_MOBILE_LAYOUT",        "Mobile version.");
define("DS_STRING_USER_LOGIN_LOGIN",                "Login");
define("DS_STRING_USER_LOGIN_TEASER",               "Don't have an account?");
define("DS_STRING_USER_LOGIN_REGISTER",             "Register!");

define( "DS_STRING_USER_LOGIN_FAILED_CREDENTIALS",  "Wrong user name or password." );
define( "DS_STRING_USER_LOGIN_FAILED_INACTIVE",     "Your account is inactive. Contact the administrator." );
define( "DS_STRING_USER_LOGIN_FAILED",              "The system could not log you in. Contact the administrator." );

define("DS_STRING_LOGIN_DISCLAIMER",                "This application is a demo. We will not guarantee preservation of any data in the application. All rights reserved.");
define("DS_STRING_LOGIN_INFO",                      "In case you find errors or inconsistencies in the application, please contact us.");





/* Registration */

define("DS_STRING_PROF_MNG_CREATE_ONE",             "Here you can create one!");
define("DS_STRING_REGISTR_TITLE",                   "Apply for an account!");
define("DS_STRING_REGISTR_GOTO_WEBPAGE",            "Go to project web page");
define("DS_STRING_REGISTR_ALREADY_HAVE_ACCOUNT",    "Already have an account?");
define("DS_STRING_REGISTR_SIGN_IN",                 "Log in!");
define("DS_STRING_REGISTR_DUNKKIS_ORG",             "Dunkkis.org");
define("DS_STRING_REGISTR_EMAIL",                   "E-mail address");
define("DS_STRING_REGISTR_EMAIL_INFO",              "Also used as your user name.");
define("DS_STRING_REGISTR_EMAIL_INVALID",           "E-mail address is invalid!");
define("DS_STRING_REGISTR_EMAIL_IN_USE",            "E-mail address is already in use!");
define("DS_STRING_REGISTR_PWD",                     "Password");
define("DS_STRING_REGISTR_PWD_TOO_SHORT_OR_ILLEGAL","Password is either too short or contains illegal characters!");
define("DS_STRING_REGISTR_WHY",                     "Why?");
define("DS_STRING_REGISTR_REASON_MUST_CONTAIN",     "Reason must contain at least two words.");
define("DS_STRING_REGISTR_APPLY_FOR_ACCOUNT_BUTTON","Apply for an account");
define("DS_STRING_REGISTR_ACC_REQ_SUCC",            "Application sent!");
define("DS_STRING_REGISTR_YOU_WILL_BE_INFORMED",    "You will receive an e-mail confirmation shortly.");





/* Navigation */

define("DS_STRING_NAV_MENU_MEASUREMENT",            "Latest Measurements");
define("DS_STRING_NAV_MENU_DEVICES",                "My MAC Devices");
define("DS_STRING_ALARM_MENU",                      "My Surveillances");
define("DS_STRING_NAV_MENU_PROFILES",               "My Profiles");
define("DS_STRING_NAV_MENU_ACCOUNT",                "My Account");
define("DS_STRING_NAV_MENU_ADMIN",                  "User Management");
define("DS_STRING_NAV_MENU_LOGOUT",                 "Logout");





/* Main page */

define("DS_STRING_MAIN_SLOGAN",                     "Better air quality,<br />&nbsp;better life with<br /><span>Open Source</span>");
define("DS_STRING_MAIN_INC_FONT",                   "Increase font size");
define("DS_STRING_MAIN_DEC_FONT",                   "Decrease font size");
define("DS_STRING_MAIN_LATEST_MEASUREMENTS",        "Latest Measurements");
define("DS_STRING_MAIN_SHOW_LATEST_STAT",           "View data");
define("DS_STRING_MAIN_CHOOSE_DEVICE",              "Device:");
define("DS_STRING_MAIN_CHOOSE_PERIOD",              "Period:");
define("DS_STRING_MAIN_CHOOSE_TODAY",               "For today");
define("DS_STRING_MAIN_CHOOSE_1_DAY",               "From yesterday");
define("DS_STRING_MAIN_CHOOSE_2_DAYS",              "From last two days");
define("DS_STRING_MAIN_CHOOSE_5_DAYS",              "From last five days");
define("DS_STRING_MAIN_CHOOSE_10_DAYS",             "From last ten days");
define("DS_STRING_MAIN_CHOOSE_15_DAYS",             "From last 15 days");
define("DS_STRING_MAIN_CHOOSE_30_DAYS",             "From last month");
define("DS_STRING_MAIN_CHOOSE_60_DAYS",             "From last two months");
define("DS_STRING_MAIN_CHOOSE_90_DAYS",             "From last three months");
define("DS_STRING_MAIN_NO_DEV_ADDED",               "No devices.");
define("DS_STRING_MAIN_NO_MAC_DEV_ADDED",           "No MAC device.");
define("DS_STRING_MAIN_SHOW_BUTTON",                "View");

define("DS_STRING_HELP_CAPTION_LATEST_MEASUREMENTS","Latest Measurements");
define("DS_STRING_HELP_CONTENT_LATEST_MEASUREMENTS","On this page you see the latest measurements collected from sensors. You may also choose a device and browse it's sensors' measurements from a chosen time interval.");





/* Latest Measurements */

define("DS_STRING_MAIN_CAPTION_STATISTICS",         "Latest Measurements");
define("DS_STRING_MSG_WAIT_LOAD",                   "Loading...");
define("PV_STR_THUMBNAIL_VIEW",                     "Thumbnails" );
define("PV_STR_THUMBNAILS",                         "Show thumbnails.") ;
define("PV_STR_IMAGE",                              "Show picture." );
define("PV_STR_FIRST",                              "First." );
define("PV_STR_PREV",                               "Previous." );
define("PV_STR_NEXT",                               "Next." );
define("PV_STR_LAST",                               "Last." );
define("PV_STR_IMG",                                "Database view." );

define("DS_STRING_HELP_CAPTION_STATISTICS",         "Latest Measurements");
define("DS_STRING_HELP_CONTENT_STATISTICS",         "On this page you see the latest measurements from the chosen device and interval.");

define( "DS_STRING_MAIN_NO_DATA_SENSOR",            "No data from sensor " );
define( "DS_STRING_MAIN_NO_DATA_BETWEEN",           " between " );
define( "PV_STR_NODATA",                            "No pictures for given interval." );





/* My MAC Devices */

define("DS_STRING_MAIN_CAPTION_MAC_DEVS",           "My MAC Devices");
define("DS_STRING_MAIN_CAPTION_DEV_ADD",            "Add a MAC Device");
define("DS_STRING_PROF_MNG_INSERT_MAC",             "MAC address");
define("DS_STRING_PROF_MNG_SET_DEV_NAME",           "Name");
define("DS_STRING_PROF_MNG_SUBMIT_BUTTON",          "Add");
define("DS_STRING_PROF_MNG_NAME",                   "Name");
define("DS_STRING_PROF_MNG_MAC",                    "MAC Address");
define("DS_STRING_PROF_MNG_ACTION",                 "Manage");
define("DS_STRING_PROF_MNG_MANAGE",                 "Edit profiles");
define("DS_STRING_PROF_MNG_REMOVE",                 "Remove");

define("DS_STRING_MAC_MNG_BIND_NO_INFO",            "Please fill in both fields!");
define("DS_STRING_MAC_MNG_BIND_MAC_IN_USE",         "MAC address is already in use! ");
define("DS_STRING_MAC_MNG_BIND_TO_USER_SUCC",       "Added a MAC device for user ");
define("DS_STRING_MAC_MNG_BIND_TO_USER_AS",         " with name ");
define("DS_STRING_DEV_MNG_DEV_REM_SUCC",            "MAC device removed.");
define("DS_STRING_DEV_MNG_DEV_REM_ERR",             "Could not remove MAC device. Contact system administrator.");
define("DS_STRING_MAC_MNG_BIND_MAC_INVALID",        "Could not add MAC device. Contact system administrator.");

define("DS_STRING_HELP_CAPTION_DEV_MAIN",           "My MAC Devices");
define("DS_STRING_HELP_CONTENT_DEV_MAIN",           "On this page you can add and remove your MAC devices.<br /><i>MAC address</i> is a string like XX:XX:XX:XX:XX:XX, where X is an hexadecimal number. You can locate the address on your device or ask your system administrator.<br />You may choose a <i>name</i> for the device, so you can easily recongnize it later.<br /><b>N.B.! Removing the MAC device cannot be reversed and also removes the devices and sensors attached to the MAC device.</b>");





/* My Monitorings */

define("DS_STRING_ALARM_MAINPAGE",                  "My Surveillances");
define("DS_STRING_ALARM_SETTINGS_NAV_BACK",         "Previous");
define("DS_STRING_ALARM_SETTINGS_NAV_NEXT",         "Next");
define("DS_STRING_ALARM_SETTINGS_LINK_NEW",         "Create a surveillance.");
define("DS_STRING_ALARM_HISTORY_LINK_ALL",          "Browse history.");
define("DS_STRING_ALARM_MNG_NAME",                  "Name");
define("DS_STRING_ALARM_MNG_SCHEDULE",              "Triggers");
define("DS_STRING_ALARM_MNG_SENSORS",               "Sensors");
define("DS_STRING_ALARM_MNG_CONTACTS",              "Contact Persons");
define("DS_STRING_ALARM_MNG_MANAGE",                "Manage");
define("DS_STRING_ALARM_MNG_SAVE",                  "Save");
define("DS_STRING_ALARM_MNG_EDIT_ALARM",            "Edit surveillance.");
define("DS_STRING_ALARM_MNG_HISTORY",               "Browse history.");
define("DS_STRING_ALARM_MNG_DELETE",                "Remove surveillance.");
define("DS_STRING_ALARM_NEW_ALARM",                 "My Surveillances - New Surveillance");
define("DS_STRING_ALARM_SETTINGS_PAGE",             "My Surveillances - Edit Surveillance");
define("DS_STRING_ALARM_NEW_PAGE",                  "Create a Surveillance");
define("DS_STRING_ALARM_EDIT_PAGE",                 "Edit Surveillance");
define("DS_STRING_ALARM_MNG_ALARM_NAME",            "Name:");
define("DS_STRING_ALARM_MNG_ALARM_TYPE",            "Notification method:");
define("DS_STRING_ALARM_MNG_SMS",                   "SMS");
define("DS_STRING_ALARM_MNG_EMAIL",                 "E-Mail");
define("DS_STRING_ALARM_MNG_COMPOSITE",             "Both");
define("DS_STRING_ALARM_MNG_SMALL_MSG",             "Short message:<br>(SMS / E-Mail subject)<br>");
define("DS_STRING_ALARM_MNG_BIG_MSG",               "Long message:<br>(E-Mail body)<br>");
define("DS_STRING_ALARM_MNG_NEW",                   "New surveillance");
define("DS_STRING_ALARM_MNG_EDIT",                  "Save changes");

define("DS_STRING_ALARM_CONFIRM_QUESTION_DEFAULT",  "Are you sure that you want to remove the surveillance?");
define("DS_STRING_ALARM_CONFIRM_QUESTION_HISTORY",  "Are you sure that you want to erase the history?");
define("DS_STRING_ALARM_CONFIRM_YES",               "Yes");
define("DS_STRING_ALARM_CONFIRM_NO",                "No");

define("DS_STRING_HELP_CAPTION_ALARM_MAIN",         "My Surveillances");
define("DS_STRING_HELP_CONTENT_ALARM_MAIN",         "On this page you can create, edit and remove surveillances. You can also browse the surveillanes' statistics.<br /><i>Surveillances</i> allow you to get notified when a sensor's value crosses given limits, or \"triggers\" the surveillance. All triggerings are saved into the history.<br />The lamp in <i>sensors</i> column tells you whether the sensor is active, that is whether it can trigger a surveillance. You can change the sensor's state by clicking the lamp. Yellow lamp means the sensor is active.");
define("DS_STRING_HELP_CAPTION_ALARM_SETTINGS",     "Edit Surveillance");
define("DS_STRING_HELP_CONTENT_ALARM_SETTINGS",     "On this page you can create a new surveillance or edit an existing one.<br />You can choose the <i>name</i> of the surveillance freely to help you distinguish between different surveillances.<br /><i>Notification method</i> specifiy how contact persons may be notified when the surceillance is triggered.<br /><i>Short message</i> is used as the SMS notification and as the subject of the e-mail notification.<br /><i>Long message</i> is the body of the e-mail notification.<br /><b>N.B.! Actual notifications will not be sent in the DEMO version.</b>");





/* My Monitorings - History */

define("DS_STRING_ALARM_HISTORY_PAGE",              "My Surveillances - Browse History");
define("DS_STRING_ALARM_HISTORY_NAV_CLEAR",         "Clear history");
define("DS_STRING_ALARM_HISTORY_TIME",              "Time");
define("DS_STRING_ALARM_HISTORY_ALARM_NAME",        "Surveillance");
define("DS_STRING_ALARM_HISTORY_SCHEDULE_NAME",     "Trigger");
define("DS_STRING_ALARM_HISTORY_SENSOR_NAME",       "Sensor");
define("DS_STRING_ALARM_HISTORY_VALUE",             "Sensor's Value");

define("DS_STRING_HELP_CAPTION_ALARM_HISTORY",      "Browse History");
define("DS_STRING_HELP_CONTENT_ALARM_HISTORY",      "On this page you can browse the history for the chosen surveillance.");

define("DS_STRING_STAT_NO_DATA_BETWEEN",            "No history for interval ");





/* My Monitorings - My Schedules */

define("DS_STRING_ALARM_SCHEDULE_PAGE",             "My Surveillances - My Triggers");
define("DS_STRING_ALARM_NEW_SCHEDULE_PAGE",         "My Surveillances - New Trigger");
define("DS_STRING_ALARM_EDIT_SCHEDULE_PAGE",        "My Surveillances - Edit Trigger");
define("DS_STRING_ALARM_NEW_TRIGGER",               "Create a New Trigger");
define("DS_STRING_ALARM_EDIT_TRIGGER",              "Edit Trigger");
define("DS_STRING_ALARM_SCHEDULES_NAV_BACK",        "Previous");
define("DS_STRING_ALARM_SCHEDULES_NAV_NEXT",        "Next");
define("DS_STRING_ALARM_MNG_SCHEDULE_NAME",         "Name");
define("DS_STRING_ALARM_SCHEDULE_LINK_ADD",         "Add to surveillance.");
define("DS_STRING_ALARM_SCHEDULE_LINK_REM",         "Remove from surveillance.");
define("DS_STRING_ALARM_SCHEDULE_LINK_EDIT",        "Edit trigger.");
define("DS_STRING_ALARM_SCHEDULE_LINK_DEL",         "Remove trigger.");
define("DS_STRING_ALARM_MNG_SCHEDULE_NAME_EDIT",    "Name:");
define("DS_STRING_ALARM_MNG_SCHEDULE_VALUES",       "Sensor's value:");
define("DS_STRING_ALARM_MNG_MIN_VALUE",             "Minimum:");
define("DS_STRING_ALARM_MNG_MAX_VALUE",             "Maximum:");
define("DS_STRING_ALARM_MNG_TRIGGER_WITHIN",        "Triggers inside limits.");
define("DS_STRING_ALARM_MNG_TRIGGER_OUTSIDE",       "Triggers outside limits.");
define("DS_STRING_ALARM_MNG_TIME",                  "Time:");
define("DS_STRING_ALARM_MNG_ALWAYS",                "Always:");
define("DS_STRING_ALARM_MNG_MONTHS",                "During months:");
define("DS_STRING_ALARM_MNG_ALL_MONTHS",            "During all months.");
define("DS_STRING_ALARM_MNG_SELECTED_MONTHS",       "During selected months:");
define("DS_STRING_ALARM_MNG_JAN",                   "Jan");
define("DS_STRING_ALARM_MNG_FEB",                   "Feb");
define("DS_STRING_ALARM_MNG_MAR",                   "Mar");
define("DS_STRING_ALARM_MNG_APR",                   "Apr");
define("DS_STRING_ALARM_MNG_MAY",                   "May");
define("DS_STRING_ALARM_MNG_JUN",                   "Jun");
define("DS_STRING_ALARM_MNG_JUL",                   "Jul");
define("DS_STRING_ALARM_MNG_AUG",                   "Aug");
define("DS_STRING_ALARM_MNG_SEP",                   "Sep");
define("DS_STRING_ALARM_MNG_OCT",                   "Oct");
define("DS_STRING_ALARM_MNG_NOV",                   "Nov");
define("DS_STRING_ALARM_MNG_DEC",                   "Dec");
define("DS_STRING_ALARM_MNG_DAYS",                  "During days:");
define("DS_STRING_ALARM_MNG_ALL_DAYS",              "During all days.");
define("DS_STRING_ALARM_MNG_SELECT_DAYS",           "During selected days:");
define("DS_STRING_ALARM_MNG_SUN",                   "Sun");
define("DS_STRING_ALARM_MNG_MON",                   "Mon");
define("DS_STRING_ALARM_MNG_TUE",                   "Tue");
define("DS_STRING_ALARM_MNG_WED",                   "Wed");
define("DS_STRING_ALARM_MNG_THU",                   "Thu");
define("DS_STRING_ALARM_MNG_FRI",                   "Fri");
define("DS_STRING_ALARM_MNG_SAT",                   "Sat");
define("DS_STRING_ALARM_MNG_ALL_DAY",               "All day (24h):");
define("DS_STRING_ALARM_MNG_START_TIME",            "At earliest:");
define("DS_STRING_ALARM_MNG_END_TIME",              "At latest:");
define("DS_STRING_ALARM_MNG_ALL_YEAR",              "All year:");
define("DS_STRING_ALARM_MNG_START_DATE",            "Starting from:");
define("DS_STRING_ALARM_MNG_END_DATE",              "Ending to:");
define("DS_STRING_ALARM_MNG_HH_MM_SS",              "(hh:mm:ss)");
define("DS_STRING_ALARM_MNG_YYYY_MM_DD_HH_MM_SS",   "(yyyy-mm-dd hh:mm:ss)");

define("DS_STRING_ALARM_SCHEDULE_MSG_APPEND",       "<font color=\"green\">Trigger added to surveillance.</font>");
define("DS_STRING_ALARM_SCHEDULE_MSG_REMOVED",      "<font color=\"green\">Trigger removed from surveillance.</font>");
define("DS_STRING_ALARM_SCHEDULE_MSG_ADDED",        "<font color=\"green\">Trigger was created successfully.</font>");
define("DS_STRING_ALARM_SCHEDULE_MSG_DELETED",      "<font color=\"green\">Trigger was removed successfully.</font>");
define("DS_STRING_ALARM_SCHEDULE_MSG_EDITED",       "<font color=\"green\">Trigger was saved successfully.</font>");

define("DS_STRING_HELP_CAPTION_ALARM_SCHEDULE",     "My Triggers");
define("DS_STRING_HELP_CONTENT_ALARM_SCHEDULE",     "On this page you can create new triggers, edit or remove existing triggers and add or remove triggers to/from the surveillance.<br />You can choose the <i>name</i> of the trigger freely, to help you distinguish between different triggers.<br /><i>Sensor's value</i> defines the limits, inside or outside of which the surveillance is triggered.<br /><i>Time</i> defines when the surveillance can trigger.<br /><i>Always</i> triggers the surveillance whenever the sensor's value differs from specified values. If you wish, you may also choose specific months and/or days.<br /><i>All day (24h)</i> means that the surveillance can trigger 24 hours a day. If you wish, you may specify a smaller time interval.<br /><i>All year</i> means that the surveillance can trigger all year round. If you wish, you may specify the dates and times, between which the surveillance can trigger.<br />Note that the above selections are not exclusive. You may well specify, that the alarm can trigger between 1.1.2010 and 31.5.2010, on Mondays and Thursdays in January, March and May between 12:00 and 23:00.");






/* My Monitorings - My Sensors */

define("DS_STRING_ALARM_SENSORS_PAGE",              "My Surveillances - My Sensors");
define("DS_STRING_ALARM_SENSORS_NAV_BACK",          "Previous");
define("DS_STRING_ALARM_SENSORS_NAV_NEXT",          "Next");
define("DS_STRING_ALARM_MNG_SENSOR_NAME",           "Sensor");
define("DS_STRING_ALARM_MNG_DEVICE_NAME",           "Device");
define("DS_STRING_ALARM_MNG_PROFILE_NAME",          "Profile");
define("DS_STRING_ALARM_MNG_ENABLED",               "State");
define("DS_STRING_ALARM_MNG_AUTOENABLE",            "Auto enable?");
define("DS_STRING_ALARM_SENSOR_AUTOENABLE",         "Yes");
define("DS_STRING_ALARM_SENSOR_NOAUTOENABLE",       "No");
define("DS_STRING_ALARM_SENSOR_ENABLED",            "Inactivate.");
define("DS_STRING_ALARM_SENSOR_DISABLED",           "Activate.");
define("DS_STRING_ALARM_SENSOR_LINK_ADD",           "Add to surveillance.");
define("DS_STRING_ALARM_SENSOR_LINK_DEL",           "Remove from surveillance.");

define("DS_STRING_ALARM_SENSOR_MSG_APPEND",         "<font color=\"green\">Sensor added to surveillance.</font>");
define("DS_STRING_ALARM_SENSOR_MSG_REMOVED",        "<font color=\"green\">Sensor removed from surveillance.</font>");
define("DS_STRING_ALARM_SENSOR_MSG_ENABLED",        "<font color=\"green\">Sensor is active.</font>");
define("DS_STRING_ALARM_SENSOR_MSG_DISABLED",       "<font color=\"green\">Sensor is inactive.</font>");
define("DS_STRING_ALARM_SENSOR_MSG_AUTOENABLE",     "<font color=\"green\">Sensor auto enable is active.</font>");
define("DS_STRING_ALARM_SENSOR_MSG_NOAUTOENABLE",   "<font color=\"green\">Sensor auto enable is inactive.</font>");

define("DS_STRING_HELP_CAPTION_ALARM_SENSORS",      "My Sensors");
define("DS_STRING_HELP_CONTENT_ALARM_SENSORS",      "On this page you can add or remove sensors from the surveillance.<br />The lamp in <i>sensors</i> column tells you whether the sensor is active, that is whether it can trigger a surveillance. You can change the sensor's state by clicking the lamp. Yellow lamp means the sensor is active.<br />\"Yes\" in <i>auto enable</i> column means that the sensor stays active even if it triggers a surveillance. You may disable the feature by clicking the text. If auto enable is disabled, you have to manually enable the sensor every time it triggers this surveillance.");





/* My Monitorings - My Contacts */

define("DS_STRING_ALARM_CONTACTS_PAGE",             "My Surveillances - My Contact Persons");
define("DS_STRING_ALARM_CONTACTS_NAV_BACK",         "Previous");
define("DS_STRING_ALARM_CONTACTS_NAV_NEXT",         "Complete");
define("DS_STRING_ALARM_CONTACTS_NAME",             "Name");
define("DS_STRING_ALARM_CONTACTS_EMAIL",            "E-mail address");
define("DS_STRING_ALARM_MNG_PHONE",                 "Phone number");
define("DS_STRING_ALARM_CONTACTS_LINK_SMS_ADD",     "Add to SMS recipients.");
define("DS_STRING_ALARM_CONTACTS_LINK_SMS_DEL",     "Remove from SMS recipients.");
define("DS_STRING_ALARM_CONTACTS_LINK_EMAIL_ADD",   "Add to e-mail recipients.");
define("DS_STRING_ALARM_CONTACTS_LINK_EMAIL_DEL",   "Remove from e-mail recipients.");
define("DS_STRING_ALARM_CONTACTS_LINK_EDIT",        "Edit contact person.");
define("DS_STRING_ALARM_CONTACTS_LINK_DEL",         "Remove contact person.");
define("DS_STRING_ALARM_MNG_ADD_NEW_CONTACT",       "Create a new contact person");
define("DS_STRING_ALARM_MNG_EDIT_CONTACT",          "Edit contact person");
define("DS_STRING_ALARM_MNG_CONTACT_NAME",          "Name:");
define("DS_STRING_ALARM_MNG_CONTACT_EMAIL",         "E-mail address:"); 
define("DS_STRING_ALARM_MNG_CONTACT_PHONE",         "Phone number:");
define("DS_STRING_ALARM_MNG_NEW_CONTACT",           "Create");


define("DS_STRING_ALARM_CONTACTS_MSG_ADDED",        "<font color=\"green\">Contact person created.</font>");
define("DS_STRING_ALARM_CONTACTS_MSG_DELETED",      "<font color=\"green\">Contact person removed.</font>");
define("DS_STRING_ALARM_CONTACTS_MSG_EDITED",       "<font color=\"green\">Contact person was saved successfully.</font>");
define("DS_STRING_ALARM_CONTACTS_MSG_APPEND_SMS",   "<font color=\"green\">Contact person added to SMS recipients.</font>");
define("DS_STRING_ALARM_CONTACTS_MSG_APPEND_EMAIL", "<font color=\"green\">Contact person added to e-mail recipients.</font>");
define("DS_STRING_ALARM_CONTACTS_MSG_REMOVED_SMS",  "<font color=\"green\">Contact person removed from SMS recipients.</font>");
define("DS_STRING_ALARM_CONTACTS_MSG_REMOVED_EMAIL","<font color=\"green\">Contact person removed from e-mail recipients.</font>");

define("DS_STRING_HELP_CAPTION_ALARM_CONTACTS",     "My Contact Persons");
define("DS_STRING_HELP_CONTENT_ALARM_CONTACTS",     "On this page you can create and edit contact persons and add the as notification recipients of your surveillance.<br /><b>N.B.! Actual notifications will not be sent in the DEMO version.</b>");





/* My Profiles */

define("DS_STRING_MAIN_CAPTION_PROFILES",           "My Profiles");
define("DS_STRING_PROF_MNG_PROFILE_INFO",           "Create a profile");
define("DS_STRING_PROF_MNG_PROFILE_OWNER",          "User name:");
define("DS_STRING_PROF_MNG_PROFILE_NAME",           "Profile name:");
define("DS_STRING_PROF_MNG_PROFILE_PWD",            "Password:");
define("DS_STRING_PROF_MNG_PROFILE_CONFIRM_PWD",    "Confirm password:");
define("DS_STRING_PROF_MNG_CREATE_PROF_BUTTON",     "Create");
define("DS_STRING_PROF_PROFILES",                   "My Profiles");
define("DS_STRING_PROF_MNG_PROFILE_NAME_TBL",       "Profile Name");
define("DS_STRING_PROF_MNG_GW_NAME",                "Devices (MAC Device)");
define("DS_STRING_PROF_ADD_MAC",                    "Add a MAC device");
define("DS_STRING_PROF_MNG_ADD_DEVICE",             "Add a device");
define("DS_STRING_PROF_MNG_DELETE_THIS_PROFILE",    "Remove");
define("DS_STRING_PROF_MNG_EDIT",                   "Edit devices");

define("DS_STRING_PROF_MNG_PROFILE_NAME_EMPTY",     "You must name the profile!");
define("DS_STRING_PROF_MNG_PROFILE_EXISTS",         "Profile with the same name exist already!");
define("DS_STRING_PROF_MNG_PWD_MISMATCH_OR_SHORT",  "Password was too short or didn't match each other.");
define("DS_STRING_PROF_MNG_CREATE_SUCC",            "Profile created.");
define("DS_STRING_PROF_MNG_PROFILE_REMOVED_BEGIN",  "Profile < ");
define("DS_STRING_PROF_MNG_PROFILE_REMOVED_END",    " > removed!");
define("DS_STRING_PROF_MNG_PROFILE_REMOVE_ERROR_BEGIN","Could not remove profile < ");
define("DS_STRING_PROF_MNG_PROFILE_REMOVE_ERROR_END"," >. Contact the system administrator.");

define("DS_STRING_HELP_CAPTION_PROF_MAIN",          "My Profiles");
define("DS_STRING_HELP_CONTENT_PROF_MAIN",          "On this page you can create, edit and remove profiles.<br /><i>Profiles</i> allow you to create different views to your system's devices. They also enable third parties to access the system through the profiles you give them access to.");





/* My Profiles - Edit profile */

define("DS_STRING_MAIN_CAPTION_ADD_DEV_TO_PROF",    "Edit profile ");
define("DS_STRING_PROF_MNG_PROFILE",                "Profile");
define("DS_STRING_PROF_MNG_DEVICE",                 "Device");
define("DS_STRING_PROF_MNG_DEV_NAME",               "Rename Device:");
define("DS_STRING_PROF_MNG_UPDATE",                 "Rename");
define("DS_STRING_PROF_MNG_ADD_TO_PROF",            "Add to profile");
define("DS_STRING_PROF_MNG_REMOVE_FROM_PROF",       "Remove from profile");
define("DS_STRING_PROF_MNG_SENSORS",                "Sensors");
define("DS_STRING_PROF_MNG_SHOW_INFO",              "Show sensors");
define("DS_STRING_PROF_MNG_SENSOR_ID",              "Address");
define("DS_STRING_PROF_MNG_SENSOR_TYPE",            "Type");
define("DS_STRING_PROF_MNG_SET_SENSOR_NAME",        "Rename Sensor:");

define("DS_STRING_DEV_MNG_DEV_UPD_NAME_ERROR",              "Device could not be renamed:<b>");
define("DS_STRING_DEV_MNG_DEV_UPD_NAME_SUCC",               "Device renamed: ");
define("DS_STRING_DEV_MNG_DEV_ADD_TO_PROF_ERROR_BEGIN",     "Device <b>");
define("DS_STRING_DEV_MNG_DEV_ADD_TO_PROF_ERROR_END",       " could not be added to profile</b>");
define("DS_STRING_DEV_MNG_DEV_ADD_TO_PROF_SUCC",            "Device added to profile:");
define("DS_STRING_DEV_MNG_DEV_ADD_TO_PROF_SUCC_BEGIN",      "Device <");
define("DS_STRING_DEV_MNG_DEV_ADD_TO_PROF_SUCC_END",        "> added to profile: ");
define("DS_STRING_DEV_MNG_DEV_REM_FROM_PROF_ERROR_BEGIN",   "Device <");
define("DS_STRING_DEV_MNG_DEV_REM_FROM_PROF_ERROR_END",     "> could not be removed from profile: ");
define("DS_STRING_DEV_MNG_DEV_REM_FROM_PROF_SUCC_BEGIN",    "Device <");
define("DS_STRING_DEV_MNG_DEV_REM_FROM_PROF_SUCC_END",      "> removed from profile: ");
define("DS_STRING_SENSOR_MNG_UPDATED",                      "Sensor renamed.");

define("DS_STRING_HELP_CAPTION_PROF_PROP",          "Edit profile");
define("DS_STRING_HELP_CONTENT_PROF_PROP",          "On this page you may add or remove devices from the selected profile.<br />If a device is added to a profile, you can rename it by typing in a name in the <i>rename device</i> field and clicking the <i>rename</i> button. The name only affects the edited profile.<br />You can view the sensor's devices by clicking <i>Show sensors</i>.<br />You can rename sensors similarily to a device.");





/* My Account */

define( "DS_STRING_USER_ACCOUNT_CAPTION",           "My Account" );
define( "DS_STRING_USER_CHANGE_PASSWORD_CAPTION",   "Change My Password" );
define( "DS_STRING_USER_CURRENT_PASSWORD",          "Current password:" );
define( "DS_STRING_USER_NEW_PASSWORD",              "New password:" );
define( "DS_STRING_USER_CONFIRM_PASSWORD",          "Confirm new password:" );
define( "DS_STRING_USER_CHANGE_PASSWORD",           "Change" );

define( "DS_STRING_USER_ACCOUNT_REMOVE_CAPTION",    "Remove My Account" );
define( "DS_STRING_USER_ACCOUNT_REMOVE",            "Remove" );

define( "DS_STRING_USER_ACCOUNT_REMOVE_CONFIRM",    "Are you sure that you want to remove your user account?" );
define( "DS_STRING_USER_ACCOUNT_REMOVE_FAILED",     "Removing your user account failed. Contact the system administrator." );
define( "DS_STRING_USER_ACCOUNT_CHANGEPW_FAILED",   "Changing your password failed. Check the passwords." );
define( "DS_STRING_USER_ACCOUNT_CHANGEPW_SUCCESS",  "Password changed." );

define("DS_STRING_USER_ACCOUNT_HELP",               "On this page you can change your password or remove your account.<br /><b>N.B.! The removal of your account cannot be reversed. All information related to you will be removed immediately after you accept the removal confirmation.</b>");





/* User Management */

define("DS_STRING_MAIN_CAPTION_MANAGE_USERS",       "User Management");
define("DS_STRING_USR_MNG_USER_MANAGEMENT",         "User Account Management");
define("DS_STRING_USR_MNG_PENDING_REQ_MANAGEMENT",  "Account Request Management");
define( "DS_STRING_YES",                            "Yes" );
define( "DS_STRING_NO",                             "No" );

define( "DS_STRING_USER_SYSTEM_ERROR",              "System error. Contact administrator." );

define("DS_STRING_HELP_CAPTION_ADMIN",              "User Management");
define("DS_STRING_HELP_CONTENT_ADMIN",              "From this page you can navigate to user account management or account request management.");





/* User Management - Account Management */

define( "DS_STRING_USER_USERS_CAPTION",             "User Account Management" );
define( "DS_STRING_USER_EMAIL_ADDRESS",             "E-Mail Address" );
define( "DS_STRING_USER_ACCOUNT_CREATED",           "Account Created" );
define( "DS_STRING_USER_LAST_LOGIN",                "Last Login" );
define( "DS_STRING_USER_VISITS",                    "Logins" );
define( "DS_STRING_USER_STATUS",                    "State" );
define( "DS_STRING_USER_ROLE",                      "Role" );
define( "DS_STRING_USER_MANAGE",                    "Manage" );
define( "DS_STRING_USER_ACTIVE",                    "Active" );
define( "DS_STRING_USER_INACTIVE",                  "Inactive" );
define( "DS_STRING_USER_ADMIN",                     "Administrator" );
define( "DS_STRING_USER_USER",                      "User" );
define( "DS_STRING_USER_ACTIVATE",                  "Activate" );
define( "DS_STRING_USER_INACTIVATE",                "Inactivate" );
define( "DS_STRING_USER_USERIZE",                   "Make user" );
define( "DS_STRING_USER_ADMINIZE",                  "Make administrator" );
define( "DS_STRING_USER_REMOVE",                    "Remove" );
define( "DS_STRING_USER_MANAGE_REQUESTS",           "To account request management...");

define( "DS_STRING_USER_REMOVE_CONFIRM",            "Are you sure you want to remove the user?" );
define( "DS_STRING_USER_TOGGLE_ROLE_FAILED",        "Role could not be changed." );
define( "DS_STRING_USER_TOGGLE_ROLE_SUCCESS",       "Role changed." );
define( "DS_STRING_USER_TOGGLE_STATUS_FAILED",      "State could not be changed." );
define( "DS_STRING_USER_TOGGLE_STATUS_SUCCESS",     "State changed." );
define( "DS_STRING_USER_REMOVE_FAILED",             "User could not be removed." );
define( "DS_STRING_USER_REMOVE_SUCCESS",            "User removed." );

define("DS_STRING_USER_USERS_HELP",                 "On this page you can control the users' access to the system, change users' roles and remove users.<br />You can deny the user access into the system by clicking the <i>inactivate</i> button or vice versa. If an user's account is active, the user is notified of it on login and the login request is denied.<br />You can make an user into an administrator by clicking the <i>make administrator</i> button or vice versa.<br /><b>N.B.! Once an user is given administrator priviledges, he or she may inactivate your account.</b>");





/* User Management - Account Request Management */

define( "DS_STRING_USER_REQUESTS_CAPTION",          "Account Request Manangement" );
define( "DS_STRING_USER_REQUEST_DATE",              "Date" );
define( "DS_STRING_USER_REQUEST_REASON",            "Reason" );
define( "DS_STRING_USER_APPROVE_REQUEST",           "Accept" );
define( "DS_STRING_USER_DECLINE_REQUEST",           "Decline" );
define( "DS_STRING_USER_NO_REQUESTS",               "No account requests." );
define( "DS_STRING_USR_MNG_USERS",                  "To user account management..." );

define( "DS_STRING_USER_DECLINE_CONFIRM",           "Are you sure that you want to decline the application?" );
define( "DS_STRING_USER_APPROVE_FAILED",            "Application could not be approved. Contact system administrator" );
define( "DS_STRING_USER_APPROVE_SUCCESS",           "Application approved." );
define( "DS_STRING_USER_DECLINE_FAILED",            "Application could not be declined. Contact sustem administrator." );
define( "DS_STRING_USER_DECLINE_SUCCESS",           "Application declined." );

define("DS_STRING_USER_REQUESTS_HELP",              "On this page you can approve or decline pending account requests.<br /><b>N.B.! Once you decline an account request, the request is permanently lost and cannot be retrieved.");

?>
