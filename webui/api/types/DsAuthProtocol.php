<?php

/** Dunkkis Server
  * ==============
  * 
  * Copyright (c) 2009-2010 Nomovok Ltd
  * This software is licensed under The MIT License. See LICENSE for details.
  *
  * @author Aki Honkasuo - aki.honkasuo@nomovok.com
  * @author Rami Erlin - rami.erlin@nomovok.com
  */

/**
 * DsAthProtocol type defines the dunkkis protocol
 * version and protocol name  
 */

class DsAuthProtocol {
	var $protocolVersionNumber = null;
	var $protocolName = null;

	function __construct($version, $name) {
		$this->protocolVersionNumber = $version;
		$this->protocolName = $name;
	}

	public function DsGetProtocolVersion() { return $this->protocolVersionNumer; }	
	public function DsGetProtocolName() { return $this->protocolName;}	
   
}
?>
