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
            <label class="hidden" for="q">Rechercher</label>
            <input class="slrn-header-search-input -slrn-radius" id="search_input" name="search_input" placeholder="Rechercher" />
        </form>
    <?php }
    
    /*
     * Echo header link (only one for now, but could change in the future, so I use a function
     * @isdummy
     */
    public function solerni_header_pages() {
        ?>
        <a href="slrn-top-header__item"><?php echo get_string('aboutsolerni'); ?></a>
    <?php }
    
    /*
     * Echo search box
     * @isdummy
     */
    public function solerni_catalogue() {
        ?>
        <a href="slrn-top-header__item"><?php echo get_string('catalogue'); ?></a>
    <?php }
    
    /*
     * Echo lang menu
     */
    public function solerni_lang_menu() {
        return $this->render_custom_menu( new custom_menu($custommenuitems, current_language()) );
    }
    
}