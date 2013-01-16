# Installation
 1.`gem install compass`

# Getting started
`[project folder]` would be something like `ajsharma.dev.poncla.com.code`
 1. `git clone https://github.com/Poncla/Poncla.git [project folder]`
 2. `cd [project folder]`
 3. `./deploy.sh development`
 4. `cd ../..`
 5. `ln -s [project folder]/www [webroot]` You may need to remove the web folder first

# Develop
 1. `cd protected`
 2. `compass watch`

# Deploy to Alpha
Run from the project root `/home/poncla_admin/alpha.enactivity.com.code`
 1. `git pull origin master`
 2. `./deploy.sh staging`

# Deploy to Production
Run from the project root `/home/poncla_admin/enactivity.com.code`
 1. `git pull origin master`
 2. `./deploy.sh production`
