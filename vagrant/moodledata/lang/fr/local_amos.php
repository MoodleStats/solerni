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
 * Strings for component 'local_amos', language 'fr', branch 'MOODLE_27_STABLE'
 *
 * @package   local_amos
 * @copyright 1999 onwards Martin Dougiamas  {@link http://moodle.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['about'] = '<p>AMOS est le dépôt central des chaînes de caractères de Moodle, avec leur historique. AMOS détecte l\'ajout de chaînes en anglais dans le code source de Moodle, rassemble les traductions, gère les tâches fréquentes de traduction et génère les paquetages de langue afin de les mettre à disposition des serveurs Moodle.</p>
<p>Référez-vous à la <a href="http://docs.moodle.org/fr/AMOS">documentation de AMOS</a> pour plus de renseignements.</p>';
$string['amos'] = 'Utilitaire de traduction AMOS';
$string['amos:commit'] = 'Implanter les chaînes du chantier dans le dépôt central';
$string['amos:execute'] = 'Lancer le AMOScript donné';
$string['amos:importfile'] = 'Importer des chaînes d\'un fichier et les placer dans le chantier';
$string['amos:importstrings'] = 'Importer directement les chaînes (y compris chaînes en anglais) dans le dépôt central';
$string['amos:manage'] = 'Gérer le portail AMOS';
$string['amos:stage'] = 'Utiliser l\'outil de traduction AMOS et proposer des chaînes';
$string['amos:stash'] = 'Enregistrer le chantier actuel dans un entrepôt permanent';
$string['amos:usegoogle'] = 'Utiliser les services de Google Translate';
$string['commitbutton'] = 'Implanter';
$string['commitkeepstaged'] = 'Conserver les chaînes dans le chantier';
$string['commitmessage'] = 'Message d\'implantation';
$string['commitmessageempty'] = 'Veuillez saisir un message décrivant l\'implantation';
$string['commitstage'] = 'Implanter les chaînes du chantier';
$string['commitstage_help'] = 'Enregistrer de façon permanente les traductions du chantier dans le dépôt central de AMOS. Le chantier est automatiquement nettoyé avant d\'effectuer l\'implantation et entièrement vidé après l\'implantation.';
$string['committableall'] = 'toutes les langues';
$string['committablenone'] = 'aucune langue permise ; veuillez contacter le gestionnaire de AMOS';
$string['componentsall'] = 'Tout';
$string['componentsenlarge'] = 'Agrandir';
$string['componentsnone'] = 'Aucun';
$string['componentsstandard'] = 'Standard';
$string['confirmaction'] = 'Cette opération ne peut pas être annulée. Voulez-vous vraiment continuer ?';
$string['contribaccept'] = 'Accepter';
$string['contribactions'] = 'Actions sur les traductions proposées';
$string['contribactions_help'] = 'Selon vos autorisations et le processus de contribution des traductions, les actions suivantes sont disponibles.

* Appliquer : copier la traduction proposée dans votre chantier, sans modifier l\'état de la contribution ;
* Attribuer à moi : vous désigner comme responsable de la contribution, c\'est-à-dire la personne chargée de l\'examen de la contribution et de son intégration ;
* Retirer l\'attribution : ne désigner personne comme responsable de la contribution ;
* Examiner : vous attribuer la nouvelle contribution, fixer son statut à « En cours d\'examen » et copier la traduction proposée dans votre chantier.
* Accepter : marquer la contribution comme acceptée ;
* Rejeter : marquer la contribution comme rejetée. Veuillez indiquer en commentaire la raison du rejet.

Le contributeur est informé par courriel lors de chaque modification du statut de sa contribution.';
$string['contribapply'] = 'Appliquer';
$string['contribassignee'] = 'Responsable';
$string['contribassigneenone'] = '-';
$string['contribassigntome'] = 'Attribuer à moi';
$string['contribauthor'] = 'Auteur';
$string['contribclosedno'] = 'Masquer les contributions résolues';
$string['contribclosedyes'] = 'Afficher les contributions résolues';
$string['contribcomponents'] = 'Composants';
$string['contribid'] = 'ID';
$string['contribincomingnone'] = 'Pas de contribution arrivée';
$string['contribincomingsome'] = 'Contributions arrivées ({$a})';
$string['contriblanguage'] = 'Langue';
$string['contribnotif'] = '[AMOS] Notification de contribution (#{$a->id})';
$string['contribnotifaccepted'] = '{$a->fullname} a accepté votre contribution de traduction
#{$a->id} {$a->subject}

---------------------------------------------------------------------
Page de la contribution : {$a->contriburl}';
$string['contribnotifcommented'] = '{$a->fullname} a commenté votre contribution de traduction
#{$a->id} {$a->subject}
---------------------------------------------------------------------

{$a->message}

---------------------------------------------------------------------
Page de la contribution : {$a->contriburl}';
$string['contribnotifpending'] = 'Une contribution de traduction en attente requiert une action de votre part
#{$a->id} {$a->subject}

En tant que mainteneur du paquetage de langue, vous êtes censé relire et le cas échéant implanter toutes les contributions de traduction. Une fois ceci fait, veuillez marquer les contributions comme acceptées ou rejetées.

Voyez {$a->docsurl} pour plus d\'information.
---------------------------------------------------------------------
Page de la contribution : {$a->contriburl}';
$string['contribnotifrejected'] = '{$a->fullname} a rejeté votre contribution de traduction
#{$a->id} {$a->subject}

---------------------------------------------------------------------
Page de la contribution : {$a->contriburl}';
$string['contribnotifsubmitted'] = '{$a->fullname} a proposé une contribution de traduction
#{$a->id} {$a->subject}
---------------------------------------------------------------------

{$a->message}

* Langue : {$a->language}
* Composants : {$a->components}
* Chaînes : {$a->strings}

---------------------------------------------------------------------
Page de la contribution : {$a->contriburl}';
$string['contribreject'] = 'Rejeter';
$string['contribresign'] = 'Retirer l\'attribution';
$string['contribstaged'] = 'Contribution <a href="contrib.php?id={$a->id}">#{$a->id}</a> de {$a->author} copiée dans le chantier';
$string['contribstagedinfo'] = 'Contribution copiée dans le chantier';
$string['contribstagedinfo_help'] = 'Le chantier contient les chaînes proposées par un contributeur. Le responsable du paquetage de langue est censé les examiner, puis changer le statut de la contribution en Acceptée (si elles ont été implantées) ou Rejetée (si elles n\'ont pas pu être incorporées dans le paquetage pour une raison ou une autre).';
$string['contribstartreview'] = 'Examiner';
$string['contribstatus'] = 'Statut';
$string['contribstatus0'] = 'Nouvelle';
$string['contribstatus10'] = 'En cours d\'examen';
$string['contribstatus20'] = 'Rejetée';
$string['contribstatus30'] = 'Acceptée';
$string['contribstatus_help'] = 'Une contribution à la traduction passe par les états suivants :

* Nouvelle : la contribution a été envoyée, mais n\'a pas encore été traitée.
* En cours d\'examen : la contribution a été attribuée à un responsable du paquetage de langue et mise en chantier pour examen.
* Rejetée : le responsable du paquetage de langue a rejeté la contribution et vraisemblablement donné une explication en commentaire.
* Acceptée : la contribution a été acceptée par le responsable du paquetage de langue.';
$string['contribstrings'] = 'Chaînes';
$string['contribstringseq'] = '{$a->orig} nouveaux';
$string['contribstringsnone'] = '{$a->orig} (toutes sont déjà traduites dans le paquetage de langue)';
$string['contribstringssome'] = '{$a->orig} ({$a->same} d\'entre elles ont déjà une traduction plus récente)';
$string['contribsubject'] = 'Sujet';
$string['contribsubmittednone'] = 'Aucune contribution envoyée';
$string['contribsubmittedsome'] = 'Vos contributions ({$a})';
$string['contribtimemodified'] = 'Modifié';
$string['contribute'] = 'Contribuer';
$string['contributenow'] = 'Contribuez maintenant !';
$string['contributestats'] = 'À ce jour, <strong>{$a->count}</strong> chaînes traduites par des membres de la communauté ont été intégrées dans AMOS.';
$string['contributethanks'] = 'Mille mercis à {$a->listcontributors} pour leurs contributions récentes !';
$string['contributions'] = 'Contributions';
$string['creditsaddcontributor'] = 'Ajouter un contributeur';
$string['creditsaddmaintainer'] = 'Ajouter un mainteneur';
$string['creditscontact'] = 'Envoyer message';
$string['creditscontributors'] = 'Autres contributeurs';
$string['creditsdelcontributor'] = 'Supprimer un contributeur';
$string['creditsdelmaintainer'] = 'Supprimer un mainteneur';
$string['creditsmaintainedby'] = 'Maintenu par';
$string['creditsnomaintainer'] = 'Pas de mainteneur actuellement. <a href="{$a->url}">Devenez mainteneur !</a>';
$string['creditsthanks'] = 'Sur cette page, nous tenons à remercier toutes les personnes ayant contribué aux traductions de Moodle. Leur travail a permis le développement de Moodle dans le monde.';
$string['creditstitlelong'] = 'Mainteneurs et contributeurs des paquetages de langue';
$string['creditstitleshort'] = 'Remerciements';
$string['diff'] = 'Comparer';
$string['diffaction'] = 'Si une différence est détectée';
$string['diffaction1'] = 'Placer dans le chantier les deux chaînes dans leur branche respective';
$string['diffaction2'] = 'Placer dans le chantier la chaîne la plus récente dans les deux branches';
$string['diffmode'] = 'Placer les chaînes dans le chantier si';
$string['diffmode1'] = 'Les chaînes en anglais ont été modifiées, mais pas les chaînes traduites';
$string['diffmode2'] = 'Les chaînes traduites ont été modifiées, mais pas les chaînes en anglais';
$string['diffmode3'] = 'Soit les chaînes en anglais ont été modifiées, soit les chaînes traduites l\'ont été (mais pas les deux)';
$string['diffmode4'] = 'Les chaînes en anglais et les chaînes traduites ont été modifiées';
$string['diffprogress'] = 'Comparer les branches sélectionnées';
$string['diffprogressdone'] = '{$a} différences trouvées';
$string['diffstringmode'] = 'Changer de mode diff';
$string['diffstrings'] = 'Comparer les chaînes de deux branches';
$string['diffstrings_help'] = 'Ceci compare les chaînes des deux branches sélectionnées. S\'il y a des différences entre les chaînes des deux branches, les deux versions sont placées dans le chantier. Vous pouvez utiliser « Modifier les chaînes du chantier » pour relire les chaînes et effectuer les modifications nécessaires.';
$string['diffversions'] = 'Versions';
$string['err_exception'] = 'Erreur : {$a}';
$string['err_invalidlangcode'] = 'Code de langue non valide';
$string['err_parser'] = 'Erreur d\'analyse : {$a}';
$string['filtercmp'] = 'Composants';
$string['filtercmp_desc'] = 'Afficher les chaînes de ces composants';
$string['filtercmpnothingselected'] = 'Veuillez sélectionner au moins un composant';
$string['filterlng'] = 'Langues';
$string['filterlng_desc'] = 'Afficher les traductions dans ces langues';
$string['filterlngnothingselected'] = 'Veuillez sélectionner au moins une langue';
$string['filtermis'] = 'Divers';
$string['filtermis_desc'] = 'Conditions supplémentaires sur les chaînes à afficher';
$string['filtermisfglo'] = 'seulement chaînes en liste grise';
$string['filtermisfhlp'] = 'seulement chaînes d\'aide';
$string['filtermisfmis'] = 'seulement chaînes manquantes ou obsolètes';
$string['filtermisfstg'] = 'seulement chaînes du chantier';
$string['filtermisfwog'] = 'sans les chaînes en liste grise';
$string['filtersid'] = 'Identifiant de chaîne de caractères';
$string['filtersid_desc'] = 'La clef, dans un tableau de chaînes de caractères';
$string['filtersidpartial'] = 'correspondance partielle';
$string['filtertxt'] = 'Chaîne partielle';
$string['filtertxtcasesensitive'] = 'sensible à la casse';
$string['filtertxt_desc'] = 'La chaîne doit contenir le texte saisi';
$string['filtertxtregex'] = 'expression régulière';
$string['filterver'] = 'Versions';
$string['filterver_desc'] = 'Afficher les chaînes de ces versions de Moodle';
$string['filtervernothingselected'] = 'Veuillez sélectionner au moins une version';
$string['found'] = '{$a->found} chaînes &nbsp;&nbsp;&nbsp; Manquantes : {$a->missing} ({$a->missingonpage})';
$string['foundinfo'] = 'Nombre de chaînes trouvées';
$string['foundinfo_help'] = 'Affiche le nombre total de rangées de la table de traduction, le nombre de traductions manquantes et le nombre de traductions manquantes sur la page affichée.';
$string['googletranslate'] = 'Traduction Google';
$string['gotofirst'] = 'vers la première page';
$string['gotoprevious'] = 'vers la page précédente';
$string['greylisted'] = 'Chaînes en liste grise';
$string['greylisted_help'] = 'Pour des raisons de compatibilité, un paquetage de langue Moodle contient parfois des chaînes de caractères qui ne sont plus utilisées, mais n\'ayant pas encore été supprimées. Ces chaînes sont placées dans une « liste grise ». Après confirmation par les développeurs qu\'une chaîne en liste grise n\'est plus utilisée nulle part dans le code, la chaîne est supprimée définitivement du paquetage.

Vous pouvez gagner un temps considérable en ne traduisant que les chaînes qui ne sont pas en liste grise.

Si vous constatez qu\'une chaîne en liste grise est encore utilisée dans Moodle, veuillez nous en informer sur le forum « Translating Moodle » sur ce site.';
$string['greylistedwarning'] = 'en liste grise';
$string['importfile'] = 'Importer des chaînes traduites à partir d\'un fichier';
$string['importfile_help'] = 'Si vous avez traduit des chaînes localement sur votre ordinateur, vous pouvez les placer dans le chantier au moyen de ce formulaire.

* Le fichier doit être un fichier de chaînes Moodle valide, en PHP. Voir le dossier « /lang/en » de votre installation de Moodle pour des exemples.
* Le nom du fichier doit correspondre exactement (en anglais) à celui du composant comportant les chaînes traduites, par exemple « moodle.php », « assignment.php » ou « enrol_manual.php ».

Toutes les chaînes contenues dans le fichier seront placées dans le chantier, pour la version et la langue sélectionnées.

Plusieurs fichiers PHP peuvent être traités simultanément si vous les compressez dans un même fichier ZIP.';
$string['language'] = 'Langue';
$string['languages'] = 'Langues';
$string['languagesall'] = 'Tout';
$string['languagesnone'] = 'Aucun';
$string['log'] = 'Historiques';
$string['logfilterbranch'] = 'Versions';
$string['logfiltercommithash'] = 'Hachage git';
$string['logfiltercommitmsg'] = 'Le message d\'implantation contient';
$string['logfiltercommits'] = 'Filtre des implantations';
$string['logfiltercommittedafter'] = 'Implanté après';
$string['logfiltercommittedbefore'] = 'Implanté avant';
$string['logfiltercomponent'] = 'Composants';
$string['logfilterlang'] = 'Langues';
$string['logfiltershow'] = 'Afficher les implantations et les chaînes filtrées';
$string['logfiltersource'] = 'Source';
$string['logfiltersourceamos'] = 'amos (application web de traduction)';
$string['logfiltersourceautomerge'] = 'fusion (copie de la traduction depuis une autre branche)';
$string['logfiltersourcebot'] = 'bot (opérations en lot exécutées par un script)';
$string['logfiltersourcecommitscript'] = 'commitscript (AMOScript dans le message d\'implantation)';
$string['logfiltersourcefixdrift'] = 'fixdrift (correction du décalage AMOS-git)';
$string['logfiltersourcegit'] = 'git (miroir git du code source de Moodle et paquetages pour 1.x)';
$string['logfiltersourceimport'] = 'importation (chaînes importées pour un plugin tiers)';
$string['logfiltersourcerevclean'] = 'revclean (inversion du processus de nettoyage)';
$string['logfilterstringid'] = 'Identifiant de chaîne';
$string['logfilterstrings'] = 'Filtre de chaîne';
$string['logfilterusergrp'] = 'Auteur de l\'implantation';
$string['logfilterusergrpor'] = 'ou';
$string['maintainers'] = 'Responsables';
$string['markuptodate'] = 'Marquer la traduction comme à jour';
$string['markuptodate_help'] = 'AMOS a détecté que cette chaîne n\'est peut-être plus correcte, car la version anglaise a été modifiée depuis la dernière traduction. Veuillez vérifier la traduction. Si elle est à jour, cochez la case. Sinon, modifiez la chaîne.';
$string['markuptodatelabel'] = 'Marquer comme à jour';
$string['merge'] = 'Fusionner';
$string['mergestrings'] = 'Fusionner les chaînes d\'une autre branche';
$string['mergestrings_help'] = 'Ceci sélectionnera et placera dans le chantier toutes les chaînes de la branche source qui ne sont pas encore traduites dans la branche cible. Vous pouvez utiliser cet outil pour copier les chaînes traduites dans les autres versions du paquetage de langue. Seuls les responsables officiels peuvent utiliser cet outil.';
$string['messageprovider:checker'] = 'Résultats de la vérification du paquetage de langue';
$string['messageprovider:contribution'] = 'Contributions de traduction';
$string['morefilteringoptions'] = 'Plus d\'options';
$string['newlanguage'] = 'Nouvelle langue';
$string['nodiffs'] = 'Aucune différence trouvée';
$string['nofiletoimport'] = 'Veuillez fournir un fichier à importer.';
$string['nologsfound'] = 'Aucune chaîne trouvée. Veuillez modifier les filtres';
$string['nostringsfound'] = 'Aucune chaîne trouvée';
$string['nostringsfoundonpage'] = 'Aucune chaîne trouvée sur la page {$a}';
$string['nostringtoimport'] = 'Aucune chaîne de caractères n\'a été trouvée dans le fichier. Assurez-vous que le fichier a un nom correct et qu\'il est formaté de façon appropriée.';
$string['nothingtomerge'] = 'La branche source ne contient aucune nouvelle chaîne manquante dans la branche source. Il n\'y a rien à fusionner.';
$string['nothingtostage'] = 'L\'opération n\'a retourné aucune chaîne à placer dans le chantier.';
$string['novalidzip'] = 'Impossible de décompresser le fichier ZIP.';
$string['numofcommitsabovelimit'] = '{$a->found} implantations correspondant au filtre, affichage des {$a->limit} plus récentes';
$string['numofcommitsunderlimit'] = '{$a->found} implantations correspondant au filtre';
$string['numofmatchingstrings'] = 'Parmi celles-ci, {$a->strings} modifications dans {$a->commits} implantations correspondent au filtre';
$string['outdatednotcommitted'] = 'Chaîne obsolète';
$string['outdatednotcommitted_help'] = 'AMOS a détecté que cette chaîne n\'est peut-être plus correcte, car la version anglaise a été modifiée depuis la dernière traduction. Veuillez vérifier la traduction.';
$string['outdatednotcommittedwarning'] = 'Obsolète';
$string['ownstashactions'] = 'Action d\'entrepôt';
$string['ownstashactions_help'] = '* Appliquer : copie les chaînes traduites de l\'entrepôt vers le chantier et conserve l\'entrepôt sans modification. Si une chaîne est déjà dans le chantier, elle sera écrasée par la chaîne de l\'entrepôt.
* Copier et jeter : copie les chaînes traduites de l\'entrepôt vers le chantier et supprime l\'entrepôt (équivalent à appliquer, puis jeter).
* Jeter : supprime l\'entrepôt et tout ce qu\'il contient.
* Proposer : ouvre un formulaire vous permettant de proposer vos traductions aux responsables officiels pour qu\'ils puissent l\'implanter dans le paquetage de langue officiel.';
$string['ownstashes'] = 'Vos entrepôts';
$string['ownstashes_help'] = 'Ceci est la liste de vos entrepôts';
$string['ownstashesnone'] = 'Vous n\'avez pas d\'entrepôt';
$string['permalink'] = 'Permalien';
$string['placeholder'] = 'Paramètres';
$string['placeholder_help'] = 'Les paramètres sont des expressions telles que « {$a} » ou « {$a->blabla} » dans une chaîne de caractères. Lorsque la chaîne est affichée dans Moodle, ils sont remplacés par une valeur.

Il est important de les copier à l\'identique, tels que présents dans la chaîne originale. Ne les traduisez pas et ne modifiez pas leur orientation de gauche à droite.';
$string['placeholderwarning'] = 'Paramètres';
$string['pluginclasscore'] = 'Sous-systèmes centraux';
$string['pluginclassnonstandard'] = 'Plugins non-standards';
$string['pluginclassstandard'] = 'Plugins standards';
$string['pluginname'] = 'AMOS';
$string['presetcommitmessage'] = 'Traduction #{$a->id} proposée par {$a->author}';
$string['presetcommitmessage2'] = 'Fusion de chaînes manquantes, de la branche {$a->source} vers la branche {$a->target}.';
$string['presetcommitmessage3'] = 'Correction des différences entre {$a->versiona} et {$a->versionb}';
$string['privileges'] = 'Vos autorisations';
$string['privilegesnone'] = 'Vous avez accès en lecture seule à l\'information publique.';
$string['processing'] = 'Traitement en cours...';
$string['propagate'] = 'Propager les traductions';
$string['propagatednone'] = 'Pas de traduction propagée';
$string['propagatedsome'] = '{$a} chaînes propagées';
$string['propagate_help'] = 'Les traductions du chantier peuvent être propagées à d\'autres branches. AMOS passe en revue la liste des traductions du chantier et tente de les appliquer à chacune des branches cochées. La propagation n\'est pas possible si :

* la chaîne originale en anglais de branche du chantier est différente de celle de la branche de destination, ou
* la chaîne est placée dans le chantier dans plusieurs branches, avec des traductions différentes.';
$string['propagaterun'] = 'Propager';
$string['quicklinks'] = 'Liens rapides';
$string['quicklinks_amos'] = 'Utilitaire de traduction';
$string['quicklinks_forum'] = 'Forum de traduction';
$string['quicklinks_manual'] = 'Manuel utilisateur';
$string['quicklinks_newcomers'] = 'Aide pour les débutants';
$string['requestactions'] = 'Action';
$string['requestactions_help'] = '* Appliquer : copie les chaînes traduites vers le chantier. Si une chaîne est déjà dans le chantier, elle sera écrasée par la chaîne de l\'entrepôt.
* Masquer : bloque la contribution de sorte qu\'elle ne soit plus affichée.';
$string['savefilter'] = 'Enregistrer les réglages du filtre';
$string['script'] = 'AMOScript';
$string['scriptexecute'] = 'Lancer et placer le résultat dans le chantier';
$string['script_help'] = 'Un AMOScript est un jeu d\'instructions à exécuter sur le dépôt central des chaînes.';
$string['sourceversion'] = 'Version source';
$string['stage'] = 'Chantier';
$string['stageactions'] = 'Action de chantier';
$string['stageactions_help'] = '* Modifier les chaînes du chantier : modifie le filtre de sorte que seules les traductions du chantier sont affichées.
* Nettoyer les chaînes non implantables : retirer du chantier toutes les traductions que vous ne pouvez pas implanter. Le chantier est nettoyé automatiquement avant toute implantation.
* Rebaser : retirer du chantier toutes les traductions qui soit ne modifient pas la traduction actuelle, soit sont plus anciennes que la traduction la plus récente dans le dépôt officiel. Le chantier est automatiquement rebasé avant toute implantation.
* Tout retirer : vide complètement le chantier. Toutes les traductions du chantier sont perdues.';
$string['stageedit'] = 'Modifier les chaînes du chantier';
$string['stageprune'] = 'Nettoyer non implantable';
$string['stagerebase'] = 'Rebaser';
$string['stagestringsnocommit'] = 'Il y a {$a->staged} chaînes dans le chantier';
$string['stagestringsnone'] = 'Il n\'y a aucune chaîne dans le chantier';
$string['stagestringssome'] = '{$a->staged} chaînes dans le chantier. {$a->committable} sont implantables.';
$string['stagesubmit'] = 'Envoyer les chaînes aux mainteneurs du paquetage de langue';
$string['stagetoolopen'] = 'Aller au chantier';
$string['stagetranslation'] = 'Traduction';
$string['stagetranslation_help'] = 'Affiche la traduction du chantier prête à être implantée. La couleur de fond de la cellule signifie :

* vert : vous avez ajouté une nouvelle traduction manquante et pouvez l\'implanter.
* jaune : vous avez modifié une chaîne et pouvez implanter la modification.
* bleu : vous avez modifié une chaîne ou ajouté une nouvelle traduction, mais n\'avez pas le droit de l\'implanter.
* sans couleur : la traduction du chantier est la même que la traduction déjà existante, et ne sera donc pas implantée.';
$string['stageunstageall'] = 'Tout retirer du chantier';
$string['stashactions'] = 'Enregistrer le travail en cours';
$string['stashactions_help'] = 'Un entrepôt est une copie de votre chantier actuel. Les entrepôts peuvent être proposés aux responsables officiels du paquetage de langue pour inclusion dans celui-ci.';
$string['stashapply'] = 'Appliquer';
$string['stashautosave'] = 'Entrepôt enregistré automatiquement';
$string['stashautosave_help'] = 'Cet entrepôt contient une copie de votre chantier le plus récent. Vous pouvez l\'utiliser comme une sauvegarde, dans le cas où vos chaînes sont retirées accidentellement du chantier, par exemple. Cliquez sur Appliquer pour copier toutes les chaînes de l\'entrepôt dans le chantier (ceci écrasera les chaînes qui sont déjà dans le chantier),';
$string['stashcomponents'] = '<span>Composants :</span> {$a}';
$string['stashdrop'] = 'Jeter';
$string['stashes'] = 'Entrepôts';
$string['stashlanguages'] = '<span>Langues :</span> {$a}';
$string['stashpop'] = 'Copier et jeter';
$string['stashpush'] = 'Copier les chaînes du chantier dans un nouvel entrepôt';
$string['stashstrings'] = '<span>Nombre de chaînes :</span> {$a}';
$string['stashsubmit'] = 'Proposer aux responsables';
$string['stashsubmitdetails'] = 'Détails de la proposition';
$string['stashsubmitmessage'] = 'Message';
$string['stashsubmitsubject'] = 'Objet';
$string['stashtitle'] = 'Titre de l\'entrepôt';
$string['stashtitledefault'] = 'Travail en cours – {$a->time}';
$string['stringhistory'] = 'Historique';
$string['strings'] = 'Chaînes';
$string['submitting'] = 'Proposer une contribution';
$string['submitting_help'] = 'Ceci enverra les chaînes traduites aux responsables officiels de la traduction. Ils pourront alors reprendre votre travail dans leur chantier, le relire et l\'implanter. Veuillez leur fournir un message décrivant votre travail et pourquoi vous désirez que votre contribution soit incluse dans la traduction.';
$string['targetversion'] = 'Version cible';
$string['timeline'] = 'Historique';
$string['translatortool'] = 'Utilitaire de traduction';
$string['translatortoolopen'] = 'Ouvrir l\'utilitaire de traduction';
$string['translatortranslation'] = 'Traduction';
$string['translatortranslation_help'] = 'Cliquez dans la cellule pour la transformer en champ d\'édition. Insérez la traduction et cliquez en dehors du champ pour placer la traduction dans votre chantier. La couleur de fond de la cellule signifie :

* vert : la chaîne est déjà traduite et vous pouvez la modifier et l\'implanter.
* jaune : la chaîne est peut-être obsolète. La version anglaise a peut-être été modifiée après que la chaîne a été traduite.
* rouge : la chaîne n\'est pas traduite.
* bleu : vous avez modifié la traduction qui est maintenant dans votre chantier.
* gris : AMOS ne peut pas être utilisé pour traduire la chaîne. Par exemple, les chaînes de la version 1.9 de Moodle ne peuvent être modifiées qu\'au moyen de l\'ancien processus, via CVS.

Les responsables des paquetages de langue peuvent voir un petit symbole rouge dans le coin des cellules dont ils peuvent implanter le contenu.';
$string['typecontrib'] = 'Plugins non-standards';
$string['typecore'] = 'Sous-systèmes centraux';
$string['typestandard'] = 'Plugins standards';
$string['unableenfixaddon'] = 'Les correctifs pour l\'anglais ne sont acceptés que pour les plugins standards';
$string['unableenfixcountries'] = 'Les noms de pays sont tirés de la norme ISO 3166-1';
$string['unstage'] = 'Retirer du chantier ?';
$string['unstageconfirm'] = 'Vraiment ?';
$string['unstaging'] = 'Retrait du chantier';
$string['version'] = 'Version';
