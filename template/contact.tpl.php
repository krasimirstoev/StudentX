<?php 
include('header.tpl.php');
echo "<h1> Пишете ни! </h1>
<h3>Ако имате каквито и да било въпроси, критики или предложения относно StudentX - Моля, пишете ни!</h3>";
if($message){
	echo "<h4>{$message}</h4>";
}
?>
<form name="send" action="" method="post">
<ul>
<li>Име: </li><li><input type="text" name="name" size="30" /> </li>
<li>E-mail: </li> <li><input type="text" name="email" size="30" /> </li>
<li>Съдържание:</li> <li><textarea name="content" cols="60" rows="20"></textarea></li>
<li><input type="hidden" name="sent" value="1" />
<input type="submit" value="Изпрати" /></li>
</ul>
</form>
<?php include('footer.tpl.php'); ?>