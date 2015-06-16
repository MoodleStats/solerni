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
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace local_orange_library\subscription_button;

use local_orange_library\extended_course\extended_course_object;
use local_orange_library\enrollment\enrollment_object;
use html_writer;
use DateTime;
use moodle_url;
use context_course;

defined('MOODLE_INTERNAL') || die();

class subscription_button_object {

    /**
     *  Set the button in the block.
     *
     * @param object $context
     * @param object $course
     * @return string html_writer::tag
     */
    public static function set_button($course) {
        $text = "";
        $date = new DateTime();
        $extendedcourse = new extended_course_object();
        $context = context_course::instance($course->id);
        $extendedcourse->get_extended_course($course, $context);

        $selfenrolment = new enrollment_object();
        $instance = new \stdClass();
        $instance->enrolstartdate = $selfenrolment->get_enrolment_startdate($course);
        $instance->enrolenddate = $selfenrolment->get_enrolment_enddate($course);

        $urlregistration = new moodle_url('/login/signup.php', array('id' => $course->id));
        $urlmoocsubscription = new moodle_url('/enrol/index.php', array('id' => $course->id));
        $moocurl = new moodle_url('/course/view.php', array('id' => $course->id));
        //   Mooc terminé et rejouable c’est-à-dire que la date du mooc est passée mais l’utilisateur.
        //   Peut demander à être averti lorsque la prochaine session du mooc débutera.
        //   Mooc terminé cad que la date de fin du mooc est dépassée.
        if ($extendedcourse->maxregisteredusers && $extendedcourse->enrolledusers >= $extendedcourse->maxregisteredusers) {
            //   Mooc complet : l’inscription est limitée aux X premiers inscrits";.
            //   CAS G : FICHE PRODUIT - MOOC COMPLET - UTILISATEUR CONNECTE OU NON CONNECTE";.
            return html_writer::tag('span', get_string('mooc_complete', 'local_orange_library'));
        } else {
            if ($extendedcourse->enddate < $date->getTimestamp()) {
                //   Mooc terminé";.
                if ($extendedcourse->replay == get_string('replay', 'format_flexpage')) {
                    //   Mooc rejouable";.
                    //   CAS E : FICHE PRODUIT - MOOC TERMINE ET REJOUABLE - UTILISATEUR CONNECTE OU NON CONNECTE";.
                    $text .= html_writer::tag('span', get_string('status_closed', 'local_orange_library'));
                    $text .= html_writer::empty_tag('br');
                    $text .= html_writer::tag('a', get_string('alert_mooc', 'local_orange_library'),
                            array('class' => 'subscription_btn btn-primary', 'href' => $moocurl));
                    return $text;
                } else {
                    //   Mooc non rejouable";.
                    //   CAS D : FICHE PRODUIT - MOOC TERMINE - UTILISATEUR CONNECTE OU NON CONNECTE";.
                    return  html_writer::tag('span', get_string('status_closed', 'local_orange_library'));
                }
            } else if ($course->startdate > $date->getTimestamp()) {
                //   Mooc non ouvert";.
                if (!isloggedin()) {
                    //   Utilisateur non connecté à Solerni";.
                    //   Utilisateur non inscrit au mooc";.
                    //   CAS A : FICHE PRODUIT - MOOC NON REJOINT - UTILISATEUR CONNECTE OU NON CONNECTE";.
                    return html_writer::tag('a', get_string('subscribe_to_mooc', 'local_orange_library'),
                            array('class' => 'subscription_btn btn-primary', 'href' => $urlregistration));
                } else {
                    //   Utilisateur connecté à Solerni";.
                    if (!is_enrolled($context)) {
                        //   Utilisateur non inscrit au mooc";.
                        //   CAS A : FICHE PRODUIT - MOOC NON REJOINT - UTILISATEUR CONNECTE OU NON CONNECTE";.
                        return html_writer::tag('a', get_string('subscribe_to_mooc', 'local_orange_library'),
                                array('class' => 'subscription_btn btn-primary', 'href' => $urlmoocsubscription));
                    } else {
                        //   Utilisateur inscrit au mooc";.
                        //   CAS C : FICHE PRODUIT - MOOC REJOINT A VENIR - UTILISATEUR CONNECTE";.
                        $text = get_string('mooc_open_date', 'local_orange_library') . date("d-m-Y", $course->startdate);
                        return html_writer::tag('a', $text, array('class' => 'subscription_btn btn-unavailable btn-disabled'));
                    }
                }
            } else {
                //   Mooc en cours";.
                if ($instance->enrolenddate < $date->getTimestamp()) {
                    //   Mooc en cours et date d'inscription passée";.
                    if (!isloggedin()) {
                        //   Utilisateur non connecté à Solerni";.
                        //   Utilisateur non inscrit au mooc";.
                        //   CAS F : FICHE PRODUIT - INSCRIPTION AU MOOC TERMINEE - UTILISATEUR CONNECTE OU NON CONNECTE";.
                        return  html_writer::tag('span', get_string('registration_stopped', 'local_orange_library'));
                    } else {
                        //   Utilisateur connecté à Solerni";.
                        if (!is_enrolled($context)) {
                            //   Utilisateur non inscrit au mooc";.
                            //   CAS F : FICHE PRODUIT - INSCRIPTION AU MOOC TERMINEE - UTILISATEUR CONNECTE OU NON CONNECTE";.
                            return  html_writer::tag('span', get_string('registration_stopped', 'local_orange_library'));
                        } else {
                            //   Utilisateur inscrit au mooc";.
                            //   CAS B : FICHE PRODUIT - MOOC REJOINT EN COURS - UTILISATEUR CONNECTE";.
                            return html_writer::tag('a', get_string('access_to_mooc', 'local_orange_library'),
                                    array('class' => 'subscription_btn btn-access', 'href' => $moocurl));
                        }
                    }
                } else {
                    if (!isloggedin()) {
                        //   Utilisateur non connecté à Solerni";.
                        //   Utilisateur non inscrit au mooc";.
                        //   CAS A : FICHE PRODUIT - MOOC NON REJOINT - UTILISATEUR CONNECTE OU NON CONNECTE";.
                        return html_writer::tag('a', get_string('subscribe_to_mooc', 'local_orange_library'),
                                array('class' => 'subscription_btn btn-primary', 'href' => $urlregistration));
                    } else {
                        //   Utilisateur connecté à Solerni";.
                        if (!is_enrolled($context)) {
                            //   Utilisateur non inscrit au mooc";.
                            //   CAS A : FICHE PRODUIT - MOOC NON REJOINT - UTILISATEUR CONNECTE OU NON CONNECTE";.
                            return html_writer::tag('a', get_string('subscribe_to_mooc', 'local_orange_library'),
                                    array('class' => 'subscription_btn btn-primary', 'href' => $urlmoocsubscription));
                        } else {
                            //   Utilisateur inscrit au mooc";.
                            //   CAS B : FICHE PRODUIT - MOOC REJOINT EN COURS - UTILISATEUR CONNECTE";.
                            return html_writer::tag('a', get_string('access_to_mooc', 'local_orange_library'),
                                    array('class' => 'subscription_btn btn-access', 'href' => $moocurl));
                        }
                    }
                }
            }
        }
    }

}
