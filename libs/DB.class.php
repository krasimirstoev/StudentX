<?php

class DB{
	
	function __construct(){
		$connection = null;
		$query = null;
		$query0 = null;
		$result = null;
		$result0 = null;
		$clean = array();
		$clean0 = array();
		$numrows0 = null;
	
		$this->connection = mysql_connect(DB_SERVER, DB_USER, DB_PASS) or die("Проблем при връзката с базата данни");
		mysql_select_db(DB_NAME, $this->connection) or die ("Базата данни не е открита");
		$this->query("SET NAMES 'utf8'");



		
	}
	
	//Проста заявка 
	public function query($query){
		return mysql_query($query, $this->connection);
		mysql_close($this->connection);
	}
	
	//Проста numrows функция
	public function numrows($query){
		$numrows0 = mysql_numrows($this->query($query));
		return $numrows0;
	}
	/** DB Функции за предметите **/
	
	public function addDiscipline($disciplineName, $disciplineDesc, $disciplineSlug){
		global $filter;
		$disciplineName = $filter->sql($disciplineName);
		$disciplineDesc = $filter->sql($disciplineDesc);
		$disciplineSlug = $filter->sql($disciplineSlug);
		$query = "INSERT INTO `disciplines`(`name`, `description`, `slug`) values('{$disciplineName}', '{$disciplineDesc}', '{$disciplineSlug}')";
		return $this->query($query);
	}
	
	public function listDisciplines(){
		
		$query = "SELECT `id`, `name`, `description`, `slug` FROM `disciplines` ORDER BY `id` ASC";
		$allDisciplines = $this->query($query);
		
		return $allDisciplines;
	}
	
	public function getDiscipline($id){
		global $filter;
		
		(int) $id = $filter->sql($id);
		$query = "SELECT `id`, `name`, `description`, `slug` FROM `disciplines` WHERE  `id`='{$id}' LIMIT 1";
		
		return $this->query($query);
	}
	
	public function getDisciplineByName($discipline){
		global $filter;
		
		$name = $filter->sql($discipline);
		$query = "SELECT `id`, `name`, `description` FROM `disciplines` WHERE `slug`='{$name}' LIMIT 1";
		
		return $this->query($query);
	}
	
	public function editDiscipline($disciplineName, $disciplineDesc, $disciplineSlug, $disciplineID){
		global $filter;
		
		(int) $id = $filter->sql($disciplineID);
		$name = $filter->sql($disciplineName);
		$desc = $filter->sql($disciplineDesc);
		$slug = $filter->sql($disciplineSlug);
		
		$query = "UPDATE `disciplines` SET `name` = '{$name}', `description` = '{$desc}', `slug` = '{$slug}' WHERE `id`='{$id}' LIMIT 1";
		return $this->query($query);
		
	}
	
	public function dropDiscipline($id){
		global $filter;
		
		(int) $id = $filter->sql($id);
		
		$query = "DELETE FROM `disciplines` WHERE `id`='{$id}' LIMIT 1";
		return $this->query($query);
	}
	
	
	/** DB Функции за Тестовете **/
	
	public function addQuiz($quizName, $quizDescription, $discipline, $quizDifficulty, $published, $text_title='0', $text='0'){
		global $filter;
		
		$quizName = $filter->sql($quizName, 35);
		$quizDescription = $filter->sql($quizDescription, 0);
		$discipline = $filter->sql($discipline);
		$quizDifficulty = $filter->sql($quizDifficulty);
		$text_title = $filter->sql($text_title);
		$text = $filter->sql($text);
		$published = $filter->sql($published);


			$query = "INSERT INTO `quiz`(`name`, `description`, `disc_id`, `difficulty`, `text_title`, `text`, `published`) VALUES('$quizName', '$quizDescription', '$discipline', '$quizDifficulty', '$text_title', '$text', '$published')";

		return $this->query($query);
		
	}
	
	public function listQuizes($page, $published = null, $discipline = null){
		global $filter;
		
		$published = $filter->sql($published);
		$discipline = $filter->sql($discipline);
		
		$query = "SELECT `id`, `name`, `description`, `disc_id`, `difficulty` FROM `quiz` WHERE 1=1 ";
		if($discipline != null){
			$query .= "AND `disc_id` = '{$discipline}' ";
		}
		if($published != null){
			$query .= "AND `published` = '{$published}' ";
		}
		$query .= "ORDER BY `id` DESC";
		$allQuizes = $this->query($query);
		
		return $allQuizes;
	}
	
	public function editQuiz($quizName, $quizDesc, $discipline, $quizDifficulty, $quizID, $text_title='0', $text='0', $published){
		global $filter;
		
		(int) $id = $filter->sql($quizID);
		$name = $filter->sql($quizName);
		$desc = $filter->sql($quizDesc);
		$diff = $filter->sql($quizDifficulty);
		$text_title = $filter->sql($text_title);
		$text = $filter->sql($text);
		$discipline = $filter->sql($discipline);
		$published = $filter->sql($published);
		
		$query = "UPDATE `quiz` SET `name` = '{$name}', `disc_id` = '{$discipline}', `description` = '{$desc}', `difficulty` = '{$diff}', `text_title` = '$text_title', `text` = '$text', `published` = '$published'  WHERE `id`='{$id}' LIMIT 1";
		if($this->query($query)){
			return true;
		}
		else{
			return false;
		}
	}
	
	public function getQuiz($id){
		global $filter;
		
		(int) $id = $filter->sql($id);
		$query = "SELECT `id`, `name`, `disc_id`, `description`, `difficulty`, `text_title`, `text`, `published` FROM `quiz` WHERE  `id`='{$id}' LIMIT 1";
		
		return $this->query($query);
	}
	
	public function dropQuiz($id){
		global $filter;
		
		(int) $id = $filter->sql($id);
		
		$query = "DELETE FROM `quiz` WHERE `id`='{$id}' LIMIT 1";
		return $this->query($query);
	}
	
	
	
	/** DB Функции за Въпросите **/
	
	
	public function addQuestion($question, $quiz_id, $opt1, $opt2, $opt3, $opt4, $correct){
		global $filter;
		
		$question = $filter->sql($question);
		(int) $quiz_id = $filter->sql($quiz_id, 3);
		$opt1 = $filter->sql($opt1);
		$opt2 = $filter->sql($opt2);
		$opt3 = $filter->sql($opt3);
		$opt4 = $filter->sql($opt4);
		$correct = $filter->sql($correct, 1);

		
		$query = "INSERT INTO `questions`(`quiz_id`, `question`, `opt1`, `opt2`, `opt3`, `opt4`, `correct`) 
						VALUES('$quiz_id', '$question', '$opt1', '$opt2', '$opt3', '$opt4', '$correct')";
		return $this->query($query);
		
	}
	
	
	public function listQuestions($page, $quiz = null){
		global $filter;
		
		$quiz = $filter->sql($quiz);
		
		$query = "SELECT `id`, `quiz_id`, `question` FROM `questions` ";
		if($quiz != null){
			$query .= "WHERE `quiz_id` = '{$quiz}' ";
		}
		$query .= "ORDER BY `id` ASC";
		$allQuestions = $this->query($query);
		
		return $allQuestions;
	}
	
	public function editQuestion($question, $quiz_id, $opt1, $opt2, $opt3, $opt4, $correct, $id){
		global $filter;
		
		$question = $filter->sql($question);
		$quiz_id = $filter->sql($quiz_id, 3);
		$opt1 = $filter->sql($opt1);
		$opt2 = $filter->sql($opt2);
		$opt3 = $filter->sql($opt3);
		$opt4 = $filter->sql($opt4);
		$correct = $filter->sql($correct, 1);
		
		$query = "UPDATE `questions` SET `question` = '{$question}', `quiz_id` = '{$quiz_id}',
						`opt1` = '{$opt1}', `opt2` = '{$opt2}', `opt3` = '{$opt3}', `opt4` = '{$opt4}', `correct` = '{$correct}'
						WHERE `id`='{$id}' LIMIT 1";
		if($this->query($query)){
			return true;
		}
		else{
			return false;
		}
	}
	
	public function getQuestion($id){
		global $filter;
		
		(int) $id = $filter->sql($id);
		$query = "SELECT `quiz_id`, `question`, `opt1`, `opt2`, `opt3`, `opt4`, `correct` FROM `questions` WHERE  `id`='{$id}' LIMIT 1";
		
		return $this->query($query);
	}
	
	public function dropQuestion($id){
		global $filter;
		
		(int) $id = $filter->sql($id);
		$query = "DELETE FROM `questions` WHERE `id`='{$id}' LIMIT 1";
		return $this->query($query);
	}
	
	
	
	
	/**
	 * @name fetchQuestions
	 * @type: Public
	 * @description: Функцията извлича от базата данни всичко въпроси, в даден тест
	 * 					по дадено ID на теста
	 **/
	public function fetchQuestions($id){
		//Извикваме си нужните ни класове
		global $filter;
		
		//Филтрираме си подадената ID променлива
		(int) $id = $filter->sql($id);
		
		//Извличаме въпросите, отговарящи на това ID
		$query = "SELECT `id`, `question`, `opt1`, `opt2`, `opt3`, `opt4`, `correct` FROM `questions` WHERE `quiz_id` = '{$id}' ORDER BY `id` ASC";
		
		return $this->query($query);
	}
	
	
	/**
	 * @name getCorrects
	 * @type: Public
	 * @description: По подадена ID променлива на теста, извличаме верните отговори от него
	 **/
	public function getCorrects($id){
		//Изикваме си нужните ни класове
		global $filter;
		
		//Филтрираме си подадената ID променлива
		(int) $id = $filter->sql($id);
		
		//Извличаме верните отговори
		$query = "SELECT `id`, `correct` FROM `questions` WHERE `quiz_id` = '{$id}'";
		
		return $this->query($query);
	}
	
	
	/**  DB Функции за потребителите **/
	/**
	 * @name addUser
	 * @type: Public
	 * @description: Функцията приема подадените и филтрирани от формуляра променливи и записва
	 * информацията за новия потребител в базата данни
	 **/
	public function addUser($username, $password0, $email, $realname = null, $city = null, $school = null){
		//Извикваме си нужните ни класове
		global $filter, $scf4u;

		//Филтрираме отново подадените ни променливи
		$username = $filter->sql($_POST['username'], 35);
		$password0 = $filter->sql($_POST['password0'], 35);
		$email = $filter->sql($_POST['email'], 64);
		$realname = $filter->sql($_POST['realname'], 50);
		$city = $filter->sql($_POST['c']);
		$school = $filter->sql($_POST['school']);
		
		//Хешираме паролата
		$passwd = $scf4u->hashString($password0);
		
		//Създаваме си заявката
		$query = "INSERT INTO `students`(`student`, `passwd`, `email`, `real_name`, `city`, `school`)
				VALUES('$username', '$passwd', '$email', '$realname', '$city', '$school')";
		
		//Връщаме изпълнената заявка
		return $this->query($query);
	}
	
	/**
	* @name getSchools
	* @description: Функцията взима списъка с училищата от даден град
	**/
	public function getSchools($location){
		//Извикваме си нужните ни класове
		global $filter;
	
		if(isset($location)){
			
			//$location = $filter->sql($location);
			
			$query = "SELECT `name`,`id` FROM `schools` WHERE `location`= '{$location}' ";
			
			
			return $this->query($query);
		}
	}
	
	/**
	* @name getSchool
	* @description: Функцията извежда дадено училище, по подадено id
	**/
	public function getSchool($id){
		//Извикваме си нужните ни класове
		global $filter;

		//Филтрираме си подадените ни променливи
		(int)$id = $filter->sql($id);

		$query = "SELECT `name` FROM `schools` WHERE `id` = '{$id}'";

		return $this->query($query);
		}
	
	/**
	* @name userExist
	* @type: Public
	* @description: Фунцкията проверява дали вече съществува такъв потребител. 
	* Връща True или False
	**/
	public function userExist($username){
		//Извикваме си нужните ни класове
		global $filter;
		
		$username = $filter->sql($username);
		
		$query = "SELECT `id` FROM `students` WHERE `student` = '{$username}' ";
		$numrows = $this->numrows($query);
		return $numrows;
	}
	
	/**
	* @name emailExist
	* @type: Public
	* @description: Фунцкията проверява дали вече съществува такъв e-mail адрес
	* Връща True или False
	**/
	public function emailExist($email){
		//Извикваме си нужните ни класове
		global $filter;
			
		$email = $filter->sql($email);
		
		$query = "SELECT `id` FROM `students` WHERE `email` = '{$email}' ";
		$numrows = $this->numrows($query);
		return $numrows;
	}
       
	/**
	* @name Login
	* @type: Public
	* @description: Функцията изпраща заявка с подадените потребителско име и парола
	* и връща 1 при съвпадение
	**/
	public function Login($username, $password){
		//Извикваме си нужните ни класове
		global $filter, $scf4u;
		
		//Филтрираме подадените ни променливи
		$username = $filter->sql($username);
		$password = $filter->sql($password);
		
		//Хешираме паролата
		$passwd = $scf4u->hashString($password);
		
		$query = "SELECT `id` FROM `students` WHERE `student` = '{$username}' 
			AND `passwd` = '{$passwd}' LIMIT 1";
		
		$numrows = $this->numrows($query);
		
		return $numrows;
	}
	
	/**
	* @name isAdmin
	* @type: Public
	* @description: Функцията изпраща заявка с подаденото потребителско име за стойността
	* на полето role. 
	**/
	public function isAdmin($username){
		//Извикваме си нужните ни класове
		global $filter;
		
		//Филтрираме подадената ни променлива
		$username = $filter->sql($username);
		
		//Дефинираме и връщаме изпълнената заявка заявката
		$query = "SELECT `role` FROM `students` WHERE `student` = '{$username}' AND `role` = '1' LIMIT 1";
		
		$numrows = $this->numrows($query);
		
		return $numrows;
	}
	
	/**
	* @name checkEmail
	* @type: Public
	* @description: Функцията проверява за съвпадение в посочените потребител и парола
	*/
	public function checkEmail($username, $email){
		//Извикваме си нужните ни класове
		global $filter;
		
		//Филтрираме подадените ни променливи
		$username = $filter->sql($username);
		$email = $filter->sql($email);
		
		//Дефинираме заявката
		$query = "SELECT `id` FROM `students` WHERE `student` = '{$username}' AND `email` = '{$email}' 
		LIMIT 1";
		
		$numrows = $this->numrows($query);
		
		return $numrows;
	}

	/**
	* @name changePassword
	* @type: Public
	* @description: Функцията сменя паролата, на потребителя
	**/
	public function changePassword($username, $password){
		//Извикваме си нужните ни класове
		global $filter, $scf4u;
		
		//Филтрираме подадените ни променливи
		$username = $filter->sql($username);
		$password = $filter->sql($password);
		
		//Хешираме паролата
		$passwd = $scf4u->hashString($password);
		
		//Дефинираме и изпълняваме заявката
		$query = "UPDATE `students` SET `passwd` = '{$passwd}' WHERE `student` = '{$username}' LIMIT 1";
		
		return $this->query($query);
	}
	
	/**
	* @name editUser
	* @type: Public
	* @description: Функцията осъществява промяната на потребителския профил
	**/
	public function editUser($student, $realname = null, $email = null, $city = null, $school = null) {
		//Извикваме си нужните ни класове
		global $filter, $scf4u;
		
		//Филтрираме подадените ни променливи
		$student = $filter->sql($student);
		$realname = $filter->sql($realname);
		$email = $filter->sql($email);
		$city = $filter->sql($city);
		$school = $filter->sql($school);
		
		
		//Създаваме и изпълняваме заявката заявката
		$query = "UPDATE `students` SET 
			`real_name` = '{$realname}', `email` = '{$email}', `city` = '{$city}', `school` = '{$school}'
			WHERE `student` = '{$student}' LIMIT 1";
		
		return $this->query($query);
	}
		
	/**
	* @name getUserInfo
	* @type: Public
	* @description: Функцията изтегля информацята за всеки потребител
	**/
	public function getUserInfo($student){
		//Извикваме си нужните ни класове
		global $filter, $scf4u;
		
		//Филтрираме подадената ни променлива
		$student = $filter->sql($student);
		
		//Създаваме и изпълняваме заявката
		$query = "SELECT * FROM `students` WHERE `student` = '{$student}' LIMIT 1";
		
		return $this->query($query);

	}
	
	/**
	* @name getUserInfoByID
	* @type: Public
	* @description: Функцията изтегля информацята за всеки потребител по подадено ID
	**/
	public function getUserInfoByID($id){
		//Извикваме си нужните ни класове
		global $filter, $scf4u;
		
		//Филтрираме подадената ни променлива
		$id = $filter->sql($id);
		
		//Създаваме и изпълняваме заявката
		$query = "SELECT * FROM `students` WHERE `id` = '{$id}' LIMIT 1";
		
		return $this->query($query);

	}

	/**
	* @name changeAvatar
	* @type: Public
	* @description: Функцията записва промените по аватара на потребителя в базата данни
	**/
	public function changeAvatar($student, $has_avatar, $ext) {
		//Извикваме си нужните ни класове
		global $filter, $scf4u, $members;

		//Филтрираме подадените ни променливи
		$student = $filter->sql($student);
		$has_avatar = $filter->sql($has_avatar);
		$ext = $filter->sql($ext);

		//Създаваме и изпълняваме заявката
		$query = "UPDATE `students` SET `has_avatar` = '{$has_avatar}', `avatar_ext` = '{$ext}'
			WHERE `student` = '{$student}' LIMIT 1";

		return $this->query($query);
	}

	/**
	* @name: dropAvatar
	* @type: Public
	* @description: Функцията изтрива избрания аватар
	**/
	public function dropAvatar($student){
		//Извикваме си нужния ни клас
		global $filter;
		
		//Филтрираме подадената променлива
		$student = $filter->sql($student);
		
		//Създаваме и изпълняваме заявката
		$query = "UPDATE `students` SET `has_avatar` = 0, `avatar_ext` = '' WHERE `student` = '{$student}' LIMIT 1";
		
		return $this->query($query);
	}

	/**
	* @name hasAvatar
	* @type: Public
	* @description: Функцията проверява дали потребителят има посочен аватар
	**/
	public function hasAvatar($student) {
		//Извикваме си нужните ни променливи
		global $filter;

		//Филтрираме подадената променлива
		$student = $filter->sql($student);

		//Създаваме и изпълняваме заявката
		$query = "SELECT `has_avatar` FROM `students` WHERE `student` = '{$student}' AND `has_avatar` = '1' LIMIT 1";

		return $this->numrows($query);
	}

	/**
	* @name getAvatar
	* @type: Public
	* @description: Функцията взима разширението на потребителския аватар
	**/
	public function getAvatar($student) {
		//Извикваме си нужните ни променливи
		global $filter;

		//Филтрираме подадената променлива
		$student = $filter->sql($student);

		//Създаваме и изпълняваме заявката
		$query = "SELECT `avatar_ext` FROM `students` WHERE `student` = '{$student}' LIMIT 1";

		return  $this->query($query);
	}
	
	/**
	* @name addPage
	* @type: Public
	* @description: Функцията осъществява добавянето на нови страници
	**/
	public function addPage($pageName, $pageSlug, $pageContent, $published, $showinmenu){
		global $filter;
		$pageName = $filter->sql($pageName);
		$pageSlug = $filter->sql($pageSlug);
		$pageContent = $filter->sql($pageContent);
		$published = $filter->sql($_POST['published']);
		$showinmenu = $filter->sql($_POST['showinmenu']);
		
		$query = "INSERT INTO `pages`(`name`, `slug`, `content`, `published`, `showinmenu`) 
		values('{$pageName}', '{$pageSlug}', '{$pageContent}', '{$published}', '{$showinmenu}')";
		
		return $this->query($query);
	}
	
	/**
	* @name getPage
	* @type: Public
	* @description: Функцията връща информация за дадената страница
	**/
	public function getPage($id){
		global $filter;
		
		(int) $id = $filter->sql($id);
		$query = "SELECT `id`, `name`, `slug`, `content`, `published`, `showinmenu` FROM `pages` WHERE  id='{$id}' LIMIT 1";
		
		return $this->query($query);
	}
	
	/**
	* @name editPage
	* @type: Public
	* @description: Функцията осъществява редактирането на страниците
	**/
	public function editPage($pageName, $pageSlug, $pageContent, $pageID){
		global $filter;
		
		$id = $filter->sql($pageID);
		$name = $filter->sql($pageName);
		$slug = $filter->sql($pageSlug);
		$content = $filter->sql($pageContent);
		
		$query = "UPDATE `pages` SET `name` = '{$name}', `slug` = '{$slug}', `content` = '{$content}' WHERE id={$id} LIMIT 1";
		if($this->query($query)){
			return true;
		}
		else{
			return false;
		}
	}
	
	/**
	* @name listPages
	* @type: Public
	* @description: Функцията осъществява листването на всички страници
	**/
	public function listPages($page, $published = null, $showinmenu = null){
		//Извикваме си нужните ни класове
		global $filter;
		
		//Филтрираме подадените ни променливи
		$published = $filter->sql($published);
		$showinmenu = $filter->sql($showinmenu);
		
		$query = "SELECT `id`, `name`, `slug` FROM `pages` WHERE 1=1 ";
		if($published != null){
			$query .= "AND `published` = '{$published}' ";
		}
		if($showinmenu){
			$query .= "AND `showinmenu` = '{$showinmenu}'";
		}
		$query .= "ORDER BY `id` ASC";
		$allPages = $this->query($query);
		
		return $allPages;
	}
	
	/**
	* @name dropDiscipline
	* @type: Public
	* @description: Функцията осъществява изтриването на страницата от базата данни
	**/
	public function dropPage($id){
		global $filter;
		
		(int) $id = $filter->sql($id);
		
		$query = "DELETE FROM `pages` WHERE id={$id} LIMIT 1";
		return $this->query($query);
	}
	
	/**
	* @name getPageByName
	* @type: Public
	* @description: Функцията извлича от базата данни информация за страница по подаден slug
	**/
	public function getPageBySlug($slug, $published = null){
		global $filter;
		
		$slug = $filter->sql($slug);
		$published = $filter->sql($published);
		
		$query = "SELECT `id`, `name`, `content` FROM `pages` WHERE  `slug`='{$slug}' ";
		if($published != null){
			$query .= "AND `published` = '{$published}' ";
		}
		$query .= "LIMIT 1";
		return $this->query($query);
	}
	
	
	/**
	* @name: Solved
	* @type: Public
	* @description: Функцията извлича от базата всички тестове решени от даден потребител
	**/
	public function Solved($username){
		global $filter;
		
		$username = $filter->sql($username);
		
		$query = "SELECT * FROM `solved` WHERE `student` = '{$username}'";
		
		return $this->query($query);
	}
	
	/**
	* @name solvedQuiz
	* @type: Public
	* @description: Функцията добавя даден тест като решен от потребителя
	**/
	public function solvedQuiz($quiz, $student, $score, $percent){
		global $filter;
		
		$quiz = $filter->sql($quiz);
		$student = $filter->sql($student);
		$score = $filter->sql($score);
		$percent = $filter->sql($percent);
		
		$query = "INSERT INTO `solved` (`quiz_id`, `student`, `score`, `percent`) 
				VALUES ('{$quiz}', '{$student}', '{$score}', '{$percent}')";
		return $this->query($query);
	}
	
	/**
	* @name countSolved
	* @type: Public
	* @description: Функцията прави проверка колко пъти е решен даден тест от потребителя
	**/
	public function countSolved($quiz, $student){
		global $filter;
		
		$quiz = $filter->sql($quiz);
		$student = $filter->sql($student);
		
		$query = "SELECT `id` FROM `solved` WHERE `student` = '{$student}'";
		if($quiz != 0){
			$query .= "AND `quiz_id`= '{$quiz}'";
		}
		
		return $this->numrows($query);
	}
	
	/**
	* @name totalSolved
	* @type: Public
	* @description: Функцията прави проверка колко ОБЩО пъти е решен даден тест
	**/
	public function totalSolved($quiz){
		//Извикваме си нужните ни класове
		global $filter;
		
		//Филтрираме си подадените ни променливи
		$quiz = $filter->sql($quiz);
		
		
		//Създаваме и изпълняваме резултата
		$query = "SELECT `id` FROM `solved` WHERE `quiz_id` = '{$quiz}'";
		
		return $this->numrows($query);
	}
	
	/**
	* @name: createCookie
	* @type: Public
	* @description: Функцията записва в базата данни хеша на бисквитката
	**/
	public function createCookie($username, $value){
		//Извикваме си нужните ни класове
		global $filter;
		
		//Филтрираме подадните ни променливи
		$username = $filter->sql($username);
		$value = $filter->sql($value);
		
		//Изпълняваме заявката
		$query = "UPDATE `students` SET `cookie` = '{$value}' WHERE `student` = '{$username}' LIMIT 1" ;
		
		return $this->query($query);
	}
	
	/**
	* @name: getCookie
	* @type: Public
	* @description: Функцията извлича потребителското име, въз основа на подадена бисквитка
	**/
	public function getCookie($cookie){
		//Извикваме си нужните ни класове
		global $filter;
		
		//Филтрираме подадената променлива
		$cookie = $filter->sql($cookie);
		
		//Създаваме и изпращаме заявката
		$query = "SELECT `student` FROM `students` WHERE `cookie` = '{$cookie}' LIMIT 1";
		
		return $this->query($query);
	}
	
	/**
	* @name: dropCookie
	* @type: Public
	* @description: Функцията унищожава записа на създадена бисквитка
	**/
	public function dropCookie($username){
		//Извикваме си нужните ни класове
		global $filter;
		
		//Филтрираме подадената променлива
		$username = $filter->sql($username);
		
		//Създаваме и изпращаме заявката
		$query = "UPDATE `students` SET `cookie` = '' WHERE `student` = '{$username}' LIMIT 1" ;
		
		return $this->query($query);
	}
	
	/**
	* @name: listUsers
	* @type: Public
	* @description: Функцията извлича всички потребители от базата данни
	*/
	public function listUsers($pageNumber){
		//Извикваме си нужните ни класове
		global $filter;
		
		//Филтрираме подадената променлива
		$pageNumber = $filter->sql($pageNumber);
		
		//Създаваме и изпращаме заявката
		$query = "SELECT `id`, `student`, `passwd`, `email`, `real_name`, `role`
			FROM `students` ORDER BY `id` ASC";
		
		return $this->query($query);
	}
	
	/**
	* @name: dropUser
	* @type: Public
	* @description: Функцията изтрива потребителя от базата  данни
	*/
	public function dropUser($id){
		//Извикваме си нужните ни класове
		global $filter;
		
		//Филтрираме подадените ни променливи
		$id = $filter->sql($id);
		
		//Изпълняваме заявката
		$query = "DELETE FROM `students` WHERE `id` = '{$id}'";
		
		return $this->query($query);
	}
	
	/**
	* @name: updateVisitors
	* @type: Public
	* @description: Функцията записва всяко посещение в базата данни
	**/
	public function updateVisitors($ip, $referer, $useragent, $current){
		//Извикваме си нужния ни клас
		global $filter;
		
		//Фитрираме подадените ни променливи
		$ip = $filter->sql($ip);
		$referer = $filter->sql($referer);
		$useragent = $filter->sql($useragent);
		$current = $filter->sql($current);
		
		$query = "INSERT INTO `visitors` (`ip`, `referer`, `useragent`, `current`) VALUES ('{$ip}', '{$referer}', '{$useragent}', '{$current}')"; 
		
		return $this->query($query);
	}
	
	/**
	* @name: countVisitors
	* @type: Public
	* @description: Преброява посещенията. Ако е подадена 1-ца, извежда само посещенията от днешна дата
	**/
	public function countVisitors($when = null){
		//Извикваме си нужния ни клас
		global $filter;
		
		//Фитрираме подадената променлива
		(int) $when = $filter->sql($when);

		
		$query = "SELECT * FROM `visitors` ";
		if($when == 1){
			$today = date("Y-m-d");
			$query .= " WHERE `datetime` LIKE '{$today}%' ";
		}
		
		return $this->numrows($query);
	}
	
	/**
	* @name: countVisitors
	* @type: Public
	* @description: Преброява посещенията. Ако е подадена 1-ца, извежда само посещенията от днешна дата
	**/
	public function countUniqueVisitors($when = null){
		//Извикваме си нужния ни клас
		global $filter;
		
		//Фитрираме подадената променлива
		(int) $when = $filter->sql($when);

		
		$query = "SELECT DISTINCT `ip` FROM `visitors` ";
		if($when == 1){
			$today = date("Y-m-d");
			$query .= " WHERE `datetime` LIKE '{$today}%' ";
		}
		
		return $this->numrows($query);
	}
	
}
$db = new DB();



?>
