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

	declare -a directories=("vagrant/override" 
	                        "vagrant/override/availability/condition"
	                        "vagrant/override/question/type"
	                        "vagrant/override/mod"
	                        "vagrant/override/auth"
	                        "vagrant/override/calendar/type"
	                        "vagrant/override/enrol"
	                        "vagrant/override/message/output"
	                        "vagrant/override/blocks"
	                        "vagrant/override/filter"
	                        "vagrant/override/lib/editor"
	                        "vagrant/override/course/format"
	                        "vagrant/override/user/profile/field"
	                        "vagrant/override/report"
	                        "vagrant/override/course/report"
	                        "vagrant/override/grade/export"
	                        "vagrant/override/grade/import"
	                        "vagrant/override/grade/report"
	                        "vagrant/override/grade/grading/form"
	                        "vagrant/override/mnet/service"
	                        "vagrant/override/webservice"
	                        "vagrant/override/repository"
	                        "vagrant/override/portfolio"
	                        "vagrant/override/question/behaviour"
	                        "vagrant/override/question/format"
	                        "vagrant/override/plagiarism"
	                        "vagrant/override/admin/tool"
	                        "vagrant/override/cache/stores"
	                        "vagrant/override/cache/locks"
	                        "vagrant/override/theme"
	                        "vagrant/override/mod/assign/submission"
	                        "vagrant/override/mod/assign/feedback"
	                        "vagrant/override/mod/assignment/type"
	                        "vagrant/override/mod/book/tool"
	                        "vagrant/override/mod/data/field"
	                        "vagrant/override/mod/data/preset"
	                        "vagrant/override/mod/lti/source"
	                        "vagrant/override/mod/quiz/report"
	                        "vagrant/override/mod/quiz/accessrule"
	                        "vagrant/override/mod/scorm/report"
	                        "vagrant/override/mod/workshop/form"
	                        "vagrant/override/mod/workshop/allocation"
	                        "vagrant/override/mod/workshop/eval"
	                        "vagrant/override/lib/editor/atto/plugins"
	                        "vagrant/override/lib/editor/tinymce/plugins"
	                        "vagrant/override/admin/tool/log/store"
	                        "vagrant/override/local"
	                        "vagrant/moodle"
	                        "vagrant/moodledata"
	                        "vagrant/moodledata/lang"
	                        "vagrant/solerni"
	                        "vagrant/system/root/backups/db"
	                        "vagrant/system/root/conf"
	                        "vagrant/system/mnt/samba")

	log_action "> Checking vagrant directories structure...";
	
	for directory in "${directories[@]}"; do
		if [[ -d ${BASE_DIR}/${directory} ]]; then
			log_info "+ The directory '${directory}' already exists."
		else
			mkdir -p "${BASE_DIR}/${directory}"
			log_info "+ The directory '${directory}' is created."
		fi
	done

	if [[ ! -d ${BASE_DIR}/vagrant/moodledata/lang/fr ]]; then

		log_action "> Installing french language for Moodle...";
		export http_proxy=http://niceway:3128 && export https_proxy=https://niceway:3128 && export ftp_proxy=http://niceway:3128

		wget -O vagrant/moodledata/lang/fr.zip https://download.moodle.org/download.php/direct/langpack/2.8/fr.zip
		log_info "+ The french language package is downloaded."
		cd vagrant/moodledata/lang
		unzip fr.zip
		log_info "+ The french language package is extracted."
		rm fr.zip

		log_ok "- DONE"
	fi
}

function main () {
	create_vagrant_share_directories
	exit 0;
}


main "$@"
