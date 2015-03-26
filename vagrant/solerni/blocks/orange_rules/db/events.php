<?php
/**
 * Forum event handler definition.
 *
 * @package block_orange_rules
 * @category event
 * @copyright 2015 Orange
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// List of observers.
$observers = array(

    array(
        'eventname'   => '\core\event\user_created',
        'callback'    => 'block_orange_rules_observer::user_created',
    )
);
