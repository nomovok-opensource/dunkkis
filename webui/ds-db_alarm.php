<?php

/** Dunkkis Web User Interface
  * ==========================
  * 
  * Copyright (c) 2009-2010 Nomovok Ltd
  * This software is licensed under The MIT License. See LICENSE for details.
  */

/**
 * db_get_alarms
 * Gets alarms associated to given user in database
 * @author Lars Kinnunen - lars.kinnunen@nomovok.com
 * @param uid: int user id
 * @return Array of resulting alarms, 0 if no match found.
 **/  
function db_get_alarms($uid) {
	$link=db_init();
	$query=sprintf("SELECT * FROM alarms WHERE uid='%s';", mysql_real_escape_string($uid));
	$result=mysql_query($query) or die(DB_QUERY_ERROR.mysql_error().'<br>'.$query);
	
	if ( mysql_num_rows($result) > 0 ) {
		$i=0;
		while($row=mysql_fetch_array($result)) {
			$value[$i]["id"]=$row["id"];
			$value[$i]["uid"]=$row["uid"];
			$value[$i]["name"]=$row["name"];
			$value[$i]["small_message"]=$row["small_message"];
			$value[$i]["long_message"]=$row["long_message"];
			$value[$i]["alert"]=$row["alert"];
			$i++;
		}
		mysql_close($link);
		return $value;
	} else {
		mysql_close($link);
		return 0;
	}
}

/**
 * db_get_alarm
 * Get alarm associated to given alarm id in database
 * @author Lars Kinnunen - lars.kinnunen@nomovok.com
 * @param id: int alarm id
 * @return Array of resulting alarm, 0 if no match found.
 **/  
function db_get_alarm($id) {
	$link=db_init();
	$query=sprintf("SELECT * FROM alarms WHERE id='%s' limit 1;", mysql_real_escape_string($id));
	$result=mysql_query($query) or die(DB_QUERY_ERROR.mysql_error().'<br>'.$query);
	
	if ( mysql_num_rows($result) == 1 ) {
		$value = mysql_fetch_array($result);
		mysql_close($link);
		return $value;
	} else {
		mysql_close($link);
		return 0;
	}
}

/**
 * db_add_alarm
 * Insert new alarm by given parameters to database
 * @author Lars Kinnunen - lars.kinnunen@nomovok.com
 * @param user: int user id
 * @param alarm: array { name, small_message, long_message, alert }
 * @return int alarm id if success, 0 if fails
 **/  
function db_add_alarm($user, $alarm) {
	$link = db_init();
	$query=sprintf("INSERT INTO `alarms` (`id`, `uid`, `name`, `small_message`, `long_message`, `alert`) VALUES ('', '%s', '%s', '%s', '%s', '%s');",
			$user, 
			mysql_real_escape_string($alarm['name']), 
			mysql_real_escape_string($alarm['small_message']),
			mysql_real_escape_string($alarm['long_message']),
			$alarm['alert']);
	$res = mysql_query($query) or die(DB_QUERY_ERROR.$query.' '.mysql_error());
	$id = mysql_insert_id();
    	mysql_close($link);
	return ($res)?$id:0;
}

/**
 * db_update_alarm
 * Updates alarm by given parameters in database
 * @author Lars Kinnunen - lars.kinnunen@nomovok.com
 * @param user: int user id
 * @param alarm: array { name, small_message, long_message, alert, id }
 * @return int alarm id if success, 0 if fails
 **/  
function db_update_alarm($user, $alarm) {
	$link = db_init();
	$query=sprintf("UPDATE `alarms` SET `name`='%s' , `small_message`='%s', `long_message`='%s', `alert`='%s' WHERE `id`='%s';",
			mysql_real_escape_string($alarm['name']), 
			mysql_real_escape_string($alarm['small_message']),
			mysql_real_escape_string($alarm['long_message']),
			$alarm['alert'], $alarm['id']);
	$res = mysql_query($query) or die(DB_QUERY_ERROR.$query.' '.mysql_error());
    	mysql_close($link);
	return ($res)?$alarm['id']:0;
}

/**
 * db_delete_alarm
 * Deletes alarm by given parameters in database
 * @author Lars Kinnunen - lars.kinnunen@nomovok.com
 * @param user: int user id
 * @param alarm: int alarm id
 * @return 1 if success, 0 if fails
 **/  
function db_delete_alarm($user, $alarm) {
	$link = db_init();
	$query=sprintf("DELETE FROM alarms WHERE `id`='%s' AND `uid`='%s'",$alarm, $user);
	$res = mysql_query($query) or die(DB_QUERY_ERROR.$query.' '.mysql_error());
    	mysql_close($link);
	return ($res)?1:0;
}

/**
 * db_get_alarm_contact
 * Get contact associated to given contact id in database
 * @author Lars Kinnunen - lars.kinnunen@nomovok.com
 * @param id: int contact id
 * @return Array of resulting contact, 0 if no match found.
 **/  
function db_get_alarm_contact($id) {
	$link=db_init();
	$query=sprintf("SELECT * FROM alarm_contacts WHERE id='%s' limit 1;", mysql_real_escape_string($id));
	$result=mysql_query($query) or die(DB_QUERY_ERROR.mysql_error().'<br>'.$query);
	
	if ( mysql_num_rows($result) == 1 ) {
		$value = mysql_fetch_array($result);
		mysql_close($link);
		return $value;
	} else {
		mysql_close($link);
		return 0;
	}
}

/**
 * db_get_alarm_contacts
 * Get contacts associated to given user id in database
 * @author Lars Kinnunen - lars.kinnunen@nomovok.com
 * @param id: int contact id
 * @return Array of resulting contacts, 0 if no match found.
 **/
function db_get_alarm_contacts($uid) {
	$link=db_init();
	$query=sprintf("SELECT * FROM alarm_contacts WHERE uid='%s';", mysql_real_escape_string($uid));
	$result=mysql_query($query) or die(DB_QUERY_ERROR.mysql_error().'<br>'.$query);	
	if ( mysql_num_rows($result) > 0 ) {
		$value = array();
		$i=0;
		while($row=mysql_fetch_array($result)) {
			$i = $row["id"] + 0;
			$value[$i]["id"]=$i;
			$value[$i]["uid"]=$row["uid"];
			$value[$i]["name"]=$row["name"];
			$value[$i]["email"]=$row["email"];
			$value[$i]["phone"]=$row["phone"];
			$value[$i]["createddate"]=$row["createddate"];
			$value[$i]["triggercount"]=$row["triggercount"];
		}
		mysql_close($link);
		return $value;
	} else {
		mysql_close($link);
		return 0;
	}
}

/**
 * db_add_alarm_contact
 * Insert new contact by given parameters to database
 * @author Lars Kinnunen - lars.kinnunen@nomovok.com
 * @param value: array { uid, name, email, phone, createddate, triggercount }
 * @return int contact id if success, 0 if fails
 **/
function db_add_alarm_contact($value)
{
	$link=db_init();
	$query=sprintf("INSERT INTO alarm_contacts (`id`, `uid`, `name`, `email`, `phone`, `createddate`, `triggercount`) VALUES ('','%s','%s','%s','%s','%s','%s');",
			$value['uid'],
			mysql_real_escape_string($value['name']), 
			mysql_real_escape_string($value['email']),
			mysql_real_escape_string($value['phone']),
			$value['createddate'],
			$value['triggercount']);
	$res = mysql_query($query) or die(DB_QUERY_ERROR.$query.' '.mysql_error());
	$id = mysql_insert_id();
    	mysql_close($link);
	return ($res)?$id:0;
}

/**
 * db_update_alarm_contact
 * Updates contact by given parameters in database
 * @author Lars Kinnunen - lars.kinnunen@nomovok.com
 * @param value: array { name, email, phone, id }
 * @return int contact id if success, 0 if fails
 **/
function db_update_alarm_contact($value) {
	$link = db_init();
	$query=sprintf("UPDATE `alarm_contacts` SET `name`='%s' , `email`='%s', `phone`='%s' WHERE `id`='%s';",
			mysql_real_escape_string($value['name']), 
			mysql_real_escape_string($value['email']),
			mysql_real_escape_string($value['phone']),
			$value['id']);
	$res = mysql_query($query) or die(DB_QUERY_ERROR.$query.' '.mysql_error());
    	mysql_close($link);
	return ($res)?$value['id']:0;
}

/**
 * db_remove_alarm_contact
 * Removes contact by given parameters in database
 * @author Lars Kinnunen - lars.kinnunen@nomovok.com
 * @param user: int user id
 * @param contact: int contact id
 * @return 1 if success, 0 if fails
 **/
function db_remove_alarm_contact($user, $contact) {			
	$link = db_init();
	$query=sprintf("DELETE FROM alarm_contacts WHERE `id`='%s' AND `uid`='%s'",
				   mysql_real_escape_string($contact), $user);

	$res = mysql_query($query) or die(DB_QUERY_ERROR.$query.' '.mysql_error());
    	mysql_close($link);
	return ($res)?1:0;
}

/**
 * db_get_alarm_schedules
 * Get schedules associated to given user id in database
 * @author Lars Kinnunen - lars.kinnunen@nomovok.com
 * @param id: int user id
 * @return Array of resulting schedules, 0 if no match found.
 **/
function db_get_alarm_schedules($id) {		
	$link=db_init();
	$query=sprintf("SELECT * FROM alarm_schedules WHERE uid='%s';", mysql_real_escape_string($id));
	$result=mysql_query($query) or die(DB_QUERY_ERROR.mysql_error().'<br>'.$query);
	$value = array();
	if ( mysql_num_rows($result) > 0 ) {
		$i=0;
		while($row=mysql_fetch_array($result)) {
			$i = $row["id"] + 0;
			$value[$i]["id"]=$i;
			$value[$i]["uid"]=$row["uid"];
			$value[$i]["name"]=$row["name"];
			$value[$i]["value_min"]=$row["value_min"];
			$value[$i]["value_max"]=$row["value_max"];
			$value[$i]["value_within"]=$row["value_within"];
			$value[$i]["always"]=$row["always"];
			$value[$i]["period"]=$row["period"];
			$value[$i]["startdate"]=$row["startdate"];
			$value[$i]["enddate"]=$row["enddate"];
			$value[$i]["months"]=$row["months"];
			$value[$i]["jan"]=$row["jan"];
			$value[$i]["feb"]=$row["feb"];
			$value[$i]["mar"]=$row["mar"];
			$value[$i]["apr"]=$row["apr"];
			$value[$i]["may"]=$row["may"];
			$value[$i]["jun"]=$row["jun"];
			$value[$i]["jul"]=$row["jul"];
			$value[$i]["aug"]=$row["aug"];
			$value[$i]["sep"]=$row["sep"];
			$value[$i]["oct"]=$row["oct"];
			$value[$i]["nov"]=$row["nov"];
			$value[$i]["dec"]=$row["dec"];
			$value[$i]["days"]=$row["days"];
			$value[$i]["sun"]=$row["sun"];
			$value[$i]["mon"]=$row["mon"];
			$value[$i]["tue"]=$row["tue"];
			$value[$i]["wed"]=$row["wed"];
			$value[$i]["thu"]=$row["thu"];
			$value[$i]["fri"]=$row["fri"];
			$value[$i]["sat"]=$row["sat"];
			$value[$i]["first_day"]=$row["first_day"];
			$value[$i]["last_day"]=$row["last_day"];
			$value[$i]["all_day"]=$row["all_day"];
			$value[$i]["starttime"]=$row["starttime"];
			$value[$i]["endtime"]=$row["endtime"];
			$i++;
		}
		mysql_close($link);
		return $value;
	} else {
		mysql_close($link);
		return 0;
	}
}

/**
 * db_get_alarm_schedule
 * Get schedule associated to given schedule id in database
 * @author Lars Kinnunen - lars.kinnunen@nomovok.com
 * @param id: int schedule id
 * @return Array of resulting schedule, 0 if no match found.
 **/
function db_get_alarm_schedule($id) {		
	$link=db_init();
	$query=sprintf("SELECT * FROM alarm_schedules WHERE id='%s' limit 1;", mysql_real_escape_string($id));
	$result=mysql_query($query) or die(DB_QUERY_ERROR.mysql_error().'<br>'.$query);
	if ( mysql_num_rows($result) == 1 ) {
		$value = mysql_fetch_array($result);
		mysql_close($link);
		return $value;
	} else {
		mysql_close($link);
		return 0;
	}
}

/**
 * db_add_alarm_schedule
 * Insert new schedule by given parameters to database
 * @author Lars Kinnunen - lars.kinnunen@nomovok.com
 * @param value: array { uid, name, value_min, value_max, value_within, always, period, startdate, enddate, months, jan-dec, sun-sat, first_day, last_day, all_day, starttime, endtime }
 * @return Int schedule id if success, 0 if fails
 **/
function db_add_alarm_schedule($value)
{
	$link=db_init();
	$query=sprintf("INSERT INTO `alarm_schedules` (`id`,`uid`,`name`,`value_min`,`value_max`,`value_within`,`always`,`period`,`startdate`,`enddate`,`months`, `jan`,`feb`,`mar`,`apr`, `may`,`jun`,`jul`,`aug`,`sep`,`oct`,`nov`,`dec`,`days`,`sun`,`mon`,`tue`,`wed`,`thu`,`fri`,`sat`,`first_day`,`last_day`,
`all_day`,`starttime`,`endtime`) VALUES ('', '%s', '%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s');", 			
			mysql_real_escape_string($value['uid']), 
			mysql_real_escape_string($value['name']),
			mysql_real_escape_string($value['value_min']),
			mysql_real_escape_string($value['value_max']),
			mysql_real_escape_string($value['value_within']),
			mysql_real_escape_string($value['always']),
			mysql_real_escape_string($value['period']),
			mysql_real_escape_string($value['startdate']),
			mysql_real_escape_string($value['enddate']),
			mysql_real_escape_string($value['months']),
			mysql_real_escape_string($value['jan']),
			mysql_real_escape_string($value['feb']),
			mysql_real_escape_string($value['mar']),
			mysql_real_escape_string($value['apr']),
			mysql_real_escape_string($value['may']),
			mysql_real_escape_string($value['jun']),
			mysql_real_escape_string($value['jul']),
			mysql_real_escape_string($value['aug']),
			mysql_real_escape_string($value['sep']),
			mysql_real_escape_string($value['oct']),
			mysql_real_escape_string($value['nov']),
			mysql_real_escape_string($value['dec']),
			mysql_real_escape_string($value['days']),
			mysql_real_escape_string($value['sun']),
			mysql_real_escape_string($value['mon']),
			mysql_real_escape_string($value['tue']),
			mysql_real_escape_string($value['wed']),
			mysql_real_escape_string($value['thu']),
			mysql_real_escape_string($value['fri']),
			mysql_real_escape_string($value['sat']),
			mysql_real_escape_string($value['first_day']),
			mysql_real_escape_string($value['last_day']),
			mysql_real_escape_string($value['all_day']),
			mysql_real_escape_string($value['starttime']),
			mysql_real_escape_string($value['endtime']));
	$res = mysql_query($query) or die(DB_QUERY_ERROR.$query.' '.mysql_error());
	$id = mysql_insert_id();
    	mysql_close($link);
	return ($res)?$id:0;
}

/**
 * db_update_alarm_schedule
 * Updates schedule by given parameters in database
 * @author Lars Kinnunen - lars.kinnunen@nomovok.com
 * @param value: array { id, uid, name, value_min, value_max, value_within, always, period, startdate, enddate, months, jan-dec, sun-sat, first_day, last_day, all_day, starttime, endtime }
 * @return Int schedule id if success, 0 if fails
 **/
function db_update_alarm_schedule($value) {
	$link = db_init();
	$query=sprintf("UPDATE `alarm_schedules` SET `name`='%s', `value_min`='%s', `value_max`='%s', `value_within`='%s', `always`='%s', `period`='%s', `startdate`='%s', `enddate`='%s', `months`='%s', `jan`='%s', `feb`='%s', `mar`='%s', `apr`='%s', `may`='%s', `jun`='%s', `jul`='%s', `aug`='%s', `sep`='%s', `oct`='%s', `nov`='%s', `dec`='%s', `days`='%s', `sun`='%s', `mon`='%s', `tue`='%s', `wed`='%s', `thu`='%s', `fri`='%s', `sat`='%s', `first_day`='%s', `last_day`='%s', `all_day`='%s', `starttime`='%s', `endtime`='%s' WHERE `id`='%s' AND `uid`='%s';",			
			mysql_real_escape_string($value['name']),
			mysql_real_escape_string($value['value_min']),
			mysql_real_escape_string($value['value_max']),
			$value['value_within'],
			$value['always'],
			$value['period'],
			mysql_real_escape_string($value['startdate']),
			mysql_real_escape_string($value['enddate']),
			$value['months'],
			$value['jan'],
			$value['feb'],
			$value['mar'],
			$value['apr'],
			$value['may'],
			$value['jun'],
			$value['jul'],
			$value['aug'],
			$value['sep'],
			$value['oct'],
			$value['nov'],
			$value['dec'],
			$value['days'],
			$value['sun'],
			$value['mon'],
			$value['tue'],
			$value['wed'],
			$value['thu'],
			$value['fri'],
			$value['sat'],
			mysql_real_escape_string($value['first_day']),
			mysql_real_escape_string($value['last_day']),
			$value['all_day'],
			mysql_real_escape_string($value['starttime']),
			mysql_real_escape_string($value['endtime']),
			$value['id'], $value['uid']);
	$res = mysql_query($query) or die(DB_QUERY_ERROR.$query.' '.mysql_error());
    	mysql_close($link);
	return ($res)?$value['id']:0;
}

/**
 * db_remove_alarm_schedule
 * Deletes alarm schedule by given parameters in database
 * @author Lars Kinnunen - lars.kinnunen@nomovok.com
 * @param user: int user id.
 * @param schedule: int schedule id.
 * @return 1 if success, 0 if fails
 **/
function db_remove_alarm_schedule($user, $schedule) {			
	$link = db_init();
	$query=sprintf("DELETE FROM alarm_schedules WHERE `id`='%s' AND `uid`='%s'",
				   mysql_real_escape_string($schedule), $user);

	$res = mysql_query($query) or die(DB_QUERY_ERROR.$query.' '.mysql_error());
    	mysql_close($link);
	return ($res)?1:0;
}

/**
 * db_get_alarm_triggers
 * Get alarm triggers associated to given alarm id in database
 * @author Lars Kinnunen - lars.kinnunen@nomovok.com
 * @param id: int alarm id.
 * @return Array of resulting alarm triggers, 0 if no match found.
 **/  
function db_get_alarm_triggers($id) {
	$link=db_init();
	$query=sprintf("SELECT * FROM alarm_triggers WHERE alarmid='%s';", mysql_real_escape_string($id));
	$result=mysql_query($query) or die(DB_QUERY_ERROR.mysql_error().'<br>'.$query);
	if ( mysql_num_rows($result) > 0 ) {
		$i=0;
		while($row=mysql_fetch_array($result)) {
			$value[$i]["alarmid"]=$row["alarmid"];
			$value[$i]["alarmscheduleid"]=$row["alarmscheduleid"];
			$i++;
		}
		mysql_close($link);
		return $value;
	} else {
		mysql_close($link);
		return 0;
	}
}

/**
 * db_add_alarm_trigger
 * Insert new alarm trigger by given parameters to database
 * @author Lars Kinnunen - lars.kinnunen@nomovok.com
 * @param alarm: int alarm id.
 * @param schedule: int schedule id.
 * @return 1 if success, 0 if fails
 **/  
function db_add_alarm_trigger($alarm, $schedule) {
	$link=db_init();
	$query=sprintf("INSERT INTO alarm_triggers (`alarmid`, `alarmscheduleid`) VALUES (%s,%s);", 
			mysql_real_escape_string($alarm),
			mysql_real_escape_string($schedule));
	$res = mysql_query($query) or die(DB_QUERY_ERROR.$query.' '.mysql_error());
    	mysql_close($link);
	return ($res)?1:0;
}

/**
 * db_del_alarm_trigger
 * Deletes alarm trigger by given parameters in database
 * @author Lars Kinnunen - lars.kinnunen@nomovok.com
 * @param alarm: int alarm id.
 * @param schedule: int schedule id.
 * @return 1 if success, 0 if fails
 **/  
function db_del_alarm_trigger($alarm, $schedule) {
	$link=db_init();
	$query=sprintf("DELETE FROM alarm_triggers WHERE `alarmid`='%s' AND `alarmscheduleid`='%s';", 
			mysql_real_escape_string($alarm),
			mysql_real_escape_string($schedule));
	$res = mysql_query($query) or die(DB_QUERY_ERROR.$query.' '.mysql_error());
    	mysql_close($link);
	return ($res)?1:0;
}

/**
 * db_get_alarm_actions
 * Get actions associated to given alarm id in database
 * @author Lars Kinnunen - lars.kinnunen@nomovok.com
 * @param id: int alarm id.
 * @return Array of resulting actions, 0 if no match found.
 **/  
function db_get_alarm_actions($id) {
	$link=db_init();
	$query=sprintf("SELECT * FROM alarm_actions WHERE alarmid='%s';", mysql_real_escape_string($id));
	$result=mysql_query($query) or die(DB_QUERY_ERROR.mysql_error().'<br>'.$query);
	if ( mysql_num_rows($result) > 0 ) {
		$i=0;
		while($row=mysql_fetch_array($result)) {
			$value[$i]["alarmid"]=$row["alarmid"];
			$value[$i]["alarmcontactsid"]=$row["alarmcontactsid"];
			$value[$i]["type"]=$row["type"];
			$i++;
		}
		mysql_close($link);
		return $value;
	} else {
		mysql_close($link);
		return 0;
	}
}

/**
 * db_add_alarm_action
 * Insert new alarm action by given parameters to database
 * @author Lars Kinnunen - lars.kinnunen@nomovok.com
 * @param alarm: int alarm id.
 * @param contact: int contact id.
 * @param type: enum action type { sms,email,composite }
 * @return 1 if success, 0 if fails
 **/  
function db_add_alarm_action($alarm, $contact, $type) {
	$link=db_init();
	$query=sprintf("INSERT INTO alarm_actions (`alarmid`, `alarmcontactsid`, `type`) VALUES ('%s','%s','%s');", 
			mysql_real_escape_string($alarm),
			mysql_real_escape_string($contact),
			mysql_real_escape_string($type));
	$res = mysql_query($query) or die(DB_QUERY_ERROR.$query.' '.mysql_error());
    	mysql_close($link);
	return ($res)?1:0;
}

/**
 * db_del_alarm_action
 * Deletes alarm action by given parameters in database
 * @author Lars Kinnunen - lars.kinnunen@nomovok.com
 * @param alarm: int alarm id.
 * @param contact: int contact id.
 * @param type: enum action type { sms,email,composite }
 * @return 1 if success, 0 if fails
 **/ 
function db_del_alarm_action($alarm, $contact, $type) {
	$link=db_init();
	$query=sprintf("DELETE FROM alarm_actions WHERE `alarmid`='%s' AND `alarmcontactsid`='%s' AND `type`='%s';", 
			mysql_real_escape_string($alarm),
			mysql_real_escape_string($contact),
			mysql_real_escape_string($type));
	$res = mysql_query($query) or die(DB_QUERY_ERROR.$query.' '.mysql_error());
    	mysql_close($link);
	return ($res)?1:0;
}

/**
 * db_get_alarm_sensors
 * Get sensors associated to given alarm id in database
 * @author Lars Kinnunen - lars.kinnunen@nomovok.com
 * @param alarm: int alarm id.
 * @return Array of resulting sensors, 0 if no match found.
 **/  
function db_get_alarm_sensors($alarm) {
	$link=db_init();
	$query=sprintf("SELECT * FROM alarm_sensors WHERE alarmid='%s';", mysql_real_escape_string($alarm));
	$result=mysql_query($query) or die(DB_QUERY_ERROR.mysql_error().'<br>'.$query);
	if ( mysql_num_rows($result) > 0 ) {
		$i = 0;
		while($row=mysql_fetch_array($result)) {
			$value[$i]["alarmid"]=$row["alarmid"] + 0;
			$value[$i]["sensorid"]=$row["sensorid"] + 0;
			$value[$i]["enabled"]=$row["enabled"] + 0;
			$value[$i]["auto_enable"]=$row["auto_enable"] + 0;
			$i++;
		}
		mysql_close($link);
		return $value;
	} else {
		mysql_close($link);
		return 0;
	}
}

/**
 * db_add_alarm_sensor
 * Associate sensor by given parameters to alarm in database
 * @author Lars Kinnunen - lars.kinnunen@nomovok.com
 * @param alarm: int alarm id.
 * @param sensor: int sensor id.
 * @return 1 if success, 0 if fails
 **/  
function db_add_alarm_sensor($alarm, $sensor) {
	$link=db_init();
	$query=sprintf("INSERT INTO alarm_sensors (`alarmid`, `sensorid`, `enabled`, `auto_enable`) VALUES ('%s','%s', '%s', '%s');", 
			mysql_real_escape_string($alarm),
			mysql_real_escape_string($sensor), 1, 1);
	$res = mysql_query($query) or die(DB_QUERY_ERROR.$query.' '.mysql_error());
    	mysql_close($link);
	return ($res)?1:0;
}

/** Sets auto_enable property for a sensor.
  * @param alarm  id of alarm (int)
  * @param sensor id of sensor (int)
  * @param autoenable 1 to enable, 0 to disable
  * @return true if successful, false otherwise.
  * @author Juha Hytonen - juha.hytonen@nomovok.com
  */  
function db_autoenable_alarm_sensor( $alarm, $sensor, $autoenable ) 
{

    $link = db_init();
    $query = "UPDATE alarm_sensors 
              SET auto_enable = ".$autoenable."  
              WHERE alarmid = ".$alarm." AND
                    sensorid = ".$sensor.";";
    $result = mysql_query( $query, $link ) or die(DB_QUERY_ERROR.$query.' '.mysql_error());
    mysql_close($link);

    if( $result ) {
        return true;
    }
    else {
        return false;
    }

}

/** Disables sensor from alarm..
  * @param alarm  id of alarm (int)
  * @param sensor id of sensor (int)
  * @return true if successful, false otherwise.
  * @author Juha Hytonen - juha.hytonen@nomovok.com
  */  
function db_disable_alarm_sensor( $alarm, $sensor ) 
{

    $link = db_init();
    $query = "UPDATE alarm_sensors 
              SET enabled = 0  
              WHERE alarmid = ".$alarm." AND
                    sensorid = ".$sensor.";";
    $result = mysql_query( $query, $link ) or die(DB_QUERY_ERROR.$query.' '.mysql_error());
    mysql_close($link);

    if( $result ) {
        return true;
    }
    else {
        return false;
    }

}

/**
 * db_enable_alarm_sensor
 * Enables sensor by given parameters for alarm in database
 * @author Lars Kinnunen - lars.kinnunen@nomovok.com
 * @param alarm: int alarm id.
 * @param sensor: int sensor id.
 * @return 1 if success, 0 if fails
 **/  
function db_enable_alarm_sensor( $alarm, $sensor ) 
{

	$link=db_init();
	$query=sprintf("UPDATE `alarm_sensors` SET `enabled`='%s' WHERE `alarmid`='%s' AND `sensorid`='%s';", 1 ,
			mysql_real_escape_string($alarm),
			mysql_real_escape_string($sensor));
	$res = mysql_query($query) or die(DB_QUERY_ERROR.$query.' '.mysql_error());
    	mysql_close($link);
	return ($res)?1:0;

}

/**
 * db_del_alarm_sensor
 * Deletes sensor association for alarm by given parameters in database
 * @author Lars Kinnunen - lars.kinnunen@nomovok.com
 * @param alarm: int alarm id.
 * @param sensor: int sensor id.
 * @return 1 if success, 0 if fails
 **/  
function db_del_alarm_sensor($alarm, $sensor) {
	$link=db_init();
	$query=sprintf("DELETE FROM alarm_sensors WHERE `alarmid`='%s' AND `sensorid`='%s';", 
			mysql_real_escape_string($alarm),
			mysql_real_escape_string($sensor));
	$res = mysql_query($query) or die(DB_QUERY_ERROR.$query.' '.mysql_error());
    	mysql_close($link);
	return ($res)?1:0;
}

/**
 * db_get_alarm_profiles
 * Get profiles associated by given alarm id in database
 * @author Lars Kinnunen - lars.kinnunen@nomovok.com
 * @param id: int alarm id.
 * @return Array of resulting alarm profiles, 0 if no match found.
 **/  
function db_get_alarm_profiles($id) {
	$link=db_init();
	$query=sprintf("SELECT * FROM alarm_profiles WHERE alarmid='%s';", mysql_real_escape_string($id));
	$result=mysql_query($query) or die(DB_QUERY_ERROR.mysql_error().'<br>'.$query);
	if ( mysql_num_rows($result) > 0 ) {
		$i=0;
		while($row=mysql_fetch_array($result)) {
			$value[$i]["alarmid"]=$row["alarmid"];
			$value[$i]["profileid"]=$row["profileid"];
			$value[$i]["enabled"]=$row["enabled"];
			$i++;
		}
		mysql_close($link);
		return $value;
	} else {
		mysql_close($link);
		return 0;
	}
}

/**
 * db_get_alarm_history
 * Get history associated by given alarm id in database
 * @author Lars Kinnunen - lars.kinnunen@nomovok.com
 * @param id: int alarm id.
 * @return Array of resulting alarm histories, 0 if no match found.
 **/  
function db_get_alarm_history($id) {
	$link=db_init();
	$query=sprintf("SELECT * FROM alarm_history WHERE alarmid='%s';", mysql_real_escape_string($id));
	$result=mysql_query($query) or die(DB_QUERY_ERROR.mysql_error().'<br>'.$query);
	if ( mysql_num_rows($result) > 0 ) {
		$i=0;
		while($row=mysql_fetch_array($result)) {
			$value[$i]["uid"]=$row["uid"];
			$value[$i]["alarmid"]=$row["alarmid"];
			$value[$i]["alarm_name"]=$row["alarm_name"];
			$value[$i]["sensorid"]=$row["sensorid"];
			$value[$i]["sensor_name"]=$row["sensor_name"];
			$value[$i]["alarmscheduleid"]=$row["alarmscheduleid"];
			$value[$i]["schedule_name"]=$row["schedule_name"];
			$value[$i]["value"]=$row["value"];
			$value[$i]["logtime"]=$row["logtime"];
			$i++;
		}
		mysql_close($link);
		return $value;
	} else {
		mysql_close($link);
		return 0;
	}
}

/**
 * db_delete_alarm_history
 * Deletes alarm history by given parameters in database
 * @author Lars Kinnunen - lars.kinnunen@nomovok.com
 * @param user: int user id.
 * @param alarm: int alarm id.
 * @return 1 if success, 0 if fails
 **/  
function db_delete_alarm_history($user, $alarm) {
	$link = db_init();
	$query=sprintf("DELETE FROM alarm_history WHERE `alarmid`='%s' AND `uid`='%s'",$alarm, $user);
	$res = mysql_query($query) or die(DB_QUERY_ERROR.$query.' '.mysql_error());
    	mysql_close($link);
	return ($res)?1:0;
}

/**
 * db_delete_alarm_history_all
 * Deletes alarm history by given parameters in database
 * @author Lars Kinnunen - lars.kinnunen@nomovok.com
 * @param user: int user id.
 * @return 1 if success, 0 if fails
 **/  
function db_delete_alarm_history_all($user) {
	$link = db_init();
	$query=sprintf("DELETE FROM alarm_history WHERE `uid`='%s'",$user);
	$res = mysql_query($query) or die(DB_QUERY_ERROR.$query.' '.mysql_error());
    	mysql_close($link);
	return ($res)?1:0;
}

/**
 * db_get_alarm_all_history
 * Get history associated by given user id in database
 * @author Lars Kinnunen - lars.kinnunen@nomovok.com
 * @param id: int user id.
 * @return Array of resulting alarm histories, 0 if no match found.
 **/  
function db_get_alarm_all_history($id) {
	$link=db_init();
	$query=sprintf("SELECT * FROM alarm_history WHERE uid='%s';", mysql_real_escape_string($id));
	$result=mysql_query($query) or die(DB_QUERY_ERROR.mysql_error().'<br>'.$query);
	if ( mysql_num_rows($result) > 0 ) {
		$i=0;
		while($row=mysql_fetch_array($result)) {
			$value[$i]["uid"]=$row["uid"];
			$value[$i]["alarmid"]=$row["alarmid"];
			$value[$i]["alarm_name"]=$row["alarm_name"];
			$value[$i]["sensorid"]=$row["sensorid"];
			$value[$i]["sensor_name"]=$row["sensor_name"];
			$value[$i]["alarmscheduleid"]=$row["alarmscheduleid"];
			$value[$i]["schedule_name"]=$row["schedule_name"];
			$value[$i]["value"]=$row["value"];
			$value[$i]["logtime"]=$row["logtime"];
			$i++;
		}
		mysql_close($link);
		return $value;
	} else {
		mysql_close($link);
		return 0;
	}
}

// ******************************************************************************
// Needed by alarm, but not found in db.php
// ******************************************************************************

/**
 * db_get_all_sensors
 * Gets all sensors in database
 * @author Lars Kinnunen - lars.kinnunen@nomovok.com
 * @return Array of resulting sensors, 0 if no match found.
 **/  
function db_get_all_sensors() {
	$link=db_init();
	$result=mysql_query("SELECT * FROM sensor;") or die(DB_QUERY_ERROR.mysql_error().'<br>'."SELECT * FROM sensor;");
	if ( mysql_num_rows($result) > 0 ) {
		$i=0;
		while($row=mysql_fetch_array($result)) {
			$i = $row["id"] + 0; // Index array by sensorid.
			$value[$i]["id"]=$i;
			$value[$i]["sensoridstr"]=$row["sensoridstr"];
			$value[$i]["name"]=$row["name"];
			$value[$i]["devid"]=$row["devid"];
			$value[$i]["type"]=$row["type"];
			$i++;
		}
		mysql_close($link);
		return $value;
	} else {
		mysql_close($link);
		return 0;
	}
}

/** Returns all sensors by uid.
  * @author Juha Hytonen - juha.hytonen@nomovok.com
  * @param uid User ID.
  * @return Array of sensors, 0 if none.
  */  
function db_get_sensors_by_uid( $uid ) 
{
    $link = db_init();
    $query = "SELECT sensor.id as id, sensor.sensoridstr as sensoridstr,
                     sensor.name as name, sensor.devid as devid,
                     sensor.type as type, profile.name as profileName
              FROM sensor, device, profile
              WHERE sensor.devid = device.id AND
                    device.profileid = profile.id AND
                    profile.userid = ".$uid.";";
    $result = mysql_query( $query ) or die(DB_QUERY_ERROR.mysql_error().'<br>'.$query);

    if( mysql_num_rows( $result ) > 0 ) {

        $sensors = array();
        while($row=mysql_fetch_array($result)) {
            $sensor["id"] = $row["id"];
            $sensor["sensoridstr"] = $row["sensoridstr"];
            $sensor["name"] = $row["name"];
            $sensor["devid"] = $row["devid"];
            $sensor["type"] = $row["type"];
            $sensor["profileName"] = $row["profileName"];
            array_push( $sensors, $sensor );
        }

        mysql_close( $link );
        return $sensors;

    } 
    else {
        mysql_close( $link );
        return 0;
    }
}

/**
 * db_set_sensor_name
 * Updates sensor name by sensor id in database
 * @author Lars Kinnunen - lars.kinnunen@nomovok.com
 * @param sensorId: int sensor id.
 * @param name: string sensor name.
 * @return 1 if success, 0 if fails
 **/  
function db_set_sensor_name($sensorId, $name) {
	$return = 1;
	$link=db_init();
	$query=sprintf("UPDATE `sensor` SET `name`='%s' WHERE `id`='%s';", mysql_real_escape_string($name), mysql_real_escape_string($sensorId));
	$res = mysql_query($query);
    	mysql_close($link);
	return ($res)?1:0;
}

/**
 * db_get_all_devices
 * Gets all devices in database
 * @author Lars Kinnunen - lars.kinnunen@nomovok.com
 * @return Array of resulting devices, 0 if no match found.
 **/  
function db_get_all_devices() {
	$link=db_init();
	$result=mysql_query("SELECT * FROM device;") or die(DB_QUERY_ERROR.mysql_error().'<br>'."SELECT * FROM device;");
	if ( mysql_num_rows($result) > 0 ) {
		$i=0;
		while($row=mysql_fetch_array($result)) {
			$i = $row["id"] + 0;
			$value[$i]['id'] = $i;
			$value[$i]['devidstr'] = $row['devidstr'];
			$value[$i]['name'] = $row['name'];
			$value[$i]['profileid'] = $row['profileid'];
			$value[$i]['dboxid'] = $row['dboxid'];
			$value[$i]['type'] = $row['type'];
			$i++;
		}
		mysql_close($link);
		return $value;
	} else {
		mysql_close($link);
		return 0;
	}
}

?>
