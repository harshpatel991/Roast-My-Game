#!/bin/bash

proddeploy() {
  printf "${RED}------------Production Deploy------------${NC}\n"

#  echo "---Backing Up Production DB"
  backupremotedb
  prodlogs
  #TODO if backup fails, this should not go through

#  echo "Verify DB backup was made."
#  ls -l prod-db-backups
  printf "${RED}Continue PROD deploy? [y/n]${NC}\n"
  read continue

  if [ "$continue" == "y" ]; then
      echo "---Minifying CSS"
      gulp --production

      lastVersion=$(git tag | tail -n1)
      echo "---Tag version [last was ${lastVersion}]"
      read tag
      git commit -m "Release $tag" public/css/app.css
      git tag -a "$tag" -m "$tag"
      echo "---Deploying"
      eb deploy rmg-env-east
  else
    echo "---Deploy canceled"
  fi
}

localdev() {
  printf "${RED}------------Start Local Dev Enviroment------------${NC}\n"
  #start local dev environment
    #start homestead
    #ssh into homestead
    #go to folder
}

backupremotedb() {
  printf "${RED}------------Backup Remote DB------------${NC}\n"
#  backupremotedb
#  echo "User: ***REMOVED***. Enter DB password..."
#  read dbpassword
  dt_now=$(date '+%d_%m_%Y__%H_%M_%S');
  \mysqldump --single-transaction --user=***REMOVED*** -p$RMG_EC2_USER_PASS --host=rmg-east.cdxi2trrcudp.us-east-1.rds.amazonaws.com --protocol=tcp --port=3306 --default-character-set=utf8 "rmg" -r "./prod-db-backups/backup$dt_now.sql"
  echo "Completed"
  echo "Copy dump to local DB? [y/n]"
  read continue

  if [ "$continue" == "y" ]; then
    mysql -u homestead -psecret --host=192.168.55.55 homestead < "./prod-db-backups/backup$dt_now.sql"
    echo "---DB dump copied!"
  else
    echo "---DB dump not copied"
  fi

}

runtests() {
  printf "${RED}------------Run Automation Tests------------${NC}\n"

  echo "---Backing Up Production DB"
  backupremotedb

  echo "Verify DB backup was made."
  ls -l prod-db-backups
  echo "Continue? [y/n]"
  read continue

  if [ "$continue" == "y" ]; then
    sudo php codecept.phar run tests/acceptance/
  else
    echo "---Tests canceled"
  fi

}

refreshseedanddump() {
  printf "${RED}------------Refresh Seed & Dump to Test File------------${NC}\n"

  currentdb="$(php artisan env:echo)"

  if [ "$currentdb" != "DB Host: localhost" ]; then
    echo "Current db is not localhost, it is $currentdb. Cancelling"
    exit 1;
  fi

  echo "Will run seed and dump against $currentdb"
  echo "Continue?[y/n]"
  read continue
  if [ "$continue" == "y" ]; then
    php artisan migrate:refresh --seed
    mysqldump --single-transaction --user=homestead -psecret --host=192.168.55.55 --protocol=tcp --port=3306 --default-character-set=utf8 "homestead" -r "./tests/_data/dump.sql"
    echo "---Finished"
  else
    echo "---Refresh Seed Caneled"
  fi
}

prodlogs() {
    printf "${RED}------------Get Latest Production Logs------------${NC}\n"
    ec2instanceIP=$(aws ec2 describe-instances --query 'Reservations[*].Instances[?KeyName==`rmg-prod-east`].PublicIpAddress' --output text)
    echo "Logging into ${ec2instanceIP}"
    ssh ec2-user@"${ec2instanceIP}" 'cat /var/app/current/storage/logs/laravel.log;'

    dt_now=$(date '+%d_%m_%Y__%H_%M_%S');
    scp ec2-user@"${ec2instanceIP}":/var/app/current/storage/logs/laravel.log "./prod-logs/log_${dt_now}"
}

RED='\033[0;31m'
NC='\033[0m' # No Color

echo "Available Commands"
echo "1. Production Deploy"
echo "2. Start Local Dev Enviroment (localdev)"
echo "3. Backup Remote DB"
echo "4. Run Automation Tests (runtests)"
echo "5. Get Production Logs"
echo "6. Refresh Seed And Dump to Test File"

read command

if [ "$command" ==  "1" ]; then
  proddeploy
elif [ $command == "localdev" ]; then
  localdev
elif [ $command == "3" ]; then
  backupremotedb
elif [ $command == "runtests" ]; then
  runtests
elif [ $command == "5" ]; then
  prodlogs
elif [ $command == "6" ]; then
  refreshseedanddump
else
  echo "Invalid command"
fi

echo "Bye bye :)"

exit


# Setting up apache
#-------------------------
#sudo service nginx stop
#sudo apt-get update
#sudo apt-get install apache2
#sudo service apache2 restart

#cd /etc/apache2/sites-available
#sudo vi myapp.conf

#    Listen 443
#    <VirtualHost *:443>
#    ServerName myapp.localhost.com
#    SSLEngine on
#    SSLCertificateFile "/home/vagrant/Code/clickr/public/myapp.localhost.com.cert"
#    SSLCertificateKeyFile "/home/vagrant/Code/clickr/public/myapp.localhost.com.key"
#    DocumentRoot "/home/vagrant/Code/clickr/public"
#        <Directory "/home/vagrant/Code/clickr/public">
#            AllowOverride all
#            Require all granted
#        </Directory>
#    </VirtualHost>
#    <VirtualHost *:80>
#        ServerName myapp.localhost.com
#        DocumentRoot "/home/vagrant/Code/clickr/public"
#        <Directory "/home/vagrant/Code/clickr/public">
#                AllowOverride all
#                Require all granted
#        </Directory>
#    </VirtualHost>
#

#cd ../sites-enabled
#sudo ln -s ../sites-available/myapp.conf
#sudo service apache2 restart
#cd /etc/apache2
#sudo vi envvars
#
#export APACHE_RUN_USER=vagrant
#export APACHE_RUN_GROUP=vagrant
#
#sudo apt-get install php5-common
#sudo apt-get install libapache2-mod-php5
#
#sudo apt-get install php5-mysql
#sudo service apache2 restart
#
#sudo a2enmod rewrite
#sudo a2enmod expires
#sudo a2enmod headers
#sudo a2enmod ssl

# sudo vim /etc/apache2/ports.conf
# ------ comment out
#   #<IfModule ssl_module>
#       #Listen 443
#   #</IfModule>

#sudo service apache2 restart
#openssl req -nodes -new -x509 -keyout /home/vagrant/Code/clickr/public/myapp.localhost.com.key -out /home/vagrant/Code/clickr/public/myapp.localhost.com.cert -subj "/C=US/ST=NY/L=NYC/O=Dis/CN=www.example.com"

#apt-get install php5-curl
#sudo apt-get install php5-gd
#sudo service apache2 restart



# --- Setting up a new ec2 instance for storing sessions ---
#----------------------------------------------------------
# cd /var/app/current/storage/../../
# sudo mkdir storage
# sudo chown -R webapp:webapp sessions/