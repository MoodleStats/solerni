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

/**
 * Print private files tree
 *
 * @package    block_orange_private_files
 * @copyright  2016 Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

class block_orange_private_files_renderer extends plugin_renderer_base {

    /**
     * Prints private files tree view
     * @return string
     */
    public function private_files_tree() {
        return $this->render(new private_files_tree);
    }

    /**
     *
     * Display the orange block heading
     *
     * @optionnal: string $url
     * @return string html
     *
     */
    public function block_orange_private_files_heading($url = '') {

        if ($url) {
            $firstcolumn = 'col-xs-8';
            $secondcolumn = 'col-xs-4';
        } else {
            $firstcolumn = 'col-xs-12';
            $secondcolumn = '';
        }

        $output = html_writer::start_tag('div', array('class' => 'row u-row-table orange-block-heading'));
            $output .= html_writer::start_tag('div', array('class' => $firstcolumn));
                $output .= html_writer::tag('h2', get_string('title', 'block_orange_private_files'));
            $output .= html_writer::end_tag('div');
                $output .= html_writer::start_tag('div', array('class' => $secondcolumn . ' text-right u-top-align'));
                    $output .= $url;
                $output .= html_writer::end_tag('div');
        $output .= html_writer::end_tag('div');

        return $output;
    }

    public function render_private_files_tree(private_files_tree $tree) {
        $module = array('name' => 'block_orange_private_files',
            'fullpath' => '/blocks/private_files/module.js', 'requires' => array('yui2-treeview'));

        if (empty($tree->dir['subdirs']) && empty($tree->dir['files'])) {
            $output = html_writer::start_tag('div', array('class' => 'row orange-private-files-footer'));
                $output .= html_writer::tag('div', get_string('nofile', 'block_orange_private_files'),
                    array('class' => 'bold'));
            $output .= html_writer::end_tag('div');
        } else {
            $htmlid = 'private_files_tree_'.uniqid();
            $this->page->requires->js_init_call('M.block_orange_private_files.init_tree', array(false, $htmlid));
            $output = html_writer::start_tag('div', array('id' => $htmlid, 'class' => 'row orange-private-files-footer'));
            $output .= $this->htmllize_tree($tree, $tree->dir);
            $output .= html_writer::end_tag('div');
        }

        return $output;
    }

    /**
     * Internal function - creates htmls structure suitable for YUI tree.
     */
    protected function htmllize_tree($tree, $dir) {
        global $CFG;
        $yuiconfig = array();
        $yuiconfig['type'] = 'html';

        if (empty($dir['subdirs']) and empty($dir['files'])) {
            return '';
        }
        $result = '<ul>';
        foreach ($dir['subdirs'] as $subdir) {
            $image = $this->output->pix_icon(file_folder_icon(36), $subdir['dirname'], 'moodle', array('class' => 'icon'));
            $result .= '<li yuiConfig=\''.json_encode($yuiconfig).'\' class="bg-blue"><div class="bg-blue">'.$image.s($subdir['dirname']).'</div> '.$this->htmllize_tree($tree, $subdir).'</li>';
        }
        foreach ($dir['files'] as $file) {
            $url = file_encode_url("$CFG->wwwroot/pluginfile.php", '/'.$tree->context->id.'/user/private'.$file->get_filepath().$file->get_filename(), true);
            $filename = $file->get_filename();
            $image = $this->output->pix_icon(file_file_icon($file, 36), $filename, 'moodle', array('class'=>'_orange-private-files-icon'));
            $result .= '<li yuiConfig=\''.json_encode($yuiconfig).'\' class="bg-blue"><div class="bg-blue">'.html_writer::link($url, $image.$filename . " (". display_size($file->get_filesize()) . ")").'</div></li>';
        }
        $result .= '</ul>';

        return $result;
    }
}

class private_files_tree implements renderable {
    public $context;
    public $dir;
    public function __construct() {
        global $USER;
        $this->context = context_user::instance($USER->id);
        $fs = get_file_storage();
        $this->dir = $fs->get_area_tree($this->context->id, 'user', 'private', 0);
    }
}
