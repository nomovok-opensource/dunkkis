<?php

/** Dunkkis Server
  * ==============
  * 
  * Copyright (c) 2009-2010 Nomovok Ltd
  * This software is licensed under The MIT License. See LICENSE for details.
  */

/**
 * Class Sensor
 */
class Sensor{
	private $devid; #MAC address of the box
	private $value; #The sensor value
	private $type; #The sensor type
	private $sensor; #The 1-Wire id
	private $board; #The board id (page.4)
	private $time; #ISO-8601 Time Format (by sec) (date -Iseconds)
	
	/* getters */
	function get_devid() {
		return $this->devid;
	}
	function get_value() {
		return $this->value;
	}
	function get_type() {
		return $this->type;
	}
	function get_sensor() {
		return $this->sensor;
	}
	function get_board() {
		return $this->board;
	}
	function get_time() {
		return $this->time;
	}

	/* setters */
	function set_devid($devid) {
		$this->devid = $devid;
	}
	function set_value($value) {
		$this->value = $value;
	}
	function set_type($type) {
		$this->type = $type;
	}
	function set_sensor($sensor) {
		$this->sensor = $sensor;
	}
	function set_board($board) {
		$this->board = $board;
	}
	function set_time($time) {
		$this->time = $time;
	}
}
?>
