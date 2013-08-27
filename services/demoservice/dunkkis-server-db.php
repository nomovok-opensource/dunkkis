<?php

/** Dunkkis Server
  * ==============
  * 
  * Copyright (c) 2009-2010 Nomovok Ltd
  * This software is licensed under The MIT License. See LICENSE for details.
  */

require_once( "../sensor.inc" );
require_once( "dunkkis-server-config.inc.php"

/**
 * Open a connection to MySQL database.
 */
function db_init() {
	global $db_config;
	
	$link = mysql_connect($db_config['db_host'], $db_config['db_user'], $db_config['db_passwd']) 
		or die('Could not connect: ' . mysql_error());
	
	mysql_select_db($db_config["db_name"], $link) 
		or die ('Cant connect to db: ' . mysql_error());
	
	return $link;
}


?>
