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
 * The comments block helper functions and callbacks
 *
 * @package    block_orange_comments
 * @copyright  2015 Orange based on block_comments plugin from 1999 onwards Martin Dougiamas (http://dougiamas.com)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Validate comment parameter before perform other comments actions
 *
 * @package  block_orange_comments
 * @category comment
 *
 * @param stdClass $comment_param {
 *              context  => context the context object
 *              courseid => int course id
 *              cm       => stdClass course module object
 *              commentarea => string comment area
 *              itemid      => int itemid
 * }
 * @return boolean
 */
function block_orange_comments_comment_validate($commentparam) {

    if ($commentparam->commentarea != 'page_comments') {
        throw new comment_exception('invalidcommentarea');
    }

    if ($commentparam->itemid == 0) {
        throw new comment_exception('invalidcommentitemid');
    }
    return true;
}

/**
 * Running addtional permission check on plugins
 *
 * @package  block_orange_comments
 * @category comment
 *
 * @param stdClass $args
 * @return array
 */
function block_orange_comments_comment_permissions($args) {
    return array('post' => true, 'view' => true);
}

/**
 * Validate comment data before displaying comments
 *
 * @package  block_orange_comments
 * @category comment
 *
 * @param stdClass $comment
 * @param stdClass $args
 * @return boolean
 */
function block_orange_comments_comment_display($comments, $args) {

    if ($args->commentarea != 'page_comments') {
        throw new comment_exception('invalidcommentarea');
    }

    if ($args->itemid == 0) {
        throw new comment_exception('invalidcommentitemid');
    }

    return $comments;
}

