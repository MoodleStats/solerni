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
 * Flavours packaging system
 *
 * @package    local
 * @subpackage flavours
 * @copyright  2011 David Monllaó
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once($CFG->dirroot . '/local/orange_rules/forms/orange_rules_form.php');
require_once($CFG->dirroot . '/local/orange_rules/forms/orange_rules_list.php');
require_once($CFG->dirroot . '/local/orange_rules/lib.php');

/**
 * Packaging system manager
 *
 * @package local
 * @subpackage flavours
 * @copyright 2011 David Monllaó
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class orange_rules  {

    protected $action;
    protected $renderable;
	protected $list;

    public function __construct($action) {

        global $CFG;

        $this->action = $action;
        $this->url = $CFG->wwwroot.'/local/orange_rules/index.php';
    }
	
	
    /**
     * Outputs the packaging form
     */
    public function rules_form() {		
        global $CFG, $PAGE, $DB;
		
		$get = new stdClass();
        foreach ($_GET as $varname => $value) {
			$get->{"$varname"} = $value;
		}
		// Create or modify
		$toform = new stdClass();
		if (isset($get->id))
		{
			$tobemodified = $DB->get_record('orange_rules', array ('id'=>$get->id));
			
			$toform->id = $tobemodified->id;
			$toform->name = $tobemodified->name;
			$toform->emails = $tobemodified->emails;
			$toform->suspended = $tobemodified->suspended;
			$toform->cohortid = $tobemodified->cohortid;
		}

        $this->renderable = new orange_rules_form();
		$this->renderable->set_data($toform);

    }

    public function rules_delete() {
        global $CFG, $PAGE, $DB;
		
		if (empty($_GET)) {
            return false;
        }

		$get = new stdClass();
        foreach ($_GET as $varname => $value) {
			$get->{"$varname"} = $value;
		}
		
		$tobedeleted = $DB->get_record('orange_rules', array ('id'=>$get->id));
		$DB->delete_records('orange_rules', array ('id'=>$get->id));
		$returnurl = new moodle_url('index.php', array('action'=>'rules_list','sesskey'=>sesskey()));
        redirect($returnurl, get_string('ruledeleted', 'local_orange_rules', $tobedeleted->name));
	}

	
    public function rules_suspend() {
        global $CFG, $PAGE, $DB;
		
		if (empty($_GET)) {
            return false;
        }

		$get = new stdClass();
        foreach ($_GET as $varname => $value) {
			$get->{"$varname"} = $value;
		}

		$rule = new stdClass();
		$rule->id = $get->id;
		$rule->suspended = true;
		
		$DB->update_record('orange_rules', $rule);
		$returnurl = new moodle_url('index.php', array('action'=>'rules_list','sesskey'=>sesskey()));
        redirect($returnurl);
	}

    public function rules_unsuspend() {
        global $CFG, $PAGE, $DB;
		
		if (empty($_GET)) {
            return false;
        }

		$get = new stdClass();
        foreach ($_GET as $varname => $value) {
			$get->{"$varname"} = $value;
		}

		$rule = new stdClass();
		$rule->id = $get->id;
		$rule->suspended = false;
		
		$DB->update_record('orange_rules', $rule);

		$returnurl = new moodle_url('index.php', array('action'=>'rules_list','sesskey'=>sesskey()));
        redirect($returnurl);
	}

	
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
	
    public function rules_list() {    	
        global $CFG, $PAGE, $DB, $OUTPUT;

		$sitecontext = context_system::instance();
		
    $stredit   = get_string('edit');
    $strdelete = get_string('delete');
    $strsuspend = get_string('suspendrule', 'local_orange_rules');
    $strunsuspend = get_string('unsuspendrule', 'local_orange_rules');

	$table = new html_table();
        $table->head = array ();
        $table->colclasses = array();
        $table->attributes['class'] = 'admintable generaltable';
        $table->head[] = get_string('ruleid', 'local_orange_rules');
        $table->head[] = get_string('rulename', 'local_orange_rules');
        $table->head[] = get_string('nbruleemails', 'local_orange_rules');
        $table->head[] = get_string('nbruledomains', 'local_orange_rules');
        $table->head[] = get_string('rulecohorts', 'local_orange_rules');
        $table->head[] = get_string('edit');
        $table->id = "rules";

	$rules = $DB->get_recordset('orange_rules');
	
    foreach ($rules as $rule) {
            $buttons = array();
            // delete button
            if (has_capability('orange/rules:edit', $sitecontext)) {
                    //$buttons[] = html_writer::link(new moodle_url('confirm.php', array('id'=>$rule->id, 'sesskey'=>sesskey())), html_writer::empty_tag('img', array('src'=>$OUTPUT->pix_url('t/delete'), 'alt'=>$strdelete, 'class'=>'iconsmall')), array('title'=>$strdelete));
            		//$buttons[] = html_writer::link(new moodle_url('index.php', array('action'=>'rules_delete','id'=>$rule->id, 'sesskey'=>sesskey())), html_writer::empty_tag('img', array('src'=>$OUTPUT->pix_url('t/delete'), 'alt'=>$strdelete, 'class'=>'iconsmall')), array('title'=>$strdelete));
                	$msgpopup = get_string('confirmdeleterule', 'local_orange_rules', $rule->name);
            		$buttons[] = html_writer::link( new moodle_url('index.php', array('action'=>'rules_delete','id'=>$rule->id, 'sesskey'=>sesskey())), 
                    		                        html_writer::empty_tag('img', array('src'=>$OUTPUT->pix_url('t/delete'), 'alt'=>$strdelete, 'class'=>'iconsmall')), 
                    		                        array('title'=>$strdelete,'onclick'=>"return confirm('$msgpopup')")
                    		                       );                                                          
                    if ($rule->suspended)
					{
                        $buttons[] = html_writer::link(new moodle_url('index.php', array('action'=>'rules_unsuspend', 'id'=>$rule->id, 'sesskey'=>sesskey())),
                        		 					   html_writer::empty_tag('img', array('src'=>$OUTPUT->pix_url('t/show'), 'alt'=>$strunsuspend, 'class'=>'iconsmall')), 
                        							   array('title'=>$strunsuspend));
					}
					else
					{
						$buttons[] = html_writer::link(new moodle_url('index.php', array('action'=>'rules_suspend','id'=>$rule->id, 'sesskey'=>sesskey())), 
													   html_writer::empty_tag('img', array('src'=>$OUTPUT->pix_url('t/hide'), 'alt'=>$strsuspend, 'class'=>'iconsmall')), 
													   array('title'=>$strsuspend));
					}
                    $buttons[] = html_writer::link(new moodle_url('view.php', array('action'=>'rules_form', 'id'=>$rule->id, 'sesskey'=>sesskey())), html_writer::empty_tag('img', array('src'=>$OUTPUT->pix_url('t/edit'), 'alt'=>$stredit, 'class'=>'iconsmall')), array('title'=>$stredit));
			}
			$row = array ();
            $row[] = $rule->id;
			$row[] = "<a href=\"view.php?sesskey=".sesskey()."&action=rules_form&id=$rule->id\">$rule->name</a>";
            $nbemails = 0;
            if ($rule->emails != null && $rule->emails !="")
            	$nbemails = count(explode("\n",$rule->emails));
            $nbdomains = 0;
            if ($rule->domains != null && $rule->domains !="")
            	$nbdomains = count(explode("\n",$rule->domains));
            
			$row[] = $nbemails;  
            $row[] = $nbdomains; 
            
            
            //$row[] = count(explode("\n",$rule->emails)); 
            //$row[] = count(explode("\n",$rule->domains));   
            $row[] = rule_get_cohortname($rule->cohortid);
            if ($rule->suspended) {
                foreach ($row as $k=>$v) {
                    $row[$k] = html_writer::tag('span', $v, array('class'=>'usersuspended'));
                }
            }
            $row[] = implode(' ', $buttons);
            $table->data[] = $row;

    }
	$rules->close();
	$this->list = $table;

        $this->renderable = new orange_rules_list(/* $this->url */);
    }
	
    public function render() {

        global $PAGE;

        $renderer = $PAGE->get_renderer('local_orange_rules');
        
        return $renderer->render_orange_wrapper($this->renderable, $this->action, $this->list);
    }

}
