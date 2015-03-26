<?php
/**
 * Orange Rules block.
 *
 * @package    block_orange_rules
 * @copyright  2015 Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class block_orange_rules extends block_base {

    function init() {
        $this->title = get_string('pluginname', 'block_orange_rules');
    }

    function applicable_formats() {
        return array('all' => true, 'tag' => false);
    }

    function specialization() {
        $this->title = isset($this->config->title) ? $this->config->title : get_string('neworangerulesblock', 'block_orange_rules');
    }

    function instance_allow_multiple() {
        return true;
    }

    function get_content() {
        global $CFG, $USER, $DB;

        if ($this->content !== NULL) {
            return $this->content;
        }

        $this->content = new stdClass();

        return $this->content;
    }

    /**
     * Returns true if the block can be docked.
     * The Orange Rules block can only be docked if it has a non-empty title.
     * @return bool
     */
    public function instance_can_be_docked() {
        return parent::instance_can_be_docked() && isset($this->config->title) && !empty($this->config->title);
    }
}

