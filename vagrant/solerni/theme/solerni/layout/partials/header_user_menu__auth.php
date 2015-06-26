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

/*
 * @author    Orange / Solerni
 * @package   theme_solerni
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$isdashboard          = $this->is_menu_item_active( '/my' );
$hasadmincapacity     = has_capability('moodle/site:config', context_system::instance());

?>

<li class="slrn-top-header__item">
    <a href="<?php echo $CFG->wwwroot; ?>/my">
        <?php echo get_string('dashboard', 'theme_solerni'); ?>
    </a>
    <?php if ( $isdashboard ) : ?>
        <span class="slrn-topbar-item__active"></span>
    <?php endif; ?>
</li>
<li class="slrn-top-header__item">
    <a class="dropdown-toggle  -not-uppercase" data-toggle="dropdown" role="button">
        <?php echo get_string('hello', 'theme_solerni') . ' ' . $USER->firstname . ' ' . $USER->lastname; ?>
        <b class="caret -is-white"></b>
    </a>
    <ul class="dropdown-menu">
        <span class="slrn-topbar-item__active"></span>
        <li class="dropdown-menu__item">
            <a class="-not-uppercase" href="<?php echo $CFG->wwwroot ?>/user/profile.php">
                <img class="profileicon" src="<?php echo $this->pix_url('profile/profile', 'theme') ?>" />
                <?php echo get_string('viewprofile'); ?>
            </a>
        </li>
        <li class="dropdown-menu__item">
            <a class="-not-uppercase" href="<?php echo $CFG->wwwroot ?>/user/edit.php">
                <img class="profileicon" src="<?php echo $this->pix_url('profile/edit', 'theme') ?>" />
                <?php echo get_string('editmyprofile'); ?>
            </a>
        </li>
        <?php if ( $hasadmincapacity ) : ?>
        <li class="dropdown-menu__item">
            <a class="-not-uppercase" href="<?php echo $CFG->wwwroot ?>/admin/index.php">
                <img class="profileicon" src="<?php echo $this->pix_url('a/settings', 'core') ?>" />
                <?php echo get_string('administration', 'theme_solerni'); ?>
            </a>
        </li>
        <?php endif; ?>
        <li class="dropdown-menu__item">
            <a class="-not-uppercase" href="<?php echo $CFG->wwwroot ?>/user/files.php">
                <img class="profileicon" src="<?php echo $this->pix_url('profile/files', 'theme') ?>" />
                <?php echo get_string('myfiles'); ?>
            </a>
        </li>
        <li class="dropdown-menu__item">
            <a class="-not-uppercase" href="<?php echo $CFG->wwwroot ?>/login/logout.php">
                <img class="profileicon" src="<?php echo $this->pix_url('profile/logout', 'theme') ?>" />
                <?php echo get_string('logout'); ?>
            </a>
        </li>
     </ul>
</li>
