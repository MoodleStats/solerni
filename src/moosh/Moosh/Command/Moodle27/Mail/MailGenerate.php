<?php
/**
 * moosh - Moodle Shell
 *
 * @copyright  2015 Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace Moosh\Command\Moodle27\Mail;
use Moosh\MooshCommand;

class MailGenerate extends MooshCommand
{
    public function __construct()
    {
        parent::__construct('generate', 'mail');
    }

    public function execute()
    {
        global $CFG;

        require_once($CFG->dirroot . '/local/orange_mail/classes/mail_generate.php');
        \mail_generate::generate();
        echo get_string('mailgeneratestatus', 'local_orange_mail') . "\n";
    }
}
