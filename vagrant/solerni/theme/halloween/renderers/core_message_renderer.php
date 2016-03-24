<?php
// This file is part of The Orange Halloween Moodle Theme
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

include_once($CFG->dirroot . "/message/renderer.php");

class theme_halloween_core_message_renderer extends core_message_renderer {

    /**
     * Display the interface for messaging options
     *
     * @param array $processors Array of objects containing message processors
     * @param array $providers Array of objects containing message providers
     * @param array $preferences Array of objects containing current preferences
     * @param array $defaultpreferences Array of objects containing site default preferences
     * @param bool $notificationsdisabled Indicate if the user's "emailstop" flag is set (shouldn't receive any non-forced notifications)
     * @param null|int $userid User id, or null if current user.
     * @return string The text to render
     */
    public function manage_messagingoptions($processors, $providers, $preferences, $defaultpreferences,
                                            $notificationsdisabled = false, $userid = null) {
        global $USER;
        if (empty($userid)) {
            $userid = $USER->id;
        }
        // Filter out enabled, available system_configured and user_configured processors only.
        $readyprocessors = array_filter($processors, create_function('$a', 'return $a->enabled && $a->configured && $a->object->is_user_configured();'));

        // Start the form.  We're not using mform here because of our special formatting needs ...
        $output = html_writer::start_tag('form', array('method'=>'post', 'class' => 'mform'));
        $output .= html_writer::empty_tag('input', array('type'=>'hidden', 'name'=>'sesskey', 'value'=>sesskey()));

        /// Settings table...
        $output .= html_writer::start_tag('fieldset', array('id' => 'providers', 'class' => 'clearfix'));
        $output .= html_writer::nonempty_tag('legend', get_string('providers_config', 'message'), array('class' => 'ftoggler'));

        foreach($providers as $provider) {
            if($provider->component != 'moodle') {
                $components[] = $provider->component;
            }
        }
        // Lets arrange by components so that core settings (moodle) appear as the first table.
        $components = array_unique($components);
        asort($components);
        array_unshift($components, 'moodle'); // pop it in front! phew!
        asort($providers);

        $numprocs = count($processors);
        // Display the messaging options table(s)
        // Select components used by Solerni form email configuration
        $usedcomponents = array('moodle');
        foreach ($components as $component) {
            if (in_array($component, $usedcomponents)) {
                $provideradded = false;
                $table = new html_table();
                $table->attributes['class'] = 'generaltable';
                $table->data = array();
                if ($component != 'moodle') {
                    $componentname = get_string('pluginname', $component);
                } else {
                    $componentname = get_string('coresystem');
                }
                $table->head = array($componentname);
                foreach ($readyprocessors as $processor) {
                    $table->head[]  = get_string('pluginname', 'message_'.$processor->name);
                }
                // Populate the table with rows
                foreach ($providers as $provider) {
                    $preferencebase = $provider->component.'_'.$provider->name;
                    // If provider component is not same or provider disabled then don't show.
                    if (($provider->component != $component) ||
                            (!empty($defaultpreferences->{$preferencebase.'_disable'}))) {
                        continue;
                    }
                    $provideradded = true;
                    $headerrow = new html_table_row();
                    $providername = get_string('messageprovider:'.$provider->name, $provider->component);
                    $providercell = new html_table_cell($providername);
                    $providercell->header = true;
                    $providercell->colspan = $numprocs;
                    $providercell->attributes['class'] = 'c0';
                    $headerrow->cells = array($providercell);
                    $table->data[] = $headerrow;

                    foreach (array('loggedin', 'loggedoff') as $state) {
                        $optionrow = new html_table_row();
                        $optionname = new html_table_cell(get_string($state.'description', 'message'));
                        $optionname->attributes['class'] = 'c0';
                        $optionrow->cells = array($optionname);
                        foreach ($readyprocessors as $processor) {
                            // determine the default setting
                            $permitted = MESSAGE_DEFAULT_PERMITTED;
                            $defaultpreference = $processor->name.'_provider_'.$preferencebase.'_permitted';
                            if (isset($defaultpreferences->{$defaultpreference})) {
                                $permitted = $defaultpreferences->{$defaultpreference};
                            }
                            // If settings are disallowed or forced, just display the
                            // corresponding message, if not use user settings.
                            if (in_array($permitted, array('disallowed', 'forced'))) {
                                if ($state == 'loggedoff') {
                                    // skip if we are rendering the second line
                                    continue;
                                }
                                $cellcontent = html_writer::nonempty_tag('div', get_string($permitted, 'message'), array('class' => 'dimmed_text'));
                                $optioncell = new html_table_cell($cellcontent);
                                $optioncell->rowspan = 2;
                                $optioncell->attributes['class'] = 'disallowed';
                            } else {
                                // determine user preferences and use them.
                                $disabled = array();
                                $checked = false;
                                if ($notificationsdisabled) {
                                    $disabled['disabled'] = 1;
                                }
                                // See if user has touched this preference
                                if (isset($preferences->{$preferencebase.'_'.$state})) {
                                    // User have some preferneces for this state in the database, use them
                                    $checked = isset($preferences->{$preferencebase.'_'.$state}[$processor->name]);
                                } else {
                                    // User has not set this preference yet, using site default preferences set by admin
                                    $defaultpreference = 'message_provider_'.$preferencebase.'_'.$state;
                                    if (isset($defaultpreferences->{$defaultpreference})) {
                                        $checked = (int)in_array($processor->name, explode(',', $defaultpreferences->{$defaultpreference}));
                                    }
                                }
                                $elementname = $preferencebase.'_'.$state.'['.$processor->name.']';
                                // prepare language bits
                                $processorname = get_string('pluginname', 'message_'.$processor->name);
                                $statename = get_string($state, 'message');
                                $labelparams = array(
                                    'provider'  => $providername,
                                    'processor' => $processorname,
                                    'state'     => $statename
                                );
                                $label = get_string('sendingviawhen', 'message', $labelparams);
                                $cellcontent = html_writer::label($label, $elementname, true, array('class' => 'accesshide'));
                                $cellcontent .= html_writer::checkbox($elementname, 1, $checked, '', array_merge(array('id' => $elementname, 'class' => 'notificationpreference'), $disabled));
                                $optioncell = new html_table_cell($cellcontent);
                                $optioncell->attributes['class'] = 'mdl-align';
                            }
                            $optionrow->cells[] = $optioncell;
                        }
                        $table->data[] = $optionrow;
                    }
                }
                // Add settings only if provider added for component.
                if ($provideradded) {
                    $output .= html_writer::start_tag('div', array('class' => 'messagesettingcomponent'));
                    $output .= html_writer::table($table);
                    $output .= html_writer::end_tag('div');
                }
            }
        }

        $output .= html_writer::end_tag('fieldset');
        foreach ($processors as $processor) {
            if (($processorconfigform = $processor->object->config_form($preferences)) && $processor->enabled) {
                $output .= html_writer::start_tag('fieldset', array('id' => 'messageprocessor_'.$processor->name, 'class' => 'clearfix'));
                $output .= html_writer::nonempty_tag('legend', get_string('pluginname', 'message_'.$processor->name), array('class' => 'ftoggler'));
                $output .= html_writer::start_tag('div');
                $output .= $processorconfigform;
                $output .= html_writer::end_tag('div');
                $output .= html_writer::end_tag('fieldset');
            }
        }

        $redirect = new moodle_url("/user/preferences.php", array('userid' => $userid));
        $output .= html_writer::end_tag('fieldset');
        $output .= html_writer::start_tag('div', array('class' => 'mdl-align'));
        $output .= html_writer::empty_tag('input', array('type' => 'submit',
            'value' => get_string('savechanges'), 'class' => 'form-submit'));
        $output .= html_writer::link($redirect, html_writer::empty_tag('input', array('type' => 'button',
            'value' => get_string('cancel'), 'class' => 'btn-cancel')));
        $output .= html_writer::end_tag('div');

        $output .= html_writer::end_tag('form');
        return $output;
    }
}