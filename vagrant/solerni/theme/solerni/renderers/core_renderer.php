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
     * Echo header link (only one for now, but could change in the future, so I use a function
     * @isdummy
     */
    public function solerni_header_pages() {
        ?>
        <a class="slrn-top-header__item" href="<?php echo $this->page->theme->settings->about; ?>"><?php echo get_string('about', 'theme_solerni'); ?></a>
    <?php }
    
    /*
     * Echo search box
     * @isdummy
     */
    public function solerni_catalogue() {
        ?>
        <a class="slrn-top-header__item" href="<?php echo $this->page->theme->settings->catalogue; ?>"><?php echo get_string('catalogue', 'theme_solerni'); ?></a>
    <?php }
    
    /*
     * Echo lang menu
     */
    public function solerni_lang_menu() {
        return $this->render_custom_menu( new custom_menu($custommenuitems, current_language()) );
    }
    
}