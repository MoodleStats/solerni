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
 * Orange Horizontal Numbers block definition
 *
 * @package    block_orange_horizontal_numbers
 * @copyright  Orange 2016
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once(dirname(__FILE__) . '/../../config.php');
require_once($CFG->dirroot.'/local/orange_library/classes/forumng/forumng_object.php');

use theme_halloween\tools\theme_utilities;
use local_orange_library\utilities\utilities_image;
use local_orange_library\utilities\utilities_network;

/**
 * Orange Horizontal Numbers block class
 * @copyright  Orange 2016
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_orange_horizontal_numbers extends block_base {

    /**
     * Sets the block title
     *
     * @return void
     */
    public function init() {
        global $PAGE;

        $this->title = get_string('pluginname', 'block_orange_horizontal_numbers');
        $this->renderer = $PAGE->get_renderer('block_orange_horizontal_numbers');
    }

    /**
     *  we have global config/settings data
     *
     * @return bool
     */
    public function has_config() {
        return false;
    }

    /**
     * Set instance title
     *
     * @return void;
     */
    public function specialization() {
        $this->title = "";
    }

    /**
     * Controls whether multiple instances of the block are allowed on a page.
     *
     * @return bool
     */
    public function instance_allow_multiple() {
        return false;
    }

    /**
     * Defines where the block can be added.
     *
     * @return array
     */
    public function applicable_formats() {
        return array(
            'course-view'    => true,
            'site'           => true,
            'mod'            => false,
            'my'             => false
        );
    }

    /**
     * Creates the blocks main content
     *
     * @return string
     */
    public function get_content() {
        global $CFG;

        // If content has already been generated, don't waste time generating it again.
        if ($this->content !== null) {
            return $this->content;
        }

        $this->content = new stdClass;
        $this->content->text = '';
        $this->content->footer = '';

        if (empty($this->instance)) {
            return $this->content;
        }

        // Get calculated data in cache (CRON).
        $currenthost = new \stdclass();
        $currenthost->id = 1;
        $host = utilities_network::get_thematic_info($currenthost);

        if (!empty($host->available)) {
            $nbuserssonnected = (int)$host->nbconnected;
            $nbusersregistred = (int)$host->nbuser;
            $nbposts = (int)$host->nbpost;
        } else {
            $nbuserssonnected = local_orange_library\utilities\utilities_user::get_nbconnectedusers();
            $nbusersregistred = local_orange_library\utilities\utilities_user::get_nbusers();
            $nbposts = \forumng_object::get_nbposts();
        }

        $lastuser = local_orange_library\utilities\utilities_user::get_lastregistered();

        // Get thematic illustration.
        if (theme_utilities::is_theme_settings_exists_and_nonempty('homepageillustration')) {
            $context = \context_system::instance();
            $file = utilities_image::get_moodle_stored_file($context, 'theme_halloween', 'homepageillustration');
            $illustrationurl = utilities_image::get_resized_url($file,
                array('w' => 1160, 'h' => 500, 'scale' => true));
        } else {
            $illustrationurl = $CFG->wwwroot . "/blocks/orange_horizontal_numbers/pix/defaultillustration.png";
        }

        $this->content->text = $this->renderer->display_horizontal_numbers(
                $illustrationurl, $nbuserssonnected, $nbposts, $nbusersregistred, $lastuser);

        return $this->content;
    }
}
