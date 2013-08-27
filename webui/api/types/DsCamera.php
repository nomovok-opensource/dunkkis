<?php
/**
 * Description of DsCamera
 *
 * This class is used to storing information about user saved web cameras
 *
 * @author Toni Leppänen - toni.leppanen@nomovok.com
 */
class DsCamera {
	// define the data first.
    	var $id;
    	var $name;
	var $url;

	/**
	 * constructor
	 * @param name: string Name of the camera.
	 * @param url: string URL of the camera.
	 */
	public function  __construct($id, $name, $url) {
        	$this->id = $id;
        	$this->name = $name;
		$this->url = $url;
	}

	/**
	 * Gets the ID.
	 * @return string Returns ID of the camera.
	 */
	public function id() {
		return $this->id;
	}


	/**
	 * Gets the name.
	 * @return string Returns name of the camera.
	 */
	public function name() {
		return $this->name;
	}

	/**
	 * Gets the URL.
	 * @return string Returns URL of the camera.
	 */
	public function url() {
		return $this->url;
	}
}
?>
