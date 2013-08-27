<?php

/** Dunkkis Server
  * ==============
  * 
  * Copyright (c) 2009-2010 Nomovok Ltd
  * This software is licensed under The MIT License. See LICENSE for details.
  */


/**
 * Returns a list of alarms by given criteria
 * @param session: DsAuthSession Authenticated session.
 * @return DsAlarm
 */

function getAlarms( $session )
{
    global $db;

    $sessionObj = new DsAuthSession( $session->sessionId );
    if( ! $sessionObj->isValid() ) {
        return new SoapFault( "Client", DS_RET_AUTHENTICATION_FAILED );
    }

    $query = $db->prepare( "SELECT `alarms`.name AS alarmName, `alarms`.id AS alarmId
                            FROM `alarms`
                            JOIN `profile` 
                                ON ( `alarms`.uid = `profile`.userid )
                            JOIN `session` 
                                ON ( `profile`.id = `session`.profileid )
                            WHERE 
                                alarms.uid = profile.userid AND
                                profile.id = session.profileid AND 
                                session.sessionid = ?" );

    if( $query && $query->execute( array( $sessionObj->sessionId ) ) ) {
        
        $alarms = $query->fetchAll( PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'DsAlarm' ); 
        if( count( $alarms ) > 0 ) {            
            return $alarms;
        }

    }
        
    // on failure, TODO see whether we should separate whether executing of query fails or there's no table entries?
    return new SoapFault( "Client", DS_RET_AUTHENTICATION_FAILED );
}

/**
 * Returns a list of happened alarms by given criteria
 * @author Lars Kinnunen <lars.kinnunen@nomovok.com>
 * @param session: DsAuthSession Authenticated session.
 * @param alarm: int Alarm ID.
 * @param criteria: DsLogCriteria History query criteria.
 * @return DsAlarmHistory
 */
function getAlarmHistory( $session, $alarm, $criteria )
{
    global $db;

    if ($alarm < 1) return new SoapFault( "Client", DS_RET_DATA_CORRUPTED );

    $sessionObj = new DsAuthSession( $session->sessionId );
    if( ! $sessionObj->isValid() ) {
        return new SoapFault( "Client", DS_RET_AUTHENTICATION_FAILED );
    }

    $order = ( $criteria->order == 1 ? "DESC" : "ASC" );

    $query = $db->prepare( "SELECT
                                `alarm_history`.alarmid AS alarmId,
                                `alarm_history`.alarm_name AS alarmName,
                                `alarm_history`.sensorid AS sensorId,
                                `alarm_history`.sensor_name AS sensorName,
                                `alarm_history`.alarmscheduleid AS scheduleId,
                                `alarm_history`.schedule_name AS scheduleName,
                                `alarm_history`.value AS measurementValue,
                                `alarm_history`.logtime AS measurementStampdate
                            FROM
                                `alarm_history`
                            JOIN `profile` 
                                ON ( `alarm_history`.uid = `profile`.userid )
                            JOIN `session` 
                                ON ( `profile`.id = `session`.profileid )
                            WHERE 
                                `alarm_history`.uid = profile.userid AND
                                `profile`.id = session.profileid AND 
                                `alarm_history`.alarmid = ? AND
                                `session`.sessionid = ?
                            ORDER BY `alarm_history`.logtime $order
                            LIMIT 3600");

    if( $query && $query->execute( array( $alarm, $sessionObj->sessionId ) ) ) {
        
        $alarms = $query->fetchAll( PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'DsAlarmHistory' );
        if( count( $alarms ) > 0 ) {
            return $alarms;
        }

    }
    return new SoapFault( "Client", DS_RET_EMPTY_PROFILE ); // proper errorcode?
}

/**
 */
function getAlarmDetails( $session, $alarm )
{

    global $db;

    if( $alarm < 1 ) {
        return new SoapFault( "Client", DS_RET_DATA_CORRUPTED );
    }

    $sessionObj = new DsAuthSession( $session->sessionId );
    if( !$sessionObj->isValid() ) {
        return new SoapFault( "Client", DS_RET_AUTHENTICATION_FAILED );
    }

    $alarmName = "";
    $schedules = "";
    $contacts = "";
    $history = ""; // Not used.
    $sensors = ""; // Not used.

    // Get alarm name.
    $query = $db->prepare( "SELECT alarms.name 
                            FROM alarms
                                JOIN profile
                                    ON( alarms.uid = profile.userid )
                                JOIN session
                                    ON( profile.id = session.profileid )
                            WHERE session.sessionid = ? AND
                                  alarms.id = ?
                            LIMIT 1" );

    if( $query && $query->execute( array( $sessionObj->sessionId, $alarm ) ) ) {
        $result = $query->fetchAll( PDO::FETCH_ASSOC );
        if( $result ) {
            $alarmName = $result[0]['name'];
        }
    }

    // Get last event time for alarm, if any.
    $query = $db->prepare( "SELECT logtime
                            FROM alarm_history
                                JOIN profile
                                    ON( alarm_history.uid = profile.userid )
                                JOIN session
                                    ON( profile.id = session.profileid )
                            WHERE session.sessionid = ? AND
                                  alarm_history.alarmid = ?
                            ORDER BY logtime ASC
                            LIMIT 1" );

    if( $query && $query->execute( array( $sessionObj->sessionId, $alarm ) ) ) {
        $result = $query->fetchAll( PDO::FETCH_ASSOC );
        if( $result ) {
            $schedules = $result[0]['logtime'];
        }
    }

    // Get contacts.
    $query = $db->prepare( "SELECT alarm_contacts.name, 
                                   SUM( triggercount ) AS triggercount
                            FROM alarm_contacts
                                JOIN profile
                                    ON( alarm_contacts.uid = profile.userid )
                                JOIN session
                                    ON( profile.id = session.profileid )
                                JOIN alarm_actions
                                    ON( alarm_contacts.id = alarm_actions.alarmcontactsid )
                            WHERE session.sessionid = ? AND
                                  alarm_actions.alarmid = ?
                            GROUP BY alarm_contacts.name" );

    if( $query && $query->execute( array( $sessionObj->sessionId, $alarm ) ) ) {

        $result = $query->fetchAll( PDO::FETCH_ASSOC );
        if( $result ) {
            foreach( $result as $contact ) {
                $contacts .= $contact['name']."|".$contact['triggercount']."\n";
            }
        }

    }

    return new DsAlarmDetails( $alarm, 
                               $alarmName, 
                               $schedules, 
                               $contacts, 
                               $history, 
                               $sensors );

}

/**
 * Returns a list of sensors associated to alarm by given criteria
 * @author Lars Kinnunen <lars.kinnunen@nomovok.com>
 * @param session: DsAuthSession Authenticated session.
 * @param alarm: int Alarm ID.
 * @return DsAlarmSensor
 */
function getAlarmSensors( $session, $alarm )
{

    global $db;

    if ($alarm < 1) return new SoapFault( "Client", DS_RET_DATA_CORRUPTED );

    $sessionObj = new DsAuthSession( $session->sessionId );
    if( ! $sessionObj->isValid() ) {
        return new SoapFault( "Client", DS_RET_AUTHENTICATION_FAILED );
    }

    $query = $db->prepare( "SELECT alarm_sensors.alarmid AS alarmId,
                                   alarm_sensors.enabled AS state,
                                   alarm_sensors.auto_enable AS autoEnable,
                                   sensor.sensoridstr AS sensorId,
                                   sensor.name AS sensorName
                            FROM alarm_sensors
                                JOIN sensor
                                    ON ( alarm_sensors.sensorid = sensor.id )
                                JOIN alarms
                                    ON ( alarm_sensors.alarmid = alarms.id )
                                JOIN profile
                                    ON ( alarms.uid = profile.userid )
                                JOIN session
                                    ON ( profile.id = session.profileid )
                            WHERE alarm_sensors.alarmid = ? AND 
                                  session.sessionid = ?
                            LIMIT 3600");

    if( $query && $query->execute( array( $alarm, $sessionObj->sessionId ) ) ) {
        
        $sensors = $query->fetchAll( PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'DsAlarmSensor' );
        if( count( $sensors ) > 0 ) {
            return $sensors;
        }

    }

    return new SoapFault( "Client", DS_RET_DATA_CORRUPTED );

}
