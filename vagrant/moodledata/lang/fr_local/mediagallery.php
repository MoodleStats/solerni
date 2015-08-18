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
 * English strings for mediagallery
 *
 * You can have a rather longer description of the file as well,
 * if you like, and it can span multiple lines.
 *
 * @package    mod_mediagallery
 * @copyright  Orange 2015
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['addagallery'] = 'Ajouter un album';
$string['addanitem'] = 'Ajouter un élément';
$string['addbulkitems'] = 'Ajouter un ensemble d\'éléments';
$string['addsamplegallery'] = 'Rajouter un album d\'exemple';
$string['allowcomments'] = 'Autoriser les commentaires';
$string['allowcomments_help'] = 'Autoriser les utilisateurs à commenter les éléments et les albums.';
$string['allowlikes'] = 'Autoriser les \'J\'aime\'';
$string['allowlikes_help'] = 'Autoriser les utilisateurs à utiliser la fonction \'J\'aime\' pour les éléments d\'un album.';
$string['areaitem'] = 'Eléments';
$string['arealowres'] = 'Basse résolution';
$string['areathumbnail'] = 'Vignettes';
$string['areagallery'] = 'Albums';
$string['automatic'] = 'Automatique';
$string['beingprocessed'] = 'En cours de traitement';
$string['bottom'] = 'Bas';
$string['broadcaster'] = 'Distributeur';
$string['broadcaster_help'] = 'Qui était le distributeur de cet élément ?';
$string['caption'] = 'Légende';
$string['caption_help'] = 'La légende de cet élément dans votre album. Cette légende sera affichée à côté de l\'élement.';
$string['captionposition'] = 'Position de la légende';
$string['carousel'] = 'Carrousel';
$string['choosecontent'] = 'Sélectionner un fichier à télécharger ou une URL dans les champs ci-dessous.';
$string['close'] = 'Fermer';
$string['collection'] = 'Bibliothèque';
$string['collectionwasdeleted'] = 'Désolé, cet album n\'existe plus ou n\'est plus accessible dans ce cours.';

// Collection modes.
$string['collmode'] = 'Style de bibliothèque';
$string['collmode_help'] = 'Cela permet de déterminer si la bibliothèque sera stockée dans Moodle, ou liée au service theBox. Une fois défini, cette valeur ne pourra pas être changée.

<ul><li>Standard: dans ce mode, la bibliothèque, ses albums et éléments, sont stockés dans Moodle.</li></ul>';

// Collection types.
$string['colltype'] = 'Type de bibliothèque';
$string['colltype_help'] = 'Le type de bibliothèque détermine comment les utilisateurs peuvent interagir avec les bibliothèques ainsi que le type de contenu.

<ul>
<li>Bibliothèque gestionnaire: Seuls les gestionnaires peuvent ajouter / modifier du contenu dans la bibliothèque. Ceci est principalement utilisé pour pour créer des bibliothèques d\'exemple ; ou un ensemble d\albums sans laisser les utilisateurs créer leur propre album.</li>
<li>Bibliothèque utilisateur : Permet aux utilisateurs de créer leurs propres albums avec des éléments, mais la bibliothèque ne peut pas être utilisée dans le cadre d\'une activité du cours.</li>
<li>Bibliothèque de cours : Les utilisateurs ne peuvent voir que les albums qu\'ils ont créés ou qui ont été créées par des personnes du même groupe. Peut être utilisé dans le cadre d\'une activité du cours.</li>
<li>Bibliothèque évaluation par les pairs : Les utilisateurs sont en mesure de voir les albums des autres utilisateurs / groupes et liker / commenter les éléments si les fonctions sont activées. Peut être utilisé dans le cadre d\'une activité d\'un cours.</li></ul>';
$string['colltypeinstructor'] = 'Bibliothèque gestionnaire';
$string['colltypecontributed'] = 'Bibliothèque utilisateur';
$string['colltypeassignment'] = 'Bibliothèque de cours';
$string['colltypepeerreviewed'] = 'Bibliothèque évaluation par les pairs';

$string['comments'] = 'Commentaires';
$string['completegallery'] = 'Album complet';
$string['configdisablestandardgallery'] = 'Empêcher les utilisateurs de créer des albums standards.';
$string['configenablethebox'] = 'Cette option doit être activée pour que les utilisateurs puissent créer des bibliothèques et des éléments basés sur le service thebox. Si l\'option n\'est pas activée, l\'accès aux bibliothèques existantes affichera un message indiquant que la bibliothèque est actuellement indisponible.';
$string['configmaxbytes'] = 'Taille maximale par defaut des éléments pouvant être ajoutés aux bibliothèque multimédia de ce site';
$string['confirmcollectiondelete'] = 'Confirmez la suppression de la bibliothèque';
$string['confirmgallerydelete'] = 'Confirmer la suppression de l\'album';
$string['confirmitemdelete'] = 'Confirmer la suppression de l\'élément';
$string['content'] = 'Contenu';
$string['content_help'] = 'L\'élément que vous souhaitez ajouter à votre album.';
$string['contentbulk'] = 'Contenu';
$string['contentbulkheader'] = 'Vous pouvez télécharger un fichier archive contenant des fichiers multimédia. Chaque fichier de l\'archive sera ajouté comme un élément dans l\'album. Les dossiers à l\'intérieur de l\'archive seront ignorés.';
$string['contentbulk_help'] = 'Vous pouvez sélectionner un fichier archive (fichier compressé) contenant plusieurs photos, ces photos seront extraites dans le répertoire image après avoir été téléchargées.';
$string['contentlinked'] = 'Contenu';
$string['contentlinkedinfo'] = 'Cet élément est lié au fichier {$a} du service theBox.';
$string['contentlinked_help'] = 'Quand un élément est lié à un contenu du service theBox, vous ne pouvez pas changer le lien.';
$string['copyright'] = 'Licence';
$string['copyright_help'] = 'Définit la licence qui sera attribuée à tous les éléments que vous téléchargez via ce formulaire.';
$string['createdby'] = 'Créé par : {$a}';
$string['creator'] = 'Créateur';
$string['datecreated'] = 'Date de création';
$string['deletegallery'] = 'Supprimer l\'album';
$string['deleteitem'] = 'Supprimer l\'élément';
$string['deleteorremovecollection'] = 'Si vous désirez supprimer le lien vers la bibliothèque sans supprimer son contenu, cliquer sur \'Valider\'.<br/><br/>

Si vous souhaitez supprimer le lien vers la bibliothèque et supprimer son contenu, saisir \'DELETE\' dans le champ de saisie et cliquer sur \'Valider\'.';
$string['deleteorremovecollectionwarn'] = 'En supprimant cette bibliothèque vous confirmez vouloir :<br/>
- supprimer le lien vers la bibliothèque multimédia<br/>
- supprimer la bibliothèque et tous ses albums et élements (incluant les contenus stockés sur le service theBox)<br/>
- désactiver tous les liens vers cette bibliothèque ou son contenu dans d\'autres cours.';
$string['deleteorremovegallery'] = 'Si vous souhaitez supprimer le lien vers l\'album sans supprimer son contenu, cliquez sur \'Valider\'.<br/><br/>

Si vous souhaitez supprimer le lien sur l\'album et supprimer son contenu, saisir \'DELETE\' dans le champ de saisie et cliquez sur \'Valider\'.';
$string['deleteorremovegallerywarn'] = 'En supprimant cet album vous confirmez vouloir :<br/>
- supprimer le lien sur l\'album<br/>
- supprimer l\album et son contenu<br/>
- désactiver tous les liens vers cet album ou son contenu dans d\autres cours.';
$string['deleteorremoveitem'] = 'Si vous souhaitez supprimer le lien vers cet élement de l\'album sans le supprimer, cliquez sur \'Valider\'.<br/><br/>

Si vous souhaitez supprimer le lien sur l\'élement et l\'élément dans l\'album, saisir \'DELETE\' dans le champ de saisie et cliquez sur \'Valider\'.';
$string['deleteorremoveitemwarn'] = 'En supprimant cet élement vous confirmez vouloir :<br/>
- supprimer le lien sur cet élément<br/>
- supprimer cet élément (et son fichier)<br/>
- désactiver tous les liens vers cet élement dans d\'autres cours';
$string['disablestandardgallery'] = 'Désactiver les albums standards';
$string['displayfullcaption'] = 'Afficher le texte intégral de la légende';
$string['editgallery'] = 'Modifier les paramètres de l\'album';
$string['editthisgallery'] = 'Modifier la galerie';
$string['enablethebox'] = 'Activer l\'accès au service theBox';
$string['enforcedefaults'] = 'Forcer les valeurs par défaut pour les albums';
$string['enforcedefaults_help'] = 'Si cette option est activée, les albums seront créés avec les valeurs par défauts définies par le gestionnaire. Ces valeurs ne pourront pas être modifiées.';
$string['errorchooseimportoption'] = 'Sélectionner une option pour réaliser l\'import';
$string['errornotyouritem'] = 'Vous ne pouvez pas modifier cet élément, il appartient à un autre utilisateur.';
$string['errortheboxunavailable'] = 'Désolé, il semble que le service theBox ne soit pas disponible actuellement. Veuillez réessayer plus tard.';
$string['errortoomanyitems'] = 'Désolé, cet album a déjà le nombre maximum d\'éléments autorisés ({$a}).';
$string['errortoomanygalleries'] = 'Désolé, vous ou votre groupe avez dépassé le nombre maximum d\'albums permis dans cette bibliothèque ({$a}).';
$string['eventcollectiondeleted'] = 'Bibliothèque supprimée';
$string['eventgallerycreated'] = 'Album créé';
$string['eventgallerydeleted'] = 'Album supprimé';
$string['eventgalleryupdated'] = 'Album modifié';
$string['eventitemcreated'] = 'Elément créé';
$string['eventitemdeleted'] = 'Elément supprimé';
$string['eventitemupdated'] = 'Elément modifié';
$string['eventgalleryviewed'] = 'Consultation d\'un album';
$string['export'] = 'Exporter';
$string['exportgallery'] = 'Exporter l\'album';
$string['externalurl'] = 'URL externe';
$string['externalurl_help'] = 'Seuls les liens vers des images et des vidéos Youtube sont actuellement supportés.';
$string['filename'] = 'Nom du fichier';
$string['filesize'] = 'Taille du fichier';
$string['foundxresults'] = '{$a} résultat(s) trouvé(s) :';
$string['gallery'] = 'Album';
$string['galleryfocus'] = 'Type d\'album';
$string['galleryfocus_help'] = 'Type par défaut de la bibliothèque (détermine le type de fichier qui sera utilisé pour présenter l\'album).';
$string['galleryname'] = 'Nom de l\'album';
$string['gallerythumbnail'] = 'Utiliser comme vignette';
$string['gallerythumbnail_help'] = 'Si elle est sélectionnée, la vignette de cet élément sera utilisée comme vignette pour l\'album.';
$string['galleryviewoptions'] = 'Mode d\'affichage';
$string['galleryviewoptions_help'] = 'Détermine le type d\'affichage de l\'album pour les apprenants.';
$string['gridview'] = 'Affichage sous forme de vignettes';
$string['gridviewcolumns'] = 'Nombre de colonnes pour l\'affichage des vignettes';
$string['gridviewcolumns_help'] = 'Pour l\'affichage en mode vignettes, nombre de colonnes à afficher.';
$string['gridviewrows'] = 'Nombre de lignes pour l\'affichage des vignettes';
$string['gridviewrows_help'] = 'Pour l\'affichage en mode vignettes, nombre de lignes à afficher.';
$string['group'] = 'Groupe';
$string['group_help'] = 'Comme vous êtes membre de plusieurs groupes (ou vous avez l\'autorisation de gérer des groupes dans ce cours), sélectionnez le groupe que vous souhaitez associer à l\'album.';
$string['information'] = 'Informations';
$string['itemdisplay'] = 'Afficher cet élément';
$string['itemdisplay_help'] = 'Inclure cet élement lors de l\'affichage de l\'album (en mode carrousel).';
$string['like'] = 'J\'aime';
$string['likedby'] = 'Qui aime';
$string['maxbytes'] = 'Taille maximale par élément';
$string['maxgalleries'] = 'Nombre maximum d\'albums par utilisateur/groupe';
$string['maxgalleries_help'] = 'Le nombre maximum d\'albums qu\'un utilisateur (ou qu\'un groupe lors de l\'utilisation des groupes) peut créer dans cette bibliothèque.

Note: pour les gestionnaires il n\'y a pas de limite.';
$string['maxgalleriesreached'] = 'Nombre maximum d\'album atteint';
$string['maxitems'] = 'Nombre maximum d\'éléments par album';
$string['maxitems_help'] = 'Le nombre maximum d\'élements qu\'un utilisateur peut déposer dans un album de cette bibliothèque.

Note: pour un gestionnaire il n\'y a pas de limite.';
$string['maxitemsreached'] = 'Nombre maximum d\'éléments atteint';
$string['modulename'] = 'Bibliothèque multimédia';
$string['modulenameplural'] = 'Bibliothèques multimédia';
$string['modulename_help'] = 'Utiliser le module Bibliothèque multimédia pour créer des albums contenant des fichiers multimédia.

Les utilisateurs peuvent créer leur propre album de photos, de vidéos ou de musiques. Ils peuvent le faire seuls ou en groupe..

Les éléments téléchargés sont ensuite présentés sous forme de carrousel ou sous forme de vignettes. Cliquer sur une vignette pour afficher la photo. Vous pouvez ainsi parcourir l\'album. Les utilisateurs peuvent utiliser la fonction \'J\'aime\' et commenter les éléments des albums auxquels ils ont accès.';
$string['mediagallery:addinstance'] = 'Ajouter une Bibliothèque multimédia';
$string['mediagallery:comment'] = 'Commenter un album ou un élément dans une Bibliothèque multimédia';
$string['mediagallery:grade'] = 'Évaluer cette bibliothèque multimédia';
$string['mediagallery:like'] = 'Posibilité d\'utiliser le \'J\'aime\' pour un élement d\'une bibliothèque multimédia';
$string['mediagallery:manage'] = 'Gérer une Bibliothèque multimédia';
$string['mediagallery:viewall'] = 'Possibilité de visualiser toutes les albums dans une bibliothèque multimédia';

$string['mediagalleryfieldset'] = 'Exemple de champ personnalisés';
$string['mediagalleryname'] = 'Nom de la Bibliothèque multimédia';
$string['mediagalleryname_help'] = 'Le nom que vous souhaitez donner à votre bibliothèque multimédia.';
$string['mediagallery'] = 'Bibliothèque multimédia';
$string['medium'] = 'Type';
$string['medium_help'] = 'Le moyen utilisé pour créer l\'oeuvre (i.e. peinture, photographie, son, etc...).';
$string['metainfobulkheader'] = 'Les valeurs ci-dessous seront utilisées comme valeurs par défaut pour tous les éléments ajoutés.';
$string['mode'] = 'Style d\'album';
$string['mode_help'] = 'Vous pouvez définir le type de contenu que cet album va contenir. Une fois défini il n\'est pas possible de le changer.

<ul><li>Standard : dans ce mode les utilisateurs peuvent ajouter tout type de fichier multimédia (photos, vidéos, musiques).</li>
<li>YouTube : dans ce mode seules les videos Youtube peuvent être ajoutées à l\'album.</li></ul>';
$string['modestandard'] = 'Standard';
$string['modethebox'] = 'theBox';
$string['modeyoutube'] = 'YouTube';
$string['moralrights'] = 'Réutilisation';
$string['moralrights_help'] = 'En sélectionnant \'Oui\', vous donnez votre consentement pour que cet élement puisse être utilisé dans le cours.';
$string['noitemsadded'] = 'Aucun élément n\'a été rajouté à l\'album.';
$string['noitemsfound'] = 'Aucun élément trouvé.';
$string['noitemsselected'] = 'Aucun élément n\'a été sélectionné pour être exporté.';
$string['originalauthor'] = 'Auteur';
$string['originalauthor_help'] = 'Nom de l\'auteur de cet élément.';
$string['other'] = 'autre';
$string['otherfiles'] = 'Autres fichiers';
$string['others'] = 'autres';
$string['pluginadministration'] = 'Administration Bibliothèque multimédia';
$string['pluginname'] = 'Bibliothèque multimédia';
$string['productiondate'] = 'Date de production';
$string['productiondate_help'] = 'La date à laquelle l\'élément original a été produit.';
$string['publisher'] = 'Editeur';
$string['publisher_help'] = 'L\'éditeur de l\'élément (s\'il existe).';
$string['readonlyfrom'] = 'En mode lecture seule à partir du';
$string['readonlyto'] = 'En mode lecture seule jusqu\'au';
$string['reference'] = 'Référence';
$string['reference_help'] = 'Référence de la bibliothèque (si elle existe) dont provient l\'élement.';
$string['removethecollection'] = 'Ajouter/Supprimer une bibliothèque';
$string['removecollectionconfirm'] = 'Êtes-vous sûr de vouloir supprimer le lien vers cette bibliothèque multimédia ?';
$string['removegalleryconfirm'] = 'Êtes-vous sûr de vouloir supprimer le lien vers cet album ?';
$string['removeitemconfirm'] = 'Êtes-vous sûr de vouloir supprimer le lien vers cet élément ?';
$string['restrictavailableinfo'] = 'Pour restreindre les dates de disponibilité de cette activité, utilisez la rubrique \'Restreindre l\'accès\' ci-dessous.';
$string['sample'] = 'Exemple';
$string['search'] = 'Rechercher';
$string['search_help'] = 'Entrez les mots clés que vous souhaitez rechercher.';
$string['searchcourseonly'] = 'Seulement ce cours';
$string['searchcourseonly_help'] = 'Est-ce que vous souhaitez rechercher seulement des élements dans les bibliothèques de ce cours ?';
$string['searchdisplayxtoyofzresults'] = '{$a->total} résultat(s) trouvé(s). Affichage de {$a->from} à {$a->to} :';
$string['searchresults'] = 'Résultats';
$string['searchtitle'] = 'Rechercher dans la bibliothèque multimédia';
$string['selection'] = 'Sélection';
$string['settingsavailability'] = 'Date de disponibilité';
$string['settingsdisplay'] = 'Afficher la liste';
$string['settingsgallery'] = 'Valeurs par défaut pour les albums';
$string['settingsgallerydisplay'] = 'Options d\'affichage';
$string['settingsvisibility'] = 'Visibilité';
$string['storagereport'] = 'Bibliothèque multimédia - espace disque utilisé';
$string['storagetotalusage'] = 'Espace total utilisé sur ce site par cette bibliothèque : {$a}.';
$string['submittedforgrading'] = 'Soumettre votre évaluation';
$string['showall'] = 'Toutes';
$string['synclastcompleted'] = 'Dernière synchronisation';
$string['syncwiththebox'] = 'Synchronisation à partir du service theBox';
$string['tags'] = 'Tags';
$string['theboxisnotenabled'] = 'Malheureusement cette bibliothèque n\'est pas disponible car elle utilise le service theBox qui a été désactivé.';
$string['thumbnail'] = 'Vignette';
$string['thumbnail_help'] = 'Vous pouvez choisir une image qui sera utilisée comme vignette pour cet élément dans l\'album.

Si vous ne définissez par de vignette, celle-ci sera générée pour vous à partir de l\'élement téléchargé (pour les photos). Pour les autres fichiers une icone par défaut sera sélectionnée.';
$string['thumbnailsperpage'] = 'Vignettes par page';
$string['thumbnailsperrow'] = 'Vignettes par ligne';
$string['togglefullscreen'] = 'Basculer en plein écran';
$string['togglesidebar'] = 'Afficher ou masquer le menu';
$string['top'] = 'Haut';
$string['typeaudio'] = 'Audio';
$string['typeimage'] = 'Photo';
$string['typevideo'] = 'Vidéo';
$string['unlike'] = 'Je n\'aime plus';
$string['uploader'] = 'Télécharger';
$string['viewfullsize'] = 'Voir l\'image en taille réelle';
$string['viewgallery'] = 'Consulter l\'album';
$string['visibleinstructor'] = 'Visible par les gestionnaires après le';
$string['visibleinstructor_help'] = 'Détermine à partir de quelle date les gestionnaires du cours pourront consulter l\'album. Cela peut être utile pour permettre aux gestionnaires d\'accéder avant tous les autres utilisateurs. Les gestionnaires de cours avec des autorisations appropriées seront toujours en mesure de voir l\'album.';
$string['visibleother'] = 'Visible de tous les apprenants après le';
$string['visibleother_help'] = 'Détermine à partir de quelle date les autres utilisateurs pourront consulter l\'album. Les gestionnaires de cours avec des autorisations appropriées seront toujours en mesure de voir l\'album.';
$string['you'] = 'vous même';
$string['youmusttypedelete'] = 'Vous devez saisir \'DELETE\' pour confirmer la suppression.';
$string['youtubeurl'] = 'URL YouTube';
