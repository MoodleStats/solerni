<?php

/*
 * @author    Shaun Daubney
 * @author    Orange / Solerni
 * @package   theme_solerni
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once($CFG->dirroot . '/auth/googleoauth2/lib.php');

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
        $aboutlink      = $this->page->theme->settings->about;
        $cataloglink    = $this->page->theme->settings->catalogue;
    ?>
        <?php if ($aboutlink) : ?>
            <li class="slrn-top-header__item">
                <a class="slrn-top-header__item slrn-top-header__item--link" href="<?php echo $this->page->theme->settings->about; ?>">
                    <?php echo get_string('about', 'theme_solerni'); ?>
                </a>
            </li>
        <?php endif; ?>
        <?php if ($cataloglink) : ?>
            <li class="slrn-top-header__item">
                <a class="slrn-top-header__item  slrn-top-header__item--link" href="<?php echo $this->page->theme->settings->catalogue; ?>">
                    <?php echo get_string('catalogue', 'theme_solerni'); ?>
                </a>
            </li>
        <?php endif;
    }

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

    /*
     * @param: (string) title of the columon
     * @param: (array) list of settings names (translation keys must match)
     *
     * Check for each settings if exists
     *
     * @return: Footer Column HTML Fragment
     */
    public function solerni_login_render_form($show_instructions, $frm) {
        global $PAGE, $CFG;

        if ($show_instructions) {
            $columns = 'twocolumns';
        } else {
            $columns = 'onecolumn';
        }

        if (!empty($CFG->loginpasswordautocomplete)) {
            $autocomplete = 'autocomplete="off"';
        } else {
            $autocomplete = '';
        }
        if (empty($CFG->authloginviaemail)) {
            $strusername = get_string('username');
        } else {
            $strusername = get_string('usernameemail');
        }
        auth_googleoauth2_display_buttons();
        ?>
        <div class="loginbox clearfix <?php echo $columns ?>">
          <div class="loginpanel">
        <?php
          if (($CFG->registerauth == 'email') || !empty($CFG->registerauth)) { ?>
              <div class="skiplinks"><a class="skip" href="signup.php"><?php print_string("tocreatenewaccount"); ?></a></div>
        <?php
          } ?>
            <h2><?php print_string("logintitle", 'theme_solerni') ?></h2>
              <div class="subcontent loginsub">
                <?php
                  if (!empty($errormsg)) {
                      echo html_writer::start_tag('div', array('class' => 'loginerrors'));
                      echo html_writer::link('#', $errormsg, array('id' => 'loginerrormessage', 'class' => 'accesshide'));
                      echo $this->error_text($errormsg);
                      echo html_writer::end_tag('div');
                  }
                ?>
                <form action="<?php echo $CFG->httpswwwroot; ?>/login/index.php" method="post" id="login" <?php echo $autocomplete; ?> >
                  <div class="loginform">
                    <div class="form-label"><label for="username"><?php echo($strusername) ?></label></div>
                    <div class="form-input">
                      <input type="text" name="username" id="username" size="15" value="<?php p($frm->username) ?>" />
                    </div>
                    <div class="clearer"><!-- --></div>
                    <div class="form-label"><label for="password"><?php print_string("password") ?></label></div>
                    <div class="form-input">
                      <input type="password" name="password" id="password" size="15" value="" <?php echo $autocomplete; ?> />
                    </div>
                  </div>
                    <div class="clearer"><!-- --></div>
                      <?php if (isset($CFG->rememberusername) and $CFG->rememberusername == 2) { ?>
                      <div class="rememberpass">
                          <input type="checkbox" name="rememberusername" id="rememberusername" value="1" <?php if ($frm->username) {echo 'checked="checked"';} ?> />
                          <label for="rememberusername"><?php print_string('rememberusername', 'admin') ?></label>
                      </div>
                      <?php } ?>
                  <div class="clearer"><!-- --></div>
                  <input class="btn btn-primary"type="submit" id="loginbtn" value="<?php print_string("login") ?>" />
                  <div class="forgetpass"><a href="forgot_password.php"><?php print_string("forgotten") ?></a></div>
                </form>
                <div class="desc">
                    <?php
                        echo get_string("cookiesenabled");
                        echo $this->help_icon('cookiesenabled');
                    ?>
                </div>
              </div>

             </div>
        <?php if ($show_instructions) { ?>
            <div class="signuppanel">
              <h2><?php print_string("register", 'theme_solerni' ) ?></h2>
              <div class="subcontent">
                    <p align="center"><?php  print_string("loginsteps", 'theme_solerni');?></p>
                  <div class="signupform">
                           <form action="signup.php" method="get" id="signup">
                           <div><input class="btn btn-primary" type="submit" value="<?php print_string("registerbutton", 'theme_solerni') ?>" /></div>
                           </form>
                         </div>
              </div>
            </div>
        <?php } ?>
        </div>
            <?php
            }

    /*
     * @param: (string) title of the columon
     * @param: (array) list of settings names (translation keys must match)
     *
     * Check for each settings if exists
     *
     * @return: Footer Column HTML Fragment
     */
    public function solerni_register_render_form($show_instructions, $mform_signup) {
        global $PAGE, $CFG;

        if ($show_instructions) {
            $columns = 'twocolumns';
        } else {
            $columns = 'onecolumn';
        }

        if (!empty($CFG->loginpasswordautocomplete)) {
            $autocomplete = 'autocomplete="off"';
        } else {
            $autocomplete = '';
        }
        if (empty($CFG->authloginviaemail)) {
            $strusername = get_string('username');
        } else {
            $strusername = get_string('usernameemail');
        }

        auth_googleoauth2_display_buttons();
        ?>
        
        <div class="loginbox clearfix <?php echo $columns ?>">
          <div class="loginpanel">
        <?php $mform_signup->display(); ?>
             </div>
        <?php if ($show_instructions) { ?>
            <div class="signuppanel">
              <h2><?php echo get_string('registertitle', 'theme_solerni') ?></h2>
              <div class="subcontent">
                  <p ><?php  print_string("loginsteps", 'theme_solerni');?></p>
                <div class="signupform">
                  <form action="index.php" method="get" id="login">
                  <div><input class="btn btn-primary" type="submit" value="<?php print_string("loginbutton", 'theme_solerni') ?>" /></div>
                  </form>
                </div>

              </div>
            </div>
        <?php } ?>

        </div>

            <?php
            }


}