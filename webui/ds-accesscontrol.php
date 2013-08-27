<?php

/** Dunkkis Web User Interface
  * ==========================
  * Access control functions 
  *
  * Copyright (c) 2009-2010 Nomovok Ltd
  * This software is licensed under The MIT License. See LICENSE for details.
  *
  * @author Juha Hytonen - juha.hytonen@nomovok.com
  */

include_once( "ds-db-accesscontrol.php" );

define( "DS_MNG_USER_APPROVE_NOTIFICATION", false ); // Not sending notifications ATM.
define( "DS_MNG_USER_APPROVE_NOTIFICATION_SUBJECT", "Dunkkis.org account approval" );
define( "DS_MNG_USER_APPROVE_NOTIFICATION_MESSAGE", "You account request has been approved. Browse to https://myhome.nomovok.info to login to your new account. We will not guarantee preservation of any data in the application. All rights reserved." );
define( "DS_MNG_USER_DECLINE_NOTIFICATION", false ); // Not sending notifications ATM.
define( "DS_MNG_USER_DECLINE_NOTIFICATION_SUBJECT", "Dunkkis.org account approval" );
define( "DS_MNG_USER_DECLINE_NOTIFICATION_MESSAGE", "We are sorry to inform you that your account request has been rejected. Please contact the project administrators for more information, if needed." );

// Method names.
define( "DS_MNG_USER_USERS", "usermanagement_main" );
define( "DS_MNG_USER_TOGGLE_ROLE", "togglerole" );
define( "DS_MNG_USER_TOGGLE_STATUS", "togglestatus" );
define( "DS_MNG_USER_REMOVE_CONFIRM", "removeconfirm" );
define( "DS_MNG_USER_REMOVE", "removeuser" );
define( "DS_MNG_USER_REQUESTS", "requestmanagement_main" );
define( "DS_MNG_USER_APPROVE_REQUEST", "acceptrequest" );
define( "DS_MNG_USER_DECLINE_REQUEST", "declinerequest" );
define( "DS_MNG_USER_ACCOUNT", "account" );
define( "DS_MNG_USER_ACCOUNT_CHANGEPW", "changepw" );
define( "DS_MNG_USER_ACCOUNT_REMOVE_CONFIRM", "removeaccconf" );
define( "DS_MNG_USER_ACCOUNT_REMOVE", "removeacc" );
define( "DS_MNG_USER_LOGIN", "login" );

/** @brief Shows the "User management" page.
  * @param $status (constant), Status of the latest operation (if any).
  * @return XHTML.
  *
  * Contains a list of users in the system and admin actions for them.
  */
function userManagementPage( $status = Null ) 
{

    // Print status message, if any.
    $content = statusMessage( $status );

    $users = dbGetUsers();

    if( count( $users ) == 0 ) {
        return $content;
    }

    $content .= "<table class='DunkkisTable'>";
    $content .= "<tr class='Header'> 
                 <th>".DS_STRING_USER_EMAIL_ADDRESS."</th>
                 <th>".DS_STRING_USER_ACCOUNT_CREATED."</th>
                 <th>".DS_STRING_USER_LAST_LOGIN."</th>
                 <th>".DS_STRING_USER_VISITS."</th>
                 <th>".DS_STRING_USER_STATUS."</th>
                 <th>".DS_STRING_USER_ROLE."</th>
                 <th colspan='3'>".DS_STRING_USER_MANAGE."</th>
                 </tr> ";

    // Administrator.
    $content .= "<tr class='OddRow'><td>admin</td><td>&nbsp;</td><td>&nbsp;</td>
                 <td>&nbsp;</td><td>".DS_STRING_USER_ACTIVE."</td>
                 <td>".DS_STRING_USER_ADMIN."</td><td colspan='3'>&nbsp;</td></tr>";

    $row = 2; // Start at 2 because of administrator's row.
    if( $users ) foreach( $users as $user ) {

        /* Define outputted texts depending on user status (active/inactive)
         * and role (administrator/user).
         */
        $status = ( $user['status'] == 1 ) ? DS_STRING_USER_ACTIVE : DS_STRING_USER_INACTIVE;
        $role = ( $user['role'] == 1 ) ? DS_STRING_USER_ADMIN : DS_STRING_USER_USER;
        
        // Define row style depending on whether the row is even or odd.
        $content .= ( $row % 2 == 1 ) ? "<tr class='OddRow'>" : "<tr class='EvenRow'>";
        $content .= "<td class='Data'>".$user['email']."</td>
                     <td class='Data'>".$user['createdate']."</td>
                     <td class='Data'>".$user['lastlogindate']."</td>
                     <td class='Data'>".$user['logincounts']."</td>
                     <td class='Data'>".$status."</td>
                     <td class='Data'>".$role."</td>";

        // User management buttons.
        $content .= "<td class='Manage'>";
        $content .= manageButton( ( $user['status'] == 1 ) ? DS_STRING_USER_INACTIVATE : DS_STRING_USER_ACTIVATE,
                                  DS_MNG_USER_TOGGLE_STATUS, 
                                  "uid", $user['uid'] );
        $content .= "</td><td class='Manage'>";
        $content .= manageButton( ( $user['role'] == 1 ) ? DS_STRING_USER_USERIZE : DS_STRING_USER_ADMINIZE,
                                  DS_MNG_USER_TOGGLE_ROLE, 
                                  "uid", $user['uid'] );
        $content .= "</td><td class='Manage'>";
        $content .= manageButton( DS_STRING_USER_REMOVE,
                                  DS_MNG_USER_REMOVE_CONFIRM,
                                  "uid", $user['uid'] );
        $content .= "</td></tr>";

        $row++;

    }

    $content .= "</table><br />";
    $content .= "<a href='demo.php?method=".DS_MNG_USER_REQUESTS."'>".DS_STRING_USER_MANAGE_REQUESTS."</a>";

    return $content;

}

/** @brief Shows the "Account request management" page.
  * @param $status (constant), Status of the latest operation (if any).
  * @return XHTML.
  *
  * Lists active account requests (if any) and makes it possible to approve
  * or decline them.
  */
function accountRequestsPage( $status = Null ) 
{

    // Print status message, if any.
    $content = statusMessage( $status );

    $requests = dbGetAccountRequests();

    if( $requests ) {

        $content .= "<table class='DunkkisTable'>";
        $content .= "<tr class='Header'> 
                     <th>".DS_STRING_USER_EMAIL_ADDRESS."</th>
                     <th>".DS_STRING_USER_REQUEST_DATE."</th>
                     <th>".DS_STRING_USER_REQUEST_REASON."</th>
                     <th colspan='2'>".DS_STRING_USER_MANAGE."</th>
                     </tr> ";

        $row = 1; 
        foreach( $requests as $request ) {
            
            // Define row style depending on whether the row is even or odd.
            $content .= ( $row % 2 == 1 ) ? "<tr class='OddRow'>" : "<tr class='EvenRow'>";
            $content .= "<td class='Data'>".$request['email']."</td>
                         <td class='Data'>".$request['requestdate']."</td>
                         <td class='Data'>".$request['text']."</td>";

            // Approve button.
            $content .= "<td class='Manage'>";
            $content .= manageButton( DS_STRING_USER_APPROVE_REQUEST,
                                      DS_MNG_USER_APPROVE_REQUEST, 
                                      "uid", $request['uid'],
                                      "email", $request['email'] );
            $content .= "</td><td class='Manage'>";
            $content .= manageButton( DS_STRING_USER_DECLINE_REQUEST,
                                      DS_MNG_USER_DECLINE_REQUEST_CONFIRM, 
                                      "uid", $request['uid'],
                                      "email", $request['email'] );
            $content .= "</td></tr>";

            $row++;

        }

        $content .= "</table>";

    }
    else {
        $content .= "<p>".DS_STRING_USER_NO_REQUESTS."</p>";
    }

    $content .= "<br /><a href='demo.php?method=".DS_MNG_USER_USERS."'>".DS_STRING_USR_MNG_USERS."</a>";

    return $content;

}

/** @brief Shows the "My Account" page.
  * @param $status (constant), Status of the latest operation (if any).
  * @return XHTML.
  *
  * Contains the possibility the change the user's password or to remove
  * the account.
  */
function myAccountPage( $status = Null )
{

    // Print status message, if any.
    $content = statusMessage( $status );

    $content .= "<h4 class='DunkkisHeading'>".DS_STRING_USER_CHANGE_PASSWORD_CAPTION."</h4>";
    $content .= "<form name='".DS_MNG_USER_ACCOUNT_CHANGEPW."' method='post' action='demo.php'>
                 <input type='hidden' name='method' value='".DS_MNG_USER_ACCOUNT_CHANGEPW."' /> 
                 <table class='DunkkisForm'>
                 <tr><td>".DS_STRING_USER_CURRENT_PASSWORD."</td>
                 <td><input name='currentpwd' type='password' size='26' /></td></tr>
                 <tr><td>".DS_STRING_USER_NEW_PASSWORD."</td>
                 <td><input name='newpwd' type='password' size='26' /></td></tr>
                 <tr><td>".DS_STRING_USER_CONFIRM_PASSWORD."</td>
                 <td><input name='confirmpwd' type='password' size='26' /></td></tr>
                 <tr><td>&nbsp;</td><td>
                 <input type='submit' value='".DS_STRING_USER_CHANGE_PASSWORD."' />
                 </td></tr></table></form><br />";

    $content .= "<h4 class='DunkkisHeading'>".DS_STRING_USER_ACCOUNT_REMOVE_CAPTION."</h4>";
    $content .= "<form name='".DS_MNG_USER_ACCOUNT_REMOVE_CONFIRM."' method='post' action='demo.php'>
                 <input type='hidden' name='method' value='".DS_MNG_USER_ACCOUNT_REMOVE_CONFIRM."' /> 
                 <input type='submit' value='".DS_STRING_USER_ACCOUNT_REMOVE."' /></form>";

    return $content;

}

/** @brief Shows the login page.
  * @param $status (constant), Status of the latest operation (if any).
  * @return XHTML.
  */
function loginPage( $status = Null ) 
{

    $content = ""; // Result variable.

    $content .= "<div class='Login'>
                 <form name='".DS_MNG_USER_LOGIN."' method='post' action='demo.php'> 
                 <input type='hidden' name='method' value='".DS_MNG_USER_LOGIN."' />";

    // Print status message, if any.
    $content .= statusMessage( $status );

    $content .= "<img src='images/dunkkis_login_screen.png' alt='Dunkkis.org' class='Image' />
                 <table class='Form'>
                 <tr><td colspan='2'>&nbsp;</td></tr>
                 <tr>
                 <td class='Caption'>".DS_STRING_USER_LOGIN_USERNAME."</td> 
                 <td class='Field'><input name='user' type='text' size='26' /></td>
                 </tr><tr>
                 <td class='Caption'>".DS_STRING_USER_LOGIN_PASSWORD."</td>
                 <td class='Field'><input name='password' type='password' size='26' /></td>
                 </tr><tr>
                 <td class='Caption'>&nbsp;</td>
                 <td class='Field'><input type='checkbox' name='simplelayout' />".DS_STRING_USER_LOGIN_MOBILE_LAYOUT."</td>
                 </tr><tr>
                 <td class='Caption'>&nbsp;</td>
                 <td class='Field'><input type='submit' value='".DS_STRING_USER_LOGIN_LOGIN."' /></td>
                 <tr><td colspan='2'>&nbsp;</td></tr>
                 <tr><td colspan='2' class='Footer'>"
                 .DS_STRING_USER_LOGIN_TEASER." <a href='ds-registration.php'>".DS_STRING_USER_LOGIN_REGISTER."</a>
                 </td></tr>
                 </form></div>";

    return $content;

}

/** @brief Returns a status message corresponding the given function response.
  * @param status, (constant) The response.
  * @return XHTML.
  */
function statusMessage( $status ) 
{

    $msg = ""; // Result variable.

    if( $status == Null ) {
        return $msg;
    }

    switch( $status ) {
    
        case DS_MNG_USER_TOGGLE_ROLE_FAILED: {
            $msg .= "<div class='DunkkisError'>".DS_STRING_USER_TOGGLE_ROLE_FAILED."</div>";
            break;
        }
        case DS_MNG_USER_TOGGLE_ROLE_SUCCESS: {
            $msg .= "<div class='DunkkisSuccess'>".DS_STRING_USER_TOGGLE_ROLE_SUCCESS."</div>";
            break;
        }
        case DS_MNG_USER_TOGGLE_STATUS_FAILED: {
            $msg .= "<div class='DunkkisError'>".DS_STRING_USER_TOGGLE_STATUS_FAILED."</div>";
            break;
        }
        case DS_MNG_USER_TOGGLE_STATUS_SUCCESS: {
            $msg .= "<div class='DunkkisSuccess'>".DS_STRING_USER_TOGGLE_STATUS_SUCCESS."</div>";
            break;
        }
        case DS_MNG_USER_REMOVE_FAILED: {
            $msg .= "<div class='DunkkisError'>".DS_STRING_USER_REMOVE_FAILED."</div>";
            break;
        }
        case DS_MNG_USER_REMOVE_SUCCESS: {
            $msg .= "<div class='DunkkisSuccess'>".DS_STRING_USER_REMOVE_SUCCESS."</div>";
            break;
        }
        case DS_MNG_USER_APPROVE_FAILED: {
            $msg .= "<div class='DunkkisError'>".DS_STRING_USER_APPROVE_FAILED."</div>";
            break;
        }
        case DS_MNG_USER_APPROVE_SUCCESS: {
            $msg .= "<div class='DunkkisSuccess'>".DS_STRING_USER_APPROVE_SUCCESS."</div>";
            break;
        }
        case DS_MNG_USER_DECLINE_FAILED: {
            $msg .= "<div class='DunkkisError'>".DS_STRING_USER_DECLINE_FAILED."</div>";
            break;
        }
        case DS_MNG_USER_DECLINE_SUCCESS: {
            $msg .= "<div class='DunkkisSuccess'>".DS_STRING_USER_DECLINE_SUCCESS."</div>";
            break;
        }
        case DS_MNG_USER_ACCOUNT_REMOVE_FAILED: {
            $msg .= "<div class='DunkkisError'>".DS_STRING_USER_ACCOUNT_REMOVE_FAILED."</div>";
            break;
        }
        case DS_MNG_USER_ACCOUNT_CHANGEPW_FAILED: {
            $msg .= "<div class='DunkkisError'>".DS_STRING_USER_ACCOUNT_CHANGEPW_FAILED."</div>";
            break;
        }
        case DS_MNG_USER_ACCOUNT_CHANGEPW_SUCCESS: {
            $msg .= "<div class='DunkkisSuccess'>".DS_STRING_USER_ACCOUNT_CHANGEPW_SUCCESS."</div>";
            break;
        }
        case DS_MNG_USER_LOGIN_FAILED_CREDENTIALS: {
            $msg .= "<div class='LoginError'>".DS_STRING_USER_LOGIN_FAILED_CREDENTIALS."</div>";
            break;
        }
        case DS_MNG_USER_LOGIN_FAILED_INACTIVE: {
            $msg .= "<div class='LoginError'>".DS_STRING_USER_LOGIN_FAILED_INACTIVE."</div>";
            break;
        }
        case DS_MNG_USER_LOGIN_FAILED: {
            $msg .= "<div class='LoginError'>".DS_STRING_USER_LOGIN_FAILED."</div>";
            break;
        }
        default: {
            $msg .= "<div class='DunkkisError'>".DS_STRING_USER_SYSTEM_ERROR."</div>";
            break;
        }

    }

    $msg .= "<br />";
    return $msg;

}

/** @brief Shows a confirmation for removing an user.
  * @param uid, (integer) User id of the user.
  * @param removeSelf, (boolean) Whether the user is removing himself (true)
  *                    or if an administrator is removing an user (false). This
  *                    affects the confirmation message.
  * @return XHTML.
  */
function userRemoveConfirmation( $uid, $removeSelf = false )
{

    $confirmation = ($removeSelf) ? DS_STRING_USER_ACCOUNT_REMOVE_CONFIRM : DS_STRING_USER_REMOVE_CONFIRM;
    $method = ($removeSelf) ? DS_MNG_USER_ACCOUNT_REMOVE : DS_MNG_USER_REMOVE;
    $target = ($removeSelf) ? DS_MNG_USER_ACCOUNT : DS_MNG_USER_USERS;

    return confirmation( $confirmation, $method, $target, "uid", $uid );

}

/** @brief Shows a confirmation for declining an account request.
  * @param uid, (integer) User id of the requester.
  * @return XHTML
  */
function requestDeclineConfirmation( $uid )
{

    return confirmation( DS_STRING_USER_DECLINE_CONFIRM,
                         DS_MNG_USER_DECLINE_REQUEST,
                         DS_MNG_USER_REQUESTS,
                         "uid", $uid );

}

/** @brief Checks if given passwords matches given user's password.
  * @param user, (string) User name of the user.
  * @param password, (string) Given password.
  * @param uid, (integer) User id of the user. Used instead of "user" if given.
  * @return (boolean) True if password matches, false otherwise.
  */
function validPassword( $user, $password, $uid = Null )
{

    global $config;
    $passwd = $password;    

    // Check, if using encrypted passwords.
    if( strcmp( $config['crypt_passwd'], "TRUE" ) ) {
        $passwd = sha1( $config['password_salt'].$password );
    }

    // Compare password to database.
    if( dbGetPassword( $user, $uid ) == $passwd ) {
        return true;
    }
    else {
        return false;
    }

}

/** @brief Approve an account request.
  * @param uid, (integer) User id of the requester.
  * @param email, (string) E-mail address requester.
  * @return DS_MNG_USER_APPROVE_FAILED or DS_MNG_USER_APPROVE_SUCCESS.
  *
  * Removes request from database, creates a new user with default settings
  * and sends a notification, if so defined.
  */
function approveRequest( $uid, $email )
{

    // Accept request.
    if( dbApproveRequest( $uid ) == DS_MNG_USER_APPROVE_FAILED ) {
        return DS_MNG_USER_APPROVE_FAILED;
    }

    // Send notification e-mail?
    if( DS_MNG_USER_APPROVE_NOTIFICATION ) {
        mail( $email, 
              DS_MNG_USER_APPROVE_NOTIFICATION_SUBJECT, 
              DS_MNG_USER_APPROVE_NOTIFICATION_MESSAGE );
    }

    return DS_MNG_USER_APPROVE_SUCCESS;

}

/** @brief Decline an account request.
  * @param uid, (integer) User id of the requester.
  * @param email, (string) E-mail address requester.
  * @return DS_MNG_USER_DECLINE_FAILED or DS_MNG_USER_DECLINE_SUCCESS.
  *
  * Removes request from database and sends a notification, if so defined.
  */
function declineRequest( $uid, $email )
{

    // Decline request.
    if( dbDeclineRequest( $uid ) == DS_MNG_USER_DECLINE_FAILED ) {
        return DS_MNG_USER_DECLINE_FAILED;
    }

    // Send notification e-mail?
    if( DS_MNG_USER_DECLINE_NOTIFICATION ) {
        mail( $email, 
              DS_MNG_USER_DECLINE_NOTIFICATION_SUBJECT, 
              DS_MNG_USER_DECLINE_NOTIFICATION_MESSAGE );
    }

    return DS_MNG_USER_DECLINE_SUCCESS;

}

/** @brief Change user's password.
  * @param uid, (integer) User id of the user.
  * @param currentPwd, (string) Current password.
  * @param newPwd, (string) New password.
  * @param confirmPwd, (string) New password confirmation.
  * @return DS_MNG_USER_ACCOUNT_CHANGEPW_FAILED or DS_MNG_USER_ACCOUNT_CHANGEPW_SUCCESS.
  *
  * Checks that current password matches, that new password and confirmation
  * are equal and that new password meets requirements.
  */
function changePassword( $uid, $currentPwd, $newPwd, $confirmPwd )
{

    global $config;
    $password = $newPwd;

    /* Check that current password is correct, that given new password
     * and confirmation match and that given new password meets requirements.
     */
    if( !validPassword( Null, $currentPwd, $uid ) ||
        strcmp( $newPwd, $confirmPwd ) != 0 ||
        !isPWRequestValid( $newPwd ) ) {
        return DS_MNG_USER_ACCOUNT_CHANGEPW_FAILED;
    }

    // Check, if using encrypted passwords.
    if( strcmp( $config['crypt_passwd'], "TRUE" ) ) {
        $password = sha1( $config['password_salt'].$newPwd );
    }

    return dbChangePassword( $uid, $password );

}

/** @brief Log given user into system.
  * @param user, (string) User name of user.
  * @param password, (string) Password of user.
  * @return DS_MNG_USER_LOGIN_SUCCESS if successful.
  *
  * Checks that password is correct and that user account is active. Logs user
  * into system and updates statistics.
  */
function login( $user, $password )
{

    // Check that password is correct.
    if( !validPassword( $user, $password ) ) {
        return DS_MNG_USER_LOGIN_FAILED_CREDENTIALS;
    }

    // Check that user is not blocked.
    $userId = dbIsUserActive( $user );
    if( !$userId ) {
        return DS_MNG_USER_LOGIN_FAILED_INACTIVE;
    }

    // Try to log user in and update statistics.
    if( dbLogin( $userId ) == DS_MNG_USER_LOGIN_FAILED ) {
        return DS_MNG_USER_LOGIN_FAILED;
    }

    // Initialize session variables.
    $_SESSION['login'] = true;
    $_SESSION['user'] = $user;
    $_SESSION['userid'] = $userId;

    return DS_MNG_USER_LOGIN_SUCCESS;

}

/**
 * admin_main_menu
 * Generates the administrator menu.
 * @return Returns the HTML generated.
 * @author Lars Ottesen - lars.ottesen@nomovok.com
 */
function admin_main_menu() //Links that are shown after "admin" link is selected on the leftmost menu.
{
	$content .= "<table class='contentpaneopen'>";
	$content .= "<ul id=\"adm_menu\">";
	$content .= "<li><a href=\"demo.php?method=usermanagement_main\">".DS_STRING_USR_MNG_USER_MANAGEMENT."</a></li>";
	$content .= "<li><a href=\"demo.php?method=requestmanagement_main\">".DS_STRING_USR_MNG_PENDING_REQ_MANAGEMENT."</a></li>";
	$content .= "</ul>";
	$content .= "</table>";
	return $content;
}

?>
