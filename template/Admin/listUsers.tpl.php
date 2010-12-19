<?php include('header.tpl.php');  
global $filter;
?>
<h1>Администрация на потребителите</h1>
<table>
	<tr>
	<th>Потребителско име</th> <th>Име и Фамилия</th> <th>Email</th> <th>Действия</th>
	</tr>
	<?php
	while( $all = mysql_fetch_array($allUsers) ){
		echo "<tr class='list'><td>".$filter->decode($all['student']) . "</td> 
		<td>".$filter->decode($all['real_name'])."</td> 
		<td>".$filter->decode($all['email'])."</td>
		<td> <a href='".SITE_URL."Admin/editProfile/".$filter->decode($all['student'])."' title='Редактирай'>Редактирай</a> | <a href='".SITE_URL."Admin/dropUser/{$all['id']}' title='Изтрий' onclick='return ask()'>Изтрий</a></td></tr>";
	}
	?>
	
</table>

<?php include('footer.tpl.php'); ?>