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

$hasheading = ($PAGE->heading);
$hasnavbar = (empty($PAGE->layout_options['nonavbar']) && $PAGE->has_navbar());
$hasfooter = (empty($PAGE->layout_options['nofooter']));
$hasheader = (empty($PAGE->layout_options['noheader']));
$hassidepre = (empty($PAGE->layout_options['noblocks']) && $PAGE->blocks->region_has_content('side-pre', $OUTPUT));
$hassidepost = (empty($PAGE->layout_options['noblocks']) && $PAGE->blocks->region_has_content('side-post', $OUTPUT));
$showsidepre = ($hassidepre && !$PAGE->blocks->region_completely_docked('side-pre', $OUTPUT));
$showsidepost = ($hassidepost && !$PAGE->blocks->region_completely_docked('side-post', $OUTPUT));
$isfrontpage = ( $PAGE->bodyid == "page-site-index" );

?>

<header role="banner" class="navbar navbar-fixed-top slrn-top-header">
    <nav role="navigation">
        <div class="container-fluid slrn-top-header__inner -wrapper-justified">

            <a class="slrn-top-header__item slrn-top-header__logo -sprite-solerni"
               href="<?php echo $CFG->wwwroot;?>">
            </a>
            
            <?php $OUTPUT->solerni_search_box(); ?>
            
            <div class="nav-collapse collapse slrn-top-header__item slrn-top-header__menu -wrapper-justified">
           
                <?php $OUTPUT->solerni_header_pages(); ?>
            
                <?php $OUTPUT->solerni_catalogue(); ?>
                              
                <ul class="slrn-top-header__item">
                    <li>
                        <?php
                        // echo language dropdown menu for unlogged visitor
                        if ( ! isloggedin() ) {
                            echo $OUTPUT->solerni_lang_menu();
                        } else {
                            echo $PAGE->headingmenu;
                            include('profileblock.php');
                        }
                        ?>
                        
                    </li>
                </ul>
            </div>
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
        </div>
    </nav>
</header>

<div id="page" class="container-fluid">

<header id="page-header" class="clearfix">
    <?php if ($hasnavbar) { ?>
        <nav class="breadcrumb-button"><?php echo $PAGE->button; ?></nav>
        <?php echo $OUTPUT->navbar(); ?>
    <?php } ?>
    <h1><?php echo $PAGE->heading ?></h1>
</header>