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
 * Strings for component 'qtype_pmatch', language 'fr', branch 'MOODLE_29_STABLE'
 *
 * @package   qtype_pmatch
 * @copyright 1999 onwards Martin Dougiamas  {@link http://moodle.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['addmoreanswerblanks'] = 'Espaces en blanc pour {no} plus de réponses';
$string['addmoresynonymblanks'] = 'Espaces en blanc pour {no} plus de synonymes';
$string['allowsubscript'] = 'Permettre l’utilisation d’indice';
$string['allowsuperscript'] = 'Permettre l’utilisation d’exposant';
$string['answer'] = 'Réponse : {$a}';
$string['answeringoptions'] = 'Options de saisie des réponses';
$string['answermustbegiven'] = 'Vous devez saisir une réponse s\'il y a une note ou un commentaire.';
$string['answerno'] = 'Réponse {$a}';
$string['answeroptions'] = 'Options de réponse';
$string['anyotheranswer'] = 'Toute autre réponse';
$string['applydictionarycheck'] = 'Vérifiez l\'orthographe de l\'étudiant';
$string['caseno'] = 'Non, la casse est sans importance';
$string['casesensitive'] = 'Sensibilité à la casse';
$string['caseyes'] = 'Oui, la casse doit correspondre';
$string['combinedcontrolnamepmatch'] = 'saisie de texte';
$string['converttospace'] = 'Convertir les caractères suivants en espaces';
$string['correctanswers'] = 'Les réponses correctes';
$string['env_dictmissing'] = 'Le dictionnaire de vérification orthographique manquant {$a->langforspellchecker} pour la langue installée {$a->humanfriendlylang} est installé.';
$string['env_dictmissing2'] = 'L\'étudiant a tenté une vérification orthographique dans la langue « {$a} ». Mais dictionnaire pour cette langue n\'est pas installé.';
$string['env_dictok'] = 'Le dictionnaire correcteur orthographique {$a->langforspellchecker} pour la langue installée {$a->humanfriendlylang} est installé.';
$string['environmentcheck'] = 'Vérifications de l’environnement pour les questions de type pmatch';
$string['env_peclnormalisationmissing'] = 'Le package PECL pour Unicode semble ne pas être correctement installé';
$string['env_peclnormalisationok'] = 'Le Package PECL pour normalisation Unicode est correctement installé';
$string['env_pspellmissing'] = 'La bibliothèque Pspell n’est pas correctement installée';
$string['env_pspellok'] = 'La bibliothèque Pspell est correctement installée';
$string['errors'] = 'Veuillez résoudre les problèmes suivants : {$a}';
$string['err_providepmatchexpression'] = 'Vous devez fournir un terme pmatch ici.';
$string['extenddictionary'] = 'Ajoutez ces mots au dictionnaire';
$string['filloutoneanswer'] = 'Utilisez la syntaxe de filtrage par motif pour décrite les bonnes réponses. Vous devez donner au moins une réponse possible. Les réponses laissées en blanc ne seront pas utilisées. La première réponse correspondante sera utilisée pour déterminer le résultat et le feedback.';
$string['forcelength'] = 'Si la réponse contient plus de 20 mots';
$string['forcelengthno'] = 'ne pas lancer d’avertissement';
$string['forcelengthyes'] = 'avertir que la réponse est trop longue et inviter le répondant à la raccourcir';
$string['ie_illegaloptions'] = 'Options non valides dans le terme "match<strong><em>{$a}</em></strong>()".';
$string['ie_lastsubcontenttypeorcharacter'] = 'Ou le caractère ne doit pas se terminer par un sous-contenu dans "{$a}".';
$string['ie_lastsubcontenttypeworddelimiter'] = 'Le caractère de délimitation du mot ne doit pas se terminer pouar un sous-contenu "{$a}".';
$string['ie_missingclosingbracket'] = 'Parenthèse fermante manquante dans le fragment de code  "{$a}".';
$string['ie_nofullstop'] = 'Les caractères points ne sont pas autorisés dans les termes pmatch. (Les points décimaux au milieu des nombres sont OK.)';
$string['ie_nomatchfound'] = 'Erreur dans le filtrage par motif de code correspondant.';
$string['ie_unrecognisedexpression'] = 'Terme non reconnu.';
$string['ie_unrecognisedsubcontents'] = 'Sous-contenu non reconnu dans le fragment de code "{$a}".';
$string['inputareatoobig'] = 'La zone de saisie définie par "{$a}" est trop grande. La taille de zone de saisie est limitée à une largeur de 150 caractères et à une hauteur de 100 caractères.';
$string['nomatchingsynonymforword'] = 'Pas de synonymes saisis pour mot. Supprimer le mot ou en saisir un ou des synonyme(s).';
$string['nomatchingwordforsynonym'] = 'Vous n’avez pas saisi de mot pour lequel le synonyme est équivalent. Supprimer le(s) synonyme(s) ou saisissez un mot équivalent pour celui-ci.';
$string['notenoughanswers'] = 'Ce type de question requiert au moins {$a} réponses';
$string['pleaseenterananswer'] = 'Veuillez saisir une réponse.';
