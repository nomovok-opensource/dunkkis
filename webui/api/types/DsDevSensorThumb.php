<?php

/** Dunkkis Server
  * ==============
  * 
  * Copyright (c) 2009-2010 Nomovok Ltd
  * This software is licensed under The MIT License. See LICENSE for details.
  *
  * @author Toni Leppänen - toni.leppanen@nomovok.com
  */


/**
 * Description of DsDevSensorThumb
 *
 * This class is used to storing information about thumbnails
 */
class DsDevSensorThumb {
	// define the data first.
    	var $sensor;
	var $thumbnail;
	var $measurementStampdate;

	/**
	 * constructor
	 * @param sensor: string Sensor.
	 * @param thumbnail: string Thumbnail data.
	 * @param stampdate: string Time stamp.
	 */
    // TODO drop type completely and use sensor object's type instead?
	public function  __construct($sensor, $thumbnail, $stampdate) {
        	$this->sensor = $sensor;
		$this->thumbnail = base64_encode($thumbnail);
		$this->measurementStampdate = $stampdate;
	}

	/**
	 * get the thumbnail
	 * @return string Returns thumbnail data.
	 */
	public function thumbnail() {
		return $this->thumbnail;
	}

	/**
	 * get the stampdate of the measurement
	 * @return string Returns the measurement time stamp.
	 */
	public function stampdate() {
		return $this->measurementStampdate;
	}
}
?>
