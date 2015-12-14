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

/*
 * Required : include flexpage library
 */
require_once($CFG->dirroot.'/course/format/flexpage/locallib.php');
use local_orange_library\utilities\utilities_course;
use theme_halloween\tools\theme_utilities;

$hassidepre = $PAGE->blocks->region_has_content('side-pre', $OUTPUT);
$hassidepost = $PAGE->blocks->region_has_content('side-post', $OUTPUT);
$knownregionpre = $PAGE->blocks->is_known_region('side-pre');
$knownregionpost = $PAGE->blocks->is_known_region('side-post');
$regions = theme_halloween_bootstrap_grid($hassidepre, $hassidepost);

// Always show block regions when editing so blocks can
// be dragged into empty block regions.
if ($PAGE->user_is_editing()) {
    if ($PAGE->blocks->is_known_region('side-pre')) {
        $showsidepre = true;
        $hassidepre  = true;
    }
    if ($PAGE->blocks->is_known_region('side-post')) {
        $showsidepost = true;
        $hassidepost  = true;
    }
    if ($PAGE->blocks->is_known_region('side-top')) {
        $hassidetop = true;
    }
}

/*
 * Fixes a strange behavior when a page has no blocks content.
 * The local plugins are not loaded - so the piwik tracker is not
 * So this test loads the missing required local plugins
 * when the page has no block content.
 */
if ( !empty($showsidepre) && !empty($showsidepost) && !empty($hassidetop)) {
    theme_utilities::load_required_plugins();
}

$PAGE->set_popup_notification_allowed(false);
if ($knownregionpre || $knownregionpost) {
    theme_bootstrap_initialise_zoom($PAGE);
}
$setzoom = theme_bootstrap_get_zoom();

echo $OUTPUT->doctype() ?>
<html <?php echo $OUTPUT->htmlattributes(); ?>>
<head>
    <title><?php echo $OUTPUT->page_title(); ?></title>
    <link rel="shortcut icon" href="<?php echo $OUTPUT->favicon(); ?>" />
    <?php echo $OUTPUT->standard_head_html(); ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimal-ui">
</head>

<body <?php echo $OUTPUT->body_attributes($setzoom); ?>>
    <script>
        document.body.className += ' jsenabled';
    </script>
    <div class="u-inverse">
        <?php require($CFG->partialsdir . '/header/skiplinks.php'); ?>
    </div>
    <!-- header -->
    <div class="u-inverse">
        <?php require($CFG->partialsdir . '/header/header_solerni.php'); ?>
    </div>
    <!-- content from template -->
    <div id="page" class="container">
        <?php if(!utilities_course::is_frontpage_course($COURSE)) {
            require($CFG->partialsdir . '/breadcrumb.php');
        } ?>
        <div id="page-content" class="row">
            <div id="region-main" class="<?php echo $regions['content']; ?>">
                <!-- content from plugin/mod/activity/local/page -->
                <?php
                echo $OUTPUT->course_content_header();
                echo $OUTPUT->main_content();
                // Flexpage
                if ($PAGE->blocks->region_has_content('main', $OUTPUT)) {
                    echo $OUTPUT->blocks('main');
                }
                echo $OUTPUT->course_content_footer();
                ?>
            </div>
            <?php
            if ($knownregionpre) {
                echo $OUTPUT->blocks('side-pre', $regions['pre']);
            }
            if ($knownregionpost) {
                echo $OUTPUT->blocks('side-post', $regions['post']);
            }
            ?>
        </div>
    </div>
    <!-- footer -->
    <div class="u-inverse">
        <?php require($CFG->partialsdir . '/footer/platform_social_bar.php'); ?>
    </div>
    <div class="u-inverse">
        <div class="col-xs-12 fullwidth-line"></div>
    </div>
    <div class="u-inverse">
        <?php require($CFG->partialsdir . '/footer/footer_solerni.php'); ?>
    </div>
    <?php echo $OUTPUT->standard_footer_html(); ?>
    <?php echo $OUTPUT->standard_end_of_body_html() ?>
</body>
</html>
