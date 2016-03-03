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

# Disallow automatic updates
moosh config-set updateautocheck 1
