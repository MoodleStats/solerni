<?php
/**
 * moosh - Moodle Shell
 *
 * @copyright  2012 onwards Tomasz Muras
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @author     Kacper Golewski <k.golewski@gmail.com>
 */

namespace Moosh\Command\Generic\Plugin;
use Moosh\MooshCommand;

class PluginList extends MooshCommand
{
    static $APIURL = "https://download.moodle.org/api/1.3/pluglist.php";

    public function __construct()
    {
        parent::__construct('list', 'plugin');

        $this->addOption('p|path:', 'path to plugins.json file', home_dir() . '/.moosh/plugins.json');
    }

    public function execute()
    {

        $filepath = $this->expandedOptions['path'];

        $stat = stat($filepath);
        if(!$stat || time() - $stat['mtime'] > 60*60*24 || !$stat['size']) {
            unlink($filepath);
            file_put_contents($filepath, fopen(self::$APIURL, 'r'));
        }
        $jsonfile = file_get_contents($filepath);

        if($jsonfile === false) {
            die("Can't read json file");
        }

        $data = json_decode($jsonfile);
        $fulllist = array();
        foreach($data->plugins as $k=>$plugin) {
            if(!$plugin->component) {
                continue;
            }
            $fulllist[$plugin->component] = array();
            foreach($plugin->versions as $v=>$version) {
                foreach($version->supportedmoodles as $supportedmoodle) {
                    $fulllist[$plugin->component]['releases'][$supportedmoodle->release] = $version;
                }
                $fulllist[$plugin->component]['url'] = $version->downloadurl;
            }
        }

        ksort($fulllist);
        foreach($fulllist as $k => $plugin) {
            $versions = array_keys($plugin['releases']);
            sort($versions);

            echo "$k," .implode(",",$versions) . ",".$plugin['url'] ."\n";
        }
    }

    public function bootstrapLevel()
    {
        return self::$BOOTSTRAP_NONE;
    }
}
