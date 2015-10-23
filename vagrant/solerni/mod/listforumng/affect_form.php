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
 * Print the form to manage affect forum in subpart of list
 * @package mod_listforumng
 * @copyright  2015 Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once($CFG->dirroot . '/course/moodleform_mod.php');
require_once($CFG->dirroot . '/mod/listforumng/lib.php');

class mod_listforumng_affect_form extends moodleform {

	public function definition() {
		global $CFG, $DB, $COURSE;
			
		list($courseid, $listforumngid, $subpartid, $id) = $this->_customdata;
		
		$listforumng = $DB->get_record('listforumng', array('id' => $listforumngid), '*', MUST_EXIST);	
		
		$mform = & $this->_form;
		
		// Get all forums created in this course
		$listallforumng = forumng_get_all($courseid);
		
		if ($subpartid != 0) {
			$subpart = $DB->get_record('listforumng', array('id' => $subpartid), '*', MUST_EXIST);			
			$subpartname = $listforumng->name . "/" . $subpart->name; 
		}
		else 	{			
			$subpartname= $listforumng->name;
		}				
		
		// Step header.
		$steplabel = get_string('assignforum', 'listforumng');
		$mform->addElement('header', 'flavourdata', $steplabel . " : " .  $subpartname);
		
		//$mform->addElement('html',$subpartname);
				
		
		
		foreach ($listallforumng as $forumng) {
			$mform->addElement('advcheckbox', "forumng-" . $forumng['id'], $forumng['name']);			
			//$mform->addElement('advcheckbox', "forumng-" . $forumng['id'], $forumng['name'], null, array('group' => 1));
		}
		/*
		foreach ($mform->_elements as $element) {
			var_dump($element);
			echo "<HR>";
			echo $element->getName(). "<br>";
			echo $element->getValue(). "<br>";
		}
		*/
		//$mform->_elements
		
		//$this->add_checkbox_controller(1, null, null);
		
		
		
		$mform->addElement('hidden', 'subpartid', $subpartid);
		$mform->setType('subpartid', PARAM_INT);
		
		$mform->addElement('hidden', 'instance', $listforumngid);
		$mform->setType('instance', PARAM_INT);
		
		$mform->addElement('hidden', 'id', $id);
		$mform->setType('id', PARAM_INT);
		
		$this->add_action_buttons();
		
	}
	
	
	
	public function validation($data, $files) {
		global $DB;
		$errors = array();
	
		return $errors;
	}

/*
	function definition_after_data() {
		parent::definition_after_data();
		
		//parcours des éléments
		$mform =& $this->_form;
		$elkeys = array_keys($mform->_elementIndex);
		var_dump($elkeys);
		
		$forumng1 = & $mform->getElement('forumng1');
		$forumng1 = 1;
		*/
		/*
		$keys      =& $mform->createElement('elkeys');
		$keys = $elkeys;
		*/
		/*
		$type      =& $mform->getElement('type');
		$typevalue = $mform->getElementValue('type');
	
		//we don't want to have these appear as possible selections in the form but
		//we want the form to display them if they are set.
		if ($typevalue[0]=='news') {
			$type->addOption(get_string('namenews', 'forum'), 'news');
			$mform->addHelpButton('type', 'namenews', 'forum');
			$type->freeze();
			$type->setPersistantFreeze(true);
		}
		if ($typevalue[0]=='social') {
			$type->addOption(get_string('namesocial', 'forum'), 'social');
			$type->freeze();
			$type->setPersistantFreeze(true);
		}
	*/
	//}
	
	
/*	
	public function get_data() {
		$data = parent::get_data();
		if ($data) {
			$data->page_after_submitformat = $data->page_after_submit_editor['format'];
			$data->page_after_submit = $data->page_after_submit_editor['text'];
	
			if (!empty($data->completionunlocked)) {
				// Turn off completion settings if the checkboxes aren't ticked
				$autocompletion = !empty($data->completion) &&
				$data->completion == COMPLETION_TRACKING_AUTOMATIC;
				if (!$autocompletion || empty($data->completionsubmit)) {
					$data->completionsubmit=0;
				}
			}
		}
	
		return $data;
	}
*/	
	
	
}
