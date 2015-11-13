<?php
// This file is part of The Orange Halloween Moodle Theme
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.
require('../config.php');
require_once($CFG->dirroot . '/user/editlib.php');

//HTTPS is required in this page when $CFG->loginhttps enabled
$PAGE->https_required();

// get auth plugin for the subscription. It will also contains the form.
// Get user loose if self-registration not authorized.
$authplugin = get_auth_plugin($CFG->registerauth);
if (!$authplugin->can_signup() || empty($CFG->registerauth)) {
    print_error('notlocalisederrormessage', 'error', '', 'Sorry, you may not use this page.');
}

// Override wanted URL, we do not want to end up here again if user clicks "Login".
$SESSION->wantsurl = $CFG->wwwroot . '/';

// Signup form
$mform_signup = $authplugin->signup_form();

if ($mform_signup->is_cancelled()) {
    redirect(get_login_url());
} else if ($user = $mform_signup->get_data()) {
    $user->confirmed   = 0;
    $user->lang        = current_language();
    $user->firstaccess = time();
    $user->timecreated = time();
    $user->mnethostid  = $CFG->mnet_localhost_id;
    $user->secret      = random_string(15);
    $user->auth        = $CFG->registerauth;
    // Initialize alternate name fields to empty strings.
    $namefields = array_diff(get_all_user_name_fields(), useredit_get_required_name_fields());
    foreach ($namefields as $namefield) {
        $user->$namefield = '';
    }
    $authplugin->user_signup($user, true); // prints notice and link to login/index.php
    exit; //never reached
}

// set page context and stuff.
// make sure we really are on the https page when https login required.
$PAGE->set_url('/login/signup.php');
$PAGE->set_context(context_system::instance());
$PAGE->verify_https_required();
$PAGE->navbar->add(get_string('login'));
$PAGE->navbar->add(get_string('newaccount'));
$PAGE->set_title(get_string('newaccount'));
$PAGE->set_heading($SITE->fullname);

//Templating
echo $OUTPUT->header();
if (isloggedin() and !isguestuser()) {
    require($CFG->partialsdir . '/login/exception_already_logged.php');
} else {
    require($CFG->partialsdir . '/login/signup_header.php');
    $mform_signup->display();
}
echo $OUTPUT->footer();
