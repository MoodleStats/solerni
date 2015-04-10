<?php
$settings->add(new admin_setting_heading(
            'headerconfig',
            get_string('headerconfig', 'block_course_extended'),
            get_string('descconfig', 'block_course_extended')
        ));
 
$settings->add(new admin_setting_configcheckbox(
            'course_extended/Allow_HTML',
            get_string('labelallowhtml', 'block_course_extended'),
            get_string('descallowhtml', 'block_course_extended'),
            '0'
        ));

