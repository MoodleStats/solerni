#!/bin/bash

# The directory where this script is located
BASE_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

function init () {
	local parent_directory="$(dirname `pwd`)"
	local env_moosh_file=$parent_directory/conf/env_moosh.cfg
	log_action "> Loading Moosh environment '${env_moosh_file}'..."
	if [ -f $env_moosh_file ]; then
		. ${env_moosh_file}
		log_ok "- OK"
	else
		log_error "- Unable to load file '${env_moosh_file}'"
		exit 1
	fi
}

function log_action () {
	tput setaf 3;
	echo ${1}
	tput sgr0
}

function log_error () {
	tput setaf 1
	echo >&2 ${1}
	tput sgr0
}

function log_info () {
	tput setaf 7
	echo ${1}
	tput sgr0
}

function log_ok () {
	tput setaf 2
	echo ${1}
	tput sgr0
}

function execute_moosh_command () {
	log_action "> Executing Moosh command '$1'..."
	local moosh_temp_stdout="/tmp/moosh-${INSTANCE_KEY}-thematic-stdout-temp-`date '+%d%m%Y%H%M%S%N'`"
	local moosh_temp_stderr="/tmp/moosh-${INSTANCE_KEY}-thematic-stderr-temp-`date '+%d%m%Y%H%M%S%N'`"

	local moosh_output=$(eval $1 2> $moosh_temp_stderr 1> $moosh_temp_stdout)

	sed -i '/^$/d' $moosh_temp_stdout
	sed -i '/^$/d' $moosh_temp_stderr

	if [ -s $moosh_temp_stdout ]; then
		log_info "+ $(<$moosh_temp_stdout)"
	fi

	if [ -s $moosh_temp_stderr ]; then
		log_error "+ $(<$moosh_temp_stderr)"
		if [ $? == 0 ]; then
			log_error "- ERROR: the moosh command returns the code 0 but writes in stderr"
			exit -1
		fi
	fi

	if [ $? != 0 ]; then
		log_error "- ERROR: the moosh command returns the code $?"
		exit -1
	else
		log_ok "- OK"
	fi

	rm ${moosh_temp_stdout}
	rm ${moosh_temp_stderr}
}

function main () {
	init

	# Web Services Activation On Home
	execute_moosh_command "moosh config-set enablewebservices 1"

	# Activate REST
	execute_moosh_command "moosh config-set webserviceprotocols rest"

	#Import Role
	execute_moosh_command "moosh role-import api_user /opt/solerni/conf/moosh/customer_thematic/${CUSTOMER_THEMATIC_KEY}/users_roles/solerniapiuser.xml"

	# Create API User
	execute_moosh_command "moosh user-create --password apiuser01! --email solerniapiuser@orange.fr --firstname 'API' --lastname 'User' --city 'Paris' --country 'FR' 'api_user'"

	# Settings PF Name
	execute_moosh_command "moosh course-config-set course 1 fullname \"${CUSTOMER_THEMATIC}\""

	# Prevent course creator to create course in HOME PF
	execute_moosh_command "moosh role-update-capability solerni_course_creator moodle/course:create prevent 1"

}

main "$@"