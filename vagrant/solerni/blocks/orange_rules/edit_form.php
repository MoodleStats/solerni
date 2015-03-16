<?php
/**
 * Form for editing Orange Rules block instances.
 *
 * @package   block_orange_rules
 * @copyright 2015 Orange
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class block_orange_rules_edit_form extends block_edit_form {
    protected function specific_definition($mform) {
        // Fields for editing HTML block title and contents.
        $mform->addElement('header', 'configheader', get_string('blocksettings', 'block'));

        $mform->addElement('text', 'config_title', get_string('configtitleblankhides', 'block_orange_rules'));
        $mform->setType('config_title', PARAM_TEXT);

	}
}