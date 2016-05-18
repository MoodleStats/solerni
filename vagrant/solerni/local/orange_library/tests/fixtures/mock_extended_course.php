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

namespace extended_course_mock;

defined('MOODLE_INTERNAL') || die();

/**
 * Mock condition.
 *
 * @package core_availability
 * @copyright 2014 The Open University
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class extended_course extends \orange_library\extended_course\extended_course {
    /**
     * The database table this grade object is stored in
     * @var string $table
     */
    private $table = 'course_format_options';

    /**
     * The end date of a course.
     * @var int $enddate
     */
    private $enddate;

    /**
     * The status of a course.
     * @var int $status
     */
    private $status;

    /**
     * The picture of a course.
     * @var file $picture
     */
    private $picture;

    /**
     * The replay value of a course.
     * @var string $replay
     */
    private $replay;

    /**
     * The duration value of a course.
     * @var int $duration
     */
    private $duration;

    /**
     * The workingtime value of a course.
     * @var int $workingtime
     */
    private $workingtime;

    /**
     * The badge value of a course.
     * @var boolean $badge
     */
    private $badge;

    /**
     * The certification of a course.
     * @var boolean $certification
     */
    private $certification;

    /**
     * The  price of a course.
     * @var int $price
     */
    private $price;

    /**
     * The language of a course.
     * @var int $language
     */
    private $language;

    /**
     * The video of a course.
     * @var boolean $video
     */
    private $video;

    /**
     * The subtitle of a course.
     * @var boolean $subtitle
     */
    private $subtitle;

    /**
     * The registration of a course.
     * @var string $registration
     */
    private $registration;

    /**
     * The $registrationcompany of a course.
     * @var string $$registrationcompany
     */
    private $registrationcompany;

    /**
     * The $maxregisteredusers of a course.
     * @var int $maxregisteredusers
     */
    private $maxregisteredusers;

    /**
     * The registration start date of a course.
     * @var int $registrationstartdate
     */
    private $registrationstartdate;

    /**
     * The registration end date of a course.
     * @var int $registrationenddate
     */
    private $registrationenddate;

    /**
     * The prerequesites of a course.
     * @var string $prerequesites
     */
    private $prerequesites;

    /**
     * The teachingteam of a course.
     * @var string $teachingteam
     */
    private $teachingteam;

    /**
     * url enrolment.
     * @var text $enrolurl
     */
    private $enrolurl;

    /**
     * url unrollment.
     * @var text $unenrolurl
     */
    private $unenrolurl;

    /**
     * The $coursestatus of a course.
     * @var text $coursestatus
     */
    private $coursestatus;

    /**
     * The $statuslink of a course.
     * @var text $statuslink
     */
    private $statuslink;

    /**
     * The $statuslinktext of a course.
     * @var text $statuslinktext
     */
    private $statuslinktext;
    /**
     * The $statustext of a course.
     * @var text $statustext
     */
    private $statustext;

    /**
     * The $coursestatustext of a course.
     * @var text $coursestatustext
     */
    private $coursestatustext;

    /**
     * The $registrationstatus of a course.
     * @var text $registrationstatus
     */
    private $registrationstatus;

    /**
     * The $registrationstatustext of a course.
     * @var text $registrationstatustext
     */
    private $registrationstatustext;

    /**
     * The $thumbnailtext of a course.
     * @var int $thumbnailtext
     */
    private $thumbnailtext;

    /**
     * The $enrolledusers of a course.
     * @var int $enrolledusers
     */
    private $enrolledusers;

    /**
     * The $enrolledusersself of a course (using self enrolment).
     * @var int $enrolledusersself
     */
    private $enrolledusersself;

    /**
     * The $enrolstartdate of a course.
     * @var int $enrolstartdate
     */
    private $enrolstartdate;

    /**
     * The $enrolstartdate of a course.
     * @var int $enrolenddate
     */
    private $enrolenddate;

    /**
     * The $displaybutton of a course.
     * @var int $displaybutton
     private
    public $displaybutton;

    /**
     * The $videoplayer of a course.
     * @var text $videoplayer
     */
    private $videoplayer;

    /**
     * The $inactivitydelay of a course.
     * @var text $inactivitydelay
     */
    private $inactivitydelay;

    const USERLOGGED        = 4;
    const USERENROLLED      = 5;
    const MAXREGISTRATEDUSERS = 100000;

    /**
     * The contact email of a course.
     * @var int $contactemail
     */
    private $contactemail;

    /**
     * The $new session url of a course.
     * @var string $newsessionurl
     */
    public $newsessionurl;
public $coursebadge = array ();
public $coursecertification = array ();

public function set_array ($id, $courseid, $format, $sectionid, $name, $value){
    return array ("id" => $id,
            "courseid" => $courseid,
            "format" => $format,
            "sectionid" => $sectionid,
            "name" => $name,
            "value" => $value);
}
    public function set_coursebadge ($id, $courseid, $format, $sectionid, $name, $value) {
            $coursebadge = set_array ($id, $courseid, $format, $sectionid, $name, $value);
    }

    public function set_coursecertification ($id, $courseid, $format, $sectionid, $name, $value){
            $coursecertification = set_array ($id, $courseid, $format, $sectionid, $name, $value);
    }

    public function set_coursecontactemail ($id, $courseid, $format, $sectionid, $name, $value){
            $coursecontactemail = set_array ($id, $courseid, $format, $sectionid, $name, $value);
    }


    public function set_courseduration ($id, $courseid, $format, $sectionid, $name, $value){
            $courseduration = set_array ($id, $courseid, $format, $sectionid, $name, $value);
    }


    public function set_courseinactivitydelay ($id, $courseid, $format, $sectionid, $name, $value){
            $courseinactivitydelay = set_array ($id, $courseid, $format, $sectionid, $name, $value);
    }


    public function set_courselanguage ($id, $courseid, $format, $sectionid, $name, $value){
            $courselanguage = set_array ($id, $courseid, $format, $sectionid, $name, $value);
    }


    public function set_coursemaxregisteredusers ($id, $courseid, $format, $sectionid, $name, $value){
            $coursemaxregisteredusers = set_array ($id, $courseid, $format, $sectionid, $name, $value);
    }


    public function set_coursepicture ($id, $courseid, $format, $sectionid, $name, $value){
            $coursepicture = set_array ($id, $courseid, $format, $sectionid, $name, $value);
    }


    public function set_courseprerequesites ($id, $courseid, $format, $sectionid, $name, $value){
            $courseprerequesites = set_array ($id, $courseid, $format, $sectionid, $name, $value);
    }


    public function set_courseprice ($id, $courseid, $format, $sectionid, $name, $value){
            $courseprice = set_array ($id, $courseid, $format, $sectionid, $name, $value);
    }


    public function set_courseregistration ($id, $courseid, $format, $sectionid, $name, $value){
            $courseregistration = set_array ($id, $courseid, $format, $sectionid, $name, $value);
    }


    public function set_coursereplay ($id, $courseid, $format, $sectionid, $name, $value){
            $coursereplay = set_array ($id, $courseid, $format, $sectionid, $name, $value);
    }


    public function set_coursesubtitle ($id, $courseid, $format, $sectionid, $name, $value){
            $coursesubtitle = set_array ($id, $courseid, $format, $sectionid, $name, $value);
    }


    public function set_courseteachingteam ($id, $courseid, $format, $sectionid, $name, $value){
            $courseteachingteam = set_array ($id, $courseid, $format, $sectionid, $name, $value);
    }


    public function set_coursethematics ($id, $courseid, $format, $sectionid, $name, $value){
            $coursethematics = set_array ($id, $courseid, $format, $sectionid, $name, $value);
    }


    public function set_coursethumbnailtext ($id, $courseid, $format, $sectionid, $name, $value){
            $coursethumbnailtext = set_array ($id, $courseid, $format, $sectionid, $name, $value);
    }


    public function set_coursevideo ($id, $courseid, $format, $sectionid, $name, $value){
            $coursevideo = set_array ($id, $courseid, $format, $sectionid, $name, $value);
    }


    public function set_coursevideoplayer ($id, $courseid, $format, $sectionid, $name, $value){
            $coursevideoplayer = set_array ($id, $courseid, $format, $sectionid, $name, $value);
    }


    public function set_courseworkingtime ($id, $courseid, $format, $sectionid, $name, $value){
            $courseworkingtime = set_array ($id, $courseid, $format, $sectionid, $name, $value);
    }


    public function set_description1 ($id, $courseid, $format, $sectionid, $name, $value){
            $description1 = set_array ($id, $courseid, $format, $sectionid, $name, $value);
    }


    public function set_description10 ($id, $courseid, $format, $sectionid, $name, $value){
            $description10 = set_array ($id, $courseid, $format, $sectionid, $name, $value);
    }

    public function set_description2 ($id, $courseid, $format, $sectionid, $name, $value){
            $description2 = set_array ($id, $courseid, $format, $sectionid, $name, $value);
    }


    public function set_description3 ($id, $courseid, $format, $sectionid, $name, $value){
            $description3 = set_array ($id, $courseid, $format, $sectionid, $name, $value);
    }


    public function set_description4 ($id, $courseid, $format, $sectionid, $name, $value){
            $description4 = set_array ($id, $courseid, $format, $sectionid, $name, $value);
    }


    public function set_description5 ($id, $courseid, $format, $sectionid, $name, $value){
            $description5 = set_array ($id, $courseid, $format, $sectionid, $name, $value);
    }


    public function set_description6 ($id, $courseid, $format, $sectionid, $name, $value){
            $description6 = set_array ($id, $courseid, $format, $sectionid, $name, $value);
    }


    public function set_description7 ($id, $courseid, $format, $sectionid, $name, $value){
            $description7 = set_array ($id, $courseid, $format, $sectionid, $name, $value);
    }


    public function set_description8 ($id, $courseid, $format, $sectionid, $name, $value){
            $description8 = set_array ($id, $courseid, $format, $sectionid, $name, $value);
    }


    public function set_description9 ($id, $courseid, $format, $sectionid, $name, $value){
            $description9 = set_array ($id, $courseid, $format, $sectionid, $name, $value);
    }


    public function set_paragraph1 ($id, $courseid, $format, $sectionid, $name, $value){
            $paragraph1 = set_array ($id, $courseid, $format, $sectionid, $name, $value);
    }



    public function set_paragraph10 ($id, $courseid, $format, $sectionid, $name, $value){
            $paragraph10 = set_array ($id, $courseid, $format, $sectionid, $name, $value);
    }


    public function set_paragraph2 ($id, $courseid, $format, $sectionid, $name, $value){
            $paragraph2 = set_array ($id, $courseid, $format, $sectionid, $name, $value);
    }

    public function set_paragraph3 ($id, $courseid, $format, $sectionid, $name, $value){
            $paragraph3 = set_array ($id, $courseid, $format, $sectionid, $name, $value);
    }


    public function set_paragraph4 ($id, $courseid, $format, $sectionid, $name, $value){
            $paragraph4 = set_array ($id, $courseid, $format, $sectionid, $name, $value);
    }


    public function set_paragraph5 ($id, $courseid, $format, $sectionid, $name, $value){
            $paragraph5 = set_array ($id, $courseid, $format, $sectionid, $name, $value);
    }

    public function set_paragraph6 ($id, $courseid, $format, $sectionid, $name, $value){
            $paragraph6 = set_array ($id, $courseid, $format, $sectionid, $name, $value);
    }

    public function set_paragraph7 ($id, $courseid, $format, $sectionid, $name, $value){
            $paragraph7 = set_array ($id, $courseid, $format, $sectionid, $name, $value);
    }

    public function set_paragraph8 ($id, $courseid, $format, $sectionid, $name, $value){
            $paragraph8 = set_array ($id, $courseid, $format, $sectionid, $name, $value);
    }

    public function set_paragraph9 ($id, $courseid, $format, $sectionid, $name, $value){
            $paragraph9 = set_array ($id, $courseid, $format, $sectionid, $name, $value);
    }


    public function set_paragraph1bgcolor ($id, $courseid, $format, $sectionid, $name, $value){
            $paragraph1bgcolor = set_array ($id, $courseid, $format, $sectionid, $name, $value);
    }


    public function set_paragraph10bgcolor ($id, $courseid, $format, $sectionid, $name, $value){
            $paragraph10bgcolor = set_array ($id, $courseid, $format, $sectionid, $name, $value);
    }


    public function set_paragraph2bgcolor ($id, $courseid, $format, $sectionid, $name, $value){
            $paragraph2bgcolor = set_array ($id, $courseid, $format, $sectionid, $name, $value);
    }

    public function set_paragraph3bgcolor ($id, $courseid, $format, $sectionid, $name, $value){
            $paragraph3bgcolor = set_array ($id, $courseid, $format, $sectionid, $name, $value);
    }

    public function set_paragraph4bgcolor ($id, $courseid, $format, $sectionid, $name, $value){
            $paragraph4bgcolor = set_array ($id, $courseid, $format, $sectionid, $name, $value);
    }

    public function set_paragraph5bgcolor ($id, $courseid, $format, $sectionid, $name, $value){
            $paragraph5bgcolor = set_array ($id, $courseid, $format, $sectionid, $name, $value);
    }

    public function set_paragraph6bgcolor ($id, $courseid, $format, $sectionid, $name, $value){
            $paragraph6bgcolor = set_array ($id, $courseid, $format, $sectionid, $name, $value);
    }

    public function set_paragraph7bgcolor ($id, $courseid, $format, $sectionid, $name, $value){
            $paragraph7bgcolor = set_array ($id, $courseid, $format, $sectionid, $name, $value);
    }

    public function set_paragraph8bgcolor ($id, $courseid, $format, $sectionid, $name, $value){
            $paragraph8bgcolor = set_array ($id, $courseid, $format, $sectionid, $name, $value);
    }

    public function set_paragraph9bgcolor ($id, $courseid, $format, $sectionid, $name, $value){
            $paragraph9bgcolor = set_array ($id, $courseid, $format, $sectionid, $name, $value);
    }


    public function set_paragraph1picture ($id, $courseid, $format, $sectionid, $name, $value){
            $paragraph1picture = set_array ($id, $courseid, $format, $sectionid, $name, $value);
    }


    public function set_paragraph10picture ($id, $courseid, $format, $sectionid, $name, $value){
            $paragraph10picture = set_array ($id, $courseid, $format, $sectionid, $name, $value);
    }

    public function set_paragraph2picture ($id, $courseid, $format, $sectionid, $name, $value){
            $paragraph2picture = set_array ($id, $courseid, $format, $sectionid, $name, $value);
    }

    public function set_paragraph3picture ($id, $courseid, $format, $sectionid, $name, $value){
            $paragraph3picture = set_array ($id, $courseid, $format, $sectionid, $name, $value);
    }

    public function set_paragraph4picture ($id, $courseid, $format, $sectionid, $name, $value){
            $paragraph4picture = set_array ($id, $courseid, $format, $sectionid, $name, $value);
    }

    public function set_paragraph5picture ($id, $courseid, $format, $sectionid, $name, $value){
            $paragraph5picture = set_array ($id, $courseid, $format, $sectionid, $name, $value);
    }

    public function set_paragraph6picture ($id, $courseid, $format, $sectionid, $name, $value){
            $paragraph6picture = set_array ($id, $courseid, $format, $sectionid, $name, $value);
    }

    public function set_paragraph7picture ($id, $courseid, $format, $sectionid, $name, $value){
            $paragraph7picture = set_array ($id, $courseid, $format, $sectionid, $name, $value);
    }

    public function set_paragraph8picture ($id, $courseid, $format, $sectionid, $name, $value){
            $paragraph8picture = set_array ($id, $courseid, $format, $sectionid, $name, $value);
    }

    public function set_paragraph9picture ($id, $courseid, $format, $sectionid, $name, $value){
            $paragraph9picture = set_array ($id, $courseid, $format, $sectionid, $name, $value);
    }


    public function set_paragraphheader ($id, $courseid, $format, $sectionid, $name, $value){
            $paragraphheader = set_array ($id, $courseid, $format, $sectionid, $name, $value);
    }



    /**
     * Constructs a mock condition with given structure.
     *
     * @param \stdClass $structure Structure object
     */
    public function mock_factory($structure) {

            $this->set_coursebadge(400,2,"flexpage",0,"coursebadge",1 );
            $this->set_coursecertification(401,2,"flexpage",0,"coursecertification",1 );
            $this->set_coursecontactemail(402,2,"flexpage",0,"coursecontactemail","contact@email.com" );
            $this->set_courseduration(403,2,"flexpage",0,"courseduration",3024000 );
            $this->set_courseinactivitydelay(404,2,"flexpage",0,"courseinactivitydelay",7 );
            $this->set_courselanguage(405,2,"flexpage",0,"courselanguage",0 );
            $this->set_coursemaxregisteredusers(406,2,"flexpage",0,"coursemaxregisteredusers",1 );
            $this->set_coursepicture(407,2,"flexpage",0,"coursepicture",381002270 );
            $this->set_courseprerequesites(408,2,"flexpage",0,"courseprerequesites","<p>Prérequis</p>" );
            $this->set_courseprice(409,2,"flexpage",0,"courseprice",1 );
            $this->set_courseregistration(410,2,"flexpage",0,"courseregistration",0 );
            $this->set_coursereplay(411,2,"flexpage",0,"coursereplay",0 );
            $this->set_coursesubtitle(412,2,"flexpage",0,"coursesubtitle",1 );
            $this->set_courseteachingteam(413,2,"flexpage",0,"courseteachingteam","<p>Équipe pédagogique</p>" );
            $this->set_coursethematics(414,2,"flexpage",0,"coursethematics",1 );
            $this->set_coursethumbnailtext(415,2,"flexpage",0,"coursethumbnailtext","cours a venir / ouvert et places dispo" );
            $this->set_coursevideo(416,2,"flexpage",0,"coursevideo",0 );
            $this->set_coursevideoplayer(417,2,"flexpage",0,"coursevideoplayer",'<iframe width="560" height="315" src="https://www.youtube.com/embed/bNfYUsDSrOs?rel=0" frameborder="0" allowfullscreen></iframe>' );
            $this->set_courseworkingtime(418,2,"flexpage",0,"courseworkingtime",7200 );
            $this->set_description1(419,2,"flexpage",0,"description1","Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat." );
            $this->set_description2(420,2,"flexpage",0,"description2","Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat." );
            $this->set_description3(421,2,"flexpage",0,"description3","Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat." );
            $this->set_description4(422,2,"flexpage",0,"description4","Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat." );
            $this->set_description5(423,2,"flexpage",0,"description5","Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat." );
            $this->set_description6(424,2,"flexpage",0,"description6","Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat." );
            $this->set_description7(425,2,"flexpage",0,"description7","Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat." );
            $this->set_description8(426,2,"flexpage",0,"description8","Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat." );
            $this->set_description9(427,2,"flexpage",0,"description9","Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat." );
            $this->set_description10(428,2,"flexpage",0,"description10","Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat." );
            $this->set_paragraph1(429,2,"flexpage",0,"paragraph1","Titre Paragraphe 1" );
            $this->set_paragraph2(430,2,"flexpage",0,"paragraph2","Titre Paragraphe 2" );
            $this->set_paragraph3(431,2,"flexpage",0,"paragraph3","Titre Paragraphe 3" );
            $this->set_paragraph4(432,2,"flexpage",0,"paragraph4","Titre Paragraphe 4" );
            $this->set_paragraph5(433,2,"flexpage",0,"paragraph5","Titre Paragraphe 5" );
            $this->set_paragraph6(434,2,"flexpage",0,"paragraph6","Titre Paragraphe 6" );
            $this->set_paragraph7(435,2,"flexpage",0,"paragraph7","Titre Paragraphe 7" );
            $this->set_paragraph8(436,2,"flexpage",0,"paragraph8","Titre Paragraphe 8" );
            $this->set_paragraph9(437,2,"flexpage",0,"paragraph9","Titre Paragraphe 9" );
            $this->set_paragraph10(438,2,"flexpage",0,"paragraph10","Titre Paragraphe 10" );
            $this->set_paragraph1bgcolor(439,2,"flexpage",0,"paragraph1bgcolor","bg-green" );
            $this->set_paragraph2bgcolor(440,2,"flexpage",0,"paragraph2bgcolor","bg-graylighter" );
            $this->set_paragraph3bgcolor(441,2,"flexpage",0,"paragraph3bgcolor","bg-red" );
            $this->set_paragraph4bgcolor(442,2,"flexpage",0,"paragraph4bgcolor","bg-graylighter" );
            $this->set_paragraph5bgcolor(443,2,"flexpage",0,"paragraph5bgcolor","bg-yellow" );
            $this->set_paragraph6bgcolor(444,2,"flexpage",0,"paragraph6bgcolor","bg-graylighter" );
            $this->set_paragraph7bgcolor(445,2,"flexpage",0,"paragraph7bgcolor","bg-blue" );
            $this->set_paragraph8bgcolor(446,2,"flexpage",0,"paragraph8bgcolor","bg-graylighter" );
            $this->set_paragraph9bgcolor(447,2,"flexpage",0,"paragraph9bgcolor","bg-pink" );
            $this->set_paragraph10bgcolor(448,2,"flexpage",0,"paragraph10bgcolor","bg-graylighter" );
            $this->set_paragraph1picture(449,2,"flexpage",0,"paragraph1picture",181464878 );
            $this->set_paragraph2picture(450,2,"flexpage",0,"paragraph2picture",435990855 );
            $this->set_paragraph3picture(451,2,"flexpage",0,"paragraph3picture",257556141 );
            $this->set_paragraph4picture(452,2,"flexpage",0,"paragraph4picture",972257379 );
            $this->set_paragraph5picture(453,2,"flexpage",0,"paragraph5picture",25516927 );
            $this->set_paragraph6picture(454,2,"flexpage",0,"paragraph6picture",635357878 );
            $this->set_paragraph7picture(455,2,"flexpage",0,"paragraph7picture",396585880 );
            $this->set_paragraph8picture(456,2,"flexpage",0,"paragraph8picture",412869366 );
            $this->set_paragraph9picture(457,2,"flexpage",0,"paragraph9picture",653207731 );
            $this->set_paragraph10picture(458,2,"flexpage",0,"paragraph10picture",730279675 );
            $this->set_paragraphheader(459,2,"flexpage",0,"paragraphheader","" );




        $this->save_extended_course_value($id, 1, 'flexpage', 0, 'table', "course_format_options");
        $this->save_extended_course_value($id++, $coursebadge->courseid, $coursebadge->format, $coursebadge->sectionid, $coursebadge->name, $coursebadge->value);
        $this->save_extended_course_value($id++, $coursecertification->courseid, $coursecertification->format, $coursecertification->sectionid, $coursecertification->name, $coursecertification->value);
        $this->save_extended_course_value($id++, $coursecontactemail->courseid, $coursecontactemail->format, $coursecontactemail->sectionid, $coursecontactemail->name, $coursecontactemail->value);
        $this->save_extended_course_value($id++, $courseduration->courseid, $courseduration->format, $courseduration->sectionid, $courseduration->name, $courseduration->value);
        $this->save_extended_course_value($id++, $courseenddate->courseid, $courseenddate->format, $courseenddate->sectionid, $courseenddate->name, $courseenddate->value);
        $this->save_extended_course_value($id++, $courseinactivitydelay->courseid, $courseinactivitydelay->format, $courseinactivitydelay->sectionid, $courseinactivitydelay->name, $courseinactivitydelay->value);
        $this->save_extended_course_value($id++, $courselanguage->courseid, $courselanguage->format, $courselanguage->sectionid, $courselanguage->name, $courselanguage->value);
        $this->save_extended_course_value($id++, $coursemaxregisteredusers->courseid, $coursemaxregisteredusers->format, $coursemaxregisteredusers->sectionid, $coursemaxregisteredusers->name, $coursemaxregisteredusers->value);
        $this->save_extended_course_value($id++, $coursepicture->courseid, $coursepicture->format, $coursepicture->sectionid, $coursepicture->name, $coursepicture->value);
        $this->save_extended_course_value($id++, $courseprerequesites->courseid, $courseprerequesites->format, $courseprerequesites->sectionid, $courseprerequesites->name, $courseprerequesites->value);
        $this->save_extended_course_value($id++, $courseprice->courseid, $courseprice->format, $courseprice->sectionid, $courseprice->name, $courseprice->value);
        $this->save_extended_course_value($id++, $courseregistration->courseid, $courseregistration->format, $courseregistration->sectionid, $courseregistration->name, $courseregistration->value);
        $this->save_extended_course_value($id++, $coursereplay->courseid, $coursereplay->format, $coursereplay->sectionid, $coursereplay->name, $coursereplay->value);
        $this->save_extended_course_value($id++, $coursesubtitle->courseid, $coursesubtitle->format, $coursesubtitle->sectionid, $coursesubtitle->name, $coursesubtitle->value);
        $this->save_extended_course_value($id++, $courseteachingteam->courseid, $courseteachingteam->format, $courseteachingteam->sectionid, $courseteachingteam->name, $courseteachingteam->value);
        $this->save_extended_course_value($id++, $coursethematics->courseid, $coursethematics->format, $coursethematics->sectionid, $coursethematics->name, $coursethematics->value);
        $this->save_extended_course_value($id++, $coursethumbnailtext->courseid, $coursethumbnailtext->format, $coursethumbnailtext->sectionid, $coursethumbnailtext->name, $coursethumbnailtext->value);
        $this->save_extended_course_value($id++, $coursevideo->courseid, $coursevideo->format, $coursevideo->sectionid, $coursevideo->name, $coursevideo->value);
        $this->save_extended_course_value($id++, $coursevideoplayer->courseid, $coursevideoplayer->format, $coursevideoplayer->sectionid, $coursevideoplayer->name, $coursevideoplayer->value);
        $this->save_extended_course_value($id++, $courseworkingtime->courseid, $courseworkingtime->format, $courseworkingtime->sectionid, $courseworkingtime->name, $courseworkingtime->value);
        $this->save_extended_course_value($id++, $description1->courseid, $description1->format, $description1->sectionid, $description1->name, $description1->value);
        $this->save_extended_course_value($id++, $description10->courseid, $description10->format, $description10->sectionid, $description10->name, $description10->value);
        $this->save_extended_course_value($id++, $description2->courseid, $description2->format, $description2->sectionid, $description2->name, $description2->value);
        $this->save_extended_course_value($id++, $description3->courseid, $description3->format, $description3->sectionid, $description3->name, $description3->value);
        $this->save_extended_course_value($id++, $description4->courseid, $description4->format, $description4->sectionid, $description4->name, $description4->value);
        $this->save_extended_course_value($id++, $description5->courseid, $description5->format, $description5->sectionid, $description5->name, $description5->value);
        $this->save_extended_course_value($id++, $description6->courseid, $description6->format, $description6->sectionid, $description6->name, $description6->value);
        $this->save_extended_course_value($id++, $description7->courseid, $description7->format, $description7->sectionid, $description7->name, $description7->value);
        $this->save_extended_course_value($id++, $description8->courseid, $description8->format, $description8->sectionid, $description8->name, $description8->value);
        $this->save_extended_course_value($id++, $description9->courseid, $description9->format, $description9->sectionid, $description9->name, $description9->value);
        $this->save_extended_course_value($id++, $paragraph1->courseid, $paragraph1->format, $paragraph1->sectionid, $paragraph1->name, $paragraph1->value);
        $this->save_extended_course_value($id++, $paragraph10->courseid, $paragraph10->format, $paragraph10->sectionid, $paragraph10->name, $paragraph10->value);
        $this->save_extended_course_value($id++, $paragraph2->courseid, $paragraph2->format, $paragraph2->sectionid, $paragraph2->name, $paragraph2->value);
        $this->save_extended_course_value($id++, $paragraph3->courseid, $paragraph3->format, $paragraph3->sectionid, $paragraph3->name, $paragraph3->value);
        $this->save_extended_course_value($id++, $paragraph4->courseid, $paragraph4->format, $paragraph4->sectionid, $paragraph4->name, $paragraph4->value);
        $this->save_extended_course_value($id++, $paragraph5->courseid, $paragraph5->format, $paragraph5->sectionid, $paragraph5->name, $paragraph5->value);
        $this->save_extended_course_value($id++, $paragraph6->courseid, $paragraph6->format, $paragraph6->sectionid, $paragraph6->name, $paragraph6->value);
        $this->save_extended_course_value($id++, $paragraph7->courseid, $paragraph7->format, $paragraph7->sectionid, $paragraph7->name, $paragraph7->value);
        $this->save_extended_course_value($id++, $paragraph8->courseid, $paragraph8->format, $paragraph8->sectionid, $paragraph8->name, $paragraph8->value);
        $this->save_extended_course_value($id++, $paragraph9->courseid, $paragraph9->format, $paragraph9->sectionid, $paragraph9->name, $paragraph9->value);
        $this->save_extended_course_value($id++, $paragraph1bgcolor->courseid, $paragraph1bgcolor->format, $paragraph1bgcolor->sectionid, $paragraph1bgcolor->name, $paragraph1bgcolor->value);
        $this->save_extended_course_value($id++, $paragraph10bgcolor->courseid, $paragraph10bgcolor->format, $paragraph10bgcolor->sectionid, $paragraph10bgcolor->name, $paragraph10bgcolor->value);
        $this->save_extended_course_value($id++, $paragraph2bgcolor->courseid, $paragraph2bgcolor->format, $paragraph2bgcolor->sectionid, $paragraph2bgcolor->name, $paragraph2bgcolor->value);
        $this->save_extended_course_value($id++, $paragraph3bgcolor->courseid, $paragraph3bgcolor->format, $paragraph3bgcolor->sectionid, $paragraph3bgcolor->name, $paragraph3bgcolor->value);
        $this->save_extended_course_value($id++, $paragraph4bgcolor->courseid, $paragraph4bgcolor->format, $paragraph4bgcolor->sectionid, $paragraph4bgcolor->name, $paragraph4bgcolor->value);
        $this->save_extended_course_value($id++, $paragraph5bgcolor->courseid, $paragraph5bgcolor->format, $paragraph5bgcolor->sectionid, $paragraph5bgcolor->name, $paragraph5bgcolor->value);
        $this->save_extended_course_value($id++, $paragraph6bgcolor->courseid, $paragraph6bgcolor->format, $paragraph6bgcolor->sectionid, $paragraph6bgcolor->name, $paragraph6bgcolor->value);
        $this->save_extended_course_value($id++, $paragraph7bgcolor->courseid, $paragraph7bgcolor->format, $paragraph7bgcolor->sectionid, $paragraph7bgcolor->name, $paragraph7bgcolor->value);
        $this->save_extended_course_value($id++, $paragraph8bgcolor->courseid, $paragraph8bgcolor->format, $paragraph8bgcolor->sectionid, $paragraph8bgcolor->name, $paragraph8bgcolor->value);
        $this->save_extended_course_value($id++, $paragraph9bgcolor->courseid, $paragraph9bgcolor->format, $paragraph9bgcolor->sectionid, $paragraph9bgcolor->name, $paragraph9bgcolor->value);
        $this->save_extended_course_value($id++, $paragraph1picture->courseid, $paragraph1picture->format, $paragraph1picture->sectionid, $paragraph1picture->name, $paragraph1picture->value);
        $this->save_extended_course_value($id++, $paragraph10picture->courseid, $paragraph10picture->format, $paragraph10picture->sectionid, $paragraph10picture->name, $paragraph10picture->value);
        $this->save_extended_course_value($id++, $paragraph2picture->courseid, $paragraph2picture->format, $paragraph2picture->sectionid, $paragraph2picture->name, $paragraph2picture->value);
        $this->save_extended_course_value($id++, $paragraph3picture->courseid, $paragraph3picture->format, $paragraph3picture->sectionid, $paragraph3picture->name, $paragraph3picture->value);
        $this->save_extended_course_value($id++, $paragraph4picture->courseid, $paragraph4picture->format, $paragraph4picture->sectionid, $paragraph4picture->name, $paragraph4picture->value);
        $this->save_extended_course_value($id++, $paragraph5picture->courseid, $paragraph5picture->format, $paragraph5picture->sectionid, $paragraph5picture->name, $paragraph5picture->value);
        $this->save_extended_course_value($id++, $paragraph6picture->courseid, $paragraph6picture->format, $paragraph6picture->sectionid, $paragraph6picture->name, $paragraph6picture->value);
        $this->save_extended_course_value($id++, $paragraph7picture->courseid, $paragraph7picture->format, $paragraph7picture->sectionid, $paragraph7picture->name, $paragraph7picture->value);
        $this->save_extended_course_value($id++, $paragraph8picture->courseid, $paragraph8picture->format, $paragraph8picture->sectionid, $paragraph8picture->name, $paragraph8picture->value);
        $this->save_extended_course_value($id++, $paragraph9picture->courseid, $paragraph9picture->format, $paragraph9picture->sectionid, $paragraph9picture->name, $paragraph9picture->value);
        $this->save_extended_course_value($id++, $paragraphheader->courseid, $paragraphheader->format, $paragraphheader->sectionid, $paragraphheader->name, $paragraphheader->value);



        $this->save_extended_course_value($id++, 1, 'flexpage', 0, 'picture', 381002270);
        $this->save_extended_course_value($id++, 1, 'flexpage', 0, 'replay', "Rejouable");
        $this->save_extended_course_value($id++, 1, 'flexpage', 0, 'duration', 5);
        $this->save_extended_course_value($id++, 1, 'flexpage', 0, 'workingtime', 1);
        $this->save_extended_course_value($id++, 1, 'flexpage', 0, 'badge', 1);
        $this->save_extended_course_value($id++, 1, 'flexpage', 0, 'certification', 1);
        $this->save_extended_course_value($id++, 1, 'flexpage', 0, 'price', "Mooc gratuit<br>certification en option");
        $this->save_extended_course_value($id++, 1, 'flexpage', 0, 'language', "Français");
        $this->save_extended_course_value($id++, 1, 'flexpage', 0, 'subtitle', 1);
        $this->save_extended_course_value($id++, 1, 'flexpage', 0, 'registration', 0);
        $this->save_extended_course_value($id++, 1, 'flexpage', 0, 'registrationcompany', 7);
        $this->save_extended_course_value($id++, 1, 'flexpage', 0, 'maxregisteredusers', 1000);
        $this->save_extended_course_value($id++, 1, 'flexpage', 0, 'registrationstartdate', 1462377425);
        $this->save_extended_course_value($id++, 1, 'flexpage', 0, 'registrationenddate', 1467496800);
        $this->save_extended_course_value($id++, 1, 'flexpage', 0, 'prerequesites', "<p>Prérequis</p>");
        $this->save_extended_course_value($id++, 1, 'flexpage', 0, 'teachingteam', "<p>Équipe pédagogique</p>");
        $this->save_extended_course_value($id++, 1, 'flexpage', 0, 'enrolurl', "http://10.194.54.237/enrol/orangeinvitation/enrol.php?enrolinvitationtoken=92a0490d5105b109df86074dc430e3e6&id=2&id2=1");
        $this->save_extended_course_value($id++, 1, 'flexpage', 0, 'unenrolurl', array
        (
            "scheme" => "http",
            "host" => "solerni",
            "port" => "",
            "user" => "",
            "pass"=> "",
            "path" => '/enrol/self/unenrolself.php',
            "slashargument" => "",
            "anchor"=> "",
            "params" => Array
                (
                    "enrolid" => 3
                )

        ));
        $this->save_extended_course_value($id++, 1, 'flexpage', 0, 'coursestatus', 6);
        $this->save_extended_course_value($id++, 1, 'flexpage', 0, 'registrationstatustext', "Inscription ouverte");
        $this->save_extended_course_value($id++, 1, 'flexpage', 0, 'replay', "Rejouable");
        $this->save_extended_course_value($id++, 1, 'flexpage', 0, 'statuslink', array
        (
            "scheme" => "http",
            "host" => "solerni",
            "port" => "",
            "user" => "",
            "pass"=> "",
            "path" => '/enrol/self/unenrolself.php',
            "slashargument" => "",
            "anchor"=> "",
            "params" => Array
                (
                    "enrolid" => 3
                )

        ));
        $this->save_extended_course_value($id++, 1, 'flexpage', 0, 'statustext', "En cours");
        $this->save_extended_course_value($id++, 1, 'flexpage', 0, 'coursestatustext', "En cours");
        $this->save_extended_course_value($id++, 1, 'flexpage', 0, 'registrationstatus', 1);
        $this->save_extended_course_value($id++, 1, 'flexpage', 0, 'registrationstatustext', "Inscription ouverte");
        $this->save_extended_course_value($id++, 1, 'flexpage', 0, 'thumbnailtext', "cours a venir / ouvert et places dispo");
        $this->save_extended_course_value($id++, 1, 'flexpage', 0, 'enrolledusers', 2);
        $this->save_extended_course_value($id++, 1, 'flexpage', 0, 'enrolledusersself', 2);
        $this->save_extended_course_value($id++, 1, 'flexpage', 0, 'enrolstartdate', 1434618300);
        $this->save_extended_course_value($id++, 1, 'flexpage', 0, 'enrolenddate', 1468832700);
        $this->save_extended_course_value($id++, 1, 'flexpage', 0, 'displaybutton', '<a class="btn btn-success" href="http://solerni/course/view.php?id=2" data-mooc-name="a venir ouvert et places dispos">Accéder au cours</a>');
        $this->save_extended_course_value($id++, 1, 'flexpage', 0, 'videoplayer', '<iframe width="560" height="315" src="https://www.youtube.com/embed/bNfYUsDSrOs?rel=0" frameborder="0" allowfullscreen></iframe>');
        $this->save_extended_course_value($id++, 1, 'flexpage', 0, 'inactivitydelay', 7);
        $this->save_extended_course_value($id++, 1, 'flexpage', 0, 'contactemail', "contact@email.com");
        $this->save_extended_course_value($id++, 1, 'flexpage', 0, 'newsessionurl', 'http://10.194.54.237/enrol/orangeinvitation/enrol.php?enrolinvitationtoken=92a0490d5105b109df86074dc430e3e6&id=2&id2=2');
        $this->save_extended_course_value($id++, 1, 'flexpage', 0, 'moocurl', Array
        (
            "scheme" => "http",
            "host" => "solerni",
            "port" => "",
            "user" => "",
            "pass" => "",
            "path" => "/course/view.php",
            "slashargument" => "",
            "anchor" => "",
            "params" => Array
                (
                    "id"=> 2
                )

        ));
        $this->save_extended_course_value($id++, 1, 'flexpage', 0, 'statuslinktext', '');

    }

    private function save_extended_course_value($id, $courseid, $format, $sectionid, $name, $value){
        $record = make_record($id, $courseid, $format, $sectionid, $name, $value);
        $DB->insert_record('course_format_options', $record);
    }

    public function is_available($not, \core_availability\info $info, $grabthelot, $userid) {
        return $not ? !$this->available : $this->available;
    }

    public function is_available_for_all($not = false) {
        return $not ? $this->forallnot : $this->forall;
    }

    public function get_description($full, $not, \core_availability\info $info) {
        $fulltext = $full ? '[FULL]' : '';
        $nottext = $not ? '!' : '';
        return $nottext . $fulltext . $this->message;
    }

    public function get_standalone_description(
            $full, $not, \core_availability\info $info) {
        // Override so that we can spot that this function is used.
        return 'SA: ' . $this->get_description($full, $not, $info);
    }

    public function update_dependency_id($table, $oldid, $newid) {
        if ($table === $this->dependtable && (int)$oldid === (int)$this->dependid) {
            $this->dependid = $newid;
            return true;
        } else {
            return false;
        }
    }

    protected function get_debug_string() {
        return ($this->available ? 'y' : 'n') . ',' . $this->message;
    }

    public function is_applied_to_user_lists() {
        return $this->filter;
    }

    public function filter_user_list(array $users, $not, \core_availability\info $info,
            \core_availability\capability_checker $checker) {
        $result = array();
        foreach ($users as $id => $user) {
            $match = in_array($id, $this->filter);
            if ($not) {
                $match = !$match;
            }
            if ($match) {
                $result[$id] = $user;
            }
        }
        return $result;
    }

    public function get_user_list_sql($not, \core_availability\info $info, $onlyactive) {
        global $DB;
        // The data for this condition is not really stored in the database,
        // so we return SQL that contains the hard-coded user list.
        list ($enrolsql, $enrolparams) =
                get_enrolled_sql($info->get_context(), '', 0, $onlyactive);
        $condition = $not ? 'NOT' : '';
        list ($matchsql, $matchparams) = $DB->get_in_or_equal($this->filter, SQL_PARAMS_NAMED);
        $sql = "SELECT userids.id
                  FROM ($enrolsql) userids
                 WHERE $condition (userids.id $matchsql)";
        return array($sql, array_merge($enrolparams, $matchparams));
    }
}
