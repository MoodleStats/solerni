<?php

/*
 * @author    Shaun Daubney
 * @author    Orange / halloween
 * @package   theme_halloween
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once($CFG->dirroot . '/auth/googleoauth2/lib.php');

class theme_halloween_core_renderer extends theme_bootstrap_core_renderer {

    /*
     * Echo search box
     * @isdummy
     */
    public function halloween_search_box() {
    ?>
    <form class="navbar-form navbar-right inline-form">

      <div class="form-group">

        <input type="search" class="input-sm form-control" placeholder="Recherche">

        <button type="submit" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-eye-open"></span> Chercher</button>

      </div>

    </form>

    <?php }

    /*
     * Echo header links inside <li> to support boostrap
     * @isdummy
     */
    public function halloween_header_links() {
        //print_object($this->page->theme->settings);
        $aboutlink      = $this->page->theme->settings->about;
        $cataloglink    = $this->page->theme->settings->catalogue;
    ?>
        <?php if ($aboutlink) : ?>
            <li class="active">
                <a  href="<?php echo $this->page->theme->settings->about; ?>">
                    <?php echo get_string('about', 'theme_halloween'); ?>
                </a>
            </li>
        <?php endif; ?>
        <?php if ($cataloglink) : ?>
            <li class="active">
                <a  href="<?php echo $this->page->theme->settings->catalogue; ?>">
                    <?php echo get_string('catalogue', 'theme_halloween'); ?>
                </a>
            </li>
        <?php endif;
    }

    /*
     * Echo lang menu
     */
    public function halloween_lang_menu() {
        return $this->halloween_render_lang_menu( new custom_menu( null, current_language() ) );
    }

    /*
     * Echo header user menu
     * @isdummy
     */
    public function halloween_user_menu() {
        global $USER, $CFG, $SESSION, $PAGE;
        $localdir = dirname(__FILE__); // we are currently inside halloween/renderers folder

        // User is logged. Use partials for maintenance
        if ( isloggedin() ) {
            include( $localdir . '/../layout/partials/header_user_menu__auth.php' );
        // User not logged in. Add langage menu
        } else {
            include( $localdir . '/../layout/partials/header_user_menu__no_auth.php' );
            echo $this->halloween_lang_menu();
        }
    }

    /*
     * This renders a menu object in the header
     *
     * This is an override of bootstrap_base which is a override of core_renderer
     */
    protected function halloween_render_lang_menu(custom_menu $menu) {
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

        $content = '<li >';
        foreach ($menu->get_children() as $item) {
            $content .= $this->halloween_render_lang_menu_item($item, 1);
        }

        return $content.'</li>';
    }

    /*
     * This code renders the custom menu items for the
     * bootstrap dropdown menu.
     */
    protected function halloween_render_lang_menu_item(custom_menu_item $menunode, $level = 0, $menu_title = '' ) {

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
                $content .= '<b ></b>';
            }
            $content .= html_writer::end_tag('a');

            $content .= '<ul >';
            $content .= '<span ></span>';
            foreach ($menunode->get_children() as $menunode) {
                $content .= $this->halloween_render_lang_menu_item($menunode, 0, $menu_title);
            }
            $content .= html_writer::end_tag('ul');
        } else {
            $content = '<li >';
            // The node doesn't have children so produce a final menuitem.
            if ($menunode->get_url() !== null) {
                $url = $menunode->get_url();
            } else {
                $url = '#';
            }

            $classes = '';
            if ( $menu_title == $current_title ) {
                $classes .= ' -is-active';
                $current_title .= '<i ></i>';
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
            //print_object($PAGE->theme->settings);
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
        <div >
            <p >
                <?php echo get_string($title, 'theme_halloween'); ?>
            </p>
            <ul >
                <?php foreach ( $settings as $setting )  :
                    if ( $PAGE->theme->settings->$setting ) : ?>
                        <li >
                            <a  href="<?php echo $PAGE->theme->settings->$setting; ?>">
                                <?php echo get_string($setting, 'theme_halloween'); ?>
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
        <div >
            <p >
                <?php echo get_string($title, 'theme_halloween'); ?>
            </p>
            <ul >
                <?php foreach ( $settings as $setting )  :
                    if ( $PAGE->theme->settings->$setting ) : ?>
                    <li >
                        <a href="<?php echo $PAGE->theme->settings->$setting; ?>"  target="_blank">
                            <span ><?php echo $setting; ?></span><!-- !!! Do not remove this comment !!! Display Bugfix : Allow no spaces between 2 elements
                            --><span >
                                <?php echo get_string($setting . 'displayname', 'theme_halloween'); ?>
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
    public function halloween_login_render_form($show_instructions, $frm) {
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
        <div >
          <div >
        <?php
          if (($CFG->registerauth == 'email') || !empty($CFG->registerauth)) { ?>
              <div ><a  href="signup.php"><?php print_string("tocreatenewaccount"); ?></a></div>
        <?php
          } ?>
            <h2><?php print_string("logintitle", 'theme_halloween') ?></h2>
              <div >
                <?php
                  if (!empty($errormsg)) {
                      echo html_writer::start_tag('div', array('class' => ''));
                      echo html_writer::link('#', $errormsg, array('id' => 'loginerrormessage', 'class' => ''));
                      echo $this->error_text($errormsg);
                      echo html_writer::end_tag('div');
                  }
                ?>
                <form action="<?php echo $CFG->httpswwwroot; ?>/login/index.php" method="post" id="login" <?php echo $autocomplete; ?> >
                  <div >
                    <div ><label for="username"><?php echo($strusername) ?></label></div>
                    <div >
                      <input type="text" name="username" id="username" size="15" value="<?php p($frm->username) ?>" />
                    </div>
                    <div ><!-- --></div>
                    <div ><label for="password"><?php print_string("password") ?></label></div>
                    <div >
                      <input type="password" name="password" id="password" size="15" value="" <?php echo $autocomplete; ?> />
                    </div>
                  </div>
                    <div ><!-- --></div>
                      <?php if (isset($CFG->rememberusername) and $CFG->rememberusername == 2) { ?>
                      <div >
                          <input type="checkbox" name="rememberusername" id="rememberusername" value="1" <?php if ($frm->username) {echo 'checked="checked"';} ?> />
                          <label for="rememberusername"><?php print_string('rememberusername', 'admin') ?></label>
                      </div>
                      <?php } ?>
                  <div ><!-- --></div>
                  <input type="submit" id="loginbtn" value="<?php print_string("login") ?>" />
                  <div ><a href="forgot_password.php"><?php print_string("forgotten") ?></a></div>
                </form>
                <div >
                    <?php
                        echo get_string("cookiesenabled");
                        echo $this->help_icon('cookiesenabled');
                    ?>
                </div>
              </div>

             </div>
        <?php if ($show_instructions) { ?>
            <div >
              <h2><?php print_string("register", 'theme_halloween' ) ?></h2>
              <div >
                    <p align="center"><?php  print_string("loginsteps", 'theme_halloween');?></p>
                  <div >
                           <form action="signup.php" method="get" id="signup">
                           <div><input  type="submit" value="<?php print_string("registerbutton", 'theme_halloween') ?>" /></div>
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
    public function halloween_register_render_form($show_instructions, $mform_signup) {
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
        <div >
          <div >
        <?php $mform_signup->display(); ?>
             </div>
        <?php if ($show_instructions) { ?>
            <div >
              <h2><?php echo get_string('registertitle', 'theme_halloween') ?></h2>
              <div >
                  <p ><?php  print_string("loginsteps", 'theme_halloween');?></p>
                <div >
                  <form action="index.php" method="get" id="login">
                  <div><input type="submit" value="<?php print_string("loginbutton", 'theme_halloween') ?>" /></div>
                  </form>
                </div>

              </div>
            </div>
        <?php } ?>

        </div>

            <?php
            }


}
