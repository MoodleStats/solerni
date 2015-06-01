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
     *  Set the dicplayed text in the block.
     *
     * @param moodle_url $imgurl
     * @param object $course
     * @param object $context
     * @return string $text
     */
    public function get_self_enrolment($course) {

        $instances = enrol_get_instances($course->id, false);
        foreach ($instances as $instanceinfo) {
            if ($instanceinfo->enrol == "self") {
                return $instanceinfo;
            }
        }
    }

}
