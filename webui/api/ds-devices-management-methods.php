<?php

/** Dunkkis Server
  * ==============
  * Devices management methods
  * 
  * Copyright (c) 2009-2010 Nomovok Ltd
  * This software is licensed under The MIT License. See LICENSE for details.
  *
  * @author Phi Van Ngoc - phivan.ngoc@nomovok.com
  */

/**
 * Returns available devices for the given profile based on DsAuthSession data
 * @param sessionData DsAuthSession object
 * @return Returns an array( errorcode, return ). If errorcode is DS_RET_OK, return will contain a list of DsDevDevices. Otherwise a proper errorcode is being set and return is set to NULL.
*/
function getDevicesByProfile( $sessionData )
{
    global $db;

    $sessionObj = new DsAuthSession( $sessionData->sessionId );
    if( ! $sessionObj->isValid() ) {
        return new SoapFault( "Client", DS_RET_AUTHENTICATION_FAILED );
    }

    $query = $db->prepare( "SELECT DISTINCT `device`.devidstr AS deviceId, `device`.type AS deviceType, 0 AS deviceState, 0 AS deviceInterval, `device`.name AS deviceName, IF(`box`.name = NULL, `box`.mac, `box`.name) AS boxName
                            FROM `device`, `session`, `dunkkisbox` AS box
                            WHERE device.profileid = session.profileid AND device.dboxid = box.id
                            AND session.sessionid = ?" );

    if( $query && $query->execute( array( $sessionObj->sessionId ) ) ) {
        
        $devices = $query->fetchAll( PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'DsDevDevice' );
        if( count( $devices ) > 0 ) {
            return $devices;
        }
        else {
            return new SoapFault( "Client", DS_RET_EMPTY_PROFILE );
        }

    }

    return new SoapFault( "Client", DS_RET_GENERIC_ERROR );
}

/**
 * Returns sensors for the given deviceId
 * @param sessionData DsAuthSession object
 * @param device DsDevDevice object
 * @return Returns an array( errorcode, return ). If errorcode is DS_RET_OK, return will contain a list of sensors (DsDevSensor). Otherwise a proper errorcode is being set and return is set to NULL.
*/
function getSensorsByDevice( $sessionData, $device )
{
    global $db;

    $deviceId = $device->deviceId;
    $sessionObj = new DsAuthSession( $sessionData->sessionId );
    if( !$sessionObj->isValid() ) {
        return new SoapFault( "Client", DS_RET_AUTHENTICATION_FAILED );
    }

    if( ! $sessionObj->hasAccessToDevice( $deviceId ) ) {
        return new SoapFault( "Client", DS_RET_PERMISSION_DENIED );
    }
    $query = $db->prepare( "SELECT DISTINCT `sensor`.sensoridstr AS sensorId, `sensor`.name AS sensorName, `sensor`.type AS sensorType, 0 AS sensorState, `device`.devidstr AS deviceId, `device`.type AS deviceType
                            FROM `sensor`, `device`, session
                            WHERE sensor.devid = device.id
                            AND device.devidstr = ?
                            AND device.profileid = session.profileid
                            AND session.sessionid = '".$sessionData->sessionId."'");

    if( $query && $query->execute( array( $deviceId ) ) ) {

        $sensors = $query->fetchAll( PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'DsDevSensor' );
        if( count( $sensors ) > 0 ) {
            return $sensors;
        }

    }

    return new SoapFault( "Client", DS_RET_UNKNOWN_DEVICE );
}

?>
