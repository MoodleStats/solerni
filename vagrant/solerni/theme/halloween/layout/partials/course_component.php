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
use local_orange_library\utilities\utilities_user;
use local_orange_library\utilities\utilities_course;
global $PAGE;

if ( $courseinfos ) :
    $customerurl = new moodle_url('/course/index.php', array('categoryid' => $course->category));

    if (!empty($courseinfos->imgurl)) {
        $courseimageurl = $imageutilities->get_resized_url($courseinfos->file,
                                 array('w' => 490, 'h' => 357, 'scale' => false));
    }
    if (!empty($customer->urlimg)) {
        $courseurlimage = $imageutilities->get_resized_url($customer->urlimg,
                                 array('w' => 40, 'h' => 40, 'scale' => false));
    }
?>

    <div class="col-sm-12 col-md-6">
        <div class="thumbnail hover">
            <div class="thumbnail-slide">
                <?php if (!empty($courseimageurl)) : ?>
                    <img src="<?php echo $courseimageurl; ?>" class="img-thumbnail img-responsive">
                <?php endif; ?>
                <div class="caption">
                    <h4><?php echo $coursename; ?></h4>
                    <?php if ($customerurl && $customer && $customer->name) : ?>
                    <p>
                        <?php echo get_string('courseproposedby', 'theme_halloween'); ?>
                        <a class="link-primary" href="<?php echo $customerurl; ?>">
                            <?php echo $customer->name;?>
                        </a>
                    </p>
                    <?php endif; ?>
                </div>
                <?php if ($courseinfos->thumbnailtext) : ?>
                <div class="thumbnail-promotionnal-box u-inverse">
                    <?php echo $courseinfos->thumbnailtext;?>
                </div>
                <?php endif; ?>
                 <div class="caption caption-hover">

                    <?php if ( $courseinfos->price != get_string('price_case1', 'local_orange_library')) : ?>
                    <div class="bottom-line-space glyphicon glyphicon-euro col-sm-1"></div>
                    <?php endif; ?>
                    <?php if ( $badges->count_badges($course->id)) : ?>
                    <div class="bottom-line-space glyphicon glyphicon-star col-sm-11"></div>
                    <?php endif; ?>
                    <?php if ( $course->startdate) : ?>
                    <div class="bold col-sm-12"><?php echo get_string('coursestartdate', 'theme_halloween') .
                                    " " . date("d.m.Y", $course->startdate); ?></div>
                    <?php endif; ?>

                    <div class="glyphicon glyphicon-calendar col-sm-1"></div>
                    <div class="bold col-sm-11">
                        <?php echo $courseinfos->duration. ' '.get_string('courseduration', 'theme_halloween');?>
                    </div>
                    <div class="col-sm-12 bottom-line-space thumbnail-text">
                        <a class="link-primary" href="<?php echo $customerurl; ?>">
                            <?php echo get_string('courseproposedby', 'theme_halloween').' '.utilities_course::get_categoryname_by_categoryid($course->category);?>
                        </a></div>
                    <div class="col-sm-12 bottom-line-space thumbnail-text">
                    <?php // @todo adapt length depending on viewport width ?
                    echo utilities_object::trim_text( $chelper->get_course_formatted_summary($course,
                        array('overflowdiv' => false, 'noclean' => true, 'para' => false)), 155); ?>
                    </div>
                    <div class="col-sm-12 midwidth-line"></div>
                    <div class="col-sm-12 thumbnail-text">
                        <a class="link-secondary" href="<?php echo $utilitiescourse->get_description_page_url($course); ?>">
                            <?php echo get_string('coursefindoutmore', 'theme_halloween'); ?>
                        </a>
                    </div>
                </div>
            </div>
            <div class="thumbnail-status-box u-inverse text-center">
                <?php echo $courseinfos->statustext;?>
            </div>
            <div class="caption button">
                <?php echo $courseinfos->displaybutton; ?>
            </div>
                    <?php if ( $courseinfos->statuslink != "#") :?>
                    <p class="col-sm-12 thumbnail-text">
                        <a class="link-secondary" href="<?php echo $courseinfos->statuslink; ?>">
                            <?php echo $courseinfos->statuslinktext; ?>
                        </a>
                    </p>
                    <?php endif; ?>
        </div>
    </div>

<?php else : ?>
    <?php if(utilities_user::is_user_site_admin($user)) : ?>
    <div class="col-xs-12 col-md-6">
        <div class="alert alert-danger">not a flexpage mooc</div>
    </div>
    <?php endif;
 endif;
