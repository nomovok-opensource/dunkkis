<?php

/** PictureViewer - Demo
  * This is a standalone implementation of the PictureViewer component
  * for testing purposes.
  *
  * @author Juha Hytonen - juha.hytonen@nomovok.com
  * @date 21.12.2009
  */  

include_once( "../ds-picture-viewer.php" );

?>

<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN'
'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>

<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='en' lang='en'>
<head>

	<meta http-equiv='Content-type' content='text/html; charset=UTF-8' />
	<link type='text/css' rel='stylesheet' href='../css/picture.css' />
	<script type='text/javascript' src='../js/picture.js'></script>
	
<?php

echo initializeJavaScript();

?>
	
	<title>Dunkkis Picture Viewer Demo</title>

</head>
<body>
<?php

$pictureViewer = new PictureViewer( 1, "26.C0295C000000" );
//$pictureViewer->setPeriod( "2009-12-18 12:03:30", "2009-12-18 12:03:40", "Y-m-d H:i:s" );
//$pictureViewer->setInterval( "00:00:05" );
echo $pictureViewer->view();

?>
</body>
</html>