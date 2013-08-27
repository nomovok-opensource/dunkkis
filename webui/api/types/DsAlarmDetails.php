<?php

/** Dunkkis Server
  * ==============
  * 
  * Copyright (c) 2009-2010 Nomovok Ltd
  * This software is licensed under The MIT License. See LICENSE for details.
  */

class DsAlarmDetails
{

    var $alarmId;  
    var $alarmName;
    var $schedules;
    var $contacts;
    var $history;
    var $sensors;

    public function __construct( $alarmId, 
                                 $alarmName = null, 
                                 $schedules = null, 
                                 $contacts = null, 
                                 $history = null,
                                 $sensors = null ) {

        $this->alarmId = $alarmId;
        $this->alarmName = $alarmName;
        $this->schedules = $schedules;
        $this->contacts = $contacts;
        $this->history = $history;
        $this->sensors = $sensors;

    }

}

?>
