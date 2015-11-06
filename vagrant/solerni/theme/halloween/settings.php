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

/**
 * @package    theme_halloween
 * @copyright  2014 Bas Brands
 * @copyright  Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
use theme_halloween\settings\options;

defined('MOODLE_INTERNAL') || die;

$settings = null;

// Create new admin category Solerni.
$ADMIN->add('themes', new admin_category('theme_halloween', 'Halloween'));

/*
 * Colors: Settings
 */
$temp = new admin_settingpage('theme_halloween_colors', get_string('colorsettings', 'theme_halloween'));
$name = 'theme_halloween/colourheading';
$heading = get_string('colourheading', 'theme_halloween');
$information = get_string('colourheadingdesc', 'theme_halloween');
$setting = new admin_setting_heading($name, $heading, $information);
$temp->add($setting);

// Get colors keys and values from options class.
foreach (options::get_colors_list() as $key => $value) {
    $name = 'theme_halloween/' . $key;
    $title = get_string($key, 'theme_halloween');
    $description = get_string( $key . 'desc', 'theme_halloween');
    $default = $value;
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);
}
$ADMIN->add('theme_halloween', $temp);

/*
 * Follow Us: Settings
 */
$temp = new admin_settingpage('theme_halloween_social', get_string('followussettings', 'theme_halloween'));
$name = 'theme_halloween/followusheading';
$heading = get_string('followusheading', 'theme_halloween');
$information = get_string('followusheadingdesc', 'theme_halloween');
$setting = new admin_setting_heading($name, $heading, $information);
$temp->add($setting);

foreach (options::halloween_get_followus_urllist() as $key => $value) {
    $name = 'theme_halloween/' . $key;
    $title = get_string($key, 'theme_halloween');
    $description = '';
    $default = $value;
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);
}
$ADMIN->add('theme_halloween', $temp);

/*
 * Footer Branding Area: Settings
 */
$temp = new admin_settingpage('theme_halloween_footerbrand', get_string('footerbrandsettings', 'theme_halloween'));
$name = 'theme_halloween/footerbrandheading';
$heading = get_string('footerbrandheading', 'theme_halloween');
$information = htmlentities(get_string('footerbrandheadingdesc', 'theme_halloween'));
$setting = new admin_setting_heading($name, $heading, $information);
$temp->add($setting);

foreach (options::halloween_get_footerbrand_content() as $key => $value) {
    $name = 'theme_halloween/' . $key;
    $title = get_string($key, 'theme_halloween');
    $description = '';
    $default = $value;
    $setting = new admin_setting_configtextarea($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);
}
$ADMIN->add('theme_halloween', $temp);

/*
 * Footer lists: Settings
 */
$temp = new admin_settingpage('theme_halloween_footerlists', get_string('footerlistssettings', 'theme_halloween'));
$name = 'theme_halloween/footerlistsheading';
$heading = get_string('footerlistsheading', 'theme_halloween');
$information = get_string('footerlistsheadingdesc', 'theme_halloween');
$setting = new admin_setting_heading($name, $heading, $information);
$temp->add($setting);

// First Column.
$name = 'theme_halloween/footerlistscolumn1heading';
$heading = get_string('footerlistscolumn1heading', 'theme_halloween');
$information = htmlentities(get_string('footerlistscolumn1headingdesc', 'theme_halloween'));
$setting = new admin_setting_heading($name, $heading, $information);
$temp->add($setting);

foreach (options::halloween_get_footerlists_column1_items() as $key => $value) {
    $name = 'theme_halloween/' . $key;
    $title = get_string( $key, 'theme_halloween' );
    $description = '';
    $default = $value;
    if (false === strpos($key, 'link')) {
        $setting = new admin_setting_configtextarea($name, $title, $description, $default);
    } else {
        $setting = new admin_setting_configtext($name, $title, $description, $default);
    }
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);
}

// Second Column.
$name = 'theme_halloween/footerlistscolumn2heading';
$heading = get_string('footerlistscolumn2heading', 'theme_halloween');
$information = htmlentities(get_string('footerlistscolumn2headingdesc', 'theme_halloween'));
$setting = new admin_setting_heading($name, $heading, $information);
$temp->add($setting);

foreach (options::halloween_get_footerlists_column2_items() as $key => $value) {
    $name = 'theme_halloween/' . $key;
    $title = get_string( $key, 'theme_halloween' );
    $description = '';
    $default = $value;
    if (false === strpos($key, 'link')) {
        $setting = new admin_setting_configtextarea($name, $title, $description, $default);
    } else {
        $setting = new admin_setting_configtext($name, $title, $description, $default);
    }
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);
}
$ADMIN->add('theme_halloween', $temp);

/*
 * Login : Settings
 */
$temp = new admin_settingpage('theme_halloween_login', get_string('loginsettings', 'theme_halloween'));
$name = 'theme_halloween/loginheading';
$heading = get_string('loginheading', 'theme_halloween');
$information = get_string('loginheadingdesc', 'theme_halloween');
$setting = new admin_setting_heading($name, $heading, $information);
$temp->add($setting);

// Login logo.
$name = 'theme_halloween/loginlogo';
$title = get_string('loginlogo', 'theme_halloween');
$description = get_string('loginlogodesc', 'theme_halloween');
$setting = new admin_setting_configstoredfile($name, $title, $description, 'loginlogo');
$setting->set_updatedcallback('theme_reset_all_caches');
$temp->add($setting);

// Login Title.
$name = 'theme_halloween/logintitle';
$title = get_string('logintitle', 'theme_halloween');
$description = get_string('logintitledesc', 'theme_halloween');
$default = ($CFG->solerni_isprivate) ?
            '<span lang="fr" class="multilang">Accédez à votre espace privé d\'apprentissage</span><span lang="en" class="multilang">Enter your private learning space</span>' :
            '<span lang="fr" class="multilang">Je me connecte</span><span lang="en" class="multilang">I log in</span>';
$setting = new admin_setting_configtextarea($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$temp->add($setting);

// Login Text.
$name = 'theme_halloween/logintext';
$title = get_string('logintext', 'theme_halloween');
$description = get_string('logintextdesc', 'theme_halloween');
$default = ($CFG->solerni_isprivate) ?
        '<span lang="fr" class="multilang"></span><span lang="en" class="multilang"></span>' :
        '<span lang="fr" class="multilang"></span><span lang="en" class="multilang"></span>';
$setting = new admin_setting_configtextarea($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$temp->add($setting);

// Username field label.
$name = 'theme_halloween/loginusername';
$title = get_string('loginusername', 'theme_halloween');
$description = get_string('loginusernamedesc', 'theme_halloween');
$default = ($CFG->solerni_isprivate) ?
        '<span lang="fr" class="multilang">Pseudo ou email</span><span lang="en" class="multilang">Nickname or email</span>' :
        '<span lang="fr" class="multilang">Pseudo ou email</span><span lang="en" class="multilang">Nickname or email</span>';
$setting = new admin_setting_configtextarea($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$temp->add($setting);

// Username field complementary text.
$name = 'theme_halloween/loginusernamesub';
$title = get_string('loginusernamesub', 'theme_halloween');
$description = get_string('loginusernamesubdesc', 'theme_halloween');
$default = ($CFG->solerni_isprivate) ?
        '<span lang="fr" class="multilang">Saisir le pseudo fourni ou votre email professionnel</span><span lang="en" class="multilang">Enter your provided username or your professionnal email</span>' :
        '<span lang="fr" class="multilang"></span><span lang="en" class="multilang"></span>';
$setting = new admin_setting_configtextarea($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$temp->add($setting);

// Password field label.
$name = 'theme_halloween/loginpassword';
$title = get_string('loginpassword', 'theme_halloween');
$description = get_string('loginpassworddesc', 'theme_halloween');
$default = '<span lang="fr" class="multilang">Mot de passe</span><span lang="en" class="multilang">Password</span>';
$setting = new admin_setting_configtextarea($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$temp->add($setting);

// Password field complementary text.
$name = 'theme_halloween/loginpasswordsub';
$title = get_string('loginpasswordsub', 'theme_halloween');
$description = get_string('loginpasswordsubdesc', 'theme_halloween');
$default = '<span lang="fr" class="multilang"></span><span lang="en" class="multilang"></span>';
$setting = new admin_setting_configtextarea($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$temp->add($setting);

$ADMIN->add('theme_halloween', $temp);
