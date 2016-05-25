<?php
/*
 * This file is part of local_analytics plugin for Moodle.
 *
 * It allows to define and return differents dimensions values
 * Piwik allows a maximum of 5 dimensions.
 *
 */
defined('MOODLE_INTERNAL') || die();

use local_orange_library\utilities\utilities_course;

class local_analytics_dimensions {

    private $dimensions1;
    private $dimensions2;
    private $dimensions3;
    private $dimensions4;
    private $dimensions5;
    private $iscourse;
    private $isuserlogged;


    function __construct($course, $user, $cfg) {
        $this->iscourse = $this->set_iscourse($course);
        $this->isuserlogged = $this->set_isuserlogged($user);
        $this->dimensions1 = $this->set_dimensions1($course);
        $this->dimensions2 = $this->set_dimensions2($course, $user);
        $this->dimensions3 = $this->set_dimensions3($course, $cfg);
        $this->dimensions4 = $this->set_dimensions4($cfg);
        $this->dimensions5 = $this->set_dimensions5();

    }

    private function set_iscourse($course) {
        return ($course->id == 1) ? false : true;
    }

    private function get_iscourse() {
        return $this->iscourse;
    }

    private function set_isuserlogged($user) {
        return ($user->id == 0) ? false : true;
    }

    private function get_isuserlogged() {
        return $this->isuserlogged;
    }

    /*
     * set dimensions1 to the full name of the mooc if we are in a mooc,
     * or to translated string if not
     */
    private function set_dimensions1($course) {
        return  ($this->iscourse) ?
                $course->fullname :
                get_string('not_in_a_mooc', 'local_analytics');
    }

    public function get_dimensions1() {
        return $this->dimensions1;
    }

    /*
     * Set dimensions2 to describe if user is subscribed to a mooc
     * If the user is not authenticated, the user is not subscribed
     * If we are are outside a mooc, the value is not applicable
     */
    private function set_dimensions2($course, $user) {
        if (!$this->iscourse) {
            $return = get_string('not_applicable', 'local_analytics');
        } else {
            $context = context_course::instance($course->id);
            $roles = get_user_roles($context, $user->id, false);
            $return =   ($roles) ?
                        get_string('subscribed', 'local_analytics') :
                        get_string('not_subscribed', 'local_analytics');
        }

        return  $return;
    }

    public function get_dimensions2() {
        return $this->dimensions2;
    }

    /*
     * Set dimensions3 to platform customer name
     * or to translated string if value is not set
     */
    private function set_dimensions3($course, $cfg) {
        if ($cfg->solerni_isprivate) {
            return ($cfg->solerni_customer_name) ?
                $cfg->solerni_customer_name :
                get_string('not_set', 'local_analytics');
        }
        if ($this->iscourse) {
            return utilities_course::get_customer($course->category)->name;
        } else {
            get_string('not_set', 'local_analytics');
        }
            
    }

    public function get_dimensions3() {
        return $this->dimensions3;
    }

    /*
     * Set dimensions4 to platform thematic name
     * or to translated string if value is not set
     */
    private function set_dimensions4($cfg) {
        return ($cfg->solerni_thematic) ?
                $cfg->solerni_thematic :
                get_string('not_set', 'local_analytics');
    }

    public function get_dimensions4() {
        return $this->dimensions4;
    }

    /*
     * Not used
     */
    private function set_dimensions5() {
        return false;
    }

    public function get_dimensions5() {
         return $this->dimensions5;
    }
}
