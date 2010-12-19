<?php
//Задаваме някои настройки на php сървъра с цел сигурност
ini_set('error_reporting', 0);
ini_set('register_globals', 0);
ini_set('magic_quotes_gpc', 0);
ini_set('magic_quotes_runtime', 0); 
$breadcrumbs = array(   home => array( id=>"home", parent=>"", title=>"Начало", url=>"" )  );

session_start();
session_regenerate_id();
include("../config.php");
include(LIBS."DB.class.php");
include(LIBS."Filter.class.php");
include(LIBS."Result.class.php");
include(LIBS."scf4u.class.php");
include(CONTROLLERS."Pages.Controller.php");
include(CONTROLLERS."Members.Controller.php");

//print_r($breadcrumbs);
if(isset($_GET['Function'])) {
	$getFunction = $filter->input($_GET['Function']);
}

if(isset($_GET['Class'])){
	$getClass = $filter->input(ucfirst($_GET['Class']));

switch($getClass){
	case 'Admin' :
		include(CONTROLLERS."Admin.Controller.php");
		
		if(isset($getFunction)) {
			$admin->$getFunction();
		}
		else {
			$admin->Index();
		}
	break;
	
	case 'Quiz' :
		include(CONTROLLERS."Quiz.Controller.php");
		
		if(isset($getFunction)) {
			$quiz->$getFunction();
		}
		else {
			$quiz->listQuizes();
		}
		break;

	case 'Members' :
		
		
		if(isset($getFunction)) {
			$members->$getFunction();
		}
		else{
			$members->editProfile();
		}
		break;
		

	case 'Pages' :
		
		$pages->$getFunction();
		break;
		


	case '' :
		include(CONTROLLERS."Quiz.Controller.php");
		
		$quiz->listDisciplines();
		break;
	
	default : 
		$pages->Error404();
	break;
}
}
else{
	include(CONTROLLERS."Quiz.Controller.php");
	$quiz->listDisciplines();
}
$members->updateVisitors();
?>
