# Installation
1.`gem install compass`

# Getting started
1. `git clone https://github.com/Poncla/Poncla.git [project folder]`
2. `cd [project folder]/protected`
3. `./yiic system config --env='development'`
4. `./yiic migrate up`
5. `./yiic store loadSweatersFromFile`
5. `cd ../..`
7. `ln -s [project folder]/www [webroot]` You may need to remove the web folder first

# Develop
1. `cd protected/[currenttheme]`
2. `compass watch`