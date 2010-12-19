<?php
//Инициализираме си нужните ни класове
global $db, $filter;
$cities = array();
$cities[0] = array("Благоевград", "Гоце Делчев", "Петрич", "Разлог", "Сандански", "Банско", "Якоруда", "Белица", "Гърмен", "Кресна", "Сатовча", "Симитли", "Хаджидимово", "Струмяни");
$cities[1] = array("Бургас", "Айтос", "Карнобат", "Поморие", "Несебър", "Средец", "Камено", "Малко Търново", "Приморско", "Сунгурларе", "Царево", "Созопол");
$cities[2] = array("Варна", "Белослав", "Бяла", "Девня", "Дългопол", "Долни чифлик", "Провадия", "Суворово", "Вълчи дол", "Аксаково", "Ветрино");
$cities[3] = array("Велико Търново", "Свищов", "Горна Оряховица", "Елена", "Златарица", "Лясковец", "Павликени", "Полски Тръмбеш", "Стражица");
$cities[4] = array("Видин", "Димово", "Бойница", "Макреш", "Ружинци", "Чупрене", "Белоградчик", "Брегово", "Грамада", "Кула", "Ново село");
$cities[5] = array("Враца", "Мездра", "Мизия", "Борован", "Б. Слатина", "Козлодуй", "Оряхово", "Криводол", "Роман", "Хайредин");
$cities[6] = array("Габрово", "Дряново", "Севлиево", "Трявна");
$cities[7] = array("Добрич", "Албена", "Балчик", "Генерал Тошево", "Шабла", "Каварна", "Тервел", "Крушари");
$cities[8] = array("Кърджали", "Момчилград", "Джебел", "Кирково", "Крумовград", "Ардино", "Черноочене");
$cities[9] = array("Кюстендил", "Дупница", "Бобовдол", "Бобошево", "Невестино", "Сапарева баня", "Кочериново", "Рила");
$cities[10] = array("Ловеч", "Априлци", "Луковит", "Троян", "Тетевен", "Летница", "Угърчин", "Ябланица");
$cities[11] = array("Монтана", "Берковица", "Лом", "Вълчедръм", "Вършец", "Чипровци", "Бойчиновци", "Брусарци", "Якимово");
$cities[12] = array("Пазарджик", "Велинград", "Панагюрище", "Пещера", "Ракитово", "Брацигово", "Септември", "Батак", "Белово", "Стрелча", "Лесичово");
$cities[13] = array("Перник", "Радомир", "Брезник", "Трън", "Земен");
$cities[14] = array("Плевен", "Белене", "Кнежа", "Левски", "Червен бряг", "Д. Дъбник", "Пордим", "Гулянци", "Д. Митрополия", "Искър", "Никопол");
$cities[15] = array("Пловдив", "Асеновград", "Карлово", "Перущица", "Първомай", "Раковски", "Садово", "Стамболийски", "Хисар", "Сопот", "Брезово", "Кричим", "Лъки", "Съединение", "Калофер", "Клисура", "Калояново", "Куклен", "Родопи", "Марица");
$cities[16] = array("Разград", "Исперих", "Кубрат", "Завет", "Лозница", "Цар Калоян");
$cities[17] = array("Русе", "Бяла", "Ценово", "Две могили", "Борово", "Сливо поле", "Ветово", "Иваново");
$cities[18] = array("Силистра", "Алфатар", "Дулово", "Ситово", "Кайнарджа", "Главиница", "Тутракан");
$cities[19] = array("Сливен", "Нова Загора", "Котел", "Твърдица");
$cities[20] = array("Смолян", "Девин", "Доспат", "Златоград", "Мадан", "Неделино", "Рудозем", "Чепеларе", "Баните", "Борино");
$cities[21] = array("София - всички", "Банкя", "Витоша", "Връбница", "Възраждане", "Изгрев", "Илинден", "Искър", "Красна поляна", "Красно село", "Кремиковци", "Лозенец", "Люлин", "Младост", "Надежда", "Нови Искър", "Оборище", "Овча купел", "Панчарево", "Подуяне", "Сердика", "Слатина", "Средец", "Триадица", "Студентска");
$cities[22] = array("Своге", "Антон", "Ботевград", "Елин Пелин", "Етрополе", "Златица", "Ихтиман", "Костенец", "Костинброд", "Мирково", "Правец", "Самоков", "Чавдар", "Челопеч", "Пирдоп", "Сливница", "Долна баня", "Божурище", "Годеч", "Горна малина", "Драгоман", "Копривщица", "Трудовец");
$cities[23] = array("Стара Загора", "Казанлък", "Братя Даскалови", "Мъглиж", "Николаево", "Опан", "Чирпан", "Гълъбово", "Павел баня", "Раднево", "Гурково");
$cities[24] = array("Търговище", "Омуртаг", "Попово", "Антоново", "Опака");
$cities[25] = array("Хасково", "Димитровград", "Минерални бани", "Свиленград", "Симеоновград", "Харманли", "Ивайловград", "Любимец", "Маджарово", "Стамболово", "Тополовград");
$cities[26] = array("Шумен", "Велики Преслав", "Каолиново", "Нови Пазар", "Каспичан", "Върбица", "Смядово", "Венец", "Хитрино");
$cities[27] = array("Ямбол", "Елхово", "Стралджа", "Болярово", "Тунджа");



if($city != "") {
	$oblast = "";
	for($i=0;$i<28;$i++){
		foreach($cities[$i] as $city0){
			if($city == $city0){
				$oblast = ++$i;
			}
		}
	}
	
}
	?>

<ul>
<li>Име и Фамилия: </li>
<li><input type="text" name="realname" maxlength="64" value="<?=$filter->decode($realname); ?>" /></li>

<li>Email: </li>
<li><input type="text" name="email" maxlength="64" value="<?=$filter->decode($email); ?>" /></li>

<li>Област: </li>
<li><select name="a" id="area" class="mbut" style="width:626px;" onchange="fillCities();">
<option label="--" value="" selected="selected">--</option>
<option label="Благоевград" value="1" <? if($oblast == 1){ echo "selected='selected'"; } ?>>Благоевград</option>
<option label="Бургас" value="2" <? if($oblast == 2){ echo "selected='selected'"; } ?>>Бургас</option>
<option label="Варна" value="3" <? if($oblast == 3){ echo "selected='selected'"; } ?>>Варна</option>
<option label="Велико Търново" value="4" <? if($oblast == 4){ echo "selected='selected'"; } ?>>Велико Търново</option>
<option label="Видин" value="5" <? if($oblast == 5){ echo "selected='selected'"; } ?>>Видин</option>
<option label="Враца" value="6" <? if($oblast == 6){ echo "selected='selected'"; } ?>>Враца</option>
<option label="Габрово" value="7" <? if($oblast == 7){ echo "selected='selected'"; } ?>>Габрово</option>
<option label="Добрич" value="8" <? if($oblast == 8){ echo "selected='selected'"; } ?>>Добрич</option>
<option label="Кърджали" value="9" <? if($oblast == 9){ echo "selected='selected'"; } ?>>Кърджали</option>
<option label="Кюстендил" value="10" <? if($oblast == 10){ echo "selected='selected'"; } ?>>Кюстендил</option>
<option label="Ловеч" value="11" <? if($oblast == 11){ echo "selected='selected'"; } ?>>Ловеч</option>
<option label="Монтана" value="12" <? if($oblast == 12){ echo "selected='selected'"; } ?>>Монтана</option>
<option label="Пазарджик" value="13" <? if($oblast == 13){ echo "selected='selected'"; } ?>>Пазарджик</option>
<option label="Перник" value="14" <? if($oblast == 14){ echo "selected='selected'"; } ?>>Перник</option>
<option label="Плевен" value="15" <? if($oblast == 15){ echo "selected='selected'"; } ?>>Плевен</option>
<option label="Пловдив" value="16" <? if($oblast == 16){ echo "selected='selected'"; } ?>>Пловдив</option>
<option label="Разград" value="17" <? if($oblast == 17){ echo "selected='selected'"; } ?>>Разград</option>
<option label="Русе" value="18" <? if($oblast == 18){ echo "selected='selected'"; } ?>>Русе</option>
<option label="Силистра" value="19" <? if($oblast == 19){ echo "selected='selected'"; } ?>>Силистра</option>
<option label="Сливен" value="20" <? if($oblast == 20){ echo "selected='selected'"; } ?>>Сливен</option>
<option label="Смолян" value="21" <? if($oblast == 21){ echo "selected='selected'"; } ?>>Смолян</option>
<option label="София - град" value="22" <? if($oblast == 22){ echo "selected='selected'"; } ?>>София - град</option>
<option label="София - област" value="23" <? if($oblast == 23){ echo "selected='selected'"; } ?>>София - област</option>
<option label="Стара Загора" value="24" <? if($oblast == 24){ echo "selected='selected'"; } ?>>Стара Загора</option>
<option label="Търговище" value="25" <? if($oblast == 25){ echo "selected='selected'"; } ?>>Търговище</option>
<option label="Хасково" value="26" <? if($oblast == 26){ echo "selected='selected'"; } ?>>Хасково</option>
<option label="Шумен" value="27" <? if($oblast == 27){ echo "selected='selected'"; } ?>>Шумен</option>
<option label="Ямбол" value="28" <? if($oblast == 28){ echo "selected='selected'"; } ?>>Ямбол</option>
</select></li>

<li>Град: </li>
<li><select name="c" id="city" class="mbut" style="width:626px;" onchange="getTheSchools();"><option value="">--</option>
<?php
if($city != ""){
	--$oblast;
	foreach($cities[$oblast] as $city1){
		echo "<option label='{$filter->decode($city1)}'";
		if($city == $city1){
			echo "selected='selected'";
		}
		echo ">{$filter->decode($city1)}</option>\n";
	}
}
?>

</select></li>
<li>Училище:</li>
<li><select name="school" id="schoolList" size="8" class="mbut" style="width:626px;"><option value="">--</option>
<?php
if($city != ""){
	$schools = $db->getSchools($city);
	$userI = mysql_fetch_row($db->getUserInfo($student));
	
	$school_id = $userI['6'];

	while($all = mysql_fetch_array($schools)){
		echo "<option label='{$filter->decode($all['name'])}' value='{$filter->decode($all['id'])}'";
		if($all['id'] == $school_id){
			echo "selected='selected'";
		}
		echo ">{$filter->decode($all['name'])}</option>";
	}
}

?>
</select> </li>
</ul>