<?php

/** Dunkkis Server
  * ==============
  * 
  * Copyright (c) 2009-2010 Nomovok Ltd
  * This software is licensed under The MIT License. See LICENSE for details.
  */

class DsLogCriteria {
    var $from;
    var $to;
    var $interval; // in seconds
    var $limit;
    var $order;
    
    public function __construct( $from, $to, $interval, $limit, $order = 1 ) {
        $this->from = $from;
        $this->to = $to;
        $this->interval = $interval;
        $this->limit = $limit;
        $this->order = $order;
    }
}

?>
