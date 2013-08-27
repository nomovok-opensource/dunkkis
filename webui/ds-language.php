<?php

/** Dunkkis Web User Interface
  * ==========================
  * Language switching functionality
  * 
  * Copyright (c) 2009-2010 Nomovok Ltd
  * This software is licensed under The MIT License. See LICENSE for details.
  *
  * @author Juha Hytonen - juha.hytonen@nomovok.com
  */

/** Define supported languages. 
  * link_text is the text shown in the language selection combo.
  * session is the string stored in the session's language variable.
  * method is the string passed as the parameter of the method when language is changed.
  * php_file is the file that contains the PHP strings for the language.
  * js_file is the file that contains the JS strings for the language.
  */
$languages['english']['link_text'] = "In English";
$languages['english']['session'] = 'EN';
$languages['english']['method'] = "en";
$languages['english']['php_file'] = "language/en.inc.php";
$languages['finnish']['link_text'] = "Suomeksi";
$languages['finnish']['session'] = 'FI';
$languages['finnish']['method'] = "fi";
$languages['finnish']['php_file'] = "language/fi.inc.php";
$languages['french']['link_text'] = "En Fran&ccedil;ais";
$languages['french']['session'] = 'FR';
$languages['french']['method'] = "fr";
$languages['french']['php_file'] = "language/fr.inc.php";

/// Define a default language in case language handling fails.
define( "DS_DEFAULT_LANGUAGE", "english" );

/** Displays language selection combo box. Handling function is in languages.js.
  */
function show_language_menu( $current )
{

    global $languages;

    echo( "<form name='language'> \n" );
    echo( "<select size='1' name='languageSelect' id='language' onchange='languageSelectChange()'> \n" );

    foreach( $languages as $lang ) {
        if( $lang['session'] == $current ) {
            echo( "<option value='".$lang['method']."'>".$lang['link_text']."</option> \n" );
            break;
        }
    }

    foreach( $languages as $lang ) {
        if( $lang['session'] != $current ) {
            echo( "<option value='".$lang['method']."'>".$lang['link_text']."</option> \n" );
        }
    }

    echo( "</select> \n" );
    echo( "</form> \n" );

}

/** Sets the sessions language when user has selected a different language
  * from the language selection combo box.
  * @param language Selected language corresponding to 'method' in $languages.
  */
function set_language( $language ) 
{

    global $languages;

    foreach( $languages as $lang ) {
        if( $lang['method'] == $language ) {
            include_once( $lang['php_file'] );
            $_SESSION['ds_language'] = $lang['session'];
            return;
        }
    }

    // Use default if parameter was incorrect.
    include_once( $languages[DS_DEFAULT_LANGUAGE]['php_file'] );
    $_SESSION['ds_language'] = $languages[DS_DEFAULT_LANGUAGE]['session'];
    
}

/** Includes the correct PHP language file when pages are loaded. 
  * @param session Session's language corresponding to 'session' in $languages.
  */
function set_session_language( $session ) 
{

    global $languages;

    foreach( $languages as $lang ) {
        if( $lang['session'] == $session ) {
            include_once( $lang['php_file'] );
            return;
        }
    }

    // Use default if parameter was incorrect.
    include_once( $languages[DS_DEFAULT_LANGUAGE]['php_file'] );

}

?>
