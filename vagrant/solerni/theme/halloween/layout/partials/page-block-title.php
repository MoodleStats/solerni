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
global $COURSE, $SCRIPT, $ME;

if ($oncoursepage = utilities_course::is_on_course_page()) {
    $sharelink = utilities_course::get_mooc_share_menu($COURSE->id);
    $learnmorelink = utilities_course::get_mooc_learnmore_menu($COURSE->id);
    $forumlink = utilities_course::get_mooc_forum_menu($COURSE->id);
    $learnlink = utilities_course::get_mooc_learn_menu($COURSE->id);

    $sharelinkactive = utilities_course::is_active_tab("share", $SCRIPT, $COURSE->id);
    $learnmorelinkactive = utilities_course::is_active_tab("learnmore", $SCRIPT, $COURSE->id);
    $forumlinkactive = utilities_course::is_active_tab("forum", $ME, $COURSE->id);
    $learnlinkactive = utilities_course::is_active_tab("learn", $ME, $COURSE->id);

    // By Default we set the LEARN tab active.
    if (empty($sharelinkactive) && empty($forumlinkactive) && empty($learnmorelinkactive)) {
        $learnlinkactive = 'class="active"';
    }
} ?>
<!-- page block title -->
<div class="row">
    <div class="col-xs-12 page-block-title">
        <h1><?php echo $titles->pageblocktitleh1; ?></h1>
        <?php if ($titles->pageblockdesc) : ?>
            <p><?php echo $titles->pageblockdesc; ?></p>
        <?php endif; ?>
        <?php if ($oncoursepage) : ?>
            <ul class="nav nav-tabs orange-nav-tabs" role="tablist">
            <?php if (!empty($learnmorelink)) : ?>
                <li role="presentation" <?php echo $learnmorelinkactive ?>>
                    <a class="orange-nav-tabs-link" href="<?php echo $learnmorelink; ?>">
                        <?php echo get_string('coursemenulearnmore', 'local_orange_library') ?>
                    </a>
                </li>
            <?php endif; ?>
            <?php if (!empty($learnlink->url)) : ?>
                <li role="presentation" <?php echo $learnlinkactive ?>>
                    <a class="orange-nav-tabs-link" href="<?php echo $learnlink->url ?>" title="<?php echo $learnlink->title ?>">
                        <?php echo get_string('coursemenulearn', 'local_orange_library') ?>
                    </a>
                </li>
            <?php endif; ?>
            <?php if (!empty($forumlink)) : ?>
                <li role="presentation" <?php echo $forumlinkactive ?>>
                    <a class="orange-nav-tabs-link" href="<?php echo $forumlink ?>">
                        <?php echo get_string('coursemenuforum', 'local_orange_library') ?>
                    </a>
                </li>
            <?php endif; ?>
            <?php if (!empty($sharelink)) : ?>
                <li role="presentation" <?php echo $sharelinkactive ?>>
                    <a class="orange-nav-tabs-link" href="<?php echo $sharelink ?>">
                        <?php echo get_string('coursemenushare', 'local_orange_library') ?>
                    </a>
                </li>
            <?php endif; ?>
            </ul>
        <?php endif; ?>
    </div>
</div>


