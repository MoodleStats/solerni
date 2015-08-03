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

if ( $courseinfos ) :
    $customerurl = new moodle_url('/course/index.php', array('categoryid' => $course->category));
    ?>

    <div class="<?php echo $classes; ?>"
         data-course-id="<?php echo $course->id; ?>" data-type="<?php echo self::COURSECAT_TYPE_COURSE; ?>">
        <div class="slrn-coursebox__column slrn-coursebox__column--image">
            <?php
    if ($courseinfos->imgurl) : ?>
                <img class="slrn-coursebox__course-image"
                     src="<?php echo $imageutilities->get_resized_url($courseinfos->imgurl,
                             array('w' => 500, 'h' => 357, 'scale' => false), $courseinfos->file); ?>">
            <?php
    endif; ?>
            <?php
    if ($customer && $customer->urlimg) : ?>
                <a class="slrn-coursebox__course-image-customer" href="<?php echo $customerurl; ?>">
                    <img src="<?php echo $imageutilities->get_resized_url($customer->urlimg,
                                 array('w' => 35, 'h' => 35, 'scale' => true), $customer->fileimg); ?>">
                </a>
            <?php
    endif; ?>
        </div>
        <div class="slrn-coursebox__column slrn-coursebox__column--description">
            <h3 class="slrn-coursebox__coursename"><?php echo $coursename; ?></h3>
            <span class="slrn-coursebox__courseby font-variant--type1">
                <?php echo get_string('courseproposedby', 'theme_solerni'); ?>
                <?php
    if ($customer && $customerurl) : ?>
                    <a class="link-primary" href="<?php echo $customerurl; ?>" class="slrn-coursebox__course-customer">
                        <?php echo $customer->name; ?>
                    </a>
                <?php
    endif; ?>
            </span>
            <div class="slrn-coursebox__summary">
                <?php
                echo $utilities->trim_text( $chelper->get_course_formatted_summary($course,
                            array('overflowdiv' => false, 'noclean' => true, 'para' => false)), 155); ?>
                <a class="link-secondary" href="<?php echo $utilitiescourse->get_description_page_url($course); ?>">
                    <?php echo get_string('coursefindoutmore', 'theme_solerni'); ?>
                </a>
            </div>
            <div class="slrn-coursebox__column--subscription_button">
                <?php echo $subscriptionbutton->set_button($course); ?>
            </div>
        </div>
        <div class="slrn-coursebox__column slrn-coursebox__column--metadata font-variant--type1">
            <div class="slrn-coursebox__metadata slrn-coursebox__metadata--dates">
                <div class="slrn-coursebox__metadata__icone -sprite-solerni"></div>
                <?php
    if ($course->startdate || $course->startdate ) : ?>
                    <span class="slrn-coursebox__metadata__item">
                        <?php
        if ( $course->startdate) : ?>
                            <div class="">
                                <?php echo get_string('coursestartdate', 'theme_solerni') .
                                        " " . date("d.m.Y", $course->startdate); ?>
                            </div>
                        <?php
        endif; ?>
                        <?php
        if ( $courseinfos->enddate) : ?>
                            <div class="">
                                <?php echo get_string('courseenddate', 'theme_solerni') .
                                    " " . date("d.m.Y", $courseinfos->enddate); ?>
                            </div>
                        <?php
        endif; ?>
                    </span>
                <?php
    endif; ?>
            </div>
            <div class="slrn-coursebox__metadata slrn-coursebox__metadata--badges">
                <div class="slrn-coursebox__metadata__icone -sprite-solerni"></div>
                <?php
    if ( $badges->count_badges($course->id)) : ?>
                    <span class="slrn-coursebox__metadata__item">
                        <?php echo get_string('coursebadge', 'theme_solerni'); ?>
                    </span>
                <?php
    else : ?>
                    <span class="slrn-coursebox__metadata__item">
                        <?php echo get_string('coursenobadge', 'theme_solerni'); ?>
                    </span>
                <?php
    endif; ?>
            </div>
            <div class="slrn-coursebox__metadata slrn-coursebox__metadata--price">
                <div class="slrn-coursebox__metadata__icone -sprite-solerni"></div>
                <span class="slrn-coursebox__metadata__item">
                    <?php echo $courseinfos->price; ?>
                </span>
            </div>
        </div>
    </div>
<?php
else : ?>
    <div class="coursebox slrn-coursebox slrn-coursebox--invalid"
         data-course-id="<?php echo $course->id; ?>" data-type="<?php echo self::COURSECAT_TYPE_COURSE; ?>">
        <h3 class="slrn-coursebox__coursename">
            <a href="<?php echo new moodle_url('/course/view.php', array('id' => $course->id)); ?>">
                <?php echo $coursename; ?>
            </a>
        </h3>
        <p>(Ce cours n'est pas au format flexpage)</p>
    </div>
<?php
endif;

 /*

            // Coursebox.
            $content .= html_writer::start_tag('div', array(
                    'class' => $classes,
                    'data-courseid' => $course->id,
                    'data-type' => self::COURSECAT_TYPE_COURSE,
            ));

            $content .= html_writer::start_tag('div', array('class' => 'info'));
            $content .= html_writer::start_tag('div', array('class' => 'presentation__mooc__block presentation__mooc__pic'));
            if (isset($courseinfos->imgurl) && (is_object($courseinfos->imgurl))) {
                $content .= html_writer::empty_tag('img', array('src' => $courseinfos->imgurl,
                    'class' => 'presentation__mooc__block__image'));

                if (isset($customer->urlimg) && (is_object($customer->urlimg))) {
                    $categoryimagelink = html_writer::link(new moodle_url(
                        '/course/index.php',
                        array('categoryid' => $course->category)),
                        html_writer::empty_tag('img', array('src' => $customer->urlimg,
                            'class' => 'presentation__mooc__block__logo'))
                        );
                    $content .= $categoryimagelink;
                }
            }
            $content .= html_writer::end_tag('div');

            // Course name.
            $coursename = $chelper->get_course_formatted_name($course);
            if (isset($courseinfos)) {
                $content .= html_writer::tag($nametag, $coursename, array('class' => 'presentation__mooc__text__title'));
            } else {
                $coursenamelink = html_writer::link(new moodle_url('/course/view.php', array('id' => $course->id)),
                    $coursename, array('class' => $course->visible ? '' : 'dimmed'));
                $content .= html_writer::tag($nametag, $coursenamelink, array('class' => 'coursename'));
            }

            // Course image.
            if (isset($courseinfos)) {
                $categorynamelink = html_writer::link(new moodle_url(
                    '/course/index.php',
                    array('categoryid' => $course->category)),
                    $courseinfos->categoryname);
                $content .= html_writer::start_tag('span', array('class' => 'presentation__mooc__text__subtitle'));
                $content .= get_string('courseproposedby', 'theme_solerni') . " " . $categorynamelink;
                $content .= html_writer::end_tag('span');
            }

            // Course info.
            $content .= html_writer::start_tag('div', array('class' => 'presentation__mooc__text'));
            if (isset($courseinfos)) {

                // En savoir plus.
                $ensavoirpluslink = html_writer::link(new moodle_url(
                    '/course/view.php',
                    array('id' => $course->id)),
                    get_string('coursefindoutmore', 'theme_solerni'),
                    array('class' => 'subscription_btn btn-primary')
                    );

                // Display course summary.
                if ($course->has_summary()) {
                    $content .= html_writer::start_tag('div', array('class' => 'presentation__mooc__text__desc'));
                    $content .= $chelper->get_course_formatted_summary($course,
                        array('overflowdiv' => true, 'noclean' => true, 'para' => false));
                    $content .= $ensavoirpluslink;
                    $content .= html_writer::end_tag('div'); // Summary.
                } else {
                    $content .= html_writer::start_tag('div', array('class' => 'presentation__mooc__text__desc'));
                    $content .= $ensavoirpluslink;
                    $content .= html_writer::end_tag('div');
                }

                // Icons.
                $content .= html_writer::start_tag('div', array('class' => 'presentation__mooc__block presentation__mooc__meta'));

                // Dates.
                $content .= html_writer::start_tag('span', array('class' => 'presentation__mooc__meta__date'));
                $content .= html_writer::tag('p', get_string('coursestartdate', 'theme_solerni') . " " .
                        date("d.m.Y", $course->startdate));
                $content .= html_writer::tag('p', get_string('courseenddate', 'theme_solerni') . " " .
                        date("d.m.Y", $courseinfos->enddate));
                $content .= html_writer::end_tag('span');

                // Badges.
                $content .= html_writer::start_tag('span', array('class' => 'presentation__mooc__meta__badge'));

                if ($badges->count_badges($course->id)) {
                    $content .= html_writer::tag('p', get_string('coursebadge', 'theme_solerni'));
                } else {
                    $content .= html_writer::tag('p', get_string('coursenobadge', 'theme_solerni'));
                }
                $content .= html_writer::end_tag('span'); // Badges.

                // Price.
                $content .= html_writer::start_tag('span', array('class' => 'presentation__mooc__meta__price'));
                $content .= html_writer::tag('p', $courseinfos->price);
                $content .= html_writer::end_tag('span'); // Price.

                $content .= html_writer::end_tag('div'); // Icons.
            }
            $content .= html_writer::end_tag('div'); // Presentation__mooc__text.

            $content .= html_writer::end_tag('div'); // Info.

            $content .= html_writer::end_tag('div'); // Coursebox.
            */
