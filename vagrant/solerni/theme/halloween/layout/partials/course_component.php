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
use local_orange_library\utilities\utilities_object;

if ( $courseinfos ) :
    $customerurl = new moodle_url('/course/index.php', array('categoryid' => $course->category));

if (isset($courseinfos->imgurl)) {
    $courseimageurl = $imageutilities->get_resized_url($courseinfos->imgurl,
                             array('w' => 490, 'h' => 357, 'scale' => false));
}
if (isset($customer->urlimg)) {
    $courseurlimage = $imageutilities->get_resized_url($courseinfos->urlimg,
                             array('w' => 40, 'h' => 40, 'scale' => false));
}

    ?>

    <div class="col-sm-12 col-md-6">
        <div class="thumbnail">
            <div class="thumbnail-slide">
                <img src="<?php echo $courseimageurl; ?>" class="img-thumbnail img-responsive">
                <div class="caption">
                  <h4><?php echo $coursename; ?></h4>
                  <p><?php echo get_string('courseproposedby', 'theme_halloween'); ?>
                <?php if ($customerurl) : ?>
                    <a class="link-primary" href="<?php echo $customerurl; ?>" class="slrn-coursebox__course-customer">
                        <?php if (isset($customer->name)) {
                            echo $customer->name;
                        }?>
                    </a>
                <?php endif; ?>
                  </p>
                </div>
                <div class="caption caption-hover">
                    <?php if ( $course->startdate) : ?>
                    <div class="bold col-sm-10"><?php echo get_string('coursestartdate', 'theme_halloween') .
                                        " " . date("d.m.Y", $course->startdate); ?></div>
                    <?php endif; ?>
                    <?php if ( $courseinfos->price != get_string('price_case1', 'local_orange_library')) : ?>
                    <div class="glyphicon glyphicon-euro col-sm-1"></div>
                    <?php endif; ?>
                    <?php if ( $badges->count_badges($course->id)) : ?>
                    <div class="glyphicon glyphicon-star col-sm-1"></div>
                    <?php endif; ?>
                    <p class="small bold col-sm-12 thumbnail-text"><?php echo $courseinfos->duration;?></p>
                    <p class="col-sm-12 thumbnail-text">
                    <?php // @todo adapt length depending on viewport width ?
                    echo utilities_object::trim_text( $chelper->get_course_formatted_summary($course,
                            array('overflowdiv' => false, 'noclean' => true, 'para' => false)), 155); ?>
                    </p>
                    <p class="col-sm-12 thumbnail-text">
                        <a class="link-secondary" href="<?php echo $utilitiescourse->get_description_page_url($course); ?>">
                            <?php echo get_string('coursefindoutmore', 'theme_halloween'); ?>
                        </a>
                    </p>
                </div>
            </div>
            <div class="thumbnail-top-box u-inverse text-center"><?php echo $courseinfos->coursestatustext;?></div>
                        <?php if ($courseinfos->enrolledusers != 0) :?>
                <div class="thumbnail-middle-box u-inverse"><?php echo $courseinfos->enrolledusers. ' ' . get_string('enrolled_users', 'local_orange_library');?></div>
             <?php endif; ?>
            <div class="caption button">
                <?php
                echo $subscriptionbutton->set_button($course); ?>
            </div>
        </div>
    </div>
<?php else : ?>
 <?php if(is_user_site_admin($user)) : ?>
<div class="col-xs-12 col-md-6"><div class="alert alert-danger">not a flexpage mooc</div></div>
<?php endif;
 endif;