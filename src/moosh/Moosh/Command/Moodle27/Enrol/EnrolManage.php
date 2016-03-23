<?php
/**
 * moosh - Moodle Shell
 *
 * @copyright  2015 Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace Moosh\Command\Moodle27\Enrol;
use Moosh\MooshCommand;

class EnrolManage extends MooshCommand
{
    public function __construct()
    {
        parent::__construct('manage', 'enrol');
        $this->addArgument('action');
        $this->addArgument('pluginname');
    }

    public function execute()
    {
        global $CFG;

        $action = $this->arguments[0];
        $pluginname = $this->arguments[1];

        // Does the authentication module exist?
        $plugins = enrol_get_plugins(false);
        $exist=false;
        foreach ($plugins as $key=>$enrol) {
            if($key == $pluginname)
                $exist = true;
        }
        if(!$exist) {
            echo("Enrol plugin '". $pluginname . "' is not installed \n");
            die;
        }   

        // Get enabled plugins.
        $enrolsenabled = enrol_get_plugins(true);

        switch($action) {
            case 'disable':
                $is_enabled = array_key_exists($pluginname, $enrolsenabled);
                if ($is_enabled !== false) {
                    $this->disable_plugin($pluginname, $enrolsenabled);
                }
                break;
            case 'down':
               echo "The action 'down' is not implemented yet\n";
               break;
            case 'enable':
                if(!in_array($pluginname, $enrolsenabled)) {
                    $this->enable_plugin($pluginname, $enrolsenabled);
                }   
                break;
            case 'up':
                echo "The action 'down' is not implemented yet\n";
                break;
            default:
                echo "The action '" . $action . "' doesn't exist\n";
                echo "Action = enable|disable\n";
        }
    }

    protected function enable_plugin($pluginname, $enabled) {
        $enabled[$pluginname] = true;
        $enabled = array_keys($enabled);
        set_config('enrol_plugins_enabled', implode(',', $enabled));
        echo("Enrol plugin '". $pluginname . "' was enabled \n");
    }

    protected function disable_plugin($pluginname, $enabled) {
        unset($enabled[$pluginname]);
        $enabled = array_keys($enabled);
        set_config('enrol_plugins_enabled', implode(',', $enabled));
        echo("Enrol plugin '". $pluginname . "' was disabled \n");
    }

}

