<?php


	namespace handler;


	class Auth {
		public $login;
		public $password;

		public function __construct() {
			$this->login = $_POST['login'] ?? null;;
			$this->password = md5($_POST['password']) ?? null;;
		}

		public function authenticate($db) {
			if (!$this->login && !$this->password) {
				return false;
			}
			if ($db->select("user", ['login' => $this->login, 'password' => $this->password])) {
				return $db->select("user", ['login' => $this->login, 'password' => $this->password]);
			}
			return false;
		}
	}

