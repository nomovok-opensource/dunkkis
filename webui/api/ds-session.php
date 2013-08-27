<?php

/** Dunkkis Server
  * ==============
  * 
  * Copyright (c) 2009-2010 Nomovok Ltd
  * This software is licensed under The MIT License. See LICENSE for details.
  *
  * @author Rami Erlin - rami.erlin@nomovok.com
  */

function initProfileSession( $profile )
{

    $profileObj = new DsPrmProfile( $profile->userName, $profile->profileName, $profile->profilePassword );

    if( $profileObj->authenticate() ) {
        $sessionObj = new DsAuthSession( $profileObj->sessionId() );
        unset( $profileObj ); 
        return $sessionObj;
    }
    else {
        unset( $profileObj );
        return new SoapFault( "Client", DS_RET_AUTHENTICATION_FAILED );
    }
}

function closeProfileSession( $session )
{
    $sessionObj = new DsAuthSession( $session->sessionId );

    if( ! $sessionObj->isValid() ) {
        return new SoapFault( "Client", DS_RET_AUTHENTICATION_FAILED );
    }

    if( $sessionObj->closeSession() ) {
        unset( $sessionObj );
        return NULL;
    }
    else {
        // TODO do we need better error-code/separate codes for different errors on closing?
        return new SoapFault( "Client", DS_RET_GENERIC_ERROR );
    }
}

?>
