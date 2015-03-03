<?php
/**
 * Flexpage Navigation Block
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see http://opensource.org/licenses/gpl-3.0.html.
 *
 * @copyright Copyright (c) 2009 Moodlerooms Inc. (http://www.moodlerooms.com)
 * @license http://opensource.org/licenses/gpl-3.0.html GNU Public License
 * @package block_flexpagenav
 * @author Mark Nielsen
 */

/**
 * @see block_flexpagenav_repository_menu
 */
require_once($CFG->dirroot.'/blocks/flexpagenav/repository/menu.php');

/**
 * Block instance editing form
 *
 * @author Mark Nielsen
 * @package block_flexpagenav
 */
class block_flexpagenav_edit_form extends block_edit_form {
    /**
     * Add block specific configuration elements
     *
     * @param MoodleQuickForm $mform
     */
    protected function specific_definition($mform) {
        global $COURSE;

        $repo    = new block_flexpagenav_repository_menu();
        $menus   = $repo->get_course_menus($COURSE->id);
        $options = array();
        foreach ($menus as $menu) {
            $options[$menu->get_id()] = format_string($menu->get_name());
        }
        $mform->addElement('header', 'configheader', get_string('blocksettings', 'block'));
        $mform->addElement('select', 'config_menuid', get_string('displaymenu', 'block_flexpagenav'), $options);

        $mform->addElement('advcheckbox', 'config_dockable', get_string('dockable', 'block_flexpagenav'));
        $mform->addHelpButton('config_dockable', 'dockable', 'block_flexpagenav');
        $mform->setDefault('config_dockable', '1');
    }
}