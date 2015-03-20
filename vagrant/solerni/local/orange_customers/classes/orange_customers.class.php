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
 * Orange_customers packaging system
 *
 * @package    local
 * @subpackage orange_customers
 * @copyright  2015 Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once($CFG->dirroot . '/local/orange_customers/forms/orange_customers_form.php');
require_once($CFG->dirroot . '/local/orange_customers/forms/orange_customers_list.php');
require_once($CFG->dirroot . '/local/orange_customers/lib.php');

/**
 * Packaging system manager
 *
 * @package local
 * @subpackage orange_customers
 * @copyright 2015 Orange
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class orange_customers  {

    protected $action;
    protected $renderable;
	protected $list;

    public function __construct($action) {

        global $CFG;

        $this->action = $action;
        $this->url = $CFG->wwwroot.'/local/orange_customers/index.php';
    }
	
	
    /**
     * Outputs the packaging form
     */
    public function customers_form() {		
        global $CFG, $PAGE, $DB;
		
		$get = new stdClass();
        foreach ($_GET as $varname => $value) {
			$get->{"$varname"} = $value;
		}
		// Create or modify
		$toform = new stdClass();
		if (isset($get->id))
		{
			$tobemodified = $DB->get_record('orange_customers', array ('id'=>$get->id));
			
			$toform->id = $tobemodified->id;
			$toform->name = $tobemodified->name;
			$toform->summary = $tobemodified->summary;
			$toform->description = $tobemodified->description;
			$toform->logo = $tobemodified->logo;
			$toform->picture = $tobemodified->picture;
		}

        $this->renderable = new orange_customers_form();
		$this->renderable->set_data($toform);

    }

    public function customers_delete() {
        global $CFG, $PAGE, $DB;
		
		if (empty($_GET)) {
            return false;
        }

		$get = new stdClass();
        foreach ($_GET as $varname => $value) {
			$get->{"$varname"} = $value;
		}
		
		$tobedeleted = $DB->get_record('orange_customers', array ('id'=>$get->id));
		$DB->delete_records('orange_customers', array ('id'=>$get->id));
		$returnurl = new moodle_url('index.php', array('action'=>'customers_list','sesskey'=>sesskey()));
        redirect($returnurl, get_string('customerdeleted', 'local_orange_customers', $tobedeleted->name));
	}

	
	/*
	public function rules_add() {		
        global $CFG, $PAGE, $DB;        
		
		if (empty($_POST)) {
            return false;
        }

		$rule = new stdClass();
        foreach ($_POST as $varname => $value) {
			//mtrace($varname."=".$value."<br/>");
			$rule->{"$varname"} = $value;
		}
		if ($rule->id == 0) 
			$lastinsertid = $DB->insert_record('orange_rules', $rule, false);			
		else 
			$DB->update_record('orange_rules', $rule);

		$returnurl = new moodle_url('index.php', array('action'=>'rules_list','sesskey'=>sesskey()));	
		//var_dump($returnurl);	
        redirect($returnurl);
	}
	
	*/
	
    public function customers_list() {    	
        global $CFG, $PAGE, $DB, $OUTPUT;

		$sitecontext = context_system::instance();
		
    $stredit   = get_string('edit');
    $strdelete = get_string('delete');    
    
	$table = new html_table();
        $table->head = array ();
        $table->colclasses = array();
        $table->attributes['class'] = 'admintable generaltable';
        $table->head[] = get_string('customerid', 'local_orange_customers');
        $table->head[] = get_string('customername', 'local_orange_customers');
        $table->head[] = get_string('customersummary', 'local_orange_customers');
        $table->head[] = get_string('customerlogo', 'local_orange_customers');
        $table->head[] = get_string('edit');
        $table->id = "customers";

	$customers = $DB->get_recordset('orange_customers');
	
    foreach ($customers as $customer) {
    	
            $buttons = array();
            // delete button
            
            if (has_capability('orange/customers:edit', $sitecontext)) {
                	$msgpopup = get_string('confirmdeletecustomer', 'local_orange_customers', $customer->name);
            		$buttons[] = html_writer::link( new moodle_url('index.php', array('action'=>'customer_delete','id'=>$customer->id, 'sesskey'=>sesskey())), 
                    		                        html_writer::empty_tag('img', array('src'=>$OUTPUT->pix_url('t/delete'), 'alt'=>$strdelete, 'class'=>'iconsmall')), 
                    		                        array('title'=>$strdelete,'onclick'=>"return confirm('$msgpopup')")
                    		                       );                                                          

                    $buttons[] = html_writer::link(new moodle_url('view.php', array('action'=>'customer_form', 'id'=>$customer->id, 'sesskey'=>sesskey())), html_writer::empty_tag('img', array('src'=>$OUTPUT->pix_url('t/edit'), 'alt'=>$stredit, 'class'=>'iconsmall')), array('title'=>$stredit));
			}
			$row = array ();
            $row[] = $customer->id;
			$row[] = "<a href=\"view.php?sesskey=".sesskey()."&action=customers_form&id=$customer->id\">$customer->name</a>";

			$row[] = $customer->summary;  
            $row[] = "emplacement du logo ?"; 
              
            $row[] = implode(' ', $buttons);
            $table->data[] = $row;

    }
	$customers->close();
	$this->list = $table;
	
	html_writer::empty_tag('input', array('type'=>'submit', 'value'=>'hello world !'));
	

        $this->renderable = new orange_customers_list(/* $this->url */);
    }
	
    public function render() {

        global $PAGE;

        $renderer = $PAGE->get_renderer('local_orange_customers');
        
        return $renderer->render_orange_wrapper($this->renderable, $this->action, $this->list);
    }

}
