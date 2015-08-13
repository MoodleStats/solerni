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

$string['attachments'] = "Pièces jointes";
$string['oublog'] = 'OU blog';
$string['modulename'] = 'OU blog';
$string['modulenameplural'] = 'OU blogs';
$string['modulename_help'] = 'L\'activité blog permet la création de blogs dans un cours (il s\'agit de blogs distincts de ceux du système de blog du coeur de Moodle). Vous pouvez créer des blogs pour un cours entier (tous les participants à un cours postent dans le même blog), pour un groupe, ou des blogs individuels.';

$string['oublogintro'] = 'Intro';

$string['oublog:view'] = 'Afficher les billets';
$string['oublog:addinstance'] = 'Créer un OU blog';
$string['oublog:viewpersonal'] = 'Afficher les billets des blogs personnels';
$string['oublog:viewprivate'] = 'Afficher les billets privés des blogs personnels';
$string['oublog:contributepersonal'] = 'Publier et commenter sur les blogs personnels';
$string['oublog:post'] = 'Créer un billet';
$string['oublog:comment'] = 'Commenter un billet';
$string['oublog:managecomments'] = 'Administrer les commentaires';
$string['oublog:manageposts'] = 'Administrer les billets';
$string['oublog:managelinks'] = 'Administrer les liens';
$string['oublog:audit'] = 'Afficher les billets effacés et les anciennes versions';
$string['oublog:viewindividual'] = 'Afficher les blogs personnels';
$string['oublog:exportownpost'] = 'Exporter votre billet';
$string['oublog:exportpost'] = 'Exporter un billet';
$string['oublog:exportposts'] = 'Exporter des billets';
$string['mustprovidepost'] = 'Vous devez fournir un postid';
$string['newpost'] = 'Nouveau {$a} billet';
$string['removeblogs'] = 'Supprimer le contenu du blog';
$string['title'] = 'Titre';
$string['message'] = 'Message';
$string['tags'] = 'Tags';
$string['tagsfield'] = 'Tags (séparés par des virgules)';
$string['allowcomments'] = 'Autoriser les commentaires';
$string['allowcommentsmax'] = 'Autoriser les commentaires (si sélectionné pour les billets) [TODO]';
$string['logincomments'] = 'Oui, pour les utilisateurs authentifiés';
$string['permalink'] = 'Permalien';
$string['publiccomments'] = 'Oui, de tout le monde (anonymes compris)';
$string['publiccomments_info'] = 'Si une personne non connectée poste un commentaire, vous recevrez une notification par email et pourrez l\'approuver ou le rejeter. Cette validation est nécessaire pour lutter contre les spams.';
$string['error_grouppubliccomments'] = 'Vous ne pouvez pas autoriser les commentaires publics sur un blog de groupe.';
$string['nocomments'] = 'Les commentaires ne sont pas autorisés';
$string['visibility'] = 'Qui peut lire cela ?';
$string['visibility_help'] = '
<p><strong>Visible par tous les participants à ce cours</strong> &ndash; pour voir ce billet, vous devez avoir accès à l\'activité, habituellement en étant inscrit au cours qui le contient.</p>

<p><strong>Visible par toute personne connecté sur le site</strong> &ndash; toute personne connectée peut voir le billet, même si elle n\'est pas inscrite à un cours spécifique.</p>
<p><strong>Visible par tous</strong> &ndash; n\'importe quel utilisateur d\'Internet peut voir ce billet
si vous lui donnez l\'adresse.</p>';
$string['maxvisibility'] = 'Visibilité maximale';
$string['yes'] = 'Oui';
$string['no'] = 'Non';
$string['blogname'] = 'Nom du blog';
$string['summary'] = 'Résumé';
$string['statblockon'] = 'Afficher les statistiques d\'usage supplémentaires du blog';
$string['statblockon_help'] = 'Autoriser l\'affichage des statistiques d\'usage supplémentaires du blog dans le \'block\' d\'utilisation du blog.
Seulement dans les blogs Personnels (globaux), dans les blogs personnels visibles et dans les blogs de groupe visibles.';
$string['oublogallpostslogin'] = 'Connexion obligatoire sur toutes les pages affichant des billets.';
$string['oublogallpostslogin_desc'] = 'Activer pour rendre obligatoire la connexion pour consulter les billets. Seuls les utilisateurs connectés verront le lien vers cette page.';

$string['globalusageexclude'] = 'Exclure des statistiques d\'usage globales';
$string['globalusageexclude_desc'] = 'Liste d\'identifiants utilisateurs, séparés par des virgules, à exclure des stats d\'usage du blog global';

$string['introonpost'] = 'Afficher l\'intro lors d\'un billet';

$string['displayname_default'] = 'blog';
$string['displayname'] = 'Nom d\'activité alternatif (laisser vide pour utiliser le nom par défaut)';
$string['displayname_help'] = 'Défini un nom alternatif pour ce type d\'activité.

Laisser le champ vide pour utiliser le nom par défaut (\'blog\').

Le nom alternatif doit démarrer par une minuscule, qui sera convertie en majuscule lorsque ce sera nécessaire.';

$string['visibleyou'] = 'Visible uniquement par le propriétaire du blog (privé)';
$string['visiblecourseusers'] = 'Visible par les participants à ce cours';
$string['visibleblogusers'] = 'Visible uniquement par les membres de ce blog';
$string['visibleloggedinusers'] = 'Visible par toute personne connectée à ce site';
$string['visiblepublic'] = 'Visible par tout le monde';
$string['invalidpostid'] = 'Postid (identifiant de billet) invalide';

$string['addpost'] = 'Ajouter un billet';
$string['editpost'] = 'Mettre à jour le billet';
$string['editsummary'] = 'Modifié par {$a->editby}, le {$a->editdate}';
$string['editonsummary'] = 'Modifié {$a->editdate}';

$string['edit'] = 'Modifier';
$string['delete'] = 'Effacer';

$string['olderposts'] = 'Posts plus anciens';
$string['newerposts'] = 'Posts plus récents';
$string['extranavolderposts'] = 'Posts plus anciens : {$a->from}-{$a->to}';
$string['extranavtag'] = 'Tag: {$a}';

$string['comments'] = 'Commentaires';
$string['recentcomments'] = 'Recent commentaires';
$string['ncomments'] = '{$a} commentaires';
$string['onecomment'] = '{$a} commentaire';
$string['npending'] = '{$a} commentaires en attente d\'approbation';
$string['onepending'] = '{$a} commentaire en attente d\'approbation';
$string['npendingafter'] = ', {$a} en attente d\'approbation';
$string['onependingafter'] = ', {$a} en attente d\'approbation';
$string['comment'] = 'Ajouter votre commentaire';
$string['lastcomment'] = '(dernier par {$a->fullname}, {$a->timeposted})';
$string['addcomment'] = 'Ajouter un commentaire';

$string['confirmdeletepost'] = 'Êtes-vous certain de vouloir effacer ce billet ?';
$string['confirmdeletecomment'] = 'Êtes-vous certain de vouloir effacer ce commentaire ?';
$string['confirmdeletelink'] = 'Êtes-vous certain de vouloir effacer ce lien ?';

$string['viewedit'] = 'Voir les modifications [TODO: la trad dépend vraiment du contexte]';
$string['views'] = 'Nombre de vues total de ce {$a}:';

$string['addlink'] = 'Ajouter un lien';
$string['editlink'] = 'Modifier le lien';
$string['links'] = 'Contenus liés';

$string['subscribefeed'] = 'Souscrire à un flux (nécessite un logiciel approprié) pour recevoir des notifications quand ce {$a} est mis à jour.';
$string['feeds'] = 'Flux';
$string['blogfeed'] = '{$a} flux';
$string['commentsfeed'] = 'Commentaires seuls';
$string['atom'] = 'Atom';
$string['rss'] = 'RSS';
$string['atomfeed'] = 'Atom feed';
$string['rssfeed'] = 'RSS feed';

$string['newblogposts'] = 'Nouveau billet de blog';

$string['blogsummary'] = 'Sommaire du Blog [TODO: confirmer qu\'il s\'agit bien de summary au sens de sommaire et pas de résumé]';
$string['posts'] = 'Billets';

$string['defaultpersonalblogname'] = '{$a->name}\'s {$a->displayname}';

$string['numposts'] = '{$a} billets';

$string['noblogposts'] = 'Aucun billet de blog';

$string['blogoptions'] = 'Options du blog';

$string['postedby'] = 'par {$a}';
$string['postedbymoderated'] = 'par {$a->commenter} (approuvé par {$a->approver}, {$a->approvedate})';
$string['postedbymoderatedaudit'] = 'par {$a->commenter} [{$a->ip}] (approuvé par {$a->approver}, {$a->approvedate})';

$string['deletedby'] = 'Effacé par {$a->fullname}, {$a->timedeleted}';

$string['newcomment'] = 'Nouveau commentaire';
$string['postmessage'] = 'Publier';

$string['searchthisblog'] = 'Rechercher dans ce {$a}';
$string['searchblogs'] = 'Rechercher';
$string['searchblogs_help'] = 'Saisissez les mots à rechercher et tapez Entrée ou cliquez sur le bouton.

Pour rechercher une phrase exacte utilisez des guillemets.

Pour exclure un mot insérez un tiret juste avant ce mot.

Exemple : le critère de recherche <tt>picasso -sculpture &quot;premières oeuvresd&quot;</tt> retournera les résultats pour &lsquo;picasso&rsquo; ou l\'expression &lsquo;premières oeuvres&rsquo; mais exclura les réponses contenants &lsquo;sculpture&rsquo;.';

$string['url'] = 'Adresse Web complète';

$string['bloginfo'] = 'A propos du blog';

$string['feedhelp'] = 'Flux';
$string['feedhelp_help'] = 'Si vous utilisez des flux vous pouvez ajoutez ces liens Atom ou RSS de façon à être informé des nouveaux billets.
La plupart des lecteurs de flux supportent les formats Atom et RSS.

Si les commentaires sont activés il y aura aussi des flux pour les &lsquo;Commentaires seuls&rsquo;.';
$string['unsupportedbrowser'] = '<p>Votre navigateur ne peut pas afficher directement les flux Atom ou RSS.</p>
<p>Les flux sont affichables dans un logiciel ou un site web Spécifique. Si vous voulez utiliser ce flux dans un programme de ce type, copiez et collez le contenu de la barre d\'adresse de votre navigateur.</p>';

$string['completionpostsgroup'] = 'Exiger des billets';
$string['completionpostsgroup_help'] = 'Si vous activez cette option, l\'activité blog sera marquée comme effectuée par un étudiant quand il aura publié le nombre spécifié de billets.';
$string['completionposts'] = 'L\'utilisateur doit publier des billets :';
$string['completioncommentsgroup'] = 'Exiger des commentaires';
$string['completioncommentsgroup_help'] = 'Si vous activez cette option, l\'activité blog sera marquée comme effectuée par un étudiant quand il aura publié le nombre spécifié de commentaires.';
$string['completioncomments'] = 'L\'utilisateur doit publier des commentaires :';

$string['computingguide'] = 'Aide en ligne d\'OU blog [TODO]';
$string['computingguideurl'] = 'Computing guide URL [TODO: qu\'est-ce que le computing guide ? Le manuel utilsateur dédié à la configuration de l\'activité ?]';
$string['computingguideurlexplained'] = 'Enter the URL for the OU blogs computing guide [TODO]';

$string['maybehiddenposts'] = 'Ce {$a->name} peut contenir des billets qui sont visibles uniquement
par les utilisateurs connectés, ou dans lequel les utilisateurs connectés peuvent publier des commentaires. Si vous possédez un compte sur ce site, veuillez vous <a href=\'{$a->link}\'>connecter pour un accès complet</a>.';
$string['guestblog'] = 'Si vous possédez un compte sur ce site, veuillez vous <a href=\'{$a}\'>connecter pour un accès complet</a>.';
$string['noposts'] = 'Il n\'y a aucun billet visible dans ce {$a}.';
$string['nopostsnotags'] = 'Il n\'y a aucun billet visible dans ce {$a->blog}, pour le tag {$a->tag}.';

// Errors.
$string['accessdenied'] = 'désolé: vous n\'avez pas accès à cette page.';
$string['invalidpost'] = 'Identifiant de billet invalide';
$string['invalidcomment'] = 'Identifiant de Commentaire invalide';
$string['invalidblog'] = 'Identifiant de Blog invalide';
$string['invalidedit'] = 'Identifiant de Modification invalide';
$string['invalidlink'] = 'Identifiant de Lien invalide';
$string['personalblognotsetup'] = 'Blog personnel non configuré';
$string['tagupdatefailed'] = 'La mise à jour des tags a échoué';
$string['commentsnotallowed'] = 'Les commentaires ne sont pas autorisés';
$string['couldnotaddcomment'] = 'L\'ajout du commentaire a échoué';
$string['onlyworkspersonal'] = 'Ne fonctionne que sur les blogs personnels';
$string['couldnotaddlink'] = 'Impossible d\'ajouter un lien';
$string['notaddpostnogroup'] = 'Impossible de publier le billet sans choisir de groupe';
$string['notaddpost'] = 'Impossible de publier le billet';
$string['feedsnotenabled'] = 'Les flux sont désactivés';
$string['invalidformat'] = 'Le format doit être Atom ou RSS';
$string['deleteglobalblog'] = 'Vous ne pouvez pas effacer le blog principal';
$string['globalblogmissing'] = 'Le blog principal est manquant';
$string['invalidvisibility'] = 'Niveau de visibilité invalide';
$string['invalidvisbilitylevel'] = 'Niveau de visibilité invalide: {$a}';
$string['invalidblogdetails'] = 'Impossible d\'afficher le billet {$a}';

$string['siteentries'] = 'Afficher les billets du site';
$string['overviewnumentrylog1'] = 'billet depuis la dernière connexion';
$string['overviewnumentrylog'] = 'billets depuis la dernière connexion';
$string['overviewnumentryvw1'] = 'billet depuis la dernière visite';
$string['overviewnumentryvw'] = 'billets depuis la dernière visite';

$string['individualblogs'] = 'Blogs personnels';
$string['no_blogtogetheroringroups'] = 'Non (bloguez tous ensemble ou par groupes)';
$string['separateindividualblogs'] = 'Blogs personnels privés';
$string['visibleindividualblogs'] = 'Blogs personnels publics';

$string['separateindividual'] = 'Personnels&nbsp;privé';
$string['visibleindividual'] = 'Personnels&nbsp;public';
$string['viewallusers'] = 'Voir tous les utilisateurs';
$string['viewallusersingroup'] = 'Voir tous les utilisateurs dans le groupe';

$string['re'] = 'Re: {$a}';

$string['moderated_info'] = 'Parce que vous n\'êtes pas connecté, votre comentaire n\apparaîtra qu\'après avoir été approuvé. SI vous possédez un compte sur ce site, veuillez <a href=\'{$a}\'>vous connecter pour avoir accès à toutes les fonctionnalités</a> SVP.';
$string['moderated_authorname'] = 'Votre nom';
$string['moderated_confirmvalue'] = 'oui';
$string['moderated_confirminfo'] = 'Veuillez saisir <strong>oui</strong> ci-dessous pour confirmer que vous êtes un humain.';
$string['moderated_confirm'] = 'Confirmation';
$string['moderated_addedcomment'] = 'Merci pour ce commentaire, qui a bien été reçu. Il n\'apparaîtra qu\'après avoir été validé par l\'auteur de ce billet.';
$string['moderated_submitted'] = 'En attente de modération';
$string['moderated_typicaltime'] = 'Habituellement, cela prend environ {$a}.';
$string['error_noconfirm'] = 'Saisissez le texte en gras ci-dessous, à l\'identique, dans ce champ de saisie.';
$string['error_toomanycomments'] = 'Vous avez saisi trop de commentaires à partir de cette adresse Internet au cours de l\'heure écoulée. Veuillez patienter un peu avant d\'essayer à nouveau.';
$string['moderated_awaiting'] = 'Commentaires en attente d\'approbation';
$string['moderated_awaitingnote'] = 'Ces commentaires ne seront pas visibles par les autres visiteurs tant que vous ne les aurez pas approuvés. Gardez en tête le fait que le système ne connait pas l\'identité des commentateurs et que les commentaires peuvent contenir des liens qui, s\'ils sont suivis, pourraient sérieusement <strong>endommager votre ordinateur</strong>. Si vous avez le moindre doute, veuillez rejeter les commentaires <strong>sans cliquer sur aucun lien</strong>.';
$string['moderated_postername'] = 'utilisant le nom <strong>{$a}</strong>';
$string['error_alreadyapproved'] = 'Commentaire déjà approuvé ou rejeté';
$string['error_wrongkey'] = 'Clé de commentaire incorrecte';
$string['error_unspecified'] = 'Le serveur ne peut pas traiter cette requête car une erreur est survenue ({$a})';
$string['error_moderatednotallowed'] = 'Les commentaires soumis à modération ne sont plus autorisés sur ce blog ou ce billet';
$string['moderated_approve'] = 'Approuver ce commentaire';
$string['moderated_reject'] = 'Rejeter ce commentaire';
$string['moderated_rejectedon'] = 'Rejeté {$a}:';
$string['moderated_restrictpost'] = 'Restreindre les commentaires sur ce billet';
$string['moderated_restrictblog'] = 'Restreindre les commentaires sur tous les billets de ce blog';
$string['moderated_restrictpage'] = 'Restreindre les commentaires';
$string['moderated_restrictpost_info'] = 'Voulez-vous restreindre les commentaires sur ce billet de façon à ce que seules les personnes connectées puissent saisir des commentaires ?';
$string['moderated_restrictblog_info'] = 'Voulez-vous restreindre les commentaires sur tous vos billets de façon à ce que seules les personnes connectées puissent saisir des commentaires ?';
$string['moderated_emailsubject'] = 'Commentaires en attente d\'approbation sur : {$a->blog} ({$a->commenter})';
$string['moderated_emailhtml'] =
'<p>(Ceci est un email généré automatiquement. Veuillez ne pas répondre.)</p>
<p>Quelqu\'un a ajouté un commentaire sur votre billet de blog : {$a->postlink}</p>
<p>Vous devez <strong>approuver le commentaire</strong> pour qu\'il soit rendu public.</p>
<p>Le système ne connait pas l\'identité des commentateurs et les commentaires 
peuvent contenir des liens qui, s\'ils sont suivis, pourraient sérieusement
<strong>endommager votre ordinateur</strong>. Si vous avez le moindre doute, 
veuillez rejeter les commentaires <strong>sans cliquer sur aucun lien</strong>.</p>
<p>Si vous approuvez un commentaire vous prenez la responsabilité de le publier.
Assurez vous qu\'il ne contienne rien qui contrevienne aux conditions d\'utilisation du site.</p>
<hr/>
<p>Nom donné : {$a->commenter}</p>
<hr/>
<h3>{$a->commenttitle}</h3>
{$a->comment}
<hr/>
<ul class=\'oublog-approvereject\'>
<li><a href=\'{$a->approvelink}\'>{$a->approvetext}</a></li>
<li><a href=\'{$a->rejectlink}\'>{$a->rejecttext}</a></li>
</ul>
<p>
Vous pouvez choisir d\'ignorer ce message. Dans ce cas le commentaire 
sera rejeté automatiquement après 30 jours.
</p>
<p>
Si vous recevez trop de messages de ce type, vous pouvez restreindre l\'ajout de
 commentaires aux utilisateurs connectés.
</p>
<ul class=\'oublog-restrict\'>
<li><a href=\'{$a->restrictpostlink}\'>{$a->restrictposttext}</a></li>
<li><a href=\'{$a->restrictbloglink}\'>{$a->restrictblogtext}</a></li>
</ul>';
$string['moderated_emailtext'] =
'Ceci est un email généré automatiquement. Veuillez ne pas répondre.
Quelqu\'un a ajouté un commentaire sur votre billet de blog : 
{$a->postlink}
Vous devez approuver le commentaire pour qu\'il soit rendu public.
Le système ne connait pas l\'identité des commentateurs et les commentaires 
peuvent contenir des liens qui, s\'ils sont suivis, pourraient sérieusement
endommager votre ordinateur. Si vous avez le moindre doute, veuillez rejeter
 les commentaires sans cliquer sur aucun lien.
Si vous approuvez un commentaire vous prenez la responsabilité de le publier.
Assurez vous qu\'il ne contienne rien qui contrevienne aux conditions d\'utilisation du site.

-----------------------------------------------------------------------
Name given: {$a->commenter}
-----------------------------------------------------------------------
{$a->commenttitle}
{$a->comment}
-----------------------------------------------------------------------

* {$a->approvetext}:
  {$a->approvelink}

* {$a->rejecttext}:
  {$a->rejectlink}

Vous pouvez choisir d\'ignorer ce message. Dans ce cas le commentaire 
sera rejeté automatiquement après 30 jours.

Si vous recevez trop de messages de ce type, vous pouvez restreindre l\'ajout de
 commentaires aux utilisateurs connectés.

* {$a->restrictposttext}:
  {$a->restrictpostlink}

* {$a->restrictblogtext}:
  {$a->restrictbloglink}
';

$string['displayversion'] = 'Version d\'OU blog : <strong>{$a}</strong>';

$string['pluginadministration'] = 'Administration d\'OU Blog';
$string['pluginname'] = 'OU Blog';
// Help strings.
$string['allowcomments_help'] = '&lsquo;Oui, par les utilisateurs connectés&rsquo; autorise l\'ajout de commentaires par les utilisateurs qui ont accès à ce billet.

&lsquo;Oui, de tout le monde&rsquo; autorise l\'ajout de commentaires par les utilisateurs connectés et par le public général. Vous recevrez des emails pour approuver ou rejeter les commentaires des utilisateurs non connectés.

&lsquo;No&rsquo; prevents anyone from making a comment on this post.';
$string['individualblogs_help'] = '
<p><strong>Non (bloguez ensemble ou en groupe)</strong>: <em>Les blogs personnels ne sont pas utilisés</em> &ndash;
Il n\y a pas de blog individuels, tout le monde fait partie d\une communauté plus large
(dépend de la valeur du paramètre \'Mode Groupe\').</p>
<p><strong>Blog personnels privés</strong>: <em>Les blogs personnels ne sont visibles que de leur propriétaire</em> &ndash;
Les utilisateurs ne peuvent publier et afficher des billets que sur leur propre blog, à moins que la permission ("viewindividual") de voir d\'autres blogs personnels leur ait été accordée.</p>
<p><strong>Blogs personnels public</strong>: <em>Les blogs personnels sont visibles par tous</em> &ndash;
les utilisateurs ne peuvent publier des billets que sur leur propre blog, mais peuvent voir les billets publiés sur les autres blogs personnels.</p>';

$string['maxvisibility_help'] = '
<p><em>Sur un blog personnel :</em> <strong>Visible seulement par le propriétaire du blog (privé)</strong> &ndash;
personne* d\'autre ne peut voir ce billet.</p>
<p><em>Sur le blog d\'un cours :</em> <strong>Visible par les inscrits à ce cours</strong> &ndash; pour voir le billet, un accès à ce blog doit vous avoir été accordé ; habituellement vous obtenez cet accès en vous inscrivant au cours auquel il est rattaché.</p>

<p><strong>Visible par toute personne connectée à ce site</strong> &ndash; 
toute personne connectée peut voir ce billet, même sans être inscrite à un cours spécifique.</p>
<p><strong>Visible par tous</strong> &ndash; n\'importe quel utilisateur d\'Internet peut voir ce billet
si vous lui donnez l\'adresse du blog.</p>

<p>Cette option existe sur le blog entier et sur chaque billet. Si l\'option est activée
sur le blog entier, cela devient un maximum. Par exemple, si tout le blog est réglé sur le premier niveau,
vous ne pouvez pas changer le réglage pour un billet donné.</p>';
$string['tags_help'] = 'Les tags sont des libellés qui vous aident à retrouver et catégoriser les billets.';
// Used at OU only.
$string['externaldashboardadd'] = 'Ajouter le blog au panneau de contrôle [TODO: est-ce que le mot dashboard est traduit dans le reste du site ? si oui comment ?]';
$string['externaldashboardremove'] = 'Retirer le blog du panneau de contrôle';
$string['viewblogdetails'] = 'Voir les details du blog ';
$string['viewblogposts'] = 'Retourner au blog';

// User participation.
$string['oublog:grade'] = 'Évaluer la participation utilisateur à OU Blog';
$string['oublog:viewparticipation'] = 'Voir la participation utilisateur à OU Blog';
$string['userparticipation'] = 'Participation utilisateur';
$string['usersparticipation'] = 'Participation de tous les utilisateurs';
$string['myparticipation'] = 'Résumé de ma participation';
$string['savegrades'] = 'Sauver les évaluations';
$string['participation'] = 'Participation';
$string['participationbyuser'] = 'Participation par utilisateur';
$string['details'] = 'Details';
$string['foruser'] = ' pour {$a}';
$string['postsby'] = 'Billets par {$a}';
$string['commentsby'] = 'Commentaires par {$a}';
$string['commentonby'] = 'Commentaire sur le billet <u>{$a->title}</u> {$a->date} par <u>{$a->author}</u>';
$string['nouserposts'] = 'Aucun billet publié.';
$string['nousercomments'] = 'Aucun comentaire ajouté.';
$string['gradesupdated'] = 'Évaluation mise à jour';
$string['usergrade'] = 'Évaluation de l\'utilisateur';
$string['nousergrade'] = 'Évaluation de l\'utilisateur non disponible.';

// Participation download strings.
$string['downloadas'] = 'Télécharger les donnnées au format ';
$string['postauthor'] = 'Auteur du billet';
$string['postdate'] = 'Date du billet';
$string['posttime'] = 'Heure du billet';
$string['posttitle'] = 'Titre du billet';

// Export.
$string['exportedpost'] = 'Billet exporté';
$string['exportpostscomments'] = ' tous les billets actuellement visibles et leurs commentaires.';
$string['exportuntitledpost'] = 'Un billet sans titre ';

$string['configmaxattachments'] = 'Nombre maximal de pièces jointes autorisées par défaut sur un billet de blog.';
$string['configmaxbytes'] = 'Taille maximale par défaut pour toutes les pièces jointes à un billet sur le site.
(peut être soumis à des limitations par cours ou par d\'autres paramètrages locaux)';
$string['maxattachmentsize'] = 'Taille maximale de la pièce jointe';
$string['maxattachments'] = 'Nombre maximal de pièces jointes';
$string['maxattachments_help'] = 'Ce paramètre définit le nombre maximal de fichiers qui peuvent être associés à un billet de blog.';
$string['maxattachmentsize_help'] = 'Ce paramètre définit la taille maximale des fichiers/images qui peuvent être associés à un billet de blog.';
$string['attachments_help'] = 'Vous pouvez ajouter un ou plusieurs fichiers à un billet de blog. Si vous ajoutez une une image, elle sera affichée après le message.';

$string['remoteserver'] = 'Importer à partir d\'un serveur distant';
$string['configremoteserver'] = 'Adresse (nom de domaine[TODO: le texte original c\'est wwwroot]) du serveur à utiliser pour l\'import.
Les blogs de ce serveur seront affichés en plus de ceux du site local quand vous importerez des billets.';
$string['remotetoken'] = 'Jeton d\'import du server distant';
$string['configremotetoken'] = 'Jeton utilisateur du Web Service oublog sur le serveur distant à importer.';

$string['reportingemail'] = 'Adresses email à notifier';
$string['reportingemail_help'] = 'Ce paramètre définit les adresses email de ceux qui seront informés des problèmes sur les billets ou des commentaires dans OUBlog.
Elles doivent être séparées par des virgules.';
$string['postalert'] = 'Alerter à propos d\'un billet';
$string['commentalert'] = 'Alerter à propos d\'un commentaire';
$string['oublog_managealerts'] = 'Gérer les alertes sur les billets ou commentaires';
$string['untitledpost'] = 'Billet sans titre';
$string['untitledcomment'] = 'Commentaire sans titre';

// Discovery block.
$string['discovery'] = '{$a} utilisation';
$string['timefilter_alltime'] = 'Depuis le début';
$string['timefilter_thismonth'] = 'Mois écoulé';
$string['timefilter_thisyear'] = 'Année écoulée';
$string['timefilter_label'] = 'Période de temps';
$string['timefilter_submit'] = 'Mettre à jour';
$string['timefilter_open'] = 'Afficher les options';
$string['timefilter_close'] = 'Masquer les options';
$string['visits'] = 'Les plus visités';
$string['activeblogs'] = 'Actifs';
$string['numberviews'] = '{$a} vues';
$string['visits_info_alltime'] = '{$a}s avec le plus grand nombre de visites';
$string['visits_info_active'] = '{$a}s actifs (au moins un billet publié au cours du mois écoulé) avec le plus grand nombre de visites';
$string['mostposts'] = 'Le plus de billets';
$string['numberposts'] = '{$a} billets';
$string['posts_info_alltime'] = '{$a}s avec le plus grand nombre de billets';
$string['posts_info_thisyear'] = '{$a}s avec le plus grand nombre de billets dans l\'année écoulée';
$string['posts_info_thismonth'] = '{$a}s avec le plus grand nombre de billets dans le mois écoulé';
$string['mostcomments'] = 'Le plus de commentaires';
$string['numbercomments'] = '{$a} commentaires';
$string['comments_info_alltime'] = '{$a}s avec le plus grand nombre de commentaires';
$string['comments_info_thisyear'] = '{$a}s avec le plus grand nombre de commentaires ajoutés dans l\'année écoulée';
$string['comments_info_thismonth'] = '{$a}s avec le plus grand nombre de commentaires ajoutés dans le mois écoulé';
$string['commentposts'] = 'Le plus de billets commentés';
$string['commentposts_info_alltime'] = 'Billets avec le plus grand nombre de commentaires';
$string['commentposts_info_thisyear'] = 'Billets avec le plus grand nombre de commentaires ajoutés dans l\'année écoulée';
$string['commentposts_info_thismonth'] = 'Billets avec le plus grand nombre de commentaires ajoutés dans le mois écoulé';

// Delete and Email.
$string['emailcontenthtml'] = 'Cette notification vous avertit que votre billet {$a->activityname} dont les caratéristiques figurent ci-dessous a été effacé par \'{$a->firstname} {$a->lastname}\':<br />
<br />
Sujet : {$a->subject}<br />
{$a->activityname} : {$a->blog}<br />
Cours : {$a->course}<br />
<br />
<a href={$a->deleteurl} title="afficher le billet effacé">Voir le billet effacé</a>';
$string['deleteemailpostbutton'] = 'Effacer et envoyer un email';
$string['deleteandemail'] = 'Effacer et envoyer un email';
$string['emailmessage'] = 'Message';
$string['cancel'] = 'Annuler';
$string['deleteemailpostdescription'] = 'Sélectionner pour effacer le billet et éventuellement envoyer par email une notification personnalisable.';
$string['copytoself'] = 'Recevoir une copie';
$string['includepost'] = 'Inclure le billet';
$string['deletedblogpost'] = 'Billet sans titre.';
$string['emailerror'] = 'Une erreur s\'est produite lors de l\'envoi de l\'email';
$string['sendanddelete'] = 'Envoyer et effacer';
$string['extra_emails'] = 'Adresses email des autres destinataires';
$string['extra_emails_help'] = 'Saisissez une ou plusieurs adresse(s) séparées par des espaces ou des points-virgules.';

// Import pages.
$string['allowimport'] = 'Activer l\'import de billets';
$string['allowimport_help'] = 'Autoriser tous les utilisateurs à importer des pages à partir d\'autres activités blogs auxquelles ils ont accès.';
$string['allowimport_invalid'] = 'Les billets ne peuvent être importés que quand l\'activité est en mode blogs personnels.';
$string['import'] = 'Importer des billets';
$string['import_notallowed'] = 'L\'import de billets est désactivé pour ce {$a}.';
$string['import_step0_nonefound'] = 'Vous n\'avez pas accès à un blog à partir duquel des billets pourraient être importés.';
$string['import_step0_inst'] = 'Sélectionner une activité à partir de laquelle importer des bilelts :';
$string['import_step0_numposts'] = '({$a} billets)';
$string['import_step1_inst'] = 'Sélectionner les billets à importer :';
$string['import_step1_from'] = 'Importer de :';
$string['import_step1_table_title'] = 'Titre';
$string['import_step1_table_posted'] = 'Posté le';
$string['import_step1_table_tags'] = 'Tags';
$string['import_step1_table_include'] = 'Inclure dans l\'import';
$string['import_step1_addtag'] = 'Filtrer par tag - {$a}';
$string['import_step1_removetag'] = 'Supprimer le tag {$a} du filtre';
$string['import_step1_include_label'] = 'Importer le billet - {$a}';
$string['import_step1_submit'] = 'Importer les billets';
$string['import_step1_all'] = 'Sélectionner tout';
$string['import_step1_none'] = 'Désélectionner tout';
$string['import_step2_inst'] = 'Importer des billets :';
$string['import_step2_none'] = 'Aucun billet n\'a été sélectionner pour l\'import.';
$string['import_step2_prog'] = 'Import en cours';
$string['import_step2_total'] = '{$a} billets importés.';
$string['import_step2_conflicts'] = '{$a} billets à importer ont été identifiés comme provoquant des conflits avec des billets existants.';
$string['import_step2_conflicts_submit'] = 'Importer les billets en conflit';

// My Participation.
$string['contribution'] = 'Participation';
$string['contribution_all'] = 'Participation - Depuis le début';
$string['contribution_from'] = 'Participation - Depuis {$a}';
$string['contribution_to'] = 'Participation - Jusqu\'à {$a}';
$string['contribution_fromto'] = 'Participation - Depuis {$a->start} Jusqu\'à {$a->end}';
$string['start'] = 'Depuis';
$string['end'] = 'Jusqu\'à';
$string['displayperiod'] = 'Sélecteur de participation - Date de début- Date de fin.[TODO - à voir dans le contexte]';
$string['info'] = 'Participation durant la période choisie.';
$string['displayperiod_help'] = '<p>La valeur par défaut affiche toutes les données.</p>
<p>Vous pouvez sélectionner toutes les participations \'Depuis\' une date et jusqu\'à aujourd\'hui.</p>
<p>Vous pouvez sélectionner toutes les participations \'Depuis\' une date et \'Jusqu\'à\' une autre date.</p>
<p>Ou vous pouvez choisir toutes les participations depuis le début et \'Jusqu\'à\' une date donnée</p>';
$string['nouserpostsfound'] = 'Aucun billet n\'a été publié pendant cette période.';
$string['nousercommentsfound'] = 'Aucun commentaire n\'a été ajouté pendant cette période.';
$string['numberpostsmore'] = 'Encore {$a} billets';
$string['numbercommentsmore'] = 'Encore {$a} billets';
$string['viewmyparticipation'] = 'Afficher ma participation';
$string['viewallparticipation'] = 'Afficher toutes les participations';
$string['timestartenderror'] = 'La date de fin ne peut être antérieure à la date de début';

$string['savefailtitle']='Le billet ne peut pas être sauvé';
$string['savefailnetwork'] = '<p>Malheureusement, vos modifications ne peuvent pas être sauvegardées maintenant,
en raison d\'un problème réseau. Soit le site web est temporairement inaccessible, soit vous avez été déconnecté.</p>
<p>La sauvegarde a été désactivée sur ce blog.
Pour conserver vos modifications vous devez copier le contenu modifié,
accéder à nouveau à la page de modification, puis coller le nouveau contenu.</p>';

$string['order'] = 'Ordre:';
$string['alpha'] = 'A à Z';
$string['use']=  'Les plus utilisés';
$string['order_help'] = 'Vous pouvez choisir d\'afficher la liste des tags soit par ordre alphabétique, soit par nombre de billets dans lesquels ils sont utilisés.
Cliquez sur les deux liens pour basculer d\'un mode d\affichage à l\'autre.
Ce choix sera mémorisé et utilisé dans les vues suivantes.';
$string['predefinedtags'] = 'Tags prédéfinis';
$string['predefinedtags_help'] = 'Présenter à l\'utilisateur une liste de tags à utiliser quand il ajoute un tag à un billet.
Les tags doivent être séparés par des virgules.';
$string['official'] = 'Liste';
$string['invalidblogtags'] = 'Tags de blog invalides';
$string['nouserpostpartsfound'] = 'Aucun billet posté au cours de cette période.';
$string['nousercommentpartsfound'] = 'Aucun commentaire ajouté au cours de cette période.';
$string['participation_all'] = 'Participation - Depuis le début';
$string['participation_from'] = 'Participation - Depuis {$a}';
$string['participation_to'] = 'Participation - Jusqu\'à{$a}';
$string['participation_fromto'] = 'Participation - Depuis {$a->start} Jusqu\'à{$a->end}';
$string['recentposts'] = 'Billets récents';
$string['commentonbyusers'] = 'Commentaire <u>{$a->commenttitle}</u> sur le billet <u>{$a->posttitle}</u> <br> par <u>{$a->author}</u>';
$string['commentdated'] = 'Daté [TODO : à vérifier]';
$string['postinfoblock'] = '<u>{$a->posttitle}</u> <br> <u>{$a->postdate}</u> <br> <u>{$a->sourcelink}</u>';
$string['postdetail'] = 'Détails du billet';
$string['group'] = 'Groupe ';
$string['event:postcreated'] = 'Billet créé';
$string['event:commentcreated'] = 'Commentaire créé';
$string['event:commentdeleted'] = 'Commentaire effacé';
$string['event:postdeleted'] = 'Billet effacé';
$string['event:postupdated'] = 'Billet mis à jour';
$string['event:postviewed'] = 'Billet affiché [TODO : vu ou affiché ?]';
$string['event:commentapproved'] = 'Commentaire approuvé';
$string['event:participationviewed'] = 'Participation affichée [TODO : vue ou affichée ?]';
$string['event:siteentriesviewed'] = 'Billets ou commentaires vus [TODO - à vérifier]';
$string['event:postimported'] = 'Billet importé';
$string['oublog:rate'] = 'Peut évaluer les billets.';
$string['oublog:viewallratings'] = 'Afficher toutes les évaluations données par des utilisateurs';
$string['oublog:viewanyrating'] = 'Afficher toutes les évaluation reçues';
$string['oublog:viewrating'] = 'Voir votre évalution totale';
$string['grading'] = 'Note';
$string['grading_help'] = 'Si vous sélectionnez cette option, une note sera calculée automatiquement et ajoutée au carnet de notes du cours pour ce blog.
 Laissez désactivé pour un blog non noté, ou que vous prévoyez de noter manuellement.';
$string['grading_invalid'] = 'Les billets ne peuvent être notés que lorsque le type de note ou d\'évaluation est défini.';
$string['nograde'] = 'Pas de note (valeur par défaut)';
$string['teachergrading'] = 'Les pédagogues notent les étudiants';
$string['userrating'] = 'Noter';
$string['share'] = 'Partage ce billet';
$string['tweet'] = 'Tweeter';
$string['oublogcrontask'] = 'Tâches de maintenance d\'OU blog';

$string['restricttags'] = 'Autoriser uniquement les \'tags prédéfinis\' ';
$string['restricttags_help'] = 'si vous choisissez cette option, vous pouvez restreindre les tags
à la liste définie au niveau de l\'activité.';
$string['restricttagslist'] = 'Vous ne pouvez utiliser que les \'tags prédéfinis\' : {$a}';
$string['restricttagsvalidation'] = 'Seuls les \'tags prédéfinis\' sont autorisés';

