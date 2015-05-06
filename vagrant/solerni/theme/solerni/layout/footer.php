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
                   get_string('footertagline', 'theme_solerni');
$explaination   = ($PAGE->theme->settings->footerexplaination) ?
                   $PAGE->theme->settings->footerexplaination :
                   get_string('footerexplaination', 'theme_solerni');
?>

<footer id="footer" class="row-fluid slrn-footer">
    <div class="span4 footer-brand">
        <div class="footer-brand__logo -sprite-solerni"></div>
        <p class="footer-brand_title"><?php echo $tagline; ?></p>
        <p class="footer-brand__text"><?php echo $explaination; ?></p>
    </div>
        <div class="span2 footer-column ">
            <p class="footer_title">A propos de nous</p>
            <ul class="footer_cms_menu__column">
                <li class="footer_cms_menu_column__item"><a class="footer_cms_menu_column__link" href="/mooc/static/page/cms_quoi">A propos de Solerni</a></li>
                <li class="footer_cms_menu_column__item"><a class="footer_cms_menu_column__link" href="/mooc/static/page/cms_partenaires">Partenaires</a></li>
                <li class="footer_cms_menu_column__item"><a class="footer_cms_menu_column__link" href="/mooc/static/page/cms_legal">Mentions légales</a></li>
                <li class="footer_cms_menu_column__item"><a class="footer_cms_menu_column__link js-link_cgu" href="/mooc/static/page/cms_cgu">CGU / Charte</a></li>
            </ul>
        </div>
        <div class="span2 footer-column ">
            <p class="footer_title">Support</p>
            <ul class="footer_cms_menu__column">
                <li class="footer_cms_menu_column__item"><a class="footer_cms_menu_column__link" href="/mooc/static/page/cms_faq">FAQ</a></li>
                <li class="footer_cms_menu_column__item"><a class="footer_cms_menu_column__link" href="/mooc/contact">Nous contacter</a></li>
            </ul>
        </div>
        <div class="span2 footer-column ">
            <p class="footer_title">Suivez-nous</p>
            <a href="/mooc/static/page/social_facebook" class="footer_social_link" target="_blank">
                <span class="footer_social_link__icon social_facebook">Facebook</span><!--
                --><span class="footer_icon_text">Facebook</span>
            </a>
            <a href="/mooc/static/page/social_twitter" class="footer_social_link" target="_blank">
                <span class="footer_social_link__icon social_twitter">Twitter</span><!--
                --><span class="footer_icon_text">Twitter</span>
            </a>
            <a href="/mooc/static/page/social_blog" class="footer_social_link">
                <span class="footer_social_link__icon social_blog">Blog</span><!--
                --><span class="footer_icon_text">Blog</span>
            </a>
        </div>
        <div class="span2 footer-column ">
            <p class="footer_title">International</p>
            <?php echo $OUTPUT->solerni_lang_menu(); ?>
        </div>

    <div class="container">
        <hr class="slrn-hr slrn-hr--thin">
        <a target="_blank" href="http://www.orange.com">
            <div class="footer_powered">powered by Orange</div>
        </a>
    </div>
</footer>
<div class="row-fluid">
    <?php echo $OUTPUT->standard_footer_html(); ?>
</div>
