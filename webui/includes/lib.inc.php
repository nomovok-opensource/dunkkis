<?php

/** Dunkkis Web User Interface, Dunkkis Server
  * ==========================================
  * 
  * Copyright (c) 2009-2010 Nomovok Ltd
  * This software is licensed under The MIT License. See LICENSE for details.
  */

if( ! function_exists( "logmsg" ) ) {
    function logmsg( $msg )
    {
        global $config;
        print "log";
        if( $config["log_file"] == false )
            return;
        $fp = fopen( $config["log_file"], "a" );
        fwrite( $fp, $msg . "\n" );
        fclose( $fp );
    }
}
?>
