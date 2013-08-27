<?php

/** PictureViewer - Demo
  *	This script is for uploading images into the Dunkkis test 
  * database for testing purposes. 
  *
  * @author Juha Hytonen - juha.hytonen@nomovok.com
  * @date 21.12.2009
  */  

include_once( "../ds-db.php" );

$sourceFile = $_FILES['sourceFile']['tmp_name'];
$logTime = $_POST['logTime'];
$time = date( "Y-m-d H:i:s" );
$sensorId = $_POST['sensorId'];
$deviceId = $_POST['deviceId'];
$sourceFile_name = $_FILES['sourceFile']['name'];
$sourceFile_size = $_FILES['sourceFile']['size'];
$sourceFile_type = $_FILES['sourceFile']['type'];

if( empty( $sensorId ) || empty( $deviceId ) || $sourceFile == "none" ) {
	echo( "Please fill out all fields." );
	return;
}

if( empty( $logTime ) ) {
	$logTime = date( "Y-m-d H:i:s" );
}

if( $sourceFile_type == "image/jpeg" ) {
	$sourceImage = imagecreatefromjpeg( $sourceFile );
}
else if( $sourceFile_type == "image/png" ) {	
	$sourceImage = imagecreatefrompng( $sourceFile );	
}
else {
	echo( "Only JPEG or PNG images allowed." );
	return;
}

$width = 100;
$height = imagesy( $sourceImage ) * ($width / imagesx( $sourceImage ));

$thumbnail = imagecreatetruecolor( $width, $height );
imagecopyresampled( $thumbnail, $sourceImage, 0, 0, 0, 0, $width, $height, 
					imagesx( $sourceImage ), imagesy( $sourceImage ) );

if( $sourceFile_type == "image/jpeg" ) {
	imagejpeg( $thumbnail, $sourceFile.".thumbnail" );
}
else if( $sourceFile_type == "image/png" ) {	
	imagepng( $thumbnail, $sourceFile.".thumbnail" );	
}


$fileHandle = fopen( $sourceFile, "r" );
$fileContent = fread( $fileHandle, $sourceFile_size );
$fileContent = addslashes( $fileContent );

$thumbnailHandle = fopen( $sourceFile.".thumbnail", "r" );
$thumbnailContent = fread( $thumbnailHandle, filesize( $sourceFile.".thumbnail" ) );
$thumbnailContent = addslashes( $thumbnailContent );

$link = db_init();
$query = "INSERT INTO picture_data
		  ( picture, mime_type, thumbnail, sensorid, logtime )
		  VALUES
		  ( '".$fileContent."', '".$sourceFile_type."', '".$thumbnailContent."', '".$sensorId."', '".$logTime."');";
mysql_query( $query ) or die (DB_QUERY_ERROR .mysql_error() . ':<br>' . $query);	
$query = "INSERT INTO data
		  ( mac, value, type, sensorid, deviceid, time, logtime )
		  VALUES
		  ( '00:22:15:32:78:86', 0, 'Picture', '".$sensorId."', '".$deviceId."',
		    '".$time."', '".$logTime."' );";
mysql_query( $query ) or die (DB_QUERY_ERROR .mysql_error() . ':<br>' . $query);	
mysql_close( $link );

echo( "<h3>File Upload - Complete</h3>" );
echo( "<b>File:</b> ".$sourceFile_name."<br />" );
echo( "<b>File size:</b> ".$sourceFile_size."<br />" );
echo( "<b>Mime type:</b> ".$sourceFile_type."<br />" );
echo( "<b>Sensor id:</b> ".$sensorId."<br />" );
echo( "<b>Device id:</b> ".$deviceId."<br />" );
echo( "<b>Time:</b> ".$time."<br />" );
echo( "<b>Logtime:</b> ".$logTime."<br /><br />" );
echo( "<a href='ds-picture-demo-upload.html'>Upload another file</a>");

?>