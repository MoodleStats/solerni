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

class HalloweenMoodleQuickForm_Renderer extends MoodleQuickForm_Renderer {

    public function HalloweenMoodleQuickForm_Renderer() {

        global $CFG;

        HTML_QuickForm::registerElementType('helpblock', $CFG->libdir . '/form/helpblock.php', 'MoodleQuickForm_helpblock');
        HTML_QuickForm::registerElementType('inverseadvcheckbox', $CFG->libdir . '/form/inverseadvcheckbox.php', 'MoodleQuickForm_inverseadvcheckbox');
        HTML_QuickForm::registerElementType('inversecheckbox', $CFG->libdir . '/form/inversecheckbox.php', 'MoodleQuickForm_inversecheckbox');
        HTML_QuickForm::registerElementType('halloweenhtml', $CFG->libdir . '/form/halloweenhtml.php', 'MoodleQuickForm_halloweenhtml');

        parent::MoodleQuickForm_Renderer();

        $this->_elementTemplates = array(

            'default' =>"\n\t\t".'<div id="{id}" class="fitem-legacy form-group {advanced}'
                . '<!-- BEGIN required --> required<!-- END required -->'
                . ' fitem_{type} {emptylabel} '
                . '<!-- BEGIN error --> has-error<!-- END error -->" '
                . '{aria-live}><label>{label}'
                . '<!-- BEGIN required --> <span class="form-required-field">*</span><!-- END required -->'
                . '</label><div>{element}'
                . '<!-- BEGIN error --><div class="help-block small">{error}</div><!-- END error -->'
                . '</div></div>',

            'actionbuttons' =>"\n\t\t".'<div id="{id}" class="fitem fitem_actionbuttons fitem_{type}">'
                . '<div class="felement {type}">{element}</div></div>',

            'fieldset' =>"\n\t\t".'<div id="{id}" class="fitem {advanced}'
                . '<!-- BEGIN required --> required<!-- END required --> '
                . 'fitem_{type} {emptylabel}"><div class="fitemtitle"><div class="fgrouplabel">'
                . '<label>{label}<!-- BEGIN required -->{req}<!-- END required -->{advancedimg} </label>'
                . '{help}</div></div><fieldset class="felement {type}'
                . '<!-- BEGIN error --> error<!-- END error -->">'
                . '<!-- BEGIN error --><span class="error">{error}</span><br /><!-- END error -->'
                . '{element}</fieldset></div>',

            'static' =>"\n\t\t".'<div class="fitem {advanced} {emptylabel}">'
                . '<div class="fitemtitle"><div class="fstaticlabel"><label>{label}'
                . '<!-- BEGIN required -->{req}<!-- END required -->{advancedimg} </label>'
                . '{help}</div></div><div class="felement fstatic '
                . '<!-- BEGIN error --> error<!-- END error -->">'
                . '<!-- BEGIN error --><span class="error">{error}</span><br /><!-- END error -->'
                . '{element}</div></div>',

            'warning' =>"\n\t\t".'<div class="fitem {advanced} {emptylabel}">{element}</div>',

            'helpblock' =>"\n\t\t".'<div class="help-block">{element}</div>',

            'inverseadvcheckbox' =>"\n\t\t".'<div id="{id}" '
                . 'class="fitem-legacy form-group form-group--inverseadvcheckbox  {advanced}'
                . '<!-- BEGIN required --> required<!-- END required --> fitem_{type} {emptylabel} '
                . '<!-- BEGIN error --> has-error<!-- END error -->" {aria-live}>'
                . '<!-- BEGIN error --><p class="text-warning">{error}</p><!-- END error -->'
                . '{element}<label>{label}</label></div>',

            'inversecheckbox' =>"\n\t\t".'<div id="{id}" class="fitem-legacy form-group {advanced}'
                . '<!-- BEGIN required --> required<!-- END required --> fitem_{type} {emptylabel}'
                . '<!-- BEGIN error --> has-error<!-- END error -->" {aria-live}>'
                . '{element}<label>{label}</label>'
                . '<!-- BEGIN error --><div class="help-block small">{error}</div><!-- END error -->'
                . '</div>',

            'halloweenhtml' => "\n\t\t".'{element}',

            'nodisplay'=>''
        );
    }
}

$GLOBALS['_HTML_QuickForm_default_renderer'] = new HalloweenMoodleQuickForm_Renderer;
