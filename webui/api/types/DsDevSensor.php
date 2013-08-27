<?php

/** Dunkkis Server
  * ==============
  * 
  * Copyright (c) 2009-2010 Nomovok Ltd
  * This software is licensed under The MIT License. See LICENSE for details.
  *
  * @author Nguyen Thanh Trung - nguyenthanh.trung@nomovok.com
  */

/**
 * Description of DsDevSensor
 *
 * This class is used to store sensor information ( not the sersor measurement data )
 *
 * @author Nguyen Thanh Trung - nguyenthanh.trung@nomovok.com
 */
class DsDevSensor {
    // define variable members
	// for more details on thses members check p2421_ais_02.odt
	public $sensorId;
	public $sensorName;
	public $sensorType;
	public $sensorState;
	public $deviceId;
	public $deviceType;

	/**
	 * constructor for this class
	 * @param sensorId: string the id of the sensor
	 * @param sensorName: string the name of the sensor
	 * @param sensorType: string the type of the sensor
	 * @param sensorState: DsDevSensorState the state of the sensor ( enumeration type )
	 * @param deviceId: string the id of the device that this sensor is attached to
	 * @param deviceType: DsDevDeviceType the type of the device
	 */
	public function  __construct($sensorId, $sensorName = null, $sensorType = null, $sensorState = null, $deviceId = null, $deviceType = null ) {
		$this->sensorId = $sensorId;
		$this->sensorName = $sensorName;
		$this->sensorType = $sensorType;
		$this->sensorState = $sensorState;
		$this->deviceId = $deviceId;
		$this->deviceType = $deviceType;
	}

}
?>
