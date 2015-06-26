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

$tagline        = ($PAGE->theme->settings->frontpagetagline) ?
                   $PAGE->theme->settings->frontpagetagline :
                   get_string('footertaglinedefault', 'theme_solerni');

$presentation   = ($PAGE->theme->settings->frontpagetagline) ?
                   $PAGE->theme->settings->frontpagetagline :
                   get_string('frontpagepresentationdefault', 'theme_solerni');
?>
<div class="frontpage-header">
    <h1 class="frontpage-header__tagline"><?php echo $tagline; ?></h1>
    <span class="frontpage-header__presentation"><?php echo $presentation; ?></span>
    <a class="frontpage-header__button" href="<?php echo $CFG->wwwroot ?>/login/index.php"></a>
</div>
