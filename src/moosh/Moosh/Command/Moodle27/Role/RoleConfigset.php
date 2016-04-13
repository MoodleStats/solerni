<?php
/**
 * moosh - Moodle Shell
 *
 * @copyright  2015 Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace Moosh\Command\Moodle27\Role;
use Moosh\MooshCommand;

class RoleConfigset extends MooshCommand
{
    public function __construct()
    {
        parent::__construct('configset', 'role');

        $this->addArgument('name');
        $this->addArgument('value');
        $this->maxArguments = 3;
    }

    public function execute()
    {
        global $CFG, $DB;

        $name = trim($this->arguments[0]);
        $value = trim($this->arguments[1]);

        $plugin = NULL;
        if (isset($this->arguments[2])) {
            $plugin = trim($this->arguments[2]);
        }

        // List case.
        if(strpos($value, ',') !== false) {
            $roles = explode(',', $value);
            $id_str = "";
            foreach($roles as $str_role){
                $role = $DB->get_record('role', array('shortname' => trim($str_role)));
                if (!$role) {
                    echo "Parameter '" . $name . "' can't be changed - Role '" . $value . "' doesn't exist!\n";
                    exit(0);
                }
                else{
                    $id_str .= $role->id . ",";
                }
            }
            if(!empty($id_str)){
                set_config($name, substr($id_str,0,-1), $plugin);
            }
            else{
                echo "String '" . $value . "' can't be resolved\n";
                exit(0);
            }
        } else {
            $role = $DB->get_record('role', array('shortname' => $value));
            if (!$role) {
                echo "Parameter '" . $name . "' can't be changed - Role '" . $value . "' doesn't exist!\n";
                exit(0);
            }
            else {
                set_config($name, $role->id, $plugin);
            }
        }
        if(!isset($plugin)) {
            $plugin = 'moodle';
        }
        echo "New value: " . $plugin . "/" . $name . " = " . get_config($plugin,$name) . "\n";
    }

    protected function getArgumentsHelp()
    {
      return "\n\nARGUMENTS:\n\tname value [plugin]\n";
    }
}
