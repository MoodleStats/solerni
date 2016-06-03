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
 * Orange Action block
 *
 * @package    block_orange_action
 * @copyright  Orange 2016
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['pluginname'] = 'Orange action';
$string['config_default_title'] = 'Orange action';
$string['hideblockheader'] = 'Masquer le titre';
$string['hideblockheaderdesc'] = 'Permet de masquer le titre du bloc';
$string['enrolledusers'] = '{$a->number} inscrit{$a->plural}';
$string['nextsessionlink'] = 'Je souhaite être averti de la prochaine session.';
$string['coursetopush'] = 'Cours à mettre en avant';
$string['coursetopush_help'] = 'Sélectionner le cours qui sera mis en avant sur le dashboard des utilisateurs (Seuls les cours non terminés sont présentés).';
$string['eventtopush'] = 'Evénement à mettre en avant';
$string['eventtopush_help'] = 'Sélectionner l\'événement qui sera mis en avant sur le dashboard des utilisateurs (Seuls les événements non passés sont présentés).';
$string['selectcourse'] = "Sélectionner un cours";
$string['selectevent'] = "Sélectionner un événement";
$string['generalconfig'] = "Configuration générale du bloc";
$string['myconfig'] = "Configuration du bloc";
$string['myconfigdesc'] = "Sélectionner le cours et/ou l'événement qui seront mis en avant. Si un cours et un événement sont sélectionnés, seul le cours sera affiché sur la page my.";
$string['gotocalendar'] = "Accéder à l'événement";
$string['gotosequence'] = "Accéder à la séquence";

$string['titledefault'] = '<span lang="fr" class="multilang">Titre</span><span lang="en" class="multilang">Title</span>';
$string['subtitledefault'] = '<span lang="fr" class="multilang">Sous-titre</span><span lang="en" class="multilang">Subtitle</span>';

$string['homepagebuttonmore'] = "En savoir plus sur Solerni";

$string['title'] = 'Titre';
$string['title_help'] = 'Entrez le texte principal qui sera affiché en gros caractères sous la vidéo.  Format :<br/>
&lt;span  lang="fr" class="multilang"><strong><i>Titre</i></strong>&lt;/span&gt;<br/>
&lt;span  lang="en" class="multilang"><strong><i>Title</i></strong>&lt;/span&gt;';

$string['subtitle'] = 'Sous-titre';
$string['subtitle_help'] = 'Entrez le texte qui sera affiché sous le titre. Format :<br/>
&lt;span  lang="fr" class="multilang"><strong><i>Sous-titre</i></strong>&lt;/span&gt;<br/>
&lt;span  lang="en" class="multilang"><strong><i>Subtitle</i></strong>&lt;/span&gt;';

// For capabilities.
$string['orange_action:addinstance'] = 'Ajouter un bloc Orange Action';
$string['orange_action:myaddinstance'] = 'Ajouter un bloc Orange Action sur mon dashboard';
