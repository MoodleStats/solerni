<?php
// This file is part of The Orange Library Plugin
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
 * @package    local
 * @subpackage orange_library
 * @copyright  2016 Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(dirname(__FILE__) . '/../../config.php');

// Get plugin config
$local_staticpage_config = get_config('local_staticpage');

// Put together absolute document paths based on requested page and current language
$lang = current_language();
$page = 'cgu';
$path_language = rtrim($local_staticpage_config->documentdirectory, '/').'/'.$page.'.'.$lang.'.html';
$path_language = str_replace('\\', '/', $path_language); // Replace backslashes in path with forward slashes if we are on a windows system
$path_international = rtrim($local_staticpage_config->documentdirectory, '/').'/'.$page.'.html';
$path_international = str_replace('\\', '/', $path_international); // Replace backslashes in path with forward slashes if we are on a windows system

// Does language based document file exist?
if (is_readable($path_language) == true) {
    // Remember document path
    $path = $path_language;
}
// Otherwise, does international document file exist?
else if (is_readable($path_international) == true) {
    // Remember document path
    $path = $path_international;
}
// If not, quit with error message
else {
    print_error('pagenotfound', 'local_staticpage');
}

// Import the document, load DOM
$staticdoc = new DOMDocument();
$staticdoc->loadHTMLFile($path);
$html = $staticdoc->saveHTML();

// Print html code
echo $html;

