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
 * Strings for component 'auth_google', language 'fr'
 *
 * @package   auth_google
 * @copyright  2015 Orange
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['pluginname'] = 'Oauth2';
$string['auth_battlenetclientid'] = 'Votre App ID/Secret peut être généré sur <a href="https://dev.battle.net/apps/mykeys">le site Battle.net API</a>.
Saisissez les paramètres suivants lors de la création d\'une application:
<br/>Web site: {$a->siteurl}
<br/>Register callback url: {$a->callbackurl} [Il faut une url HTTPS sinon Battle.net refuse de vous logger]
<br/>Franchises: Starcraft II';
$string['auth_battlenetclientid_key'] = 'Battle.net key';
$string['auth_battlenetclientsecret'] = '';
$string['auth_battlenetclientsecret_key'] = 'Battle.net secret';
$string['auth_dropboxclientid'] = 'Votre App ID/Secret peut être généré dans la <a href="https://www.dropbox.com/developers/apps">console Dropbox app</a>.
Saisissez les paramètres suivants lors de la création d\'une application:
<br/>App website: {$a->siteurl}
<br/>Redirect URIs: {$a->callbackurl}';
$string['auth_dropboxclientid_key'] = 'Dropbox App key';
$string['auth_dropboxclientsecret'] = '';
$string['auth_dropboxclientsecret_key'] = 'Dropbox App secret';
$string['auth_facebookclientid'] = 'Votre App ID/Secret peut être généré dans la <a href="https://developers.facebook.com/apps/">page Facebook pour developer</a>:
<br/>Add a new app > Website > Enter your site name as app name > Create new facebook app ID > Enter the Site URL - no need to enter Mobile URL > On the confirmation page, look for the "Skip to Developer Dashboard" link > on the app dashboard you should find the id/secret > Settings > Advanced > enter the Valid OAuth redirect URIs
<br/>Site URL: {$a->siteurl}
<br/>Site domain: {$a->sitedomain}
<br/>Valid OAuth redirect URIs: {$a->callbackurl}';
$string['auth_facebookclientid_key'] = 'Facebook App ID';
$string['auth_facebookclientsecret'] = 'Voir ci-dessus.';
$string['auth_facebookclientsecret_key'] = 'Facebook App secret';
$string['auth_githubclientid'] = 'Votre client ID/Secret peut être généré dans la <a href="https://github.com/settings/applications/new">page Github</a>:
<br/>Homepage URL: {$a->siteurl}
<br/>Authorization callback URL: {$a->callbackurl}';
$string['auth_githubclientid_key'] = 'ID client Github';
$string['auth_githubclientsecret'] = 'Voir ci-dessus.';
$string['auth_githubclientsecret_key'] = 'client secret Github';
$string['auth_googleclientid'] = 'Votre client ID/Secret peut être généré dans la <a href="https://code.google.com/apis/console">console Google API</a>:
<br/>
Project > APIS & AUTH > Credentials > Create new Client ID > Web application
<br/>
Authorized Javascript origins: {$a->jsorigins}
<br/>
Authorized Redirect URI: {$a->redirecturls}
<br/>
You also need to <strong>enable the "Google+ API"</strong> in Project > APIS & AUTH > APIs';
$string['auth_googleclientid_key'] = 'Google Client ID';
$string['auth_googleclientsecret'] = 'Voir ci-dessus.';
$string['auth_googleclientsecret_key'] = 'Google Client secret';
$string['auth_googleipinfodbkey'] = 'IPinfoDB est un service qui vous permet de connaitre le pays et la ville de vos visiteurs. Ce paramétrage est optionel. Vous pouvez souscrire à <a href="http://www.ipinfodb.com/register.php">IPinfoDB</a> pour avoir une clef.<br/>
Website: {$a->website}';
$string['auth_googleipinfodbkey_key'] = 'IPinfoDB Key';
$string['auth_googleuserprefix'] = 'Le pseudo des utilisateurs commencera par ce prefix. Sur un site Moodle basic, vous n\'avez pas à changer cette option';
$string['auth_googleuserprefix_key'] = 'Pseudo prefix';
$string['auth_googleoauth2description'] = 'Ce plugin offre aux utilisateurs la opssibilité de se connecter sur le site via un fournisseur externe: Google/Facebook/Windows Live. La première fois que l\'utilisateur se connecte via ce plugin, un nouveau compte est créé. L\'option <a href="'.$CFG->wwwroot.'/admin/search.php?query=authpreventaccountcreation">Empêcher la création de compte lors de l\'authentification</a> <b>doit</b> être décochée.';
$string['auth_linkedinclientid'] = 'Votre clef API/Secret peut être générée dans la <a href="https://www.linkedin.com/secure/developer">page Linkedin register application</a>:
<br/>Website URL: {$a->siteurl}
<br/>OAuth 1.0 Accept Redirect URL: {$a->callbackurl}';
$string['auth_linkedinclientid_key'] = 'Linkedin API Key';
$string['auth_linkedinclientsecret'] = 'Voir ci-dessus.';
$string['auth_linkedinclientsecret_key'] = 'Linkedin Secret key';
$string['auth_vkclientid_key'] = 'VK app id';
$string['auth_vkclientsecret_key'] = 'VK app secret';
$string['auth_vkclientid'] = 'Votre App ID/Secret peut être généré dans la <a href="https://vk.com/editapp?act=create">page VK developer</a>.<br/>
Base domain: {$a->siteurl} (without http://)<br/>
Site address: {$a->callbackurl}';
$string['auth_vkclientsecret'] = '';
$string['auth_messengerclientid'] = 'Votre clef API/Secret peut être générée dans la <a href="https://account.live.com/developers/applications">page Windows Live apps</a>:
<br/>Redirect domain: {$a->domain}';
$string['auth_messengerclientid_key'] = 'Messenger Client ID';
$string['auth_messengerclientsecret'] = 'Voir ci-dessus.';
$string['auth_messengerclientsecret_key'] = 'Messenger Client secret';
$string['auth_googlesettings'] = 'Paramétrages';
$string['couldnotauthenticate'] = 'L\'authentification a échoué - Essayer de vous re-connecter.';
$string['couldnotgetgoogleaccesstoken'] = 'Il y a une erreur de communication entre Solerni et le site d\'authentification. Essayer de vous re-connecter.';
$string['couldnotauthenticateuserlogin'] = 'Erreur d\'authentification.<br/>
L\'utilisateur existe déjà sur Solerni, connectez-vous avec votre login et mot de passe.<br/>
<br/>
<a href="{$a->loginpage}">Essayez de vous re-connecter</a>.<br/>
<a href="{$a->forgotpass}">Vous avez oublié votre mot de passe</a>?';
$string['oauth2displaybuttons'] = 'Afficher les boutons sur la page de login';
$string['oauth2displaybuttonshelp'] = 'Afficher les boutons de logo Google/Facebook/... en haut de la page. Si vous voulez positionner vous-même ces boutons, vous opuvez garder cette option non coché et ajouter vous-même le code suivant:
{$a}';
$string['emailaddressmustbeverified'] = 'Votre adresse email n\'est pas vérifiée par la méthode d\'authentification que vous avez sélectionné. Vous avez sans doute oublié de cliquer sur le lien "vérifier mon adresse email" que Google ou Facebook vous a envoyé lors de votre inscription à leur service.';
$string['auth_sign-in_with'] = '{$a->providername}';
$string['moreproviderlink'] = 'S’authentifier avec un autre service.';
$string['signinwithanaccount'] = 'S\'authentifier avec:';
$string['noaccountyet'] = 'Vous n\'avez plus la permission d\'utiliser ce site. Contactez votre administrateur et demander lui d\'activer votre compte.';
$string['unknownfirstname'] = 'Nom inconnu';
$string['unknownlastname'] = 'Prénom inconnu';
