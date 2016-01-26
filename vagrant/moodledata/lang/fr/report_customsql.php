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
 * Strings for component 'report_customsql', language 'fr', branch 'MOODLE_29_STABLE'
 *
 * @package   report_customsql
 * @copyright 1999 onwards Martin Dougiamas  {@link http://moodle.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['addcategory'] = 'Ajouter une nouvelle catégorie';
$string['addcategorydesc'] = 'Pour modifier la catégorie d\'un rapport, vous devez modifier ce rapport. Ici vous pouvez ajouter ou supprimer une catégorie, ou modifier son texte.';
$string['addreport'] = 'Ajouter une nouvelle requête';
$string['addreportcategory'] = 'Ajouter une nouvelle catégorie de rapports';
$string['anyonewhocanveiwthisreport'] = 'Toute personne pouvant voir ce rapport (report/customsql:view)';
$string['archivedversions'] = 'Versions archivées de cette requête';
$string['at'] = 'à';
$string['automaticallydaily'] = 'Planifiée, quotidien';
$string['automaticallymonthly'] = 'Planifiée, le premier jour de chaque mois';
$string['automaticallyweekly'] = 'Planifiée, le premier jour de chaque semaine';
$string['availablereports'] = 'Requêtes à la demande';
$string['availableto'] = 'Disponible pour {$a}.';
$string['backtoreportlist'] = 'Retour à la liste des requêtes';
$string['categorycontent'] = '({$a->manual} sur demande, {$a->daily} quotidien, {$a->weekly} hebdomadaire, {$a->monthly} mensuel)';
$string['categoryexists'] = 'Les noms de catégorie doivent être uniques ; ce nom existe déjà';
$string['categorynamex'] = 'Nom de catégorie : {$a}';
$string['changetheparameters'] = 'Changer les paramètres';
$string['customsql:definequeries'] = 'Définir des requêtes personnalisées';
$string['customsql:managecategories'] = 'Définir des catégories personnalisées';
$string['customsql:view'] = 'Voir les rapports personnalisés';
$string['dailyheader'] = 'Quotidien';
$string['dailyheader_help'] = 'Ces requêtes sont automatiquement exécutées chaque jour à l\'heure indiquée. Ces liens vous permettent d\'afficher les résultats qui ont déjà été recueillis.';
$string['defaultcategory'] = 'Divers';
$string['delete'] = 'Supprimer';
$string['deleteareyousure'] = 'Êtes vous certain de vouloir supprimer cette requête ?';
$string['deletecategoryareyousure'] = '<p>Êtes vous certain de vouloir supprimer cette catégorie ? </p><p>Elle ne doit pas contenir de requête.</p>';
$string['deletecategoryyesno'] = '<p>Êtes vous certain de vouloir supprimer cette catégorie ? </p>';
$string['deletethiscategory'] = 'Supprimer cette catégorie';
$string['deletethisreport'] = 'Supprimer cette requête';
$string['description'] = 'Description';
$string['displayname'] = 'Nom de la requête';
$string['displaynamerequired'] = 'Vous devez saisir un nom de requête';
$string['displaynamex'] = 'Nom de la requête : {$a}';
$string['downloadthisreportascsv'] = 'Télécharger le résultat sous forme CSV';
$string['edit'] = 'Ajouter/Modifier';
$string['editcategory'] = 'Mettre à jour la catégorie';
$string['editingareport'] = 'Modifier une requête personnalisée';
$string['editthiscategory'] = 'Modifier cette catégorie';
$string['editthisreport'] = 'Modifier cette requête';
$string['emailbody'] = 'Cher {$a}';
$string['emailink'] = 'Pour accéder au rapport, cliquez sur ce lien : {$a}';
$string['emailnumberofrows'] = 'Uniquement le nombre de lignes et le lien';
$string['emailresults'] = 'Inclure les résultats dans le corps du message';
$string['emailrow'] = 'Le rapport a retourné {$a} ligne.';
$string['emailrows'] = 'Le rapport a retourné {$a} lignes.';
$string['emailsent'] = 'Un courriel de notification a été envoyé à {$a}';
$string['emailsentfailed'] = 'Impossible d\'envoyer un courriel à {$a}';
$string['emailsubject'] = 'Requête {$a}';
$string['emailto'] = 'Envoyer automatiquement par courriel à';
$string['emailwhat'] = 'Contenu à envoyer';
$string['enterparameters'] = 'Entrez les paramètres pour la requête personnalisée';
$string['errordeletingcategory'] = '<p>Erreur de suppression d\'une catégorie de requête.</p><p>Elle doit être vide pour pouvoir être supprimée.</p>';
$string['errordeletingreport'] = 'Erreur lors de la suppression d\'une requête.';
$string['errorinsertingreport'] = 'Erreur lors de l\'insertion d\'une requête.';
$string['errorupdatingreport'] = 'Erreur lors de la modification d\'une requête.';
$string['invalidreportid'] = 'Identifiant de requête invalide {$a}.';
$string['lastexecuted'] = 'Dernière exécution le {$a->lastrun}. Durée d\'exécution : {$a->lastexecutiontime} s.';
$string['managecategories'] = 'Gérer les catégories de rapports';
$string['manual'] = 'Sur demande';
$string['manualheader'] = 'Sur demande';
$string['manualheader_help'] = 'Ces requêtes sont exécutées sur demande, lorsque vous cliquez sur le lien pour afficher les résultats.';
$string['messageprovider:notification'] = 'Notifications et alertes des rapports personnalisés';
$string['monthlyheader'] = 'Mensuel';
$string['monthlyheader_help'] = 'Ces requêtes sont exécutées automatiquement le premier jour de chaque mois pour faire rapport sur le mois précédent. Ces liens vous permettent d\'afficher les résultats qui ont déjà été recueillis.';
$string['monthlynote_help'] = 'Ces requêtes sont exécutées automatiquement le premier jour de chaque mois pour faire rapport sur le mois précédent. Ces liens vous permettent d\'afficher les résultats qui ont déjà été recueillis.';
$string['morethanonerowreturned'] = 'Plus d\'une ligne retournée comme résultat. Cette requête devrait retourner une seule ligne.';
$string['nodatareturned'] = 'Cette requête n\'a retourné aucun résultat.';
$string['noexplicitprefix'] = 'N\'incluez pas le préfixe de nom des tables <tt>{$a}</tt> dans la requête SQL. À la place, mettez le nom de table sans préfixe encadré de caractères  <tt>{}</tt>.';
$string['noreportsavailable'] = 'Pas de requête disponible';
$string['norowsreturned'] = 'Aucune ligne retournée comme résultat. Cette requête devrait retourner une ligne.';
$string['noscheduleifplaceholders'] = 'Les requêtes contenant des paramètres ne peuvent être exécutées qu\'à la demande.';
$string['nosemicolon'] = 'Vous ne pouvez pas utiliser le caractère ; dans la requête SQL.';
$string['notallowedwords'] = 'Vous ne pouvez pas utiliser les mots <tt>{$a}</tt> dans la requête SQL.';
$string['note'] = 'Notes';
$string['notrunyet'] = 'Cette requête n\'a pas encore été exécutée.';
$string['onerow'] = 'La requête retourne une ligne, accumulez les résultats ligne par ligne';
$string['parametervalue'] = '{$a->name} : {$a->value}';
$string['pluginname'] = 'Rapports personnalisés';
$string['query_deleted'] = 'Requête supprimée';
$string['query_edited'] = 'Requête modifée';
$string['queryfailed'] = 'Erreur à l\'exécution de la requête : {$a}';
$string['querylimit'] = 'Nombre limite de lignes retournées';
$string['querylimitrange'] = 'Le nombre doit être entre 1 et {$a}';
$string['querynote'] = '<ul>
<li>La chaîne <tt>%%WWWROOT%%</tt> dans les résultats sera remplacée par <tt>{$a}</tt>.</li>
<li>Tout champ de sortie ressemblant à une URL sera automatiquement transformé en lien.</li>
<li>Si un nom de colonne de résultat se termine par <tt>date</tt>, et que la colonne contient une valeur au format integer, elle sera traitée comme un timestamp Unix, et automatiquement convertie en date lisible par l\'homme.</li>
<li>La chaîne <tt>%%USERID%%</tt> dans la requête sera remplacée par l\'identifiant de l\'utilisateur visualisant le rapport, avant l\'exécution du rapport.</li>
<li>Pour des rapports programmés, les chaînes <tt>%%STARTTIME%%</tt> et <tt>%%ENDTIME%%</tt> sont remplacées par le timestamp Unix du début et de fin de semaine/mois du rapport dans la requête avant son exécution.</li>
<li>Vous pouvez inclure des paramètres dans la requête SQL en utilisant des marqueurs nommés, par exemple <tt>:nom_parametre</tt>. Ainsi quand le rapport est exécuté, l\'utilisateur peut entrer les valeurs des paramètres à utiliser lorsque la requête est exécutée.</li>
<li>Si le <tt>:nom_parametre</tt> commence ou se termine par les caractères <tt>date</tt> alors un sélecteur de date sera utilisé pour l\'entrée de la valeur de ce paramètre, dans les autres cas un champ texte est utilisé.</li>
<li>Vous ne pouvez pas utiliser les caractères  <tt>:</tt> ou <tt>?</tt> dans les chaînes à l\'intérieur de votre requête. Si vous avez besoin de ces caractères, vous pouvez utiliser <tt>CHR(58)</tt> et <tt>CHR(63)</tt> respectivement ainsi que la concaténation des chaînes. (Qui est <tt>CHR</tt> pour Postgres ou Oracle, <tt>CHAR</tt> pour MySQL ou SQL server.)</li>
</ul>';
$string['queryparameters'] = 'Paramètres de la requête';
$string['queryparams'] = 'Entrez les valeurs par défaut des paramètres de la requête';
$string['queryparamschanged'] = 'Les paramètres dans la requête ont changé.';
$string['queryrundate'] = 'date d\'exécution de la requête';
$string['querysql'] = 'Requête SQL';
$string['querysqlrequried'] = 'Vous devez saisir du code SQL';
$string['query_viewed'] = 'Requête consultée';
$string['recordlimitreached'] = 'Cette requête a atteint la limite de {$a} lignes de résultat. Des lignes ont certainement été omises à la fin.';
$string['reportfor'] = 'Requête exécutée le {$a}';
$string['requireint'] = 'Une valeur entière est requise';
$string['runable'] = 'Exécution';
$string['runablex'] = 'Exécution : {$a}.';
$string['schedulednote'] = 'Ces requêtes sont lancées automatiquement le premier jour de chaque semaine ou chaque mois, pour des rapports sur la semaine ou le mois précédent. Ces liens vous permettent de visualiser les résultats qui ont déjà été accumulés.';
$string['scheduledqueries'] = 'Requêtes programmées';
$string['selectcategory'] = 'Sélectionnez la catégorie de ce rapport';
$string['typeofresult'] = 'Type de résultat';
$string['unknowndownloadfile'] = 'Fichier à télécharger inconnu.';
$string['userhasnothiscapability'] = 'L\'utilisateur \'{$a->username}\' n\'a pas la permission \'{$a->capability}\'. Supprimez cet utilisateur de la liste ou changez le choix dans  \'{$a->whocanaccess}\'.';
$string['userinvalidinput'] = 'Entrée invalide, une liste de noms d\'utilisateurs séparée par des virgules est requise';
$string['usernotfound'] = 'L\'utilisateur avec le nom  \'{$a}\' n\'existe pas';
$string['userswhocanconfig'] = 'Administrateurs uniquement (moodle/site:config)';
$string['userswhocanviewsitereports'] = 'Utilisateurs pouvant voir les rapports (moodle/site:viewreports)';
$string['verifyqueryandupdate'] = 'Vérifier le texte de la requête SQLet mettre à jour le formulaire';
$string['weeklyheader'] = 'Hebdomadaire';
$string['weeklyheader_help'] = 'Ces requêtes sont exécutées automatiquement le premier jour de chaque semaine, pour faire rapport sur la semaine précédente. Ces liens vous permettent d\'afficher les résultats qui ont déjà été recueillis.';
$string['whocanaccess'] = 'Qui peut accéder à cette requête';
