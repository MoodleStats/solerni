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
 * Moodle local_orange_thematics renderer class
 *
 * @package local
 * @subpackage orange_thematics
 * @copyright  2015 Orange
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class local_orange_thematics_renderer extends plugin_renderer_base {

    /**
     * Wraps all the actions
     *
     * @param renderable $renderable
     * @param string $action
     * @return string
     */
    public function render_orange_wrapper(renderable $renderable, $action, $list) {
        global $PAGE, $SITE;

        $context = context_system::instance();

        $PAGE->set_heading($SITE->fullname);
        $PAGE->set_title(get_string('action' . $action, 'local_orange_thematics'));

        $output = $this->output->header();
        $output .= $this->output->heading(get_string('action' . $action, 'local_orange_thematics'));

        // Redirects the flow to the specific method.
        $actiontorender = 'render_orange_' . $action;
        if ($action == "thematics_list") {
            $output .= $this->$actiontorender($list);
            $output .= $this->output->single_button(new moodle_url('/local/orange_thematics/view.php',
                                                                   array('contextid' => $context->id)), get_string('add'));
        } else {
            $output .= $this->$actiontorender($renderable);
        }

        $output .= $this->output->footer();

        return $output;

    }

    /**
     * Packaging form renderer
     * 
     * @param renderable $renderable
     * @return string
     */
    protected function render_orange_thematics_form(renderable $renderable) {
        return $this->render_form($renderable);
    }

    /**
     * Packaging form renderer
     * 
     * @param html_table $list
     * @return string
     */
    protected function render_orange_thematics_list(html_table $list) {
        return $this->render_list($list);
    }

    /**
     * Packaging form renderer
     * @param renderable $renderable
     * @return string
     */
    protected function render_orange_thematics_add(renderable $renderable) {
        return $this->render_form($renderable);
    }


    /**
     * Gets the HTML of a moodle form
     *
     * @param moodleform $form
     * @return string The HTML of the form
     */
    protected function render_form(moodleform $form) {

        ob_start();
        $form->display();
        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }

    /**
     * Gets the html table with list parameters
     *
     * @param html_table $list
     * @return string The HTML of the form
     */

    protected function render_list(html_table $list) {

        ob_start();

        if (!empty($list)) {
            echo html_writer::table($list);
        }

        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }


}
