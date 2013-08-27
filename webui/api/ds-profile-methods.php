<?php

/** Dunkkis Server
  * ==============
  * 
  * Copyright (c) 2009-2010 Nomovok Ltd
  * This software is licensed under The MIT License. See LICENSE for details.
  */

/**
 * Returns a list of profiles for given username+password pair
 * @param userName name
 * @param password password
 * @return ProfileArray a list of DsPrmProfiles
*/
function getProfiles( $userName, $password )
{
    global $config;
    global $db;

    $query = $db->prepare( "SELECT `user`.name AS userName, `profile`.name AS profileName
                            FROM `profile`
                            INNER JOIN `user`
                            ON ( `profile`.userid = `user`.uid )
                            WHERE `user`.name = ? AND
                            `user`.password = SHA1( ? )" );

    if( $query && $query->execute( array( $userName, $config['password_salt'] . $password ) ) ) {
        
        $profiles = $query->fetchAll( PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'DsPrmProfile' );
        if( count( $profiles ) > 0 ) {            
            return $profiles;
        }

    }
        
    // on failure, TODO see whether we should separate whether executing of query fails or there's no table entries?
    return new SoapFault( "Client", DS_RET_AUTHENTICATION_FAILED );
}

?>
