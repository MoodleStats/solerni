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
 * orange_paragraph_list block
 *
 * @package    orange_paragraph_list
 * @copyright  Orange 2016
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

class block_orange_paragraph_list_renderer extends plugin_renderer_base {

    /**
     * Display for "Find out more" page
     *
     * @return html string
     */
    public function render_paragraph_list($findoutmore) {

        // No flexpage content. Get out.
        if (!$findoutmore->paragraphtitle) {
            return '';
        }

        $output = html_writer::start_tag('div', array('class' => 'zigzag'));
        ksort($findoutmore->paragraphtitle,SORT_NATURAL);
        foreach ($findoutmore->paragraphtitle as $index => $value) {
            if (!$value || !$findoutmore->paragraphdescription[$index]) {
                continue; // We skip the row if we do not have title & text.
            }
            $output .= $this->render_paragraph_row($findoutmore, $index);
        }

        $output .= html_writer::end_tag('div');

        return $output;
    }

    private function render_paragraph_row($findoutmore, $index) {

        $textvalues = array('title' => $findoutmore->paragraphtitle[$index],
                            'text' => $findoutmore->paragraphdescription[$index]);
        $imgvalues = array('url' => $findoutmore->resizedimgurl[$index]);

        $odd = ($index % 2) ? true : false;
        $zigzagclass = ($odd) ? ' zig' : ' zag';
        $zigzagclass = $zigzagclass . ' expanded ' . $findoutmore->paragraphbgcolor[$index];

        $output = html_writer::start_tag('div', array('class' => 'zigzag-row' . $zigzagclass));
            $output .= html_writer::start_tag('div', array('class' => 'row'));

        if ($odd) {
            $output .= $this->render_paragraph_cell_image($imgvalues, $odd);
            $output .= $this->render_paragraph_cell_text($textvalues, $odd);
        } else {
            $output .= $this->render_paragraph_cell_text($textvalues, $odd);
            $output .= $this->render_paragraph_cell_image($imgvalues, $odd);
        }

            $output .= html_writer::end_tag('div');
        $output .= html_writer::end_tag('div');

        return $output;
    }

    /**
     * Render html for paragraph cell
     *
     * @return message
     */
    private function render_paragraph_cell_text($textvalues, $odd) {
        $customclasses = ($odd) ? 'col-md-offset-1 col-md-5' : 'col-md-5';

        $output = html_writer::start_tag('div', array('class' => 'col-xs-12 zigzag-row__text ' . $customclasses));
            $output .= html_writer::tag('h2', $textvalues['title'] ,
                                        array('class' => 'h2 text-oneline'));
            $output .= html_writer::tag('p', $textvalues['text'],
                                        array('class' => 'thumbnail-text'));
        $output .= html_writer::end_tag('div');

        return $output;
    }

    /**
     * Display for "Find out more" page
     *
     * @return message
     */
    private function render_paragraph_cell_image($imgvalues, $odd) {
        $customclasses = ($odd) ? 'col-md-6' : 'col-md-6 col-md-offset-1';

        $output = html_writer::start_tag('div', array('class' => 'col-xs-12 zigzag-row__image ' . $customclasses));
            $output .= html_writer::empty_tag('img', array('src' => $imgvalues['url'], 'class' => 'img-responsive'));
        $output .= html_writer::end_tag('div');

        return $output;
    }
}
