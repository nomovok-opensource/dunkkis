<?php

/** Dunkkis Server
  * ==============
  * 
  * Copyright (c) 2009-2010 Nomovok Ltd
  * This software is licensed under The MIT License. See LICENSE for details.
  *
  * @author Toni Leppänen - toni.leppanen@nomovok.com
  * @author Juha Hytonen - juha.hytonen@nomovok.com
  */

class DsDevSensorPicture 
{

    var $sensor;
    var $timestamp;
    var $picture;

    public function __construct( $sensor, $timestamp, $picture ) 
    {

        $this->sensor = $sensor;
        $this->timestamp = $timestamp;
        $this->picture = base64_encode( $picture );

    }

    public function picture() 
    {

        return $this->picture;

    }

}
?>
