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

/*
 * Contains functions and associative arrays useful for the settings page, as the list of colors
 * that will be used on the CSS, or the list of the social networks.
 *
 * All of those are stored into a standard class to be instanciated when necessary.
 *
 *
 * @author    Orange / halloween
 * @package   theme_halloween
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace theme_halloween\settings;

class options {

    /**
     * This function defines a list of colors with their default values.
     * The color names matches bootstrap's LESS variable name so the theme
     * could replace their values with the settings values.
     * Allowing Moodle Admin to change boostraps defaults.
     *
     * @return array
     */
    public static function get_colors_list() {
        return array(
            'body_bg'           => '#FFFFFF',
            'brand_primary'     => '#000000',
            'brand_secondary'   => '#F16E00',
            'brand_tertiary'    => '#FFFFFF',
            'brand_success'     => '#32C832',
            'brand_info'        => '#527EBD',
            'brand_warning'     => '#FFCC00',
            'brand_danger'      => '#DC3C14',
            'orange_yellow'     => '#FFD200',
            'orange_blue'       => '#4BB4E6',
            'orange_green'      => '#50BE87',
            'orange_purple'     => '#A885D8',
            'orange_pink'       => '#FFB4E6',
            'orange_light_1'    => '#F6F6F6',
            'orange_light_2'    => '#EEEEEE',
            'orange_light_3'    => '#DDDDDD',
            'orange_light_4'    => '#CCCCCC',
            'orange_mid_1'      => '#999999',
            'orange_mid_2'      => '#666666',
            'orange_dark_1'     => '#444444',
            'orange_dark_2'     => '#333333',
            'orange_dark_3'     => '#232323'
        );
    }

    /*
     * Return associative array ( setting_name => default_value )
     * List fields and default values for social networks and profiles channels.
     */
    public static function halloween_get_followus_urllist() {
        return array(
            'facebook'          => 'https://fr-fr.facebook.com/pages/Solerni/648508191861244',
            'twitter'           => 'https://twitter.com/solerniofficiel',
            'linkedin'          => '',
            'googleplus'        => '',
            'dailymotion'       => 'http://www.dailymotion.com/Solerni',
            'blog'              => 'https://solerni.org/blog/'
        );
    }

    /*
    * Return associative array with fieldtype
    * List fields and default values for footer text setting page
     */
    public static function halloween_get_footerbrand_content() {
        global $CFG;
        return array (
            'footerbrandtitle'      => '<span lang="fr" class="multilang">Solerni</span><span lang="en" class="multilang">Solerni</span>',
            'footerbrandchapo'      => '<span lang="fr" class="multilang">Apprendre, c\'est toujours mieux ensemble</span><span lang="en" class="multilang">To learn is more fun together</span>',
            'footerbrandarticle'    => '<span lang="fr" class="multilang">Solerni est une solution logicielle complète dédiée à la création et à l\'hébergement de parcours d\'apprentissage massifs collaboratifs.</span><span lang="en" class="multilang">Solerni is a full software suite dedicated to help you creating and hosting massively collaborative learning routes.</span>',
            'footerbrandanchor'     => '<span lang="fr" class="multilang">Accédez à notre catalogue de cours</span><span lang="en" class="multilang">See our course catalog</span>',
            'footerbrandurl'        => '<span lang="fr" class="multilang">' . $CFG->wwwroot . '/catalog</span><span lang="en" class="multilang">' . $CFG->wwwroot . '/catalog</span>'
        );
    }

    /*
    * Return associative array ( setting_name => default_value )
    * List fields and default values for first column footer links
     */
    public static function halloween_get_footerlists_column1_items() {
        global $CFG;
        return array(
            'footerlistscolumn1title'   => '<span lang="fr" class="multilang">A propos de nous</span><span lang="en" class="multilang">About us</span>',
            'footerlistscolumn1anchor1' => '<span lang="fr" class="multilang">A propos de Solerni</span><span lang="en" class="multilang">About Solerni</span>',
            'footerlistscolumn1link1'   => $CFG->wwwroot . '/static/a-propos.html',
            'footerlistscolumn1anchor2' => '<span lang="fr" class="multilang">Partenaires</span><span lang="en" class="multilang">Partners</span>',
            'footerlistscolumn1link2'   => $CFG->wwwroot . '/static/partenaires.html',
            'footerlistscolumn1anchor3' => '<span lang="fr" class="multilang">Mentions légales</span><span lang="en" class="multilang">Legal notices</span>',
            'footerlistscolumn1link3'   => $CFG->wwwroot . '/static/mentions-legales.html',
            'footerlistscolumn1anchor4' => '<span lang="fr" class="multilang">CGU / Charte</span><span lang="en" class="multilang">Terms and Conditions</span>',
            'footerlistscolumn1link4'   => $CFG->wwwroot . '/static/cgu.html'
        );
    }

    /*
    * Return associative array ( setting_name => default_value )
    * List fields and default values for second column footer links
     */
    public static function halloween_get_footerlists_column2_items() {
        global $CFG;
        return array(
            'footerlistscolumn2title'   => '<span lang="fr" class="multilang">Support</span><span lang="en" class="multilang">Support</span>',
            'footerlistscolumn2anchor1' => '<span lang="fr" class="multilang">FAQ</span><span lang="en" class="multilang">FAQ</span>',
            'footerlistscolumn2link1'   => $CFG->wwwroot . '/static/faq.html',
            'footerlistscolumn2anchor2' => '<span lang="fr" class="multilang">Nous contacter</span><span lang="en" class="multilang">Contact us</span>',
            'footerlistscolumn2link2'   => $CFG->wwwroot . '/contact/',
            'footerlistscolumn2anchor3' => '<span lang="fr" class="multilang"></span><span lang="en" class="multilang"></span>',
            'footerlistscolumn2link3'   => '',
            'footerlistscolumn2anchor4' => '<span lang="fr" class="multilang"></span><span lang="en" class="multilang"></span>',
            'footerlistscolumn2link4'   => ''
        );
    }
}
