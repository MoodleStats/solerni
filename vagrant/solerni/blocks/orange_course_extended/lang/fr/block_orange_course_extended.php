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
$string['descconfig'] = 'Configuration de la description';
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
$string['status'] = 'Etat';
$string['status_help'] = 'Etat du cours : en cours, à venir, terminé';
$string['current'] = 'en cours';
$string['startingsoon'] = 'à venir';
$string['closed'] = 'terminé';
$string['coursestatus'] = 'Etat du cours';
$string['coursestatus_default'] = 'en cours';
$string['coursestatus_help'] = 'Etat du cours : en cours, à venir, terminé';

// Picture.
$string['filetitle'] = 'Course image';
$string['userfile_default'] = 'undefined';
$string['picturefields'] = 'Image d\'illustration';
$string['displaypicture'] = 'Illustration du mooc ';
$string['pictureselect'] = 'Selection de l\'image';
$string['picturedesc'] = 'Image description';
$string['picture_help'] = 'Image utilisée pour illustrer le mooc';
$string['picture'] = 'image';

// Duration.
$string['duration'] = 'Durée: ';
$string['duration_help'] = '(en semaines) ';
$string['duration_default'] = 'Inférieur à 4 semaines ';
$string['in_four_weeks'] = 'Inférieur à 4 semaines ';
$string['four_six_weeks'] = '4 à 6 semaines';
$string['sup_six_weeks'] = 'Supérieur à 6 semaines';

// Working time.
$string['workingtime'] = 'Durée hebdomadaire: ';
$string['workingtime_help'] = 'Temps de travail hebdomadaire ';
$string['workingtime_default'] = 'Inférieur à une heure';
$string['inf_one'] = 'Inférieur à une heure';
$string['one_two'] = 'Une à deux heures';
$string['two_three'] = 'Deux à trois heures';

// Certification.
$string['badge'] = 'Badge';
$string['badges'] = 'Badges';
$string['badge_default'] = 'Non badgeant';
$string['certification'] = 'Certification:';
$string['certification_default'] = 'Pas d\'attestation de réussite';
$string['certification_help'] = 'Pas d\'attestation de réussite';

// Start end date.
$string['startdate'] = 'Date de début: ';
$string['enddate'] = 'Date de fin: ';
$string['enddate_default'] = "Pas de date de fin";
$string['enddate_help'] = 'Date de fin du mooc';

// Course replay.
$string['course_replay_default'] = 'Rejouer';

// Price.
$string['price'] = 'Tarif: ';
$string['price_help'] = 'Prix du mooc';
$string['price_default'] = 'Mooc gratuit';
$string['price_case1'] = ' Mooc gratuit';
$string['price_case2'] = ' Mooc gratuit<p>certification en option';
$string['price_case3'] = ' Formation professionnelle';

// Language.
$string['language'] = 'Langue: ';
$string['language_default'] = 'Anglais';
$string['french'] = 'Français';
$string['english'] = 'Anglais';

// Video.
$string['video'] = 'Vidéos: ';
$string['video_help'] = 'Le mooc possède des vidéos';
$string['video_default'] = '0';
$string['subtitle'] = 'Sous-titres';

// Registration.
$string['registration'] = 'Enregistrement: ';
$string['registration_default'] = 'Enregistrement';
$string['registration_startdate'] = 'Date de début d\'enregistrement: ';
$string['registration_enddate'] = 'Date de fin d\'enregistrement: ';
$string['registration_startdate_default'] = 'date de début d\'enregistrement par défaut';
$string['registration_enddate_default'] = 'date de fin d\'enregistrement par défaut';
$string['registration_startdate_help'] = 'Sélectionnez la date de début d\'enregistrement';
$string['registration_enddate_help'] = 'Sélectionnez la date de fin d\'enregistrement';
$string['registeredusers_limitation'] = 'Nombre d\'inscrits: ';
$string['registration_case1'] = 'ouvert à tous ';
$string['registration_from'] = ' du ';
$string['registration_to'] = ' au ';
$string['registrationcompany'] = 'Propriétaire: ';
$string['registrationcompany_default'] = 'Propriétaire';
$string['registrationcompany_help'] = 'Société à laquelle appartient le mooc.';
$string['registration_case2'] = '{$a} place(s) disponible(s)';
$string['registration_case3'] = 'Vous êtes autorisé à vous inscrire par ';

// Registered users.
$string['registeredusers'] = 'Nombre d\'inscrits: ';
$string['registeredusers_help'] = 'Nombre d\'inscrits au mooc';
$string['registeredusers_default'] = 'aucun';
$string['moocstatus_default'] = 'non démarré';

// Prerequestites.
$string['prerequesites'] = 'Prérequis';
$string['prerequesites_help'] = 'Prérequis pour participer au mooc';
$string['prerequesites_default'] = 'Aucun prérequis';

// Teaching team.
$string['teachingteam'] = 'Equipe pédagogique';
$string['teachingteam_help'] = 'description de léquipe pédagogique';
$string['teachingteam_default'] = 'Conception : Orange avec Learning CRM';

// Contact email.
$string['contactemail'] = 'Email de contact:';
$string['contactemail_help'] = 'Email de contact du Mooc utilisé pour le formulaire de contact';
$string['contactemail_default'] = 'contact@solerni.com';