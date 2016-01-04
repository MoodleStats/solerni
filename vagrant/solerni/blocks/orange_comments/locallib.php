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
 * Functions and classes for commenting
 *
 * @package    block_orange_comments
 * @copyright  2015 Orange based on block_comments plugin from 1999 onwards Martin Dougiamas (http://dougiamas.com)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();

/**
 * Comment is helper class to add/delete comments anywhere in moodle
 *
 * @package    block_orange_comments
 * @copyright  2015 Orange based on block_comments plugin from 1999 onwards Martin Dougiamas (http://dougiamas.com)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class orangecomment extends comment {

    public function __construct(stdClass $options) {
        // setup client_id
        if (!empty($options->client_id)) {
            $this->cid = $options->client_id;
        } else {
            $this->cid = uniqid();
        }

        // setup context
        if (!empty($options->context)) {
            $this->context = $options->context;
            $this->contextid = $this->context->id;
        } else if (!empty($options->contextid)) {
            $this->contextid = $options->contextid;
            $this->context = context::instance_by_id($this->contextid);
        } else {
            print_error('invalidcontext');
        }

        if (!empty($options->component)) {
            // set and validate component
            $this->set_component($options->component);
        } else {
            // component cannot be empty
            throw new comment_exception('invalidcomponent');
        }

        // setup course
        // course will be used to generate user profile link
        if (!empty($options->course)) {
            $this->courseid = $options->course->id;
        } else if (!empty($options->courseid)) {
            $this->courseid = $options->courseid;
        } else {
            $this->courseid = SITEID;
        }
        // setup coursemodule
        if (!empty($options->cm)) {
            $this->cm = $options->cm;
        } else {
            $this->cm = null;
        }

        // setup commentarea
        if (!empty($options->area)) {
            $this->commentarea = $options->area;
        }

        // setup autostart
        if (!empty($options->autostart)) {
            $this->autostart = $options->autostart;
        }

        // setup itemid
        if (!empty($options->itemid)) {
            $this->itemid = $options->itemid;
        } else {
            $this->itemid = 0;
        }

        // setup options for callback functions
        $this->comment_param = new stdClass();
        $this->comment_param->context     = $this->context;
        $this->comment_param->courseid    = $this->courseid;
        $this->comment_param->cm          = $this->cm;
        $this->comment_param->commentarea = $this->commentarea;
        $this->comment_param->itemid      = $this->itemid;

        // setup customized linktext
        if (!empty($options->linktext)) {
            $this->linktext = $options->linktext;
        } else {
            $this->linktext = get_string('comments');
        }

        // setting post and view permissions
        $this->check_permissions();

        // load template
        $this->template = html_writer::start_tag('div', array('class' => 'comment-message'));
        $this->template .= html_writer::start_tag('div', array('class' => 'comment-message-meta'));

        $this->template .= html_writer::tag('span', '___picture___', array('class' => 'picture'));
        $this->template .= html_writer::tag('span', '___name___', array('class' => 'user')) . ' - ';
        $this->template .= html_writer::tag('span', '___time___', array('class' => 'time'));

        $this->template .= html_writer::end_tag('div'); // .comment-message-meta
        $this->template .= html_writer::tag('div', '___content___', array('class' => 'text'));

        $this->template .= html_writer::end_tag('div'); // .comment-message

        if (!empty($this->plugintype)) {
            $this->template = plugin_callback($this->plugintype, $this->pluginname, 'comment', 'template', array($this->comment_param), $this->template);
        }

    }


    /**
     * Initialises the JavaScript that enchances the comment API.
     *
     * @param moodle_page $page The moodle page object that the JavaScript should be
     *                          initialised for.
     */
    public function initialise_javascript(moodle_page $page) {

        $options = new stdClass;
        $options->client_id   = $this->cid;
        $options->commentarea = $this->commentarea;
        $options->itemid      = $this->itemid;
        $options->page        = 0;
        $options->courseid    = $this->courseid;
        $options->contextid   = $this->contextid;
        $options->component   = $this->component;
        $options->component   = 'block_orange_comments';
        $options->notoggle    = $this->notoggle;
        $options->autostart   = $this->autostart;

        $jsmodule = array('name' => 'block_orange_comment',
                        'fullpath' => '/blocks/orange_comments/module.js',
                        'requires' => array('base', 'io-base', 'node', 'json', 'yui2-animation', 'overlay'),
                        'strings' => array(array('confirmdeletecomments', 'admin'), array('yes', 'moodle'), array('no', 'moodle')));

        $page->requires->js_init_call('M.block_orange_comment.init', array($options), true, $jsmodule);
        return true;
    }


    /**
     * Prepare comment code in html
     * @param  boolean $return
     * @return string|void
     */
    public function output($return = true) {
        global $PAGE, $OUTPUT;
        static $template_printed;

        $this->initialise_javascript($PAGE);

        if (!empty(self::$nonjs)) {
            // return non js comments interface
            return $this->print_comments(self::$comment_page, $return, true);
        }

        $html = '';

        // print html template
        // Javascript will use the template to render new comments
        if (empty($template_printed) && $this->can_view()) {
            $html .= html_writer::tag('div', $this->template, array('style' => 'display:none', 'id' => 'cmt-tmpl'));
            $template_printed = true;
        }

        if ($this->can_view()) {
            // print commenting icon and tooltip
            $html .= html_writer::start_tag('div', array('class' => 'mdl-left'));
            $html .= html_writer::link($this->get_nojslink($PAGE), get_string('showcommentsnonjs'), array('class' => 'showcommentsnonjs'));

            if ($this->can_post()) {

                if (!$this->notoggle) {
                    // If toggling is enabled (notoggle=false) then print the controls to toggle
                    // comments open and closed
                    $countstring = '';
                    if ($this->displaytotalcount) {
                        $countstring = '('.$this->count().')';
                    }
                    $collapsedimage = 't/collapsed';
                    if (right_to_left()) {
                        $collapsedimage = 't/collapsed_rtl';
                    } else {
                        $collapsedimage = 't/collapsed';
                    }
                    $html .= html_writer::start_tag('a', array('class' => 'comment-link', 'id' => 'comment-link-'.$this->cid, 'href' => '#'));
                    $html .= html_writer::empty_tag('img', array('id' => 'comment-img-'.$this->cid, 'src' => $OUTPUT->pix_url($collapsedimage), 'alt' => $this->linktext, 'title' => $this->linktext));
                    $html .= html_writer::tag('span', $this->linktext.' '.$countstring, array('id' => 'comment-link-text-'.$this->cid));
                    $html .= html_writer::end_tag('a');
                }

                $html .= html_writer::start_tag('div', array('id' => 'comment-ctrl-'.$this->cid, 'class' => 'comment-ctrl', 'style' => 'display:block'));

                // print posting textarea
                $textareaattrs = array(
                        'name' => 'content',
                        'rows' => 2,
                        'id' => 'dlg-content-'.$this->cid
                );
                if (!$this->fullwidth) {
                    $textareaattrs['cols'] = '20';
                } else {
                    $textareaattrs['class'] = 'fullwidth';
                }

                $html .= html_writer::start_tag('div', array('class' => 'comment-area'));

                $html .= html_writer::start_tag('div', array('class' => 'db'));
                $html .= html_writer::tag('textarea', '', $textareaattrs);
                $html .= html_writer::end_tag('div'); // .db

                $html .= html_writer::start_tag('div', array('class' => 'fd', 'id' => 'comment-action-'.$this->cid));
                $html .= html_writer::link('#', get_string('savecomment'), array('id' => 'comment-action-post-'.$this->cid));

                if ($this->displaycancel) {
                    $html .= html_writer::tag('span', ' | ');
                    $html .= html_writer::link('#', get_string('cancel'), array('id' => 'comment-action-cancel-'.$this->cid));
                }

                $html .= html_writer::end_tag('div'); // .fd

                $html .= html_writer::end_tag('div'); // .comment-area
                $html .= html_writer::tag('div', '', array('class' => 'clearer'));

                $html .= html_writer::end_tag('div'); // .comment-ctrl

            }

            if ($this->autostart) {
                $html .= "<br>";
                // If autostart has been enabled print the comments list immediatly
                $html .= html_writer::start_tag('ul', array('id' => 'comment-list-'.$this->cid, 'class' => 'comment-list comments-loaded'));
                $html .= html_writer::tag('li', '', array('class' => 'first'));
                $html .= $this->print_comments(0, true, false);
                $html .= html_writer::end_tag('ul'); // .comment-list
                $html .= $this->get_pagination(0);
            } else {
                $html .= html_writer::start_tag('ul', array('id' => 'comment-list-'.$this->cid, 'class' => 'comment-list'));
                $html .= html_writer::tag('li', '', array('class' => 'first'));
                $html .= html_writer::end_tag('ul'); // .comment-list
                $html .= html_writer::tag('div', '', array('id' => 'comment-pagination-'.$this->cid, 'class' => 'comment-pagination'));
            }

            $html .= html_writer::end_tag('div'); // .mdl-left
        } else {
            $html = '';
        }

        if ($return) {
            return $html;
        } else {
            echo $html;
        }
    }

    /**
     * Return matched comments
     *
     * @param  int $page
     * @return array
     */
    public function get_comments($page = '') {
        global $DB, $CFG, $USER, $OUTPUT;
        if (!$this->can_view()) {
            return false;
        }
        if (!is_numeric($page)) {
            $page = 0;
        }

        $params = array();
        $perpage = (!empty($CFG->commentsperpage)) ? $CFG->commentsperpage : 15;
        $start = $page * $perpage;

        if ($page == 2) {
            $perpage = 0;
            $start = 0;
        }

        $ufields = user_picture::fields('u');
        $sql = "SELECT $ufields, c.id AS cid, c.content AS ccontent, c.format AS cformat, c.timecreated AS ctimecreated
        FROM {comments} c
        JOIN {user} u ON u.id = c.userid
        WHERE c.contextid = :contextid AND c.commentarea = :commentarea AND c.itemid = :itemid
        ORDER BY c.timecreated DESC";
        $params['contextid'] = $this->contextid;
        $params['commentarea'] = $this->commentarea;
        $params['itemid'] = $this->itemid;

        $comments = array();
        $formatoptions = array('overflowdiv' => true);
        $rs = $DB->get_recordset_sql($sql, $params, $start, $perpage);
        foreach ($rs as $u) {
            $c = new stdClass();
            $c->id          = $u->cid;
            $c->content     = $u->ccontent;
            $c->format      = $u->cformat;
            $c->timecreated = $u->ctimecreated;
            $c->strftimeformat = get_string('strftimerecentfull', 'langconfig');
            $url = new moodle_url('/user/view.php', array('id' => $u->id, 'course' => $this->courseid));
            $c->profileurl = $url->out(false); // URL should not be escaped just yet.
            $c->fullname = fullname($u);
            $c->time = userdate($c->timecreated, $c->strftimeformat);
            $c->content = format_text($c->content, $c->format, $formatoptions);
            $c->avatar = $OUTPUT->user_picture($u, array('size' => 18));
            $c->userid = $u->id;

            $candelete = $this->can_delete($c->id);
            if (($USER->id == $u->id) || !empty($candelete)) {
                $c->delete = true;
            }
            $comments[] = $c;
        }
        $rs->close();

        if (!empty($this->plugintype)) {
            // moodle module will filter comments
            $comments = plugin_callback($this->plugintype, $this->pluginname, 'comment', 'display', array($comments, $this->comment_param), $comments);
        }

        return $comments;
    }

    /**
     * check posting comments permission
     * It will check based on user roles and ask modules
     * If you need to check permission by modules, a
     * function named $pluginname_check_comment_post must be implemented
     */

    private function check_permissions() {
        $this->postcap = has_capability('moodle/comment:post', $this->context);
        $this->viewcap = has_capability('moodle/comment:view', $this->context);

        if (!empty($this->plugintype)) {
            $permissions = plugin_callback($this->plugintype, $this->pluginname, 'comment', 'permissions', array($this->comment_param), array('post' => false, 'view' => false));
            $this->postcap = $this->postcap && $permissions['post'];
            $this->viewcap = $this->viewcap && $permissions['view'];
        }

    }


    /**
     * Gets a link for this page that will work with JS disabled.
     *
     * @global moodle_page $PAGE
     * @param moodle_page $page
     * @return moodle_url
     */
    public function get_nojslink(moodle_page $page = null) {
        if ($page === null) {
            global $PAGE;
            $page = $PAGE;
        }

        $link = new moodle_url($page->url, array(
                'nonjscomment'    => true,
                'comment_itemid'  => $this->itemid,
                'comment_context' => $this->context->id,
                'comment_area'    => $this->commentarea,
        ));
        $link->remove_params(array('comment_page'));
        return $link;

    }

    /**
     * Returns true if the user can add comments against this comment description
     * @return bool
     */
    public function can_post() {
        $this->validate();
        return isloggedin() && !empty($this->postcap);
    }

    /**
     * Print comments
     *
     * @param int $page
     * @param bool $return return comments list string or print it out
     * @param bool $nonjs print nonjs comments list or not?
     * @return string|void
     */
    public function print_comments($page = 0, $return = true, $nonjs = true) {
        global $DB, $CFG, $PAGE;

        if (!$this->can_view()) {
            return '';
        }

        $html = '';
        if (!($this->itemid == null && $this->context->id == null && $this->commentarea == null)) {
            $page = 0;
        }
        $comments = $this->get_comments($page);

        $html = '';
        if ($nonjs) {
            $html .= html_writer::tag('h3', get_string('comments'));
            $html .= html_writer::start_tag('ul', array('id' => 'comment-list-'.$this->cid, 'class' => 'comment-list'));
        }
        // Display comment : last comment in first position
        foreach ($comments as $cmt) {
            $html .= html_writer::tag('li', $this->print_comment($cmt, $nonjs), array('id' => 'comment-'.$cmt->id.'-'.$this->cid));
        }
        if ($nonjs) {
            $html .= html_writer::end_tag('ul');
            $html .= $this->get_pagination($page);
        }
        if ($nonjs && $this->can_post()) {
            // Form to add comments
            $html .= html_writer::start_tag('form', array('method' => 'post', 'action' => new moodle_url('/comment/comment_post.php')));
            // Comment parameters
            $html .= html_writer::empty_tag('input', array('type' => 'hidden', 'name' => 'contextid', 'value' => $this->contextid));
            $html .= html_writer::empty_tag('input', array('type' => 'hidden', 'name' => 'action',    'value' => 'add'));
            $html .= html_writer::empty_tag('input', array('type' => 'hidden', 'name' => 'area',      'value' => $this->commentarea));
            $html .= html_writer::empty_tag('input', array('type' => 'hidden', 'name' => 'component', 'value' => $this->component));
            $html .= html_writer::empty_tag('input', array('type' => 'hidden', 'name' => 'itemid',    'value' => $this->itemid));
            $html .= html_writer::empty_tag('input', array('type' => 'hidden', 'name' => 'courseid',  'value' => $this->courseid));
            $html .= html_writer::empty_tag('input', array('type' => 'hidden', 'name' => 'sesskey',   'value' => sesskey()));
            $html .= html_writer::empty_tag('input', array('type' => 'hidden', 'name' => 'returnurl', 'value' => $PAGE->url));
            // Textarea for the actual comment
            $html .= html_writer::tag('textarea', '', array('name' => 'content', 'rows' => 2));
            // Submit button to add the comment
            $html .= html_writer::empty_tag('input', array('type' => 'submit', 'value' => get_string('submit')));
            $html .= html_writer::end_tag('form');
        }
        if ($return) {
            return $html;
        } else {
            echo $html;
        }
    }
    /**
     * Returns true if the user can delete this comment
     * @param int $commentid
     * @return bool
     */
    public function can_delete($commentid) {
        $this->validate(array('commentid' => $commentid));
        return has_capability('moodle/comment:delete', $this->context);
    }
    /**
     * Returns the number of comments associated with the details of this object
     *
     * @global moodle_database $DB
     * @return int
     */
    public function count() {
        global $DB;
        if ($this->totalcommentcount === null) {
            $this->totalcommentcount = $DB->count_records('comments', array('itemid' => $this->itemid, 'commentarea' => $this->commentarea, 'contextid' => $this->context->id));
        }
        return $this->totalcommentcount;
    }


    /**
     * Returns an array containing comments in HTML format.
     *
     * @global core_renderer $OUTPUT
     * @param stdClass $cmt {
     *          id => int comment id
     *          content => string comment content
     *          format  => int comment text format
     *          timecreated => int comment's timecreated
     *          profileurl  => string link to user profile
     *          fullname    => comment author's full name
     *          avatar      => string user's avatar
     *          delete      => boolean does user have permission to delete comment?
     * }
     * @param bool $nonjs
     * @return array
     */
    public function print_comment($cmt, $nonjs = true) {
        global $OUTPUT;
        $patterns = array();
        $replacements = array();

        if (!empty($cmt->delete) && empty($nonjs)) {
            $deletelink  = html_writer::start_tag('div', array('class' => 'comment-delete'));
            $deletelink .= html_writer::start_tag('a', array('href' => '#', 'id' => 'comment-delete-'.$this->cid.'-'.$cmt->id));
            $deletelink .= $OUTPUT->pix_icon('t/delete', get_string('delete'));
            $deletelink .= html_writer::end_tag('a');
            $deletelink .= html_writer::end_tag('div');
            $cmt->content = $deletelink . $cmt->content;
        }
        $patterns[] = '___picture___';
        $patterns[] = '___name___';
        $patterns[] = '___content___';
        $patterns[] = '___time___';
        $replacements[] = $cmt->avatar;
        $replacements[] = html_writer::link($cmt->profileurl, $cmt->fullname);
        $replacements[] = $cmt->content;
        $replacements[] = $cmt->time;

        // use html template to format a single comment.
        return str_replace($patterns, $replacements, $this->template);
    }

    /**
     * Returns HTML to display a pagination bar
     *
     * @global stdClass $CFG
     * @global core_renderer $OUTPUT
     * @param int $page
     * @return string
     */
    public function get_pagination($page = 0) {
        global $CFG, $OUTPUT;
        $count = $this->count();
        $perpage = (!empty($CFG->commentsperpage)) ? $CFG->commentsperpage : 15;
        $pages = (int)ceil($count / $perpage);
        if ($pages == 1 || $pages == 0) {
            return html_writer::tag('div', '', array('id' => 'comment-pagination-'.$this->cid, 'class' => 'comment-pagination'));
        }
        if (!empty(self::$nonjs)) {
            // used in non-js interface
            return $OUTPUT->paging_bar($count, $page, $perpage, $this->get_nojslink(), 'comment_page');
        } else {
            // return ajax paging bar
            $str = '';
            $str .= '<div class="comment-paging" id="comment-pagination-'.$this->cid.'">';
            for ($p = 0; $p < $pages; $p++) {
                if ($p == $page) {
                    $class = 'curpage';
                } else {
                    $class = 'pageno';
                }
                $str .= '<a href="#" class="'.$class.'" id="comment-page-' . $this->cid . '-'.$p.'">'.($p + 1).'</a> ';
            }
            $str .= '</div>';
        }
        return $str;
    }
}
