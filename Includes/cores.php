<?php 

require_once "app/Controller.php";
$Controller = new Controller();
$Controller->authenticated();
$Controller->subscription();