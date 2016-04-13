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
 * @package    local
 * @subpackage orange_mail
 * @copyright  Orange 2015
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// Plugin strings.
$string['pluginname'] = 'Solerni Mail';
$string['orange_mail:config'] = 'Configure Orange mail plugin';
$string['mailsetting'] = 'Settings';
$string['mailgenerate'] = 'Generate templates e-mail';
$string['mailgeneratestatus'] = 'E-mail\'s templates generation completed. You need to purge caches to take into account these new templates.';
$string['mailtest'] = 'Send test e-mails';
$string['mailteststatus'] = 'Tests e-mails send.';
$string['pluginname_desc'] = 'This plugin allow to configure mails sent by Solerni.';
$string['orange_mail'] = 'Orange mail';
$string['css'] = 'Mail CSS';
$string['css_desc'] = 'CSS content included in all mails. It should start by <STYLE> and end by </STYLE>';
$string['header'] = 'Mail Header';
$string['header_desc'] = 'Mail Header';
$string['contentstart'] = 'Content start';
$string['contentstart_desc'] = 'HTML code before content';
$string['contentend'] = 'Content end';
$string['contentend_desc'] = 'HTML code after content';
$string['headertext'] = 'Mail Header';
$string['headertext_desc'] = 'Mail Header';
$string['footer'] = 'Mail Footer';
$string['footer_desc'] = 'Mail Footer';
$string['footertext'] = 'Mail Footer';
$string['footertext_desc'] = 'Mail Footer';
$string['footerinscription'] = 'Mail Footer Inscription';
$string['footerinscription_desc'] = 'Mail Footer Inscription';
$string['footerinscriptiontext'] = 'Mail Footer Inscription';
$string['footerinscriptiontext_desc'] = 'Mail Footer Inscription';
$string['signature'] = 'Mail Signature';
$string['signature_desc'] = 'Mail Signature';
$string['signaturetext'] = 'Mail Signature';
$string['signaturetext_desc'] = 'Mail Signature';
$string['followus'] = '"Follow us" section';
$string['followus_desc'] = '"Follow us" section';
$string['followustext'] = '"Follow us" section';
$string['followustext_desc'] = '"Follow us" section';
$string['contactemail'] = 'Solerni contact e-mail';
$string['contactemail_desc'] = 'Solerni contact e-mail. This e-mail is used for mails sent by the platform but also by the contact form.';
$string['supportemail'] = 'Solerni support e-mail';
$string['supportemail_desc'] = 'Solerni support e-mail. This e-mail is used for mails sent by the platform but also by the contact form.';
$string['marketemail'] = 'Solerni marketing e-mail';
$string['marketemail_desc'] = 'Solerni markerting e-mail. This e-mail is used for mails sent by the platform but also by the contact form.';
$string['partneremail'] = 'Solerni partnership e-mail';
$string['partneremail_desc'] = 'Solerni partnership e-mail. This e-mail is used for mails sent by the platform but also by the contact form.';
$string['noreplyemail'] = 'E-mail No Reply Solerni';
$string['noreplyemail_desc'] = 'E-mail No Reply Solerni. This e-mail is used for mails sent by the platform but also by the contact form.';
$string['heading_general'] = 'General';
$string['heading_htmltemplate'] = 'Mail HTML template';
$string['heading_texttemplate'] = 'Mail text template';
$string['helptext'] = 'You can use these variables on the templates. These variables will be replaced by the content during the template generation.'
        . '<ul>'
        . '<li>{$b->sitename} : site name</li>'
        . '<li>{$b->siteurl} : site url</li>'
        . '<li>{$b->catalogurl} : catalog url</li>'
        . '<li>{$b->profilurl} : profil page url</li>'
        . '<li>{$b->facebook} : Solerni Facebook url</li>'
        . '<li>{$b->twitter} : Solerni Twitter url</li>'
        . '<li>{$b->blog} : Solerni blog url</li>'
        . '<li>{$b->linkedin} : Solerni Linkedin url</li>'
        . '<li>{$b->googleplus} : Solerni Googleplus url</li>'
        . '<li>{$b->dailymotion} : Solerny Dailymotion page</li>'
        . '<li>{$b->servicename} : Solerni for Home or Solerni - thematic name</li>'
        . '</ul>'
        . '<br />The variables {$a->xxx} are treated by Moodle during the mail sent process. These variables depends on each mail.';
$string['helphtml'] = 'You can use these variables on the templates. These variables will be replaced by the content during the template generation..'
        . '<ul>'
        . '<li>{$b->imageurl} : directory for images used in e-mails</li>'
        . '<li>{$b->sitename} : site name</li>'
        . '<li>{$b->siteurl} : site url</li>'
        . '<li>{$b->catalogurl} : catalog url</li>'
        . '<li>{$b->profilurl} : profil page url</li>'
        . '<li>{$b->facebook} : Solerni Facebook url</li>'
        . '<li>{$b->twitter} : Solerni Twitter url</li>'
        . '<li>{$b->blog} : Solerni blog url</li>'
        . '<li>{$b->linkedin} : Solerni Linkedin url</li>'
        . '<li>{$b->googleplus} : Solerni Googleplus url</li>'
        . '<li>{$b->dailymotion} : Solerny Dailymotion page</li>'
        . '<li>{$b->servicename} : Solerni for Home or Solerni - thematic name</li>'
        . '</ul>'
        . '<br />The variables {$a->xxx} are treated by Moodle during the mail sent process. These variables depends on each mail.';

// Mail template strings.
$string['solernimailsignature'] = '<span class="txt18BNoir">The {$b->servicename} Team</span><br />'
        . 'Learning is always better together<br/> <a href="{$b->siteurl}" class="lientxt18orange">{$b->siteurl}</a>';
$string['solernimailsignaturetext'] = 'The {$b->servicename} Team
Learning is always better together {$b->siteurl}';
$string['solernimailfootertext'] = 'This is an automatic message, please do not reply to it directly. If you have any questions, write to us at {$b->contactemail}.
To ensure that you never miss our e-mail, add this address {$b->noreplyemail} to your address book.';
$string['solernimailfooterhtml'] = '<p>This is an automatic message, please do not reply to it directly.<br />
    If you have any questions, write to us at <a href="mailto:{$b->contactemail}" class="lientxt14orange">{$b->contactemail}</a>.<br />
To ensure that you never miss our e-mail, add this address <a href="mailto:{$b->noreplyemail}" class="lientxt14orange">{$b->noreplyemail}</a> to your address book.</p>';
$string['solernimailfooterinscriptiontext'] = 'You have received this e-mail because your e-mail address was used to sign up to our site {$a->sitename}. This is an automatic message, please do not reply to it directly. If you have any questions, write to us at {$b->contactemail}.
To ensure that you never miss our e-mail, add this address {$b->noreplyemail} to your address book.';
$string['solernimailfooterinscriptionhtml'] = '<p>You have received this e-mail because your e-mail address was used to sign up to our site <a href="{$b->siteurl}" class="lientxt14orange">{$b->sitename}</a>.</p>
    <p>This is an automatic message, please do not reply to it directly.<br />
    If you have any questions, write to us at <a href="mailto:{$b->contactemail}" class="lientxt14orange">{$b->contactemail}</a>.<br />
To ensure that you never miss our e-mail, add this address <a href="mailto:{$b->noreplyemail}" class="lientxt14orange">{$b->noreplyemail}</a> to your address book.</p>';
$string['solernimailfollowus'] = 'Follow us';

// Original Moodle email strings.
$string['newpasswordtext'] = '<p>Hello <span class="txt18BNoir">{$a->firstname} {$a->lastname}</span>,</p>

<p>Your account password at \'{$a->sitename}\' has been reset
and you have been issued with a new temporary password.</p>

Your current login information is now:<br />
   username: <span class="txt18BNoir">{$a->username}</span><br />
   password: {$a->newpassword}<br />

<p>Please go to this page to change your password:
   <a href="{$a->link}" class="lientxt18orange">{$a->link}</a></p>

<p>In most mail programs, this should appear as a blue link
which you can just click on.  If that doesn\'t work,
then cut and paste the address into the address
line at the top of your web browser window.</p>';
$string['contentuseraccountemail'] = '<p>Hello <span class="txt18BNoir">{$a->fullname}</span>,<br /><br />
Welcome to <strong>{$b->servicename}</strong>, your new collaborative learning platform.<p>
<p>Your login details to access your {$b->servicename} account are:</p>
<ul>
    <li>E-mail address: <a href="mailto:{$a->email}" class="lientxt18orange">{$a->email}</a></li>
    <li>Password : only know to you</li>
</ul>
<p>Your login details can be used to connect to all {$b->servicename} collaborative learning sites.</p>
<p>You can therefore connect to any theme, and browse from one theme to another.</p>
<p>See you very soon on {$b->servicename}.</p>';
$string['contentuseraccountemailprivate'] = '<p>Hello <span class="txt18BNoir">{$a->fullname}</span>,<br /><br />
Welcome to <strong>{$b->servicename}</strong>, your new collaborative learning platform.<p>
<p>Your login details to access your {$b->servicename} account are:</p>
<ul>
    <li>E-mail address: <a href="mailto:{$a->email}" class="lientxt18orange">{$a->email}</a></li>
    <li>Password : only know to you</li>
</ul>
<p>See you very soon on {$b->servicename}.</p>';
$string['emailresetconfirmation'] = '<p>Hello <span class="txt18BNoir">{$a->firstname} {$a->lastname}</span>,</p>

<p>You have requested a password reset. If you did not request this reset, please ignore this message.</p>

Your username is : <span class="txt18BNoir">{$a->username}</span>
<br />
<p><a href="{$a->link}" class="lientxt18orange">Click on the link to reset your password</a>';
$string['emailconfirmation'] = '<p>Hello <span class="txt18BNoir">{$a->firstname}</span>,</p>

<p>We have received a registration request from you using your e-mail address.</p>
<p>To confirm this request, please click the following link:<br />
<a href="{$a->link}" class="lientxt18orange">confirm my registration</a></p>
<p>If the button does not work, copy and paste the following link to your browser\'s address bar :  <a href="{$a->link}" class="lientxt18orange">{$a->link}</a></p>';

$string['welcometocoursetext'] = '<p>Hello,</p>
<p>We would like to confirm your registration for Mooc <span class="txt18BNoir">{$a->coursename}</span>.</p>

<p>We hope you really enjoy this new training course
 on {$b->sitename}, your collaborative French MOOC platform.</p>';

$string['informationmessagetext'] = '<p>Hello <span class="txt18BNoir">{$a->fullname}</span>,</p>

<p>Thanks for your interest for the course <span class="txt18BNoir">{$a->coursename}</span>. You will be informed when a new session will start.</p>';

$string['defaultemailmsg'] = '<p>Hello <span class="txt18BNoir">{$a->fullname}</span>,
          <p>Your account has been deleted from Solerni.<br />Thank you for using Solerni!</p>';

$string['newusernewpasswordtext'] = '<p>Dear <span class="txt18BNoir">{$a->firstname}</span>,</p>
<p>Your user account has been created on {$a->sitename}, your new collaborative company learning platform, on which you have been invited to follow one or more online courses.</p>
<p>Your login details :</p>
<ul>
   <li>user name : {$a->username}</li>
   <li>password : {$a->newpassword}</li>
</ul>
<p><strong>Please note :</strong> this is a temporary password, tou must change it when you connect for the first time.</p>
<p>Click on the following link, to connect to {$a->sitename} now :<br />
   <a href="{$a->link}" class="lientxt18orange">{$a->link}</a><br />
and personalise your password.</p>
<p>if the link does not work, copy and paste the URL to your browser\'s address bar.</p>
<p>You have received this e-mail because your company wanted to automatically register you on our platform.</p>
<p>See you soon on {$a->sitename}</p>';

$string['badgemessagebody'] = '<p>Hello,</p>
<p>You have been awarded the badge "%badgename%"!</p>
<p>More information about this badge can be found from {$a} page.</p>';
