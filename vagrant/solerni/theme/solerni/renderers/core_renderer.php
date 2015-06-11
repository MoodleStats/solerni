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
            <a class="slrn-top-header__item slrn-top-header__item--link" href="<?php echo $this->page->theme->settings->about; ?>">
                <?php echo get_string('about', 'theme_solerni'); ?>
            </a>
        </li>
        <li class="slrn-top-header__item">
            <a class="slrn-top-header__item  slrn-top-header__item--link" href="<?php echo $this->page->theme->settings->catalogue; ?>">
                <?php echo get_string('catalogue', 'theme_solerni'); ?>
            </a>
        </li>
    <?php }

    /*
     * Echo lang menu
     */
    public function solerni_lang_menu() {
        return $this->solerni_render_lang_menu( new custom_menu( null, current_language() ) );
    }

    /*
     * Echo header user menu
     * @isdummy
     */
    public function solerni_user_menu() {
        global $USER, $CFG, $SESSION, $PAGE;
        $localdir = dirname(__FILE__); // we are currently inside solerni/renderers folder

        // User is logged. Use partials for maintenance
        if ( isloggedin() ) {
            include( $localdir . '/../layout/partials/header_user_menu__auth.php' );
        // User not logged in. Add langage menu
        } else {
            include( $localdir . '/../layout/partials/header_user_menu__no_auth.php' );
            echo $this->solerni_lang_menu();
        }
    }

    /*
     * This renders a menu object in the header
     *
     * This is an override of bootstrap_base which is a override of core_renderer
     */
    protected function solerni_render_lang_menu(custom_menu $menu) {
        global $CFG;

        // TODO: eliminate this duplicated logic, it belongs in core, not
        // here. See MDL-39565.
        $addlangmenu = true;
        $langs = get_string_manager()->get_list_of_translations();

        // Do not display if only 1 language.
        if (count($langs) < 2
            or empty($CFG->langmenu)
            or ($this->page->course != SITEID and !empty($this->page->course->lang))) {
                $addlangmenu = false;
        }
        //
        if (!$menu->has_children() && $addlangmenu === false) {
            return '';
        }

        if ($addlangmenu) {
            $strlang =  get_string('language');
            $currentlang = current_language();
            if (isset($langs[$currentlang])) {
                $currentlang = $langs[$currentlang];
            } else {
                $currentlang = $strlang;
            }
            $this->language = $menu->add($currentlang, new moodle_url('#'), $strlang, 10000);
            foreach ($langs as $langtype => $langname) {
                $this->language->add($langname, new moodle_url($this->page->url, array('lang' => $langtype)), $langname);
            }
        }

        $content = '<li class="slrn-selected-in-menu slrn-lang-menu">';
        foreach ($menu->get_children() as $item) {
            $content .= $this->solerni_render_lang_menu_item($item, 1);
        }

        return $content.'</li>';
    }

    /*
     * This code renders the custom menu items for the
     * bootstrap dropdown menu.
     */
    protected function solerni_render_lang_menu_item(custom_menu_item $menunode, $level = 0, $menu_title = '' ) {

        static $submenucount = 0;
        $content = '';
        $current_title = str_replace( array( ' (fr)', ' (en)' ), '',  $menunode->get_text() );

        if ($menunode->has_children()) {

            $menu_title = $current_title;

            // If the child has menus render it as a sub menu.
            $submenucount++;
            if ($menunode->get_url() !== null) {
                $url = $menunode->get_url();
            } else {
                $url = '#cm_submenu_'.$submenucount;
            }

            $content .= html_writer::start_tag('a', array(
                                                    'href'=>$url,
                                                    'class'=>'dropdown-toggle',
                                                    'data-toggle'=>'dropdown'
            ));

            $content .= $menu_title;
            if ($level == 1) {
                $content .= '<b class="caret"></b>';
            }
            $content .= html_writer::end_tag('a');

            $content .= '<ul class="dropdown-menu">';
            $content .= '<span class="slrn-topbar-item__active"></span>';
            foreach ($menunode->get_children() as $menunode) {
                $content .= $this->solerni_render_lang_menu_item($menunode, 0, $menu_title);
            }
            $content .= html_writer::end_tag('ul');
        } else {
            $content = '<li class="dropdown-menu__item">';
            // The node doesn't have children so produce a final menuitem.
            if ($menunode->get_url() !== null) {
                $url = $menunode->get_url();
            } else {
                $url = '#';
            }

            $classes = 'dropdown-menu__item__link';
            if ( $menu_title == $current_title ) {
                $classes .= ' -is-active';
                $current_title .= '<i class="icon-ok"></i>';
            }

            $content .= html_writer::link($url, $current_title, array('class' => $classes ));
        }
        return $content;
    }

    /*
     * Checks if $fragment is part of current page path
     *
     * Return @bool
     */
    protected function is_menu_item_active( $fragment ) {
        global $PAGE;
        $page_path = $PAGE->url->get_path();

        return preg_match ( "#$fragment#", $page_path );

    }

    /*
     * @param: (array) list of settings
     *
     * @return (boolean) true if one of the settings exists, false otherwise
     */
    protected function is_theme_settings_exists( $settings = array() ) {
        global $PAGE;

        $return = false;
        foreach ( $settings as $setting ) {
            if ( $PAGE->theme->settings->$setting ) {
                $return = true;
            }
        }

        return $return;
    }

    /*
     * @param: (string) title of the columon
     * @param: (array) list of settings names (translation keys must match)
     *
     * Check for each settings if exists
     *
     * @return: Footer Column HTML Fragment
     */
    protected function render_footer_column_with_links( $title, $settings = array() ) {
        global $PAGE;

        if ( $title && $this->is_theme_settings_exists($settings) ) :
    ?>
        <div class="span2 footer-column ">
            <p class="footer_column_title">
                <?php echo get_string($title, 'theme_solerni'); ?>
            </p>
            <ul class="footer_column_menu__column">
                <?php foreach ( $settings as $setting )  :
                    if ( $PAGE->theme->settings->$setting ) : ?>
                        <li class="footer_column__item">
                            <a class="footer_column_menu_column__link" href="<?php echo $PAGE->theme->settings->$setting; ?>">
                                <?php echo get_string($setting, 'theme_solerni'); ?>
                            </a>
                        </li>
                    <?php endif;
                endforeach; ?>
            </ul>
        </div>
    <?php endif;
    }

    /*
     * @param: (string) title of the columon
     * @param: (array) list of settings names (translation keys and CSS classes must match)
     *
     * Check for each settings if exists
     *
     * @return: Footer Column HTML Fragment
     */
    protected function render_footer_column_socials( $title, $settings = array() ) {
        global $PAGE;

        if ( $title && $this->is_theme_settings_exists($settings)) :
    ?>
        <div class="span2 footer-column ">
            <p class="footer_column_title">
                <?php echo get_string($title, 'theme_solerni'); ?>
            </p>
            <ul class="footer_column_menu__column">
                <?php foreach ( $settings as $setting )  :
                    if ( $PAGE->theme->settings->$setting ) : ?>
                    <li class="button_social_item">
                        <a href="<?php echo $PAGE->theme->settings->$setting; ?>" class="footer_column_menu_column__link" target="_blank">
                            <span class="button_social_link__icon button_social_<?php echo $setting; ?>  -sprite-solerni"><?php echo $setting; ?></span><!--
                            --><span class="footer_icon_text">
                                <?php echo get_string($setting . 'displayname', 'theme_solerni'); ?>
                            </span>
                        </a>
                    </li>
                 <?php endif; endforeach; ?>
            </ul>
        </div>
    <?php endif;
    }

    /**
	 * Returns HTML to print list of courses user is enrolled to for the frontpage
	 *
	 * Also lists remote courses or remote hosts if MNET authorisation is used
	 *
	 * @return string
	 */
	public function frontpage_my_courses() {
		global $USER, $CFG, $DB;

		if (!isloggedin() or isguestuser()) {
			return '';
		}

		$output = '';
		if (!empty($CFG->navsortmycoursessort)) {
			// sort courses the same as in navigation menu
			$sortorder = 'visible DESC,'. $CFG->navsortmycoursessort.' ASC';
		} else {
			$sortorder = 'visible DESC,sortorder ASC';
		}
		$courses  = enrol_get_my_courses('summary, summaryformat', $sortorder);
		$rhosts   = array();
		$rcourses = array();
		if (!empty($CFG->mnet_dispatcher_mode) && $CFG->mnet_dispatcher_mode==='strict') {
			$rcourses = get_my_remotecourses($USER->id);
			$rhosts   = get_my_remotehosts();
		}

		if (!empty($courses) || !empty($rcourses) || !empty($rhosts)) {

			$chelper = new coursecat_helper();
			if (count($courses) > $CFG->frontpagecourselimit) {
				// There are more enrolled courses than we can display, display link to 'My courses'.
				$totalcount = count($courses);
				$courses = array_slice($courses, 0, $CFG->frontpagecourselimit, true);
				$chelper->set_courses_display_options(array(
						'viewmoreurl' => new moodle_url('/my/'),
						'viewmoretext' => new lang_string('mycourses')
				));
			} else {
				// All enrolled courses are displayed, display link to 'All courses' if there are more courses in system.
				$chelper->set_courses_display_options(array(
						'viewmoreurl' => new moodle_url('/course/index.php'),
						'viewmoretext' => new lang_string('fulllistofcourses')
				));
				$totalcount = $DB->count_records('course') - 1;
			}
			$chelper->set_show_courses(self::COURSECAT_SHOW_COURSES_EXPANDED)->
			set_attributes(array('class' => 'frontpage-course-list-enrolled'));
			$output .= $this->coursecat_courses($chelper, $courses, $totalcount);

			// MNET
			if (!empty($rcourses)) {
				// at the IDP, we know of all the remote courses
				$output .= html_writer::start_tag('div', array('class' => 'courses'));
				foreach ($rcourses as $course) {
					$output .= $this->frontpage_remote_course($course);
				}
				$output .= html_writer::end_tag('div'); // .courses
			} elseif (!empty($rhosts)) {
				// non-IDP, we know of all the remote servers, but not courses
				$output .= html_writer::start_tag('div', array('class' => 'courses'));
				foreach ($rhosts as $host) {
					$output .= $this->frontpage_remote_host($host);
				}
				$output .= html_writer::end_tag('div'); // .courses
			}
		}
		return $output;
	}
}
