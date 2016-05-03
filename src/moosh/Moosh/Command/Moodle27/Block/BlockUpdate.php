<?php
/**
 * moosh - Moodle Shell
 *
 * @copyright  2015 Oranges
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace Moosh\Command\Moodle27\Block;
use Moosh\MooshCommand;
use context_coursecat;
use context_course;

class BlockUpdate extends MooshCommand
{
    public function __construct()
    {
        parent::__construct('update', 'block');

        $this->addArgument('mode');
        $this->addArgument('id');
        $this->addArgument('blocktype');
        $this->addArgument('field');
        $this->addArgument('value');
    }

    public function execute()
    {
        global $CFG;

        $mode = $this->arguments[0];
        $id = $this->arguments[1];
        $blocktype = $this->arguments[2]; // name of the block (in English)
        $field = $this->arguments[3]; // field to change : 'showinsubcontexts', 'pagetypepattern', 'subpagepattern', 'defaultregion', 'defaultweight'
        $value = $this->arguments[4]; // new value for the field

        switch ($mode) {
            case 'category':
                $context = context_coursecat::instance($id /* categoryid */, MUST_EXIST);
                self::blockUpdate($context->id /* categorycontextid */,$blocktype,$field,$value);
                break;
            case 'course':
                $context = context_course::instance($id /* courseid */, MUST_EXIST);
                self::blockUpdate($context->id,$blocktype,$field,$value);
                break;

            case 'categorycourses':
                // get all courses in category (recursive).
                $courselist = get_courses($id /* categoryid */,'','c.id');
                foreach ($courselist as $course) {
                    $context = context_course::instance($course->id /* courseid */, MUST_EXIST);
                    self::blockUpdate($context->id,$blocktype,$field,$value);
                    echo "debug: courseid=$course->id \n";
                }
                break;
            case 'system':
                // For users.
                $context = \context_system::instance();
                self::blockUpdate($context->id,$blocktype,$field,$value);
                break;
        }
    }

    private function blockUpdate($contextid,$blocktype,$field,$value){
        global $CFG,$DB;
        require_once($CFG->dirroot . '/lib/blocklib.php');

        // Only update if already exist.
        $block_instances = $DB->get_records('block_instances', array('blockname'=>$blocktype, 'parentcontextid' => $contextid));
        if (!count($block_instances)) {
            echo "Block '" . $blocktype . "' doesn't exist on page '" . $pagetypepattern . "' with contextid " . $contextid . "\n";
        } else if (count($block_instances) == 1){
            $first_instance = array_shift($block_instances);

            // Update record.
            $newbi = new \stdClass;
            $newbi->id = $first_instance->id;
            $valid = 1;
            switch ($field) {
                case 'showinsubcontexts':
                    $newbi->showinsubcontexts = $value;
                    break;
                case 'pagetypepattern':
                    $newbi->pagetypepattern = $value;
                    break;
                case 'subpagepattern':
                    $newbi->subpagepattern = $value;
                    break;
                case 'defaultregion':
                    $newbi->defaultregion = $value;
                    break;
                case 'defaultweight':
                    $newbi->defaultweight = $value;
                    break;
                default:
                    $valid = 0;
                    echo "The field '" . $field . "' is not valid, it must be : 'showinsubcontexts', 'pagetypepattern', 'subpagepattern', 'defaultregion', 'defaultweight'\n";
                    break;
            }
            if($valid) {
                $DB->update_record('block_instances', $newbi);
                echo "Block was modified (blockid={$first_instance->id}), '" . $field . "' = '" . $value . "'\n";
            }
            
        } else {
            echo "More than one block '" . $blocktype . "' exist on page '" . $pagetypepattern . "' with contextid " . $contextid . "\n";
        }
    }
    protected function getArgumentsHelp()
    {
        return "\n\nARGUMENTS:".
                "\n\tcourse courseid blocktype field value".
                "\n\tcategorycourses categoryid[all] blocktype field value".
                "\n\tcategory categoryid blocktype field value";
    }
}
