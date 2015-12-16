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
 * @package    orange_mail
 * @copyright  2015 Orange
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();

use theme_halloween\settings\options;
use theme_halloween\tools\theme_utilities;


class mail_object {

    /**
     * Get the badges for a course
     * @return array $usedbadges
     */
    public static function get_mail($content, $mailtype, $footertype) {
        global $CFG, $USER;
        $imageurl = new moodle_url('/local/orange_mail/pix/mail/');

        $site  = get_site();

        $config = get_config('local_orangemail');

        $b = new stdClass();
        $b->imageurl = $imageurl->out();
        $b->sitename = format_string($site->fullname);
        $b->siteurl = $CFG->wwwroot;
        $b->catalogurl = $CFG->wwwroot;
        $b->profilurl = $CFG->wwwroot."user/profile.php";

        $b->solernimailsignature = get_string('solernimailsignature', 'local_orange_mail');
        $b->solernimailsignaturetext = get_string('solernimailsignaturetext', 'local_orange_mail');
        $b->solernimailfootertext = get_string('solernimailfootertext', 'local_orange_mail');
        $b->solernimailfooterhtml = get_string('solernimailfooterhtml', 'local_orange_mail');
        $b->solernimailfooterinscriptiontext = get_string('solernimailfooterinscriptiontext', 'local_orange_mail');
        $b->solernimailfooterinscriptionhtml = get_string('solernimailfooterinscriptionhtml', 'local_orange_mail');
        
        $config->contactemail ? $b->contactemail = $config->contactemail : $b->contactemail = "contact@solerni.com";
        $config->noreplyemail ? $b->noreplyemail = $config->noreplyemail : $b->noreplyemail = "noreply@solerni.com";
        
        // get follow us links
        foreach(options::halloween_get_followus_urllist() as $key => $value) {
            if (theme_utilities::is_theme_settings_exists_and_nonempty($key)) {
                $b->$key = $value;
            }
        }

        if ($mailtype == "html")
        {
            $output = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'. PHP_EOL .
                    '<html xmlns="http://www.w3.org/1999/xhtml">' . PHP_EOL .
                    '<head>' . PHP_EOL .
                    '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />' . PHP_EOL .
                    '<title>' . $site->fullname . '</title>' . PHP_EOL;
            if (isset($config->css)) $output .= $config->css . PHP_EOL;
            $output .= '</head>' . PHP_EOL . 
                        '<body>' . PHP_EOL . 
                        '<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">' . PHP_EOL;
            $output .= self::get_string($config->header, $b) . PHP_EOL;
            $output .= self::get_string($content, $b) . PHP_EOL;
            $output .= self::get_string($config->signature, $b) . PHP_EOL;
            $output .= self::get_string($config->followus, $b) . PHP_EOL;
            $output .= self::get_string($config->{'footer' . $footertype}, $b) . PHP_EOL;
            $output .= '</table>' . PHP_EOL . '</body>' . PHP_EOL . '</html>';
        } else {
            $output = "";
            $output .= self::get_string($config->headertext, $b) . PHP_EOL;
            $output .= self::get_string($content, $b) . PHP_EOL;
            $output .= self::get_string($config->signaturetext, $b) . PHP_EOL;
            $output .= self::get_string($config->followustext, $b) . PHP_EOL;
            $output .= self::get_string($config->{'footer'.$footertype.'text'}, $b) . PHP_EOL;
        }
        return $output;
    }

    
  
    public static function get_string($string, $b = null) {
        if ($b !== null) {
            // Process array's and objects (except lang_strings).
            if (is_array($b) or (is_object($b))) {
                $b = (array)$b;
                $search = array();
                $replace = array();
                foreach ($b as $key => $value) {
                    if (is_int($key)) {
                        // We do not support numeric keys - sorry!
                        continue;
                    }
                    if (is_array($value) or (is_object($value) && !($value instanceof lang_string))) {
                        // We support just string or lang_string as value.
                        continue;
                    }
                    $search[]  = '{$b->'.$key.'}';
                    $replace[] = (string)$value;
                }
                if ($search) {
                    $string = str_replace($search, $replace, $string);
                    // Call it twice in case a replace string contains a {$b}
                    $string = str_replace($search, $replace, $string);
                }
            } else {
                $string = str_replace('{$b}', (string)$b, $string);
            }
        }
        return $string;
    }
    
    static public function generate ($stringid, $mailtype, $footertype='') {
        
        $currentlang = current_language();
        
        $langs = get_string_manager()->get_list_of_translations();
        foreach ($langs as $lang => $value) {
            force_current_language($lang);
            $string = get_string($stringid, 'local_orange_mail');
            $string = self::get_mail($string, $mailtype, $footertype);
            set_config('mail_'.$stringid.'_'.$lang.'_'. $mailtype, $string, 'local_orangemail');
        }
        force_current_language($currentlang);
    }
    
}