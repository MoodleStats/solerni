<?php
echo "coucou";

require_once(dirname(__FILE__) . '/../config.php');
require_once($CFG->dirroot . '/my/lib.php');

require_once("../local/orange_library/classes/forumng/forumng_object.php");
//require_once("../lib/accesslib.php");

$PAGE->set_url($CFG->wwwroot . "/eliane/index.php");

$PAGE->set_context(context_system::instance());
//$PAGE->set_context(get_system_context());
echo "***************************************";

$PAGE->set_pagelayout('course');
$PAGE->set_title("About page");
$PAGE->set_heading("About");

//$PAGE->set_url($CFG->wwwroot . '/about.php');


echo $OUTPUT->header();

$PAGE->navbar->add("coucou");
$PAGE->navbar->add("est");
$PAGE->navbar->add("ce");
$PAGE->navbar->add("que");
$PAGE->navbar->add("ça");
$PAGE->navbar->add("fonctionne ?");




$forumng_o = new forumng_object();

$user=3;
$course = $DB->get_record('course', array('id' => '14'), '*', MUST_EXIST);

$courses = array();
$courses[] = $course;



$reponse = $forumng_o->get_posts_by_user($user, $courses);


// Affichage des posts :
//var_dump($reponse);
foreach ($reponse->posts as $post) {
	//var_dump($post);
	echo "<hr>";
	echo "userid : " . $post->userid . "<br>";
	echo "date : " . $post->modified . "<br>";
	echo "Titre de la disucssion : <b>" . $post->discussionname . "</b><br>";
	echo "Message : <i>" . $post->message ."</i><br>";
	echo "Accès : <A HREF='" . $CFG->wwwroot . "/mod/forumng/discuss.php?d=".$post->discussionid . "'> ICI </A><br>";

	
}

echo "<br>-->" . $OUTPUT->navbar() ."<--<bR>";

echo " <hr>FIN DU SCRIPT";

echo $OUTPUT->footer();