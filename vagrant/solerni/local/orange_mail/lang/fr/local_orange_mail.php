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
$string['mailgeneratestatus'] = 'Génération des modèles des e-mails terminée. Vous devez purger les caches afin que ces nouveaux modèles soient pris en compte.';
$string['mailtest'] = 'Envoi d\'e-mails de test';
$string['mailteststatus'] = 'Envoi des e-mails de test terminé.';
$string['pluginname_desc'] = 'Ce plugin permet de configurer les e-mails envoyés par Solerni.';
$string['orange_mail'] = 'Orange mail';
$string['css'] = 'CSS inclu dans l\'e-mail';
$string['css_desc'] = 'CSS inclus dans tous les e-mails. Il doit commencer par <STYLE> et terminer par </STYLE>';
$string['header'] = 'Entête de l\'e-mail';
$string['header_desc'] = 'Entête de l\'e-mail (partie contenant le logo Orange).';
$string['contentstart'] = 'Avant le contenu de l\'e-mail';
$string['contentstart_desc'] = 'Code HTML placé avant le contenu de l\'e-mail';
$string['contentend'] = 'Après le contenu de l\'e-mail';
$string['contentend_desc'] = 'Code HTML placé après le contenu de l\'e-mail';
$string['headertext'] = 'E-mail Header';
$string['headertext_desc'] = 'E-mail Header';
$string['footer'] = 'E-mail Footer';
$string['footer_desc'] = 'E-mail Footer';
$string['footertext'] = 'E-mail Footer';
$string['footertext_desc'] = 'E-mail Footer';
$string['footerinscription'] = 'E-mail Footer Inscription';
$string['footerinscription_desc'] = 'E-mail Footer Inscription';
$string['footerinscriptiontext'] = 'E-mail Footer Inscription';
$string['footerinscriptiontext_desc'] = 'E-mail Footer Inscription';
$string['signature'] = 'E-mail Signature';
$string['signature_desc'] = 'E-mail Signature';
$string['signaturetext'] = 'E-mail Signature';
$string['signaturetext_desc'] = 'E-mail Signature';
$string['followus'] = 'Ajouter une section "Follow us" à l\'e-mail';
$string['followus_desc'] = 'Ajouter une section "Follow us" basée sur le template';
$string['followustext'] = 'Ajouter une section "Follow us" à l\'e-mail';
$string['followustext_desc'] = 'Ajouter une section "Follow us" basée sur le template';
$string['contactemail'] = 'E-mail de contact Solerni';
$string['contactemail_desc'] = 'E-mail de contact Solerni. Cet e-mail est utilisé pour les e-mails envoyés par la plateforme mais aussi pour le formulaire de contact.';
$string['supportemail'] = 'E-mail de support Solerni';
$string['supportemail_desc'] = 'E-mail de support Solerni. Cet e-mail est utilisé pour les e-mails envoyés par la plateforme mais aussi pour le formulaire de contact.';
$string['marketemail'] = 'E-mail marketing Solerni';
$string['marketemail_desc'] = 'E-mail marketing Solerni. Cet e-mail est utilisé pour les e-mails envoyés par la plateforme mais aussi pour le formulaire de contact.';
$string['partneremail'] = 'E-mail de partenariat Solerni';
$string['partneremail_desc'] = 'E-mail de partenariat Solerni. Cet e-mail est utilisé pour les e-mails envoyés par la plateforme mais aussi pour le formulaire de contact.';
$string['noreplyemail'] = 'E-mail No Reply Solerni';
$string['noreplyemail_desc'] = 'E-mail No Reply Solerni. Cet e-mail est utilisé pour les e-mails envoyés par la plateforme mais aussi pour le formulaire de contact.';
$string['heading_general'] = 'Général';
$string['heading_htmltemplate'] = 'Modèle HTML de l\'e-mail';
$string['heading_texttemplate'] = 'Modèle texte de l\'e-mail';
$string['helptext'] = 'Vous pouvez utiliser les variables suivantes dans les templates. Ces variables seront remplacées par du contenu lors de la génération des modèles.'
        . '<ul>'
        . '<li>{$b->sitename} : nom du site</li>'
        . '<li>{$b->siteurl} : url du site</li>'
        . '<li>{$b->customer} : nom du client</li>'
        . '<li>{$b->thematic} : nom de la thématique</li>'
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
        . '<br />Les variables en {$a->xxx} seront traitées par Moodle lors de l\'envoi de l\'e-mail. Leur nombre varie en fonction de chaque mail.';
$string['helphtml'] = 'Vous pouvez utiliser les variables suivantes dans les templates. Ces variables seront remplacées par du contenu lors de la génération des modèles.'
        . '<ul>'
        . '<li>{$b->imageurl} : répertoire des images pour les e-mails</li>'
        . '<li>{$b->sitename} : nom du site</li>'
        . '<li>{$b->siteurl} : url du site</li>'
        . '<li>{$b->customer} : nom du client</li>'
        . '<li>{$b->thematic} : nom de la thématique</li>'
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
        . '<br />Les variables en {$a->xxx} seront traitées par Moodle lors de l\'envoi de l\e-mail. Leur nombre varie en fonction de chaque mail.';

// Mail template strings.
$string['solernimailsignature'] = '<span class="txt18BNoir">L’équipe de {$b->servicename}</span><br />'
        . 'Apprendre c’est toujours mieux ensemble<br /> <a href="{$b->siteurl}" class="lientxt18orange">{$b->sitename}</a>';
$string['solernimailsignaturetext'] = 'L’équipe de {$b->servicename}
Apprendre c’est toujours mieux ensemble {$b->sitename}';

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
$string['solernimailfooterinscriptionprivatetext'] = 'Vous recevez cet e-mail car votre entreprise a souhaité vous inscrire automatiquement sur notre plateforme.
            Ce message vous est envoyé automatiquement, merci de ne pas y répondre directement.
              Si vous avez des questions écrivez-nous à {$b->contactemail}.
              Afin de bien recevoir nos e-mails, ajoutez cette adresse {$b->noreplyemail} dans votre carnet d\'adresses.';
$string['solernimailfooterinscriptionprivatehtml'] = '<p>Vous recevez cet e-mail car votre entreprise a souhaité vous inscrire automatiquement sur notre plateforme.
            <p>Ce message vous est envoyé automatiquement, merci de ne pas y répondre directement.<br />
              Si vous avez des questions écrivez-nous à <a href="mailto:{$b->contactemail}" class="lientxt14orange">{$b->contactemail}</a>.<br />
              Afin de bien recevoir nos e-mails, ajoutez cette adresse <a href="mailto:{$b->noreplyemail}" class="lientxt14orange">{$b->noreplyemail}</a> dans votre carnet d\'adresses.</p>';
$string['solernimailfollowus'] = 'Suivez-nous';


// Original Moodle email strings.
// Mail M1.
$string['newpasswordtext'] = '<p>Bonjour <span class="txt18BNoir">{$a->firstname} {$a->lastname}</span>,</p>

<p>Le mot de passe de votre compte {$b->servicename} a été remplacé par un nouveau mot de passe temporaire. Ce mot de passe temporaire devra être personnalisé à votre prochaine connexion.</p>

Les informations pour vous connecter sont désormais :<br />

<p>
    pseudo : <span class="txt18BNoir">{$a->username}</span><br/>
    mot de passe temporaire : {$a->newpassword}</p>

<p>Nous vous invitons à vous connecter dès maintenant en cliquant sur le lien ci-après afin de personnaliser votre mot de passe sans attendre :
    <a href="{$a->link}" class="lientxt18orange">personnaliser mon mot de passe</a></p>

<p>Si celui-ci ne fonctionne pas, vous pouvez copier-coller le lien dans la barre d\'adresse de votre navigateur : <a href="{$a->link}" class="lientxt18orange">{$a->link}</a></p>
<p>A bientôt sur {$b->servicename}.</p>';

// Mail M2 public.
$string['contentuseraccountemail'] = '<p>Bonjour <span class="txt18BNoir">{$a->fullname}</span>,<br /><br />
Bienvenue sur <span class="txt18BNoir">{$b->sitename}</span>, votre nouvelle plateforme d\'apprentissage collaborative.</p>
<p>Vos identifiants de connexion pour accéder à votre compte {$b->sitename} sont:<ul>
    <li>E-mail : <a href="mailto:{$a->email}" class="lientxt18orange">{$a->email}</a></li>
    <li>Mot de passe : vous seul le connaissez</li>
</ul></p>
<p>Vos identifiants vous permettent de vous connecter sur l\'ensemble des sites d\'apprentissage collaboratif proposés par {$b->servicename}.</p>
<p>Vous pouvez donc vous connecter à partir de n\'importe quelle thématique et naviguer librement d\'une thématique à une autre.</p>
<p>A bientôt sur {$b->servicename}.</p>';
$string['contentuseraccountemailprivate'] = '<p>Bonjour <span class="txt18BNoir">{$a->fullname}</span>,<br /><br />
Bienvenue sur <span class="txt18BNoir">{$b->servicename}</span>, votre nouvelle plateforme d\'apprentissage collaborative.</p>
<p>Vos identifiants de connexion pour accéder à votre compte {$b->servicename} sont:<ul>
    <li>E-mail : <a href="mailto:{$a->email}" class="lientxt18orange">{$a->email}</a></li>
    <li>Mot de passe : vous seul le connaissez</li>
</ul></p>
<p>A bientôt sur {$b->servicename}.</p>';

// Mail M4 public.
$string['emailresetconfirmation'] = '<p>Bonjour <span class="txt18BNoir">{$a->firstname} {$a->lastname}</span>,</p>
<p>Vous avez demandé la réinitialisation de votre mot de passe. Si vous n\'êtes pas à l\'origine de cette action, veuillez ignorer ce message.</p>
<p>Votre pseudo est : <span class="txt18BNoir">{$a->username}</span></p>
<p>Veuillez cliquer sur le lien ci-après pour réinitialiser votre mot de passe :<br />
<a href="{$a->link}" class="lientxt18orange">réinitialiser mon mot de passe</a></p>
<p>Si ce dernier ne fonctionne pas, vous pouvez copier-coller le lien suivant dans la barre d\'adresse de votre navigateur :<br />
<a href="{$a->link}" class="lientxt18orange">{$a->link}</a></p>
<p>A bientôt sur {$b->servicename}.</p>';

// Mail M5.
$string['emailconfirmation'] = '<p>Bonjour <span class="txt18BNoir">{$a->firstname}</span>,</p>
<p>Nous avons reçu une demande d’inscription de votre part avec votre adresse e-mail.</p>
<p>Afin de valider cette demande nous vous invitons à cliquer sur le lien suivant :<br />
<a href="{$a->link}" class="lientxt18orange">valider mon inscription</a></p>
<p>Si celui-ci ne fonctionne pas, vous pouvez copier-coller le lien ci-après dans la barre d’adresse de votre navigateur :<br/>
<a href="{$a->link}" class="lientxt18orange">{$a->link}</a></p>
<p>A bientôt sur {$b->servicename}.</p>';

// Mail M6.
$string['welcometocoursetext'] = '<p>Bonjour,</p>
<p>Nous vous confirmons votre inscription au Mooc "<span class="txt18BNoir">{$a->coursename}</span>".</p>
<p>Nous vous remercions pour votre inscription et vous souhaitons beaucoup de plaisir à suivre ce nouveau parcours d\'apprentissage
 sur <span class="txt18BNoir">{$b->sitename}</span>, votre plateforme d\'apprentissage collaboratif.</p>';

// Mail M7.
$string['informationmessagetext'] = '<p>Bonjour <span class="txt18BNoir">{$a->fullname}</span>,</p>
<p>Vous avez demandé à être alerté(e) de la prochaine session du MOOC <a href="{$a->learnmoreurl}" class="lientxt18orange">{$a->coursename}</a>.</p>
<p>Votre demande a été enregistrée et nous vous en remercions.</p>
<p>A bientôt sur {$b->servicename}.</p>';

// Mail M8.
$string['defaultemailmsg'] = '<p>Bonjour <span class="txt18BNoir">{$a->fullname}</span>,</p>
<p>Nous vous informons que votre compte a bien été supprimé de notre plateforme <span class="txt18BNoir">{$b->sitename}</span>.</p>
</p>Merci d\'avoir utilisé <span class="txt18BNoir">{$b->sitename}</span> !</p>';

// Mail M14 public.
$string['newusernewpasswordtext'] = '<p>Bonjour <span class="txt18BNoir">{$a->firstname}</span>,</p>
<p>Solerni, votre plateforme d\'apprentissage collaborative, évolue et change d\'adresse par la même occasion.</p>
<p><span class="txt18BNoir">Comment accéder à la nouvelle version {$a->sitename} ?</span></p>
<p>Pour accéder à la nouvelle version et découvrir nos derniers MOOCs, vous devez désormais vous rendre sur {$a->sitename} et utiliser les identifiants suivants :<br />
<ul>
   <li>nom d\'utilisateur : {$a->username}</li>
   <li>mot de passe       : {$a->newpassword}</li>
</ul>
</p>
<p><span class="txt18BNoir">Attention : </span>ce mot de passe est provisoire, vous devrez  le changer à votre première connexion.</p>
<p>Vos nouveaux identifiants vous permettent de vous connecter sur l\'ensemble des sites d\'apprentissage thématiques proposés par {$b->servicename}.</p>
<p>Vous pouvez donc vous connecter à partir de n\'importe quelle thématique avec vos nouveaux identifiants et naviguer librement d\'une thématique à une autre.</p>
<p><span class="txt18BNoir">Que devient l\'ancienne version solerni.org ?</span></p>
<p>L\'ancienne version <a href="http://solerni.org" class="lientxt18orange">solerni.org</a> reste accessible avec vos identifiants habituels pour y consulter vos MOOCs archivés.</p>
<p></p>
<p>Connectez-vous dès maintenant  sur {$a->sitename} en cliquant sur le lien suivant afin de personnaliser votre mot de passe :<br />
   <a href="{$a->link}" class="lientxt18orange">personnaliser mon mot de passe</a>
</p>
<p>Si le lien ne fonctionne pas, vous pouvez copier-coller le lien ci-après dans la barre d\'adresse de votre navigateur : <br />
   <a href="{$a->link}" class="lientxt18orange">{$a->link}</a>
</p>

<p>A très bientôt sur {$b->servicename}</p>';

// Mail M14 private.
$string['newusernewpasswordtext_private'] = '<p>Bonjour <span class="txt18BNoir">{$a->firstname}</span>,</p>
<p>Votre compte utilisateur a été créé sur {$a->sitename}, votre nouvelle plateforme d\'apprentissage collaborative d\'entreprise, sur laquelle vous êtes invité(e) à suivre une ou plusieurs formations en ligne.</p>
<p>Vos identifiants de connexion sont :</p>
<ul>
   <li>nom d\'utilisateur : {$a->username}</li>
   <li>mot de passe       : {$a->newpassword}</li>
</ul>
<p><span class="txt18BNoir">Attention : </span>ce mot de passe est provisoire, vous devrez  le changer à votre première connexion.</p>
<p>Connectez-vous dès maintenant  sur {$a->sitename} en cliquant sur le lien suivant afin de personnaliser votre mot de passe :<br />
   <a href="{$a->link}" class="lientxt18orange">personnaliser mon mot de passe</a>
</p>
<p>Si le lien ne fonctionne pas, vous pouvez copier-coller le lien ci-après dans la barre d\'adresse de votre navigateur : <br />
   <a href="{$a->link}" class="lientxt18orange">{$a->link}</a>
</p>
<p>A très bientôt sur {$b->servicename}</p>';

// Mail M16 badge.
$string['messagebody'] = '<p>Bonjour,</p>
<p>Vous venez d’obtenir le badge <span class="lientxt18orange">%badgelink%</span>.</p>
<p>Pour retrouver tous les détails de votre badge, rendez-vous sur la page {$a} accessible depuis votre tableau de bord.</p>
<p>A très bientôt sur {$b->servicename}</p>';

// Mail M17.
$string['emailupdatemessage'] = '<p>Bonjour <span class="txt18BNoir">{$a->fullname}</span>,</p>
<p>Vous avez demandé la modification de votre adresse e-mail pour votre compte utilisateur sur {$a->site}.</p>
<p>Afin de valider cette demande nous vous invitons à cliquer sur le lien suivant.<br />
<a href="{$a->url}" class="lientxt18orange">confirmer le changement de mon adresse e-mail</a>
</p>
<p>Si celui-ci ne fonctionne pas, vous pouvez copier-coller le lien ci-après dans la barre d\'adresse de votre navigateur :<br />
   <a href="{$a->url}" class="lientxt18orange">{$a->url}</a>
</p>';
