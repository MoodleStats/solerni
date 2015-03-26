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
        'eventname'   => '\core\event\cohort_deleted',
        'callback'    => 'local_orange_rules_observer::rule_suspended',
    )

);