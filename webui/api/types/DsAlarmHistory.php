<?php

/** Dunkkis Server
  * ==============
  * 
  * Copyright (c) 2009-2010 Nomovok Ltd
  * This software is licensed under The MIT License. See LICENSE for details.
  */

class DsAlarmHistory {
    var $alarmId; 
    var $alarmName; 
    var $sensorId;
    var $sensorName;
    var $scheduleId;
    var $scheduleName;
    var $measurementValue;
    var $measurementStampdate;

    public function  __construct($alarmId = null, $alarmName = null, $sensorId = null, $sensorName = null, $scheduleId = null, $scheduleName = null, $measurementValue = null, $measurementStampdate = null) {
		$this->alarmId = $alarmId;
		$this->alarmName = $alarmName;
		$this->sensorId = $sensorId;
		$this->sensorName = $sensorName;
		$this->scheduleId = $scheduleId;
		$this->scheduleName = $scheduleName;
		$this->measurementValue = $measurementValue;
		$this->measurementStampdate = $measurementStampdate;
    }
}

?>
