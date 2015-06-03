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
 * @author    Orange
 * @package   theme_solerni
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$haswebsite     = (!empty($PAGE->theme->settings->website));
$hasfacebook    = (!empty($PAGE->theme->settings->facebook));
$hastwitter     = (!empty($PAGE->theme->settings->twitter));
$hasgoogleplus  = (!empty($PAGE->theme->settings->googleplus));
$haslinkedin    = (!empty($PAGE->theme->settings->linkedin));
$hasyoutube     = (!empty($PAGE->theme->settings->youtube));
$tagline        = ($PAGE->theme->settings->footertagline) ?
                   $PAGE->theme->settings->footertagline :
                   get_string('footertaglinedefault', 'theme_solerni');
$explaination   = ($PAGE->theme->settings->footerexplaination) ?
                   $PAGE->theme->settings->footerexplaination :
                   get_string('footerexplainationdefault', 'theme_solerni');
?>

<footer id="footer" class="row-fluid slrn-footer">
    <div class="clearfix">
        <div class="span4 footer-brand">
            <div class="footer-brand__logo -sprite-solerni"></div>
            <p class="footer-brand_title"><?php echo $tagline; ?></p>
            <p class="footer-brand__text"><?php echo $explaination; ?></p>
        </div>
        <div class="span2 footer-column ">
            <p class="footer_column_title">
                <?php echo get_string('aboutus', 'theme_solerni'); ?>
            </p>
            <ul class="footer_column_menu__column">
                <li class="footer_column__item">
                    <a class="footer_column_menu_column__link" href="<?php echo $PAGE->theme->settings->aboutsolerni; ?>">
                        <?php echo get_string('aboutsolerni', 'theme_solerni'); ?>
                    </a>
                </li>
                <li class="footer_column__item">
                    <a class="footer_column_menu_column__link" href="<?php echo $PAGE->theme->settings->partners; ?>">
                        <?php echo get_string('partners', 'theme_solerni'); ?>
                    </a>
                </li>
                <li class="footer_column__item">
                    <a class="footer_column_menu_column__link" href="<?php echo $PAGE->theme->settings->legal; ?>">
                        <?php echo get_string('legal', 'theme_solerni'); ?>
                    </a>
                </li>
                <li class="footer_column__item">
                    <a class="footer_column_menu_column__link js-link_cgu" href="<?php echo $PAGE->theme->settings->cgu; ?>">
                        <?php echo get_string('cgu', 'theme_solerni'); ?>
                    </a>
                </li>
            </ul>
        </div>
        <div class="span2 footer-column ">
            <p class="footer_column_title">
                <?php echo get_string('support', 'theme_solerni'); ?>
            </p>
            <ul class="footer_column_menu__column">
                <li class="footer_column__item">
                    <a class="footer_column_menu_column__link" href="<?php echo $PAGE->theme->settings->faq; ?>">
                        <?php echo get_string('faq', 'theme_solerni'); ?>
                    </a>
                </li>
                <li class="footer_column__item">
                    <a class="footer_column_menu_column__link" href="<?php echo $PAGE->theme->settings->contactus; ?>">
                        <?php echo get_string('contactus', 'theme_solerni'); ?>
                    </a>
                </li>
            </ul>
        </div>
        <div class="span2 footer-column ">
            <p class="footer_column_title">
                <?php echo get_string('followus', 'theme_solerni'); ?>
            </p>
            <ul class="footer_column_menu__column">
                <li class="footer_column__item">
                    <a href="<?php echo $PAGE->theme->settings->facebook; ?>" class="footer_column_menu_column__link footer_social_link" target="_blank">
                        <span class="footer_social_link__icon footer_social_facebook  -sprite-solerni">Facebook</span><!--
                        --><span class="footer_icon_text">Facebook</span>
                    </a>
                </li>
                <li class="footer_column__item">
                    <a href="<?php echo $PAGE->theme->settings->twitter; ?>" class="footer_column_menu_column__link footer_social_link" target="_blank">
                        <span class="footer_social_link__icon footer_social_twitter -sprite-solerni">Twitter</span><!--
                        --><span class="footer_icon_text">Twitter</span>
                    </a>
                </li>
                <li class="footer_column__item">
                    <a href="<?php echo $PAGE->theme->settings->blog; ?>" class="footer_column_menu_column__link footer_column_menu_column__linkfooter_social_link">
                        <span class="footer_social_link__icon footer_social_blog -sprite-solerni">Blog</span><!--
                        --><span class="footer_icon_text">Blog</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="span2 footer-column">
            <p class="footer_column_title">
                <?php echo get_string('international', 'theme_solerni'); ?>
            </p>
            <ul class="footer_lang_menu">
                <?php echo $OUTPUT->solerni_lang_menu(); ?>
            </ul>
        </div>
    </div>
    <div class="row-fluid">
        <hr class="slrn-hr slrn-hr--thin">
        <a class="pull-right" target="_blank" href="http://www.orange.com">
            <div class="footer_powered  -sprite-solerni">powered by Orange</div>
        </a>
    </div>
</footer>
<div class="row-fluid">
    <?php echo $OUTPUT->standard_footer_html(); ?>
</div>
