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
 * English language file.
 *
 * @package local_eledia_makeanonymous
 * @author Matthias Schwabe <support@eledia.de>
 * @copyright 2013 & 2014 eLeDia GmbH
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['pluginname'] = 'makeanonymous';

$string['anonymousauth'] = 'Auth method of anonymous users';
$string['anonymouscountry'] = 'Country of anonymous users';
$string['anonymouscity'] = 'City of anonymous users';
$string['anonymousfirstname'] = 'First name of anonymous users';
$string['anonymoussurname'] = 'Surname of anonymous users';
$string['anonymoususername_prefix'] = 'Username prefix of anonymous users';
$string['anonymousdomainemail'] = 'Email domain name of anonymous users';
$string['anonymousprefixemail'] = 'Email prefix of anonymous users';
$string['makeanonymous_desc'] = 'eLeDia makeanonymous plugin to make deleted users anonymous';
$string['makeanonymous_delay_desc'] = 'You can delay the anonymization';
$string['makeanonymous_delay'] = 'Enable delay';
$string['makeanonymous_delay_config'] = 'Enable delay to anonymize deleted users after a certain time.';
$string['makeanonymous_delay_time'] = 'Delay time (minutes)';
$string['makeanonymous_anonymize_old_head'] = 'Anonymization of former deleted users';
$string['makeanonymous_enable'] = 'Enable makeanonymous plugin';
$string['makeanonymous_enable_desc'] = 'If this option is disabled this plugin will have no effect.';
$string['makeanonymous_anonymize_no_users'] = 'There are no former deleted users you can anonymize.';
$string['makeanonymous_anonymize_users_available'] = 'There are {$a} former deleted users you can anonymize. You can do this by clicking the button below this text.';
$string['makeanonymous_button'] = 'Make former deleted users anonymous';
$string['makeanonymous_anonymize_old_desc'] = 'You can also anonymize users which you have deleted in the past.';
$string['eledia_makeanonymous_task'] = 'Task for delayed anonymisation of deleted users.';
$string['email_desc'] = 'You can inform users by email';
$string['mailerror'] = 'the mail can\'t be sent';
$string['emailsubject'] = 'mail subject';
$string['emailsubject_desc'] = 'Subject shown on sent mail';
$string['defaultemailsubject'] = 'Your account has been deleted from Solerni';
$string['emailmsg'] = 'mail message';
$string['emailmsg_desc'] = 'A custom welcome message may be added as plain text or Moodle-auto format, including HTML tags and multi-lang tags.
The following placeholders may be included in the message:
    User\'s name {$a->fullname}
    User\'s email {$a->email}';
$string['defaultemailmsg'] = 'Hello {$a->fullname},<br> Your account has been deleted from Solerni. <br>Thank you for using Solerni!';
$string['enabledemail'] = 'Enabled email';
$string['enabledemail_desc'] = 'Enable plateform to send mail to confirm user deletion';
