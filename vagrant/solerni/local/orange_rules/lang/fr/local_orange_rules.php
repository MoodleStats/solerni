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
 * English language strings
 *
 * @package    local
 * @subpackage orange_rules
 * @copyright  2015 Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['pluginname'] = 'Orange Rules';
$string['listrules'] = 'Gestion des règles';
$string['definerulesheader'] = 'Gestion des règles';
$string['actionrules_list'] = 'Liste des règles';
$string['actionrules_form'] = 'Ajouter une nouvelle règle';

$string['ruleid'] = 'Id.';
$string['rulename'] = 'Nom de la règle';
$string['nbruleemails'] = 'Nombre d\'emails autorisés';
$string['nbruledomains'] = 'Nombre de domaines autorisés';
$string['ruleemails'] = 'Liste des emails autorisés';
$string['ruledomains'] = 'Liste des domaines autorisés';
$string['ruleemails_help'] = 'Liste des emails autorisés. Un email par ligne.';
$string['ruledomains_help'] = 'Liste des domaines autorisés. Un domaine par ligne.';
$string['rulecohorts'] = 'Cohorte associée à la règle';
$string['rulecohorts_help'] = 'Seules les cohortes qui ne sont associées à aucune règle sont présentées ici';

$string['suspendrule'] = 'Désactiver la règle';
$string['unsuspendrule'] = 'Activer la règle';
$string['impossibleaction'] = "Action impossible, la cohorte associée a été supprimée";
$string['confirmdeleterule'] = 'Voulez-vous vraiment supprimer la règle <b>{$a}</b> ?';
$string['ruledeleted'] = 'La règle {$a} a été supprimée';
$string['selectcohort'] = 'Sélectionner une cohorte';
$string['cohortempty'] = 'Vous devez sélectionner une cohorte';
$string['cohortdeleted'] = 'Cette règle n\'est affectée à aucune cohorte';

$string['noaddrulewarning'] = 'La règle ne peut être créée. Deux raisons possibles : son nom existe déjà ou la cohorte choisie a déjà été affectée à une autre règle.';

$string['eventruleupdated'] = 'Règle modifée';

$string['orange_rules:edit'] = 'Edition des règles';