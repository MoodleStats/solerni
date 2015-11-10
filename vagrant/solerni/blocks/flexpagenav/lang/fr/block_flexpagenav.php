<?php
/**
 * Flexpage Navigation Block
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see http://opensource.org/licenses/gpl-3.0.html.
 *
 * @copyright Copyright (c) 2009 Moodlerooms Inc. (http://www.moodlerooms.com)
 * @license http://opensource.org/licenses/gpl-3.0.html GNU Public License
 * @package block_flexpagenav
 * @author Mark Nielsen
 */

/**
 * Plugin language
 *
 * @author Orange 2015
 * @package block_flexpagenav
 */

$string['pluginname'] = 'Menu Flexpage';
$string['flexpagenav:view'] = 'Voir les menus Flexpage';
$string['flexpagenav:manage'] = 'Gérer les menus Flexpage';
$string['flexpagenav:addinstance'] = 'Ajouter un block de menu Flexpage';
$string['addexistingmenuaction'] = 'Ajouter un menu existant';
$string['managemenusaction'] = 'Gérer tous les menus';
$string['managemenus'] = 'Gérer les menus';
$string['name'] = 'Nom';
$string['manage'] = 'Gérer';
$string['usedastabs'] = 'Utiliser comme onglet';
$string['addmenudotdotdot'] = 'Ajouter un menu ...';
$string['editmenu'] = 'Modifier le menu';
$string['useastab'] = 'Utiliser comme onglet';
$string['displayname'] = 'Afficher le nom';
$string['render'] = 'Afficher le menu comme';
$string['name'] = 'Nom';
$string['tree'] = 'Arbre';
$string['dropdown'] = 'Menu déroulant';
$string['navhorizontal'] = 'Navigation horizontale';
$string['navvertical'] = 'Navigation verticale';
$string['ajaxexception'] = 'Erreur : {$a}';
$string['editmenuaction'] = 'Menu Modifier';
$string['deletemenuaction'] = 'Supprimer';
$string['managelinksaction'] = 'Gérer les liens';
$string['managelinks'] = 'Gérer les liens';
$string['editlink'] = 'Modifier';
$string['movelink'] = 'Déplacer';
$string['deletelink'] = 'Supprimer';
$string['type'] = 'Type';
$string['preview'] = 'Aperçu/Information';
$string['urllink'] = 'URL';
$string['addlinkdotdotdot'] = 'Ajouter un lien...';
$string['editingx'] = 'Modifier {$a}';
$string['label'] = 'Libellé';
$string['url'] = 'URL';
$string['labelurlrequired'] = 'Les champs libellé et URL sont obligatoires.';
$string['editlinkaction'] = 'Modifier';
$string['movelinkaction'] = 'Déplacer';
$string['deletelinkaction'] = 'Supprimer';
$string['movelinkx'] = 'Déplacer le lien {$a}';
$string['movebefore'] = 'avant';
$string['moveafter'] = 'après';
$string['movelink'] = 'Déplacer un lien';
$string['areyousuredeletelink'] = '<p>Êtes-vous sûr de vouloir supprimer le lien ?</p><p>{$a}</p>';
$string['areyousuredeletemenu'] = 'Êtes-vous sûr de vouloir supprimer le menu <strong>{$a}</strong> ?';
$string['deletemenu'] = 'Supprimer le menu';
$string['displaymenu'] = 'Afficher le menu';
$string['flexpage'] = 'Flexpage';
$string['flexpagelink'] = 'Flexpage';
$string['includechildren'] = 'Inclure les enfants';
$string['excludechildren'] = 'Enfant à inclure : ';
$string['nochildpages'] = 'pas de flexpages enfant';
$string['flexpagewithchildren'] = '{$a} avec les enfants';
$string['flexpagewithoutchildren'] = '{$a} sans les enfants';
$string['flexpageerror'] = 'Erreur : n\'existe probablement plus';
$string['flexpagenav'] = 'Menu Flexpage';
$string['flexpagenavlink'] = 'Menu Flexpage';
$string['flexpagenavx'] = '{$a} menu';
$string['flexpagenaverror'] = 'Erreur : le menu Flexpage n\'existe probablement plus';
$string['nomenustoadd'] = 'Il n\'y a pas d\'autres menus Flexpage que vous pouvez ajouter à ce menu.';
$string['coursemodule'] = 'Activités de cours';
$string['modlink'] = 'Activité';
$string['ticketlink'] = 'Trouble Ticket';
$string['subject'] = 'Sujet';
$string['labelrequired'] = 'Le champ libellé est obligatoire.';
$string['menus'] = 'Menus';
$string['addexistingmenu'] = 'Ajouter un menu existant';
$string['addexistingmenu_help'] = 'Choisissez l\'emplacement où vous souhaitez placer le bloc sur la Flexpage en sélectionnant l\'un des boutons <strong>Ajouter un menu existant</ strong> sur le haut de la fenêtre. Ensuite, cliquez sur le nom du menu que vous souhaitez ajouter à ce cours.';
$string['migrationtoptabs'] = 'Onglets du cours';
$string['moderror'] = 'Erreur : cette activité n\'existe probablement plus';
$string['noexistingmenustoadd'] = 'Aucun menu n\'a été créé pour ce cours.  Utiliser <strong>Gérér > Gérer tous les menu</strong> pour créer un nouveau menu.';
$string['urlfailedcleaning'] = 'L\'URL saisie est invalide.  Merci de vérifier que l\'URL est bien valide.';
$string['urlmuststartwith'] = 'L\'URL saisie doit commencer par http:// ou https://';
$string['managinglinksforx'] = 'Gérer les liens  pour le menu <em>{$a}</em>';
$string['formnamerequired'] = 'Le nom du menu est obligatoire.';
$string['invalidurl'] = 'L\'URL fournie est invalide et ne peut pas être utilisée. Merci de vérifier l\'URL saisie.';
$string['menudisplayerror'] = 'Impossible d\'afficher le menu flexpage associé.  Le menu Flexpage est corrompu ou n\'existe plus.  Vous devez supprimer ce block ou le modifier pour afficher un autre menu Flexpage.';
$string['dockable'] = 'Permettre à ce block d\être arrimé';

$string['dockable_help'] = 'Détermine si ce block peut être arrimé ou pas par l\'utilisateur. A noter que l\'arrimage peut être désactivé dans les cas suivants :
<ul>
    <li>La configuration du thème peut empêcher l\'arrimage des blocs.</li>
    <li>Seuls les menus Flexpage affichés sous forme d\'arbre peuvent être arrimés.</li>
    <li>Les blocs sans titre ne peuvent pas être arrimés.</li>
</ul>';

$string['managemenus_help'] = '<p>Les menus permettent aux utilisateurs de naviguer dans les flexpages d\'un cours. Les menus peuvent être placés dans n\'importe quelle région comme bloc. Les menus contiennent des liens sur des flexpages du cours, des URLs externes, et des liens vers d\'autres menus.</p>
<p>Un des menu du cours peut aussi être affiché sous forme d\'onglet. Ce menu apparaitra tout en haut du cours. Si vous voulez avoir plusieurs options pour chaque onglet, créez un menu pour chaque onglet qui pointera sur différents menus Flexpage.</p>';