<div class="width25 floatRight leftColumn">
<?php
//Инициализираме си нужните ни класове
global $members, $db, $scf4u, $filter;
if($members->isLogged() != True) { ?>
	
	<h1>Вход</h1>
	<ul class="sideMenu">
	<li class="here">
		<?php if($_GET['Function'] != "Login"){ ?>
		<form action="<?=SITE_URL; ?>Members/Login" method="post">
		<ul>
			<li><label for="username">Потребителско име: </label><input type="text" name="username" id="username" style="width: 215px;" /></li>
			<li><label for="password">Парола: </label><input type="password" name="password" id="password" style="width: 215px;" /></li>
			<li><input type="checkbox" name="rememberme" id="rememberme" value="1" /> <label for="rememberme"> Запомни ме</label></li>
			<li><input type="hidden" name="sent" value="1" /> 
			<input type="hidden" name="referral" value="<?=$scf4u->getCurrentPage(); ?>" /></li>
			<li><input type="submit" name="Вход" value="Вход" /></li>
		</ul>
		</form>
	<?php } ?>

	
	</li>
	<li style="font-size: 18px;"><a href="<?=SITE_URL; ?>Members/Register" title="Регистрирай се">Регистрация</a></li>
	<li style="font-size: 18px;"><a href="<?=SITE_URL; ?>Members/forgottenPassword" title="Забравена парола"> Забравих си паролата!?</a></li>
	</ul></div>
<?php } 
else {
	$userInfo = $members->getProfile($members->studentName());
	while ($user = mysql_fetch_array($userInfo)) {
		$real_name = $filter->decode($user['real_name']);
		$city = $filter->decode($user['city']);
		$school_id = $filter->decode($user['school']);
		$city = $filter->decode($user['city']);
		$solvedQuizes = $db->countSolved(0, $members->studentName());
	}
	
	$schoolInfo = $db->getSchool($school_id);
	while ($all0 = mysql_fetch_array($schoolInfo)){
		$school = $all0['name'];
	}
	?>
	<h1><?=$members->StudentName(); ?></h1>
	<ul class="sideMenu">
	<li class="here">
	<?php
	if($db->hasAvatar($members->studentName()) == 1){
		$avatar_ext = $db->getAvatar($members->studentName());
		$ext = mysql_fetch_array($avatar_ext);
		echo "<img src='".SITE_URL."avatars/".$members->studentName(). $ext[0]."' alt='Аватарът на {$members->studentName()}' style='margin: 18px;'/>";
	}
	else{ ?>
	<img src="<?=SITE_URL; ?>images/noAvatar.jpg" alt="User has no avatar" style="margin: 18px; width: 200px; height: 200px;" />
	<?php } ?>
	<ul style="margin-left: 18px; color: #FFF;">
		<li>Име: <strong><?=$real_name; ?></strong><br /></li>
		<li>Град: <strong><?=$city; ?></strong><br /></li>
		<li>Училище: <strong><?=$school; ?></strong><br /></li>
		<li><a href="<?=SITE_URL; ?>Members/Solved" title="Решени тестове">Решени тестове: <strong><?=$solvedQuizes; ?></strong></a></li>
	<?php 
	global $members;
	if($members->isAdmin($members->studentName()) == True){ echo '<li><a href="'.SITE_URL.'Admin" title="Администраторски панел">Админ панел</a></li>'; } ?>
	
		<li><a href="<?=SITE_URL; ?>Members/editProfile" title="Редактирай профила си">Редакция на профила</a></li>
		<li><a href="<?=SITE_URL; ?>Members/Logout" title="Изход">Изход</a></li>
	</ul>
	</li>
	</ul>
	</div>
<?}?>