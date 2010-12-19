<?php
global $filter, $pages;
if(isset($_GET['Class']) && $filter->input(ucfirst($_GET['Class'])) == "Admin"){
	require_once(ADMIN_MENU);
}
else{
?>
<div id="mainMenu">
<ul class="floatRight">
<li><a href="<?=SITE_URL; ?>" title="Начало" <?php if(ucfirst($_GET['Class']) == null || $_GET['Function'] == "listDisciplines" || $_GET['Class'] == "Members"){ echo 'class="here"'; } ?>>Начало</a></li>
<li><a href="<?=SITE_URL."Quiz/listQuizes" ;?>" title="Тестове" <?php if(ucfirst($_GET['Class']) == "Quiz")  { print 'class="here"'; } ?> >Тестове</a></li>

<?php
//Добавяме и динамичните страници
$pages = $pages->listPages('1','1');
while($page = mysql_fetch_array($pages)){
	echo "<li><a href='".SITE_URL."Pages/{$page['slug']}' title='{$page['name']}' "; if($_GET['Function'] == $page['slug']) { echo "class='here'"; } echo ">{$page['name']}</a></li> \n";
}
?>
<li><a href="<?=SITE_URL."Pages/Contact" ;?>" title="Пишете ни!" <?php if(ucfirst($_GET['Class']) == "Pages" && ucfirst($_GET['Function'] == "Contact"))  { echo 'class="here"'; } ?> >Пишете ни!</a></li>
</ul>
</div> 
<?php
}
?>
