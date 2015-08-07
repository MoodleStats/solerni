<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * @package    blocks
 * @subpackage orange_social_sharing
 * @copyright  2015 Orange
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class block_orange_social_sharing_edit_form extends block_edit_form {

    protected function specific_definition($mform) {

        // Section header title according to language file.
        $mform->addElement('header',
                'config_header',
                get_string('blocksettings',
                'block'));
        // A sample string variable with a default value.
        $mform->addElement('text',
                'config_title',
                get_string('configtitle',
                        'block_orange_social_sharing'));
        $mform->setDefault('config_title', get_string('configtitle',
                        'block_orange_social_sharing'));
        $mform->setType('config_title', PARAM_TEXT);
        // A sample string variable with a default value.
        $mform->addElement('advcheckbox',
                'config_facebook',
                get_string('labelfacebook', 'block_orange_social_sharing'),
                get_string('descfacebook', 'block_orange_social_sharing'),
                array('group' => 1),
                array(0, 1));
        $mform->addElement('advcheckbox',
                'config_twitter',
                get_string('labeltwitter', 'block_orange_social_sharing'),
                get_string('desctwitter', 'block_orange_social_sharing'),
                array('group' => 1),
                array(0, 1));
        $mform->addElement('advcheckbox',
                'config_linkedin',
                get_string('labellinkedin', 'block_orange_social_sharing'),
                get_string('desclinkedin', 'block_orange_social_sharing'),
                array('group' => 1),
                array(0, 1));
        $mform->addElement('advcheckbox',
                'config_googleplus',
                get_string('labelgoogleplus', 'block_orange_social_sharing'),
                get_string('descgoogleplus', 'block_orange_social_sharing'),
                array('group' => 1),
                array(0, 1));
    }

}