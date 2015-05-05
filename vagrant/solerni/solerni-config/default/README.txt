ROLE CONFIGURATION
------------------
settings/users/roles/
This config files have to be installed in following order :
1- solerni_utilisateur.xml
2- solerni_apprenant.xml
3- solerni_power_apprenant.xml
4- solerni_animateur.xml
5- solerni_teacher.xml
6- solerni_course_creator.xml
7- solerni_marketing.xml

In fact, some roles can assign other roles assignments.
course_creator can assign : apprenant, power_apprenant, animateur, teacher, course_creator
teacher can assign : apprenant, power_apprenant, animateur, teacher
Thus those roles (course_creator and teacher) have to be imported after the others.

When all roles are imported, some other configurations can be done :
settings/plugin/enrolments/self_enrolment.zip
settings/users/permissions/user_policies.zip


