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
 * Strings for component 'subcourse', language 'fr', branch 'MOODLE_29_STABLE'
 *
 * @package   subcourse
 * @copyright 1999 onwards Martin Dougiamas  {@link http://moodle.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['currentgrade'] = 'Votre note actuelle : {$a}';
$string['errfetch'] = 'Impossible de récupérer les notes: code d\'erreur {$a}';
$string['eventgradesfetched'] = 'Notes récupérés';
$string['fetchnow'] = 'Récupérer maintenant';
$string['gotocoursename'] = 'Aller vers le cours <a href="{$a->href}">{$a->name}</a>';
$string['hiddencourse'] = '*caché*';
$string['instantredirect'] = 'Rediriger vers le cours lié';
$string['instantredirect_help'] = 'Si activé, les utilisateurs seront redirigés vers le cours lié quand ils essayeront d\'accéder à l\'activité subcourse. Cela n\'a pas d\'effet sur les utilisateurs qui ont la permission de récupérer les notes manuellement.';
$string['lastfetchnever'] = 'Les notes n\'ont pas encore été récupérées';
$string['lastfetchtime'] = 'Dernière synchronisation :{$a}';
$string['modulename_help'] = 'Cette activité propose des fonctionnalités très simples mais intéressantes. Quand ajoutée dans un cours, elle se comporte comme une activité évaluée. La note pour chaque étudiant est prise dans la note final d\'un autre cours. Associé aux métacours, cela permet aux enseignants d\'organiser leur enseignement dans des cours séparés.';
$string['nocoursesavailable'] = 'Aucun cours avec des notes à récupérer';
$string['nosubcourses'] = 'Il n\'y a pas de sous-cours dans ce cours';
$string['pluginadministration'] = 'Administration de subcourse';
$string['refcourse'] = 'Cours lié';
$string['refcoursecurrent'] = 'Garder le lien courant';
$string['refcourse_help'] = 'La note de l\'activité est celle du cours lié. Les étudiants devraient être inscrits dans le cours lié. Vous devez être un enseignant dans ce cours pour le voir listé ici. Vous  pouvez demander à un administrateur de paramétrer cette activité pour les autres cours.';
$string['refcourselabel'] = 'Récupérer les notes de';
$string['refcoursenull'] = 'Aucun cours lié configuré';
$string['subcourse:addinstance'] = 'Ajouter une nouvelle activité subcourse';
$string['subcourse:begraded'] = 'Récupérer la note du cours lié';
$string['subcourse:fetchgrades'] = 'Récupérer les notes manuellement du cours cours lié';
$string['subcoursename'] = 'Nom de l\'activité';
$string['taskfetchgrades'] = 'Récupérer les notes du cours lié';
