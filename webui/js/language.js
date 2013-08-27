/** Dunkkis Web User Interface
  * ==========================
  * Language switching functionality
  * 
  * Copyright (c) 2009-2010 Nomovok Ltd
  * This software is licensed under The MIT License. See LICENSE for details.
  *
  * @author Juha Hytonen - juha.hytonen@nomovok.com
  */

/** Invoke a change of language when the language combo box selection changes.
  */
function languageSelectChange()
{

    var selectedLanguage = document.language.languageSelect.value;
    window.location = "?method=language&language=" + selectedLanguage;

}
