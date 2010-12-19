<?php
/**
 * @file: Admin.Controller.php
 * @type: Controller
 * @description: Админ контролерът управлява функционирането на
 * 	Администраторския панел, извиква нужните външни
 * 	класове и темплейт файловете.
 * @license: GNU General Public License v2
 */

class Admin{
	
	//Нулираме си променливите
	var $message;

	/**
	* @name: Admin
	* @description: Функция, която се изпълнява при всяко извикване на класа
	*/
	function __construct() {
		global $members, $breadcrumbs;
		
		if(!$members->isAdmin($members->studentName())) {
			header("Location: " . SITE_URL ."Pages/Error404/");
		}
		
		//Добавяме пътечката
		$breadcrumbs["Admin"] = array( id=>"Admin", parent=>"home", title=>"Администраторски панел", url=>"Admin/Index" );
		$breadcrumbs["listPages"] = array( id=>"listPages", parent=>"Admin", title=>"Страници", url=>"Admin/listPages" );
		$breadcrumbs["listDisciplines"] = array( id=>"listDisciplines", parent=>"Admin", title=>"Предмети", url=>"Admin/listDisciplines" );
		$breadcrumbs["listQuizes"] = array( id=>"listQuizes", parent=>"Admin", title=>"Тестове", url=>"Admin/listQuizes" );
		$breadcrumbs["listQuestions"] = array( id=>"listQuestions", parent=>"Admin", title=>"Въпроси", url=>"Admin/listQuestions" );
		$breadcrumbs["listUsers"] = array( id=>"listUsers", parent=>"Admin", title=>"Потребители", url=>"Admin/listUsers" );
	}

	/**
	* @name: __call
	* @description: Тази функция се изпълнява при извикване на несъществуваща
	* функция в този клас.
	*/
	function __call($getClass, $getFunction){
		global $pages;
		
		$pages->Error404();
	}

	/**
	* @name: Index
	* @type: Public
	* @description: Функцията представя началната страница в администраторския панел
	**/
	public function Index(){
		//Извикваме си нужните ни класове
		global $db, $filter;
		
		//Взимаме посещенията от днес
		$uniqueVisitors =  $db->countUniqueVisitors(1);
		$Visitors = $db->countVisitors(1);
		
		//Взимаме всички посещения
		$allUniqueVisitors =  $db->countUniqueVisitors();
		$allVisitors = $db->countVisitors();
		
		//Обща статистическа информация
		$allDisciplines = $db->numrows("SELECT `id` FROM `disciplines`");
		$allQuizes = $db->numrows("SELECT `id` FROM `quiz`");
		$allQuestions = $db->numrows("SELECT `id` FROM `questions`");
		$allPages = $db->numrows("SELECT `id` FROM `pages`");
		$allStudents = $db->numrows("SELECT `id` FROM `students`");
		
		$title= "Администраторски панел | ".SITE_NAME;
		require_once(ADMIN_TEMPLATE."Index.tpl.php");

		
	}
	
	/**
	 * @name: addDiscipline
	 * @type: Public
	 * @description: Страницата, за добавяне на нови предмети
	 */
	public function addDiscipline(){
		//Извикваме нужните ни класове и пътечката
		global $db, $filter, $breadcrumbs;
		
		//Ако е изпратен формуляр
		if($_POST['sent'] == 1){
			//Филтрираме подадените променливи
			$disciplineName = $filter->input($_POST['name']);
			$disciplineDesc = $filter->input($_POST['description']);
			$disciplineSlug = $filter->input($_POST['slug']);
			
			//При празни полета, връща грешка
			if($disciplineName == null || $disciplineDesc == null || $disciplineSlug == null){
				$message = "Моля, попълнете всички полета!";
			}
			else{
				//Проверяваме, дали вече има предмет с това име
				$query0 = "SELECT id FROM disciplines WHERE name = '{$disciplineName}' LIMIT 1";
				$numrows = $db->numrows($query0);
				if($numrows != 0){
					//Ако има, връща грешка
					$message = "Вече е добавен предмет с това име!";
				}
				else{
					//Ако всичко е наред вкарваме в базата данни информацията
					if($db->addDiscipline($disciplineName, $disciplineDesc, $disciplineSlug)){
					$message = "Предметът '$disciplineName' беше добавен успешно!";
				}
			}
		}
		}
			//Заглавието на страницата
			$title = "Добавяне на нов предмет | " . SITE_NAME;

		//Добавяме пътечката
		$breadcrumbs["addDiscipline"] = array( id=>"addDiscipline", parent=>"listDisciplines", title=>"Добавяне на предмет", url=>"" );
		
		//Показваме формуляра
		require_once(ADMIN_TEMPLATE."addDiscipline.tpl.php");
	}
	
	/**
	 * @name: editDiscipline
	 * @type: Public
	 * @description: Страницата, за редактиране на съществуващ предмет
	 */
	public function editDiscipline(){
		//Извикваме нужните ни класове и пътечката
		global $db, $filter, $breadcrumbs;
		
		//Нулираме си променливите
		$discipline = array();
		
		//Ако е изпратен формуляр
		if($_POST['sent'] == 1){
			//Филтрираме подадените променливи
			$disciplineName = $filter->input($_POST['name']);
			$disciplineDesc = $filter->input($_POST['description']);
			$disciplineID = $filter->input($_GET['id']);
			$disciplineSlug = $filter->input($_POST['slug']);
			
			//Проверяваме, дали изобщо съществува поисканият предмет
			$numrows = $db->numrows("SELECT id FROM `disciplines` WHERE id = '{$disciplineID}' LIMIT 1");
			if($numrows != 1){
				//Ако не съществува, връщаме грешка
				$message = "Не съществува такъв предмет!";
			}
			else{
				//Ако всичко е наред записваме подадената информация и пренасочваме към страницата 
				//със списък на предметите
				if($db->editDiscipline($disciplineName, $disciplineDesc, $disciplineSlug, $disciplineID)){
					$message = "Предметът '$disciplineName' беше редактиран успешно!";
					header("Location: " . SITE_URL ."Admin/listDisciplines/");
				}
				else{
					//При неуспех връщаме грешка
					$message = "Грешка в конфигурацията на сървъра, моля опитайте по-късно!";
				}
			}
		}


			$disciplineID = $filter->input($_GET['id']);
			//Взимаме информацията за поисканата дисциплина
			$result = $db->getDiscipline($disciplineID);

		//Заглавието на страницата
		$title = "Редактиране на предмет | " . SITE_NAME;
		
		//Добавяме пътечката
		$breadcrumbs["editDiscipline"] = array( id=>"editDiscipline", parent=>"listDisciplines", title=>"Редактиране на предмет", url=>"" );
		
		//Визуализираме формуляра
		require_once(ADMIN_TEMPLATE."editDiscipline.tpl.php");
		
	}
	
	
	/**
	 * @name: dropDiscipline
	 * @type: Public
	 * @description: Функция за триене на предмет
	 */
	public function dropDiscipline(){
		//Извикваме нужните ни класове
		global $db, $filter;
		
		//Филтрираме си променливата
		$id = $filter->input($_GET['id']);
		//Трием зададения предмет
		$db->dropDiscipline($id);
		
		//Пренасочваме към списъка с предмети
		header("Location: ".SITE_URL . "Admin/listDisciplines/");
	}
		
	

	/**
	 * @name: listDisciplines
	 * @type: Public
	 * @description: Списък със всички добавени предмети
	 */
	public function listDisciplines(){
		//Извикваме нужните ни класове
		global $db, $filter;
		
		//Нулираме си променливите
		$allDisciplines = array();
		$disciplinePage = 0;
		
		//Филтрираме подадените променливи
		if(isset($_GET['page'])){
			$disciplinePage = $filter->input($_GET['page']);
		}
		
		//Взимаме предметите според, поисканата страница
		$allDisciplines = $db->listDisciplines($disciplinePage);
		
		//Заглавие на страницата
		$title = "Администрация на предметите | " . SITE_NAME;
		
		//Визуализираме върнатия списък с предмети
		require_once(ADMIN_TEMPLATE."listDisciplines.tpl.php");
		
	}
	
	
	/**
	 * @name: addQuiz
	 * @type: Public
	 * @description: Добавяне на нов тест
	 */
	public function addQuiz(){
		//Извикваме нужните ни класове и пътечките
		global $db, $filter, $breadcrumbs;
		
		//Ако е изпратен формуляр
		if($_POST['sent'] == 1){
			//Филтрираме подадените променливи
			$published = 0;
			$quizName = $filter->input($_POST['name'], 35);
			$quizDescription = $filter->input($_POST['description']);
			$discipline = $filter->input($_POST['discipline'], 3);
			$quizDifficulty = $filter->input($_POST['difficulty'], 35);
			$published = $filter->input($_POST['published']);
			if($_POST['hastext'] == 1){
				$text_title = $filter->input($_POST['text_title'], 35);
				$text = $filter->input($_POST['text']);
			}
				$query0 = "SELECT id FROM quiz WHERE name = '{$quizName}' LIMIT 1";
				$numrows = $db->numrows($query0);
				
				//Проверяваме да не е оставено празно някое от полетата
				if($quizName == null || $quizDescription == null || $discipline == null || $quizDifficulty == null){
					$message = "Моля, попълнете всички полета!";
				}
				//Проверяваме дали вече съществува тест с това име и ако е така връщаме грешка
				else if($numrows != 0){
					$message = "Вече е добавен тест с това име!";
				}
				
				else{   //Ако всичко е наред записваме новия тест
					if($_POST['hastext'] == 1){
						if($db->addQuiz($quizName, $quizDescription, $discipline, $quizDifficulty, $published, $text_title, $text)){
							//$message = "Тестът '$quizName' беше добавен успешно!";
							header("Location: ".SITE_URL."Admin/addQuestion");
						}
					}
					else {
						if($db->addQuiz($quizName, $quizDescription, $discipline, $quizDifficulty, $published)){
							//$message = "Тестът '$quizName' беше добавен успешно!";
							header("Location: ".SITE_URL."Admin/addQuestion");
						}
					}
				}
		}
		//Взимаме всички предмети
		$allDisciplines = $db->listDisciplines(0);
		
		//Заглавие на страницата
		$title = "Добавяне на нов тест | " . SITE_NAME;
		
		//Добавяме пътечката
		$breadcrumbs["addQuiz"] = array( id=>"addQuiz", parent=>"listQuizes", title=>"Добавяне на тест", url=>"" );
		
		//Визуализираме формуляра
		require_once(ADMIN_TEMPLATE."addQuiz.tpl.php");
	}
	
	/**
	 * @name: listQuizes
	 * @type: Public
	 * @description: Списък със всички добавени тестове
	 */
	public function listQuizes(){
		//Извикваме нужните ни класове
		global $db, $filter;
		
		//Нулираме си променливите
		$allQuizes = array();
		$quizPage = 0;
		
		//Филтрираме променливата за страницата
		$quizPage = $filter->input($_GET['page']);
		$disciplineName = $filter->input($_GET['id']);
		
		//Ако е избран предмет извличаме id-то му
		if($disciplineName != null){
			$allDisciplines = mysql_fetch_array($db->getDisciplineByName($disciplineName));
			if(mysql_numrows($db->getDisciplineByName($disciplineName)) == 1){
				$discipline = $allDisciplines['id'];
				$discName = $allDisciplines['name'];
			}
			else{
				$discipline = "False";
			}
		}
		
		//Вземане на тестовете, според поисканата страница и предмет(if any)
		$allQuizes = $db->listQuizes($quizPage, null, $discipline);

		
		//Заглавие на страницата
		$title = "Администрация на тестовете | " . SITE_NAME;
		
		//Визуализираме списъка
		require_once(ADMIN_TEMPLATE."listQuizes.tpl.php");
		
	}
	
	/**
	 * @name: editQuiz
	 * @type: Public
	 * @description: Страницата, за редактиране на съществуващ тест
	 */
	public function editQuiz(){
		//Извикваме нужните ни класове и пътечката
		global $db, $filter, $breadcrumbs;
		
		//Нулираме си масива
		$quiz = array();

		
		//Ако е изпратен формуляр
		if($_POST['sent'] == 1){
			//Филтриране на приетите променливи
			$published = 0;
			$quizName = $filter->input($_POST['name']);
			$quizDescription = $filter->input($_POST['description']);
			$quizDifficulty = $filter->input($_POST['difficulty'], 2);
			$quizID = $filter->input($_GET['id']);
			$discipline = $filter->input($_POST['discipline'], 3);
			$published = $filter->input($_POST['published']);
			if($_POST['hastext'] == 1){
				$text_title = $filter->input($_POST['text_title'], 35);
				$text = $filter->input($_POST['text']);
			}
       
			
			//Проверка дали съществува поисканият тес, ако ли не връщаме грешка
			$numrows = $db->numrows("SELECT id FROM `quiz` WHERE id = '{$quizID}' LIMIT 1");
			if($numrows != 1){
				$message = "Не съществува такъв тест!";
			}
			//Проверяваме да не е оставено празно някое от полетата
				if($quizName == null || $quizDescription == null || $discipline == null || $quizDifficulty == null){
					$message = "Моля, попълнете всички полета!";
			}
			else{
				//Записваме редакцията и пренасочваме към списъка с тестове
				if($db->editQuiz($quizName, $quizDescription, $discipline, $quizDifficulty, $quizID, $text_title, $text, $published)){
					$message = "Тестът '$quizName' беше редактиран успешно!";
					header("Location: " . SITE_URL ."Admin/listQuizes/");
				}
				else{
					//При неуспех връщаме грешка
					$message = "Грешка в конфигурацията на сървъра, моля опитайте по-късно!";
				}
			}
		}

		//Филтрираме id променливата на извикания тест
		$quizID = $filter->input($_GET['id']);
		//Взимаме информация за поискания тест
		$result = $db->getQuiz($quizID);
		//Взимаме всички предмети
		$allDisciplines = $db->listDisciplines(0);
		

		
		//Заглавие на страницата
		$title = "Редактиране на тестове | " . SITE_NAME;
		
		//Добавяме пътечката
		$breadcrumbs["editQuiz"] = array( id=>"editQuiz", parent=>"listQuizes", title=>"Редактиране на тест", url=>"" );
		
		//Визуализираме формуляра
		require_once(ADMIN_TEMPLATE."editQuiz.tpl.php");
		
	}
	
	/**
	 * @name: dropQuiz
	 * @type: Public
	 * @description: Функция за триене на тест
	 */
	public function dropQuiz(){
		//Извикваме си нужните ни класове
		global $db, $filter;
		
		//Филтрираме id променливата
		$id = $filter->input($_GET['id']);
		
		//Изтриваме теста, отговарящ на това id
		$db->dropQuiz($id);
		
		//Пренасочваме към списъка с въпроси
		header("Location: ".SITE_URL . "Admin/listQuizes/");
	}
	
	/**
	 * @name: addQuestion
	 * @type: Public
	 * @description: Страницата, за добавяне на нови въпроси
	 */
	public function addQuestion(){
		//Извикваме нужните ни класове и пътечката
		global $db, $filter, $breadcrumbs;
		
		//Ако е изпратен формуляр
		if($_POST['sent'] == 1){
			//Филтрираме си подадените променливи
			$question = $filter->input($_POST['question']);
			$quiz_id = $filter->input($_POST['quiz_id'], 3);
			$opt1 = $filter->input($_POST['opt1']);
			$opt2 = $filter->input($_POST['opt2']);
			$opt3 = $filter->input($_POST['opt3']);
			$opt4 = $filter->input($_POST['opt4']);
			$correct = $filter->input($_POST['correct'], 1);
			
			//При празни полета, връщаме грешка
			if($question == null || $quiz_id == null || $opt1 == null || $opt2 == null || $opt3 == null || $opt4 == null){
				$message = "Моля, попълнете всички полета!";
			}
			else {
				//Ако всичко е наред добавяме новия въпрос
				if($db->addQuestion($question, $quiz_id, $opt1, $opt2, $opt3, $opt4, $correct)){
						$message = "Въпросът беше добавен успешно!";
					}

			}
		}
		//Взимаме всички тестове
		$allQuizes = $db->listQuizes(0);
		
		//Заглавие на страницата
		$title = "Добавяне на нов тест | " . SITE_NAME;
		
		//Добавяме пътечката
		$breadcrumbs["addQuestion"] = array( id=>"addQuestion", parent=>"listQuestions", title=>"Добавяне на въпрос", url=>"" );
		
		//Визуализираме формуляра
		require_once(ADMIN_TEMPLATE."addQuestion.tpl.php");
	}
	
	/**
	 * @name: listQuestions
	 * @type: Public
	 * @description: Списък със всички добавени въпроси
	 */
	public function listQuestions(){
		//Извикваме нужните ни класове
		global $db, $filter;
		
		//Нулираме си променливите
		$allQuestions = array();
		$Page = 0;
		
		//Филтрираме променливата съдържаща страницата
		$Page = $filter->input($_GET['page']);
		$quizID = $filter->input($_GET['id']);
		
		//Извличаме поисканите въпроси
		$allQuestions = $db->listQuestions($Page, $quizID);
		
		//Заглавието на страницата
		$title = "Администрация въпросите | " . SITE_NAME;
		
		//Визуализираме въпросите
		require_once(ADMIN_TEMPLATE."listQuestions.tpl.php");
		
	}
	
	/**
	 * @name: editQuestion
	 * @type: Public
	 * @description: Страницата, за редактиране на съществуващ въпрос
	 */
	public function editQuestion(){
		//Извикваме нужните ни класове и пътечката
		global $db, $filter, $breadcrumbs;
		
		//Нулираме си масива
		$quiz = array();
		
		//Ако е изпратен фомруляр
		if($_POST['sent'] == 1){
			//Филтрираме си променливите
			$question = $filter->input($_POST['question']);
			$quiz_id = $filter->input($_POST['quiz_id'], 3);
			$opt1 = $filter->input($_POST['opt1']);
			$opt2 = $filter->input($_POST['opt2']);
			$opt3 = $filter->input($_POST['opt3']);
			$opt4 = $filter->input($_POST['opt4']);
			$correct = $filter->input($_POST['correct'], 1);
			$ID = $filter->input($_GET['id']);
			
			//Проверяваме дали съществува такъв въпрос, ако ли не - връщаме грешка
			$numrows = $db->numrows("SELECT id FROM `questions` WHERE id = '{$ID}' LIMIT 1");
			if($numrows != 1){
				$message = "Не съществува такъв въпрос!";
			}
			else if($question == null || $quiz_id == null || $opt1 == null || $opt2 == null || $opt3 == null || $opt4 == null){
				$message = "Моля, попълнете всички полета!";
			}
			else{
				//Ако всичко е наред, записваме редакцията и пренасочваме към списъка с въпроси
				if($db->editQuestion($question, $quiz_id, $opt1, $opt2, $opt3, $opt4, $correct, $ID)){
					$message = "Въпросът беше редактиран успешно!";
					header("Location: " . SITE_URL ."Admin/listQuestions/");
				}
				else{
					//Ако възникне проблем, връщаме грешка
					$message = "Грешка в конфигурацията на сървъра, моля опитайте по-късно!";
				}
			}
		}

			
			//Филтрираме си id променливата на поискания въпрос
			$ID = $filter->input($_GET['id']);
			
			//Извличаме информацията за този въпрос
			$result = $db->getQuestion($ID);
			
			//Извличаме всички тестове
			$allQuizes = $db->listQuizes(0);

		//Заглавието на страницата
		$title = "Редактиране на въпроси | " . SITE_NAME;
		
		//Добавяме пътечката
		$breadcrumbs["editQuestion"] = array( id=>"editQuestion", parent=>"listQuestions", title=>"Редактиране на въпрос", url=>"" );
		
		//Визуализираме формуляра
		require_once(ADMIN_TEMPLATE."editQuestion.tpl.php");
		
	}
	
	/**
	 * @name: dropQuestion
	 * @type: Public
	 * @description: Функция за триене на въпрос
	 */
	public function dropQuestion(){
		//Извикваме нужните ни класове
		global $db, $filter;
		
		//Филтрираме id променливата на извиквания въпрос
		$id = $filter->input($_GET['id']);
		
		//Изтриване на въпроса от базата данни
		$db->dropQuestion($id);
		
		//Пренасочваме към списъка с въпроси
		header("Location: ".SITE_URL . "Admin/listQuestions/");
	}
	
	
	/**
	 * @name: addPage
	 * @type: Public
	 * @description: Добавя нови страници в сайта
	 */
	public function addPage(){
		//Извикваме нужните ни класове и пътечката
		global $db, $filter, $breadcrumbs;
		
		//Ако е изпратен формуляр
		if($_POST['sent'] == 1){
			//Филтрираме подадените променливи
			$published = 0;
			$showinmenu = 0;
			$pageName = $filter->input($_POST['name']);
			$pageSlug = $filter->input($_POST['slug']);
			$pageContent = $filter->input($_POST['content']);
			$published = $filter->input($_POST['published']);
			$showinmenu = $filter->input($_POST['showinmenu']);
			
			//При празни полета, връща грешка
			if($pageName == null || $pageContent == null || $pageSlug == null){
				$message = "Моля, попълнете всички полета!";
			}
			else{
				//Проверяваме, дали вече има страница с това име
				$query0 = "SELECT id FROM pages WHERE name = '{$pageName}' LIMIT 1";
				$numrows = $db->numrows($query0);
				if($numrows != 0){
					//Ако има, връща грешка
					$message = "Вече е добавенa страница с това име!";
				}
				else{
					//Ако всичко е наред вкарваме в базата данни информацията
					if($db->addPage($pageName, $pageSlug, $pageContent, $published, $showinmenu)){
						$message = "Страницата '$pageName' беше добавена успешно!";
					}
					else{
						$message = "Временен проблем с базата данни!";
					}
				}
			}
		}
		
		//Заглавието на страницата
		$title = "Добавяне на нова страница | " . SITE_NAME;
		
		//Добавяме пътечката
		$breadcrumbs["addPage"] = array( id=>"addPage", parent=>"listPages", title=>"Добавяне на страница", url=>"" );
		
		//Показваме формуляра
		require_once(ADMIN_TEMPLATE."addPage.tpl.php");
	}
	
	/**
	 * @name: editPage
	 * @type: Public
	 * @description: Страницата, за редактиране на съществуваща страница
	 */
	public function editPage(){
		//Извикваме нужните ни класове и пътечката
		global $db, $filter, $breadcrumbs;
		
		//Нулираме си променливите
		$page = array();
		
		//Ако е изпратен формуляр
		if($_POST['sent'] == 1){
			//Филтрираме подадените променливи
			$pageName = $filter->input($_POST['name']);
			$pageSlug = $filter->input($_POST['slug']);
			$pageContent = $filter->input($_POST['content']);
			$pageID = $filter->input($_GET['id']);
			
			//Проверяваме, дали изобщо съществува поисканата страница
			$numrows = $db->numrows("SELECT id FROM `pages` WHERE id = '{$pageID}' LIMIT 1");
			if($numrows != 1){
				//Ако не съществува, връщаме грешка
				$message = "Не съществува такава страница!";
			}
			//При празни полета, връща грешка
			else if($pageName == null || $pageContent == null || $pageSlug == null){
				$message = "Моля, попълнете всички полета!";
			}
			else{
				//Ако всичко е наред записваме подадената информация и пренасочваме 
				//към списъка на страниците
				if($db->editPage($pageName, $pageSlug, $pageContent, $pageID)){
					$message = "Страницата '$pageName' беше редактирана успешно!";
					header("Location: " . SITE_URL ."Admin/listPages/");
				}
				else{
					//При неуспех връщаме грешка
					$message = "Грешка в конфигурацията на сървъра, моля опитайте по-късно!";
				}
			}
		}


			$pageID = $filter->input($_GET['id']);
			//Взимаме информацията за поисканата страница
			$result = $db->getPage($pageID);

		//Заглавието на страницата
		$title = "Редактиране на страници | " . SITE_NAME;
		
		//Добавяме пътечката
		$breadcrumbs["editPage"] = array( id=>"editPage", parent=>"listPages", title=>"Редактиране на страница", url=>"" );
		
		//Визуализираме формуляра
		require_once(ADMIN_TEMPLATE."editPage.tpl.php");
		
	}
	
	/**
	 * @name: dropPage
	 * @type: Public
	 * @description: Функция за триене на страница
	 */
	public function dropPage(){
		//Извикваме нужните ни класове
		global $db, $filter;
		
		//Филтрираме си променливата
		$id = $filter->input($_GET['id']);
		//Трием зададения предмет
		$db->dropPage($id);
		
		//Пренасочваме към списъка с предмети
		header("Location: ".SITE_URL . "Admin/listPages/");
	}
		
	

	/**
	 * @name: listPages
	 * @type: Public
	 * @description: Списък със всички добавени страници
	 */
	public function listPages(){
		//Извикваме нужните ни класове
		global $db, $filter;
		
		//Нулираме си променливите
		$allPages = array();
		$pageNumber = 0;
		
		//Филтрираме подадените променливи
		if(isset($_GET['page'])){
			$pageNumber = $filter->input($_GET['page']);
		}
		
		//Взимаме предметите според, поисканата страница
		$allPages = $db->listPages($pageNumber);
		
		//Заглавие на страницата
		$title = " Администрация на страниците | " . SITE_NAME;
		
		//Визуализираме върнатия списък с предмети
		require_once(ADMIN_TEMPLATE."listPages.tpl.php");
		
	}
	
	/**
	* @name: listUsers
	* @type: Public
	* @description: Списък със всички потребители в сайта
	*/
	public function listUsers() {
		//Извикваме си нужните ни класове
		global $db, $filter;
		
		//Нулираме си променливите
		$allUsers = array();
		$pageNumber = 0;
		
		//Филтрираме подадените променливи
		if(isset($_GET['page'])){
			$pageNumber = $filter->input($_GET['page']);
		}
		
		//Взимаме предметите според, поисканата страница
		$allUsers = $db->listUsers($pageNumber);
		
		//Заглавие на страницата
		$title = "Администрация на потребителите | " . SITE_NAME;
		
		//Визуализираме върнатия списък с потребители
		require_once(ADMIN_TEMPLATE."listUsers.tpl.php");
	}
	
	/**
	* @name: editProfile
	* @type: Public
	* @description: Редактиране на потребител
	*/
	public function editProfile(){
		//Извикваме си нужните ни класове
		global $db, $filter, $members;
		
		//Филтрираме си подадените променливи
		$username = $filter->input($_GET['id']);
		
		$members->editProfile($username);
		
	}
	
	/**
	* @name: changePassword
	* @type: Public
	* @description: Редактиране на потребителската парола
	*/
	public function changePassword(){
		//Извикваме си нужните ни класове
		global $db, $filter, $members;
		
		//Филтрираме си подадените променливи
		$username = $filter->input($_GET['id']);
		
		$members->changePassword($username);
		
	}
	
	/**
	* @name: changeAvatar
	* @type: Public
	* @description: Редактиране на потребителския аватар
	*/
	public function changeAvatar(){
		//Извикваме си нужните ни класове
		global $db, $filter, $members;
		
		//Филтрираме си подадените променливи
		$username = $filter->input($_GET['id']);
		
		$members->changeAvatar($username);
		
	}
	
	/**
	* @name: dropAvatar
	* @type: Public
	* @description: Изтриване на потребителския аватар
	*/
	public function dropAvatar(){
		//Извикваме си нужните ни класове
		global $db, $filter, $members;
		
		//Филтрираме си подадените променливи
		$username = $filter->input($_GET['id']);
		
		$members->dropAvatar($username);
		
	}
	
	/**
	* @name: dropUser
	* @type: Public
	* @description: Изтрива потребител
	*/
	public function dropUser(){
		//Извикваме си нужните ни класове
		global $db, $filter;
		
		//Филтрираме подадените ни променливи
		$user = $filter->input($_GET['id']);
		
		//Изтриваме потребителя от базата данни
		$db->dropUser($user);
		
		//Пренасочваме към списъка с потребители
		header("Location: ".SITE_URL."Admin/listUsers/");
	}
	

}
//Инициалираме класа
$admin = new Admin;
?>