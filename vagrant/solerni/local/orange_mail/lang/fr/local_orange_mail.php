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
 * @package    local
 * @subpackage orange_mail
 * @copyright  Orange 2015
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// Plugin strings.
$string['pluginname'] = 'Solerni Mail';
$string['orange_mail:config'] = 'Configuration du plugin Orange mail';
$string['mailsetting'] = 'Configuration';
$string['mailgenerate'] = 'Génération des modèles';
$string['mailgeneratestatus'] = 'Génération des modèles de mails terminée. Vous devez purger les caches afin que ces nouveaux modèles soient pris en compte.';
$string['mailtest'] = 'Envoi d\'e-mails de test';
$string['mailteststatus'] = 'Envoi des e-mails de test terminé.';
$string['pluginname_desc'] = 'Ce plugin permet de configurer les e-mail envoyé par Solerni.';
$string['orange_mail'] = 'Orange mail';
$string['css'] = 'CSS inclu dans l\'e-mail';
$string['css_desc'] = 'CSS inclus dans tous les e-mails. Il doit commencer par <STYLE> et terminer par </STYLE>';
$string['header'] = 'Entête du mail';
$string['header_desc'] = 'Entête du mail (partie contenant le logo Orange).';
$string['contentstart'] = 'Avant le contenu du mail';
$string['contentstart_desc'] = 'Code HTML placé avant le contenu du mail';
$string['contentend'] = 'Après le contenu du mail';
$string['contentend_desc'] = 'Code HTML placé après le contenu du mail';
$string['headertext'] = 'Mail Header';
$string['headertext_desc'] = 'Mail Header';
$string['footer'] = 'Mail Footer';
$string['footer_desc'] = 'Mail Footer';
$string['footertext'] = 'Mail Footer';
$string['footertext_desc'] = 'Mail Footer';
$string['footerinscription'] = 'Mail Footer Inscription';
$string['footerinscription_desc'] = 'Mail Footer Inscription';
$string['footerinscriptiontext'] = 'Mail Footer Inscription';
$string['footerinscriptiontext_desc'] = 'Mail Footer Inscription';
$string['signature'] = 'Mail Signature';
$string['signature_desc'] = 'Mail Signature';
$string['signaturetext'] = 'Mail Signature';
$string['signaturetext_desc'] = 'Mail Signature';
$string['followus'] = 'Add "Follow us" section to mail';
$string['followus_desc'] = 'Add "Follow us" section based on the template settings';
$string['followustext'] = 'Add "Follow us" section to mail';
$string['followustext_desc'] = 'Add "Follow us" section based on the template settings';
$string['contactemail'] = 'E-mail de contact Solerni';
$string['contactemail_desc'] = 'E-mail de contact Solerni. Cet e-mail est utilisé pour les mails envoyés par la plateforme mais aussi pour le formulaire de contact.';
$string['supportemail'] = 'E-mail de support Solerni';
$string['supportemail_desc'] = 'E-mail de support Solerni. Cet e-mail est utilisé pour les mails envoyés par la plateforme mais aussi pour le formulaire de contact.';
$string['marketemail'] = 'E-mail marketing Solerni';
$string['marketemail_desc'] = 'E-mail marketing Solerni. Cet e-mail est utilisé pour les mails envoyés par la plateforme mais aussi pour le formulaire de contact.';
$string['partneremail'] = 'E-mail de partenariat Solerni';
$string['partneremail_desc'] = 'E-mail de partenariat Solerni. Cet e-mail est utilisé pour les mails envoyés par la plateforme mais aussi pour le formulaire de contact.';
$string['noreplyemail'] = 'E-mail No Reply Solerni';
$string['noreplyemail_desc'] = 'E-mail No Reply Solerni. Cet e-mail est utilisé pour les mails envoyés par la plateforme mais aussi pour le formulaire de contact.';
$string['heading_general'] = 'Général';
$string['heading_htmltemplate'] = 'Modèle HTML du mail';
$string['heading_texttemplate'] = 'Modèle texte du mail';
$string['helptext'] = 'Vous pouvez utiliser les variables suivantes dans les templates. Ces variables seront remplacées par du contenu lors de la génération des modèles.'
        . '<ul>'
        . '<li>{$b->sitename} : nom du site</li>'
        . '<li>{$b->siteurl} : url du site</li>'
        . '<li>{$b->catalogurl} : url du catalogue</li>'
        . '<li>{$b->profilurl} : url de la page profil</li>'
        . '<li>{$b->facebook} : url de la page Facebook de Solerni</li>'
        . '<li>{$b->twitter} : url de la page Twitter de Solerni</li>'
        . '<li>{$b->blog} : url du blog de Solerni</li>'
        . '<li>{$b->linkedin} : url du Linkedin de Solerni</li>'
        . '<li>{$b->googleplus} : url de la page Googleplus de Solerni</li>'
        . '<li>{$b->dailymotion} : url de la chaîne Dailymotion de Solerni</li>'
        . '<li>{$b->servicename} : Solerni pour la Home ou Solerni - nom de la thématique</li>'
        . '</ul>'
        . '<br />Les variables en {$a->xxx} seront traitées par Moodle lors de l\'envoi du mail. Leur nombre varie en fonction de chaque mail.';
$string['helphtml'] = 'Vous pouvez utiliser les variables suivantes dans les templates. Ces variables seront remplacées par du contenu lors de la génération des modèles.'
        . '<ul>'
        . '<li>{$b->imageurl} : répertoire des images pour les e-mails</li>'
        . '<li>{$b->sitename} : nom du site</li>'
        . '<li>{$b->siteurl} : url du site</li>'
        . '<li>{$b->catalogurl} : url du catalogue</li>'
        . '<li>{$b->profilurl} : url de la page profil</li>'
        . '<li>{$b->facebook} : url de la page Facebook de Solerni</li>'
        . '<li>{$b->twitter} : url de la page Twitter de Solerni</li>'
        . '<li>{$b->blog} : url du blog de Solerni</li>'
        . '<li>{$b->linkedin} : url du Linkedin de Solerni</li>'
        . '<li>{$b->googleplus} : url de la page Googleplus de Solerni</li>'
        . '<li>{$b->dailymotion} : url de la chaîne Dailymotion de Solerni</li>'
        . '<li>{$b->servicename} : Solerni pour la Home ou Solerni - nom de la thématique</li>'
        . '</ul>'
        . '<br />Les variables en {$a->xxx} seront traitées par Moodle lors de l\'envoi du mail. Leur nombre varie en fonction de chaque mail.';

// Mail template strings.
$string['solernimailsignature'] = '<span class="txt18BNoir">L’équipe de {$b->servicename}</span><br />'
        . 'Apprendre c’est toujours mieux ensemble<br /> <a href="{$b->siteurl}" class="lientxt18orange">{$b->siteurl}</a>';
$string['solernimailsignaturetext'] = 'L’équipe de {$b->servicename}
Apprendre c’est toujours mieux ensemble {$b->siteurl}';
$string['solernimailfootertext'] = 'Ce message vous est envoyé automatiquement, merci de ne pas y répondre directement.
              Si vous avez des questions écrivez-nous à {$b->contactemail}.
              Afin de bien recevoir nos e-mails, ajoutez cette adresse {$b->noreplyemail} dans votre carnet d\'adresses.';
$string['solernimailfooterhtml'] = '<p>Ce message vous est envoyé automatiquement, merci de ne pas y répondre directement.<br />
              Si vous avez des questions écrivez-nous à <a href="mailto:{$b->contactemail}" class="lientxt14orange">{$b->contactemail}</a>.<br />
              Afin de bien recevoir nos e-mails, ajoutez cette adresse <a href="mailto:{$b->noreplyemail}" class="lientxt14orange">{$b->noreplyemail}</a> dans votre carnet d\'adresses.</p>';
$string['solernimailfooterinscriptiontext'] = 'Vous recevez cet e-mail car votre adresse e-mail a été utilisée sur notre site {$b->sitename}. Si vous ne vous êtes pas inscrit à {$b->sitename}, veuillez simplement ignorer ce message et votre compte sera supprimé automatiquement.
            Ce message vous est envoyé automatiquement, merci de ne pas y répondre directement.
              Si vous avez des questions écrivez-nous à {$b->contactemail}.
              Afin de bien recevoir nos e-mails, ajoutez cette adresse {$b->noreplyemail} dans votre carnet d\'adresses.';
$string['solernimailfooterinscriptionhtml'] = '<p>Vous recevez cet e-mail car votre adresse e-mail a été utilisée sur notre site <a href="{$b->siteurl}" class="lientxt14orange">{$b->sitename}</a>. Si vous ne vous êtes pas inscrit à {$b->sitename}, veuillez simplement ignorer ce message et votre compte sera supprimé automatiquement.</p>
            <p>Ce message vous est envoyé automatiquement, merci de ne pas y répondre directement.<br />
              Si vous avez des questions écrivez-nous à <a href="mailto:{$b->contactemail}" class="lientxt14orange">{$b->contactemail}</a>.<br />
              Afin de bien recevoir nos e-mails, ajoutez cette adresse <a href="mailto:{$b->noreplyemail}" class="lientxt14orange">{$b->noreplyemail}</a> dans votre carnet d\'adresses.</p>';
$string['solernimailfollowus'] = 'Suivez-nous';


// Original Moodle email strings.
$string['newpasswordtext'] = '<p>Bonjour <span class="txt18BNoir">{$a->firstname} {$a->lastname}</span>,</p>

<p>Le mot de passe de votre compte sur {$a->sitename} a été remplacé par un nouveau mot de passe temporaire.</p>

Les informations pour vous connecter sont désormais :<br />

    nom d\'utilisateur : <span class="txt18BNoir">{$a->username}</span><br/>
    mot de passe : {$a->newpassword}<br/>

<p>Merci de visiter cette page afin de changer de mot de passe :
    <a href="{$a->link}" class="lientxt18orange">{$a->link}</a></p>

<p>Dans la plupart des logiciels de messagerie, cette adresse devrait apparaître comme un lien de couleur bleue qu\'il vous suffit de cliquer. Si cela ne fonctionne pas, copiez ce lien et collez-le dans la barre d\'adresse de votre navigateur web.</p>';
$string['contentuseraccountemail'] = '<p>Bonjour <span class="txt18BNoir">{$a->fullname}</span>,<br /><br />
Bienvenue sur <strong>{$b->servicename}</strong>, votre nouvelle plateforme d\'apprentissage collaborative.</p>
<p>Vos identifiants de connexion pour accéder à votre compte {$b->servicename} sont:</p>
<ul>
    <li>Adresse e-mail : <a href="mailto:{$a->email}" class="lientxt18orange">{$a->email}</a></li>
    <li>Mot de passe : vous seul le connaissez</li>
</ul>
<p>Vos identifiants vous permettent de vous connecter sur l\'ensemble des sites d\'apprentissage collaboratif proposé par {$b->servicename}.</p>
<p>Vous pouvez donc vous connecter à partir de n\'importe quelle thématique et naviguer librement d\'une thématique à une autre.</p>
<p>A bientôt sur {$b->servicename}.</p>';
$string['contentuseraccountemailprivate'] = '<p>Bonjour <span class="txt18BNoir">{$a->fullname}</span>,<br /><br />
Bienvenue sur <strong>{$b->servicename}</strong>, votre nouvelle plateforme d\'apprentissage collaborative.</p>
<p>Vos identifiants de connexion pour accéder à votre compte {$b->servicename} sont:</p>
<ul>
    <li>Adresse e-mail : <a href="mailto:{$a->email}" class="lientxt18orange">{$a->email}</a></li>
    <li>Mot de passe : vous seul le connaissez</li>
</ul>
<p>A bientôt sur {$b->servicename}.</p>';

$string['emailresetconfirmation'] = '<p>Bienvenue <span class="txt18BNoir">{$a->firstname} {$a->lastname}</span>,</p>

<p> Vous avez demandé la réinitialisation de votre mot de passe. Si vous n\'êtes pas à l\'origine de cette action, veuillez ignorer ce message.</p>

Votre pseudo est : <span class="txt18BNoir">{$a->username}</span>
<br />
<p><a href="{$a->link}" class="lientxt18orange">Veuillez cliquer sur ce lien pour réinitialiser votre mot de passe</a>';
$string['emailconfirmation'] = '<p>Bonjour <span class="txt18BNoir">{$a->firstname}</span>,</p>

<p>Nous avons reçu une demande d’inscription de votre part avec votre adresse e-mail.</p>
<p>Afin de valider cette demande nous vous invitons à cliquer sur le lien suivant :<br />
<a href="{$a->link}" class="lientxt18orange">valider mon inscription</a></p>
<p>Si le bouton ne fonctionne pas, copiez-collez le lien suivant dans la barre d’adresse de votre navigateur :  <a href="{$a->link}" class="lientxt18orange">{$a->link}</a></p>';

$string['welcometocoursetext'] = '<p>Bonjour,</p>
<p>Nous vous confirmons votre inscription au Mooc <span class="txt18BNoir">{$a->coursename}</span>.</p>

<p>Nous vous remercions pour votre inscription et vous souhaitons beaucoup de plaisir à suivre ce nouveau parcours d\'apprentissage
 sur {$b->sitename}, votre plateforme de Moocs francophone collaborative.</p>';

$string['informationmessagetext'] = '<p>Bonjour <span class="txt18BNoir">{$a->fullname}</span>,</p>

<p>Merci de votre intérêt pour le cours <span class="txt18BNoir">{$a->coursename}</span>. Vous serrez informé du lancement d\'une nouvelle session.</p>';

$string['defaultemailmsg'] = '<p>Bonjour <span class="txt18BNoir">{$a->fullname}</span>,</p>
        <p>Votre compte a été supprimé de Solerni.<br />Merci d\'avoir utilisé Solerni !</p>';

$string['newusernewpasswordtext'] = '<p>Bonjour <span class="txt18BNoir">{$a->firstname}</span>,</p>
<p>Votre compte utilisateur a été créé sur {$a->sitename}, votre nouvelle plateforme d\'apprentissage collaborative d\'entreprise, sur laquelle vous êtes  invité(e)  à suivre une ou plusieurs formations en ligne.</p>
<p>Vos identifiants de connexion sont :</p>
<ul>
   <li>nom d\'utilisateur : {$a->username}</li>
   <li>mot de passe       : {$a->newpassword}</li>
</ul>
<p><strong>Attention : </strong>ce mot de passe est provisoire, vous devrez  le changer à votre 1ere connexion.</p>
<p>Connectez-vous dès maintenant  sur {$a->sitename}  en cliquant sur le lien suivant :<br />
   <a href="{$a->link}" class="lientxt18orange">{$a->link}</a><br />
afin de personnaliser votre mot de passe.</p>
<p>Si le lien ne fonctionne pas, copiez-collez le lien dans la barre d\'adresse de votre navigateur.</p>
<p>Vous recevez cet e-mail car votre entreprise a souhaité vous inscrire automatiquement sur notre plateforme.</p>
<p>A très bientôt sur {$a->sitename}</p>';

$string['badgemessagebody'] = '<p>Bonjour,</p>
<p>Vous venez d’obtenir le badge « %badgename% »!</p>
<p>Pour retrouver tous les détails de votre badge, rendez-vous sur la page {$a}.</p>';