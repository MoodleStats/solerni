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
use local_orange_library\utilities\utilities_image;

global $COURSE, $SCRIPT, $ME;

if ($oncoursepage = utilities_course::is_on_course_page()) {
    $coursedashboardlink = utilities_course::get_mooc_dashboard_menu($COURSE->id);
    $sharelink = utilities_course::get_mooc_share_menu($COURSE->id);
    $learnmorelink = utilities_course::get_mooc_learnmore_menu($COURSE->id);
    $forumlink = utilities_course::get_mooc_forum_menu($COURSE->id);
    $learnlink = utilities_course::get_mooc_learn_menu($COURSE->id);

    $coursedashboardlinkactive = utilities_course::is_active_tab("coursedashboard", $ME, $COURSE->id);
    $sharelinkactive = utilities_course::is_active_tab("share", $ME, $COURSE->id);
    $learnmorelinkactive = utilities_course::is_active_tab("learnmore", $SCRIPT, $COURSE->id);
    $forumlinkactive = utilities_course::is_active_tab("forum", $ME, $COURSE->id);
    $learnlinkactive = utilities_course::is_active_tab("learn", $ME, $COURSE->id);

    // By Default we set the LEARN tab active in case we are in a module activity.
    if (empty($sharelinkactive)
        && empty($forumlinkactive)
        && empty($learnmorelinkactive)
        && empty($coursedashboardlinkactive)) {
            $learnlinkactive = 'class="active"';
    }

    // Load the customer logo
    $customer = utilities_course::solerni_course_get_customer_infos($COURSE->category);
    if($customer) {
        $customerlogoresizedurl = utilities_image::get_resized_url($customer->urlimg,
            array ('scale' => 'true', 'h' => 60));
        $customerurl = new moodle_url('/course/index.php',
                array('categoryid' => $COURSE->category));
    }
}
?>
<!-- page block title -->
<div class="row">
    <div class="col-xs-12 page-block-title">
        <?php if ($titles->pageblocktitleh1) : ?>
            <?php if (isset($customerlogoresizedurl)): ?>
                <a href="<?php echo $customerurl; ?>">
                    <img class="pull-right page-block-title__img" src="<?php echo $customerlogoresizedurl; ?>"
                         alt=" <?php echo get_string('course_edited_by', 'theme_halloween', $customer->name); ?>">
                </a>
            <?php endif; ?>
            <h1>
            <?php if ($oncoursepage) : ?>
                <a class="page-block-title__link" href="<?php echo $titles->pageblockurl; ?>" title="">
            <?php endif; ?>
                <?php echo $titles->pageblocktitleh1; ?>
            <?php if ($oncoursepage) : ?>
                </a>
            <?php endif; ?>
            </h1>
        <?php endif; ?>

        <?php if ($titles->pageblockdesc) : ?>
            <p><?php echo $titles->pageblockdesc; ?></p>
        <?php endif; ?>
        <?php if ($oncoursepage) : ?>
            <!-- Course navigation -->
            <ul class="nav nav-tabs orange-nav-tabs" role="tablist">
            <!-- Tab: course dashboard -->
            <?php if (!empty($coursedashboardlink)) : ?>
                <li role="presentation" <?php echo $coursedashboardlinkactive ?>>
                    <a class="orange-nav-tabs-link" href="<?php echo $coursedashboardlink; ?>">
                        <?php echo get_string('coursemenudashboard', 'local_orange_library') ?>
                    </a>
                </li>
            <?php endif; ?>
            <!-- Tab: Learn More -->
            <?php if (!empty($learnmorelink)) : ?>
                <li role="presentation" <?php echo $learnmorelinkactive ?>>
                    <a class="orange-nav-tabs-link" href="<?php echo $learnmorelink; ?>">
                        <?php echo get_string('coursemenulearnmore', 'local_orange_library') ?>
                    </a>
                </li>
            <?php endif; ?>
            <!-- Tab: Learn -->
            <?php if (!empty($learnlink->url)) : ?>
                <li role="presentation" <?php echo $learnlinkactive ?>>
                    <a class="orange-nav-tabs-link" href="<?php echo $learnlink->url ?>" title="<?php echo $learnlink->title ?>">
                        <?php echo get_string('coursemenulearn', 'local_orange_library') ?>
                    </a>
                </li>
            <?php endif; ?>
            <!-- Tab: Forum -->
            <?php if (!empty($forumlink)) : ?>
                <li role="presentation" <?php echo $forumlinkactive ?>>
                    <a class="orange-nav-tabs-link" href="<?php echo $forumlink ?>">
                        <?php echo get_string('coursemenuforum', 'local_orange_library') ?>
                    </a>
                </li>
            <?php endif; ?>
            <!-- Tab: Share Resources -->
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
