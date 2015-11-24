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

use theme_halloween\tools\theme_utilities;

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir.'/formslib.php');
require_once($CFG->dirroot.'/user/profile/lib.php');
require_once($CFG->dirroot . '/user/editlib.php');

class login_signup_form extends moodleform {

    function definition() {
        global $CFG, $PAGE;

        require_once($CFG->dirroot . '/filter/multilang/filter.php');
        $filtermultilang = new filter_multilang($PAGE->context, array());

        $mform = $this->_form;
        // Name, surname.
        $namefields = useredit_get_required_name_fields();
        foreach ($namefields as $field) {
            $mform->addElement('text', $field, get_string($field),
                    array('maxlength' => 100, 'size' => 30, 'class' => 'form-control'));
            $mform->setType($field, PARAM_TEXT);
            $stringid = 'missing' . $field;
            if (!get_string_manager()->string_exists($stringid, 'moodle')) {
                $stringid = 'required';
            }
            $mform->addRule($field, get_string($stringid), 'required', null, 'client');
        }
        // Pseudo.
        $usernamelabel = (theme_utilities::is_theme_settings_exists_and_nonempty('signupusername')) ?
            $filtermultilang->filter($PAGE->theme->settings->signupusername) :
            get_string('username', 'theme_halloween');
        if (theme_utilities::is_theme_settings_exists_and_nonempty('signupusernamesub')) {
            $usernamehelptext = $filtermultilang->filter($PAGE->theme->settings->signupusernamesub);
        }
        $mform->addElement('text', 'username', $usernamelabel, array('maxlength' => 100, 'size' => 12, 'class' => 'form-control'));
        $mform->setType('username', PARAM_NOTAGS);
        $mform->addRule('username', get_string('missingusername', 'theme_halloween',
                strtolower($usernamelabel)), 'required', null, 'client');
        if ($usernamehelptext) {
            $mform->addElement('helpblock', 'usernamehelper', 'label', $usernamehelptext);
        }
        //Email.
        $mform->addElement('text', 'email', get_string('email'),
                array('maxlength' => 100, 'size' => 25, 'class' => 'form-control'));
        $mform->setType('email', PARAM_RAW_TRIMMED);
        $mform->addRule('email', get_string('missingemail'), 'required', null, 'client');
        // Password.
        if (theme_utilities::is_theme_settings_exists_and_nonempty('signuppasswordsub')) {
            $passwordhelptext = $filtermultilang->filter($PAGE->theme->settings->signuppasswordsub);
        }
        $mform->addElement('passwordunmask', 'password', get_string('password'),
                array('maxlength' => 100, 'size' => 12, 'class' => 'form-control'));
        $mform->setType('password', PARAM_RAW);
        $mform->addRule('password', get_string('missingpassword'), 'required', null, 'client');
        if ($passwordhelptext) {
            $mform->addElement('helpblock', 'passwordhelper', 'label', $passwordhelptext);
        }
        // CGU required
        if ($cgulink = theme_utilities::get_platform_cgu_url()) {
            $mform->addElement('inversecheckbox', 'policyagreed',
                    get_string('policyaccept', 'theme_halloween', $cgulink));
            $mform->addRule('policyagreed', get_string('policyagree'), 'required', null, 'client');
        }
        // Commercial
        halloween_profile_signup_fields($mform);
        // Submit
        $mform->addElement('submit', 'submitbutton', get_string('create_account', 'theme_halloween'),
                array('class' => 'btn btn-engage'));
    }
    /**
     * Does something (trimming, obviously) with username
     */
    function definition_after_data() {
        $mform = $this->_form;
        $mform->applyFilter('username', 'trim');
    }

    /**
     *
     * Server-side check of the data.
     *
     * @global type $CFG
     * @global type $DB
     * @param type $data
     * @param type $files
     * @return array (fieldname => errors)
     */
    function validation($data, $files) {
        global $CFG, $DB;
        $errors = parent::validation($data, $files);

        $authplugin = get_auth_plugin($CFG->registerauth);

        if ($DB->record_exists('user', array('username'=>$data['username'], 'mnethostid'=>$CFG->mnet_localhost_id))) {
            $errors['username'] = get_string('usernameexists');
        } else {
            //check allowed characters
            if ($data['username'] !== core_text::strtolower($data['username'])) {
                $errors['username'] = get_string('usernamelowercase');
            } else {
                if ($data['username'] !== clean_param($data['username'], PARAM_USERNAME)) {
                    $errors['username'] = get_string('invalidusername');
                }
            }
        }

        //check if user exists in external db
        //TODO: maybe we should check all enabled plugins instead
        if ($authplugin->user_exists($data['username'])) {
            $errors['username'] = get_string('usernameexists');
        }

        if (! validate_email($data['email'])) {
            $errors['email'] = get_string('invalidemail');
        } else if ($DB->record_exists('user', array('email'=>$data['email']))) {
            $errors['email'] = get_string('emailexists').' <a href="forgot_password.php">'.get_string('newpassword').'?</a>';
        }

        // Do not remove $errmsg variable : it is passed as reference by the password checker
        $errmsg = '';
        if (!check_password_policy($data['password'], $errmsg)) {
            $errors['password'] = $errmsg;
        }

        if (!$data['policyagreed']) {
            $errors['policyagreed'] = get_string('policyagree');
        }

        if ($this->signup_captcha_enabled()) {
            $recaptcha_element = $this->_form->getElement('recaptcha_element');
            if (!empty($this->_form->_submitValues['recaptcha_challenge_field'])) {
                $challenge_field = $this->_form->_submitValues['recaptcha_challenge_field'];
                $response_field = $this->_form->_submitValues['recaptcha_response_field'];
                if (true !== ($result = $recaptcha_element->verify($challenge_field, $response_field))) {
                    $errors['recaptcha'] = $result;
                }
            } else {
                $errors['recaptcha'] = get_string('missingrecaptchachallengefield');
            }
        }
        // Validate customisable profile fields. (profile_validation expects an object as the parameter with userid set)
        $dataobject = (object)$data;
        $dataobject->id = 0;
        $errors += profile_validation($dataobject, $files);

        return $errors;

    }

    /**
     * Returns whether or not the captcha element is enabled, and the admin settings fulfil its requirements.
     * @return bool
     */
    function signup_captcha_enabled() {
        global $CFG;
        return !empty($CFG->recaptchapublickey) && !empty($CFG->recaptchaprivatekey) && get_config('auth/email', 'recaptcha');
    }

}
