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
 * Mock extended_course.
 *
 * @package extended_course
 * @copyright 2016 Orange
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace local_orange_library_tests_fixtures_mock_extended_course;
use \local_orange_library\extended_course;
defined('MOODLE_INTERNAL') || die();

/**
 * Mock condition.
 *
 * @package core_availability
 * @copyright 2014 The Open University
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class mock_extended_course extends \local_orange_library\extended_course\extended_course_object {
    /**
     * The database table this grade object is stored in
     * @var string $table
     */
    public $table = 'course_format_options';

    /**
     * The end date of a course.
     * @var int $enddate
     */
    public $enddate;

    /**
     * The status of a course.
     * @var int $status
     */
    public $status;

    /**
     * The picture of a course.
     * @var file $picture
     */
    public $picture;

    /**
     * The replay value of a course.
     * @var string $replay
     */
    public $replay;

    /**
     * The duration value of a course.
     * @var int $duration
     */
    public $duration;

    /**
     * The workingtime value of a course.
     * @var int $workingtime
     */
    public $workingtime;

    /**
     * The badge value of a course.
     * @var boolean $badge
     */
    public $badge;

    /**
     * The certification of a course.
     * @var boolean $certification
     */
    public $certification;

    /**
     * The  price of a course.
     * @var int $price
     */
    public $price;

    /**
     * The language of a course.
     * @var int $language
     */
    public $language;

    /**
     * The video of a course.
     * @var boolean $video
     */
    public $video;

    /**
     * The subtitle of a course.
     * @var boolean $subtitle
     */
    public $subtitle;

    /**
     * The registration of a course.
     * @var string $registration
     */
    public $registration;

    /**
     * The $registrationcompany of a course.
     * @var string $$registrationcompany
     */
    public $registrationcompany;

    /**
     * The $maxregisteredusers of a course.
     * @var int $maxregisteredusers
     */
    public $maxregisteredusers;

    /**
     * The registration start date of a course.
     * @var int $registrationstartdate
     */
    public $registrationstartdate;

    /**
     * The registration end date of a course.
     * @var int $registrationenddate
     */
    public $registrationenddate;

    /**
     * The prerequesites of a course.
     * @var string $prerequesites
     */
    public $prerequesites;

    /**
     * The teachingteam of a course.
     * @var string $teachingteam
     */
    public $teachingteam;

    /**
     * url enrolment.
     * @var text $enrolurl
     */
    public $enrolurl;

    /**
     * url unrollment.
     * @var text $unenrolurl
     */
    public $unenrolurl;

    /**
     * The $coursestatus of a course.
     * @var text $coursestatus
     */
    public $coursestatus;

    /**
     * The $statuslink of a course.
     * @var text $statuslink
     */
    public $statuslink;

    /**
     * The $statuslinktext of a course.
     * @var text $statuslinktext
     */
    public $statuslinktext;
    /**
     * The $statustext of a course.
     * @var text $statustext
     */
    public $statustext;

    /**
     * The $coursestatustext of a course.
     * @var text $coursestatustext
     */
    public $coursestatustext;

    /**
     * The $registrationstatus of a course.
     * @var text $registrationstatus
     */
    public $registrationstatus;

    /**
     * The $registrationstatustext of a course.
     * @var text $registrationstatustext
     */
    public $registrationstatustext;

    /**
     * The $thumbnailtext of a course.
     * @var int $thumbnailtext
     */
    public $thumbnailtext;

    /**
     * The $enrolledusers of a course.
     * @var int $enrolledusers
     */
    public $enrolledusers;

    /**
     * The $enrolledusersself of a course (using self enrolment).
     * @var int $enrolledusersself
     */
    public $enrolledusersself;

    /**
     * The $enrolstartdate of a course.
     * @var int $enrolstartdate
     */
    public $enrolstartdate;

    /**
     * The $enrolstartdate of a course.
     * @var int $enrolenddate
     */
    public $enrolenddate;

    /**
     * The $displaybutton of a course.
     * @var int $displaybutton
     private
    public $displaybutton;

    /**
     * The $videoplayer of a course.
     * @var text $videoplayer
     */
    public $videoplayer;

    /**
     * The $inactivitydelay of a course.
     * @var text $inactivitydelay
     */
    public $inactivitydelay;

    const USERLOGGED        = 4;
    const USERENROLLED      = 5;
    const MAXREGISTRATEDUSERS = 100000;

    /**
     * The contact email of a course.
     * @var int $contactemail
     */
    public $contactemail;

    /**
     * The $new session url of a course.
     * @var string $newsessionurl
     */
    public $newsessionurl;
    public $coursebadge = array ();
    public $coursecertification = array ();

    /**
     * Constructs with item details.
     *
     * @param \stdClass $course Optional course param (otherwise uses $SITE)
     * @param int $userid Userid for modinfo (if used)
     */
    public function __construct($course = null, $userid = 0) {
        $structure = "";
        //$this->mock_factory($course);
    }


    private function add_record ($courseid, $format, $sectionid, $name, $value) {
        global $DB;
        $record = new \stdClass();
        $record->courseid         = $courseid;
        $record->format = $format;
        $record->sectionid = $sectionid;
        $record->name = $name;
        $record->value = $value;

        $lastinsertid = $DB->insert_record('course_format_options', $record, true);

    }

    /**
     * Constructs a mock condition with given structure.
     *
     * @param \stdClass $structure Structure object
     */
    public function mock_factory($course) {

        $this->add_record($course->id, 'flexpage', 0, 'table', 'course_format_options');
        $this->add_record($course->id, 'flexpage', 0, 'coursebadge', 1);
        $this->add_record($course->id, 'flexpage', 0, 'coursecertification', 1);
        $this->add_record($course->id, 'flexpage', 0, 'coursecontactemail', 'contact@email.com');
        $this->add_record($course->id, 'flexpage', 0, 'courseduration', 3024000);
        $this->add_record($course->id, 'flexpage', 0, 'courseinactivitydelay', 7);
        $this->add_record($course->id, 'flexpage', 0, 'courseenddate', 1467496801);
        $this->add_record($course->id, 'flexpage', 0, 'language', 0);
        $this->add_record($course->id, 'flexpage', 0, 'coursemaxregisteredusers', 5);
        $this->add_record($course->id, 'flexpage', 0, 'coursepicture', 381002270);
        $this->add_record($course->id, 'flexpage', 0, 'courseprerequesites', "<p>Prérequis</p>");
        $this->add_record($course->id, 'flexpage', 0, 'courseprice', 1);
        $this->add_record($course->id, 'flexpage', 0, 'courseregistration', 0);
        $this->add_record($course->id, 'flexpage', 0, 'coursereplay', 0);
        $this->add_record($course->id, 'flexpage', 0, 'coursesubtitle', 1);
        $this->add_record($course->id, 'flexpage', 0, 'courseteachingteam', "<p>Équipe pédagogique</p>");
        $this->add_record($course->id, 'flexpage', 0, 'coursethumbnailtext', "cours a venir / ouvert et places dispo");
        $this->add_record($course->id, 'flexpage', 0, 'coursevideoplayer', '<iframe width="560" height="315" src="https://www.youtube.com/embed/bNfYUsDSrOs?rel=0" frameborder="0" allowfullscreen></iframe>');
        $this->add_record($course->id, 'flexpage', 0, 'courseworkingtime', 7200);
        $this->add_record($course->id, 'flexpage', 0, 'description1', "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.");
        $this->add_record($course->id, 'flexpage', 0, 'description2', "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.");
        $this->add_record($course->id, 'flexpage', 0, 'description3', "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.");
        $this->add_record($course->id, 'flexpage', 0, 'description4', "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.");
        $this->add_record($course->id, 'flexpage', 0, 'description5', "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.");
        $this->add_record($course->id, 'flexpage', 0, 'description6', "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.");
        $this->add_record($course->id, 'flexpage', 0, 'description7', "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.");
        $this->add_record($course->id, 'flexpage', 0, 'description8', "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.");
        $this->add_record($course->id, 'flexpage', 0, 'description9', "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.");
        $this->add_record($course->id, 'flexpage', 0, 'description10', "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.");
        $this->add_record($course->id, 'flexpage', 0, 'paragraph1', "Titre Paragraphe 1");
        $this->add_record($course->id, 'flexpage', 0, 'paragraph2', "Titre Paragraphe 2");
        $this->add_record($course->id, 'flexpage', 0, 'paragraph3', "Titre Paragraphe 3");
        $this->add_record($course->id, 'flexpage', 0, 'paragraph4', "Titre Paragraphe 4");
        $this->add_record($course->id, 'flexpage', 0, 'paragraph5', "Titre Paragraphe 5");
        $this->add_record($course->id, 'flexpage', 0, 'paragraph6', "Titre Paragraphe 6");
        $this->add_record($course->id, 'flexpage', 0, 'paragraph7', "Titre Paragraphe 7");
        $this->add_record($course->id, 'flexpage', 0, 'paragraph8', "Titre Paragraphe 8");
        $this->add_record($course->id, 'flexpage', 0, 'paragraph9', "Titre Paragraphe 9");
        $this->add_record($course->id, 'flexpage', 0, 'paragraph10', "Titre Paragraphe 10");
        $this->add_record($course->id, 'flexpage', 0, 'paragraph1bgcolor', "bg-green");
        $this->add_record($course->id, 'flexpage', 0, 'paragraph2bgcolor', "bg-graylighter");
        $this->add_record($course->id, 'flexpage', 0, 'paragraph3bgcolor', "bg-red");
        $this->add_record($course->id, 'flexpage', 0, 'paragraph4bgcolor', "bg-graylighter");
        $this->add_record($course->id, 'flexpage', 0, 'paragraph5bgcolor', "bg-yellow");
        $this->add_record($course->id, 'flexpage', 0, 'paragraph6bgcolor', "bg-graylighter");
        $this->add_record($course->id, 'flexpage', 0, 'paragraph7bgcolor', "bg-blue");
        $this->add_record($course->id, 'flexpage', 0, 'paragraph8bgcolor', "bg-graylighter");
        $this->add_record($course->id, 'flexpage', 0, 'paragraph9bgcolor', "bg-pink");
        $this->add_record($course->id, 'flexpage', 0, 'paragraph10bgcolor', "bg-graylighter");
        $this->add_record($course->id, 'flexpage', 0, 'paragraph1picture', 181464878);
        $this->add_record($course->id, 'flexpage', 0, 'paragraph2picture', 435990855);
        $this->add_record($course->id, 'flexpage', 0, 'paragraph3picture', 257556141);
        $this->add_record($course->id, 'flexpage', 0, 'paragraph4picture', 972257379);
        $this->add_record($course->id, 'flexpage', 0, 'paragraph5picture', 25516927);
        $this->add_record($course->id, 'flexpage', 0, 'paragraph6picture', 635357878);
        $this->add_record($course->id, 'flexpage', 0, 'paragraph7picture', 396585880);
        $this->add_record($course->id, 'flexpage', 0, 'paragraph8picture', 412869366);
        $this->add_record($course->id, 'flexpage', 0, 'paragraph9picture', 653207731);
        $this->add_record($course->id, 'flexpage', 0, 'paragraph10picture', 730279675);
        $this->add_record($course->id, 'flexpage', 0, 'paragraphheader', "");

    }
}
