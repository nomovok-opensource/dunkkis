<?php

/** Dunkkis Web User Interface
  * ==========================
  * Latest measurements view database access functions
  * 
  * Copyright (c) 2009-2010 Nomovok Ltd
  * This software is licensed under The MIT License. See LICENSE for details.
  *
  * @author Juha Hytonen - juha.hytonen@nomovok.com
  */

include_once( "ds-db.php" );

/** Returns user's devices.
  * @param uid, (integer) ID of the user.
  * @return An associated array( id, name ) of devices or 0 if none found.
  *
  * This functions strips the IDs and names (if given) of all the devices
  * connected to user's MAC devices and also cameras added to user's 
  * profiles.
  */
function dbGetUsersDevices( $uid )
{

    $link = db_init();
    $query = "SELECT DISTINCT id, name
              FROM ( ( 
                  SELECT DISTINCT data.deviceid AS id, (
                      SELECT DISTINCT device.name 
                      FROM device
                      JOIN profile ON ( device.profileid = profile.id )
                      WHERE device.devidstr = data.deviceid AND
                            profile.userid = ".$uid." 
                      LIMIT 1 ) AS name
                  FROM data 
                  WHERE mac IN (
                      SELECT mac 
                      FROM dunkkisbox
                      WHERE uid = ".$uid." ) )
              UNION (
                  SELECT DISTINCT device.devidstr AS id, device.name AS name
                  FROM device
                  JOIN profile ON ( device.profileid = profile.id )
                  WHERE profile.userid = ".$uid." ) )
              AS devices;";
    $result = mysql_query( $query, $link );

    $devices = 0;
    if( mysql_num_rows( $result ) > 0 ) {

        $devices = array();
        while( $device = mysql_fetch_assoc( $result ) ) {
            array_push( $devices, $device );
        }

    }

    mysql_close( $link );
    return $devices;

}

/** Returns sensors connected to a device.
  * @param device, (string) Address of the device.
  * @param uid, (string) User id of the device owner.
  * @return An associated array( id, name, sensoridstr, type, devid, devname ) 
  *         of sensors or 0 if none found.
  *
  * This function bounds the device to a profile and an user to fetch 
  * correct names for the sensors. If same device is attached to multiple
  * profiles with different names, first device in database is selected.
  */
function dbGetSensorsByDevice( $deviceId, $deviceName, $uid ) 
{

    // If user has not specified a device name.
    $deviceName = empty( $deviceName ) ? $deviceId : $deviceName;

    $link = db_init();
    $query = "SELECT sensor.id, sensor.name, sensor.sensoridstr, sensor.type,
                     device.devidstr AS devid, device.name AS devname
              FROM sensor, device
              WHERE device.id = sensor.devid AND
                    device.id = (
                  SELECT device.id
                  FROM device
                  JOIN profile ON ( device.profileid = profile.id )
                  WHERE device.devidstr = '".$deviceId."' AND
                        device.name = '".$deviceName."' AND
                        profile.userid = ".$uid."
                  LIMIT 1 );";
    $result = mysql_query( $query, $link );

    $sensors = 0;
    if( mysql_num_rows( $result ) > 0 ) {

        $sensors = array();
        while( $sensor = mysql_fetch_assoc( $result ) ) {
            array_push( $sensors, $sensor );
        }

    }

    mysql_close( $link );
    return $sensors;

}

/** Returns sensor's data from a given period.
  * @param sensor, (string) Address of the sensor.
  * @param periodBegin, (string) Beginning of the period.
  * @param periodEnd, (string) End of the period.
  * @return An associated array( time, value ) in which time and value are
  *         arrays with the measurement data (corresponding time-value pairs
  *         in corresponding indices) or zero if no data found.
  * @note periodBegin and periodEnd must be formatted like "yyyy-mm-dd hh:mm:ss".
  */
function dbGetSensorData( $sensor, $periodBegin, $periodEnd ) 
{

    $link = db_init();
    $query = "SELECT value, logtime
              FROM data 
              WHERE sensorid = '".$sensor."' AND
                    logtime >= '".$periodBegin."' AND
                    logtime <= '".$periodEnd."' AND
                    MOD( TIMESTAMP ( logtime ), ".DS_LATEST_DATA_GRANULARITY_DIV." )
                        < ".DS_LATEST_DATA_GRANULARITY_MOD."
              ORDER BY logtime ASC;";
    $result = mysql_query( $query, $link );

    $data = 0;
    if( mysql_num_rows( $result ) > 0 ) {

        $data = array();
        $i = 0;
        while( $row = mysql_fetch_assoc( $result ) ) {
            $data['time'][$i] = $row['logtime'];
            $data['value'][$i] = $row['value'];
            $i++;
        }

    }

    mysql_close( $link );
    return $data;

}


?>
