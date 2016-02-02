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
 * Strings for component 'filter_poodll', language 'fr', branch 'MOODLE_29_STABLE'
 *
 * @package   filter_poodll
 * @copyright 1999 onwards Martin Dougiamas  {@link http://moodle.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['activate'] = 'Activer PoodLL ?';
$string['alwayshtml5'] = 'Toujours utiliser HTML5';
$string['audioheight'] = 'Hauteur du lecteur Audio';
$string['audiosplash'] = 'Afficher l\'accueil Audio Simple';
$string['audiosplashdetails'] = 'L\'écran d\'accueil est affiché pour Flowplayer seulement.';
$string['audiotranscode'] = 'Conversion automatique en MP3';
$string['audiotranscodedetails'] = 'Conversion des fichiers audio enregistrés ou téléversés au format MP3 avant de les stocker dans Moodle. Fonctionne seulement lorsque vous utilisez le serveur tokyo.poodll.com, ou les enregistrements téléversés si vous utilisez FFMPEG.';
$string['audiowidth'] = 'Largeur du lecteur Audio';
$string['autotryports'] = 'Essayez des ports différents si la connexion échoue';
$string['bandwidth'] = 'Connexion étudiant en octets par seconde. Affecte la qualité de la Webcam.';
$string['bgtranscode_audio'] = 'Convertir en MP3 en tâche de fond';
$string['bgtranscodedetails_audio'] = 'C\'est plus fiable qu\'exécuter la conversion alors que l\'utilisateur attend. Mais l\'utilisateur n\'obtiendra pas son audio tant que le cron n\'aura pas été exécuté après l\'enregistrement. Ne fonctionne que si vous utilisez FFMPEG et Moodle 2.7 ou supérieur. Pour les enregistrements en MP3 avec l\'enregistreur MP3, la conversion a lieu dans le navigateur, pas sur le serveur. Donc la conversion côté serveur (FFMPEG) ne sera pas utilisée.';
$string['bgtranscodedetails_video'] = 'C\'est plus fiable qu\'exécuter la conversion alors que l\'utilisateur attend. Mais l\'utilisateur n\'obtiendra pas son audio tant que le cron n\'aura pas été exécuté après l\'enregistrement. Ne fonctionne que si vous utilisez FFMPEG et Moodle 2.7 ou supérieur.';
$string['bgtranscode_video'] = 'Convertir en MP4 en tâche de fond';
$string['biggallheight'] = 'Galerie vidéo (grande) : hauteur';
$string['biggallwidth'] = 'Galerie vidéo (grande) : largeur';
$string['capturefps'] = 'Enregistrement vidéo : images par seconde';
$string['captureheight'] = 'Enregistrement vidéo : hauteur';
$string['capturewidth'] = 'Enregistrement vidéo : largeur';
$string['datadir'] = 'Répertoire des données PoodLL';
$string['datadirdetails'] = 'Sous-dossier de Moodle, pour permettre l\'accès à certains composants et l\'accès aux fichiers de ressources multimédias comme avec Moodle 1.9. Ne doit être utilisé que pour des ressources multimédias non sensibles. PoodLL ne va pas créer ou gérer les droits d\'accès de ce dossier.';
$string['defaultplayer'] = 'Lecteur audio/vidéo par défaut';
$string['defaultwhiteboard'] = 'Tableau blanc par défaut';
$string['ffmpeg'] = 'Convertir avec ffmpeg les fichiers multimédia déposés';
$string['ffmpeg_details'] = 'Le logiciel ffmpeg doit être installé sur votre serveur Moodle, et dans le chemin système. Il devra prendre en charge la conversion en MP3. Essayez d\'abord en ligne de commande. Par exemple : ffmpeg-i somefile.flv somefile.mp3 . C\'est encore « expérimental »';
$string['filename'] = 'Nom de fichier par défaut';
$string['filtername'] = 'Filtre PoodLL';
$string['filter_poodll_audioplayer_heading'] = 'Paramètres du lecteur audio';
$string['filter_poodll_camera_heading'] = 'Paramètres de la webcam';
$string['filter_poodll_flowplayer_heading'] = 'Paramètres du lecteur Flowplayer';
$string['filter_poodll_intercept_heading'] = 'Types de fichiers PoodLL par défaut';
$string['filter_poodll_legacy_heading'] = 'Paramètres PoodLL hérités';
$string['filter_poodll_mic_heading'] = 'Paramètres du microphone';
$string['filter_poodll_mp3recorder_heading'] = 'Paramètres de l\'enregistreur MP3';
$string['filter_poodll_network_heading'] = 'Paramètres du réseau PoodLL';
$string['filter_poodll_playertypes_heading'] = 'Types de lecteurs par défaut';
$string['filter_poodll_registration_explanation'] = 'Depuis PoodLL version 2.8.0 vous devez obtenir et saisir une clé d\'enregistrement PoodLL. L\'enregistrement est actuellement gratuit, et vous pouvez obtenir facilement une clé depuis <a href=\'http://poodll.com/registration\'>http://poodll.com/registration</a>';
$string['filter_poodll_registration_heading'] = 'Enregistrer votre PoodLL';
$string['filter_poodll_videogallery_heading'] = 'Paramètres de la galerie vidéo';
$string['filter_poodll_videoplayer_heading'] = 'Paramètres du lecteur vidéo';
$string['filter_poodll_whiteboard_heading'] = 'Paramètres du tableau blanc';
$string['forum_audio'] = 'Forum PoodLL : audio ?';
$string['forum_recording'] = 'Forum PoodLL : enregistrement audio-vidéo activé ?';
$string['forum_video'] = 'Forum PoodLL : vidéo ?';
$string['fp_bgcolor'] = 'Couleur Flowplayer';
$string['fpembedtype'] = 'Méthode d\'intégration Flowplayer';
$string['fp_embedtypedescr'] = 'SWF Object est la méthode la plus fiable. Flowplayer JS gère mieux les images de démarrage de prévisualisation. Si vous utilisez Flowplayer JS, pensez à désactiver les autres filtres multimédia MP3/FLV/MP4 afin d\'éviter un double filtrage.';
$string['fp_enableplaylist'] = 'Activer la playlist audio Flowplayer';
$string['fp_enableplaylistdescr'] = 'Cela nécessite la librairie javascript jQuery et ajoute environ 100 kO à la taille de la page téléchargée. Moodle la mettra en cache, il ne devrait donc y avoir aucun ralentissement notable. Vous devriez également choisir dans les paramètres Flowplayer js d\'intégrer Flowplayer. Purgez le cache après ce changement ou pour n\'importe quelle configuration flowplayer.';
$string['handleflv'] = 'Accepter les fichiers FLV';
$string['handlemov'] = 'Accepter les fichiers MOV';
$string['handlemp3'] = 'Accepter les fichiers MP3';
$string['handlemp4'] = 'Accepter les fichiers MP4';
$string['html5controls'] = 'Contrôles HTML5';
$string['html5fancybutton'] = 'Utilisez le bouton de dépôt';
$string['html5play'] = 'Lecture en HTML5';
$string['html5rec'] = 'Enregistrement en HTML5';
$string['html5use_heading'] = 'Quand utiliser HTML5';
$string['html5widgets'] = 'Widgets PoodLL HTML5';
$string['journal_audio'] = 'Journal PoodLL : audio ?';
$string['journal_recording'] = 'Journal PoodLL : activer les enregistrements audio-vidéo ?';
$string['journal_video'] = 'Journal PoodLL : vidéo ?';
$string['miccanpause'] = 'Permettre la mise en pause (enregistreur MP3 uniquement)';
$string['micecho'] = 'Echo du micro';
$string['micgain'] = 'Gain du micro';
$string['micloopback'] = 'Bouclage du micro';
$string['micrate'] = 'Volume du micro';
$string['micsilencelevel'] = 'Niveau du silence micro';
$string['miniplayerwidth'] = 'Largeur du mini-lecteur';
$string['mobileandwebkit'] = 'Mobiles + navigateurs Webkit (Safari, Chrome, etc.)';
$string['mobileonly'] = 'Seulement les appareils mobiles';
$string['mobile_os_version_warning'] = '<p>La version de votre système d\'exploitation est trop ancienne.</p>
<ul>
<li>Android : version 4 minimum</li>
<li>iOS : version 6 minimum</li>
</ul>';
$string['mp3opts'] = 'Options de conversion MP3 de FFmpeg';
$string['mp3opts_details'] = 'Laissez ceci vide si vous souhaitez laisser FFmpeg prendre les décisions. Tout ce que vous entrez ici apparaîtra entre [ffmpeg -i myfile.xx ] et [ myfile.mp3 ]';
$string['mp3skin'] = 'Habillage MP3';
$string['mp3skin_details'] = 'Si vous voulez utiliser un habillage de l\'enregistreur, entrez son nom ici. Sinon, saisissez : none.';
$string['mp4opts'] = 'Options de conversion MP4 de FFmpeg';
$string['mp4opts_details'] = 'Laissez ceci vide si vous souhaitez laisser FFmpeg prendre les décisions. Tout ce que vous entrez ici apparaîtra entre [ffmpeg -i myfile.xx ] et [ myfile.mp4 ]';
$string['neverhtml5'] = 'Ne jamais utiliser HTML5';
$string['newpairheight'] = 'Hauteur du widget PairWork';
$string['newpairwidth'] = 'Largeur du widget PairWork';
$string['nopoodllresource'] = '--- Sélection de la ressource PoodLL ---';
$string['normal'] = 'Normal';
$string['overwrite'] = 'Écraser aussi ?';
$string['picqual'] = 'Cible webcam qual. 1 - 10';
$string['pluginname'] = 'Filtre PoodLL';
$string['poodll:candownloadmedia'] = 'Peut télécharger des médias';
$string['recui_audiogain'] = 'Gain audio';
$string['recui_audiorate'] = 'Taux audio';
$string['recui_btnupload'] = 'Enregistrer ou choisir un fichier';
$string['recui_close'] = 'Fermer';
$string['recui_continue'] = 'Continuer';
$string['recui_converting'] = 'conversion';
$string['recui_echo'] = 'Suppression d\'écho';
$string['recui_inaudibleerror'] = 'Impossible de vous entendre. Veuillez vérifier les permissions Flash et celles du navigateur internet.';
$string['recui_loopback'] = 'Bouclage';
$string['recui_off'] = 'Désactivé';
$string['recui_ok'] = 'OK';
$string['recui_on'] = 'Activé';
$string['recui_pause'] = 'Pause';
$string['recui_play'] = 'Lecture';
$string['recui_record'] = 'Enregistrer';
$string['recui_silencelevel'] = 'Niveau de silence';
$string['recui_stop'] = 'Stop';
$string['recui_time'] = 'Temps :';
$string['recui_timeouterror'] = 'La demande a expiré. Désolé.';
$string['recui_uploaderror'] = 'Une erreur est survenue et votre fichier n\'a PAS été déposé.';
$string['recui_uploading'] = 'téléversement en cours';
$string['registrationkey'] = 'Clé d\'enregistrement';
$string['registrationkey_explanation'] = 'Saisissez votre clé d\'enregistrement PoodLL ici. C\'est gratuit, mais PoodLL ne fonctionnera pas sans cela. Vous pouvez obtenir une clé depuis <a href=\'http://poodll.com/registration\'>http://poodll.com/registration</a>';
$string['screencapturedevice'] = 'Nom du périphérique de capture d\'écran';
$string['serverhttpport'] = 'Port du serveur PoodLL (HTTP)';
$string['serverid'] = 'Identifiant du serveur PoodLL';
$string['servername'] = 'Adresse de l\'hôte PoodLL';
$string['serverport'] = 'Port du serveur PoodLL (RTMP)';
$string['settings'] = 'Paramètres du filtre PoodLL';
$string['showdownloadicon'] = 'Afficher l\'icône de téléchargement sous les lecteurs';
$string['showheight'] = 'Hauteur du lecteur de capture vidéo';
$string['showwidth'] = 'Largeur du lecteur de capture vidéo';
$string['size'] = 'Taille';
$string['smallgallheight'] = 'Hauteur de la galerie vidéo (petit)';
$string['smallgallwidth'] = 'Largeur de la galerie vidéo (petit)';
$string['studentcam'] = 'Nom choisi pour l\'appareil photo';
$string['studentmic'] = 'Nom choisi pour le microphone';
$string['talkbackheight'] = 'Hauteur du lecteur de retour du son';
$string['talkbackwidth'] = 'Largeur du lecteur de retour du son';
$string['thumbnailsplash'] = 'Utiliser une image de prévisualisation comme accueil';
$string['thumbnailsplashdetails'] = 'Utilise la première image de la vidéo comme image de démarrage. N\'utilisez ceci que lorsque vous utilisez tokyo.poodll.com comme serveur.';
$string['tiny'] = 'Tout petit';
$string['transcode_heading'] = 'Paramètres de conversion audio/vidéo';
$string['unregistered'] = 'PoodLL ne s\'affiche pas car il n\'a pas été enregistré/validé. L\'enregistrement est gratuit. Demandez à votre enseignant/administrateur de visiter les paramètres du filtre PoodLL et de terminer le processus d\'enregistrement.';
$string['usecourseid'] = 'Utiliser l\'identifiant de cours ?';
$string['videoheight'] = 'Hauteur du lecteur vidéo';
$string['videosplash'] = 'Afficher l\'accueil simple vidéo';
$string['videosplashdetails'] = 'L\'écran d\'accueil est seulement affiché pour Flowplayer.';
$string['videotranscode'] = 'Conversion automatique en MP4';
$string['videotranscodedetails'] = 'Convertir automatiquement au format MP4 les fichiers vidéo enregistrés ou déposés avant de les stocker dans Moodle. Fonctionne seulement lorsque vous utilisez le serveur tokyo.poodll.com, ou les enregistrements téléversés si vous utilisez FFMPEG.';
$string['videowidth'] = 'Largeur du lecteur vidéo';
$string['wboardautosave'] = 'Enregistrement automatique (millisecondes)';
$string['wboardautosave_details'] = 'Enregistrer le dessin lorsque l\'utilisateur arrête de dessiner pendant au moins X millisecondes. 0 = pas d\'enregistrement automatique';
$string['wboardheight'] = 'Hauteur du tableau blanc';
$string['wboardwidth'] = 'Largeur du tableau blanc';
$string['whiteboardsave'] = 'Enregistrer l\'image';
$string['wordplayerfontsize'] = 'Taille du texte du lecteur';
