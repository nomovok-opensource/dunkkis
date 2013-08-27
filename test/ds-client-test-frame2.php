<?php

/**
 * Tets SOAP APIs
 *
 * @author phivan.ngoc <phivan.ngoc@nomovok.com>
 *
 */
include_once '../includes/ds-constants.inc.php';
include_once '../includes/config.inc.php';
include_once '../types/DsDevSensor.php';
include_once '../types/DsPrmProfile.php';
include_once '../types/DsAuthSession.php';
include_once '../types/DsAuthProtocol.php';
include_once '../types/DsDevDevice.php';
include_once '../types/DsLogCriteria.php';

//error_reporting(E_ALL);
ini_set("memory_limit", "32M");
session_start();

$ds_wsdl_file = '../ds-services.wsdl';
ini_set("soap.wsdl_cache_enabled", "0");
$soapClient = new SoapClient($ds_wsdl_file, array("trace"      => 1, /* show all trasmission */
												"exceptions" => 1 ));

$func_name = $_REQUEST["func"];
$signature = $_REQUEST["signature"];

if (function_exists($func_name)) {
	$ret = call_user_func($func_name);
	if ($_POST["func"]) {
		$req = show_XML($soapClient->__getLastRequest());
		$res = show_XML($soapClient->__getLastResponse());
	}
}

function print_header() {
    global $func_name, $signature;
if ($func_name && $signature) {
	echo "<h2>{$func_name}</h2>";
	echo "<div style='border:1px solid black; background-color:#fff9d7; padding:5px'>";
	echo urldecode($signature);
	echo "</div>";
	echo "<hr>";
	echo "<form action='' method='post'>";
	echo "<input type='hidden' name='func' value='{$func_name}'/>";
	echo "<input type='hidden' name='signature' value='{$signature}'/>";
}
}

function print_footer() {
    echo "</form>";
}


if($req && $res) {
	echo "<h2>SOAP Request:</h2>";
	echo $req;

	echo "<h2>SOAP Response:</h2>";
	echo $res;
}

/**
 * show the xml source for the SOAP request and response
 * Just write this for easier checking soap request and response
 *
 * @param xmlStr: string the source of request or the response
 * @param num_space_for_tab: int number of space used for tab character
 * @author Nguyen Thanh Trung - nguyenthanh.trung@nomovok.com
 */
function show_XML($xmlStr, $num_space_for_tab = 8) {
	trim($xmlStr);
	//echo highlight_string(str_replace(array(">", "<", "> ;<", "> ", ";</", ";<"), array("> ", ";<", ">\n<", ">\n", "\n</", "<"), $xmlStr), true) . "\n";
    // what may have been the reasoning not to print the result in this case?
    //if ( print_r(strpos($xmlStr, "<?xml"), 1) != '0' ) {
    //    return $xmlStr;
    //}
	$out_arr = array();
	$ok = true;

	// split the string to an array of lines
	while (strlen($xmlStr) > 0) {
		if ($xmlStr[0] == "<") { // for a tag
			$lastPost = strpos($xmlStr, ">");
			$out_arr[] = substr($xmlStr, 0, $lastPost + 1);
			$xmlStr = trim(substr($xmlStr, $lastPost+1));
		} else { // for data
			$lastPost = strpos($xmlStr, "<");
			$out_arr[] = substr($xmlStr, 0, $lastPost);
			$xmlStr = trim(substr($xmlStr, $lastPost));
		}
	}
//	var_dump($out_arr);
	// now print the line with ident
	$out = "<div style=\"border: 1px solid black; font-size: 12px;background-color: #CCFFFF;\">\n";
	if (count($out_arr) > 0) {
		$self_close = false; // mark if this tag is a self close tag
		$is_a_tag = true; // mark if line is a tag
		$ident = -1;
		// print the first line
		$out .= htmlspecialchars($out_arr[0]);
		for ( $i=1 ; $i<count($out_arr); $i++ ) {
			$line = $out_arr[$i];
//			$self_close = false;
//			$is_a_tag = true;
			if ($line[0] == "<" && $line[1] != "/") { // open tag
				$ident++;
			}

			if ($line[0] != "<") { // for the data
				$ident++;
//				$is_a_tag = false;
			}

//			if ($is_a_tag && !$self_close) {
//				$out .= "\n<br/>". str_repeat("&nbsp;", $num_space_for_tab * $ident) . $div_open . htmlspecialchars($line);
//			} else {
				$out .= "\n<br/>". str_repeat("&nbsp;", $num_space_for_tab * $ident) . htmlspecialchars($line);
//			}

			if ($line[0] != "<") {
				$ident--;
			}

			if ($line[strlen($line) - 1] == ">" && $line[strlen($line) - 2] == "/") { // selfclosed tag
				$ident--;
//				$self_close = true;
			}
			// check the closing tag
			if ($line[0] == "<" && $line[1] == "/") { // closing tag
				$ident--;
//				$out .= "</div>\n";
			}
		}
	}

	$out .= "</div>\n";
//	highlight_string($out);
	return $out;
//	return $out;
}

function getLoggedDataBySensor() {
    global $config, $protocol, $soapClient;
    $deviceId = "04559C00";
    $sensorId = "26.A2529C000000";
    $from = "2008-01-01";
    $to = "2010-01-01";
    $interval = -1;
    $limit = 100;
    if (isset($_POST['func'])) {
        if (isset($_POST['sensorId'])) {
            $sensorId = $_POST['sensorId'];
        }
        if (isset($_POST['deviceId'])) {
            $deviceId = $_POST['deviceId'];
        }
        if(isset($_POST['from'])) {
            $from = $_POST['from'];
        }
        if(isset($_POST['to'])) {
            $to = $_POST['to'];
        }
        if(isset($_POST['interval'])) {
            $interval = $_POST['interval'];
        }
        if(isset($_POST['order'])) {
            $order = $_POST['order'];
        }
        if(isset($_POST['limit'])) {
            $limit = $_POST['limit'];
        }
        $sessionObj = new DsAuthSession( $_POST['sessionId'] );
        $criteria = new DsLogCriteria( $from, $to, $interval, $limit, $order );

                // "26.74479C000000"
        $sensor = new DsDevSensor($sensorId, "testname", DS_GENERIC_DEVICE, DS_DEVICE_READY, $deviceId );

        $ret = $soapClient->getLoggedDataBySensor($sessionObj, $sensor, $criteria);
    }
	print_header();
    ?>
    <table>
        <tr>
            <td><label>SesseionId:</label></td>
            <td><input type="text" name="sessionId" value="<?php echo $_SESSION['sessionId']; ?>"/></td>
        </tr>
        <tr>
            <td><label>DeviceId:</label></td>
            <td><input type="text" name="deviceId" value="<?php echo $deviceId; ?>"/></td>
        </tr>
        <tr>
            <td><label>SensorId:</label></td>
            <td><input type="text" name="sensorId" value="<?php echo $sensorId; ?>"/></td>
        </tr>
        <tr>
            <td><label>Interval:</label></td>
            <td><input type="text" name="interval" value="<?php echo $interval; ?>"/></td>
        </tr>
        <tr>
            <td><label>From:</label></td>
            <td><input type="text" name="from" value="<?php echo $from; ?>"/></td>
        </tr>
        <tr>
            <td><label>To:</label></td>
            <td><input type="text" name="to" value="<?php echo $to; ?>"/></td>
        </tr>
        <tr>
            <td><label>Limit:</label></td>
            <td><input type="text" name="limit" value="<?php echo $limit; ?>"/></td>
        </tr>
        <tr>
            <td><label>Latest first:</label></td>
            <td><input type="checkbox" name="order" value="1" <?php echo ($order == 1 ? 'checked="yes"' : ''); ?>/></td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
			<td colspan="2"><input type="submit" value="Do SOAP Call"/></td>
		</tr>
    </table>
    <hr/>

    <?php
	print_footer();
}

function getLoggedDataByDevice() {
    global $config, $soapClient;
    $deviceId = "04559C00";
    $from = "2008-01-01";
    $to = "2010-01-01";
    $interval = -1;
    $limit = 100;
    if (isset($_POST['func'])) {
        if (isset($_POST['deviceId'])) {
            $sensorId = $_POST['deviceId'];
        }
        if(isset($_POST['from'])) {
            $from = $_POST['from'];
        }
        if(isset($_POST['to'])) {
            $to = $_POST['to'];
        }
        if(isset($_POST['interval'])) {
            $interval = $_POST['interval'];
        }
        if(isset($_POST['limit'])) {
            $limit = $_POST['limit'];
        }
        if(isset($_POST['order'])) {
            $order = $_POST['order'];
        }
        
        $sessionObj = new DsAuthSession( $_POST['sessionId'] );
        $criteria = new DsLogCriteria( $from, $to, $interval, $limit, $order );

        $device = new DsDevDevice($deviceId, DS_GENERIC_DEVICE, DS_DEVICE_READY, 0, "dasdsa" );

        $ret = $soapClient->getLoggedDataByDevice($sessionObj, $device, $criteria);
    }
	print_header();
    ?>
    <table>
        <tr>
            <td><label>SessionId:</label></td>
            <td><input type="text" name="sessionId" value="<?php echo $_SESSION['sessionId']; ?>"/></td>
        </tr>
        <tr>
            <td><label>DeviceId:</label></td>
            <td><input type="text" name="sensorId" value="<?php echo $deviceId; ?>"/></td>
        </tr>
        <tr>
            <td><label>Interval:</label></td>
            <td><input type="text" name="interval" value="<?php echo $interval; ?>"/></td>
        </tr>
        <tr>
            <td><label>From:</label></td>
            <td><input type="text" name="from" value="<?php echo $from; ?>"/></td>
        </tr>
        <tr>
            <td><label>To:</label></td>
            <td><input type="text" name="to" value="<?php echo $to; ?>"/></td>
        </tr>
        <tr>
            <td><label>Limit:</label></td>
            <td><input type="text" name="limit" value="<?php echo $limit; ?>"/></td>
        </tr>
        <tr>
            <td><label>Latest first:</label></td>
            <td><input type="checkbox" name="order" value="1" <?php echo ($order == 1 ? 'checked="yes"' : ''); ?>/></td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
            <td colspan="2"><input type="submit" value="Do SOAP Call"/></td>
        </tr>
    </table>
    <hr/>

    <?php
	print_footer();
}

/**
 * Test getDevicesByProfile SOAP API
 */

function getDevicesByProfile() {
	global $soapClient;

	if (isset($_POST['func'])) {
		$ret = $soapClient->getDevicesByProfile(new DsAuthSession($_POST["sessionId"]));
	}
    print_header();
	?>
		<table>
			<tr>
				<td><label>Session Id:</label></td>
				<td><input type="text" name="sessionId" value="<?php echo $_SESSION["sessionId"];?>"/></td>
			</tr>
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td colspan="2"><input type="submit" value="Do SOAP Call"/></td>
			</tr>
		</table>
		<hr/>
	<?php
    print_footer();
}

function getSensorsByDevice() {
	global $soapClient;

	if (isset($_POST['func'])) {
		$ret = $soapClient->getSensorsByDevice(new DsAuthSession($_POST["sessionId"]), new DsDevDevice($_POST["deviceId"]));
	}
    print_header();
	?>
		<table>
			<tr>
				<td><label>Session Id:</label></td>
				<td><input type="text" name="sessionId" value="<?php echo $_SESSION["sessionId"];?>"/></td>
			</tr>
			<tr>
				<td><label>Device Id:</label></td>
				<td><input type="text" name="deviceId" value="<?php echo $_POST["deviceId"];?>"/></td>
			</tr>
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td colspan="2"><input type="submit" value="Do SOAP Call"/></td>
			</tr>
		</table>
		<hr/>
	<?php
    print_footer();
}


function getProfiles() {
    global $soapClient;

    if (isset($_POST['func'])) {
        $userName = $_POST['userName'];
        $password = $_POST['password'];
        $ret = $soapClient->getProfiles($userName, $password);
    }
    print_header();
    ?>
        <table>
            <tr>
                <td><label>Userame:</label></td>
                <td><input type="text" name="userName" value="<?php echo $_POST["userName"];?>"/></td>
            </tr>
            <tr>
                <td><label>Password:</label></td>
                <td><input type="text" name="password" value="<?php echo $_POST["password"];?>"/></td>
            </tr>
            <tr><td>&nbsp;</td></tr>
            <tr>
                <td colspan="2"><input type="submit" value="Do SOAP Call"/></td>
            </tr>
        </table>
        <hr/>
    <?php
    print_footer();
}

/**
 * Test getAlarms SOAP API
 *
 * @author Alexey Vlasov <alexey.vlasov@nomovok.com>
 */
function getAlarms() {
    global $soapClient;

    if (isset($_POST['sessionId'])) {
        $sessionObj = new DsAuthSession( $_POST['sessionId'] );
        $ret = $soapClient->getAlarms( $sessionObj );
    }
    print_header();
    ?>
        <table>
        <tr>
            <td><label>SessionId:</label></td>
            <td><input type="text" name="sessionId" value="<?php echo $_SESSION['sessionId']; ?>"/></td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" value="Do SOAP Call"/></td>
        </tr>		
        </table>
        <hr/>
    <?php
    print_footer();
}

/**
 * Test getAlarmHistory SOAP API
 *
 * @author Alexey Vlasov <alexey.vlasov@nomovok.com>
 */
function getAlarmHistory() {
    global $soapClient;

    if (isset($_POST['sessionId'])) {
        $sessionObj = new DsAuthSession( $_POST['sessionId'] );
        $alarmId = (int)$_POST['alarmId'];
        
        if(isset($_POST['order'])) {
            $order = $_POST['order'];
        }
        $criteria = new DsLogCriteria( "2009-02-04", "2009-02-04", -1, 100, $order );
        $ret = $soapClient->getAlarmHistory( $sessionObj, $alarmId, $criteria );
    }
    print_header();
    ?>
        <table>
        <tr>
            <td><label>SessionId:</label></td>
            <td><input type="text" name="sessionId" value="<?php echo $_SESSION['sessionId']; ?>"/></td>
        </tr>
        <tr>
            <td><label>Alarm Id:</label></td>
            <td><input type="text" name="alarmId" value="<?php echo $_POST['alarmId'];?>"/></td>
        </tr>
        <tr>
            <td><label>Latest first:</label></td>
            <td><input type="checkbox" name="order" value="1" <?php echo ($order == 1 ? 'checked="yes"' : ''); ?>/></td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" value="Do SOAP Call"/></td>
        </tr>		
        </table>
        <hr/>
    <?php
    print_footer();
}

/**
 * Test getAlarmDetails SOAP API
 *
 * @author Alexey Vlasov <alexey.vlasov@nomovok.com>
 */
function getAlarmDetails() {
    global $soapClient;

    if (isset($_POST['sessionId'])) {
        if (isset($_POST['alarmId'])) {
            $sessionObj = new DsAuthSession( $_POST['sessionId'] );
            $alarmId = (int)$_POST['alarmId'];
            $ret = $soapClient->getAlarmDetails( $sessionObj, $alarmId );
        }
    }
    print_header();
    ?>
        <table>
        <tr>
            <td><label>SessionId:</label></td>
            <td><input type="text" name="sessionId" value="<?php echo $_SESSION['sessionId']; ?>"/></td>
        </tr>
        <tr>
	        <td><label>Alarm Id:</label></td>
            <td><input type="text" name="alarmId" value="<?php echo $_POST['alarmId'];?>"/></td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" value="Do SOAP Call"/></td>
        </tr>
        </table>
        <hr/>
    <?php
    print_footer();
}

/**
 * Test getAlarmSensors SOAP API
 *
 * @author Alexey Vlasov <alexey.vlasov@nomovok.com>
 */
function getAlarmSensors() {
    global $soapClient;

    if (isset($_POST['sessionId'])) {
        if (isset($_POST['alarmId'])) {
            $sessionObj = new DsAuthSession( $_POST['sessionId'] );
            $alarmId = (int)$_POST['alarmId'];
            $ret = $soapClient->getAlarmSensors( $sessionObj, $alarmId );
        }
    }
    print_header();
    ?>
        <table>
        <tr>
            <td><label>SessionId:</label></td>
            <td><input type="text" name="sessionId" value="<?php echo $_SESSION['sessionId']; ?>"/></td>
        </tr>
        <tr>
            <td><label>Alarm Id:</label></td>
            <td><input type="text" name="alarmId" value="<?php echo $_POST['alarmId'];?>"/></td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" value="Do SOAP Call"/></td>
        </tr>
        </table>
        <hr/>
    <?php
    print_footer();
}

/**
 * Test getThumbnailsBySensor SOAP API
 *
 * @author Alexey Vlasov <alexey.vlasov@nomovok.com>
 */
function getThumbnailsBySensor() {
    global $soapClient;

    $deviceId = "0E469C00";
    $sensorId = "26.C0295C000000";
    $from = "2009-10-01";
    $to = "2009-11-01";
    $interval = -1;
    $limit = 10;
    $order = 0;

    if (isset($_POST['sessionId'])) {

        if (isset($_POST['sensorId'])) {
            $sensorId = $_POST['sensorId'];
        }
        if (isset($_POST['deviceId'])) {
            $deviceId = $_POST['deviceId'];
        }
        if(isset($_POST['from'])) {
            $from = $_POST['from'];
        }
        if(isset($_POST['to'])) {
            $to = $_POST['to'];
        }
        if(isset($_POST['interval'])) {
            $interval = $_POST['interval'];
        }
        if(isset($_POST['limit'])) {
            $limit = $_POST['limit'];
        }
        if(isset($_POST['order'])) {
            $order = $_POST['order'];
        }
    
        $sessionObj = new DsAuthSession( $_POST['sessionId'] );
        $sensor = new DsDevSensor($sensorId, "testname", DS_GENERIC_DEVICE, DS_DEVICE_READY, $deviceId );
        $criteria = new DsLogCriteria( $from, $to, $interval, $limit, $order );
        $ret = $soapClient->getThumbnailsBySensor( $sessionObj, $sensor, $criteria);
    }
    print_header();
    ?>
        <table>
        <tr>
            <td><label>SessionId:</label></td>
            <td><input type="text" name="sessionId" value="<?php echo $_SESSION['sessionId']; ?>"/></td>
        </tr>
        <tr>
            <td><label>DeviceId:</label></td>
            <td><input type="text" name="deviceId" value="<?php echo $deviceId; ?>"/></td>
        </tr>
        <tr>
            <td><label>SensorId:</label></td>
            <td><input type="text" name="sensorId" value="<?php echo $sensorId; ?>"/></td>
        </tr>
        <tr>
            <td><label>Interval:</label></td>
            <td><input type="text" name="interval" value="<?php echo $interval; ?>"/></td>
        </tr>
        <tr>
            <td><label>From:</label></td>
            <td><input type="text" name="from" value="<?php echo $from; ?>"/></td>
        </tr>
        <tr>
            <td><label>To:</label></td>
            <td><input type="text" name="to" value="<?php echo $to; ?>"/></td>
        </tr>
        <tr>
            <td><label>Limit:</label></td>
            <td><input type="text" name="limit" value="<?php echo $limit; ?>"/></td>
        </tr>
        <tr>
            <td><label>Latest first:</label></td>
            <td><input type="checkbox" name="order" value="1" <?php echo ($order == 1 ? 'checked="yes"' : ''); ?>/></td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" value="Do SOAP Call"/></td>
        </tr>
        </table>
        <hr/>
    <?php
    print_footer();
}

/**
 * Test getPictureByTimestamp SOAP API
 *
 * @author Alexey Vlasov <alexey.vlasov@nomovok.com>
 */
function getPictureByTimestamp() {
    global $soapClient;

    $deviceId = "0E469C00";
    $sensorId = "26.C0295C000000";
    $timestamp = "2009-10-09 13:41:58";

    if (isset($_POST['sessionId'])) {

        if (isset($_POST['sensorId'])) {
            $sensorId = $_POST['sensorId'];
        }
        if (isset($_POST['deviceId'])) {
            $deviceId = $_POST['deviceId'];
        }
        if(isset($_POST['timestamp'])) {
            $timestamp = $_POST['timestamp'];
        }
    
        $sessionObj = new DsAuthSession( $_POST['sessionId'] );
        $ret = $soapClient->getPictureByTimestamp( $sessionObj, $sensorId, $timestamp);
    }
    print_header();
    ?>
        <table>
        <tr>
            <td><label>SessionId:</label></td>
            <td><input type="text" name="sessionId" value="<?php echo $_SESSION['sessionId']; ?>"/></td>
        </tr>
        <tr>
            <td><label>DeviceId:</label></td>
            <td><input type="text" name="deviceId" value="<?php echo $deviceId; ?>"/></td>
        </tr>
        <tr>
            <td><label>SensorId:</label></td>
            <td><input type="text" name="sensorId" value="<?php echo $sensorId; ?>"/></td>
        </tr>
        <tr>
            <td><label>Timestamp:</label></td>
            <td><input type="text" name="timestamp" value="<?php echo $timestamp; ?>"/></td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" value="Do SOAP Call"/></td>
        </tr>
        </table>
        <hr/>
    <?php
    print_footer();
}

/**
 * Test closeSession SOAP API
 *
 * @author Rami Erlin <rami.erlin@nomovok.com>
 */
function closeProfileSession() {
	global $soapClient;

	if (isset($_POST['func'])) {
		if (isset($_POST['ds_sessionId'])) {
			$ret = $soapClient->closeProfileSession( new DsAuthSession($_POST['ds_sessionId']) );
			unset($_SESSION["sessionId"]);
		} else {
			$ret = array(9, "<h3>Fill required fields !</h3>");
		}

	}
    print_header();
    ?>
		<table>
            <tr><td colspan="2"><b>give credentials:</b></td></tr>
			<tr>
				<td><label>sessionId:</label></td>
				<td><input type="text" name="ds_sessionId" value="<?php echo $_SESSION["sessionId"];?>"/></td>
			</tr>

			<tr><td>&nbsp;</td></tr>
			<tr>
				<td colspan="2"><input type="submit" value="Do SOAP Call"/></td>
			</tr>
		</table>
		<hr/>
	<?php
    print_footer();
}


/**
 * Test initSession SOAP API
 *
 * @author Rami Erlin <rami.erlin@nomovok.com>
 */
function initProfileSession() {
	global $soapClient;

	if (isset($_POST['func'])) {
		if (isset($_POST['ds_username']) && isset($_POST['ds_profileName']) && isset($_POST['ds_profilePassword'])) {
			$ret = $soapClient->initProfileSession(new DsPrmProfile($_POST['ds_username'], $_POST['ds_profileName'], $_POST['ds_profilePassword']));
			$_SESSION["sessionId"] = $ret->sessionId;
		}
	}
	print_header();
	?>
		<table>
            <tr><td colspan="2"><b>give credentials:</b></td></tr>
			<tr>
				<td><label>username:</label></td>
				<td><input type="text" name="ds_username" value="<?php echo $_POST["ds_username"];?>"/></td>
			</tr>
			<tr>
				<td><label>profilename:</label></td>
				<td><input type="text" name="ds_profileName" value="<?php echo $_POST["ds_profileName"];?>"/></td>
			</tr>
			<tr>
				<td><label>profile password:</label></td>
				<td><input type="text" name="ds_profilePassword" value="<?php echo $_POST["ds_profilePassword"];?>"/></td>
			</tr>

			<tr><td>&nbsp;</td></tr>
			<tr>
				<td colspan="2"><input type="submit" value="Do SOAP Call"/></td>
			</tr>
		</table>
		<hr/>
	<?php
    print_footer();
}

?>


