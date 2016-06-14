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

    /**
     * trasform duration format to time format
     * @param type $extendedcourse
     * @return type
     */
    public static function duration_to_time($duration) {

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
     * trasform duration format to week format
     * @param type $extendedcourse
     * @return type
     */
    public static function duration_to_week($duration) {

        $secondsinaminute = 60;
        $secondsinanhour = 60 * $secondsinaminute;
        $secondsinaday = 24 * $secondsinanhour;
        $secondsinaweek = 7 * $secondsinaday;

        $weeks = floor($duration / $secondsinaweek);
        $text = 0;

        if ($weeks > 0) {
            $text = $weeks;
        } else {
            $text = 1;
        }

        return $text;
    }

    /**
     * trims text to a space then adds ellipses if desired
     * @param string $input text to trim
     * @param int $length in characters to trim to
     * @param bool $ellipses if ellipses (...) are to be added
     * @param bool $striphtml if html tags are to be stripped
     * @param bool $ellipsesallways if ellipses (...) are to be added even if the text is not cut
     * @param bool $underline if last word and ellipses are underligned
     * @return string
     */
    public static function trim_text($input, $length, $ellipses = true, $striphtml = true, $ellipsesallways = false, $underline = false) {
        // Strip tags, if desired.
        if ($striphtml) {
            $input = strip_tags($input);
        }

        // No need to trim, already shorter than trim length.
        if (strlen($input) <= $length) {
            if ($ellipsesallways) {
                if ($underline) {
                    $pos = strripos($input, " " );
                    return substr($input, 0, $pos) . " <u>" . substr($input, $pos) . "...</u>";
                } else {
                    return $input .= '...';
                }
            } else {
                return $input;
            }
        }

        // Find last space within length.
        $lastspace = strrpos(substr($input, 0, $length), ' ');
        $trimmedtext = substr($input, 0, $lastspace);

        // Add ellipses (...).
        if ($ellipses) {
            if ($underline) {
                $pos = strripos($trimmedtext, " " );
                $trimmedtext = substr($trimmedtext, 0, $pos) . " <u>" . substr($trimmedtext, $pos) . "...</u>";
            } else {
                $trimmedtext .= '...';
            }
        }

        return $trimmedtext;
    }

    /**
     * trims text to a space then adds ellipses if desired
     * @param string $input text to trim
     * @param int $length in characters to trim to
     * @param bool $ellipses if ellipses (...) are to be added
     * @param bool $striphtml if html tags are to be stripped
     * @return string
     */
    public static function get_formatted_date($date) {
        $format = "d-m-Y";
        if (current_language() == "en") {
            $format = "Y-m-d";
        }

        return date($format, $date);
    }

    /**
     * Is the date is before current date.
     *
     * @param object $date
     * @return boolean
     */
    public static function is_before($date) {

        $return = false;
        $datetime = new \DateTime;
        $curentdate = $datetime->getTimestamp();
        if ($date > $curentdate) {
            $return = true;
        }
        return $return;

    }

    /**
     * Is the date is after current date.
     *
     * @param object $date
     * @return boolean
     */
    public static function is_after($date) {
        $return = false;
        $datetime = new \DateTime;
        $curentdate = $datetime->getTimestamp();
        if ($date < $curentdate) {
            $return = true;
        }
        return $return;
    }

    /**
     * format date for forum
     * @param string $date date
     * @return string
     */
    public static function get_formatted_date_forum($date) {

        // The date is today.
        if (date('Y-m-d', $date) == date('Y-m-d')) {
            return get_string('today', 'local_orange_library') . userdate($date, '%H:%M');
        }

        // The date is yesterday.
        if (date('Y-m-d', $date) == date('Y-m-d', mktime(0, 0, 0, date("m")  , date("d") - 1, date("Y")))) {
            return get_string('yesterday', 'local_orange_library') . userdate($date, '%H:%M');
        }

        // The date is another day.
        return userdate($date, '%d %b %Y');
    }

    /**
     * return plural or singular depending testvalue
     * @param int $testvalue
     * @param int $pluginname
     * @param int $singulars
     * @param int $plural
     * @param mixed $a Value or null
     * @return string
     */
    public static function get_string_plural($testvalue, $pluginname, $singular, $plural, $a=null) {

        return ((int) $testvalue > 1) ? get_string($plural, $pluginname, $a) : get_string($singular, $pluginname, $a);
    }

    /**
     * Is the current page is the frontpage
     * @return boolean
     */
    public static function is_frontpage() {
        global $PAGE;

        return ($PAGE->pagetype == 'site-index');
    }

}