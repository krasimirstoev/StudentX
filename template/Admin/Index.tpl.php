<?php include('header.tpl.php');  ?>
<h1>Администраторски панел</h1>

<h2>Посещения:</h2>
<ul>
	<li class="list" style="cursor: default;">Уникални посещения днес: <?=$uniqueVisitors; ?></li>
	<li class="list" style="cursor: default;">Всички посещения днес: <?=$Visitors; ?></li>
	<li>---</li>
	<li class="list" style="cursor: default;">Всички уникални посещения: <?=$allUniqueVisitors; ?></li>
	<li class="list" style="cursor: default;">Всички посещения: <?=$allVisitors; ?></li>
</ul>

<h2>Обща информация за проекта:</h2>
<ul>
	<li class="list" onclick="document.location.href='<?=SITE_URL; ?>Admin/listDisciplines'">Учебни предмети: <?=$allDisciplines; ?></li>
	<li class="list" onclick="document.location.href='<?=SITE_URL; ?>Admin/listQuizes'">Добавени тестове: <?=$allQuizes; ?></li>
	<li class="list" onclick="document.location.href='<?=SITE_URL; ?>Admin/listQuestions'">Всички въпроси: <?=$allQuestions; ?></li>
	<li class="list" onclick="document.location.href='<?=SITE_URL; ?>Admin/listPages'">Налични страници: <?=$allPages; ?></li>
	<li class="list" onclick="document.location.href='<?=SITE_URL; ?>Admin/listUsers'">Регистрирани потребителя: <?=$allStudents; ?></li>
</ul>



<?php include('footer.tpl.php'); ?>