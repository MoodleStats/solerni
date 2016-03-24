<?php

/**
 * moosh - Moodle Shell
 *
 * @copyright  2012 onwards Tomasz Muras
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace Moosh\Command\Moodle27\Role;
use Moosh\MooshCommand;
use context_coursecat;
use context_course;
use context_block;

class RoleUpdateCapabilityContext extends MooshCommand
{
    public function __construct()
    {
        parent::__construct('update-capability-ctx', 'role');

        $this->addArgument('role'); // id or shortname
        $this->addArgument('capability'); // Example: block/calendar_month:myaddinstance
        $this->addArgument('value'); // CAP_INHERIT=0, CAP_ALLOW=1, CAP_PREVENT=-1, CAP_PROHIBIT=-1000
        $this->addArgument('context'); // "block"
        $this->addArgument('contextname'); // name of block
    }

    public function execute()
    {
        global $CFG, $DB;

        $arguments = $this->arguments;

        // with context and contexname (when id is not known).
        if(count($arguments) == 5) {
            switch ($arguments[3]) {
            case 'block':
                $instances = $DB->get_records('block_instances', array('blockname'=>$arguments[4], 'parentcontextid' => \context_system::instance()->id));

                if(count($instances)){
                    foreach ($instances as $instance) {
                        $context = context_block::instance($instance->id /* blockid */, MUST_EXIST);
                        $this->change_capability($arguments[0], $arguments[1], $arguments[2], $context->id); 
                        $context->mark_dirty();
                    }
                }
                else
                    echo "There is no instance of block '" . $arguments[4] . "' with parentcontextid " . \context_system::instance()->id . "\n";

                break;
            }
        } else if(count($arguments) == 4) {
            $contextid = $arguments[3];
            $this->change_capability($arguments[0], $arguments[1], $arguments[2], $contextid);
        } else {
            echo "There is not enough arguments \n";
        }        
    }

    /**
     * Assign capability from $rolevalue, $capability, $value and $contextid
     *
     * @static
     * @param int/string $rolevalue
     * @param string $capability
     * @param int $value
     * @param int $contextid
     * @return 
     */
    public function change_capability($rolevalue, $capability, $value, $contextid) {
        global $DB;

        //execute method
        if (is_numeric($rolevalue)) {
            $role = $DB->get_record('role', array('id' => $rolevalue));
            if (!$role) {
                echo "Role with id '" . $rolevalue . "' does not exist\n";
                exit(0);
            }
        } else {
            $role = $DB->get_record('role', array('shortname' => $rolevalue));
            if (!$role) {
                echo "Role '" . $rolevalue . "' does not exist.\n";
                exit(0);
            }
        }

        $capability_val = CAP_ALLOW;
        switch ($value) {
            case 'inherit': $capability_val = CAP_INHERIT; break;
            case 'allow': $capability_val = CAP_ALLOW; break;
            case 'prevent': $capability_val = CAP_PREVENT; break;
            case 'prohibit': $capability_val = CAP_PROHIBIT; break;
        }

        if (assign_capability($capability,$capability_val,$role->id,$contextid,true)) {
            echo "Capability '{$capability}' was set to {$capability_val} for roleid {$role->id} ({$role->shortname}) for contextid {$contextid} successfuly\n";
        }
    }
}
