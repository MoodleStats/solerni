#!/bin/bash
# Fichier "default/conf.sh"

# load of ansible variables us_290 us_292 us_71 us_247
if [ -f ../../conf/env_moosh.cfg ]; then
. ../../conf/env_moosh.cfg
fi
if [ -f ../conf/env_moosh.cfg ]; then
. ../conf/env_moosh.cfg
fi

# add conf for external logs (#us_289)
moosh config-set enabled_stores logstore_standard,logstore_database tool_log
moosh config-set dbdriver native/mysqli logstore_database
moosh config-set dbhost ${CUSTOMER_LOG_DB_HOST} logstore_database
moosh config-set dbuser ${CUSTOMER_LOG_DB_USERNAME} logstore_database
moosh config-set dbpass ${CUSTOMER_LOG_DB_PASSWORD} logstore_database
moosh config-set dbname ${CUSTOMER_LOG_DB_NAME} logstore_database
moosh config-set dbtable mdl_logstore_standard_log logstore_database

# add conf for Piwik (Analytics) (#us_292)
echo ${CUSTOMER_PIWIK_URL}
moosh config-set siteurl ${CUSTOMER_PIWIK_URL} local_analytics
moosh config-set location footer local_analytics
moosh config-set trackadmin 1 local_analytics

# First install : import Solerni roles
# Attention : order is important to keep roles assignments
moosh role-import solerni_utilisateur solerni-config/default/users_roles/solerni_utilisateur.xml
moosh role-import solerni_apprenant solerni-config/default/users_roles/solerni_apprenant.xml
moosh role-import solerni_power_apprenant solerni-config/default/users_roles/solerni_power_apprenant.xml
moosh role-import solerni_animateur solerni-config/default/users_roles/solerni_animateur.xml
moosh role-import solerni_client solerni-config/default/users_roles/solerni_client.xml
moosh role-import solerni_teacher solerni-config/default/users_roles/solerni_teacher.xml
moosh role-import solerni_marketing solerni-config/default/users_roles/solerni_marketing.xml
moosh role-import solerni_course_creator solerni-config/default/users_roles/solerni_course_creator.xml

# Default role for all users (#us_62-69)
moosh role-configset defaultuserroleid solerni_utilisateur

# Creators' role in new courses (#us_62-69)
moosh role-configset creatornewroleid solerni_course_creator

# Restorers' role in courses (#us_62-69)
moosh role-configset restorernewroleid solerni_course_creator

# Default role assignment - Plugin Enrolments/Self enrolment (#us_62-69)
moosh role-configset roleid solerni_apprenant enrol_self

# Self registration (#us_6)
moosh config-set registerauth email

# Enabled - Plugin Local/Goodbye (#us_9)
moosh config-set enabled 1 local_goodbye

# Guest login button (#us_119)
moosh config-set guestloginbutton 0

# Default Course format (#us_77)
moosh config-set format flexpage moodlecourse

# Default Theme (#us_185 and #us_186)
moosh config-set theme halloween

# Maximum number of moocs to display in frontPage (#us_114 and #us_119)
moosh config-set frontpagecourselimit 5

# Default lang
moosh config-set lang fr

# User policies : hide user fields (#us_110)
moosh config-set hiddenuserfields icqnumber,skypeid,yahooid,aimid,msnid,lastip

# Activation multilang Filter (#us_110)
moosh filter-manage -c on multilang

# Add new user profil fields (#us_110)
moosh userprofilefields-import solerni-config/default/users_profil/profile_fields.csv

# Enable cron via the web (Security)
moosh config-set cronclionly 1

# Completion tracking 'moodlecourse/enablecompletion' (#us_99)
moosh config-set enablecompletion 1 moodlecourse

# Default role assignment - Plugin Enrolments/Manual enrolment
moosh role-configset roleid solerni_apprenant enrol_manual

# Force Apache mod_rewrite - Plugin Local/Static Pages (#us_71)
moosh config-set apacherewrite 1 local_staticpage

# Manage enrolment method
moosh enrol-manage enable orangeinvitation
moosh enrol-manage enable self
moosh enrol-manage enable orangenextsession
moosh enrol-manage disable cohort
moosh enrol-manage disable guest

# Profile visible roles : List of roles that are visible on user profiles and participation page
moosh role-configset profileroles solerni_apprenant,solerni_power_apprenant,solerni_animateur,solerni_teacher

# Modify Document directory - Plugin Local/Static Pages (#us_71)
moosh config-set documentdirectory ${CUSTOMER_STATIC_DIRECTORY} local_staticpage

# Path of geoipfile for geolocation (#us_247)
moosh config-set geoipfile ${GEOIP_FILE_PATH}

# Block Orange course Dashboard (#us_102)
moosh config-set catalogurl /catalog block_orange_course_dashboard
moosh config-set hideblockheader 1 block_orange_course_dashboard

# Manage blocks for 'Dashboard' page (badges + course overview deleted)
moosh block-delete system 0 badges my-index
moosh block-delete system 0 course_overview my-index
moosh block-delete system 0 calendar_upcoming my-index
moosh block-delete system 0 calendar_month my-index
moosh block-delete system 0 news_items my-index
moosh block-delete system 0 orange_last_message my-index

# Manage blocks for 'my' page (Dashboard)
moosh block-add system 0 orange_action my-index content -10
moosh block-add system 0 orange_course_dashboard my-index content -9
# moosh block-add system 0 <block forum> my-index content -8
moosh block-add system 0 orange_badges my-index content -7
moosh block-add system 0 private_files my-index content -6

# Enable self enrolment method in new courses - Plugin Enrolments/Self enrolment
# /!\ this value is reversed 0 => true, 1 => false
moosh config-set status 0 enrol_self

# Maximum number of moocs when list of Moocs is displayed
moosh config-set coursesperpage 5

# Mnet (#us_326)
moosh config-set mnet_dispatcher_mode strict
moosh config-set mnet_register_allhosts 0
moosh config-set sessioncookie ${CUSTOMER_COOKIE_PREFIX}
moosh peer-add ${MNET_PEER}

# oauth2: do not display buttons on login page
moosh config-set oauth2displaybuttons 0 'auth/googleoauth2'

# Enable Mnet authentication method (#us_326)
moosh auth-manage enable mnet

# SMTP hosts : SMTP servers that Moodle use to send mail
moosh config-set smtphosts ${SMTP_SERVER}

# Create a support user (normally id=3)
moosh user-create --password pass --email ${CUSTOMER_CONTACT_USER_EMAIL} --firstname 'Contact' --lastname 'Solerni' --city 'Paris' --country 'FR' 'supportuser'

# disable default messaging system (#us_226)
moosh config-set messaging 0

# Completion tracking for progressbar 'moodle/enablecompletion' (#us_99)
moosh config-set enablecompletion 1

# Authorize login with email adress as well as username in login form
moosh config-set authloginviaemail 1

# Enable cookie secure
moosh config-set cookiesecure 1

# Disallow automatic updates
moosh config-set updateautocheck 0

# Timezone
#moosh timezone-import Europe/paris
moosh config-set timezone Europe/Paris

# support contact : Admin > Server > Support contact
moosh config-set supportname "Contact Solerni"
moosh config-set supportemail ${CUSTOMER_CONTACT_USER_EMAIL}

# support contacts (#us_288)
moosh username-configset supportuserid supportuser
moosh username-configset noreplyuserid supportuser

# orangenextsession (#us_26)
moosh config-set defaultenrol 1 enrol_orangenextsession
# /!\ this value is reversed 0 => true, 1 => false
moosh config-set status 0 enrol_orangenextsession

# orangeinvitation
moosh config-set defaultenrol 1 enrol_orangeinvitation
# /!\ this value is reversed 0 => true, 1 => false
moosh config-set status 0 enrol_orangeinvitation

# Add cache store memcached
# moosh cache-admin --servers ${MEMCACHED_CACHE_SERVER} --prefix ${MEMCACHED_CACHE_PREFIX} memcached addstore ${MEMCACHED_CACHE_NAME}
# moosh cache-admin memcached editmodemappings ${MEMCACHED_CACHE_NAME}

# Make Anonymous : add empty mail subject & msg
moosh config-set emailsubject '' local_eledia_makeanonymous
moosh config-set emailmsg '' local_eledia_makeanonymous

# Generate mail string html/txt
moosh mail-generate

# Default frontpage role : changed to allow access to the general ForumNg
moosh role-configset defaultfrontpageroleid solerni_utilisateur

# Inverse Last Name and First Name in Signup Form
moosh config-set fullnamedisplay "lastname, firstname"

# local_orangemail : add email support, contact...
moosh config-set contactemail ${CUSTOMER_CONTACT_USER_EMAIL} local_orangemail
moosh config-set supportemail ${CUSTOMER_SUPPORT_USER_EMAIL} local_orangemail
moosh config-set marketemail ${CUSTOMER_MARKET_USER_EMAIL} local_orangemail
moosh config-set partneremail ${CUSTOMER_PARTNER_USER_EMAIL} local_orangemail
moosh config-set noreplyemail ${CUSTOMER_NOREPLY_USER_EMAIL} local_orangemail
moosh config-set integratoremail ${CUSTOMER_DATA_INTEGRATOR_USER_EMAIL} local_orangemail
moosh config-set noreplyaddress ${CUSTOMER_NOREPLY_USER_EMAIL}

# Hide some activities
moosh module-manage hide assign
moosh module-manage hide assignment
moosh module-manage hide book
moosh module-manage hide chat
moosh module-manage hide choice
moosh module-manage show data
moosh module-manage hide feedback
moosh module-manage show forum
moosh module-manage hide imscp
moosh module-manage hide lesson
moosh module-manage hide lti
moosh module-manage hide scorm
moosh module-manage hide survey
moosh module-manage hide url
moosh module-manage hide wiki
moosh module-manage hide listforumng

# Set default Store (unable memcached)
moosh cache-admin memcached editmodemappings "default_application"

# Page contact
moosh config-set footerlistscolumn2link2 ${CUSTOMER_HTTP_BASE_URL}/contact/ theme_halloween

# Settings PF Name
moosh course-config-set course 1 fullname "${CUSTOMER_NAME} ${CUSTOMER_THEMATIC}"
moosh course-config-set course 1 shortname ${CUSTOMER_THEMATIC}

# block_orange_action (#us_458)
moosh config-set hideblockheader 1 block_orange_action

# defaulthomepage = Dashboard (#us_380)
moosh config-set defaulthomepage 1

# Disable Oauth2 authentication method
moosh auth-manage disable googleoauth2

# block_orange_course_dashboard
moosh config-set defaultmaxrecommendations 0 block_orange_course_dashboard
moosh config-set mymoocsurl '/moocs/mymoocs.php' block_orange_course_dashboard

# Delete Main Menu block in frontpage (course=1)
moosh block-delete course 1 site_main_menu site-index

# local_goodbye : delete value to keep default text (#us_442)
moosh config-set farewell "" local_goodbye

# hide block admin for solerni_utilisateur, solerni_apprenant, solerni_power_apprenant, solerni_animateur, solerni_client (#us_252)
moosh role-update-capability-ctx solerni_utilisateur moodle/block:view prevent block settings
moosh role-update-capability-ctx solerni_apprenant moodle/block:view prevent block settings
moosh role-update-capability-ctx solerni_power_apprenant moodle/block:view prevent block settings
moosh role-update-capability-ctx solerni_animateur moodle/block:view prevent block settings
moosh role-update-capability-ctx solerni_client moodle/block:view prevent block settings
moosh role-update-capability-ctx solerni_teacher moodle/block:view allow block settings
moosh role-update-capability-ctx solerni_course_creator moodle/block:view allow block settings
moosh role-update-capability-ctx solerni_marketing moodle/block:view allow block settings

# cgu = '' on all platforms except HOME, if a value exists in config.php, it will be kept (#us_485)
moosh config-set sitepolicy ''

# disable external open badges
moosh config-set badges_allowexternalbackpack 0

# Hide blocks for solerni_teacher (#us_507)
moosh block-manage hide admin_bookmarks
moosh block-manage hide badges
moosh block-manage hide blog_menu
moosh block-manage hide blog_recent
moosh block-manage hide blog_tags
moosh block-manage hide comments
moosh block-manage hide community
moosh block-manage hide completionstatus
moosh block-manage hide course_list
moosh block-manage hide course_list
moosh block-manage hide course_overview
moosh block-manage hide course_summary
moosh block-manage hide feedback
moosh block-manage hide login
moosh block-manage hide mentees
moosh block-manage hide messages
moosh block-manage hide mnet_hosts
moosh block-manage hide myprofile
moosh block-manage hide news_items
moosh block-manage hide participants
moosh block-manage hide recent_activity
moosh block-manage hide search_forums
moosh block-manage hide section_links
moosh block-manage hide selfcompletion
moosh block-manage hide site_main_menu
moosh block-manage hide social_activities
moosh block-manage hide tag_flickr
moosh block-manage hide tag_youtube

# disable editors 'plain text' and 'Atto HTML'
moosh editor-manage disable atto
moosh editor-manage disable textarea

# Blog : enableblogs to false (#us_468)
moosh config-set enableblogs 0

# block_orange_course_dashboard (#us_307)
moosh block-instance_config system 0 orange_course_dashboard my-index defaultmaxrecommendations 0

# disable 'Popup' and 'Jabber' notification in Plugins/Messages outputs (#us_468)
moosh message-manage disable jabber
moosh message-manage disable popup

# Set defaut email for badge (#us_468)
moosh config-set message_provider_moodle_badgerecipientnotice_loggedin popup,email message
moosh config-set message_provider_moodle_badgecreatornotice_loggedin email message
