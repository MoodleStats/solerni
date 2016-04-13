<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function xmldb_local_orange_event_course_created_install() {
global $DB;

   
 $site = new stdClass();
 $site->piwik_siteid = 1;
 $site->courseid = 1;
 $DB->insert_record('piwik_site', $site);
}
