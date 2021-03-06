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

use local_orange_library\utilities\utilities_network; ?>

<div class="container">
    <header class="header row">
        <div class="col-xs-12">
            <a href="<?php echo $CFG->wwwroot; ?>" class="header-logo">
                <img class="logo-image" src="<?php echo $OUTPUT->pix_url('logo-orange', 'theme'); ?>"
                     alt="" width="50" height="50">
                <?php $sitename = (utilities_network::is_home())
                        ? ucfirst($CFG->solerni_customer_name)
                        : ucfirst($CFG->solerni_customer_name) . ' ' . ucfirst($CFG->solerni_thematic); ?>
                <span class="logo-brandname"><?php echo $sitename; ?></span>
            </a>
            <?php if (isloggedin()) {
                require($CFG->partialsdir . '/header/header_user_menu__auth.php');
            } else {
                require($CFG->partialsdir . '/header/header_user_menu__no_auth.php');
            }
            ?>
        </div>
    </header>
</div>
