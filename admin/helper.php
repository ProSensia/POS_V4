<?php 


require_once "../app/core.php";
$Controller = new Controller();
$Controller->checkUserLoggedIn();

$userData = $Controller->find("id",$_SESSION['loggedIn_ID']);
if (!$userData) {
	$Controller->redirect("./");
}
$Controller->authenticated();
$Controller->subscription();
$Controller->auto_log_out();

$user_token =  $_SESSION['token'];
$cProfile = $Controller->get_profile();
if (!$Controller->checkDuplicateLoggedIn($userData->email,$user_token)) {
	session_destroy();
    $Controller->redirect("./");
}

