<?php

/** Dunkkis Server
  * ==============
  * Alarm functionality queue functions
  * 
  * Copyright (c) 2009-2010 Nomovok Ltd
  * This software is licensed under The MIT License. See LICENSE for details.
  *
  * @author Juha Hytonen - juha.hytonen@nomovok.com
  * Some code courtesy of Lars Kinnunen - lars.kinnunen@nomovok.com
  */

/** Adds a sensor to alarm queue.
  * @param sensor Sensor-object.
  */
function put_to_alarm_queue( Sensor $sensor )
{

    global $db_config, $DS_ALARM_DEBUG;

    $link = db_init();
    $query = "INSERT INTO ".$db_config['db_table_alarm']."
                  (mac, value, type, sensorid, deviceid, time, logtime)
              VALUES ('".$sensor->get_devid()."',
                      '".$sensor->get_value()."', 
                      '".$sensor->get_type()."',
                      '".$sensor->get_sensor()."', 
                      '".$sensor->get_board()."',
                      '".date( DATE_ISO8601 )."',
                      '".date( DATE_ISO8601, $sensor->get_time() )."')";
    $results = mysql_query ($query); //or die ('Error in query: ' .mysql_error() . ":<br>\n" . $query);
    mysql_close ($link);

    if( isset( $DS_ALARM_DEBUG ) ) {
        echo( "Sensor ".$sensor->get_devid()." put to alarm_queue.<br/>" );
    }

}

?>
