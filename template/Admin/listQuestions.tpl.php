<?php include('header.tpl.php');  ?>
<h1>Администрация на въпросите</h1>
<ul><li><a href="<?php echo SITE_URL . "Admin/addQuestion"; ?>" class="profileLink">Добави въпрос</a></li></ul>
<table>
	<tr>
	<th>Въпрос</th> <th>В тест</th> <th>Действия</th>
	</tr>
	<?php
	$i = 1;
	while( $all = mysql_fetch_array($allQuestions) ){
		echo "<tr class='list'><td>{$i}.".$filter->decode($all['question']) . "</td> \n";
		$result = $db->getQuiz($all['quiz_id']);
		while( $d = mysql_fetch_array($result)){
			echo "<td> ".$filter->decode($d['name']) . "</td> \n";
		}
		echo "
		<td> <a href='".SITE_URL."Admin/editQuestion/{$all['id']}' title='Редактирай'>Редактирай</a> 
		<a href='".SITE_URL."Admin/dropQuestion/{$all['id']}' title='Изтрий' onclick='return ask()'>Изтрий</a></td></tr>";
		++$i;
		}
	?>
</table>

<?php include('footer.tpl.php'); ?>
