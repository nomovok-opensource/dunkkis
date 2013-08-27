/** Dunkkis Web User Interface
  * ==========================
  * 
  * Copyright (c) 2009-2010 Nomovok Ltd
  * This software is licensed under The MIT License. See LICENSE for details.
  *
  * @author Juha Hytonen - juha.hytonen@nomovok.com
  */

function showMessageBox( id, show )
{

    if( show ) {
        document.getElementById(id).style.display = "block";
    }
    else {
        document.getElementById(id).style.display = "none";
    }

}

