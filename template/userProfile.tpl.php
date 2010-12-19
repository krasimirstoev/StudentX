<?php include(TEMPLATE."header.tpl.php");
global $filter;

//Масивът, в който ще съхраняваме потребителската информация
$user = array();


$user = mysql_fetch_array($userInfo);
$real_name = $filter->decode($user['real_name']);
$email = $filter->decode($user['email']);
$city = $filter->decode($user['city']);
$school_id = $filter->decode($user['school']);
$solvedQuizes = $db->countSolved(0, $student);
	
echo "<h1>$student</h1>";
if($this->isLogged() && $this->studentName() == $student){
	include('profileMenu.tpl.php');
}

if($db->hasAvatar($student) == 1){
	$avatar_ext = $db->getAvatar($student);
	$ext = mysql_fetch_array($avatar_ext);
	echo "<img src='".SITE_URL."avatars/".$student. $ext[0]."' alt='Аватарът на {$student}' style='margin: 18px; float: left'/><br />";
}

echo "<h3>Име: $real_name</h3>\n
<h3>E-mail: $email</h3>\n
<h3>Град: $city </h3>\n";

$schoolInfo = $db->getSchool($school_id);
$all0 = mysql_fetch_array($schoolInfo);
$school = $filter->decode($all0['name']);


echo "<h3>Училище: $school </h3>\n";
echo "<h3>Решени тестове: $solvedQuizes </h3>\n";


include(TEMPLATE."footer.tpl.php");	
?>