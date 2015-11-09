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
use local_orange_library\utilities\utilities_image;
require_once($CFG->dirroot . '/filter/multilang/filter.php');
$filtermultilang = new filter_multilang($PAGE->context, array());
?>
<?php if (theme_utilities::is_theme_settings_exists_and_nonempty('loginlogo')) : ?>
    <img class="img-responsive center-block img-thumbnail"
        src="<?php echo utilities_image::get_resized_url(
            null,
            array('w' => 200, 'h' => 200, 'scale' => true),
            utilities_image::get_moodle_stored_file(
                    context_system::instance(), 'theme_halloween', 'loginlogo'));
        ?>"
    alt="" width="200" height="200">
<?php endif; ?>
<?php if (theme_utilities::is_theme_settings_exists_and_nonempty('logintitle')) : ?>
    <h1 class="col-md-8 col-md-offset-2">
        <?php echo $filtermultilang->filter($PAGE->theme->settings->logintitle); ?>
    </h1>
<?php endif; ?>
<?php if (theme_utilities::is_theme_settings_exists_and_nonempty('logintext')) : ?>
    <p class="col-md-6 col-md-offset-3">
        <?php echo $filtermultilang->filter($PAGE->theme->settings->logintext); ?>
    </p>
<?php endif; ?>
<p class="col-md-6 col-md-offset-3" >
    <?php echo get_string('not_registered_yet', 'theme_halloween'); ?>
    <a class="js-register" href="<?php echo $CFG->wwwroot ?>/login/signup.php">
        <?php echo get_string('i_do_register', 'theme_halloween'); ?>
    </a>
</p>
