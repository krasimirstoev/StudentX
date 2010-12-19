<?php include('header.tpl.php');  ?>
<h1>Администрация на страниците</h1>
<ul><li><a href="<?php echo SITE_URL . "Admin/addPage"; ?>" class="profileLink">Добави страница</a></li></ul>
<table>
	<tr>
	<th>Име</th> <th>Действия</th>
	</tr>
	<?php
	while( $all = mysql_fetch_array($allPages) ){
		echo "<tr class='list'><td>".$all['name'] . "</td>
			<td> <a href='".SITE_URL."Admin/editPage/{$all['id']}' title='Редактирай'>Редактирай</a> | <a href='".SITE_URL."Admin/dropPage/{$all['id']}' title='Изтрий' onclick='return ask()'>Изтрий</a></td></tr>";
	}
	?>
</table>

<?php include('footer.tpl.php'); ?>