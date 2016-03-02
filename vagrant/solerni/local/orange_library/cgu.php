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

// Get plugin config.
$localstaticpageconfig = get_config('local_staticpage');

// Put together absolute document paths based on requested page and current language.
$lang = current_language();
$page = 'cgu';
$pathlanguage = rtrim($localstaticpageconfig->documentdirectory, '/').'/'.$page.'.'.$lang.'.html';
// Replace backslashes in path with forward slashes if we are on a windows system.
$pathlanguage = str_replace('\\', '/', $pathlanguage);
$pathinternational = rtrim($localstaticpageconfig->documentdirectory, '/').'/'.$page.'.html';
// Replace backslashes in path with forward slashes if we are on a windows system.
$pathinternational = str_replace('\\', '/', $pathinternational);

// Does language based document file exist?
if (is_readable($pathlanguage) == true) {
    // Remember document path.
    $path = $pathlanguage;
} else if (is_readable($pathinternational) == true) {
    // Otherwise, does international document file exist?
    // Remember document path.
    $path = $pathinternational;
} else {
    // If not, quit with error message.
    print_error('pagenotfound', 'local_staticpage');
}

// Import the document, load DOM.
$staticdoc = new DOMDocument();
$staticdoc->loadHTMLFile($path);
$html = $staticdoc->saveHTML();

// Print html code.
echo $html;

