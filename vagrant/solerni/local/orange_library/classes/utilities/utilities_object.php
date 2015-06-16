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
 * @package    orange_library
 * @subpackage utilities
 * @copyright  2015 Orange
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace local_orange_library\utilities;

defined('MOODLE_INTERNAL') || die();

class utilities_object {

    public function duration_to_time($duration) {
        $secondsinaminute = 60;
        $secondsinanhour = 60 * $secondsinaminute;
        $secondsinaday = 24 * $secondsinanhour;
        $secondsinaweek = 7 * $secondsinaday;

        $weeks = floor($duration / $secondsinaweek);
        // Extract days.
        $dayseconds = $duration % $secondsinaweek;
        $days = floor($dayseconds / $secondsinaday);

        // Extract hours.
        $hourseconds = $duration % $secondsinaday;
        $hours = floor($hourseconds / $secondsinanhour);

        // Extract minutes.
        $minuteseconds = $duration % $secondsinanhour;
        $minutes = floor($minuteseconds / $secondsinaminute);

        // Extract the remaining seconds.
        $remainingseconds = $duration % $secondsinaminute;
        $seconds = ceil($remainingseconds);

        $text = "";

        if ($weeks > 0) {
            $text = $weeks." ".get_string('week', 'block_orange_course_extended'). " ".$text;
        } else if ($days > 0) {
            $text = $days." ".get_string('day', 'block_orange_course_extended'). " ".$text;
        }
        if ($hours > 0) {
            $text = $hours." ".get_string('hour', 'block_orange_course_extended'). " ".$text;
        }
        if ($minutes > 0) {
            $text = $minutes." ".get_string('minute', 'block_orange_course_extended'). " ".$text;
        }
        if ($seconds > 0) {
            $text = $seconds." ".get_string('second', 'block_orange_course_extended'). " ".$text;
        }

        return $text;
    }

    /**
     * Truncate text to the width
     *
     * @param type $string
     * @param type $width
     * @return type
     */
   public function solerni_trim_words($string, $width){
        if (mb_str_word_count($string) > $width) {
            $string= preg_replace('/((\w+\W*|| [\p{L}]+\W*){'.($width-1).'}(\w+))(.*)/', '${1}', $string);
        }
        return $string;
    }

}
