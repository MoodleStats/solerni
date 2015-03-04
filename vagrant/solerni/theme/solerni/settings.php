<?php

/*
 * @author    Shaun Daubney
 * @package   theme_solerni
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {

    // Basic Heading
    $name = 'theme_solerni/basicheading';
    $heading = get_string('basicheading', 'theme_solerni');
    $information = get_string('basicheadingdesc', 'theme_solerni');
    $setting = new admin_setting_heading($name, $heading, $information);
    $settings->add($setting);
	
	// Logo file setting
	$name = 'theme_solerni/logo';
	$title = get_string('logo','theme_solerni');
	$description = get_string('logodesc', 'theme_solerni');
	$setting = new admin_setting_configtext($name, $title, $description, '', PARAM_URL);
	$settings->add($setting);	

	// Hide Menu
	$name = 'theme_solerni/hidemenu';
	$title = get_string('hidemenu','theme_solerni');
	$description = get_string('hidemenudesc', 'theme_solerni');
	$default = 1;
	$choices = array(1=>get_string('yes',''), 0=>get_string('no',''));
	$setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
	$settings->add($setting);

	// Email url setting
	$name = 'theme_solerni/emailurl';
	$title = get_string('emailurl','theme_solerni');
	$description = get_string('emailurldesc', 'theme_solerni');
	$default = '';
	$setting = new admin_setting_configtext($name, $title, $description, $default);
	$settings->add($setting);

	// Custom CSS file
	$name = 'theme_solerni/customcss';
	$title = get_string('customcss','theme_solerni');
	$description = get_string('customcssdesc', 'theme_solerni');
	$default = '';
	$setting = new admin_setting_configtextarea($name, $title, $description, $default);
	$setting->set_updatedcallback('theme_reset_all_caches');
	$settings->add($setting);

	// Frontpage Heading
    $name = 'theme_solerni/frontpageheading';
    $heading = get_string('frontpageheading', 'theme_solerni');
    $information = get_string('frontpageheadingdesc', 'theme_solerni');
    $setting = new admin_setting_heading($name, $heading, $information);
    $settings->add($setting);

	// Title Date setting
	$name = 'theme_solerni/titledate';
	$title = get_string('titledate','theme_solerni');
	$description = get_string('titledatedesc', 'theme_solerni');
	$default = 1;
	$choices = array(1=>get_string('yes',''), 0=>get_string('no',''));
	$setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
	$settings->add($setting);

	// General Alert setting
	$name = 'theme_solerni/generalalert';
	$title = get_string('generalalert','theme_solerni');
	$description = get_string('generalalertdesc', 'theme_solerni');
	$default = '';
	$setting = new admin_setting_configtext($name, $title, $description, $default);
	$settings->add($setting);

	// Snow Alert setting
	$name = 'theme_solerni/snowalert';
	$title = get_string('snowalert','theme_solerni');
	$description = get_string('snowalertdesc', 'theme_solerni');
	$default = '';
	$setting = new admin_setting_configtext($name, $title, $description, $default);
	$settings->add($setting);

    // Colour Heading
    $name = 'theme_solerni/colourheading';
    $heading = get_string('colourheading', 'theme_solerni');
    $information = get_string('colourheadingdesc', 'theme_solerni');
    $setting = new admin_setting_heading($name, $heading, $information);
    $settings->add($setting);
	
	// Background colour setting
	$name = 'theme_solerni/backcolor';
	$title = get_string('backcolor','theme_solerni');
	$description = get_string('backcolordesc', 'theme_solerni');
	$default = '#fafafa';
	$previewconfig = NULL;
	$setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
	$settings->add($setting);

	// Graphic Wrap (Background Image)
	$name = 'theme_solerni/backimage';
	$title=get_string('backimage','theme_solerni');
	$description = get_string('backimagedesc', 'theme_solerni');
	$default = '';
	$setting = new admin_setting_configtext($name, $title, $description, '', PARAM_URL);
	$settings->add($setting);

	// Graphic Wrap (Background Position)
	$name = 'theme_solerni/backposition';
	$title = get_string('backposition','theme_solerni');
	$description = get_string('backpositiondesc', 'theme_solerni');
	$default = 'no-repeat';
	$choices = array('no-repeat'=>get_string('backpositioncentred','theme_solerni'), 'no-repeat fixed'=>get_string('backpositionfixed','theme_solerni'), 'repeat'=>get_string('backpositiontiled','theme_solerni'), 'repeat-x'=>get_string('backpositionrepeat','theme_solerni'));
	$setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
	$settings->add($setting);

	// Menu hover background colour setting
	$name = 'theme_solerni/menuhovercolor';
	$title = get_string('menuhovercolor','theme_solerni');
	$description = get_string('menuhovercolordesc', 'theme_solerni');
	$default = '#f42941';
	$previewconfig = NULL;
	$setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
	$settings->add($setting);	
	
	// Footer Options Heading
    $name = 'theme_solerni/footeroptheading';
    $heading = get_string('footeroptheading', 'theme_solerni');
    $information = get_string('footeroptdesc', 'theme_solerni');
    $setting = new admin_setting_heading($name, $heading, $information);
    $settings->add($setting);
	
	// Copyright setting
	$name = 'theme_solerni/copyright';
	$title = get_string('copyright','theme_solerni');
	$description = get_string('copyrightdesc', 'theme_solerni');
	$default = '';
	$setting = new admin_setting_configtext($name, $title, $description, $default);
	$settings->add($setting);

	// CEOP
	$name = 'theme_solerni/ceop';
	$title = get_string('ceop','theme_solerni');
	$description = get_string('ceopdesc', 'theme_solerni');
	$default = '';
	$choices = array(''=>get_string('ceopnone','theme_solerni'), 'http://www.thinkuknow.org.au/site/report.asp'=>get_string('ceopaus','theme_solerni'), 'http://www.ceop.police.uk/report-abuse/'=>get_string('ceopuk','theme_solerni'));
	$setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
	$settings->add($setting);

	// Disclaimer setting
	$name = 'theme_solerni/disclaimer';
	$title = get_string('disclaimer','theme_solerni');
	$description = get_string('disclaimerdesc', 'theme_solerni');
	$default = '';
	$setting = new admin_setting_confightmleditor($name, $title, $description, $default);
	$settings->add($setting);	

	// Social Icons Heading
    $name = 'theme_solerni/socialiconsheading';
    $heading = get_string('socialiconsheading', 'theme_solerni');
    $information = get_string('socialiconsheadingdesc', 'theme_solerni');
    $setting = new admin_setting_heading($name, $heading, $information);
    $settings->add($setting);
	
	// Website url setting
	$name = 'theme_solerni/website';
	$title = get_string('website','theme_solerni');
	$description = get_string('websitedesc', 'theme_solerni');
	$default = '';
	$setting = new admin_setting_configtext($name, $title, $description, $default);
	$settings->add($setting);

	// Facebook url setting
	$name = 'theme_solerni/facebook';
	$title = get_string('facebook','theme_solerni');
	$description = get_string('facebookdesc', 'theme_solerni');
	$default = '';
	$setting = new admin_setting_configtext($name, $title, $description, $default);
	$settings->add($setting);

	// Twitter url setting
	$name = 'theme_solerni/twitter';
	$title = get_string('twitter','theme_solerni');
	$description = get_string('twitterdesc', 'theme_solerni');
	$default = '';
	$setting = new admin_setting_configtext($name, $title, $description, $default);
	$settings->add($setting);

	// Google+ url setting
	$name = 'theme_solerni/googleplus';
	$title = get_string('googleplus','theme_solerni');
	$description = get_string('googleplusdesc', 'theme_solerni');
	$default = '';
	$setting = new admin_setting_configtext($name, $title, $description, $default);
	$settings->add($setting);

	// Flickr url setting
	$name = 'theme_solerni/flickr';
	$title = get_string('flickr','theme_solerni');
	$description = get_string('flickrdesc', 'theme_solerni');
	$default = '';
	$setting = new admin_setting_configtext($name, $title, $description, $default);
	$settings->add($setting);

	// Pinterest url setting
	$name = 'theme_solerni/pinterest';
	$title = get_string('pinterest','theme_solerni');
	$description = get_string('pinterestdesc', 'theme_solerni');
	$default = '';
	$setting = new admin_setting_configtext($name, $title, $description, $default);
	$settings->add($setting);

	// Instagram url setting
	$name = 'theme_solerni/instagram';
	$title = get_string('instagram','theme_solerni');
	$description = get_string('instagramdesc', 'theme_solerni');
	$default = '';
	$setting = new admin_setting_configtext($name, $title, $description, $default);
	$settings->add($setting);

	// LinkedIn url setting
	$name = 'theme_solerni/linkedin';
	$title = get_string('linkedin','theme_solerni');
	$description = get_string('linkedindesc', 'theme_solerni');
	$default = '';
	$setting = new admin_setting_configtext($name, $title, $description, $default);
	$settings->add($setting);
	
	// Wikipedia url setting
	$name = 'theme_solerni/wikipedia';
	$title = get_string('wikipedia','theme_solerni');
	$description = get_string('wikipediadesc', 'theme_solerni');
	$default = '';
	$setting = new admin_setting_configtext($name, $title, $description, $default);
	$settings->add($setting);

	// YouTube url setting
	$name = 'theme_solerni/youtube';
	$title = get_string('youtube','theme_solerni');
	$description = get_string('youtubedesc', 'theme_solerni');
	$default = '';
	$setting = new admin_setting_configtext($name, $title, $description, $default);
	$settings->add($setting);

	// Apple url setting
	$name = 'theme_solerni/apple';
	$title = get_string('apple','theme_solerni');
	$description = get_string('appledesc', 'theme_solerni');
	$default = '';
	$setting = new admin_setting_configtext($name, $title, $description, $default);
	$settings->add($setting);

	// Android url setting
	$name = 'theme_solerni/android';
	$title = get_string('android','theme_solerni');
	$description = get_string('androiddesc', 'theme_solerni');
	$default = '';
	$setting = new admin_setting_configtext($name, $title, $description, $default);
	$settings->add($setting);

}

