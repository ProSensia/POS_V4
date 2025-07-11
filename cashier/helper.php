<?php 


require_once "../app/core.php";
$Controller = new Controller();
$Controller->checkUserLoggedIn();

$userData = $Controller->find("id",$_SESSION['loggedIn_ID']);
if (!$userData) {
	$Controller->redirect("./");
}

$Controller->authenticated();
$Controller->auto_log_out();

$user_token =  $_SESSION['token'];

$storeId = $_SESSION['store_id'];
$warehouse_data = $Controller->get_store_by_id($storeId);

$cProfile = $Controller->get_profile();

if (!$Controller->checkDuplicateLoggedIn($userData->email,$user_token)) {
	session_destroy();
    $Controller->redirect("./");
}