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

use theme_halloween\tools\theme_utilities;
require_once($CFG->dirroot . '/filter/multilang/filter.php');
$filtermultilang = new filter_multilang($PAGE->context, array());

$autocomplete =  (!$CFG->loginpasswordautocomplete) ? 'autocomplete="off"' : '';
?>
<div class="row login-header">
    <div class="page-header text-center">
        <?php require($CFG->partialsdir . '/login/login_header.php'); ?>
    </div>
</div>
<?php if (!$CFG->solerni_isprivate) :
    require_once($CFG->dirroot . '/auth/googleoauth2/lib.php');
    $oauthbuttons = auth_googleoauth2_render_buttons();
    if (0 !== $oauthbuttons['providers']) : ?>
<!-- authentication plugin row -->
<div class="row login-oauth2">
    <div class="col-md-6 col-md-offset-3">
        <?php echo $oauthbuttons['html']; ?>
    </div>
    <div class="col-md-6 col-md-offset-3">
        <div class="login-line">
            <span class="line-inner">
                <?php echo get_string('or', 'theme_halloween'); ?>
            </span>
        </div>
    </div>
</div>
<?php endif; endif; ?>
<!-- login form -->
<div class="row login-box">
    <div class="loginpanel col-md-6 col-md-offset-3">
        <?php if ($errormsg) : ?>
            <!-- alert box -->
            <div class="alert alert-warning loginerrors" role="alert">
                <p id="loginerrormessage" class="alert-link">
                    <?php echo $OUTPUT->error_text($errormsg); ?>
                </p>
            </div>
        <?php endif; ?>
        <form action="<?php echo $CFG->httpswwwroot; ?>/login/index.php"
              method="POST" id="login" <?php echo $autocomplete; ?> >
            <div class="form-group">
                <?php $usernamelabel = (theme_utilities::is_theme_settings_exists_and_nonempty('loginusername')) ?
                        $filtermultilang->filter($PAGE->theme->settings->loginusername) :
                        get_string('username', 'theme_halloween'); ?>
                <label for="username">
                    <?php echo $usernamelabel; ?>
                </label>
                <input class="form-control" type="text" name="username" id="username"
                       value="<?php p($frm->username) ?>" />
              <?php if (theme_utilities::is_theme_settings_exists_and_nonempty('loginusernamesub')) : ?>
                    <p class="help-block small"><?php echo $filtermultilang->filter($PAGE->theme->settings->loginusernamesub); ?></p>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <?php $passwordlabel = (theme_utilities::is_theme_settings_exists_and_nonempty('loginpassword')) ?
                        $filtermultilang->filter($PAGE->theme->settings->loginpassword) :
                        get_string('password'); ?>
                <label for="password">
                    <?php echo $passwordlabel; ?>
                </label>
                <div class="password-wrapper">
                    <input class="form-control" type="password" name="password" id="password" size="15"
                           value="" <?php echo $autocomplete; ?> />
                    <a class="btn btn-warning login-forgot" href="forgot_password.php">
                        <?php print_string('forgotten', 'theme_halloween') ?>
                    </a>
                </div>
                <?php if (theme_utilities::is_theme_settings_exists_and_nonempty('loginpasswordsub')) : ?>
                    <p class="help-block small"><?php echo $filtermultilang->filter($PAGE->theme->settings->loginpasswordsub); ?></p>
                <?php endif; ?>
            </div>
            <?php if ($CFG->rememberusername and $CFG->rememberusername == 2) : ?>
                <div class="form-group text-right">
                    <input class="o-checkbox" type="checkbox" name="rememberusername" id="rememberusername"
                           value="1" <?php if ($frm->username) { echo 'checked="checked"'; } ?> />
                    <label for="rememberusername">
                        <?php print_string('rememberusername', 'theme_halloween') ?>
                    </label>
                </div>
            <?php endif; ?>
            <div class="form-group">
                <input type="submit" class="btn btn-primary btn-block" id="loginbtn" value="<?php print_string("login") ?>" />
            </div>
        </form>
    </div>
</div>
