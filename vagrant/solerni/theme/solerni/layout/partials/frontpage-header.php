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
 * @author    Orange / Solerni
 * @package   theme_solerni
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$tagline        = ($PAGE->theme->settings->frontpagetagline) ?
                   $PAGE->theme->settings->frontpagetagline :
                   get_string('footertaglinedefault', 'theme_solerni');

$presentation   = ($PAGE->theme->settings->frontpagepresentation) ?
                   $PAGE->theme->settings->frontpagepresentation :
                   get_string('frontpagepresentationdefault', 'theme_solerni');


?>
<div class="frontpage-header">
    <div class="frontpage-header__inner">
        <h1 class="frontpage-header__item frontpage-header__tagline"><?php echo $tagline; ?></h1>
        <span class="frontpage-header__item frontpage-header__presentation">
            <div class="frontpage-header__presentation_text"><?php echo $presentation; ?></div>
            <?php if (!isloggedin()) : ?>
                <a class="btn btn-primary frontpage-header__button" href="<?php echo $CFG->wwwroot ?>/login/index.php">
                   <?php echo get_string('ifreelyregister', 'theme_solerni'); ?>
                </a>
            <?php endif; ?>
        </span>
    </div>
</div>
<div class="front-page_subheader">
        <a class="front-page_subheader__item front-page_subheader__item--contenus" href="<?php echo $this->page->theme->settings->about; ?>">
            <img class="front-page_subheader__item__picture" src="<?php echo $OUTPUT->pix_url('frontpage/header-front-contenus', 'theme'); ?>" alt="" />
            Vous êtes libres d'enrichir et de partager des contenus
        </a>
        <a class="front-page_subheader__item front-page_subheader__item--communaute" href="<?php echo $this->page->theme->settings->about; ?>">
            <img class="front-page_subheader__item__picture" src="<?php echo $OUTPUT->pix_url('frontpage/header-front-communaute', 'theme'); ?>" alt="" />
            Vous apprenez des autres et avec les autres
         </a>
        <a class="front-page_subheader__item front-page_subheader__item--activites" href="<?php echo $this->page->theme->settings->about; ?>">
            <img class="front-page_subheader__item__picture" src="<?php echo $OUTPUT->pix_url('frontpage/header-front-activites', 'theme'); ?>" alt="" />
            Vous progressez en pratiquant seul ou à plusieurs
         </a>
        <a class="front-page_subheader__item front-page_subheader__item--attestation" href="<?php echo $this->page->theme->settings->about; ?>">
            <img class="front-page_subheader__item__picture" src="<?php echo $OUTPUT->pix_url('frontpage/header-front-attestation', 'theme'); ?>" alt="" />
            Vous obtenez une validation de vos apprentissages
        </a>
</div>
