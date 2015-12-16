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
 * To add the Orange_customers links to the administration block
 *
 * @package    local
 * @subpackage orange_mail
 * @copyright  2015 Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

if ($hassiteconfig) {
    // New settings page
    $page = new admin_settingpage('orange_mail_settings', new lang_string('mailsetting', 'local_orange_mail'));

    $page->add(new admin_setting_heading('general', new lang_string('heading_general', 'local_orange_mail'), ''));
    
    $page->add(new admin_setting_configtext('local_orangemail/contactemail', 
            new lang_string('contactemail', 'local_orange_mail'), 
            new lang_string('contactemail_desc','local_orange_mail'), 'contact@solerni.com', PARAM_NOTAGS));

    $page->add(new admin_setting_configtext('local_orangemail/noreplyemail', 
            new lang_string('noreplyemail', 'local_orange_mail'), 
            new lang_string('noreplyemail_desc','local_orange_mail'), 'noreply@solerni.com', PARAM_NOTAGS));


    $page->add(new admin_setting_heading('htmltemplate', 
            new lang_string('heading_htmltemplate', 'local_orange_mail'), 
            new lang_string('helphtml', 'local_orange_mail')));

    $page->add(new admin_setting_configtextarea('local_orangemail/css', 
            new lang_string('css', 'local_orange_mail'), 
            new lang_string('css_desc', 'local_orange_mail'), '', PARAM_RAW, '50', '10'));

    $page->add(new admin_setting_configtextarea('local_orangemail/header', 
            new lang_string('header', 'local_orange_mail'), 
            new lang_string('header_desc', 'local_orange_mail'), '', PARAM_RAW, '50', '10'));

    $page->add(new admin_setting_configtextarea('local_orangemail/signature', 
            new lang_string('signature', 'local_orange_mail'), 
            new lang_string('signature_desc', 'local_orange_mail'), '', PARAM_RAW, '50', '10'));

    $page->add(new admin_setting_configtextarea('local_orangemail/followus', 
            new lang_string('followus', 'local_orange_mail'), 
            new lang_string('followus_desc', 'local_orange_mail'), '', PARAM_RAW, '50', '10'));

    $page->add(new admin_setting_configtextarea('local_orangemail/footer', 
            new lang_string('footer', 'local_orange_mail'), 
            new lang_string('footer_desc', 'local_orange_mail'), '', PARAM_RAW, '50', '10'));

    $page->add(new admin_setting_configtextarea('local_orangemail/footerinscription', 
            new lang_string('footerinscription', 'local_orange_mail'), 
            new lang_string('footerinscription_desc', 'local_orange_mail'), '', PARAM_RAW, '50', '10'));


    $page->add(new admin_setting_heading('texttemplate', 
            new lang_string('heading_texttemplate', 'local_orange_mail'), 
            new lang_string('helptext', 'local_orange_mail')));

    $page->add(new admin_setting_configtextarea('local_orangemail/headertext', 
            new lang_string('headertext', 'local_orange_mail'), 
            new lang_string('headertext_desc', 'local_orange_mail'), '', PARAM_RAW, '50', '3'));

    $page->add(new admin_setting_configtextarea('local_orangemail/signaturetext', 
            new lang_string('signaturetext', 'local_orange_mail'), 
            new lang_string('signaturetext_desc', 'local_orange_mail'), '', PARAM_RAW, '50', '3'));

    $page->add(new admin_setting_configtextarea('local_orangemail/followustext', 
            new lang_string('followustext', 'local_orange_mail'), 
            new lang_string('followustext_desc', 'local_orange_mail'), '', PARAM_RAW, '50', '3'));

    $page->add(new admin_setting_configtextarea('local_orangemail/footertext', 
            new lang_string('footertext', 'local_orange_mail'), 
            new lang_string('footertext_desc', 'local_orange_mail'), '', PARAM_RAW, '50', '3'));

    $page->add(new admin_setting_configtextarea('local_orangemail/footerinscriptiontext', 
            new lang_string('footerinscriptiontext', 'local_orange_mail'), 
            new lang_string('footerinscriptiontext_desc', 'local_orange_mail'), '', PARAM_RAW, '50', '3'));

    
    $ADMIN->add('localplugins', new admin_category('orange_mail', new lang_string('pluginname', 'local_orange_mail')));
    
    // Add settings page to navigation tree
    $ADMIN->add('orange_mail', $page);

    $temp= new admin_externalpage('orange_mail_generate', new lang_string('mailgenerate', 'local_orange_mail'), $CFG->wwwroot . '/local/orange_mail/generate.php',
			'local/orange_mail:config');
    $ADMIN->add('orange_mail', $temp);
    $temp= new admin_externalpage('orange_mailtest', new lang_string('mailtest', 'local_orange_mail'), $CFG->wwwroot . '/local/orange_mail/test.php',
			'local/orange_mail:config');
    $ADMIN->add('orange_mail', $temp);
}