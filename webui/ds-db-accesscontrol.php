<?php

/** Dunkkis Web User Interface
  * ==========================
  * Access control database functions 
  *
  * Copyright (c) 2009-2010 Nomovok Ltd
  * This software is licensed under The MIT License. See LICENSE for details.
  *
  * @author Juha Hytonen - juha.hytonen@nomovok.com
  */

define( "DS_MNG_USER_ADMIN", 1 );
define( "DS_MNG_USER_ADMIN_UID", 1 );
define( "DS_MNG_USER_ACTIVE", 1 );

// Function return values.
define( "DS_MNG_USER_TOGGLE_ROLE_FAILED", 1 );
define( "DS_MNG_USER_TOGGLE_ROLE_SUCCESS", 2 );
define( "DS_MNG_USER_TOGGLE_STATUS_FAILED", 3 );
define( "DS_MNG_USER_TOGGLE_STATUS_SUCCESS", 4 );
define( "DS_MNG_USER_REMOVE_FAILED", 5 );
define( "DS_MNG_USER_REMOVE_SUCCESS", 6 );
define( "DS_MNG_USER_APPROVE_FAILED", 7 );
define( "DS_MNG_USER_APPROVE_SUCCESS", 8 );
define( "DS_MNG_USER_DECLINE_FAILED", 9 );
define( "DS_MNG_USER_DECLINE_SUCCESS", 10 );
define( "DS_MNG_USER_ACCOUNT_REMOVE_FAILED", 11 );
define( "DS_MNG_USER_ACCOUNT_CHANGEPW_FAILED", 12 );
define( "DS_MNG_USER_ACCOUNT_CHANGEPW_SUCCESS", 13 );
define( "DS_MNG_USER_LOGIN_FAILED_CREDENTIALS", 14 );
define( "DS_MNG_USER_LOGIN_FAILED_INACTIVE", 15 );
define( "DS_MNG_USER_LOGIN_FAILED", 16 );
define( "DS_MNG_USER_LOGIN_SUCCESS", 17 );

/** @brief Fetches all users from the database.
  * @return Array or users or 0 if no users found.
  *
  * Users are arranged so that admins come first, among admins and users
  * active users come first and then users are ordered alphabetically by email.
  */
function dbGetUsers() 
{

    $link = db_init();
    $query = "SELECT uid, email, createdate, lastlogindate, logincounts, status, role
              FROM user
              WHERE name != 'admin'
              ORDER BY role DESC, status DESC, email ASC;";
    $result = mysql_query( $query, $link ) 
              or die( DB_QUERY_ERROR.mysql_error()."<br />".$query );

    $users = array();
    if( mysql_num_rows( $result ) > 0 ) {
        while( $row = mysql_fetch_array( $result ) ) {
            array_push( $users, $row );
        }
    }

    mysql_close( $link );
    if( count( $users ) > 0 ) {
        return $users;
    }
    else {
        return 0;
    }

}

/** @brief Fetches all user account requests from the database.
  * @return Array or requests or 0 if no requests found.
  *
  * Requests are arranged oldest first.
  */
function dbGetAccountRequests()
{

    $link = db_init();
    $query = "SELECT * FROM userrequest ORDER BY requestdate ASC;";
    $result = mysql_query( $query, $link ) 
              or die( DB_QUERY_ERROR.mysql_error()."<br />".$query );

    $requests = array();
    if( mysql_num_rows( $result ) > 0 ) {
        while( $row = mysql_fetch_array( $result ) ) {
            array_push( $requests, $row );
        }
    }

    mysql_close( $link );
    if( count( $requests ) > 0 ) {
        return $requests;
    }
    else {
        return 0;
    }


}

/** @brief Toggles an user's status (active/inactive).
  * @param uid, (integer) User ID of the user, whose role is toggled.
  * @param userName, (string) User name of the current user (for priviledges check).
  * @return DS_MNG_USER_TOGGLE_STATUS_FAILED or DS_MNG_USER_TOGGLE_STATUS_SUCCESS.
  */
function dbToggleUserStatus( $uid )
{

    // Check that current user is admin and that user is not editing himself.
    $userUid = dbIsUserAdmin( $_SESSION['user'] );
    if( !$userUid || $userUid == $uid ) {
        return DS_MNG_USER_TOGGLE_STATUS_FAILED;
    }
    
    // Toggle status.
    $link = db_init();
    $query = "UPDATE user
              SET status = !status
              WHERE uid = ".$uid.";";
    $result = mysql_query( $query, $link ) 
              or die( DB_QUERY_ERROR.mysql_error()."<br />".$query );

    mysql_close( $link );
    return DS_MNG_USER_TOGGLE_STATUS_SUCCESS;

}


/** @brief Toggles an user's role (admin/user).
  * @param uid, (integer) User ID of the user, whose role is toggled.
  * @param userName, (string) User name of the current user (for priviledges check).
  * @return DS_MNG_USER_TOGGLE_ROLE_FAILED or DS_MNG_USER_TOGGLE_ROLE_SUCCESS.
  * @note Function may fail, if current user is not an administrator
  */
function dbToggleUserRole( $uid )
{

    // Check that current user is admin and that user is not editing himself.
    $userUid = dbIsUserAdmin( $_SESSION['user'] );
    if( !$userUid || $userUid == $uid ) {
        return DS_MNG_USER_TOGGLE_ROLE_FAILED;
    }
    
    // Toggle role.
    $link = db_init();
    $query = "UPDATE user
              SET role = !role
              WHERE uid = ".$uid.";";
    $result = mysql_query( $query, $link ) 
              or die( DB_QUERY_ERROR.mysql_error()."<br />".$query );

    mysql_close( $link );
    return DS_MNG_USER_TOGGLE_ROLE_SUCCESS;

}

/** @brief Removes the user and all associated data from the database.
  * @note Performed as a transaction.
  * @param uid, (integer) User id of the user to be removed.
  * @return DS_MNG_USER_REMOVE_FAILED or DS_MNG_USER_REMOVE_SUCCESS.
  */
function dbRemoveUser( $uid )
{

    // Admin cannot be removed.
    if( $uid == DS_MNG_USER_ADMIN_UID ) {
        return DS_MNG_USER_REMOVE_FAILED;
    }

    $link = dbStartTransaction();
    if( !$link ) {
        return DS_MNG_USER_REMOVE_FAILED;
    }

    /* Remove alarms. Associated actions, history entries, sensors and
     * triggers are removed automatically due to database collation rules.
     */
    $query = "DELETE FROM alarms WHERE uid=".$uid.";";
    if( !($result = mysql_query( $query, $link ) ) ) {
        dbRollbackTransaction( $link );
        return DS_MNG_USER_REMOVE_FAILED;
    }

    // Remove alarm contacts.
    $query = "DELETE FROM alarm_contacts WHERE uid=".$uid.";";
    if( !($result = mysql_query( $query, $link ) ) ) {
        dbRollbackTransaction( $link );
        return DS_MNG_USER_REMOVE_FAILED;
    }

    // Remove alarm schedules.
    $query = "DELETE FROM alarm_schedules WHERE uid=".$uid.";";
    if( !($result = mysql_query( $query, $link ) ) ) {
        dbRollbackTransaction( $link );
        return DS_MNG_USER_REMOVE_FAILED;
    }

    // Remove cameras.
    $query = "DELETE FROM camera WHERE uid=".$uid.";";
    if( !($result = mysql_query( $query, $link ) ) ) {
        dbRollbackTransaction( $link );
        return DS_MNG_USER_REMOVE_FAILED;
    }

    // Remove profiles. Associated devices and sensors are removed automatically.
    $query = "DELETE FROM profile WHERE userid=".$uid.";";
    if( !($result = mysql_query( $query, $link ) ) ) {
        dbRollbackTransaction( $link );
        return DS_MNG_USER_REMOVE_FAILED;
    }
    
    // Remove MAC devices.
    $query = "DELETE FROM dunkkisbox WHERE uid=".$uid.";";
    if( !($result = mysql_query( $query, $link ) ) ) {
        dbRollbackTransaction( $link );
        return DS_MNG_USER_REMOVE_FAILED;
    }

    // Remove user.
    $query = "DELETE FROM user WHERE uid=".$uid.";";
    if( !($result = mysql_query( $query, $link ) ) ) {
        dbRollbackTransaction( $link );
        return DS_MNG_USER_REMOVE_FAILED;
    }

    if( dbCommitTransaction( $link ) ) {
        return DS_MNG_USER_REMOVE_SUCCESS;
    }
    else {
        return DS_MNG_USER_REMOVE_FAILED;
    }

}

/** @brief Approves an user account request.
  * @param uid, User id (in userrequest table) of the approved user.
  * @return DS_MNG_USER_APPROVE_FAILED or DS_MNG_USER_APPROVE_SUCCESS.
  *
  * Removes the account request entry from the database and inserts are 
  * corresponding user. Inserts default MAC device and profile for the new
  * user. Operations are performed as a transaction.
  */
function dbApproveRequest( $uid ) 
{

    global $config;

    $link = dbStartTransaction();
    if( !$link ) {
        return DS_MNG_USER_APPROVE_FAILED;
    }

    // Fetch request from database.
    $query = "SELECT DISTINCT * FROM userrequest WHERE uid=".$uid.";";
    if( !($result = mysql_query( $query, $link ) ) ) {
        dbRollbackTransaction( $link );
        return DS_MNG_USER_APPROVE_FAILED;
    }
    $request = mysql_fetch_assoc( $result );

    // Delete request from database.
    $query = "DELETE FROM userrequest WHERE uid=".$uid.";";
    if( !($result = mysql_query( $query, $link ) ) ) {
        dbRollbackTransaction( $link );
        return DS_MNG_USER_APPROVE_FAILED;
    }

    // Insert user.
    $query = sprintf( "INSERT INTO user (name, password, email, createdate,
                                         lastlogindate, logincounts, status, role)
                       VALUES ('%s', '%s', '%s', CURDATE(), '%s', 0, 1, 0);",
                      mysql_real_escape_string( $request['name'] ),
                      mysql_real_escape_string( $request['password'] ),
                      mysql_real_escape_string( $request['email'] ),
                      mysql_real_escape_string( "0000-00-00" ) );
    if( !($result = mysql_query( $query, $link ) ) ) {
        dbRollbackTransaction( $link );
        return DS_MNG_USER_APPROVE_FAILED;
    }

    $userId = mysql_insert_id(); // User id of the added user, not request.

    // Insert default MAC device.
    $query = "INSERT INTO dunkkisbox(mac, name, uid)
              VALUES('".$config['test_macdevice_mac']."',
                     '".$config['test_macdevice_name']."', ".$userId.");";
    if( !($result = mysql_query( $query, $link ) ) ) {
        dbRollbackTransaction( $link );
        return DS_MNG_USER_APPROVE_FAILED;
    }

    // Insert default profile.
    $query = sprintf( "INSERT INTO profile(userid, name, password)
                       VALUES (".$userId.", '%s', '%s');",
                      mysql_real_escape_string( $config['test_profile_name'] ),
                      mysql_real_escape_string( sha1( $config['password_salt'].
                                                      $config['test_profile_password'] ) ) );
    if( !($result = mysql_query( $query, $link ) ) ) {
        dbRollbackTransaction( $link );
        return DS_MNG_USER_APPROVE_FAILED;
    }

    if( dbCommitTransaction( $link ) ) {
        return DS_MNG_USER_APPROVE_SUCCESS;
    }
    else {
        return DS_MNG_USER_APPROVE_FAILED;
    }

}

/** @brief Declines an user account request and removes it from the database.
  * @param uid, User id (in userrequest table) of the declined user.
  * @return DS_MNG_USER_DECLINE_FAILED or DS_MNG_USER_DECLINE_SUCCESS.
  */
function dbDeclineRequest( $uid )
{

    $link = db_init();
    $query = "DELETE FROM userrequest WHERE uid = ".$uid.";";
    
    if( mysql_query( $query, $link ) ) {
        mysql_close( $link );
        return DS_MNG_USER_DECLINE_SUCCESS;
    }
    else {
        mysql_close( $link );
        return DS_MNG_USER_DECLINE_FAILED;
    }

}

/** @brief Changes a password for user.
  * @param uid, (integer) The user's user id.
  * @param newPassword, (string) The new password.
  * @return DS_MNG_USER_ACCOUNT_CHANGEPW_FAILED or DS_MNG_USER_ACCOUNT_CHANGEPW_SUCCESS.
  */
function dbChangePassword( $uid, $newPassword )
{

    $link = db_init();
    $query = sprintf( "UPDATE user
                       SET password = '%s'
                       WHERE uid = ".$uid.";",
                       mysql_real_escape_string( $newPassword ) );
    if( mysql_query( $query, $link ) ) {
        mysql_close( $link );
        return DS_MNG_USER_ACCOUNT_CHANGEPW_SUCCESS;
    }
    else {
        mysql_close( $link );
        return DS_MNG_USER_ACCOUNT_CHANGEPW_FAILED;
    }

}

/** @brief Updates login statistics when user is logged in.
  * @param uid, (integer) User id of the user.
  * @return DS_MNG_USER_LOGIN_SUCCESS or DS_MNG_USER_LOGIN_FAILED.
  */
function dbLogin( $uid ) 
{

    $link = dbStartTransaction();
    if( !$link ) {
        return DS_MNG_USER_LOGIN_FAILED;
    }

    // Increase login count.
    $query = "UPDATE user SET logincounts = logincounts + 1 WHERE uid = ".$uid.";";
    if( !($result = mysql_query( $query, $link ) ) ) {
        dbRollbackTransaction( $link );
        return DS_MNG_USER_LOGIN_FAILED;
    }

    // Change last login date.
    $query = "UPDATE user SET lastlogindate  = NOW() WHERE uid = ".$uid.";";
    if( !($result = mysql_query( $query, $link ) ) ) {
        dbRollbackTransaction( $link );
        return DS_MNG_USER_LOGIN_FAILED;
    }

    if( dbCommitTransaction( $link ) ) {
        return DS_MNG_USER_LOGIN_SUCCESS;
    }
    else {
        return DS_MNG_USER_LOGIN_FAILED;
    }

}

/** @brief Returns the password for given user.
  * @param user, (string) User name of the user.
  * @param uid, (integer) User id of the user, used instead of "user" if given.
  * @return (string) The password.
  */
function dbGetPassword( $user, $uid = Null )
{

    // Decide, whether to check based on user name or uid.
    $field = ( $uid == Null ) ? "name" : "uid";
    $value = ( $uid == Null ) ? "'".$user."'" : $uid;

    $link = db_init();
    $query = "SELECT password FROM user WHERE ".$field." = ".$value.";";
    $result = mysql_query( $query, $link ) 
              or die( DB_QUERY_ERROR.mysql_error()."<br />".$query );
    
    $row = mysql_fetch_assoc( $result );
    mysql_close( $link );
    return $row['password'];

}

/** @brief Checks if given user is an administrator.
  * @param userName, (string) User name of the user.
  * @return (integer/boolean) User id of the user, if user was an administrator
  *         or false if not.
  */
function dbIsUserAdmin( $userName )
{

    $link = db_init();
    $query = "SELECT uid, role 
              FROM user
              WHERE name = '".$userName."';";
    $result = mysql_query( $query, $link ) 
              or die( DB_QUERY_ERROR.mysql_error()."<br />".$query );
    
    $row = mysql_fetch_assoc( $result );
    mysql_close( $link );
    if( $row['role'] == DS_MNG_USER_ADMIN ) {
        return $row['uid'];
    }
    else {
        return false;
    }

}

/** @brief Checks if account of given user is active.
  * @param userName, (string) User name of the user.
  * @return (integer/boolean) User id of the user, if account was active
  *         or false if not.
  */
function dbIsUserActive( $userName )
{

    $link = db_init();
    $query = "SELECT uid, status 
              FROM user
              WHERE name = '".$userName."';";
    $result = mysql_query( $query, $link ) 
              or die( DB_QUERY_ERROR.mysql_error()."<br />".$query );
    
    $row = mysql_fetch_assoc( $result );
    mysql_close( $link );
    if( $row['status'] == DS_MNG_USER_ACTIVE ) {
        return $row['uid'];
    }
    else {
        return false;
    }

}

/** @brief Starts a databse transaction.
  * @return A database connection object.
  */
function dbStartTransaction() 
{

    $link = db_init();
    if( !mysql_query("START TRANSACTION;", $link ) ) {
        mysql_close( $link );
        return false;
    }
    else {
        return $link;
    }

}

/** @brief Commits a database trasaction.
  * @param link, (object) Database connection object.
  * @return (boolean) True if successful, false otherwise.
  * @note Closes the database connection.
  */
function dbCommitTransaction( $link )
{

    if( !mysql_query( "COMMIT;", $link ) ) {
        mysql_close( $link );
        return false;
    }
    else {
        mysql_close( $link );
        return true;
    }

}

/** @brief Rolls back a database transaction.
  * @param link, (object) Database connection object.
  * @note Closes the database connection.
  */
function dbRollbackTransaction( $link )
{

    mysql_query( "ROLLBACK;", $link )
        or die( DB_QUERY_ERROR.mysql_error()."<br />".$query );
    mysql_close( $link );

}

?>
