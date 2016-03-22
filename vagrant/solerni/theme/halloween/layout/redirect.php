<?php
// This file is part of The Bootstrap 3 Moodle theme
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

use local_orange_library\utilities\utilities_network;

echo $OUTPUT->doctype() ?>
<html <?php echo $OUTPUT->htmlattributes(); ?>>
<head>
    <title><?php echo $OUTPUT->page_title(); ?></title>
    <link rel="shortcut icon" href="<?php echo $OUTPUT->favicon(); ?>" />
    <?php echo $OUTPUT->standard_head_html() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimal-ui">
</head>

<body <?php echo $OUTPUT->body_attributes(); ?>>
<?php echo $OUTPUT->standard_top_of_body_html() ?>
    <script>
        document.body.className += ' jsenabled';
    </script>
    <div class="u-inverse">
        <?php require_once($CFG->partialsdir . '/header/skiplinks.php'); ?>
    </div>
    <?php if (utilities_network::is_platform_uses_mnet()) : ?>
    <div class="u-inverse">
        <?php require_once($CFG->partialsdir . '/header/nav-resac.php'); ?>
    </div>
    <div class="u-inverse">
        <div class="col-xs-12 fullwidth-line"></div>
    </div>
    <?php endif; ?>
    <!-- header -->
    <div class="u-inverse">
        <?php require($CFG->partialsdir . '/header/header_solerni.php'); ?>
    </div>
    <!-- content -->
    <div id="page">
        <div id="page-content" class="container clearfix">
            <?php echo $OUTPUT->main_content(); ?>
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
    <?php echo $OUTPUT->standard_end_of_body_html() ?>
</body>
</html>
