<?php
/**
 * moosh - Moodle Shell
 *
 * @copyright  2015 Orange (based on)
 * @copyright  2012 onwards Tomasz Muras
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace Moosh\Command\Moodle27\Activity;
use Moosh\MooshCommand;

class ActivityDelete extends MooshCommand
{
    public function __construct()
    {
        parent::__construct('delete', 'activity');

        $this->addArgument('mode');
        $this->addArgument('id');
        $this->addOption('n|name:', 'activity instance name');
    }

    public function execute() 
    {
        global $CFG, $DB;
        require_once $CFG->dirroot . '/course/lib.php';

        $mode = $this->arguments[0];

        $moduleid = NULL;
        switch ($mode) {
            case 'module':
                $moduleid = intval($this->arguments[1]);
                if ($moduleid <= 0) {
                    echo("Argument 'moduleid' must be bigger than 0.\n");
                } else {
                    if (!$DB->get_record('course_modules', array('id' => $this->arguments[0]))) {
                        echo("There is no such activity to delete.\n");
                    } else {
                        course_delete_module($moduleid);
                        echo "Deleted activity $moduleid\n";
                    }
                }
                break;
            case 'course':
                // $options are course module options.
                $options = $this->expandedOptions;

                if (!empty($options['name'])) {
                    if (!$module = $DB->get_record('modules', array('name' => $options['name']))) {
                        echo("There is no activity named '" . $options['name'] . "'\n");
                        break;
                    }
                    else {
                        if (!$moduleinstance = $DB->get_records('course_modules', array('module' => $module->id, 'course' => $this->arguments[1]))) {
                            echo("There is no activity '" . $options['name'] . "' in course '" . $this->arguments[1] . "'.\n");
                            break;
                        } else {
                            $nbinstance = count($moduleinstance);
                            if ($nbinstance == 1) {
                                course_delete_module(key($moduleinstance));
                                echo "Deleted activity '" . key($moduleinstance) . "'\n";
                            } else
                                echo "There is more than one module to delete (" . $nbinstance . ")\n";
                        }
                    }
                }
                else
                    echo("There is no name for activity.\n");
                break;
        }
    }
}

