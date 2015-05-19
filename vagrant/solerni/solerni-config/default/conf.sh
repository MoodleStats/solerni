#!/bin/sh
# Fichier "default/conf.sh"

# Default role for all users
# Attention : find the role_id of 'solerni_utilisateur'
moosh config-set defaultuserroleid 11

# Creators' role in new courses
# Attention : find the role_id of 'solerni_course_creator'
moosh config-set creatornewroleid 9

# Restorers' role in courses
# Attention : find the role_id of 'solerni_course_creator'
moosh config-set restorernewroleid 9

# Default role assignment (Plugin Enrolments/Self enrolment)
# Attention : find the role_id of 'solerni_apprenant'
moosh config-set roleid 10 enrol_self
