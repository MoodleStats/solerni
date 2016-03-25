<?php
/**
 * moosh - Moodle Shell
 *
 * @copyright  2012 onwards Tomasz Muras
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace Moosh\Command\Moodle28\Dev;
use Moosh\MooshCommand;

class GenerateGradeExport extends MooshCommand
{
    public function __construct()
    {
        parent::__construct('gradeexport', 'generate');

        $this->addArgument('export_name');
    }

    public function execute()
    {
        //copy newmodule
        $modPath = $this->topDir . '/grade/export/' . $this->arguments[0];
        if (file_exists($modPath)) {
            cli_problem("Already exists: '$modPath'");
            cli_problem("Not creating new grade export " . $this->arguments[0]);
            exit(1);
        }
        run_external_command("cp -r '{$this->mooshDir}/vendor/danielneis/moodle-gradeexport_newgradeexport' '$modPath'", "Copying from grade export template failed");

        if (file_exists("$modPath/.git")) {
            run_external_command("rm --interactive=never -r '$modPath/.git'", "Removing .git failed");
        }

        //replace newmodule with $this->arguments[0]
        run_external_command("find '$modPath' -type f -exec sed 's/newgradeexport/{$this->arguments[0]}/g' -i {} \;", "sed command failed");

        //rename lang/en/newmodule.php
        run_external_command("mv '$modPath/lang/en/gradeexport_newgradeexport.php' '$modPath/lang/en/gradeexport_{$this->arguments[0]}.php'", "Renaming lang file failed");
    }
}
