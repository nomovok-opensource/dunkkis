<?php

/** Dunkkis Server
  * ==============
  * 
  * Copyright (c) 2009-2010 Nomovok Ltd
  * This software is licensed under The MIT License. See LICENSE for details.
  *
  * Nguyen Thanh Trung - nguyenthanh.trung@nomovok.com
  */

/**
 * Description of DsLogMeasurement
 *
 * This class is used to storing information about measurement
 */
class DsLogMeasurement {
	// define the data first.
	// For more details on these variable memebers, see p2421_ais_02.odt
    var $sensor;
	var $measurementType;
	var $measurementValue;
	var $measurementStampdate;

	/**
	 * constructor
	 * @param sensor: string Sensor.
	 * @param type: string Measurement type.
	 * @param value: int Measurement value.
	 * @param stampdate: string Time stamp.
	 */
    // TODO drop type completely and use sensor object's type instead?
	public function  __construct($sensor, $type, $value, $stampdate) {
        $this->sensor = $sensor;
		$this->measurementType = $type;
		$this->measurementValue = $value;
		$this->measurementStampdate = $stampdate;
	}

	/**
	 * get the type of the measurement
	 * @return int Returns the type of measurement.
	 */
	public function type() {
		return $this->measurementType;
	}

	/**
	 * get the value of the measurement
	 * @return int Returns the value of measurement.
	 */
	public function value() {
		return $this->measurementValue;
	}

	/**
	 * get the time stamp of the measurement
	 * @return string Returns the time stamp of measurement.
	 */
	public function stampdate() {
		return $this->measurementStampdate;
	}
}
?>
