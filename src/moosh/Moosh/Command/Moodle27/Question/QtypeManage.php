<?php
/**
 * moosh - Moodle Shell
 *
 * @copyright  2015 Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace Moosh\Command\Moodle27\Question;
use Moosh\MooshCommand;

class QtypeManage extends MooshCommand
{
    public function __construct()
    {
        parent::__construct('manage', 'qtype');
        $this->addArgument('action');
        $this->addArgument('qtypename');
    }

    public function execute()
    {
        global $CFG;
        require_once($CFG->libdir . '/questionlib.php');

        $action = $this->arguments[0];
        $qtype = $this->arguments[1];

        $qtypes = \question_bank::get_all_qtypes();
        if (!empty($qtype) and empty($qtypes[$qtype])) {
            echo "The qtype '" . $qtype ."' is not valid\n";
        }

        // Work of the correct sort order.
        if ($action == 'up' || $action == 'down') {
            $config = get_config('question');
            $sortedqtypes = array();
            foreach ($qtypes as $qtypename => $qt) {
                $sortedqtypes[$qtypename] = $qt->local_name();
            }
            $sortedqtypes = \question_bank::sort_qtype_array($sortedqtypes, $config);
        }

        switch ($action) {
            case 'disable':
                set_config($qtype . '_disabled', 1, 'question');
                echo "The question type '" . $qtype . "' was disabled\n";
                break;

            case 'enable':
                unset_config($qtype . '_disabled', 'question');
                echo "The question type '" . $qtype . "' was enabled\n";
                break;

            case 'down':
                $neworder = question_reorder_qtypes($sortedqtypes, $qtype, +1);
                question_save_qtype_order($neworder, $config);
                echo "The question type '" . $qtype . "' was down\n";
                break;

            case 'up':
                $neworder = question_reorder_qtypes($sortedqtypes, $qtype, -1);
                question_save_qtype_order($neworder, $config);
                echo "The question type '" . $qtype . "' was up\n";
                break;

            default:
                echo "The action '" . $action . "' is not valid\n";
                break;
        }
    }
}
