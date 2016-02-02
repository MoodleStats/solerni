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
 * Strings for component 'tool_mergeusers', language 'fr', branch 'MOODLE_28_STABLE'
 *
 * @package   tool_mergeusers
 * @copyright 1999 onwards Martin Dougiamas  {@link http://moodle.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['choose_users'] = 'Choisir les utilisateurs à fusionner';
$string['clear_selection'] = 'Désélectionnez l\'utilisateur actuel';
$string['cligathering:description'] = 'Introduire les paires d’identifiant d’utilisateur pour fusionner le premier avec le deuxième. Le premier identifiant d’utilisateur (fromid) perdra toutes ses données qui seront transférés vers le second (toid). L’utilisateur « toid » inclura des données des deux utilisateurs.';
$string['cligathering:fromid'] = 'ID de l\'utilisateur d\'origine (fromid) :';
$string['cligathering:stopping'] = 'Pour interrompre, tapez Ctrl+C ou entrez -1 dans les deux champs (fromid et toid).';
$string['cligathering:toid'] = 'ID de l\'utilisateur de destination (toid) :';
$string['dbko_no_transactions'] = '<strong>La fusion a échoué !</strong> <br/> Votre moteur de base de données pas supporte les transactions. Par conséquent, votre base de données <strong>a été modifiée</strong> et a été laissée dans un état incohérent. <br/>Vérifiez le journal de la fusion et signalez les erreurs aux développeurs de plugin.<br/> Une fois le plugin corrigé par les développeurs et mis à jour, réitérez la fusion pour finaliser.';
$string['dbko_transactions'] = '<strong>La fusion a échoué !</strong> <br/>Votre moteur de base de données supporte les transactions. Par conséquent, la base de données <strong>n\'a pas été modifiée</strong>.';
$string['dbok'] = 'La fusion a réussi';
$string['deleted'] = 'L\'utilisateur d\'ID {$a} a été éliminé';
$string['errordatabase'] = 'Erreur : type de base de données {$a} non supporté.';
$string['errorsameuser'] = 'Impossible de fusionner le même utilisateur';
$string['errortransactionsonly'] = 'Erreur : le support des transactions est requis, et votre base de données {$a} ne les supporte pas. Si nécessaire, vous pouvez configurer ce module pour que les fusions sont faites sans utiliser les transactions. Ajustez les paramètres en fonction de vos besoins.';
$string['excluded_exceptions'] = 'Exceptions à exclure';
$string['excluded_exceptions_desc'] = 'L\'expérience dans ce domaine suggère que ces tables de base de données doivent être exclues du processus fusion. Voir le fichier README pour plus de détails.<br>Donc, si vous voulez appliquer le comportement par défaut, vous devez choisir \'{$a}\' afin d\'exclure ces tables du processus de fusion (recommandé).<br>Si vous préférez, vous pouvez choisir les tables que vous souhaitez inclure dans le processus de fusion (non recommandé).';
$string['header'] = 'Fusionner deux comptes utilisateur en un';
$string['header_help'] = '<p>Étant donné un utilisateur à supprimer et un utilisateur à conserver, ceci fusionnera toutes les données utilisateur vers le compte de l\'utilisateur à conserver. Les deux utilisateurs doivent exister dans la base d\'utilisateurs de Moodle, et aucun compte n\'est supprimé par cet utilitaire (ceci est laissé au loisir de l\'administrateur).</p><p><strong>N\'utilisez ceci que si vous en comprenez les implications, car les opérations réalisées ici ne sont pas réversibles !</strong></p>';
$string['into'] = 'vers';
$string['invaliduser'] = 'Utilisateur non valide';
$string['logid'] = 'Pour référence ultérieure, ces données apparaissent dans le journal avec l\'id {$a}.';
$string['tableskipped'] = 'Pour des raisons de traçabilité ou de sécurité, la table <strong>{$a}</strong> n\'est pas traitée.<br />Pour supprimer ces entrées, supprimez l\'ancien compte utilisateur une fois la fusion réussie.';
$string['transactions_not_supported'] = 'Pour votre information, votre base de données <strong>ne prend pas en charge les transactions</strong>.';
$string['transactions_setting'] = 'Seules les transactions sont autorisées';
$string['transactions_setting_desc'] = 'Si cette option est activée, les comptes utilisateur ne peuvent être fusionnés que si votre base de données prend en charge les transactions (recommandé). Avec cette option activée, vous vous assurez que la base de données reste toujours dans un état cohérent, même si une fusion se termine avec des erreurs.<br /> Si cette option est désactivée, vous pourrez fusionner des comptes utilisateur sans utiliser de transactions.
En cas d\'erreur, l\'inscription de la fusion montrera quel était le problème. Si vous signalé cette erreur aux développeurs de ce plugin, une solution devrait être trouvée rapidement.<br />Notez que ce plugin gère tous les composants standard de Moodle. Par conséquent, si vous avez une installation de Moodle standard, vous pouvez exécuter ce plugin sans problème avec cette option activée ou désactivée.';
$string['transactions_supported'] = 'Pour votre information, votre base de données <strong>prend en charge les transactions</strong>.';
$string['viewlog'] = 'Voir le journal des fusions';
$string['wronglogid'] = 'L\'historique que vous demandez n\'existe pas.';
