<?php include('header.tpl.php');  
global $db, $members, $filter;

$slug = $db->getDisciplineByName($filter->input($_GET['id']));
$disc_info = mysql_fetch_array($slug);
$disc_desc = $filter->decode($disc_info['description']);

if($disc_desc != null){
	echo "<h1>{$disc_desc}</h1> \n
	<h2>Моля, изберете теста, който искате да държите</h2> \n
	<table>\n";
}
else{
	echo "<h1>Онлайн решаване на тестове</h1> \n
	<h2>Безплатно решаване на тестове за всички класове</h2>\n
<table>\n ";
}

while( $all = mysql_fetch_array($allQuizes) ){
	$url = SITE_URL."Quiz/execQuiz/{$all['id']}";
	echo "<tr class='list' onclick='document.location.href=\"$url\"'>\n <td>";
	if($members->isLogged() == True && $db->countSolved($all['id'], $members->studentName()) > 0){
		echo "<strong><span style='color: #F8D766;'>". $all['description']." *</span></strong></td>";
	}
	else{
		echo "<strong>". $all['description']."</strong></td>";
	}
	echo "<td><a href='$url' title='Реши ".$all['description']."' style='text-decoration: none;'><strong>Реши този тест</strong></a></td></tr>\n";
}
echo "</table>";
 
if($members->isLogged() == True){
	echo "<h3>* Маркираните тестове са вече решавани от Вас!</h3>";
}
else{
	echo "<h4>За да използвате всичките възможности, предлагани от Нас, моля <a href='".SITE_URL."Members/Register'>регистрирайте се</a>!</h4>";
}

include('footer.tpl.php'); ?>
