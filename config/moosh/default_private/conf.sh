#!/bin/bash

# The directory where this script is located
BASE_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

MODE=PROD

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

function check_usage () {
	while true; do

		if [ -z "$1" ]; then
			break
		fi

		case $1 in
			-dev|--development)
				MODE=DEV
				shift
				;;
			*)
				shift
				;;
		esac

		shift
	done
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
	local moosh_temp_stdout="/tmp/moosh-default-${INSTANCE_KEY}-default-private-stdout-temp-`date '+%d%m%Y%H%M%S%N'`"
	local moosh_temp_stderr="/tmp/moosh-default-${INSTANCE_KEY}-default-private-stderr-temp-`date '+%d%m%Y%H%M%S%N'`"

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
			if [ "$MODE" == "PROD" ]; then
				exit -1
			fi
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

	# Check usage mode : 
	# DEV or PROD (Default)
	check_usage $@

	# Force users to log in (#us_119)
	execute_moosh_command "moosh config-set forcelogin 1"

	# unenrolself is only for students in public PF
	execute_moosh_command "moosh role-update-capability solerni_apprenant enrol/self:unenrolself prevent 1"
	execute_moosh_command "moosh role-update-capability solerni_apprenant enrol/manual:unenrolself prevent 1"
}

main "$@"
