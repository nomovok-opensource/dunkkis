<?php
/**
 * Returns a list of cameras
 * @param session: DsAuthSession Authenticated session.
 * @return DsCamera
 */

function getCameras( $session )
{
    global $db;

    $sessionObj = new DsAuthSession( $session->sessionId );
    if( ! $sessionObj->isValid() ) {
        return new SoapFault( "Client", DS_RET_AUTHENTICATION_FAILED );
    }

    $query = $db->prepare( "SELECT `sensor`.id AS id, `sensor`.name AS name, `sensor`.sensoridstr AS url
                            FROM `sensor`, `device`, `session`
			    WHERE `sensor`.type='Picture'
			    AND `device`.profileid = `session`.profileid
			    AND `sensor`.devid = `device`.id
			    AND `session`.sessionid = ?" );

    if( $query && $query->execute( array( $sessionObj->sessionId ) ) ) {
        $cameras = $query->fetchAll( PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'DsCamera' ); // fetch_props_late to assign the values after ctor has been called            
        return $cameras;
    }

        
    // on failure, TODO see whether we should separate whether executing of query fails or there's no table entries?
    return new SoapFault( "Client", DS_RET_GENERIC_ERROR );
}

function setCamera( $session, $id, $name, $url )
{
    global $db;

    $sessionObj = new DsAuthSession( $session->sessionId );
    if( ! $sessionObj->isValid() ) {
        return new SoapFault( "Client", DS_RET_AUTHENTICATION_FAILED );
    }

    // edit and delete operations need old_url and devid
    if (0 < $id) {
	$query = $db->prepare( "SELECT sensoridstr, devid FROM sensor WHERE id=?" );

	    if ($query && $query->execute( array( $id ) ) )
		foreach ($query->fetchAll() as $rs ) {
		    $old_url = $rs["sensoridstr"];
		    $devid = $rs["devid"];
		}
    }

    if ("" == $name && "" == $url) {
	// remove camera from sensor, device, data and picture_data tables
        if (0 < $id) {
	    $query = $db->prepare( "DELETE FROM sensor WHERE id=?" );

	    if ($query && $query->execute( array( $id ) ) )
	        $query = $db->prepare( "DELETE FROM device WHERE id=?" );

		if ($query && $query->execute( array( $devid ) ) )
		    $query = $db->prepare( "DELETE FROM data WHERE sensorid=?" );

		    if ($query && $query->execute( array( $old_url ) ) )
		        $query = $db->prepare( "DELETE FROM picture_data WHERE sensorid=?" );

		        if ($query && $query->execute( array( $old_url ) ) )
		            return DS_RET_OK;
        }

	return new SoapFault( "Client", DS_RET_GENERIC_ERROR );
    }

    if (0 < $id) {
	// edit camera entries in sensor, device and data tables
        $query = $db->prepare( "UPDATE sensor SET name=?, sensoridstr=? WHERE id=?" );

        if ($query && $query->execute( array( $name, $url, $id ) ) ) {
            $query = $db->prepare( "UPDATE device SET name=?, devidstr=? WHERE id=?" );

            if ($query && $query->execute( array( $name, $url, $devid ) ) ) {
                $query = $db->prepare( "UPDATE data SET sensorid=?, deviceid=? WHERE sensorid=?" );

                if ($query && $query->execute( array( $url, $url, $old_url ) ) )
                    $query = $db->prepare( "UPDATE picture_data SET sensorid=? WHERE sensorid=?" );

                    if ($query && $query->execute( array( $url, $old_url ) ) )
                        return DS_RET_OK;
            }
        }
    } else {
	// add new camera
	$profileid = "";
	$deviceid = "";
	$devicemac = "";

	// get profileid and deviceid for new camera device/sensor
$query = $db->prepare( "SELECT dunkkisbox.id, dunkkisbox.mac, profile.userid, session.profileid FROM session, profile, dunkkisbox WHERE profile.id=session.profileid AND dunkkisbox.uid=profile.userid AND session.sessionid=?" );

	if ($query && $query->execute( array( $sessionObj->sessionId ) ) ) {
	    foreach( $query->fetchAll() as $rs ) {
	        $profileid = $rs["profileid"];
	        $deviceid = $rs["id"];
	        $devicemac = $rs["mac"];
	    }
	}

	// failed if profileid and deviceid not found
	if ("" == $profileid || "" == $deviceid)
	    return new SoapFault( "Client", DS_RET_GENERIC_ERROR );

	// create new camera device
	$query = $db->prepare( "INSERT INTO device(devidstr, name, profileid, dboxid, type) VALUES(?, ?, ?, ?, ?)" );

	// create new camera sensor for the device
        if ($query && $query->execute( array( $url, $name, $profileid, $deviceid, 5 ) ) ) {
            $query = $db->prepare( "INSERT INTO sensor(name, sensoridstr, devid, type) VALUES(?, ?, ?, '".DS_SENSOR_TYPE_PICTURE."')" );

	    // create dummy data item for camera. needed currently to be visible in the system
	    if ($query && $query->execute( array( $name, $url, $db->lastInsertId() ) ) ) {
		$query = $db->prepare( "INSERT INTO data(mac, value, type, sensorid, deviceid, time, logtime) VALUES(?, '0', '".DS_SENSOR_TYPE_PICTURE."', ?, ?, ?, ?)" );
		$ts = date("Y-m-d H:i:s");

		if ($query && $query->execute( array( $devicemac, $url, $url, $ts, $ts) ) )
                    return DS_RET_OK;
	    }
	}
    }

    return new SoapFault( "Client", DS_RET_GENERIC_ERROR );
}

function setPicture( $session, $picturedata, $thumbnaildata, $mimetype, $sensorid, $timestamp )
{
    global $db;

    $sessionObj = new DsAuthSession( $session->sessionId );
    if( ! $sessionObj->isValid() ) {
        return new SoapFault( "Client", DS_RET_AUTHENTICATION_FAILED );
    }

    $dboxid = "";
    $mac = "";

    // get dunkkisbox id of the camera
    $query = $db->prepare( "SELECT dboxid FROM device WHERE devidstr=?" );

    if ($query && $query->execute( array( $sensorid ) ) ) {
        foreach( $query->fetchAll() as $rs ) {
            $dboxid = $rs["dboxid"];
        }
    }

    // if no camera found, add a new one
    if ("" == $dboxid) {
        setCamera( $session, 0, "Camera", $sensorid );

        if ($query && $query->execute( array( $sensorid ) ) ) {
            foreach( $query->fetchAll() as $rs ) {
                $dboxid = $rs["dboxid"];
            }
        }
    }

    // get mac of the dunkkisbox
    if ("" != $dboxid) {
        $query = $db->prepare( "SELECT mac FROM dunkkisbox WHERE id=?" );

        if ($query && $query->execute( array( $dboxid ) ) ) {
            foreach( $query->fetchAll() as $rs ) {
                $mac = $rs["mac"];
            }
        }
    }

    // add picture to db
    $query = $db->prepare( "INSERT INTO picture_data(picture, mime_type, thumbnail, sensorid, logtime) VALUES(?, ?, ?, ?, ?)" );

    // add data to picture_data table
    if ($query && $query->execute( array( base64_decode($picturedata), $mimetype, base64_decode($thumbnaildata), $sensorid, $timestamp ) ) ) {
        $query = $db->prepare( "INSERT INTO data(mac, value, type, sensorid, deviceid, time, logtime) VALUES(?, '0', '".DS_SENSOR_TYPE_PICTURE."', ?, ?, ?, ?)" );

        // add data to data table
        if ($query && $query->execute( array( $mac, $sensorid, $sensorid, $timestamp, $timestamp ) ) ) {
            return DS_RET_OK;
        }
    }

    return new SoapFault( "Client", DS_RET_GENERIC_ERROR );
}
?>
