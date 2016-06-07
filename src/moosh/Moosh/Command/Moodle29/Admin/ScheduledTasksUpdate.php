<?php
/**
 * moosh - Moodle Shell
 *
 * @copyright  2016 Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace Moosh\Command\Moodle29\Admin;
use Moosh\MooshCommand;

class ScheduledTasksUpdate extends MooshCommand
{
    public function __construct()
    {
        parent::__construct('set', 'scheduledtask');

        $this->addArgument('name');
        $this->addArgument('minute');
        $this->addArgument('hour');
        $this->addArgument('day');
        $this->addArgument('month');
        $this->addArgument('dayofweek');
        $this->addArgument('disabled');
        $this->addArgument('customised');
       
        $this->maxArguments = 8;
    }
        
    public function execute()
    {
        global $DB;

        $name = trim($this->arguments[0]);
        $minute = trim($this->arguments[1]);
        $hour = trim($this->arguments[2]);
        $day = trim($this->arguments[3]);
        $month = trim($this->arguments[4]);
        $dayofweek = trim($this->arguments[5]);
        $disabled = trim($this->arguments[6]);
        $customised = trim($this->arguments[7]);

         $record = $DB->get_record('task_scheduled', array('classname' => $name));
          
         if ($record) {
            $record->minute = $minute;
            $record->hour = $hour;
            $record->day = $day;
            $record->month = $month;
            $record->dayofweek = $dayofweek;
            $record->disabled = $disabled;
            $record->customised = $customised;

            if ($DB->update_record('task_scheduled', $record)) {
                echo "Scheduled Task'" . $name . "' updated";
            } else {
                echo "Scheduled Task'" . $name . "' unknown";
            }
        }
    }
}