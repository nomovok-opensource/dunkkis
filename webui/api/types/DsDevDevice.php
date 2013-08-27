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
 * DsDevDevice type defines charasterics information of device, such as
 * id, state and device name which is a descriptive name of the
 * device.
 */

class DsDevDevice {
	var $deviceId = null; 			// unique ID
	var $deviceType = null;
	var $deviceState = null;
	var $deviceInterval = null;		// read interval trigger in secs
	var $deviceName = null;			// friendly name for device
	var $boxName		= null;

	function __construct($id, $type = null, $state = null, $interval = null, $name = null, $boxName = null) {
		$this->deviceId = $id;
		$this->deviceType = $type;
		$this->deviceState = $state;
		$this->deviceInterval = $interval;
		$this->deviceName = $name;
		$this->boxName	= $boxName;
	}
}
?>
