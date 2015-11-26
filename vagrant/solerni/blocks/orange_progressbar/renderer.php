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
 * Orange Last Message block renderer
 *
 * @package    block_orange_progressbar
 * @copyright  Orange 2015
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

class block_orange_progressbar_renderer extends plugin_renderer_base {

    /**
     * Construct progress bar 
     *
     * @param nbactivities in the course
     * @param nbactivitiescompleted completed in the course
     * @param details of all activities
     * @return string html of the simple progress bar
     */
    public function display_progress($nbactivities, $nbactivitiescompleted, $details = null) {
        $progress = round($nbactivitiescompleted / $nbactivities * 100);

        $output = html_writer::start_tag('div', array('class' => 'progress'));
        $output .= html_writer::start_tag('div', array('class' => 'progress-bar',
                                                      'role' => 'progressbar',
                                                      'aria-valuenow' => $progress,
                                                      'aria-valuemin' => '0',
                                                      'aria-valuemax' => '100',
                                                      'style' => 'width:'.$progress.'%'));
        if ($progress > 25) {
            $output .= $progress . ' %';
        }
        $output .= html_writer::end_tag('div');
        if ($progress <= 25) {
            $output .= $progress . ' %';
        }
        $output .= html_writer::end_tag('div');

        if (count($details)) {
            $output .= html_writer::tag('h3', get_string('progres_detail', 'block_orange_progressbar'));

            $currentmodule = '';
            foreach ($details as $key => $detailsbytype) {
                foreach ($detailsbytype as $detail) {
                    if ($detail->modname != $currentmodule) {
                        $output .= html_writer::tag('h4', $detail->modnametext);
                        $currentmodule = $detail->modname;
                    }
                    
                    $output .= html_writer::start_tag('div', array('class' => 'col-md-12'));
                        $output .= html_writer::start_tag('span', array('class' => 'col-md-8'));
                        if ($detail->modname == 'page') {
                            $output .= $detail->name;
                        } else {
                            $output .= HTML_WRITER::link($detail->url, $detail->name);
                        }
                        $output .= html_writer::end_tag('span');
                        $output .= html_writer::start_tag('span', array('class' => 'col-md-2'));

                        // For quizz we have to display the number of attemps.
                        if ($detail->modname == 'quiz') {
                            $output .= $detail->quizuserattempts . ' ' . get_string('attempts', 'quiz');
                            if ($detail->quizmaxattempts != 0) {
                                $output .= "/" . $detail->quizmaxattempts;
                            }
                        }

                        // For page we display the total of pages.
                        if ($detail->modname == 'page') {
                            $output .= "$detail->pagescompleted/$detail->pages";
                            if ($detail->pagescompleted == $detail->pages) {
                                $detail->completionstate = true;
                            } else {
                                $detail->completionstate = false;
                            }
                        }
                        $output .= html_writer::end_tag('span');

                        $output .= html_writer::start_tag('span', array('class' => 'col-md-2'));
                        if ($detail->completionstate) {
                            $output .= '<span class="glyphicon glyphicon-ok" style="color:green"></span>';
                        } else {
                            $output .= '<span class="glyphicon glyphicon-remove" style="color:red"></span>';
                        }
                        $output .= html_writer::end_tag('span');
                    $output .= html_writer::end_tag('div');
                }
            }
        }
        return $output;
    }

    /**
     * Display message when no activy is monitored
     *
     * @return message
     */
    public function display_noactivity_monitored () {
        $output = html_writer::start_tag('div');
        $output .= get_string('no_activities_monitored', 'block_orange_progressbar');
        $output .= html_writer::end_tag('div');

        return $output;
    }

    /**
     * Display message when completion is not enabled for the course
     *
     * @return message
     */
    public function display_completion_notenabled () {
        $output = html_writer::start_tag('div');
        $output .= get_string('completion_not_enabled', 'block_orange_progressbar');
        $output .= html_writer::end_tag('div');

        return $output;
    }
}
