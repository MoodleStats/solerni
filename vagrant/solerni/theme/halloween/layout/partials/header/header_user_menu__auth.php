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

use local_orange_library\utilities\utilities_user;
use theme_halloween\tools\log_and_session_utilities;
$youvegotmail = utilities_user::user_have_new_mail($USER);
$formaction = log_and_session_utilities::define_login_form_action(); ?>

<div class="action-area is-logged">
    <a title="email" href="<?php echo $CFG->wwwroot ?>/local/mail/view.php?t=inbox" class="header-email-icon icon-halloween icon-halloween--email">
        email
        <?php if ($youvegotmail) : ?>
            <span class="email-notification"><?php echo $youvegotmail; ?></span>
        <?php endif; ?>
    </a>
    <div class="dropdown header-dropdown">
        <button class="btn btn-default" type="button" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
                <?php echo $USER->firstname . ' ' . $USER->lastname; ?>
                <span class="caret"></span>
        </button>
        <ul class="dropdown-menu list-unstyled list-link" aria-labelledby="dLabel">
            <li>
                <a href="<?php echo $CFG->wwwroot ?>/my/index.php">
                    <?php echo get_string('user_menu_dashboard', 'theme_halloween'); ?>
                </a>
            </li>
            <li>
                <a href="<?php echo $CFG->wwwroot ?>/user/profile.php">
                    <?php echo get_string('user_menu_profile', 'theme_halloween'); ?>
                </a>
            </li>
            <li>
                <a href="<?php echo $formaction['host'] ?>/user/preferences.php">
                    <?php echo get_string('user_menu_preferences', 'theme_halloween'); ?>
                </a>
            </li>
            <li>
                <a href="<?php echo $CFG->wwwroot ?>/local/mail/view.php?t=inbox">
                    <?php echo get_string('user_menu_email', 'theme_halloween'); ?>
                </a>
            </li>
            <?php if (utilities_user::is_user_site_admin($USER)) : ?>
            <li>
                <a href="<?php echo $CFG->wwwroot ?>/admin/index.php">
                    <?php echo get_string('administration', 'theme_halloween'); ?>
                </a>
            </li>
            <?php endif; ?>
            <li>
                <a href="<?php echo $CFG->wwwroot ?>/login/logout.php">
                    <?php echo get_string('user_menu_logout', 'theme_halloween'); ?>
                </a>
            </li>
        </ul>
    </div>
</div>

