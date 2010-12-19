<?php
/**
 * @file: Login.Controller.php
 * @type: Controller
 * @description: Login контролерът се грижи за автентикацията на потребителите, в системата
 * @license: GNU General Public License v2
**/

class Members{
	
	
	/**
	* @name: __call
	* @description: Тази функция се изпълнява при извикване на несъществуваща
	* функция в този клас. В случая при извикването й ще се листва информация за потърсения потребител
	**/
	function __call($method, $arguments){
		//Извикваме нужните ни класове
		global $db, $filter, $pages;
		
		//Филтрираме подадения аргумент
		$student = $filter->input($method);
		
		//Извличаме потребителската информация от базата данни
		$userInfo = $db->getUserInfo($student);
		
		//Ако не съществува подобен потребител - пренасочваме към 404 страницата
		if(mysql_numrows($userInfo) != 1){
			$pages->Error404();
		}
		//Заглавие на страницата
		$title = "Информация за {$student} | ". SITE_NAME;
		
		//Визуализираме tpl файла
		require_once(TEMPLATE."userProfile.tpl.php");
		
	}
	
	/**
	* @name: __construct
	* @description: Тази функция се изпълнява при всяко извикване на който и да е обект от този клас
	*/
	function __construct(){
	global $db, $breadcrumbs;
	
	//Добавяме пътечката
	$breadcrumbs["Login"] = array( id=>"Login", parent=>"home", title=>"Вход в системата", url=>"Members/Login/" );
	$breadcrumbs["Register"] = array( id=>"Register", parent=>"home", title=>"Регистрация", url=>"" );
	$breadcrumbs["forgottenPassword"] = array( id=>"forgottenPassword", parent=>"Login", title=>"Забравена парола", url=>"" );
	$breadcrumbs["editProfile"] = array( id=>"editProfile", parent=>"home", title=>"Редакция на профила", url=>"Members/editProfile/" );
	$breadcrumbs["changePassword"] = array( id=>"changePassword", parent=>"editProfile", title=>"Смяна на паролата", url=>"" );
	$breadcrumbs["changeAvatar"] = array( id=>"changeAvatar", parent=>"editProfile", title=>"Смяна на аватара", url=>"" );
	
	}
	/**
	 * @name: Register
	 * @description: Функция осъществяващ регистрацията на нови потребители
	 **/
	public function Register(){
		if($this->isLogged() != True){
		
		//Извикваме нужните ни класове
		global $db, $filter, $scf4u;;
		
		
		//Нулираме си променливите
		$message = "";
		
		//Ако е изпратен формуляр
		if(isset($_POST['sent'])){
			//Филтрираме подадените променливи
			$username = $filter->input($_POST['username'], 35);
			$password0 = $filter->input($_POST['password0']);
			$password1 = $filter->input($_POST['password1']);
			$email = $filter->input($_POST['email'], 64);
			$realname = $filter->input($_POST['realname'], 64);
			$city = $filter->input($_POST['c']);
			$school = $filter->input($_POST['school']);

			
			//Ако има незапълнени задължителни полета
			if(!$username || !$password0 || !$password1 || !$email){
				$message = "Не сте попълнили всички задължителни полета!";
			}
			else{
				//Проверки за нередности:
				
				//Проверяваме, дали вече има регистрирано такова потребителско име
				if($db->userExist($username) > 0){
					$message = "Вече съществува потребител, с такова потребителско име!";
				}
				//Проверяваме, за невалиден e-mail адрес
				else if($scf4u->validEmail($email) == false){
					$message = "Въвели сте невалиден email адрес!";
				}
				//Проверяваме за вече използван e-mail адрес
				else if($db->emailExist($email) > 0){
					$message = "Въведеният e-mail вече се използва от друг потребител!";
				}
				//Проверяваме за несъвпадащи пароли
				else if($password0 != $password1){
					$message = "Въведените от вас пароли НЕ съвпадат!";
				}
				//Проверяваме дали паролата не е по-къса от 6 символа
				else if(strlen($password0) < 6){
					$message = "Въведената парола е по-къса от 6 символа!";
				}
				//Ако името е въведено с латински символи
				else if($scf4u->cyrillicName($realname) == false){
					$message = "Въвели сте името си на латиница!";
				}
				//Ако всичко е наред
				else {
					$db->addUser($username, $password0, $email, $realname = null, $city = null, $school = null);
					header("Location: " . SITE_URL . "Pages/registeredUser/");
				}
			}
		}
		
		//Ако НЕ е изпратен формуляр
		//Заглавието на страницата
		$title = "Регистрация | " . SITE_NAME;
		
		//Визуализираме формуляра
		require_once(TEMPLATE."register.tpl.php");
		}
		else{
			header("Location: ".SITE_URL."");
		}
		
	}
	
	
	/**
	* @name: Login
	* @type: Public
	* @description: Функцията осъществява входа на потребителя в системата
	**/
	public function Login(){
       if($this->isLogged() != True){
		//Извикваме си нужните ни класове
		global $db, $filter, $scf4u;
		
		//Нулираме си променливите
		$message == "";
		
		//Ако е изпратен формуляр
		if(isset($_POST['sent']) && $_POST['sent'] == 1){
			//Филтрираме си подадените ни променливи
			$username = $filter->input($_POST['username'], 35);
			$password = $filter->input($_POST['password']);
			$referral = $filter->input($_POST['referral']);
			$cookie = $filter->input($_POST['rememberme'], 1);
			//Ако има незапълнени задължителни полета
			if(!$username || !$password){
				$message = "Не сте попълнили всички задължителни полета!";
			}
			else{
				//Проверяваме достоверността на изпратените
				//Потребителско име и парола
				if($db->Login($username, $password) == 1){
					$logged = true;
					//При успех, създаваме сесията
					$this->createSession($username, $cookie);
					if($referral != SITE_URL OR $referral != SITE_URL."/Members/Login/"){
						header("Location: ". $referral);
					}
					else{
						header("Location: ".SITE_URL);
					}
				}
				else{
					$message = "Грешно потребителско име или парола!";
					$logged= false;
				}
			}
			
			
			
			
			
		}

			//Заглавие на страницата
			$title = "Вход в системата | ". SITE_NAME;

			//Визуализираме формата
			require_once(TEMPLATE."login.tpl.php");
		

		}
		else{
			header("Location: ".SITE_URL);
		}
	}
	
	/**
	* @name: createSession
	* @type: Private
	* @description: Функцията създава сесия, след влизането в сисмтеата
	**/
	private function createSession($username, $cookie){
		//Извикваме си нужните ни класове
		global $filter, $scf4u, $db;
		
		//Филтрираме си подадената ни променлива
		$username = $filter->input($username);
		
		//Проверяваме, за вече съществуваща сесия или бисквитка и ги унищожаваме при наличие
		if(isset($_SESSION['logged_student'])){
			session_destroy();
			
		}
		if(isset($_COOKIE['rememberme'])){
			$_COOKIE['rememberme'] = null;
		}
		//Създаваме потребителската сесия
		$_SESSION['logged_student'] = $username;
		
		if($cookie == 1){
			$value = $scf4u->hashString($username . time());
			setcookie("rememberme", $value, time()+2678400, "/", DOMAIN);
			$db->createCookie($username, $value);
		}
	}
	
	/**
	* @name: isLogged
	* @type: Public
	* @description: Функцията прави проверка дали потребителят е влезнал в системата.
	* Връща True ако е така, в противен случай - False
	**/
	public function isLogged(){
		global $db, $filter;
		if( !isset($_SESSION['logged_student']) && isset($_COOKIE['rememberme']) ) {
			$result = $db->getCookie($filter->decode($_COOKIE['rememberme']));
			if(mysql_num_rows($result)) {
				$user = mysql_fetch_assoc($result);
				$_SESSION['logged_student'] = $filter->decode($user['student']);
				return True;
			}
		}
		else{
			//Ако има създадена сесиина променлива и тя не е празна, връщаме True, в противен случай - False
			return (isset($_SESSION['logged_student']) && $_SESSION['logged_student'] != "");
		}
	}
	
	/**
	* @name: isAdmin
	* @type: Public
	* @description: Функцията прави проверка дали потребителят има администраторски права.
	* Връща True ако е така, в противен случай - False
	**/
	public function isAdmin($username){
		//Извикваме си нужните ни класове
		global $db, $filter;
		
		//Филтрираме подадената ни променлива
		$username = $filter->input($username);
		
		//Ако има потребителска сесия
		if($this->isLogged()){
			//Ако е адмнистратор, връщаме True
			if($db->isAdmin($username) == 1){
				return True;
			}
			else{
				//В противен случай връщаме False
				return False;
			}
		}
		else{
			//Ако изобщо няма създадена потребителска сесия, връщаме False
			return False;
		}
	}
	
	/**
	* @name: Logout
	* @type: Public
	* @description: Функцията премахва сесията на потребителя, чрез което осъществява излизането му от системата
	**/
	public function Logout(){
		//Извикваме си нужните ни класове
		global $db;
    
		//Пренасочваме към индекса на StudentX
		header("Location: " . SITE_URL);
		
		//Унищожаваме потребителската сесия, бисквитката и нейния запис в базата данни(ако има такива)
		setcookie("rememberme", 0, time()-3600, "/", DOMAIN);
		$db->dropCookie($this->studentName());
		session_destroy();
		

	}
	
	/**
	* @name: forgottenPassword
	* @type: Public
	* @description: Функцията осигурява възстановяването на забравена парола
	*/
	public function forgottenPassword(){
		if($this->isLogged() != True){
		//Извикваме си нужните ни класове
		global $db, $filter, $scf4u;
		
		//Нулираме си променливите
		$message = "";
		
		//Ако е изпратен формуляр
		if($_POST['sent'] == 1){
			//Филтрираме си подадените ни променливи
			$username = $filter->input($_POST['username'], 35);
			$email = $filter->input($_POST['email']);
			//Ако има незапълнени задължителни полета
			if(!$username || !$email){
				$message = "Не сте попълнили всички задължителни полета!";
			}
			else{
				//Проверяваме достоверността на подадените променливи
				if($db->checkEmail($username, $email) == 1){
					//Генерираме паролата
					$new_pass = $scf4u->generatePassword();
					//Вписваме я в базата данни
					$db->changePassword($username, $new_pass);
					//Изпращаме я на потребителя
					$scf4u->mailPassword($username, $new_pass, $email);
					
					$message = "Вашата нова парола беше изпратена успешно!";
					
					
				}
				else{
					$message = "Потребителското име не съвпада с посочения email!";
				}
					
			
			}
		
		
		}
		
		//Дефинираме заглавието на страницата
		$title = "Забравих си паролата! | ". SITE_NAME ;
		
		//Визуализираме формуляра
		require_once(TEMPLATE . "forgottenPassword.tpl.php");
		}
		else{
			header("Location: ". SITE_URL);
		}
	}
	
	/**
	* @name: studentName
	* @type: Public
	* @description: Връща името на потребителя, ако няма потребителска сесия връща "Гост"
	**/
	public function studentName() {
		//Извикваме си нужните ни класове
		global $filter;
		
		//Проверяваме дали потребителят е логнат
		if($this->isLogged() == True){
			//Ако това е така, връщаме името на потребителя
			return $_SESSION['logged_student'];
		}
		else{
			//Ако ли не - връщаме "Гост"
			return "Гост";
		}
	}
	
	
	/**
	* @name: editProfile
	* @type: Public
	* @description: Функцията осигурява редактиране на профила
	**/
	public function editProfile($username = null) {
		if($this->isLogged() == True){
		//Извикваме нужните ни класове
		global $db, $filter, $scf4u;
		
		//Нулираме си променливите
		$message = "";
		
		//Извикваме си името на потребителя и изтегляме информацията за него
		if($username != null && $this->isAdmin($this->studentName()) == True){

			$student = $filter->input($username);
		}
		else{
			$student = $this->studentName();
		}
		$studentInfo = $db->getUserInfo($student);
		
		//Ако е изпратен формуляр
		if(isset($_POST['sent'])){
			//Филтрираме подадените променливи
			$realname = $filter->input($_POST['realname']);
			$email = $filter->input($_POST['email']);
			$city = $filter->input($_POST['c']);
			$school = $filter->input($_POST['school']);
			
			
			//Проверки за нередности
			//Ако името е въведено с латински символи
			if($scf4u->cyrillicName($realname) == false){
					$message = "Въвели сте името на латиница!";
			}
			//Проверяваме, за невалиден e-mail адрес
			else if($scf4u->validEmail($email) == false){
				$message = "Въвели сте невалиден email адрес!";
			}
			//Проверяваме дали друг не използва посоченият e-mail адрес
			else if($db->numrows("SELECT * FROM `students` WHERE `email` = '{$email}' AND `student` != '{$student}'") > 0){
				$message = "Въведеният e-mail вече се използва от друг потребител!";
			}
			//Ако всичко е наред
			else{
				if($db->editUser($student, $realname, $email, $city, $school)){
				$message = "Профилът беше редактиран успешно!";
				}
			}
			
			
			
		}
		
		
		//Отново извикваме си името на потребителя и изтегляме информацията за него
		//Извикваме си името на потребителя и изтегляме информацията за него
		if($username != null && $this->isAdmin($this->studentName()) == True){
			$student = $filter->input($username);
		}
		else{
			$student = $this->studentName();
		}
		$studentInfo = $db->getUserInfo($student);
		
		//Заглавието на страницата
		$title = "Редакция на профила | " . SITE_NAME;
		
		//Визуализираме формуляра
		require_once(TEMPLATE."editInfo.tpl.php");
		
		}
		else{
			header("Location: " . SITE_URL);
		}
		
	}
	
	/**
	* @name: getProfile
	* @type: Public
	* @description: Функцията извлича профила на даден потребител
	*/
	public function getProfile($student) {
		//Извикваме нужните ни класове
		global $db, $filter, $scf4u;
		
		//Филтрираме си променливите
		$student = $filter->input($student);
		
		//Нулираме си променливите
		$user = array();
		
		//Извличаме от базата данни информацията за потребителя
		return $userInfo = $db->getUserInfo($student);
	}

	/**
	* @name: changePassword
	* @type: Public
	* @description: Функцията осъщестествява смяната на парола на потребителите
	*/
	public function changePassword($username = null) {
		//Извикваме нужните ни класове
		global $db, $filter, $scf4u;

		//Проверяваме дали потребителят е влезнал в акаунта си
		if($this->isLogged() == True){
			if($username != null && $this->isAdmin($this->studentName()) == True){
			$student = $filter->input($username);
			
			}
			else{
				$student = $this->studentName();
			}
			//Проверяваме дали е изпратен формуляр
			if($_POST['sent'] == 1){
				//Филтрираме си подадените ни променливи
				$newpassword = $filter->input($_POST['newpassword0']);
				$newpassword1 = $filter->input($_POST['newpassword1']);
				
				//Проверяваме дали паролите съвпадат
				if($newpassword == $newpassword1) {
					//Вписваме новата парола в базата данни
					$db->changePassword($student, $newpassword);
					$message = "Вашата парола е сменена успешно!";
				}
				else {
					$message = "Въведените пароли не съвпадат!";
				}
			}

			//Заглавие на страницата
			$title = "Смяна на паролата | " . SITE_NAME;

			//Визулаизираме формата
			require_once(TEMPLATE."changePassword.tpl.php");
		}

	}

	/**
	* @name: changeAvatar
	* @type: Public
	* @description: Функцията осъществява качването на аватари от потребителите
	*/
	public function changeAvatar($username = null) {
		//Извикваме си нужните ни класове
		global $db, $filter, $scf4u;

		//Проверяваме дали потребителят е влезнал в акаунта си
		if($this->isLogged() == True) {
			if($username != null && $this->isAdmin($this->studentName()) == True){
			$student = $filter->input($username);

			}
			else{
				$student = $this->studentName();
			}
			//Проверяваме дали е изпратен формуляр
			if($_POST['sent'] == 1){
				foreach($_FILES as $file) {
					if($file['tmp_name'] != "") {
					if(!getimagesize($file['tmp_name'])){
							$message = "Моля, изберете изображение!";
						
					}
					else{
						$nocol = strval(mt_rand());
						$filename = $nocol.basename($file['name']);
						$file_ext = strtolower(substr($file['name'],strrpos($file['name'],".")));
						move_uploaded_file($file['tmp_name'], HTDOCS ."uploads/".$filename)
							or die("не мога да преместя картинката");

						//Преоразмеряваме каченото изображение
						$scf4u->makeAvatar($student, $filename, $file_ext);
						//Изтриваме стария аватар(ако е имало такъв) и записваме в базата данни новия
						if($db->hasAvatar($student) == 1){
							$avatar_ext = $db->getAvatar($student);
							$ext = mysql_fetch_array($avatar_ext);
							
							unlink(HTDOCS . 'avatars/' . $student . $ext[0]);
						}
						$db->changeAvatar($student, "1", $file_ext);
						//Изтриваме файла от временната директория
						unlink(HTDOCS . 'uploads/' . $filename);
						$message = "Аватарът беше променен успешно!";
						}
					}
			}
	
			}
		}
	$title = "Промяна на аватар | ". SITE_NAME;

	require_once(TEMPLATE . "changeAvatar.tpl.php");
	}
	
	/**
	* @name: dropAvatar
	* @type: Public
	* @description: Функцията осъществява изтриването на аватари от потребителите
	*/
	public function dropAvatar($username = null) {
		//Извикваме си нужните ни класове
		global $db, $filter;

		//Проверяваме дали потребителят е влезнал в акаунта си
		if($this->isLogged() == True) {
			if($username != null && $this->isAdmin($this->studentName()) == True){
			$student = $filter->input($username);
			}
			else{
				$student = $this->studentName();
			}
			if($db->hasAvatar($student) == 1){
				$avatar_ext = $db->getAvatar($student);
				$ext = mysql_fetch_array($avatar_ext);
					
				unlink(HTDOCS . 'avatars/' . $student . $ext[0]);
			}
			$db->dropAvatar($student);
		}
		header("Location: ".$this->changeAvatar());
		
	}
	
	/**
	* @name: updateVisitors
	* @type: Public
	* @description: Класът записва всяко посещение на която и да е страница от портала
	**/
	public function updateVisitors(){
		//Извикваме си нужните ни класове
		global $db, $filter;
		
		$ip = $filter->input($_SERVER['REMOTE_ADDR']);
		$referer = $filter->input($_SERVER['HTTP_REFERER']);
		$useragent = $filter->input($_SERVER['HTTP_USER_AGENT']);
		$current = $filter->input($_SERVER["REQUEST_URI"]);
		
		$db->updateVisitors($ip, $referer, $useragent, $current);
		
	}
	
	/**
	* @name: Solved
	* @type: Public
	* @description: Функцията извлича и показва резултатите от държаните тестове
	**/
	public function Solved(){
		//Извикваме си нужните ни класове
		global $db, $filter;
		
		$solved = $db->Solved($this->studentName());
		
		$title = "Решените тестове | ".SITE_NAME;
		require_once(TEMPLATE . "Solved.tpl.php");
		
	}
}


//Инициалираме класа
$members = new Members;