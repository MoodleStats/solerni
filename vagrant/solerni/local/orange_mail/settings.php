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
    // New settings page.
    $page = new admin_settingpage('orange_mail_settings', new lang_string('mailsetting', 'local_orange_mail'));

    $page->add(new admin_setting_heading('general', new lang_string('heading_general', 'local_orange_mail'), ''));

    $page->add(new admin_setting_configtext('local_orangemail/contactemail',
            new lang_string('contactemail', 'local_orange_mail'),
            new lang_string('contactemail_desc', 'local_orange_mail'), 'contact@solerni.fr', PARAM_NOTAGS));

    $page->add(new admin_setting_configtext('local_orangemail/supportemail',
            new lang_string('supportemail', 'local_orange_mail'),
            new lang_string('supportemail_desc', 'local_orange_mail'), 'support@solerni.com', PARAM_NOTAGS));

    $page->add(new admin_setting_configtext('local_orangemail/marketemail',
            new lang_string('marketemail', 'local_orange_mail'),
            new lang_string('marketemail_desc', 'local_orange_mail'), 'marketing@solerni.com', PARAM_NOTAGS));

    $page->add(new admin_setting_configtext('local_orangemail/partneremail',
            new lang_string('partneremail', 'local_orange_mail'),
            new lang_string('partneremail_desc', 'local_orange_mail'), 'partners@solerni.com', PARAM_NOTAGS));

    $page->add(new admin_setting_configtext('local_orangemail/noreplyemail',
            new lang_string('noreplyemail', 'local_orange_mail'),
            new lang_string('noreplyemail_desc', 'local_orange_mail'), 'noreply@solerni.fr', PARAM_NOTAGS));


    $page->add(new admin_setting_heading('htmltemplate',
            new lang_string('heading_htmltemplate', 'local_orange_mail'),
            new lang_string('helphtml', 'local_orange_mail')));

    $page->add(new admin_setting_configtextarea('local_orangemail/css',
            new lang_string('css', 'local_orange_mail'),
            new lang_string('css_desc', 'local_orange_mail'), '<style type="text/css">
body, td, th, ul {
	font-family: Arial, Helvetica, sans-serif;
	color: #000;
	font-size: 18px;
}
.txt14blanc, .txt14blanc > p {
	color: #FFF;
	font-size: 14px;
}
.lientxt14orange {
	color: #F16E00;
	font-size: 14px;
	text-decoration: underline;
}
.lientxt18orange {
	color: #F16E00;
	font-size: 18px;
	text-decoration: underline;
}
.lientxt18noir {
	color: #000;
	font-size: 18px;
	text-decoration: underline;
}
.txt18Noir, .txt18Noir > p {
	color: #000;
	font-size: 18px;
}
.txt18BNoir, .txt18BNoir > p {
	color: #000;
	font-size: 18px;
	font-weight: bold;
}
.txt22BBlanc, .txt22BBlanc > p {
	font-family: "OrangeSans", Arial, Helvetica, sans-serif;;
	color: #FFF;
	font-size: 18px;
	font-weight: bold;
	vertical-align: bottom;
}
div.forumng-info h2 small {
	color: #000;
	font-size: 16px;
}
div.forumng-moderator-flag, span.forumng-date {
	color: #000;
	font-size: 10px;
}
div.forumng-message p {
	color: #000;
	font-size: 16px;
}
div.forumng-emailheader a,
.text_to_html a {
	color: #F16E00;
	font-size: 18px;
	text-decoration: underline;
}
div.forumng-email-navbar a,
div.forumng-email-unsubscribe a,
h3.forumng-subject a,
div.forumng-info h2 a,
div.forumng-message a,
div.forumng-breadcrumbs a,
ul.forumng-attachments a,
ul.forumng-commands a {
	color: #F16E00;
	font-size: 16px;
	text-decoration: underline;
}
div.forumng-post {
        border: 1px solid #AAA;
        padding: 0.5em;
        margin-top: 1em;
        margin-bottom: 1em;
}
</style>', PARAM_RAW, '50', '10'));

    $page->add(new admin_setting_configtextarea('local_orangemail/header',
            new lang_string('header', 'local_orange_mail'),
            new lang_string('header_desc', 'local_orange_mail'), '  <tr>
    <td height="100" align="center" bgcolor="#000000"><table width="600" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td width="70" >
                <a href="{$b->siteurl}"><img src="{$b->imageurl}logo.png" width="62" height="54" alt="{$b->sitename}"
                title="{$b->sitename}" /></a>
            </td><td class="txt22BBlanc" align="left">{$b->servicename}</td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td height="20">&nbsp;</td>
  </tr>', PARAM_RAW, '50', '10'));

    $page->add(new admin_setting_configtextarea('local_orangemail/contentstart',
            new lang_string('contentstart', 'local_orange_mail'),
            new lang_string('contentstart_desc', 'local_orange_mail'), '  <tr>
    <td><table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td class="txt18Noir">', PARAM_RAW, '50', '10'));

    $page->add(new admin_setting_configtextarea('local_orangemail/contentend',
            new lang_string('contentend', 'local_orange_mail'),
            new lang_string('contentend_desc', 'local_orange_mail'), '</td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td height="20">&nbsp;</td>
  </tr>', PARAM_RAW, '50', '10'));

    $page->add(new admin_setting_configtextarea('local_orangemail/signature',
            new lang_string('signature', 'local_orange_mail'),
            new lang_string('signature_desc', 'local_orange_mail'), '  <tr>
    <td><table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td class="txt18Noir"><p>{$b->solernimailsignature}</p></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td height="20">&nbsp;</td>
  </tr>', PARAM_RAW, '50', '10'));

    $page->add(new admin_setting_configtextarea('local_orangemail/followus',
            new lang_string('followus', 'local_orange_mail'),
            new lang_string('followus_desc', 'local_orange_mail'), '<tr>
    <td height="70" bgcolor="#000000"><table border="0" align="left" cellpadding="0" cellspacing="0">
<tr>
    <td width="25">&nbsp;</td>
    <td width="110" class="txt14blanc">{$b->solernimailfollowus}</td>
    <td width="57"><a href="{$b->facebook}"><img src="{$b->imageurl}picto_facebook.png" width="36" height="36"
    alt="Faceboook" /></a></td>
    <td width="57"><a href="{$b->twitter}"><img src="{$b->imageurl}picto_twitter.png" width="36" height="36"
    alt="twitter" /></a></td>
    <td width="57"><a href="{$b->blog}"><img src="{$b->imageurl}picto_blog.png" width="36" height="36" alt="" /></a></td>
    </tr>
    </table></td>
</tr>
<tr>
<td><img src="{$b->imageurl}sep.png" width="650" height="1" /></td>
</tr>', PARAM_RAW, '50', '10'));

    $page->add(new admin_setting_configtextarea('local_orangemail/footer',
            new lang_string('footer', 'local_orange_mail'),
            new lang_string('footer_desc', 'local_orange_mail'), '  <tr>
    <td height="170" bgcolor="#000000"><table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td class="txt14blanc">{$b->solernimailfooterhtml}</td>
        </tr>
      </table></td>
  </tr>', PARAM_RAW, '50', '10'));

    $page->add(new admin_setting_configtextarea('local_orangemail/footerinscription',
            new lang_string('footerinscription', 'local_orange_mail'),
            new lang_string('footerinscription_desc', 'local_orange_mail'), '  <tr>
    <td height="230" bgcolor="#000000"><table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td class="txt14blanc">{$b->solernimailfooterinscriptionhtml}</td>
        </tr>
      </table></td>
  </tr>', PARAM_RAW, '50', '10'));


    $page->add(new admin_setting_heading('texttemplate',
            new lang_string('heading_texttemplate', 'local_orange_mail'),
            new lang_string('helptext', 'local_orange_mail')));

    $page->add(new admin_setting_configtextarea('local_orangemail/headertext',
            new lang_string('headertext', 'local_orange_mail'),
            new lang_string('headertext_desc', 'local_orange_mail'), '', PARAM_RAW, '50', '3'));

    $page->add(new admin_setting_configtextarea('local_orangemail/signaturetext',
            new lang_string('signaturetext', 'local_orange_mail'),
            new lang_string('signaturetext_desc', 'local_orange_mail'), '{$b->solernimailsignaturetext}', PARAM_RAW, '50', '3'));

    $page->add(new admin_setting_configtextarea('local_orangemail/followustext',
            new lang_string('followustext', 'local_orange_mail'),
            new lang_string('followustext_desc', 'local_orange_mail'), '', PARAM_RAW, '50', '3'));

    $page->add(new admin_setting_configtextarea('local_orangemail/footertext',
            new lang_string('footertext', 'local_orange_mail'),
            new lang_string('footertext_desc', 'local_orange_mail'), '{$b->solernimailfootertext}', PARAM_RAW, '50', '3'));

    $page->add(new admin_setting_configtextarea('local_orangemail/footerinscriptiontext',
            new lang_string('footerinscriptiontext', 'local_orange_mail'),
            new lang_string('footerinscriptiontext_desc', 'local_orange_mail'), '{$b->solernimailfooterinscriptiontext}',
            PARAM_RAW, '50', '3'));


    $ADMIN->add('localplugins', new admin_category('orange_mail', new lang_string('pluginname', 'local_orange_mail')));

    // Add settings page to navigation tree.
    $ADMIN->add('orange_mail', $page);

    $temp = new admin_externalpage('orange_mail_generate',
            new lang_string('mailgenerate', 'local_orange_mail'), $CFG->wwwroot . '/local/orange_mail/generate.php',
            'local/orange_mail:config');
    $ADMIN->add('orange_mail', $temp);
    $temp = new admin_externalpage('orange_mailtest',
            new lang_string('mailtest', 'local_orange_mail'), $CFG->wwwroot . '/local/orange_mail/test.php',
            'local/orange_mail:config');
    $ADMIN->add('orange_mail', $temp);
}