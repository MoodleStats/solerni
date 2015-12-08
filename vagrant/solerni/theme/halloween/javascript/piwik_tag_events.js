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
 *
 * By convention, the class name for the element triggering the event is
 * prefixed with "tag-"
 */

/*
 *
 * Remove #hashtag or ?query from url
 *
 * @param {string} url
 * @returns {string}
 */
function getPathFromUrl( url ) {
  return url.split(/[?#]/)[0];
}

/*
 * Returns the tracking event name depending on page pathname
 *
 * @returns {string}
 */
function get_subscription_name() {
    pageURL = getPathFromUrl( window.location.pathname );
    currentLocation = pageURL;

    if ( pageURL === '/') {
        currentLocation = 'homepage';
    }
    if ( pageURL === '/my') {
        currentLocation = 'dashboard';
    }
    if ( pageURL.indexOf('/catalog') !== -1 ) {
        currentLocation = 'catalog';
    }
    if ( pageURL.indexOf('mod/descriptionpage') !== -1 ) {
        currentLocation = 'description-page';
    }

    return currentLocation;
}

var tracked_events = {
    '.tag-course-subscription': {
        'event': 'click',
        'piwik_data': {
            'cat':      'course-subscription',
            'action':   get_subscription_name(),
            'name':     'data:mooc-name',
            'value':    null
        }
    },
    '.tag-footer-facebook': {
        'event': 'click',
        'piwik_data': {
            'cat':      'footer',
            'action':   'footer-social-network',
            'name':     'footer-facebook',
            'value':    null
        }
    },
    '.tag-footer-twitter': {
        'event': 'click',
        'piwik_data': {
            'cat':      'footer',
            'action':   'footer-social-network',
            'name':     'footer-twitter',
            'value':    null
        }
    },
    '.tag-footer-dailymotion': {
        'event': 'click',
        'piwik_data': {
            'cat':      'footer',
            'action':   'footer-social-network',
            'name':     'footer-dailymotion',
            'value':    null
        }
    },
    '.tag-footer-blog': {
        'event': 'click',
        'piwik_data': {
            'cat':      'footer',
            'action':   'footer-social-network',
            'name':     'footer-blog',
            'value':    null
        }
    },
    '.tag-course-catalog-status-filter': {
        'event': 'click',
        'piwik_data': {
            'cat':      'course-catalog',
            'action':   'course-catalog-filter',
            'name':     'course-catalog-filter-status',
            'value':    null
        }
    },
    '.tag-course-catalog-theme-filter': {
        'event': 'click',
        'piwik_data': {
            'cat':      'course-catalog',
            'action':   'course-catalog-filter',
            'name':     'course-catalog-filter-theme',
            'value':    null
        }
    },
    '.tag-course-catalog-duration-filter': {
        'event': 'click',
        'piwik_data': {
            'cat':      'course-catalog',
            'action':   'course-catalog-filter',
            'name':     'course-catalog-filter-duration',
            'value':    null
        }
    },
    '.tag-course-catalog-company-filter': {
        'event': 'click',
        'piwik_data': {
            'cat':      'course-catalog',
            'action':   'course-catalog-filter',
            'name':     'course-catalog-filter-company',
            'value':    null
        }
    },
    '.tag-course-sequence': {
        'event': 'click',
        'piwik_data': {
            'cat':      'course',
            'action':   'course-sequence',
            'name':     'course-sequence-block',
            'value':    null
        }
    },
    '.tag-course-sequence-next': {
        'event': 'click',
        'piwik_data': {
            'cat':      'course',
            'action':   'course-sequence',
            'name':     'course-sequence-next',
            'value':    null
        }
    },
    '.tag-course-sequence-previous': {
        'event': 'click',
        'piwik_data': {
            'cat':      'course',
            'action':   'course-sequence',
            'name':     'course-sequence-previous',
            'value':    null
        }
    },
    '.tag-platform-subscription': {
        'event': 'click',
        'piwik_data': {
            'cat':      'platform',
            'action':   'platform',
            'name':     'platform-subscription',
            'value':    null
        }
    }
};

/*
 * Returns the data-attribute of target-element
 * based on data_value (convention is : data:data-attribute)
 *
 * @param {string} data
 * @returns {string}
 */
function extract_data_attribute( target, data_value ) {
    data_value = data_value.replace('data:', '');
    return target.data( data_value );
}

/*
 * Attach an event to a jQuery object
 *
 * @param jQuery Object target
 * @param string event name
 * @param Object data
 * @returns void
 */

function attach_event( target, data ) {
    if ( typeof _paq !== 'undefined' ) {
        if ( data.piwik_data.name && data.piwik_data.name.indexOf('data:') !== -1 ) {
            data.piwik_data.name = extract_data_attribute( target, data.piwik_data.name );
        }
        target.on( data.event, function( evt ) {
            _paq.push( ['trackEvent', data.piwik_data.cat,
                data.piwik_data.action, data.piwik_data.name, data.piwik_data.value] );
        });
    }
}

jQuery(document).ready(function() {
    jQuery.each( tracked_events, function(key, data) {
        if ( (target = jQuery(key)) && (target.length) ) {
            attach_event( target, data );
        }
    });
});
