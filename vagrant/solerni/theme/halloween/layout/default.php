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
use theme_halloween\tools\theme_utilities;
use local_orange_library\utilities\utilities_network;
use local_orange_library\utilities\utilities_object;

theme_halloween_redirect_if_wantsurl();


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
if ( !isset($showsidepre) && !isset($showsidepost) && !isset($hassidetop)) {
    theme_utilities::load_required_plugins();
}

/*
 * Define page titles and description, the unified way.
 */
$titles = theme_utilities::define_page_titles_and_desc();
$PAGE->set_popup_notification_allowed(false);

echo $OUTPUT->doctype() ?>
<html <?php echo $OUTPUT->htmlattributes(); ?>>
<head>
    <title><?php echo $OUTPUT->page_title(); ?></title>
    <link rel="shortcut icon" href="<?php echo $OUTPUT->favicon(); ?>" />
    <?php echo $OUTPUT->standard_head_html(); ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimal-ui">
</head>

<body <?php echo $OUTPUT->body_attributes(); ?>>
    <script>
        document.body.className += ' jsenabled';
    </script>
    <div class="u-inverse">
        <?php require_once($CFG->partialsdir . '/header/skiplinks.php'); ?>
    </div>
    <?php if (utilities_network::is_platform_uses_mnet()) : ?>
    <!-- resac nav -->
    <div class="u-inverse">
        <?php require_once($CFG->partialsdir . '/header/nav-resac.php'); ?>
    </div>
    <div class="u-inverse">
        <div class="col-xs-12 fullwidth-line"></div>
    </div>
    <?php endif; ?>
    <!-- navigation header -->
    <div class="u-inverse">
        <?php require_once($CFG->partialsdir . '/header/header_solerni.php'); ?>
    </div>
    <?php if (theme_utilities::is_layout_uses_breadcrumbs()) : ?>
        <!-- page breadcrumbs -->
        <div class="container">
            <?php echo $OUTPUT->navbar(); ?>
        </div>
        <div class="col-xs-12 fullwidth-line line-primary"></div>
    <?php endif; ?>
    <?php if ($PAGE->button) : ?>
        <div class="container">
            <div class="page-single-button">
                <?php echo $OUTPUT->page_heading_button(); ?>
            </div>
        </div>
    <?php endif; ?>
    <?php if (utilities_object::is_frontpage()
        && utilities_network::is_platform_uses_mnet()
        && utilities_network::is_thematic()):
    ?>
        <!-- frontpage block title -->
        <div class="container">
            <?php require_once($CFG->partialsdir . '/frontpage-block-title.php'); ?>
        </div>
    <?php elseif (theme_utilities::is_layout_uses_page_block_title()) : ?>
        <!-- page block title -->
        <div class="container">
            <?php require_once($CFG->partialsdir . '/page-block-title.php'); ?>
        </div>
    <?php endif; ?>
    <main class="main-page-content">
        <div class="container">
            <div id="page-content" class="row">
                <div id="region-main" class="<?php echo $regions['content']; ?>">
                    <!-- content from plugin/mod/activity/local/page -->
                    <?php
                        echo $OUTPUT->course_content_header();
                        echo $OUTPUT->main_content();
                    ?>
                    <!-- Flexpage main block -->
                    <?php if ($PAGE->blocks->region_has_content('main', $OUTPUT)) {
                        echo $OUTPUT->blocks('main');

                        if (format_flexpage_has_next_or_previous()) : ?>
                            <!-- flexpage nav -->
                            <div class="flexpage_prev_next">
                                <?php
                                echo format_flexpage_previous_button();
                                echo format_flexpage_next_button();
                                ?>
                            </div>
                        <?php endif;
                    }
                    echo $OUTPUT->course_content_footer(); ?>
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
    </main>
    <!-- footer -->
    <div class="u-inverse">
        <?php require_once($CFG->partialsdir . '/footer/platform_social_bar.php'); ?>
    </div>
    <div class="u-inverse">
        <div class="col-xs-12 fullwidth-line"></div>
    </div>
    <div class="u-inverse">
        <?php require_once($CFG->partialsdir . '/footer/footer_solerni.php'); ?>
    </div>
    <?php echo $OUTPUT->standard_end_of_body_html() ?>
</body>
</html>
