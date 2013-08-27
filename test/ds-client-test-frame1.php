<?php
/**
 * Tets SOAP APIs
 *
 * @author phivan.ngoc <phivan.ngoc@nomovok.com>
 *
 */

include_once '../includes/config.inc.php';
include_once '../types/DsDevSensor.php';
include_once '../types/DsPrmProfile.php';
include_once '../types/DsAuthSession.php';
include_once '../types/DsAuthProtocol.php';
include_once '../includes/ds-constants.inc.php';

$ds_wsdl_file = '../ds-services.wsdl';

ini_set("soap.wsdl_cache_enabled", "0");
$soapClient = new SoapClient($ds_wsdl_file, array("trace"      => 1, /* show all trasmission */
												"exceptions" => 0
										   ));

$functions = $soapClient->__getFunctions();

?>

<style>
	a, a:visited {color:blue;text-decoration:none;}
	a:hover {text-decoration:underline;}
</style>

<h3>Dunkkis SOAP Demo 3 APIs</h3>
<hr/>

<ol>

<?php
	$reg = "#^(.+?(\({1}.+?\){1})*) (.+?)\(#";
	foreach ($functions as $func) {
		if (preg_match_all($reg, $func, $matches, PREG_PATTERN_ORDER)) {
			$func_name = $matches[3][0];
			$_func = urlencode($func);
			echo "<li><a href='ds-client-test-frame2.php?func={$func_name}&signature={$_func}' target='frame2' title='{$func}'>" . $func_name . "</a></li>";
		}
	}
?>

</ol>

