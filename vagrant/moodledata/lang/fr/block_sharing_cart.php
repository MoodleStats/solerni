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
 * Strings for component 'block_sharing_cart', language 'fr', branch 'MOODLE_29_STABLE'
 *
 * @package   block_sharing_cart
 * @copyright 1999 onwards Martin Dougiamas  {@link http://moodle.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['backup'] = 'Copier dans le panier d\'activités';
$string['bulkdelete'] = 'Purge du panier';
$string['clipboard'] = 'Coller cet élément';
$string['confirm_backup'] = 'Souhaitez-vous copier cet élément dans le panier d\'activités ?';
$string['confirm_delete'] = 'Voulez-vous vraiment supprimer cet élément ?';
$string['confirm_delete_selected'] = 'Êtes-vous sûr de vouloir supprimer tous les éléments sélectionnés ?';
$string['confirm_restore'] = 'Souhaitez-vous coller cet élément dans le cours ?';
$string['confirm_userdata'] = 'Souhaitez-vous inclure les données utilisateurs dans la copie de cette activité ?';
$string['copyhere'] = 'Coller ici';
$string['forbidden'] = 'Vous n\'avez pas l\'autorisation d\'accéder à cet élément';
$string['invalidoperation'] = 'Une opération invalide a été détectée';
$string['movedir'] = 'Déplacer dans un dossier';
$string['notarget'] = 'Cible non trouvée';
$string['pluginname'] = 'Panier d\'activités';
$string['recordnotfound'] = 'Impossible de trouver l\'élément';
$string['requireajax'] = 'Le panier d\'activités nécessite l\'activation d\'AJAX';
$string['requirejs'] = 'Le JavaScript de votre navigateur doit être activé pour pouvoir utiliser le panier d\'activités';
$string['restore'] = 'Coller dans le cours';
$string['settings:userdata_copyable_modtypes'] = 'Type de module avec données utilisateur copiables';
$string['settings:userdata_copyable_modtypes_desc'] = 'Lors de la copie d\'une activité dans le partage de panier, une boîte de dialogue affiche une option si une copie d\'une activité comprend les données utilisateur ou non, si ce type de module est coché ci-dessus et qu\'un opérateur a les capacités <strong>moodle/backup:userinfo</strong>, <strong>moodle/backup:anonymise</strong> et <strong>moodle/restore:userinfo</strong> (par défaut, seul le rôle de gestionnaire a ces capacités.)';
$string['settings:workaround_qtypes'] = 'Solution pour les types de questions';
$string['settings:workaround_qtypes_desc'] = 'La solution pour la restauration de question sera effectuée si son type de question est cochée.
Cependant, lorsque les questions à restaurer existent déjà, ces données seront incompatibles, cette solution de contournement va essayer de faire un autre doublon au lieu de réutiliser les données existantes.
Cette solution peut être utile pour éviter certaines erreurs de restauration, telles que <i>error_question_match_sub_missing_in_db</i>.';
$string['sharing_cart'] = 'Panier d\'activités';
$string['sharing_cart:addinstance'] = 'Ajouter le bloc panier d\'activités';
$string['sharing_cart_help'] = '<h2 class="helpheading">Aide</h2>
<dl style="margin-left:0.5em;">
<dt>Copier un élément du cours vers le panier d\'activités</dt>
<dd>Dans le menu contextuel de l\'activité ou de la ressource, vous verrez apparaitre la fonction "Copier dans le panier d\'activités".  Cliquez sur cette fonction pour envoyer une copie de la ressource/activité vers le panier d\'activités.  L\'élément sera copié dans le panier. Suivant le type d\'élément copié, il vous sera parfois demandé si vous souhaitez y inclure les données utilisateurs.   L\'élément sera copié avec ou sans données utilisateurs.</dd>
<dt>Coller un élément du panier d\'activités vers le cours</dt>
<dd>Depuis le bloc panier d\'activités, cliquez sur l\'icône "Coller dans le cours" de l\'activité/ressource souhaitée et indiquez sur quelle section vous souhaitez coller l\'élément.  Pour annuler la copie, cliquez sur l\'icône "Annuler" dans l\'entête du cours.</dd>
<dt>Créer des répertoires au sein du panier d\'activités</dt>
<dd>Cliquez sur l\'icône "Déplacer dans un dossier" de l\'élément que vous souhaitez déplacer.  Si vous n\'avez pas de dossier sur le panier, vous serez invité à saisir le nom du nouveau dossier à créer.  Si vous avez déjà des dossiers sur votre panier, vous pouvez sélectionner un dossier existant dans la liste déroulante.   Pour basculer sur le champ de saisie d\'un nouveau nom de dossier, cliquez sur l\'icône "Modifier". icon.</dd>
</dl>';
$string['unexpectederror'] = 'Une erreur inattendue est survenue';
