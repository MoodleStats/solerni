<?php
/**
 * moosh - Moodle Shell
 *
 * @copyright  2012 onwards Tomasz Muras
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace Moosh\Command\Moodle27\Role;
use Moosh\MooshCommand;

class RoleImport extends MooshCommand
{
    public function __construct()
    {
        parent::__construct('import', 'role');

        $this->addArgument('shortname');
        $this->addArgument('importfile');
    }

    public function execute()
    {
        global $CFG, $DB;

        $arguments = $this->arguments;
        $shortname = $this->arguments[0];
        $filearg = $this->arguments[1];

        //don't create if already exists.
        $role = $DB->get_record('role', array('shortname' => $shortname));
        if ($role) {
            echo "Role '" . $shortname . "' already exists!\n";
            exit(0);
        }

        if (substr($filearg, 0, 1) == '/') {
            // Absolute file.
            $filename = $filearg;
        } else {
            // Relative to current directory.
            $filename = $this->cwd . DIRECTORY_SEPARATOR . $filearg;
        }
        $fh = fopen($filename, 'r');
        $roledefinition = fread($fh, filesize($filename));

        if ($roledefinition) {
            $systemcontext = \context_system::instance();
            $options = array(
                'shortname'     => 1,
                'name'          => 1,
                'description'   => 1,
                'permissions'   => 1,
                'archetype'     => 1,
                'contextlevels' => 1,
                'allowassign'   => 1,
                'allowoverride' => 1,
                'allowswitch'   => 1,
                'permissions'   => 1);

            $definitiontable = new \core_role_define_role_table_advanced($systemcontext, 0);

            // Add all permissions from definition file to $_POST, otherwise, they won't be applied.
            $info = \core_role_preset::parse_preset($roledefinition);
            $_POST = $info['permissions'];
            $definitiontable->read_submitted_permissions();

            $definitiontable->force_preset($roledefinition, $options);
            // ATTENTION : can send dmlwriteexception - Error writing to database Debug: Duplicate entry.
            $definitiontable->save_changes();

            //echo "$newroleid\n";
        }
    }
}
