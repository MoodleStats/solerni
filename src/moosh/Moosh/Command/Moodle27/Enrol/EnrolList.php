<?php
/**
 * moosh - Moodle Shell
 *
 * @copyright  2015 Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace Moosh\Command\Moodle27\Enrol;
use Moosh\MooshCommand;

class EnrolList extends MooshCommand
{
    public function __construct()
    {
        parent::__construct('list', 'enrol');

        $this->addOption('a|all', 'display all auth plugins, by default lists enabled only');
    }

    public function execute()
    {
        if ($this->expandedOptions['all']) {
            $plugins = enrol_get_plugins(false);
        } else {
            $plugins = enrol_get_plugins(true);
        }

        echo "\nList of enabled enrol plugins:\n\n";

        $i=0;
        foreach ($plugins as $key=>$enrol) {
            echo $i+1 . ". ". $key . "\n";
            $i = $i+1;
        }
    }

}
