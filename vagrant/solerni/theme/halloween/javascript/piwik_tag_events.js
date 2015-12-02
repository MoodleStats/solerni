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


/*
 * This script allows to generate event tracking for piwik
 *
 * Provided a array of jQuery selectors, the script will find DOM node matching
 * those selectors, and attach an event to them. If triggered, this event will
 * push a tracking event into the piwik tracker.
 */

var tracked_events = {
    '.icon-halloween--email': {
        'event': 'click',
        'piwik_data': {
            'cat':      'categroy',
            'action':   'actionroy',
            'name':     undefined,
            'value':    undefined
        }
    }
};

/*
 * Attach an event to a jQuery object
 *
 * @param jQuery Object target
 * @param string event name
 * @param Object data
 * @returns void
 */
function attach_event( target, event, data ) {
    target.on( event, function(e) {
        _paq.push(['trackEvent', data.cat, data.action, data.name, data.value]);
    });
}

jQuery(document).ready(function() {
    jQuery.each( tracked_events, function(key, data) {
        if ( (target = jQuery(key)) && (target.length > 0) ) {
            attach_event( target, data.event, data.piwik_data );
        }
    });
});
