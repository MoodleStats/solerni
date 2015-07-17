#!/bin/bash
# Fichier "default/conf.sh"

# First install : import Solerni roles
# Attention : order is important to keep roles assignments
moosh role-import solerni_utilisateur solerni-config/default/users_roles/solerni_utilisateur.xml
moosh role-import solerni_apprenant solerni-config/default/users_roles/solerni_apprenant.xml
moosh role-import solerni_power_apprenant solerni-config/default/users_roles/solerni_power_apprenant.xml
moosh role-import solerni_animateur solerni-config/default/users_roles/solerni_animateur.xml
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
moosh config-set theme solerni

# Maximum number of moocs to display in frontPage (#us_114 and #us_119)
moosh config-set frontpagecourselimit 5

# Default lang
moosh config-set lang fr

# User policies : hide user fields (#us_110)
moosh config-set hiddenuserfields icqnumber,skypeid,yahooid,aimid,msnid,lastip

# Update capability : See full user fields identity in lists (#us_110)
moosh role-update-capability solerni_utilisateur moodle/site:viewuseridentity allow 1

# Activation multilang Filter (#us_110)
moosh filter-manage -c on multilang

# Add capabilities orangeinvitation:config for coursecreator and solerni_course_creator (#us_7)
moosh role-update-capability coursecreator enrol/orangeinvitation:config allow 1
moosh role-update-capability solerni_course_creator enrol/orangeinvitation:config allow 1

# Add new user profil fields (#us_110)
moosh userprofilefields-import solerni-config/default/users_profil/profile_fields.csv
