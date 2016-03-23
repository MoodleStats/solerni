<?php
/**
 * moosh - Moodle Shell
 *
 * @copyright  2015 Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace Moosh\Command\Moodle27\User;
use Moosh\MooshCommand;

class UsernameConfigset extends MooshCommand
{
    public function __construct()
    {
        parent::__construct('configset', 'username');

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


        $user = $DB->get_record('user', array('username' => $value));
        if (!$user) {
            echo "Parameter '" . $name . "' can't be changed - User '" . $value . "' doesn't exist!\n";
            exit(0);
        }
        else {
            $valexist = get_config($plugin,$name);
            if($valexist !== $user->id){
                set_config($name, $user->id, $plugin);
                if(!isset($plugin)) {
                    $plugin = 'moodle';
                }
                echo "New value: " . $plugin . "/" . $name . " = " . get_config($plugin,$name) . "\n";
            }
            else{
                echo "Value already exists with the right userid=" . $user->id . " \n";
            }
        }
    }

    protected function getArgumentsHelp()
    {
      return "\n\nARGUMENTS:\n\tname value [plugin]\n";
    }
}
