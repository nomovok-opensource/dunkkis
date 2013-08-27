<?php

/** Dunkkis Web User Interface
  * ==========================
  * French translation
  * 
  * Copyright (c) 2009-2010 Nomovok Ltd
  * This software is licensed under The MIT License. See LICENSE for details.
  *
  * @author Juha Hytonen - juha.hytonen@nomovok.com
  */





include_once( "ds-sensor-strings.inc.php" );





/* General */

define("DS_STRING_MAIN_GENERIC",                "G&eacute;n&eacute;ral");
define("DS_STRING_MAIN_TEMPERATURE",            "Temp&eacute;rature");
define("DS_STRING_MAIN_HUMIDITY",               "Humidit&eacute;");
define("DS_STRING_MAIN_AIR_PRESSURE",           "Pression atmosph&eacute;rique");
define("DS_STRING_MAIN_SPECIAL",                "Divergent");
define("DS_STRING_MAIN_CO2",                    "CO2");
define("DS_STRING_MAIN_DOOR",                   "Porte");
define("DS_STRING_MAIN_MOTION",                 "D&eacute;tecteur du mouvement");
define("DS_STRING_MAIN_SWITCH",                 "Commutateur");
define("DS_STRING_MAIN_CUSTOM",                 "Mukautettu"); /// @fixme
define("DS_STRING_MAIN_LDR",                    "LDR");
define("DS_STRING_MAIN_PICTURE",                "Image");





/* Login */

define("DS_STRING_USER_LOGIN_USERNAME",             "Nom d'utilisateur:");
define("DS_STRING_USER_LOGIN_PASSWORD",             "Mot de passe:");
define("DS_STRING_USER_LOGIN_MOBILE_LAYOUT",        "Version mobile.");
define("DS_STRING_USER_LOGIN_LOGIN",                "Connexion");
define("DS_STRING_USER_LOGIN_TEASER",               "Vous n'avez pas un relev&eacute; d'utilisateur?");
define("DS_STRING_USER_LOGIN_REGISTER",             "Enregistrer!");

define( "DS_STRING_USER_LOGIN_FAILED_CREDENTIALS",  "Le nom d'utilisateur ou le mot de passe &agrave; &egrave;t&egrave; invalid." );
define( "DS_STRING_USER_LOGIN_FAILED_INACTIVE",     "Votre relev&eacute; utilisateur n'est pas actif." );
define( "DS_STRING_USER_LOGIN_FAILED",              "Connexion a faili." );

define("DS_STRING_LOGIN_DISCLAIMER",                "Ce logiciel est un version de d&eacute;monstration. Nous ne garantons pas la conservation des donn&eacute;es. Tous droits r&eacute;serv&eacute;s.");
define("DS_STRING_LOGIN_INFO",                       "Quand vous trouvez bogues ou inconstances, s'il vous plait et contactez nous.");





/* Registration */ /// NOTE: Not needed ATM.

define("DS_STRING_PROF_MNG_CREATE_ONE",                             "Täällä voit luoda sellaisen!");
define("DS_STRING_REGISTR_TITLE",                                   "Ano käyttäjätiliä!");
define("DS_STRING_REGISTR_GOTO_WEBPAGE",                            "Siirry projektin sivuille");
define("DS_STRING_REGISTR_ALREADY_HAVE_ACCOUNT",                    "Omistat jo käyttäjätilin?");
define("DS_STRING_REGISTR_SIGN_IN",                                 "Kirjaudu sisään!");
define("DS_STRING_REGISTR_DUNKKIS_ORG",                             "Dunkkis.org");
define("DS_STRING_REGISTR_EMAIL",                                   "Sähköpostiosoite");
define("DS_STRING_REGISTR_EMAIL_INFO",                              "Käytetään myös käyttäjätunnuksenasi.");
define("DS_STRING_REGISTR_EMAIL_INVALID",                           "Sähköpostiosoite ei kelpaa!");
define("DS_STRING_REGISTR_EMAIL_IN_USE",                            "Sähköpostiosoite on jo käytössä!");
define("DS_STRING_REGISTR_PWD",                                     "Salasana");
define("DS_STRING_REGISTR_PWD_TOO_SHORT_OR_ILLEGAL",                "Salasana on liian lyhyt tai se sisältää sopimattomia merkkejä!");
define("DS_STRING_REGISTR_WHY",                                     "Miksi?");
define("DS_STRING_REGISTR_REASON_MUST_CONTAIN",                     "Perusteen täytyy sisältää vähintään kaksi sanaa!");
define("DS_STRING_REGISTR_APPLY_FOR_ACCOUNT_BUTTON",                "Ano käyttäjätiliä");
define("DS_STRING_REGISTR_ACC_REQ_SUCC",                            "Käyttäjätilianomus lähetetty!");
define("DS_STRING_REGISTR_YOU_WILL_BE_INFORMED",                    "Saat sähköposti-ilmoituksen piakkoin.");





/* Navigation */

define("DS_STRING_NAV_MENU_MEASUREMENT",            "Statistiques nouvelles");
define("DS_STRING_NAV_MENU_DEVICES",                "Mes appareils MAC");
define("DS_STRING_ALARM_MENU",                      "Mes surveillances");
define("DS_STRING_NAV_MENU_PROFILES",               "Mes profiles");
define("DS_STRING_NAV_MENU_ACCOUNT",                "Mon relev&eacute; utilisateur");
define("DS_STRING_NAV_MENU_ADMIN",                  "Gestion des utilisateurs");
define("DS_STRING_NAV_MENU_LOGOUT",                 "Disconnexion");





/* Main page */

define("DS_STRING_MAIN_SLOGAN",                     "Better air quality,<br />&nbsp;better life with<br /><span>Open Source</span>");
define("DS_STRING_MAIN_INC_FONT",                   "Agrandir"); 
define("DS_STRING_MAIN_DEC_FONT",                   "R&eacute;duire"); 
define("DS_STRING_MAIN_LATEST_MEASUREMENTS",        "Statistiques nouvelles");
define("DS_STRING_MAIN_SHOW_LATEST_STAT",           "&Eacute;tudier les statistiques");
define("DS_STRING_MAIN_CHOOSE_DEVICE",              "L'appareil:");
define("DS_STRING_MAIN_CHOOSE_PERIOD",              "Le period:");
define("DS_STRING_MAIN_CHOOSE_TODAY",               "Pendant aujourd'hui");
define("DS_STRING_MAIN_CHOOSE_1_DAY",               "Pendant hier");
define("DS_STRING_MAIN_CHOOSE_2_DAYS",              "Pendant deux jours");
define("DS_STRING_MAIN_CHOOSE_5_DAYS",              "Pendant cinq jours");
define("DS_STRING_MAIN_CHOOSE_10_DAYS",             "Pendant dix jours");
define("DS_STRING_MAIN_CHOOSE_15_DAYS",             "Pendant 15 jours");
define("DS_STRING_MAIN_CHOOSE_30_DAYS",             "Pendant un mois");
define("DS_STRING_MAIN_CHOOSE_60_DAYS",             "Pendant deux mois");
define("DS_STRING_MAIN_CHOOSE_90_DAYS",             "Pendant trois mois");
define("DS_STRING_MAIN_NO_DEV_ADDED",               "Pas des appareils.");
define("DS_STRING_MAIN_NO_MAC_DEV_ADDED",           "Pas des appareils MAC.");
define("DS_STRING_MAIN_SHOW_BUTTON",                "Visualiser");

define("DS_STRING_HELP_CAPTION_LATEST_MEASUREMENTS",        "Statistiques nouvelles");
define("DS_STRING_HELP_CONTENT_LATEST_MEASUREMENTS",        "On this page you see the latest measurements collected from sensors. You may also choose a device and browse it's sensors' measurements from a chosen time interval.");





/* Latest Measurements */

define("DS_STRING_MAIN_CAPTION_STATISTICS",         "Statistiques nouvelles");
define("DS_STRING_MSG_WAIT_LOAD",                   "Attendez-vous...");
define("PV_STR_THUMBNAIL_VIEW",                     "Imagettes" );
define("PV_STR_THUMBNAILS",                         "Imagettes.") ;
define("PV_STR_IMAGE",                              "Images." );
define("PV_STR_FIRST",                              "Premi&eacute;re image." );
define("PV_STR_PREV",                               "Derni&egrave;re image." );
define("PV_STR_NEXT",                               "Image suivante." );
define("PV_STR_LAST",                               "Image p&eacute;c&eacute;dente." );
define("PV_STR_IMG",                                "L'image dans la base de donn&eacute;es." );

define("DS_STRING_HELP_CAPTION_STATISTICS",         "Statistiques nouvelles");
define("DS_STRING_HELP_CONTENT_STATISTICS",         "On this page you see the latest measurements from the chosen device and interval.");

define( "DS_STRING_MAIN_NO_DATA_SENSOR",            "Pas des statistiques pour " );
define( "DS_STRING_MAIN_NO_DATA_BETWEEN",           " a " );
define( "PV_STR_NODATA",                            "Pas des statistiques." );





/* My MAC Devices */

define("DS_STRING_MAIN_CAPTION_MAC_DEVS",           "Mes appareils MAC");
define("DS_STRING_MAIN_CAPTION_DEV_ADD",            "Nouvel appareil");
define("DS_STRING_PROF_MNG_SUBMIT_BUTTON",          "Sauvegarder");
define("DS_STRING_PROF_MNG_SET_DEV_NAME",           "Le nom d'appareil");
define("DS_STRING_PROF_MNG_INSERT_MAC",             "L'addresse MAC");
define("DS_STRING_PROF_MNG_NAME",                   "Nom d'appareil");
define("DS_STRING_PROF_MNG_MAC",                    "Addresse MAC");
define("DS_STRING_PROF_MNG_ACTION",                 "Administrer");
define("DS_STRING_PROF_MNG_MANAGE",                 "Gestion des profiles");
define("DS_STRING_PROF_MNG_REMOVE",                 "Supprimer");

define("DS_STRING_MAC_MNG_BIND_NO_INFO",            "Remplez tous les champs.");
define("DS_STRING_MAC_MNG_BIND_MAC_IN_USE",         "L'addresse MAC existe d&eacute;j&agrave; ");
define("DS_STRING_MAC_MNG_BIND_TO_USER_SUCC",       "L'appareil est sauvegard&eacute; pour utilisateur "); 
define("DS_STRING_MAC_MNG_BIND_TO_USER_AS",         " avec le nom ");
define("DS_STRING_DEV_MNG_DEV_REM_SUCC",            "L'appereil est supprim&eacute;."); 
define("DS_STRING_DEV_MNG_DEV_REM_ERR",             "Suppression d'appareil a faili.");
define("DS_STRING_MAC_MNG_BIND_MAC_INVALID",        "Insertion d'appareil a faili.");

define("DS_STRING_HELP_CAPTION_DEV_MAIN",           "Mes appareils MAC");
define("DS_STRING_HELP_CONTENT_DEV_MAIN",           "On this page you can add and remove your MAC devices.<br /><i>MAC address</i> is a string like XX:XX:XX:XX:XX:XX, where X is an hexadecimal number. You can locate the address on your device or ask your system administrator.<br />You may choose a <i>name</i> for the device, so you can easily recongnize it later.<br /><b>N.B.! Removing the MAC device cannot be reversed and also removes the devices and sensors attached to the MAC device.</b>");





/* My Monitorings */

define("DS_STRING_ALARM_MAINPAGE",                  "Mes surveillances");
define("DS_STRING_ALARM_SETTINGS_NAV_BACK",         "Pr&eacute;c&eacute;dent");
define("DS_STRING_ALARM_SETTINGS_NAV_NEXT",         "Suivant");
define("DS_STRING_ALARM_SETTINGS_LINK_NEW",         "Nouvelle surveillance.");
define("DS_STRING_ALARM_HISTORY_LINK_ALL",          "&Eacute;tudier les statistiques.");
define("DS_STRING_ALARM_MNG_NAME",                  "Nom de la surveillance");
define("DS_STRING_ALARM_MNG_SCHEDULE",              "Horaires");
define("DS_STRING_ALARM_MNG_SENSORS",               "Capteurs");
define("DS_STRING_ALARM_MNG_CONTACTS",              "Personnes-ressource");
define("DS_STRING_ALARM_MNG_MANAGE",                "Administrer");
define("DS_STRING_ALARM_MNG_SAVE",                  "Sauvegarder");
define("DS_STRING_ALARM_MNG_EDIT_ALARM",            "&Eacute;diter la surveillance.");
define("DS_STRING_ALARM_MNG_HISTORY",               "&Eacute;tudier les statistiques.");
define("DS_STRING_ALARM_MNG_DELETE",                "Supprimer la surveillance.");
define("DS_STRING_ALARM_NEW_ALARM",                 "Mes surveillances - Nouvelle surveillance");
define("DS_STRING_ALARM_SETTINGS_PAGE",             "Mes surveillances - Éditer la surveillance");
define("DS_STRING_ALARM_NEW_PAGE",                  "Nouvelle surveillance");
define("DS_STRING_ALARM_EDIT_PAGE",                 "Éditer la surveillance");
define("DS_STRING_ALARM_MNG_ALARM_NAME",            "Le nom:");
define("DS_STRING_ALARM_MNG_ALARM_TYPE",            "La m&eacute;thode de la notification:");
define("DS_STRING_ALARM_MNG_SMS",                   "Un message SMS");
define("DS_STRING_ALARM_MNG_EMAIL",                 "Un courrier &eacute;lectronique");
define("DS_STRING_ALARM_MNG_COMPOSITE",             "Tous les deux");
define("DS_STRING_ALARM_MNG_SMALL_MSG",             "Le message br&egrave;ve:<br>(Le SMS / Le sujet du courrier &eacute;lectronique)<br>");
define("DS_STRING_ALARM_MNG_BIG_MSG",               "Le message long:<br>(Les corps du courrier &eacute;lectronique)<br>");
define("DS_STRING_ALARM_MNG_NEW",                   "Sauvegarder");
define("DS_STRING_ALARM_MNG_EDIT",                  "Sauvegarder");

define("DS_STRING_ALARM_CONFIRM_QUESTION_DEFAULT",  "Vous voulez supprimer la surveillance?"); 
define("DS_STRING_ALARM_CONFIRM_QUESTION_HISTORY",  "Vous voulez supprimer les statistiques?");
define("DS_STRING_ALARM_CONFIRM_YES",               "Oui");
define("DS_STRING_ALARM_CONFIRM_NO",                "Non");

define("DS_STRING_HELP_CAPTION_ALARM_MAIN",                 "Mes surveillances");
define("DS_STRING_HELP_CONTENT_ALARM_MAIN",                 "On this page you can create, edit and remove surveillances. You can also browse the surveillanes' statistics.<br /><i>Surveillances</i> allow you to get notified when a sensor's value crosses given limits, or \"triggers\" the surveillance. All triggerings are saved into the history.<br />The lamp in <i>sensors</i> column tells you whether the sensor is active, that is whether it can trigger a surveillance. You can change the sensor's state by clicking the lamp. Yellow lamp means the sensor is active.");
define("DS_STRING_HELP_CAPTION_ALARM_SETTINGS",             "Nouvelle surveillance");
define("DS_STRING_HELP_CONTENT_ALARM_SETTINGS",             "On this page you can create a new surveillance or edit an existing one.<br />You can choose the <i>name</i> of the surveillance freely to help you distinguish between different surveillances.<br /><i>Notification method</i> specifiy how contact persons may be notified when the surceillance is triggered.<br /><i>Short message</i> is used as the SMS notification and as the subject of the e-mail notification.<br /><i>Long message</i> is the body of the e-mail notification.<br /><b>N.B.! Actual notifications will not be sent in the DEMO version.</b>");





/* My Monitorings - History */

define("DS_STRING_ALARM_HISTORY_PAGE",              "Mes surveillances - Mes statistiques");
define("DS_STRING_ALARM_HISTORY_NAV_CLEAR",         "Supprimer les statistiques");
define("DS_STRING_ALARM_HISTORY_TIME",              "Temps du &eacute;v&eacute;nement");
define("DS_STRING_ALARM_HISTORY_ALARM_NAME",        "Nom du surveillance");
define("DS_STRING_ALARM_HISTORY_SCHEDULE_NAME",     "Nom du capteur");
define("DS_STRING_ALARM_HISTORY_SENSOR_NAME",       "Nom de l'horaire");
define("DS_STRING_ALARM_HISTORY_VALUE",             "Valeur du capteur");

define("DS_STRING_HELP_CAPTION_ALARM_HISTORY",              "Mes statistiques");
define("DS_STRING_HELP_CONTENT_ALARM_HISTORY",              "This page displays history for the selected alarm(s).");

define("DS_STRING_STAT_NO_DATA_BETWEEN",                    "Pas d'histoire pendant ");





/* My Monitorings - My Schedules */

define("DS_STRING_ALARM_SCHEDULE_PAGE",             "Mes surveillances - Mes horaires");
define("DS_STRING_ALARM_NEW_SCHEDULE_PAGE",         "Mes surveillances - Nouvel horaire");
define("DS_STRING_ALARM_EDIT_SCHEDULE_PAGE",        "Mes surveillances - &Eacute;diter l'horaire");
define("DS_STRING_ALARM_NEW_TRIGGER",               "Nouvel horaire");
define("DS_STRING_ALARM_EDIT_TRIGGER",              "&Eacute;diter l'horaire");
define("DS_STRING_ALARM_SCHEDULES_NAV_BACK",        "Pr&eacute;c&eacute;dent");
define("DS_STRING_ALARM_SCHEDULES_NAV_NEXT",        "Suivant");
define("DS_STRING_ALARM_MNG_SCHEDULE_NAME",         "Nom de l'horaire");
define("DS_STRING_ALARM_SCHEDULE_LINK_ADD",         "Ins&eacute;rer sur la surveillance."); 
define("DS_STRING_ALARM_SCHEDULE_LINK_REM",         "Supprimer sur la surveillance."); 
define("DS_STRING_ALARM_SCHEDULE_LINK_EDIT",        "&Eacute;diter l'horaire.");
define("DS_STRING_ALARM_SCHEDULE_LINK_DEL",         "Supprimer l'horaire.");
define("DS_STRING_ALARM_MNG_SCHEDULE_NAME_EDIT",    "Le nom de l'horaire:");
define("DS_STRING_ALARM_MNG_SCHEDULE_VALUES",       "La valeur du capteur:");
define("DS_STRING_ALARM_MNG_MIN_VALUE",             "Minimum:");
define("DS_STRING_ALARM_MNG_MAX_VALUE",             "Maximum:");
define("DS_STRING_ALARM_MNG_TRIGGER_WITHIN",        "L'horaire est valable dedans les valeurs.");
define("DS_STRING_ALARM_MNG_TRIGGER_OUTSIDE",       "L'horaire est valable dehors les valeurs."); 
define("DS_STRING_ALARM_MNG_TIME",                  "Temps du &eacute;v&eacute;nement:");
define("DS_STRING_ALARM_MNG_ALWAYS",                "Toujours: ");
define("DS_STRING_ALARM_MNG_MONTHS",                "Au mois de:"); 
define("DS_STRING_ALARM_MNG_ALL_MONTHS",            "&Agrave; tous les moins.");
define("DS_STRING_ALARM_MNG_SELECTED_MONTHS",       "&Agrave; mois s&eacute;lectionn&eacute;s:");
define("DS_STRING_ALARM_MNG_JAN",                   "Janvier");
define("DS_STRING_ALARM_MNG_FEB",                   "F&eacute;vrier");
define("DS_STRING_ALARM_MNG_MAR",                   "Mars");
define("DS_STRING_ALARM_MNG_APR",                   "Avril");
define("DS_STRING_ALARM_MNG_MAY",                   "Mai");
define("DS_STRING_ALARM_MNG_JUN",                   "Juin");
define("DS_STRING_ALARM_MNG_JUL",                   "Juillet");
define("DS_STRING_ALARM_MNG_AUG",                   "Ao&ucirc;t");
define("DS_STRING_ALARM_MNG_SEP",                   "Septembre");
define("DS_STRING_ALARM_MNG_OCT",                   "Octobre");
define("DS_STRING_ALARM_MNG_NOV",                   "Novembre");
define("DS_STRING_ALARM_MNG_DEC",                   "Decembre");
define("DS_STRING_ALARM_MNG_DAYS",                  "Les jours:"); 
define("DS_STRING_ALARM_MNG_ALL_DAYS",              "Tous les jours.");
define("DS_STRING_ALARM_MNG_SELECT_DAYS",           "Les jours s&eacute;lectionn&eacute;s:");
define("DS_STRING_ALARM_MNG_SUN",                   "Dimanche");
define("DS_STRING_ALARM_MNG_MON",                   "Lundi");
define("DS_STRING_ALARM_MNG_TUE",                   "Mardi");
define("DS_STRING_ALARM_MNG_WED",                   "Mercredi");
define("DS_STRING_ALARM_MNG_THU",                   "Jeudi");
define("DS_STRING_ALARM_MNG_FRI",                   "Vendredi");
define("DS_STRING_ALARM_MNG_SAT",                   "Samedi");
define("DS_STRING_ALARM_MNG_ALL_DAY",               "Tout jour (24h):");
define("DS_STRING_ALARM_MNG_START_TIME",            "Au plus t&ocirc;t:");
define("DS_STRING_ALARM_MNG_END_TIME",              "Au plus tard:");
define("DS_STRING_ALARM_MNG_ALL_YEAR",              "Tout ann&eacute;e:");
define("DS_STRING_ALARM_MNG_START_DATE",            "Du:");
define("DS_STRING_ALARM_MNG_END_DATE",              "Au:");
define("DS_STRING_ALARM_MNG_HH_MM_SS",              "(hh:mm:ss)");
define("DS_STRING_ALARM_MNG_YYYY_MM_DD_HH_MM_SS",   "(aaaa-mm-jj hh:mm:ss)");

define("DS_STRING_ALARM_SCHEDULE_MSG_APPEND",               "<font color=\"green\">L'horaire est ins&eacute;r&eacute; sur la surveillance.</font>");
define("DS_STRING_ALARM_SCHEDULE_MSG_REMOVED",              "<font color=\"green\">L'horaire est supprim&eacute; sur la surveillance.</font>");
define("DS_STRING_ALARM_SCHEDULE_MSG_ADDED",                "<font color=\"green\">L'horaire est sauvegard&eacute;.</font>");
define("DS_STRING_ALARM_SCHEDULE_MSG_DELETED",              "<font color=\"green\">L'horaire est supprim&eacute;.</font>");
define("DS_STRING_ALARM_SCHEDULE_MSG_EDITED",               "<font color=\"green\">L'horaire est sauvegard&eacute;.</font>");

define("DS_STRING_HELP_CAPTION_ALARM_SCHEDULE",             "Mes horaires");
define("DS_STRING_HELP_CONTENT_ALARM_SCHEDULE",             "On this page you can create new triggers, edit or remove existing triggers and add or remove triggers to/from the surveillance.<br />You can choose the <i>name</i> of the trigger freely, to help you distinguish between different triggers.<br /><i>Sensor's value</i> defines the limits, inside or outside of which the surveillance is triggered.<br /><i>Time</i> defines when the surveillance can trigger.<br /><i>Always</i> triggers the surveillance whenever the sensor's value differs from specified values. If you wish, you may also choose specific months and/or days.<br /><i>All day (24h)</i> means that the surveillance can trigger 24 hours a day. If you wish, you may specify a smaller time interval.<br /><i>All year</i> means that the surveillance can trigger all year round. If you wish, you may specify the dates and times, between which the surveillance can trigger.<br />Note that the above selections are not exclusive. You may well specify, that the alarm can trigger between 1.1.2010 and 31.5.2010, on Mondays and Thursdays in January, March and May between 12:00 and 23:00.");






/* My Monitorings - My Sensors */

define("DS_STRING_ALARM_SENSORS_PAGE",              "Mes surveillances - Mes capteurs");
define("DS_STRING_ALARM_SENSORS_NAV_BACK",          "Pr&eacute;c&eacute;dent");
define("DS_STRING_ALARM_SENSORS_NAV_NEXT",          "Suivant");
define("DS_STRING_ALARM_MNG_SENSOR_NAME",           "Nom du capteur");
define("DS_STRING_ALARM_MNG_DEVICE_NAME",           "Nom du appareil");
define("DS_STRING_ALARM_MNG_PROFILE_NAME",          "Nom du profil");
define("DS_STRING_ALARM_MNG_ENABLED",               "L'&eacute;tat du capteur");
define("DS_STRING_ALARM_MNG_AUTOENABLE",            "Activation automatique");
define("DS_STRING_ALARM_SENSOR_AUTOENABLE",         "Oui");
define("DS_STRING_ALARM_SENSOR_NOAUTOENABLE",       "Non");
define("DS_STRING_ALARM_SENSOR_ENABLED",            "D&eacute;sactiver le capteur.");
define("DS_STRING_ALARM_SENSOR_DISABLED",           "Activer le capteur.");
define("DS_STRING_ALARM_SENSOR_LINK_ADD",           "Ins&eacute;rer sur la surveillance");
define("DS_STRING_ALARM_SENSOR_LINK_DEL",           "Supprimer sur la surveillance");

define("DS_STRING_ALARM_SENSOR_MSG_APPEND",                 "<font color=\"green\">Le capteur est ins&eacute;r&eacute; sur la surveillance.</font>");
define("DS_STRING_ALARM_SENSOR_MSG_REMOVED",                "<font color=\"green\">Le capteur est supprim&eacute; sur la surveillance.</font>");
define("DS_STRING_ALARM_SENSOR_MSG_ENABLED",                "<font color=\"green\">Le capteur est maintenant activ&eacute;.</font>");
define("DS_STRING_ALARM_SENSOR_MSG_DISABLED",               "<font color=\"green\">Le capteur est maintenant d&eacute;sactiv&eacute;.</font>");
define("DS_STRING_ALARM_SENSOR_MSG_AUTOENABLE",             "<font color=\"green\">L'activation du capteur est maintenant automatique.</font>");
define("DS_STRING_ALARM_SENSOR_MSG_NOAUTOENABLE",           "<font color=\"green\">L'activation du captuer est maintenant manuel.</font>");

define("DS_STRING_HELP_CAPTION_ALARM_SENSORS",              "Mes capteurs");
define("DS_STRING_HELP_CONTENT_ALARM_SENSORS",              "On this page you can add or remove sensors from the surveillance.<br />The lamp in <i>sensors</i> column tells you whether the sensor is active, that is whether it can trigger a surveillance. You can change the sensor's state by clicking the lamp. Yellow lamp means the sensor is active.<br />\"Yes\" in <i>auto enable</i> column means that the sensor stays active even if it triggers a surveillance. You may disable the feature by clicking the text. If auto enable is disabled, you have to manually enable the sensor every time it triggers this surveillance.");





/* My Monitorings - My Contacts */

define("DS_STRING_ALARM_CONTACTS_PAGE",             "Mes surveillances - Mes personnes-ressource");
define("DS_STRING_ALARM_CONTACTS_NAV_BACK",         "Pr&eacute;c&eacute;dent");
define("DS_STRING_ALARM_CONTACTS_NAV_NEXT",         "Complet");
define("DS_STRING_ALARM_CONTACTS_NAME",             "Nom");
define("DS_STRING_ALARM_CONTACTS_EMAIL",            "Adresse de courrier &eacute;lectronique");
define("DS_STRING_ALARM_MNG_PHONE",                 "Num&eacute;ro du t&eacute;l&eacute;phone");
define("DS_STRING_ALARM_CONTACTS_LINK_SMS_ADD",     "Ins&eacute;rer parmi r&eacute;cepteurs du message SMS.");
define("DS_STRING_ALARM_CONTACTS_LINK_SMS_DEL",     "Supprimer parmi r&eacute;cepteurs du message SMS.");
define("DS_STRING_ALARM_CONTACTS_LINK_EMAIL_ADD",   "Ins&eacute;rer parmi r&eacute;cepteurs du courrier &eacute;lectronique.");
define("DS_STRING_ALARM_CONTACTS_LINK_EMAIL_DEL",   "Supprimer parmi r&eacute;cepteur du courrier &eacute;lectronique.");
define("DS_STRING_ALARM_CONTACTS_LINK_EDIT",        "&Eacute;diter le personne-ressource.");
define("DS_STRING_ALARM_CONTACTS_LINK_DEL",         "Supprimer le personne-ressource.");
define("DS_STRING_ALARM_MNG_ADD_NEW_CONTACT",       "Nouveou personne-ressource:");
define("DS_STRING_ALARM_MNG_EDIT_CONTACT",          "&Eacute;diter le personne-ressource:");
define("DS_STRING_ALARM_MNG_CONTACT_NAME",          "Le nom:");
define("DS_STRING_ALARM_MNG_CONTACT_EMAIL",         "L'adresse du courrier &eacute;lectronique:"); 
define("DS_STRING_ALARM_MNG_CONTACT_PHONE",         "Le num&eacute;ro du t&eacute;l&eacute;phone:");
define("DS_STRING_ALARM_MNG_NEW_CONTACT",           "Sauvegarder");


define("DS_STRING_ALARM_CONTACTS_MSG_ADDED",                "<font color=\"green\">Le personne-ressource est sauvegard&eacute;.</font>");
define("DS_STRING_ALARM_CONTACTS_MSG_DELETED",              "<font color=\"green\">Le personne-ressource est supprim&eacute;.</font>");
define("DS_STRING_ALARM_CONTACTS_MSG_EDITED",               "<font color=\"green\">Le personne-ressource est sauvegard&eacute;.</font>");
define("DS_STRING_ALARM_CONTACTS_MSG_APPEND_SMS",           "<font color=\"green\">Le personne-ressource est ins&eacute;r&eacute; parmi r&eacute;cepteurs du message SMS.</font>");
define("DS_STRING_ALARM_CONTACTS_MSG_APPEND_EMAIL",         "<font color=\"green\">Le personne-ressource est ins&eacute;r&eacute; parmi r&eacute;cepteurs du courrier &eacute;lectronique.</font>");
define("DS_STRING_ALARM_CONTACTS_MSG_REMOVED_SMS",          "<font color=\"green\">Le personne-ressource est supprim&eacute; parmi r&eacute;cepteurs du message SMS.</font>");
define("DS_STRING_ALARM_CONTACTS_MSG_REMOVED_EMAIL",        "<font color=\"green\">Le personne-ressource est supprim&eacute; parmi r&eacute;cepteurs du courrier &eacute;lectronique.</font>");

define("DS_STRING_HELP_CAPTION_ALARM_CONTACTS",             "Mes presonnes-ressource");
define("DS_STRING_HELP_CONTENT_ALARM_CONTACTS",             "On this page you can create and edit contact persons and add the as notification recipients of your surveillance.<br /><b>N.B.! Actual notifications will not be sent in the DEMO version.</b>");





/* My Profiles */

define("DS_STRING_MAIN_CAPTION_PROFILES",           "Mes profiles");
define("DS_STRING_PROF_MNG_PROFILE_INFO",           "Nouveau profil");
define("DS_STRING_PROF_MNG_PROFILE_OWNER",          "Le nom d'utilisateur:");
define("DS_STRING_PROF_MNG_PROFILE_NAME",           "Le nom du profil:");
define("DS_STRING_PROF_MNG_PROFILE_PWD",            "Le mot de passe:");
define("DS_STRING_PROF_MNG_PROFILE_CONFIRM_PWD",    "Confirmer le mot de passe:");
define("DS_STRING_PROF_MNG_CREATE_PROF_BUTTON",     "Sauvegarder");
define("DS_STRING_PROF_PROFILES",                   "Mes profiles");
define("DS_STRING_PROF_MNG_PROFILE_NAME_TBL",       "Nom du profil");
define("DS_STRING_PROF_MNG_GW_NAME",                "Appareils (L'appareil MAC)");
define("DS_STRING_PROF_ADD_MAC",                    "Nouvel appareil MAC");
define("DS_STRING_PROF_MNG_ADD_DEVICE",             "Ins&eacute;rer un appareil");
define("DS_STRING_PROF_MNG_DELETE_THIS_PROFILE",    "Supprimer");
define("DS_STRING_PROF_MNG_EDIT",                   "&Eacute;diter");

define("DS_STRING_PROF_MNG_PROFILE_NAME_EMPTY",             "Rempliez-vous le nom du profil!");
define("DS_STRING_PROF_MNG_PROFILE_EXISTS",                 "Un profil avec le m&ecirc;me nom existe d&eacute;j&agrave;!");
define("DS_STRING_PROF_MNG_PWD_MISMATCH_OR_SHORT",          "Le mot de passe est trop br&egrave;ve ou les mots de passe n'est pas m&ecirc;me!");
define("DS_STRING_PROF_MNG_CREATE_SUCC",                    "Le profil est sauvegard&eacute;.");
define("DS_STRING_PROF_MNG_PROFILE_REMOVED_BEGIN",          "Le profil < ");
define("DS_STRING_PROF_MNG_PROFILE_REMOVED_END",            " > est supprim&eacute;!"); 
define("DS_STRING_PROF_MNG_PROFILE_REMOVE_ERROR_BEGIN",     "Le profile n'est pas supprim&eacute; < ");
define("DS_STRING_PROF_MNG_PROFILE_REMOVE_ERROR_END",       " >!");

define("DS_STRING_HELP_CAPTION_PROF_MAIN",                  "Mes profiles");
define("DS_STRING_HELP_CONTENT_PROF_MAIN",                  "On this page you can create, edit and remove profiles.<br /><i>Profiles</i> allow you to create different views to your system's devices. They also enable third parties to access the system through the profiles you give them access to.");





/* My Profiles - Edit profile */

define("DS_STRING_MAIN_CAPTION_ADD_DEV_TO_PROF",    "Mes profiles - &Eacute;diter le profil ");
define("DS_STRING_PROF_MNG_PROFILE",                "Nom du profil");
define("DS_STRING_PROF_MNG_DEVICE",                 "L'appareil");
define("DS_STRING_PROF_MNG_DEV_NAME",               "Nouveau nom du appareil:");
define("DS_STRING_PROF_MNG_UPDATE",                 "Renommer");
define("DS_STRING_PROF_MNG_ADD_TO_PROF",            "Ins&eacute;rer");
define("DS_STRING_PROF_MNG_REMOVE_FROM_PROF",       "Supprimer"); 
define("DS_STRING_PROF_MNG_SENSORS",                "Les capteurs");
define("DS_STRING_PROF_MNG_SHOW_INFO",              "Afficher les capteurs");
define("DS_STRING_PROF_MNG_SENSOR_ID",              "L'addresse");
define("DS_STRING_PROF_MNG_SENSOR_TYPE",            "Le type");
define("DS_STRING_PROF_MNG_SET_SENSOR_NAME",        "Nouveau nom du capteur:");

define("DS_STRING_DEV_MNG_DEV_UPD_NAME_ERROR",              "L'appareil n'est pas renomm&eacute:<b>");
define("DS_STRING_DEV_MNG_DEV_UPD_NAME_SUCC",               "L'appareil est renomm&eacute;: ");
define("DS_STRING_DEV_MNG_DEV_ADD_TO_PROF_ERROR_BEGIN",     "L'appareil n'est pas ins&eacute;r&eacute; <b>");
define("DS_STRING_DEV_MNG_DEV_ADD_TO_PROF_ERROR_END",       " sur le profil </b>");
define("DS_STRING_DEV_MNG_DEV_ADD_TO_PROF_SUCC",            "L'appareil est ins&eacute;r&eacute; sur le profil:");
define("DS_STRING_DEV_MNG_DEV_ADD_TO_PROF_SUCC_BEGIN",      "L'appareil <");
define("DS_STRING_DEV_MNG_DEV_ADD_TO_PROF_SUCC_END",        "> a ins&eacute;rer sur le profil: ");
define("DS_STRING_DEV_MNG_DEV_REM_FROM_PROF_ERROR_BEGIN",   "L'appreil n'est pas supprim&eacute; <");
define("DS_STRING_DEV_MNG_DEV_REM_FROM_PROF_ERROR_END",     "> sur le profil: ");
define("DS_STRING_DEV_MNG_DEV_REM_FROM_PROF_SUCC_BEGIN",    "L'appareil <");
define("DS_STRING_DEV_MNG_DEV_REM_FROM_PROF_SUCC_END",      "> est supprim&eacute; sur le profil: ");
define("DS_STRING_SENSOR_MNG_UPDATED",                      "Le capteur est renomm&eacute;.");

define("DS_STRING_HELP_CAPTION_PROF_PROP",                          "&Eacute;diter le profil ");
define("DS_STRING_HELP_CONTENT_PROF_PROP",                          "TOn this page you may add or remove devices from the selected profile.<br />If a device is added to a profile, you can rename it by typing in a name in the <i>rename device</i> field and clicking the <i>rename</i> button. The name only affects the edited profile.<br />You can view the sensor's devices by clicking <i>Show sensors</i>.<br />You can rename sensors similarily to a device.");





/* My Account */

define( "DS_STRING_USER_ACCOUNT_CAPTION",           "Mon relev&eacute; utilisateur" );
define( "DS_STRING_USER_CHANGE_PASSWORD_CAPTION",   "Changer le mot de passe" );
define( "DS_STRING_USER_CURRENT_PASSWORD",          "Mot de passe:" );
define( "DS_STRING_USER_NEW_PASSWORD",              "Nouveau mot de passe:" );
define( "DS_STRING_USER_CONFIRM_PASSWORD",          "Confirmer le nouveau mot de passe:" );
define( "DS_STRING_USER_CHANGE_PASSWORD",           "Sauvegarder" );

define( "DS_STRING_USER_ACCOUNT_REMOVE_CAPTION",    "Supprimer le relev&eacute; utilisateur" );
define( "DS_STRING_USER_ACCOUNT_REMOVE",            "Supprimer" );

define( "DS_STRING_USER_ACCOUNT_REMOVE_CONFIRM",    "Supprimer votre relev&eacute; utilisateur?" );
define( "DS_STRING_USER_ACCOUNT_REMOVE_FAILED",     "Suppression du relev&eacute; utilisateur a faili." );
define( "DS_STRING_USER_ACCOUNT_CHANGEPW_FAILED",   "Le mot de passe n'est pas sauvegard&eacute; V&eacute;rifier les mots de passe." );
define( "DS_STRING_USER_ACCOUNT_CHANGEPW_SUCCESS",  "Le mot de passe est sauvegard&eacute;." );

define("DS_STRING_USER_ACCOUNT_HELP",               "On this page you can change your password or remove your account.<br /><b>N.B.! The removal of your account cannot be reversed. All information related to you will be removed immediately after you accept the removal confirmation.</b>");





/* User Management */

define("DS_STRING_MAIN_CAPTION_MANAGE_USERS",       "Gestion des utilisateurs");
define("DS_STRING_USR_MNG_USER_MANAGEMENT",         "Gestion des relev&eacute;s utilisateur");
define("DS_STRING_USR_MNG_PENDING_REQ_MANAGEMENT",  "Gestion des p&eacute;titions"); 
define( "DS_STRING_YES",                            "Oui" );
define( "DS_STRING_NO",                             "Non" );

define( "DS_STRING_USER_SYSTEM_ERROR",              "Erreur. Contactez l'administrateur." );

define("DS_STRING_HELP_CAPTION_ADMIN",              "Gestion des utilisateurs");
define("DS_STRING_HELP_CONTENT_ADMIN",              "From this page you can navigate to user account management or account request management.");





/* User Management - Account Management */

define( "DS_STRING_USER_USERS_CAPTION",             "Gestion des relev&eacute;s utilisateur" );
define( "DS_STRING_USER_EMAIL_ADDRESS",             "Adresse de courrier &eacute;lectronique" );
define( "DS_STRING_USER_ACCOUNT_CREATED",           "Approuv&eacute;" );
define( "DS_STRING_USER_LAST_LOGIN",                "Temps de la visite derni&egrave;re" );
define( "DS_STRING_USER_VISITS",                    "Visites" );
define( "DS_STRING_USER_STATUS",                    "&Eacute;tat" );
define( "DS_STRING_USER_ROLE",                      "R&ocirc;le" );
define( "DS_STRING_USER_MANAGE",                    "Administrer" );
define( "DS_STRING_USER_ACTIVE",                    "Actif" );
define( "DS_STRING_USER_INACTIVE",                  "Inactif" );
define( "DS_STRING_USER_ADMIN",                     "Administrateur" );
define( "DS_STRING_USER_USER",                      "Utilisateur" );
define( "DS_STRING_USER_ACTIVATE",                  "Activer" );
define( "DS_STRING_USER_INACTIVATE",                "Inactiver" );
define( "DS_STRING_USER_USERIZE",                   "Parmi administrateurs" );
define( "DS_STRING_USER_ADMINIZE",                  "Parmi utilisateurs" );
define( "DS_STRING_USER_REMOVE",                    "Supprimer" );
define( "DS_STRING_USER_MANAGE_REQUESTS",           "Gestion des p&eacute;titions.");

define( "DS_STRING_USER_REMOVE_CONFIRM",            "Supprimer l'utilisateur?" );
define( "DS_STRING_USER_TOGGLE_ROLE_FAILED",        "Changement du r&ocirc;le a faili." );
define( "DS_STRING_USER_TOGGLE_ROLE_SUCCESS",       "Le r&ocirc;le d'utilisateur est chang&eacute;." );
define( "DS_STRING_USER_TOGGLE_STATUS_FAILED",      "Changement d'&eacute;tat a faili." );
define( "DS_STRING_USER_TOGGLE_STATUS_SUCCESS",     "L'&eacute;tat d'utilisateur est chang&eacute;" );
define( "DS_STRING_USER_REMOVE_FAILED",             "Suppression d'utilisateur a faili." );
define( "DS_STRING_USER_REMOVE_SUCCESS",            "L'utilisateur est supprim&eacute;." );

define("DS_STRING_USER_USERS_HELP",                 "On this page you can control the users' access to the system, change users' roles and remove users.<br />You can deny the user access into the system by clicking the <i>inactivate</i> button or vice versa. If an user's account is active, the user is notified of it on login and the login request is denied.<br />You can make an user into an administrator by clicking the <i>make administrator</i> button or vice versa.<br /><b>N.B.! Once an user is given administrator priviledges, he or she may inactivate your account.</b>");





/* User Management - Account Request Management */

define( "DS_STRING_USER_REQUESTS_CAPTION",          "Gestion des p&eacute;titions" );
define( "DS_STRING_USER_REQUEST_DATE",              "Datte" );
define( "DS_STRING_USER_REQUEST_REASON",            "L'argumentation" );
define( "DS_STRING_USER_APPROVE_REQUEST",           "Approuver" );
define( "DS_STRING_USER_DECLINE_REQUEST",           "Rejeter" );
define( "DS_STRING_USER_NO_REQUESTS",               "Pas des petitions." );
define( "DS_STRING_USR_MNG_USERS",                  "Gestion des relev&eacute;s utilisateur." );

define( "DS_STRING_USER_DECLINE_CONFIRM",           "Rejeter la p&eacute;tition?" );
define( "DS_STRING_USER_APPROVE_FAILED",            "Approuvement de la p&eacute;tition a faili." );
define( "DS_STRING_USER_APPROVE_SUCCESS",           "La p&eacute;tition est approuv&eacute;." );
define( "DS_STRING_USER_DECLINE_FAILED",            "Rejetion de la p&eacute;tition a faili" );
define( "DS_STRING_USER_DECLINE_SUCCESS",           "La p&eacute;tition est rejet&eacute;." );

define("DS_STRING_USER_REQUESTS_HELP",              "This page allows to approve pending registration requests.");

?>
