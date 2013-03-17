# System Requirements
 1. MySQL
 2. Apache
 3. Unix server
 4. PHP 5.3+ (developed/tested with 5.3)
 5. Rails (for compass)

# Installation
 1.`gem install compass`

# Getting started
`[project folder]` can be something any private folder on the server that can hold the unprotected code, `[webroot]` is the apache folder that serves the webpage.
 1. `git clone https://github.com/Poncla/Poncla.git [project folder]`
 2. `cd [project folder]`
 3. `./deploy.sh development`
 4. `cd ../..`
 5. `ln -s [project folder]/www [webroot]` You may need to remove the web folder first

# Develop
 1. `cd protected`
 2. `compass watch`

# Deploying
Enactivity supports three environments, `development`, `staging`, and `production`, referred to in the commands as `[environment]`.  

Run from the project folder.
 1. `git pull origin master`
 2. `./deploy.sh [environment]`