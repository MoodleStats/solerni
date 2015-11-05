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

/* $show_instructions is a local variable that stands if admin checked
the ability to display instructions on the login page. We removed it but we could
use it if necessary, hence this comment */

$autocomplete =  (!empty($CFG->loginpasswordautocomplete)) ? 'autocomplete="off"' : '';
$strusername = (empty($CFG->authloginviaemail)) ? get_string('username') : get_string('usernameemail') ;
?>
<div class="row login-header">
    <div class="page-header text-center">
        <?php require('login_header.php'); ?>
    </div>
</div>
<?php if (!$CFG->solerni_isprivate) : ?>
<!-- authentication plugin row -->
<div class="row login-oauth2">
    <div class="col-md-6 col-md-offset-3">
        <?php
        require_once($CFG->dirroot . '/auth/googleoauth2/lib.php');
        auth_googleoauth2_display_buttons();
        ?>
    </div>
</div>
<?php endif; ?>

<div class="loginbox row">
  <div class="loginpanel">
<?php
  if (($CFG->registerauth == 'email') || !empty($CFG->registerauth)) { ?>
      <div class="skiplinks">
          <a class="skip" href="signup.php">
            <?php print_string("tocreatenewaccount"); ?>
          </a>
      </div>
<?php
  } ?>
    <h2><?php print_string("login") ?></h2>
      <div class="subcontent loginsub">
        <?php
          if (!empty($errormsg)) {
              echo html_writer::start_tag('div', array('class' => 'loginerrors'));
              echo html_writer::link('#', $errormsg, array('id' => 'loginerrormessage', 'class' => 'accesshide'));
              echo $OUTPUT->error_text($errormsg);
              echo html_writer::end_tag('div');
          }
        ?>
        <form action="<?php echo $CFG->httpswwwroot; ?>/login/index.php" method="post" id="login" <?php echo $autocomplete; ?> >
          <div class="loginform">
            <div class="form-label"><label for="username"><?php echo($strusername) ?></label></div>
            <div class="form-input">
              <input type="text" name="username" id="username" size="15" value="<?php p($frm->username) ?>" />
            </div>
            <div class="clearer"><!-- --></div>
            <div class="form-label"><label for="password"><?php print_string("password") ?></label></div>
            <div class="form-input">
              <input type="password" name="password" id="password" size="15" value="" <?php echo $autocomplete; ?> />
            </div>
          </div>
            <div class="clearer"><!-- --></div>
              <?php if (isset($CFG->rememberusername) and $CFG->rememberusername == 2) { ?>
              <div class="rememberpass">
                  <input type="checkbox" name="rememberusername" id="rememberusername" value="1" <?php if ($frm->username) {echo 'checked="checked"';} ?> />
                  <label for="rememberusername"><?php print_string('rememberusername', 'admin') ?></label>
              </div>
              <?php } ?>
          <div class="clearer"><!-- --></div>
          <input type="submit" id="loginbtn" value="<?php print_string("login") ?>" />
          <div class="forgetpass"><a href="forgot_password.php"><?php print_string("forgotten") ?></a></div>
        </form>
        <div class="desc">
            <?php
                echo get_string("cookiesenabled");
                echo $OUTPUT->help_icon('cookiesenabled');
            ?>
        </div>
      </div>

<?php if ($CFG->guestloginbutton and !isguestuser()) {  ?>
      <div class="subcontent guestsub">
        <div class="desc">
          <?php print_string("someallowguest") ?>
        </div>
        <form action="index.php" method="post" id="guestlogin">
          <div class="guestform">
            <input type="hidden" name="username" value="guest" />
            <input type="hidden" name="password" value="guest" />
            <input type="submit" value="<?php print_string("loginguest") ?>" />
          </div>
        </form>
      </div>
<?php } ?>
     </div>
<?php if ($show_instructions) { ?>
    <div class="signuppanel">
      <h2><?php print_string("firsttime") ?></h2>
      <div class="subcontent">
<?php     if (is_enabled_auth('none')) { // instructions override the rest for security reasons
              print_string("loginstepsnone");
          } else if ($CFG->registerauth == 'email') {
              if (!empty($CFG->auth_instructions)) {
                  echo format_text($CFG->auth_instructions);
              } else {
                  print_string("loginsteps", "", "signup.php");
              } ?>
                 <div class="signupform">
                   <form action="signup.php" method="get" id="signup">
                   <div><input type="submit" value="<?php print_string("startsignup") ?>" /></div>
                   </form>
                 </div>
<?php     } else if (!empty($CFG->registerauth)) {
              echo format_text($CFG->auth_instructions); ?>
              <div class="signupform">
                <form action="signup.php" method="get" id="signup">
                <div><input type="submit" value="<?php print_string("startsignup") ?>" /></div>
                </form>
              </div>
<?php     } else {
              echo format_text($CFG->auth_instructions);
          } ?>
      </div>
    </div>
<?php } ?>
<?php if (!empty($potentialidps)) { ?>
    <div class="subcontent potentialidps">
        <h6><?php print_string('potentialidps', 'auth'); ?></h6>
        <div class="potentialidplist">
<?php foreach ($potentialidps as $idp) {
    echo  '<div class="potentialidp"><a href="' . $idp['url']->out() . '" title="' . $idp['name'] . '">' . $OUTPUT->render($idp['icon'], $idp['name']) . $idp['name'] . '</a></div>';
} ?>
        </div>
    </div>
<?php } ?>
</div>

