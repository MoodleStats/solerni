<?php

/**
 * moosh - Moodle Shell
 *
 * @copyright  2015 Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace Moosh\Command\Moodle27\Filter;
use Moosh\MooshCommand;

class FilterManage extends MooshCommand
{
    public function __construct()
    {
        parent::__construct('manage', 'filter');

        $this->addArgument('action');
        $this->addArgument('filtername');
        $this->addOption('c|contentheadings', 'Apply to content and headings');
    }

    public function execute()
    {
        global $DB;

        $action = $this->arguments[0];
        $filtername = $this->arguments[1]; // name of the filter (in English)

        // Does filter exists?
        if (!empty($filtername)) {
            $filters = filter_get_all_installed();
            if (!array_key_exists($filtername, $filters)) {
                print_string('filternotinstalled', 'error',$filtername);
                echo "\n";
            }
            else {

                // 3 possible states of filter_set_global_state() : TEXTFILTER_ON, TEXTFILTER_OFF or TEXTFILTER_DISABLED.
                switch ($action) {
                    case 'on':
                        filter_set_global_state($filtername, TEXTFILTER_ON); // active filter.
                        if ($this->expandedOptions['contentheadings']) {
                            filter_set_applies_to_strings($filtername, true);
                        }
                        echo "Filter " . $filtername . " state =" . TEXTFILTER_ON . "\n";
                        break;

                    case 'off':
                        filter_set_global_state($filtername, TEXTFILTER_OFF); // disable filter.
                        echo "Filter " . $filtername . " state =" . TEXTFILTER_OFF . "\n";
                        break;

                    case 'disable':
                        filter_set_global_state($filtername, TEXTFILTER_DISABLED); // disable filter.
                        echo "Filter " . $filtername . " state =" . TEXTFILTER_DISABLED . "\n";
                        break;
                    default:
                        echo "The action '" . $action . "' doesn't exist\n";
                        echo "Action = on|off|disable\n";
                }
            }
        }

    }

    protected function getArgumentsHelp()
    {
        return "\n\nARGUMENTS:".
                "\n\taction[on|off|disable] filtername";
                //"\n\n\t-c|--contentheadings apply to content and headings";
    }
}
