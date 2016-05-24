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
$string['mailgenerate'] = 'Generate templates email';
$string['mailgeneratestatus'] = 'Email\'s templates generation completed. You need to purge caches to take into account these new templates.';
$string['mailtest'] = 'Send test emails';
$string['mailteststatus'] = 'Tests emails send.';
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
$string['contactemail'] = 'Solerni contact email';
$string['contactemail_desc'] = 'Solerni contact email. This email is used for mails sent by the platform but also by the contact form.';
$string['supportemail'] = 'Solerni support email';
$string['supportemail_desc'] = 'Solerni support email. This email is used for mails sent by the platform but also by the contact form.';
$string['marketemail'] = 'Solerni marketing email';
$string['marketemail_desc'] = 'Solerni markerting email. This email is used for mails sent by the platform but also by the contact form.';
$string['partneremail'] = 'Solerni partnership email';
$string['partneremail_desc'] = 'Solerni partnership email. This email is used for mails sent by the platform but also by the contact form.';
$string['noreplyemail'] = 'Email No Reply Solerni';
$string['noreplyemail_desc'] = 'Email No Reply Solerni. This email is used for mails sent by the platform but also by the contact form.';
$string['heading_general'] = 'General';
$string['heading_htmltemplate'] = 'Mail HTML template';
$string['heading_texttemplate'] = 'Mail text template';
$string['helptext'] = 'You can use these variables on the templates. These variables will be replaced by the content during the template generation.'
        . '<ul>'
        . '<li>{$b->sitename} : site name</li>'
        . '<li>{$b->siteurl} : site url</li>'
        . '<li>{$b->customer} : customer name</li>'
        . '<li>{$b->thematic} : thematic name</li>'
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
        . '<li>{$b->imageurl} : directory for images used in emails</li>'
        . '<li>{$b->sitename} : site name</li>'
        . '<li>{$b->siteurl} : site url</li>'
        . '<li>{$b->customer} : customer name</li>'
        . '<li>{$b->thematic} : thematic name</li>'
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
        . 'Learning is always better together<br/> <a href="{$b->siteurl}" class="lientxt18orange">{$b->sitename}</a>';
$string['solernimailsignaturetext'] = 'The {$b->servicename} Team
Learning is always better together {$b->sitename}';

$string['solernimailfootertext'] = 'This is an automatic message, please do not reply to it directly. If you have any questions, send us a message at {$b->contactemail}.
To make sure you receive our emails, please add the address {$b->noreplyemail} to your contacts.';
$string['solernimailfooterhtml'] = '<p>This is an automatic message, please do not reply to it directly.<br />
    If you have any questions, send us a messsage at <a href="mailto:{$b->contactemail}" class="lientxt14orange">{$b->contactemail}</a>.<br />
To make sure you receive our emails, please add the address <a href="mailto:{$b->noreplyemail}" class="lientxt14orange">{$b->noreplyemail}</a> to your contacts.</p>';
$string['solernimailfooterinscriptiontext'] = 'You have received this email because your email address was used to sign up to our website {$a->sitename}. If you dit not sign up to {$b->sitename}, simmply ignore this email and your account will be deleted automatically. This is an automatic message, please do not reply to it directly. If you have any questions, send us a message at {$b->contactemail}.
To make sure you receive our emails, please add the address {$b->noreplyemail} to your contacts.';
$string['solernimailfooterinscriptionhtml'] = '<p>You have received this email because your email address was used to sign up to our website <a href="{$b->siteurl}" class="lientxt14orange">{$b->sitename}</a>. If you dit not sign up to {$b->sitename}, simmply ignore this email and your account will be deleted automatically. </p>
    <p>This is an automatic message, please do not reply to it directly.<br />
    If you have any questions, send us a message at <a href="mailto:{$b->contactemail}" class="lientxt14orange">{$b->contactemail}</a>.<br />
To make sure you receive our emails, please add the address <a href="mailto:{$b->noreplyemail}" class="lientxt14orange">{$b->noreplyemail}</a> to your contacts.</p>';
$string['solernimailfooterinscriptionprivatetext'] = 'You have received this email because your company wanted to automatically register you on our platform.
    This is an automatic message, please do not reply to it directly.
    If you have any questions, send us a message at {$b->contactemail}.
    To ensure that you never miss our email, please add this address {$b->noreplyemail} to your address book.';
$string['solernimailfooterinscriptionprivatehtml'] = '<p>You have received this email because your company wanted to automatically register you on our platform.</p>
    <p>This is an automatic message, please do not reply to it directly.<br />
    If you have any questions, send us a message at <a href="mailto:{$b->contactemail}" class="lientxt14orange">{$b->contactemail}</a>.<br />
    To ensure that you never miss our email, please add this address <a href="mailto:{$b->noreplyemail}" class="lientxt14orange">{$b->noreplyemail}</a> to your contacts.</p>';
$string['solernimailfollowus'] = 'Follow us';

// Original Moodle email strings.
// Mail M1.
$string['newpasswordtext'] = '<p>Hello <span class="txt18BNoir">{$a->firstname} {$a->lastname}</span>,</p>
<p>Your account password at {$b->servicename} has been reset
and you have been issued with a new temporary password.</p>
<p>Your current login information is now:<br />
   username: <span class="txt18BNoir">{$a->username}</span><br />
   temporary password: {$a->newpassword}</p>
<p>Please click on the following link to personalize your password:
   <a href="{$a->link}" class="lientxt18orange">Peronnalize my password</a></p>
<p>If that doesn\'t work, cut and paste the link below into the address
line at the top of your web browser window: <a href="{$a->link}" class="lientxt18orange">{$a->link}</a></p>
<p>See you soon on {$b->servicename}.</p>';

// Mail M2 public.
$string['contentuseraccountemail'] = '<p>Hello <span class="txt18BNoir">{$a->fullname}</span>,<br /><br />
Welcome to <span class="txt18BNoir">{$b->servicename}</span>, your new collaborative learning platform.<p>
<p>Your login details to access your {$b->sitename} account are:<ul>
    <li>Email address: <a href="mailto:{$a->email}" class="lientxt18orange">{$a->email}</a></li>
    <li>Password: only known to you</li>
</ul></p>
<p>Your login details can be used to connect to all {$b->servicename} collaborative learning sites.</p>
<p>You can therefore connect to any theme, and browse from one theme to another.</p>
<p>See you soon on {$b->servicename}.</p>';
$string['contentuseraccountemailprivate'] = '<p>Hello <span class="txt18BNoir">{$a->fullname}</span>,<br /><br />
Welcome to <span class="txt18BNoir">{$b->sitename}</span>, your new collaborative learning platform.<p>
<p>Your login details to access your {$b->servicename} account are:<ul>
    <li>Email address: <a href="mailto:{$a->email}" class="lientxt18orange">{$a->email}</a></li>
    <li>Password: only known to you</li>
</ul></p>
<p>See you soon on {$b->servicename}.</p>';

// Mail M4 public.
$string['emailresetconfirmation'] = '<p>Hello <span class="txt18BNoir">{$a->firstname} {$a->lastname}</span>,</p>

<p>You have requested a password reset. If you did not request this reset, please ignore this message.</p>

<p>Your username is : <span class="txt18BNoir">{$a->username}</span></p>
<p>Please click on the link below to reset your password:<br />
<a href="{$a->link}" class="lientxt18orange">reset my password</a></p>
<p>If that doesn\'t work, cut and paste the link below into the address line at the top of your web browser window:<br />
<a href="{$a->link}" class="lientxt18orange">{$a->link}</a></p>
<p>See you soon on {$b->servicename}.</p>';

// Mail M5.
$string['emailconfirmation'] = '<p>Hello <span class="txt18BNoir">{$a->firstname}</span>,</p>
<p>We have received a registration request from you using your email address.</p>
<p>To confirm this request, please click the following link:<br />
<a href="{$a->link}" class="lientxt18orange">confirm my registration</a></p>
<p>If that doesn\'t work, cut and paste the link below into the address line at the top of your web browser window :<br/>
<a href="{$a->link}" class="lientxt18orange">{$a->link}</a></p>
<p>See you soon on {$b->servicename}.</p>';

// Mail M6.
$string['welcometocoursetext'] = '<p>Hello,</p>
<p>Thanks for signing up to the "<span class="txt18BNoir">{$a->coursename}</span>" MOOC.</p>
<p>We hope you have a great time on this new learning course
 on <span class="txt18BNoir">{$b->sitename}</span>, your collaborative learning platform.</p>';

// Mail M7.
$string['informationmessagetext'] = '<p>Hello <span class="txt18BNoir">{$a->fullname}</span>,</p>
<p>Thanks for signing up to alerts for the next <a href="{$a->learnmoreurl}" class="lientxt18orange">{$a->coursename}</a> MOOC session.</p>
<p>Your request has been received.</p>
<p>See you soon on {$b->servicename}.</p>';

// Mail M8.
$string['defaultemailmsg'] = '<p>Hello <span class="txt18BNoir">{$a->fullname}</span>,
<p>This email is to confirm that your <span class="txt18BNoir">{$b->sitename}</span> platform account has been deleted.</p>
<p>Thank you for using <span class="txt18BNoir">{$b->sitename}</span>!</p>';

// Mail M14 public.
$string['newusernewpasswordtext'] = '<p>Hello <span class="txt18BNoir">{$a->firstname}</span>,</p>
<p>Solerni, your collaborative learning platform, evolves and changes its internet address at the same time.</p>
<p><span class="txt18BNoir">How to access the new version of {$a->sitename}?</span></p>
<p>To access the new version and discover our lastest MOOCs, you must now go to {$a->sitename} and use the following login details:<br />
<ul>
   <li>user name : {$a->username}</li>
   <li>password : {$a->newpassword}</li>
</ul>
<p><span class="txt18BNoir">Please note :</span> this is a temporary password, you must change it when you connect for the first time.</p>
<p>Your new login details allow you to connect to all the thematic learning sites proposed by {$b->servicename}.</p>
<p>So you will be able to connect from any topic with your new login and navigate freely from one theme to another.</p>
<p><span class="txt18BNoir">What happens to the old solerni.org release?</span></p>
<p><a href="http://solerni.org" class="lientxt18orange">solerni.org</a> old version remains available with your usual password to consult your archived MOOCs.</p>
<p>Click on the following link, to connect to {$a->sitename} and personalize your password:<br />
   <a href="{$a->link}" class="lientxt18orange">personalize my password</a>
</p>
<p>if that doesn\'t work, cut and paste the link below into the address line at the top of your browser window:<br />
   <a href="{$a->link}" class="lientxt18orange">{$a->link}</a>
</p>
<p>See you soon on {$b->servicename}</p>';

// Mail M14 private.
$string['newusernewpasswordtext_private'] = '<p>Dear <span class="txt18BNoir">{$a->firstname}</span>,</p>
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
<p>You have received this email because your company wanted to automatically register you on our platform.</p>
<p>See you soon on {$b->servicename}</p>';

// Mail M16 badge.
$string['messagebody'] = '<p>Hello,</p>
<p>You have been awarded the badge "%badgename%".</p>
<p>To find all the details of your badge, please visit the "{$a}" page, accessible from your dashboard.</p>
<p>See you soon on {$b->servicename}</p>';

// Mail M17.
$string['emailupdatemessage'] = '<p>Hello <span class="txt18BNoir">{$a->fullname}</span>,</p>
<p>You have requested a change of your email address for your {$a->site} account.</p>
<p>To confirm this request, please click the following link:<br />
<a href="{$a->url}" class="lientxt18orange">confirm changing my email address</a>
</p>
<p>if that doesn\'t work, cut and paste the link below into the address line at the top of your browser window:<br />
   <a href="{$a->url}" class="lientxt18orange">{$a->url}</a>
</p>
';
