#!/bin/bash
# Fichier "default_private/conf.sh"

# Force users to log in (#us_119)
moosh config-set forcelogin 1

# unenrolself is only for students in public PF
moosh role-update-capability solerni_apprenant enrol/self:unenrolself prevent 1
moosh role-update-capability solerni_apprenant enrol/manual:unenrolself prevent 1  

