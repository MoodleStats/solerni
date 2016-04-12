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

require_once(dirname(__FILE__) . '/../config.php');
require_once('lib.php');

use local_orange_library\utilities\utilities_network;
use theme_halloween\tools\log_and_session_utilities;

redirect_if_major_upgrade_required();
$testsession = optional_param('testsession', 0, PARAM_INT);     // test session works properly
$locallog    = optional_param('locallog', 0, PARAM_BOOL);       // if true, use local database for login
$cancel      = optional_param('cancel', 0, PARAM_BOOL);
// redirect to frontpage, needed for loginhttps
if ($cancel) {
    redirect(new moodle_url('/'));
}

//HTTPS is required in this page when $CFG->loginhttps enabled.
$PAGE->https_required();
$PAGE->set_url("$CFG->httpswwwroot/login/index.php");
$PAGE->set_context(context_system::instance());
$PAGE->set_pagelayout('login');

// Initialize variables and redirect user when testsession exists and no errors.
$loginstateinit = log_and_session_utilities::testsession_initialize($testsession);
log_and_session_utilities::login_redirect_user($loginstateinit, $testsession);
$errormsg   = $loginstateinit['errormsg'];
$errorcode  = $loginstateinit['errorcode'];
$site       = get_site();
$loginsite  = get_string("loginsite");
$PAGE->navbar->add($loginsite);

//  From this point this is the first loop. The form is either empty, or invalid.
// auth plugins may override these - SSO anyone?
$frm  = false;
if ((isloggedin() and !isguestuser()) ) {
    $user = $USER;
} else {
    $user = false;
}

// Iterate auth plugins to catch possible auth processing.
$authsequence = get_enabled_auth_plugins(true); // auths, in sequence
foreach($authsequence as $authname) {
    $authplugin = get_auth_plugin($authname);
    $authplugin->loginpage_hook();
}

if ($user !== false || $frm !== false || $errormsg !== '') {
    // some auth plugin already supplied full user, fake form data or prevented user login with error message
} else if (!empty($SESSION->wantsurl) && file_exists($CFG->dirroot.'/login/weblinkauth.php')) {
    // Handles the case of another Moodle site linking into a page on this site
    //TODO: move weblink into own auth plugin
    include($CFG->dirroot.'/login/weblinkauth.php');
    if (function_exists('weblink_auth')) {
        $user = weblink_auth($SESSION->wantsurl);
    }
    if ($user) {
        $frm->username = $user->username;
    } else {
        $frm = data_submitted();
    }
} else {
    $frm = data_submitted();
}

/// Check for timed out sessions
if (!empty($SESSION->has_timed_out)) {
    $session_has_timed_out = true;
    unset($SESSION->has_timed_out);
} else {
    $session_has_timed_out = false;
}

/// Check if the user has actually submitted login data to us
// Login WITH cookies
if ($frm and isset($frm->username)) {
    // If user come from thematic, use jump url in $SESSION
    log_and_session_utilities::check_for_mnet_origin($frm);
    $frm->username = trim(core_text::strtolower($frm->username));
    if (is_enabled_auth('none') ) {
        if ($frm->username !== clean_param($frm->username, PARAM_USERNAME)) {
            $errormsg = get_string('username').': '.get_string("invalidusername");
            $errorcode = 2;
            $user = null;
        }
    }
    if ($user) {
        //user already supplied by auth plugin prelogin hook
    } else if (($frm->username == 'guest') and empty($CFG->guestloginbutton)) {
        $user = false;    /// Can't log in as guest if guest button is disabled
        $frm = false;
    } else {
        if (empty($errormsg)) {
            $user = authenticate_user_login($frm->username, $frm->password);
        }
    }

    // Intercept 'restored' users to provide them with info & reset password
    if (!$user and $frm and is_restored_user($frm->username)) {
        $PAGE->set_title(get_string('restoredaccount'));
        $PAGE->set_heading($site->fullname);
        echo $OUTPUT->header();
        echo $OUTPUT->heading(get_string('restoredaccount'));
        echo $OUTPUT->box(get_string('restoredaccountinfo'), 'generalbox boxaligncenter');
        require_once('restored_password_form.php'); // Use our "supplanter" login_forgot_password_form. MDL-20846
        $form = new login_forgot_password_form('forgot_password.php', array('username' => $frm->username));
        $form->display();
        echo $OUTPUT->footer();
        die;
    }

    if ($user) {
        // language setup
        if (isguestuser($user)) {
            // no predefined language for guests - use existing session or default site lang
            unset($user->lang);
        } else if (!empty($user->lang)) {
            // unset previous session language - use user preference instead
            unset($SESSION->lang);
        }

        // This account need to have its email confirmed
        if (empty($user->confirmed)) {
            $PAGE->set_title(get_string("mustconfirm"));
            $PAGE->set_heading($site->fullname);
            echo $OUTPUT->header();
            echo $OUTPUT->heading(get_string("mustconfirm"));
            echo $OUTPUT->box(get_string("emailconfirmsent", "", $user->email), "generalbox boxaligncenter");
            echo $OUTPUT->footer();
            die;
        }

        /// Let's get them all set up.
        complete_user_login($user);

        // sets the username cookie
        if (!empty($CFG->nolastloggedin)) {
            // do not store last logged in user in cookie
            // auth plugins can temporarily override this from loginpage_hook()
            // do not save $CFG->nolastloggedin in database!

        } else if (empty($CFG->rememberusername) or ($CFG->rememberusername == 2 and empty($frm->rememberusername))) {
            // no permanent cookies, delete old one if exists
            set_moodle_cookie('');

        } else {
            set_moodle_cookie($USER->username);
        }

        $urltogo = core_login_get_return_url();

        /// check if user password has expired
        /// Currently supported only for ldap-authentication module
        $userauth = get_auth_plugin($USER->auth);
        if (!empty($userauth->config->expiration) and $userauth->config->expiration == 1) {
            if ($userauth->can_change_password()) {
                $passwordchangeurl = $userauth->change_password_url();
                if (!$passwordchangeurl) {
                    $passwordchangeurl = $CFG->httpswwwroot.'/login/change_password.php';
                }
            } else {
                $passwordchangeurl = $CFG->httpswwwroot.'/login/change_password.php';
            }
            $days2expire = $userauth->password_expire($USER->username);
            $PAGE->set_title("$site->fullname: $loginsite");
            $PAGE->set_heading("$site->fullname");
            if (intval($days2expire) > 0 && intval($days2expire) < intval($userauth->config->expiration_warning)) {
                echo $OUTPUT->header();
                echo $OUTPUT->confirm(get_string('auth_passwordwillexpire', 'auth', $days2expire), $passwordchangeurl, $urltogo);
                echo $OUTPUT->footer();
                exit;
            } elseif (intval($days2expire) < 0 ) {
                echo $OUTPUT->header();
                echo $OUTPUT->confirm(get_string('auth_passwordisexpired', 'auth'), $passwordchangeurl, $urltogo);
                echo $OUTPUT->footer();
                exit;
            }
        }

        // Discard any errors before the last redirect.
        unset($SESSION->loginerrormsg);

        // test the session actually works by redirecting to self.
        $SESSION->wantsurl = $urltogo;
        redirect(new moodle_url(get_login_url(), array('testsession'=>$USER->id)));

    } else {
        if (empty($errormsg)) {
            $errormsg = get_string('invalidlogin', 'theme_halloween', strtolower(get_string('username', 'theme_halloween')));
            $errorcode = 3;
        }
    }
}

// User is already log.
if ((isloggedin() and !isguestuser()) ) {
    if ($frm = data_submitted()) {
        log_and_session_utilities::check_for_mnet_origin($frm);
        redirect(new moodle_url(get_login_url(), array('testsession'=>$USER->id)));
    }
}

/// Detect problems with timedout sessions
if ($session_has_timed_out and !data_submitted()) {
    $errormsg = get_string('sessionerroruser', 'error');
    $errorcode = 4;
}

/// First, let's remember where the user was trying to get to before they got here.
if (empty($SESSION->wantsurl) && array_key_exists('HTTP_REFERER',$_SERVER)) {

    // array of urls with strict comparaison, or not.
    $specialurls = array(
        array('url' => $CFG->wwwroot, 'strict' => true),
        array('url' => $CFG->wwwroot.'/', 'strict' => true),
        array('url' => $CFG->httpswwwroot.'/login/', 'strict' => false),
        array('url' => $CFG->wwwroot.'/login/', 'strict' => false),
        array('url' => $CFG->wwwroot.'/local/goodbye/index.php', 'strict' => false)
    );
    $nogo = false;

    //referrer is another domain
    if (strpos($_SERVER["HTTP_REFERER"], $CFG->wwwroot) === false) {
         $nogo = true;
    }

    // Check each specialurl unless allready resolved.
    if (!$nogo) {
        foreach($specialurls as $url) {
            if($url['strict']) {
                $nogo = ($url['url'] == $_SERVER["HTTP_REFERER"]) ? true : false;
            } else {
                $nogo = (strpos($_SERVER["HTTP_REFERER"], $url['url']) !==  false) ? true : false;
            }
        }
    }

    // Register the referrer as wanted url if referrer is not enlisted as exception.
    if(!$nogo) {
        $SESSION->wantsurl = $_SERVER["HTTP_REFERER"];
    }
}

// We need a value later in this page.
if (!isset($SESSION->wantsurl)) {
    $SESSION->wantsurl = NULL;
}

/// Redirect to alternative login URL if needed
if (!empty($CFG->alternateloginurl)) {
    $loginurl = $CFG->alternateloginurl;

    if (strpos($SESSION->wantsurl, $loginurl) === 0) {
        //we do not want to return to alternate url
        $SESSION->wantsurl = NULL;
    }

    if ($errorcode) {
        if (strpos($loginurl, '?') === false) {
            $loginurl .= '?';
        } else {
            $loginurl .= '&';
        }
        $loginurl .= 'errorcode='.$errorcode;
    }

    redirect($loginurl);
}

// make sure we really are on the https page when https login required
$PAGE->verify_https_required();

/// Generate the login page with forms
if (!isset($frm) or !is_object($frm)) {
    $frm = new stdClass();
}

if (empty($frm->username) && $authsequence[0] != 'shibboleth') {  // See bug 5184
    if (!empty($_GET["username"])) {
        $frm->username = clean_param($_GET["username"], PARAM_RAW); // we do not want data from _POST here
    } else {
        $frm->username = get_moodle_cookie();
    }
    $frm->password = "";
}

if (!empty($frm->username)) {
    $focus = "password";
} else {
    $focus = "username";
}

if (!empty($CFG->registerauth) or is_enabled_auth('none') or !empty($CFG->auth_instructions)) {
    $show_instructions = true;
} else {
    $show_instructions = false;
}

$potentialidps = array();
foreach($authsequence as $authname) {
    $authplugin = get_auth_plugin($authname);
    $potentialidps = array_merge($potentialidps, $authplugin->loginpage_idp_list($SESSION->wantsurl));
}

if (!empty($SESSION->loginerrormsg)) {
    // We had some errors before redirect, show them now.
    $errormsg = $SESSION->loginerrormsg;
    unset($SESSION->loginerrormsg);

} else if ($testsession) {
    // No need to redirect here.
    unset($SESSION->loginerrormsg);

} else if ($errormsg or !empty($frm->password)) {
    // We must redirect after every password submission.
    if ($errormsg) {
        $SESSION->loginerrormsg = $errormsg;
    }
    redirect(new moodle_url('/login/index.php'));
}

$PAGE->set_title("$site->fullname: $loginsite");
$PAGE->set_heading("$site->fullname");

// Templating
echo $OUTPUT->header();
if (isloggedin() and !isguestuser()) {
    require($CFG->partialsdir . '/login/exception_already_logged.php');
} else {
    require('login_form.php');
    if ($errormsg) {
        $PAGE->requires->js_init_call('M.util.focus_login_error', null, true);
    } else if (!empty($CFG->loginpageautofocus)) {
        //focus username or password
        $PAGE->requires->js_init_call('M.util.focus_login_form', null, true);
    }
}
echo $OUTPUT->footer();
