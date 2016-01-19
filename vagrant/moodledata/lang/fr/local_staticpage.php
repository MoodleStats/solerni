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
 * Strings for component 'local_staticpage', language 'fr', branch 'MOODLE_29_STABLE'
 *
 * @package   local_staticpage
 * @copyright 1999 onwards Martin Dougiamas  {@link http://moodle.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['apacherewrite'] = 'Forcer l\'utilisation du mod_rewrite Apache';
$string['apacherewrite_desc'] = 'Servir les pages statiques avec une URL propre, réécrite par le module mod_rewrite d\'Apache. Consulter le fichier README pour plus de détails.';
$string['documentdirectory'] = 'Répertoire des pages statiques';
$string['documentdirectory_desc'] = 'Répertoire contenant les fichiers .html contenant le code HTML des pages statiques. Consulter le fichier README pour plus de détails.';
$string['documentheadingsource'] = 'Source pour l\'en-tête de données du document';
$string['documentheadingsource_desc'] = 'Données utilisées dans le fichier html pour l\'en-tête du document';
$string['documentlist'] = 'Liste des documents';
$string['documentlistdirectoryempty'] = 'Il n\'y a pas de fichier .html dans le répertoire des pages statiques. Il n\'y a donc pas de pages statiques disponibles. Consulter le fichier README pour plus de détails.';
$string['documentlistdirectorynotreadable'] = 'Le répertoire contenant les pages statiques n\'est pas accessible. Il n\'y a donc pas de pages statiques disponibles.';
$string['documentlistentryfilename'] = 'Le document suivant a été trouvé : <br /><strong>{$a}</strong>';
$string['documentlistentrylanguage'] = 'Ce document sera disponible pour la langue ci-dessous :<br /><strong>{$a}</strong>';
$string['documentlistentrypagename'] = 'A partir du nom du fichier, Moodle à fixé le nom de la page suivante :<br /><strong>{$a}</strong>';
$string['documentlistentryreachablefail'] = 'Ce document devrait être disponible avec l\'URL suivante, mais un navigateur ne peut actuellement pas accéder à cette page (il doit y avoir un problème avec la configuration de votre serveur Web -  Consulter le fichier README pour plus de détails) : <br /><strong>{$a}</strong>';
$string['documentlistentryreachablesuccess'] = 'Ce document est disponible et peut être atteint avec cette URL : <br /><strong>{$a}</strong>';
$string['documentlistentryrewritefail'] = 'Ce document devrait être disponible avec l\'URL explicite suivante, mais un navigateur ne peut actuellement pas accéder à cette page (il doit y avoir un problème avec la configuration de votre serveur Web ou avec le module mod_rewrite - Consulter le fichier README pour plus de détails) :<br /><strong>{$a}</strong>';
$string['documentlistentryrewritesuccess'] = 'Ce document est disponible et peut être atteint avec cette URL explicite : <br /><strong>{$a}</strong>';
$string['documentlistentryunsupported'] = 'Le suffixe de ce fichier fait référence à une langue non supportée, le document ne sera donc <strong>pas disponible</strong>. Changer le nom du document afin d\'utiliser une langue supportée.';
$string['documentlistinstruction'] = 'La liste ci-dessous présente les fichiers trouvés dans le répertoire des pages statiques et leurs URLs d\'accès.';
$string['documentlistnodirectory'] = 'Le répertoire des pages statiques n\'existe pas, de ce fait aucune page statique ne sera disponible.';
$string['documentnavbarsource'] = 'Source pour le titre dans le fil d\'ariane';
$string['documentnavbarsource_desc'] = 'Données utilisées dans le fichier html pour le titre de la page dans le fil d\'ariane.';
$string['documenttitlesource'] = 'Source pour le titre du document';
$string['documenttitlesource_desc'] = 'Données utilisées dans le fichier html pour le titre du document';
$string['documenttitlesourceh1'] = 'Premier tag H1 du code HTML de la page (généralement situé juste après l\'ouverture du tag BODY)';
$string['documenttitlesourcehead'] = 'Premier tag TITLE du code HTML de la page (généralement situé entre les tags HEAD)';
$string['international'] = 'Tous les langages';
$string['pagenotfound'] = 'Page non  trouvée';
$string['pluginname'] = 'Pages statiques';
