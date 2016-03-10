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
 * Strings for component 'qtype_ordering', language 'fr'
 *
 * @package   qtype_ordering
 * @copyright  2015 Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['pluginname_link'] = 'question/type/ordonnancement';
$string['absoluteposition'] = 'Position absolue';
$string['gradedetails'] = 'Detail de la notation';
$string['gradingtype'] = 'Type de notation';
$string['gradingtype_help'] = 'Choisir le type de calcul pour la notation.

**Position absolue**
: Un item est consideré comme correct s\'il est à la même position que dans la solution. La plus haute note possible pour la question est **la même que** le nombre d\'items affichés à l\'utilisateur.

**Relative par rapport au prochain item (en excluant le dernier)**
: Un item est consideré comme correct s\'il est suivi par le même item dans la solution. L\'item à la dernière position n\'est pas vérifié. Ainsi, la plus haute note possible pour la question **un de moins que** le nombre d\'items affichés à l\'utilisateur.

**Relative par rapport au prochain item (en incluant le dernier)**
: Un item est consideré comme correct s\'il est suivi par le même item dans la solution. L\'item à la dernière position est inclu donc il ne doit pas avoir d\'item qui le suit. Ainsi, la plus haute note possible pour la question est **la même que** le nombre d\'items affichés à l\'utilisateur.

**Relative par rapport à l\'item précédent et au suivant**
: Un item est consideré comme correct si l\'item précédent et le suivant sont les mêmes que dans la solution. Le premier item ne doit pas avoir d\'item précédent, et le dernier item ne doit pas avoir d\'item qui le suit. Thus, there are two possible points for each item, and the highest possible score for the question is **twice** the number of items displayed to the student. Ainsi, il y a 2 points opssibles pour chaque réponse, et la plus haute note possible est **le double** du nombre d\'items affichés à l\'utilisateur.

**Relative à tous les items précédents et suivants**
: Un item est consideré comme correct si tous les items précédents et tous les suivants sont les mêmes que dans la solution. L\'ordre des items précédents et suivants n\'est pas importants. Ainsi, si ***n*** items sont présentés à l\'utilisateur,  le nombre de choix valides pour chaque item est de ***(n - 1)***, et la plus haute note possible pour la question est ***n x (n - 1)***, ce qui revient au même que ***(n² - n)***.

**Le plus long sous-ensemble ordonné**
: La note est le nombre d\'éléments dans le sous-ensemble du plus long sous-ensemble ordonné. La plus haute note possible pour la question est **la même que** le nombre d\'items affichés à l\'utilisateur.
Un sous-ensemble doit avoir au moins deux éléments. Les sous-ensembles ne doivent pas forcément commencer au premier élément ( mais ils peuvent ) et ils ne doivent pas nécessairement être contigus ( mais ils peuvent être ). Quand il y a plusieurs sous-ensembles de taille identique, les items dans les sous-ensembles qui ont été trouvés en premier, en cherchant de gauche à droite, seront affichés comme correct. Les autres items seront affichés comme incorrect.

**Le plus long sous-ensemble contigu**
: La note est le nombre d\'éléments dans le sous-ensemble du plus long sous-ensemble contigu. La note est le nombre d\'éléments dans le plus long sous-ensemble contigu d\'éléments. Le grade le plus élevé possible est le même que le nombre d\'éléments affichés. Un sous-ensemble doit avoir au moins deux éléments. Les sous-ensembles ne doivent pas commencer au premier élément ( mais ils peuvent ) et ils doivent être contigus. Lorsqu\'il ya plusieurs sous-ensembles de longueur égale, les éléments du sous-ensemble que l\'on trouve d\'abord, lors de la recherche de gauche à droite, seront affichés comme correct. Les autres items seront marqués comme incorrects.';
$string['longestcontiguoussubset'] = 'Le plus long sous-ensemble contigu';
$string['longestorderedsubset'] = 'Le plus long sous-ensemble ordonné';
$string['noscore'] = 'Pas de résultat';
$string['relativeallpreviousandnext'] = 'Relative à tous les items précédents et suivants';
$string['relativenextexcludelast'] = 'Relative par rapport au prochain item (en excluant le dernier)';
$string['relativenextincludelast'] = 'Relative par rapport au prochain item (en incluant le dernier)';
$string['relativeonepreviousandnext'] = 'Relative par rapport à l\'item précédent et au suivant';
$string['scoredetails'] = 'Voici les scores pour chaque item dans la réponse:';

// required strings for Moodle 2.0
$string['ordering'] = 'Ordonnancement';
$string['ordering_help'] = 'Plusieurs éléments sont affichés dans un ordre dispersé. Les éléments peuvent être glissés dans un ordre significatif.';
$string['ordering_link'] = 'question/type/ordonnancement';
$string['orderingsummary'] = 'Placer les objets pêle-mêle dans un ordre significatif.';
