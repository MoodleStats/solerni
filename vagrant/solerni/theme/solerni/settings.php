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

/**
 * This is built using the bootstrapbase template to allow for new theme's using
 * Moodle's new Bootstrap theme engine
 *
 * @package     theme_solerni
 * @copyright   2013 Julian Ridden
 * @copyright   2014 Gareth J Barnard, David Bezemer
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$settings = null;

defined('MOODLE_INTERNAL') || die;
if (is_siteadmin()) {

    $ADMIN->add('themes', new admin_category('theme_solerni', 'Solerni'));

    /* Generic Settings */
    $temp = new admin_settingpage('theme_solerni_generic', get_string('genericsettings', 'theme_solerni'));

    $temp->add(new admin_setting_heading('theme_solerni_generalheading', get_string('generalheadingsub', 'theme_solerni'),
        format_text(get_string('generalheadingdesc', 'theme_solerni'), FORMAT_MARKDOWN)));

    // Background Image.
    $name = 'theme_solerni/pagebackground';
    $title = get_string('pagebackground', 'theme_solerni');
    $description = get_string('pagebackgrounddesc', 'theme_solerni');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'pagebackground');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Background Image.
    $name = 'theme_solerni/pagebackgroundstyle';
    $title = get_string('pagebackgroundstyle', 'theme_solerni');
    $description = get_string('pagebackgroundstyledesc', 'theme_solerni');
    $default = 'fixed';
    $setting = new admin_setting_configselect($name, $title, $description, $default, array(
        'fixed' => get_string('backgroundstylefixed', 'theme_solerni'),
        'tiled' => get_string('backgroundstyletiled', 'theme_solerni'),
        'stretch' => get_string('backgroundstylestretch', 'theme_solerni'),
    ));
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Fixed or Variable Width.
    $name = 'theme_solerni/pagewidth';
    $title = get_string('pagewidth', 'theme_solerni');
    $description = get_string('pagewidthdesc', 'theme_solerni');
    $default = 1200;
    $choices = array(960 => get_string('fixedwidthnarrow', 'theme_solerni'),
        1200 => get_string('fixedwidthnormal', 'theme_solerni'),
        1400 => get_string('fixedwidthwide', 'theme_solerni'),
        100 => get_string('variablewidth', 'theme_solerni'));
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Custom or standard layout.
    $name = 'theme_solerni/layout';
    $title = get_string('layout', 'theme_solerni');
    $description = get_string('layoutdesc', 'theme_solerni');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // New or old navbar.
    $name = 'theme_solerni/oldnavbar';
    $title = get_string('oldnavbar', 'theme_solerni');
    $description = get_string('oldnavbardesc', 'theme_solerni');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Choose breadcrumbstyle
    $name = 'theme_solerni/breadcrumbstyle';
    $title = get_string('breadcrumbstyle', 'theme_solerni');
    $description = get_string('breadcrumbstyledesc', 'theme_solerni');
    $default = 1;
    $choices = array(
        1 => get_string('breadcrumbstyled', 'theme_solerni'),
        4 => get_string('breadcrumbstylednocollapse', 'theme_solerni'),
        2 => get_string('breadcrumbsimple', 'theme_solerni'),
        3 => get_string('breadcrumbthin', 'theme_solerni'),
        0 => get_string('nobreadcrumb', 'theme_solerni')
    );
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Fitvids.
    $name = 'theme_solerni/fitvids';
    $title = get_string('fitvids', 'theme_solerni');
    $description = get_string('fitvidsdesc', 'theme_solerni');
    $default = true;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Custom CSS file.
    $name = 'theme_solerni/customcss';
    $title = get_string('customcss', 'theme_solerni');
    $description = get_string('customcssdesc', 'theme_solerni');
    $default = '';
    $setting = new admin_setting_configtextarea($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $readme = new moodle_url('/theme/essential/README.txt');
    $readme = html_writer::link($readme, get_string('readme_click', 'theme_solerni'), array('target' => '_blank'));

    $temp->add(new admin_setting_heading('theme_solerni_generalreadme', get_string('readme_title', 'theme_solerni'),
        get_string('readme_desc', 'theme_solerni', array('url' => $readme))));

    $ADMIN->add('theme_solerni', $temp);


    /* Colour Settings */
    $temp = new admin_settingpage('theme_solerni_color', get_string('colorheading', 'theme_solerni'));
    $temp->add(new admin_setting_heading('theme_solerni_color', get_string('colorheadingsub', 'theme_solerni'),
        format_text(get_string('colordesc', 'theme_solerni'), FORMAT_MARKDOWN)));

    // Main theme colour setting.
    $name = 'theme_solerni/themecolor';
    $title = get_string('themecolor', 'theme_solerni');
    $description = get_string('themecolordesc', 'theme_solerni');
    $default = '#30add1';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Main theme text colour setting.
    $name = 'theme_solerni/themetextcolor';
    $title = get_string('themetextcolor', 'theme_solerni');
    $description = get_string('themetextcolordesc', 'theme_solerni');
    $default = '#217a94';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Main theme link colour setting.
    $name = 'theme_solerni/themeurlcolor';
    $title = get_string('themeurlcolor', 'theme_solerni');
    $description = get_string('themeurlcolordesc', 'theme_solerni');
    $default = '#943b21';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Main theme Hover colour setting.
    $name = 'theme_solerni/themehovercolor';
    $title = get_string('themehovercolor', 'theme_solerni');
    $description = get_string('themehovercolordesc', 'theme_solerni');
    $default = '#6a2a18';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Icon colour setting.
    $name = 'theme_solerni/themeiconcolor';
    $title = get_string('themeiconcolor', 'theme_solerni');
    $description = get_string('themeiconcolordesc', 'theme_solerni');
    $default = '#30add1';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Navigation colour setting.
    $name = 'theme_solerni/themenavcolor';
    $title = get_string('themenavcolor', 'theme_solerni');
    $description = get_string('themenavcolordesc', 'theme_solerni');
    $default = '#ffffff';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // This is the descriptor for the Footer
    $name = 'theme_solerni/footercolorinfo';
    $heading = get_string('footercolors', 'theme_solerni');
    $information = get_string('footercolorsdesc', 'theme_solerni');
    $setting = new admin_setting_heading($name, $heading, $information);
    $temp->add($setting);

    // Footer background colour setting.
    $name = 'theme_solerni/footercolor';
    $title = get_string('footercolor', 'theme_solerni');
    $description = get_string('footercolordesc', 'theme_solerni');
    $default = '#555555';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Footer text colour setting.
    $name = 'theme_solerni/footertextcolor';
    $title = get_string('footertextcolor', 'theme_solerni');
    $description = get_string('footertextcolordesc', 'theme_solerni');
    $default = '#bbbbbb';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Footer Block Heading colour setting.
    $name = 'theme_solerni/footerheadingcolor';
    $title = get_string('footerheadingcolor', 'theme_solerni');
    $description = get_string('footerheadingcolordesc', 'theme_solerni');
    $default = '#cccccc';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Footer Seperator colour setting.
    $name = 'theme_solerni/footersepcolor';
    $title = get_string('footersepcolor', 'theme_solerni');
    $description = get_string('footersepcolordesc', 'theme_solerni');
    $default = '#313131';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Footer URL colour setting.
    $name = 'theme_solerni/footerurlcolor';
    $title = get_string('footerurlcolor', 'theme_solerni');
    $description = get_string('footerurlcolordesc', 'theme_solerni');
    $default = '#217a94';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Footer URL hover colour setting.
    $name = 'theme_solerni/footerhovercolor';
    $title = get_string('footerhovercolor', 'theme_solerni');
    $description = get_string('footerhovercolordesc', 'theme_solerni');
    $default = '#30add1';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // This is the descriptor for the user theme colors.
    $name = 'theme_solerni/alternativethemecolorsinfo';
    $heading = get_string('alternativethemecolors', 'theme_solerni');
    $information = get_string('alternativethemecolorsdesc', 'theme_solerni');
    $setting = new admin_setting_heading($name, $heading, $information);
    $temp->add($setting);

    $defaultalternativethemecolors = array('#a430d1', '#d15430', '#5dd130');
    $defaultalternativethemehovercolors = array('#9929c4', '#c44c29', '#53c429');

    foreach (range(1, 3) as $alternativethemenumber) {

        // Enables the user to select an alternative colours choice.
        $name = 'theme_solerni/enablealternativethemecolors' . $alternativethemenumber;
        $title = get_string('enablealternativethemecolors', 'theme_solerni', $alternativethemenumber);
        $description = get_string('enablealternativethemecolorsdesc', 'theme_solerni', $alternativethemenumber);
        $default = false;
        $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $temp->add($setting);

        // User theme colour name.
        $name = 'theme_solerni/alternativethemename' . $alternativethemenumber;
        $title = get_string('alternativethemename', 'theme_solerni', $alternativethemenumber);
        $description = get_string('alternativethemenamedesc', 'theme_solerni', $alternativethemenumber);
        $default = get_string('alternativecolors', 'theme_solerni', $alternativethemenumber);
        $setting = new admin_setting_configtext($name, $title, $description, $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $temp->add($setting);

        // User theme colour setting.
        $name = 'theme_solerni/alternativethemecolor' . $alternativethemenumber;
        $title = get_string('alternativethemecolor', 'theme_solerni', $alternativethemenumber);
        $description = get_string('alternativethemecolordesc', 'theme_solerni', $alternativethemenumber);
        $default = $defaultalternativethemecolors[$alternativethemenumber - 1];
        $previewconfig = null;
        $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $temp->add($setting);

        // Alternative theme text colour setting.
        $name = 'theme_solerni/alternativethemetextcolor' . $alternativethemenumber;
        $title = get_string('alternativethemetextcolor', 'theme_solerni', $alternativethemenumber);
        $description = get_string('alternativethemetextcolordesc', 'theme_solerni', $alternativethemenumber);
        $default = $defaultalternativethemecolors[$alternativethemenumber - 1];
        $previewconfig = null;
        $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $temp->add($setting);

        // Alternative theme link colour setting.
        $name = 'theme_solerni/alternativethemeurlcolor' . $alternativethemenumber;
        $title = get_string('alternativethemehovercolor', 'theme_solerni', $alternativethemenumber);
        $description = get_string('alternativethemehovercolordesc', 'theme_solerni', $alternativethemenumber);
        $default = $defaultalternativethemecolors[$alternativethemenumber - 1];
        $previewconfig = null;
        $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $temp->add($setting);

        // User theme hover colour setting.
        $name = 'theme_solerni/alternativethemehovercolor' . $alternativethemenumber;
        $title = get_string('alternativethemehovercolor', 'theme_solerni', $alternativethemenumber);
        $description = get_string('alternativethemehovercolordesc', 'theme_solerni', $alternativethemenumber);
        $default = $defaultalternativethemehovercolors[$alternativethemenumber - 1];
        $previewconfig = null;
        $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $temp->add($setting);
    }

    $ADMIN->add('theme_solerni', $temp);

    /* Header Settings */
    $temp = new admin_settingpage('theme_solerni_header', get_string('headerheading', 'theme_solerni'));

    // Default Site icon setting.
    $name = 'theme_solerni/siteicon';
    $title = get_string('siteicon', 'theme_solerni');
    $description = get_string('siteicondesc', 'theme_solerni');
    $default = 'laptop';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $temp->add($setting);

    // Logo file setting.
    $name = 'theme_solerni/logo';
    $title = get_string('logo', 'theme_solerni');
    $description = get_string('logodesc', 'theme_solerni');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'logo');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Header title setting.
    $name = 'theme_solerni/headertitle';
    $title = get_string('headertitle', 'theme_solerni');
    $description = get_string('headertitledesc', 'theme_solerni');
    $default = '1';
    $choices = array(
        0 => get_string('notitle', 'theme_solerni'),
        1 => get_string('fullname', 'theme_solerni'),
        2 => get_string('shortname', 'theme_solerni'),
        3 => get_string('fullnamesummary', 'theme_solerni'),
        4 => get_string('shortnamesummary', 'theme_solerni')
    );
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Navbar title setting.
    $name = 'theme_solerni/navbartitle';
    $title = get_string('navbartitle', 'theme_solerni');
    $description = get_string('navbartitledesc', 'theme_solerni');
    $default = '2';
    $choices = array(
        0 => get_string('notitle', 'theme_solerni'),
        1 => get_string('fullname', 'theme_solerni'),
        2 => get_string('shortname', 'theme_solerni'),
    );
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    /* Course Menu Settings */
    $name = 'theme_solerni/mycoursesinfo';
    $heading = get_string('mycoursesinfo', 'theme_solerni');
    $information = get_string('mycoursesinfodesc', 'theme_solerni');
    $setting = new admin_setting_heading($name, $heading, $information);
    $temp->add($setting);

    // Toggle courses display in custommenu.
    $name = 'theme_solerni/displaymycourses';
    $title = get_string('displaymycourses', 'theme_solerni');
    $description = get_string('displaymycoursesdesc', 'theme_solerni');
    $default = true;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Set terminology for dropdown course list
    $name = 'theme_solerni/mycoursetitle';
    $title = get_string('mycoursetitle', 'theme_solerni');
    $description = get_string('mycoursetitledesc', 'theme_solerni');
    $default = 'course';
    $choices = array(
        'course' => get_string('mycourses', 'theme_solerni'),
        'unit' => get_string('myunits', 'theme_solerni'),
        'class' => get_string('myclasses', 'theme_solerni'),
        'module' => get_string('mymodules', 'theme_solerni')
    );
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Helplink type
    $name = 'theme_solerni/helplinktype';
    $title = get_string('helplinktype', 'theme_solerni');
    $description = get_string('helplinktypedesc', 'theme_solerni');
    $default = 1;
    $choices = array(1 => get_string('email'),
        2 => get_string('url'),
        0 => get_string('none')
    );
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Helplink
    $name = 'theme_solerni/helplink';
    $title = get_string('helplink', 'theme_solerni');
    $description = get_string('helplinkdesc', 'theme_solerni');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    /* Social Network Settings */
    $temp->add(new admin_setting_heading('theme_solerni_social', get_string('socialheadingsub', 'theme_solerni'),
        format_text(get_string('socialdesc', 'theme_solerni'), FORMAT_MARKDOWN)));

    // Website url setting.
    $name = 'theme_solerni/website';
    $title = get_string('website', 'theme_solerni');
    $description = get_string('websitedesc', 'theme_solerni');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Facebook url setting.
    $name = 'theme_solerni/facebook';
    $title = get_string('facebook', 'theme_solerni');
    $description = get_string('facebookdesc', 'theme_solerni');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Flickr url setting.
    $name = 'theme_solerni/flickr';
    $title = get_string('flickr', 'theme_solerni');
    $description = get_string('flickrdesc', 'theme_solerni');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Twitter url setting.
    $name = 'theme_solerni/twitter';
    $title = get_string('twitter', 'theme_solerni');
    $description = get_string('twitterdesc', 'theme_solerni');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Google+ url setting.
    $name = 'theme_solerni/googleplus';
    $title = get_string('googleplus', 'theme_solerni');
    $description = get_string('googleplusdesc', 'theme_solerni');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // LinkedIn url setting.
    $name = 'theme_solerni/linkedin';
    $title = get_string('linkedin', 'theme_solerni');
    $description = get_string('linkedindesc', 'theme_solerni');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Pinterest url setting.
    $name = 'theme_solerni/pinterest';
    $title = get_string('pinterest', 'theme_solerni');
    $description = get_string('pinterestdesc', 'theme_solerni');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Instagram url setting.
    $name = 'theme_solerni/instagram';
    $title = get_string('instagram', 'theme_solerni');
    $description = get_string('instagramdesc', 'theme_solerni');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // YouTube url setting.
    $name = 'theme_solerni/youtube';
    $title = get_string('youtube', 'theme_solerni');
    $description = get_string('youtubedesc', 'theme_solerni');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Skype url setting.
    $name = 'theme_solerni/skype';
    $title = get_string('skype', 'theme_solerni');
    $description = get_string('skypedesc', 'theme_solerni');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // VKontakte url setting.
    $name = 'theme_solerni/vk';
    $title = get_string('vk', 'theme_solerni');
    $description = get_string('vkdesc', 'theme_solerni');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    /* Apps Settings */
    $temp->add(new admin_setting_heading('theme_solerni_mobileapps', get_string('mobileappsheadingsub', 'theme_solerni'),
        format_text(get_string('mobileappsdesc', 'theme_solerni'), FORMAT_MARKDOWN)));

    // Android App url setting.
    $name = 'theme_solerni/android';
    $title = get_string('android', 'theme_solerni');
    $description = get_string('androiddesc', 'theme_solerni');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Windows App url setting.
    $name = 'theme_solerni/windows';
    $title = get_string('windows', 'theme_solerni');
    $description = get_string('windowsdesc', 'theme_solerni');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Windows PhoneApp url setting.
    $name = 'theme_solerni/winphone';
    $title = get_string('winphone', 'theme_solerni');
    $description = get_string('winphonedesc', 'theme_solerni');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // iOS App url setting.
    $name = 'theme_solerni/ios';
    $title = get_string('ios', 'theme_solerni');
    $description = get_string('iosdesc', 'theme_solerni');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // This is the descriptor for iOS Icons
    $name = 'theme_solerni/iosiconinfo';
    $heading = get_string('iosicon', 'theme_solerni');
    $information = get_string('iosicondesc', 'theme_solerni');
    $setting = new admin_setting_heading($name, $heading, $information);
    $temp->add($setting);

    // iPhone Icon.
    $name = 'theme_solerni/iphoneicon';
    $title = get_string('iphoneicon', 'theme_solerni');
    $description = get_string('iphoneicondesc', 'theme_solerni');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'iphoneicon');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // iPhone Retina Icon.
    $name = 'theme_solerni/iphoneretinaicon';
    $title = get_string('iphoneretinaicon', 'theme_solerni');
    $description = get_string('iphoneretinaicondesc', 'theme_solerni');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'iphoneretinaicon');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // iPad Icon.
    $name = 'theme_solerni/ipadicon';
    $title = get_string('ipadicon', 'theme_solerni');
    $description = get_string('ipadicondesc', 'theme_solerni');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'ipadicon');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // iPad Retina Icon.
    $name = 'theme_solerni/ipadretinaicon';
    $title = get_string('ipadretinaicon', 'theme_solerni');
    $description = get_string('ipadretinaicondesc', 'theme_solerni');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'ipadretinaicon');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $ADMIN->add('theme_solerni', $temp);


    /* Font Settings */
    $temp = new admin_settingpage('theme_solerni_font', get_string('fontsettings', 'theme_solerni'));
    // This is the descriptor for the font settings
    $name = 'theme_solerni/fontheading';
    $heading = get_string('fontheadingsub', 'theme_solerni');
    $information = get_string('fontheadingdesc', 'theme_solerni');
    $setting = new admin_setting_heading($name, $heading, $information);
    $temp->add($setting);

    // Font Selector.
    $name = 'theme_solerni/fontselect';
    $title = get_string('fontselect', 'theme_solerni');
    $description = get_string('fontselectdesc', 'theme_solerni');
    $default = 1;
    $choices = array(
        1 => get_string('fonttypestandard', 'theme_solerni'),
        2 => get_string('fonttypegoogle', 'theme_solerni'),
        3 => get_string('fonttypecustom', 'theme_solerni'),
    );
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Heading font name
    $name = 'theme_solerni/fontnameheading';
    $title = get_string('fontnameheading', 'theme_solerni');
    $description = get_string('fontnameheadingdesc', 'theme_solerni');
    $default = 'Verdana';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Text font name
    $name = 'theme_solerni/fontnamebody';
    $title = get_string('fontnamebody', 'theme_solerni');
    $description = get_string('fontnamebodydesc', 'theme_solerni');
    $default = 'Verdana';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    if(get_config('theme_solerni', 'fontselect') === "2") {
        // Google Font Character Sets
        $name = 'theme_solerni/fontcharacterset';
        $title = get_string('fontcharacterset', 'theme_solerni');
        $description = get_string('fontcharactersetdesc', 'theme_solerni');
        $default = 'latin-ext';
        $setting = new admin_setting_configmulticheckbox($name, $title, $description, $default, array(
            'latin-ext' => get_string('fontcharactersetlatinext', 'theme_solerni'),
            'cyrillic' => get_string('fontcharactersetcyrillic', 'theme_solerni'),
            'cyrillic-ext' => get_string('fontcharactersetcyrillicext', 'theme_solerni'),
            'greek' => get_string('fontcharactersetgreek', 'theme_solerni'),
            'greek-ext' => get_string('fontcharactersetgreekext', 'theme_solerni'),
            'vietnamese' => get_string('fontcharactersetvietnamese', 'theme_solerni'),
        ));
        $setting->set_updatedcallback('theme_reset_all_caches');
        $temp->add($setting);

    } else if(get_config('theme_solerni', 'fontselect') === "3") {

        // This is the descriptor for the font files
        $name = 'theme_solerni/fontfiles';
        $heading = get_string('fontfiles', 'theme_solerni');
        $information = get_string('fontfilesdesc', 'theme_solerni');
        $setting = new admin_setting_heading($name, $heading, $information);
        $temp->add($setting);

        // Heading Fonts.
        // TTF Font.
        $name = 'theme_solerni/fontfilettfheading';
        $title = get_string('fontfilettfheading', 'theme_solerni');
        $description = '';
        $setting = new admin_setting_configstoredfile($name, $title, $description, 'fontfilettfheading');
        $setting->set_updatedcallback('theme_reset_all_caches');
        $temp->add($setting);

        // OTF Font.
        $name = 'theme_solerni/fontfileotfheading';
        $title = get_string('fontfileotfheading', 'theme_solerni');
        $description = '';
        $setting = new admin_setting_configstoredfile($name, $title, $description, 'fontfileotfheading');
        $setting->set_updatedcallback('theme_reset_all_caches');
        $temp->add($setting);

        // WOFF Font.
        $name = 'theme_solerni/fontfilewoffheading';
        $title = get_string('fontfilewoffheading', 'theme_solerni');
        $description = '';
        $setting = new admin_setting_configstoredfile($name, $title, $description, 'fontfilewoffheading');
        $setting->set_updatedcallback('theme_reset_all_caches');
        $temp->add($setting);

        // WOFF2 Font.
        $name = 'theme_solerni/fontfilewofftwoheading';
        $title = get_string('fontfilewofftwoheading', 'theme_solerni');
        $description = '';
        $setting = new admin_setting_configstoredfile($name, $title, $description, 'fontfilewofftwoheading');
        $setting->set_updatedcallback('theme_reset_all_caches');
        $temp->add($setting);

        // EOT Font.
        $name = 'theme_solerni/fontfileeotheading';
        $title = get_string('fontfileeotheading', 'theme_solerni');
        $description = '';
        $setting = new admin_setting_configstoredfile($name, $title, $description, 'fontfileweotheading');
        $setting->set_updatedcallback('theme_reset_all_caches');
        $temp->add($setting);

        // SVG Font.
        $name = 'theme_solerni/fontfilesvgheading';
        $title = get_string('fontfilesvgheading', 'theme_solerni');
        $description = '';
        $setting = new admin_setting_configstoredfile($name, $title, $description, 'fontfilesvgheading');
        $setting->set_updatedcallback('theme_reset_all_caches');
        $temp->add($setting);

        // Body fonts.
        // TTF Font.
        $name = 'theme_solerni/fontfilettfbody';
        $title = get_string('fontfilettfbody', 'theme_solerni');
        $description = '';
        $setting = new admin_setting_configstoredfile($name, $title, $description, 'fontfilettfbody');
        $setting->set_updatedcallback('theme_reset_all_caches');
        $temp->add($setting);

        // OTF Font.
        $name = 'theme_solerni/fontfileotfbody';
        $title = get_string('fontfileotfbody', 'theme_solerni');
        $description = '';
        $setting = new admin_setting_configstoredfile($name, $title, $description, 'fontfileotfbody');
        $setting->set_updatedcallback('theme_reset_all_caches');
        $temp->add($setting);

        // WOFF Font.
        $name = 'theme_solerni/fontfilewoffbody';
        $title = get_string('fontfilewoffbody', 'theme_solerni');
        $description = '';
        $setting = new admin_setting_configstoredfile($name, $title, $description, 'fontfilewoffbody');
        $setting->set_updatedcallback('theme_reset_all_caches');
        $temp->add($setting);

        // WOFF2 Font.
        $name = 'theme_solerni/fontfilewofftwobody';
        $title = get_string('fontfilewofftwobody', 'theme_solerni');
        $description = '';
        $setting = new admin_setting_configstoredfile($name, $title, $description, 'fontfilewofftwobody');
        $setting->set_updatedcallback('theme_reset_all_caches');
        $temp->add($setting);

        // EOT Font.
        $name = 'theme_solerni/fontfileeotbody';
        $title = get_string('fontfileeotbody', 'theme_solerni');
        $description = '';
        $setting = new admin_setting_configstoredfile($name, $title, $description, 'fontfileweotbody');
        $setting->set_updatedcallback('theme_reset_all_caches');
        $temp->add($setting);

        // SVG Font.
        $name = 'theme_solerni/fontfilesvgbody';
        $title = get_string('fontfilesvgbody', 'theme_solerni');
        $description = '';
        $setting = new admin_setting_configstoredfile($name, $title, $description, 'fontfilesvgbody');
        $setting->set_updatedcallback('theme_reset_all_caches');
        $temp->add($setting);
    }

    // Include Awesome Font from Bootstrapcdn
    $name = 'theme_solerni/bootstrapcdn';
    $title = get_string('bootstrapcdn', 'theme_solerni');
    $description = get_string('bootstrapcdndesc', 'theme_solerni');
    $setting = new admin_setting_configcheckbox($name, $title, $description, 0);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $ADMIN->add('theme_solerni', $temp);


    /* Footer Settings */
    $temp = new admin_settingpage('theme_solerni_footer', get_string('footerheading', 'theme_solerni'));

    // Copyright setting.
    $name = 'theme_solerni/copyright';
    $title = get_string('copyright', 'theme_solerni');
    $description = get_string('copyrightdesc', 'theme_solerni');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $temp->add($setting);

    // Footnote setting.
    $name = 'theme_solerni/footnote';
    $title = get_string('footnote', 'theme_solerni');
    $description = get_string('footnotedesc', 'theme_solerni');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Performance Information Display.
    $name = 'theme_solerni/perfinfo';
    $title = get_string('perfinfo', 'theme_solerni');
    $description = get_string('perfinfodesc', 'theme_solerni');
    $perf_max = get_string('perf_max', 'theme_solerni');
    $perf_min = get_string('perf_min', 'theme_solerni');
    $default = 'min';
    $choices = array('min' => $perf_min, 'max' => $perf_max);
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $ADMIN->add('theme_solerni', $temp);

    $temp = new admin_settingpage('theme_solerni_frontpage', get_string('frontpageheading', 'theme_solerni'));

    $name = 'theme_solerni/courselistteachericon';
    $title = get_string('courselistteachericon', 'theme_solerni');
    $description = get_string('courselistteachericondesc', 'theme_solerni');
    $default = 'graduation-cap';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $temp->add(new admin_setting_heading('theme_solerni_frontcontent', get_string('frontcontentheading', 'theme_solerni'),
        ''));

    // Toggle Frontpage Content.
    $name = 'theme_solerni/togglefrontcontent';
    $title = get_string('frontcontent', 'theme_solerni');
    $description = get_string('frontcontentdesc', 'theme_solerni');
    $alwaysdisplay = get_string('alwaysdisplay', 'theme_solerni');
    $displaybeforelogin = get_string('displaybeforelogin', 'theme_solerni');
    $displayafterlogin = get_string('displayafterlogin', 'theme_solerni');
    $dontdisplay = get_string('dontdisplay', 'theme_solerni');
    $default = 0;
    $choices = array(1 => $alwaysdisplay, 2 => $displaybeforelogin, 3 => $displayafterlogin, 0 => $dontdisplay);
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Frontpage Content
    $name = 'theme_solerni/frontcontentarea';
    $title = get_string('frontcontentarea', 'theme_solerni');
    $description = get_string('frontcontentareadesc', 'theme_solerni');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_solerni_frontpageblocksheading';
    $heading = get_string('frontpageblocksheading', 'theme_solerni');
    $information = '';
    $setting = new admin_setting_heading($name, $heading, $information);
    $temp->add($setting);

    // Frontpage Block alignment.
    $name = 'theme_solerni/frontpageblocks';
    $title = get_string('frontpageblocks', 'theme_solerni');
    $description = get_string('frontpageblocksdesc', 'theme_solerni');
    $left = get_string('left', 'theme_solerni');
    $right = get_string('right', 'theme_solerni');
    $default = 1;
    $choices = array(1 => $left, 0 => $right);
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Toggle Frontpage Middle Blocks
    $name = 'theme_solerni/frontpagemiddleblocks';
    $title = get_string('frontpagemiddleblocks', 'theme_solerni');
    $description = get_string('frontpagemiddleblocksdesc', 'theme_solerni');
    $alwaysdisplay = get_string('alwaysdisplay', 'theme_solerni');
    $displaybeforelogin = get_string('displaybeforelogin', 'theme_solerni');
    $displayafterlogin = get_string('displayafterlogin', 'theme_solerni');
    $dontdisplay = get_string('dontdisplay', 'theme_solerni');
    $default = 0;
    $choices = array(1 => $alwaysdisplay, 2 => $displaybeforelogin, 3 => $displayafterlogin, 0 => $dontdisplay);
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);


    /* Marketing Spot Settings */
    $temp->add(new admin_setting_heading('theme_solerni_marketing', get_string('marketingheadingsub', 'theme_solerni'),
        format_text(get_string('marketingdesc', 'theme_solerni'), FORMAT_MARKDOWN)));

    // Toggle Marketing Spots.
    $name = 'theme_solerni/togglemarketing';
    $title = get_string('togglemarketing', 'theme_solerni');
    $description = get_string('togglemarketingdesc', 'theme_solerni');
    $alwaysdisplay = get_string('alwaysdisplay', 'theme_solerni');
    $displaybeforelogin = get_string('displaybeforelogin', 'theme_solerni');
    $displayafterlogin = get_string('displayafterlogin', 'theme_solerni');
    $dontdisplay = get_string('dontdisplay', 'theme_solerni');
    $default = 1;
    $choices = array(1 => $alwaysdisplay, 2 => $displaybeforelogin, 3 => $displayafterlogin, 0 => $dontdisplay);
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Marketing Spot Image Height.
    $name = 'theme_solerni/marketingheight';
    $title = get_string('marketingheight', 'theme_solerni');
    $description = get_string('marketingheightdesc', 'theme_solerni');
    $default = 100;
    $choices = array(50 => '50', 100 => '100', 150 => '150', 200 => '200', 250 => '250', 300 => '300');
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $temp->add($setting);

    // This is the descriptor for Marketing Spot One.
    $name = 'theme_solerni/marketing1info';
    $heading = get_string('marketing1', 'theme_solerni');
    $information = get_string('marketinginfodesc', 'theme_solerni');
    $setting = new admin_setting_heading($name, $heading, $information);
    $temp->add($setting);

    // Marketing Spot One.
    $name = 'theme_solerni/marketing1';
    $title = get_string('marketingtitle', 'theme_solerni');
    $description = get_string('marketingtitledesc', 'theme_solerni');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_solerni/marketing1icon';
    $title = get_string('marketingicon', 'theme_solerni');
    $description = get_string('marketingicondesc', 'theme_solerni');
    $default = 'star';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_solerni/marketing1image';
    $title = get_string('marketingimage', 'theme_solerni');
    $description = get_string('marketingimagedesc', 'theme_solerni');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'marketing1image');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_solerni/marketing1content';
    $title = get_string('marketingcontent', 'theme_solerni');
    $description = get_string('marketingcontentdesc', 'theme_solerni');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_solerni/marketing1buttontext';
    $title = get_string('marketingbuttontext', 'theme_solerni');
    $description = get_string('marketingbuttontextdesc', 'theme_solerni');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_solerni/marketing1buttonurl';
    $title = get_string('marketingbuttonurl', 'theme_solerni');
    $description = get_string('marketingbuttonurldesc', 'theme_solerni');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, '', PARAM_URL);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_solerni/marketing1target';
    $title = get_string('marketingurltarget', 'theme_solerni');
    $description = get_string('marketingurltargetdesc', 'theme_solerni');
    $target1 = get_string('marketingurltargetself', 'theme_solerni');
    $target2 = get_string('marketingurltargetnew', 'theme_solerni');
    $target3 = get_string('marketingurltargetparent', 'theme_solerni');
    $default = '_blank';
    $choices = array('_self' => $target1, '_blank' => $target2, '_parent' => $target3);
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // This is the descriptor for Marketing Spot Two.
    $name = 'theme_solerni/marketing2info';
    $heading = get_string('marketing2', 'theme_solerni');
    $information = get_string('marketinginfodesc', 'theme_solerni');
    $setting = new admin_setting_heading($name, $heading, $information);
    $temp->add($setting);

    // Marketing Spot Two.
    $name = 'theme_solerni/marketing2';
    $title = get_string('marketingtitle', 'theme_solerni');
    $description = get_string('marketingtitledesc', 'theme_solerni');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_solerni/marketing2icon';
    $title = get_string('marketingicon', 'theme_solerni');
    $description = get_string('marketingicondesc', 'theme_solerni');
    $default = 'star';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_solerni/marketing2image';
    $title = get_string('marketingimage', 'theme_solerni');
    $description = get_string('marketingimagedesc', 'theme_solerni');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'marketing2image');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_solerni/marketing2content';
    $title = get_string('marketingcontent', 'theme_solerni');
    $description = get_string('marketingcontentdesc', 'theme_solerni');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_solerni/marketing2buttontext';
    $title = get_string('marketingbuttontext', 'theme_solerni');
    $description = get_string('marketingbuttontextdesc', 'theme_solerni');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_solerni/marketing2buttonurl';
    $title = get_string('marketingbuttonurl', 'theme_solerni');
    $description = get_string('marketingbuttonurldesc', 'theme_solerni');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, '', PARAM_URL);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_solerni/marketing2target';
    $title = get_string('marketingurltarget', 'theme_solerni');
    $description = get_string('marketingurltargetdesc', 'theme_solerni');
    $target1 = get_string('marketingurltargetself', 'theme_solerni');
    $target2 = get_string('marketingurltargetnew', 'theme_solerni');
    $target3 = get_string('marketingurltargetparent', 'theme_solerni');
    $default = '_blank';
    $choices = array('_self' => $target1, '_blank' => $target2, '_parent' => $target3);
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // This is the descriptor for Marketing Spot Three
    $name = 'theme_solerni/marketing3info';
    $heading = get_string('marketing3', 'theme_solerni');
    $information = get_string('marketinginfodesc', 'theme_solerni');
    $setting = new admin_setting_heading($name, $heading, $information);
    $temp->add($setting);

    // Marketing Spot Three.
    $name = 'theme_solerni/marketing3';
    $title = get_string('marketingtitle', 'theme_solerni');
    $description = get_string('marketingtitledesc', 'theme_solerni');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_solerni/marketing3icon';
    $title = get_string('marketingicon', 'theme_solerni');
    $description = get_string('marketingicondesc', 'theme_solerni');
    $default = 'star';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_solerni/marketing3image';
    $title = get_string('marketingimage', 'theme_solerni');
    $description = get_string('marketingimagedesc', 'theme_solerni');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'marketing3image');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_solerni/marketing3content';
    $title = get_string('marketingcontent', 'theme_solerni');
    $description = get_string('marketingcontentdesc', 'theme_solerni');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_solerni/marketing3buttontext';
    $title = get_string('marketingbuttontext', 'theme_solerni');
    $description = get_string('marketingbuttontextdesc', 'theme_solerni');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_solerni/marketing3buttonurl';
    $title = get_string('marketingbuttonurl', 'theme_solerni');
    $description = get_string('marketingbuttonurldesc', 'theme_solerni');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, '', PARAM_URL);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $name = 'theme_solerni/marketing3target';
    $title = get_string('marketingurltarget', 'theme_solerni');
    $description = get_string('marketingurltargetdesc', 'theme_solerni');
    $target1 = get_string('marketingurltargetself', 'theme_solerni');
    $target2 = get_string('marketingurltargetnew', 'theme_solerni');
    $target3 = get_string('marketingurltargetparent', 'theme_solerni');
    $default = '_blank';
    $choices = array('_self' => $target1, '_blank' => $target2, '_parent' => $target3);
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    /* User Alerts */
    $temp->add(new admin_setting_heading('theme_solerni_alerts', get_string('alertsheadingsub', 'theme_solerni'),
        format_text(get_string('alertsdesc', 'theme_solerni'), FORMAT_MARKDOWN)));

    $information = get_string('alertinfodesc', 'theme_solerni');

    // This is the descriptor for Alert One
    $name = 'theme_solerni/alert1info';
    $heading = get_string('alert1', 'theme_solerni');
    $setting = new admin_setting_heading($name, $heading, $information);
    $temp->add($setting);

    // Enable Alert
    $name = 'theme_solerni/enable1alert';
    $title = get_string('enablealert', 'theme_solerni');
    $description = get_string('enablealertdesc', 'theme_solerni');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Alert Type.
    $name = 'theme_solerni/alert1type';
    $title = get_string('alerttype', 'theme_solerni');
    $description = get_string('alerttypedesc', 'theme_solerni');
    $alert_info = get_string('alert_info', 'theme_solerni');
    $alert_warning = get_string('alert_warning', 'theme_solerni');
    $alert_general = get_string('alert_general', 'theme_solerni');
    $default = 'info';
    $choices = array('info' => $alert_info, 'error' => $alert_warning, 'success' => $alert_general);
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Alert Title.
    $name = 'theme_solerni/alert1title';
    $title = get_string('alerttitle', 'theme_solerni');
    $description = get_string('alerttitledesc', 'theme_solerni');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Alert Text.
    $name = 'theme_solerni/alert1text';
    $title = get_string('alerttext', 'theme_solerni');
    $description = get_string('alerttextdesc', 'theme_solerni');
    $default = '';
    $setting = new admin_setting_configtextarea($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // This is the descriptor for Alert Two
    $name = 'theme_solerni/alert2info';
    $heading = get_string('alert2', 'theme_solerni');
    $setting = new admin_setting_heading($name, $heading, $information);
    $temp->add($setting);

    // Enable Alert
    $name = 'theme_solerni/enable2alert';
    $title = get_string('enablealert', 'theme_solerni');
    $description = get_string('enablealertdesc', 'theme_solerni');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Alert Type.
    $name = 'theme_solerni/alert2type';
    $title = get_string('alerttype', 'theme_solerni');
    $description = get_string('alerttypedesc', 'theme_solerni');
    $alert_info = get_string('alert_info', 'theme_solerni');
    $alert_warning = get_string('alert_warning', 'theme_solerni');
    $alert_general = get_string('alert_general', 'theme_solerni');
    $default = 'info';
    $choices = array('info' => $alert_info, 'error' => $alert_warning, 'success' => $alert_general);
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Alert Title.
    $name = 'theme_solerni/alert2title';
    $title = get_string('alerttitle', 'theme_solerni');
    $description = get_string('alerttitledesc', 'theme_solerni');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Alert Text.
    $name = 'theme_solerni/alert2text';
    $title = get_string('alerttext', 'theme_solerni');
    $description = get_string('alerttextdesc', 'theme_solerni');
    $default = '';
    $setting = new admin_setting_configtextarea($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // This is the descriptor for Alert Three
    $name = 'theme_solerni/alert3info';
    $heading = get_string('alert3', 'theme_solerni');
    $setting = new admin_setting_heading($name, $heading, $information);
    $temp->add($setting);

    // Enable Alert
    $name = 'theme_solerni/enable3alert';
    $title = get_string('enablealert', 'theme_solerni');
    $description = get_string('enablealertdesc', 'theme_solerni');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Alert Type.
    $name = 'theme_solerni/alert3type';
    $title = get_string('alerttype', 'theme_solerni');
    $description = get_string('alerttypedesc', 'theme_solerni');
    $alert_info = get_string('alert_info', 'theme_solerni');
    $alert_warning = get_string('alert_warning', 'theme_solerni');
    $alert_general = get_string('alert_general', 'theme_solerni');
    $default = 'info';
    $choices = array('info' => $alert_info, 'error' => $alert_warning, 'success' => $alert_general);
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Alert Title.
    $name = 'theme_solerni/alert3title';
    $title = get_string('alerttitle', 'theme_solerni');
    $description = get_string('alerttitledesc', 'theme_solerni');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Alert Text.
    $name = 'theme_solerni/alert3text';
    $title = get_string('alerttext', 'theme_solerni');
    $description = get_string('alerttextdesc', 'theme_solerni');
    $default = '';
    $setting = new admin_setting_configtextarea($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $ADMIN->add('theme_solerni', $temp);

    /* Slideshow Widget Settings */
    $temp = new admin_settingpage('theme_solerni_slideshow', get_string('slideshowheading', 'theme_solerni'));
    $temp->add(new admin_setting_heading('theme_solerni_slideshow', get_string('slideshowheadingsub', 'theme_solerni'),
        format_text(get_string('slideshowdesc', 'theme_solerni'), FORMAT_MARKDOWN)));

    // Toggle Slideshow.
    $name = 'theme_solerni/toggleslideshow';
    $title = get_string('toggleslideshow', 'theme_solerni');
    $description = get_string('toggleslideshowdesc', 'theme_solerni');
    $alwaysdisplay = get_string('alwaysdisplay', 'theme_solerni');
    $displaybeforelogin = get_string('displaybeforelogin', 'theme_solerni');
    $displayafterlogin = get_string('displayafterlogin', 'theme_solerni');
    $dontdisplay = get_string('dontdisplay', 'theme_solerni');
    $default = 1;
    $choices = array(1 => $alwaysdisplay, 2 => $displaybeforelogin, 3 => $displayafterlogin, 0 => $dontdisplay);
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Number of slides.
    $name = 'theme_solerni/numberofslides';
    $title = get_string('numberofslides', 'theme_solerni');
    $description = get_string('numberofslides_desc', 'theme_solerni');
    $default = 4;
    $choices = array(
        1 => '1',
        2 => '2',
        3 => '3',
        4 => '4',
        5 => '5',
        6 => '6',
        7 => '7',
        8 => '8',
        9 => '9',
        10 => '10',
        11 => '11',
        12 => '12',
        13 => '13',
        14 => '14',
        15 => '15',
        16 => '16'
    );
    $temp->add(new admin_setting_configselect($name, $title, $description, $default, $choices));

    // Hide slideshow on phones.
    $name = 'theme_solerni/hideontablet';
    $title = get_string('hideontablet', 'theme_solerni');
    $description = get_string('hideontabletdesc', 'theme_solerni');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Hide slideshow on tablet.
    $name = 'theme_solerni/hideonphone';
    $title = get_string('hideonphone', 'theme_solerni');
    $description = get_string('hideonphonedesc', 'theme_solerni');
    $default = true;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Slide interval.
    $name = 'theme_solerni/slideinterval';
    $title = get_string('slideinterval', 'theme_solerni');
    $description = get_string('slideintervaldesc', 'theme_solerni');
    $default = '5000';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Slide Text colour setting.
    $name = 'theme_solerni/slidecolor';
    $title = get_string('slidecolor', 'theme_solerni');
    $description = get_string('slidecolordesc', 'theme_solerni');
    $default = '#ffffff';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Show caption options.
    $name = 'theme_solerni/slidecaptionoptions';
    $title = get_string('slidecaptionoptions', 'theme_solerni');
    $description = get_string('slidecaptionoptionsdesc', 'theme_solerni');
    $default = '0';
    $choices = array(
        0 => get_string('slidecaptionbeside', 'theme_solerni'),
        1 => get_string('slidecaptionontop', 'theme_solerni'),
        2 => get_string('slidecaptionunderneath', 'theme_solerni'),
    );
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Show caption centred.
    $name = 'theme_solerni/slidecaptioncentred';
    $title = get_string('slidecaptioncentred', 'theme_solerni');
    $description = get_string('slidecaptioncentreddesc', 'theme_solerni');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Slide button colour setting.
    $name = 'theme_solerni/slidebuttoncolor';
    $title = get_string('slidebuttoncolor', 'theme_solerni');
    $description = get_string('slidebuttoncolordesc', 'theme_solerni');
    $default = '#30add1';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // Slide button hover colour setting.
    $name = 'theme_solerni/slidebuttonhovercolor';
    $title = get_string('slidebuttonhovercolor', 'theme_solerni');
    $description = get_string('slidebuttonhovercolordesc', 'theme_solerni');
    $default = '#217a94';
    $previewconfig = null;
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    $numberofslides = get_config('theme_solerni', 'numberofslides');
    for ($i = 1; $i <= $numberofslides; $i++) {
        // This is the descriptor for Slide One
        $name = 'theme_solerni/slide' . $i . 'info';
        $heading = get_string('slideno', 'theme_solerni', array('slide' => $i));
        $information = get_string('slidenodesc', 'theme_solerni', array('slide' => $i));
        $setting = new admin_setting_heading($name, $heading, $information);
        $temp->add($setting);

        // Title.
        $name = 'theme_solerni/slide' . $i;
        $title = get_string('slidetitle', 'theme_solerni');
        $description = get_string('slidetitledesc', 'theme_solerni');
        $default = '';
        $setting = new admin_setting_configtext($name, $title, $description, $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $temp->add($setting);

        // Image.
        $name = 'theme_solerni/slide' . $i . 'image';
        $title = get_string('slideimage', 'theme_solerni');
        $description = get_string('slideimagedesc', 'theme_solerni');
        $setting = new admin_setting_configstoredfile($name, $title, $description, 'slide' . $i . 'image');
        $setting->set_updatedcallback('theme_reset_all_caches');
        $temp->add($setting);

        // Caption text.
        $name = 'theme_solerni/slide' . $i . 'caption';
        $title = get_string('slidecaption', 'theme_solerni');
        $description = get_string('slidecaptiondesc', 'theme_solerni');
        $default = '';
        $setting = new admin_setting_configtextarea($name, $title, $description, $default, PARAM_TEXT);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $temp->add($setting);

        // URL.
        $name = 'theme_solerni/slide' . $i . 'url';
        $title = get_string('slideurl', 'theme_solerni');
        $description = get_string('slideurldesc', 'theme_solerni');
        $default = '';
        $setting = new admin_setting_configtext($name, $title, $description, $default, PARAM_URL);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $temp->add($setting);

        // URL target.
        $name = 'theme_solerni/slide' . $i . 'target';
        $title = get_string('slideurltarget', 'theme_solerni');
        $description = get_string('slideurltargetdesc', 'theme_solerni');
        $target1 = get_string('slideurltargetself', 'theme_solerni');
        $target2 = get_string('slideurltargetnew', 'theme_solerni');
        $target3 = get_string('slideurltargetparent', 'theme_solerni');
        $default = '_blank';
        $choices = array('_self' => $target1, '_blank' => $target2, '_parent' => $target3);
        $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $temp->add($setting);
    }

    $ADMIN->add('theme_solerni', $temp);

    /* Category Settings */
    $temp = new admin_settingpage('theme_solerni_categoryicon', get_string('categoryiconheading', 'theme_solerni'));
    $temp->add(new admin_setting_heading('theme_solerni_categoryicon', get_string('categoryiconheadingsub', 'theme_solerni'),
        format_text(get_string('categoryicondesc', 'theme_solerni'), FORMAT_MARKDOWN)));

    // Category Icons.
    $name = 'theme_solerni/enablecategoryicon';
    $title = get_string('enablecategoryicon', 'theme_solerni');
    $description = get_string('enablecategoryicondesc', 'theme_solerni');
    $default = true;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $temp->add($setting);

    // We only want to output category icon options if the parent setting is enabled
    if (get_config('theme_solerni', 'enablecategoryicon')) {

        // Default Icon Selector.
        $name = 'theme_solerni/defaultcategoryicon';
        $title = get_string('defaultcategoryicon', 'theme_solerni');
        $description = get_string('defaultcategoryicondesc', 'theme_solerni');
        $default = 'folder-open';
        $setting = new admin_setting_configtext($name, $title, $description, $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $temp->add($setting);

        // Category Icons.
        $name = 'theme_solerni/enablecustomcategoryicon';
        $title = get_string('enablecustomcategoryicon', 'theme_solerni');
        $description = get_string('enablecustomcategoryicondesc', 'theme_solerni');
        $setting = new admin_setting_configcheckbox($name, $title, $description, 0);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $temp->add($setting);

        if (get_config('theme_solerni', 'enablecustomcategoryicon')) {

            // This is the descriptor for Custom Category Icons
            $name = 'theme_solerni/categoryiconinfo';
            $heading = get_string('categoryiconinfo', 'theme_solerni');
            $information = get_string('categoryiconinfodesc', 'theme_solerni');
            $setting = new admin_setting_heading($name, $heading, $information);
            $temp->add($setting);

            // Get the default category icon.
            $defaultcategoryicon = get_config('theme_solerni', 'defaultcategoryicon');
            if (empty($defaultcategoryicon)) {
                $defaultcategoryicon = 'folder-open';
            }

            // Get all category IDs and their pretty names
            require_once($CFG->libdir . '/coursecatlib.php');
            $coursecats = coursecat::make_categories_list();

            // Go through all categories and create the necessary settings
            foreach ($coursecats as $key => $value) {

                // Category Icons for each category.
                $name = 'theme_solerni/categoryicon';
                $title = $value;
                $description = get_string('categoryiconcategory', 'theme_solerni', array('category' => $value));
                $default = $defaultcategoryicon;
                $setting = new admin_setting_configtext($name . $key, $title, $description, $default);
                $setting->set_updatedcallback('theme_reset_all_caches');
                $temp->add($setting);
            }
            unset($coursecats);
        }
    }

    $ADMIN->add('theme_solerni', $temp);

    /* Analytics Settings */
    $temp = new admin_settingpage('theme_solerni_analytics', get_string('analytics', 'theme_solerni'));
    $temp->add(new admin_setting_heading('theme_solerni_analytics', get_string('analyticsheadingsub', 'theme_solerni'),
        format_text(get_string('analyticsdesc', 'theme_solerni'), FORMAT_MARKDOWN)));

    $name = 'theme_solerni/analyticsenabled';
    $title = get_string('analyticsenabled', 'theme_solerni');
    $description = get_string('analyticsenableddesc', 'theme_solerni');
    $default = true;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $temp->add($setting);

    $name = 'theme_solerni/analytics';
    $title = get_string('analytics', 'theme_solerni');
    $description = get_string('analyticsdesc', 'theme_solerni');
    $guniversal = get_string('analyticsguniversal', 'theme_solerni');
    $piwik = get_string('analyticspiwik', 'theme_solerni');
    $default = 'piwik';
    $choices = array(
        'piwik' => $piwik,
        'guniversal' => $guniversal,
    );
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $temp->add($setting);

    if (get_config('theme_solerni', 'analytics') === 'piwik') {
        $name = 'theme_solerni/analyticssiteid';
        $title = get_string('analyticssiteid', 'theme_solerni');
        $description = get_string('analyticssiteiddesc', 'theme_solerni');
        $default = '1';
        $setting = new admin_setting_configtext($name, $title, $description, $default);
        $temp->add($setting);

        $name = 'theme_solerni/analyticsimagetrack';
        $title = get_string('analyticsimagetrack', 'theme_solerni');
        $description = get_string('analyticsimagetrackdesc', 'theme_solerni');
        $default = true;
        $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
        $temp->add($setting);

        $name = 'theme_solerni/analyticssiteurl';
        $title = get_string('analyticssiteurl', 'theme_solerni');
        $description = get_string('analyticssiteurldesc', 'theme_solerni');
        $default = '';
        $setting = new admin_setting_configtext($name, $title, $description, $default);
        $temp->add($setting);
    } else if (get_config('theme_solerni', 'analytics') === 'guniversal') {
        $name = 'theme_solerni/analyticstrackingid';
        $title = get_string('analyticstrackingid', 'theme_solerni');
        $description = get_string('analyticstrackingiddesc', 'theme_solerni');
        $default = 'UA-XXXXXXXX-X';
        $setting = new admin_setting_configtext($name, $title, $description, $default);
        $temp->add($setting);
    }

    $name = 'theme_solerni/analyticstrackadmin';
    $title = get_string('analyticstrackadmin', 'theme_solerni');
    $description = get_string('analyticstrackadmindesc', 'theme_solerni');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $temp->add($setting);

    $name = 'theme_solerni/analyticscleanurl';
    $title = get_string('analyticscleanurl', 'theme_solerni');
    $description = get_string('analyticscleanurldesc', 'theme_solerni');
    $default = true;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $temp->add($setting);

    $ADMIN->add('theme_solerni', $temp);
}
