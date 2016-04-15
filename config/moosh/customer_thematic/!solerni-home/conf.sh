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
	local moosh_temp_stdout="/tmp/moosh-default-${INSTANCE_KEY}-default-stdout-temp-`date '+%d%m%Y%H%M%S%N'`"
	local moosh_temp_stderr="/tmp/moosh-default-${INSTANCE_KEY}-default-stderr-temp-`date '+%d%m%Y%H%M%S%N'`"

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

	# Manage blocks for 'forum' page (#us_413 - All forum in thematic)
	execute_moosh_command "moosh block-add system 0 orange_horizontal_numbers forum-index content -10"
	execute_moosh_command "moosh block-add system 0 orange_listforumng forum-index content -8"
	execute_moosh_command "moosh block-add system 0 orange_list_bestforumng forum-index content -4"
}

main "$@"
