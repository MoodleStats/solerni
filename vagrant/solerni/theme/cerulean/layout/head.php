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


//TODO IE8 REQUEST
?>
<head>
    <title><?php echo $PAGE->title ?></title>
    <link rel="shortcut icon" href="<?php echo $OUTPUT->pix_url('favicon', 'theme')?>" />
    <link rel="apple-touch-icon-precomposed" href="<?php echo $OUTPUT->pix_url('apple-touch-icon', 'theme')?>" />
        <meta charset="utf-8">

    <link href="assets/css/bootstrap.css" rel="stylesheet">

    <style type="text/css">

      body { background-color:#DDD; }

      [class*="col"] { margin-bottom: 20px; }

      .form-inline { margin-top: 20px}

      img { width: 100%; }

      .well {

        background-color:#CCC;

        padding: 20px;

      }

    </style>
    <?php echo $OUTPUT->standard_head_html() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet" type='text/css' />
    <link href="/theme/cerulean/style/catalogue.css" rel="stylesheet" type='text/css' />
</head>
