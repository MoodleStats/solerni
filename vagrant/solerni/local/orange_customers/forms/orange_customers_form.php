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
 * To manage customers
 *
 * @package    local
 * @subpackage orange_customers
 * @copyright  2015 Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once($CFG->libdir . '/formslib.php');

/**
 * Form to select the ingredients to deploy
 *
 * @package local
 * @subpackage orange_customers
 * @copyright 2015 Orange
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class orange_customers_form extends moodleform implements renderable {

    public function definition() {
		global $CFG;
	
        $mform = & $this->_form;
        // Step header
        $steplabel = get_string('definecustomersheader', 'local_orange_customers');
        $mform->addElement('header', 'flavourdata', $steplabel);

        $mform->addElement('static', 'name', get_string('customername', 'local_orange_customers'));
        
        //$mform->addRule('name', null, 'required', null, 'client');
        //$mform->setType('name', PARAM_TEXT);		
		
        $mform->addElement('editor', 'summary_editor', get_string('customersummary', 'local_orange_customers'));
        $mform->setType('summary_editor', PARAM_RAW);
		
        $mform->addElement('editor', 'description_editor', get_string('customerdescription', 'local_orange_customers'));
        $mform->setType('description_editor', PARAM_RAW);
        
        
        
        $optionsfilemanager = array(
        		'maxfiles' => 1,
        		'maxbytes' => $CFG->maxbytes,
        		'subdirs' => 0,
        		'accepted_types' => 'web_image'
        );
        
        $mform->addElement('filemanager', 'logo', get_string('customerlogo', 'local_orange_customers'), null, $optionsfilemanager);
        
        $mform->addElement('filemanager', 'picture', get_string('customerpicture', 'local_orange_customers'), null, $optionsfilemanager);
		
        $mform->addElement('hidden', 'id', 0);
        $mform->setType('id',PARAM_RAW);        

	$this->add_action_buttons();			
    }

/*
    function definition_after_data() {   
    	global $DB;    	
    	parent::definition_after_data();
    	$mform     =& $this->_form;
    	$cohortid      =& $mform->getElement('cohortid');
    	$cohortidvalue = $mform->getElementValue('cohortid');
    	     	
    	$sql = "SELECT c.id, c.name, r.cohortid AS idcohortrule
    	FROM {cohort} c left outer join {orange_rules} r
    	ON r.cohortid = c.id
    	group by c.id, c.name";
    	
    	$cohorts = $DB->get_records_sql($sql);
    	
    	foreach ($cohorts as $cohort) {    		
    		if ($cohort->idcohortrule == null || $cohort->id==$cohortidvalue[0] )
    			$cohortid->addOption($cohort->name, $cohort->id);    		
    		else
    			$cohortid->addOption($cohort->name, $cohort->id, array( 'disabled' => 'disabled' ));
    	}
    	    	    	    	  	
   }
  */
    
    
    public function validation($data, $files) {
        global $DB;
        $errors=array();
        
/*
        $errors = parent::validation($data, $files);

        $cohortid = trim($data['cohortid']);
		mtrace($cohortid);
		die;
		if ($cohortid === 0)
		{
			$errors['cohortid'] = get_string('cohortempty', 'local_orange_customers');
		}
		*/

		return $errors;
    }


}
