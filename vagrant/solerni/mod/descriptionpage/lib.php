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
 * Public page module utility functions
 * @package mod
 * @subpackage descriptionpage
 * @copyright  2015 Orange based on mod_page plugin from 2009 Petr Skoda (http://skodak.org)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die;

/**
 * List of features supported in Page module
 * @param string $feature FEATURE_xx constant for requested feature
 * @return mixed True if module supports feature, false if not, null if doesn't know
 */
function descriptionpage_supports($feature) {
    switch($feature) {
        case FEATURE_MOD_ARCHETYPE:
            return MOD_ARCHETYPE_RESOURCE;
        case FEATURE_GROUPS:
            return false;
        case FEATURE_GROUPINGS:
            return false;
        case FEATURE_GROUPMEMBERSONLY:
            return true;
        case FEATURE_MOD_INTRO:
            return true;
        case FEATURE_COMPLETION_TRACKS_VIEWS:
            return true;
        case FEATURE_GRADE_HAS_GRADE:
            return false;
        case FEATURE_GRADE_OUTCOMES:
            return false;
        case FEATURE_BACKUP_MOODLE2:
            return true;
        case FEATURE_SHOW_DESCRIPTION:
            return true;

        default:
            return null;
    }
}

/**
 * Returns all other caps used in module
 * @return array
 */
function descriptionpage_get_extra_capabilities() {
    return array('moodle/site:accessallgroups');
}

/**
 * This function is used by the reset_course_userdata function in moodlelib.
 * @param $data the data submitted from the reset course.
 * @return array status array
 */
function descriptionpage_reset_userdata($data) {
    return array();
}

/**
 * List the actions that correspond to a view of this module.
 * This is used by the participation report.
 *
 * Note: This is not used by new logging system. Event with
 *       crud = 'r' and edulevel = LEVEL_PARTICIPATING will
 *       be considered as view action.
 *
 * @return array
 */
function descriptionpage_get_view_actions() {
    return array('view' , 'view all');
}

/**
 * List the actions that correspond to a post of this module.
 * This is used by the participation report.
 *
 * Note: This is not used by new logging system. Event with
 *       crud = ('c' || 'u' || 'd') and edulevel = LEVEL_PARTICIPATING
 *       will be considered as post action.
 *
 * @return array
 */
function descriptionpage_get_post_actions() {
    return array('update', 'add');
}

/**
 * Add page instance.
 * @param stdClass $data
 * @param mod_page_mod_form $mform
 * @return int new page instance id
 */
function descriptionpage_add_instance($data, $mform = null) {
    global $CFG, $DB;
    require_once("$CFG->libdir/resourcelib.php");

    $cmid = $data->coursemodule;

    $data->timemodified = time();
    $displayoptions = array();
    if ($data->display == RESOURCELIB_DISPLAY_POPUP) {
        $displayoptions['popupwidth']  = $data->popupwidth;
        $displayoptions['popupheight'] = $data->popupheight;
    }
    $displayoptions['printheading'] = $data->printheading;
    $displayoptions['printintro']   = $data->printintro;
    $data->displayoptions = serialize($displayoptions);

    if ($mform) {
        $data->content       = $data->descriptionpage['text'];
        $data->contentformat = $data->descriptionpage['format'];
    }

    $data->id = $DB->insert_record('descriptionpage', $data);

    // We need to use context now, so we need to make sure all needed info is already in db.
    $DB->set_field('course_modules', 'instance', $data->id, array('id' => $cmid));
    $context = context_module::instance($cmid);

    if ($mform and !empty($data->descriptionpage['itemid'])) {
        $draftitemid = $data->descriptionpage['itemid'];
        $pgeo = descriptionpage_get_editor_options($context);
        $decpage = 'mod_descriptionpage';
        $cid = $context->id;
        $dcontent = $data->content;
        $data->content = file_save_draft_area_files($draftitemid, $cid, $decpage, 'content', 0, $pgeo, $dcontent);
        $DB->update_record('descriptionpage', $data);
    }

    return $data->id;
}

/**
 * Update page instance.
 * @param object $data
 * @param object $mform
 * @return bool true
 */
function descriptionpage_update_instance($data, $mform) {
    global $CFG, $DB;
    require_once("$CFG->libdir/resourcelib.php");

    $cmid        = $data->coursemodule;
    $draftitemid = $data->descriptionpage['itemid'];

    $data->timemodified = time();
    $data->id           = $data->instance;
    $data->revision++;

    $displayoptions = array();
    if ($data->display == RESOURCELIB_DISPLAY_POPUP) {
        $displayoptions['popupwidth']  = $data->popupwidth;
        $displayoptions['popupheight'] = $data->popupheight;
    }
    $displayoptions['printheading'] = $data->printheading;
    $displayoptions['printintro']   = $data->printintro;
    $data->displayoptions = serialize($displayoptions);

    $data->content       = $data->descriptionpage['text'];
    $data->contentformat = $data->descriptionpage['format'];

    $DB->update_record('descriptionpage', $data);

    $context = context_module::instance($cmid);
    if ($draftitemid) {
        $cid = $context->id;
        $mdescpage = 'mod_descriptionpage';
        $pgeo = descriptionpage_page_get_editor_options($context);
        $dcontent = $data->content;
        $data->content = file_save_draft_area_files($draftitemid, $cid, $mdescpage, 'content', 0, $pgeo, $dcontent);
        $DB->update_record('descriptionpage', $data);
    }

    return true;
}

/**
 * Delete page instance.
 * @param int $id
 * @return bool true
 */
function descriptionpage_delete_instance($id) {
    global $DB;

    if (!$descriptionpage = $DB->get_record('descriptionpage', array('id' => $id))) {
        return false;
    }

    // Note: all context files are deleted automatically.

    $DB->delete_records('descriptionpage', array('id' => $descriptionpage->id));

    return true;
}

/**
 * Given a course_module object, this function returns any
 * "extra" information that may be needed when printing
 * this activity in a course listing.
 *
 * See {@link get_array_of_activities()} in course/lib.php
 *
 * @param stdClass $coursemodule
 * @return cached_cm_info Info to customise main page display
 */
function descriptionpage_get_coursemodule_info($coursemodule) {
    global $CFG, $DB;
    require_once("$CFG->libdir/resourcelib.php");

    if (!$descriptionpage = $DB->get_record('descriptionpage', array('id' => $coursemodule->instance),
            'id, name, display, displayoptions, intro, introformat')) {
        return null;
    }

    $info = new cached_cm_info();
    $info->name = $descriptionpage->name;

    if ($coursemodule->showdescription) {
        // Convert intro to html. Do not filter cached version, filters run at display time.
        $info->content = format_module_intro('descriptionpage', $descriptionpage, $coursemodule->id, false);
    }

    if ($descriptionpage->display != RESOURCELIB_DISPLAY_POPUP) {
        return $info;
    }

    $fullurl = "$CFG->wwwroot/mod/descriptionpage/view.php?id=$coursemodule->id&amp;inpopup=1";
    $options = empty($descriptionpage->displayoptions) ? array() : unserialize($descriptionpage->displayoptions);
    $width  = empty($options['popupwidth']) ? 620 : $options['popupwidth'];
    $height = empty($options['popupheight']) ? 450 : $options['popupheight'];
    $stringpart1 = "width=$width,height=$height,toolbar=no,location=no,menubar=no,copyhistory=no";
    $stringpart2 = "status=no,directories=no,scrollbars=yes,resizable=yes";
    $wh = $stringpart1.$stringpart2;
    // ..."width=$width,height=$height,toolbar=no,location=no,menubar=no,copyhistory=no,
    // ...status=no,directories=no,scrollbars=yes,resizable=yes";.
    $info->onclick = "window.open('$fullurl', '', '$wh'); return false;";

    return $info;
}


/**
 * Lists all browsable file areas
 *
 * @package  mod_page
 * @category files
 * @param stdClass $course course object
 * @param stdClass $cm course module object
 * @param stdClass $context context object
 * @return array
 */
function descriptionpage_get_file_areas($course, $cm, $context) {
    $areas = array();
    $areas['content'] = get_string('content', 'descriptionpage');
    return $areas;
}

/**
 * File browsing support for page module content area.
 *
 * @package  mod_descriptionpage
 * @category files
 * @param stdClass $browser file browser instance
 * @param stdClass $areas file areas
 * @param stdClass $course course object
 * @param stdClass $cm course module object
 * @param stdClass $context context object
 * @param string $filearea file area
 * @param int $itemid item ID
 * @param string $filepath file path
 * @param string $filename file name
 * @return file_info instance or null if not found
 */
function descriptionpage_get_file_info($browser, $areas, $course, $cm, $context, $filearea, $itemid, $filepath, $filename) {
    global $CFG;

    if (!has_capability('moodle/course:managefiles', $context)) {
        // Students can not peak here!
        return null;
    }

    $fs = get_file_storage();

    if ($filearea === 'content') {
        $filepath = is_null($filepath) ? '/' : $filepath;
        $filename = is_null($filename) ? '.' : $filename;

        $urlbase = $CFG->wwwroot.'/pluginfile.php';
        if (!$storedfile = $fs->get_file($context->id, 'mod_descriptionpage', 'content', 0, $filepath, $filename)) {
            if ($filepath === '/' and $filename === '.') {
                $storedfile = new virtual_root_file($context->id, 'mod_descriptionpage', 'content', 0);
            } else {
                // Not found.
                return null;
            }
        }
        require_once("$CFG->dirroot/mod/descriptionpage/locallib.php");
        $b = $browser;
        $c = $context;
        $s = $storedfile;
        $u = $urlbase;
        $a = $areas[$filearea];
        return new descriptionpage_page_content_file_info($b, $c, $s, $u, $a, true, true, true, false);
    }

    // Note: page_intro handled in file_browser automatically.

    return null;
}

/**
 * Serves the page files.
 *
 * @package  mod_descriptionpage
 * @category files
 * @param stdClass $course course object
 * @param stdClass $cm course module object
 * @param stdClass $context context object
 * @param string $filearea file area
 * @param array $args extra arguments
 * @param bool $forcedownload whether or not force download
 * @param array $options additional options affecting the file serving
 * @return bool false if file not found, does not return if found - just send the file
 */
function descriptionpage_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options=array()) {
    global $CFG, $DB;
    require_once("$CFG->libdir/resourcelib.php");

    if ($context->contextlevel != CONTEXT_MODULE) {
        return false;
    }

    require_course_login($course, true, $cm);
    if (!has_capability('mod/descriptionpage:view', $context)) {
        return false;
    }

    if ($filearea !== 'content') {
        // Intro is handled automatically in pluginfile.php.
        return false;
    }

    // ...$arg could be revision number or index.html.
    $arg = array_shift($args);
    if ($arg == 'index.html' || $arg == 'index.htm') {
        // Serve page content.
        $filename = $arg;

        if (!$descriptionpage = $DB->get_record('descriptionpage', array('id' => $cm->instance), '*', MUST_EXIST)) {
            return false;
        }

        // Remove @@PLUGINFILE@@/.
        $content = str_replace('@@PLUGINFILE@@/', '', $descriptionpage->content);

        $formatoptions = new stdClass;
        $formatoptions->noclean = true;
        $formatoptions->overflowdiv = true;
        $formatoptions->context = $context;
        $content = format_text($content, $descriptionpage->contentformat, $formatoptions);

        send_file($content, $filename, 0, 0, true, true);
    } else {
        $fs = get_file_storage();
        $relativepath = implode('/', $args);
        $fullpath = "/$context->id/mod_descriptionpage/$filearea/0/$relativepath";
        if (!$file = $fs->get_file_by_hash(sha1($fullpath)) or $file->is_directory()) {
            $arrayid = array('id' => $cm->instance);
            $moddesc = 'mod_descriptionpage';
            $descriptionpage = $DB->get_record('descriptionpage', $arrayid, 'id, legacyfiles', MUST_EXIST);
            if ($descriptionpage->legacyfiles != RESOURCELIB_LEGACYFILES_ACTIVE) {
                return false;
            }
            if (!$file = resourcelib_try_file_migration('/'.$relativepath, $cm->id, $cm->course, $moddesc, 'content', 0)) {
                return false;
            }
            // File migrate - update flag.
            $descriptionpage->legacyfileslast = time();
            $DB->update_record('descriptionpage', $descriptionpage);
        }

        // Finally send the file.
        send_stored_file($file, null, 0, $forcedownload, $options);
    }
}

/**
 * Return a list of page types
 * @param string $pagetype current page type
 * @param stdClass $parentcontext Block's parent context
 * @param stdClass $currentcontext Current context of block
 */
function descriptionpage_type_list($pagetype, $parentcontext, $currentcontext) {
    $modulepagetype = array('mod-page-*' => get_string('page-mod-page-x', 'descriptionpage'));
    return $modulepagetype;
}

/**
 * Export page resource contents
 *
 * @return array of file content
 */
function descriptionpage_export_contents($cm, $baseurl) {
    global $CFG, $DB;
    $contents = array();
    $context = context_module::instance($cm->id);

    $descriptionpage = $DB->get_record('descriptionpage', array('id' => $cm->instance), '*', MUST_EXIST);

    // Page contents.
    $url = "/mod_descriptionpage/content/";
    $fs = get_file_storage();
    $files = $fs->get_area_files($context->id, 'mod_descriptionpage', 'content', 0, 'sortorder DESC, id ASC', false);
    foreach ($files as $fileinfo) {
        $urlbase = "$CFG->wwwroot/".$baseurl;
        $url = '/'.$context->id.$url.$descriptionpage->revision.$fileinfo->get_filepath().$fileinfo->get_filename();
        $file = array();
        $file['type'] = 'file';
        $file['filename'] = $fileinfo->get_filename();
        $file['filepath'] = $fileinfo->get_filepath();
        $file['filesize'] = $fileinfo->get_filesize();
        $file['fileurl'] = file_encode_url($urlbase, $url, true);
        $file['timecreated'] = $fileinfo->get_timecreated();
        $file['timemodified'] = $fileinfo->get_timemodified();
        $file['sortorder'] = $fileinfo->get_sortorder();
        $file['userid'] = $fileinfo->get_userid();
        $file['author'] = $fileinfo->get_author();
        $file['license'] = $fileinfo->get_license();
        $contents[] = $file;
    }

    // Page html conent.
    $filename = 'index.html';
    $pagefile = array();
    $pagefile['type']         = 'file';
    $pagefile['filename']     = $filename;
    $pagefile['filepath']     = '/';
    $pagefile['filesize']     = 0;
    $url1 = "$CFG->wwwroot/" . $baseurl;
    $url2 = '/'.$context->id.'/mod_descriptionpage/content/' . $filename;
    $pagefile['fileurl']      = file_encode_url($url1, $url2, true);
    $pagefile['timecreated']  = null;
    $pagefile['timemodified'] = $descriptionpage->timemodified;
    // Make this file as main file.
    $pagefile['sortorder']    = 1;
    $pagefile['userid']       = null;
    $pagefile['author']       = null;
    $pagefile['license']      = null;
    $contents[] = $pagefile;

    return $contents;
}

/**
 * Register the ability to handle drag and drop file uploads
 * @return array containing details of the files / types the mod can handle
 */
function descriptionpage_dndupload_register() {
    return array('types' => array(
                     array('identifier' => 'text/html', 'message' => get_string('createpage', 'descriptionpage')),
                     array('identifier' => 'text', 'message' => get_string('createpage', 'descriptionpage'))
                 ));
}

/**
 * Handle a file that has been uploaded
 * @param object $uploadinfo details of the file / content that has been uploaded
 * @return int instance id of the newly created mod
 */
function descriptionpage_dndupload_handle($uploadinfo) {
    // Gather the required info.
    $data = new stdClass();
    $data->course = $uploadinfo->course->id;
    $data->name = $uploadinfo->displayname;
    $data->intro = '<p>'.$uploadinfo->displayname.'</p>';
    $data->introformat = FORMAT_HTML;
    if ($uploadinfo->type == 'text/html') {
        $data->contentformat = FORMAT_HTML;
        $data->content = clean_param($uploadinfo->content, PARAM_CLEANHTML);
    } else {
        $data->contentformat = FORMAT_PLAIN;
        $data->content = clean_param($uploadinfo->content, PARAM_TEXT);
    }
    $data->coursemodule = $uploadinfo->coursemodule;

    // Set the display options to the site defaults.
    $config = get_config('descriptionpage');
    $data->display = $config->display;
    $data->popupheight = $config->popupheight;
    $data->popupwidth = $config->popupwidth;
    $data->printheading = $config->printheading;
    $data->printintro = $config->printintro;

    return page_add_instance($data, null);
}
