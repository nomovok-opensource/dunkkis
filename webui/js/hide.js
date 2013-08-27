/** Dunkkis Web User Interface
  * ==========================
  * 
  * Copyright (c) 2009-2010 Nomovok Ltd
  * This software is licensed under The MIT License. See LICENSE for details.
  */


function unhide(divID) {
  var item = document.getElementById(divID);
  if (item) {
    item.className=(item.className=='hidden')?'unhidden':'hidden';
  }
}
