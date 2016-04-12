<?php

/**
 * moosh - Moodle Shell
 *
 * @copyright  2016 Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace Moosh\Command\Moodle27\Networking;
use Moosh\MooshCommand;

class PeerFields extends MooshCommand
{
    public function __construct()
    {
        parent::__construct('fields', 'peer');

        $this->addArgument('fields');
    }

    public function execute()
    {
        $fields = trim($this->arguments[0]);

        $mnet = get_mnet_environment();

        $hosts = mnet_get_hosts(true);
        foreach($hosts as $host) {
            if($host->name != "All Hosts") {
                // Set selected fields.
                set_config("host{$host->id}importfields", $fields, "mnet");
                set_config("host{$host->id}exportfields", $fields, "mnet");
                // Disabled default fields.
                set_config("host{$host->id}importdefault", 0, "mnet");
                set_config("host{$host->id}exportdefault", 0, "mnet");
            }
        }
        
    }

    protected function getArgumentsHelp()
    {
        return "\n\nARGUMENTS:".
                "\n\tfields[policyagreed,suspended,idnumber,...]";
                //"\n\n\t-c|--contentheadings apply to content and headings";
    }
}
