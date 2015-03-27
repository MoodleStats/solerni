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

/*
 * @author    Shaun Daubney
 * @package   theme_solerni
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

	function get_content () {
            global $USER, $CFG, $SESSION, $COURSE;
            $wwwroot = '';
            $signup = '';       
        }

	if (empty($CFG->loginhttps)) {
		$wwwroot = $CFG->wwwroot;
	} else {
		$wwwroot = str_replace("http://", "https://", $CFG->wwwroot);
	}

if (!isloggedin() or isguestuser()) {
	echo '<form class="navbar-form pull-left" method="post" action="'.$wwwroot.'/login/index.php?authldap_skipntlmsso=1">';
	echo '<input class="span2" type="text" name="username" placeholder="'.get_string('username').'">';
	echo '<input class="span2" type="password" name="password" placeholder="'.get_string('password').'">';
	echo '<button class="btn" type="submit"> '.get_string('login').'</button>';
	echo '</form>';
} else { 


	echo '';

}?>