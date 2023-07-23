<?php


	namespace dataBase;

	class Mysql {
		private $connection = false;

		//создаем подключение к бд
		public function __construct($host, $user, $password, $db, $port = 3306) {
			$this->connection = mysqli_connect($host, $user, $password, $db);
		}

		public function getArraySql(array $arr, string $glue) {
			$condition = [];

			foreach ($arr as $key => $value) {
				$condition[] = $key . '= "' . $this->escape($value) . '"';
			}
			return implode($glue, $condition);
		}

		private function escape($value) {
			return mysqli_real_escape_string($this->connection, $value);
		}

		protected function getWhere(array $where = []) {
			$whereStr = '';
			if (!empty($where)) {
				$whereStr = ' WHERE ' . implode(' AND ', $this->getConditions($where));
			}
			return $whereStr;
		}

		protected function getConditions(array $dataset) {
			$condition = [];
			foreach ($dataset as $field => $value) {
				$condition[] = $field . " = '" . $this->escape($value) . "'";
			}
			return $condition;
		}

		//выборка из бд
		public function querySelect($sql) {

			$result = mysqli_query($this->connection, $sql);
			if (!$result) {
				return false;
			}

			$out = [];
			while ($row = mysqli_fetch_assoc($result)) {
				$out[] = $row;
			}
			return $out;
		}


		public function select($tableName, $where = []) {
			////SELECT * FROM users WHERE login='ivanov' AND password='1111'
			//$db->select("users", ['login' => $this->login, 'password' => $this->password])
			return $this->querySelect('SELECT * FROM ' . $tableName . $this->getWhere($where));
		}

		//вставка в бд
		public function insert($tableName, $data) {
			//INSERT INTO users (login,password) VALUES ('AAAA', '5f4dcc3b5aa765d61d8327deb882cf99')
			/*	$db->insert('users', [
				'login'    => 'AAAA',
				'password' => md5('password'),
			]);*/
			$sql     = 'INSERT INTO ' . $tableName;
			$columns = [];
			$values  = [];
			foreach ($data as $field => $value) {
				$columns[] = $field;
				$values[]  = $this->escape($value);
			}
			$sql .= ' (' . implode(',', $columns) . ") VALUES ('" . implode("', '", $values) . "')";
			return mysqli_query($this->connection, $sql);
		}

		//вставка в бд
		public function deleteSql(string $tableName, array $data) {
			//DELETE FROM  users WHERE id=26 AND login=555 AND password=321325135
			$sql       = 'DELETE FROM  ' . $tableName . ' WHERE ';
			$condition = [];
			foreach ($data as $key => $value) {
				$condition[] = $key . '= "' . $this->escape($value) . '"';
			}
			$sql .= implode(' AND ', $condition);
			echo $sql;
			return mysqli_query($this->connection, $sql);
		}

		//обновление в бд
		public function updateSql(string $tableName, array $set, array $where = []) {
			//UPDATE  users SET login= "lena" , password= "866786" WHERE id= "21"
			$sql = 'UPDATE  ' . $tableName;
			$sql .= ' SET ' . $this->getArraySql($set, ' , ');
			if (!empty($where)) {
				$sql .= ' WHERE ' . $this->getArraySql($where, ' AND ');
			}
			return mysqli_query($this->connection, $sql);
		}
	}