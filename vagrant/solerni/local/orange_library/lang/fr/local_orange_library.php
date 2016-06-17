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
 * Strings for component 'descriptionpage', language 'en', branch 'MOODLE_20_STABLE'
 *
 * @package mod
 * @subpackage orange libary
 * @copyright  2015 Orange based on mod_page plugin from 2009 Petr Skoda (http://skodak.org)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['pluginname']           = 'Orange Library';
$string['local_orange_library'] = 'Orange Library';

// Subscription button object.
$string['subscribe_to_mooc']    = 'S’inscrire';
$string['access_to_mooc']       = 'Accéder au cours';
$string['status_default']       = 'A venir';
$string['status_running']       = 'En cours';
$string['status_closed']        = 'Terminé';
$string['alert_mooc']           = 'M’avertir de la prochaine session';
$string['registration_closed']  = 'Inscription terminée';
$string['registration_open']    = 'Inscription ouverte';
$string['registration_not_open']    = 'Inscription pas encore ouverte';
$string['mooc_complete']        = 'Mooc complet';
$string['mooc_open_date']       = 'Début le {$a}';
$string['acces_to_archive']     = 'Acces aux archives';
$string['enrolled_users']       = 'utilisateurs enregistrés';
$string['unsubscribe']          = 'me désinscrire';
$string['new_session']          = 'nouvelle session';

// Extended course object.
$string['english']              = 'Anglais';
$string['french']               = 'Français';
$string['duration_default']     = 0;
$string['workingtime_default']  = 0;
$string['prerequesites_default'] = 'Pas de prérequis';
$string['subtitle']             = 'Sous-titres';
$string['subtitle_default']     = 'Sous-titres';
$string['teachingteam_default'] = 'Conception : Orange avec Learning CRM';

// Badges.
$string['certification']        = 'Attestation de réussite';
$string['certification_default'] = 'Pas d\'attestation de réussite';
$string['badges']               = 'Badges';
$string['badge_default']        = 'Non badgeant';
$string['badge']                = 'Badge ';

// Exception.
$string['missing_course_in_construct'] = 'Vous avez essayé d\'instancier un objet subscription_button_object sans lui passer un objet $course';

$string['price']                = 'Tarif : ';
$string['price_help']           = 'tarif du cours';
$string['price_default']        = 'Mooc gratuit';
$string['price_case1']          = 'Mooc gratuit';
$string['price_case2']          = 'Mooc gratuit<br>certification en option';
$string['price_case3']          = 'enseignement professionnel';

$string['coursereplay']         = 'cours rejouable';
$string['coursereplay_help']    = 'le cours est-il rejouable ?';
$string['replay']               = 'Rejouable';
$string['notreplay']            = 'Non rejouable';

// Configuration check.
$string['configuration_error']  = 'Erreurs de configuration pour ce cours :';
$string['enrolmentmethodmissing'] = 'Méthode d\'inscription "{$a}" manquante.';
$string['enrolmentmethodenabled'] = 'La méthode d\'inscription "{$a}" doit être activée.';
$string['moddescriptionpagemissing'] = 'Page "{$a}" manquante.';
$string['moddescriptionpagemultiple'] = 'Ce cours dispose de plus d\'une page "{$a}".';
$string['blockmissing'] = 'Bloc "{$a}" manquant.';
$string['startenrolmentdatemissing'] = "La date de début d'inscription n'est pas renseignée dans la méthode 'auto-inscription'";
$string['endenrolmentdatemissing'] = "La date de fin d'inscription n'est pas renseignée dans la méthode 'auto-inscription'";
$string['orangeinvitationconfigmissing'] = "Vous devez enregistrer au moins une fois la configuration de la méthode d'inscription 'URLs d'accès au cours'";

$string['today'] = "auj, ";
$string['yesterday'] = "hier, ";
$string['weeks'] = "sem";
$string['day'] = "jour";
$string['hour'] = "H";
$string['minute'] = "min";
$string['second'] = "sec";

// Cron Tasks.
$string['orange_library_mnet_task'] = "Mise à jour des clés MNET";
$string['orange_library_mnet_mail'] = '<p>Bonjour  {$a->firstname}  {$a->lastname},</p>
<p>Je suis la tâche automatisée de vérification de la validité des clés MNet pour <b>{$a->sitename}</b>';
$string['orange_library_mnet_mail_subject'] = "Test de validité des clés MNet ";
$string['orange_library_thematic_task'] = "Mise à jour des informations des thématiques";

// Course menu item.
$string['coursemenudashboard'] = "Accueil";
$string['coursemenulearn'] = "Apprendre";
$string['coursemenulearnmore'] = "Actualités";
$string['coursemenuforum'] = "Forum";
$string['coursemenushare'] = "Ressource";

// Capability.
$string['orange_library:viewadmin']    = 'Permet de voir l\'item Administration dans le menu principal';
