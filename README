Dunkkis Server
==============
README

Copyright (c) 2009-2010 Nomovok Ltd
This software is licensed under The MIT License. See LICENSE for details.

Author Juha Hytonen - juha.hytonen@nomovok.com





Contents
--------
Changelog
Introduction
Prerequisites
Automated or manual installation?
Installing application
Configuring application
Setting up SSH keys
Uninstalling application
Updating an existing server
Manual installation procedure
Manually setting up SSH keys





Changelog
---------

12.02.2010 - v0.1-2 - Juha Hytonen <juha.hytonen@nomovok.com>
- "sensorid" and "deviceid" fields "data" table for extended to 48 chars.
- Latest measurement algorithms have been revised lighter.
- Latest measurement view no longer shows other user's cameras, device names
  or sensor names by accident.
- Latest measurement view now supports multiple MAC devices.
- API includes functions for saving and retrieving cameras from the database.
- The non-functioning getAlarmSensors() API functions is fixed.
- getAlarmDetails() API function has been revised. The time of latest 
  surveillance event is now supplied in "schedules". "contacts" contains a
  list of surveillance contacts and the times they have been notified.
  "sensors" and "history" is left unused as there are separate functions for
  those.
- "timestamp" field was added to DsDevSensorPicture type.
- "autoEnable" field was added to DsAlarmSensor type.

20.01.2010 - v0.1-1 - Juha Hytonen <juha.hytonen@nomovok.com>
- Initial revised version with instructions for online demo.





Introduction
------------

Dunkkis Server is an application that consists of three parts:

1) Web UI. This is the visible part of the application. Web UI allows you to
   manage the MAC devices, devices, sensors, profiles, surveillances and users
   in your system. It also contains the functionality to browse the data from
   your devices. Web UI runs on your web server. It is located under the webui/
   directory in the installation package.

2) SOAP API. This is the part of the server that serves client applications.
   Client applications, such as Qt Dunkkis Client Demo, can be used to connect
   to your server remotely to view data gathered from your devices or, for
   example, to perform video surveillance. SOAP API also runs on your web
   server. It is located under the webui/api/ directory in the installation
   package.

3) Logger. This is the part that receives the data from your devices and adds
   it into the database. The logger is also responsible for checking the data
   against the surveillances user's have set thorough the Web UI. Logger is
   accessed by the devices thorough a special user account on your computer 
   using SSH. It is located under the services/ directory in the installation
   package.

The docs/ directory contains some simple use cases of the SOAP API as well as
the alarm functionalities of the logger.





Prerequisites
-------------

You need to have the following software installed on your server for this
application to work (Ubuntu package name in parentheses):
- Apache 2.X (apache2)
- PHP 5.X (php5)
- PHP Apache2 Module (libapache2-mod-php5)
- PHP Command Line Interpreter (php5-cli)
- PHP MySQL Module (php5-mysql)
- MySQL 5.X Database Server (mysql-server)
- MySQL 5.X Database Client (mysql-client)
- OpenSSH Server (openssh-server)
- The GNU Bourne Again Shell (bash)

The application should work on other server configurations as well, but may
require extra configuration. If your server configuration is radically different
from above, we recommend not using the installation script, but setting up
the application manually.





Automated or manual installation?
---------------------------------

Automated installation procedure with the install.sh installation script should
work in most cases. However below is a list of a few occasions, when you need to
resort to manual installation:
- Your database server is separate from the WWW server. Installation script
  assumes 'localhost' for database server.
- There is no mysql client program ("mysql") in your system. Installation script
  needs this.
- Your system prevents the use of /home for user's home directories.
- You cannot run the installation script in superuser mode.
- You want only parts of the server installed, such as the Web UI and SOAP API
  but not the logger.

Installation using the installer script is described in "Installing application"
whereas manual installation steps are described in "Manual installation 
procedure".





Installing application
----------------------

1) Browse into the directory where the server installation package
   dunkkis-demo-server-0.1-2.tar.gz is located.

2) Unpack the package. Issue the following commad:
   "tar -xf dunkkis-demo-server-0.1-2.tar.gz"

3) Run the installation script. Issue the following command:
   "sudo ./install.sh"

4) You will now be prompted for several configuration details. For most part
   you can use the default values. Below is a brief explanation of what every
   parameter means:
   - "Name for database" is the name of the MySQL database that is to be 
     created on your database server. You might want to change this, if you
     want to have multiple instances of Dunkkis running on your server.
   - "Name for database user" is the name of an user that is to be created
     on your database server. This user has access to the database you created
     in the previous step. This user is used to access the database from the
     Web UI and the SOAP API.
   - "Password for database user" is the password for the user created in the
     previous step.
   - "WWW server's user name" and "WWW server's user group" are the user name 
     and user group under which your WWW server daemon runs. This is used to 
     correctly set the ownership and file permissions of the application.
   - "Database server's admin user name" and "Database server's admin password"
     are used to create the database on the database server. These will not
     be saved anywhere.
   - "Web UI installation directory" is the directory where the Web UI 
     application files will be copied. This directory should be under your
     WWW server's document root.
   - "Name for logger user" is the user name of the user that will be created
     on your server. This is also the user the gateways connect as.
   - "Name for database user" and "Password for database user" are as before,
     but these credentials are used by the server script to add data from the
     devices into the database.

5) Now you have (hopefully) successfully installed the application. If you
   encountered any errors, refer to "Manual installation procedure" for 
   explanation of manual installation. Otherwise move on to "Configuring 
   application".





Configuring application
-----------------------

As the file permissions are set for production use by the installer script,
you need to perform the following steps with adminstrator privileges (sudo su).

1) Browse to "includes" under your Web Ui installation directory.

2) Edit the file called "config.inc.php". You need to check at least the
   following variables:
   - $config['db_host'] is the host name of your MySQL server.
   - $config['db_name'], $config['db_user'] and $config['db_passwd'] are the
     database name, database user and database user password (respectively) you
     provided the installation script with. If you accepted the script's 
     default parameters, you don't need to change these.
   - $config['ds_wsdl_file'] is the path to the SOAP API WSDL file. The
     file is located in the Web UI installation directory, under 
     "api/ds-services.wsdl". This variable must contain an absolute path to
     that file. It is imperative that you get this right, or the SOAP API will
     not function.

3) Browse to "api" under your Web Ui installation directory.

4) Edit the file called "ds-services.wsdl". Just at the end of the file you
   will find a comment saying "change this to match your server configuration".
   Change the "soap:address location" to match the URL of your SOAP API as it
   is visible into the Internet. Again it is imperative that you get this, or
   the SOAP API will not function.

5) Browse to "services/demoservice" under the home directory of the logger
   user (created by the installer script). You can do this by issuing the
   following command:
   "cd ~<name-of-user>/services/demoservice"

6) Edit the file called "dunkkis-server-config.inc.php". You need to check the
   following variables:
   - $config['db_host'] is the host name of your MySQL server.
   - $config['db_name'], $config['db_user'] and $config['db_passwd'] are the
     database name, database user and database user password (respectively) you
     provided the installation script with. Note that these user name and
     password are the ones you entered under "logger configuration". If you 
     accepted the script's default parameters, you don't need to change these.

7) You have now successfully configured the application. You may now browse
   to <url-to-application>/demo.php and login as admin:dunkk15. It is 
   recommended to change the password immediately after you login. The password
   to the preset profile is "dunkkis". Also refer to "Setting up SSH keys" to 
   get your data gathering started.





Setting up SSH keys
-------------------

Refer to the documentation provided with your MAC Device on information how
to create a SSH key pair on the device. You need to export the public key from
the device and upload it on to your server.

1) Log in to your server, if not already.

2) Log in as the logger user. (The user you created when installing the 
   application.)Issue the following command:
   "sudo su logger"

3) Browse into the home directory of the logger user. Issue the following command:
   "cd ~<logger-user-name>"

4) Execute the key installation script. Issue the following command:
   "./install_key.sh"

5) You will now be prompted for a key file. This is the public key you exported
   from the MAC Device and uploaded on to your server. Enter an absolute path
   to the file.

6) After entering the key file, you will be prompted for a service. If you don't
   have any additional services installed (which is unlikely), you may just
   hit enter and accept the default option. This option determines which
   service/script is run, when an user with the key pair you just provided logs
   into the system.

7) The key installation is now complete. If you have more keys, start over from
   step 4.





Uninstalling application
------------------------

NOTE! The uninstallation script removes everything it installed including
the source files, the database, database users and the logger and it's home
folder.

1) Browse into the directory where the server installation script is located.
   If you don't have the server installation script anymore, see steps 1 and 2
   of "Installing application".

2) Run the installation script. Issue the following command:
   "sudo ./install.sh --uninstall"

3) You will now be prompted for some of the same configuration details as when
   you installed the application. Obviously, you need to enter the same
   parameters as then for the uninstallation to work.

4) You have now successfully uninstalled the application.





Updating an existing server
---------------------------

NOTE! This only works with dunkkis-server-0.1-1.
If you have a prior version of Dunkkis Server installed, you can use the
installer script's updating switch to upgrade your server. Your configuration
files will be preserved except for the SOAP API path in the ds-services.wsdl
file, which you'll have to manually reset after the updating procedure.

1) Issue the following command:
   "sudo ./install-sh --update <TARGET> <LOGGER_USER>"

    Above <TARGET> is the path to your old Dunkkis Server installation. By
    default this is "/var/www/dunkkis-demo-v3". <LOGGER_USER> is the user name
    of the logger service. By default this is "logger". You were prompted for
    this information when installing the server.

2) The server files should now have been updated. Move to the api/ directory
   under your installation directory and make the necessary change in the
   ds-services.wsdl file. See "Configuring application", step 4.

In case the automatic upgrade fails, you can either uninstall your previous
server or, if you wish to save your database, update your server by hand. Refer
to steps 4-8 of "Manual installation procedure" for instructions. You might
want to back up your configuration file config.inc.php in the includes/
directory under your installation directory.





Manual installation procedure
-----------------------------

This chapter describes the manual steps of the installation procedure. Example
commands are from a Debian-based system, and thus need to be adjusted according
to your platform.

1) Move into the directory, where the source code package is located.

2) Unpack the source code package.
   "tar -xf dunkkis-demo-server-0.1-2.tar.gz"

3) Create a directory for the Web UI under your WWW server's root.
   "sudo mkdir <www-root>/dunkkis-demo-v3"

4) Copy the contents of the webui/ directory into the directory you created
   in the previous step.
   "sudo cp -r webui/* <www-root>/dunkkis-demo-v3/"

5) Set the ownership of the Web UI files to your WWW server, so that the
   application runs properly. Issue the following commands:
   "sudo chown -R <www-server-user-name> <www-root>/dunkkis-demo-v3
    sudo chgrp -R <www-server-user-group> <www-root>/dunkkis-demo-v3"

6) Set the file permissions of the Web UI files. Issue the following commands:
   "sudo chmod -R 544 <www-root>/dunkkis-demo-v3
    sudo chmod 744 <www-root>/dunkkis-demo-v3/graph"
   Note that the graph-directory needs to be writable for the "Latest
   measurements" functionality to work.
   Note also that it is sufficient for the "demo.php" and "api/index.php" files
   to be executable. 

7) There are sub-directory redirects in every sub-directory. Sub-directories
   (except api/) need not be accessed by users. You may edit the "index.php" 
   files in the sub-directories to change the redirects according to your system
   configuration, or at your option, remove them alltogether.

8) It is also recommended to prevent access to the includes/ directory of the
   Web UI by using a Directory directive in Apache's configuration files. We 
   also recommend running PHP in safe mode, if possible.

9) Login to your database server with root privileges. Note that if your
   database server is separate from the WWW server, you need to specify the
   address of your db server in the command.
   "mysql -u root -p<password>"

10) Create a new database for the application.
    "CREATE DATABASE <db_name>;"

11) Create two users into the database. Note that in the following, you need
    to replace "localhost" with the host name or IP-address of your WWW server,
    if it's separate from your database server.
    "CREATE USER '<user>'@'localhost' IDENTIFIED BY '<user_password>';"
    "CREATE USER '<2nd_user>'@'localhost' IDENTIFIED BY '<2nd_user_password>';"

12) Quit the database client and issue the following command to upload the
    database schema into the database.
    "zcat database/db_empty.sql.gz | mysql -B -u root -p<password> --database=<db_name>"

13) Now log in to your database server again (with root privileges). Issue
    the following commands to set the access rights for the database you just
    created:
    "GRANT SELECT, INSERT, UPDATE, DELETE on <db_name>.* TO '<user>'@'localhost';
     GRANT SELECT ON <db_name>.* TO '<2nd_user>'@'localhost';
     GRANT UPDATE ON <db_name>.alarm_sensors TO '<2nd_user>'@'localhost';
     GRANT INSERT ON <db_name>.alarm_history TO '<2nd_user>'@'localhost';
     GRANT INSERT, DELETE ON <db_name>.alarm_queue TO '<2nd_user>'@'localhost';
     GRANT INSERT ON <db_name>.data TO '<2nd_user>'@'localhost';"
    The above rights are the minimum needed rights for the application to work.

14) Create a new user into your system. The user account should have no password
    as SSH is used to log in to the account by the gateways. You also need to
    create a home directory for the user. Issue the following command:
    "sudo useradd <username> --home <path-to-home-directory> --create-home"

15) Now copy the contents of the services/ directory into the home directory
    of the user you just created. Issue the following command:
    "sudo cp -r services/* ~<username>/"

16) Also copy "install_key.sh" from scripts/ into the home directory. Issue
    the following command:
    "sudo cp scripts/install_key.sh ~<username>/"

17) Set the permissions of the files in the user's home directory. The files
    should be owned and executable only by the user. Issue the following
    commands:
    "chown -R <username> ~<username>/
     chgrp -R <username> ~<username>/
     chmod -R 544 ~<username>/"

18) You have now installed the application Refer to "Configuring application" 
    for configuration instructions.





Manually setting up SSH keys
----------------------------

This chapter describes setting up SSH keys manually. There is a key installation
script provided with the package. See "Setting up SSH keys" for instructions.
The following present the actions performed by the script. Example commands 
are from a Debian-based system, and thus need to be adjusted according to your 
platform.

Refer to the documentation provided with your MAC Device on information how
to create a SSH key pair on the device. You need to export the public key from
the device and upload it on to your server.

1) Log in as the logger user. (The user you created when installing the 
   application.)Issue the following command:
   "sudo su logger"

2) Browse into the home directory of the logger user. Issue the following command:
   "cd ~<logger-user-name>"

3) Create a directory named ".ssh" in the home directory. Issue the following 
   command:
   "mkdir .ssh"

4) Now you need to add the public key into the authorized_keys file under the
   .ssh/ directory and force users logging in with that key pair run the server
   script located in services/demoservice/dunkkis-server.php (or, some other
   service). Issue the following command:
   "echo -n 'command="<server-script>" ' | cat - <key-file> >> .ssh/authorized_keys"
   Server scripts should be located under the services directory in the logger
   user's home directory. Always use the absolute path.

5) If you have more keys, repeate step 4 for each.

6) Set the file permissions correctly for the keys (SSH should not even work,
   if they are improperly set). Issue the following commands:
   "chmod 700 .ssh
    chmod 600 .ssh/authorized_keys"

7) You're done!
