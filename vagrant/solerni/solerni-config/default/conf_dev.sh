#!/bin/bash
# Fichier "default/conf_dev.sh"
# DEV ENV specific conf - do not use any settings for production

# load of ansible variables us_290 us_292 us_71 us_247
if [ -f ../../conf/env_moosh.cfg ]; then
. ../../conf/env_moosh.cfg
fi
if [ -f ../conf/env_moosh.cfg ]; then
. ../conf/env_moosh.cfg
fi
# ${CUSTOMER_LOG_DB_HOST}
# ${CUSTOMER_LOG_DB_NAME}
# ${CUSTOMER_LOG_DB_USERNAME}
# ${CUSTOMER_LOG_DB_PASSWORD}
# ${CUSTOMER_STATS_DB_HOST}
# ${CUSTOMER_STATS_DB_NAME}
# ${CUSTOMER_STATS_DB_USERNAME}
# ${CUSTOMER_STATS_DB_PASSWORD}
# ${CUSTOMER_PIWIK_URL}

# ${CUSTOMER_STATIC_DIRECTORY}
# ${GEOIP_FILE_PATH}


# Disallow automatic updates
moosh config-set updateautocheck 1
