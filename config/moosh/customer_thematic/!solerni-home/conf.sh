#!/bin/bash

# The directory where this script is located
BASE_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

MODE=PROD
TRACE=1	

function init () {
	local parent_directory="$(dirname `pwd`)"
	local env_moosh_file=$parent_directory/conf/env_moosh.cfg
	if [ $TRACE -eq 1 ]; then
		log_action "> Loading Moosh environment '${env_moosh_file}'..."
	fi
	if [ -f $env_moosh_file ]; then
		. ${env_moosh_file}
		if [ $TRACE -eq 1 ]; then
			log_ok "- OK"
		fi
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
				;;
			-s| --silence)
				TRACE=0
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
	if [ $TRACE -eq 1 ]; then
		log_action "> Executing Moosh command '$1'..."
	fi
	local moosh_temp_stdout="/tmp/moosh-default-${INSTANCE_KEY}-default-stdout-temp-`date '+%d%m%Y%H%M%S%N'`"
	local moosh_temp_stderr="/tmp/moosh-default-${INSTANCE_KEY}-default-stderr-temp-`date '+%d%m%Y%H%M%S%N'`"

	local moosh_output=$(eval $1 2> $moosh_temp_stderr 1> $moosh_temp_stdout)

	sed -i '/^$/d' $moosh_temp_stdout
	sed -i '/^$/d' $moosh_temp_stderr

	if [ -s $moosh_temp_stdout ] && [ $TRACE -eq 1 ]; then
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
		if [ $TRACE -eq 1 ]; then
			log_ok "- OK"
		fi
	fi

	rm ${moosh_temp_stdout}
	rm ${moosh_temp_stderr}
}

function main () {
	init

	# Check usage mode : 
	# DEV or PROD (Default)
	check_usage $@

	# Manage blocks for 'forum' page (#us_413 - All forum in thematic)
	execute_moosh_command "moosh block-add system 0 orange_horizontal_numbers forum-index content -10"
	execute_moosh_command "moosh block-add system 0 orange_listforumng forum-index content -8"
	execute_moosh_command "moosh block-add system 0 orange_list_bestforumng forum-index content -4"

	# defaulthomepage = Dashboard for thematics only (#us_380)
	execute_moosh_command "moosh config-set defaulthomepage 1"

        # Settings Thematic Name
        execute_moosh_command "moosh course-config-set course 1 fullname \"${CUSTOMER_NAME} ${CUSTOMER_THEMATIC}\""

        # No default moodle blocks on frontpage
	execute_moosh_command "moosh config-set frontpage ''"

        # Bloc setup for frontpage
        execute_moosh_command "moosh block-delete system 0 orange_action site-index"
        execute_moosh_command "moosh block-delete system 0 orange_course_home site-index"
        execute_moosh_command "moosh block-delete system 0 orange_transverse_discussion site-index"
        execute_moosh_command "moosh block-delete system 0 orange_opinion site-index"

        execute_moosh_command "moosh block-add system 0 orange_action site-index content -10"
	execute_moosh_command "moosh block-add system 0 orange_course_home site-index content -7"
	execute_moosh_command "moosh block-add system 0 orange_transverse_discussion site-index content -2"
	execute_moosh_command "moosh block-add system 0 orange_opinion site-index content 7"

	# Add Main Menu block in /forum page (forum-index)
        execute_moosh_command "moosh block-add system 0 site_main_menu forum-index content -1"
}

main "$@"
