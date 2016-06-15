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
 * Adds new instance of enrol_orangeinvitation to specified course
 * or edits current instance.
 *
 * @package    enrol
 * @subpackage orangenextsession
 * @copyright  Orange 2015 based on Waitlist Enrol plugin / emeneo.com
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class enrol_orangenextsession_plugin extends enrol_plugin {

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
        $key = false;
        $nokey = false;
        foreach ($instances as $instance) {
            if ($instance->password or $instance->customint1) {
                $key = true;
            } else {
                $nokey = true;
            }
        }
        $icons = array();
        if ($nokey) {
            $icons[] = new pix_icon('withoutkey', get_string('pluginname', 'enrol_orangenextsession'), 'enrol_orangenextsession');
        }
        if ($key) {
            $icons[] = new pix_icon('withkey', get_string('pluginname', 'enrol_orangenextsession'), 'enrol_orangenextsession');
        }
        return $icons;
    }

    /**
     * Returns localised name of enrol instance
     *
     * @param object $instance (null is accepted too)
     * @return string
     */
    public function get_instance_name($instance) {
        global $DB;

        if (empty($instance->name)) {
            if (!empty($instance->roleid) and $role = $DB->get_record('role', array('id' => $instance->roleid))) {
                $role = ' (' . role_get_name($role, context_course::instance($instance->courseid)) . ')';
            } else {
                $role = '';
            }
            $enrol = $this->get_name();
            return get_string('pluginname', 'enrol_'.$enrol) . $role;
        } else {
            return format_string($instance->name);
        }
    }

    public function roles_protected() {
        // Users may tweak the roles later.
        return false;
    }

    public function allow_unenrol(stdClass $instance) {
        // Users with unenrol cap may unenrol other users manually manually.
        return true;
    }

    public function allow_manage(stdClass $instance) {
        // Users with manage cap may tweak period and status.
        return true;
    }

    public function show_enrolme_link(stdClass $instance) {
        return ($instance->status == ENROL_INSTANCE_ENABLED);
    }


    /**
     * Returns edit icons for the page with list of instances
     * @param stdClass $instance
     * @return array
     */
    public function get_action_icons(stdClass $instance) {
        global $OUTPUT;

        if ($instance->enrol !== 'orangenextsession') {
            throw new coding_exception('invalid enrol instance!');
        }
        $context = context_course::instance($instance->courseid, MUST_EXIST);

        $icons = array();

        if (has_capability('enrol/orangenextsession:config', $context)) {
            $editlink = new moodle_url("/enrol/orangenextsession/edit.php",
                    array('courseid' => $instance->courseid, 'id' => $instance->id));
            $icons[] = $OUTPUT->action_icon($editlink, new pix_icon('t/edit', get_string('edit'), 'core',
                    array('class' => 'iconsmall')));

            $exportlink = new moodle_url("/enrol/orangenextsession/export.php",
                    array('courseid' => $instance->courseid, 'id' => $instance->id));
            $icons[] = $OUTPUT->action_icon($exportlink , new pix_icon('t/email',
                    get_string('exportuserlist', 'enrol_orangenextsession'), 'core', array('class' => 'iconsmall')));
        }

        return $icons;
    }

    /**
     * Returns link to page which may be used to add new instance of enrolment plugin in course.
     * @param int $courseid
     * @return moodle_url page url
     */
    public function get_newinstance_link($courseid) {
        $context = context_course::instance($courseid, MUST_EXIST);

        if (!has_capability('moodle/course:enrolconfig', $context) or !has_capability('enrol/orangenextsession:config', $context)) {
            return null;
        }
        // Multiple instances supported - different roles with different password.
        return new moodle_url('/enrol/orangenextsession/edit.php', array('courseid' => $courseid));
    }

    /**
     * Sets up navigation entries.
     *
     * @param object $instance
     * @return void
     */
    public function add_course_navigation($instancesnode, stdClass $instance) {
        if ($instance->enrol !== 'orangenextsession') {
             throw new coding_exception('Invalid enrol instance type!');
        }

        $context = context_course::instance($instance->courseid);
        if (has_capability('enrol/orangenextsession:config', $context)) {
            $managelink = new moodle_url('/enrol/orangenextsession/edit.php', array('courseid' => $instance->courseid,
                'id' => $instance->id));
            $instancesnode->add($this->get_instance_name($instance), $managelink, navigation_node::TYPE_SETTING);
        }
    }

    public function enrol_orangenextsession(stdClass $instance) {
        global $CFG, $USER, $DB;

        if (isguestuser()) {
            // Can not enrol guest!!.
            return null;
        }
        if ($DB->record_exists('user_enrolments', array('userid' => $USER->id, 'enrolid' => $instance->id))) {
            return get_string('alreadyenrolled', 'enrol_orangenextsession');
        }

        if ($DB->record_exists('user_enrol_nextsession', array('userid' => $USER->id, 'instanceid' => $instance->id))) {
            return get_string('alreadyinlist', 'enrol_orangenextsession');
        }

        require_once("$CFG->dirroot/enrol/orangenextsession/orangenextsession.php");

        $nextsession = new orangenextsession();
        $nextsession->add_nextsession_list($instance->id, $USER->id);

        if ($instance->customint1) {
            $this->email_information_message($instance, $USER);
        }

        return get_string('orangenextsessioninfo', 'enrol_orangenextsession');
    }


    /**
     * Add new instance of enrol plugin with default settings.
     * @param object $course
     * @return int id of new instance
     */
    public function add_default_instance($course) {
        $fields = array('customint1'  => $this->get_config('sendconfirmationmessage'),
                        'status'      => $this->get_config('status')
                        );

        return $this->add_instance($course, $fields);
    }

    /**
     * Send information email to specified user
     *
     * @param object $instance
     * @param object $user user record
     * @return void
     */
    protected function email_information_message($instance, $user) {
        global $CFG, $DB;

        $course = $DB->get_record('course', array('id' => $instance->courseid), '*', MUST_EXIST);

        $a = new stdClass();
        $a->coursename = format_string($course->fullname);
        $a->profileurl = "$CFG->wwwroot/user/view.php?id=$user->id&course=$course->id";
        $a->fullname = fullname($user);
        $a->learnmoreurl = local_orange_library\utilities\utilities_course::get_course_findoutmore_url($instance->courseid);

        if (trim($instance->customtext1) !== '') {
            $messagehtml = $instance->customtext1;
            $messagehtml = str_replace('{$a->coursename}', $a->coursename, $message);
            $messagehtml = str_replace('{$a->profileurl}', $a->profileurl, $message);
        } else {
            $messagehtml = get_string('informationmessagetext', 'enrol_orangenextsession', $a);
        }

        $message = html_to_text($messagehtml);
        $subject = get_string('informationmessage', 'enrol_orangenextsession', format_string($course->fullname));

        $context = context_course::instance($instance->courseid, MUST_EXIST);

        $supportuser = core_user::get_support_user();

        // Directly emailing welcome message rather than using messaging.
        email_to_user($user, $supportuser, $subject, $message, $messagehtml);
    }

    /**
     * Is it possible to hide/show enrol instance via standard UI?
     *
     * @param stdClass $instance
     * @return bool
     */
    public function can_hide_show_instance($instance) {
        $context = context_course::instance($instance->courseid);
        return has_capability('enrol/orangenextsession:config', $context);
    }


}