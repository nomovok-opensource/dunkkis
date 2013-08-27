<?php

/** Dunkkis Web User Interface, Dunkkis Server
  * ==========================================
  * Configuration file
  * 
  * Copyright (c) 2009-2010 Nomovok Ltd
  * This software is licensed under The MIT License. See LICENSE for details.
  */

/** MySQL database configuration.
  * db_host is the address of your database server. Usually "localhost".
  * You provided db_name, db_user and db_passwd to installer script when
  * asked for WEB UI configuration. Enter corresponding information here.
  */
$config['db_host'] = "localhost";
$config['db_name'] = "dunkkis_demo_v3";
$config['db_user'] = "dunkkis-v3";
$config['db_passwd'] = "dunkkis";

// Do NOT change!
$config["db_connstring"] = "mysql:host=".$config['db_host'].";dbname=".$config['db_name'];

/** Default language for user interface.
  */
$config['ds_language'] = "EN";

/** Absolute path to and name of WSDL file.
  */
$config['ds_wsdl_file'] = "/var/www/dunkkis-demo-v3/api/ds-services.wsdl";

/** Set crypt_passwd to true, to enable encrypted passwords (recommended).
  * Change password_salt to a custom string unique to your system.
  */
$config['crypt_passwd'] = TRUE;
$config['password_salt'] = "insert-your-random-generated-salt-here";

/** Absolute path to and name of log file. Set to false, to disable logging.
  */
$config['log_file'] = "/tmp/errorlog.log";

/** Default devices and profile for new users. 
  *Change according to your system spec.
  */
$config['test_macdevice_mac'] = "00:22:15:32:78:86";
$config['test_macdevice_name'] = "Test MAC Device";
$config['test_profile_name'] = "Test Profile";
$config['test_profile_password'] = "dunkkis";
$config['test_device1_idstr'] = "0E469C00";
$config['test_device1_name'] = "Test Device 1";
$config['test_device2_idstr'] = "04559C00";
$config['test_device2_name'] = "Test Device 2";

/** Preserved for compatibility reasons. Do NOT change.
  */
$config['usemysql'] = TRUE;

/** Defines the address of the MAC device, that can belong to multiple
  * users at the same time.
  * If USE_PERSISTENT_MAC is false, then this feature is not used and any
  * MAC device can be associated only with one user.
  */
define( "PERSISTENT_MAC",                       "00:22:15:32:78:86" );
define( "USE_PERSISTENT_MAC",                   true );

/** Maximum number of entries to be fetched when getting latest measurements
  * from the database.
  */
define("DS_VAR_DB_GET_MY_LATEST_DATA_LIMIT",    800);


/** Sensor types.
  */
define("DS_SENSOR_TYPE_GENERIC",                "Generic");
define("DS_SENSOR_TYPE_TEMPERATURE",            "Temperature");
define("DS_SENSOR_TYPE_PRESSURE",               "Pressure");
define("DS_SENSOR_TYPE_HUMIDITY",               "Humidity");
define("DS_SENSOR_TYPE_SPECIAL",                "Special");
define("DS_SENSOR_TYPE_CO2",                    "CO2");
define("DS_SENSOR_TYPE_DOOR",                   "Door");
define("DS_SENSOR_TYPE_MOTION",                 "Motion");
define("DS_SENSOR_TYPE_SWITCH",                 "Switch");
define("DS_SENSOR_TYPE_CUSTOM",                 "Custom");
define("DS_SENSOR_TYPE_LDR",                    "LDR");
define("DS_SENSOR_TYPE_PICTURE",                "Picture");

?>
