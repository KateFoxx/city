<?php


	namespace handler;


	class Registration {
		protected $db;
		public $login;
		public $password;
		public $date;

		public function __construct() {
			$this->login    = $_POST['login'] ?? null;
			$this->password = md5($_POST['password']) ?? null;
		}

		public function save($db) {
			$save = $db->insert('user', [
				'login'    => $this->login,
				'password' => $this->password,
			]);
			return ($save) ? true : false;
		}

		public function checkUserLogin($db) {
			$check = $db->select('user', ['login' => $this->login]);
			return ($check && !empty($check)) ? true : false;

		}


	}