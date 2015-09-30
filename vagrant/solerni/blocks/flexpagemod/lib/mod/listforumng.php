<?php
/**
 * Flexpage Activity Block
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
 * @package block_flexpagemod
 * @author Mark Nielsen
 */

/**
 * Display mod/listforumng
 *
 * @author orange
 * @package block_flexpagemod
 */
class block_flexpagemod_lib_mod_listforumng extends block_flexpagemod_lib_mod {
    public function module_block_setup() {
        global $CFG, $COURSE, $DB, $OUTPUT;

        $cm = $this->get_cm();
        $listforumng = $DB->get_record('listforumng', array('id' => $cm->instance));
        $context  = context_module::instance($cm->id);
        $course  = $COURSE;

        if ($listforumng and has_capability('mod/listforumng:view', $context)) {

            $this->append_content($OUTPUT->heading(format_string($listforumng->name), 2));
            $this->append_content("<BR>");

            $params = array(
                    'context'  => $context,
                    'objectid' => $listforumng->id
            );
            $event  = \mod_listforumng\event\course_module_viewed::create($params);
            $event->add_record_snapshot('course_modules', $cm);
            $event->add_record_snapshot('course', $course);
            $event->add_record_snapshot('listforumng', $listforumng);
            $event->trigger();

            ob_start();

            // Build table of forums.
            $table = new html_table;

            $table->head = array(get_string('headtablename', 'listforumng'));
            $table->head[] = get_string('headtablenbposts', 'listforumng');
            $table->head[] = get_string('headtablelastpost', 'listforumng');

            $table->data = array();

            $listforumng = forumng_get_all($cm->course);

            foreach ($listforumng as $forumng) {
                $row = array();

                $row[] = "<a href=" . $CFG->wwwroot. "/mod/forumng/view.php?&id=" . $forumng['instance'] . ">"
                        .  $forumng['name'] . "</a>"
                        . "<br>". '<span class="listforumng-date">le ' . userdate($forumng['createddate']) . '</span>';
                $row[] = $forumng['nbposts'];
                $row[] = $forumng['usernamelastpost']. "<br>". $forumng['datelastpost'];

                $table->data[] = $row;
            }

            print html_writer::table($table);

            $this->append_content(ob_get_contents());
            ob_end_clean();

             // Update 'viewed' state if required by completion system.
            require_once($CFG->libdir . '/completionlib.php');
            $completion = new completion_info($course);
            $completion->set_module_viewed($cm);

        }
    }
}