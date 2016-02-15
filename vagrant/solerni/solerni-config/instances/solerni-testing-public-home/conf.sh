#!/bin/bash
# Fichier "default/conf.sh"

# load of ansible variables us_290 us_292 us_71 us_247
if [ -f ../../conf/env_moosh.cfg ]; then
. ../../conf/env_moosh.cfg
fi
if [ -f ../conf/env_moosh.cfg ]; then
. ../conf/env_moosh.cfg
fi

# Web Services Activation On Home
moosh config-set enablewebservices 1

# Activate REST
moosh config-set webserviceprotocols rest

#Import Role
moosh role-import apiuser solerni-config/instances/solerni-home/users_roles/solerniapiuser.xml

# Create API User
moosh user-create --password apiuser01! --email solerniapiuser@orange.fr --firstname 'API' --lastname 'User' --city 'Paris' --country 'FR' 'api_user'

# Settings PF Name
moosh course-config-set course 1 fullname "${CUSTOMER_THEMATIC}"
