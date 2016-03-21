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
 * Strings for component 'booktool_wordimport', language 'fr', branch 'MOODLE_29_STABLE'
 *
 * @package   booktool_wordimport
 * @copyright 1999 onwards Martin Dougiamas  {@link http://moodle.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['cannotopentempfile'] = 'Impossible d\'ouvrir le fichier temporaire <b>{$a}</b>';
$string['exportbook'] = 'Exporter le livre vers Microsoft Word';
$string['exportchapter'] = 'Exporter ce chapitre vers Microsoft Word';
$string['importchapters'] = 'Importer de Microsoft Word';
$string['insertionpoint'] = 'Insérer avant le chapitre actuel';
$string['insertionpoint_help'] = 'Insérer le contenu avant le chapitre actuel, en gardant tout le contenu existant';
$string['nochapters'] = 'Pas de chapitres de livres trouvés, donc impossible à exporter vers Microsoft Word';
$string['pluginname'] = 'Import de fichier Microsoft Word';
$string['replacebook'] = 'Remplacer le livre';
$string['replacebook_help'] = 'Supprimer le contenu actuel livre avant d\'importer';
$string['replacechapter'] = 'Remplacer le chapitre actuel';
$string['replacechapter_help'] = 'Remplacer le contenu du chapitre avec le premier chapitre du fichier, mais garder tous les autres chapitres';
$string['splitonsubheadings'] = 'Créer des sous-chapitres basés sur les niveaux de titres';
$string['splitonsubheadings_help'] = 'Les sous-chapitres seront crées à partir des styles  " Titre 2 "';
$string['stylesheetunavailable'] = 'La feuille de style XSLT <b>{$a}</b> n\'est pas disponible';
$string['transformationfailed'] = 'La transformation XSLT n\'a pas réussi (<b>{$a}</b>)';
$string['wordfile'] = 'Fichier Microsoft Word';
$string['wordfile_help'] = 'Déposer le fichier <i>.docx</i> enregistré à partir de Microsoft Word ou LibreOffice';
$string['wordimport:export'] = 'Exporter le fichier Microsoft Word';
$string['wordimport:import'] = 'Importer le fichier Microsoft Word';
$string['xsltunavailable'] = 'Vous devez avoir la librairie XSLT installée dans PHP pour enregistrer ce fichier Word';
