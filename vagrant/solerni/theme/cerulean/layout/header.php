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
 * @author    Shaun Daubney
 * @author    Orange / Solerni
 * @package   theme_solerni
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$hasnavbar      = (empty($PAGE->layout_options['nonavbar']) && $PAGE->has_navbar());
$hasfooter      = (empty($PAGE->layout_options['nofooter']));
$hasheader      = (empty($PAGE->layout_options['noheader']));
$hassidepre     = (empty($PAGE->layout_options['noblocks']) && $PAGE->blocks->region_has_content('side-pre', $OUTPUT));
$hassidepost    = (empty($PAGE->layout_options['noblocks']) && $PAGE->blocks->region_has_content('side-post', $OUTPUT));
$showsidepre    = ($hassidepre && !$PAGE->blocks->region_completely_docked('side-pre', $OUTPUT));
$showsidepost   = ($hassidepost && !$PAGE->blocks->region_completely_docked('side-post', $OUTPUT));
$isfrontpage    = ($PAGE->pagetype === 'site-index');
?>

<header role="banner" >
    <nav role="navigation">
        <div >

            <a
               href="<?php echo $CFG->wwwroot; ?>">
            </a>

            <?php $OUTPUT->cerulean_search_box(); ?>

            <div >
                <ul >
                    <?php $OUTPUT->cerulean_header_links(); ?>
                    <?php $OUTPUT->cerulean_user_menu(); ?>
                </ul>
            </div>

            <a 
               data-toggle="collapse"
               data-target=".nav-collapse"
            >
                <span ></span>
                <span ></span>
                <span ></span>
            </a>

        </div>
    </nav>
</header>

<?php if ( $PAGE->pagetype === 'site-index' ) {
    include($CFG->partialsdir . '/frontpage_header.php');
} ?>

<div id="page" >
