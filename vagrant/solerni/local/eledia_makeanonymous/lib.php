<?php
// This file is part of Moodle - http://moodle.org/
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

/**
 * This local plugin anonymizes data of deleted users, 
 * optinally with a delay time.
 *
 * @package local_eledia_makeanonymous
 * @copyright  2015 Orange
 *     Fork : author Matthias Schwabe <support@eledia.de>,  copyright 2013 & 2014 eLeDia GmbH
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Called from event observer.
 */
function start_anonymous($userid, $useroldemail) {
    global $DB;

    $config = get_config('local_eledia_makeanonymous');

    if ($config->enable == '1') {

        $user = $DB->get_record('user', array('id' => $userid));

        if ($config->delay == '0') {
            make_anonymous($user, $useroldemail);
        } else {
            store_to_table($user);
        }
    }
}

/**
 * The function which anonymizes the deleted user.
 */
function make_anonymous($user, $useroldemail='') {
    global $DB;

    $config = get_config('local_eledia_makeanonymous');

    // Mark internal user record as "deleted".
    $updateuser = new stdClass();
    $updateuser->id           = $user->id;

    $uniquestr = hash('crc32' , $user->username.time());
    $updateuser->deleted      = 1;
    $updateuser->idnumber     = '';
    $updateuser->picture      = 0;
    $updateuser->firstname    = $config->deletedfirstname;
    $updateuser->lastname     = $config->deletedsurname;
    $updateuser->country      = $config->deletedcountry;
    $updateuser->city         = $config->deletedcity;
    $updateuser->username     = $config->deletedprefixusername . $uniquestr;
    $updateuser->email        = $config->deletedprefixemail . $uniquestr . '@' .$config->deletedomainemail;
    $updateuser->emailstop    = 1;
    $updateuser->auth         = $config->deletedauth;

    $updateuser->mnethostid = 0;
    $updateuser->icq = '';
    $updateuser->skype = '';
    $updateuser->yahoo = '';
    $updateuser->aim = '';
    $updateuser->msn = '';
    $updateuser->phone1 = '';
    $updateuser->phone2 = '';
    $updateuser->institution = '';
    $updateuser->department = '';
    $updateuser->address = '';
    $updateuser->lang = '';
    $updateuser->timezone = '';
    $updateuser->lastip = '0.0.0.0';
    $updateuser->secret = '';
    $updateuser->url = '';
    $updateuser->description = '';
    $updateuser->imagealt = '';

    $updateuser->timemodified = '0';
    $updateuser->firstaccess = '0';
    $updateuser->lastaccess = '0';
    $updateuser->lastlogin = '0';
    $updateuser->currentlogin = '0';
    $updateuser->timecreated = '0';

    $updateuser->lastnamephonetic = '';
    $updateuser->firstnamephonetic = '';
    $updateuser->middlename = '';
    $updateuser->alternatename = '';

    $DB->update_record('user', $updateuser);
    // Send an email to user.
    if (get_config('local_eledia_makeanonymous', 'enabledemail')) {
        if (!empty($useroldemail) &&
            ((local_orange_library\utilities\utilities_network::is_platform_uses_mnet() &&
              local_orange_library\utilities\utilities_network::is_home()) ||
             (!local_orange_library\utilities\utilities_network::is_platform_uses_mnet()))
           ) {
            send_email_deletion($user, $useroldemail);
        }
    }
}

/**
 * Stores deleted users into a table to anonymize them
 * after a certain delay time.
 */
function store_to_table($user) {
    global $DB;

    $record = new stdClass();
    $record->userid = $user->id;
    $record->timedeleted = time();
    $DB->insert_record('local_eledia_makeanonymous', $record, false, false);
}

/**
 * Called from scheduled task.
 */
function anonymize_task() {
    global $DB;

    $config = get_config('local_eledia_makeanonymous');

    if ($config->enable == '1') {

        $timenow = time();

        $delay = $config->delay * 60; // Minutes to seconds.
        $delaytime = $timenow - $delay;

        $sql = ("SELECT userid
                 FROM {local_eledia_makeanonymous}
                 WHERE timedeleted < ?");
        $params = array($delaytime);
        $userids = $DB->get_records_sql($sql, $params);

        foreach ($userids as $userid) {

            $id = $userid->userid;
            $user = $DB->get_record('user', array('id' => $id));
            make_anonymous($user);
        }

        $DB->delete_records_select('local_eledia_makeanonymous', "timedeleted < ?", array($delaytime));

        return true;
    }
}

/**
 * Called from send deletion email to user
 */
function send_email_deletion($user, $useroldemail) {
    $supportuser = core_user::get_support_user();
    $message = get_config('local_eledia_makeanonymous', 'emailmsg');

    // Otherwise email_to_user() method block email.
    $user->deleted      = 0;
    $user->email     = $useroldemail;

    $a = new stdClass();
    $a->fullname = fullname($user);
    $a->email = $user->email;

    if (trim($message) !== '') {
        $key = array('{$a->fullname}', '{$a->email}');
        $value = array($a->fullname, $a->email);
        $message = str_replace($key, $value, $message);

        if (strpos($message, '<') === false) {
            // Plain text only.
            $messagetext = $message;
            $messagehtml = text_to_html($messagetext, null, false, true);
        } else {
            // This is most probably the tag/newline soup known as FORMAT_MOODLE.
            $messagehtml = format_text($message, FORMAT_MOODLE, array('para' => false, 'newlines' => true, 'filter' => true));
            $messagetext = html_to_text($messagehtml);
        }
    } else {
        $messagehtml = get_string('defaultemailmsg', 'local_eledia_makeanonymous', $a);
        $messagetext = text_to_html($messagehtml);
    }

    $subject = get_config('local_eledia_makeanonymous', 'emailsubject');
    if (trim($subject) == '') {
        $subject = get_string('defaultemailsubject', 'local_eledia_makeanonymous');
    }

    if (! email_to_user($user, $supportuser, $subject, $messagetext, $messagehtml)) {
        mtrace('mail error : mail was not sent to '. $user->email);
    }
}
