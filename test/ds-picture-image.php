<?php

/** PictureViewer
  * This script fetches an image with the given identifier from the
  * database and displays it as an image file.
  *
  * @author Juha Hytonen - juha.hytonen@nomovok.com
  * @date 21.12.2009
  */  
  
/// @todo Have to be bound with session (security issue).

include_once( "../ds-db.php" );

// Check that a session is open, before allowing access into the db.
/*session_start();
if( $_SESSION['login'] == false ) {
	return;
}*/

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