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
 * Flexpagenav Restore Task
 *
 * WARNING! This block's tables are being backed up by course/format/flexpage
 * as the format has more appropriate hooks for handling this data.
 *
 * @author Mark Nielsen
 * @package format_flexpage
 */
class restore_flexpagenav_block_task extends restore_default_block_task {

    public function build() {
        if (!$this->get_setting_value('overwrite_conf') and
            ($this->get_target() == backup::TARGET_CURRENT_ADDING or
             $this->get_target() == backup::TARGET_EXISTING_ADDING)) {
            $this->built = true;
        } else {
            parent::build();
        }
    }

    /**
     * Need to remap menu IDs
     *
     * @return void
     */
    public function after_restore() {
        global $DB;

        if ($instance = $DB->get_record('block_instances', array('id' => $this->get_blockid()))) {
            $block = block_instance('flexpagenav', $instance);
            if (!empty($block->config->menuid)) {
                $info = restore_dbops::get_backup_ids_record($this->get_restoreid(), 'flexpage_menu', $block->config->menuid);

                if ($info) {
                    $meuid = $info->newitemid;
                } else {
                    $meuid = 0;
                }
                $block->instance_config_save((object) array('menuid' => $meuid));
            }
        }
    }
}