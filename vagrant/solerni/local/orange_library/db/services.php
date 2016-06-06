<?php
// This file is part of The Orange Library Plugin
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
 * Web services declaration
 *
 * @package     local
 * @subpackage  orange_library
 * @copyright  2016 Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$functions = array(
    'local_orange_library_get_resac_hosts' => array(
        'classname'     => 'local_orange_library_external',
        'methodname'    => 'get_resac_hosts',
        'classpath'     => 'local/orange_library/externallib.php',
        'description'   => 'Allows to get the resac navigation from MNET HOME to external hosts',
        'type'          => 'read'
    ),
    'local_orange_library_get_profile_fields' => array(
        'classname'     => 'local_orange_library_external',
        'methodname'    => 'get_profile_fields',
        'classpath'     => 'local/orange_library/externallib.php',
        'description'   => 'Allows to get the profile fields of a user from MNET HOME',
        'type'          => 'read'
    ),
    'local_orange_library_get_thematic_info' => array(
        'classname'     => 'local_orange_library_external',
        'methodname'    => 'get_thematic_info',
        'classpath'     => 'local/orange_library/externallib.php',
        'description'   => 'Allows to get informations form from MNET Thematic',
        'type'          => 'read'
    ),
    'local_orange_library_del_user_on_thematic' => array(
        'classname'     => 'local_orange_library_external',
        'methodname'    => 'del_user_on_thematic',
        'classpath'     => 'local/orange_library/externallib.php',
        'description'   => 'Allows to delete a user from MNET Home to MNET Thematic',
        'type'          => 'write'
    ),
    'local_orange_library_update_user_on_thematic' => array(
        'classname'     => 'local_orange_library_external',
        'methodname'    => 'update_user_on_thematic',
        'classpath'     => 'local/orange_library/externallib.php',
        'description'   => 'Allows to update a user from MNET Home to MNET Thematic',
        'type'          => 'write'
    )
);

$services = array(
    'MNET RESAC' => array(
            'functions'         => array('local_orange_library_get_resac_hosts',
                'local_orange_library_get_profile_fields',
                'local_orange_library_get_thematic_info',
                'local_orange_library_del_user_on_thematic',
                'local_orange_library_update_user_on_thematic'),
            'restricted_users'  => 0,
            'enabled'           => 1
    )
);
