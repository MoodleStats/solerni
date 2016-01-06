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
$string['mailgeneratestatus'] = 'Génération des modèles de mails terminée.';
$string['mailtest'] = 'Envoi d\'emails de test';
$string['mailteststatus'] = 'Envoi des emails de test terminé.';
$string['pluginname_desc'] = 'Ce plugin permet de configurer les email envoyé par Solerni.';
$string['orange_mail'] = 'Orange mail';
$string['css'] = 'CSS inclu dans l\'email';
$string['css_desc'] = 'CSS inclus dans tous les emails. Il doit commencer par <STYLE> et terminer par </STYLE>';
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
$string['contactemail'] = 'Email de contact Solerni';
$string['contactemail_desc'] = 'Email de contact Solerni. Cet e-mail est utilisé pour les mails envoyés par la plateforme mais aussi pour le formulaire de contact.';
$string['supportemail'] = 'Email de support Solerni';
$string['supportemail_desc'] = 'Email de support Solerni. Cet e-mail est utilisé pour les mails envoyés par la plateforme mais aussi pour le formulaire de contact.';
$string['marketemail'] = 'Email marketing Solerni';
$string['marketemail_desc'] = 'Email marketing Solerni. Cet e-mail est utilisé pour les mails envoyés par la plateforme mais aussi pour le formulaire de contact.';
$string['partneremail'] = 'Email de partenariat Solerni';
$string['partneremail_desc'] = 'Email de partenariat Solerni. Cet e-mail est utilisé pour les mails envoyés par la plateforme mais aussi pour le formulaire de contact.';
$string['noreplyemail'] = 'Email No Reply Solerni';
$string['noreplyemail_desc'] = 'Email No Reply Solerni. Cet e-mail est utilisé pour les mails envoyés par la plateforme mais aussi pour le formulaire de contact.';
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
        . '</ul>'
        . '<br />Les variables en {$a->xxx} seront traitées par Moodle lors de l\'envoi du mail. Leur nombre varie en fonction de chaque mail.';
$string['helphtml'] = 'Vous pouvez utiliser les variables suivantes dans les templates. Ces variables seront remplacées par du contenu lors de la génération des modèles.'
        . '<ul>'
        . '<li>{$b->imageurl} : répertoire des images pour les emails</li>'
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
        . '</ul>'
        . '<br />Les variables en {$a->xxx} seront traitées par Moodle lors de l\'envoi du mail. Leur nombre varie en fonction de chaque mail.';

// Mail template strings.
$string['solernimailsignature'] = 'L’équipe de <a href="{$b->siteurl}" class="lientxt18orange">{$b->sitename}</a><br />'
        . 'Apprendre c’est toujours mieux ensemble <a href="{$b->siteurl}" class="lientxt18orange">solerni.com</a>';
$string['solernimailsignaturetext'] = 'L’équipe de {$b->sitename}
Apprendre c’est toujours mieux ensemble solerni.com';
$string['solernimailfootertext'] = 'Ce message vous est envoyé automatiquement, merci de ne pas y répondre directement.
              Si vous avez des questions écrivez-nous à {$b->contactemail}.
              Afin de bien recevoir nos e-mails, ajoutez cette adresse {$b->noreplyemail} dans votre carnet d\'adresses.';
$string['solernimailfooterhtml'] = '<p>Ce message vous est envoyé automatiquement, merci de ne pas y répondre directement.<br />
              Si vous avez des questions écrivez-nous à <a href="mailto:{$b->contactemail}" class="lientxt14orange">{$b->contactemail}</a>.<br />
              Afin de bien recevoir nos e-mails, ajoutez cette adresse <a href="mailto:{$b->npreplyemail}" class="lientxt14orange">{$b->noreplyemail}</a> dans votre carnet d\'adresses.</p>';
$string['solernimailfooterinscriptiontext'] = 'Vous recevez cet e-mail car votre adresse e-mail a été utilisée sur notre site {$b->sitename}. Si vous ne vous êtes pas inscrit à {$b->sitename}, veuillez simplement ignorer ce message et votre compte sera supprimé automatiquement.
            Ce message vous est envoyé automatiquement, merci de ne pas y répondre directement.
              Si vous avez des questions écrivez-nous à {$b->contactemail}.
              Afin de bien recevoir nos e-mails, ajoutez cette adresse {$b->noreplyemail} dans votre carnet d\'adresses.';
$string['solernimailfooterinscriptionhtml'] = '<p>Vous recevez cet e-mail car votre adresse e-mail a été utilisée sur notre site <a href="{$b->siteurl}" class="lientxt14orange">{$b->sitename}</a>. Si vous ne vous êtes pas inscrit à {$b->sitename}, veuillez simplement ignorer ce message et votre compte sera supprimé automatiquement.</p>
            <p>Ce message vous est envoyé automatiquement, merci de ne pas y répondre directement.<br />
              Si vous avez des questions écrivez-nous à <a href="mailto:{$b->contactemail}" class="lientxt14orange">{$b->contactemail}</a>.<br />
              Afin de bien recevoir nos e-mails, ajoutez cette adresse <a href="mailto:{$b->npreplyemail}" class="lientxt14orange">{$b->noreplyemail}</a> dans votre carnet d\'adresses.</p>';
$string['solernimailfollowus'] = 'Suivez-nous';


// Original Moodle email strings.
$string['newpasswordtext'] = '<p>Bonjour <span class="txt18BNoir">{$a->firstname} {$a->lastname}</span>,</p>

<p>Le mot de passe de votre compte sur « {$a->sitename} » a été remplacé par un nouveau mot de passe temporaire.</p>

Les informations pour vous connecter sont désormais :<br />

    nom d\'utilisateur : <span class="txt18BNoir">{$a->username}</span><br/>
    mot de passe : {$a->newpassword}<br/>

<p>Merci de visiter cette page afin de changer de mot de passe :
    <a href="{$a->link}" class="lientxt18orange">{$a->link}</a></p>

<p>Dans la plupart des logiciels de messagerie, cette adresse devrait apparaître comme un lien de couleur bleue qu\'il vous suffit de cliquer. Si cela ne fonctionne pas, copiez ce lien et collez-le dans la barre d\'adresse de votre navigateur web.</p>';
$string['contentuseraccountemail'] = '<p>Bonjour <span class="txt18BNoir">{$a->fullname}</span>,<br /><br />
Nous vous remercions pour votre inscription sur le site <strong>{$a->sitename}</strong>.</p>
<p>Voici un rappel de vos identifiants de connexion pour accéder à votre compte :</p>
<ul>
    <li>Email : <a href="{$a->email}" class="lientxt18orange">{$a->email}</a></li>
    <li>Mot de passe : vous seul le connaissez</li>
</ul>
<p>Vous pouvez dès à présent accéder à votre compte en cliquant <a href="{$a->profileurl}" class="lientxt18orange">ici</a>.</p>
<p>A très vite sur {$a->sitename}, votre nouvelle plateforme de Moocs francophone collaborative.</p>';

$string['contentwelcomeemail'] = '<p>Bienvenue <span class="txt18BNoir">{$a->fullname}</span>,</p>
<p>Nous sommes ravis de vous accueillir sur {$a->sitename}, votre nouvelle plateforme de Moocs francophone collaborative.</p>
<p>Plus que l’acquisition de connaissances, nous souhaitons que cette plateforme vous aide à développer vos compétences. Nous pensons en effet qu’aujourd’hui, l’apprentissage ne peut plus se faire seul face à un professeur ou un formateur mais aussi ensemble, en réseau. C\'est à travers un parcours favorisant les échanges et les activités que vous développerez vos compétences. Vous serez à tout moment accompagné(e) par vos pairs mais aussi par des pédagogues dont l’objectif est de faciliter vos apprentissages en stimulant le partage d’information et l\'enrichissement mutuel.</p>
<p><strong>C’est parti, inscrivez-vous à un Mooc</strong><br /></p>
<p>Notre plateforme vient tout juste d’être lancée et s’enrichira au fil des semaines de nouveaux Moocs aux contenus variés. </p>
<p>Vous pouvez d’ores et déjà consulter <a href="{$b->catalogurl}" class="lientxt18orange">notre catalogue</a> et vous inscrire à l’un des Moocs disponibles aujourd’hui. Notre plateforme est ouverte et gratuite, les inscriptions sont donc illimitées&nbsp;! </p>
<p><strong>Restez en contact, restez connecté</strong></p>
<p>Pour être au courant des nouveautés et des évènements sur {$a->sitename}, rejoignez nous sur <a href="{$b->facebook}" target="_new" class="lientxt18orange">Facebook</a> et <a href="{$b->twitter}" target="_new" class="lientxt18orange">Twitter</a>, sans oublier d\'aller faire un tour sur notre <a href="{$b->blog}" target="_new" class="lientxt18orange">Blog</a> qui vous informera des actualités liées  à l’univers de ces nouvelles méthodes d’apprentissage sociales et collaboratives.</p>
<p><strong>Pour bien communiquer, remplissez votre profil</strong></p>
<p>Et pour être sûr(e) de pouvoir échanger avec les autres apprenants et les pédagogues, n’oubliez pas de remplir et de paramétrer votre <a href="{$b->profileurl}" class="lientxt18orange">profil</a>.</p>
<p>Voilà, vous êtes prêt(e) à présent pour vous lancer avec nous dans l’aventure des Moocs collaboratifs.
En espérant vous retrouver très vite sur {$a->sitename} où nous vous souhaitons de vivre de nouvelles expériences enrichissantes&nbsp;!</p>';
$string['emailresetconfirmationhtml'] = '<p>Bienvenue <span class="txt18BNoir">{$a->firstname} {$a->lastname}</span>,</p>

<p> Vous avez demandé la réinitialisation de votre mot de passe. Si vous n\'êtes pas à l\'origine de cette action, veuillez ignorer ce message.</p>

Votre pseudo est : <span class="txt18BNoir">{$a->username}</span>
<br />
<p><a href="{$a->link}" class="lientxt18orange">Veuillez cliquer sur ce lien pour réinitialiser votre mot de passe</a>';
$string['emailresetconfirmation'] = 'Bonjour <span class="txt18BNoir">{$a->firstname}</span>,

Vous avez demandé la réinitialisation de votre mot de passe. Si vous n\'êtes pas à l\'origine de cette action, veuillez ignorer ce message.

Votre pseudo est : <span class="txt18BNoir">{$a->username}</span>.

Veuillez cliquer sur le lien suivant pour réinitialiser votre mot de passe :
{$a->link}

Si le lien ne fonctionne pas, copiez-collez le lien dans la barre d\'adresse de votre navigateur.
';
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
