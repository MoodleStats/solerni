<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function xmldb_local_orange_event_course_created_upgrade($oldversion) {
    global $DB;
    $dbman = $DB->get_manager();

                        
            if ($oldversion < 2016032420) {

        // Define table piwik_site to be created.
        $table = new xmldb_table('piwik_site');

        // Adding fields to table piwik_site.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('piwik_siteid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('courseid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);

        // Adding keys to table piwik_site.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));

        // Adding indexes to table piwik_site.
        $table->add_index('piwik_siteid', XMLDB_INDEX_UNIQUE, array('piwik_siteid'));
        $table->add_index('courseid', XMLDB_INDEX_UNIQUE, array('courseid'));

        // Conditionally launch create table for piwik_site.
            if (!$dbman->table_exists($table)) {
        $dbman->create_table($table);
            }

        // Local savepoint reached.
        upgrade_plugin_savepoint(true, 2016032420, 'local', 'orange_event_course_created');
        require_once('install.php');
        xmldb_local_orange_event_course_created_install();
         
            }
                                     
    return true;
}

  
