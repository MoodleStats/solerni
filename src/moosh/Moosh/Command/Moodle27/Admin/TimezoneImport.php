<?php

/**
 * moosh - Moodle Shell
 *
 * @copyright  2015 Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace Moosh\Command\Moodle27\Admin;
use Moosh\MooshCommand;

class TimezoneImport extends MooshCommand
{
    public function __construct()
    {
        parent::__construct('import', 'timezone');
        $this->addArgument('name');
    }

    public function execute()
    {
        global $CFG, $DB;

        require_once($CFG->libdir.'/adminlib.php');
        require_once($CFG->libdir.'/filelib.php');
        require_once($CFG->libdir.'/olson.php');
        $name = $this->arguments[0];

        // Check that "Europe/Paris" is not already define
        if ($timezone = $DB->get_records('timezone', array('name' => $name))) {
            echo "timezone " . $name . " already exist - nothing added \n";
        } 
        else {

            $importdone = false;
       
            /// First, look for an Olson file locally
            $source = $CFG->tempdir.'/olson.txt';
            if (!$importdone and is_readable($source)) {
	        if ($timezones = olson_to_timezones($source)) {
		    update_timezone_records($timezones);
		    $importdone = $source;
	        }
            }

            /// Next, look for a CSV file locally
            $source = $CFG->tempdir.'/timezone.txt';
            if (!$importdone and is_readable($source)) {
	        if ($timezones = get_records_csv($source, 'timezone')) {
		    update_timezone_records($timezones);
		    $importdone = $source;
	        }
            }

            /// Otherwise, let's try moodle.org's copy
            $source = 'https://download.moodle.org/timezone/';
            if (!$importdone && ($content=download_file_content($source))) {
	        if ($file = fopen($CFG->tempdir.'/timezone.txt', 'w')) {            // Make local copy
		    fwrite($file, $content);
		    fclose($file);
		    if ($timezones = get_records_csv($CFG->tempdir.'/timezone.txt', 'timezone')) {  // Parse it
			update_timezone_records($timezones);
			$importdone = $source;
		    }
		    unlink($CFG->tempdir.'/timezone.txt');
	        }
            }

            /// Final resort, use the copy included in Moodle
            $source = $CFG->dirroot.'/lib/timezone.txt';
            if (!$importdone and is_readable($source)) {  // Distribution file
	        if ($timezones = get_records_csv($source, 'timezone')) {
		    update_timezone_records($timezones);
		    $importdone = $source;
	        }
            }

            /// That's it!
            if ($importdone) {
	        $a = new \stdClass();
	        $a->count = count($timezones);
	        $a->source  = $importdone;
	        echo get_string('importtimezonescount', 'tool_timezoneimport', $a)."\n";

	        $timezonelist = array();
	        foreach ($timezones as $timezone) {
		    if (is_array($timezone)) {
			$timezone = (object)$timezone;
		    }
		    else if ($timezone->name === $name) {
			echo "timezone " . $name . " was added \n";
		    }
	        }
            }
        }
    }

}
