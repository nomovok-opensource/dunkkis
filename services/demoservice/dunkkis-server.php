#!/usr/bin/php -q
<?php

/** Dunkkis Server
  * ==============
  * 
  * Copyright (c) 2009-2010 Nomovok Ltd
  * This software is licensed under The MIT License. See LICENSE for details.
  */

require_once( "dunkkis-server-db.php" );
require_once( "dunkkis-alarm.php" );

/**
 * Receving data through ssh mode.
 */
function start_ssh_mode() {
	while (true) {
		$received_data = trim(fgets(STDIN));
		
		if($received_data == "DUNKKIS 0.0.1") {
			/* Give response message. */
			print "OK";
		}
		
		if (substr($received_data, 0, 1) == "[" and substr($received_data, -1, 1) == "]") {
			/* Init an instance of class Sensor. */
			$sensor = set_sensor_data($received_data);
			/* Save sensor's data to database. */
			save_data_to_db($sensor);
			/* Create alarm records */
			alarm_process( $sensor );
			/* Give response message. */
			print "OK";
		}
		
		if ($received_data == "END") {
			/* Give response message. */
			print "BYE";
			break;
		}
	}
}

/**
 * Set data to an object of class Sensor.
 *
 */
function set_sensor_data($received_data){
	/* Create an instance of class Sensor. */
	$sensor = new Sensor();
	
	/* Get values from received data. */
	$devid = substr($received_data, 1,  17);
	$time = substr($received_data, -25,  24);
	$replace = array($devid, $time, "[", "]");
	$others = str_replace($replace, "", $received_data);
	$data = split(":", $others);
	$value = $data[1];
	$type = $data[2];
	$sensor_id = $data[3];
	$board_id = $data[4];
	
	/*Set values of the sensor object. */
	$sensor->set_devid($devid);
	$sensor->set_time($time);
	$sensor->set_value($value);
	$sensor->set_type($type);
	$sensor->set_sensor($sensor_id);
	$sensor->set_board($board_id);
	
	/* Return an object of class Sensor. */
	return $sensor;
}

/**
 * Save data to database.
 */
function save_data_to_db(Sensor $sensor) {
	global $db_config;
	$link = db_init();
	$query = "INSERT INTO ".$db_config['db_table']. "
				(mac, value, type, sensorid, deviceid, time, logtime)
			VALUES ('" . $sensor->get_devid() . "',
					'" . $sensor->get_value() . "', 
					'" .$sensor->get_type() . "',
					'" .$sensor->get_sensor() . "', 
					'" . $sensor->get_board() . "',
					'" . date(DATE_ISO8601) . "',
					'" . $sensor->get_time() . "')";
	$results = mysql_query ($query)
	or die ('Error in query: ' .mysql_error() . ":<br>\n" . $query);
	mysql_close ($link);
}

/* ***    MAIN     *** */
	start_ssh_mode();
?>
