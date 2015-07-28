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
 * @author    Orange
 * @package   theme_solerni
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use theme_cerulean\settings\options as options;

$haswebsite         = (!empty($PAGE->theme->settings->website));
$hasfacebook        = (!empty($PAGE->theme->settings->facebook));
$hastwitter         = (!empty($PAGE->theme->settings->twitter));
$hasgoogleplus      = (!empty($PAGE->theme->settings->googleplus));
$haslinkedin        = (!empty($PAGE->theme->settings->linkedin));
$hasyoutube         = (!empty($PAGE->theme->settings->youtube));
$footertagline      = 'footertagline_'.current_language();
$footerexplaination = 'footerexplaination_'.current_language();
$tagline            = ($PAGE->theme->settings->$footertagline) ?
                       $PAGE->theme->settings->$footertagline :
                       get_string('footertaglinedefault', 'theme_cerulean');
$explaination       = ($PAGE->theme->settings->$footerexplaination) ?
                       $PAGE->theme->settings->$footerexplaination :
                       get_string('footerexplainationdefault', 'theme_cerulean');
?>

<footer id="footer" class="row-fluid slrn-footer">
    <div class="clearfix">
        <div class="span4 footer-brand">
            <div class="footer-brand__logo -sprite-cerulean"></div>
            <p class="footer-brand_title"><?php echo $tagline; ?></p>
            <p class="footer-brand__text"><?php echo $explaination; ?></p>
        </div>
        <?php $OUTPUT->render_footer_column_with_links( 'aboutus', array('aboutsolerni', 'partners', 'legal', 'cgu') ); ?>
        <?php $OUTPUT->render_footer_column_with_links( 'support', array('faq', 'contactus') ); ?>
        <?php $OUTPUT->render_footer_column_socials( 'followus', array('facebook', 'twitter', 'dailymotion', 'blog') ); ?>
        <div class="span2 footer-column">
            <p class="footer_column_title">
                <?php echo get_string('international', 'theme_cerulean'); ?>
            </p>
            <ul class="footer_lang_menu">
                <?php echo $OUTPUT->cerulean_lang_menu(); ?>
            </ul>
        </div>
    </div>
    <div class="row-fluid">
        <hr class="slrn-hr slrn-hr--thin">
        <a class="pull-right" target="_blank" href="http://www.orange.com">
            <div class="footer_powered  -sprite-cerulean">powered by Orange</div>
        </a>
    </div>
</footer>
<div class="row-fluid">
    <?php echo $OUTPUT->standard_footer_html(); ?>
</div>
