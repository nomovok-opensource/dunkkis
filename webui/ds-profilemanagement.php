<?php

/** Dunkkis Web User Interface
  * ==========================
  * 
  * Copyright (c) 2009-2010 Nomovok Ltd
  * This software is licensed under The MIT License. See LICENSE for details.
  */

include_once("ds-db.php");
include_once("includes/config.inc.php");

/**
 * profile_management_form_create
 * Generates the profile management form for a specified user.
 * @param username: string User name.
 * @return Returns the HTML generated.
 *
 * Revised by Juha Hytonen - juha.hytonen@nomovok.com
 */
function profile_management_form_create($username) 
{

    $content = "<h4 class='DunkkisHeading'>".DS_STRING_PROF_MNG_PROFILE_INFO."</h4>";
    $content .= "<form name='profileformcreate' method='post' action='demo.php'>
                 <table class='DunkkisForm'>
                 <tr><td>".DS_STRING_PROF_MNG_PROFILE_OWNER."</td>
                 <td><input type='text' name='profileowner' size='26' readonly value='".$username."' /></td></tr>
                 <tr><td>".DS_STRING_PROF_MNG_PROFILE_NAME."</td>
                 <td><input type='text' name='profilename' size='26' /></td><tr>
                 <tr><td>".DS_STRING_PROF_MNG_PROFILE_PWD."</td>
                 <td><input type='password' name='profilepw' size='26' /></td><tr>
                 <tr><td>".DS_STRING_PROF_MNG_PROFILE_CONFIRM_PWD."</td>
                 <td><input type='password' name='profilepw2' size='26' /></td><tr>
                 <tr><td>&nbsp;</td><td>
                 <input type='submit' name='profileformcreate' value='".DS_STRING_PROF_MNG_CREATE_PROF_BUTTON."' />
                 </td></tr></table></form>";
    return $content;

}

/**
 * add_device_to_profile_form
 * Generates an entry to the form to add devices to a profile.
 * @param profilename: string Profile name.
 * @param dev Device to add as entry.
 * @param devs Array of devices. Will be used to lookup additional profile bindings.
 * @return Returns the HTML generated.
 */
function add_device_to_profile_form($profilename, $dev, $devs) {
	$content = '';
	ob_flush();
	$color =  constant("DS_VAR_ALARM_COLOR_B");

	$content .= "<table style=\"vertical-align:top;text-align: left; width: 650px%;\" border=\"0\" cellpadding=\"2\" cellspacing=\"0\">\n";
	$content .= "<tbody>\n";
	$content .= '<tr><th width="120">'.DS_STRING_PROF_MNG_PROFILE.'</th>
				<th width="120">'.DS_STRING_PROF_MNG_DEVICE.'</th>
				<th width="300">'.DS_STRING_PROF_MNG_DEV_NAME.'</th></tr>'."\n";
	$content .= '<tr>';

    // collect all profiles the device is bound to
    $boundProfileList = "";
    foreach ($devs as $d) {
        if ($d['deviceStr'] == $dev['deviceStr']) {
            if (!empty($boundProfileList)) {
                $boundProfileList .= "<br />";
            }
            $boundProfileList .= stripslashes( $d['profileName'] );
        }
    }

    $content .= "<td style=\"background-color:".$color."\">".$boundProfileList.'</td>'."\n";
	$content .= "<td style=\"background-color:".$color."\">".$dev['deviceStr']."</td>"."\n";

	if (empty($dev['deviceName'])) {
		$dev['deviceName'] = $dev['deviceStr'];
	}

	$content .= "<td style=\"background-color:".$color."\">".'<form ';
	if( $profilename != $dev['profileName']) {
		$content .= 'name="adddev2prof" ';
	} else {
		$content .= 'name="remdevfromprf" ';
	}
	$content .= 'method="post" action="demo.php">'.'<input type="text" size="20" name="';

    if ($dev['profileName'] != $profilename) {
        $content .= "devicename\" value=\"".$dev['deviceStr']."\" />"."\n";
    } else {
        $content .= "devicename\" value=\"".$dev['deviceName']."\" />"."\n";
    }

	$content .= '<input type="submit"';
	$content .= ' name="updatedevname" value="'.DS_STRING_PROF_MNG_UPDATE.'"';			
	if( $profilename != $dev['profileName']) {
		$content .= ' disabled ';
	}
	$content .= '>'."\n";

	$content .= '<input type="submit"';
	if( $profilename != $dev['profileName']) {
		$content .= 'name="adddev2prof" value="'.DS_STRING_PROF_MNG_ADD_TO_PROF.'">'."\n";
	} else {
		$content .= 'name="remdevfromprf" value="'.DS_STRING_PROF_MNG_REMOVE_FROM_PROF.'">'."\n";
	}
	$content .= '<input type="hidden" name="mac" value="'.$dev['mac'].'">'."\n";
	$content .= '<input type="hidden" name="devid" value="'.$dev['deviceStr'].'">'."\n";
	$content .= '<input type="hidden" name="type" value="'.$dev['type'].'">'."\n";
	$content .= '<input type="hidden" name="prfname" value="'.$profilename.'">'."\n";
	if( $profilename != stripslashes( $dev['profileName'] )) {
		$content .= '<input type="hidden" name="method" value="adddev2prof">';
	} else {
		$content .= '<input type="hidden" name="method" value="remdevfromprf">';
	}
	$content .= '</form></td></tr>'."\n";
	$content .= "</tbody>\n";
	$content .= '</table>'."\n";
	$content .= '<b>'.DS_STRING_PROF_MNG_SENSORS.":</b> (";
	foreach ( $dev['type'] as $type ) {
		$content .= sensor_type_string($type);
	}
	$content .= " ) ";
	if( $profilename == $dev['profileName']) {
		$content .= "<a href=\"javascript:unhide('".$dev['deviceStr']."');\">".DS_STRING_PROF_MNG_SHOW_INFO."</a>\n";
	}
	$content .= '<div id="'.$dev['deviceStr'].'" class="hidden">'."\n";
	$content .= get_sensors_list( $dev , $profilename );
	$content .= '</div>'."\n";

	return $content;
}

/**
 * add_devices_to_profile_form
 * Generates the form to add devices to a profile.
 * @param profilename: string Profile name.
 * @param devs Array of devices.
 * @return Returns the HTML generated.
 */
function add_devices_to_profile_form($profilename, $devs) {
	
    //$profilename = html_entity_decode( $profname, ENT_QUOTES );
    $content = '';
	if(!empty($devs)) {

        // keep track of which devices have been displayed
        $displayedDevs = array();

        // sort by binding - display devices bound to this profile first
		foreach ($devs as $dev) {
            if ($dev['profileName'] == $profilename) {
                array_push($displayedDevs, $dev['deviceStr']);
                $content .= add_device_to_profile_form($profilename, $dev, $devs);
                $content .= "<br /><br />";
            }
        }

        // display rest of the devices
        foreach ($devs as $dev) {
            if ($dev['profileName'] != $profilename && !in_array($dev['deviceStr'], $displayedDevs)) {
                array_push($displayedDevs, $dev['deviceStr']);
                $content .= add_device_to_profile_form($profilename, $dev, $devs);
                $content .= "<br /><br />";
            }
        }
    }
	return $content;
}

/**
 * device_list
 * Generates the table of all devices for a user.
 * @param username: string User name.
 * @return Returns the HTML generated.
 *
 * Revised by Juha Hytonen - juha.hytonen@nomovok.com
 */
function device_list($username) 
{

    // if username is numeric, then it is uid, not the name
    $uid = (is_numeric($username))? $username : db_get_userid($username);

    $content .= "<br /><h4 class='DunkkisHeading'>".DS_STRING_PROF_PROFILES."</h4>";

    $profiles = db_get_profiles_by_uid( $uid );
    $gateways = db_get_dunkkisboxes_by_uid( $uid );
    if( $profiles ) {

        // If there are profiles, print table and content.
        $content .= "<table class='DunkkisTable'>";
        $content .= "<tr class='Header'> 
                     <th>".DS_STRING_PROF_MNG_PROFILE_NAME_TBL."</th>
                     <th>".DS_STRING_PROF_MNG_GW_NAME."</th>
                     <th colspan='2'>".DS_STRING_PROF_MNG_ACTION."</th>
                     </tr> ";

        $row = 1; 
        foreach( $profiles as $profile ) {

            // Remove splashes from profile name.
            $name = stripslashes( $profile['name'] );

            // Define row style depending on whether the row is even or odd.
            $content .= ( $row % 2 == 1 ) ? "<tr class='OddRow'>" : "<tr class='EvenRow'>";
            $content .= "<td class='Data'>".$name."</td>";

            if( $gateways ) {

                $devices = db_get_devicearray_by_profileid( $profile['id'] );
                if( $devices ) {

                    // List the devices and gateways bound with the profile.
                    $content .= "<td class='Data'>";
                    foreach( $devices as $device ) {                
                        $gateway = db_get_dunkkisbox_by_id( $device['dboxid'] );
                        $content .= $device['name'];
                        $content .= " (".$gateway['name'].")<br />";
                    }
                    $content .= "</td>";

                    $content .= "<td class='Manage'>";
                    $content .= manageButton( DS_STRING_PROF_MNG_EDIT,
                                              "adddevicetoprofilepage",
                                              "name", $name );
                    $content .= "</td>";

                }
                else {

                    /* If there are no devices bound to the profile, show
                     * only "add" button.
                     */
                    $content .= "<td class='Data'>&nbsp;</td><td class='Manage'>";
                    $content .= manageButton( DS_STRING_PROF_MNG_ADD_DEVICE,
                                              "adddevicetoprofilepage",
                                              "name", $name );
                    $content .= "</td>";
                }

            }
            else {

                // If the user has no gateways, show only "add mac" button.
                $content .= "<td>&nbsp</td><td class='Manage'>";
                $content .= manageButton( DS_STRING_PROF_ADD_MAC,
                                          "macdevices",
                                          "name", $name );
                $content .= "</td>";

            }

            // Always allow the user to remove a profile.
            $content .= "<td class='Manage'>";
            $content .= manageButton( DS_STRING_PROF_MNG_DELETE_THIS_PROFILE,
                                      "removeprofile",
                                      "name", $name );
            $content .= "</td></tr>";

            $row++;

        }
        
        $content .= "</table>";

    }

    return $content;

}

/**
 * get_sensors_list
 * Generates the table of all sensors for a device.
 * @param device Device to list sensors for.
 * @param profile: string Profile name.
 * @return Returns the HTML generated.
 */
function get_sensors_list($device, $profile) {
	$output = "<table style=\"vertical-align:top;text-align: left; width: 650px%;\" border=\"0\" cellpadding=\"2\" cellspacing=\"0\">\n";
	$output .= "<tbody>\n";
	// Table header line
	$color = constant("DS_VAR_ALARM_COLOR_A");
	$output .= "<tr><th width=\"120\">".DS_STRING_PROF_MNG_SENSOR_ID."</th>
					<th width=\"120\">".DS_STRING_PROF_MNG_SENSOR_TYPE."</th>
					<th width=\"300\">".DS_STRING_PROF_MNG_SET_SENSOR_NAME."</th>
				</tr>\n";

	$sensors = db_get_device_sensors($device['deviceId']);
	if ($sensors == 0) return "";

	$i = 0;
	foreach ( $sensors as $row ) {
		$i++;
		$color =  ((int)$i % 2 == 1)? constant("DS_VAR_ALARM_COLOR_B") : constant("DS_VAR_ALARM_COLOR_C");
		$output .= "<tr>\n";
		$output .= "<td style=\"background-color:".$color."\">".$row['sensorString']."</td>\n";
		$output .= "<td style=\"background-color:".$color."\">".sensor_type_string($device['type'][$row['sensorString']])."</td>\n";
		$output .= "<td style=\"background-color:".$color."\">";
		$output .= '<form name="adddevicetoprofilepage" method="post" action="demo.php">'."\n";
		$output .= '<input type="text" name="sensorname" size="20" value="'.$row['sensorName'].'"/>'."\n";
		$output .= '<input type="hidden" name="sensorId" value="'.$row['sensorId'].'">'."\n";
		$output .= '<input type="hidden" name="name" value="'.$profile.'">'."\n";
		$output .= '<input type="hidden" name="method" value="adddevicetoprofilepage">'."\n";
		$output .= '<input type="submit" value="'.DS_STRING_PROF_MNG_UPDATE.'"></form>'."\n";
		$output .= "</td>\n";
		$output .= "</tr>\n";
	}
	$output .= "</tbody>\n";
	$output .= "</table>\n";
	return $output;
}

/**
 * add_device_to_profile_page
 * Generates the page to add a device to a profile.
 * @param profilename: string Profile name.
 * @param msg: string Text message.
 * @return Returns the HTML generated.
 */
function add_device_to_profile_page($profilename, $msg = "") {
	$uid =  db_get_userid( $_SESSION['user'] ); 
	if (isset($_POST['sensorId']) && !empty($_POST['name'])) {
		if (db_set_sensor_name($_POST['sensorId'], stripslashes( $_POST['sensorname'] ))) {
		   $msg = "<p style=\"color: green\">".DS_STRING_SENSOR_MNG_UPDATED."</p>";
		} else {
		   $msg = "<p style=\"color: red\">".DS_STRING_SENSOR_MNG_INVALID."</p>";
		}
	}
	$content = sprintf("<div id='divvalidateerrors'>%s</div>", $msg);
	$dbox = db_get_dunkkisboxes_by_uid($uid);
	if( count($dbox) > 0 ) {
		$alldevs = array();
		for ( $c = 0; $c <= count($dbox) ; $c++ ) {
			$data = $dbox[$c];
			$devs = db_get_all_devices_by_mac($_SESSION['user'], $data['mac']);
			if(count($devs) > 0) {
				foreach($devs as $dev) {
					array_push($alldevs, $dev);
				}
			}
		}
		$content .= add_devices_to_profile_form($profilename,$alldevs);
	}	
	return $content;
}

/**
 * profile_exists
 * Checks if a profile exists for a specified user.
 * @param user: string User name.
 * @param profile: string Profile name.
 * @return Returns true if the profile exists, false otherwise.
 */
function profile_exists($user, $profile) {
    return db_profile_exists($user, $profile);
}

/**
 * create_profile
 * Creates a profile.
 * @param owner: string User name.
 * @param name: string Profile name.
 * @param pw: string Profile password.
 */
function create_profile($owner,$name,$pw) {
	global $config;
 	$sha1pw = sha1($pw);
	$saltedpw = sha1($config['password_salt'].$pw);
	db_add_profile($owner,$name,$saltedpw);	
	return $content;
}

/**
 * profile_create_page
 * Generates the page to create a profile.
 * @return Returns the HTML generated.
 */
function profile_create_page() { 
	$uid =  db_get_userid( $_SESSION['user'] ); 
	// no profiles - default action, create one
	if ( 0 == db_get_profiles_by_uid($uid) ) {
		$content .= "<p>".DS_STRING_PROF_MNG_USER_NO_EXISTING_PROFILES_BEGIN.": [". $_SESSION['user']."] ".DS_STRING_PROF_MNG_USER_NO_EXISTING_PROFILES_END."<br/>";
		$content .= DS_STRING_PROF_MNG_CREATE_ONE . "</p>";
	} 
	return $content;
}

/**
 * add_mac_check
 * Checks if a MAC is valid.
 * @param mac: string MAC to check.
 * @return Returns 1 if the MAC is valid, 0 otherwise.
 */
function add_mac_check( $mac ) {
	/* TODO: too stupid check, fix it */
	if( (strlen($mac) == 17) && ereg('^([0-9a-fA-F]{2}:){5}[0-9a-fA-F]{2}$',$mac) ) { 
		return 1;
	}

	return 0;
}

/**
 * mac_device_management_page
 * Generates the device management page.
 * @return Returns the HTML generated.
 *
 * Revised by Juha Hytonen - juha.hytonen@nomovok.com
 */
function mac_device_management_page() 
{

    $uid = $_SESSION['userid'];
    $content = ""; // Result variable.

    $content .= "<h4 class='DunkkisHeading'>".DS_STRING_MAIN_CAPTION_DEV_ADD."</h4>";

    $content .= "<form name='addmac' method='post' action='demo.php'>
                 <input type='hidden' name='method' value='addmac'>
                 <table class='DunkkisForm'>
                 <tr><td>".DS_STRING_PROF_MNG_INSERT_MAC.":</td>
                 <td><input type='text' name='addmacaddr' size='26' /></td></tr>
                 <tr><td>".DS_STRING_PROF_MNG_SET_DEV_NAME.":</td>
                 <td><input type='text' name='addmacname' size='26' /></td></tr>
                 <tr><td>&nbsp;</td><td>
                 <input type='submit' value='".DS_STRING_PROF_MNG_SUBMIT_BUTTON."'>
                 </td></tr></table></form><br />";

    $content .= "<h4 class='DunkkisHeading'>".DS_STRING_MAIN_CAPTION_MAC_DEVS."</h4>";

    $gateways = db_get_dunkkisboxes_by_uid($uid);
    if( $gateways ) {

        $content .= "<table class='DunkkisTable'>";
        $content .= "<tr class='Header'> 
                     <th>".DS_STRING_PROF_MNG_NAME."</th>
                     <th>".DS_STRING_PROF_MNG_MAC."</th>
                     <th colspan='2'>".DS_STRING_PROF_MNG_ACTION."</th>
                     </tr> ";

        $row = 1; 
        foreach( $gateways as $gateway ) {

            // Define row style depending on whether the row is even or odd.
            $content .= ( $row % 2 == 1 ) ? "<tr class='OddRow'>" : "<tr class='EvenRow'>";
            $content .= "<td class='Data'>".$gateway['name']."</td>
                         <td class='Data'>".$gateway['mac']."</td>";

            $content .= "<td class='Manage'>";
            $content .= manageButton( DS_STRING_PROF_MNG_MANAGE,
                                      "addnewprofile",
                                      "prfid", $gateway['id'] );
            $content .= "</td><td class='Manage'>";
            $content .= manageButton( DS_STRING_PROF_MNG_REMOVE,
                                      "removedunkkisbox",
                                      "dunkkisbox", $gateway['id'] );
            $content .= "</td></tr>";

            $row++;

        }
        
        $content .= "</table>";

    }

    return $content;

}

?>
