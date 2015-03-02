<?php
/**
 * Flexpage Navigation Block
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see http://opensource.org/licenses/gpl-3.0.html.
 *
 * @copyright Copyright (c) 2009 Moodlerooms Inc. (http://www.moodlerooms.com)
 * @license http://opensource.org/licenses/gpl-3.0.html GNU Public License
 * @package block_flexpagenav
 * @author Mark Nielsen
 */

/**
 * @see block_flexpagenav_repository_menu
 */
require_once($CFG->dirroot.'/blocks/flexpagenav/repository/menu.php');

/**
 * @see block_flexpagenav_repository_link
 */
require_once($CFG->dirroot.'/blocks/flexpagenav/repository/link.php');

/**
 * AJAX Controller
 *
 * @author Mark Nielsen
 * @package block_flexpagenav
 */
class block_flexpagenav_controller_ajax extends mr_controller {
    /**
     * Since this handles AJAX, set our own exception handler
     *
     * @return void
     */
    protected function init() {
        set_exception_handler(array($this, 'exception_handler'));
    }

    public function require_capability() {
        require_capability('block/flexpagenav:manage', $this->get_context());
    }

    /**
     * Set's errors through mr_notify
     *
     * @param Exception $e
     * @return void
     */
    public function exception_handler($e) {
        $this->notify->bad('ajaxexception', $e->getMessage());

        if (debugging('', DEBUG_DEVELOPER)) {
            $this->notify->add_string(format_backtrace(get_exception_info($e)->backtrace));
        }
    }

    /**
     * Add existing menu modal
     */
    public function addexistingmenu_action() {
        global $CFG, $COURSE;

        require_once($CFG->dirroot.'/course/format/flexpage/lib.php');
        require_once($CFG->dirroot.'/course/format/flexpage/lib/moodlepage.php');

        if (optional_param('add', 0, PARAM_BOOL)) {
            require_sesskey();

            $menuid = optional_param('menuid', '', PARAM_INT);
            $region = optional_param('region', false, PARAM_ALPHANUMEXT);
            $page   = format_flexpage_cache()->get_current_page();

            if (!empty($menuid)) {
                course_format_flexpage_lib_moodlepage::add_menu_block($page, $menuid, $region);
            }
        } else {
            $repo = new block_flexpagenav_repository_menu();

            echo json_encode((object) array(
                'args' => course_format_flexpage_lib_moodlepage::get_region_json_options(),
                'header' => $this->output->flexpage_help_icon('addexistingmenu', 'block_flexpagenav'),
                'body' => $this->output->add_existing_menu(
                    $this->new_url(array('sesskey' => sesskey(), 'action' => 'addexistingmenu', 'add' => 1)),
                    $repo->get_course_menus($COURSE->id)
                ),
            ));
        }
    }

    /**
     * Mange menus modal
     */
    public function managemenus_action() {
        global $COURSE;

        $repo = new block_flexpagenav_repository_menu();

        echo json_encode((object) array(
            'args'   => (object) array('addurl' => $this->new_url(array('action' => 'editmenu'))->out(false)),
            'header' => $this->output->flexpage_help_icon('managemenus', 'block_flexpagenav'),
            'body'   => $this->output->manage_menus(
                $this->new_url(),
                $repo->get_course_menus($COURSE->id)
            ),
        ));
    }

    /**
     * Edit menu modal
     */
    public function editmenu_action() {
        global $COURSE;

        $menuid = optional_param('menuid', 0, PARAM_INT);

        $repo = new block_flexpagenav_repository_menu();

        if (!empty($menuid)) {
            $menu = $repo->get_menu($menuid);
        } else {
            $menu = new block_flexpagenav_model_menu();
        }
        if (optional_param('edit', 0, PARAM_BOOL)) {
            require_sesskey();

            $menu->set_couseid($COURSE->id)
                 ->set_name(trim(required_param('name', PARAM_TEXT)))
                 ->set_render(required_param('render', PARAM_ALPHA))
                 ->set_displayname(optional_param('displayname', 0, PARAM_BOOL))
                 ->set_useastab(optional_param('useastab', 0, PARAM_BOOL));

            $repo->save_menu($menu);

        } else {
            echo json_encode((object) array(
                'header' => get_string('editmenu', 'block_flexpagenav'),
                'body'   => $this->output->edit_menu(
                    $this->new_url(array('action' => 'editmenu', 'sesskey' => sesskey(), 'edit' => 1, 'menuid' => $menuid)),
                    $menu
                ),
            ));
        }
    }

    /**
     * Delete menu modal
     */
    public function deletemenu_action() {
        $menuid = required_param('menuid', PARAM_INT);

        $repo = new block_flexpagenav_repository_menu();
        $menu = $repo->get_menu($menuid);

        if (optional_param('confirmdelete', 0, PARAM_BOOL)) {
            require_sesskey();

            $repo->delete_menu($menu);

        } else {
            echo json_encode((object) array(
                'header' => get_string('deletemenu', 'block_flexpagenav'),
                'body'   => $this->output->delete_menu(
                    $this->new_url(array('action' => 'deletemenu', 'sesskey' => sesskey(), 'confirmdelete' => 1, 'menuid' => $menu->get_id())),
                    $menu
                ),
            ));
        }
    }

    /**
     * Manage links modal
     */
    public function managelinks_action() {
        $menuid = required_param('menuid', PARAM_INT);

        $menurepo = new block_flexpagenav_repository_menu();
        $linkrepo = new block_flexpagenav_repository_link();

        $menu = $menurepo->get_menu($menuid);
        $linkrepo->set_menu_links($menu);

        echo json_encode((object) array(
            'header' => get_string('managinglinksforx', 'block_flexpagenav', format_string($menu->get_name())),
            'body'   => $this->output->manage_links(
                $this->new_url(),
                $menu
            ),
        ));
    }

    /**
     * Edit link modal
     */
    public function editlink_action() {
        $menuid = required_param('menuid', PARAM_INT);
        $type   = required_param('type', PARAM_SAFEDIR);
        $linkid = optional_param('linkid', 0, PARAM_INT);

        $menurepo = new block_flexpagenav_repository_menu();
        $linkrepo = new block_flexpagenav_repository_link();

        $menu = $menurepo->get_menu($menuid);

        /** @var $link block_flexpagenav_model_link */
        if (!empty($linkid)) {
            $link = $linkrepo->get_link($linkid);
            $linkrepo->set_link_configs($link);
        } else {
            // New link, populate it with the goods
            $link = new block_flexpagenav_model_link();
            $link->set_type($type)
                 ->set_menuid($menu->get_id())
                 ->set_weight($linkrepo->get_next_weight($link));
        }
        if (optional_param('edit', 0, PARAM_BOOL)) {
            require_sesskey();

            try {
                $link->load_type()->handle_form();
            } catch (moodle_exception $e) {
                $this->notify->add_string($e->getMessage());
            }

            $linkrepo->save_link($link)
                     ->save_link_config($link, $link->get_configs());

        } else {
            echo json_encode((object) array(
                'args'   => $link->get_type(),
                'header' => get_string('editingx', 'block_flexpagenav', $link->load_type()->get_name()),
                'body'   => $link->load_type()->edit_form(
                    $this->new_url(array('action' => 'editlink', 'sesskey' => sesskey(), 'edit' => 1, 'menuid' => $menu->get_id(), 'linkid' => $linkid, 'type' => $link->get_type()))
                ),
            ));
        }
    }

    /**
     * Move link modal
     */
    public function movelink_action() {
        $linkid = required_param('linkid', PARAM_INT);

        $menurepo = new block_flexpagenav_repository_menu();
        $linkrepo = new block_flexpagenav_repository_link();

        $link = $linkrepo->get_link($linkid);
        $linkrepo->set_link_configs($link);

        $menu = $menurepo->get_menu($link->get_menuid());
        $linkrepo->set_menu_links($menu);

        if (optional_param('confirmmove', 0, PARAM_BOOL)) {
            require_sesskey();

            $move      = required_param('move', PARAM_INT);
            $reflinkid = required_param('reflinkid', PARAM_INT);

            $linkrepo->move_link($link, $move, $reflinkid)
                     ->save_link($link);

        } else {
            echo json_encode((object) array(
                'header' => get_string('movelink', 'block_flexpagenav'),
                'body'   => $this->output->move_link(
                    $this->new_url(array('action' => 'movelink', 'sesskey' => sesskey(), 'confirmmove' => 1, 'linkid' => $link->get_id())),
                    $link,
                    $menu
                ),
            ));
        }
    }

    /**
     * Delete link modal
     */
    public function deletelink_action() {
        $linkid = required_param('linkid', PARAM_INT);

        $repo = new block_flexpagenav_repository_link();
        $link = $repo->get_link($linkid);
        $repo->set_link_configs($link);

        if (optional_param('confirmdelete', 0, PARAM_BOOL)) {
            require_sesskey();

            $repo->delete_link($link);

        } else {
            echo json_encode((object) array(
                'header' => get_string('deletelink', 'block_flexpagenav'),
                'body'   => $this->output->delete_link(
                    $this->new_url(array('action' => 'deletelink', 'sesskey' => sesskey(), 'confirmdelete' => 1, 'linkid' => $link->get_id())),
                    $link
                ),
            ));
        }
    }

    /**
     * Special AJAX endpoint for Flexpage links.  Fetches
     * child pages in a UL list with check boxes.
     */
    public function childpages_action() {
        global $CFG;

        require_once($CFG->dirroot.'/course/format/flexpage/locallib.php');

        $pageid = required_param('pageid', PARAM_INT);
        $linkid = required_param('linkid', PARAM_INT);

        $exclude = array();
        if (!empty($linkid)) {
            $repo = new block_flexpagenav_repository_link();
            $link = $repo->get_link($linkid);
            $repo->set_link_configs($link);

            $config = $link->get_config('exclude', array());
            if (!empty($config)) {
                $exclude = explode(',', $config);
            }
        }

        $cache  = format_flexpage_cache();
        $parent = $cache->get_page($pageid);

        echo $this->output->child_pages_list($parent, $cache, $exclude);
    }

    /**
     * Special AJAX endpoint for Flexpage links.  Validates
     * as passed URL.
     */
    public function validateurl_action() {
        $rawurl = required_param('url', PARAM_RAW);
        $url    = required_param('url', PARAM_URL);

        $error = '';
        if ($rawurl != $url) {
            $error = get_string('urlfailedcleaning', 'block_flexpagenav');
        } else if (strpos($url, 'http://') !== 0 and strpos($url, 'https://') !== 0) {
            $error = get_string('urlmuststartwith', 'block_flexpagenav');
        } else if (@parse_url($url) === false) {
            $error = get_string('invalidurl', 'block_flexpagenav');
        }
        echo json_encode((object) array('error' => $error));
    }
}