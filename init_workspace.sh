#!/bin/bash

#######
##
## @Copyright	: orange
## @author 	: Nicolas Chauvin
## @author 	: Simon Vart
##
####### The main point of this script is to : 
## 	- keeps track of all required repositories for a Solerni instance
## 	- easily deploy development environment with subtrees remotes
##
## This script will download and install a development VM
## and creating the workspace with all plugins
##
####### Using subtrees
## 
## We use subtrees to maitain the Solerni/Moodle working directory
## All remotes (official third-party repos and orange repos) are named remote-source
## All remote fork from which some pull-request could be requested will be named remote-fork (non currently)
##
####### Quick note of all current remote names :
## 	- moodle-source 	: official Moodle Mirror (Github)	
## 	- theme-source 		: Solerni Theme (Orange Forge)
## 	- flavours-source 	: official Moodle Mirror (Github)
## 	- navbuttons-source 	: official Moodle Mirror (Github)
## 	- progressbar-source 	: official Moodle Mirror (Github)
## 	- customlabel-source 	: official Moodle Mirror (Github)
## 	- flexibleformat-source : official Moodle Mirror (Github)
## 	- flexpageformat-source : official Moodle Mirror (Github)
## 	- goodbye-source 	: official Moodle Mirror (Github)
## 	- makeanon-source 	: official Moodle Mirror (Github)
## 	- autoenrol-source 	: official Moodle Mirror (Github)
##
## Wiki documentation : https://www.forge.orange-labs.fr/plugins/mediawiki/wiki/e-educ/index.php/Les_plugins_%C3%A0_installer
##
########

# The directory where this script is located
BASE_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

# Log functions
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

# Create directories
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
		cd -

		log_ok "- DONE"
	fi
}

# Abort when error
function abort () {
    log_error 'Return code superior to 0. Abort ! Abort !'
    exit $?
}

# Check return status
function check_status () {
  if [ $? -ne 0 ]; then
    abort
  fi
}


# Add remote and fetch, deploy working directory and split branch for history
# $1 is prefix, $2 is remote name, $3 is remote url, $4 is remote branch to deploy
function init_subtree {

  if [ $# -ne "4" ]; then
    log_error '+ Illegal numbers of parameters';
    exit $?
  fi

  log_action "> Init subtree: $2"

  #Add remote if not exists
  log_action "> Checking remote..."
  git ls-remote --exit-code $2 &> /dev/null
  if [ $? -ne 0 ]; then
    ADD_REMOTE='git remote add -f '$2' '$3;
    log_action "> Adding remote: $ADD_REMOTE"
    $ADD_REMOTE
  else
    log_info "+ Remote already present" 
  fi

  check_status
  
  #Deploy subtree if directory not present
  log_action "> Checking subtree..."
  if [ ! -d $1 ]; then
    cd ${BASE_DIR}
    CREATE_SUBTREE='git subtree add --prefix='$1' '$2' '$4' --squash';
    log_action "> Create subtree: $CREATE_SUBTREE"
    $CREATE_SUBTREE

    check_status

    # Spliting into branch for history
    SPLIT_SUBTREE='git subtree split --prefix='$1' --annotate="ANNOTE_'$2'" --branch '$2
    log_action "> Spliting subtree: $SPLIT_SUBTREE"
    $SPLIT_SUBTREE
  else
    log_info "+ Subtree already present. Doing nothing."
  fi

  check_status
  
  log_ok "- Done with: $2"
}


#########
# Command
#########
#@Todo : store variables in a file to automate pull & push operation on each subtree by giving the remote name as parameter
#@Todo : adding update / remove command for a specific remote / subtree
#########


# Install Moodle, Theme and Plugins as subtrees, deploy working directory
function create_subtrees () {
	# Moodle
	init_subtree vagrant/moodle moodle-source https://github.com/moodle/moodle.git MOODLE_27_STABLE

	# Theme Solerni
	#@Todo : type branch as command parameter to deploy either develop or master or orange branch
	init_subtree vagrant/solerni/theme/solerni theme-source https://www.forge.orange-labs.fr/git/e-educ/solerni_theme.git develop

	##########
	# Plugins
	##########
	#@Todo: workflow when forking a plugin (defining different remotes and/or branch to pull/push)
	##########

	# Flavours (master = 1.7.2)
	init_subtree vagrant/solerni/local/flavours flavours-source https://github.com/dmonllao/moodle-local_flavours.git master

	# Navigation Buttons (master = 2.2)
	init_subtree vagrant/solerni/block/navbuttons navbuttons-source https://github.com/davosmith/moodle-navbuttons.git master

	# oAuth Google (master = 1.5)
	init_subtree vagrant/solerni/auth/googleoauth2 goauth-source https://github.com/mouneyrac/moodle-auth_googleoauth2.git master

	# Progress bar (master = 2015021100)
	init_subtree vagrant/solerni/block/progressbar progressbar-source https://github.com/deraadt/Moodle-block_progress.git master

	# Course Element (master = 2.4.0)
	init_subtree vagrant/solerni/mod/customlabel customlabel-source https://github.com/vfremaux/moodle-mod_customlabel.git master

	# Flexible Format (master = 2.8.1)
	init_subtree vagrant/solerni/course/format/flexible flexibleformat-source https://github.com/marinaglancy/moodle-format_flexsections.git MOODLE_27_STABLE

	# Flexpage Format (master = 2.7.0)
	init_subtree vagrant/solerni/course/format/flexpage flexpageformat-source https://github.com/moodlerooms/moodle-format_flexpage.git master

	# Goodbye (master = 1)
	init_subtree vagrant/solerni/local/goodbye goodbye-source https://github.com/bmbrands/moodle-local_goodbye.git master

	# Makeanonymous (tag v_28 = 0.5)
	init_subtree vagrant/solerni/local/makeanonymous makeanon-source https://github.com/eledia/local_eledia_makeanonymous.git v_28

	# Autoenrol (master = 1.3)
	init_subtree vagrant/solerni autoenrol-source https://github.com/markward/enrol_autoenrol.git master
}


# Start main 
function main () {
	create_vagrant_share_directories
	create_subtrees
	exit 0;
}

main "$@"
