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
 * Lang strings.
 * @package forumngfeature
 * @subpackage delete
 * @copyright 2011 The Open University
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['deletediscussion'] = 'Supprimer la discussion';
$string['undeletediscussion'] = 'Restaurer la discussion';
$string['confirmdeletediscussion'] = 'Etes-vous sûr de vouloir supprimer cette discussion ?';
$string['confirmundeletediscussion'] = 'Etes-vous sûr de vouloir restaurer cette discussion ?';
$string['pluginname'] = 'Suppression/Restauration de discussion';
$string['deleteandemail'] = 'Supprimer et envoyer un courriel';
$string['emailcontentplain'] = 'La discussion que vous avez initié et dont les caractéristiques figurent ci-dessous
a été effacée par \'{$a->firstname} {$a->lastname}\':

Sujet : {$a->subject}
Forum : {$a->forum}
Cours : {$a->course}';


$string['emailcontenthtml'] = 'La discussion que vous avez initié et dont les caractéristiques figurent ci-dessous
a été effacée par \'{$a->firstname} {$a->lastname}\' :<br />
<br />
Sujet : {$a->subject}<br />
Forum : {$a->forum}<br />
Cours : {$a->course}<br/>
<br/>';

$string['notifycontributors'] = 'Notifier les autres contributeurs';
$string['notifycontributors_help'] = 'Envoie un courriel pour informer les contributeurs qui ont posté des messages ou répondu';
$string['notifycontributorsemailcontentplain'] = 'La discussion à laquelle vous avez contribué et dont les caractéristiques figurent ci-dessous
a été effacée par \'{$a->firstname} {$a->lastname}\':

Sujet : {$a->subject}
Forum : {$a->forum}
Cours : {$a->course}';


$string['notifycontributorsemailcontenthtml'] = 'La discussion à laquelle vous avez contribué et dont les caractéristiques figurent ci-dessous
a été effacée par \'{$a->firstname} {$a->lastname}\' :<br />
<br />
Sujet : {$a->subject}<br />
Forum : {$a->forum}<br />
Cours : {$a->course}<br/>
<br/>';
