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

$string['orange_course_extended:addinstance'] = 'Ajout d\'un nouveau bloc cours étendu';
$string['orange_course_extended:myaddinstance'] = 'Ajout d\'un nouveau bloc cours étendu à la page My Moodle';
$string['course_extended'] = 'Cours étendu';

// General configuration.
$string['defaulttitle'] = 'Cours étendu';
$string['headerconfig'] = 'Configuration du titre';
$string['descconfig'] = 'configuration de la description';
$string['blocktitle'] = 'Cours étendu';
$string['blocktitle_default'] = 'Cours étendu';
$string['title_help'] = 'Gardez ce champ vide pour utiliser le tritre par défaut.Si vous définissez un titre, celui-ci sera utilisé par défaut.';
$string['pluginname'] = 'Extended Course';
$string['basics_title'] = 'Cours étendu';
$string['course_extended_settings'] = 'settings';
$string['week'] = 'semaine(s)';
$string['day'] = 'jour(s)';
$string['hour'] = 'heure(s)';
$string['minute'] = 'minute(s)';
$string['second'] = 'seconde(s)';

// Course visibility.
$string['maxvisibility'] = 'visibilité';
$string['maxvisibility_help'] = '
<p><strong>Visible seulement sur la page utilisateur (private)</strong> &ndash;
personne d\'autre ne peut voir cette page.</p>
<p><<strong>Visible aux participants de ce cours</strong> &ndash;
Pour voir ce cours vous devez avoir les droits d\'accès a ce cours, généralement par l\'inscription au cours qui contient cette page.</p>

<p><strong>Visible à toute personne identifiée sur la plate forme.</strong> &ndash; quiconque est identifié sur la plate forme
peut voir cette page, même sans être inscrit a un cours.</p>
<p><strong>Visible pour tous</strong> &ndash; n\'importe quel utilisateur peut consulter cette page. (si l\'adresse de la page a été fournie.).</p>';

$string['visiblecourseusers'] = 'Visible aux participants du cours';
$string['visibleloggedinusers'] = 'Visible aux utilisateurs identifiés sur la plate forme.';
$string['visiblepublic'] = 'Visible a tout le monde';

// Extended course parameters.
$string['title'] = 'Cours étendu';
$string['true'] = 'true';
$string['false'] = 'false';
$string['inserterror'] = 'insert error';
$string['notinserterror'] = 'not insert error';
$string['invalidcourse'] = 'Course non défini';
$string['pagetitle'] = 'titre de la page';
$string['pagetitle_default'] = 'Cours étendu';
$string['pagetitle_help'] = 'Titre de la page';

// Status.
$string['status'] = 'état';
$string['status_help'] = 'état du cours : en cours, à venir, terminé';
$string['current'] = 'en cours';
$string['startingsoon'] = 'à venir';
$string['closed'] = 'terminé';
$string['coursestatus'] = 'état du cours';
$string['coursestatus_default'] = 'en cours';
$string['coursestatus_help'] = 'état du cours : en cours, à venir, terminé';

// Picture.
$string['filetitle'] = 'Course image';
$string['userfile_default'] = 'undefined';
$string['picturefields'] = 'Image d\'illustration';
$string['displaypicture'] = 'Illustration du mooc ';
$string['pictureselect'] = 'Selection de l\'image';
$string['picturedesc'] = 'image description';
$string['picture_help'] = 'Image utilisée pour illustrer le mooc';
$string['picture'] = 'image';

// Duration.
$string['duration'] = 'durée: ';
$string['duration_help'] = '(en semaines) ';
$string['duration_default'] = 'inférieur à 4 semaines ';
$string['in_four_weeks'] = 'inférieur à 4 semaines ';
$string['four_six_weeks'] = '4 à 6 semaines';
$string['sup_six_weeks'] = 'supérieur à 6 semaines';

// Working time.
$string['workingtime'] = 'Durée hebdomadaire: ';
$string['workingtime_help'] = 'temps de travail hebdomadaire ';
$string['workingtime_default'] = 'inférieur à une heure';
$string['inf_one'] = 'inférieur à une heure';
$string['one_two'] = 'une à deux heures';
$string['two_three'] = 'deux à trois heures';

// Certification.
$string['badge'] = 'Badge';
$string['badges'] = 'badges';
$string['certification'] = 'Certification';
$string['certification_default'] = '<br>attestation de réussite';
$string['certification_help'] = 'pas d\'attestation de réussite';

// Start end date.
$string['startdate'] = 'date de début: ';
$string['enddate'] = 'date de fin: ';
$string['enddate_default'] = "0";
$string['enddate_help'] = 'date de fin du mooc ';

// Course replay.
$string['course_replay_default'] = 'Replay';

// Price.
$string['price'] = 'Tarif: ';
$string['price_help'] = 'prix du mooc';
$string['price_default'] = ' mooc gratuit';
$string['price_case1'] = ' mooc gratuit';
$string['price_case2'] = ' mooc gratuit<br>certification en option';
$string['price_case3'] = ' formation professionnelle';

// Language.
$string['language'] = 'Langue: ';
$string['language_default'] = 'Anglais';
$string['french'] = 'Français';
$string['english'] = 'Anglais';

// Video.
$string['video'] = 'Vidéos ';
$string['video_help'] = 'Le mooc possède des vidéos';
$string['video_default'] = '0';
$string['subtitle'] = ' sous-titres';

// Registration.
$string['registration'] = 'enregistrement: ';
$string['registration_default'] = 'enregistrement';
$string['registration_startdate'] = 'date de début d\'enregistrement: ';
$string['registration_enddate'] = 'date de fin d\'enregistrement: ';
$string['registration_startdate_default'] = 'date de début d\'enregistrement par défaut';
$string['registration_enddate_default'] = 'date de fin d\'enregistrement par défaut';
$string['registration_startdate_help'] = 'sélectionnez la date de début d\'enregistrement';
$string['registration_enddate_help'] = 'sélectionnez la date de fin d\'enregistrement';
$string['registeredusers_limitation'] = 'Nombre d\'inscrits: ';
$string['registration_case1'] = 'ouvert à tous ';
$string['registration_from'] = ' du ';
$string['registration_to'] = ' au ';
$string['registrationcompany'] = 'Propriétaire: ';
$string['registrationcompany_default'] = 'Propriétaire';
$string['registrationcompany_help'] = 'Société à laquelle appartient le mooc.';
$string['registration_case2'] = 'limité aux ';
$string['registration_case2_2'] = 'premiers inscrits ';
$string['registration_case3'] = 'Vous êtes autorisé à vous inscrire par ';

// Registered users.
$string['registeredusers'] = 'Nombre d\'inscrits: ';
$string['registeredusers_help'] = 'Nombre d\'inscrits au mooc';
$string['registeredusers_default'] = 'aucun';
$string['moocstatus_default'] = 'non démarré';

// Prerequestites.
$string['prerequesites'] = 'Prérequis';
$string['prerequesites_help'] = 'Prérequis pour participer au mooc';
$string['prerequesites_default'] = 'Aucun';

// Teaching team.
$string['teachingteam'] = 'équipe pédagogique';
$string['teachingteam_help'] = 'description de léquipe pédagogique';
$string['teachingteam_default'] = 'Conception : Orange avec Learning CRM';


