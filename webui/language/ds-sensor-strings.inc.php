<?php

/** Dunkkis Web User Interface
  * ==========================
  * Sensor type translation routines
  * 
  * Copyright (c) 2009-2010 Nomovok Ltd
  * This software is licensed under The MIT License. See LICENSE for details.
  */

$config['sensor_type_to_string'] = array(
                                        DS_SENSOR_TYPE_GENERIC =>               DS_STRING_MAIN_GENERIC,
                                        DS_SENSOR_TYPE_TEMPERATURE =>           DS_STRING_MAIN_TEMPERATURE,
                                        DS_SENSOR_TYPE_PRESSURE =>              DS_STRING_MAIN_AIR_PRESSURE,
                                        DS_SENSOR_TYPE_HUMIDITY =>              DS_STRING_MAIN_HUMIDITY,
                                        DS_SENSOR_TYPE_SPECIAL =>               DS_STRING_MAIN_SPECIAL,
                                        DS_SENSOR_TYPE_CO2 =>                   DS_STRING_MAIN_CO2,
                                        DS_SENSOR_TYPE_DOOR =>                  DS_STRING_MAIN_DOOR,
                                        DS_SENSOR_TYPE_MOTION =>                DS_STRING_MAIN_MOTION,
                                        DS_SENSOR_TYPE_SWITCH =>                DS_STRING_MAIN_SWITCH,
                                        DS_SENSOR_TYPE_CUSTOM =>                DS_STRING_MAIN_CUSTOM,
                                        DS_SENSOR_TYPE_LDR =>                   DS_STRING_MAIN_LDR,
                                        DS_SENSOR_TYPE_PICTURE =>               DS_STRING_MAIN_PICTURE
                                        );

function sensor_type_string($sensorType) {
    global $config;

    $sensors = explode(" ", $sensorType);
    $ret = "";
    foreach ($sensors as $sensor) {
        $str = $config['sensor_type_to_string'][$sensor];
        if (empty($str))
            $ret .= $sensor." ";
        else
            $ret .= $str." ";
    }

    return $ret;
}

?>
