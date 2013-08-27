#!/bin/bash

# Dunkkis Server
# ==============
# Gateway key installation script
# 
# Copyright (c) 2010 Nomovok Ltd
# This software is licensed under The MIT License. See LICENSE for details.
#
# Author Juha Hytonen - juha.hytonen@nomovok.com

SERVICE_DEF="services/demoservice/dunkkis-server.php"
CURRENT_DIR="$(dirname "$(readlink -f ${BASH_SOURCE[0]})")"

echo $CURRENT_DIR

echo
echo "Dunkkis Demo - Gateway Key Installation"
echo "======================================="
echo
echo "Copyright (c) 2010, Nomovok Ltd"
echo "This software is licensed under The MIT License. See LICENSE for details."
echo
echo -n "Name of the key file: "
read KEYFILE
echo -n "Path to service ($SERVICE_DEF): "
read SERVICE
echo

# Use default service?
SERVICE=${SERVICE:-$SERVICE_DEF}

# Check that give files exist.
if [ ! -e "$KEYFILE" ]; then
    echo "Key file not found in given location."
    exit 1
fi
if [ ! -e "$SERVICE" ]; then
    echo "Service not found in given location."
    exit 1
fi

echo -n "Installing key..."

# Create key directory, if doesn't exist.
if [ ! -e "$CURRENT_DIR/.ssh" ]; then
    mkdir -p $CURRENT_DIR/.ssh
fi

# Add key.
echo -n "command=\"$CURRENT_DIR/$SERVICE\" " | cat - $KEYFILE >> $CURRENT_DIR/.ssh/authorized_keys
chmod 700 $CURRENT_DIR/.ssh
chmod 600 $CURRENT_DIR/.ssh/authorized_keys

echo "Done!"
echo
