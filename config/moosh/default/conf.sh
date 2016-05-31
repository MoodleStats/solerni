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
	# Check usage mode : 
	# DEV or PROD (Default)
	check_usage $@

	init

	# add conf for external logs (#us_289)
	execute_moosh_command "moosh config-set enabled_stores logstore_standard,logstore_database tool_log"
	execute_moosh_command "moosh config-set dbdriver native/mysqli logstore_database"
	execute_moosh_command "moosh config-set dbhost ${CUSTOMER_LOG_DB_HOST} logstore_database"
	execute_moosh_command "moosh config-set dbuser ${CUSTOMER_LOG_DB_USERNAME} logstore_database"
	execute_moosh_command "moosh config-set dbpass ${CUSTOMER_LOG_DB_PASSWORD} logstore_database"
	execute_moosh_command "moosh config-set dbname ${CUSTOMER_LOG_DB_NAME} logstore_database"
	execute_moosh_command "moosh config-set dbtable mdl_logstore_standard_log logstore_database"

	# add conf for Piwik (Analytics) (#us_292)
	execute_moosh_command "moosh config-set siteurl ${CUSTOMER_PIWIK_URL} local_analytics"
	execute_moosh_command "moosh config-set location footer local_analytics"
	execute_moosh_command "moosh config-set trackadmin 1 local_analytics"

	# First install : import Solerni roles
	# Attention : order is important to keep roles assignments
	execute_moosh_command "moosh role-import solerni_utilisateur /opt/solerni/conf/moosh/default/users_roles/solerni_utilisateur.xml"
	execute_moosh_command "moosh role-import solerni_apprenant  /opt/solerni/conf/moosh/default/users_roles/solerni_apprenant.xml"
	execute_moosh_command "moosh role-import solerni_power_apprenant /opt/solerni/conf/moosh/default/users_roles/solerni_power_apprenant.xml"
	execute_moosh_command "moosh role-import solerni_animateur /opt/solerni/conf/moosh/default/users_roles/solerni_animateur.xml"
	execute_moosh_command "moosh role-import solerni_client /opt/solerni/conf/moosh/default/users_roles/solerni_client.xml"
	execute_moosh_command "moosh role-import solerni_teacher /opt/solerni/conf/moosh/default/users_roles/solerni_teacher.xml"
	execute_moosh_command "moosh role-import solerni_marketing /opt/solerni/conf/moosh/default/users_roles/solerni_marketing.xml"
	execute_moosh_command "moosh role-import solerni_course_creator /opt/solerni/conf/moosh/default/users_roles/solerni_course_creator.xml"

	# Default role for all users (#us_62-69)
	execute_moosh_command "moosh role-configset defaultuserroleid solerni_utilisateur"

	# Creators' role in new courses (#us_62-69)
	execute_moosh_command "moosh role-configset creatornewroleid solerni_course_creator"

	# Restorers' role in courses (#us_62-69)
	execute_moosh_command "moosh role-configset restorernewroleid solerni_course_creator"

	# Default role assignment - Plugin Enrolments/Self enrolment (#us_62-69)
	execute_moosh_command "moosh role-configset roleid solerni_apprenant enrol_self"

	# Self registration (#us_6)
	execute_moosh_command "moosh config-set registerauth email"

	# Enabled - Plugin Local/Goodbye (#us_9)
	execute_moosh_command "moosh config-set enabled 1 local_goodbye"

	# Guest login button (#us_119)
	execute_moosh_command "moosh config-set guestloginbutton 0"

	# Default Course format (#us_77)
	execute_moosh_command "moosh config-set format flexpage moodlecourse"

	# Default Theme (#us_185 and #us_186)
	execute_moosh_command "moosh config-set theme halloween"

	# Maximum number of moocs to display in frontPage (#us_114 and #us_119)
	execute_moosh_command "moosh config-set frontpagecourselimit 5"

	# Default lang
	execute_moosh_command "moosh config-set lang fr"

	# User policies : hide user fields (#us_110)
	execute_moosh_command "moosh config-set hiddenuserfields icqnumber,skypeid,yahooid,aimid,msnid,lastip"

	# Activation multilang Filter (#us_110)
	execute_moosh_command "moosh filter-manage -c on multilang"

	# Add new user profil fields (#us_110)
	execute_moosh_command "moosh userprofilefields-import /opt/solerni/conf/moosh/default/users_profil/profile_fields.csv"

	# Enable cron via the web (Security)
	execute_moosh_command "moosh config-set cronclionly 1"

	# Completion tracking 'moodlecourse/enablecompletion' (#us_99)
	execute_moosh_command "moosh config-set enablecompletion 1 moodlecourse"

	# Default role assignment - Plugin Enrolments/Manual enrolment
	execute_moosh_command "moosh role-configset roleid solerni_apprenant enrol_manual"

	# Force Apache mod_rewrite - Plugin Local/Static Pages (#us_71)
	execute_moosh_command "moosh config-set apacherewrite 1 local_staticpage"

	# Manage enrolment method
	execute_moosh_command "moosh enrol-manage enable orangeinvitation"
	execute_moosh_command "moosh enrol-manage enable self"
	execute_moosh_command "moosh enrol-manage enable orangenextsession"
	execute_moosh_command "moosh enrol-manage disable cohort"
	execute_moosh_command "moosh enrol-manage disable guest"

	# Profile visible roles : List of roles that are visible on user profiles and participation page
	execute_moosh_command "moosh role-configset profileroles solerni_apprenant,solerni_power_apprenant,solerni_animateur,solerni_teacher"

	# Modify Document directory - Plugin Local/Static Pages (#us_71)
	execute_moosh_command "moosh config-set documentdirectory ${CUSTOMER_STATIC_DIRECTORY} local_staticpage"

	# Path of geoipfile for geolocation (#us_247)
	execute_moosh_command "moosh config-set geoipfile ${GEOIP_FILE_PATH}"

	# Block Orange course Dashboard (#us_102)
	execute_moosh_command "moosh config-set catalogurl /catalog block_orange_course_dashboard"
	execute_moosh_command "moosh config-set hideblockheader 1 block_orange_course_dashboard"

	# Manage blocks for 'Dashboard' page (badges + course overview deleted)
	execute_moosh_command "moosh block-delete system 0 badges my-index"
	execute_moosh_command "moosh block-delete system 0 course_overview my-index"
	execute_moosh_command "moosh block-delete system 0 calendar_upcoming my-index"
	execute_moosh_command "moosh block-delete system 0 calendar_month my-index"
	execute_moosh_command "moosh block-delete system 0 news_items my-index"
	execute_moosh_command "moosh block-delete system 0 orange_last_message my-index"

	# Manage blocks for 'my' page (Dashboard)
	execute_moosh_command "moosh block-add system 0 orange_action my-index content -10"
	execute_moosh_command "moosh block-add system 0 orange_course_dashboard my-index content -9"
        execute_moosh_command "moosh block-add system 0 orange_emerging_messages my-index content -8"
	execute_moosh_command "moosh block-add system 0 orange_badges my-index content -7"
	execute_moosh_command "moosh block-add system 0 private_files my-index content -6"

	# Enable self enrolment method in new courses - Plugin Enrolments/Self enrolment
	# /!\ this value is reversed 0 => true, 1 => false
	execute_moosh_command "moosh config-set status 0 enrol_self"

	# Maximum number of moocs when list of Moocs is displayed
	execute_moosh_command "moosh config-set coursesperpage 5"

	# Mnet (#us_326)
	execute_moosh_command "moosh config-set mnet_dispatcher_mode strict"
	execute_moosh_command "moosh config-set mnet_register_allhosts 0"
	execute_moosh_command "moosh config-set sessioncookie ${CUSTOMER_COOKIE_PREFIX}"
	execute_moosh_command "moosh peer-add ${MNET_PEER}"

	# oauth2: do not display buttons on login page
	execute_moosh_command "moosh config-set oauth2displaybuttons 0 'auth/googleoauth2'"

	# Enable Mnet authentication method (#us_326)
	execute_moosh_command "moosh auth-manage enable mnet"

	# SMTP hosts : SMTP servers that Moodle use to send mail
	execute_moosh_command "moosh config-set smtphosts ${SMTP_SERVER}"

	# Create a support user (normally id=3)
	execute_moosh_command "moosh user-create --password pass --email ${CUSTOMER_CONTACT_USER_EMAIL} --firstname 'Contact' --lastname 'Solerni' --city 'Paris' --country 'FR' 'supportuser'"

	# disable default messaging system (#us_226)
	execute_moosh_command "moosh config-set messaging 0"

	# Completion tracking for progressbar 'moodle/enablecompletion' (#us_99)
	execute_moosh_command "moosh config-set enablecompletion 1"

	# Authorize login with email adress as well as username in login form
	execute_moosh_command "moosh config-set authloginviaemail 1"

	# Enable cookie secure
	execute_moosh_command "moosh config-set cookiesecure 1"

	# Disallow automatic updates
	execute_moosh_command "moosh config-set updateautocheck 0"

	# Timezone
	#moosh timezone-import Europe/paris
	execute_moosh_command "moosh config-set timezone Europe/Paris"

	# support contact : Admin > Server > Support contact
	execute_moosh_command "moosh config-set supportname \"Contact Solerni\""
	execute_moosh_command "moosh config-set supportemail ${CUSTOMER_CONTACT_USER_EMAIL}"

	# support contacts (#us_288)
	execute_moosh_command "moosh username-configset supportuserid supportuser"
	execute_moosh_command "moosh username-configset noreplyuserid supportuser"

	# orangenextsession (#us_26)
	execute_moosh_command "moosh config-set defaultenrol 1 enrol_orangenextsession"
	# /!\ this value is reversed 0 => true, 1 => false
	execute_moosh_command "moosh config-set status 0 enrol_orangenextsession"

	# orangeinvitation
	execute_moosh_command "moosh config-set defaultenrol 1 enrol_orangeinvitation"
	# /!\ this value is reversed 0 => true, 1 => false
	execute_moosh_command "moosh config-set status 0 enrol_orangeinvitation"

	# Add cache store memcached
	# moosh cache-admin --servers ${MEMCACHED_CACHE_SERVER} --prefix ${MEMCACHED_CACHE_PREFIX} memcached addstore ${MEMCACHED_CACHE_NAME}
	# moosh cache-admin memcached editmodemappings ${MEMCACHED_CACHE_NAME}

	# Make Anonymous : add empty mail subject & msg
	execute_moosh_command "moosh config-set emailsubject '' local_eledia_makeanonymous"
	execute_moosh_command "moosh config-set emailmsg '' local_eledia_makeanonymous"

	# Generate mail string html/txt
	execute_moosh_command "moosh mail-generate"

	# Default frontpage role : changed to allow access to the general ForumNg
	execute_moosh_command "moosh role-configset defaultfrontpageroleid solerni_utilisateur"

	# Inverse Last Name and First Name in Signup Form
	execute_moosh_command "moosh config-set fullnamedisplay \"lastname, firstname\""

	# local_orangemail : add email support, contact...
	execute_moosh_command "moosh config-set contactemail ${CUSTOMER_CONTACT_USER_EMAIL} local_orangemail"
	execute_moosh_command "moosh config-set supportemail ${CUSTOMER_SUPPORT_USER_EMAIL} local_orangemail"
	execute_moosh_command "moosh config-set marketemail ${CUSTOMER_MARKET_USER_EMAIL} local_orangemail"
	execute_moosh_command "moosh config-set partneremail ${CUSTOMER_PARTNER_USER_EMAIL} local_orangemail"
	execute_moosh_command "moosh config-set noreplyemail ${CUSTOMER_NOREPLY_USER_EMAIL} local_orangemail"
	execute_moosh_command "moosh config-set integratoremail ${CUSTOMER_DATA_INTEGRATOR_USER_EMAIL} local_orangemail"
	execute_moosh_command "moosh config-set noreplyaddress ${CUSTOMER_NOREPLY_USER_EMAIL}"

	# Hide some activities
	execute_moosh_command "moosh module-manage hide assign"
	execute_moosh_command "moosh module-manage hide assignment"
	execute_moosh_command "moosh module-manage hide book"
	execute_moosh_command "moosh module-manage hide chat"
	execute_moosh_command "moosh module-manage hide choice"
	execute_moosh_command "moosh module-manage show data"
	execute_moosh_command "moosh module-manage hide feedback"
	execute_moosh_command "moosh module-manage show forum"
	execute_moosh_command "moosh module-manage hide imscp"
	execute_moosh_command "moosh module-manage hide lesson"
	execute_moosh_command "moosh module-manage hide lti"
	execute_moosh_command "moosh module-manage hide scorm"
	execute_moosh_command "moosh module-manage hide survey"
	execute_moosh_command "moosh module-manage hide url"
	execute_moosh_command "moosh module-manage hide wiki"

	# Set default Store (unable memcached)
	execute_moosh_command "moosh cache-admin memcached editmodemappings \"default_application\""

	# Page contact
	execute_moosh_command "moosh config-set footerlistscolumn2link2 ${CUSTOMER_HTTP_BASE_URL}/contact/ theme_halloween"

	# Settings PF Name shortname
	execute_moosh_command "moosh course-config-set course 1 shortname ${CUSTOMER_THEMATIC}"

	# block_orange_action (#us_458)
	execute_moosh_command "moosh config-set hideblockheader 1 block_orange_action"

	# Disable Oauth2 authentication method
	execute_moosh_command "moosh auth-manage disable googleoauth2"

	# block_orange_course_dashboard
	execute_moosh_command "moosh config-set defaultmaxrecommendations 0 block_orange_course_dashboard"
	execute_moosh_command "moosh config-set mymoocsurl '/moocs/mymoocs.php' block_orange_course_dashboard"

	# local_goodbye : delete value to keep default text (#us_442)
	execute_moosh_command "moosh config-set farewell "" local_goodbye"

	# hide block admin for solerni_utilisateur, solerni_apprenant, solerni_power_apprenant, solerni_animateur, solerni_client (#us_252)
	execute_moosh_command "moosh role-update-capability-ctx solerni_utilisateur moodle/block:view prevent block settings"
	execute_moosh_command "moosh role-update-capability-ctx solerni_apprenant moodle/block:view prevent block settings"
	execute_moosh_command "moosh role-update-capability-ctx solerni_power_apprenant moodle/block:view prevent block settings"
	execute_moosh_command "moosh role-update-capability-ctx solerni_animateur moodle/block:view prevent block settings"
	execute_moosh_command "moosh role-update-capability-ctx solerni_client moodle/block:view prevent block settings"
	execute_moosh_command "moosh role-update-capability-ctx solerni_teacher moodle/block:view allow block settings"
	execute_moosh_command "moosh role-update-capability-ctx solerni_course_creator moodle/block:view allow block settings"
	execute_moosh_command "moosh role-update-capability-ctx solerni_marketing moodle/block:view allow block settings"

	# cgu = '' on all platforms except HOME, if a value exists in config.php, it will be kept (#us_485)
	execute_moosh_command "moosh config-set sitepolicy ''"

	# disable external open badges
	execute_moosh_command "moosh config-set badges_allowexternalbackpack 0"

	# Hide blocks for solerni_teacher (#us_507)
	execute_moosh_command "moosh block-manage hide admin_bookmarks"
	execute_moosh_command "moosh block-manage hide badges"
	execute_moosh_command "moosh block-manage hide blog_menu"
	execute_moosh_command "moosh block-manage hide blog_recent"
	execute_moosh_command "moosh block-manage hide blog_tags"
	execute_moosh_command "moosh block-manage hide comments"
	execute_moosh_command "moosh block-manage hide community"
	execute_moosh_command "moosh block-manage hide completionstatus"
	execute_moosh_command "moosh block-manage hide course_list"
	execute_moosh_command "moosh block-manage hide course_list"
	execute_moosh_command "moosh block-manage hide course_overview"
	execute_moosh_command "moosh block-manage hide course_summary"
	execute_moosh_command "moosh block-manage hide feedback"
	execute_moosh_command "moosh block-manage hide login"
	execute_moosh_command "moosh block-manage hide mentees"
	execute_moosh_command "moosh block-manage hide messages"
	execute_moosh_command "moosh block-manage hide mnet_hosts"
	execute_moosh_command "moosh block-manage hide myprofile"
	execute_moosh_command "moosh block-manage hide news_items"
	execute_moosh_command "moosh block-manage hide participants"
	execute_moosh_command "moosh block-manage hide recent_activity"
	execute_moosh_command "moosh block-manage hide search_forums"
	execute_moosh_command "moosh block-manage hide section_links"
	execute_moosh_command "moosh block-manage hide selfcompletion"
	execute_moosh_command "moosh block-manage show site_main_menu"
	execute_moosh_command "moosh block-manage hide social_activities"
	execute_moosh_command "moosh block-manage hide tag_flickr"
	execute_moosh_command "moosh block-manage hide tag_youtube"

	# disable editors 'plain text' and 'Atto HTML'
	execute_moosh_command "moosh editor-manage disable atto"
	execute_moosh_command "moosh editor-manage disable textarea"

	# Blog : enableblogs to false (#us_468)
	execute_moosh_command "moosh config-set enableblogs 0"

	# block_orange_course_dashboard (#us_307)
	execute_moosh_command "moosh block-instance_config system 0 orange_course_dashboard my-index defaultmaxrecommendations 0"

	# disable 'Popup' and 'Jabber' notification in Plugins/Messages outputs (#us_468)
	execute_moosh_command "moosh message-manage disable jabber"
	execute_moosh_command "moosh message-manage disable popup"

	# Set defaut email for badge (#us_468)
	execute_moosh_command "moosh config-set message_provider_moodle_badgerecipientnotice_loggedin popup,email message"
	execute_moosh_command "moosh config-set message_provider_moodle_badgecreatornotice_loggedin email message"

	# Set import/export fields for Mnet user profil copy (#us_486)
	execute_moosh_command "moosh peer-fields policyagreed,suspended,idnumber,emailstop,icq,skype,yahoo,aim,msn,phone1,phone2,institution,department,address,city,country,lang,calendartype,timezone,firstaccess,lastaccess,lastlogin,currentlogin,secret,picture,url,description,descriptionformat,mailformat,maildigest,maildisplay,autosubscribe,trackforums,trustbitmask,imagealt,lastnamephonetic,firstnamephonetic,middlename,alternatename"

	# Set user fullname format (#us_504)
	execute_moosh_command "moosh config-set fullnamedisplay \"firstname lastname\""
	execute_moosh_command "moosh config-set emailonlyfromnoreplyaddress 1"

        # Set blocks for find out more page (#us_397)
	execute_moosh_command "moosh block-add system 0 orange_action mooc-view content -10"
	execute_moosh_command "moosh block-add system 0 orange_iconsmap mooc-view content -9"
	execute_moosh_command "moosh block-add system 0 orange_separator_line mooc-view content -8"
	execute_moosh_command "moosh block-add system 0 orange_social_sharing mooc-view content -7"
	execute_moosh_command "moosh block-add system 0 orange_paragraph_list mooc-view content -6"

        # Webservice activation for all PTF (#us_501)
        # Web Services Activation On Home
	execute_moosh_command "moosh config-set enablewebservices 1"
	# Activate REST
	execute_moosh_command "moosh config-set webserviceprotocols rest"
	#Import Role
	execute_moosh_command "moosh role-import api_user /opt/solerni/conf/moosh/default/users_roles/solerniapiuser.xml"
	# Create API User
	execute_moosh_command "moosh user-create --password apiuser01! --email solerniapiuser@orange.fr --firstname 'API' --lastname 'User' --city 'Paris' --country 'FR' 'api_user'"

	# Disable some quiz question type qtype (#us_478)
	execute_moosh_command "moosh qtype-manage disable calculatedmulti"
	execute_moosh_command "moosh qtype-manage disable calculatedsimple"
	execute_moosh_command "moosh qtype-manage disable calculated"
	execute_moosh_command "moosh qtype-manage disable essay"
	execute_moosh_command "moosh qtype-manage disable multianswer"
	execute_moosh_command "moosh qtype-manage disable randomsamatch"

        # Delete block_orange_course_extended
        execute_moosh_command "moosh block-delete course all orange_course_extended course-view-*"
        
        # Admin Block : change settings pagetypepattern=* to make it visible
	execute_moosh_command "moosh block-update system 0 'settings' 'pagetypepattern' '*'"

        # Navigation Block : change settings pagetypepattern=course-view-* to make it visible only in course pages
	execute_moosh_command "moosh block-update system 0 'navigation' 'pagetypepattern' 'course-view-*'"

	# Activation emoticon, glossary, urltolink, emailprotect Filter (#us_217)
	execute_moosh_command "moosh filter-manage -c on emoticon"
	execute_moosh_command "moosh filter-manage -c on glossary"
	execute_moosh_command "moosh filter-manage -c on urltolink"
	execute_moosh_command "moosh filter-manage -c on emailprotect"

	# Activation place buttons in tinyMCE toolbar (#us_217)
        #FIXME : can't use 'execute_moosh_command' function (the newline is misinterpreted)
        moosh config-set customtoolbar "wrap,formatselect,wrap,bold,italic,wrap,bullist,numlist,wrap,link,unlink,wrap,image,moodleemoticon,wrap,code
 
            undo,redo,wrap,underline,strikethrough,sub,sup,wrap,justifyleft,justifycenter,justifyright,wrap,outdent,indent,wrap,forecolor,backcolor,wrap,ltr,rtl
 
            fontselect,fontsizeselect,wrap,search,replace,wrap,nonbreaking,charmap,table,wrap,code,cleanup,removeformat,pastetext,pasteword,wrap,mediagallery,wrap,fullscreen
            " editor_tinymce

	# Add Main Menu block in frontpage (course=1)
	execute_moosh_command "moosh block-add course 1 site_main_menu site-index side-pre 1"

        # hide block main menu for solerni_utilisateur, solerni_apprenant, solerni_power_apprenant, solerni_animateur, solerni_client, guest
	execute_moosh_command "moosh role-update-capability-ctx --id 1 solerni_utilisateur moodle/block:view prevent block_in_course site_main_menu"
	execute_moosh_command "moosh role-update-capability-ctx --id 1 solerni_apprenant moodle/block:view prevent block_in_course site_main_menu"
	execute_moosh_command "moosh role-update-capability-ctx --id 1 solerni_power_apprenant moodle/block:view prevent block_in_course site_main_menu"
	execute_moosh_command "moosh role-update-capability-ctx --id 1 solerni_animateur moodle/block:view prevent block_in_course site_main_menu"
	execute_moosh_command "moosh role-update-capability-ctx --id 1 solerni_client moodle/block:view prevent block_in_course site_main_menu"
	execute_moosh_command "moosh role-update-capability-ctx --id 1 guest moodle/block:view prevent block_in_course site_main_menu"
	execute_moosh_command "moosh role-update-capability-ctx --id 1 solerni_teacher moodle/block:view allow block_in_course site_main_menu"
	execute_moosh_command "moosh role-update-capability-ctx --id 1 solerni_course_creator moodle/block:view allow block_in_course site_main_menu"
	execute_moosh_command "moosh role-update-capability-ctx --id 1 solerni_marketing moodle/block:view allow block_in_course site_main_menu"

        # Delete activity forum in frontpage (course=1)
        execute_moosh_command "moosh activity-delete --name forum course 1"
}

main "$@"
