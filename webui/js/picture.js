/** Dunkkis Web User Interface
  * ==========================
  * Picture Viewer UI functionality
  * 
  * Copyright (c) 2009-2010 Nomovok Ltd
  * This software is licensed under The MIT License. See LICENSE for details.
  *
  * @author Juha Hytonen - juha.hytonen@nomovok.com
  */

/// Instances' current operating modes.
var mode = [];
/// Instances' current picture indexes.
var currentIndex = [];
/// Instances' picture counts.
var itemsCount = [];
/// Instances' image indexes.
var images = [];
/// Instances' header texts.
var headers = [];

/** Creates the frame element that shows the thumbnail view.
  * @param id Id of the PictureViewer instance.
  * @return The frame element.
  */  
function createFrame( id )
{

    var frame = document.createElement( 'iframe' );
    frame.setAttribute( 'src', 'ds-picture-thumbnails.html' );
    frame.setAttribute( 'id', PV_FRAME + id );
    frame.setAttribute( 'class', 'Frame' );
    frame.setAttribute( 'scrolling', 'no' );
    return frame;

}

/** Creates the image element that shows the picture from the database.
  * @param id Id of the PictureViewer instance.
  * @return The image element.
  */  
function createImage( id )
{

    var image = document.createElement( 'img' );
    image.setAttribute( 'src', PV_IMAGE_SOURCE + images[id][currentIndex[id]] );
    image.setAttribute( 'id', PV_IMAGE + id );
    image.setAttribute( 'class', 'Image' );
    return image;

}

/** Creates the combobox element and loads it with defined values.
  * @param id Id of the PictureViewer instance.
  * @return The combobox element.
  */
function createCombobox( id )
{

    var combobox = document.createElement( 'select' );
    combobox.setAttribute( 'size', '1' );
    combobox.setAttribute( 'id', PV_COMBOBOX + id );
    combobox.setAttribute( 'class', 'Combobox' );
    combobox.onchange = function() { comboboxChange(id); };

    for( i = 0; i < itemsCount[id]; i++ ) {
        var option = document.createElement( 'option' );
        var text = document.createTextNode( headers[id][i] );
        option.appendChild( text );
        combobox.appendChild( option );
    }

    return combobox;

}

/** Updates the UI. Loads the picture from the database, sets the combobox
  * and textedit texts and item count according to currentIndex. Calls
  * updateNavigationState() to update navigation components of the UI.  
  * @param id Id of the PictureViewer instance.
  */
function update( id )
{

    updateNavigationState( id );

    document.getElementById( PV_IMAGE + id ).src = PV_IMAGE_SOURCE + images[id][currentIndex[id]];
    document.getElementById( PV_COMBOBOX + id ).selectedIndex = currentIndex[id];
    document.getElementById( PV_TEXTEDIT + id ).value = (currentIndex[id] + 1);
    document.getElementById( PV_COUNT + id ).innerHTML = itemsCount[id];


}

/** Updates the state (disabled/enabled) of navigation buttons according
  * to the value of currentIndex.
  * @param id Id of the PictureViewer instance.
  * @todo Implement hand cursor.  
  */  
function updateNavigationState( id )
{

    // If first picture...
    if( currentIndex[id] == 0 ) {

        // Disable first and previous buttons.
        document.getElementById( PV_FIRSTBUTTON + id ).src = PV_IMG_FIRST_DIS;
        document.getElementById( PV_FIRSTBUTTON + id ).className = 'NavBtnDis';
        document.getElementById( PV_PREVIOUSBUTTON + id ).src = PV_IMG_PREV_DIS;
        document.getElementById( PV_PREVIOUSBUTTON + id ).className = 'NavBtnDis';

        if( itemsCount[id] > 0 ) {
            document.getElementById( PV_NEXTBUTTON + id ).src = PV_IMG_NEXT;
            document.getElementById( PV_NEXTBUTTON + id ).className = 'NavBtn';
            document.getElementById( PV_LASTBUTTON + id ).src = PV_IMG_LAST;
            document.getElementById( PV_LASTBUTTON + id ).className = 'NavBtn';
        }

    }
    // If last picture...
    else if( currentIndex[id] == (itemsCount[id] - 1) ) {

        // Disable next and last buttons.
        document.getElementById( PV_NEXTBUTTON + id ).src = PV_IMG_NEXT_DIS;
            document.getElementById( PV_NEXTBUTTON + id ).className = 'NavBtnDis';
        document.getElementById( PV_LASTBUTTON + id ).src = PV_IMG_LAST_DIS;
            document.getElementById( PV_LASTBUTTON + id ).className = 'NavBtnDis';

        if( itemsCount[id] != 0 ) {
            document.getElementById( PV_FIRSTBUTTON + id ).src = PV_IMG_FIRST;
            document.getElementById( PV_FIRSTBUTTON + id ).className = 'NavBtn';
            document.getElementById( PV_PREVIOUSBUTTON + id ).src = PV_IMG_PREV;
            document.getElementById( PV_PREVIOUSBUTTON + id ).className = 'NavBtn';
        }

    }
    // If not first nor last picture...
    else if( itemsCount[id] != 0 ) {

        // Make sure that all buttons are enabled.
        document.getElementById( PV_FIRSTBUTTON + id ).src = PV_IMG_FIRST;
        document.getElementById( PV_FIRSTBUTTON + id ).className = 'NavBtn';
        document.getElementById( PV_PREVIOUSBUTTON + id ).src = PV_IMG_PREV;
        document.getElementById( PV_PREVIOUSBUTTON + id ).className = 'NavBtn';
        document.getElementById( PV_NEXTBUTTON + id ).src = PV_IMG_NEXT;
        document.getElementById( PV_NEXTBUTTON + id ).className = 'NavBtn';
        document.getElementById( PV_LASTBUTTON + id ).src = PV_IMG_LAST;
        document.getElementById( PV_LASTBUTTON + id ).className = 'NavBtn';

    }

}

/** Moves to the first picture in the database when the first button is clicked.
  * @param id Id of the PictureViewer instance.
  * @note In thumbnails mode moves to the first page of thumbnails.
  * @todo Implement thumbnails mode.
  */ 
function firstImage( id )
{

    if( mode[id] == 'image' ) {

        currentIndex[id] = 0;
        update( id );

    }

}

/** Moves to the previous picture in the database when the previous button is clicked.
  * @param id Id of the PictureViewer instance.
  * @note In thumbnails mode moves to the previous page of thumbnails.
  * @todo Implement thumbnails mode.
  */ 
function previousImage( id )
{

    if( mode[id] == 'image' ) {

        if( currentIndex[id] > 0 ) {
            currentIndex[id] -= 1;
        }
        update( id );

    }

}

/** Moves to the next picture in the database when the next button is clicked.
  * @param id Id of the PictureViewer instance.
  * @note In thumbnails mode moves to the next page of thumbnails.
  * @todo Implement thumbnails mode.
  */  
function nextImage( id )
{

    if( mode[id] == 'image' ) {

        if( currentIndex[id] < (itemsCount[id]-1) ) {
            currentIndex[id] += 1;
        }
        update( id );

    }

}

/** Moves to the last picture in the database when the last button is clicked.
  * @param id Id of the PictureViewer instance.
  * @note In thumbnails mode moves to the last page of thumbnails.
  * @todo Implement thumbnails mode.
  */  
function lastImage( id )
{

    if( mode[id] == 'image' ) {

        currentIndex[id] = (itemsCount[id] - 1);
        update( id );

    }

}

/** Loads a new picture from the database when the selection in the combobox
  * is changed.
  * @param id Id of the PictureViewer instance.
  * @note Combobx indexes match currentIndex indexing.  
  */  
function comboboxChange( id )
{

    currentIndex[id] = document.getElementById( PV_COMBOBOX + id ).selectedIndex;

    if( currentIndex[id] < 0 || currentIndex[id] >= itemsCount[id] ) {
        currentIndex[id] = 0;
    }

    update( id );

}

/** Loads a new picture from the database when the index in the textedit
  * is changed.
  * @param id Id of the PictureViewer instance.
  */  
function texteditChange( id )
{

    var index = document.getElementById( PV_TEXTEDIT + id ).value - 1;

    // Check that value in textedit is a number.
    if( !isNaN( index ) ) {

        // Check that value in textedit is between index boundaries.
        if( index >= 0 && index < itemsCount[id] ) {
            currentIndex[id] = index;
            update( id );
        }
        else {
            window.alert( 'Index out of range.' );
        }

    }
    else {
        window.alert( 'Index not a number.' );
    }

}

/** Changes between "image" and "thumbnails" modes when the mode button
  * is toggled.
  * @param id Id of the PictureViewer instance.
  */
function changeMode( id )
{

    if( mode[id] == 'image' ) {

        mode[id] = 'thumbnails';

        // Remove combobox.
        var header = document.getElementById( PV_HEADER + id );
        var combobox = document.getElementById( PV_COMBOBOX + id );
        header.removeChild( combobox );

        // Remove image.
        var image = document.getElementById( PV_IMAGE + id );
        var container = document.getElementById( PV_CONTAINER + id );
        container.removeChild( image );

        // Add frame in place of image.
        var frame = createFrame( id );
        container.appendChild( frame );

        // Change button image and add header text.
        document.getElementById( PV_MODEBUTTON + id ).src = PV_IMG_IMAGE;
        document.getElementById( PV_MODEBUTTON + id ).alt = PV_STR_IMAGE;
        document.getElementById( PV_HEADER + id ).innerHTML = PV_STR_THUMBNAIL_VIEW;

    }
    else {

        mode[id] = 'image';

        // Replace header text with combobox.
        var header = document.getElementById( PV_HEADER + id );
        var combobox = createCombobox( id );
        header.innerHTML = '';
        header.appendChild( combobox );

        // Remove frame.
        var container = document.getElementById( PV_CONTAINER + id );
        var frame = document.getElementById( PV_FRAME + id );
        container.removeChild( frame );

        // Add image in place of frame.
        var image = createImage( id );
        container.appendChild( image );

        // Change button image and go to first image.
        document.getElementById( PV_MODEBUTTON + id ).src = PV_IMG_THUMBNAILS;
        document.getElementById( PV_MODEBUTTON + id ).alt = PV_STR_THUMBNAILS;
        firstImage( id );

    }

}
