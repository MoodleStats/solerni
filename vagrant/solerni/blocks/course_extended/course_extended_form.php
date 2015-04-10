<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once("{$CFG->libdir}/formslib.php");
require_once($CFG->dirroot.'/blocks/course_extended/lib.php');
require_once($CFG->dirroot.'/blocks/course_extended/locallib.php');
 
class course_extended_form extends moodleform {
 
    function definition() {
        global $CFG, $DB, $OUTPUT, $PAGE;
        
        $mform =& $this->_form;
        
        //$allowHTML = $CFG->Allow_HTML;
        //$allowHTML = get_config('course_extended', 'Allow_HTML');

        
        // add page title element.
        $mform->addElement('header','displayinfo', get_string('blocktitle', 'block_course_extended'));

        // Adding the "maxvisibility" field.
        $options = array(page_VISIBILITY_COURSEUSER => get_string('visiblecourseusers', 'descriptionpage'),
                page_VISIBILITY_LOGGEDINUSER => get_string('visibleloggedinusers', 'descriptionpage'),
                page_VISIBILITY_PUBLIC => get_string('visiblepublic', 'descriptionpage'));

        $mform->addElement('select', 'maxvisibility', get_string('maxvisibility', 'descriptionpage'), $options);
        $mform->setType('maxvisibility', PARAM_INT);
        $mform->addHelpButton('maxvisibility', 'maxvisibility', 'descriptionpage');

        // add filename selection.
        $imageoptions = array('maxbytes' => $CFG->maxbytes, 'accepted_types' => array('web_image'));
        $mform->addElement('filepicker', 'picture', get_string('filetitle', 'block_course_extended'), null, $imageoptions);

        // rename the bloc.
        $mform->addElement('text', 'pagetitle', get_string('title', 'block_course_extended'));
        $mform->setDefault('pagetitle', get_string('blocktitle_default', 'block_course_extended'));
        $mform->setType('pagetitle', PARAM_TEXT);
        $mform->addHelpButton('pagetitle', 'pagetitle', 'block_course_extended');

        // define the cousre start date.
        $mform->addElement('date_selector', 'startdate', get_string('startdate', 'block_course_extended'));
        $mform->setType('startdate', PARAM_ALPHANUM);
        $mform->setDefault('startdate', date($PAGE->course->startdate));

        $mform->addElement('date_selector', 'enddate', get_string('enddate', 'block_course_extended'));
        $mform->setType('enddate', PARAM_ALPHANUM);

        $mform->addElement('duration', 'duration', get_string('duration', 'block_course_extended'));
        $mform->setType('duration', PARAM_ALPHANUM);

        $mform->addElement('duration', 'workingtime', get_string('workingtime', 'block_course_extended'));
        $mform->setType('workingtime', PARAM_ALPHANUM);

        $badges = get_badges();

        foreach ($badges as $value) {
            $optionsbadges[$value->id]=$value->name;
        }
        $mform->addElement('select', 'certification', get_string('certification', 'block_course_extended'),$optionsbadges);


        $mform->addElement('text', 'price', get_string('price', 'block_course_extended'));
        $mform->setType('price', PARAM_INT);

        $mform->addElement('text', 'language', get_string('language', 'block_course_extended'));
        $mform->setType('language', PARAM_TEXT);
        $mform->setDefault('language', $PAGE->course->lang);

        $mform->addElement('advcheckbox', 'video', get_string('video', 'block_course_extended'),
            get_string('video', 'block_course_extended'));
        $mform->setDefault('video', 0);
        $mform->setType('video', PARAM_BOOL);

        $mform->addElement('date_selector', 'registration_startdate', get_string('registration_startdate', 'block_course_extended'));
        $mform->setType('registration_startdate', PARAM_ALPHANUM);
        $mform->setDefault('registration_startdate', date($PAGE->course->startdate));

        $mform->addElement('date_selector', 'registration_enddate', get_string('registration_enddate', 'block_course_extended'));
        $mform->setType('registration_enddate', PARAM_ALPHANUM);
        
         $mform->addElement('text', 'registeredusers', get_string('registeredusers', 'block_course_extended'));
        $mform->setType('registeredusers', PARAM_INT);

        $mform->addElement('text', 'prerequesites', get_string('prerequesites', 'block_course_extended'));
        $mform->setType('prerequesites', PARAM_MULTILANG);
        $mform->setDefault('prerequesites', get_string('prerequesites_default', 'block_course_extended'));
       //$mform->setType('prerequisites', PARAM_MULTILANG);

        $mform->addElement('text', 'teachingteam', get_string('teachingteam', 'block_course_extended'));
        $mform->setType('teachingteam', PARAM_MULTILANG);
        $mform->setDefault('teachingteam', get_string('teachingteam_default', 'block_course_extended'));

        $mform->addElement('hidden', 'id', 0);
        $mform->setType('id',PARAM_RAW);        

        // hidden elements
        $mform->addElement('hidden', 'blockid');
        $mform->setType('blockid', PARAM_INT);
        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);
        $mform->addElement('hidden', 'courseid');
        $mform->setType('courseid', PARAM_INT);




        $this->add_action_buttons();
    }
}
