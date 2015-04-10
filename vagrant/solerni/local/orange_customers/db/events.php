<?php
/**
 * Orange rules event handler definition.
 *
 * @package    local
 * @subpackage orange_rules
 * @category event
 * @copyright 2015 Orange
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$observers = array(

	array(
		'eventname'   => '\core\event\course_category_created',
		'callback'    => 'local_orange_customers_observer::customer_created',
	),
	array(
		'eventname'   => '\core\event\course_category_updated',
		'callback'    => 'local_orange_customers_observer::customer_updated',
	)
		
		
);
