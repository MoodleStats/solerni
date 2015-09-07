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
 * Language strings.
 * @package forumngfeature_usage
 * @copyright 2013 The Open University
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
$string['pluginname'] = 'Statistiques d\’affichage du forum';
$string['usage:view'] = 'Voir les statistiques d\'utilisation du forum';
$string['usage:viewusage'] = 'Voir les informations sur les statistiques d\'utilisation du forum';
$string['usage:viewflagged'] = 'Voir les posts marqués';
$string['event:viewed'] = 'Voir les informations sur l\'utilisation';
$string['button'] = 'Voir l’utilisation';
$string['title'] = 'Utilisation';
$string['contribution'] = 'Contribution';
$string['usage'] = 'Utilisation';
$string['mostposts'] = 'Le plus de posts';
$string['mostposts_none'] = 'Aucune réponse.';
$string['mostposts_help'] = 'Utilisateurs ayant posté le plus de réponses.';
$string['mostdiscussions'] = 'Le plus de discussions';
$string['mostdiscussions_none'] = 'Aucune discussion.';
$string['mostdiscussions_help'] = 'Utilisateurs ayant démarré le plus de discussions';
$string['usagechartpoststotal'] = 'Historique des posts - {$a} posts';
$string['usagechartpoststot'] = 'Historique des posts';
$string['usagechartpoststot_help'] = 'Vue de l\'historique des discussions/posts créés au fil du temps. Affiche les posts créés chaque jour et le total courant des posts créés au cours de la période sélectionnée.';
$string['usagechartposts'] = 'Posts';
$string['usagechartpostslabel'] = 'Posts par jour';
$string['usagechartday'] = 'Date';
$string['usagecharttotal'] = 'Total';
$string['usagecharttotallabel'] = 'Nombre total de posts';
$string['usagechartdatesubmit'] = 'Mettre à jour l\'historique des posts';
$string['usagechartpoststable'] = 'Historique des posts, nombre de posts par jour et total général';
$string['usagesubscribers'] = 'Abonnés';
$string['usagesubscribers_help'] = 'Tableau montrant les informations à propos des abonnés.
Chaque utilisateur ne peut avoir qu\'un type d\'abonnement par forum ; par exemple l\'abonnement à un forum de groupe prend le pas sur l\'abonnement à chacune des discussions.';
$string['usagesubscribertabletype'] = 'Type d\'abonné';
$string['usagesubscribertabletotal'] = 'Nombre';
$string['usagesubscribertable_all'] = 'Nombre total d\'abonnés';
$string['usagesubscribertable_whole'] = 'Abonnés au forum entier';
$string['usagesubscribertable_group'] = 'Abonnés à un forum de groupe';
$string['usagesubscribertable_discuss'] = 'Abonnés à une discussion';
$string['mostreaders'] = 'Discussions les plus lues';
$string['mostreaders_none'] = 'Aucune discussion marquée comme lue.';
$string['mostreaders_help'] = 'Discussions classées par nombre d\'utilisateurs les ayant marquées comme lues. La liste ne compte que les gens qui ont affiché la discussion dans un navigateur web. Certaines personnes peuvent avoir suivi la discussion par l\'intermédiaire d\'un abonnement email ou via un flux Atom ou RSS, ce qui ne comptera pas dans cette liste. Quand les utilisateurs activent l\'option \'marquer manuellement les discussions comme lues\', ils n\'apparaissent pas dans cette liste tant qu\'ils n\'ont pas marqué la discussion comme lue. A l\'inverse, il est possible d\'être pris en compte dans cette liste en ayant cliqué sur le bouton \'Marquer comme lu\' sans avoir vraiment lu la discussion.';
$string['mostflagged'] = 'Le plus de posts marqués';
$string['mostflagged_none'] = 'Aucun post marqué.';
$string['mostflagged_help'] = 'Posts classés par nombre d\'utilisateurs qui les ont \'marqués\'.';
$string['mostflaggeddiscussions'] = 'Discussions les plus marquées';
$string['mostflaggeddiscussions_none'] = 'Aucune discussion marquée.';
$string['mostflaggeddiscussions_help'] = 'Discussions classées par nombre d\'utilisateurs qui les ont \'marquées\'.';
$string['noscript'] = 'Afficher toutes les informations qui ne sont pas encore chargées.';
$string['mostratedposts'] = 'Les posts les plus notés par';
$string['mostratedposts_none'] = 'Aucun post noté.';
$string['mostratedposts_help'] = 'Nombre total de notes selon la méthode choisie pour la notation du forum';
$string['forumngratingsfilter'] = 'Filtrer les notes par';
$string['forumngratingsfilter_help'] = 'Choisir une option de tri pour les posts les plus notés.';
$string['forumng_ratings_grading_average'] = 'Posts les plus notés - Note moyenne';
$string['forumng_ratings_grading_count'] = 'Posts les plus notés - Nombre de notes';
$string['forumng_ratings_grading_max'] = 'Posts les plus notés - Note maximale';
$string['forumng_ratings_grading_min'] = 'Posts les plus notés  - Note minimale';
$string['forumng_ratings_grading_sum'] = 'Posts les plus notés - Somme des notes';
$string['forumng_ratings_grading_average_none'] = 'Aucun post noté';
$string['forumng_ratings_grading_count_none'] = 'Aucun post noté';
$string['forumng_ratings_grading_max_none'] = 'Aucun post noté';
$string['forumng_ratings_grading_min_none'] = 'Aucun post noté';
$string['forumng_ratings_grading_sum_none'] = 'Aucun post noté';
$string['forumng_ratings_grading_average_help'] = 'Afficher les posts ayant le plus de notes par note moyenne la plus haute';
$string['forumng_ratings_grading_count_help'] = 'Afficher les posts ayant le plus de notes par nombre total de note atribuées';
$string['forumng_ratings_grading_max_help'] = 'Afficher les posts ayant le plus de notes par note maximale la plus haute';
$string['forumng_ratings_grading_min_help'] = 'Afficher les posts ayant le plus de notes par note minimale la plus haute';
$string['forumng_ratings_grading_sum_help'] = 'Afficher les posts ayant le plus de notes par la somme totale des notes des posts';
