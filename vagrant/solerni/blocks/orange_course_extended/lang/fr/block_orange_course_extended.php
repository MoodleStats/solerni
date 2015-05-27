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
 * @package    blocks
 * @subpackage course_extended
 * @copyright  2015 Orange
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();


$string['orange_course_extended:addinstance'] = 'Ajout d\'un nouveau bloc données étendues du cours';
$string['orange_course_extended:myaddinstance'] = 'Ajout d\'un nouveau bloc données étendues du cours à la page Mon Moodle';
$string['course_extended'] = 'Contenus du bloc données étendues du cours';
$string['defaulttitle'] = 'Contenus';

$string['headerconfig'] = 'configuration de l\'entete';
$string['descconfig'] = 'configuration de la description';
$string['labelallowhtml'] = 'html autorisé pour le label';
$string['descallowhtml'] = 'html autorisé pour la description';
$string['descallow'] = 'descallow';
$string['title'] = 'Données de cours étendues';
$string['current'] = 'courant';
$string['startingsoon'] = 'va bientôt commencer';
$string['closed'] = 'clos';
$string['picture'] = 'image';
$string['true'] = 'true';
$string['false'] = 'false';
$string['in_four_weeks'] = 'inférieur à 4 semaines';
$string['four_six_weeks'] = '4 à 6 semaines';
$string['sup_six_weeks'] = 'supérieur à 6 semaines';

$string['inserterror'] = 'erreur inscérée';

$string['notinserterror'] = 'pas d\'erreur inscérée';

$string['invalidcourse'] = 'Cours invalide';
$string['addpage'] = 'ajout d\'une page';
$string['editpage'] = 'edition d\'une page';
$string['course_extended_settings'] = 'configuration';

$string['maxvisibility'] = 'Visibilité';
$string['maxvisibility_help'] = '
<p><strong>Visible seulement pour le propriétaire de la page (privé)</strong> &ndash;
personne ne pourra voir cette page.</p>
<p><<strong>Visible aux participants à ce cours</strong> &ndash; Pour voir cette page vous devez avoir les droits nécessaires pour accéder à ce cours,
habituellement par l\'inscription au cours qui contient cette page.</p>

<p><strong>Visible à toute personne identifiée au système</strong> &ndash; Quiconque identifié
peut voir la page, meme s\'ils ne sont pas inscrit à un cours particulier.</p>
<p><strong>Visible pour tout le monde</strong> &ndash; Quiconque provenant du web pourra
voir la page si les utilisateurs ont accès à solerni.org.</p>';

$string['visiblecourseusers'] = 'Visible aux participants de ce cours';
$string['visibleloggedinusers'] = 'Visible à toute personne identifié au système';
$string['visiblepublic'] = 'Visible à tout le monde';

$string['coursestatus'] = 'état du cours';
$string['coursestatus_default'] = 'état du cours par défaut';
$string['coursestatus_help'] = 'aide état du cours';

$string['pagetitle'] = 'titre de la page';
$string['pagetitle_default'] = 'Données de cours étendues';
$string['pagetitle_help'] = 'Aide données de cours étendues';
$string['displayedhtml'] = 'affichage html';
$string['picturefields'] = 'champs image';
$string['displaypicture'] = 'affichage de l\'image';
$string['pictureselect'] = 'sélection de l\'image';
$string['picturedesc'] = 'image description';
$string['picture_help'] = 'aide image';
$string['inf_one'] = 'inférieur à 1 heure';
$string['one_two'] = '1 à 2 heures';
$string['two_three'] = '2 à 3 heures';
$string['badge'] = 'Badge';
$string['status'] = 'état';
$string['status_help'] = 'Aide état';
$string['status_default'] = 'MOOC non démarré';


$string['filetitle'] = 'image du cours';
$string['userfile_default'] = 'indéfini';

$string['blocktitle'] = 'Données de cours étendues';
$string['blocktitle_default'] = 'Données de cours étendues';
$string['title_help'] = 'Laissez ce champ vide pour utiliser le titre par défaut. Si une titre est défini ici il remplacera celui par défaut.';
$string['enumerate'] = 'Enumération des titres des sections';
$string['enumerate_label'] = 'Si activé, le numéro de section est affiché avant le titre de la section';
$string['notusingsections'] = 'Ce format de cours n\'utilise pas les sections';
$string['pluginname'] = 'Données de cours étendues';
$string['basics_title'] = 'Données de cours étendues';


$string['startdate'] = 'date de début: ';
$string['enddate'] = 'date de fin: ';
$string['enddate_default'] = "0";
$string['enddate_help'] = 'aide date de fin ';



$string['duration'] = 'durée: ';
$string['duration_help'] = 'aide durée ';
$string['duration_default'] = 'dans 4 semaines';


$string['workingtime'] = 'temps de travail par jour: ';
$string['workingtime_help'] = 'aide temps de travail par jour';
$string['workingtime_default'] = 'inférieur à 1 heure';

$string['price'] = 'tarif: ';
$string['price_help'] = 'aide tarif';
$string['price_default'] = 'MOOC gratuit';

$string['certification'] = 'Certification';
$string['certification_default'] = 'Pas de Certification';
$string['certification_help'] = 'Aide pas de Certification';

$string['language'] = 'Langue: ';
$string['language_default'] = 'Pas de langue définie';

$string['video'] = 'Vidéo: ';
$string['video_help'] = 'aide vidéo';
$string['video_default'] = 0;

$string['registration'] = 'enregistrement: ';
$string['registration_default'] = 'enregistrement';
$string['registration_startdate'] = 'date de début d\'enregistrement: ';
$string['registration_enddate'] = 'date de fin d\'enregistrement: ';
$string['registration_startdate_default'] = 'date de début d\'enregistrement défaut';
$string['registration_enddate_default'] = 'date de fin d\'enregistrement défaut';
$string['registration_startdate_help'] = 'aide date de début d\'enregistrement';
$string['registration_enddate_help'] = 'aide date de fin d\'enregistrement';

$string['registeredusers'] = 'utilisateurs enregistrés: ';
$string['registeredusers_help'] = 'aide utilisateurs enregistrés';
$string['registeredusers_default'] = 'aucun utilisateur enregistré';
$string['moocstatus_default'] = 'MOOC non débuté';

$string['prerequesites'] = 'Prérequis';
$string['prerequesites_help'] = 'Prérequis aide';
$string['prerequesites_default'] = 'Aucun Prérequis';

$string['teachingteam'] = 'Equipe enseignante';
$string['teachingteam_help'] = 'Equipe enseignante aide';
$string['teachingteam_default'] = 'Conception : Orange avec Learning CRM';