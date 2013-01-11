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

###
# Yii specific stuff
# -- At each step return to protected folder
###
cd protected

# Set environment
echo " DEPLOY>> Setting up environment mode"
echo ${arguments[0]} > config/local.mode
echo " DEPLOY>> Done"

# Migrate db as needed
echo " DEPLOY>> Migrating database if needed"
php yiic.php migrate --interactive=0
echo " DEPLOY>> Database migrations done"

# Clean out assets
echo " DEPLOY>> Cleaning out assets"
rm -rf ../www/assets/*
echo " DEPLOY>> Assets are cleaned"

echo " DEPLOY>> Cleaning out minified files"
rm -rf runtime/minScript/*
echo " DEPLOY>> Minified files are deleted"

echo " DEPLOY>> Cleaning out mustache cache"
rm -rf runtime/Mustache/*
echo " DEPLOY>> Mustache files are deleted"

# Run compass once to update stylesheets
echo " DEPLOY>> Compiling sass files"
compass compile -e production --force
echo " DEPLOY>> Sass files compiled"

# Done
echo " DEPLOY>> Deployment completed - good work"