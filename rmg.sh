#!/bin/bash

proddeploy() {
  printf "${RED}------------Production Deploy------------${NC}\n"

#  echo "---Backing Up Production DB"
  backupremotedb

#  echo "Verify DB backup was made."
#  ls -l prod-db-backups
  printf "${RED}Continue PROD deploy? [y/n]${NC}\n"
  read continue

  if [ "$continue" == "y" ]; then
      echo "---Minifying CSS"
      gulp --production
      echo "---Tag version [ex v1.2]"
      read tag
      git commit -m "Release $tag" public/css/app.css
      git tag -a "$tag" -m "$tag"
      echo "---Deploying"
      eb deploy rmg-prod
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
#  echo "User: rmg_ec2_user. Enter DB password..."
#  read dbpassword
  dt_now=$(date '+%d_%m_%Y__%H_%M_%S');
  \mysqldump --single-transaction --user=rmg_ec2_user -p$RMG_EC2_USER_PASS --host=rmg2.cwqtmomh10su.us-west-2.rds.amazonaws.com --protocol=tcp --port=3306 --default-character-set=utf8 "rmg" -r "./prod-db-backups/backup$dt_now.sql"
  echo "Completed"
  echo "Copy remote dump to local test folder? [y/n]"
  read continue

  if [ "$continue" == "y" ]; then
    cp "./prod-db-backups/backup$dt_now.sql"  "./tests/_data/dump.sql"
  else
    echo "---Tests copy canceled"
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

prodlogs() {
    printf "${RED}------------Get Latest Production Logs------------${NC}\n"
    ec2instanceIP=$(aws ec2 describe-instances --query 'Reservations[*].Instances[?KeyName==`rmg-prod`].PublicIpAddress' --output text)
    echo "Logging into ${ec2instanceIP}"
    ssh ec2-user@"${ec2instanceIP}" 'cat /var/app/current/storage/logs/laravel.log;'
}

RED='\033[0;31m'
NC='\033[0m' # No Color

echo "Available Commands"
echo "1. Production Deploy"
echo "2. Start Local Dev Enviroment (localdev)"
echo "3. Backup Remote DB"
echo "4. Run Automation Tests (runtests)"
echo "5. Get Production Logs"

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
else
  echo "Invalid command"
fi

echo "Bye bye :)"

exit
