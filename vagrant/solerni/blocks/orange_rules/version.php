<?php

/**
 * Version details
 *
 * @package    block_orange_rules
 * @copyright  2015 Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$plugin->version   = 2015031000;        // The current plugin version (Date: YYYYMMDDXX)
$plugin->requires  = 2014050800;        // Requires this Moodle version
$plugin->component = 'block_orange_rules';   // Full name of the plugin (used for diagnostics)
$plugin->dependencies = array (
    'local_orange_rules' => 2015031007
);
