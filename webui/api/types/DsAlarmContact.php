<?php

/** Dunkkis Server
  * ==============
  * 
  * Copyright (c) 2009-2010 Nomovok Ltd
  * This software is licensed under The MIT License. See LICENSE for details.
  *
  * @author Juha Hytonen - juha.hytonen@nomovok.com
  */

/** @brief Alarm contact entry.
  *
  * Contains the alarm contact's id, name, email, phone number, the id of the
  * user that created the contact, date when the contact was created and the
  * number of times the user has been sent an alert.
  */
class DsAlarmContact 
{

    var $id;                    ///< Id of the contact.
    var $uid;                   ///< Id of the user, who created the contact.
    var $name;                  ///< Name of the contact.
    var $email;                 ///< E-mail address of the contact.
    var $phone;                 ///< Phone number of the contact.
    var $dateCreated;           ///< Date when contact was created.
    var $triggerCount;          ///< Times the contact has been alerted.

    public function __construct( $id, $uid, 
                                 $name = Null, $email = Null, $phone = Null,
                                 $dateCreated = Null, $triggerCount = Null ) 
    {

        $this->id = $id;
        $this->uid = $uid;
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->dateCreated = $dateCreated;
        $this->triggerCount = $triggerCount;

    }

}
