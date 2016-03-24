<?php

/**
 * moosh - Moodle Shell
 *
 * @copyright  2015 Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace Moosh\Command\Moodle27\Networking;
use Moosh\MooshCommand;

class PeerManage extends MooshCommand
{
    public function __construct()
    {
        parent::__construct('manage', 'peer');

        $this->addArgument('pluginname');
        $this->addArgument('state');
    }

    public function execute()
    {
        global $CFG, $DB;

        $pluginname = $this->arguments[0];
        $state = trim($this->arguments[1]);

        if($state == "on" && $pluginname == "mnet"){

            $mnet = get_mnet_environment();

            $hosts = mnet_get_hosts(true);
            $mnet_peer = new \mnet_peer();
            foreach($hosts as $host) {
                $mnet_peer->set_id($host->id);
                if($host->name == "All Hosts"){         
                    $myservices = mnet_get_service_info($mnet_peer);
                    foreach ($myservices as $name => $versions) {
                        if($versions[1]['pluginname'] == $pluginname){
                            $host2service   = $DB->get_record('mnet_host2service', array('hostid'=> $host->id, 'serviceid'=>$versions[1]['serviceid']));
                            if(false == $host2service){
                                $host2service = new \stdClass();
                                $host2service->hostid = $host->id;
                                $host2service->serviceid = $versions[1]['serviceid'];

                                $host2service->publish = 1;
                                $host2service->subscribe = 1;
                                $host2service->id = $DB->insert_record('mnet_host2service', $host2service);
                                echo "Mnet service '" . $name . "' was published and subscribed\n";
                            }else if($host2service->publish != 1 || $host2service->subscribe != 1){
                                $host2service->publish = 1;
                                $host2service->subscribe = 1;
                                $DB->update_record('mnet_host2service', $host2service);
                                echo "Mnet service '" . $name . "' was published and subscribed\n";
                            }
                        }
                    }
                }
            }
        }
        else{
            echo "The pluginname '" . $pluginname . "' doesn't exist\n";
            echo "possible pluginname = mnet\n";
            echo "OR The state '" . $state . "' doesn't exist\n";
            echo "possible state = on\n";
        }
        
    }

    protected function getArgumentsHelp()
    {
        return "\n\nARGUMENTS:".
                "\n\tpluginname[mnet|mahara...] state[on|off|disable]";
                //"\n\n\t-c|--contentheadings apply to content and headings";
    }
}
