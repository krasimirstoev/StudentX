<?php
/**
 * @file: Quiz.Controller.php
 * @type: Controller
 * @description: Quiz контролерът управлява функционирането на
 * 					възможносттите за извеждане, решаване и оценяване на добавените тестове,
 * 					 извиква нужните външни класове и темплейт файловете.
 * @license: GNU General Public License v2
 */
class Quiz{
	
	/**
	* @name: __construct
	* @description: Изпълнява се при всяко извикване на класа
	**/
	function __construct(){
	global $db, $breadcrumbs;
	
	//Добавяме пътечката
	$breadcrumbs["Quiz"] = array( id=>"Quiz", parent=>"home", title=>"Тестове", url=>"Quiz/listQuizes/" );
	
	//Извличаме предметите
	$allDisciplines = $db->listDisciplines();
	
	while( $all = mysql_fetch_array($allDisciplines) ){
		$breadcrumbs[$all['slug']] = array( id=>$all['slug'], parent=>"Quiz", title=>$all['name'], url=>"Quiz/listQuizes/{$all['slug']}" );
	}

	
}

	
	/**
	 * @name: __call
	 * @description: Тази функция се изпълнява при извикване на несъществуваща
	 * 				функция в този клас. 
	 */
	function __call($getClass, $getFunction){
		global $pages;
		
		$pages->Error404();
		
	}
	
	/**
	* @name: listDisciplines
	* @type: Public
	* @description: Списък с всички предмети
	*/
	public function listDisciplines(){
		//Извикваме нужните ни класове
		global $db, $filter;
		
		//Извличаме предметите
		$allDisciplines = $db->listDisciplines();
		
		//Заглавие на страницата
		$title = SITE_NAME." - Решаване на тестове онлайн!";
		
		//Визуализираме списъка с предмети
		require_once(TEMPLATE."listDisciplines.tpl.php");
	}
	
	/**
	 * @name: listQuizes
	 * @type: Public
	 * @description: Списък със всички добавени тестове и възможност за решаване на 
	 */
	public function listQuizes(){
		//Извикваме нужните ни класове
		global $db, $filter;
		
		//Нулираме си променливите
		$allQuizes = array();
		$page = 0;
		$disciplineName = $filter->input($_GET['id']);
		
		//Ако е избран предмет извличаме id-то му
		if($disciplineName != null){
			$allDisciplines = mysql_fetch_array($db->getDisciplineByName($disciplineName));
			if(mysql_numrows($db->getDisciplineByName($disciplineName)) == 1){
				$discipline = $allDisciplines['id'];
			}
			else{
				$discipline = "False";
			}
		}
		//Филтрираме променливата за страницата
		if(isset($_GET['page'])){
			$page = $filter->input($_GET['page']);
		}
		
		//Вземане на тестовете, според поисканата страица 
		$allQuizes = $db->listQuizes($page, 1, $discipline);
		
		//Заглавие на страницата
		$title = "Тестове | " . SITE_NAME;
		
		//Визуализираме списъка
		require_once(TEMPLATE."listQuizes.tpl.php");
	}
	
	/**
	 * @name: execQuiz
	 * @type: Public
	 * @description: Функция, извличаща въпросите към даден тест
	 * 					и визуализираща ги под формата на формуляр
	 * */
	public function execQuiz(){
		//Извикваме си нужните ни класове и пътечката
		global $db, $filter, $breadcrumbs;
		
		//Нулираме си променливите
		$quizInfo = array();
		$allQuestions = array();
		
		//Филтрираме ID променливата на теста
		$quizID = $filter->input($_GET['id']);
		
		//Взимаме информация за теста и името на предмета
		$info = $db->getQuiz($quizID);
		$bla = mysql_fetch_array($info);
		$disc_id = $db->getDiscipline($bla['disc_id']);
		$discipline = mysql_fetch_array($disc_id);
		
		//Извличаме всичко въпроси, към избрания тест
		$allQuestions = $db->fetchQuestions($quizID);
		
		
		//Заглавие на страницата
			$title = "Решаване на тестове | " . SITE_NAME;
			
		//Добавяме пътечката
		$breadcrumbs[$bla['id']] = array( id=>$bla['id'], parent=>$discipline['slug'], title=>$bla['description'], url=>"" );
		
		//Визуализираме теста
		require(TEMPLATE."execQuiz.tpl.php");
		
	}
	
	/**
	 * @name: showResults
	 * @type: Public
	 * @description: Функция която приема подадените от потребителя отговори, 
	 * 					оценява ги и връща изчислена оценка
	 **/
	public function showResults(){
		//Извикваме си нужните ни класове
		global $db, $filter, $result;
		
		if($_POST['sent'] == 1){
			//Нулираме си променливите
			$True = 0;
			$False = 0;
			$answer = null;
			
			//Филтрираме си подадените ни променливи
			$quizID = $filter->input($_GET['id']);
			
			//Извличаме от базата данни верните отговори и информация за теста
			$correct = $db->fetchQuestions($quizID);
			$quiz = $db->getQuiz($quizID);
			//Заглавие на страницата
			$title = "Резултати от теста | ". SITE_NAME;
			
			//Визуализираме резултатите
			require_once(TEMPLATE."showResults.tpl.php");
		}
		else{
			$this->execQuiz($_GET['id']);
		}
		
		
	}
	
}

$quiz = new Quiz();
