<?php
// This file is part of Google Oauth2 authentication plugin
//
// Google Oauth2 authentication plugin is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Google Oauth2 authentication plugin is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Google Oauth2 authentication plugin.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Google Oauth2 authentication plugin upgrade code
 *
 * @package    auth_googleoauth2
 * @copyright  2014 Jerome Mouneyrac
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * @param int $oldversion the version we are upgrading from
 * @return bool result
 */
function xmldb_auth_googleoauth2_upgrade($oldversion) {

    if ($oldversion < 2014060700) {
        set_config('oauth2displaybuttons', 0, 'auth/googleoauth2');
        upgrade_plugin_savepoint(true, 2014060700, 'auth', 'googleoauth2');
    }

    return true;
}
