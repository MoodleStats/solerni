<?php

/* 
 * @author    Shaun Daubney
 * @author    Orange / Solerni
 * @package   theme_solerni
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class theme_solerni_core_renderer extends theme_bootstrapbase_core_renderer {

    /*
     * Echo search box
     * @isdummy
     */
    public function solerni_search_box() {
    ?>
        <form id="search_form" class="slrn-top-header__item slrn-header-search-form -inactive" method="GET" action="<?php echo $this->page->url; ?>">
            <input class="slrn-header-search-input -slrn-radius" id="search_input" name="search_input" placeholder="<?php echo get_string('search', 'theme_solerni'); ?>" value=""/>
        </form>
    <?php }
    
    /*
     * Echo header links inside <li> to support boostrap
     * @isdummy
     */
    public function solerni_header_links() {
    ?>
        <li class="slrn-top-header__item">
            <a class="slrn-top-header__item" href="<?php echo $this->page->theme->settings->about; ?>"><?php echo get_string('about', 'theme_solerni'); ?></a>
        </li>
        <li class="slrn-top-header__item">
            <a class="slrn-top-header__item" href="<?php echo $this->page->theme->settings->catalogue; ?>"><?php echo get_string('catalogue', 'theme_solerni'); ?></a>
        </li>
    <?php }

    /*
     * Echo lang menu
     */
    public function solerni_lang_menu() {
        return $this->render_custom_menu( new custom_menu( null, current_language() ) );
    }
    
    /*
     * Echo header user menu
     * @isdummy
     */
    public function solerni_user_menu() {
        global $USER, $CFG, $SESSION;
        ?>
        <li class="dropdown slrn-top-header__item">
            <a class="dropdown-toggle" data-toggle="dropdown" role="button">
                <img class="profilepic" 
                     src="<?php echo $CFG->wwwroot; ?>/user/pix.php?file=/<?php echo $USER->id; ?>/f1.jpg" 
                     width="80px" 
                     height="80px" 
                     title="<?php echo $USER->firstname ?> <?php $USER->lastname ?>" 
                     alt="<?php $USER->firstname ?> <?php $USER->lastname ?>" 
                />
                <?php echo $USER->firstname ?>
                <b class="caret"></b>
            </a>
            <ul class="dropdown-menu profiledrop">
                <li>
                    <a href="<?php echo $CFG->wwwroot; ?>/my">
                        <img class="profileicon" src="<?php echo $this->pix_url('profile/course', 'theme') ?>" />
                        <?php echo get_string('mycourses'); ?>
                    </a>
                </li>
                <li>
                    <a href="<?php echo $CFG->wwwroot ?>/user/profile.php">
                        <img class="profileicon" src="<?php echo $this->pix_url('profile/profile', 'theme') ?>" />
                        <?php echo get_string('viewprofile'); ?>
                    </a>
                </li>
                <li>
                    <a href="<?php echo $CFG->wwwroot ?>/user/edit.php">
                        <img class="profileicon" src="<?php echo $this->pix_url('profile/edit', 'theme') ?>" />
                        <?php echo get_string('editmyprofile'); ?>
                    </a>
                </li>
                <li>
                    <a href="<?php echo $CFG->wwwroot ?>/user/files.php">
                        <img class="profileicon" src="<?php echo $this->pix_url('profile/files', 'theme') ?>" />
                        <?php echo get_string('myfiles'); ?>
                    </a>
                </li>
                <li>
                    <a href="<?php echo $CFG->wwwroot ?>/calendar/view.php?view=month">
                        <img class="profileicon" src="<?php echo $this->pix_url('profile/calendar', 'theme') ?>" />
                        <?php echo get_string('calendar','calendar'); ?>
                    </a>
                </li>
                <li>
                    <a href="<?php echo $CFG->wwwroot ?>/login/logout.php">
                        <img class="profileicon" src="<?php echo $this->pix_url('profile/logout', 'theme') ?>" />
                        <?php echo get_string('logout'); ?>
                    </a>
                </li>
             </ul>
        </li>
    <?php
    }
    
}