<?php

/** Dunkkis Web User Interface
  * ==========================
  * Picture Viewer functionality
  * 
  * Copyright (c) 2009-2010 Nomovok Ltd
  * This software is licensed under The MIT License. See LICENSE for details.
  *
  * @author Juha Hytonen - juha.hytonen@nomovok.com
  */

/* HOW TO USE, Perform the following steps in order:
 * 1) In the <head> section of your XHTML, call initializeJavaScript()
 *    and echo/print the resulting XHTML.
 * 2) Include "js/picture.js".
 * 3) Include "css/picture.css".
 * 4) Create instances of PictureViewer in the <body> section of your XHTML.
 *    Provide each index with a numerical and unique identifier and 
 *    the id of the sensor, the pictures of which you wish to display.
 * 5) Call PictureViewer->view() and echo/print the resulting XHTML.
 */
  
include_once( "ds-db.php" );

/// Print debug messages?
define( "PV_DEBUG", true );

/// Path to image viewer script. 
define( "PV_IMAGE_SOURCE", "ds-picture-image.php?id=" );

/** UI icons. If you change these, remember to change corresponding
  * entries in js/picture.js.
  */
define( "PV_IMG_FIRST", "images/first.png" );
define( "PV_IMG_FIRST_DIS", "images/first_disabled.png" );
define( "PV_IMG_PREV", "images/previous.png" );
define( "PV_IMG_PREV_DIS", "images/previous_disabled.png" );
define( "PV_IMG_NEXT", "images/next.png" );
define( "PV_IMG_NEXT_DIS", "images/next_disabled.png" );
define( "PV_IMG_LAST", "images/last.png" );
define( "PV_IMG_LAST_DIS", "images/last_disabled.png" );
define( "PV_IMG_THUMBNAILS", "images/thumbnails.png" );
define( "PV_IMG_IMAGE", "images/image.png" );

/** Identifier prefixes for UI components. If you change these, remember
  * to change corresponding entries in js/picture.js.
  */ 
define( "PV_HEADER", "PVHeader" );
define( "PV_COMBOBOX", "PVCombobox" );
define( "PV_MODEBUTTON", "PVMode" );
define( "PV_FIRSTBUTTON", "PVFirst" );
define( "PV_PREVIOUSBUTTON", "PVPrevious" );
define( "PV_TEXTEDIT", "PVTextedit" );
define( "PV_COUNT", "PVCount" );
define( "PV_NEXTBUTTON", "PVNext" );
define( "PV_LASTBUTTON", "PVLast" );
define( "PV_CONTAINER", "PVContainer" );
define( "PV_IMAGE", "PVImage" );
define( "PV_FRAME", "PVFrame" );

/** Initialize JavaScript constants from PHP constants.
  * @return XHTML initialization code.
  */
function initializeJavaScript() 
{

    $content = "";
    $content .= "<script type='text/javascript'>";
    $content .= "const PV_STR_THUMBNAILS = '".PV_STR_THUMBNAILS."';";
    $content .= "const PV_STR_IMAGE = '".PV_STR_IMAGE."';";
    $content .= "const PV_STR_THUMBNAIL_VIEW = '".PV_STR_THUMBNAIL_VIEW."';";
    $content .= "const PV_IMAGE_SOURCE = '".PV_IMAGE_SOURCE."';";
    $content .= "const PV_IMG_FIRST = '".PV_IMG_FIRST."';";
    $content .= "const PV_IMG_FIRST_DIS = '".PV_IMG_FIRST_DIS."';";
    $content .= "const PV_IMG_PREV = '".PV_IMG_PREV."';";
    $content .= "const PV_IMG_PREV_DIS = '".PV_IMG_PREV_DIS."';";
    $content .= "const PV_IMG_NEXT = '".PV_IMG_NEXT."';";
    $content .= "const PV_IMG_NEXT_DIS = '".PV_IMG_NEXT_DIS."';";
    $content .= "const PV_IMG_LAST = '".PV_IMG_LAST."';";
    $content .= "const PV_IMG_LAST_DIS = '".PV_IMG_LAST_DIS."';";
    $content .= "const PV_IMG_THUMBNAILS = '".PV_IMG_THUMBNAILS."';";
    $content .= "const PV_IMG_IMAGE = '".PV_IMG_IMAGE."';"; 
    $content .= "const PV_HEADER = '".PV_HEADER."';";
    $content .= "const PV_COMBOBOX = '".PV_COMBOBOX."';";
    $content .= "const PV_MODEBUTTON = '".PV_MODEBUTTON."';";
    $content .= "const PV_FIRSTBUTTON = '".PV_FIRSTBUTTON."';";
    $content .= "const PV_PREVIOUSBUTTON = '".PV_PREVIOUSBUTTON."';";
    $content .= "const PV_TEXTEDIT = '".PV_TEXTEDIT."';";
    $content .= "const PV_COUNT = '".PV_COUNT."';";
    $content .= "const PV_NEXTBUTTON = '".PV_NEXTBUTTON."';";
    $content .= "const PV_LASTBUTTON = '".PV_LASTBUTTON."';";
    $content .= "const PV_CONTAINER = '".PV_CONTAINER."';";
    $content .= "const PV_IMAGE = '".PV_IMAGE."';";
    $content .= "const PV_FRAME = '".PV_FRAME."';";
    $content .= "</script>";
    return $content;

}

/** PictureViewer component.
  */
class PictureViewer
{

    /// Unique identifier for an instance of PictureViewer.
    private $id;
    /// Sensoridstr of the sensor from which pictures are displayed.
    private $sensorId;
    /// User specified name of the sensor.
    private $sensorName;
    /// Start date of pictures displayed as Unix timestamp or Null if not specified.
    private $periodBegin;
    /// End date of pictures displayed as Unix timestamp or Null if not specified.
    private $periodEnd;
    /// Interval of pictures displayed as Unix timestamp or Null if not specified.
    private $interval;
    /// Container for ids and timestamps of pictures displayed.
    private $data;
    /// Number of pictures available for displaying with current settings.
    private $viewCount;

    /** Constructor for PictureViewer.
      * @param id An unique id for the instance of PictureViewer.
      * @note The id must be numerical, positive and non zero (>0)!
      * @note The id must be unique if there are several instances
      *       of PictureViewer within the same page!
      * @param sensorId The sensoridstr (eg. 26.C0295C000000) of the
      *        sensor from which pictures are displayed.
      */
    function __construct( $id, $sensorId )
    {

        if( !is_integer( $id ) || $id < 1 || empty( $id ) || empty( $sensorId ) ) {

            if( PV_DEBUG ) {
                echo( "Invalid parameters for constructor.\n" );
            }

            return false;

        }

        $this->id = $id;
        $this->sensorId = $sensorId;
        $this->sensorName = Null;
        $this->periodBegin = Null;
        $this->periodEnd = Null;
        $this->interval = Null;

    }

    /** Set the picture sensor's name.
      * @param sensorName, (string) The name.
      * @note If sensorName is set to Null, then sensoridstr is shown instead
      *       of name.
      */
    public function setSensorName( $sensorName = Null )
    {

        $this->sensorName = $sensorName;

    }

    /** Set period from which the pictures are displayed.
      * @param begin Start date of the period.
      * @param end End date of the period.
      * @note Expected format is "yyyy-mm-dd" or "yyyy-mm-dd hh:mm:ss".
      * @note To reset period, set begin and end to Null.
      */
    public function setPeriod( $begin, $end )
    {

        if( $begin == Null && $end == Null ) {
            $this->periodBegin = Null;
            $this->periodEnd = Null;
        }

        if( $beginTS = $this->dateTimeToTimestamp( $begin ) ) {
            $this->periodBegin = $beginTS;
        }
        else if( PV_DEBUG ) {
            echo( "Error converting start date ".$start." for period.\n" );
        }

        if( $endTS = $this->dateTimeToTimestamp( $end ) ) {
            $this->periodEnd = $endTS;
        } 
        else if( PV_DEBUG ) {
            echo( "Error converting end date ".$end." for period.\n" );
        }

    }

    /** Set interval for the pictures to be displayed.
      * @param interval Interval in time.
      * @note Default format is hh:mm:ss.
      * @note To reset interval, set interval to null.
      */
    public function setInterval( $interval )
    {

        if( $interval == Null ) {
            $this->interval = Null;
        }

        if( $intervalTS = $this->timeToTimestamp( $interval ) ) {
            $this->interval = $intervalTS;
        }
        else if( PV_DEBUG ) {
            echo( "Error converting interval ".$interval.".\n" );
        }


    }

    /** Display the PictureViewer.
      */
    public function view()
    {

        $this->getData();
        if( count( $this->data ) > 0 ) {

            $content = "";
            $content .= $this->initializeUI();
            $content .= $this->generateUI();
            return $content;

        }
        else {
            return PV_STR_NODATA;
        }

    }

    /** Initializes the JavaScript part of the user interface.
      * @return XHTML initialization code.
      */
    private function initializeUI()
    {

        $content = "";
        $content .= "<script type='text/javascript'>";	
        $content .= "mode[".$this->id."] = 'image';";
        $content .= "currentIndex[".$this->id."] = 0;";
        $content .= "images[".$this->id."] = [];";
        $content .= "headers[".$this->id."] = [];";

        $next = 0; // Next timestamp must be greater or equal to this.
        $this->viewCount = 0; // Number of pictures to display.
        for( $i = 0; $i < count( $this->data ); $i++ ) {

            if( $this->dateTimeToTimestamp( $this->data[$i]['logtime'] ) >= $next ) {

                $content .= "images[".$this->id."][".$this->viewCount."] = '".$this->data[$i]['id']."';";
                $content .= "headers[".$this->id."][".$this->viewCount."] = '".$this->data[$i]['logtime']."';";
                $this->viewCount++;

                /* Account for interval. If interval has been set, set
                 * that next picture must have a timestamp greater or equal to
                 * the sum of last picture's timestamp plus the interval.
                 */
                $next = $this->dateTimeToTimestamp( $this->data[$i]['logtime'] );
                if( $this->interval != Null ) {
                    $next += $this->interval;
                }

            }

        }

        $content .= "itemsCount[".$this->id."] = ".$this->viewCount.";";
        $content .= "</script>";
        return $content;

    }

    /** Generates the user interface.
      * @note initializeUI() must be called before this function.
      * @return XHTML code for the user interface.
      */
    private function generateUI() 
    {

        $viewerHeaderId = PV_HEADER.$this->id;
        $viewerModeButtonId = PV_MODEBUTTON.$this->id;
        $viewerFirstButtonId = PV_FIRSTBUTTON.$this->id;
        $viewerPreviousButtonId = PV_PREVIOUSBUTTON.$this->id;
        $viewerTexteditId = PV_TEXTEDIT.$this->id;
        $viewerCountId = PV_COUNT.$this->id;
        $viewerNextButtonId = PV_NEXTBUTTON.$this->id;
        $viewerLastButtonId = PV_LASTBUTTON.$this->id;
        $viewerContainerId = PV_CONTAINER.$this->id;
        $viewerImageId = PV_IMAGE.$this->id;

        $content = "";
        $content .= "<table class='PictureViewer'>";
        $content .= "<tr>";

        // If name is set, show name.
        if( $this->sensorName == Null ) {
            $content .= "<td class='Header'>".$this->sensorId."</td>";
        }
        else {
            $content .= "<td class='Header'>".$this->sensorName."</td>";
        }

        $content .= "<td id='".$viewerHeaderId."' class='Header'>";
        $content .= "<script type='text/javascript'>";
        $content .= "var combobox = createCombobox(".$this->id.");";
        $content .= "document.getElementById( '".$viewerHeaderId."' ).appendChild( combobox );";
        $content .= "</script>";
        $content .= "</td>";
        $content .= "<td class='Mode'>";
        $content .= "<img src='".PV_IMG_THUMBNAILS."' class='NavBtn' id='".$viewerModeButtonId."' onmousedown='changeMode(".$this->id.")' title='".PV_STR_THUMBNAILS."' /> ";
        $content .= "</td>";
        $content .= "<td colspan='2' class='Navigation'>";
        $content .= "<img src='".PV_IMG_FIRST_DIS."' class='NavBtnDis' id='".$viewerFirstButtonId."' onmousedown='firstImage(".$this->id.")' title='".PV_STR_FIRST."' />";
        $content .= "<img src='".PV_IMG_PREV_DIS."' class='NavBtnDis' id='".$viewerPreviousButtonId."' onmousedown='previousImage(".$this->id.")' title='".PV_STR_PREV."' /> ";
        $content .= "<input type='text' id='".$viewerTexteditId."' value='1' onchange='texteditChange(".$this->id.")' class='Textedit' /> / ";
        $content .= "<span id='".$viewerCountId."'>".$this->viewCount."</span> ";
        $content .= "<img src='".PV_IMG_NEXT."' class='NavBtn' id='".$viewerNextButtonId."' onmousedown='nextImage(".$this->id.")' title='".PV_STR_NEXT."' />";
        $content .= "<img src='".PV_IMG_LAST."' class='NavBtn' id='".$viewerLastButtonId."' onmousedown='lastImage(".$this->id.")' title='".PV_STR_LAST."' />";
        $content .= "</td>";
        $content .= "</tr>";
        $content .= "<tr>";
        $content .= "<td colspan='5' id='".$viewerContainerId."' class='Picture'>";
        $content .= "<img src='ds-picture-image.php?id=".$this->data[0]['id']."' id='".$viewerImageId."' class='Image' alt='".PV_STR_IMG."' />";
        $content .= "</td>";
        $content .= "</tr>";
        $content .= "</table>";
        return $content;

    }

    /** Get id's and logtimes for sensor matching given sensorId and 
      * given period from the database.
      */
    private function getData()
    {

        $link = db_init();
        $query = "SELECT id, logtime
                  FROM picture_data
                  WHERE sensorid = '".$this->sensorId."' "; 

        if( $this->periodBegin != Null ) {
            $query .= "AND UNIX_TIMESTAMP( logtime ) >= ".$this->periodBegin." ";
        }
        if( $this->periodEnd != Null ) {
            $query .= "AND UNIX_TIMESTAMP( logtime ) <= ".$this->periodEnd." ";
        }

        $query.= "ORDER BY logtime ASC;";
        $result = mysql_query( $query, $link ) or die (DB_QUERY_ERROR .mysql_error() . ':<br>' . $query);

        $this->data = array();
        if( $result ) {
            if( mysql_num_rows( $result ) > 0 ) {
                while( $row = mysql_fetch_assoc( $result ) ) {
                    array_push( $this->data, $row );
                }
            }
        }
        else if( PV_DEBUG ) {
            echo( "Error getting data for ".$this->sensorId.". \n" );
            echo( "Period begin ".$this->periodBegin.", end ".$this->periodEnd.".\n" );
        }

        mysql_close( $link );

    }

    /** Converts a date and time into a Unix timestamp.
      * @param value Date and time yyyy-mm-dd hh:mm:ss.
      * @return Unix timestamp of the date and time.
      *	@author Lars Ottesen - lars.ottesen@nomovok.com
      */
    private function dateTimeToTimestamp( $value )
    {
       
        if( !preg_match('/^\d\d\d\d-\d\d-\d\d \d\d:\d\d/', $value ) ) {
            return false;
        }

        $val = explode( " ", $value );
        $date = explode( "-", $val[0] );
        $time = explode( ":", $val[1] );
        return mktime( $time[0], $time[1], $time[2], $date[1], $date[2], $date[0]);

    }

    /** Converts a time into a Unix timestamp.
      * @param value Time hh:mm:ss.
      * @return Given time as Unix timestamp (seconds).
      */
    private function timeToTimestamp( $value )
    {

        if( !preg_match( '/^\d\d:\d\d/', $value ) ) {
            return false;
        }

        $time = explode( ":", $value );
        return ( ($time[0] * 3600) + ($time[1] * 60) + $time[2] );
       
    }

}
