<?php include('header.tpl.php');

 ?>
<h1>Регистрация</h1>
<h2><?=$message; ?>&nbsp;</h2>

<form name="add" action="" method="post">
<ul>
<li>Потребителско име: </li>
<li><input type="text" name="username" size="35" maxlength="35" value="<?=$_POST['username']; ?>"/></li>
<li>Парола: </li>
<li><input type="password" name="password0" size="35" value="<?=$_POST['password0']; ?>"/></li>
<li>Повторете паролата: </li>
<li><input type="password" name="password1" size="35" value="<?=$_POST['password1']; ?>"/></li>
</ul>
<?php
require_once(TEMPLATE."memberInfo.tpl.php");
?>
<ul>
<li><input type="hidden" name="sent" value="1" /><input type="submit" value="Добави" /></li>
</ul>
</form>

<?php include('footer.tpl.php'); ?> 
