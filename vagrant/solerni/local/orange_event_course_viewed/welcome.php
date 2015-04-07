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
 * Version details
 *
 * @package    local_orange_event_course_viewed
 * @copyright  2015 Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');
require_once($CFG->libdir.'/adminlib.php');
require_once($CFG->dirroot.'/course/lib.php');

global $DB, $PAGE, $USER;

require_login(0, false);
$PAGE->set_context(context_system::instance());

$id = required_param('id', PARAM_INT);
$clause = array('id' => $id);

$course = $DB->get_records('course', $clause);

$instance = $DB->get_record('enrol', array('courseid' => $id, 'enrol' => 'self'));

if (isset($instance->id)) {
    $enroldata = $DB->get_record('user_enrolments', array('userid' => $USER->id, 'enrolid' => $instance->id));
    if (($course != null) && ($enroldata != null) && ((time() - $enroldata->timecreated) < 5) ) {
        $timeformat = get_string('strftimedatefullshort', 'langconfig');

        if ($course[$id]->startdate <= time()) {
            $message = get_string('welcome_enrolment_message_title', 'local_orange_event_course_viewed') . " " .
                get_string('welcome_enrolment_message_inscription', 'local_orange_event_course_viewed',
                format_string($course[$id]->fullname)) . " " .
                get_string('welcome_enrolment_message_started', 'local_orange_event_course_viewed');
        } else {
            $message = get_string('welcome_enrolment_message_title', 'local_orange_event_course_viewed') . " " .
                get_string('welcome_enrolment_message_inscription', 'local_orange_event_course_viewed',
                format_string($course[$id]->fullname)) . " " .
                get_string('welcome_enrolment_message_notstarted', 'local_orange_event_course_viewed',
                userdate($course[$id]->startdate, $timeformat) );
        }
?>
        alert("<?php echo $message ?>");
<?php
    }
}