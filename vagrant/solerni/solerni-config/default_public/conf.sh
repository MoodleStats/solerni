#!/bin/bash
# Fichier "default_public/conf.sh"

# Enable OAuth2 (googleoauth2) auth plugin (#us_13 and #us_23)
moosh auth-manage enable googleoauth2

# unenrolself is only for students in public PF
moosh role-update-capability solerni_apprenant enrol/self:unenrolself allow 1
moosh role-update-capability solerni_apprenant enrol/manual:unenrolself allow 1  
