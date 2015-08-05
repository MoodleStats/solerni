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

/*
 * @author    Shaun Daubney
 * @author    Orange / Solerni
 * @package   theme_solerni
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
use local_orange_library\utilities\utilities_course;

$utilities_course = new utilities_course();
?>
<head>
    <title><?php echo $PAGE->title ?></title>
    <link rel="shortcut icon" href="<?php echo $OUTPUT->pix_url('favicon', 'theme')?>" />
    <link rel="apple-touch-icon-precomposed" href="<?php echo $OUTPUT->pix_url('apple-touch-icon', 'theme')?>" />
    <?php echo $OUTPUT->standard_head_html() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet" type='text/css' />
    <link href="/theme/solerni/style/catalogue.css" rel="stylesheet" type='text/css' />
    <!-- FACEBOOK LINKEDIN OPEN GRAPH -->
    <meta property="og:title" content="<?php echo $PAGE->title ?>" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="<?php echo $PAGE->url ?>" />
    <?php if ($utilities_course->solerni_get_mooc_image()) {

    ?>
    <meta property="og:image" content="<?php echo $utilities_course->solerni_get_mooc_image(); ?>" />
    <?php
    }
    ?>
    <meta property="description" content="<?php echo strip_tags($COURSE->summary) ?>" />

    <!-- TWITTER CARDS -->
    <meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="@SolerniOfficiel">
<meta name="twitter:title" content="<?php echo $PAGE->title ?>">
<meta name="twitter:description" content="<?php echo strip_tags($COURSE->summary) ?>">
    <?php if ($utilities_course->solerni_get_mooc_image()) {

    ?>
<meta name="twitter:image" content="<?php echo $utilities_course->solerni_get_mooc_image(); ?>">
    <?php
    }
    ?>
</head>
