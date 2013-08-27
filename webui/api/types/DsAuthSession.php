<?php

/** Dunkkis Server
  * ==============
  * 
  * Copyright (c) 2009-2010 Nomovok Ltd
  * This software is licensed under The MIT License. See LICENSE for details.
  *
  * @author Aki Honkasuo - aki.honkasuo@nomovok.com
  * @author Rami Erlin - rami.erlin@nomovok.com
  */

/**
 * DsAuthSession is a container which helds the sessionID hash to be used for all actions which need authentication. The object is used as a key for all profile related actions and provides the functionality to check whether user is permitted to access certain device.
 */
class DsAuthSession {
    var $sessionId = null;
    var $protocolVersion = DS_SOAP_API_VERSION;

    /**
     * Constructor.
     * @param sessionId Session identifier.
     */
    public function __construct( $sessionId ) {
        $this->sessionId = $sessionId;
    }

    /**
     * Closes session for the given DsAuthSession
     * @return Returns true on success, false otherwise.
     */
    public function closeSession() {
        global $db;

        if( ! $this->sessionId )
            return false;

        $query = $db->prepare( "DELETE FROM session
                                WHERE sessionid = ?
                                LIMIT 1" );
        if( $query->execute( array( $this->sessionId ) ) ) {
            return true;
        }

        return false;
    }

    /**
    * Returns false if session is not active/valid.
    * this function should be called always in hasAccess* functions before doing anything else?
    * TODO specify the time limit in config?
    * @return Returns true if session is active and valid, false otherwise.
    */
    public function isValid() {
        global $db;

        if( ! $this->sessionId )
            return false;

        $query = $db->prepare( "SELECT DISTINCT sessionid
                                FROM session
                                WHERE sessionid = ?" );

        if( $query && $query->execute( array( $this->sessionId ) ) ) {
            $result = $query->fetchAll();            
            if( count( $result ) > 0 ){
                return true;
            }
        }

        return false;
    }

    /**
     * This function checks whether user is allowed to access a specific device. Should be used internally before allowing user to get any data from devices.
     * @param deviceId Device ID string.
     * @param isDevId: bool Specifies if deviceId is an id or string.
     * @return Returns true if allowed, false if not.
     */
    public function hasAccessToDevice( $deviceId, $isDevId = false ) {
        global $db;

        if( ! $this->sessionId )
            return false;

        $query = $db->prepare( "SELECT d.id
                                FROM device AS d
                                JOIN session
                                ON ( d.profileid = session.profileid )
                                WHERE session.sessionid = ?".
                                ($isDevId ? " AND d.id = ?" : " AND d.devidstr = ?")); // FIXME hacky devidstr..
        if( $query && $query->execute( array( $this->sessionId, $deviceId ) ) ) {
            $result = $query->fetchAll();            
            if( count( $result ) > 0 ) {
                return true;
            }
        }


        return false;
    }

    /**
     * This function checks whether the user is allowed to access the specific sensor. It should be used internally before allowing user to get data from calls related to sensors.
     * @param sensorId ID of the sensor
     * @return Returns true if allowed, false if not
     */
    public function hasAccessToSensor( $sensorId ) {
        global $db;

        if( ! $this->sessionId )
            return false;

        $query = $db->prepare( "SELECT devid
                                FROM sensor
                                WHERE sensoridstr = ?" );
        if( $query && $query->execute( array( $sensorId ) ) ) {
                
            $rows = $query->fetchAll();
            if( count( $rows ) > 0 ) {

                foreach( $rows as $row ) {    
                    if( $this->hasAccessToDevice( $row['devid'], true ) ) {
                        return true;
                    }
                } 

            }
        }

        return false;
    }
}
?>
