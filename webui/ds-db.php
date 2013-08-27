<?php

/** Dunkkis Web User Interface
  * ==========================
  * 
  * Copyright (c) 2009-2010 Nomovok Ltd
  * This software is licensed under The MIT License. See LICENSE for details.
  */

/* select either sqlite3 (default) or mysql database*/

include_once "includes/config.inc.php";

/**
 * db_init
 * Opens or reuses a connection to a MySQL server.
 * @return Resource link for MySQL connection
 */
function db_init()
{
	global $config;
	$link = mysql_connect($config['db_host'], $config['db_user'], $config['db_passwd'])
		or die(DB_CONNECT_ERROR . mysql_error());
	mysql_select_db($config['db_name'], $link)
		or die (DB_CONNECT_DB_ERROR . mysql_error());
	return $link;
}



/**
 * db_get_latest_data_by_type
 * Get data associated to given sensor type in database
 * @param sensortype: string type, aka "Temperature".
 * @return Array of resulting data, Empty array if no matching string found.
 */
function db_get_latest_data_by_type($sensortype)
{
	global $config;

	$value = array();
	$i = 0;

	$query = "SELECT * FROM `data` WHERE `type` LIKE CONVERT(_utf8 '" . $sensortype . "' USING latin1) COLLATE latin1_swedish_ci ORDER by `time` DESC LIMIT 0 , 1";

	if (!$config['usemysql'])
	{
	}
	else
	{
		$link = db_init();

		$results = mysql_query ($query)
		or die (DB_QUERY_ERROR .mysql_error() . ':<br>' . $query);



		while ($row = mysql_fetch_array($results))
		{
			$value[$i]['sensor'] = $row['sensorid'];
			$value[$i]['board'] = $row['deviceid'];
			$value[$i]['value'] = $row['value'];
			$value[$i]['recordtime'] = $row['time'];
			$i++;
		}
		mysql_close ($link);
	}

	return $value;
}

/**
 * db_get_all_data
 * Get data associated to specified search option and date range in database
 * @param find: string key, aka "deviceid".
 * @param like: string match, aka "00000000".
 * @param datefrom: string timestamp, aka "Y-m-d H:i:s".
 * @param dateto: string timestamp, aka "Y-m-d H:i:s".
 * @return Array of resulting data, Empty array if no match found.
 */
function db_get_all_data($find, $like, $datefrom, $dateto)
{
	global $config;

	$value = array();
	$i = 0;
	$query = "SELECT * FROM `data`"
			." WHERE `" . $find . "` LIKE CONVERT(_utf8 '" . $like . "' USING latin1) COLLATE latin1_swedish_ci";
	if ($datefrom) {
		$query .= " AND `time` >= '" . $datefrom . "'";
	}
	if ($dateto) {
		$query .= " AND `time` <= '" . $dateto . "'";
	}

	$query .= " ORDER by `time` ASC";

	$link = db_init();

	$results = mysql_query ($query)
	or die ('Error in query: ' .mysql_error() . ':<br>' . $query);

	while ($row = mysql_fetch_array($results))
	{
		$value[$i]['devid'] = $row['mac'];
		$value[$i]['value'] = $row['value'];
		$value[$i]['type'] = $row['type'];
		$value[$i]['sensor'] = $row['sensorid'];
		$value[$i]['board'] = $row['deviceid'];
		$value[$i]['recordtime'] = $row['time'];
		$i++;
	}
	mysql_close ($link);

	return $value;
}	

/**
 * db_get_devices_by_mac
 * Get device information including sensor id's and profile name associated to MAC from data, device and profile in database
 * @author Lars Kinnunen - lars.kinnunen@nomovok.com
 * @param mac: string MAC, aka "XX:XX:XX:XX:XX:XX".
 * @return Array of resulting devices information including sensor id's and profile name, Empty array if no match found.
 */
function db_get_devices_by_mac($mac) {
	$query="SELECT DISTINCT `data`.deviceid AS deviceStr, `data`.type AS type, `data`.sensorid AS sensorStr FROM `data` WHERE `data`.mac='{$mac}'"; 
	$link=db_init();
	$value=array();
	$result=mysql_query($query) or die(DB_QUERY_ERROR.mysql_error().'<br>'.$query);	
	while($row=mysql_fetch_array($result)) {
		$i = $row['deviceStr'];
		$value[$i]['mac']=$mac;
		$value[$i]['deviceStr']=$row['deviceStr'];
		$value[$i]['type'][$row['sensorStr']] .= $row['type']." ";
		if(!empty($row['deviceStr'])) {
		 $query2="SELECT `device`.id AS deviceId, `device`.name AS deviceName, `device`.profileid AS profileId FROM `device` WHERE `device`.devidstr='{$row['deviceStr']}'";
		 $result2=mysql_query($query2) or die(DB_QUERY_ERROR.mysql_error().'<br>'.$query2);
	         while($row2=mysql_fetch_array($result2)) {
 		  $value[$i]['deviceId']=$row2['deviceId'];
		  $value[$i]['deviceName']=$row2['deviceName'];
 		  $value[$i]['profileId']=$row2['profileId'] + 0;
		 }
		}
		if($value[$i]['profileId'] != 0) {
		 $query2="SELECT `profile`.name AS profileName FROM `profile` WHERE `profile`.id='{$value[$i]['profileId']}'"; 
		 $result2=mysql_query($query2) or die(DB_QUERY_ERROR.mysql_error().'<br>'.$query2);
	         while($row2=mysql_fetch_array($result2)) {
		  $value[$i]['profileName']=$row2['profileName'];
		 }
		}
	}
	mysql_close($link);
	return $value;
}


/**
 * db_get_all_devices_by_mac
 * Get device information including sensor id's and profile name associated to MAC from data, device and profile in database.
 * This function is different from db_get_devices_by_mac that does not overwrite profile data with last data retreived. The original function is kept for compatibility.
 * @author Alexey Vlasov - alexey.vlasov@nomovok.com
 * @param username: string username
 * @param mac: string MAC, aka "XX:XX:XX:XX:XX:XX".
 * @return Array of resulting devices information including sensor id's and profile name, Empty array if no match found.
 */
function db_get_all_devices_by_mac($username, $mac) {

    $value = array();
    $uid = db_get_userid($username);

	$link = db_init();	

    $query = "SELECT DISTINCT `data`.deviceid AS deviceStr, `data`.type AS type, `data`.sensorid AS sensorStr FROM `data` WHERE `data`.mac='{$mac}'";
    $result = mysql_query($query) or die(DB_QUERY_ERROR.mysql_error().'<br>'.$query);

    // merge same device entries that differ only by sensor types
    $mergedDevices = array();
    while ($devEntry = mysql_fetch_array($result)) {
        $devName = $devEntry['deviceStr'];
        $mergedDevices[$devName]['deviceStr'] = $devName;
		$mergedDevices[$devName]['type'][$devEntry['sensorStr']] .= $devEntry['type']." ";
    }
	
	foreach ($mergedDevices as $row) {
        $device = array();
		$device['mac'] = $mac;
		$device['deviceStr'] = $row['deviceStr'];
		$device['type'] = $row['type'];

        // get all entries in device table that match deviceStr
		if (!empty($row['deviceStr'])) {
            $query2 = "SELECT `device`.id AS deviceId, `device`.name AS deviceName, `device`.profileid AS profileId FROM `device` WHERE `device`.devidstr='{$row['deviceStr']}'";
            $result2 = mysql_query($query2) or die(DB_QUERY_ERROR.mysql_error().'<br>'.$query2);

            // for each device-profile association add a new device entry
            $entries = 0;
            while ($row2 = mysql_fetch_array($result2)) {

                $profileId = $row2['profileId'] + 0;

                if ($profileId == 0)
                    continue;

                // check if profile is accessible by user
                $accessQuery = sprintf("SELECT name FROM profile WHERE id='%s' AND userid='%s'", mysql_real_escape_string($profileId), mysql_real_escape_string($uid));
                $accessResult = mysql_query($accessQuery) or die(DB_QUERY_ERROR.$accessQuery.' '.mysql_error());
                if (mysql_num_rows($accessResult) == 0)
                    continue;

                $device['deviceId'] = $row2['deviceId'];
                $device['deviceName'] = $row2['deviceName'];
                $device['profileId'] = $profileId;

                $query2 = "SELECT `profile`.name AS profileName FROM `profile` WHERE `profile`.id='{$device['profileId']}'";
                $result3 = mysql_query($query2) or die(DB_QUERY_ERROR.mysql_error().'<br>'.$query2);

                while ($row3 = mysql_fetch_array($result3)) {
                    $device['profileName'] = $row3['profileName'];
                }

                // add
                array_push($value, $device);
                $entries++;
            }

            if ($entries == 0) {
                // the device is not associated with any profile, add basic entry
                array_push($value, $device);
            }
        }
	}
	
    mysql_close($link);
    return $value;
}

/**
 * db_get_device_sensors
 * Get sensors associated to given device id in database
 * @author Lars Kinnunen - lars.kinnunen@nomovok.com
 * @param device: int device
 * @return Array of resulting sensors, 0 if no match found.
 */
function db_get_device_sensors($device) {
	$link=db_init();
	$query=sprintf("SELECT  `sensor`.id AS sensorId, 
				`sensor`.name AS sensorName, 
				`sensor`.sensoridstr AS sensorString
                            FROM 
				`sensor`
                            WHERE 
                                `sensor`.devid = '%s';", mysql_real_escape_string($device));
	$result=mysql_query($query) or die(DB_QUERY_ERROR.mysql_error().'<br>'."Sensors for Device");
	if ( mysql_num_rows($result) > 0 ) {
		$i=0;
		while($row=mysql_fetch_array($result)) {
			$i = $row["sensorId"] + 0;
			$value[$i]["sensorId"]=$i;
			$value[$i]["sensorName"]=$row["sensorName"];
			$value[$i]["sensorString"]=$row["sensorString"];
			$value[$i]["deviceId"]=$device;
			$i++;
		}
		mysql_close($link);
		return $value;
	} else {
		mysql_close($link);
		return 0;
	}
}

/** REMOVE ?
 * db_get_sensors_by_devicestr
 * Get sensors associated to given device string in database
 * @author Lars Kinnunen - lars.kinnunen@nomovok.com
 * @param devicestr: string device
 * @return Array of resulting sensors, 0 if no match found.
 */
function db_get_sensors_by_devicestr($devicestr) {
	$link=db_init();
	$query=sprintf("SELECT  `sensor`.id AS sensorId, 
				`sensor`.name AS sensorName, 
				`sensor`.sensoridstr AS sensorString,
				`sensor`.type AS sensorType,
				`device`.name AS deviceName
                            FROM 
				`sensor`
			    JOIN 
				`device` ON ( `sensor`.devid = 	`device`.id )		
                            WHERE 
				`sensor`.devid = `device`.id AND
                                `device`.devidstr = '%s';", mysql_real_escape_string($devicestr));
	$result=mysql_query($query) or die(DB_QUERY_ERROR.mysql_error().'<br>'."Sensor by id");
	if ( mysql_num_rows($result) > 0 ) {
		$i=0;
		while($row=mysql_fetch_array($result)) {
			$i = $row["sensorString"];
			$value[$i]["id"]=$row["id"];
			$value[$i]["sensorString"]=$i;
			$value[$i]["sensorName"]=$row["sensorName"];
			$value[$i]["sensorType"]=$row["sensorType"] + 0;
			$value[$i]["deviceName"]=$row["deviceName"];
			$value[$i]["deviceString"]=$devicestr;
		}
		mysql_close($link);
		return $value;
	} else {
		mysql_close($link);
		return 0;
	}
}

/** TO BE REMOVED
 * db_get_userid
 * Get user id associated to given username in database
 * @param user: string username
 * @return int user id, nothing is returned if no match found.
 */
function db_get_userid( $user ) {
	$value = array();
	$i = 0;

	$query = "SELECT `uid` FROM `user` WHERE `name` LIKE '" . $user . "' COLLATE latin1_swedish_ci LIMIT 0 , 1";
	$link = db_init();

	$results = mysql_query ($query)
	or die (DB_QUERY_ERROR .mysql_error() . ':<br>' . $query);

	$row = mysql_fetch_array($results);
	mysql_close($link);
	return $row['uid'];
}

/**
 * db_get_device_by_devid
 * Get device associated to given device string in database
 * @param devid: string device
 * @return device, Empty array if no match found.
 */
function db_get_device_by_devid($devid)
{
	$query="SELECT * FROM device WHERE devidstr='$devid';";
	$link=db_init();
	$result=mysql_query($query) or die(DB_QUERY_ERROR.mysql_error.'<br>'.$query);
	$devices = array();
	while($row=mysql_fetch_array($result))
	{
		$devices[] = $row;
	}
	mysql_close($link);
	return $devices;
}

/** REMOVE
 * db_get_devices_by_userid
 * Get devices associated to given user id in database
 * @param userid: int user id
 * @return Array of resulting devices, empty array if no match found.
 *
 * Revised by Juha Hytonen - juha.hytonen@nomovok.com
 * If you edit this, be careful not to break show_my_device_in_list() and
 * showDeviceOptionsList() in demo.php.
 */
function db_get_devices_by_userid($userid)
{

    $devices = array();
    $profiles = db_get_profiles_by_uid( $userid );
    if( $profiles == 0 ) {
        return $devices;
    }

    foreach( $profiles as $profile ) {

        $query = "SELECT name as deviceName, devidstr as deviceStr 
                  FROM device 
                  WHERE profileid = ".$profile['id'].";";
        $link = db_init();
        $result = mysql_query( $query )
            or die( DB_QUERY_ERROR .mysql_error().':<br>'.$query );

        while( $row = mysql_fetch_array( $result ) ) {
            array_push( $devices, $row );
        }

        mysql_close ( $link );

    }

    return $devices;

}

/**
 * db_get_user_role
 * Check if user has admin rights
 * @param username: string username
 * @return boolean true if admin, false if set, Empty string otherwise.
 */
function db_get_user_role($username) {
	$link=db_init();

	$query="SELECT role FROM user WHERE name='$username';";
	$result=mysql_query($query);
	$row=mysql_fetch_array($result);
	mysql_close($link);
	return ($row['role']);
}

/**
 * db_remove_user
 * Remove user from the database
 * TODO: using invalid table usergroup
 * @param username: string username
 */
function db_remove_user($username)
{
	$query="SELECT uid FROM user WHERE name='$username';";
	$link=db_init();
	$result=mysql_query($query) or die(DB_QUERY_ERROR.mysql_error().':<br>'.$query);
	$row=mysql_fetch_array($result);
	$uid=$row['uid'];
	$removeusergroup="DELETE FROM usergroup WHERE uid=$uid;";
	$removeuser="DELETE FROM user WHERE uid=$uid;";
	mysql_query($removeusergroup) or die(DB_QUERY_ERROR.mysql_error().':<br>'.$query);
	mysql_query($removeuser) or die(DB_QUERY_ERROR.mysql_error().':<br>'.$query);
	mysql_close($link);
}


/*
 *
 * Profile management functions
 *
 */

/**
 * db_get_profiles
 * Get all profiles from database.
 * @return Array of resulting profiles, Empty string if no match found.
 */
function db_get_profiles() {
	$query="SELECT * FROM profiles";
	$link=db_init();
	$result=mysql_query($query);
	$i=0;
	while($row=mysql_fetch_array($result))
	{
		$value[$i]["id"]=$row["id"];
		$value[$i]["name"]=$row["name"];
		$value[$i]["password"]=$row["password"];
		$i++;
	}
	mysql_close($link);
	return ($value);
}

/**
 * db_get_profile_id_by_name
 * Get profile associated to given profile name in database
 * @param userName: string user name
 * @param profileName: string profile name
 * @return Array of resulting profile, Empty string if no match found.
 */
function db_get_profile_id_by_name($userName, $profileName) {
    if (empty ($profileName)) {
        return null;
    }
    
    $uid = db_get_userid($userName);

	$link = db_init();
	$query = sprintf( "SELECT DISTINCT `id` AS id FROM profile WHERE name = '%s' AND userid = '{$uid}'",
                      mysql_real_escape_string( $profileName ) );
	$result = mysql_query($query);
	$row = mysql_fetch_assoc($result);
	mysql_close($link);
	return $row;
}

/**
 * db_insert_device_to_profile
 * Insert/Update device and profile associated to given parameters in database
 * @param deviceId: string device id
 * @param fname: string device name
 * @param profileId: int profile
 * @param dboxId: int dunkkisbox
 * @param type: string sensor type, for example "Temperature"
 * @return 0 if update, 1 if insert, no db check.
 */
function db_insert_device_to_profile($deviceId, $fname, $profileId, $dboxId, $type) {

	$query = "SELECT COUNT(*) AS count FROM `device` WHERE `profileid`='{$profileId}' AND `devidstr`='{$deviceId}'";
	$link = db_init();
	$result = mysql_query($query);
	$row = mysql_fetch_array($result);
	
	$name = mysql_real_escape_string($fname);
	if ( 0 != $row['count']) {
			$query = "update `device` set `name`='{$name}' where `profileid`='{$profileId}' AND `devidstr`='{$deviceId}'";
		$ret = 0;
	} else {
		$query = "INSERT INTO device (`profileid`, `devidstr`, `name`,`dboxid`, `type`) 
			VALUES('{$profileId}','{$deviceId}','{$name}', '{$dboxId}','{$type}')";
		$ret = 1;
	}
	
	mysql_query($query);
	mysql_close($link);
	return $ret;
}

/**
 * db_remove_dev_from_profile
 * Deletes device associated to given profile id in database
 * @param profileId: int profile id
 * @param devstr: string device id
 * @return boolean true if success, false if query problem.
 */
function db_remove_dev_from_profile($profileId, $devstr) {
	//$query = "UPDATE `device` SET `device`.profileid = 0 WHERE `profileid`='{$profileId}' AND
	$query = "DELETE FROM `device` WHERE `profileid`='{$profileId}' AND
		`devidstr`='{$devstr}'";
	$link = db_init();
	$result = mysql_query($query);
	$ok = mysql_affected_rows($link) == 1;
	mysql_close($link);
	return $ok;
}

/**
 * db_remove_profile
 * Deletes profile associated to given username and profile name in database
 * @param username: string username
 * @param prfName: string profile name
 * @return 1 if success, 0 if query problem.
 */
function db_remove_profile($username, $prfName) {
    $link = db_init();

    $deleted = 0;

    // get user id
    $query = sprintf("SELECT uid FROM user WHERE name='%s'", mysql_real_escape_string($username));
    $result = mysql_query($query) or die(DB_QUERY_ERROR.$query.' '.mysql_error());


    if (mysql_num_rows($result) > 0) {
        $row = mysql_fetch_array($result);
        $uid = $row['uid'];

        $query = sprintf("SELECT DISTINCT `id` AS id FROM profile WHERE name = '%s'", mysql_real_escape_string($prfName));
        $result = mysql_query($query);
        $row = mysql_fetch_assoc($result);
        $_id = $row['id'];

        $query = sprintf("DELETE FROM `profile` WHERE `name`='%s' AND userid='%s'", mysql_real_escape_string($prfName), mysql_real_escape_string($uid));
        $result = mysql_query($query);
        $deleted = mysql_affected_rows($link);
        
        if ($deleted == 1) {
                $query = "DELETE FROM `device` WHERE `profileid`='{$_id}'";
                mysql_query($query);
        }
    }

        mysql_close($link);
        return $deleted;
}

/**
 * db_add_new_account_request
 * Insert new request into userrequest associated to given parameters in database
 * @param email: string email
 * @param pwreq: string password md5 salt hash
 * @param reason: string reason
 */
function db_add_new_account_request($email,$pwreq,$reason) {
	
	global $config;
	$requestdate=date("Y-m-d");
	$pw = sha1($config['password_salt'].$pwreq);
	$link = db_init();
	$query=sprintf("INSERT INTO userrequest (name,password,email,requestdate,text) values ('%s','%s','%s','%s','%s')",
					mysql_real_escape_string($email),
					mysql_real_escape_string($pw),
					mysql_real_escape_string($email),
					mysql_real_escape_string($requestdate),
					mysql_real_escape_string($reason));
    $result = mysql_query($query);
    mysql_close($link);
} 

/** 
 * db_user_exists
 * Get user associated to given username in database
 * @param username: string username
 * @return 1 if user, 0 if no match found.
 */
function db_user_exists($username) {
    $link = db_init();
    $query = sprintf("SELECT name FROM user WHERE name='%s' LIMIT 1;",mysql_real_escape_string($username));
    $result = mysql_query($query) or die(DB_QUERY_ERROR.$query.' '.mysql_error());
    $rows = mysql_num_rows($result);
    mysql_close($link);
    return($rows);
}

/** 
 * db_get_profiles_by_uid
 * Get profile associated to given user id in database
 * @param uid: int user id
 * @return Array of resulting profile, 0 if no match found.
 */
function db_get_profiles_by_uid($uid) {
	$link=db_init();
	$query=sprintf("SELECT * FROM profile WHERE userid='$uid';");
	$result=mysql_query($query) or die(DB_QUERY_ERROR.mysql_error().'<br>'.$query);
	if( mysql_num_rows($result) > 0 ) {	
		$i=0;
		while($row=mysql_fetch_array($result)) {
			$value[$i]["id"]=$row["id"];
			$value[$i]["name"]=$row["name"];
			$value[$i]["password"]=$row["password"];
			$i++;
		}
		mysql_close($link);
		return $value;
	}
	mysql_close($link);
	return 0;
}

/**
 * db_get_devicearray_by_profileid
 * Get devices associated to given profile id in database
 * @param profileid: int profile id
 * @return Array of resulting devices, Empty string if no match found.
 */
function db_get_devicearray_by_profileid($profileid) {
	$link=db_init();
	$query=sprintf("SELECT * FROM device WHERE profileid='%s';", mysql_real_escape_string($profileid));
	$result=mysql_query($query) or die(DB_QUERY_ERROR.mysql_error().'<br>'.$query);
	$i=0;
	while($row=mysql_fetch_array($result)) {
		$value[$i]["devidstr"]=$row["devidstr"];
		$value[$i]["name"]=$row["name"];
		$value[$i]["dboxid"]=$row["dboxid"];
		$value[$i]["type"]=$row["type"];
		$i++;
	}
	mysql_close($link);
	return $value;
}

/**
 * db_get_dunkkisbox_by_id
 * Get dunkkisbox associated to given dunkkisbox id in database
 * @param id: int dunkkisbox id
 * @return Array of resulting dunkkisbox, boolean False if no match found.
 */
function db_get_dunkkisbox_by_id($id) {
	$query = "SELECT * FROM dunkkisbox WHERE id='{$id}' LIMIT 1";
	$link = db_init();
	$result = mysql_query($query);
	$row = mysql_fetch_array($result);
	mysql_close($link);
	return $row;
}

/**
 * db_get_dunkkisbox_by_mac
 * Get dunkkisbox associated to given MAC in database
 * @param mac: string MAC, aka "XX:XX:XX:XX:XX:XX".
 * @return Array of resulting dunkkisbox, 0 if no match found.
 */
function db_get_dunkkisbox_by_mac($mac, $uid) {
	$link=db_init();
	$query=sprintf("SELECT * FROM dunkkisbox WHERE mac='%s' AND uid=".$uid." LIMIT 1;",
				   mysql_real_escape_string($mac));
	$result=mysql_query($query) or die(DB_QUERY_ERROR.mysql_error().'<br>'.$query);
	
	if ( mysql_num_rows($result) > 0 ) {
		$row=mysql_fetch_array($result);
		mysql_close($link);
		return $row;
	} else {
		mysql_close($link);
		return 0;
	}
}

/**
 * db_get_dunkkisboxes_by_uid
 * Get dunkkisboxs associated to given user id in database
 * @param uid: int user id
 * @return Array of resulting dunkkisboxs, 0 if no match found.
 */  
function db_get_dunkkisboxes_by_uid($uid) {
	$link=db_init();
	$query=sprintf("SELECT * FROM dunkkisbox WHERE uid='%s';", mysql_real_escape_string($uid));
	$result=mysql_query($query) or die(DB_QUERY_ERROR.mysql_error().'<br>'.$query);
	
	if ( mysql_num_rows($result) > 0 ) {
		$i=0;
		while($row=mysql_fetch_array($result)) {
			$value[$i]["id"]=$row["id"];
			$value[$i]["name"]=$row["name"];
			$value[$i]["mac"]=$row["mac"];
			$i++;
		}
		mysql_close($link);
		return $value;
	} else {
		mysql_close($link);
		return 0;
	}
}

/**
 * db_is_mac_free
 * Get dunkkisbox associated to given MAC in database
 * @param mac: string MAC, aka "XX:XX:XX:XX:XX:XX".
 * @return 1 if result found, 0 if no match found.
 *
 * Revised by Juha Hytonen - juha.hytonen@nomovok.com
 */
function db_is_mac_free( $mac, $uid = Null ) 
{

    $link = db_init();
    $query = sprintf( "SELECT * FROM dunkkisbox WHERE mac='%s';",
                      mysql_real_escape_string( $mac ));
    $result = mysql_query( $query, $link ) 
                or die(DB_QUERY_ERROR.mysql_error().'<br>'.$query);

    // If no devices with same MAC.
    if( mysql_num_rows( $result ) == 0 ) {
        mysql_close( $link );
        return 1;
    }
    /* If devices with same MAC and user either not defined or persistent
     * MAC not used.
     */
    else if( (mysql_num_rows( $result ) != 0 && $uid == Null) || !USE_PERSISTENT_MAC ) {
        mysql_close( $link );
        return 0;
    }
    // Devices with same MAC exist, but persistent MAC is used and user defined.
    else  {

        // Given MAC is not same as persistent MAC.
        if( strcasecmp( $mac, PERSISTENT_MAC ) != 0 ) {
            mysql_close( $link );
            return 0;
        }

        // Check if user has MAC already.
        while( $mac = mysql_fetch_assoc( $result ) ) {
            if( $mac['uid'] == $uid ) {
                mysql_close( $link );
                return 0;
            }
        }

        // If didn't, MAC is free.
        mysql_close( $link );
        return 1;

    }

}

/**
 * db_add_mac_to_user
 * Insert new dunkkisbox by given parameters in database
 * @param uid: int user id
 * @param mac: string MAC, aka "XX:XX:XX:XX:XX:XX".
 * @param name: string name
 * @return 1 if success, 0 if fails
 */
function db_add_mac_to_user($uid,$mac,$name) {
	$link = db_init();
	$query=sprintf("INSERT INTO dunkkisbox (mac,name,uid) values ('%s','%s','%d')",
					mysql_real_escape_string($mac),
					mysql_real_escape_string($name),
					mysql_real_escape_string($uid));

    $res = mysql_query($query) or die(DB_QUERY_ERROR.$query.' '.mysql_error());
    mysql_close($link);

	return ($res)?1:0;
} 

/**
 * db_remove_mac_from_user
 * Remove dunkkisbox from the database
 * @param id: int dunkkisbox id
 * @return 1 if success, 0 if fails
 */
function db_remove_mac_from_user($id) {
	$link = db_init();
	$query=sprintf("DELETE FROM `dunkkisbox` WHERE `id`='%s'",
				   mysql_real_escape_string($id));

    $res = mysql_query($query) or die(DB_QUERY_ERROR.$query.' '.mysql_error());
    mysql_close($link);

	return ($res)?1:0;
} 

/**
 * db_profile_exists
 * Get profile associated to given username and profilename in database
 * @param username: string username
 * @param profilename: string profile name
 * @return 1 if profile exists, 0 if no match found.
 */
function db_profile_exists($username, $profilename) {
    $link = db_init();
    $query = sprintf("SELECT uid FROM user WHERE name='%s'", mysql_real_escape_string($username));
    $result = mysql_query($query) or die(DB_QUERY_ERROR.$query.' '.mysql_error());
    $found = 0;
    
	if (mysql_num_rows($result) > 0) {
        $row = mysql_fetch_array($result);
        $uid = $row['uid'];
        
        $query = sprintf("SELECT name FROM profile WHERE name='%s' AND userid='%s'", mysql_real_escape_string($profilename), mysql_real_escape_string($uid));
    	$result = mysql_query($query) or die(DB_QUERY_ERROR.$query.' '.mysql_error());
    
        if (mysql_num_rows($result) > 0)
            $found = 1;
    }

    mysql_close($link);
    return $found;
}

/**
 * db_add_profile
 * Insert new profile by given parameters in database
 * @param profileowner: string username
 * @param profilename: string profile name
 * @param password: string password md5 salt hash
 */
function db_add_profile($profileowner,$profilename,$password) {
    $link=db_init();
    $query=sprintf("SELECT uid FROM user WHERE name='%s'",mysql_real_escape_string($profileowner));
    $result=mysql_query($query) or die(DB_QUERY_ERROR.$query.' '.mysql_error());
    
	if(mysql_num_rows($result)>0) {
        $row=mysql_fetch_array($result);
        $uid=$row['uid'];
        $insert_query=sprintf("INSERT INTO profile (userid,name,password)
							  values ('%d','%s','%s')",$uid,mysql_real_escape_string($profilename),$password);
        mysql_query($insert_query) or die (DB_QUERY_ERROR.$insert_query.' '.mysql_error());
	}
    mysql_close($link);
}

/**
 * db_get_sensors_by_deviceid
 * Get sensor ids associated to given device in database
 * @param deviceid: string device
 * @return Array of resulting sensors, 0 if no match found.
 */
function db_get_sensors_by_deviceid($deviceid) {
	$link=db_init();
	//echo $deviceid." ";
	$query=sprintf("SELECT DISTINCT `sensorid` FROM `data` WHERE deviceid='%s';", mysql_real_escape_string($deviceid));
	$result=mysql_query($query) or die(DB_QUERY_ERROR.mysql_error().'<br>'.$query);


	if ( mysql_num_rows($result) > 0 ) {
		$i=0;
		while($row=mysql_fetch_array($result)) {
			$value[$i]["sensorid"]=$row["sensorid"];
			$i++;
		}
		mysql_close($link);
		return $value;
	} else {
		mysql_close($link);
		return 0;
	}

}

/**
 * db_get_type_by_sensorid
 * Get sensor type associated to given sensor in database
 * @author Lars Kinnunen - lars.kinnunen@nomovok.com
 * @param sensorid: string sensor id
 * @return string sensor type, for example "Temperature"; 0 if not found
 */
function db_get_type_by_sensorid($sensorid) {
	global $config;
	$link=db_init();
	$query=sprintf("SELECT DISTINCT `type` FROM `data` WHERE sensorid='%s' LIMIT 1;", mysql_real_escape_string($sensorid));
	$result=mysql_query($query);
	if ( mysql_num_rows($result) > 0 ) {
		$row=mysql_fetch_array($result);
		mysql_close($link);
		return ($row["type"]);
	} else {
		mysql_close($link);
		return 0;
	}

}

/**
 * db_add_sensor_to_profile
 * Insert new sensor into sensor table by given parameters to database
 * @param sensorid: string sensor id
 * @param name: string name
 * @param devid: array device
 * @param type: int type
 */
function db_add_sensor_to_profile($sensorid,$name,$devid,$type) {
	$link=db_init();
	$query=sprintf("INSERT INTO `sensor` (`sensoridstr`,`name`,`devid`,`type`)
				   	VALUES ('%s','%s','%s','%s')",
					mysql_real_escape_string($sensorid),
					mysql_real_escape_string($name),
					mysql_real_escape_string($devid['id']),
					mysql_real_escape_string($type));
	$result=mysql_query($query) or die(DB_QUERY_ERROR.mysql_error().'<br>'.$query);
	mysql_close($link);
}

/**
 * db_del_sensors_from_device
 * Remove sensors associated to given device from database
 * @param devid: int device id
 */
function db_del_sensors_from_device($devid) {
	$link=db_init();
	$query=sprintf("DELETE FROM sensor WHERE devid='%s'", mysql_real_escape_string($devid));
	$result=mysql_query($query) or die(DB_QUERY_ERROR.mysql_error().'<br>'.$query);
	mysql_close($link);
}

/**
 * db_get_id_of_device_by_devidstr
 * Get device id associated to given device and profile id in database
 * @param devidstr: string device
 * @param prfId: int profile id
 * @return Array of resulting id, 0 if no match found.
 */
function db_get_id_of_device_by_devidstr($devidstr,$prfId) {
	$link=db_init();
	$query=sprintf("SELECT `id` FROM `device` WHERE `devidstr`='%s' AND
				   `profileid`='%s' LIMIT 1", 
					mysql_real_escape_string($devidstr),
					mysql_real_escape_string($prfId));

	$result=mysql_query($query) or die(DB_QUERY_ERROR.mysql_error().'<br>'.$query);
	
	if ( mysql_num_rows($result) > 0 ) {
		mysql_close($link);
		return mysql_fetch_array($result);
	} else {
		mysql_close($link);
		return 0;
	}
}

/**
 * db_is_device_added_to_profile
 * Get device id associated to given device and profile id in database
 * TODO: Dublication of db_get_id_of_device_by_devidstr, why not use same function?
 * @param devidstr: string device
 * @param prfId: int profile id
 * @return 1 if match, 0 if no match found.
 */
function db_is_device_added_to_profile($devidstr,$prfId) {
	$link=db_init();
	$query=sprintf("SELECT `id` FROM `device` WHERE `devidstr`='%s' AND
				   `profileid`='%s'", 
					mysql_real_escape_string($devidstr),
					mysql_real_escape_string($prfId));

	$result=mysql_query($query) or die(DB_QUERY_ERROR.mysql_error().'<br>'.$query);
	
	if ( mysql_num_rows($result) > 0 ) {
		mysql_close($link);
		return 1;
	} else {
		mysql_close($link);
		return 0;
	}
}

function db_get_sensor_name( $sensoridstr, $uid ) {

    $query = "SELECT sensor.name as name
              FROM sensor, device, profile 
              WHERE sensor.sensoridstr = '".$sensoridstr."' AND
                sensor.devid = device.id AND
                device.profileid = profile.id AND
                profile.userid = ".$uid." LIMIT 1;";
    $link = db_init();
    $result = mysql_query( $query, $link ) 
                or die( DB_QUERY_ERROR .mysql_error().":<br>".$query );

    if( mysql_num_rows( $result ) > 0 ) {
        $row = mysql_fetch_assoc( $result ) ;
        mysql_close( $link );
        return $row['name'];
    }

    mysql_close( $link );
    return false;

}

?>
