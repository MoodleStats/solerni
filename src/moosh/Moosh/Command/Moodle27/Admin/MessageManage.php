<?php

/**
 * moosh - Moodle Shell
 *
 * @copyright  2015 Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace Moosh\Command\Moodle27\Admin;
use Moosh\MooshCommand;

class MessageManage extends MooshCommand
{
    public function __construct()
    {
        parent::__construct('manage', 'message');

        $this->addArgument('action');
        $this->addArgument('messagename');
    }

    public function execute()
    {
        global $DB;

        $action = $this->arguments[0];
        $messagename = $this->arguments[1]; // name of the message (in English)

        $processors = get_message_processors();
        // Does filter exists?
        if (!empty($messagename)) {
            if (!array_key_exists($messagename, $processors)) {
                echo(get_string('outputdoesnotexist', 'message') . " : " . $messagename);
                echo "\n";
            }
            else {
                if (!$processor = $DB->get_record('message_processors', array('name'=>$messagename))) {
                    print_error('outputdoesnotexist', 'message');
                }
                // 2 possible states.
                switch ($action) {
                    case 'enable':
                        $DB->set_field('message_processors', 'enabled', '1', array('id'=>$processor->id));      // Enable output.
                        echo "Message output '" . $messagename . "' was Enable\n";
                        break;

                    case 'disable':
                            $DB->set_field('message_processors', 'enabled', '0', array('id'=>$processor->id));      // Disable output.
                        echo "Message output '" . $messagename . "' was Disable\n";
                        break;
                    default:
                        echo "The action '" . $action . "' doesn't exist\n";
                        echo "Action = enable|disable\n";
                }
            }
        }
    }

    protected function getArgumentsHelp()
    {
        return "\n\nARGUMENTS:".
                "\n\taction[enable|disable] messagename";
    }
}
