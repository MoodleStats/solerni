<?php
/**
 * moosh - Moodle Shell
 *
 * @copyright  2015 Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace Moosh\Command\Moodle27\Admin;
use Moosh\MooshCommand;
use cache_administration_helper;
use cache_config_writer;

class CacheAdmin extends MooshCommand
{
    public function __construct()
    {
        parent::__construct('admin', 'cache');
        $this->addArgument('plugin');
        $this->addArgument('action');
        $this->addArgument('name');     
        $this->addOption('s|servers:', 'Servers');
        $this->addOption('p|prefix:', 'Prefix');
    }

    public function execute()
    {
        global $CFG, $DB;

        require_once($CFG->dirroot.'/lib/adminlib.php');
        require_once($CFG->dirroot.'/cache/locallib.php');
        require_once($CFG->dirroot.'/cache/forms.php');

        $plugin = $this->arguments[0];
        $action = $this->arguments[1];
        $name = $this->arguments[2];

        $plugins = cache_administration_helper::get_store_plugin_summaries();
   
        if (!empty($action)) {
	    switch ($action) {
		case 'rescandefinitions' : // Rescan definitions.
			cache_config_writer::update_definitions();
			break;
		case 'addstore' : // Add the requested store.
                    if ($this->expandedOptions['servers'] && $this->expandedOptions['prefix']) {
                        $servers = $this->expandedOptions['servers'];
                        $prefix = $this->expandedOptions['prefix'];
                        if (!$plugins[$plugin]['canaddinstance']) {
                            echo "ERROR : you can't add instance of " . $plugin . "\n"; 
                            break;
                        }
                        $data = new \stdClass();
                        $data->action = $action;
                        $data->plugin = $plugin;
                        $data->name = $name;
                        $data->servers = $servers;
                        $data->prefix = $prefix;
                        $data->lock = 'cachelock_file_default';
                        $data->compression = 1;
                        $data->serialiser = 1;
                        $data->hash = 0;
                        $data->bufferwrites = 0;
                        $data->sesskey="63pwThvBhd";
	                $config = cache_administration_helper::get_store_configuration_from_data($data);
		        $writer = cache_config_writer::instance();
                        unset($config['lock']);
                        foreach ($writer->get_locks() as $lock => $lockconfig) {
                            if ($lock == $data->lock) {
                                $config['lock'] = $data->lock;
                            }
                        }

                        $stores = cache_administration_helper::get_store_instance_summaries();
                        if (array_key_exists($data->name, $stores)) {
                            echo get_string('storenamealreadyused', 'cache') . "\n";
                            break;
                        }
                        $writer->add_store_instance($data->name, $data->plugin, $config);

                        echo "Cache store '" . $data->name . "' (" . $data->plugin . ") was added\n";
                    }
                    else
                        echo "Not enough arguments provided. Please specify: servers AND prefix\n";
				
		    break;

                case 'editmodemappings': // Edit default mode mappings.
		    $mappings = array(
		        \cache_store::MODE_APPLICATION => array($name),
		        \cache_store::MODE_SESSION => array("default_session"),
		        \cache_store::MODE_REQUEST => array("default_request"),
		    );

                    $stores = cache_administration_helper::get_store_instance_summaries();

                    if (!array_key_exists($name, $stores)) {
                        echo "The instance name for the new mapping does not exist\n";
                        break;
                    }

                    $writer = cache_config_writer::instance();
                    $writer->set_mode_mappings($mappings);

                    echo "Cache store '" . $name . "' was activated\n";

                    break;
            }
        }
    }

}
