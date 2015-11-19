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

require_once($CFG->libdir.'/formslib.php');

class solerni_quickform_renderer extends MoodleQuickForm_Renderer {

    public function solerni_quickform_renderer() {

        global $CFG;

        HTML_QuickForm::registerElementType( 'helpblock', $CFG->libdir . '/form/helpblock.php', 'MoodleQuickForm_helpblock');

        parent::MoodleQuickForm_Renderer();

        $this->_elementTemplates = array(

            'default'=>"\n\t\t".'<div id="{id}" class="fitem-legacy form-group {advanced}<!-- BEGIN required --> required<!-- END required --> fitem_{type} {emptylabel} <!-- BEGIN error --> has-error<!-- END error -->" {aria-live}><label>{label}</label><!-- BEGIN error --><p class="text-warning">{error}</p><!-- END error -->{element}</div>',

            'actionbuttons'=>"\n\t\t".'<div id="{id}" class="fitem fitem_actionbuttons fitem_{type}"><div class="felement {type}">{element}</div></div>',

            'fieldset'=>"\n\t\t".'<div id="{id}" class="fitem {advanced}<!-- BEGIN required --> required<!-- END required --> fitem_{type} {emptylabel}"><div class="fitemtitle"><div class="fgrouplabel"><label>{label}<!-- BEGIN required -->{req}<!-- END required -->{advancedimg} </label>{help}</div></div><fieldset class="felement {type}<!-- BEGIN error --> error<!-- END error -->"><!-- BEGIN error --><span class="error">{error}</span><br /><!-- END error -->{element}</fieldset></div>',

            'static'=>"\n\t\t".'<div class="fitem {advanced} {emptylabel}"><div class="fitemtitle"><div class="fstaticlabel"><label>{label}<!-- BEGIN required -->{req}<!-- END required -->{advancedimg} </label>{help}</div></div><div class="felement fstatic <!-- BEGIN error --> error<!-- END error -->"><!-- BEGIN error --><span class="error">{error}</span><br /><!-- END error -->{element}</div></div>',

            'warning'=>"\n\t\t".'<div class="fitem {advanced} {emptylabel}">{element}</div>',

            'helpblock' =>"\n\t\t".'<div class="help-block">{element}</div>',

            'nodisplay'=>''
        );
    }
}

$GLOBALS['_HTML_QuickForm_default_renderer'] = new solerni_quickform_renderer;
