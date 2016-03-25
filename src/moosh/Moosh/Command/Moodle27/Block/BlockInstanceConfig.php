<?php
/**
 * moosh - Moodle Shell
 *
 * @copyright  2015 Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace Moosh\Command\Moodle27\Block;
use Moosh\MooshCommand;
use context_coursecat;
use context_course;
use context_block;

class BlockInstanceConfig extends MooshCommand
{
    public function __construct()
    {
        parent::__construct('instance_config', 'block');

        $this->addArgument('mode');
        $this->addArgument('id');
        $this->addArgument('blockname');
        $this->addArgument('pagetypepattern');
        $this->addArgument('name');
        $this->addArgument('value');
    }

    public function execute()
    {
        global $CFG, $DB;

        $mode = $this->arguments[0];
        $id = $this->arguments[1];
        $blockname = $this->arguments[2]; // name of the block (in English)
        $pagetypepattern = $this->arguments[3]; // in which page types it will be available ('course-*' , 'mod-*' ...)
        $configname = $this->arguments[4];
        $configvalue = $this->arguments[5];

        switch ($mode) {
            case 'category':
                $context = context_coursecat::instance($id /* categoryid */, MUST_EXIST);
                break;
            case 'course':
                $context = context_course::instance($id /* courseid */, MUST_EXIST);
                break;
            case 'system':
                //For users.
                $context = \context_system::instance();
                break;
        }
        self::blockConfigSave($context->id,$blockname,$pagetypepattern,$configname, $configvalue);
    }

    private function blockConfigSave($contextid,$blockname,$pagetypepattern,$configname, $configvalue){
        global $CFG,$DB;
        require_once($CFG->dirroot . '/lib/blocklib.php');

        if (empty($pagetypepattern)) {
            $pagetypepattern = '*';
        }

        $instances = $DB->get_records('block_instances', array('blockname'=>$blockname, 'pagetypepattern' => $pagetypepattern, 'parentcontextid' => $contextid));

        if(count($instances)){
            foreach ($instances as $instance) {
                $config = unserialize(base64_decode($instance->configdata));
                echo "Last configuration : \n";
                print_r($config);
                $config->$configname = $configvalue;
                $DB->set_field('block_instances', 'configdata', base64_encode(serialize($config)), array('id' => $instance->id));
                echo "New configuration : " . $configname . " = " . $configvalue . "\n";
            }
        }
        else
            echo "There is no instance of block '" . $blockname . "' on page '" . $pagetypepattern . "' with contextid " . $contextid . "\n";
    }
    protected function getArgumentsHelp()
    {
        return "\n\nARGUMENTS:".
                "\n\tcourse courseid blockname pagetypepattern name value".
                "\n\tcategorycourses categoryid[all] blockname pagetypepattern name value".
                "\n\tcategory categoryid blockname pagetypepattern name value".
                "\n\n\tpagetypepattern = *|course-view-*|mod-*-view|site-index|...".
                "\n\tname = name of config to change for block instance".
                "\n\tvalue = value of config to change for block instance";
    }
}
