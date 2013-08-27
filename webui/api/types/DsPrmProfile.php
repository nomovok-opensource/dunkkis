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
 * DsPrmProfile is a class which handles the authentication of the profile
 * and creation of the session to the session table. For checking whether user has access to some resource see DsAuthSession.
 */
class DsPrmProfile {
    var $userName = null;
    var $profileName = null;
    var $profilePassword = null;

    var $profileId = null;
    var $sessionId = null;

    public function __construct( $userName, $profileName, $profilePassword = NULL ) {
        $this->userName = $userName;
        $this->profileName = $profileName;
        $this->profilePassword = $profilePassword;
    }

    /**
     * This function gets called by ds-session to authenticate the user with credidentials given in constructor.
     * @return Returns true on success, false otherwise
     */
    public function authenticate() {
        global $config;
        global $db;

        $password = sha1( $config['password_salt'] . $this->profilePassword );

        $query = $db->prepare( "SELECT `profile`.id as id
                                FROM `profile`, `user`
                                WHERE `user`.name = ? AND
                                      `profile`.name = ? AND
                                      `profile`.password = ? AND
                                      `profile`.userid = `user`.uid" );

        if( $query->execute( array( $this->userName, $this->profileName, $password ) ) ) {

            $result = $query->fetchAll();
            if( count( $result ) == 1 ) {
                $this->profileId = $result[0][0];
                if( $this->profileId ) {
                    $this->sessionId = sha1( uniqid( rand(), true ) );
                    return $this->initializeSession();
                }
            }
        }
        
        return false;

    }

    /**
     * Returns sessionId for the session, which is used in communications after initSession().
     * @return unique sessionId for the session
     */
    public function sessionId() {
        return $this->sessionId;
    }

    /**
     * Initializes the session to session table
     * @return Returns true if session was added to correctly, false otherwise
     */
    private function initializeSession() {
        global $db;

        $query = $db->prepare( "INSERT INTO `session` ( profileid, sessionid, logindate ) VALUES( ?, ?, NOW() )" );
        if( $query->execute( array( $this->profileId, $this->sessionId ) ) ) {
            return true;
        }
        
        return false;
    }
}
?>
