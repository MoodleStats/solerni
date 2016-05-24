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
                if ($id == "all"){
                    $courselist = get_courses();
                    foreach ($courselist as $course) {
                        $context = context_course::instance($course->id /* courseid */, MUST_EXIST);
                        self::blockDelete($context->id,$blocktype,$pagetypepattern);
                        echo "debug: courseid=$course->id \n";
                    }
                }
                else {
                    $context = context_course::instance($id /* courseid */, MUST_EXIST);
                    self::blockDelete($context->id,$blocktype,$pagetypepattern);
                }
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
                // Could target specific context.
                $contextid = \context_system::instance()->id;
                self::blockDelete($contextid,$blocktype,$pagetypepattern);
                break;

            case 'context':
                self::blockDelete($id,$blocktype,$pagetypepattern);
                break;

        }

    }

    private function blockDelete($contextid,$blocktype,$pagetypepattern){
        global $DB;
        $paramarray = array('blockname' => $blocktype, 'pagetypepattern' => $pagetypepattern, 'parentcontextid' => $contextid);
        if ($contextid != "all") {
            $paramarray = array('blockname' => $blocktype, 'pagetypepattern' => $pagetypepattern);

        }
        //Only delete if already exist.
        $block_instances = $DB->get_records('block_instances', $paramarray);
        $nb_blocks = count($block_instances);
        if ($nb_blocks) {
            $DB->delete_records('block_instances', $paramarray);
            if($nb_blocks == 1)
                echo $nb_blocks . " block '" . $blocktype . "' was deleted\n";
            else
                echo $nb_blocks . " blocks '" . $blocktype . "' were deleted\n";
        } else {
            echo "There is no block '" . $blocktype . "' to delete on page '" . $pagetypepattern . "' with contextid " . $contextid . "\n";
        }

    }

    protected function getArgumentsHelp()
    {
        return "\n\nARGUMENTS:".
                "\n\tcontext contextid blocktype pagetypepattern => delete block with the specific contextid".
                "\n\tsystem 0 blocktype pagetypepattern => delete block at context system (1)".
                "\n\tcourse courseid blocktype pagetypepattern => delete block for courseid course".
                "\n\tcategorycourses categoryid[all] blocktype pagetypepattern".
                "\n\tcategory categoryid blocktype pagetypepattern".
                "\n\n\tpagetypepattern = *|course-view-*|mod-*-view|site-index|...";
    }
}
