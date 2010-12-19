<?php include('header.tpl.php');  ?>
<h1>Вход в системата</h1>
<h3><?=$message; ?>&nbsp;</h3>
<form name="add" action="" method="post">
<ul class="here">
<li><label for="username">Потребителско име: </label></li>
<li><input type="text" name="username" id="username" /></li>
<li><label for="password">Парола: </label></li>
<li><input type="password" name="password" id="password" /></li>
<li><input type="checkbox" name="rememberme" id="rememberme" value="1"/> <label for="rememberme"> Запомни ме</label></li>
<li><input type="hidden" name="sent" value="1" />
<input type="hidden" name="referral" value="<?=$scf4u->getCurrentPage(); ?>" /></li>
<li><input type="submit" value="Вход" /></li>
</ul>
</form>

<?php include('footer.tpl.php'); ?> 
