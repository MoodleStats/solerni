<?php
// This file is part of The Orange Halloween Moodle Theme
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

namespace theme_halloween\tools;

class theme_utilities {

    /**
     * Check if a theme setting exists and if it has a value.
     * We could ask for a unique setting or an array of settings,
     * with a option to check if all settings needs to be true,
     * or at least one.
     *
     * @param array or string $settings : setting name or array of settings names
     * @param string $option : 'atleastone' or 'all' values
     */
    public static function is_theme_settings_exists_and_nonempty($settings, $option = null) {
        if (is_string($settings)) {
            return self::try_catch_theme_setting($settings);
        }

        if (is_array($settings) && $option === 'all') {
            foreach ($settings as $setting) {
                if (!self::try_catch_theme_setting($setting)) {
                    return false;
                }
            }
            return true;
        }

        if (is_array($settings) && $option === 'atleastone') {
            foreach ($settings as $setting) {
                if (self::try_catch_theme_setting($setting)) {
                    return true;
                }
            }
            return false;
        }

        return false;
    }

    private static function try_catch_theme_setting($setting) {
        global $PAGE;
        try {
            $PAGE->theme->settings->$setting;
            return ($PAGE->theme->settings->$setting) ? true : false;
        } catch (\moodle_exception $ex) {
            debugging("Theme setting does not exists " . $ex->getMessage() . $ex->debuginfo, DEBUG_DEVELOPER);
        }
        return false;
    }
}
