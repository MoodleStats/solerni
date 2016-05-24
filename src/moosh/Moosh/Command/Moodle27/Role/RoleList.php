<?php
/**
 * moosh - Moodle Shell
 *
 * List roles.
 *
 * @copyright  2012 onwards Tomasz Muras
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace Moosh\Command\Moodle27\Role;

use Moosh\MooshCommand;
use context_system;

class RoleList extends MooshCommand {
    public function __construct() {
        parent::__construct('list', 'role');
    }

    public function execute() {
        global $DB, $CFG;

        require_once $CFG->dirroot . '/lib/accesslib.php';
        require_once($CFG->dirroot . '/enrol/locallib.php');
        require_once($CFG->dirroot . '/group/lib.php');

        @error_reporting(E_ALL | E_STRICT);
        @ini_set('display_errors', '1');

        $options = $this->expandedOptions;
        $limit_from = 0;

        if (count($this->arguments) == 0) {
            $roles = ("SELECT * FROM {role}");
            $limit_to = 100;
        } else {
            echo "Invalid arguments.\n";
        }

        $roles = $DB->get_records_sql($roles, $params = null, $limit_from, $limit_to);

        foreach ($roles as $role) {
            $to_print = $role->shortname . " ({$role->id}), " . $role->name . ", ";
            echo $to_print . "\n";
        }
    }
}
