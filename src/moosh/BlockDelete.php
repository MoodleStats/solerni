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

class BlockDelete extends MooshCommand
{
    public function __construct()
    {
        parent::__construct('delete', 'block');

        $this->addArgument('mode');
        $this->addArgument('id');
        $this->addArgument('blocktype');
        $this->addArgument('pagetypepattern');
    }

    public function execute()
    {
        global $DB;

        $mode = $this->arguments[0];
        $id = $this->arguments[1];
        $blocktype = $this->arguments[2]; // name of the block (in English)
        $pagetypepattern = $this->arguments[3]; // in which page types it will be available ('course-*' , 'mod-*' ...)

        switch ($mode) {
            case 'category':
                $context = context_coursecat::instance($id /* categoryid */, MUST_EXIST);
                self::blockDelete($context->id /* categorycontextid */,$blocktype,$pagetypepattern);
                break;
            case 'course':
                $context = context_course::instance($id /* courseid */, MUST_EXIST);
                self::blockDelete($context->id,$blocktype,$pagetypepattern);
                break;

            case 'categorycourses':
                //get all courses in category (recursive)
                $courselist = get_courses($id /* categoryid */,'','c.id');
                foreach ($courselist as $course) {
                    $context = context_course::instance($course->id /* courseid */, MUST_EXIST);
                    self::blockDelete($context->id,$blocktype,$pagetypepattern);
                    echo "debug: courseid=$course->id \n";
                }
                break;
            case 'system':
                //For users.
                $context = \context_system::instance();
                self::blockDelete($context->id,$blocktype,$pagetypepattern);

                break;
        }

    }

    private function blockDelete($contextid,$blocktype,$pagetypepattern){
        global $CFG,$DB;

        //Only delete if already exist.
        $block_instances = $DB->get_records('block_instances', array('blockname' => $blocktype, 'pagetypepattern' => $pagetypepattern, 'parentcontextid' => $contextid));
        $nb_blocks = count($block_instances);
        if (count($block_instances)) {
            $DB->delete_records('block_instances', array('blockname' => $blocktype, 'pagetypepattern' => $pagetypepattern, 'parentcontextid' => $contextid));
            if($nb_blocks == 1)
                echo $nb_blocks . " block '" . $blocktype . "' was deleted\n";
            else
                echo $nb_blocks . " blocks '" . $blocktype . "' were deleted\n";
        }else{
            echo "There is no block '" . $blocktype . "' on page '" . $pagetypepattern . "' with contextid " . $contextid . "\n";
        }

    }

    protected function getArgumentsHelp()
    {
        return "\n\nARGUMENTS:".
                "\n\tsystem 0 blocktype pagetypepattern".
                "\n\tcourse courseid blocktype pagetypepattern".
                "\n\tcategorycourses categoryid[all] blocktype pagetypepattern".
                "\n\tcategory categoryid blocktype pagetypepattern".
                "\n\n\tpagetypepattern = *|course-view-*|mod-*-view|site-index|...";
    }
}
