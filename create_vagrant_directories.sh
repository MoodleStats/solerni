#!/bin/bash

# The directory where this script is located
BASE_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

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

function create_vagrant_share_directories () {

	declare -a directories=("vagrant/override" "vagrant/moodle" "vagrant/moodledata" "vagrant/solerni" "vagrant/system/root/backups/db" "vagrant/system/mnt/samba")

	log_action "> Checking vagrant directories structure...";
	
	for directory in "${directories[@]}"; do
		if [[ -d ${BASE_DIR}/${directory} ]]; then
			log_info "+ The directory '${directory}' already exists."
		else
			mkdir -p "${BASE_DIR}/${directory}"
			log_info "+ The directory '${directory}' is created."
		fi
	done

	log_ok "- DONE"
}

function main () {
	create_vagrant_share_directories
	exit 0;
}


main "$@"
