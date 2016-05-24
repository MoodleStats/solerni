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
use theme_halloween\tools\log_and_session_utilities;

require_once($CFG->dirroot . '/filter/multilang/filter.php');
$filtermultilang = new filter_multilang($PAGE->context, array());
$autocomplete =  (!$CFG->loginpasswordautocomplete) ? 'autocomplete="off"' : '';

// Define form action url.
// Use local database if the platform is not using MNET or if we override it with locallog query.
// otherwise, log with MNET upon the "home" platform.
$formaction = log_and_session_utilities::define_login_form_action($locallog); ?>

<?php if (!$CFG->solerni_isprivate) :
    require_once($CFG->dirroot . '/auth/googleoauth2/lib.php');
    $oauthbuttons = auth_googleoauth2_render_buttons();
    if (isset($oauthbuttons['providers']) && 0 !== $oauthbuttons['providers']) : ?>
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
    <?php endif;
endif; ?>
<!-- login form -->
<div class="row login-box">
    <div class="loginpanel col-xs-12 col-md-8 col-md-offset-2">
        <?php if ($errormsg) : ?>
        <div class="alert alert-danger">
            <?php echo $errormsg; ?>
        </div>
        <?php endif; ?>
        <form action="<?php echo $formaction['host']; ?>/login/index.php"
              method="POST" id="login" <?php echo $autocomplete;
              if ($errormsg) : ?> class="has-error"<?php endif; ?> >
            <div class="inner-panel">
                <?php if ( $formaction['isthematic']) :?>
                    <input type="hidden" name="mnetorigin" value="<?php echo $CFG->wwwroot; ?>">
                <?php endif; ?>
                <div class="form-group">
                    <?php $usernamelabel = (theme_utilities::is_theme_settings_exists_and_nonempty('loginusername')) ?
                            $filtermultilang->filter($PAGE->theme->settings->loginusername) :
                            get_string('username', 'theme_halloween'); ?>
                    <label for="username">
                        <?php echo $usernamelabel; ?>
                    </label>
                    <input class="form-control" type="text" name="username" id="username"
                           value="<?php p($frm->username) ?>" required/>
                    <?php if (!$errormsg && theme_utilities::is_theme_settings_exists_and_nonempty('loginusernamesub')) {
                        $emailhelper = $filtermultilang->filter($PAGE->theme->settings->loginusernamesub);
                    } elseif ($errormsg) {
                        $emailhelper = get_string('invalidemail', 'theme_halloween');
                    } ?>
                    <?php if (isset($emailhelper)) : ?>
                        <p class="help-block small"><?php echo $emailhelper; ?></p>
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
                               value="" <?php echo $autocomplete; ?> required />
                        <a class="forgot-password-link pull-right form-helper-link" href="<?php echo $formaction['host'] ?>/login/forgot_password.php">
                            <?php print_string('forgotten', 'theme_halloween') ?>
                        </a>
                    </div>
                    <?php if (!$errormsg && theme_utilities::is_theme_settings_exists_and_nonempty('loginpasswordsub')) {
                        $passwordwderror = $filtermultilang->filter($PAGE->theme->settings->loginpasswordsub);
                    } elseif ($errormsg) {
                        $passwordwderror =get_string('invalidpassword', 'theme_halloween');
                    } ?>
                    <?php if (isset($passwordwderror)) : ?>
                        <p class="help-block small"><?php echo $passwordwderror; ?></p>
                    <?php endif; ?>
                </div>
                <?php if ($CFG->rememberusername and $CFG->rememberusername == 2) : ?>
                    <div class="form-group">
                        <input class="o-checkbox" type="checkbox" name="rememberusername" id="rememberusername"
                               value="1" <?php if ($frm->username) { echo 'checked="checked"'; } ?> />
                        <label for="rememberusername">
                            <?php print_string('rememberusername', 'theme_halloween') ?>
                        </label>
                    </div>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-engage btn-block" id="id_submitbutton" value="<?php print_string("login") ?>" />
            </div>
        </form>
    </div>
</div>
