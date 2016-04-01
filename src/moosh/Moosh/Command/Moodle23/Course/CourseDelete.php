<?php

/**
 * Delete course by id.
 *
 * moosh course-delete [<id1> <id2> ...]
 *
 * @copyright  2012 onwards Tomasz Muras
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace Moosh\Command\Moodle23\Course;

use Moosh\MooshCommand;

class CourseDelete extends MooshCommand
{

    public function __construct()
    {
        parent::__construct('delete', 'course');

        $this->addArgument('id');
        $this->maxArguments = 255;
    }

    public function execute()
    {
        global $DB;

        foreach ($this->arguments as $argument) {
            try {
                $course = $DB->get_record('course', array('id' => $argument));
            } catch (Exception $e) {
                print get_class($e) . " thrown within the exception handler. Message: " . $e->getMessage() . " on line " . $e->getLine();
            }

            if ($course instanceof \stdClass) {
                delete_course($course);
            } else {
                print "Course not found\n";
            }
        }
        fix_course_sortorder();
    }

}
