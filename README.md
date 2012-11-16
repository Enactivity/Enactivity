# Installation
 1.`gem install compass`

# Getting started
`[project folder]` would be something like `ajsharma.dev.poncla.com.code`
 1. `git clone https://github.com/Poncla/Poncla.git [project folder]`
 2. `cd [project folder]/protected`
 3. `./yiic system config --env='development'`
 4. `./yiic migrate up`
 5. `cd ../..`
 7. `ln -s [project folder]/www [webroot]` You may need to remove the web folder first

# Develop
 1. `cd protected`
 2. `compass watch`

# Deploy to Production
Run from the project root `/home/poncla_admin/enactivity.com.code`
 1. `git pull origin master`
 2. `./deploy production`