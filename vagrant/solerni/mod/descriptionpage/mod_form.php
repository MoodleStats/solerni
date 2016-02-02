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
 * Page configuration form
 *
 * @package mod
 * @subpackage descriptionpage
 * @copyright  2015 Orange based on mod_page plugin from 2009 Petr Skoda (http://skodak.org)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die;

require_once($CFG->dirroot.'/course/moodleform_mod.php');
require_once($CFG->dirroot.'/mod/descriptionpage/locallib.php');
require_once($CFG->libdir.'/filelib.php');

class mod_descriptionpage_mod_form extends moodleform_mod {
    public function definition() {
        global $CFG;

        $mform = $this->_form;

        $config = get_config('descriptionpage');

        // -------------------------------------------------------
        $mform->addElement('header', 'general', get_string('general', 'form'));

        $mform->addElement('text', 'name', get_string('name'), array('size' => '48'));
        if (!empty($CFG->formatstringstriptags)) {
            $mform->setType('name', PARAM_TEXT);
        } else {
            $mform->setType('name', PARAM_CLEANHTML);
        }
        $mform->addRule('name', null, 'required', null, 'client');
        $mform->addRule('name', get_string('maximumchars', '', 255), 'maxlength', 255, 'client');
        // 20160127 Orange change for Moodle 2.9.
        $this->standard_intro_elements();

        // Adding the "maxvisibility" field.
        $options = array(DESCRIPTIONPAGE_VISIBILITY_COURSEUSER => get_string('visiblecourseusers', 'descriptionpage'),
                DESCRIPTIONPAGE_VISIBILITY_LOGGEDINUSER => get_string('visibleloggedinusers', 'descriptionpage'),
                DESCRIPTIONPAGE_VISIBILITY_PUBLIC => get_string('visiblepublic', 'descriptionpage'));

        $mform->addElement('select', 'maxvisibility', get_string('maxvisibility', 'descriptionpage'), $options);
        $mform->setType('maxvisibility', PARAM_INT);
        $mform->addHelpButton('maxvisibility', 'maxvisibility', 'descriptionpage');

        // -------------------------------------------------------
        $mform->addElement('header', 'contentsection', get_string('contentheader', 'descriptionpage'));
        $descpagegeteditoropt = descriptionpage_get_editor_options($this->context);
        $mform->addElement('editor', 'descriptionpage', get_string('content', 'descriptionpage'), null, $descpagegeteditoropt);
        $mform->addRule('descriptionpage', get_string('required'), 'required', null, 'client');

        // -------------------------------------------------------
        $mform->addElement('header', 'appearancehdr', get_string('appearance'));

        if ($this->current->instance) {
            $options = resourcelib_get_displayoptions(explode(',', $config->displayoptions), $this->current->display);
        } else {
            $options = resourcelib_get_displayoptions(explode(',', $config->displayoptions));
        }
        if (count($options) == 1) {
            $mform->addElement('hidden', 'display');
            $mform->setType('display', PARAM_INT);
            reset($options);
            $mform->setDefault('display', key($options));
        } else {
            $mform->addElement('select', 'display', get_string('displayselect', 'descriptionpage'), $options);
            $mform->setDefault('display', $config->display);
        }

        if (array_key_exists(RESOURCELIB_DISPLAY_POPUP, $options)) {
            $mform->addElement('text', 'popupwidth', get_string('popupwidth', 'descriptionpage'), array('size' => 3));
            if (count($options) > 1) {
                $mform->disabledIf('popupwidth', 'display', 'noteq', RESOURCELIB_DISPLAY_POPUP);
            }
            $mform->setType('popupwidth', PARAM_INT);
            $mform->setDefault('popupwidth', $config->popupwidth);

            $mform->addElement('text', 'popupheight', get_string('popupheight', 'descriptionpage'), array('size' => 3));
            if (count($options) > 1) {
                $mform->disabledIf('popupheight', 'display', 'noteq', RESOURCELIB_DISPLAY_POPUP);
            }
            $mform->setType('popupheight', PARAM_INT);
            $mform->setDefault('popupheight', $config->popupheight);
        }

        $mform->addElement('advcheckbox', 'printheading', get_string('printheading', 'descriptionpage'));
        $mform->setDefault('printheading', $config->printheading);
        $mform->addElement('advcheckbox', 'printintro', get_string('printintro', 'descriptionpage'));
        $mform->setDefault('printintro', $config->printintro);

        // Add legacy files flag only if used.
        if (isset($this->current->legacyfiles) and $this->current->legacyfiles != RESOURCELIB_LEGACYFILES_NO) {
            $options = array(RESOURCELIB_LEGACYFILES_DONE   => get_string('legacyfilesdone', 'descriptionpage'),
                             RESOURCELIB_LEGACYFILES_ACTIVE => get_string('legacyfilesactive', 'descriptionpage'));
            $mform->addElement('select', 'legacyfiles', get_string('legacyfiles', 'descriptionpage'), $options);
            $mform->setAdvanced('legacyfiles', 1);
        }

        // -------------------------------------------------------
        $this->standard_coursemodule_elements();

        // -------------------------------------------------------
        $this->add_action_buttons();

        // -------------------------------------------------------
        $mform->addElement('hidden', 'revision');
        $mform->setType('revision', PARAM_INT);
        $mform->setDefault('revision', 1);
    }

    public function data_preprocessing(&$defaultvalues) {
        if ($this->current->instance) {
            $draftitemid = file_get_submitted_draft_itemid('descriptionpage');
            $defaultvalues['descriptionpage']['format'] = $defaultvalues['contentformat'];
            $ctxid = $this->context->id;
            $moddescpage = 'mod_descriptionpage';
            $ct = 'content';
            $descpaggeteditopt = descriptionpage_get_editor_options($this->context);
            $defvalues = $defaultvalues['content'];
            $fileprepdraft = file_prepare_draft_area($draftitemid, $ctxid, $moddescpage, $ct, 0, $descpaggeteditopt, $defvalues);
            $defaultvalues['descriptionpage']['text'] = $fileprepdraft;
            $defaultvalues['descriptionpage']['itemid'] = $draftitemid;
        }
        if (!empty($defaultvalues['displayoptions'])) {
            $displayoptions = unserialize($defaultvalues['displayoptions']);
            if (isset($displayoptions['printintro'])) {
                $defaultvalues['printintro'] = $displayoptions['printintro'];
            }
            if (isset($displayoptions['printheading'])) {
                $defaultvalues['printheading'] = $displayoptions['printheading'];
            }
            if (!empty($displayoptions['popupwidth'])) {
                $defaultvalues['popupwidth'] = $displayoptions['popupwidth'];
            }
            if (!empty($displayoptions['popupheight'])) {
                $defaultvalues['popupheight'] = $displayoptions['popupheight'];
            }
        }
    }
}

