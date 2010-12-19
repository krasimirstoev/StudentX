<?php include('header.tpl.php'); 
echo "<h1>Забравена парола</h1>";
if($message){
	echo "<h3>$message</h3>";
}
?>
<form name="add" action="" method="post">
<ul>
<li>Потребителско име: </li>
<li><input type="text" name="username" size="35" maxlength="35" /></li>
<li>E-mail: </li>
<li><input type="text" name="email" size="35" maxlength="64" /></li>
<li><input type="hidden" name="sent" value="1" /></li>
<li><input type="submit" value="Изпрати новата парола" /></li>
</ul>
</form>
<?php include('footer.tpl.php'); ?> 