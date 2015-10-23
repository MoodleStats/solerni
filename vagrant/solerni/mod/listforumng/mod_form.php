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

require_once($CFG->dirroot . '/course/moodleform_mod.php');
require_once($CFG->dirroot . '/mod/forumng/mod_forumng.php');
require_once($CFG->dirroot . '/mod/listforumng/lib.php');

/**
 * Form for editing module settings.
 * @package mod_listforumng
 * @copyright  2015 Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class mod_listforumng_mod_form extends moodleform_mod {
    public function definition() {
        global $CFG, $DB;

        $mform = $this->_form;

        $mform->addElement('header', 'general', get_string('general', 'form'));

        $mform->addElement('text', 'name', get_string('name'), array('size' => '48'));
        if (!empty($CFG->formatstringstriptags)) {
            $mform->setType('name', PARAM_TEXT);
        } else {
            $mform->setType('name', PARAM_CLEANHTML);
        }
        $mform->setDefault ('name', get_string('defaultname', 'listforumng'));
        $mform->addRule('name', null, 'required', null, 'client');
        $mform->addRule('name', get_string('maximumchars', '', 255), 'maxlength', 255, 'client');

        $this->add_intro_editor(true, get_string('listforumngintro', 'listforumng'));


        
        
        $repeatarray = array();
        $repeatarray[] = $mform->createElement('text', 'subpart', get_string('subpartno', 'listforumng'));
        $repeatarray[] = $mform->createElement('hidden', 'subpartid', 0);
        
        if ($this->_instance){
        	$repeatno = $DB->count_records('listforumng', array('parent'=>$this->_instance));
        	$repeatno += 2;
        } else {
        	$repeatno = 5;
        }
        
        $repeateloptions = array();

        $mform->setType('subpart', PARAM_CLEANHTML);
        
        $mform->setType('subpartid', PARAM_INT);
        
        $this->repeat_elements($repeatarray, $repeatno,
        		$repeateloptions, 'subpart_repeats', 'subpart_add_fields', 3, null, true);
        
        /*
        // Make the first option required
        if ($mform->elementExists('subpart[0]')) {
        	$mform->addRule('subpart[0]', "COUCOUCOU", 'required', null, 'client');
        }
        */      
        
        $this->standard_coursemodule_elements();
        $this->add_action_buttons();
    }
    
    
    
    
   
    function data_preprocessing(&$default_values){
    	global $DB;
    	if (!empty($this->_instance) 
    			&& ($subparts = $DB->get_records_menu('listforumng',array('parent'=>$this->_instance), 'id', 'id,name'))) {
    				
    				$parentids=array_keys($subparts);
    				$subparts=array_values($subparts);
    
    				foreach (array_keys($subparts) as $key){
    					$default_values['subpart['.$key.']'] = $subparts[$key];
    					$default_values['subpartid['.$key.']'] = $parentids[$key];
    				}
    
    			}
    }
    
}