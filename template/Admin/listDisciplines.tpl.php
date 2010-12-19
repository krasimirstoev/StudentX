<?php include('header.tpl.php');  ?>
<h1>Администрация на предметите</h1>
<ul><li><a href="<?php echo SITE_URL . "Admin/addDiscipline"; ?>" class="profileLink">Добави предмет</a></li></ul>
<table>
	<tr>
	<th>Предмет</th> <th>Описание</th> <th>Действия</th>
	</tr>
	<?php
	while( $all = mysql_fetch_array($allDisciplines) ){
		echo "<tr class='list'><td>".$all['name'] . "</td>
		<td>" . $all['description'] . "</td>
		<td> <a href='".SITE_URL."Admin/editDiscipline/{$all['id']}' title='Редактирай'>Редактирай</a> | <a href='".SITE_URL."Admin/dropDiscipline/{$all['id']}' title='Изтрий' onclick='return ask()'>Изтрий</a></td></tr>";
	}
	?>
</table>

<?php include('footer.tpl.php'); ?>
