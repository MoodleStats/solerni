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
 * Mooc Component HTML Fragment
 *
 * @package     theme_solerni
 * @copyright   2015 Orange
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
?>

<div class="<?php echo $classes; ?>" data-course-id="<?php echo $course->id; ?>" data-type="<?php echo self::COURSECAT_TYPE_COURSE; ?>">
    <div class="slrn-coursebox__column slrn-coursebox__column--image">
        <?php if (isset($courseinfos->imgurl) && (is_object($courseinfos->imgurl))) : ?>
            <?php /* <img class="" src="<?php echo $image_utilities->get_resized_url($courseinfos->imgurl, array('w' => 324, 'h' => 232, 'scale' => true)); ?>"> */ ?>
            <img class="slrn-coursebox__course-image" src="<?php echo $courseinfos->imgurl; ?>">
        <?php endif; ?>
        <?php   if (isset($customer->urlimg) && (is_object($customer->urlimg))) :
                $customer_url = new moodle_url('/course/index.php', array('categoryid' => $course->category));
        ?>
            <a href="<?php echo $customer_url; ?>">
                <img class="slrn-coursebox__course-image-customer" src="<?php echo $customer->urlimg; ?>">
            </a>
        <?php endif; ?>
    </div>
    <div class="slrn-coursebox__column slrn-coursebox__column--description">
        <h3 class="slrn-coursebox__coursename"><?php echo $coursename; ?></h3>
        <span class="slrn-coursebox__courseby">
            <?php echo get_string('courseproposedby', 'theme_solerni'); ?>
            <a href="<?php echo $customer_url; ?>" class="slrn-coursebox__course-customer">
                <?php echo $customer->name; ?>
            </a>
        </span>
        <div class="slrn-coursebox__summary">
            <?php
            /* @todo : add filter to trim_words content with length parameter.
             * see https://docs.moodle.org/dev/Filters#Creating_a_basic_filter
             *
             */
            echo $chelper->get_course_formatted_summary($course,
                        array('overflowdiv' => false, 'noclean' => true, 'para' => false)); ?>
        </div>
    </div>
    <div class="slrn-coursebox__column slrn-coursebox__column--metadata">
    </div>
</div>
