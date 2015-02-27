<?php  //$Id: upgrade.php,v 1.7 2011-09-28 23:06:12 vf Exp $

// This file keeps track of upgrades to 
// the customlabel module
//
// Sometimes, changes between versions involve
// alterations to database structures and other
// major things that may break installations.
//
// The upgrade function in this file will attempt
// to perform all the necessary actions to upgrade
// your older installtion to the current version.
//
// If there's something it cannot do itself, it
// will tell you what you need to do.
//
// The commands in here will all be database-neutral,
// using the functions defined in lib/ddllib.php

function xmldb_customlabel_upgrade($oldversion=0) {

    global $CFG, $THEME, $DB;

    $result = true;

	$dbman = $DB->get_manager();

//===== 1.9.0 upgrade line ======//

    if ($result && $oldversion < 2012062401) {
    
    /// Define field fallbacktype to be added to customlabel
        $table = new xmldb_table('customlabel');
        $field = new xmldb_field('fallbacktype');
        $field->set_attributes(XMLDB_TYPE_CHAR, '32', null, null, null, null, 'labelclass');

    /// Launch add field parent
        $result = $result || $dbman->add_field($table, $field);

        /// customlabel savepoint reached
        upgrade_mod_savepoint($result, 2012062401, 'customlabel');
    }

    return $result;
}

