<?php

/** Dunkkis Web User Interface, Dunkkis Server
  * ==========================================
  * Constant definitions
  * 
  * Copyright (c) 2009-2010 Nomovok Ltd
  * This software is licensed under The MIT License. See LICENSE for details.
  *
  * @author Nguyen Thanh Trung - nguyenthanh.trung@nomovok.com
  * @author Aki Honkasuo - aki.honkasuo@nomovok.com
  * @author Rami Erlin - rami.erlin@nomovok.com
  */

/**
 * Soap api specific constants
 */

define("DS_SOAP_API_VERSION",               2);

/**
 * Return values
 * These values are return values for Dunkkis
 * client application
 */

define("DS_RET_OK",                         0);
define("DS_RET_GENERIC_ERROR",              1);
define("DS_RET_TIME_OUT",                   2);
define("DS_RET_NO_NETWORK_CONNECTION",      3);
define("DS_RET_SERVER_BUSY",                4);
define("DS_RET_NOT_IMPLEMENTED",            5);
define("DS_RET_AUTHENTICATION_FAILED",      6);
define("DS_RET_PERMISSION_DENIED",          7);
define("DS_RET_INVALID_SOAP_MESSAGE",       8);
define("DS_RET_UNKNOWN_PROFILE",            9);
define("DS_RET_UNKNOWN_DEVICE",             10);
define("DS_RET_INTERVAL_NOT_SET",           11);
define("DS_RET_INVALID_INTERVAL",           12);
define("DS_RET_INVALID_TIME",               13);
define("DS_RET_UNKNOWN_SENSOR",             14);
define("DS_RET_DATA_CORRUPTED",             15);
define("DS_RET_NO_DATA_SAVED",              16);
define("DS_RET_NO_LOG_AVAILABLE",           17);
define("DS_RET_DEVICE_NOT_IN_PROFILE",      18);
define("DS_RET_EMPTY_PROFILE",              19);
define("DS_RET_INVALID_PROFILE_ACTION",     20);
define("DS_RET_DEVICE_ALREADY_IN_PROFILE",  21);
define("DS_RET_PROFILE_ALREADY_EXISTS",     22);

?>
