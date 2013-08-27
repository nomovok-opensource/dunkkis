<?php

/** Dunkkis Web User Interface
  * ==========================
  * 
  * Copyright (c) 2009-2010 Nomovok Ltd
  * This software is licensed under The MIT License. See LICENSE for details.
  */


    /*This script validates the input given by user registration 
    form using build-in filter function and regexps. Validation is based on these facts:
    -username can be email address.
    -reason, why user needs the account must have at least two words 
    -user is not allowed to enter malicious code in
    the fields (SQL queries etc.)*/
    
/** Check if e-mail address is valid and unique.
  * @author Juha Hytonen - juha.hytonen@nomovok.com
  * @date 7.12.2009
  * @param $email Address to be checked.
  * @return 0 if valid, 1 if invalid, 2 if not unique
 */

function isEmailValid($email) {
	if((!filter_var($email, FILTER_VALIDATE_EMAIL))) return 1;
	if(db_user_exists($email)) return 2;
	return eregi('[^a-z0-9_@-\.]', $email) ? 1 : 0;
}


function isPWRequestValid($pwreq) {
		return ereg("^[a-zA-Z0-9_]{6,80}$",$pwreq) ? 1 : 0;
}



/**
 * Check if string is a valid registration reason text. It must contain at least two words.
 * @param $reason String address to be checked.
 * @return True if valid, false otherwise.
 */
   
function isReasonValid ($reason) {

    return ereg('[ ]', $reason) ? true : false;
}


/**
 * Check if user submitted data is valid.
 * 
 * @param $email user-given e-mail address.
 * @param $pwreq user-give password.
 * @param $reason user-given reason.
 * @return $errors Array containing results for specific tests and general OK.
 *
 * Revised 7.12.2009 by Juha Hytonen - juha.hytonen@nomovok.com
 */
function validate_registration($email,$pwreq, $reason){
	$errors = array("username" => 0, "email" => false, "pwreq" => false, "reason"  => false, "ok" => true);
	
	
    $rv = isEmailValid($email); //0=OK, 1=invalid, 2=in use 
	if ($rv) {
		$errors["ok"] = false;
		$errors["email"] = $rv;
	}
	
	if (!isReasonValid($reason)) {
		$errors["ok"] = false;
		$errors["reason"] = true;
	}

	if (!isPWRequestValid($pwreq)) {
		$errors["ok"] = false;
		$errors["pwreq"] = true;
	}
	return $errors;	
}
?>
