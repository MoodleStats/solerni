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
 * Strings for component 'block_xp', language 'fr', branch 'MOODLE_29_STABLE'
 *
 * @package   block_xp
 * @copyright 1999 onwards Martin Dougiamas  {@link http://moodle.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['activityoresourceis'] = 'L\'activité ou ressource est {$a}';
$string['addacondition'] = 'Ajouter une condition';
$string['addarule'] = 'Ajouter une règle';
$string['addrulesformhelp'] = 'La dernière colonne définit la quantité de points d\'expérience acquise lorsque le critère est rempli.';
$string['awardaxpwhen'] = '<strong>{$a}</strong> points d\'expérience sont attribués quand :';
$string['basexp'] = 'Base de l\'algorithme';
$string['cachedef_filters'] = 'Filtres de niveau';
$string['cachedef_ruleevent_eventslist'] = 'Liste de quelques événements';
$string['changelevelformhelp'] = 'Si vous changez le nombre de niveaux, les badges de niveau personnalisés seront temporairement désactivés pour éviter d\'éventuels niveaux sans badges. Si vous changez le nombre de niveaux, une fois ce formulaire enregistré, visitez la page \'Visuels\' pour réactiver les badges personnalisés.';
$string['cheatguard'] = 'Protection anti-triche';
$string['coefxp'] = 'Coefficient de l\'algorithme';
$string['colon'] = '{$a->a} : {$a->b}';
$string['configdescription'] = 'Description à ajouter';
$string['configheader'] = 'Réglages';
$string['configtitle'] = 'Titre';
$string['congratulationsyouleveledup'] = 'Félicitations !';
$string['coolthanks'] = 'Merci c\'est cool !';
$string['courselog'] = 'Journal du cours';
$string['coursereport'] = 'Rapport du cours';
$string['courserules'] = 'Règles du cours';
$string['coursesettings'] = 'Réglages du cours';
$string['coursevisuals'] = 'Visuels de cours';
$string['customizelevels'] = 'Personnaliser les niveaux';
$string['defaultrules'] = 'Règles par défaut';
$string['defaultrulesformhelp'] = 'Ce sont les règles par défaut fournies par le plugin, Elles attribuent automatiquement des points d\'expérience par défaut et ignorent certains événements redondants. Les règles personnalisées ont priorité sur elles.';
$string['deletecondition'] = 'Supprimer la condition';
$string['deleterule'] = 'Supprimer la règle';
$string['description'] = 'Description';
$string['dismissnotice'] = 'Masquer la note';
$string['enableinfos'] = 'Activer la page d\'infos';
$string['enableinfos_help'] = 'Lorsque ce réglage est sur «Non», les étudiants ne seront pas en mesure d\'afficher la page d\'infos.';
$string['enableladder'] = 'Activer l\'échelle';
$string['enableladder_help'] = 'Lorsque ce réglage est sur «Non», les étudiants ne seront pas en mesure d\'afficher l\'échelle.';
$string['enablelevelupnotif'] = 'Activer la notification de progression';
$string['enablelevelupnotif_help'] = 'Lorsque ce réglage est à \'Oui\', une fenêtre surgissante sera affichée pour féliciter les étudiants du nouveau niveau atteint.';
$string['enablelogging'] = 'Activer l\'historique';
$string['enablexpgain'] = 'Activer le gain d\'expérience';
$string['enablexpgain_help'] = 'Si ce réglage est à \'Non\', personne ne pourra gagner des points d\'expérience dans ce cours. Ceci peut être utile pour bloquer l\'expérience acquise, ou pour la débloquer à un certain moment.

S\'il vous plait notez que ceci peut être controlé de manière plus fine  par la permission \'block/xp:earnxp\'.';
$string['errorformvalues'] = 'l y a quelques problèmes dans les valeurs de formulaire, s\'il vous plaît corrigez-les.';
$string['errorlevelsincorrect'] = 'Le nombre minimum de niveaux est 2';
$string['errornotalllevelsbadgesprovided'] = 'Tous les badges de niveau n\'ont pas été fournis. Manquant : {$a}';
$string['errorunknownevent'] = 'Erreur : événement inconnu';
$string['errorunknownmodule'] = 'Erreur : module inconnu';
$string['errorxprequiredlowerthanpreviouslevel'] = 'L\'expérience requise est inférieure ou égale à celle du précédent niveau.';
$string['eventis'] = 'L\'événement est {$a}';
$string['eventname'] = 'Nom de l\'événement';
$string['eventproperty'] = 'Propriété de l\'événement';
$string['eventtime'] = 'Heure de l\'événement';
$string['event_user_leveledup'] = 'Utilisateur promu';
$string['for1day'] = 'Pour 1 jour';
$string['for1month'] = 'Pour 1 mois';
$string['for1week'] = 'Pour une semaine';
$string['for3days'] = 'Pour 3 jours';
$string['forever'] = 'Pour toujours';
$string['forthewholesite'] = 'Pour tout le site';
$string['give'] = 'donne';
$string['incourses'] = 'Dans les cours';
$string['infos'] = 'Informations';
$string['invalidxp'] = 'Valeur d\'expérience invalide';
$string['keeplogs'] = 'Conserver l\'historique';
$string['ladder'] = 'Echelle';
$string['level'] = 'Niveau';
$string['levelbadges'] = 'Badges de niveau';
$string['levelbadgesformhelp'] = 'Nommez les fichiers [niveau].[extension de fichier] par exemple 1.png, 2.jpg, etc. La taille d\'image recommandée est 100 x 100.';
$string['levelcount'] = 'Nombre de niveaux';
$string['leveldesc'] = 'Description du niveau';
$string['levels'] = 'Niveaux';
$string['levelswillbereset'] = 'Attention ! Sauver ce formulaire recalculera le niveau de chaque participant !';
$string['levelup'] = 'Progressez !';
$string['levelx'] = 'Niveau #{$a}';
$string['likenotice'] = '<strong>Aimez-vous le plugin ?</strong> Prenez un moment pour <a href="{$a->moodleorg}" target="_blank">l\'ajouter à vos favoris</a> sur Moodle.org et <a href="{$a->github}" target="_blank">donnez-lui une étoile sur GitHub</a>.';
$string['logging'] = 'Historiques';
$string['maxactionspertime'] = 'Nombre max d\'actions par intervalle de temps';
$string['maxactionspertime_help'] = 'Le nombre maximal d\'actions qui seront prise en compte pour le calcul de l\'expérience au cours de la période de temps donnée. Toute action ultérieure sera ignorée.';
$string['movecondition'] = 'Déplacer la condition';
$string['moverule'] = 'Déplacer la règle';
$string['navinfos'] = 'Infos';
$string['navladder'] = 'Echelle';
$string['navlevels'] = 'Niveaux';
$string['navlog'] = 'Historique';
$string['navreport'] = 'Rapport';
$string['navrules'] = 'Règles';
$string['navsettings'] = 'Réglages';
$string['navvisuals'] = 'Visuels';
$string['participatetolevelup'] = 'Participez au cours pour gagner des points d\'expérience et progresser !';
$string['pickaconditiontype'] = 'Choisissez un type de condition';
$string['pluginname'] = 'Progressez !';
$string['progress'] = 'Progression';
$string['property:action'] = 'Action de l\'événement';
$string['property:component'] = 'Composant de l\'événement';
$string['property:crud'] = 'Event CRUD';
$string['property:eventname'] = 'Nom de l\'événement';
$string['property:target'] = 'Cible de l\'événement';
$string['rank'] = 'Rang';
$string['reallyresetdata'] = 'Really reset the levels and experience points of everyone in this course?';
$string['reallyresetgroupdata'] = 'Voulez-vous vraiment remettre à zéro les niveaux et points d\'expérience de tout le monde dans ce groupe ?';
$string['resetcoursedata'] = 'Réinitialiser les données du cours';
$string['resetgroupdata'] = 'Remettre à zéro les données du groupe';
$string['rule'] = 'Règle';
$string['rulecm'] = 'Activité ou ressource';
$string['rulecmdesc'] = 'L\'activité ou ressource est \'{$a->contextname}\'.';
$string['rule:contains'] = 'contient';
$string['rule:eq'] = 'est égal à';
$string['rule:eqs'] = 'est strictement égal à';
$string['ruleevent'] = 'Événement précis';
$string['ruleeventdesc'] = 'L\'événement est \'{$a->eventname}\'';
$string['rule:gt'] = 'est supérieur à';
$string['rule:gte'] = 'est supérieur ou égal à';
$string['rule:lt'] = 'est inférieur à';
$string['rule:lte'] = 'est inférieur ou égal à';
$string['ruleproperty'] = 'Propriété de l\'événement';
$string['rulepropertydesc'] = 'La propriété \'{$a->property}\' {$a->compare} \'{$a->value}\'.';
$string['rule:regex'] = 'correspond à l\'expression rationnelle';
$string['ruleset'] = 'Groupe de conditions';
$string['ruleset:all'] = 'TOUTES les conditions sont vraies';
$string['ruleset:any'] = 'UNE des conditions est vraie';
$string['ruleset:none'] = 'AUCUNE des conditions n\'est vraie';
$string['rulesformhelp'] = '<p> Ce plugin utilise les événements pour attribuer des points d\'expérience aux étudiants selon les actions effectuées. Vous pouvez utiliser le formulaire ci-dessous pour ajouter vos propres règles et voir celles par défaut. </p>
<p> Il est conseillé de vérifier le plugin <a href="{$a->log}">historique</a> pour identifier les événements qui sont déclenchés lorsque vous effectuez des actions dans le cours, et aussi pour en savoir plus sur les événements eux-mêmes: <a href="{$a->list}">liste de tous les événements</a> , <a href="{$a->doc}">documentation développeur</a> . </p>
<p> Enfin, veuillez noter que le plugin ignore toujours:
<ul>
    <li> Les actions effectuées par les administrateurs, invités ou non connectés. </li>
    <li> Les actions réalisées par des utilisateurs n\'ayant pas la permission <em>block/xp:earnxp</em>.</li>
    <li> Les actions répétées dans un court intervalle de temps, pour éviter la tricherie. </li>
    <li> Et les événements de niveau d\'éducation différent de <em>participation.</em> </li>
</ul>
</p>';
$string['timebetweensameactions'] = 'Temps requis entre deux actions identiques';
$string['timebetweensameactions_help'] = 'Temps minimum nécessaire en secondes entre les actions identiques. Une action est considéré comme identique si elle concerne le même contexte et le même l\'objet, la lecture d\'un message sur le forum sera considérée comme identique si le même message est relu.';
$string['timeformaxactions'] = 'Temps max pour un nombre max d\'actions';
$string['timeformaxactions_help'] = 'Le laps de temps (en secondes) pendant lequel l\'utilisateur ne doit pas excéder un nombre maximal d\'actions.';
$string['updateandpreview'] = 'Mise à jour et aperçu';
$string['usealgo'] = 'Utiliser l\'algorithme';
$string['usecustomlevelbadges'] = 'Utiliser les badges de niveau personnalisés';
$string['usecustomlevelbadges_help'] = 'Lorsque cette option est sur \'Oui\', vous devez fournir une image pour chaque niveau.';
$string['value'] = 'Valeur';
$string['valuessaved'] = 'Les valeurs ont été enregistrées avec succès';
$string['viewtheladder'] = 'Voir l\'échelle';
$string['when'] = 'Quand';
$string['wherearexpused'] = 'Où les points d\'expériences sont-ils utilisés ?';
$string['wherearexpused_desc'] = 'Quand \'Dans les cours\' est sélectionné, les points d\'expérience sont seulement acquis dans les cours où le bloc a été ajouté. Quand \'Pour tout le site\' est sélectionné, un utilisateur augmentera de niveau dans le site plutôt que par cours, toute l\'expérience reçue à travers le site sera utilisée.';
$string['xp'] = 'Points d\'expérience';
$string['xp:addinstance'] = 'Ajouter un nouveau bloc XP';
$string['xp:earnxp'] = 'Gagner des points d\'expérience';
$string['xpgaindisabled'] = 'Gain d\'expérience désactivé';
$string['xp:myaddinstance'] = 'Ajouter le bloc à mon tableau de bord';
$string['xprequired'] = 'Expérience requise';
$string['xp:view'] = 'Voir le bloc et ses pages relatives';
$string['youreachedlevela'] = 'Vous avez atteint le niveau {$a} !';
$string['yourownrules'] = 'Vos propres règles';
