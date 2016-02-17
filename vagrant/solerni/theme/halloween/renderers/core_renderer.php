<?php
// This file is part of The Orange Halloween Moodle Theme
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

require_once($CFG->dirroot . '/auth/googleoauth2/lib.php');

class theme_halloween_core_renderer extends theme_bootstrap_core_renderer {

    /*
     * Echo language selection dropdown menu
     *
     * @return string
     */
    public function halloween_lang_menu() {
        return $this->halloween_render_lang_menu( new custom_menu( null, current_language() ) );
    }

    /*
     * Renders a menu object
     *
     * @param $menu instance of custom_menu
     *
     * @return string
     */
    protected function halloween_render_lang_menu(custom_menu $menu) {
        global $CFG;
        $addlangmenu = true;
        $langs = get_string_manager()->get_list_of_translations();

        if (count($langs) < 2 || empty($CFG->langmenu) || ($this->page->course != SITEID
            && !empty($this->page->course->lang))) {
                $addlangmenu = false;
        }
        if (!$menu->has_children() && $addlangmenu === false) {
            return '';
        }

        if ($addlangmenu) {
            $strlang = get_string('language');
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

        $content = '<div class="dropdown">';
        foreach ($menu->get_children() as $item) {
            $content .= $this->halloween_render_lang_menu_item($item, 1);
        }
        $content .= '</div>';

        return $content;
    }

    /*
     * This code renders the custom menu items for the
     * bootstrap dropdown menu.
     */
    protected function halloween_render_lang_menu_item(custom_menu_item $menunode, $level = 0, $menutitle = '' ) {
        static $submenucount = 0;
        $content = '';
        $currenttitle = str_replace(array( ' (fr)', ' (en)' ), '',  $menunode->get_text());
        if ($menunode->has_children()) {
            $menutitle = $currenttitle;
            $submenucount++;
            if ($menunode->get_url() !== null) {
                $url = $menunode->get_url();
            } else {
                $url = '#cm_submenu_'.$submenucount;
            }
            $content .= '<button id="dLabel" class="btn btn-primary " type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
            $content .= $menutitle;
            $content .= '<span class="caret"></span></button>';
            $content .= '<ul class="dropdown-menu list-unstyled list-link" aria-labelledby="dLabel">';
            foreach ($menunode->get_children() as $menunode) {
                $content .= $this->halloween_render_lang_menu_item($menunode, 0, $menutitle);
            }
            $content .= '</ul>';
        } else {
            if ($menunode->get_url() !== null) {
                $url = $menunode->get_url();
            } else {
                $url = '#';
            }
            $classes = '';
            if ( $menutitle == $currenttitle ) {
                $classes .= ' class="is-active"';
            }
            $content .= '<li><a href="' . $url . '"' . $classes . '>' . $currenttitle . '</a></li>';
        }
        return $content;
    }

    /*
     * Echo header user menu
     * @isdummy
     */
    public function halloween_user_menu() {
        global $CFG;
        if ( isloggedin() ) {
            include($CFG->partialsdir . '/header_user_menu__auth.php' );
        } else {
            include( $CFG->partialsdir . '/header_user_menu__no_auth.php' );
            echo $this->halloween_lang_menu();
        }
    }

    /*
     * Checks if $fragment is part of current page path
     *
     * Return @bool
     */
    protected function is_menu_item_active( $fragment ) {
        global $PAGE;
        $pagepath = $PAGE->url->get_path();

        return preg_match ( "#$fragment#", $pagepath );

    }

    /*
     * @param: (string) title of the columon
     * @param: (array) list of settings names (translation keys must match)
     *
     * Check for each settings if exists
     *
     * @return: Footer Column HTML Fragment
     */
    public function halloween_login_render_form($showinstructions, $frm) {
        global $PAGE, $CFG;

        if ($showinstructions) {
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
                          <input type="checkbox" name="rememberusername" id="rememberusername" value="1" <?php if ($frm->username) { echo 'checked="checked"'; } ?> />
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
        <?php if ($showinstructions) { ?>
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
    public function halloween_register_render_form($showinstructions, $mformsignup) {
        global $PAGE, $CFG;

        if ($showinstructions) {
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
        <?php $mformsignup->display(); ?>
             </div>
        <?php if ($showinstructions) { ?>
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

    /**
     * Output an error message. By default wraps the error message in <span class="error">.
     * If the error message is blank, nothing is output.
     *
     * @param string $message the error message.
     * @return string the HTML to output.
     */
    public function error_text($message) {
        if (empty($message)) {
            return '';
        }

        return html_writer::tag('span', $message, array('class' => 'error'));
    }

    /**
     * Function to iterate the resav nav items. $hosts could be a object (one host)
     * or a array of host objects.
     *
     * @param array of hosts || host stdClass
     */
    public function resac_nav_items($hosts, $stripclient = false) {
        $html = '';

        if(is_object($hosts)) {
            $html .= self::render_nav_item($hosts, $stripclient);
        }

        if(is_array($hosts)) {
            foreach ($hosts as $host) {
                $html .= self::render_nav_item($host, $stripclient);
            }
        }

        return $html;
    }

    /**
     * Return HTML <li> element use in resac nav. You have a regular link to thematics
     * or a jump url weither you're logged in or not.
     *
     * @global type $CFG
     * @param stdClass $host
     * @return string <html fragment>
     */
    public function render_nav_item(stdClass $host, $stripclient) {
        global $CFG;

        // remove client name from host name for reasons.
        if ($stripclient) {
            $host->name = str_replace($CFG->solerni_customer_name . ' ', '', $host->name);
            $host->name = str_replace(strtolower($CFG->solerni_customer_name) . ' ', '', $host->name);
        }

        $aclasses = 'navigation-item';
        $aclasses .= (strcmp($CFG->wwwroot, $host->url) === 0) ? ' active' : '';
        $url = isloggedin() ? $host->jump : $host->url;

        $html = '<li class="list-group-item">';
        $html .= '<a class="' . $aclasses . '" href="' . $url . '">' . ucfirst($host->name) . '</a>';
        $html .= '</li>';

        return $html;
    }
}
