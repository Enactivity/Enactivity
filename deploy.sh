#!/bin/bash
# This script is designed to automatically DEPLOY>> the app
# Arguments:
# 1. config environment name ('development', 'production', etc.)
if [ $# -eq 0 ]
  then
    echo " DEPLOY>> Specify the config environment."
    exit
fi

# load arguments into array
arguments=("$@");

# Stop on error
set -e

# Git should be done manually (i.e. 'git pull origin master')

# Yii specific stuff
cd protected

# DEPLOY>> config files
echo " DEPLOY>> Setting up config"
php yiic.php system config --env=${arguments[0]}
echo " DEPLOY>> Done"

# Migrate db as needed
echo " DEPLOY>> Migrating database if needed"
php yiic.php migrate --interactive=0
echo " DEPLOY>> Database migrations done"

# Clean out assets
echo " DEPLOY>> Cleaning out assets"
cd ../www/assets
rm -rf *
echo " DEPLOY>> Assets are cleaned"

# Run compass once to update stylesheets
echo " DEPLOY>> Compiling sass files"
cd ../../protected
compass compile -e production --force
echo " DEPLOY>> Sass files compiled"

# Done
echo " DEPLOY>> Deployment completed - good work"