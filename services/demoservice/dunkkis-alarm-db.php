<?php

/** Dunkkis Server
  * ==============
  * Alarm database access functionality
  * 
  * Copyright (c) 2009-2010 Nomovok Ltd
  * This software is licensed under The MIT License. See LICENSE for details.
  *
  * @author Juha Hytonen - juha.hytonen@nomovok.com
  */

require_once( "dunkkis-server-db.php" );

/// Value that indicates a sensor is enabled to an alarm.
define( "DS_ALARM_PROC_SENSOR_ENABLED", 1 );
/// Value that indicates that no alert has been associated with alarm.
define( "DS_ALARM_PROC_NO_ALERT", "none" );
/// Value that indicates that autoenable is enabled.
define( "DS_ALARM_PROC_AUTO_ENABLE", 1 );

/** Returns the contacts of an alarm.
  * @alarmId The id of the alarm.
  * @return An array of contacts with the following fields: name, email, phone,
  *         type (either sms, email or composite).
  * @note Currently "composite" is not used when contact is selected both
  *       as an email and sms contact, but two contacts are inserted.
  */
function db_get_alarm_contacts( $alarmId )
{

    $link = db_init();
    $query = "SELECT alarm_contacts.name, alarm_contacts.email, 
                     alarm_contacts.phone, alarm_actions.type
              FROM alarm_contacts, alarm_actions, alarms
              WHERE alarms.id=".$alarmId." &&
                    alarms.id = alarm_actions.alarmid &&
                    alarm_actions.alarmcontactsid = alarm_contacts.id;";
    $result = mysql_query( $query ) or die(DB_QUERY_ERROR.mysql_error().'<br>'.$query);

    $contacts = array();
    if ( mysql_num_rows($result) > 0 ) {
        while( $row = mysql_fetch_array( $result, MYSQL_ASSOC ) ) {
            array_push( $contacts, $row );
        }
    }
    else {
        mysql_close( $link );
        return 0;
    }

    mysql_close( $link );
    return $contacts;

}

/** Returns the alarm queue as an array of Sensors.
  * @return Sensor array or 0 if the alarm_queue was empty.
  */
function db_get_alarm_queue() 
{

    $link = db_init();
    $query = "SELECT deviceid, value, type, sensorid, deviceid,
                     UNIX_TIMESTAMP( logtime ) as time
              FROM alarm_queue
              ORDER BY 'time' ASC
              LIMIT 3600;";
    $result = mysql_query( $query ); // or die(DB_QUERY_ERROR.mysql_error().'<br>'.$query);

    // Put the data in Sensor objects.
    $sensors = array();
    if( mysql_num_rows( $result ) > 0 ) {

        while( $row = mysql_fetch_array( $result ) ) {

            $sensor = new Sensor();
            $sensor->set_devid( $row['deviceid'] );
            $sensor->set_value( $row['value'] );
            $sensor->set_type( $row['type'] );
            $sensor->set_sensor( $row['sensorid'] );
            $sensor->set_board( $row['deviceid'] );
            $sensor->set_time( $row['time'] );
            array_push( $sensors, $sensor );

        }

        mysql_close($link);
        return $sensors;

    } 
    else {
        mysql_close($link);
        return 0;
    }
}


/** Returns a schedule for a given scheduleid.
  * @param scheduleId Id of the schedule. Assumed unique.
  * @return An associative array with following fields: 
            id, uid, name, value_min, value_max, value_within_ always,
            period, startdate, enddate, months, jan, feb, mar, apr, may, jun,
            jul, aug, sep, oct, nov, dec, days, sun, mon, tue, wed, thu, fri,
            sat, first_day, last_day, all_day, starttime, endtime
  * @note startdate and enddate are in UNIX timestamp format.
  * @note starttime and endtime are in "HH:MM:SS" format strings.
  */
function db_get_schedule( $scheduleId )
{

    // Get the schedule for the specified scheduleid.
    $link = db_init();
    $query = "SELECT id, uid, name, value_min, value_max, value_within, always, 
                     period, 
                     UNIX_TIMESTAMP( startdate ) as startdate,
                     UNIX_TIMESTAMP( enddate ) as enddate, 
                     months, jan, feb, mar, apr, may, jun, jul, aug, sep, oct, 
                     nov, \"dec\", days, sun, mon, tue, wed, thu, fri, sat, 
                     first_day, last_day, all_day, starttime, endtime
              FROM alarm_schedules
              WHERE alarm_schedules.id = ".$scheduleId.";";
    $result = mysql_query( $query ); // or die(DB_QUERY_ERROR.mysql_error().'<br>'.$query);

    // Assume scheduleid is unique, so get only the first row.
    $schedule = mysql_fetch_assoc( $result );
    mysql_close( $link );
    return $schedule;

}

/** Returns triggers for a given alarm.
  * An entry in the alarm_triggers table binds an alarm to a schedule.
  * @param alarmId Id of the alarm.
  * @return An associative array with following fields: alarmid, scheduleid.
  *         Zero if no triggers were found.
  */
function db_get_alarm_triggers( $alarmId )
{

    // Check if there are any triggers for the alarm.
    $link = db_init();
    $query = "SELECT alarm_triggers.alarmid as alarmid, 
                     alarm_triggers.alarmscheduleid as scheduleid
              FROM alarm_triggers
              WHERE alarm_triggers.alarmid = ".$alarmId.";";
    $result = mysql_query( $query ); // or die(DB_QUERY_ERROR.mysql_error().'<br>'.$query);

    // If there were any triggers, put them into an array and return it.
    $triggers = array();
    if ( mysql_num_rows($result) > 0 ) {
        while( $row = mysql_fetch_array( $result, MYSQL_ASSOC ) ) {

            array_push( $triggers, $row );

            if( DS_ALARM_DEBUG ) {
                echo( "Schedule ".$row['scheduleid']." associated with alarm.\n" );
            }

        }
    }
    else {

        if( DS_ALARM_DEBUG ) {
            echo( "No schedules associated with alarm." );
        }

        mysql_close( $link );
        return 0;

    }

    mysql_close( $link );
    return $triggers;

}

/** Returns enabled alarms for a sensor.
  * An entry in the alarm_sensors table binds a sensor to an alarm.
  * @param sensorIdStr Sensoridstr of the sensor that we're fetching alarms for.
  * @return An associative array with the following fields: alarmid, sensorid.
  *         Zero if no enabled alarms were found.
  * @note sensorid here is the numerical id that bounds a sensor to a profile
  *       through devid.
  */
function db_get_enabled_alarms( $sensorIdStr )
{

    // Check if the sensor is enabled to any alarms.
    $link = db_init();
    $query = "SELECT alarm_sensors.alarmid as alarmid, 
                     alarm_sensors.sensorid as sensorid
              FROM alarm_sensors, sensor
              WHERE sensor.sensoridstr = '".$sensorIdStr."' AND
                    sensor.id = alarm_sensors.sensorid AND
                    alarm_sensors.enabled =".DS_ALARM_PROC_SENSOR_ENABLED.";";
    $result = mysql_query( $query ); // or die(DB_QUERY_ERROR.mysql_error().'<br>'.$query);

    // If there were any enabled alarms, put them into an array and return it.
    $enabledAlarms = array();
    if( mysql_num_rows( $result ) > 0 ) {
        while( $row = mysql_fetch_array( $result, MYSQL_ASSOC ) ) {

            array_push( $enabledAlarms, $row );

            if( DS_ALARM_DEBUG ) {
                echo( "Alarm ".$row['alarmid']." associated with sensor ".$row['sensorid'].".\n" );
            }

        }
    }
    else {

        if( DS_ALARM_DEBUG ) {
            echo( "No alarms associated with sensor.\n" );
        }

        mysql_close( $link );
        return 0;

    }

    mysql_close( $link );
    return $enabledAlarms;

}

/** Returns a single field of a MySQL table.
  * @param field Name of the field.
  * @param table Name of the table.
  * @param key Name of a key field in the table.
  * @param keyValue Value that the key field has to match.
  * @note The value of the key fields are assumed unique.
  * @return The value requested.
  */
function db_get_field( $field, $table, $key, $keyValue )
{

    $link = db_init();
    $query = "SELECT ".$field. 
             " FROM ".$table.
             " WHERE ".$table.".".$key."='".$keyValue."';";
    $result = mysql_query( $query ) or die(DB_QUERY_ERROR.mysql_error().'<br>'.$query);

    $row = mysql_fetch_row( $result );
    $res = $row[0];
    mysql_close( $link );
    return $res;

}

/**
 *  Adds an alarm history entry.
 *  @author Lars Kinnunen - lars.kinnunen@nomovok.com
 *  @param history Data for the entry: uid, alarmid, alarm_name, sensorid, sensor_name, alarmscheduleid, schedule_name, value, logtime.
 *  @return Returns 0.
 **/  
function db_add_alarm_history( $history ) {
	$link=db_init();
	$query=sprintf("INSERT INTO alarm_history (`uid`, `alarmid`, `alarm_name`, `sensorid`, `sensor_name`, `alarmscheduleid`, `schedule_name`, `value`, `logtime`) VALUES (%s,%s,'%s',%s,'%s',%s,'%s','%s','%s');", 
			mysql_real_escape_string($history["uid"]) + 0,
			mysql_real_escape_string($history["alarmid"]) + 0,
			mysql_real_escape_string($history["alarm_name"]),
			mysql_real_escape_string($history["sensorid"]) + 0,
			mysql_real_escape_string($history["sensor_name"]),
			mysql_real_escape_string($history["alarmscheduleid"]) + 0,
			mysql_real_escape_string($history["schedule_name"]),
			mysql_real_escape_string($history["value"]) + 0,
			mysql_real_escape_string($history["logtime"]));
	/// Lets not make errors if dublicates. 
	mysql_query($query) or die(DB_QUERY_ERROR.mysql_error().'<br>'.$query);
	mysql_close($link);

    if( DS_ALARM_DEBUG ) {
        echo( "Put to alarm history.\n" );
    }

	return 0;
}

/**
 *  Sets an alarm to disabled state.
 *  @author Lars Kinnunen - lars.kinnunen@nomovok.com
 *  @param alarmid: Alarm.
 *  @param sensorid: Sensor.
 *  @return Returns 0.
 **/  
function db_disable_alarm_sensor( $alarmId, $sensorId ) 
{
    $link=db_init();
    $query=sprintf("UPDATE `alarm_sensors` SET `enabled`='%s' WHERE `alarmid`='%s' AND `sensorid`='%s';", 0 ,
		    mysql_real_escape_string($alarmId),
		    mysql_real_escape_string($sensorId));
    $res = mysql_query($query);
	    mysql_close($link);
    
    if( DS_ALARM_DEBUG ) {
        echo( "Disabled sensor ".$sensorId." from alarm ".$alarmId.".\n" );
    }

}

function db_empty_alarm_queue() 
{

    $link = db_init();
    $query = "DELETE FROM alarm_queue;";
    $result = mysql_query( $query ) or die(DB_QUERY_ERROR.mysql_error().'<br>'.$query);
    mysql_close( $link );

}

?>
