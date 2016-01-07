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
 * @package    orange_mail
 * @copyright  2015 Orange
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();

require_once(dirname(__FILE__) . '/mail_object.php');


class mail_generate {

    /**
     * Generate the email template based on the language string id
     * Use by the menu entry in "Site administration" and by "Moosh"
     * @return true
     */
    static public function generate() {

        // Mail for new password.
        mail_object::generate('newpasswordtext', 'text');
        mail_object::generate('newpasswordtext', 'html');

        // Mail sent after user registration.
        mail_object::generate('contentuseraccountemail', 'text');
        mail_object::generate('contentuseraccountemail', 'html');

        // Welcome message.
        mail_object::generate('contentwelcomeemail', 'text');
        mail_object::generate('contentwelcomeemail', 'html');

        // Reset password.
        mail_object::generate('emailresetconfirmation', 'text');
        mail_object::generate('emailresetconfirmationhtml', 'html');

        // Registration e-mail validation.
        mail_object::generate('emailconfirmation', 'text', 'inscription');
        mail_object::generate('emailconfirmation', 'html', 'inscription');

        // Welcome to course.
        mail_object::generate('welcometocoursetext', 'text');
        mail_object::generate('welcometocoursetext', 'html');

        // Inscription for next session.
        mail_object::generate('informationmessagetext', 'text');
        mail_object::generate('informationmessagetext', 'html');

        // Delete account email.
        mail_object::generate('defaultemailmsg', 'text');
        mail_object::generate('defaultemailmsg', 'html');

        // New User by CSV import
        mail_object::generate('newusernewpasswordtext', 'text');
        mail_object::generate('newusernewpasswordtext', 'html');
        
        return true;
    }

}