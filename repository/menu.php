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
 * @see block_flexpagenav_model_menu
 */
require_once($CFG->dirroot.'/blocks/flexpagenav/model/menu.php');

/**
 * Repository mapper for block_flexpagenav_model_menu
 *
 * @author Mark Nielsen
 * @package block_flexpagenav
 */
class block_flexpagenav_repository_menu {

    protected function to_model(stdClass $data) {
        $menu = new block_flexpagenav_model_menu();

        return $menu->set_id($data->id)
                    ->set_couseid($data->courseid)
                    ->set_name($data->name)
                    ->set_render($data->render)
                    ->set_displayname($data->displayname)
                    ->set_useastab($data->useastab);
    }

    /**
     * @param int $id
     * @return block_flexpagenav_model_menu
     */
    public function get_menu($id) {
        global $DB;

        return $this->to_model(
            $DB->get_record('block_flexpagenav_menu', array('id' => $id), '*', MUST_EXIST)
        );
    }

    /**
     * @param int $courseid
     * @param string $sort
     * @return block_flexpagenav_model_menu[]
     */
    public function get_course_menus($courseid, $sort = 'name') {
        global $DB;

        $menus   = array();
        $records = $DB->get_recordset('block_flexpagenav_menu', array('courseid' => $courseid), $sort);
        foreach ($records as $record) {
            $menus[$record->id] = $this->to_model($record);
        }
        $records->close();

        return $menus;
    }

    /**
     * Get the menu that is used as the course's tabs
     *
     * @param int $courseid
     * @return block_flexpagenav_model_menu|bool
     */
    public function get_course_tab_menu($courseid) {
        global $DB;

        $menu    = false;
        $records = $DB->get_recordset('block_flexpagenav_menu', array('courseid' => $courseid, 'useastab' => 1));
        foreach ($records as $record) {
            $menu = $this->to_model($record);
            break;
        }
        $records->close();

        return $menu;
    }

    /**
     * @param block_flexpagenav_model_menu $menu
     * @return block_flexpagenav_repository_menu
     */
    public function save_menu(block_flexpagenav_model_menu $menu) {
        global $DB;

        $record = array(
            'courseid' => $menu->get_couseid(),
            'name' => $menu->get_name(),
            'render' => $menu->get_render(),
            'displayname' => $menu->get_displayname(),
            'useastab' => $menu->get_useastab(),
        );

        $id = $menu->get_id();
        if (!empty($id)) {
            $record['id'] = $id;
            $DB->update_record('block_flexpagenav_menu', $record);
        } else {
            $menu->set_id(
                $DB->insert_record('block_flexpagenav_menu', $record)
            );
        }
        // Only one can have this flag
        if ($menu->get_useastab()) {
            $DB->set_field_select('block_flexpagenav_menu', 'useastab', 0, 'id != ? AND courseid = ?', array($menu->get_id(), $menu->get_couseid()));
        }
        return $this;
    }

    /**
     * @param block_flexpagenav_model_menu $menu
     * @return void
     */
    public function delete_menu(block_flexpagenav_model_menu $menu) {
        global $DB;

        $instances = $DB->get_recordset_sql("
            SELECT i.*
              FROM {block_instances} i
        INNER JOIN {block_flexpagenav} f ON i.id = f.instanceid
             WHERE f.menuid = ?
        ", array($menu->get_id()));

        foreach ($instances as $instance) {
            blocks_delete_instance($instance, true);
        }
        $instances->close();

        $DB->execute('
            DELETE c
              FROM {block_flexpagenav_link} l
        INNER JOIN {block_flexpagenav_config} c ON l.id = c.linkid
             WHERE l.menuid = ?
        ', array($menu->get_id()));

        $DB->delete_records('block_flexpagenav_link', array('menuid' => $menu->get_id()));
        $DB->delete_records('block_flexpagenav_menu', array('id' => $menu->get_id()));

        $menu->set_id(null)
             ->set_links(array());
    }

    /**
     * @param int $courseid
     * @return void
     */
    public function delete_course_menus($courseid) {
        global $DB;

        $DB->execute('
            DELETE FROM {block_flexpagenav_config}
                  WHERE linkid IN (
                 SELECT l.id
                   FROM {block_flexpagenav_menu} m
                   JOIN {block_flexpagenav_link} l ON m.id = l.menuid
                  WHERE m.courseid = ?)
        ', array($courseid));

        $DB->execute('
            DELETE FROM {block_flexpagenav_link}
                  WHERE menuid IN (SELECT id FROM {block_flexpagenav_menu} WHERE courseid = ?)
        ', array($courseid));

        $DB->delete_records('block_flexpagenav_menu', array('courseid' => $courseid));
    }
}