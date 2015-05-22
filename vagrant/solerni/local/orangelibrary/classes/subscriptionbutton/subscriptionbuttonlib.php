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

defined('MOODLE_INTERNAL') || die();
/**
     *  Set the button in the block.
     *
     * @param object $context
     * @param object $course
     * @param object $this->extendedcourse
     * @return string html_writer::tag
     */
    function set_button($context, $course) {
        $text = "";
        $date = new DateTime();

        $urlmoocsubsription = new moodle_url('/course/view.php', array('id' => $course->id));
        $moocurl = new moodle_url('/course/view.php', array('id' => $course->id));
        //   Mooc terminé et rejouable c’est-à-dire que la date du mooc est passée mais l’utilisateur.
        //   Peut demander à être averti lorsque la prochaine session du mooc débutera.
        //   Mooc terminé cad que la date de fin du mooc est dépassée.
        if ($this->extendedcourse->enrolledusers >= $this->extendedcourse->registeredusers) {
            //   Mooc complet : l’inscription est limitée aux X premiers inscrits";.
            //   CAS G : FICHE PRODUIT - MOOC COMPLET - UTILISATEUR CONNECTE OU NON CONNECTE";.
            return html_writer::tag('span', get_string('mooc_complete', 'block_course_extended'));
        } else {
            if ($this->extendedcourse->enddate < $date->getTimestamp()) {
                //   Mooc terminé";.
                if ($this->extendedcourse->replay == get_string('replay', 'format_flexpage')) {
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
                if ($this->extendedcourse->registration_enddate < $date->getTimestamp()) {
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
            /**
     *  Set the extended course values from the extended course flexpage values.
     *
     * @param object $extendedcourseflexpagevalue
     * @param object $context
     * @param object $extendedcourse
     * @return object $this->extendedcourse
     */
    function set_extendedcourse ($extendedcourseflexpagevalue, $context) {
        switch ($extendedcourseflexpagevalue->name) {
            case 'coursereplay':
                if ($extendedcourseflexpagevalue->value == 0) {
                    $this->extendedcourse->replay = get_string('replay', 'format_flexpage');
                } else {
                    $this->extendedcourse->replay = get_string('notreplay', 'format_flexpage');
                }
                break;
            case 'coursestatus':
                if ($extendedcourseflexpagevalue->value == 0) {
                    $this->extendedcourse->status = get_string('current', 'format_flexpage');
                } else if ($extendedcourseflexpagevalue->value == 1) {
                    $this->extendedcourse->status = get_string('startingsoon', 'format_flexpage');
                } else {
                    $this->extendedcourse->status = get_string('closed', 'format_flexpage');
                }
                break;
            case 'coursepicture':
                $this->extendedcourse->picture = $extendedcourseflexpagevalue->value;
                break;
            case 'courseenddate':
                $this->extendedcourse->enddate = $extendedcourseflexpagevalue->value;
                break;
            case 'courseworkingtime':
                    $this->extendedcourse->workingtime = $this->durationtotime($extendedcourseflexpagevalue->value);
                break;

            case 'courselanguage':
                if ($extendedcourseflexpagevalue->value == 0) {
                    $this->extendedcourse->language = get_string('french', 'format_flexpage');
                } else {
                    $this->extendedcourse->language = get_string('english', 'block_course_extended');
                }
                break;
            case 'coursebadge':
                    $this->extendedcourse->badge = $extendedcourseflexpagevalue->value;
                break;
            case 'courseprice':
                if ($extendedcourseflexpagevalue->value == 0) {
                    $this->extendedcourse->price = get_string('price_case1', 'format_flexpage');
                } else if ($extendedcourseflexpagevalue->value == 1) {
                    $this->extendedcourse->price = get_string('price_case2', 'format_flexpage');
                } else {
                    $this->extendedcourse->price = get_string('price_case3', 'format_flexpage');
                }
                break;
            case 'coursecertification':
                   $this->extendedcourse->certification = $extendedcourseflexpagevalue->value;
                break;
            case 'coursevideo':
                    $this->extendedcourse->video = $extendedcourseflexpagevalue->value;
                break;
            case 'coursesubtitle':
                     $this->extendedcourse->subtitle = $extendedcourseflexpagevalue->value;
                break;
            case 'courseteachingteam':
                $this->extendedcourse->teachingteam = $extendedcourseflexpagevalue->value;
                break;
            case 'courseprerequesites':
                $this->extendedcourse->prerequesites = $extendedcourseflexpagevalue->value;
                break;
            case 'courseduration':
                $this->extendedcourse->duration = $this->durationtotime($extendedcourseflexpagevalue->value);
                break;
            case 'courseregistrationcompany':
                    $this->extendedcourse->registrationcompany = $extendedcourseflexpagevalue->value;
                break;
            case 'coursemaxregisteredusers':
                    $this->extendedcourse->registeredusers = $extendedcourseflexpagevalue->value;
                break;
            case 'courseregistrationstartdate':
                $this->extendedcourse->registration_startdate = $extendedcourseflexpagevalue->value;
                break;
            case 'courseregistrationenddate':
                $this->extendedcourse->registration_enddate = $extendedcourseflexpagevalue->value;
                break;
            case 'courseregistration':
                $this->extendedcourse->registration = $extendedcourseflexpagevalue->value;
                break;
        }
        $this->extendedcourse->enrolledusers = count_enrolled_users($context);
        return $this->extendedcourse;
    }

    }


