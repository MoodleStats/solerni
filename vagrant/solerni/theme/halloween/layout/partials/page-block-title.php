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
use local_orange_library\utilities\utilities_object;
use local_orange_library\utilities\utilities_network;

global $COURSE, $SCRIPT, $ME;

if ($oncoursepage = utilities_course::is_on_course_page()) {
    $sharelink = utilities_course::get_mooc_share_menu($COURSE->id);
    $learnmorelink = utilities_course::get_mooc_learnmore_menu($COURSE->id);
    $forumlink = utilities_course::get_mooc_forum_menu($COURSE->id);
    $learnlink = utilities_course::get_mooc_learn_menu($COURSE->id);

    $sharelinkactive = utilities_course::is_active_tab("share", $ME, $COURSE->id);
    $learnmorelinkactive = utilities_course::is_active_tab("learnmore", $SCRIPT, $COURSE->id);
    $forumlinkactive = utilities_course::is_active_tab("forum", $ME, $COURSE->id);
    $learnlinkactive = utilities_course::is_active_tab("learn", $ME, $COURSE->id);

    // By Default we set the LEARN tab active.
    if (empty($sharelinkactive) && empty($forumlinkactive) && empty($learnmorelinkactive)) {
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

// This page is not available on Solerni HOME
if (local_orange_library\utilities\utilities_network::is_platform_uses_mnet() &&
        !local_orange_library\utilities\utilities_network::is_home() &&
        local_orange_library\utilities\utilities_network::is_thematic() &&
        local_orange_library\utilities\utilities_object::is_frontpage()) {
    $nbusersconnected = local_orange_library\utilities\utilities_user::get_nbconnectedusers();
    $nbusersregistred = local_orange_library\utilities\utilities_user::get_nbusers();
    $onthematicfrontpage = true;
}

?>
<!-- page block title -->
<div class="row">
    <div class="col-xs-12 page-block-title">

        <?php if(isset($onthematicfrontpage)) : ?>
        <?php echo "<div class='page-block-lineinfo-thematic-frontpage'>" .
            get_string('lineinfobegin', 'theme_halloween') .
            "<span class='text-bold text-secondary'>" . $nbusersregistred . "</span>" .
        utilities_object::get_string_plural($nbusersregistred, 'theme_halloween', 'registered', 'registeredplural') .
            "<span class='text-bold text-secondary'>" . $nbusersconnected . "</span>" .
        utilities_object::get_string_plural($nbusersconnected, 'theme_halloween', 'connected', 'connectedplural') .
                "</div>";
        ?>
        <?php elseif ($titles->pageblocktitleh1) : ?>
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


