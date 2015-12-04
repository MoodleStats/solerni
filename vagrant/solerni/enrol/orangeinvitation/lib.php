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
 * orangeinvitation enrolment plugin.
 *
 * This plugin allows you to create an orangeinvitation link. Users
 * clicking on the link are automatically directed to the course.
 *
 * @package    enrol
 * @subpackage orangeorangeinvitation
 * @copyright  Orange 2015 based on Jerome Mouneyrac orangeinvitation plugin{@link http://www.moodleitandme.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/enrol/orangeinvitation/locallib.php');

/**
 * orangeinvitation enrolment plugin implementation.
 * @author  Jerome Mouneyrac
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class enrol_orangeinvitation_plugin extends enrol_plugin {

    /**
     * Returns optional enrolment information icons.
     *
     * This is used in course list for quick overview of enrolment options.
     *
     * We are not using single instance parameter because sometimes
     * we might want to prevent icon repetition when multiple instances
     * of one type exist. One instance may also produce several icons.
     *
     * @param array $instances all enrol instances of this type in one course
     * @return array of pix_icon
     */
    public function get_info_icons(array $instances) {
        return array(new pix_icon('invite', get_string('pluginname', 'enrol_orangeinvitation'), 'enrol_orangeinvitation'));
    }

    public function roles_protected() {
        // Users with role assign cap may tweak the roles later.
        return false;
    }

    public function allow_manage(stdClass $instance) {
        // Users with manage cap may tweak period and status - requires enrol/orangeinvitation:manage.
        return true;
    }

    /**
     * Attempt to automatically enrol current user in course without any interaction,
     * calling code has to make sure the plugin and instance are active.
     *
     * This should return either a timestamp in the future or false.
     *
     * @param stdClass $instance course enrol instance
     * @param stdClass $user record
     * @return bool|int false means not enrolled, integer means timeend
     */
    public function try_autoenrol(stdClass $instance) {
        global $USER;

        return false;
    }

    /**
     * Returns link to page which may be used to add new instance of enrolment plugin in course.
     * @param int $courseid
     * @return moodle_url page url
     */
    public function get_newinstance_link($courseid) {
        global $DB;

        $context = context_course::instance($courseid);

        if (!has_capability('moodle/course:enrolconfig', $context)
                or !has_capability('enrol/orangeinvitation:config', $context)) {
            return null;
        }

        // We don't want more than one instance per course.
        if ($DB->record_exists('enrol', array('courseid' => $courseid, 'enrol' => 'orangeinvitation'))) {
            return null;
        }

        return new moodle_url('/enrol/orangeinvitation/edit.php', array('courseid' => $courseid));
    }

    /**
     * Add new instance of enrol plugin.
     * @param object $course
     * @param array instance fields
     * @return int id of new instance, null if can not be created
     */
    public function add_instance($course, array $fields = null) {
        global $DB;

        if ($DB->record_exists('enrol', array('courseid' => $course->id, 'enrol' => 'orangeinvitation'))) {
            // Only one instance allowed, sorry.
            return null;
        }

        return parent::add_instance($course, $fields);
    }

    /**
     * Sets up navigation entries.
     *
     * @param object $instance
     * @return void
     */
    public function add_course_navigation($instancesnode, stdClass $instance) {
        if ($instance->enrol !== 'orangeinvitation') {
             throw new coding_exception('Invalid enrol instance type!');
        }

        $context = context_course::instance($instance->courseid);
        if (has_capability('enrol/orangeinvitation:config', $context)) {
            $managelink = new moodle_url('/enrol/orangeinvitation/edit.php', array('courseid' => $instance->courseid,
                'id' => $instance->id));
            $instancesnode->add($this->get_instance_name($instance), $managelink, navigation_node::TYPE_SETTING);
        }
    }

    /**
     * Returns edit icons for the page with list of instances
     * @param stdClass $instance
     * @return array
     */
    public function get_action_icons(stdClass $instance) {
        global $OUTPUT;

        if ($instance->enrol !== 'orangeinvitation') {
            throw new coding_exception('invalid enrol instance!');
        }
        $context = context_course::instance($instance->courseid);

        $icons = array();

        if (has_capability('enrol/orangeinvitation:config', $context)) {
            $editlink = new moodle_url("/enrol/orangeinvitation/edit.php", array('courseid' => $instance->courseid,
                'id' => $instance->id));
            $icons[] = $OUTPUT->action_icon($editlink, new pix_icon('t/edit',
                get_string('edit'), 'core', array('class' => 'iconsmall')));
        }

        return $icons;
    }

    /**
     * Creates course enrol form, checks if form submitted
     * and enrols user if necessary. It can also redirect.
     *
     * @param stdClass $instance
     * @return string html text, usually a form in a text box
     */
    public function enrol_page_hook(stdClass $instance) {
    }

    /**
     * Returns an enrol_user_button that takes the user to a page where they are able to
     * enrol users into the managers course through this plugin.
     *
     * Optional: If the plugin supports manual enrolments it can choose to override this
     * otherwise it shouldn't
     *
     * @param course_enrolment_manager $manager
     * @return enrol_user_button|false
     */
    public function get_manual_enrol_button(course_enrolment_manager $manager) {
        global $CFG;

        $instance = null;
        $instances = array();
        foreach ($manager->get_enrolment_instances() as $tempinstance) {
            if ($tempinstance->enrol == 'orangeinvitation') {
                if ($instance === null) {
                    $instance = $tempinstance;
                }
                $instances[] = array('id' => $tempinstance->id, 'name' => $this->get_instance_name($tempinstance));
            }
        }
        if (empty($instance)) {
            return false;
        }
    }




    /**
     * Returns true if the plugin has one or more bulk operations that can be performed on
     * user enrolments.
     *
     * @return bool
     */
    public function has_bulk_operations(course_enrolment_manager $manager) {
        return false;
    }

    /**
     * Return an array of enrol_bulk_enrolment_operation objects that define
     * the bulk actions that can be performed on user enrolments by the plugin.
     *
     * @return array
     */
    public function get_bulk_operations(course_enrolment_manager $manager) {
        return array();
    }


    /**
     * This function return the course information related to the token cookie
     * @param cookie
     * @return course_name
     */
    public function get_course_by_token ($cookie) {
        global $DB;

        // Decrypt cookie content token-courseId.
        $cookiecontent = explode("-", rc4decrypt($cookie));
        $enrolinvitationtoken = $cookiecontent[0];
        $id = $cookiecontent[1];

        // Retrieve the token info.
        $invitation = $DB->get_record('enrol_orangeinvitation', array('token' => $enrolinvitationtoken));
        // If token is valid, enrol the user into the course.
        if (!empty($invitation) && !empty($invitation->courseid) && ($invitation->courseid == $id)) {
            if ($course = $DB->get_record('course', array('id' => $id))) {
                $coursename = $course->fullname;
            } else {
                $coursename = "";
            }
        } else {
            $coursename = "";
        }

        return $coursename;
    }

}
