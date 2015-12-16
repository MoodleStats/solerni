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
 * Version details
 *
 * @package    local_orange_event_course_created
 * @copyright  2015 Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

  
/**
 * Event observer for block orange_ruels.
 */
class local_orange_event_course_created_observer {

  
    /**
     * Triggered via course_viewed event.
     *
     * @param \core\event\course_viewed $event
     */

    public static function course_created(\core\event\course_created  $event) {
        global $CFG;
        
        if ($event->courseid != 1) {
            
            // $course = get_record('course','id', $event->courseid);
            // error_log($course->fullname);
            require_once($CFG->dirroot.'/config.php');
            $url = $CFG->piwik_internal_url;
            // error_log($url);
            //$url = 'http::81/piwik/?';
            $module = 'module=API';
            $method = '&method=UsersManager.addUser';
            $user = '&userLogin=Nouto72159';
            $password = '&password=totototo';
            $email = '&email=azertyfdvbtyby@gmail.com';
            $token_auth = '&token_auth=54a685f1bb79eb195d431d6f55118dd7'; 
            $url =$url.'?'.$module.$method.$user.$password.$email.$token_auth;
         
            
           
            
                    
            // we call the REST API in order to create a account piwik
            // $fetched = file_get_contents($url);
            // $ch = curl_init($url);
            

            $ch = curl_init();
            $timeout = 5;
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
            $data = curl_exec($ch);
            // print_r($data);
          
            curl_close($ch);
            print_object($data);
            die('mofo');
}
           
           
            //$result_Piwik = new SimpleXMLElement($ret);
            //error_log ("result_Piwik=".var_dump($result_Piwik));
            //error_log ("result_Piwik->error=".var_dump($result_Piwik->error));
            //error_log ($result_Piwik->['error message']);
           
            //curl_close($ch);
            // case error
            
            
        // }
        

        return true;
    }
}


