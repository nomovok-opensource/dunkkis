<?php

/** Dunkkis Server
  * ==============
  * 
  * Copyright (c) 2009-2010 Nomovok Ltd
  * This software is licensed under The MIT License. See LICENSE for details.
  */

class DsAlarmSensor 
{

    var $alarmId;
    var $sensorId;
    var $sensorName;
    var $state;
    var $autoEnable;

    public function __construct( $alarmId = null, 
                                 $sensorId = null, 
                                 $sensorName = null, 
                                 $state = null,
                                 $autoEnable = null ) {

    $this->alarmId = $alarmId;
    $this->sensorId = $sensorId;
    $this->sensorName = $sensorName;
    $this->state = $state;
    $this->autoEnable = $autoEnable;

    }

}
?>
