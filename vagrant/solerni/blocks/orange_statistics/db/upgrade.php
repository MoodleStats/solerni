<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function xmldb_block_orange_statistics_upgrade($oldversion) {
    global $DB;
    $dbman = $DB->get_manager();

                        
        if ($oldversion < 2016060802) {

            // Define table user_dropout to be created.
             $table = new xmldb_table('user_dropout');

            // Adding fields to table user_dropout.
            $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
            $table->add_field('userid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
            $table->add_field('courseid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);

            // Adding keys to table user_dropout.
            $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));

            // Adding indexes to table user_dropout.
            $table->add_index('userid', XMLDB_INDEX_UNIQUE, array('userid'));
            $table->add_index('courseid', XMLDB_INDEX_UNIQUE, array('courseid'));

            // Conditionally launch create table for user_dropout.
            if (!$dbman->table_exists($table)) {
                $dbman->create_table($table);
            }
         
        }
                                     
    return true;
}

  
