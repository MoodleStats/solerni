<?php

/**
 * moosh - Moodle Shell
 *
 * @copyright  2015 Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace Moosh\Command\Moodle27\Networking;
use Moosh\MooshCommand;

class PeerAdd extends MooshCommand
{
    public function __construct()
    {
        parent::__construct('add', 'peer');

        $this->addArgument('wwwroot');
    }

    public function execute()
    {
        global $CFG;
        $wwwroot = $this->arguments[0];
        $peers = explode(",",$wwwroot);
        $ipwwwroot = parse_url($CFG->wwwroot, PHP_URL_PORT);
        $schemewwwroot = parse_url($CFG->wwwroot, PHP_URL_SCHEME);
        $hostwwwroot = get_host_from_url($CFG->wwwroot);

        if(!empty($ipwwwroot))
            $hostwwwroot = $hostwwwroot . ":" . $ipwwwroot;
        if(!empty($schemewwwroot))
            $hostwwwroot = $schemewwwroot . "://" . $hostwwwroot;
        else
            echo "You have to specify an url scheme ('http' or 'https')\n";

        if(count($peers) > 0){
            foreach($peers as $key => $peer){
                if(($hostwwwroot === $peers[0]) && $key === 0){
                    set_config("mnet_home", 1, "theme_halloween");  
                }
                else if(($hostwwwroot === $peers[0]) && $key > 0){
                    echo $this->addMNetPeer($peer);
                } 
                else if(($hostwwwroot != $peers[0]) && $key == 0){
                    echo $this->addMNetPeer($peers[0]);
                }
                else if($hostwwwroot === $peer){
                    set_config("mnet_home", 0, "theme_halloween");
                }
            }
        }
        else{
            if($hostwwwroot != $wwwroot)
                echo $this->addMNetPeer($wwwroot);        
        }
    }

    // $wwwroot : peer to add
    function addMNetPeer($wwwroot)
    {
        global $DB, $CFG;

        require_once($CFG->libdir.'/adminlib.php');
        require_once($CFG->dirroot . '/mnet/lib.php');
        require_once($CFG->dirroot . '/'.$CFG->admin.'/mnet/peer_forms.php');

        // Application : moodle
        $applicationid = 1;

        // Check that host is not already define
        if ($host = $DB->get_record('mnet_host', array('wwwroot' => $wwwroot))) {
            $output = "Peer " . $wwwroot . " already exist - nothing added \n";
        } else {
            $mnet_peer = new \mnet_peer();
            $mnet_peer->set_applicationid($applicationid);
            $application = $DB->get_field('mnet_application', 'name', array('id' => $applicationid));

            // WARNING : 503 Service Unavailable + dmlwriteexception when IP doesn't exist
            try{
                $res1 = $mnet_peer->bootstrap($wwwroot, null, $application);

                $mnet_peer->commit();
                $host = $DB->get_record('mnet_host', array('wwwroot' => $wwwroot));

                $output = sprintf("Peer %s added \n", $mnet_peer->name);
            } catch (Exception $e) {
                // Failed : dmlwriteexception in BDD
                echo "Failed to request " . $wwwroot;
                die;
            }
        }

        // define service for this host
        // should add subscribe and publish for sso_idp, sso_sp and mnet_enrol
        $services = array (1 => 'sso_idp', 2 => 'sso_sp', 3 => 'mnet_enrol');
        foreach ($services as $service => $servicename) {
            $host2service = $DB->get_record('mnet_host2service', array('hostid' => $host->id, 'serviceid' => $service));

            $publish = 1;
            $subscribe = 1;
        
            if (false == $host2service && ($publish == 1 || $subscribe == 1)) {
                $host2service = new \stdClass();
                $host2service->hostid = $host->id;
                $host2service->serviceid = $service;

                $host2service->publish = $publish;
                $host2service->subscribe = $subscribe;

                $host2service->id = $DB->insert_record('mnet_host2service', $host2service);
            
                $output .= " - service $servicename added \n";
            } elseif ($host2service->publish != $publish || $host2service->subscribe != $subscribe) {
                $host2service->publish   = $publish;
                $host2service->subscribe = $subscribe;
                $DB->update_record('mnet_host2service', $host2service);

                $output .= " - service $servicename updated \n";
            }
        }

        return $output;
    }

    // $wwwroot : peer
    // not used because we don't know what url scheme to force (https or http ?)
    function formatdomain($wwwroot)
    {
        // Check wwwroot format
        if (strtolower(substr($wwwroot, 0, 4)) != 'http') {
            $wwwroot = 'http://'.$wwwroot;
        }
        $wwwroot = trim($wwwroot);
        $wwwroot = rtrim($wwwroot, '/');

        return $wwwroot;
    }


    protected function getArgumentsHelp()
    {
        return "\n\nARGUMENTS:".
                "\n\twwwroot[ip1,ip2...]";
    }
}
