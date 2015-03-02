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
 * Link Config Model
 *
 * @author Mark Nielsen
 * @package block_flexpagenav
 */
class block_flexpagenav_model_link_config {
    /**
     * @var int
     */
    protected $id;

    /**
     * @var int
     */
    protected $linkid;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $value;

    /**
     * @param null|string $name
     * @param null|string $value Name is required to set value
     */
    public function __construct($name = null, $value = null) {
        if (!is_null($name)) {
            $this->set_name($name);

            if (!is_null($value)) {
               $this->set_value($value);
            }
        }
    }

    /**
     * @param int $id
     * @return block_flexpagenav_model_link_config
     */
    public function set_id($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function get_id() {
        return $this->id;
    }

    /**
     * @param int $linkid
     * @return block_flexpagenav_model_link_config
     */
    public function set_linkid($linkid) {
        $this->linkid = $linkid;
        return $this;
    }

    /**
     * @return int
     */
    public function get_linkid() {
        return $this->linkid;
    }

    /**
     * @param string $name
     * @return block_flexpagenav_model_link_config
     */
    public function set_name($name) {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function get_name() {
        return $this->name;
    }

    /**
     * @param string $value
     * @return block_flexpagenav_model_link_config
     */
    public function set_value($value) {
        $this->value = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function get_value() {
        return $this->value;
    }
}