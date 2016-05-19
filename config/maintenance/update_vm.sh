#!/bin/bash

# This script allows to update all local Moodle instances at once.
# Just run it from /opt/solerni/customers/solerni(x)/www/
# using the command-line: bash /opt/solerni/conf/maintenance/update_vm.sh
# By default the script purges all caches, if pressing "u" it will also update
# the Moodle database.

# update all jobs, all instances
echo
do_instance=p
read -t 5 -n 1 -p $"Do you want to purge(*) or update (U|u) all instances ?" do_instance

if [[ $do_instance =~ ^(u|U)$ ]]; then
    for i in solerni solerni2 solerni3 solerni4 solerni5; do
        cd ../../$i/www
        echo
        echo "Upgrading ... [ $i ]"
        php admin/cli/upgrade.php --non-interactive
        echo
        echo "Mooshing ... [ $i ]"
        bash /opt/solerni/conf/moosh/default/conf.sh -dev -s;
        if [ "$i" = "solerni" ]
            then
                echo
                echo "Mooshing... [ MNET HOME $i ]"
                bash /opt/solerni/conf/moosh/customer_thematic/solerni-home/conf.sh -dev -s
        fi
    done
fi
echo

for i in solerni solerni2 solerni3 solerni4 solerni5; do
    cd ../../$i/www
    echo "Purging ... [ $i ]"
    php admin/cli/purge_caches.php
done
