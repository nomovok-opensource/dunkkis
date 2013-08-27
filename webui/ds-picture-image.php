<?php

/** Dunkkis Web User Interface
  * ==========================
  * Picture Viewer - Image fetching & displaying functionality
  * 
  * Copyright (c) 2009-2010 Nomovok Ltd
  * This software is licensed under The MIT License. See LICENSE for details.
  *
  * @author Juha Hytonen - juha.hytonen@nomovok.com
  */

/// @todo Have to be bound with session (security issue).

include_once( "ds-db.php" );

// Check that a session is open, before allowing access into the db.
session_start();
if( $_SESSION['login'] == false ) {
	return;
}

if( isset( $_GET['id'] ) ) {
	
	// "id" assumed and defined unique.	
	$link = db_init();
	$query = "SELECT picture, mime_type 
			  FROM picture_data
			  WHERE id = ".$_GET['id'].";";
	$result = mysql_query( $query, $link );
	
	if( mysql_num_rows( $result ) > 0 && $result ) {
		
		list( $picture, $mimeType ) = mysql_fetch_row( $result );
		header( $mimeType );
		echo( $picture );
		
	}
	
	mysql_close( $link );
	
}

?>
