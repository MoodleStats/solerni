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
 * Page module admin settings and defaults
 *
 * @package mod
 * @subpackage descriptionpage
 * @copyright  2015 Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {
    require_once("$CFG->libdir/resourcelib.php");

    $displayoptions = resourcelib_get_displayoptions(array(RESOURCELIB_DISPLAY_OPEN, RESOURCELIB_DISPLAY_POPUP));
    $defaultdisplayoptions = array(RESOURCELIB_DISPLAY_OPEN);

    /* -------------------------------------------------------
       // General settings.
       */
    $settings->add(new admin_setting_configcheckbox('descriptionpage/requiremodintro',
        get_string('requiremodintro', 'admin'), get_string('configrequiremodintro', 'admin'), 1));
    $settings->add(new admin_setting_configmultiselect('descriptionpage/displayoptions',
        get_string('displayoptions', 'descriptionpage'), get_string('configdisplayoptions', 'descriptionpage'),
        $defaultdisplayoptions, $displayoptions));

    /*-------------------------------------------------------
       // modedit defaults.
       */
    $modeditdefaults = get_string('modeditdefaults', 'admin');
    $condifmodeditdefaults = get_string('condifmodeditdefaults', 'admin');
    $displayselectexplain = get_string('displayselectexplain', 'descriptionpage');
    $displayselect = get_string('displayselect', 'descriptionpage');
    $settings->add(new admin_setting_heading('pagemodeditdefaults', $modeditdefaults, $condifmodeditdefaults));

    $settings->add(new admin_setting_configcheckbox('descriptionpage/printheading',
        get_string('printheading', 'descriptionpage'), get_string('printheadingexplain', 'descriptionpage'), 1));
    $settings->add(new admin_setting_configcheckbox('descriptionpage/printintro',
        get_string('printintro', 'descriptionpage'), get_string('printintroexplain', 'descriptionpage'), 0));
    $settings->add(new admin_setting_configselect('descriptionpage/display',
        $displayselect, $displayselectexplain, RESOURCELIB_DISPLAY_OPEN, $displayoptions));
    $settings->add(new admin_setting_configtext('descriptionpage/popupwidth',
        get_string('popupwidth', 'descriptionpage'), get_string('popupwidthexplain', 'descriptionpage'), 620, PARAM_INT, 7));
    $settings->add(new admin_setting_configtext('descriptionpage/popupheight',
        get_string('popupheight', 'descriptionpage'), get_string('popupheightexplain', 'descriptionpage'), 450, PARAM_INT, 7));
}
