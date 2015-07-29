#!/bin/bash
# Fichier "default/role_update_capabilities.sh"

# solerni_utilisateur : See full user fields identity in lists (#us_110)
moosh role-update-capability solerni_utilisateur moodle/site:viewuseridentity allow 1

# coursecreator and solerni_course_creator : Configure MOOC URLs access (#us_7)
moosh role-update-capability coursecreator enrol/orangeinvitation:config allow 1
moosh role-update-capability solerni_course_creator enrol/orangeinvitation:config allow 1

# solerni_teacher and solerni_course_creator : progress:addinstance (#us_99)
moosh role-update-capability solerni_teacher block/progress:addinstance allow 1
moosh role-update-capability solerni_course_creator block/progress:addinstance allow 1

# solerni_teacher and solerni_course_creator :  progress:overview (#us_99)
moosh role-update-capability solerni_teacher block/progress:overview allow 1
moosh role-update-capability solerni_course_creator block/progress:overview allow 1

# solerni_utilisateur : Add a new mail (#us_113)
moosh role-update-capability solerni_utilisateur local/mail:addinstance allow 1

# solerni_utilisateur : Use mail (#us_106)
moosh role-update-capability solerni_utilisateur local/mail:usemail allow 1

# solerni_utilisateur : View page content (#us_50)
moosh role-update-capability solerni_utilisateur mod/descriptionpage:view allow 1
# solerni_utilisateur : descriptionpage:viewpersonal (#us_50)
moosh role-update-capability solerni_utilisateur mod/descriptionpage:viewpersonal allow 1
# solerni_course_creator : Add a new page resource (#us_50)
moosh role-update-capability solerni_course_creator mod/descriptionpage:addinstance allow 1

# solerni_utilisateur : View course contents block to the My Moodle page
moosh role-update-capability solerni_utilisateur block/orange_course_extended:view allow 1
moosh role-update-capability solerni_utilisateur block/orange_course_extended:viewpersonal allow 1
# solerni_utilisateur : Add a new course contents block to the My Moodle page
moosh role-update-capability solerni_utilisateur block/orange_course_extended:myaddinstance allow 1
# solerni_course_creator : orange_course_extended:addinstance
moosh role-update-capability solerni_course_creator block/orange_course_extended:addinstance allow 1

# solerni_utilisateur : Add a new Social sharing block to the My Moodle page (#us_58)
moosh role-update-capability solerni_utilisateur block/orange_social_sharing:myaddinstance allow 1
# solerni_course_creator : orange_social_sharing:addinstance (#us_58)
moosh role-update-capability solerni_course_creator block/orange_social_sharing:addinstance allow 1


