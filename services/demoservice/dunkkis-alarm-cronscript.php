#!/usr/bin/php -q

<?php

/** Dunkkis Server
  * ==============
  * Alarm queue cronscript
  * 
  * Copyright (c) 2009-2010 Nomovok Ltd
  * This software is licensed under The MIT License. See LICENSE for details.
  *
  * @author Juha Hytonen - juha.hytonen@nomovok.com
  * Some code courtesy of Lars Kinnunen - lars.kinnunen@nomovok.com
  */

require_once( "dunkkis-alarm-common.php" );
require_once( "dunkkis-alarm-db.php" );

/// Print debug messages?
define( "DS_ALARM_DEBUG", true );

/** Alerts a contact of an alarm by email.
  * @param email The contact's email address.
  * @param subject Subject of the message.
  * @param message The message body.
  */
function alert_contact_by_email( $email, $subject, $message ) 
{

    // Do nothing ATM.

    if( DS_ALARM_DEBUG ) {
        echo( "Sent mail to $email.\n" );
    }

}

/** Alerts a contact of an alarm by SMS.
  * @param phone The contact's phone number.
  * @param message The message body.
  */
function alert_contact_by_sms( $phone, $message ) 
{

    // Do nothing ATM.
    
    if( DS_ALARM_DEBUG ) {
        echo( "Sent a SMS to $phone.\n" );
    }

}

/** Alerts contacts of an alarm.
  * @param alarmid ID of the alarm, of which to alert.
  */
function alert_contacts( $alarmid )
{

    $alert = db_get_field( "alert", "alarms", "id", $alarmid );
    $short_msg = db_get_field( "small_message", "alarms", "id", $alarmid );
    $long_msg = db_get_field( "long_message", "alarms", "id", $alarmid );

    // Get contacts for alarm. If there aren't any, leave.
    $contacts = db_get_alarm_contacts( $alarmid );
    if( $contacts == 0 ) {
        
        if( DS_ALARM_DEBUG ) {
            echo( "No contacts associated with alarm.\n" );
        }

        return;

    }

    // Set contact_type based on alert. Empty contact type means that all
    // contacts are notified ($alert=='all').
    $contact_type = "all";
    if( $alert == "email" || $alert == "email_composite" ) {
        $contact_type = "email";
    }
    elseif( $alert == "sms" || $alert == "sms_composite" ) {
        $contact_type = "sms";
    }

    foreach( $contacts as $contact ) {

        // Alert contact if the contact's and alarm's contact types match.
        if( ($contact_type == $contact['type']) || $contact_type == "all" ) {

            // Alert by SMS.
            if( $contact['type'] == "sms" ) {
                alert_contact_by_sms( $contact['phone'], $short_msg );
            }

            // Alert by email.
            if( $contact['type'] == "email" ) {
                alert_contact_by_email( $contact['email'], $short_msg, $long_msg );
            }

        }

    }

}

// Get sensors that are in the alarm_queue. If there are no, exit.
$sensors = db_get_alarm_queue();
if( $sensors == 0 ) {

    if( DS_ALARM_DEBUG ) {
        echo( "The alarm queue is empty. Leaving.\n" );
    }

    return;

}

// Empty the alarm queue.
db_empty_alarm_queue();

foreach( $sensors as $sensor ) {

    /* Find out if there are any enabled alarms for the sensor. Note that
     * alarms might have been disabled before the cron job is run.
     */
    $alarms = db_get_enabled_alarms( $sensor->get_sensor() );
    if( $alarms == 0 ) {
        continue;
    }

    /* Process enabled alarms.
     */
    foreach( $alarms as $alarm ) {

        if( DS_ALARM_DEBUG ) {
            echo( "Processing alarm ".$alarm['alarmid'].".\n" );
        }

        // Get triggers for alarm. If there aren't any, no need to continue.
        $triggers = db_get_alarm_triggers( $alarm['alarmid'] );
        if( $triggers == 0 ) {

            if( DS_ALARM_DEBUG ) {
                echo( "No schedules associated with alarm.\n" );
            }

            continue;

        }

        // Process triggers.
        foreach( $triggers as $trigger ) {

            if( DS_ALARM_DEBUG ) {
                echo( "Processing schedule ".$trigger['scheduleid'].".\n" );
            }

            // Get schedule for trigger.
            $schedule = db_get_schedule( $trigger['scheduleid'] );

            // Check if schedule matches the sensor.
            if( is_schedule_match( $sensor, $schedule ) ) { 

                if( DS_ALARM_DEBUG ) {
                    echo( "Sensor matches schedule.\n" );
                }

                // Alert contacts.
                alert_contacts( $alarm['alarmid'] );

                // Create history entry and add to alarm_history. Disable sensor.
                $history = create_history_entry( $schedule['uid'], 
                                                 $alarm['alarmid'],
                                                 $alarm['sensorid'], 
                                                 $schedule['id'], 
                                                 $schedule['name'], 
                                                 $sensor );
                db_add_alarm_history( $history );
				
				// Disable sensor, if autoenable is disabled.
				$autoEnable = db_get_field( "auto_enable", "alarm_sensors", "sensorid", $alarm['sensorid'] );
				if( $autoEnable != DS_ALARM_PROC_AUTO_ENABLE ) {			
					db_disable_alarm_sensor( $alarmId, $sensorId );
				}
				
                break;

            }

        }

    }

}

?> 
