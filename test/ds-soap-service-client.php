<?php
/**
 * Mar 13, 2009
 *
 * SOAP client
 *
 */

include_once '../includes/config.inc.php';
include_once '../types/DsDevSensor.php';
include_once '../types/DsPrmProfile.php';
include_once '../types/DsAuthSession.php';
include_once '../types/DsAuthProtocol.php';
include_once '../types/tmpTypes.php';

ini_set("soap.wsdl_cache_enabled", "0");
$soapClient = new SoapClient('../'.$config['ds_wsdl_file'], array("trace"      => 1, /* show all trasmission */
												  "exceptions" => 0,
												 ));

echo "<pre>";
//print $soapClient->initSession("username", "password", "id");
print $soapClient->__soapCall("initSession",array("username","password", "id"));

print $soapClient->__getLastRequest();
echo "--------------------------------";
print $soapClient->__getLastResponse();
echo "</pre>";
?>
