#!/bin/bash
# Fichier "default/role_update_capabilities.sh"

# See full user fields identity in lists (#us_110)
moosh role-update-capability solerni_utilisateur moodle/site:viewuseridentity allow 1

# Orange Invitation (#us_7)
# coursecreator and solerni_course_creator : Configure MOOC URLs access
moosh role-update-capability coursecreator enrol/orangeinvitation:config allow 1
moosh role-update-capability solerni_course_creator enrol/orangeinvitation:config allow 1
moosh role-update-capability solerni_teacher enrol/orangeinvitation:config allow 1

# Description Page (#us_50)
# View page content
moosh role-update-capability solerni_utilisateur mod/descriptionpage:view allow 1
moosh role-update-capability solerni_utilisateur mod/descriptionpage:viewpersonal allow 1
# Add a new page resource
moosh role-update-capability solerni_course_creator mod/descriptionpage:addinstance allow 1

# Orange Course Extended
# View course contents block to the My Moodle page
moosh role-update-capability solerni_utilisateur block/orange_course_extended:view allow 1
moosh role-update-capability solerni_utilisateur block/orange_course_extended:viewpersonal allow 1
# Add a new course contents block to the My Moodle page
moosh role-update-capability solerni_utilisateur block/orange_course_extended:myaddinstance allow 1
# orange_course_extended:addinstance
moosh role-update-capability solerni_course_creator block/orange_course_extended:addinstance allow 1

# Orange Social Sharing (#us_58)
# Add a new Social sharing block to the My Moodle page 
moosh role-update-capability solerni_utilisateur block/orange_social_sharing:myaddinstance allow 1
# orange_social_sharing:addinstance
moosh role-update-capability solerni_course_creator block/orange_social_sharing:addinstance allow 1

# Local Mail (#us_113, #us_106)
# local/mail : addinstance
moosh role-update-capability solerni_utilisateur local/mail:addinstance allow 1
# local/mail : usemail
moosh role-update-capability solerni_utilisateur local/mail:usemail allow 1

# Progress Bar (#us_99)
# block/progress : addinstance 
moosh role-update-capability solerni_teacher block/progress:addinstance allow 1
# block/progress : overview
moosh role-update-capability solerni_teacher block/progress:overview allow 1
moosh role-update-capability solerni_marketing block/progress:overview allow 1
moosh role-update-capability solerni_animateur block/progress:overview allow 1
moosh role-update-capability solerni_client block/progress:overview allow 1

# Oublog (#us_206)
# mod/oublog : contributepersonal, addinstance
moosh role-update-capability solerni_teacher mod/oublog:contributepersonal allow 1
moosh role-update-capability solerni_teacher mod/oublog:addinstance allow 1
moosh role-update-capability solerni_course_creator mod/oublog:addinstance allow 1
# mod/oublog : viewpersonal, viewprivate
moosh role-update-capability solerni_teacher mod/oublog:viewpersonal allow 1
moosh role-update-capability solerni_marketing mod/oublog:viewpersonal allow 1
moosh role-update-capability solerni_teacher mod/oublog:viewprivate allow 1
moosh role-update-capability solerni_marketing mod/oublog:viewprivate allow 1
# mod/oublog : audit
moosh role-update-capability solerni_marketing mod/oublog:audit allow 1
moosh role-update-capability solerni_teacher mod/oublog:audit allow 1
moosh role-update-capability solerni_animateur mod/oublog:audit allow 1
# mod/oublog : comment, exportownpost, exportpost
moosh role-update-capability solerni_teacher mod/oublog:comment allow 1
moosh role-update-capability solerni_animateur mod/oublog:comment allow 1
moosh role-update-capability solerni_apprenant mod/oublog:comment allow 1
moosh role-update-capability solerni_power_apprenant mod/oublog:comment allow 1
moosh role-update-capability solerni_client mod/oublog:comment allow 1
moosh role-update-capability solerni_marketing mod/oublog:comment allow 1
moosh role-update-capability solerni_course_creator mod/oublog:comment allow 1
moosh role-update-capability solerni_teacher mod/oublog:exportownpost allow 1
moosh role-update-capability solerni_animateur mod/oublog:exportownpost allow 1
moosh role-update-capability solerni_apprenant mod/oublog:exportownpost allow 1
moosh role-update-capability solerni_power_apprenant mod/oublog:exportownpost allow 1
moosh role-update-capability solerni_client mod/oublog:exportownpost allow 1
moosh role-update-capability solerni_marketing mod/oublog:exportownpost allow 1
moosh role-update-capability solerni_course_creator mod/oublog:exportownpost allow 1
moosh role-update-capability solerni_teacher mod/oublog:exportpost allow 1
moosh role-update-capability solerni_animateur mod/oublog:exportpost allow 1
moosh role-update-capability solerni_apprenant mod/oublog:exportpost allow 1
moosh role-update-capability solerni_power_apprenant mod/oublog:exportpost allow 1
moosh role-update-capability solerni_client mod/oublog:exportpost allow 1
moosh role-update-capability solerni_marketing mod/oublog:exportpost allow 1
moosh role-update-capability solerni_course_creator mod/oublog:exportpost allow 1
# mod/oublog : grade
moosh role-update-capability solerni_marketing mod/oublog:grade allow 1
moosh role-update-capability solerni_teacher mod/oublog:grade allow 1
moosh role-update-capability solerni_animateur mod/oublog:grade allow 1 
# mod/oublog : managecomments, managelinks, manageposts,post
moosh role-update-capability solerni_teacher mod/oublog:managecomments allow 1
moosh role-update-capability solerni_animateur mod/oublog:managecomments allow 1
moosh role-update-capability solerni_teacher mod/oublog:managelinks allow 1
moosh role-update-capability solerni_animateur mod/oublog:managelinks allow 1
moosh role-update-capability solerni_teacher mod/oublog:manageposts allow 1
moosh role-update-capability solerni_animateur mod/oublog:manageposts allow 1
moosh role-update-capability solerni_teacher mod/oublog:post allow 1
moosh role-update-capability solerni_animateur mod/oublog:post allow 1
# mod/oublog : rate,view,viewallratings,viewanyrating
moosh role-update-capability solerni_teacher mod/oublog:rate allow 1
moosh role-update-capability solerni_animateur mod/oublog:rate allow 1
moosh role-update-capability solerni_apprenant mod/oublog:rate allow 1
moosh role-update-capability solerni_power_apprenant mod/oublog:rate allow 1
moosh role-update-capability solerni_client mod/oublog:rate allow 1
moosh role-update-capability solerni_marketing mod/oublog:rate allow 1
moosh role-update-capability solerni_course_creator mod/oublog:rate allow 1
moosh role-update-capability solerni_teacher mod/oublog:view allow 1
moosh role-update-capability solerni_animateur mod/oublog:view allow 1
moosh role-update-capability solerni_apprenant mod/oublog:view allow 1
moosh role-update-capability solerni_power_apprenant mod/oublog:view allow 1
moosh role-update-capability solerni_client mod/oublog:view allow 1
moosh role-update-capability solerni_marketing mod/oublog:view allow 1
moosh role-update-capability solerni_course_creator mod/oublog:view allow 1
moosh role-update-capability solerni_teacher mod/oublog:viewallratings allow 1
moosh role-update-capability solerni_animateur mod/oublog:viewallratings allow 1
moosh role-update-capability solerni_apprenant mod/oublog:viewallratings allow 1
moosh role-update-capability solerni_power_apprenant mod/oublog:viewallratings allow 1
moosh role-update-capability solerni_client mod/oublog:viewallratings allow 1
moosh role-update-capability solerni_marketing mod/oublog:viewallratings allow 1
moosh role-update-capability solerni_course_creator mod/oublog:viewallratings allow 1
moosh role-update-capability solerni_teacher mod/oublog:viewanyrating allow 1
moosh role-update-capability solerni_animateur mod/oublog:viewanyrating allow 1
moosh role-update-capability solerni_apprenant mod/oublog:viewanyrating allow 1
moosh role-update-capability solerni_power_apprenant mod/oublog:viewanyrating allow 1
moosh role-update-capability solerni_client mod/oublog:viewanyrating allow 1
moosh role-update-capability solerni_marketing mod/oublog:viewanyrating allow 1
moosh role-update-capability solerni_course_creator mod/oublog:viewanyrating allow 1
# mod/oublog : viewindividual
moosh role-update-capability solerni_teacher mod/oublog:viewindividual allow 1
moosh role-update-capability solerni_marketing mod/oublog:viewindividual allow 1
# mod/oublog : viewparticipation
moosh role-update-capability solerni_teacher mod/oublog:viewparticipation allow 1
moosh role-update-capability solerni_animateur mod/oublog:viewparticipation allow 1
moosh role-update-capability solerni_client mod/oublog:viewparticipation allow 1
moosh role-update-capability solerni_marketing mod/oublog:viewparticipation allow 1
# mod/oublog : viewrating
moosh role-update-capability solerni_teacher mod/oublog:viewrating allow 1
moosh role-update-capability solerni_animateur mod/oublog:viewrating allow 1
moosh role-update-capability solerni_client mod/oublog:viewrating allow 1
moosh role-update-capability solerni_apprenant mod/oublog:viewrating allow 1
moosh role-update-capability solerni_power_apprenant mod/oublog:viewrating allow 1
moosh role-update-capability solerni_marketing mod/oublog:viewrating allow 1

# questionnaire (#us_211)
# mod/questionnaire : addinstance, createpublic, createtemplates, deleteresponses, editquestions, manage
moosh role-update-capability solerni_teacher mod/questionnaire:addinstance allow 1
moosh role-update-capability solerni_teacher mod/questionnaire:createpublic allow 1
moosh role-update-capability solerni_teacher mod/questionnaire:createtemplates allow 1
moosh role-update-capability solerni_teacher mod/questionnaire:deleteresponses allow 1
moosh role-update-capability solerni_teacher mod/questionnaire:editquestions allow 1
moosh role-update-capability solerni_teacher mod/questionnaire:manage allow 1
# mod/questionnaire : downloadresponses
moosh role-update-capability solerni_teacher mod/questionnaire:downloadresponses allow 1
moosh role-update-capability solerni_animateur mod/questionnaire:downloadresponses allow 1
moosh role-update-capability solerni_marketing mod/questionnaire:downloadresponses allow 1
moosh role-update-capability solerni_client mod/questionnaire:downloadresponses allow 1
# mod/questionnaire : message
moosh role-update-capability solerni_teacher mod/questionnaire:message allow 1
moosh role-update-capability solerni_animateur mod/questionnaire:message allow 1
# mod/questionnaire : preview
moosh role-update-capability solerni_teacher mod/questionnaire:preview allow 1
moosh role-update-capability solerni_animateur mod/questionnaire:preview allow 1
moosh role-update-capability solerni_marketing mod/questionnaire:preview allow 1
# mod/questionnaire : printblank
moosh role-update-capability solerni_teacher mod/questionnaire:printblank allow 1
moosh role-update-capability solerni_animateur mod/questionnaire:printblank allow 1
moosh role-update-capability solerni_marketing mod/questionnaire:printblank allow 1
moosh role-update-capability solerni_client mod/questionnaire:printblank allow 1
moosh role-update-capability solerni_apprenant mod/questionnaire:printblank allow 1
moosh role-update-capability solerni_power_apprenant mod/questionnaire:printblank allow 1
# mod/questionnaire : readallresponseanytime, mod/questionnaire:readallresponses
moosh role-update-capability solerni_teacher mod/questionnaire:readallresponseanytime allow 1
moosh role-update-capability solerni_animateur mod/questionnaire:readallresponseanytime allow 1
moosh role-update-capability solerni_marketing mod/questionnaire:readallresponseanytime allow 1
moosh role-update-capability solerni_client mod/questionnaire:readallresponseanytime allow 1
moosh role-update-capability solerni_teacher mod/questionnaire:readallresponses allow 1
moosh role-update-capability solerni_animateur mod/questionnaire:readallresponses allow 1
moosh role-update-capability solerni_marketing mod/questionnaire:readallresponses allow 1
moosh role-update-capability solerni_client mod/questionnaire:readallresponses allow 1
# mod/questionnaire : readownresponses, submit, view
moosh role-update-capability solerni_teacher mod/questionnaire:readownresponses allow 1
moosh role-update-capability solerni_animateur mod/questionnaire:readownresponses allow 1
moosh role-update-capability solerni_marketing mod/questionnaire:readownresponses allow 1
moosh role-update-capability solerni_client mod/questionnaire:readownresponses allow 1
moosh role-update-capability solerni_apprenant mod/questionnaire:readownresponses allow 1
moosh role-update-capability solerni_power_apprenant mod/questionnaire:readownresponses allow 1
moosh role-update-capability solerni_teacher mod/questionnaire:submit allow 1
moosh role-update-capability solerni_animateur mod/questionnaire:submit allow 1
moosh role-update-capability solerni_marketing mod/questionnaire:submit allow 1
moosh role-update-capability solerni_client mod/questionnaire:submit allow 1
moosh role-update-capability solerni_apprenant mod/questionnaire:submit allow 1
moosh role-update-capability solerni_power_apprenant mod/questionnaire:submit allow 1
moosh role-update-capability solerni_teacher mod/questionnaire:view allow 1
moosh role-update-capability solerni_animateur mod/questionnaire:view allow 1
moosh role-update-capability solerni_marketing mod/questionnaire:view allow 1
moosh role-update-capability solerni_client mod/questionnaire:view allow 1
moosh role-update-capability solerni_apprenant mod/questionnaire:view allow 1
moosh role-update-capability solerni_power_apprenant mod/questionnaire:view allow 1
# mod/questionnaire : viewsingleresponse
moosh role-update-capability solerni_teacher mod/questionnaire:viewsingleresponse allow 1
moosh role-update-capability solerni_animateur mod/questionnaire:viewsingleresponse allow 1
moosh role-update-capability solerni_marketing mod/questionnaire:viewsingleresponse allow 1
moosh role-update-capability solerni_client mod/questionnaire:viewsingleresponse allow 1

# forumng (#us_205)
# mod/forumng : addinstance
moosh role-update-capability solerni_teacher mod/forumng:addinstance allow 1
# forumngfeature/edittags : editsettags, managesettags
moosh role-update-capability solerni_teacher forumngfeature/edittags:editsettags allow 1
moosh role-update-capability solerni_animateur forumngfeature/edittags:editsettags allow 1
moosh role-update-capability solerni_teacher forumngfeature/edittags:managesettags allow 1
moosh role-update-capability solerni_animateur forumngfeature/edittags:managesettags allow 1
# forumngfeature/usage : view, viewflagged, viewusage
moosh role-update-capability solerni_teacher forumngfeature/usage:view allow 1
moosh role-update-capability solerni_animateur forumngfeature/usage:view allow 1
moosh role-update-capability solerni_marketing forumngfeature/usage:view allow 1
moosh role-update-capability solerni_client forumngfeature/usage:view allow 1
moosh role-update-capability solerni_power_apprenant forumngfeature/usage:view allow 1
moosh role-update-capability solerni_teacher forumngfeature/usage:viewflagged allow 1
moosh role-update-capability solerni_animateur forumngfeature/usage:viewflagged allow 1
moosh role-update-capability solerni_marketing forumngfeature/usage:viewflagged allow 1
moosh role-update-capability solerni_client forumngfeature/usage:viewflagged allow 1
moosh role-update-capability solerni_power_apprenant forumngfeature/usage:viewflagged allow 1
moosh role-update-capability solerni_teacher forumngfeature/usage:viewusage allow 1
moosh role-update-capability solerni_animateur forumngfeature/usage:viewusage allow 1
moosh role-update-capability solerni_marketing forumngfeature/usage:viewusage allow 1
moosh role-update-capability solerni_client forumngfeature/usage:viewusage allow 1
moosh role-update-capability solerni_power_apprenant forumngfeature/usage:viewusage allow 1
# forumngfeature/userposts : view
moosh role-update-capability solerni_teacher forumngfeature/usage:view allow 1
moosh role-update-capability solerni_animateur forumngfeature/usage:view allow 1
moosh role-update-capability solerni_marketing forumngfeature/usage:view allow 1
moosh role-update-capability solerni_client forumngfeature/usage:view allow 1
moosh role-update-capability solerni_apprenant forumngfeature/usage:view allow 1
moosh role-update-capability solerni_power_apprenant forumngfeature/usage:viewflagged allow 1
# mod/forumng : addtag, createattachment
moosh role-update-capability solerni_teacher mod/forumng:addtag allow 1
moosh role-update-capability solerni_animateur mod/forumng:addtag allow 1
moosh role-update-capability solerni_apprenant mod/forumng:addtag allow 1
moosh role-update-capability solerni_power_apprenant mod/forumng:addtag allow 1
moosh role-update-capability solerni_teacher mod/forumng:createattachment allow 1
moosh role-update-capability solerni_animateur mod/forumng:createattachment allow 1
moosh role-update-capability solerni_apprenant mod/forumng:createattachment allow 1
moosh role-update-capability solerni_power_apprenant mod/forumng:createattachment allow 1
# mod/forumng : copydiscussion, deleteanypost, editanypost
moosh role-update-capability solerni_teacher mod/forumng:copydiscussion allow 1
moosh role-update-capability solerni_animateur mod/forumng:copydiscussion allow 1
moosh role-update-capability solerni_power_apprenant mod/forumng:copydiscussion allow 1
moosh role-update-capability solerni_teacher mod/forumng:deleteanypost allow 1
moosh role-update-capability solerni_animateur mod/forumng:deleteanypost allow 1
moosh role-update-capability solerni_power_apprenant mod/forumng:deleteanypost allow 1
moosh role-update-capability solerni_teacher mod/forumng:editanypost allow 1
moosh role-update-capability solerni_animateur mod/forumng:editanypost allow 1
moosh role-update-capability solerni_power_apprenant mod/forumng:editanypost allow 1
# mod/forumng : forwardposts, grade
moosh role-update-capability solerni_teacher mod/forumng:forwardposts allow 1
moosh role-update-capability solerni_animateur mod/forumng:forwardposts allow 1
moosh role-update-capability solerni_client mod/forumng:forwardposts allow 1
moosh role-update-capability solerni_apprenant mod/forumng:forwardposts allow 1
moosh role-update-capability solerni_power_apprenant mod/forumng:forwardposts allow 1
moosh role-update-capability solerni_teacher mod/forumng:grade allow 1
moosh role-update-capability solerni_animateur mod/forumng:grade allow 1
moosh role-update-capability solerni_client mod/forumng:grade allow 1
moosh role-update-capability solerni_apprenant mod/forumng:grade allow 1
moosh role-update-capability solerni_power_apprenant mod/forumng:grade allow 1
# mod/forumng : ignorepostlimits, mailnow, managediscussions, movediscussions
moosh role-update-capability solerni_teacher mod/forumng:ignorepostlimits allow 1
moosh role-update-capability solerni_animateur mod/forumng:ignorepostlimits allow 1
moosh role-update-capability solerni_power_apprenant mod/forumng:ignorepostlimits allow 1
moosh role-update-capability solerni_teacher mod/forumng:mailnow allow 1
moosh role-update-capability solerni_animateur mod/forumng:mailnow allow 1
moosh role-update-capability solerni_power_apprenant mod/forumng:mailnow allow 1
moosh role-update-capability solerni_teacher mod/forumng:managediscussions allow 1
moosh role-update-capability solerni_animateur mod/forumng:managediscussions allow 1
moosh role-update-capability solerni_power_apprenant mod/forumng:managediscussions allow 1
moosh role-update-capability solerni_teacher mod/forumng:movediscussions allow 1
moosh role-update-capability solerni_animateur mod/forumng:movediscussions allow 1
moosh role-update-capability solerni_power_apprenant mod/forumng:movediscussions allow 1
# mod/forumng : managesubscriptions
moosh role-update-capability solerni_teacher mod/forumng:managesubscriptions allow 1
moosh role-update-capability solerni_animateur mod/forumng:managesubscriptions allow 1
# mod/forumng:postanon, postasmoderator
moosh role-update-capability solerni_teacher mod/forumng:postanon allow 1
moosh role-update-capability solerni_teacher mod/forumng:postasmoderator allow 1
# mod/forumng:rate, mod/forumng:replypost
moosh role-update-capability solerni_teacher mod/forumng:rate allow 1
moosh role-update-capability solerni_animateur mod/forumng:rate allow 1
moosh role-update-capability solerni_client mod/forumng:rate allow 1
moosh role-update-capability solerni_apprenant mod/forumng:rate allow 1
moosh role-update-capability solerni_power_apprenant mod/forumng:rate allow 1
moosh role-update-capability solerni_teacher mod/forumng:replypost allow 1
moosh role-update-capability solerni_animateur mod/forumng:replypost allow 1
moosh role-update-capability solerni_client mod/forumng:replypost allow 1
moosh role-update-capability solerni_apprenant mod/forumng:replypost allow 1
moosh role-update-capability solerni_power_apprenant mod/forumng:replypost allow 1
# mod/forumng:setimportant, mod/forumng:splitdiscussions, mod/forumng:startdiscussion
moosh role-update-capability solerni_teacher mod/forumng:setimportant allow 1
moosh role-update-capability solerni_animateur mod/forumng:setimportant allow 1
moosh role-update-capability solerni_power_apprenant mod/forumng:setimportant allow 1
moosh role-update-capability solerni_teacher mod/forumng:splitdiscussions allow 1
moosh role-update-capability solerni_animateur mod/forumng:splitdiscussions allow 1
moosh role-update-capability solerni_power_apprenant mod/forumng:splitdiscussions allow 1
moosh role-update-capability solerni_teacher mod/forumng:startdiscussion allow 1
moosh role-update-capability solerni_animateur mod/forumng:startdiscussion allow 1
moosh role-update-capability solerni_power_apprenant mod/forumng:startdiscussion allow 1
# mod/forumng : view
moosh role-update-capability solerni_teacher mod/forumng:view allow 1
moosh role-update-capability solerni_animateur mod/forumng:view allow 1
moosh role-update-capability solerni_marketing mod/forumng:view allow 1
moosh role-update-capability solerni_client mod/forumng:view allow 1
moosh role-update-capability solerni_apprenant mod/forumng:view allow 1
moosh role-update-capability solerni_power_apprenant mod/forumng:view allow 1
# mod/forumng : viewallposts, viewallratings, viewanyrating
moosh role-update-capability solerni_teacher mod/forumng:viewallposts allow 1
moosh role-update-capability solerni_animateur mod/forumng:viewallposts allow 1
moosh role-update-capability solerni_marketing mod/forumng:viewallposts allow 1
moosh role-update-capability solerni_client mod/forumng:viewallposts allow 1
moosh role-update-capability solerni_power_apprenant mod/viewallposts:view allow 1
moosh role-update-capability solerni_teacher mod/forumng:viewallratings allow 1
moosh role-update-capability solerni_animateur mod/forumng:viewallratings allow 1
moosh role-update-capability solerni_marketing mod/forumng:viewallratings allow 1
moosh role-update-capability solerni_client mod/forumng:viewallratings allow 1
moosh role-update-capability solerni_power_apprenant mod/forumng:viewallratings allow 1
moosh role-update-capability solerni_teacher mod/forumng:viewanyrating allow 1
moosh role-update-capability solerni_animateur mod/forumng:viewanyrating allow 1
moosh role-update-capability solerni_marketing mod/forumng:viewanyrating allow 1
moosh role-update-capability solerni_client mod/forumng:viewanyrating allow 1
moosh role-update-capability solerni_power_apprenant mod/forumng:viewanyrating allow 1
# mod/forumng : viewdiscussion, viewrating, viewreadinfo
moosh role-update-capability solerni_teacher mod/forumng:viewdiscussion allow 1
moosh role-update-capability solerni_animateur mod/forumng:viewdiscussion allow 1
moosh role-update-capability solerni_marketing mod/forumng:viewdiscussion allow 1
moosh role-update-capability solerni_client mod/forumng:viewdiscussion allow 1
moosh role-update-capability solerni_apprenant mod/forumng:viewdiscussion allow 1
moosh role-update-capability solerni_power_apprenant mod/forumng:viewdiscussion allow 1
moosh role-update-capability solerni_teacher mod/forumng:viewrating allow 1
moosh role-update-capability solerni_animateur mod/forumng:viewrating allow 1
moosh role-update-capability solerni_marketing mod/forumng:viewrating allow 1
moosh role-update-capability solerni_client mod/forumng:viewrating allow 1
moosh role-update-capability solerni_apprenant mod/forumng:viewrating allow 1
moosh role-update-capability solerni_power_apprenant mod/forumng:viewrating allow 1
moosh role-update-capability solerni_teacher mod/forumng:viewreadinfo allow 1
moosh role-update-capability solerni_animateur mod/forumng:viewreadinfo allow 1
moosh role-update-capability solerni_marketing mod/forumng:viewreadinfo allow 1
moosh role-update-capability solerni_client mod/forumng:viewreadinfo allow 1
moosh role-update-capability solerni_apprenant mod/forumng:viewreadinfo allow 1
moosh role-update-capability solerni_power_apprenant mod/forumng:viewreadinfo allow 1
# mod/forumng : viewsubscribers
moosh role-update-capability solerni_teacher mod/forumng:viewsubscribers allow 1
moosh role-update-capability solerni_animateur mod/forumng:viewsubscribers allow 1
moosh role-update-capability solerni_marketing mod/forumng:viewsubscribers allow 1
moosh role-update-capability solerni_client mod/forumng:viewsubscribers allow 1

# mediagallery (#us_210)
# mod/mediagallery : addinstance, manage
moosh role-update-capability solerni_teacher mod/mediagallery:addinstance allow 1
moosh role-update-capability solerni_teacher mod/mediagallery:manage allow 1
# mod/mediagallery:comment, grade, like
moosh role-update-capability solerni_teacher mod/mediagallery:comment allow 1
moosh role-update-capability solerni_animateur mod/mediagallery:comment allow 1
moosh role-update-capability solerni_client mod/mediagallery:comment allow 1
moosh role-update-capability solerni_apprenant mod/mediagallery:comment allow 1
moosh role-update-capability solerni_power_apprenant mod/mediagallery:comment allow 1
moosh role-update-capability solerni_teacher mod/mediagallery:grade allow 1
moosh role-update-capability solerni_animateur mod/mediagallery:grade allow 1
moosh role-update-capability solerni_client mod/mediagallery:grade allow 1
moosh role-update-capability solerni_apprenant mod/mediagallery:grade allow 1
moosh role-update-capability solerni_power_apprenant mod/mediagallery:grade allow 1
moosh role-update-capability solerni_teacher mod/mediagallery:like allow 1
moosh role-update-capability solerni_animateur mod/mediagallery:like allow 1
moosh role-update-capability solerni_client mod/mediagallery:like allow 1
moosh role-update-capability solerni_apprenant mod/mediagallery:like allow 1
moosh role-update-capability solerni_power_apprenant mod/mediagallery:like allow 1
# mod/mediagallery : viewall
moosh role-update-capability solerni_teacher mod/mediagallery:viewall allow 1
moosh role-update-capability solerni_marketing mod/mediagallery:viewall allow 1

# Flexpage
# format/flexpage : managepages
moosh role-update-capability solerni_teacher format/flexpage:managepages allow 1
# block/flexpagemod : addinstance
moosh role-update-capability solerni_teacher block/flexpagemod:addinstance allow 1
# block/flexpagenav : addinstance, manage, view
moosh role-update-capability solerni_teacher block/flexpagenav:addinstance allow 1
moosh role-update-capability solerni_teacher block/flexpagenav:manage allow 1
moosh role-update-capability solerni_teacher block/flexpagenav:view allow 1

# Statistics
moosh role-update-capability solerni_client report/stats:view allow 1
moosh role-update-capability solerni_client quiz/statistics:view allow 1

# Workshop (#us_90)
moosh role-update-capability solerni_apprenant mod/workshop:viewauthornames prevent 1

# Update course creator role (#us_285)
moosh role-update-capability solerni_course_creator moodle/user:create allow 1
moosh role-update-capability solerni_course_creator moodle/user:delete allow 1
moosh role-update-capability solerni_course_creator moodle/user:update allow 1
moosh role-update-capability solerni_course_creator moodle/user:editprofile allow 1
moosh role-update-capability solerni_course_creator enrol/manual:unenrol allow 1
moosh role-update-capability solerni_course_creator enrol/self:unenrol allow 1
moosh role-update-capability solerni_course_creator moodle/user:viewdetails allow 1
moosh role-update-capability solerni_course_creator moodle/user:viewhiddendetails allow 1
moosh role-update-capability solerni_course_creator moodle/course:viewhiddenuserfields allow 1
moosh role-update-capability solerni_course_creator moodle/role:review allow 1
moosh role-update-capability solerni_course_creator local/orange_customers:edit allow 1
moosh role-update-capability solerni_course_creator local/orange_rules:edit allow 1
moosh role-update-capability solerni_course_creator local/orange_thematics:edit allow 1
moosh role-update-capability solerni_course_creator moodle/user:loginas allow 1

# Update teacher role
moosh role-update-capability solerni_teacher moodle/user:loginas allow 1
moosh role-update-capability solerni_teacher block/html:addinstance allow 1
moosh role-update-capability solerni_teacher moodle/block:edit allow 1
moosh role-update-capability solerni_teacher moodle/site:manageblocks allow 1

# mod/listforumng (#us_236)
moosh role-update-capability solerni_apprenant mod/listforumng:view allow 1
moosh role-update-capability solerni_teacher mod/listforumng:addinstance allow 1
moosh role-update-capability solerni_course_creator mod/listforumng:addinstance allow 1
moosh role-update-capability solerni_utilisateur mod/listforumng:view allow 1

# Update course creator role : add Ensavoir+ page
moosh role-update-capability solerni_course_creator format/flexpage:managepages allow 1
moosh role-update-capability solerni_course_creator moodle/course:manageactivities allow 1

# Update course creator role : add ressource on home page
moosh role-update-capability solerni_course_creator moodle/course:activityvisibility allow 1

# Add capabilities for progress bar (#us_99)
moosh role-update-capability solerni_utilisateur block/orange_progressbar:overview allow 1

# Add capabilities for calendar (#us_262, #us_266)
moosh role-update-capability solerni_utilisateur moodle/calendar:manageownentries allow 1
moosh role-update-capability solerni_course_creator moodle/calendar:manageentries allow 1
moosh role-update-capability solerni_animateur moodle/calendar:manageentries allow 1

# solerni_course_creator can add extended course
moosh role-update-capability solerni_course_creator moodle/site:manageblocks allow 1

# listforumng capabilities (#236)
moosh role-update-capability solerni_utilisateur block/orange_listforumng:overview allow 1
moosh role-update-capability guest block/orange_listforumng:overview allow 1
moosh role-update-capability solerni_teacher block/orange_listforumng:addinstance allow 1
moosh role-update-capability solerni_course_creator block/orange_listforumng:addinstance allow 1

# Mnet (#us_326)
moosh role-update-capability solerni_utilisateur moodle/site:mnetlogintoremote allow 1

# block orange_comments (#us_209)
moosh role-update-capability solerni_teacher block/orange_comments:addinstance allow 1
moosh role-update-capability solerni_teacher moodle/comment:delete allow 1
moosh role-update-capability solerni_animateur moodle/comment:delete allow 1
moosh role-update-capability solerni_course_creator moodle/comment:post allow 1
moosh role-update-capability solerni_marketing moodle/comment:post allow 1
moosh role-update-capability solerni_course_creator moodle/comment:view allow 1

# Course Backup (#us_229)
moosh role-update-capability solerni_teacher moodle/backup:anonymise allow 1
moosh role-update-capability solerni_course_creator moodle/backup:anonymise allow 1
moosh role-update-capability solerni_teacher moodle/backup:backupcourse allow 1
moosh role-update-capability solerni_course_creator moodle/backup:backupcourse allow 1
moosh role-update-capability solerni_teacher moodle/backup:backuptargetimport allow 1
moosh role-update-capability solerni_course_creator moodle/backup:backuptargetimport allow 1
moosh role-update-capability solerni_teacher moodle/backup:configure allow 1
moosh role-update-capability solerni_course_creator moodle/backup:configure allow 1
moosh role-update-capability solerni_teacher moodle/backup:downloadfile allow 1
moosh role-update-capability solerni_course_creator moodle/backup:downloadfile allow 1
moosh role-update-capability solerni_teacher moodle/backup:userinfo allow 1
moosh role-update-capability solerni_course_creator moodle/backup:userinfo allow 1
moosh role-update-capability solerni_teacher moodle/backup:backupsection allow 1
moosh role-update-capability solerni_course_creator moodle/backup:backupsection allow 1

# Course Restore (#us_229)
moosh role-update-capability solerni_teacher moodle/restore:configure allow 1
moosh role-update-capability solerni_course_creator moodle/restore:configure allow 1
moosh role-update-capability solerni_teacher moodle/restore:restoreactivity allow 1
moosh role-update-capability solerni_course_creator moodle/restore:restoreactivity allow 1
moosh role-update-capability solerni_teacher moodle/restore:restorecourse allow 1
moosh role-update-capability solerni_course_creator moodle/restore:restorecourse allow 1
moosh role-update-capability solerni_teacher moodle/restore:restoresection allow 1
moosh role-update-capability solerni_course_creator moodle/restore:restoresection allow 1
moosh role-update-capability solerni_teacher moodle/restore:restoretargetimport allow 1
moosh role-update-capability solerni_course_creator moodle/restore:restoretargetimport allow 1
moosh role-update-capability solerni_teacher moodle/restore:rolldates allow 1
moosh role-update-capability solerni_course_creator moodle/restore:rolldates allow 1
moosh role-update-capability solerni_teacher moodle/restore:uploadfile allow 1
moosh role-update-capability solerni_course_creator moodle/restore:uploadfile allow 1
moosh role-update-capability solerni_teacher moodle/restore:userinfo allow 1
moosh role-update-capability solerni_course_creator moodle/restore:userinfo allow 1
moosh role-update-capability solerni_teacher moodle/restore:viewautomatedfilearea allow 1
moosh role-update-capability solerni_course_creator moodle/restore:viewautomatedfilearea allow 1

# Course Creator : can add block in a course
moosh role-update-capability solerni_course_creator moodle/block:edit allow 1

# Orangenextsession (#us_26)
moosh role-update-capability solerni_course_creator enrol/orangenextsession:config allow 1
moosh role-update-capability solerni_teacher enrol/orangenextsession:config allow 1

# Add capabilities for progress bar (#us_99, #us_274)
moosh role-update-capability solerni_course_creator block/orange_progressbar:addinstance allow 1

# Forumng : Add capability for solerni_course_creator (#us_388)
moosh role-update-capability solerni_course_creator mod/forumng:startdiscussion allow 1

# solerni_utilisateur role can see other user's profil
moosh role-update-capability solerni_utilisateur moodle/user:viewdetails allow 1

# Forumng : delete capability for solerni_power_apprenant
moosh role-update-capability solerni_power_apprenant mod/forumng:editanypost prevent 1

# Forumng : forumngfeature/userposts:view for all roles
moosh role-update-capability solerni_teacher forumngfeature/userposts:view allow 1
moosh role-update-capability solerni_animateur forumngfeature/userposts:view allow 1
moosh role-update-capability solerni_marketing forumngfeature/userposts:view allow 1
moosh role-update-capability solerni_client forumngfeature/userposts:view allow 1
moosh role-update-capability solerni_power_apprenant forumngfeature/userposts:view allow 1

# Forumng : add capabilities for solerni_utilisateur
moosh role-update-capability solerni_utilisateur forumngfeature/userposts:view allow 1
moosh role-update-capability solerni_utilisateur mod/forumng:addtag allow 1
moosh role-update-capability solerni_utilisateur mod/forumng:createattachment allow 1
moosh role-update-capability solerni_utilisateur mod/forumng:forwardposts allow 1
moosh role-update-capability solerni_utilisateur mod/forumng:grade allow 1
moosh role-update-capability solerni_utilisateur mod/forumng:rate allow 1
moosh role-update-capability solerni_utilisateur mod/forumng:replypost allow 1
moosh role-update-capability solerni_utilisateur mod/forumng:view allow 1
moosh role-update-capability solerni_utilisateur mod/forumng:viewdiscussion allow 1
moosh role-update-capability solerni_utilisateur mod/forumng:viewrating allow 1
moosh role-update-capability solerni_utilisateur mod/forumng:viewreadinfo allow 1

# Forumng : solerni_animateur can create forumNG
moosh role-update-capability solerni_animateur mod/forumng:addinstance inherit 1
moosh role-update-capability solerni_animateur moodle/course:manageactivities inherit 1

# Forumng : update capabilities
moosh role-update-capability solerni_marketing forumngfeature/edittags:editsettags inherit 1
moosh role-update-capability solerni_course_creator forumngfeature/edittags:editsettags inherit 1
moosh role-update-capability solerni_marketing forumngfeature/edittags:managesettags inherit 1
moosh role-update-capability solerni_apprenant forumngfeature/usage:view inherit 1
moosh role-update-capability solerni_apprenant forumngfeature/userposts:view allow 1
moosh role-update-capability solerni_course_creator forumngfeature/userposts:view allow 1
moosh role-update-capability solerni_course_creator mod/forumng:addtag allow 1
moosh role-update-capability solerni_marketing mod/forumng:copydiscussion inherit 1
moosh role-update-capability solerni_course_creator mod/forumng:createattachment allow 1
moosh role-update-capability solerni_marketing mod/forumng:deleteanypost inherit 1
moosh role-update-capability solerni_marketing mod/forumng:editanypost inherit 1
moosh role-update-capability solerni_course_creator mod/forumng:forwardposts allow 1
moosh role-update-capability solerni_course_creator mod/forumng:grade allow 1
moosh role-update-capability solerni_marketing mod/forumng:ignorepostlimits inherit 1
moosh role-update-capability solerni_marketing mod/forumng:mailnow inherit 1
moosh role-update-capability solerni_marketing mod/forumng:managediscussions inherit 1
moosh role-update-capability solerni_marketing mod/forumng:managesubscriptions inherit 1
moosh role-update-capability solerni_marketing mod/forumng:movediscussions inherit 1
moosh role-update-capability solerni_marketing mod/forumng:postanon inherit 1
moosh role-update-capability solerni_animateur mod/forumng:postanon inherit 1
moosh role-update-capability solerni_marketing mod/forumng:postasmoderator inherit 1
moosh role-update-capability solerni_animateur mod/forumng:postasmoderator inherit 1
moosh role-update-capability solerni_course_creator mod/forumng:rate allow 1
moosh role-update-capability solerni_course_creator mod/forumng:replypost allow 1
moosh role-update-capability solerni_marketing mod/forumng:setimportant inherit 1
moosh role-update-capability solerni_marketing mod/forumng:splitdiscussions inherit 1
moosh role-update-capability solerni_utilisateur mod/forumng:startdiscussion inherit 1
moosh role-update-capability solerni_course_creator mod/forumng:view allow 1
moosh role-update-capability solerni_power_apprenant mod/forumng:viewallposts allow 1
moosh role-update-capability solerni_course_creator mod/forumng:viewdiscussion allow 1
moosh role-update-capability solerni_course_creator mod/forumng:viewrating allow 1
moosh role-update-capability solerni_course_creator mod/forumng:viewreadinfo allow 1

# solerni_course_creator : can add or delete roles in frontpage and courses
moosh role-update-capability solerni_course_creator moodle/role:override allow 1
