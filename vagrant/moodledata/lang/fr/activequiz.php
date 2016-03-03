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
 * Strings for component 'activequiz', language 'fr', branch 'MOODLE_29_STABLE'
 *
 * @package   activequiz
 * @copyright 1999 onwards Martin Dougiamas  {@link http://moodle.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['activequiz:addinstance'] = 'Ajouter une instance d\'Active Quiz';
$string['activequiz:attempt'] = 'Tenter un Active Quiz';
$string['activequiz:control'] = 'Contrôler un Active Quiz (habituellement pour les enseignants)';
$string['activequiz:editquestions'] = 'Éditer les questions d\'un Active Quiz';
$string['activequizintro'] = 'Introduction';
$string['activequiz:seeresponses'] = 'Afficher les autres réponses des étudiants pour les noter';
$string['activequizsettings'] = 'Paramètres généraux de l\'Active Quiz';
$string['activequiz:viewownattempts'] = 'Autoriser les étudiants à voir leur propres tentatives à un questionnaire.';
$string['activitygrades'] = 'Notes de l\'activité :';
$string['addquestion'] = 'Ajouter une question';
$string['addtoquiz'] = 'Ajouter';
$string['anonymousresponses'] = 'Rendre anonymes les réponses des étudiants';
$string['anonymousresponses_help'] = 'Rendre anonymes les réponses des étudiants dans la vue de l\'enseignant, de sorte que les noms des étudiants ou des groupes ne soient pas affichés';
$string['assessed'] = 'Évalué';
$string['assessed_help'] = 'Cocher cette case pour que votre questionnaire soit évalué';
$string['attempt_grade'] = 'Note de la tentative';
$string['attemptno'] = 'Numéro de la tentative';
$string['attempts'] = 'Tentatives';
$string['attemptstarted'] = 'Vous avez déjà démarré une tentative, merci de cliquer ci-dessous pour la rejoindre.';
$string['attemptstartedalready'] = 'Une tentative a déjà été démarrée par un membre de votre groupe';
$string['attemptview'] = 'Voir la tentative';
$string['cantaddquestiontwice'] = 'Vous ne pouvez pas ajouter la même question plus d\'une fois dans un quiz';
$string['cantinitattempts'] = 'Impossible d\'initialiser les tentatives';
$string['closesession'] = 'Fermer la session';
$string['closingsession'] = 'Session en cours de fermeture...';
$string['countdatasetlabel'] = 'Nombre de questions';
$string['defaultquestiontime'] = 'Durée par défaut d\'une question';
$string['defaultquestiontime_help'] = 'Le temps d\'affichage de chaque question par défaut (en seconde).
Ce paramètre peut être modifié pour chaque question individuellement.';
$string['edit'] = 'Modifier le questionnaire';
$string['editpage_opensession_error'] = 'Vous ne pouvez pas modifier une question ni l\'affichage lorsque des sessions sont ouvertes.';
$string['endquestion'] = 'Terminer la question';
$string['eventattemptstarted'] = 'Tentative démarrée';
$string['eventattemptviewed'] = 'Tentative visualisée';
$string['eventquestionanswered'] = 'Question répondue pour la tentative';
$string['eventquestionmanuallygraded'] = 'Question notée manuellement';
$string['feedbackintro'] = 'Commentaires sur la question. Merci d\'attendre que l\'enseignant démarre la question suivante.';
$string['firstsession'] = 'Première session';
$string['gatheringresults'] = 'Collecte des résultats...';
$string['gotosession'] = 'Rejoindre la session en cours';
$string['grademethod'] = 'Méthode de notation';
$string['grademethod_help'] = 'Méthode utilisée pour la notation.
Cette méthode détermine la façon de noter plusieurs sessions d\'un même quiz';
$string['gradesettings'] = 'Paramètres de notation';
$string['groupattendance'] = 'Autoriser les tentatives de groupe';
$string['groupattendance_help'] = 'Si cette case est cochée, l\'étudiant rejoignant le questionnaire peut choisir avec quels étudiants du groupe il exécute sa tentative.';
$string['grouping'] = 'Regroupement';
$string['grouping_help'] = 'Sélectionnez le groupe que vous souhaitez utiliser pour regrouper les étudiants';
$string['groupmembership'] = 'Membres du groupe';
$string['groupworksettings'] = 'Paramètres de groupe';
$string['hide_correct_answer'] = 'Cacher la réponse correcte';
$string['hidenotresponded'] = 'Cacher les « non répondus »';
$string['hidestudentresponses'] = 'Cacher les réponses';
$string['highestsessiongrade'] = 'Note de session la plus élevée';
$string['indvquestiontime'] = 'Durée de la question';
$string['indvquestiontime_help'] = 'Temps d\'affichage de la question (en secondes).';
$string['instructorquizinst'] = '<p>Merci d\'attendre que les étudiants se connectent.< /br>
Une fois que vous cliquez sur « Démarrer le questionnaire », le questionnaire lancera la première question.</p>
    <p>
<p>Contrôles :</p>
    <ul>
        <li>
            Poser à nouveau cette question
            <ul>
                <li>
                    Permet à l\'enseignant de poser à nouveau la même question (disponible durant la relecture d\'une question).
                </li>
            </ul>
        </li>
        <li>
            Question suivante
            <ul>
                <li>
                    Passer à la question suivante (disponible durant la relecture d\'une question).
                </li>
            </ul>
        </li>
        <li>
            Terminer la question
            <ul>
                <li>
                    Termine la question actuelle. Permet aussi à l\'enseignant d\'arrêter une question minutée plus tôt (disponible tant que la question est en cours). <i>Si la question n\'a pas de limite de temps, l\'enseignant devra cliquer sur « Terminer la question »</i>
                </li>
            </ul>
        </li>
        <li>
            Aller à la question
            <ul>
                <li>
                    Ouvre une boite de dialogue pour permettre de sélectionner la question dans la liste de toutes les question du questionnaire de destination (disponible durant la relecture d\'une question).
                </li>
            </ul>
        </li>
        <li>
            Fermer la session
            <ul>
                <li>
                    Ferme la session actuelle, ainsi que toutes les tentatives des étudiants. Cela entrainera automatiquement la notation des tentatives. (disponible tout le temps).
                </li>
            </ul>
        </li>
        <li>
            Recharger les résultats
            <ul>
                <li>
                    Recharge l\'état des réponses des étudiants dans la zone d\'information. Permet à l\'enseignant de voir combien d\'étudiants ou de groupes ont répondus et combien doivent encore le faire (disponible durant la relecture d\'une question).
                </li>
            </ul>
        </li>
        <li>
            Voir / cacher les « non répondus »
            <ul>
                <li>
                    Affiche ou cache la zone d\'information qui indique combien d\'étudiants ou de groupes ont répondus et combien doivent encore le faire (disponible durant l\'interrogation).
                </li>
            </ul>
        </li>
        <li>
            Montrer la réponse juste
            <ul>
                <li>
                    Affiche pour l\'enseignant une vue avec la question ainsi que la réponse correcte sélectionnée (disponible durant la relecture d\'une question). N\'affichera pas la réponse correctes pour des questions de typr notées manuellement, essais ou graphiques.
                </li>
            </ul>
        </li>
    </ul>
</p>';
$string['instructorsessionsgoing'] = 'Une session est déjà en cours. Merci de cliquer sur le bouton ci-dessous pour la rejoindre.';
$string['invalidattemptaccess'] = 'Vous n\'avez pas l\'autorisation d\'accéder à cette tentative';
$string['invalid_indvquestiontime'] = 'La durée de la question doit être un nombre supérieur ou égal à 0';
$string['invalid_numberoftries'] = 'Le nombre d\'essais doit être un nombre supérieur ou égal à 1';
$string['invalid_points'] = 'Les points sont nécessaires et doivent être un nombre plus grand que 0';
$string['invalidquestionattempt'] = 'Tentative d\'ajout d\'une question invalide ($a->questionname).';
$string['joinquiz'] = 'Rejoindre un questionnaire';
$string['joinquizinstructions'] = 'Cliquer ici pour rejoindre un questionnaire';
$string['jumptoquesetioninstructions'] = 'Sélectionnez la question ou vous voudriez aller :';
$string['jumptoquestion'] = 'Aller à la question';
$string['lastsession'] = 'Dernière session';
$string['loading'] = 'Initialisation du questionnaire';
$string['manualcomment'] = 'Commentaire manuel';
$string['manualcomment_help'] = 'Le commentaire que l\'enseignant peut ajouter quand il note une tentative';
$string['marks'] = 'Notes';
$string['marks_help'] = 'La note de chaque question au format numérique, et le score global de la tentative.';
$string['modulename'] = 'Active Quiz';
$string['modulename_help'] = '<p>Active Quiz permet à un enseignant de créer et animer un questionnaire en temps réel. Toutes les questions courantes de l\'activité « Test » peuvent être utilisées dans un Active Quiz.
</p>
<p>Active Quiz permet une participation individuelle ou en groupe. Dans le cas d\'une participation en groupe, la note sera appliquée uniquement à tous les participants du groupe durant la session.
Les questions peuvent être paramétrées pour autoriser plusieurs essais.
Une limite de temps peut être indiquée pour automatiquement clore la question, mais l\'enseignant peut aussi décider d\'arrêter lui même la question et de passer à la suivante.
Il a aussi la possibilité de passer d\'une question à une autre durant une session.
Enfin, il peut superviser la participation des étudiants ou des groupes, les réponses des étudiants en temps réel, et les questions déjà posées.
</p>
<p>
Chaque tentative est évaluée automatiquement comme l\'activité « Test » (à l\'exception des questions de type essais ou PoodLL) et la note est inscrite dans le carnet de notes.
La notation pour les participations en groupe peut être automatiquement répercutée de l\'étudiant meneur à tous les autres membres.
</p>

<p>
L\'enseignant a la possibilité d\'afficher des conseils, donner des commentaires et montrer les réponses correctes aux étudiants à l’achèvement du test.</p>

<p>Active Quiz peut être utilisé comme outil pour mener des travaux de groupes au sein de Moodle.</p>';
$string['modulenameplural'] = 'Active Quiz';
$string['nextquestion'] = 'Question suivante';
$string['nochangegroups'] = 'Vous ne pouvez pas modifier les paramètres de groupe après avoir créée une session, ou il n\'y a pas de groupe défini pour ce cours.';
$string['nochangegroups_label'] = '&nbsp;';
$string['nofeedback'] = 'Il n\'y a pas de commentaire pour cette question';
$string['no_questions'] = 'Il n\'y a pas de question ajoutée à ce questionnaire';
$string['nosession'] = 'Il n\'y a pas de session ouverte';
$string['notime'] = 'Pas de limite de temps';
$string['notime_help'] = 'Cocher cette case pour ne pas limiter le temps de cette question. L\'enseignant aura alors besoin de cliquer sur « Terminer la question » manuellement.';
$string['notresponded'] = 'Nombre de tentatives sans réponse';
$string['numberoftries'] = 'Nombre d\'essais';
$string['numberoftries_help'] = 'Nombre de fois qu\'un étudiant peut répondre à la question. Il sera tout de même toujours limité par la durée de la question.';
$string['overallgrade'] = 'Note globale : {$a->overallgrade} / {$a->scale}';
$string['percentagedatasetlabel'] = 'Pourcentage du total des réponses';
$string['pluginadministration'] = 'Administration de l\'Active Quiz';
$string['pluginname'] = 'Active Quiz';
$string['points'] = 'Points de la question';
$string['points_help'] = 'Nombre de points que vous souhaitez attribuer à cette question.';
$string['qdeleteerror'] = 'Impossible de supprimer la question';
$string['qdeletesucess'] = 'Question supprimée avec succès';
$string['qmoveerror'] = 'Impossible de déplacer la question';
$string['qmovesuccess'] = 'Question déplacée avec succès';
$string['question'] = 'Question';
$string['questiondelete'] = 'Supprimer la question {$a}';
$string['questionedit'] = 'Modifier la question';
$string['questionfinished'] = 'Question terminée, en attente des résultats.';
$string['questionlist'] = 'Liste des questions';
$string['questionmovedown'] = 'Déplacer la question {$a} vers le bas';
$string['questionmoveup'] = 'Déplacer la question {$a} vers le haut';
$string['quiznotrunning'] = 'Le test n\'est pas encore en fonctionnement ; attendez que votre enseignant le démarre.
Utilisez le bouton d\'actualisation pour recharger la page et vérifier à nouveau.';
$string['regradeallgrades'] = 'Recalculer toutes les notes';
$string['reload_results'] = 'Recharger les résultats';
$string['repollquestion'] = 'Poser à nouveau cette question';
$string['response_attempt_controls'] = 'Modifier / Voir une tentative';
$string['responses'] = 'Voir les réponses';
$string['reviewafter'] = 'Après que la session soit fermée';
$string['reviewoptionsettings'] = 'Options de relecture';
$string['savequestion'] = 'Enregistrer la question';
$string['scale'] = 'Note maximum';
$string['scale_help'] = 'Cette valeur définit la note maximum de ce questionnaire (nombre entier).';
$string['select_group'] = 'Sélectionner votre groupe';
$string['selectsession'] = 'Sélectionner la session à voir';
$string['sessionaverage'] = 'Moyenne des sessions';
$string['sessionclosed'] = 'La session est désormais fermée';
$string['sessionname'] = 'Nom de la session';
$string['sessionname_required'] = 'Le nom de la session est requis';
$string['sessionnametext'] = 'Session :';
$string['show_correct_answer'] = 'Afficher la réponse juste';
$string['showhistoryduringquiz'] = 'Afficher l\'historique des réponses';
$string['showhistoryduringquiz_help'] = 'Afficher l\'historique des réponses de l\'étudiant ou du groupe durant la relecture d\'une question pendant le questionnaire.';
$string['shownotresponded'] = 'Afficher les « non répondues »';
$string['showstudentresponses'] = 'Afficher les réponses';
$string['startedon'] = 'Démarré le';
$string['startquiz'] = 'Démarrer le questionnaire';
$string['start_session'] = 'Démarrer la session';
$string['studentquizinst'] = 'Merci d\'attendre que l\'enseignant démarre le questionnaire. Une fois lancé, vous verrez un compteur défiler jusqu\'au déclenchement de la première question.';
$string['successregrade'] = 'Notes du test recalculées';
$string['teacherjoinquizinstruct'] = 'À utiliser si vous voulez essayer votre test (vous aurez aussi besoin de démarrer le quiz dans une autre fenêtre).';
$string['teacherstartinstruct'] = 'Utiliser cette page pour démarrer la session et que les étudiants puissent la rejoindre.<br />
Utiliser la zone de texte pour donner un nom à la session (cela pourra vous aider à la relecture ultérieure des résultats).';
$string['theattempt'] = 'La tentative';
$string['theattempt_help'] = 'L\'étudiant peut relire toute la tentative.';
$string['timecompleted'] = 'Temps écoulé';
$string['timemodified'] = 'Temps modifié';
$string['timertext'] = 'Votre question sera terminée et envoyée automatiquement dans :';
$string['trycount'] = 'Il vous reste {$a->tries} essais.';
$string['unabletocreate_session'] = 'Impossible de créer la session';
$string['view'] = 'Voir le questionnaire';
$string['viewstats'] = 'Voir les statistiques du questionnaire';
$string['waitforquestion'] = 'Envoi de la question dans :';
$string['waitforquestiontime'] = 'Temps d\'attente de la question';
$string['waitforquestiontime_help'] = 'Temps d\'attente pour le chargement de chaque question.';
$string['waitforrevewingend'] = 'L\'enseignant est en train de relire la question précédente. Merci d\'attendre le démarrage de la question suivante.';
$string['waitstudent'] = 'En attente de la connexion des étudiants';
$string['workedingroups'] = 'Utiliser les groupes';
$string['workedingroups_help'] = 'Cochez cette case pour indiquer aux étudiants qu\'ils travailleront en groupe. Assurez vous de sélectionner un groupement ci-dessous.';
