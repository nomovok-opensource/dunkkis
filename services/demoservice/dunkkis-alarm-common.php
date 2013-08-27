<?php

/** Dunkkis Server
  * ==============
  * Alarm history and cronscript common functionality
  * 
  * Copyright (c) 2009-2010 Nomovok Ltd
  * This software is licensed under The MIT License. See LICENSE for details.
  *
  * @author Juha Hytonen - juha.hytonen@nomovok.com
  * Some code courtesy of Lars Kinnunen - lars.kinnunen@nomovok.com
  */

/** Check if a sensor's value and logtime match with the given schedule.
  * @param $sensor Sensor to match.
  * @param $schedule Schedule to match (from get_schedule()).
  */
function is_schedule_match( Sensor $sensor, $schedule )
{

    $sensorvalue = $sensor->get_value();
    $sensortime = $sensor->get_time();

    // Check, if sensor value has to be between given values.
    // If it should, and it is not, leave.
    if( $schedule['value_within'] == 1 && 
        !($sensorvalue >= $schedule['value_min'] && 
          $sensorvalue <= $schedule['value_max'])) {
        return false;
    }

    // Check, if sensor value has to be outside given value. 
    // If it should, and it is not, leave.
    if( $schedule['value_within'] == 0 && 
        !($sensorvalue < $schedule['value_min'] || 
          $sensorvalue > $schedule['value_max']) ) {
        return false;
    }

    // If the schedule is not valid always, go through the additional params.
    if( $schedule['always'] == 0 ) {

        // If the schedule is not valid all year, check that sensor date
        // is between given dates. If not, leave.
        if( $schedule['period'] == 0 &&
            !($sensortime >= date( "U", $schedule['startdate'] ) && 
              $sensortime <= date( "U", $schedule['enddate'] )) ) {
            return false;
        }

        // If the schedule is not valid all months, check that the sensor month
        // matches. If not, leave.
        $month = strtolower( date( "M", $sensortime ) ); // Three letter, lowercase.
        if( $schedule['months'] == 0 && $schedule[$month] != 1 ) {
            return false;
        }

        // If the schedule is not valid for all days, check that the sensor day
        // matches. If not, leave.
        $day = strtolower( date( "D", $sensortime ) ); // Three letter, lowercase.
        $day_number = date( "j", $sensortime ); //Day number without leading zeros.
        if( $schedule['days'] == 0 && 
            !($schedule[$day] == 1 && 
              $day_number >= $schedule['first_day']  && 
              $day_number <= $schedule['last_day'])) {
            return false;
        }

        // If the schedule is not valid all day, check that the sensor time
        // is between given times. If not, leave. Please not that MySQL's
        // TIME datatype needs to be converted to a UNIX timestamp with
        // strtotime().
        if( $schedule['all_day'] == 0 && 
            !( $sensortime >= date( "U", strtotime( $schedule['starttime'] ) ) && 
               $sensortime <= date( "U", strtotime( $schedule['endtime'] ) )) ) {
            return false;
        }

    }

    // If we got so far, the schedule matches.
    return true;

}

/** Creates a history entry of the given data.
  * @param uid User ID.
  * @param alarmId Alarm ID.
  * @param sensorId Sensor ID (NOT idstr).
  * @param scheduleID Schedule ID.
  * @param scheduleName Schedule name.
  * @param sensor Sensor.
  * @note Sensor's time needs to be converted to ISO 8601 format for MySQL.
  */
function create_history_entry( $uid, $alarmId, $sensorId, $scheduleId, $scheduleName, $sensor)
{

    $history = array();
    $history['uid'] = $uid;
    $history['alarmid'] = $alarmId;
    $history['alarm_name'] = db_get_field( "name", "alarms", "id", $alarmId );
    $history['sensorid'] = $sensorId;
    $history['sensor_name'] = db_get_field( "name", "sensor", "id", $sensorId );
    $history['alarmscheduleid'] = $scheduleId;
    $history['schedule_name'] = $scheduleName;
    $history['value'] = $sensor->get_value();
    $history['logtime'] = date( "c", $sensor->get_time() );
    return $history;

}

?>
