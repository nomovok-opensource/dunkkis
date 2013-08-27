<?php

/** Dunkkis Web User Interface
  * ==========================
  * Finnish translation
  * 
  * Copyright (c) 2009-2010 Nomovok Ltd
  * This software is licensed under The MIT License. See LICENSE for details.
  *
  * @author Juha Hytonen - juha.hytonen@nomovok.com
  */





include_once( "ds-sensor-strings.inc.php" );





/* General */

define("DS_STRING_MAIN_GENERIC",                "Yleinen");
define("DS_STRING_MAIN_TEMPERATURE",            "Lämpötila");
define("DS_STRING_MAIN_HUMIDITY",               "Kosteus");
define("DS_STRING_MAIN_AIR_PRESSURE",           "Ilmanpaine");
define("DS_STRING_MAIN_SPECIAL",                "Erikois");
define("DS_STRING_MAIN_CO2",                    "Hiilidioksidi");
define("DS_STRING_MAIN_DOOR",                   "Ovi");
define("DS_STRING_MAIN_MOTION",                 "Liiketunnistin");
define("DS_STRING_MAIN_SWITCH",                 "Katkaisija");
define("DS_STRING_MAIN_CUSTOM",                 "Mukautettu");
define("DS_STRING_MAIN_LDR",                    "LDR");
define("DS_STRING_MAIN_PICTURE",                "Kuva");





/* Login */

define("DS_STRING_USER_LOGIN_USERNAME",             "Käyttäjätunnus:");
define("DS_STRING_USER_LOGIN_PASSWORD",             "Salasana:");
define("DS_STRING_USER_LOGIN_MOBILE_LAYOUT",        "Mobiiliversio.");
define("DS_STRING_USER_LOGIN_LOGIN",                "Kirjaudu sisään");
define("DS_STRING_USER_LOGIN_TEASER",               "Eikö sinulla ole käyttäjätunnusta?");
define("DS_STRING_USER_LOGIN_REGISTER",             "Rekisteröidy!");

define( "DS_STRING_USER_LOGIN_FAILED_CREDENTIALS",  "Väärä käyttäjätunnus tai salasana." );
define( "DS_STRING_USER_LOGIN_FAILED_INACTIVE",     "Käyttäjätilisi ei ole aktiivinen. Ota yhteyttä pääkäyttäjään." );
define( "DS_STRING_USER_LOGIN_FAILED",              "Järjestelmä ei voinut kirjata sinua sisään. Ota yhteyttä pääkäyttäjään." );

define("DS_STRING_LOGIN_DISCLAIMER",                "Tämä sovellus on vain DEMO. Emme ota vastuuta tietojen säilymisestä sovelluksessa. Kaikki oikeudet pidätetään.");
define("DS_STRING_LOGIN_INFO",                      "Mikäli löydätte sovelluksesta virheitä tai epäjohdonmukaisuuksia, pyydämme teitä ottamaan yhteyttä meihin.");





/* Registration */

define("DS_STRING_PROF_MNG_CREATE_ONE",             "Täällä voit luoda sellaisen!");
define("DS_STRING_REGISTR_TITLE",                   "Ano käyttäjätiliä!");
define("DS_STRING_REGISTR_GOTO_WEBPAGE",            "Siirry projektin sivuille");
define("DS_STRING_REGISTR_ALREADY_HAVE_ACCOUNT",    "Onko sinulla jo käyttäjätili?");
define("DS_STRING_REGISTR_SIGN_IN",                 "Kirjaudu sisään!");
define("DS_STRING_REGISTR_DUNKKIS_ORG",             "Dunkkis.org");
define("DS_STRING_REGISTR_EMAIL",                   "Sähköpostiosoite");
define("DS_STRING_REGISTR_EMAIL_INFO",              "Käytetään myös käyttäjätunnuksenasi.");
define("DS_STRING_REGISTR_EMAIL_INVALID",           "Sähköpostiosoite ei kelpaa!");
define("DS_STRING_REGISTR_EMAIL_IN_USE",            "Sähköpostiosoite on jo käytössä!");
define("DS_STRING_REGISTR_PWD",                     "Salasana");
define("DS_STRING_REGISTR_PWD_TOO_SHORT_OR_ILLEGAL","Salasana on liian lyhyt tai se sisältää sopimattomia merkkejä!");
define("DS_STRING_REGISTR_WHY",                     "Miksi?");
define("DS_STRING_REGISTR_REASON_MUST_CONTAIN",     "Perustelun täytyy sisältää vähintään kaksi sanaa!");
define("DS_STRING_REGISTR_APPLY_FOR_ACCOUNT_BUTTON","Ano käyttäjätiliä");
define("DS_STRING_REGISTR_ACC_REQ_SUCC",            "Käyttäjätilianomus lähetetty!");
define("DS_STRING_REGISTR_YOU_WILL_BE_INFORMED",    "Saat sähköposti-ilmoituksen piakkoin.");





/* Navigation */

define("DS_STRING_NAV_MENU_MEASUREMENT",            "Uusimmat historiatiedot");
define("DS_STRING_NAV_MENU_DEVICES",                "Omat MAC-laitteet");
define("DS_STRING_ALARM_MENU",                      "Omat valvonnat");
define("DS_STRING_NAV_MENU_PROFILES",               "Omat profiilit");
define("DS_STRING_NAV_MENU_ACCOUNT",                "Oma käyttäjätili");
define("DS_STRING_NAV_MENU_ADMIN",                  "Käyttäjien hallinta");
define("DS_STRING_NAV_MENU_LOGOUT",                 "Kirjaudu ulos");





/* Main page */

define("DS_STRING_MAIN_SLOGAN",                     "Better air quality,<br />&nbsp;better life with<br /><span>Open Source</span>");
define("DS_STRING_MAIN_INC_FONT",                   "Suurenna kirjasinkokoa");
define("DS_STRING_MAIN_DEC_FONT",                   "Pienennä kirjasinkokoa");
define("DS_STRING_MAIN_LATEST_MEASUREMENTS",        "Uusimmat historiatiedot");
define("DS_STRING_MAIN_SHOW_LATEST_STAT",           "Tarkastele mittauksia");
define("DS_STRING_MAIN_CHOOSE_DEVICE",              "Laite:");
define("DS_STRING_MAIN_CHOOSE_PERIOD",              "Ajanjakso:");
define("DS_STRING_MAIN_CHOOSE_TODAY",               "Tältä päivältä");
define("DS_STRING_MAIN_CHOOSE_1_DAY",               "Eilseltä päivältä");
define("DS_STRING_MAIN_CHOOSE_2_DAYS",              "Kahdelta päivältä");
define("DS_STRING_MAIN_CHOOSE_5_DAYS",              "Viideltä päivältä");
define("DS_STRING_MAIN_CHOOSE_10_DAYS",             "Kymmeneltä päivältä");
define("DS_STRING_MAIN_CHOOSE_15_DAYS",             "15 päivältä");
define("DS_STRING_MAIN_CHOOSE_30_DAYS",             "Kuukaudelta");
define("DS_STRING_MAIN_CHOOSE_60_DAYS",             "Kahdelta kuukaudelta");
define("DS_STRING_MAIN_CHOOSE_90_DAYS",             "Kolmelta kuukaudelta");
define("DS_STRING_MAIN_NO_DEV_ADDED",               "Ei laitteita.");
define("DS_STRING_MAIN_NO_MAC_DEV_ADDED",           "Ei MAC-laitetta.");
define("DS_STRING_MAIN_SHOW_BUTTON",                "Tarkastele");

define("DS_STRING_HELP_CAPTION_LATEST_MEASUREMENTS","Uusimmat historiatiedot");
define("DS_STRING_HELP_CONTENT_LATEST_MEASUREMENTS","Tällä sivulla näet viimeisimmät mittaustiedot. Voit myös siirtyä tarkastelemaan viimeisimpiä tallennettuja mittauksia laitekohtaisesti.");





/* Latest Measurements */

define("DS_STRING_MAIN_CAPTION_STATISTICS",         "Latest Measurements - Statistics");
define("DS_STRING_MSG_WAIT_LOAD",                   "Loading...");
define("PV_STR_THUMBNAIL_VIEW",                     "Pikkukuvat" );
define("PV_STR_THUMBNAILS",                         "Näytä pikkukuvat.") ;
define("PV_STR_IMAGE",                              "Näytä kuva." );
define("PV_STR_FIRST",                              "Ensimmäinen kuva." );
define("PV_STR_PREV",                               "Edellinen kuva." );
define("PV_STR_NEXT",                               "Seuraava kuva." );
define("PV_STR_LAST",                               "Viimeinen kuva." );
define("PV_STR_IMG",                                "Tietokantanäkymä." );

define("DS_STRING_HELP_CAPTION_STATISTICS",         "Tietojen tarkastelu");
define("DS_STRING_HELP_CONTENT_STATISTICS",         "Tällä sivulla näet viimeisimmät tallennetut mittaukset valitsemaltasi laitteelta ja aikaväliltä.");

define( "DS_STRING_MAIN_NO_DATA_SENSOR",            "Ei mittauksia anturilta " );
define( "DS_STRING_MAIN_NO_DATA_BETWEEN",           " aikavälillä " );
define( "PV_STR_NODATA",                            "Ei kuvia annetulla aikavälillä." );





/* My MAC Devices */

define("DS_STRING_MAIN_CAPTION_MAC_DEVS",           "Omat MAC-laitteet");
define("DS_STRING_MAIN_CAPTION_DEV_ADD",            "Lisää uusi MAC-laite");
define("DS_STRING_PROF_MNG_SUBMIT_BUTTON",          "Lisää");
define("DS_STRING_PROF_MNG_SET_DEV_NAME",           "Nimi");
define("DS_STRING_PROF_MNG_INSERT_MAC",             "MAC-osoite");
define("DS_STRING_PROF_MNG_NAME",                   "Nimi");
define("DS_STRING_PROF_MNG_MAC",                    "MAC-osoite");
define("DS_STRING_PROF_MNG_ACTION",                 "Hallitse");
define("DS_STRING_PROF_MNG_MANAGE",                 "Muokkaa profiileja");
define("DS_STRING_PROF_MNG_REMOVE",                 "Poista");
define("DS_STRING_PROF_MNG_ADD_NEW",                "Lisää uusi laite");

define("DS_STRING_MAC_MNG_BIND_NO_INFO",            "Ole hyvä ja täytä molemmat kentät!");
define("DS_STRING_MAC_MNG_BIND_MAC_IN_USE",         "MAC-osoite on jo käytössä! ");
define("DS_STRING_MAC_MNG_BIND_TO_USER_SUCC",       "MAC-laitteen luominen onnistui käyttäjälle ");
define("DS_STRING_MAC_MNG_BIND_TO_USER_AS",         " nimellä ");
define("DS_STRING_DEV_MNG_DEV_REM_SUCC",            "MAC-laitteen poistaminen onnistui.");
define("DS_STRING_DEV_MNG_DEV_REM_ERR",             "MAC-laitteen poistaminen epäonnistui. Ota yhteyttä järjestelmänvalvojaan.");
define("DS_STRING_MAC_MNG_BIND_MAC_INVALID",        "MAC-laitteen lisääminen epäonnistui. Ota yhteyttä järjestelmänvalvojaan.");

define("DS_STRING_HELP_CAPTION_DEV_MAIN",           "Omat MAC-laitteet");
define("DS_STRING_HELP_CONTENT_DEV_MAIN",           "Tällä sivulla voit lisätä ja poistaa MAC-laitteita.<br /><i>MAC-osoite</i> on muotoa XX:XX:XX:XX:XX:XX, jossa X on heksadesimaalinumero. Osoitteen näet laitteestasi tai voit kysyä sitä järjestelmän ylläpitäjältä.<br /><i>Nimi</i> on vapaamuotoinen teksti, jolla haluat kuvata laitetta.<br /><b>HUOM! MAC-laitteen poistamista ei voi peruuttaa ja myös kaikki MAC-laitteeseen liitetyt laitteet ja sensorit poistetaan.</b>");





/* My Monitorings */

define("DS_STRING_ALARM_MAINPAGE",                  "Omat valvonnat");
define("DS_STRING_ALARM_SETTINGS_NAV_BACK",         "Edellinen");
define("DS_STRING_ALARM_SETTINGS_NAV_NEXT",         "Seuraava");
define("DS_STRING_ALARM_SETTINGS_LINK_NEW",         "Luo uusi valvonta.");
define("DS_STRING_ALARM_HISTORY_LINK_ALL",          "Näytä kaikki historiatiedot.");
define("DS_STRING_ALARM_MNG_NAME",                  "Nimi");
define("DS_STRING_ALARM_MNG_SCHEDULE",              "Aikataulut");
define("DS_STRING_ALARM_MNG_SENSORS",               "Anturit");
define("DS_STRING_ALARM_MNG_CONTACTS",              "Yhteyshenkilöt");
define("DS_STRING_ALARM_MNG_MANAGE",                "Hallinnoi");
define("DS_STRING_ALARM_MNG_NEW",                   "Luo");
define("DS_STRING_ALARM_MNG_SAVE",                  "Tallenna muutokset");
define("DS_STRING_ALARM_MNG_EDIT_ALARM",            "Muokkaa valvontaa.");
define("DS_STRING_ALARM_MNG_HISTORY",               "Näytä historiatiedot.");
define("DS_STRING_ALARM_MNG_DELETE",                "Poista valvonta.");
define("DS_STRING_ALARM_NEW_ALARM",                 "Omat valvonnat - Uusi valvonta");
define("DS_STRING_ALARM_SETTINGS_PAGE",             "Omat valvonnat - Muokkaa valvontaa");
define("DS_STRING_ALARM_NEW_PAGE",                  "Luo uusi valvonta");
define("DS_STRING_ALARM_EDIT_PAGE",                 "Muokkaa valvontaa");
define("DS_STRING_ALARM_MNG_ALARM_NAME",            "Nimi:");
define("DS_STRING_ALARM_MNG_ALARM_TYPE",            "Ilmoitustapa:");
define("DS_STRING_ALARM_MNG_SMS",                   "Tekstiviesti");
define("DS_STRING_ALARM_MNG_EMAIL",                 "Sähköposti");
define("DS_STRING_ALARM_MNG_COMPOSITE",             "Molemmat");
define("DS_STRING_ALARM_MNG_SMALL_MSG",             "Lyhyt viesti:<br>(Tekstiviesti / Sähköpostin otsikko)<br>");
define("DS_STRING_ALARM_MNG_BIG_MSG",               "Pitkä viesti:<br>(Sähköpostin sisältö)<br>");
define("DS_STRING_ALARM_MNG_NEW",                   "Luo uusi valvonta");
define("DS_STRING_ALARM_MNG_EDIT",                  "Tallenna muutokset");

define("DS_STRING_ALARM_CONFIRM_QUESTION_DEFAULT",  "Haluatko varmasti poistaa?");
define("DS_STRING_ALARM_CONFIRM_QUESTION_HISTORY",  "Haluatko varmasti poistaa historiatiedot?");
define("DS_STRING_ALARM_CONFIRM_YES",               "Kyllä");
define("DS_STRING_ALARM_CONFIRM_NO",                "Ei");

define("DS_STRING_HELP_CAPTION_ALARM_MAIN",         "Omat valvonnat");
define("DS_STRING_HELP_CONTENT_ALARM_MAIN",         "Tällä sivulla voit luoda, muokata ja poistaa valvontoja sekä tarkastella historiatietoja.<br /><i>Valvontojen</i> avulla saat tiedon siitä, kun määrittelemäsi anturin arvo poikkeaa määritellystä arvosta. Halutessasi saat tapahtumasta ilmoituksen sähköpostitse tai tekstiviestillä. Tapahtuma tallentuu myös valvontahistoriaan.<br /><i>Anturit</i>-sarakkeessa palava lamppu tarkoittaa sitä, että anturi on seurantatilassa. Klikkaamalla sammunnutta lamppua, voit asettaa lauenneen anturin takaisin seurantatilaan.");
define("DS_STRING_HELP_CAPTION_ALARM_SETTINGS",     "Muokkaa valvontaa");
define("DS_STRING_HELP_CONTENT_ALARM_SETTINGS",     "Tällä sivulla voit muokata valitsemaasi valvontaa.<br /><i>Nimi</i> on vapaamuotoinen teksti, jolla erotat valvonnat toisistaan.<br /><i>Ilmoitustapa</i> määrittää tavat, joilla yhteyshenkilöille voidaan ilmoittaa valvonnan laukeamisesta.<br /><i>Lyhyt viesti</i> on tekstiviesti-ilmoituksen sisältö, jota käytetään myös sähköposti-ilmoituksen otsikkona.<br /><i>Pitkä viesti</i> on sähköposti-ilmoituksen teksti.<br /><b>HUOM! Ilmoitustoiminnot (Tekstiviesti/Sähköposti/Molemmat) eivät ole käytössä demoversiossa.</b>");





/* My Monitorings - History */

define("DS_STRING_ALARM_HISTORY_PAGE",              "Omat valvonnat - Historiatiedot");
define("DS_STRING_ALARM_HISTORY_NAV_CLEAR",         "Tyhjennä historia");
define("DS_STRING_ALARM_HISTORY_TIME",              "Tapahtuma-aika");
define("DS_STRING_ALARM_HISTORY_ALARM_NAME",        "Valvonta");
define("DS_STRING_ALARM_HISTORY_SCHEDULE_NAME",     "Aikataulu");
define("DS_STRING_ALARM_HISTORY_SENSOR_NAME",       "Anturi");
define("DS_STRING_ALARM_HISTORY_VALUE",             "Arvo");

define("DS_STRING_HELP_CAPTION_ALARM_HISTORY",              "Historiatiedot");
define("DS_STRING_HELP_CONTENT_ALARM_HISTORY",              "Tällä sivulla näet valitsemasi valvonnan historiatiedot.");

define("DS_STRING_STAT_NO_DATA_BETWEEN",                    "Ei historiatietoja aikaväliltä ");





/* My Monitorings - My Schedules */

define("DS_STRING_ALARM_SCHEDULE_PAGE",             "Omat valvonnat - Omat aikataulut");
define("DS_STRING_ALARM_NEW_SCHEDULE_PAGE",         "Omat valvonnat - Uusi aikataulu");
define("DS_STRING_ALARM_EDIT_SCHEDULE_PAGE",        "Omat valvonnat - Muokkaa aikataulua");
define("DS_STRING_ALARM_NEW_TRIGGER",               "Luo uusi aikataulu");
define("DS_STRING_ALARM_EDIT_TRIGGER",              "Muokkaa aikataulua");
define("DS_STRING_ALARM_SCHEDULES_NAV_BACK",        "Edellinen");
define("DS_STRING_ALARM_SCHEDULES_NAV_NEXT",        "Seuraava");
define("DS_STRING_ALARM_MNG_SCHEDULE_NAME",         "Nimi");
define("DS_STRING_ALARM_SCHEDULE_LINK_ADD",         "Liitä aikataulu valvontaan.");
define("DS_STRING_ALARM_SCHEDULE_LINK_REM",         "Poista aikataulu valvonnasta.");
define("DS_STRING_ALARM_SCHEDULE_LINK_EDIT",        "Muokkaa aikataulua.");
define("DS_STRING_ALARM_SCHEDULE_LINK_DEL",         "Poista aikataulu.");
define("DS_STRING_ALARM_MNG_SCHEDULE_NAME_EDIT",    "Nimi:");
define("DS_STRING_ALARM_MNG_SCHEDULE_VALUES",       "Anturin arvo:");
define("DS_STRING_ALARM_MNG_MIN_VALUE",             "Alaraja:");
define("DS_STRING_ALARM_MNG_MAX_VALUE",             "Yläraja:");
define("DS_STRING_ALARM_MNG_TRIGGER_WITHIN",        "Kytkeytyy rajojen sisäpuolella.");
define("DS_STRING_ALARM_MNG_TRIGGER_OUTSIDE",       "Kytkeytyy rajojen ulkopuolella.");
define("DS_STRING_ALARM_MNG_TIME",                  "Tapahtuma-aika:");
define("DS_STRING_ALARM_MNG_ALWAYS",                "Milloin tahansa:");
define("DS_STRING_ALARM_MNG_MONTHS",                "Kuukaudet:");
define("DS_STRING_ALARM_MNG_ALL_MONTHS",            "Kaikki kuukaudet.");
define("DS_STRING_ALARM_MNG_SELECTED_MONTHS",       "Valitut kuukaudet:");
define("DS_STRING_ALARM_MNG_JAN",                   "Tammi");
define("DS_STRING_ALARM_MNG_FEB",                   "Helmi");
define("DS_STRING_ALARM_MNG_MAR",                   "Maalis");
define("DS_STRING_ALARM_MNG_APR",                   "Huhti");
define("DS_STRING_ALARM_MNG_MAY",                   "Touko");
define("DS_STRING_ALARM_MNG_JUN",                   "Kesä");
define("DS_STRING_ALARM_MNG_JUL",                   "Heinä");
define("DS_STRING_ALARM_MNG_AUG",                   "Elo");
define("DS_STRING_ALARM_MNG_SEP",                   "Syys");
define("DS_STRING_ALARM_MNG_OCT",                   "Loka");
define("DS_STRING_ALARM_MNG_NOV",                   "Marras");
define("DS_STRING_ALARM_MNG_DEC",                   "Joulu");
define("DS_STRING_ALARM_MNG_DAYS",                  "Päivät:");
define("DS_STRING_ALARM_MNG_ALL_DAYS",              "Kaikki päivät.");
define("DS_STRING_ALARM_MNG_SELECT_DAYS",           "Valitut päivät:");
define("DS_STRING_ALARM_MNG_SUN",                   "Su");
define("DS_STRING_ALARM_MNG_MON",                   "Ma");
define("DS_STRING_ALARM_MNG_TUE",                   "Ti");
define("DS_STRING_ALARM_MNG_WED",                   "Ke");
define("DS_STRING_ALARM_MNG_THU",                   "To");
define("DS_STRING_ALARM_MNG_FRI",                   "Pe");
define("DS_STRING_ALARM_MNG_SAT",                   "La");
define("DS_STRING_ALARM_MNG_ALL_DAY",               "Koko päivä (24h):");
define("DS_STRING_ALARM_MNG_START_TIME",            "Aikaisintaan:");
define("DS_STRING_ALARM_MNG_END_TIME",              "Myöhäisintään:");
define("DS_STRING_ALARM_MNG_ALL_YEAR",              "Koko vuosi:");
define("DS_STRING_ALARM_MNG_START_DATE",            "Alkaen:");
define("DS_STRING_ALARM_MNG_END_DATE",              "Loppuen:");
define("DS_STRING_ALARM_MNG_HH_MM_SS",              "(tt:mm:ss)");
define("DS_STRING_ALARM_MNG_YYYY_MM_DD_HH_MM_SS",   "(vvvv-kk-pp tt:mm:ss)");

define("DS_STRING_ALARM_SCHEDULE_MSG_APPEND",       "<font color=\"green\">Aikataulu liitetty valvontaan.</font>");
define("DS_STRING_ALARM_SCHEDULE_MSG_REMOVED",      "<font color=\"green\">Aikataulu poistettu valvonnasta.</font>");
define("DS_STRING_ALARM_SCHEDULE_MSG_ADDED",        "<font color=\"green\">Aikataulun luominen onnistui.</font>");
define("DS_STRING_ALARM_SCHEDULE_MSG_DELETED",      "<font color=\"green\">Aikataulun poistaminen onnistui.</font>");
define("DS_STRING_ALARM_SCHEDULE_MSG_EDITED",       "<font color=\"green\">Aikataulun muokkaaminen onnistui.</font>");

define("DS_STRING_HELP_CAPTION_ALARM_SCHEDULE",     "Omat aikataulut");
define("DS_STRING_HELP_CONTENT_ALARM_SCHEDULE",     "Tällä sivulla voit luoda, muokata ja poistaa aikatauluja sekä liittää niitä muokattavanasi olevaan valvontaan.<br /><i>Nimi</i> on vapaamuotoinen teksti, jonka avulla erotat aikataulut toisistaan.<br /><i>Anturin arvo</i> määrittää anturin arvolle rajat, joiden sisä- tai ulkopuolella valvonta laukeaa.<br /><i>Tapahtuma-aika</i> määrittää ajan, jolloin valvonta on voimassa.<br />Valinnalla <i>milloin tahansa</i> valvonta laukeaa aina, kun anturin arvo poikkeaa sallitusta. Halutessasi voit valita kuukaudet ja/tai viikonpäivät, jolloin valvonta on voimassa.<br />Valinnalla <i>koko päivä (24h)</i> valvonta on voimassa ympäri vuorokauden. Halutessasi voit määrittää aikavälin, jolloin hälytys laukeaa.<br />Valinnalla <i>koko vuosi</i> valvonta on voimassa ympärivuoden. Halutessasi voit määrittää aloitus- ja lopetusajan, joiden välillä valvonta on voimassa.");






/* My Monitorings - My Sensors */

define("DS_STRING_ALARM_SENSORS_PAGE",              "Omat valvonnat - Omat anturit");
define("DS_STRING_ALARM_SENSORS_NAV_BACK",          "Edellinen");
define("DS_STRING_ALARM_SENSORS_NAV_NEXT",          "Seuraava");
define("DS_STRING_ALARM_MNG_SENSOR_NAME",           "Anturi");
define("DS_STRING_ALARM_MNG_DEVICE_NAME",           "Laite");
define("DS_STRING_ALARM_MNG_PROFILE_NAME",          "Profiili");
define("DS_STRING_ALARM_MNG_ENABLED",               "Tila");
define("DS_STRING_ALARM_MNG_AUTOENABLE",            "Automaattipalautus");
define("DS_STRING_ALARM_SENSOR_AUTOENABLE",         "Kyllä");
define("DS_STRING_ALARM_SENSOR_NOAUTOENABLE",       "Ei");
define("DS_STRING_ALARM_SENSOR_ENABLED",            "Poista seurantatilasta.");
define("DS_STRING_ALARM_SENSOR_DISABLED",           "Aseta seurantatilaan.");
define("DS_STRING_ALARM_SENSOR_LINK_ADD",           "Liitä anturin valvontaan.");
define("DS_STRING_ALARM_SENSOR_LINK_DEL",           "Poista anturi valvonnasta.");

define("DS_STRING_ALARM_SENSOR_MSG_APPEND",         "<font color=\"green\">Anturi liitetty valvontaan.</font>");
define("DS_STRING_ALARM_SENSOR_MSG_REMOVED",        "<font color=\"green\">Anturi poistettu valvonnasta.</font>");
define("DS_STRING_ALARM_SENSOR_MSG_ENABLED",        "<font color=\"green\">Anturin asettaminen seurantatilaan onnistui.</font>");
define("DS_STRING_ALARM_SENSOR_MSG_DISABLED",       "<font color=\"green\">Anturin poistaminen seurantatilasta onnistui.</font>");
define("DS_STRING_ALARM_SENSOR_MSG_AUTOENABLE",     "<font color=\"green\">Anturin automaattipalautus kytketty.</font>");
define("DS_STRING_ALARM_SENSOR_MSG_NOAUTOENABLE",   "<font color=\"green\">Anturin automaattipalautus poiskytketty.</font>");

define("DS_STRING_HELP_CAPTION_ALARM_SENSORS",      "Omat anturit");
define("DS_STRING_HELP_CONTENT_ALARM_SENSORS",      "Tällä sivulla voit liittää ja poistaa antureita valvonnasta sekä palauttaa lauenneen anturin takaisin käyttöön.<br /><i>Tila</i>-sarakkeessa oleva palava lamppu tarkoittaa, että anturi on seurantatilassa. Voit palauttaa anturin takaisin seurantatilaan klikkaamalla sammunutta lamppua.<br /><i>Automaattipalautus</i>-sarakkeen kyllä-teksti kertoo, että anturi pysyy seurantatilassa, vaikka se aiheuttaisikin hälytyksen. Klikkaamalla tekstiä, voit poistaa automaattipalautuksen käytöstä, jolloin anturi on asetettava seurantatilaan käsin sen aiheutettua hälytyksen.<br /><i>Hallinnoi</i>-sarakkeen ikonia klikkaamalla voit liittää tai poistaa anturin valvonnasta.");





/* My Monitorings - My Contacts */

define("DS_STRING_ALARM_CONTACTS_PAGE",             "Omat valvonnat - Omat yhteyshenkilöt");
define("DS_STRING_ALARM_CONTACTS_NAV_BACK",         "Edellinen");
define("DS_STRING_ALARM_CONTACTS_NAV_NEXT",         "Valmis");
define("DS_STRING_ALARM_CONTACTS_NAME",             "Nimi");
define("DS_STRING_ALARM_CONTACTS_EMAIL",            "Sähköpostiosoite");
define("DS_STRING_ALARM_MNG_PHONE",                 "Puhelinnumero");
define("DS_STRING_ALARM_CONTACTS_LINK_SMS_ADD",     "Lisää tekstiviestin vastaanottajaksi.");
define("DS_STRING_ALARM_CONTACTS_LINK_SMS_DEL",     "Poista tekstiviestin vastaanottajista.");
define("DS_STRING_ALARM_CONTACTS_LINK_EMAIL_ADD",   "Lisää sähköpostin vastaanottajaksi.");
define("DS_STRING_ALARM_CONTACTS_LINK_EMAIL_DEL",   "Poista sähköpostin vastaanottajista.");
define("DS_STRING_ALARM_CONTACTS_LINK_EDIT",        "Muokkaa yhteyshenkilöä.");
define("DS_STRING_ALARM_CONTACTS_LINK_DEL",         "Poista yhteyshenkilö.");
define("DS_STRING_ALARM_MNG_ADD_NEW_CONTACT",       "Lisää uusi yhteyshenkilö");
define("DS_STRING_ALARM_MNG_EDIT_CONTACT",          "Muokkaa yhteyshenkilöä");
define("DS_STRING_ALARM_MNG_CONTACT_NAME",          "Nimi:");
define("DS_STRING_ALARM_MNG_CONTACT_EMAIL",         "Sähköposti:"); 
define("DS_STRING_ALARM_MNG_CONTACT_PHONE",         "Puhelinnumero:");
define("DS_STRING_ALARM_MNG_NEW_CONTACT",           "Luo");


define("DS_STRING_ALARM_CONTACTS_MSG_ADDED",        "<font color=\"green\">Yhteyshenkilön luominen onnistui.</font>");
define("DS_STRING_ALARM_CONTACTS_MSG_DELETED",      "<font color=\"green\">Yhteyshenkilön poistaminen onnistui.</font>");
define("DS_STRING_ALARM_CONTACTS_MSG_EDITED",       "<font color=\"green\">Yhteyshenkilön muokkaaminen onnistui.</font>");
define("DS_STRING_ALARM_CONTACTS_MSG_APPEND_SMS",   "<font color=\"green\">Yhteyshenkilön lisääminen tekstiviestin vastaanottajaksi onnistui.</font>");
define("DS_STRING_ALARM_CONTACTS_MSG_APPEND_EMAIL", "<font color=\"green\">Yhteyshenkilön lisääminen sähköpostin vastaanottajaksi onnistui.</font>");
define("DS_STRING_ALARM_CONTACTS_MSG_REMOVED_SMS",  "<font color=\"green\">Yhteyshenkilön poistaminen tekstiviestin vastaanottajista onnistui.</font>");
define("DS_STRING_ALARM_CONTACTS_MSG_REMOVED_EMAIL","<font color=\"green\">Yhteyshenkilön poistaminen sähköpostin vastaanottajista onnistui.</font>");

define("DS_STRING_HELP_CAPTION_ALARM_CONTACTS",     "Omat yhteyshenkilöt");
define("DS_STRING_HELP_CONTENT_ALARM_CONTACTS",     "Tällä sivulla voit luoda, muokata ja poistaa yhteyshenkilöitä sekä lisätä tai poistaa heitä muokkaamasi valvonnan sähköposti- tai tekstiviesti-ilmoituksen vastaanottajista.<br /><b>HUOM! Ilmoituksia ei lähetetä demoversiossa.</b>");





/* My Profiles */

define("DS_STRING_MAIN_CAPTION_PROFILES",           "Omat profiilit");
define("DS_STRING_PROF_MNG_PROFILE_INFO",           "Lisää Uusi profiili");
define("DS_STRING_PROF_MNG_PROFILE_OWNER",          "Käyttäjätunnus:");
define("DS_STRING_PROF_MNG_PROFILE_NAME",           "Profiilin nimi:");
define("DS_STRING_PROF_MNG_PROFILE_PWD",            "Salasana:");
define("DS_STRING_PROF_MNG_PROFILE_CONFIRM_PWD",    "Vahvista salasana:");
define("DS_STRING_PROF_MNG_CREATE_PROF_BUTTON",     "Lisää");
define("DS_STRING_PROF_PROFILES",                   "Omat profiilit");
define("DS_STRING_PROF_ADD_MAC",                    "Lisää MAC-laite");
define("DS_STRING_PROF_MNG_PROFILE_NAME_TBL",       "Nimi");
define("DS_STRING_PROF_MNG_GW_NAME",                "MAC-laite");
define("DS_STRING_PROF_MNG_ADD_DEVICE",             "Lisää laite");
define("DS_STRING_PROF_MNG_DELETE_THIS_PROFILE",    "Poista");
define("DS_STRING_PROF_MNG_EDIT",                   "Muokkaa");

define("DS_STRING_PROF_MNG_PROFILE_NAME_EMPTY",     "Anna profiilin nimi!");
define("DS_STRING_PROF_MNG_PROFILE_EXISTS",         "Samanniminen profiili on jo olemassa!");
define("DS_STRING_PROF_MNG_PWD_MISMATCH_OR_SHORT",  "Salasana oli liian lyhyt tai salasanat eivät vastanneet toisiaan!");
define("DS_STRING_PROF_MNG_CREATE_SUCC",            "Profiilin luominen onnistui.");
define("DS_STRING_PROF_MNG_PROFILE_REMOVED_BEGIN",  "Profiili < ");
define("DS_STRING_PROF_MNG_PROFILE_REMOVED_END",    " > poistettu!");
define("DS_STRING_PROF_MNG_PROFILE_REMOVE_ERROR_BEGIN","Profiilin poistaminen epäonnistui < ");
define("DS_STRING_PROF_MNG_PROFILE_REMOVE_ERROR_END"," > ");

define("DS_STRING_HELP_CAPTION_PROF_MAIN",          "Omat profiilit");
define("DS_STRING_HELP_CONTENT_PROF_MAIN",          "Tällä sivulla voit lisätä, muokata ja poistaa profiilejasi.<br /><i>Profiilien</i> avulla voit luoda erilaisia näkymiä järjestelmäsi laitteisiin ja halutessasi antaa myös muiden tarkastella järjestelmääsi luomiesi profiilien kautta.");





/* My Profiles - Edit profile */

define("DS_STRING_MAIN_CAPTION_ADD_DEV_TO_PROF",    "Muokkaa profiilia ");
define("DS_STRING_PROF_MNG_PROFILE",                "Profiili");
define("DS_STRING_PROF_MNG_DEVICE",                 "Laite");
define("DS_STRING_PROF_MNG_DEV_NAME",               "Muuta laitteen nimi:");
define("DS_STRING_PROF_MNG_UPDATE",                 "Muuta");
define("DS_STRING_PROF_MNG_ADD_TO_PROF",            "Lisää profiiliin");
define("DS_STRING_PROF_MNG_REMOVE_FROM_PROF",       "Poista profiilista");
define("DS_STRING_PROF_MNG_SENSORS",                "Anturit");
define("DS_STRING_PROF_MNG_SHOW_INFO",              "Näytä anturit");
define("DS_STRING_PROF_MNG_SENSOR_ID",              "Osoite");
define("DS_STRING_PROF_MNG_SENSOR_TYPE",            "Tyyppi");
define("DS_STRING_PROF_MNG_SET_SENSOR_NAME",        "Muuta anturin nimi:");

define("DS_STRING_DEV_MNG_DEV_UPD_NAME_ERROR",              "Virhe muutettaessa laitteen nimeä:<b>");
define("DS_STRING_DEV_MNG_DEV_UPD_NAME_SUCC",               "Laitteen nimi muutettu: ");
define("DS_STRING_DEV_MNG_DEV_ADD_TO_PROF_ERROR_BEGIN",     "Virhe lisättäessä laitetta <b>");
define("DS_STRING_DEV_MNG_DEV_ADD_TO_PROF_ERROR_END",       " profiiliin</b>");
define("DS_STRING_DEV_MNG_DEV_ADD_TO_PROF_SUCC",            "Laite lisätty onnistuneesti:");
define("DS_STRING_DEV_MNG_DEV_ADD_TO_PROF_SUCC_BEGIN",      "Laite <");
define("DS_STRING_DEV_MNG_DEV_ADD_TO_PROF_SUCC_END",        "> lisätty profiiliin: ");
define("DS_STRING_DEV_MNG_DEV_REM_FROM_PROF_ERROR_BEGIN",   "Virhe poistettaessa laitetta <");
define("DS_STRING_DEV_MNG_DEV_REM_FROM_PROF_ERROR_END",     "> profiilista: ");
define("DS_STRING_DEV_MNG_DEV_REM_FROM_PROF_SUCC_BEGIN",    "Laite <");
define("DS_STRING_DEV_MNG_DEV_REM_FROM_PROF_SUCC_END",      "> poistettu profiilista: ");
define("DS_STRING_SENSOR_MNG_UPDATED",                      "Anturin nimi muutettu.");

define("DS_STRING_HELP_CAPTION_PROF_PROP",          "Muokkaa profiilia");
define("DS_STRING_HELP_CONTENT_PROF_PROP",          "Tällä sivulla voit lisätä ja poistaa laitteita valitsemastasi profiilista. Voit myös nimetä laitteet ja sensorit.<br />Voit lisätä laitteen profiiliin klikkaamalla <i>lisää profiiliin</i> -painiketta. Jos laite on jo liitetty profiiliin, voit poistaa sen klikkaamalla <i>poista profiilista</i> -painiketta.<br />Voit muuttaa laitteen nimen kirjoittamalla haluamasi nimen <i>muuta laitteen nimi</i> -tekstikenttään ja klikkaamalla <i>muuta</i>-painiketta.<br />Voit tarkastella laitteen antureita klikkaamalla <i>Näytä anturit</i>-linkkiä.<br />Voit muuttaa anturin nimen kirjoittamalla haluamasi nimen kyseisen anturin kohdalla olevaan <i>muuta anturin nimi</i> -tekstikenttään ja klikkaamalla <i>muuta</i>-painiketta.");





/* My Account */

define( "DS_STRING_USER_ACCOUNT_CAPTION",           "Oma käyttäjätili" );
define( "DS_STRING_USER_CHANGE_PASSWORD_CAPTION",   "Vaihda salasana" );
define( "DS_STRING_USER_CURRENT_PASSWORD",          "Nykyinen salasana:" );
define( "DS_STRING_USER_NEW_PASSWORD",              "Uusi salasana:" );
define( "DS_STRING_USER_CONFIRM_PASSWORD",          "Vahvista salasana:" );
define( "DS_STRING_USER_CHANGE_PASSWORD",           "Vaihda" );

define( "DS_STRING_USER_ACCOUNT_REMOVE_CAPTION",    "Poista käyttäjätili" );
define( "DS_STRING_USER_ACCOUNT_REMOVE",            "Poista" );

define( "DS_STRING_USER_ACCOUNT_REMOVE_CONFIRM",    "Haluatko varmasti poistaa käyttäjätilisi?" );
define( "DS_STRING_USER_ACCOUNT_REMOVE_FAILED",     "Käyttäjätilin poistaminen epäonnistui." );
define( "DS_STRING_USER_ACCOUNT_CHANGEPW_FAILED",   "Salasanan vaihtaminen epäonnistui." );
define( "DS_STRING_USER_ACCOUNT_CHANGEPW_SUCCESS",  "Salasana vaihdettu." );

define("DS_STRING_USER_ACCOUNT_HELP",               "Tällä sivulla voit vaihtaa salasanasi tai poistaa käyttäjätilisi.<br /><b>HUOM! Käyttäjätilin poistamista ei voi peruuttaa. Kaikki käyttäjätiliisi liittyvät tiedot poistetaan järjestelmästä pysyvästi heti, kun olet vastannut varmistuskysymykseen myöntävästi.");





/* User Management */

define("DS_STRING_MAIN_CAPTION_MANAGE_USERS",       "Käyttäjien hallinta");
define("DS_STRING_USR_MNG_USER_MANAGEMENT",         "Käyttäjätilien hallinta");
define("DS_STRING_USR_MNG_PENDING_REQ_MANAGEMENT",  "Käyttäjätilianomusten hallinta");
define( "DS_STRING_YES",                            "Kyllä" );
define( "DS_STRING_NO",                             "Ei" );

define( "DS_STRING_USER_SYSTEM_ERROR",              "Järjestelmävirhe. Ota yhteys järjestelmänvalvojaan." );

define("DS_STRING_HELP_CAPTION_ADMIN",              "Käyttäjien hallinta");
define("DS_STRING_HELP_CONTENT_ADMIN",              "Tältä sivulta pääset muokkaamaan käyttäjiä ja tarkastelemaan käyttäjätilianomuksia.");





/* User Management - Account Management */

define( "DS_STRING_USER_USERS_CAPTION",             "Käyttäjien hallinta" );
define( "DS_STRING_USER_EMAIL_ADDRESS",             "Sähköpostiosoite" );
define( "DS_STRING_USER_ACCOUNT_CREATED",           "Tili luotu" );
define( "DS_STRING_USER_LAST_LOGIN",                "Edellinen sisäänkirjaus" );
define( "DS_STRING_USER_VISITS",                    "Käyntejä" );
define( "DS_STRING_USER_STATUS",                    "Tila" );
define( "DS_STRING_USER_ROLE",                      "Rooli" );
define( "DS_STRING_USER_MANAGE",                    "Hallitse" );
define( "DS_STRING_USER_ACTIVE",                    "Aktiivinen" );
define( "DS_STRING_USER_INACTIVE",                  "Estetty" );
define( "DS_STRING_USER_ADMIN",                     "Pääkäyttäjä" );
define( "DS_STRING_USER_USER",                      "Käyttäjä" );
define( "DS_STRING_USER_ACTIVATE",                  "Aktivoi" );
define( "DS_STRING_USER_INACTIVATE",                "Estä" );
define( "DS_STRING_USER_USERIZE",                   "Käyttäjäksi" );
define( "DS_STRING_USER_ADMINIZE",                  "Pääkäyttäjäksi" );
define( "DS_STRING_USER_REMOVE",                    "Poista" );
define( "DS_STRING_USER_MANAGE_REQUESTS",           "Käyttäjätilianomusten hallinta");

define( "DS_STRING_USER_REMOVE_CONFIRM",            "Haluatko varmasti poistaa käyttäjän?" );
define( "DS_STRING_USER_TOGGLE_ROLE_FAILED",        "Roolin vaihtaminen epäonnistui." );
define( "DS_STRING_USER_TOGGLE_ROLE_SUCCESS",       "Käyttäjän rooli vaihdettu." );
define( "DS_STRING_USER_TOGGLE_STATUS_FAILED",      "Tilan vaihtaminen epäonnistui." );
define( "DS_STRING_USER_TOGGLE_STATUS_SUCCESS",     "Käyttäjän tila vaihdettu." );
define( "DS_STRING_USER_REMOVE_FAILED",             "Käyttäjän poistaminen epäonnistui." );
define( "DS_STRING_USER_REMOVE_SUCCESS",            "Käyttäjä poistettu." );

define("DS_STRING_USER_USERS_HELP",                 "Tällä sivulla voit estää tai sallia käyttäjien pääsyn järjestelmään tai muuttaa käyttäjien oikeuksia. Nykyisen käyttäjän oikeuksien muuttaminen ei ole sallittua.<br />Voit estää käyttäjän pääsyn järjestelmään klikkaamalla käyttäjän kohdalla olevaa <i>estä</i>-linkkiä. Voit purkaa eston klikkaamalla <i>aktivoi</i>-linkkiä.<br />Voit tehdä käyttäjästä pääkäyttäjän klikkaamalla <i>muuta pääkäyttäjäksi</i>-linkkiä. Voit myös tehdä pääkäyttäjästä tavallisen käyttäjän klikkaamalla <i>muuta käyttäjäksi</i>-linkkiä.<br /><b>HUOM! Kun olet tehnyt käyttäjästä pääkäyttäjän, hän voi estää pääsysi järjestelmään.</b>");





/* User Management - Account Request Management */

define( "DS_STRING_USER_REQUESTS_CAPTION",          "Käyttäjätilianomusten hallinta" );
define( "DS_STRING_USER_REQUEST_DATE",              "Päivämäärä" );
define( "DS_STRING_USER_REQUEST_REASON",            "Perustelut" );
define( "DS_STRING_USER_APPROVE_REQUEST",           "Hyväksy" );
define( "DS_STRING_USER_DECLINE_REQUEST",           "Hylkää" );
define( "DS_STRING_USER_NO_REQUESTS",               "Ei käyttäjätilianomuksia." );
define( "DS_STRING_USR_MNG_USERS",                  "Käyttäjien hallinta" );

define( "DS_STRING_USER_DECLINE_CONFIRM",           "Haluatko varmasti hylätä anomuksen?" );
define( "DS_STRING_USER_APPROVE_FAILED",            "Käyttäjätilianomuksen hyväksyminen epäonnistui." );
define( "DS_STRING_USER_APPROVE_SUCCESS",           "Käyttäjätilianomus hyväksytty." );
define( "DS_STRING_USER_DECLINE_FAILED",            "Käyttäjätilianomuksen hylkääminen epäonnistui." );
define( "DS_STRING_USER_DECLINE_SUCCESS",           "Käyttäjätilianomus hylätty." );

define("DS_STRING_USER_REQUESTS_HELP",              "Tällä sivulla voit hyväksyä tai hylätä avoimet käyttäjätilianomukset.<br /><b>HUOM! Käyttäjätilianomuksen hylkääminen poistaa sen järjestelmästä pysyvästi.</b>");

?>
