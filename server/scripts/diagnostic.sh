#!/bin/bash
TIMESTAMP=$(date +%s)
APACHE_STATUS=$(service apache2 status | awk 'NR == 3 {print $2}')
PRIVATE_IP=$(ifconfig | grep "inet 192" | awk 'NR == 1 {print $2}')
PUBLIC_IP=$(curl ifconfig.me)

rm -f /stupify/diagnostic.json
echo "{\"timestamp\":\"$TIMESTAMP\",\"apache_status\":\"$APACHE_STATUS\",\"private_ip\":\"$PRIVATE_IP\",\"public_ip\":\"$PUBLIC_IP\"}" >     /stupify/diagnostic.json

