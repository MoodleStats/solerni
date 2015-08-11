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
 * Strings for the Participation credit workshop evaluator
 *
 * @package    workshopeval_credit
 * @copyright  2015 Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['mode'] = 'Mode d\'évaluation';
$string['mode_desc'] = 'Mode d\'évaluation par défaut utilisée par la méthode _Participation credit_.';
$string['mode_help'] = 'Le mode détermine la façon dont la note pour l\'évaluation est calculée.

* Tout ou rien - L\'apprenant doit évaluer toutes les copies attribuées afin d\'obtenir la note maximale; sinon ils reçoivent une note de zéro.
* Proportionnel - La note obtenue est proportionnelle au nombre de copies évaluées. Si toutes les copies attribuées sont évaluées, l\'apprenant devra obtenir la note maximale; si la moitié des copies attribuées sont évaluées, l\'apprenant obtiendra 50% de la note maximale.
* Au moins une copie - L\apprenant doit évaluer au moins une copie pour avoir la note maximum.';
$string['modeall'] = 'Tout ou rien';
$string['modeone'] = 'Au moins une copie';
$string['modeproportional'] = 'Proportionnel';
$string['pluginname'] = 'Participation credit';
