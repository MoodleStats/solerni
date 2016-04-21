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

use local_orange_library\utilities\utilities_array;

/**
 * shareonarray construction.
 *
 * @return array $shareonarray.
 */
function block_orange_social_sharing_shareonarray() {

    $shareonarray = new utilities_array();

    $shareonarray->add(get_string('shareonfacebook', 'block_orange_social_sharing'));
    $shareonarray->add(get_string('shareontwitter', 'block_orange_social_sharing'));
    $shareonarray->add(get_string('shareonlinkedin', 'block_orange_social_sharing'));
    $shareonarray->add(get_string('shareongoogleplus', 'block_orange_social_sharing'));

    return $shareonarray;
}

/**
 * socialclassarray construction.
 *
 * @return array $socialclassarray.
 */
function block_orange_social_sharing_socialclassarray() {

    $socialclassarray = new utilities_array();

    $socialclassarray->add('facebook');
    $socialclassarray->add('twitter');
    $socialclassarray->add('linkedin');
    $socialclassarray->add('googleplus');

    return $socialclassarray;
}

/**
 * socialclassarray construction.
 *
 * @return array $socialclassarray.
 */
function block_orange_social_sharing_socialurlarray() {

    $socialurlarray = new utilities_array();
        $socialurlarray->add(get_string('urlshareonfacebook', 'block_orange_social_sharing'));
        $socialurlarray->add(get_string('urlshareontwitter', 'block_orange_social_sharing'));
        $socialurlarray->add(get_string('urlshareonlinkedin', 'block_orange_social_sharing'));
        $socialurlarray->add(get_string('urlshareongoogleplus', 'block_orange_social_sharing'));

    return $socialurlarray;
}