<?php

/** Dunkkis Server
  * ==============
  * Sensor data methods
  * 
  * Copyright (c) 2009-2010 Nomovok Ltd
  * This software is licensed under The MIT License. See LICENSE for details.
  *
  * @author Nguyen Thanh Trung - nguyenthanh.trung@nomovok.com
  */

/**
 * Extracts logged data from return values into an array of DsLogMeasurement objects.
 * @param result: Return value from one of Log menthods.
 * @param criteria: DsLogCriteria Criteria for the query.
 * @return Array of DsLogMeasurement objects.
 */
function extractData( &$result, $criteria ) {
    global $config;

    $res = array();
    $last_taken = 0;
    $can_be_taken = 100;
    $taken = 0;
    foreach( $result->fetchAll() as $row ) {
        if( $can_be_taken == 0 || $criteria->limit <= $taken )
            break;
        if( $criteria->order == 0 && $row['unixtime'] < ($last_taken + $criteria->interval) && $last_taken > 0 )
            continue;
        if( $criteria->order == 1 && $row['unixtime'] > ($last_taken - $criteria->interval) && $last_taken > 0 )
            continue;

        $last_taken = $row['unixtime'];

        // TODO populate DsDevSensor completely and drop sensortype from DsLogMeasurement?
        $res[] = new DsLogMeasurement( new DsDevSensor( $row['sensorid'] ), $row['type'], $row['value'], $row['time'] );
        $can_be_taken -= 1;
        $taken += 1;
    }

    return $res;
}

/**
 * Extracts thumbnail data from return values into an array of DsDevSensorThumb objects.
 * @param result: Return value from getThumbnailsBySensor.
 * @param criteria: DsLogCriteria Criteria for the query.
 * @return Array of DsDevSensorThumb objects.
 */
function extractThumbnail( &$result, $criteria ) {

    $res = array();
    $last_taken = 0;
    $can_be_taken = 100;
    $taken = 0;
    foreach( $result->fetchAll() as $row ) {
	  if( $can_be_taken == 0 || $criteria->limit <= $taken )
	  	break;
	  if( $criteria->order == 0 && $row['unixtime'] < ($last_taken + $criteria->interval) && $last_taken > 0 )
	  	continue;
	  if( $criteria->order == 1 && $row['unixtime'] > ($last_taken - $criteria->interval) && $last_taken > 0 )
	  	continue;

	  $last_taken = $row['unixtime'];

	  $res[] = new DsDevSensorThumb( new DsDevSensor( $row['sensorid'] ), $row['thumbnail'], $row['logtime'] );
	  $can_be_taken -= 1;
	  $taken += 1;
    }

    return $res;
}

/**
 * get the logged data from the sensor
 *
 * @param sessionData: DsAuthSession authentication data for the session
 * @param sensor: DsDevSensor sensor identification
 * @param criteria: DsLogCriteria Criteria for the query.
 * @return the data logged by sensor that we want to get in the time restriction
 *
 */
function getLoggedDataBySensor( $sessionData, $sensor, $criteria ) {
    global $db;

    $sessionObj = new DsAuthSession( $sessionData->sessionId );

    if( ! $sessionObj->isValid() ) {
        return new SoapFault( "Client", DS_RET_AUTHENTICATION_FAILED );
    }

    if( ! $sessionObj->hasAccessToSensor( $sensor->sensorId ) ) {
        return new SoapFault( "Client", DS_RET_PERMISSION_DENIED );
    }

    $order = ( $criteria->order == 1 ? "DESC" : "ASC" );

    $query = $db->prepare( "SELECT DISTINCT d.`sensorid`, d.`type`, d.`value`, d.`time`,
                                   UNIX_TIMESTAMP( `time` ) as `unixtime`
                            FROM `data` as d
                            INNER JOIN `session` ON ( session.`sessionid` = ? )
                            INNER JOIN `device` ON ( session.`profileid` = device.`profileid` )
                            WHERE d.`sensorid` = ? AND
                                  d.`deviceid` = ? AND
                                  d.`time` >= ? AND
                                  d.`time` <= ?
                            ORDER BY d.`time` $order
                            LIMIT 3600" );

    if( $query && $query->execute( array( $sessionData->sessionId, $sensor->sensorId, $sensor->deviceId, $criteria->from, $criteria->to ) ) ) {
        $data = extractData( $query, $criteria );
        if( empty( $data ) ) {
            return new SoapFault( "Client", DS_RET_NO_LOG_AVAILABLE );
        }

        return $data;
    }

    return new SoapFault( "Client", DS_RET_GENERIC_ERROR );

}

/**
 * Returns logged data per device basis. Set interval to -1 to get only the latest result.
 * @param sessionData: DsAuthSession Authenticated session.
 * @param device: DsDevDevice Device to return data for.
 * @param criteria: DsLogCriteria Criteria for the query.
 * @return Returns the logged data.
*/
function getLoggedDataByDevice( $sessionData, $device, $criteria ) {
    global $db;

    $sessionObj = new DsAuthSession( $sessionData->sessionId );
    if( ! $sessionObj->isValid() ) {
        return new SoapFault( "Client", DS_RET_AUTHENTICATION_FAILED );
    }

    if( ! $sessionObj->hasAccessToDevice( $device->deviceId ) ) {
        return new SoapFault( "Client", DS_RET_PERMISSION_DENIED );
    }

    $order = ( $criteria->order == 1 ? "DESC" : "ASC" );

    $query = $db->prepare( "SELECT DISTINCT d.`sensorid`, d.`type`, d.`value`, d.`time`, UNIX_TIMESTAMP( d.`time` ) as `unixtime`
                            FROM `data` as d
                            INNER JOIN `session` ON ( session.`sessionid` = ? )
                            INNER JOIN `device` ON ( session.`profileid` = device.`profileid` )
                            WHERE d.`deviceid` = ? AND
                                  d.`time` >= ? AND
                                  d.`time` <= ?
                            ORDER BY d.`time` $order
                            LIMIT 3600" );
                           logmsg( print_r($query,true) );
    // can't use limit with pdo as it casts all ?'s to strings, bug in pdo's mysql plugin...

    if( $query && $query->execute( array( $sessionData->sessionId, $device->deviceId, $criteria->from, $criteria->to ) ) ) {
        $data = extractData( $query, $criteria );
        if( empty( $data ) ) {
            return new SoapFault( "Client", DS_RET_NO_LOG_AVAILABLE );
        }

        return $data;
    }

    // unable to prepare/execute query
    return new SoapFault( "Client", DS_RET_GENERIC_ERROR );
}

/**
 * get thumbnails from camera sensor
 *
 * @param sessionData: DsAuthSession authentication data for the session
 * @param sensor: DsDevSensor sensor identification
 * @param criteria: DsLogCriteria criteria for search results (from, to, interval, limit, order)
 * @return the thumbnails of images taken by camera sensor
 *
 */
function getThumbnailsBySensor( $sessionData, $sensor, $criteria ) {
    global $db;

    $sessionObj = new DsAuthSession( $sessionData->sessionId );

    if( ! $sessionObj->isValid() ) {
        return new SoapFault( "Client", DS_RET_AUTHENTICATION_FAILED );
    }

    if( ! $sessionObj->hasAccessToSensor( $sensor->sensorId ) ) {
        return new SoapFault( "Client", DS_RET_PERMISSION_DENIED );
    }

    $order = ( $criteria->order == 1 ? "DESC" : "ASC" );

    $query = $db->prepare( "SELECT DISTINCT pd.`sensorid`, pd.`thumbnail`, pd.`logtime`,
                                   UNIX_TIMESTAMP( `logtime` ) as `unixtime`
                            FROM `picture_data` as pd
                            INNER JOIN `session` ON ( session.`sessionid` = ? )
                            WHERE pd.`sensorid` = ? AND
                                  pd.`logtime` >= ? AND
                                  pd.`logtime` <= ?
                            ORDER BY pd.`logtime` $order
                            LIMIT 3600" );

    if( $query && $query->execute( array( $sessionData->sessionId, $sensor->sensorId, $criteria->from, $criteria->to ) ) ) {

        $data = extractThumbnail( $query, $criteria );

        if( empty( $data ) ) {
            return new SoapFault( "Client", DS_RET_NO_LOG_AVAILABLE );
        }

        return $data;
    }

    return new SoapFault( "Client", DS_RET_GENERIC_ERROR );

}

/**
 * get thumbnails from camera sensor
 *
 * @param sessionData: DsAuthSession authentication data for the session
 * @param sensorid ID of the sensor
 * @param timestamp Timestamp of the picture
 * @return the picture taken by camera sensor
 *
 */
function getPictureByTimestamp( $sessionData, $sensorid, $timestamp ) {
    global $db;

    $sessionObj = new DsAuthSession( $sessionData->sessionId );

    if( ! $sessionObj->isValid() ) {
        return new SoapFault( "Client", DS_RET_AUTHENTICATION_FAILED );
    }

    $query = $db->prepare( "SELECT DISTINCT sensorid, picture
                            FROM picture_data
                            WHERE logtime = ?
			    AND sensorid = ?
                            LIMIT 3600" );

    if( $query && $query->execute( array( $timestamp, $sensorid ) ) ) {
	$data = array();

        foreach( $query->fetchAll() as $row ) {
	    $data[] = new DsDevSensorPicture( new DsDevSensor( $row['sensorid'] ), $timestamp, $row['picture'] );
        }

        if( empty( $data ) ) {
            return new SoapFault( "Client", DS_RET_NO_LOG_AVAILABLE );
        }

        return $data;
    }

    return new SoapFault( "Client", DS_RET_GENERIC_ERROR );

}

?>
