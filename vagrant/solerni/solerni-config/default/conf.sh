#!/bin/sh
# Fichier "default/conf.sh"

# Default role for all users (#us_62-69)
# Attention : find the role_id of 'solerni_utilisateur'
moosh config-set defaultuserroleid 9

# Creators' role in new courses (#us_62-69)
# Attention : find the role_id of 'solerni_course_creator'
moosh config-set creatornewroleid 15

# Restorers' role in courses (#us_62-69)
# Attention : find the role_id of 'solerni_course_creator'
moosh config-set restorernewroleid 15

# Default role assignment - Plugin Enrolments/Self enrolment (#us_62-69)
# Attention : find the role_id of 'solerni_apprenant'
moosh config-set roleid 10 enrol_self

# Self registration (#us_6)
moosh config-set registerauth email




