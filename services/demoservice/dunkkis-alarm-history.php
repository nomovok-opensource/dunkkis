<?php

/** Dunkkis Server
  * ==============
  * Alarm history functionality
  * 
  * Copyright (c) 2009-2010 Nomovok Ltd
  * This software is licensed under The MIT License. See LICENSE for details.
  *
  * @author Juha Hytonen - juha.hytonen@nomovok.com
  */

require_once( "dunkkis-alarm-common.php" );

/** Puts an alarm into alarm_history.
  * @param sensor Sensor that triggered the alarm.
  * @param alarmId Id of the alarm the sensor triggered.
  * @param sensorId Id of the sensor that triggered the alarm. This is the
  *                 numerical id, not "sensoridstr".
  *
  * This function gets the schedules associated with the alarm (called
  * triggers). It then compares the sensor data to the schedules, to see if
  * any of them match and trigger an alarm. Only the first matching schedule 
  * triggers the alarm, after which the alarm is disabled.
  */
function put_to_alarm_history( Sensor $sensor, $alarmId, $sensorId )
{

    // Get triggers for alarm. If there aren't any, no need to continue.
    $triggers = db_get_alarm_triggers( $alarmId );
    if( $triggers == 0 ) {
        return;
    }

    // Process each trigger.
    foreach( $triggers as $trigger ) {

        if( DS_ALARM_DEBUG ) {
            echo( "Processing schedule ".$trigger['scheduleid'].".\n" );
        }

        // Get schedule for trigger.
        $schedule = db_get_schedule( $trigger['scheduleid'] );

        // Check if schedule matches the sensor.
        if( is_schedule_match( $sensor, $schedule ) ) {

            if( DS_ALARM_DEBUG ) {
                echo( "Sensor matches schedule.\n" );
            }

            // Create history entry and add to alarm_history. Disable sensor.
            $history = create_history_entry( $schedule['uid'], 
                                             $alarmId,
                                             $sensorId, 
                                             $schedule['id'], 
                                             $schedule['name'], 
                                             $sensor );
            db_add_alarm_history( $history );

            // Disable sensor, if autoenable is disabled.
            $autoEnable = db_get_field( "auto_enable", "alarm_sensors", "sensorid", $sensorId );
            if( $autoEnable != DS_ALARM_PROC_AUTO_ENABLE ) {
	            db_disable_alarm_sensor( $alarmId, $sensorId );
            }

            return;

        }
        else {

            if( DS_ALARM_DEBUG ) {
                echo( "Sensor does not match schedule. Data discarded.\n" );
            }
            
        }

    }

}

?>
