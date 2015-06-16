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
 * Course Component HTML Fragment
 *
 * @package     theme_solerni
 * @copyright   2015 Orange
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

if ( $courseinfos ) : ?>

    <div class="<?php echo $classes; ?>"
         data-course-id="<?php echo $course->id; ?>" data-type="<?php echo self::COURSECAT_TYPE_COURSE; ?>">
        <div class="slrn-coursebox__column slrn-coursebox__column--image">
            <?php if ($courseinfos->imgurl) : ?>
                <img class="slrn-coursebox__course-image"
                     src="<?php echo $image_utilities->get_resized_url($courseinfos->imgurl,
                             array('w' => 450, 'h' => 450, 'scale' => true), $courseinfos->file); ?>">
            <?php endif; ?>
            <?php   if ($customer->urlimg) :
                    $customer_url = new moodle_url('/course/index.php',
                            array('categoryid' => $course->category));
            ?>
                <a href="<?php echo $customer_url; ?>">
                    <img class="slrn-coursebox__course-image-customer"
                         src="<?php echo $image_utilities->get_resized_url($customer->urlimg,
                                 array('w' => 35, 'h' => 35, 'scale' => true), $customer->fileimg); ?>">
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
            <div>
                <?php echo $subscription_button->set_button($course); ?>
            </div>
        </div>
        <div class="slrn-coursebox__column slrn-coursebox__column--metadata">

        </div>
    </div>
<?php else : ?>
    <div class="coursebox slrn-coursebox slrn-coursebox--invalid"
         data-course-id="<?php echo $course->id; ?>" data-type="<?php echo self::COURSECAT_TYPE_COURSE; ?>">
        <h3 class="slrn-coursebox__coursename">
            <a href="<?php echo new moodle_url('/course/view.php', array('id' => $course->id)); ?>">
                <?php echo $coursename; ?>
            </a>
        </h3>
        <p>(Ce cours n'est pas au format flexpage)</p>
    </div>
<?php endif;
