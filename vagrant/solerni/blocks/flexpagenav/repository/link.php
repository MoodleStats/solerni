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
 * @see block_flexpagenav_model_link
 */
require_once($CFG->dirroot.'/blocks/flexpagenav/model/link.php');

/**
 * @see block_flexpagenav_model_link
 */
require_once($CFG->dirroot.'/blocks/flexpagenav/model/link/config.php');

/**
 * Repository mapper for block_flexpagenav_model_link and block_flexpagenav_model_link_config
 *
 * @author Mark Nielsen
 * @package block_flexpagenav
 */
class block_flexpagenav_repository_link {

    protected function to_link_model(stdClass $data) {

        $link = new block_flexpagenav_model_link();

        return $link->set_id($data->id)
                    ->set_menuid($data->menuid)
                    ->set_type($data->type)
                    ->set_weight($data->weight);
    }

    protected function to_link_config_model(stdClass $data) {

        $config = new block_flexpagenav_model_link_config();

        return $config->set_id($data->id)
                      ->set_linkid($data->linkid)
                      ->set_name($data->name)
                      ->set_value($data->value);
    }

    /**
     * @param int $id
     * @return block_flexpagenav_model_link
     */
    public function get_link($id) {
        global $DB;

        return $this->to_link_model(
            $DB->get_record('block_flexpagenav_link', array('id' => $id), '*', MUST_EXIST)
        );
    }

    /**
     * @param block_flexpagenav_model_link $link
     * @return block_flexpagenav_model_link_config[]
     */
    public function get_link_configs(block_flexpagenav_model_link $link) {
        global $DB;

        $configs = array();
        $records = $DB->get_recordset('block_flexpagenav_config', array('linkid' => $link->get_id()));
        foreach ($records as $record) {
            $configs[$record->id] = $this->to_link_config_model($record);
        }
        return $configs;
    }

    /**
     * @param block_flexpagenav_model_link $link
     * @return void
     */
    public function set_link_configs(block_flexpagenav_model_link $link) {
        $link->set_configs($this->get_link_configs($link));
    }

    /**
     * Get all links for a menu with their configs
     *
     * @param block_flexpagenav_model_menu $menu
     * @return block_flexpagenav_model_link[]
     */
    public function get_menu_links(block_flexpagenav_model_menu $menu) {
        global $DB;

        $links   = array();
        $records = $DB->get_recordset('block_flexpagenav_link', array('menuid' => $menu->get_id()), 'weight');
        foreach ($records as $record) {
            $links[$record->id] = $this->to_link_model($record);
        }

        // Bulk populate configs
        $records = $DB->get_recordset_sql('
            SELECT c.*
              FROM {block_flexpagenav_link} l
        INNER JOIN {block_flexpagenav_config} c ON l.id = c.linkid
             WHERE l.menuid = ?', array($menu->get_id()));

        foreach ($records as $record) {
            if (!array_key_exists($record->linkid, $links)) {
                continue;  // Prevent a bad life
            }
            $links[$record->linkid]->add_config($this->to_link_config_model($record));
        }
        return $links;
    }

    /**
     * Get all links for a menu with their configs and set to the passed menu
     *
     * @param block_flexpagenav_model_menu $menu
     * @return void
     */
    public function set_menu_links(block_flexpagenav_model_menu $menu) {
        $menu->set_links($this->get_menu_links($menu));
    }

    /**
     * @param block_flexpagenav_model_link $link
     * @return block_flexpagenav_repository_link
     */
    public function save_link(block_flexpagenav_model_link $link) {
        global $DB;

        $record = array(
            'menuid' => $link->get_menuid(),
            'type' => $link->get_type(),
            'weight' => $link->get_weight(),
        );

        $id = $link->get_id();
        if (!empty($id)) {
            $record['id'] = $id;
            $DB->update_record('block_flexpagenav_link', $record);
        } else {
            $link->set_id(
                $DB->insert_record('block_flexpagenav_link', $record)
            );
        }
        return $this;
    }

    /**
     * @param block_flexpagenav_model_link $link
     * @param block_flexpagenav_model_link_config[] $configs
     * @return block_flexpagenav_repository_link
     */
    public function save_link_config(block_flexpagenav_model_link $link, array $configs) {
        global $DB;

        foreach ($configs as $config) {
            // Ensure the relationship is established
            $config->set_linkid($link->get_id());

            $record = array(
                'linkid' => $config->get_linkid(),
                'name' => $config->get_name(),
                'value' => $config->get_value(),
            );

            $id = $config->get_id();
            if (!empty($id)) {
                $record['id'] = $id;
                $DB->update_record('block_flexpagenav_config', $record);
            } else {
                $config->set_id(
                    $DB->insert_record('block_flexpagenav_config', $record)
                );
            }
        }
        return $this;
    }

    /**
     * Delete a link, the passed model has its ID and configs cleared
     *
     * @param block_flexpagenav_model_link $link
     * @return void
     */
    public function delete_link(block_flexpagenav_model_link $link) {
        global $DB;

        $this->remove_link_weight($link);

        $DB->delete_records('block_flexpagenav_link', array('id' => $link->get_id()));
        $DB->delete_records('block_flexpagenav_config', array('linkid' => $link->get_id()));

        $link->set_id(null)
             ->set_configs(array());
    }

    /**
     * Gets the next link weight value
     *
     * @param block_flexpagenav_model_link $link
     * @return int
     */
    public function get_next_weight(block_flexpagenav_model_link $link) {
        global $DB;

        if ($next = $DB->get_field('block_flexpagenav_link', '(MAX(weight) + 1) AS next', array('menuid' => $link->get_menuid()))) {
            return $next;
        }
        return 0;
    }

    /**
     * Move a link
     *
     * @param block_flexpagenav_model_link $link
     * @param int $move block_flexpagenav_model_link::MOVE_XXX constant
     * @param int $referencelinkid
     * @return block_flexpagenav_repository_link
     */
    public function move_link(block_flexpagenav_model_link $link, $move, $referencelinkid) {
        global $DB;

        $reflink = $this->get_link($referencelinkid);

        // Remove from ordering
        $this->remove_link_weight($link);

        switch ($move) {
            case block_flexpagenav_model_link::MOVE_BEFORE:
                // Link get reflink's weight
                $link->set_weight($reflink->get_weight());

                // Push weights up to make room
                $DB->execute("
                    UPDATE {block_flexpagenav_link}
                       SET weight = (weight + 1)
                     WHERE menuid = ?
                       AND weight >= ?
                ", array($reflink->get_menuid(), $reflink->get_weight()));


                break;
            case block_flexpagenav_model_link::MOVE_AFTER:
                // Link gets reflink's weight + 1
                $link->set_weight(($reflink->get_weight() + 1));

                // Push weights up to make room
                $DB->execute("
                    UPDATE {block_flexpagenav_link}
                       SET weight = (weight + 1)
                     WHERE menuid = ?
                       AND weight > ?
                ", array($reflink->get_menuid(), $reflink->get_weight()));

                break;
        }
        return $this;
    }

    /**
     * Remove a link from the weight numbering
     *
     * @param block_flexpagenav_model_link $link
     * @return void
     */
    protected function remove_link_weight(block_flexpagenav_model_link $link) {
        global $DB;

        $DB->execute('
            UPDATE {block_flexpagenav_link}
               SET weight = (weight - 1)
             WHERE menuid = ?
               AND weight > ?
        ', array($link->get_menuid(), $link->get_weight()));

        $link->set_weight(0);
    }
}