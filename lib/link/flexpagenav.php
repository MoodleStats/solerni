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

require_once($CFG->dirroot.'/blocks/flexpagenav/repository/menu.php');
require_once($CFG->dirroot.'/blocks/flexpagenav/repository/link.php');

/**
 * @see block_flexpagenav_lib_link_abstract
 */
require_once($CFG->dirroot.'/blocks/flexpagenav/lib/link/abstract.php');

/**
 * Flexpage Menu Link
 *
 * @author Mark Nielsen
 * @package block_flexpagenav
 */
class block_flexpagenav_lib_link_flexpagenav extends block_flexpagenav_lib_link_abstract {
    /**
     * Used to prevent recursive rendering of menus
     *
     * @var array
     */
    static protected $menuids = array();

    public function get_info() {
        try {
            $repo = new block_flexpagenav_repository_menu();
            $menu = $repo->get_menu($this->get_link()->get_config('menuid', 0));
            return get_string('flexpagenavx', 'block_flexpagenav', format_string($menu->get_name()));
        } catch (Exception $e) {
            return get_string('flexpagenaverror', 'block_flexpagenav');
        }
    }

    public function handle_form() {
        $this->get_link()->set_config('menuid', required_param('cfgmenuid', PARAM_INT));
    }

    public function edit_form(moodle_url $submiturl) {
        $menurepo = new block_flexpagenav_repository_menu();
        $linkrepo = new block_flexpagenav_repository_link();

        $menu  = $menurepo->get_menu($this->get_link()->get_menuid());
        $menus = $menurepo->get_course_menus($menu->get_couseid());
        unset($menus[$menu->get_id()]);
        $linkrepo->set_menu_links($menu);

        foreach ($menu->get_links() as $link) {
            /** @var $link block_flexpagenav_model_link */
            if ($link->get_type() == $this->get_type() and $link->get_id() != $this->get_link()->get_id()) {
                unset($menus[$link->get_config('menuid', 0)]);
            }
        }

        if (empty($menus)) {
            return html_writer::tag('div', get_string('nomenustoadd', 'block_flexpagenav'), array('class' => 'block_flexpagenav_nomenus'));
        }
        $options = array();
        foreach ($menus as $menu) {
            $options[$menu->get_id()] = format_string($menu->get_name());
        }
        $box = new course_format_flexpage_lib_box(array('class' => 'format_flexpage_form'));

        $box->add_new_row()->add_new_cell(html_writer::label(get_string('flexpagenav', 'block_flexpagenav'), 'id_menuid'))
                           ->add_new_cell(html_writer::select($options, 'cfgmenuid', $this->get_link()->get_config('menuid'), false, array('id' => 'id_menuid')));

        return $this->get_renderer()->form_wrapper($submiturl, $box);
    }

    public function add_nodes(navigation_node $root) {
        $extrapop = false;
        if (empty(self::$menuids)) {
            array_push(self::$menuids, $this->get_link()->get_menuid());
            $extrapop = true;
        }
        $menuid = $this->get_link()->get_config('menuid', 0);
        if (!empty($menuid) and !in_array($menuid, self::$menuids)) {
            array_push(self::$menuids, $menuid);

            try {
                $menurepo = new block_flexpagenav_repository_menu();
                $linkrepo = new block_flexpagenav_repository_link();
                $menu = $menurepo->get_menu($menuid);
                $linkrepo->set_menu_links($menu);
                $links = $menu->get_links();

                if (!empty($links)) {
                    $node = $root->add(format_string($menu->get_name()), null, navigation_node::TYPE_CUSTOM, null, 'menu_'.$menu->get_id().'_'.$this->get_link()->get_id());
                    foreach ($links as $link) {
                        $link->load_type()->add_nodes($node);
                    }
                    // Steal link for first child
                    foreach ($node->children as $childnode) {
                        $node->action = $childnode->action;
                        $node->check_if_active(); // Re-run this since we just added the action
                        break;
                    }
                }
            } catch (Exception $e) {
            }
            array_pop(self::$menuids);
        }
        if ($extrapop) {
            array_pop(self::$menuids);
        }
    }
}