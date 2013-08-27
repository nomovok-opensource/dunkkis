<?php

/** Dunkkis Web User Interface
  * ==========================
  * Latest measurements view
  * 
  * Copyright (c) 2009-2010 Nomovok Ltd
  * This software is licensed under The MIT License. See LICENSE for details.
  *
  * @author Juha Hytonen - juha.hytonen@nomovok.com
  */

include_once( "ds-db-latest-measurements.php" );
include_once( "ds-picture-viewer.php" );

// Post variable definitions.
define( "DS_LATEST_SHOW", "showlatest" );
/* Number of measurements to be fetched from the database and used in
 * calculating the data points.
 * Each value's timestamp must match:
 * (timestamp / DS_LATEST_DATA_GRANULARITY_DIV) < DS_LATEST_DATA_GRANULARITY_MOD
 * to get included in the data set. Set both to "1" to get all data points.
 */
define( "DS_LATEST_DATA_GRANULARITY_DIV", 2 );
define( "DS_LATEST_DATA_GRANULARITY_MOD", 1 );
// Number of data points actually to be shown on graph.
define( "DS_LATEST_VALUE_COUNT", 30 );
// Format of timestamp on graph.
define( "DS_LATEST_TIME_FORMAT", "H:i" );

/** Displays a menu where user can select the device and period from which
  * he/she wants to view measurements.
  * @return XHTML.
  */
function latestMeasurementsMenu() 
{

    $content = ""; // Result variable.

    $content .= "<br />
                 <h4 class='DunkkisHeading'>".DS_STRING_MAIN_SHOW_LATEST_STAT."</h4>
                 <form name='latestMeasurements' method='post' action='demo.php'>
                 <input type='hidden' name='method' value='".DS_LATEST_SHOW."' /> 
                 <table class='DunkkisForm'>
                 <tr><td>".DS_STRING_MAIN_CHOOSE_DEVICE."</td>
                 <td><select name='device'>";

    // Get and list user's devices.
    $devices = dbGetUsersDevices( $_SESSION['userid'] );
    if( $devices != 0 ) {

        foreach( $devices as $device ) {

            $content .= "<option value='".$device['id']."#".$device['name']."'>";

            if( $device['name'] != Null ) {
                $content .= $device['name'];
                $content .= " (".$device['id'].")";
            }
            else {
                $content .= $device['id'];
            }

            $content .= "</option>";

        }

    }

    $content .= "</select></td></tr>
                 <tr><td>".DS_STRING_MAIN_CHOOSE_PERIOD."</td>
                 <td><select name='period'>
                 <option value='0'>".DS_STRING_MAIN_CHOOSE_TODAY."</option>
                 <option value='1'>".DS_STRING_MAIN_CHOOSE_1_DAY."</option>
                 <option value='2' selected>".DS_STRING_MAIN_CHOOSE_2_DAYS."</option>
                 <option value='5'>".DS_STRING_MAIN_CHOOSE_5_DAYS."</option>
                 <option value='10'>".DS_STRING_MAIN_CHOOSE_10_DAYS."</option>
                 <option value='15'>".DS_STRING_MAIN_CHOOSE_15_DAYS."</option>
                 <option value='30'>".DS_STRING_MAIN_CHOOSE_30_DAYS."</option>
                 <option value='60'>".DS_STRING_MAIN_CHOOSE_60_DAYS."</option>
                 <option value='90'>".DS_STRING_MAIN_CHOOSE_90_DAYS."</option>
                 </select></td></tr>
                 <tr><td>&nbsp;</td><td>
                 <input type='submit' value='".DS_STRING_MAIN_SHOW_BUTTON."' />
                 </td></tr></table></form><br />";

    return $content;

}

/** Displays the data of a given users given device from given period.
  * @param device, (string) The address of the device.
  * @param period, (integer) Number of days to fetch data from.
  * @param user, (integer) ID of the user.
  * @return XHTML.
  */
function latestMeasurementsView( $deviceId, $deviceName, $period, $user ) 
{

    $content = ""; // Result variable.

    $periodBegin = date( "Y-m-d H:i:s", 
                         mktime( 0, 0, 1, date("m"), date("d") - $period, date("Y") ) );
    $periodEnd = date( "Y-m-d H:i:s", 
                       mktime(23, 59, 59, date("m"), date("d"), date("Y") ) );

    $sensors = dbGetSensorsByDevice( $deviceId, $deviceName, $user );
    if( $sensors != 0 ) {

        foreach( $sensors as $sensor ) {

            // Choose how to show data depending on sensor type.
            switch( $sensor['type'] ) {

                case DS_SENSOR_TYPE_PICTURE: {

                    // Create & configure PictureViewer.
                    $pictureViewer = new PictureViewer( ($sensor['id'] + 1),
                                                        $sensor['sensoridstr'] );
                    $pictureViewer->setSensorName( $sensor['name'] );
                    $pictureViewer->setPeriod( $periodBegin, $periodEnd );

                    // Show PictureViewer.
                    $content .= $pictureViewer->view();
                    $content .= "<br />";

                    break;

                }

                default: {
                    $content .= getGraph( $sensor, $periodBegin, $periodEnd );
                    break;
                }

            }

        }

    }

    return $content;

}

/** Returns the graph of a sensor's data from a given period.
  * @param sensor, (string) Address of sensor.
  * @param periodBegin, (string) Beginning of the period.
  * @param periodEnd, (string) End of the period.
  * @return XHTML
  * @note periodBegin and periodEnd must be formatted like "yyyy-mm-dd hh:mm:ss".
  *
  * This is a new wrapper for old pChart access functions.
  */
function getGraph( $sensor, $periodBegin, $periodEnd ) 
{

    // Use sensor name, if available, otherwise sensoridstr.
    $sensorName = "";
    if( $sensor['name'] != "" ) {
        $sensorName .= $sensor['name'];
    }
    else {
        $sensorName .= $sensor['sensoridstr'];
    }

    // Graph captions.
    $graphTitle .= $sensorName." - ".sensor_type_string( $sensor['type'] );
    $valueLabel = getValueLabel( $sensor['type'] );
    $timeLabel = $periodBegin." - ".$periodEnd;

    // Get data from given period.
    $data = dbGetSensorData( $sensor['sensoridstr'], 
                             $periodBegin, 
                             $periodEnd );
    if( $data == 0 ) {
        return "<p>".
               DS_STRING_MAIN_NO_DATA_SENSOR.$sensorName.
               DS_STRING_MAIN_NO_DATA_BETWEEN.$timeLabel."</p>"; 
    }

    return draw_item( getDataPoints( $data['value'] ), 
                      getTimePoints( $data['time'] ), 
                      $graphTitle,
                      $sensor['devname']." (".$sensor['devid'].")", 
                      $valueLabel, 
                      $timeLabel );

}

/** Returns a string describing the type of value for a sensor.
  * @param sensorType, (string) Type of the sensor.
  * @return (string).
  */
function getValueLabel( $sensorType )
{

    $valueLabel = "";
    switch( $sensorType ) {

        case DS_SENSOR_TYPE_TEMPERATURE: {
            $valueLabel = "Celsius"; 
            break;
        }
        case DS_SENSOR_TYPE_HUMIDITY: {
            $valueLabel = "%"; 
            break;
        }
        case DS_SENSOR_TYPE_PRESSURE: {
            $valueLabel = "mbar"; 
            break;
        }

        default:
            break;

    }

    return $valueLabel;

}

/** Returns defined number of data points from given set.
  * @param data, (array, integer) Set of data.
  * @return An array containing DS_LATEST_VALUE_COUNT number of 
  *         data points calculated from the given set.
  *
  * This function calculates and returns average values.
  */
function getDataPoints( $data ) 
{

    // Do not bother calculating averages for a small number of points.
    if( count( $data ) < (DS_LATEST_VALUE_COUNT * 2) ) {
        return $data;
    }

    $interval = count( $data ) / DS_LATEST_VALUE_COUNT;

    $calculatedData = array();
    for( $i = 0; $i < DS_LATEST_VALUE_COUNT; $i++ ) {

        $sum = 0;
        for( $j = $i * $interval; $j < ($i + 1) * $interval; $j++ ) {
            $sum += $data[$j];
        }

        $calculatedData[$i] = $sum / $interval;

    }

    return $calculatedData;

}

/** Returns defined number of times from given date set.
  * @param dates, (array, string) Set of dates.
  * @note dates are expected to be formatted like "yyyy-mm-dd hh:mm:ss".
  * @return An array containing DS_LATEST_MEASUREMENT_COUNT number of 
  *         time points calculated from the given set.
  *
  * This function calculates and returns average values. Result is formatted
  * according to DS_LATEST_TIME_FORMAT.
  */
function getTimePoints( $dates )
{

    // Do not bother calculating averages for a small number of points.
    if( count( $dates ) < (DS_LATEST_VALUE_COUNT * 2) ) {

        // Formatting still has to be applied.
        $formattedDates = array();
        for( $i = 0; $i < count( $dates ); $i++ ) {
            $newDate = date( DS_LATEST_TIME_FORMAT, 
                             dateToTimestamp( $dates[$i] ) );
            array_push( $formattedDates, $newDate );
        }

        return $formattedDates;

    }

    $interval = count( $dates ) / DS_LATEST_VALUE_COUNT;

    $calculatedTimes = array();
    for( $i = 0; $i < DS_LATEST_VALUE_COUNT; $i++ ) {

        $sum = 0;
        for( $j = $i * $interval; $j < ($i + 1) * $interval; $j++ ) {
            $sum += dateToTimestamp( $dates[$j] );
        }

        $calculatedTimes[$i] = date( DS_LATEST_TIME_FORMAT, ($sum / $interval) );

    }

    return $calculatedTimes;

}

/** Converts a date to a timestamp.
  * @param date, (string) The date like "yyyy-mm-dd hh:mm:ss".
  * @return (integer) The timestamp.
  */
function dateToTimestamp( $date ) 
{

    if( preg_match( '/^\d\d\d\d-\d\d-\d\d \d\d:\d\d/', $date ) ) {
        $val = explode(" ",$date);
        $date = explode("-",$val[0]);
        $time = explode(":",$val[1]);
        return mktime( $time[0], $time[1], $time[2], $date[1], $date[2], $date[0] );
    }

    return 0;

}

/**
 * draw_item
 * Draws a graph item.
 * @param value Line data.
 * @param time Graph title.
 * @param label Graph title.
 * @param dataname Line legend.
 * @param unit Graph units.
 * @param date Graph date.
 * @return Returns the HTML code generated.
 * (from old implementation, not revised)
 */
function draw_item($value, $time, $label, $dataname, $unit, $date) {
	$xsize = 660;
//	$ysize = 220;
	$ysize = 260;

	$MarginColor = "#E5DDFF";
	$imgpath= "graph/";
	$output = "";

	// Dataset definition    
	$DataSet = new pData;   
	$DataSet->AddPoint($value,"Serie1");   
	$DataSet->AddPoint($time,"Hours");
	$DataSet->AddSerie("Serie1");   
	$DataSet->SetAbsciseLabelSerie("Hours");
	$DataSet->SetSerieName($dataname,"Serie1");   

	// Initialise the graph   

	$graph = new pChart($xsize, $ysize);   
	$graph->drawGraphAreaGradient(130,150,170,70,TARGET_BACKGROUND);   

	// Prepare the graph area   
	$graph->setFontProperties("fonts/LiberationSans-Regular.ttf",10);   

	// Added space for vertical text.
	$graph->setGraphArea(60,40,595,$ysize - 80);   

	// Initialise graph area   
	$graph->setFontProperties("fonts/LiberationSans-Regular.ttf",10);   

	// Draw the SourceForge Rank graph   
	$DataSet->SetYAxisName($unit);
	$DataSet->SetXAxisName($date);

	$graph->drawScale($DataSet->GetData(),$DataSet->GetDataDescription(),SCALE_NORMAL,213,217,221,TRUE,90,0);
	$graph->clearScale();
	$graph->drawGraphAreaGradient(100,120,80,-50);   
	$graph->drawGrid(4,TRUE,230,230,230,10);

	$graph->drawRightScale($DataSet->GetData(),$DataSet->GetDataDescription(),SCALE_NORMAL,213,217,221,TRUE,90,0);          

	$graph->setShadowProperties(0,2.5,0,0,0,60,1.5);  
	$graph->drawFilledCubicCurve($DataSet->GetData(),$DataSet->GetDataDescription(),.05,50);
	$graph->clearShadow();

	$graph->drawPlotGraph($DataSet->GetData(),$DataSet->GetDataDescription(),3,2,255,255,255);

	// Write the legend (box less)   
	$graph->setFontProperties("fonts/LiberationSans-Regular.ttf",8);   
	$graph->drawLegend(530,5,$DataSet->GetDataDescription(),0,0,0,0,0,0,255,255,255,FALSE);   

	// Write the title   
	$graph->setFontProperties("fonts/MankSans.ttf",18);
	$graph->setShadowProperties(1,1,0,0,0);   
	$graph->drawTitle(0,0,$label,255,255,255,660,30,TRUE);   
	$graph->clearShadow();   

	// Render the picture   
	$ran = rand();
	$date = vsprintf('%d%d', gettimeofday());
	$filename = "img-" .$_SESSION['user'] .$date . $ran . ".png";
	$graph->Render(realpath('.') . "/" . $imgpath . $filename);
	$output .= '<img src="' . $imgpath . $filename . '"><br /><br />';

	return $output;
}

?>
