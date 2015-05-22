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
 * @package    blocks
 * @subpackage course_extended
 * @copyright  2015 Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
use local_orangelibrary\extendedcourse\extendedcourse_object;

defined('MOODLE_INTERNAL') || die();


class block_course_extended_renderer extends plugin_renderer_base {

    public function init() {
        $extendedcourse = new extendedcourse_object();
        $extendedcourse->get_extendedcourse($course->id, $context);
    }

    /**
     *  Set the button in the block.
     *
     * @param object $context
     * @param object $course
     * @param object $this->extendedcourse
     * @return string html_writer::tag
     */
    public function set_button($context, $course) {
        $text = "";
        $date = new DateTime();
        $extendedcourse = new extendedcourse_object();
        $extendedcourse->get_extendedcourse($course->id, $context);

        $urlmoocsubsription = new moodle_url('/course/view.php', array('id' => $course->id));
        $moocurl = new moodle_url('/course/view.php', array('id' => $course->id));
        //   Mooc terminé et rejouable c’est-à-dire que la date du mooc est passée mais l’utilisateur.
        //   Peut demander à être averti lorsque la prochaine session du mooc débutera.
        //   Mooc terminé cad que la date de fin du mooc est dépassée.
        if ($extendedcourse->enrolledusers >= $extendedcourse->maxregisteredusers) {
            //   Mooc complet : l’inscription est limitée aux X premiers inscrits";.
            //   CAS G : FICHE PRODUIT - MOOC COMPLET - UTILISATEUR CONNECTE OU NON CONNECTE";.
            return html_writer::tag('span', get_string('mooc_complete', 'block_course_extended'));
        } else {
            if ($extendedcourse->enddate < $date->getTimestamp()) {
                //   Mooc terminé";.
                if ($extendedcourse->replay == get_string('replay', 'format_flexpage')) {
                    //   Mooc rejouable";.
                    //   CAS E : FICHE PRODUIT - MOOC TERMINE ET REJOUABLE - UTILISATEUR CONNECTE OU NON CONNECTE";.
                    $text .= html_writer::tag('span', get_string('status_closed', 'block_course_extended'));
                    $text .= html_writer::empty_tag('br');
                    $text .= html_writer::tag('a', get_string('alert_mooc', 'block_course_extended'),
                            array('class' => 'btn btn-primary', 'href' => $moocurl));
                    return $text;
                } else {
                    //   Mooc non rejouable";.
                    //   CAS D : FICHE PRODUIT - MOOC TERMINE - UTILISATEUR CONNECTE OU NON CONNECTE";.
                    return  html_writer::tag('span', get_string('status_closed', 'block_course_extended'));
                }
            } else if ($course->startdate > $date->getTimestamp()) {
                //   Mooc non ouvert";.
                if (!isloggedin()) {
                    //   Utilisateur non connecté à Solerni";.
                    //   Utilisateur non inscrit au mooc";.
                    //   CAS A : FICHE PRODUIT - MOOC NON REJOINT - UTILISATEUR CONNECTE OU NON CONNECTE";.
                    return html_writer::tag('a', get_string('subscribe_to_mooc', 'block_course_extended'),
                            array('class' => 'btn btn-primary', 'href' => $urlmoocsubsription));
                } else {
                    //   Utilisateur connecté à Solerni";.
                    if (!is_enrolled($context)) {
                        //   Utilisateur non inscrit au mooc";.
                        //   CAS A : FICHE PRODUIT - MOOC NON REJOINT - UTILISATEUR CONNECTE OU NON CONNECTE";.
                        return html_writer::tag('a', get_string('subscribe_to_mooc', 'block_course_extended'),
                                array('class' => 'btn btn-primary', 'href' => $urlmoocsubsription));
                    } else {
                        //   Utilisateur inscrit au mooc";.
                        //   CAS C : FICHE PRODUIT - MOOC REJOINT A VENIR - UTILISATEUR CONNECTE";.
                        $text = get_string('mooc_open_date', 'block_course_extended') . date("d-m-Y", $course->startdate);
                        return html_writer::tag('a', $text, array('class' => 'btn btn-unavailable btn-disabled'));
                    }
                }
            } else {
                //   Mooc en cours";.
                if ($extendedcourse->registration_enddate < $date->getTimestamp()) {
                    //   Mooc en cours et date d'inscription passée";.
                    if (!isloggedin()) {
                        //   Utilisateur non connecté à Solerni";.
                        //   Utilisateur non inscrit au mooc";.
                        //   CAS F : FICHE PRODUIT - INSCRIPTION AU MOOC TERMINEE - UTILISATEUR CONNECTE OU NON CONNECTE";.
                        return  html_writer::tag('span', get_string('registration_stopped', 'block_course_extended'));
                    } else {
                        //   Utilisateur connecté à Solerni";.
                        if (!is_enrolled($context)) {
                            //   Utilisateur non inscrit au mooc";.
                            //   CAS F : FICHE PRODUIT - INSCRIPTION AU MOOC TERMINEE - UTILISATEUR CONNECTE OU NON CONNECTE";.
                            return  html_writer::tag('span', get_string('registration_stopped', 'block_course_extended'));
                        } else {
                            //   Utilisateur inscrit au mooc";.
                            //   CAS B : FICHE PRODUIT - MOOC REJOINT EN COURS - UTILISATEUR CONNECTE";.
                            return html_writer::tag('a', get_string('access_to_mooc', 'block_course_extended'),
                                    array('class' => 'btn btn-access', 'href' => $moocurl));
                        }
                    }
                } else {
                    if (!isloggedin()) {
                        //   Utilisateur non connecté à Solerni";.
                        //   Utilisateur non inscrit au mooc";.
                        //   CAS A : FICHE PRODUIT - MOOC NON REJOINT - UTILISATEUR CONNECTE OU NON CONNECTE";.
                        return html_writer::tag('a', get_string('access_to_mooc', 'block_course_extended'),
                                array('class' => 'btn btn-access', 'href' => $moocurl));
                    } else {
                        //   Utilisateur connecté à Solerni";.
                        if (!is_enrolled($context)) {
                            //   Utilisateur non inscrit au mooc";.
                            //   CAS A : FICHE PRODUIT - MOOC NON REJOINT - UTILISATEUR CONNECTE OU NON CONNECTE";.
                            return html_writer::tag('a', get_string('access_to_mooc', 'block_course_extended'),
                                    array('class' => 'btn btn-access', 'href' => $moocurl));
                        } else {
                            //   Utilisateur inscrit au mooc";.
                            //   CAS B : FICHE PRODUIT - MOOC REJOINT EN COURS - UTILISATEUR CONNECTE";.
                            return html_writer::tag('a', get_string('access_to_mooc', 'block_course_extended'),
                                    array('class' => 'btn btn-access', 'href' => $moocurl));
                        }
                    }
                }
            }
        }
    }

    /**
     *  Set the dicplayed text in the block.
     *
     * @param moodle_url $imgurl
     * @param object $course
     * @param object $context
     * @return string $text
     */
    public function get_text($imgurl, $course, $context) {
        $extendedcourse = new extendedcourse_object();
        $extendedcourse->get_extendedcourse($course->id, $context);
        print_object($extendedcourse) ;
        $text = html_writer::start_tag('div', array('class' => 'sider'));
        $language = get_string('french', 'format_flexpage');
        $registrationvalue = get_string('registration_case1', 'format_flexpage');
        if ($imgurl) {
            $text .= html_writer::empty_tag('img', array('src' => $imgurl));
        }
        $text .= html_writer::tag('h2', $course->fullname.' ');
            $text .= html_writer::start_tag('div', array('class' => 'sider__content'));
                $text .= html_writer::start_tag('ul', array('class' => 'essentiels'));
                   $text .= html_writer::start_tag('li');
                        $text .= html_writer::start_tag('i', array('class' => 'essentiels-icon essentiels__date'));
                        $text .= html_writer::end_tag('i');
                        $text .= html_writer::tag('span', get_string('startdate', 'format_flexpage'));
                        $text .= html_writer::empty_tag('br');
                        $text .= html_writer::tag('span', date("d-m-Y", $course->startdate), array('class' => 'slrn-bold'));
                        $text .= html_writer::empty_tag('br');
                        $text .= html_writer::tag('span', get_string('enddate', 'format_flexpage'));
                        $text .= html_writer::empty_tag('br');
                        $enddate = $extendedcourse->enddate;
                        $text .= html_writer::tag('span', date("d-m-Y", $enddate), array('class' => 'slrn-bold'));
                    $text .= html_writer::end_tag('li');
                    $text .= html_writer::start_tag('li');
                        $text .= html_writer::start_tag('i', array('class' => 'essentiels-icon essentiels__duration'));
                        $text .= html_writer::end_tag('i');
                        $text .= html_writer::tag('span', get_string('duration', 'format_flexpage'));
                        $text .= html_writer::empty_tag('br');
                        $text .= html_writer::tag('span', $extendedcourse->duration.' ', array('class' => 'slrn-bold'));
                        $text .= html_writer::empty_tag('br');
                        $text .= html_writer::tag('span', get_string('workingtime', 'format_flexpage'));
                        $text .= html_writer::empty_tag('br');
                        $text .= html_writer::tag('span', $extendedcourse->workingtime, array('class' => 'slrn-bold'));
                    $text .= html_writer::end_tag('li');
                    $text .= html_writer::start_tag('li');
                        $text .= html_writer::start_tag('i', array('class' => 'essentiels-icon essentiels__price'));
                        $text .= html_writer::end_tag('i');
                        $text .= html_writer::tag('span', get_string('price', 'format_flexpage'));
                        $text .= html_writer::empty_tag('br');
                        $text .= html_writer::tag('span', $extendedcourse->price.' ', array('class' => 'slrn-bold'));
                    $text .= html_writer::end_tag('li');
        if (!empty($extendedcourse->badge)||!empty($extendedcourse->certification)) {
                    $text .= html_writer::start_tag('li');
                        $text .= html_writer::start_tag('i', array('class' => 'essentiels-icon essentiels__certification'));
                        $text .= html_writer::end_tag('i');
                        $text .= html_writer::tag('span', get_string('certification', 'format_flexpage'));
                        $text .= html_writer::empty_tag('br');
            if (!empty($extendedcourse->badge)) {
                        $text .= html_writer::tag('span', get_badges_string().' ', array('class' => 'slrn-bold'));
            }
            if (!empty($extendedcourse->certification)) {
                        $text .= html_writer::tag('span', $extendedcourse->certification.' ', array('class' => 'slrn-bold'));
            }
                    $text .= html_writer::end_tag('li');
        }
                    $text .= html_writer::start_tag('li');
                        $text .= html_writer::start_tag('i', array('class' => 'essentiels-icon essentiels__language'));
                        $text .= html_writer::end_tag('i');
                        $text .= html_writer::tag('span', get_string('language').':');
                        $text .= html_writer::empty_tag('br');
        if (!empty($extendedcourse->language)) {
                            $language = $extendedcourse->language;
        }
                        $text .= html_writer::tag('span', $language.' ', array('class' => 'slrn-bold'));
                    $text .= html_writer::end_tag('li');
        if (!empty($extendedcourse->video)) {
                    $text .= html_writer::start_tag('li');
                        $text .= html_writer::start_tag('i', array('class' => 'essentiels-icon essentiels__video'));
                        $text .= html_writer::end_tag('i');
                        $text .= html_writer::tag('span', get_string('video', 'format_flexpage'));
                        $text .= html_writer::empty_tag('br');
            if (!empty($extendedcourse->subtitle)) {
                            $language = $extendedcourse->language;
                            $subtitle = $extendedcourse->subtitle;
                        $text .= html_writer::tag('span', $language.' '.$subtitle.' ', array('class' => 'slrn-bold'));
            }
                    $text .= html_writer::end_tag('li');
        }
                        $text .= html_writer::start_tag('li');
                        $text .= html_writer::start_tag('i', array('class' => 'essentiels-icon essentiels__subscription'));
                        $text .= html_writer::end_tag('i');
                        $text .= html_writer::tag('span', get_string('registration', 'format_flexpage'));
                        $text .= html_writer::empty_tag('br');
                        $registrationvalue = $this->get_registration($extendedcourse);

                        $text .= html_writer::tag('span', $registrationvalue.' ', array('class' => 'slrn-bold'));
                    $text .= html_writer::end_tag('li');
                    $text .= html_writer::start_tag('li');
                        $text .= html_writer::start_tag('i', array('class' => 'essentiels-icon essentiels__subscribers'));
                        $text .= html_writer::end_tag('i');
                        $text .= html_writer::tag('span', get_string('registeredusers', 'format_flexpage'));
                        $text .= html_writer::empty_tag('br');
                        $text .= html_writer::tag('span', $extendedcourse->enrolledusers.' ', array('class' => 'slrn-bold'));
                    $text .= html_writer::end_tag('li');
                    $text .= html_writer::start_tag('li');
                    $text .= $this->set_button($context, $course);
                    $text .= html_writer::end_tag('li');
                    $text .= html_writer::start_tag('li');
                        $text .= html_writer::empty_tag('br');
                        $text .= html_writer::tag('span', get_string('status', 'format_flexpage'));
                        $text .= html_writer::empty_tag('br');
                        $text .= html_writer::tag('span', $extendedcourse->status.' ', array('class' => 'slrn-bold'));
                    $text .= html_writer::end_tag('li');
                $text .= html_writer::end_tag('ul');
            $text .= html_writer::end_tag('div');
        $text .= html_writer::tag('h2', get_string('prerequesites', 'format_flexpage'));
            $text .= html_writer::empty_tag('br');
            $text .= html_writer::start_tag('div', array('class' => 'sider__content'));
                $text .= html_writer::start_tag('ul', array('class' => 'essentiels'));
                    $text .= html_writer::start_tag('li');
                    $prerequesites = $extendedcourse->prerequesites;
                    $text .= html_writer::tag('span', $prerequesites.' ', array('class' => 'slrn-bold'));
                    $text .= html_writer::end_tag('li');
                $text .= html_writer::end_tag('ul');
            $text .= html_writer::end_tag('div');
        $text .= html_writer::tag('h2', get_string('teachingteam', 'format_flexpage'));
            $text .= html_writer::empty_tag('br');
            $text .= html_writer::start_tag('div', array('class' => 'sider__content'));
                $text .= html_writer::start_tag('ul', array('class' => 'essentiels'));
                    $text .= html_writer::start_tag('li');
                    $teachingteam = $extendedcourse->teachingteam;
                    $text .= html_writer::tag('span', $teachingteam.' ', array('class' => 'slrn-bold'));
                    $text .= html_writer::end_tag('li');
                $text .= html_writer::end_tag('ul');
            $text .= html_writer::end_tag('div');
        $text .= html_writer::end_tag('div');

        return $text;

    }

    /**
     * Set the extended course values from config.
     *
     * @param object $context
     * @return object $this->extendedcourse
     */
    public function get_nb_users_enrolled_in_course ($course) {
        global $DB;
        $courseid = $course->id;
        $sqlrequest = "SELECT DISTINCT u.id AS userid, c.id AS courseid
        FROM mdl_user u
        JOIN mdl_user_enrolments ue ON ue.userid = u.id
        JOIN mdl_enrol e ON e.id = ue.enrolid
        JOIN mdl_role_assignments ra ON ra.userid = u.id
        JOIN mdl_context ct ON ct.id = ra.contextid AND ct.contextlevel = 50
        JOIN mdl_course c ON c.id = ct.instanceid AND e.courseid = ". $courseid."
        JOIN mdl_role r ON r.id = ra.roleid AND r.shortname = 'student'
        WHERE e.status = 0 AND u.suspended = 0 AND u.deleted = 0
        AND (ue.timeend = 0 OR ue.timeend > NOW()) AND ue.status = 0";
        $enrolledusers = $DB->get_records_sql($sqlrequest);
        $nbenrolledusers = count ($enrolledusers);
        return $nbenrolledusers;

    }

    /**
     *  Set the extended course registration values from the extended course registration.
     *
     * @param object $extendedcourse
     * @return object $this->extendedcourse
     */
    private function get_registration ($extendedcourse) {
        if (!empty($extendedcourse->registration)) {
            switch ($extendedcourse->registration) {
                case '0':
                    $registrationvalue = get_string('registration_case1', 'block_course_extended').
                    get_string('registration_from', 'block_course_extended').
                    date("d-m-Y", $extendedcourse->registrationstartdate).
                    get_string('registration_to', 'block_course_extended').
                    date("d-m-Y", $extendedcourse->registrationenddate);
                break;
                case '1':
                    $registrationvalue = get_string('registration_case2', 'block_course_extended').
                    $extendedcourse->maxregisteredusers.' '.
                    get_string('registration_case2_2', 'block_course_extended').
                    get_string('registration_from', 'block_course_extended').
                    date("d-m-Y", $extendedcourse->registrationstartdate).
                    get_string('registration_to', 'block_course_extended').
                    date("d-m-Y", $extendedcourse->registrationenddate);
                break;
                case '2':

                    $registrationvalue = get_string('registration_case3', 'block_course_extended').
                    $extendedcourse->registrationcompany.
                    get_string('registration_from', 'block_course_extended').
                    date("d-m-Y", $extendedcourse->registrationstartdate).
                    get_string('registration_to', 'block_course_extended').
                    date("d-m-Y", $extendedcourse->registrationenddate);
                break;
            }
            return $registrationvalue;
        }
    }



}
