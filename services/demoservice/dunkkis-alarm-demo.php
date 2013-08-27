#!/usr/bin/php -q

<?php

/** Dunkkis Server
  * ==============
  * Alarm functionality test script
  * 
  * Copyright (c) 2009-2010 Nomovok Ltd
  * This software is licensed under The MIT License. See LICENSE for details.
  *
  * @author Juha Hytonen - juha.hytonen@nomovok.com
  */

/* Fill in the sensor data below to trigger the alarm functionality
 * without a live sensor.
 */

include_once( "dunkkis-alarm.php" );

$sensor = new Sensor();
$sensor->set_devid( "00:22:15:32:78:86" );
$sensor->set_time( date( "U" ) );
$sensor->set_value( 20 );
$sensor->set_type( "Temperature" );
$sensor->set_sensor( "26.04559C000000" );
$sensor->set_board( "04559C00" );

alarm_process($sensor);

?>
