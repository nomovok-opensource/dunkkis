<?php

/** Dunkkis Server
  * ==============
  * 
  * Copyright (c) 2009-2010 Nomovok Ltd
  * This software is licensed under The MIT License. See LICENSE for details.
  *
  * @author Juha Hytonen - juha.hytonen@nomovok.com
  */


/** @brief Alarm trigger entry.
  *
  * Contains the binding between an alarm and a schedule, the id of the
  * alarm and the schedule as well as their names for convenience.
  */
class DsAlarmTrigger 
{

    var $alarmid;               ///< Id of the alarm.
    var $scheduleId;            ///< Id of the schedule.
    var $alarmName;             ///< Name of the alarm.
    var $scheduleName;          ///< Name of the schedule.

    public function __construct( $alarmId, $scheduleId, 
                                 $alarmName = Null, $scheduleName = Null ) 
    {

        $this->alarmId = $alarmId;
        $this->scheduleId = $scheduleId;
        $this->alarmname = $alarmName;
        $this->scheduleName = $scheduleName;

    }

}
