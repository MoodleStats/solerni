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
 * @package    local
 * @subpackage orange_customers
 * @copyright  2015 Orange
* @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
*/

defined('MOODLE_INTERNAL') || die();


/// STANDARD FUNCTIONS ///////////////////////////////////////////////////////////

/**
 * Given an object containing all the necessary data,
 * (defined by the form) this function
 * will create or update a new instance and return true if it was created or updated
 *
 * @param stdClass $customer 
 * @return boolean
 */
function customer_add_customer($customer) {
	global $CFG, $DB;

	if (!isset($customer->name)) {
            throw new coding_exception('Missing customer name in customer_add_customer().');
	}
	
	if ($customer->id == 0) {			
            $lastinsertid = $DB->insert_record('orange_customers', $customer, false);			
	} else {							
            $DB->update_record('orange_customers', $customer);		
	}
	
	return $customer->id;
		
}

/**
 * Return the customer identified by $id
 *
 * @param int $id id of customer
 * @return stdClass $customer 
 */
function customer_get_customer($id) {
	global $CFG, $DB;
        
	$customer = $DB->get_record('orange_customers', array('id'=>$id));

	return $customer;


}
/*
 * Mandatory callback from pluginfile.php
 * Deals with local specific
 * $args[] = itemid
 * $args[] = path
 * $args[] = filename
 */
function local_orange_customers_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options=array()) {
    global $CFG, $DB;

    // Not sure about that, I'm not context-fluent. Our module use SYSTEM
    if ( $context->contextlevel != CONTEXT_SYSTEM ) {
        return false;
    }
    
    // We only use two file areas
    if ( $filearea != 'logo' && $filearea != 'picture' ) {
        return false;
    }
    
    // We need to be connected (or not ?)
    require_login($course, true);
    
    // And have the rights. I think we'll have to extend it to all users so they can see the logo on frontend :)
    if (! has_capability('orange/customers:edit', $context)) {
        return false;
    }
    
    // Get item ID which is the first
    $itemid = array_shift($args);
    
    // Filename is always the last item in $args
    $filename = array_pop($args); 
    
    // Define filepath, either what's left of the $args, or root
    if (!$args) {
        $filepath = '/';
    } else {
        $filepath = '/'.implode('/', $args).'/';
    }

    // Get file
    $fs = get_file_storage();
    $file = $fs->get_file($context->id, 'local_orange_customers', $filearea, $itemid, $filepath, $filename);
    
    // No file
    if (!$file) {
        return false;
    }

    // finally send the file
    send_stored_file($file, 86400, 0, true, $options); // download MUST be forced - security!
}
