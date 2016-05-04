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
 * @package    orange_library
 * @copyright  2015 Orange
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
function xmldb_local_orange_library_upgrade($oldversion) {
    global $DB;
    $dbman = $DB->get_manager();

    if ($oldversion < 2016041400) {

        // Define table last_page_viewed to be created.
        $table = new xmldb_table('last_page_viewed');

        // Adding fields to table.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('userid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('courseid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('pageid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('time', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);

        // Adding keys to table.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));

        // Adding indexes to table.
        $table->add_index('usercourse', XMLDB_INDEX_UNIQUE, array('userid', 'courseid'));

        // Conditionally launch create table.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Local savepoint reached.
        upgrade_plugin_savepoint(true, 2016041400, 'local', 'orange_library');
    }

    if ($oldversion < 2016042701) {
        // Define table thematic_info to be created.
        $table = new xmldb_table('thematic_info');

        // Adding fields to table.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('hostid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('available', XMLDB_TYPE_INTEGER, '1', null, XMLDB_NOTNULL, null, null);
        $table->add_field('nbmooc', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('nbinprogressmooc', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('nbfuturemooc', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('nbuser', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('nbconnected', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('illustration', XMLDB_TYPE_CHAR, '255', null, XMLDB_NOTNULL, null, null);
        $table->add_field('logo', XMLDB_TYPE_CHAR, '255', null, XMLDB_NOTNULL, null, null);
        $table->add_field('timeupdated', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);

        // Adding keys to table.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));

        // Adding indexes to table.
        $table->add_index('hostid', XMLDB_INDEX_UNIQUE, array('hostid'));

        // Conditionally launch create table.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Local savepoint reached.
        upgrade_plugin_savepoint(true, 2016042701, 'local', 'orange_library');
    }

    if ($oldversion < 2016050300) {
        // Define table thematic_info to be upgraded.
        $table = new xmldb_table('thematic_info');

        // Adding fields to table.
        $field = new xmldb_field('nbpost', XMLDB_TYPE_INTEGER, '10', null, null, null, null);

        // Conditionally launch add field referencefileid.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Local savepoint reached.
        upgrade_plugin_savepoint(true, 2016050300, 'local', 'orange_library');
    }

    return true;
}