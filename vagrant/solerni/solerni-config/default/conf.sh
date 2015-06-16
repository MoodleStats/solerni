#!/bin/bash
# Fichier "default/conf.sh"

# First install : import Solerni roles
# Attention : order is important to keep roles assignments
moosh role-import solerni_utilisateur /tmp/solerni_utilisateur.xml
moosh role-import solerni_apprenant /tmp/solerni_apprenant.xml
moosh role-import solerni_power_apprenant /tmp/solerni_power_apprenant.xml
moosh role-import solerni_animateur /tmp/solerni_animateur.xml
moosh role-import solerni_teacher /tmp/solerni_teacher.xml
moosh role-import solerni_marketing /tmp/solerni_marketing.xml
moosh role-import solerni_course_creator /tmp/solerni_course_creator.xml

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


