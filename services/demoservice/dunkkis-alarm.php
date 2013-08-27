<?php

/** Dunkkis Server
  * ==============
  * Alarm processing wrapper
  * 
  * Copyright (c) 2009-2010 Nomovok Ltd
  * This software is licensed under The MIT License. See LICENSE for details.
  *
  * @author Juha Hytonen - juha.hytonen@nomovok.com
  */

/// Print debug messages?
define( "DS_ALARM_DEBUG", true );

/// Alarm queue table in database?
$db_config['db_table_alarm'] = 'alarm_queue';

require_once( "../sensor.inc" );
require_once( "dunkkis-alarm-history.php" );
require_once( "dunkkis-alarm-queue.php" );
require_once( "dunkkis-alarm-db.php" );

/** Processes a sensor alarm.
  * @param sensor Sensor data.
  *
  * This function checks whether the sensor is associated with any alarms. It
  * then process every alarm and puts the data into alarm history, if no alert
  * is associated with the alarm or into alarm queue, if there is an associated
  * alert.
  */
function alarm_process( Sensor $sensor )
{

    $sensor->set_time( strtotime( $sensor->get_time() ) );

    if( DS_ALARM_DEBUG ) {
        echo( "Processing alarm from sensor ".$sensor->get_sensor().".\n" );
    }

    // Get alarms the sensor is associated with, if any.
    $alarms = db_get_enabled_alarms( $sensor->get_sensor() );
    if( $alarms == 0 ) {

        if( DS_ALARM_DEBUG ) {
            echo( "No alarms associated with sensor or invalid sensor.\n" );
        }

        return;

    }

    foreach( $alarms as $alarm ) {

        if( DS_ALARM_DEBUG ) {
            echo( "Processing alarm ".$alarm['alarmid'].".\n" );
        }

        // Check if there is an alert associated with the alarm. If not
        // put to alarm history, otherwise put to alarm queue.
        $alert = db_get_field( "alert", "alarms", "id", $alarm['alarmid'] );
        if( $alert == DS_ALARM_PROC_NO_ALERT ) {

            put_to_alarm_history( $sensor, $alarm['alarmid'], $alarm['sensorid'] ); 

            if( DS_ALARM_DEBUG ) {
                echo( "Sensor ".$alarm['sensorid']." put to alarm history.\n" );
            }

        }
        else {

            put_to_alarm_queue( $sensor );

            if( DS_ALARM_DEBUG ) {
                echo( "Sensor ".$alarm['sensorid']." put to alarm queue.\n" );
            }

        }

    }

}


?>
