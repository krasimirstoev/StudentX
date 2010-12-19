<?php include('header.tpl.php');  
global $filter;
if(!isset($_GET['id'])){
	echo "<h1>Администрация на тестовете</h1>";
}
else{
	echo "<h1>Администрация на тестовете по ".$filter->decode($discName)."</h1>";
}
?>
<ul><li><a href="<?php echo SITE_URL . "Admin/addQuiz/"; ?>" class="profileLink">Добави тест</a>  <a href="<?php echo SITE_URL . "Admin/addQuiz/1/"; ?>" class="profileLink">Добави тест с текст</a></li></ul>
<table>
	<tr>
		<th>Тест</th> <th>За клас</th> <th>Описание</th> <th>Действия</th>
	</tr>
	<?php
	while( $all = mysql_fetch_array($allQuizes) ){
		echo "<tr class='list'><td>".$filter->decode($all['name']) . "</td>
		<td>".$filter->decode($all['difficulty']). "</td> 
		<td>". $filter->decode($all['description'])."</td>
		<td> <a href='".SITE_URL."Admin/editQuiz/{$filter->decode($all['id'])}' title='Редактирай'>Редактирай</a> 
		| <a href='".SITE_URL."Admin/dropQuiz/{$filter->decode($all['id'])}' title='Изтрий' onclick='return ask()'>Изтрий</a></td></tr>";
		}
	?>
</table>

<?php include('footer.tpl.php'); ?>
