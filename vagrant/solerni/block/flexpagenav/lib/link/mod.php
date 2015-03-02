<?php
/**
 * Flexpage Navigation Block
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see http://opensource.org/licenses/gpl-3.0.html.
 *
 * @copyright Copyright (c) 2009 Moodlerooms Inc. (http://www.moodlerooms.com)
 * @license http://opensource.org/licenses/gpl-3.0.html GNU Public License
 * @package block_flexpagenav
 * @author Mark Nielsen
 */

/**
 * @see block_flexpagenav_lib_link_abstract
 */
require_once($CFG->dirroot.'/blocks/flexpagenav/lib/link/abstract.php');

/**
 * Course Module Link
 *
 * @author Mark Nielsen
 * @package block_flexpagenav
 */
class block_flexpagenav_lib_link_mod extends block_flexpagenav_lib_link_abstract {

    public function get_info() {
        global $COURSE;

        try {
            $modinfo = get_fast_modinfo($COURSE);
            $cm     = $modinfo->get_cm($this->get_link()->get_config('cmid', 0));
            return html_writer::link($cm->get_url(), $cm->name);
        } catch (Exception $e) {
            return get_string('moderror', 'block_flexpagenav');
        }
    }

    public function handle_form() {
        $this->get_link()->set_config('cmid', required_param('cmid', PARAM_INT));
    }

    public function edit_form(moodle_url $submiturl) {
        global $COURSE;

        $modinfo   = get_fast_modinfo($COURSE);
        $optgroups = array();
        foreach ($modinfo->get_instances() as $module => $instances) {
            $options = array();
            foreach ($instances as $instance) {
                $options[$instance->id] = $instance->name;
            }
            natcasesort($options);

            $optgroups[get_string('modulenameplural', $module)] = array(get_string('modulenameplural', $module) => $options);
        }
        ksort($optgroups);

        $box = new course_format_flexpage_lib_box(array('class' => 'format_flexpage_form'));

        $box->add_new_row()->add_new_cell(html_writer::label(get_string('coursemodule', 'block_flexpagenav'), 'id_cmid'))
                           ->add_new_cell(html_writer::select($optgroups, 'cmid', $this->get_link()->get_config('cmid'), false, array('id' => 'id_cmid')));

        return $this->get_renderer()->form_wrapper($submiturl, $box);
    }

    public function add_nodes(navigation_node $root) {
        global $COURSE;

        try {
            $modinfo = get_fast_modinfo($COURSE);
            $cm      = $modinfo->get_cm($this->get_link()->get_config('cmid', 0));
            $url     = $cm->get_url();
            if ($cm->uservisible and $url) {
                if ($cm->icon) {
                    $icon = new pix_icon($cm->icon, get_string('modulename', $cm->modname), $cm->iconcomponent);
                } else {
                    $icon = new pix_icon('icon', get_string('modulename', $cm->modname), $cm->modname);
                }
                $activitynode = $root->add(format_string($cm->name), $url, navigation_node::TYPE_CUSTOM, null, 'mod_'.$cm->id.'_'.$this->get_link()->get_id(), $icon);
                $activitynode->title(get_string('modulename', $cm->modname));
                $activitynode->hidden = (!$cm->visible);  // @todo Should we not add if it's not visible?
            }
        } catch (Exception $e) {
        }
    }
}