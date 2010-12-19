<?php
/**
 * @file: Page.Controller.php
 * @type: Controller
 * @description: Page контролерът се грижи за визуализирането на страниците
 * @license: GNU General Public License v2
**/

class Page {

	//Променлви за нулиране

	/**
	 * @function: __call
	 * @description: Тази функция се изпълнява при извикване на несъществуваща
	 * 	функция в този клас. 
	 */
	function __call($method, $arguments){
		//Извикваме си нужните ни класове и пътечката
		global $db, $filter, $scf4u, $breadcrumbs;
		
		//Извличаме от базата данни информация за страницата
		$result = $db->getPageBySlug($method, 1);
		if(mysql_numrows($result) != 1){
			$this->Error404();
		}
		$page = mysql_fetch_array($result);
		
		//Филтрираме получените данни и добавяме подръжка на bbcode
		$name = $filter->decode($scf4u->bbcode($page['name']));
		$content = $filter->decode($scf4u->bbcode($page['content']));
		
		//Заглавие на страницата
		$title = $name . " | " . SITE_NAME;
		
		//Добавяме пътечката
		$breadcrumbs[$method] = array( id=>$name, parent=>"home", title=>$name, url=>"Pages/{$method}" );
		
		//Визуализираме страницата
		require_once(TEMPLATE."page.tpl.php");
		
	}

	/**
	* @function: __construct
	* @description: Функцията се изпълнява при всяко извикване на класа
	**/
	function __construct() {
		$name = null;
		$content = null;
		
	}
	
	/**
	* @function: list
	* @type: Public
	* @description: Функцията връща лист от всички добавени страници
	**/
	public function listPages($published = null, $showinmenu = null){
		//Извикваме нужните ни класове
		global $db, $filter;
		
		//Нулираме си променливите
		$allPages = array();
		$pageNumber = 0;
		
		//Филтрираме подадените променливи
		if(isset($_GET['page'])){
			$pageNumber = $filter->input($_GET['page']);
		}
		$published = $filter->input($published, 1);
		$showinmenu = $filter->input($showinmenu, 1);
		
		//Взимаме предметите според, поисканата страница
		$allPages = $db->listPages($pageNumber, $published, $showinmenu);
		return $allPages;
	}
	
	/**
	* @function: Contact
	* @type: Public
	* @description: Функцията осъществява изпращането на писма до администраторите
	**/
	public function Contact(){
		//Извикваме нужните ни класове и пътечката
		global $db, $filter, $scf4u, $breadcrumbs;
		
		$message = null;
		
		//Ако е изпратен формуляр, обработваме и изпращаме
		if($_POST['sent'] == 1){
			//Филтрираме си подадените ни променливи
			$name = $_POST['name'];
			$email = $_POST['email'];
			$content = $_POST['content'];
			
			//Проверяваме, за невалиден e-mail адрес
			if($scf4u->validEmail($email) == false){
				$message = "Въвели сте невалиден email адрес!";
			}
			//Ако всич ко е наред изпращаме съобщението
			else{
				$scf4u->sendMail($name, $email, $content);
				$message = "Съобщението е изпратено успешно! Ще се свържем с Вас при първа възможност!";
			}
		}
		//Визуализираме страницата с формуляра
		$title = "Пишете ни | ". SITE_NAME;
		
		//Добавяме пътечката
		$breadcrumbs['Contact'] = array( id=>"Пишете ни!", parent=>"home", title=>"Пишете ни!", url=>"Pages/Contact" );
		
		require_once(TEMPLATE."contact.tpl.php");
	}
	

}

$pages = new Page();

