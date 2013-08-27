/** Dunkkis Web User Interface
  * ==========================
  * 
  * Copyright (c) 2009-2010 Nomovok Ltd
  * This software is licensed under The MIT License. See LICENSE for details.
  */

 function textarea_maxlength(element,target, maxvalue)
     {
     var x=document.getElementById(element);
     var y=document.getElementById(target);
     var q = eval(x.value.length);
     var r = q - maxvalue; 
     var msg = DS_STRING_ALARM_MSG_TOO_BIG1 + q + DS_STRING_ALARM_MSG_TOO_BIG2+
       DS_STRING_ALARM_MSG_TOO_BIG3 + "\"" + element + "\"" +
       DS_STRING_ALARM_MSG_TOO_BIG4 +
       maxvalue + DS_STRING_ALARM_MSG_TOO_BIG5 +
       DS_STRING_ALARM_MSG_TOO_BIG6 + r + DS_STRING_ALARM_MSG_TOO_BIG7;
     textarea_size(element, target, maxvalue);
     if (q > maxvalue) alert(msg);
     }

 function textarea_size(element, target, maxvalue)
	{
	var x=document.getElementById(element);
	var y=document.getElementById(target);
	y.value = x.value.length + "/" + maxvalue;
	}

function alarm_validate_size(field,msg,maxlenght)
	{
	with (field)
		{
		if (value==null||value==""||value.length>maxlenght)
			{
			document.getElementById('divvalidateerrors').innerHTML='<font color="red">' + msg + '</font><br>';
			return false;
			}
		else
			{
			return true;
			}
		}
	}

function alarm_validate_int(x, msg)
	{
	var x = x.replace(/,/,".");
	var y = new RegExp("^\d{1,5}(\.\d\d\d\d)?$");
	if (!y.test(x)) {
		document.getElementById('divvalidateerrors').innerHTML='<font color="red">' + msg + '</font><br>';
		return false;
	}
	return true;
	}

 function alarm_validate_settings(thisform)
	{
	with (thisform)
	  {
	  if (alarm_validate_size(alarmname,DS_STRING_ALARM_INVALID_NAME,250)==false) { alarmname.focus(); return false; }
	  if (alarm_validate_size(smallmessage,DS_STRING_ALARM_INVALID_SMALL_MSG,160)==false) { smallmessage.focus(); return false; }
	  if (alarm_validate_size(bigmessage,DS_STRING_ALARM_INVALID_BIG_MSG,250)==false) { bigmessage.focus(); return false; }
	  }
	}

 function alarm_validate_schedule(thisform)
	{
	with (thisform)
	  {
	  if (alarm_validate_size(name,DS_STRING_ALARM_INVALID_SCHEDULE_NAME,250)==false) { name.focus(); return false; }
	  if (alarm_validate_int(minvalue,DS_STRING_ALARM_INVALID_MIN_VALUE)==false) { minvalue.focus(); return false; }
	  if (alarm_validate_int(maxvalue,DS_STRING_ALARM_INVALID_MAX_VALUE)==false) { maxvalue.focus(); return false; }
	  }
	}

 function alarm_validate_contact(thisform)
	{
	with (thisform)
	  {
	  if (alarm_validate_size(name,DS_STRING_ALARM_INVALID_CONTACT_NAME,250)==false) { name.focus(); return false; }
	  if (alarm_validate_size(phone,DS_STRING_ALARM_INVALID_PHONE,250)==false) { phone.focus(); return false; }
	  if (alarm_validate_size(email,DS_STRING_ALARM_INVALID_EMAIL,250)==false) { email.focus(); return false; }
	  }
	}

 function alarm_schedule_form()
	{
	alarm_schedule_always();
	alarm_schedule_months();
	alarm_schedule_days();
	alarm_schedule_allday();
	alarm_schedule_allyear();
	}

 function alarm_schedule_always()
	{
	var x=document.getElementById('form_always');
	if (x.checked == true)	{
		document.getElementById('form_months1').disabled=true;
		document.getElementById('form_months2').disabled=true;
		document.getElementById('form_days1').disabled=true;
		document.getElementById('form_days2').disabled=true;				
		document.getElementById('form_firstday').disabled=true;
		document.getElementById('form_lastday').disabled=true;
		document.getElementById('form_allday').disabled=true;
		document.getElementById('form_allyear').disabled=true;
	} else {
		document.getElementById('form_months1').disabled=false;
		document.getElementById('form_months2').disabled=false;
		document.getElementById('form_days1').disabled=false;
		document.getElementById('form_days2').disabled=false;				
		document.getElementById('form_firstday').disabled=false;
		document.getElementById('form_lastday').disabled=false;
		document.getElementById('form_allday').disabled=false;
		document.getElementById('form_allyear').disabled=false;
	}	
	}

 function alarm_schedule_months()
	{
	var x=document.getElementById('form_always');
	var y=document.getElementById('form_months1');
	if (x.checked == true || y.checked == true)	{
		document.getElementById('form_jan').disabled=true;
		document.getElementById('form_feb').disabled=true;
		document.getElementById('form_mar').disabled=true;
		document.getElementById('form_apr').disabled=true;
		document.getElementById('form_may').disabled=true;
		document.getElementById('form_jun').disabled=true;
		document.getElementById('form_jul').disabled=true;
		document.getElementById('form_aug').disabled=true;
		document.getElementById('form_sep').disabled=true;
		document.getElementById('form_oct').disabled=true;
		document.getElementById('form_nov').disabled=true;
		document.getElementById('form_dec').disabled=true;
	} else {
		document.getElementById('form_jan').disabled=false;
		document.getElementById('form_feb').disabled=false;
		document.getElementById('form_mar').disabled=false;
		document.getElementById('form_apr').disabled=false;
		document.getElementById('form_may').disabled=false;
		document.getElementById('form_jun').disabled=false;
		document.getElementById('form_jul').disabled=false;
		document.getElementById('form_aug').disabled=false;
		document.getElementById('form_sep').disabled=false;
		document.getElementById('form_oct').disabled=false;
		document.getElementById('form_nov').disabled=false;
		document.getElementById('form_dec').disabled=false;
	}
	}

 function alarm_schedule_days()
	{
	var x=document.getElementById('form_always');
	var y=document.getElementById('form_days1');
	if (x.checked == true || y.checked == true)	{
		document.getElementById('form_sun').disabled=true;
		document.getElementById('form_mon').disabled=true;
		document.getElementById('form_tue').disabled=true;
		document.getElementById('form_wed').disabled=true;
		document.getElementById('form_thu').disabled=true;
		document.getElementById('form_fri').disabled=true;
		document.getElementById('form_sat').disabled=true;
	} else {
		document.getElementById('form_sun').disabled=false;
		document.getElementById('form_mon').disabled=false;
		document.getElementById('form_tue').disabled=false;
		document.getElementById('form_wed').disabled=false;
		document.getElementById('form_thu').disabled=false;
		document.getElementById('form_fri').disabled=false;
		document.getElementById('form_sat').disabled=false;	
	}
	}

 function alarm_schedule_allday()
	{
	var x=document.getElementById('form_always');
	var y=document.getElementById('form_allday');
	if (x.checked == true || y.checked == true)	{
		document.getElementById('form_starttime').disabled=true;
		document.getElementById('form_endtime').disabled=true;
	} else {
		document.getElementById('form_starttime').disabled=false;
		document.getElementById('form_endtime').disabled=false;	
	}
	}

 function alarm_schedule_allyear()
	{
	var x=document.getElementById('form_always');
	var y=document.getElementById('form_allyear');
	if (x.checked == true || y.checked == true)	{
		document.getElementById('form_startdate').disabled=true;
		document.getElementById('form_enddate').disabled=true;
	} else {
		document.getElementById('form_startdate').disabled=false;
		document.getElementById('form_enddate').disabled=false;	
	}
	}
