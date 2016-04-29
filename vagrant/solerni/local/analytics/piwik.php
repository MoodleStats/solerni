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
 * Analytics
 *
 * This module provides extensive analytics on a platform of choice
 * Currently support Google Analytics and Piwik
 *
 * @package    local_analytics
 * @copyright  David Bezemer <info@davidbezemer.nl>, www.davidbezemer.nl
 * @author     David Bezemer <info@davidbezemer.nl>, Bas Brands <bmbrands@gmail.com>, Gavin Henrick <gavin@lts.ie>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

function analytics_trackurl() {
    global $DB, $PAGE, $COURSE, $SITE;
    $pageinfo = get_context_info_array($PAGE->context->id);
    $trackurl = "'";

    // Adds course category name.
    if (isset($pageinfo[1]->category)) {
        if ($category = $DB->get_record('course_categories', array('id'=>$pageinfo[1]->category))) {
            $cats=explode("/",$category->path);
            foreach(array_filter($cats) as $cat) {
                if ($categorydepth = $DB->get_record("course_categories", array("id" => $cat))) {;
                    $trackurl .= $categorydepth->name.'/';
                }
            }
        }
    }

    // Adds course full name.
    if (isset($pageinfo[1]->fullname)) {
        if (isset($pageinfo[2]->name)) {
            $trackurl .= $pageinfo[1]->fullname.'/';
        } else if ($PAGE->user_is_editing()) {
            $trackurl .= $pageinfo[1]->fullname.'/'.get_string('edit', 'local_analytics');
        } else {
            $trackurl .= $pageinfo[1]->fullname.'/'.get_string('view', 'local_analytics');
        }
    }

    // Adds activity name.
    if (isset($pageinfo[2]->name)) {
        $trackurl .= $pageinfo[2]->modname.'/'.$pageinfo[2]->name;
    }

    $trackurl .= "'";

    return $trackurl;
}

function insert_analytics_tracking() {
    global $DB,$COURSE, $USER, $CFG ;

    if (class_exists('local_analytics_dimensions')) {
        $dimensions = new local_analytics_dimensions($COURSE, $USER, $CFG);
        $trackdimensions = "
            _paq.push(['setCustomVariable', 1, 'moocName', '" . $dimensions->get_dimensions1() . "', 'page']);
            _paq.push(['setCustomVariable', 2, 'moocSubscription', '" . $dimensions->get_dimensions2() . "', 'page']);
            _paq.push(['setCustomVariable', 3, 'customerName', '" . $dimensions->get_dimensions3() . "', 'page']);
            _paq.push(['setCustomVariable', 4, 'thematicName', '" . $dimensions->get_dimensions4() . "', 'page']);
        ";
    } else {
       $trackdimensions  = '';
    }

    $trackuser = ($USER->id != 0) ? "_paq.push(['setUserId', '" . get_string('user', 'local_analytics') . '_' . md5($USER->id) . "']);" : '';
    $enabled = get_config('local_analytics', 'enabled');
    $imagetrack = get_config('local_analytics', 'imagetrack');
    $siteurl = get_config('local_analytics', 'siteurl');
    $siteid = get_config('local_analytics', 'siteid');
    $trackadmin = get_config('local_analytics', 'trackadmin');
    $cleanurl = get_config('local_analytics', 'cleanurl');
    $location = "additionalhtml".get_config('local_analytics', 'location');
    if ($siteidcourseid = $DB->get_record_sql('SELECT piwik_siteid FROM {piwik_site} WHERE courseid = ?', array($COURSE->id))) {
        $siteidforcourseid = $siteidcourseid->piwik_siteid;
    }

    $CFG->$location .= "<!-- Start first tracker Piwik Code -->";

	if (!empty($siteurl)) {
		if ($imagetrack) {
			$addition = '<noscript><p><img src="//'.$siteurl.'/piwik.php?idsite='.$siteid.'&rec=1&bots=1 style="border:0;" alt="" /></p></noscript>';
		} else {
			$addition = '';
		}

		if ($cleanurl) {
			$doctitle = "_paq.push(['setDocumentTitle', ".analytics_trackurl()."]);";
		} else {
			$doctitle = "";
		}

		if ($enabled && (!is_siteadmin() || $trackadmin)) {
			$CFG->$location .= "
<script type='text/javascript'>
    var _paq = _paq || [];
    ".$doctitle.$trackdimensions.
      $trackuser."
    _paq.push(['trackPageView']);
    _paq.push(['enableLinkTracking']);
    (function() {
      var u='//".$siteurl."/';
      _paq.push(['setTrackerUrl', u+'piwik.php']);
      _paq.push(['setSiteId', ".$siteid."]);

      var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
    g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
    })();
</script>".$addition;
		}
	} else {
       $CFG->$location .= get_string('url_not_set', 'local_analytics');
    }

    $CFG->$location .= "<!-- End first tracker Piwik Code -->";
    if ($COURSE->id != 1 && $siteidcourseid) {
        $CFG->$location .= '<script type="text/javascript">$( document ).ready(function() {
            function sendTrackPagePiwik() {
                var piwik2Tracker = Piwik.getTracker();
                piwik2Tracker.setSiteId('.$siteidforcourseid.');
                piwik2Tracker.trackPageView();
            }
            // We dont know if Piwik is loaded yet.
            checkPiwik = setTimeout(function() {
                if(Piwik) {
                    window.clearTimeout(checkPiwik);
                    sendTrackPagePiwik();
                }
            }, 500);
        });</script>';
    }

}
//_paq.push(['setSiteId', ".$siteid."]);
insert_analytics_tracking();

if (debugging() && ($CFG->debugdisplay)) {
    $CFG->additionalhtmlfooter .= "<span class='badge badge-success'>Tracking: ".analytics_trackurl()."</span>";
}

