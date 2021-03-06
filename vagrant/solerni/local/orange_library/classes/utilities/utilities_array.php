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
class utilities_array{

    public $all;
    public $count;
    public $curr;

    public function __construct () {

        $this->count = 0;

    }

    public function add ($step) {

        $this->count++;
        $this->all[$this->count] = $step;

    }

    public function setcurrent ($step) {

        $this->curr = $this->all[$step];

    }

    public function getcurrent () {

        return $this->curr;

    }

    public function getnext () {

        self::setCurrent($this->curr);
        return next($this->all);

    }

}