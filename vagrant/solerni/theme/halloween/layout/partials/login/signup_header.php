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

use theme_halloween\tools\theme_utilities;
require_once($CFG->dirroot . '/filter/multilang/filter.php');
$filtermultilang = new filter_multilang($PAGE->context, array());
?>
<?php if (theme_utilities::is_theme_settings_exists_and_nonempty(
        array('signuptitle', 'signuptext'), 'atleastone')) : ?>
    <div class="row signup-header">
        <div class="page-header text-center">
            <?php if (theme_utilities::is_theme_settings_exists_and_nonempty('signuptitle')) : ?>
                <h1 class="col-md-8 col-md-offset-2">
                    <?php echo $filtermultilang->filter($PAGE->theme->settings->signuptitle); ?>
                </h1>
            <?php endif; ?>
            <?php if (theme_utilities::is_theme_settings_exists_and_nonempty('signuptext')) : ?>
                <p class="col-md-6 col-md-offset-3">
                    <?php echo $filtermultilang->filter($PAGE->theme->settings->signuptext); ?>
                </p>
            <?php endif; ?>
        </div>
    </div>
<?php endif;
