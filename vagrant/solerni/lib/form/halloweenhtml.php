<?php

// This file is part of The Orange Halloween Moodle Theme
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
 * Allows to display arbitrary text in a moodle form
 */

require_once("HTML/QuickForm/static.php");

/**
 * Text element
 *
 * HTML class for any element
 *
 * @package   theme_halloween
 * @category  form
 * @copyright 2006 Jamie Pratt <me@jamiep.org>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class MoodleQuickForm_halloweenhtml extends HTML_QuickForm_static{
    /** @var string Form element type */
    var $_elementTemplateType='halloweenhtml';

    /** @var string html for help button, if empty then no help */
    var $_helpbutton='';

    /** @var store the html we want to display */
    var $_html = '';

    /**
     * constructor
     *
     * @param string $htmlcontent (optionnal) the content we want to insert
     * @param string $elementLabel (optional) text field label
     * @param string $text (optional) Text to put in text field
     */
    function MoodleQuickForm_halloweenhtml($htmlcontent=null, $elementLabel=null, $text=null) {

        $this->_html = $htmlcontent;

        parent::HTML_QuickForm_static($htmlcontent, $elementLabel, $text);
    }

    /**
     * get html for help button
     *
     * @return string html for help button
     */
    function getHelpButton(){
        return $this->_helpbutton;
    }

    /**
     * Gets the type of form element
     *
     * @return string
     */
    function getElementTemplateType(){
        return $this->_elementTemplateType;
    }

    /*
     * Returns the html fragment
     *
     * @return string
     */
    function toHtml() {
        return $this->_html;
    }
}
