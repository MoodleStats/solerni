<?php
echo $OUTPUT->box_start();
$logout = new single_button(new moodle_url($CFG->httpswwwroot . '/login/logout.php',
    array('sesskey' => sesskey(), 'loginpage' => 1)), get_string('logout'), 'post');
$continue = new single_button(new moodle_url('/'), get_string('cancel'), 'get');
if ("$CFG->httpswwwroot/login/index.php" == $PAGE->url) {
    echo $OUTPUT->confirm(get_string('alreadyloggedin', 'error', fullname($USER)), $logout, $continue);
} else {
    echo $OUTPUT->confirm(get_string('cannotsignup', 'error', fullname($USER)), $logout, $continue);
}
echo $OUTPUT->box_end();
