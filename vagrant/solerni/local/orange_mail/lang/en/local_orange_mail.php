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
$string['mailgeneratestatus'] = 'Email\'s templates generation completed.';
$string['mailtest'] = 'Send test emails';
$string['mailteststatus'] = 'Tests emails send.';
$string['pluginname_desc'] = 'This plugin allow to configure mails sent by Solerni.';
$string['orange_mail'] = 'Orange mail';
$string['css'] = 'Mail CSS';
$string['css_desc'] = 'CSS content included in all mails. It should start by <STYLE> and end by </STYLE>';
$string['header'] = 'Mail Header';
$string['header_desc'] = 'Mail Header';
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
$string['contactemail'] = 'Email de contact Solerni';
$string['contactemail_desc'] = 'Email de contact Solerni. This e-mail is used for mails sent by the platform but also by the contact form.';
$string['noreplyemail'] = 'Email No Reply Solerni';
$string['noreplyemail_desc'] = 'Email No Reply Solerni. This e-mail is used for mails sent by the platform but also by the contact form.';
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
        . '</ul>'
        . '<br>The variables {$a->xxx} are treated by Moodle during the mail sent process. These variables depends on each mail.';
$string['helphtml'] = 'You can use these variables on the templates. These variables will be replaced by the content during the template generation..'
        . '<ul>'
        . '<li>{$b->imageurl} : directory for images used in emails</li>'
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
        . '</ul>'
        . '<br>The variables {$a->xxx} are treated by Moodle during the mail sent process. These variables depends on each mail.';

// Mail template strings.
$string['solernimailsignature'] = 'The <a href="{$b->siteurl}" class="lientxt18orange">{$b->sitename}</a> Team<br />'
        . 'Learning is always better together <a href="{$b->siteurl}" class="lientxt18orange">solerni.com</a>';
$string['solernimailsignaturetext'] = 'The {$b->sitename} Team
Learning is always better together solerni.com';
$string['solernimailfootertext'] = 'This is an automatic message, please do not reply to it directly. If you have any questions, write to us at {$b->contactemail}.
To ensure that you never miss our email, add this address {$b->noreplyemail} to your address book.';
$string['solernimailfooterhtml'] = '<p>This is an automatic message, please do not reply to it directly.<br />
    If you have any questions, write to us at <a href="mailto:{$b->contactemail}" class="lientxt14orange">{$b->contactemail}</a>.<br />
To ensure that you never miss our email, add this address <a href="mailto:{$b->npreplyemail}" class="lientxt14orange">{$b->noreplyemail}</a> to your address book.</p>';
$string['solernimailfooterinscriptiontext'] = 'You have received this email because your email address was used to sign up to our site {$a->sitename}. This is an automatic message, please do not reply to it directly. If you have any questions, write to us at {$b->contactemail}.
To ensure that you never miss our email, add this address {$b->noreplyemail} to your address book.';
$string['solernimailfooterinscriptionhtml'] = '<p>You have received this email because your email address was used to sign up to our site <a href="{$b->siteurl}" class="lientxt14orange">{$b->sitename}</a>.</p>
    <p>This is an automatic message, please do not reply to it directly.<br />
    If you have any questions, write to us at <a href="mailto:{$b->contactemail}" class="lientxt14orange">{$b->contactemail}</a>.<br />
To ensure that you never miss our email, add this address <a href="mailto:{$b->npreplyemail}" class="lientxt14orange">{$b->noreplyemail}</a> to your address book.</p>';
$string['solernimailfollowus'] = 'Follow us';

// Original Moodle email strings.
$string['newpasswordtext'] = '<tr>
    <td valign="top"><table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td class="txt18Noir"><p>Hello <span class="txt18BNoir">{$a->firstname} {$a->lastname}</span>,</p>

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
line at the top of your web browser window.</p>
</td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td height="30">&nbsp;</td>
  </tr>';
$string['contentuseraccountemail'] = '<tr>
    <td valign="top"><table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td class="txt18Noir"><p>Hello <span class="txt18BNoir">{$a->fullname}</span>,<br/><br/>
Thank you for registering to <strong>{$a->sitename}</strong>.<p>
<p>Here is a reminder of your account login details :</p>
<ul>
    <li>E-mail : <a href="{$a->email}" class="lientxt18orange">{$a->email}</a></li>
    <li>Password : you are the only one to know</li>
</ul>
<p>You can now access your account by <a href="{$a->profileurl}" class="lientxt18orange">here</a>.</p>
<p>See you very soon on {$a->sitename}, your new collaborative French MOOC platform.</p>
</td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td height="30">&nbsp;</td>
  </tr>';
$string['contentwelcomeemail'] = '<tr>
    <td valign="top"><table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td class="txt18Noir"><p>Welcome <span class="txt18BNoir">{$a->fullname}</span>,</p>
<p>We are delighted to welcome you to {$a->sitename}, your new collaborative French MOOC platform.</p>
<p>More than just gaining knowledge, we hope this platform will help you to hone your skills. Indeed, we see learning as more than just something to be done alone with a teacher or a trainer, but also together, as a network. You hone your skills by following a pathway that promotes interaction and activities. You will be supported by your peers at all times, but also by teachers whose aim is to help you learn by encouraging information sharing and mutual enrichment. </p>
<p><strong>Let\'s get started, sign up for a MOOC</strong></p>
<p>Our platform has just launched and new, varied MOOCs will be added over the weeks. </p>
<p>You can view <a href="{$b->catalogurl}" class="lientxt18orange">our catalogue</a> and sign up for one of the MOOCs that is already available. Our platform is open and free, so there is no limit on what you can sign up for!</p>
<p><strong>Stay in contact, stay connected</strong> </p>
<p>To keep up with new developments and events on Solerni, join us on <a href="{$b->facebook}" target="_new" class="lientxt18orange">Facebook</a> and <a href="{$b->twitter}" target="_new" class="lientxt18orange">Twitter</a>, and don\'t forget to visit our <a href="{$b->blog}" target="_new" class="lientxt18orange">Blog</a>, which will keep you informed of the latest news about these new social and collaborative learning methods.</p>
<p><strong>For effective communication, complete your profile</strong></p>
<p>And to ensure you are able to interact with other learners and teachers, don\'t forget to complete and configure your <a href="{$b->profileurl}" class="lientxt18orange">profile</a>.</p>
<p>That\'s it! You\'re now ready to start your collaborative MOOC adventure with us. We hope to see you very soon on {$a->sitename} and hope you enjoy new and rewarding experiences with us!</p>
</td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td height="30">&nbsp;</td>
  </tr>';
$string['emailresetconfirmationhtml'] = '<tr>
    <td valign="top"><table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td class="txt18Noir"><p>Hello <span class="txt18BNoir">{$a->firstname} {$a->lastname}</span>,</p>

<p>You have requested a password reset. If you did not request this reset, please ignore this message.</p>

Your username is : <span class="txt18BNoir">{$a->username}</span>
<br />
<p><a href="{$a->link}" class="lientxt18orange">Click on the link to reset your password</a>
</td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td height="30">&nbsp;</td>
  </tr>';
$string['emailresetconfirmation'] = 'Hello <span class="txt18BNoir">{$a->firstname}</span>,

You have requested a password reset. If you did not request this reset, please ignore this message.

Your username is : <span class="txt18BNoir">{$a->username}</span>.

Click on the link to reset your password :
{$a->link}

If the link does not work, copy and paste the URL to your browser\'s address bar.
';
$string['emailconfirmation'] = '<tr>
    <td valign="top"><table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td class="txt18Noir"><p>Hello <span class="txt18BNoir">{$a->firstname}</span>,</p>

<p>We have received a registration request from you using your email address.</p>
<p>To confirm this request, please click the following link:<br>
<a href="{$a->link}" class="lientxt18orange">confirm my registration</a></p>
<p>If the button does not work, copy and paste the following link to your browser\'s address bar :  <a href="{$a->link}" class="lientxt18orange">{$a->link}</a></p>
</td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td height="30">&nbsp;</td>
  </tr>';

$string['welcometocoursetext'] = '<tr>
    <td valign="top"><table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td class="txt18Noir"><p>Hello,</p>
<p>We would like to confirm your registration for Mooc <span class="txt18BNoir">{$a->coursename}</span>.</p>

<p>We hope you really enjoy this new training course
 on {$b->sitename}, your collaborative French MOOC platform.</p>
</td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td height="30">&nbsp;</td>
  </tr>';

$string['informationmessagetext'] = '<tr>
    <td valign="top"><table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td class="txt18Noir"><p>Hello <span class="txt18BNoir">{$a->fullname}</span>,</p>

<p>Thanks for your interest for the course <span class="txt18BNoir">{$a->coursename}</span>. You will be informed when a new session will start.</p>
</td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td height="30">&nbsp;</td>
  </tr>';

$string['defaultemailmsg'] = '<tr>
    <td valign="top"><table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td class="txt18Noir"><p>Hello <span class="txt18BNoir">{$a->fullname}</span>,
          <p>Your account has been deleted from Solerni.<br />Thank you for using Solerni!</p>
</td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td height="30">&nbsp;</td>
  </tr>';
