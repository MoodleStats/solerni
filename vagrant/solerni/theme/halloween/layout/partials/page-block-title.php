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

use local_orange_library\utilities\utilities_course;
global $COURSE; ?>

<!-- page block title -->
<div class="row">
    <div class="col-xs-12 page-block-title">
        <h1><?php echo $titles->pageblocktitleh1; ?></h1>
        <p><?php echo $titles->pageblockdesc; ?></p>
        <?php if (utilities_course::is_on_course_page()) :
            $sharelink = utilities_course::get_mooc_share_menu($COURSE->id);
            $learnmorelink = utilities_course::get_mooc_learnmore_menu($COURSE->id);
            $forumlink = utilities_course::get_mooc_forum_menu($COURSE);
            $learnlink = utilities_course::get_mooc_learn_menu($COURSE->id);
        ?>
        <div id="navbar">
            <ul class="nav nav-tabs" role="tablist">
            <?php if (!empty($learnmorelink)) : ?>
                <li><a class="navbar-brand" href="<?php echo $learnmorelink; ?>">
                    <?php echo get_string('coursemenulearnmore', 'local_orange_library') ?>
                </a></li>        
            <?php endif; ?>
            <?php if (!empty($learnlink)) : ?>
                <li><a class="navbar-brand" href="<?php echo $learnlink ?>">
                    <?php echo get_string('coursemenulearn', 'local_orange_library') ?>
                </a></li>        
            <?php endif; ?>
            <?php if (!empty($forumlink)) : ?>
                <li><a class="navbar-brand" href="<?php echo $forumlink ?>">
                    <?php echo get_string('coursemenuforum', 'local_orange_library') ?>
                </a></li>
            <?php endif; ?>
            <?php if (!empty($sharelink)) : ?>
                <li><a class="navbar-brand" href="<?php echo $sharelink ?>">
                    <?php echo get_string('coursemenushare', 'local_orange_library') ?>
                </a></li>
            <?php endif; ?>
            </ul>
        </div>
        <?php endif; ?>
    </div>
</div>


