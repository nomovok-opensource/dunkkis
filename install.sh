#!/bin/bash
set -eu

# Dunkkis Server
# ==============
# Installation script
# 
# Copyright (c) 2010 Nomovok Ltd
# This software is licensed under The MIT License. See LICENSE for details.
#
# Author Juha Hytonen - juha.hytonen@nomovok.com

# Versioning.
SERVER_VERSION="0.1-2"
API_VERSION="2"

# Installation sources.
WEBUI="webui"
SERVICES="services"
SCRIPTS="scripts"
DEMO_DB="database/db_real_test_data.sql.gz"
EMPTY_DB="database/db_empty.sql.gz"
PICTURE_DB="database/db_pictures.sql.gz"

# Default values.
DB_NAME_DEF="dunkkis_demo_v3"
DB_USER_DEF="dunkkis-v3"
DB_USER_PW_DEF="dunkkis"
WWW_USER_NAME_DEF="www-data"
WWW_USER_GROUP_DEF="www-data"
DB_ADMIN_NAME_DEF="root"
DB_ADMIN_PW_DEF=""
LOGGER_USER_DEF="logger"
LOGGER_DB_USER_DEF="dunkkis-logger"
LOGGER_DB_USER_PW_DEF="dunkkis"
TARGET_DEF="/var/www/dunkkis-demo-v3"

MODE="inst"
DB="database/db_empty.sql.gz"
PICTURES=false
DEFAULT=false
TARGET=""
STTY_ORIG=""

function invalidParameters()
{

    echo "Invalid parameters." 1>&2
    echo 1>&2
    exit 1

}

# Check command line parameters.
if [ $# -gt 0 ]; then
    case "$1" in
        "--update") MODE="upd" ;;
        "--uninstall") MODE="uninst" ;;
        "--demo") DB=$DEMO_DB ;;
        "--help") MODE="help" ;;
    esac
    if [ $# -gt 1 ]; then
        if [ $1 == "--demo" ]; then
            if [ $2 == "--pictures" ]; then
                PICTURES=true
            elif [ $2 == "--default" ]; then
                DEFAULT=true
            else
                invalidParameters
            fi
            if [ $# -gt 2 ]; then
                if [ $3 == "--pictures" ]; then
                    PICTURES=true
                elif [ $3 == "--default" ]; then
                    DEFAULT=true
                else
                    invalidParameters
                fi
            fi
        elif [ $1 == "--update" ]; then
            TARGET=$2
            if [ $# -gt 2 ]; then
                LOGGER_USER=$3
            else
                invalidParameters
            fi
        elif [ $1 == "--uninstall" ]; then
            if [ $2 == "--default" ]; then
                DEFAULT=true
            else
                invalidParameters
            fi
        else
            invalidParameters
        fi
    elif [ $1 == "--update" ]; then
        invalidParameters
    fi
fi

# Turn echo on off when asking user for passwords.
function passwordMode()
{

    if [ $1 == "on" ]; then
        STTY_ORIG=`stty -g`
        stty -echo
    else
        stty $STTY_ORIG
    fi

}

echo
echo "Dunkkis Demo - Server Installation"
echo "=================================="
echo "Version $SERVER_VERSION, API version $API_VERSION"
echo "http://www.dunkkis.org"
echo
echo "Copyright (c) 2010, Nomovok Ltd"
echo "This software is licensed under The MIT License. See LICENSE for details."
echo

if [ $MODE == "help" ]; then

    echo "Usage: sudo ./install.sh [MODE] [OPTIONS]"
    echo
    echo "When given no parameters default action is installation. Following"
    echo "modes parameters may be specified to perform other actions:"
    echo "-- help                           this text"
    echo "-- uninstall                      uninstalls the application."
    echo "-- update <TARGET> <LOGGER_USER>  updates the current installation"
    echo "                                  <TARGET> is the location to which"
    echo "                                  the application is currently"
    echo "                                  installed in and <LOGGER_USER> is"
    echo "                                  the user name of the logger user"
    echo "-- demo [--pictures] [--default]  installs the application with a"
    echo "                                  a database containing test data,"
    echo "                                  optionally installation parameters"
    echo "                                  can be set default (not prompted)"
    echo "                                  with --default and additional"
    echo "                                  images installed with --picture"
    echo
    echo "Please note that the demo database, with pictures and default options"
    echo "is only for testing purposes, not for production use. Test database"
    echo "is not included in the distribution package."
    echo
    exit

fi

# Check that script is run as root.
if [[ $EUID -ne 0 ]]; then
    echo "The installation must be performed with root priviledges." 1>&2
    echo 1>&2
    exit 1
fi

if [ $MODE == "inst" ]; then
    echo "Welcome to Dunkkis Server installation!"
    echo "If you have an existing installation, please use --update or uninstall first."
elif [ $MODE == "uninst" ]; then
    echo "Welcome to Dunkkis Server uninstallation!"
else
    echo "Welcome to Dunkkis Server upgrade!"
fi
echo

# Do not prompt for configuration if upgrading, or if --default is set.
if [ $MODE != "upd" ]; then
if [ $DEFAULT == false ]; then

    echo "WEB UI CONFIGURATION"
    echo "--------------------"
    echo -n "Name for database ($DB_NAME_DEF): "
    read DB_NAME
    echo -n "Name for database user ($DB_USER_DEF): "
    read DB_USER

    if [ $MODE == "inst" ]; then

        echo -n "Password for database user ($DB_USER_PW_DEF): "
        passwordMode on
        read DB_USER_PW
        passwordMode off
        echo
        echo -n "WWW server's user name ($WWW_USER_NAME_DEF): "
        read WWW_USER_NAME
        echo -n "WWW server's user group ($WWW_USER_GROUP_DEF): "
        read WWW_USER_GROUP

    fi

    echo -n "Database server's admin user name ($DB_ADMIN_NAME_DEF): "
    read DB_ADMIN_NAME
    echo -n "Database server's admin password ($DB_ADMIN_PW_DEF): "
    passwordMode on
    read DB_ADMIN_PW
    passwordMode off
    echo
    echo -n "Web UI installation directory ($TARGET_DEF): "
    read TARGET
    echo
    echo "LOGGER CONFIGURATION"
    echo "--------------------"
    echo -n "Name for logger user ($LOGGER_USER_DEF): "
    read LOGGER_USER
    echo -n "Name for database user ($LOGGER_DB_USER_DEF): "
    read LOGGER_DB_USER

    if [ $MODE == "inst" ]; then

        echo -n "Password for database user ($LOGGER_DB_USER_PW_DEF): "
        passwordMode on
        read LOGGER_DB_USER_PW
        passwordMode off
        echo
        echo
        echo "INSTALLATION"
        echo "------------"

    else

        echo
        echo "UNINSTALLATION"
        echo "--------------"

    fi

else # --default

    # Ask for db password anyway, cause otherwise prompted three times.
    echo -n "Database server's admin password ($DB_ADMIN_PW_DEF): "
    passwordMode on
    read DB_ADMIN_PW
    passwordMode off
    echo
    echo

fi # --default

    # Set default values, if nothing given.
    DB_NAME=${DB_NAME:-$DB_NAME_DEF}
    DB_USER=${DB_USER:-$DB_USER_DEF}
    DB_USER_PW=${DB_USER_PW:-$DB_USER_PW_DEF}
    WWW_USER_NAME=${APACHE_USER_NAME:-$WWW_USER_NAME_DEF}
    WWW_USER_GROUP=${APACHE_USER_GROUP:-$WWW_USER_GROUP_DEF}
    DB_ADMIN_NAME=${DB_ADMIN_NAME:-$DB_ADMIN_NAME_DEF}
    DB_ADMIN_PW=${DB_ADMIN_PW:-$DB_ADMIN_PW_DEF}
    LOGGER_USER=${LOGGER_USER:-$LOGGER_USER_DEF}
    LOGGER_DB_USER=${LOGGER_DB_USER:-$LOGGER_DB_USER_DEF}
    LOGGER_DB_USER_PW=${LOGGER_DB_USER_PW:-$LOGGER_DB_USER_PW_DEF}
    TARGET=${TARGET:-$TARGET_DEF}

else

    echo "UPGRADE"
    echo "-------"

fi

# Create logger user.
if [ $MODE == "inst" ]; then

    echo -n "Creating user $LOGGER_USER..."
    useradd $LOGGER_USER --home "/home/$LOGGER_USER"
    mkdir -p "/home/$LOGGER_USER"
    echo "Done!"

elif [ $MODE == "uninst" ]; then

    echo -n "Removing user $LOGGER_USER..."
    userdel --force $LOGGER_USER
    echo "Done!"

fi

# Back up configuration files, if updating.
if [ $MODE == "upd" ]; then

    echo -n "Backing up configuration..."
    #cp $TARGET/api/ds-services.wsdl $TARGET/api/ds-services.wsdl.backup
    cp $TARGET/includes/config.inc.php $TARGET/includes/config.inc.php.backup
    cp /home/$LOGGER_USER/services/demoservice/dunkkis-server-config.inc.php \
        /home/$LOGGER_USER/services/demoservice/dunkkis-server-config.inc.php.backup
    echo "Done!"

fi

# Copy files.
if [ $MODE == "inst" ]; then

    echo -n "Copying files..."
    mkdir -p $TARGET
    cp -r $WEBUI/* $TARGET/
    cp "$SCRIPTS/install_key.sh" "/home/$LOGGER_USER/"
    mkdir -p "/home/$LOGGER_USER/services"
    cp -r $SERVICES/* "/home/$LOGGER_USER/services/"
    echo "Done!"

elif [ $MODE == "uninst" ]; then

    echo -n "Removing files..."
    rm -rf $TARGET
    rm -rf "/home/$LOGGER_USER"
    echo "Done!"

fi

# Restore configuration files, if updating.
if [ $MODE == "upd" ]; then

    echo -n "Restoring configuration..."
    #cp $TARGET/api/ds-services.wsdl.backup $TARGET/api/ds-services.wsdl
    cp $TARGET/includes/config.inc.php.backup $TARGET/includes/config.inc.php
    cp /home/$LOGGER_USER/services/demoservice/dunkkis-server-config.inc.php.backup \
        /home/$LOGGER_USER/services/demoservice/dunkkis-server-config.inc.php
    echo "Done!"

fi

if [ $MODE == "inst" ]; then

    echo -n "Setting permissions..."
    chown -R $WWW_USER_NAME $TARGET 
    chgrp -R $WWW_USER_GROUP $TARGET
    chmod -R 544 $TARGET
    chmod 744 $TARGET/graph
    chown -R $LOGGER_USER /home/$LOGGER_USER
    chgrp -R $LOGGER_USER /home/$LOGGER_USER
    chmod -R 544 /home/$LOGGER_USER
    echo "Done!"

    echo -n "Creating database..."
mysql -B -u $DB_ADMIN_NAME -p$DB_ADMIN_PW <<-END
    CREATE DATABASE $DB_NAME;
END
    echo "Done!"

    # Upload database schema. (sample data with --demo switch)
    echo -n "Creating tables..."
    zcat $DB | mysql -B -u $DB_ADMIN_NAME -p$DB_ADMIN_PW --database=$DB_NAME
    echo "Done!"

    # Upload sample pictures with --pictures switch.
    if [ $PICTURES == true ]; then

        echo -n "Uploading pictures..."
        zcat $PICTURE_DB | mysql -B -u $DB_ADMIN_NAME -p$DB_ADMIN_PW --database=$DB_NAME
        echo "Done!"

    fi

    echo -n "Creating users..."
mysql -B -u $DB_ADMIN_NAME -p$DB_ADMIN_PW <<-END
    CREATE USER '$DB_USER'@'localhost' IDENTIFIED BY '$DB_USER_PW';
    GRANT SELECT, INSERT, UPDATE, DELETE on $DB_NAME.* TO '$DB_USER'@'localhost';
    CREATE USER '$LOGGER_DB_USER'@'localhost' IDENTIFIED BY '$LOGGER_DB_USER_PW';
    GRANT SELECT ON $DB_NAME.* TO '$LOGGER_DB_USER'@'localhost';
    GRANT UPDATE ON $DB_NAME.alarm_sensors TO '$LOGGER_DB_USER'@'localhost';
    GRANT INSERT ON $DB_NAME.alarm_history TO '$LOGGER_DB_USER'@'localhost';
    GRANT INSERT, DELETE ON $DB_NAME.alarm_queue TO '$LOGGER_DB_USER'@'localhost';
    GRANT INSERT ON $DB_NAME.data TO '$LOGGER_DB_USER'@'localhost';
END
    echo "Done!"

elif [ $MODE == "uninst" ]; then

    echo -n "Dropping database..."
mysql -B -u $DB_ADMIN_NAME -p$DB_ADMIN_PW <<-END
    DROP DATABASE $DB_NAME;
    DROP USER '$DB_USER'@'localhost';
    DROP USER '$LOGGER_DB_USER'@'localhost';
END
    echo "Done!"

fi

echo
if [ $MODE == "inst" ]; then
    echo "The installation has been completed."
    echo "Refer to README for information on configuring your system."
elif [ $MODE == "uninst" ]; then
    echo "The uninstallation has been completed."
    echo "Thank you for using Dunkkis."
else
    echo "The upgrade has been completed."
fi
echo


