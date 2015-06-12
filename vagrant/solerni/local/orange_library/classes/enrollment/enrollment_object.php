<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of enrollment_class
 *
 * @author ajby6350
 */
namespace local_orange_library\enrollment;

defined('MOODLE_INTERNAL') || die();

class enrollment_object {

    /**
     *  Get self enrollment instance.
     *
     * @param object $course
     * @return object enrollinstance
     */
    public function get_self_enrolment($course) {

        $instances = enrol_get_instances($course->id, false);
        foreach ($instances as $instanceinfo) {
            if ($instanceinfo->enrol == "self") {
                return $instanceinfo;
            }
        }
    }

    /**
     *  Get self enrollment instance.
     *
     * @param moodle_url $imgurl
     * @param object $course
     * @param object $context
     * @return string $text
     */
    public function get_enrolment_startdate($course) {

        $instances = enrol_get_instances($course->id, false);
        foreach ($instances as $instance) {
            if($instance->enrolstartdate){
               return $instance->enrolstartdate;
            }
        }
            return date('c');
    }

    /**
     *  Get self enrollment instance.
     *
     * @param moodle_url $imgurl
     * @param object $course
     * @param object $context
     * @return string $text
     */
    public function get_enrolment_enddate($course) {

        $instances = enrol_get_instances($course->id, false);
        foreach ($instances as $instance) {
            if($instance->enrolenddate){
               return $instance->enrolenddate;
            }
        }
            return date('c');
    }
}
