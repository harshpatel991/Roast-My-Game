#!/bin/bash
set -x

#get eb config variables and add as env vars
for s in $(/opt/elasticbeanstalk/bin/get-config environment | jq -r "to_entries|map(\"\(.key)=\(.value|tostring)\")|.[]" ); do
    export $s
done

echo "============ START SETUP SSL ============";

if $SHOULD_GENERATE_CERT; then
  echo "Generating new cert"
  certbot --nginx -d ${SERVER_DOMAIN} -d ${SERVER_ALIAS} --non-interactive --agree-tos -m ${CERT_EMAIL}
  cat /etc/nginx/nginx.conf
else
  echo "Generating new cert disabled";
fi

if $SHOULD_CRON_REFRESH_CERT; then
  echo "Creating cron to refresh cert"
  systemctl status certbot-renew.timer
  systemctl start certbot-renew.timer
  systemctl status certbot-renew.timer
else
  echo "Refresh cert cron is disabled"
fi
echo "============ END SETUP SSL ============";