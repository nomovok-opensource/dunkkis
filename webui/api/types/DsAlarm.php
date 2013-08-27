<?php

/** Dunkkis Server
  * ==============
  * 
  * Copyright (c) 2009-2010 Nomovok Ltd
  * This software is licensed under The MIT License. See LICENSE for details.
  */

class DsAlarm 
{

    var $alarmName; 
    var $alarmId;

    public function __construct( $alarmName = null, $alarmId = null ) {

        $this->alarmName = $alarmName;
        $this->alarmId = $alarmId;

    }

}
?>
