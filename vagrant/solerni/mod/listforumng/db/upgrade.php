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
 * Listforumng database upgrade script.
 * @package mod
 * @subpackage listforumng
 * @copyright  2015 Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

function xmldb_listforumng_upgrade($oldversion=0) {
    global $CFG, $THEME, $DB;

    $dbman = $DB->get_manager();

    if ($oldversion < 2015090803) {
        // Define field parent to be added to listforumng.
        $table = new xmldb_table('listforumng');
        $field = new xmldb_field('parent', XMLDB_TYPE_INTEGER, '1', null, XMLDB_NOTNULL, null, '0', 'introformat');

        // Launch add field canpostanon.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Define table listforumng_forumng to be created.
        $table = new xmldb_table('listforumng_forumng');

        // Adding fields to table forumng_read_posts.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('listforumngid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('forumngid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);

        // Adding keys to table forumng_read_posts.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));
        $table->add_key('listforumngid', XMLDB_KEY_FOREIGN, array('listforumngid'), 'listforumng', array('id'));
        $table->add_key('forumngid', XMLDB_KEY_FOREIGN, array('forumngid'), 'forumng', array('id'));

        // Adding indexes to table forumng_read_posts.
        $table->add_index('listforumngid-forumngid', XMLDB_INDEX_UNIQUE, array('listforumngid', 'forumngid'));

        // Conditionally launch create table for forumng_read_posts.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Listforumng savepoint reached.
        upgrade_mod_savepoint(true, 2015090803, 'listforumng');
    }

    return true;
}
    