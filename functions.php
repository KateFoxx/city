<?php
	function debug($param) {
		echo "<pre style='padding: 10px; background: rgba(0,0,0,.2); border: 1px solid black; color=black; font-size: 16px; line-height: 120%'>";
		var_dump($param);
		echo "</pre>";
	}

	//редирект с соххранением сообщенияя в сессии
	function redirect($arg, $redirect = '') {
		$_SESSION['message'] = $arg;
		header('Location:/' . $redirect);
		die();
	}

	//сравнение городов
	function compareString($city1, $city2) {
		$arrExclude = ['ь', 'ъ', 'ы'];
		//получаем последняя буква города
		$city      = trim($city1);                     //обрезаем пробелы
		$arrLetter = mb_str_split($city);              //разбиваем слово на массив букв
		$letter    = $arrLetter[count($arrLetter) - 1];//получаем последний элемент массива
		//проверяем что была строка без скобок
		if ($letter == ')') {
			$arrString = explode(' ', $city);
			unset($arrString[count($arrString) - 1]);
			$city      = implode($arrString);
			$arrLetter = mb_str_split($city);              //разбиваем слово на массив букв
			$letter    = $arrLetter[count($arrLetter) - 1];//получаем последний элемент массива
		}
		//проверяем что б  последняя буква не заканчивалась на массив исключение $arrExclude
		if (in_array($letter, $arrExclude)) {
			$letter = $arrLetter[count($arrLetter) - 2];
		}


		//получаем первую букву города
		$letterArray = trim($city2);
		$letterArray = mb_substr($letterArray, 0, 1);
		return (mb_strtoupper($letter) == mb_strtoupper($letterArray));
	}

	function userUpdatePoint($point,$db) {
		$db->updateSql('user', ['point' => $point], ['login' => $_SESSION['user']['login']]);
		$_SESSION['user']['point'] = $point;
	}

	//автозагрузка классов
	function autoloadMainClasses($class_name) {
		$class_name = str_replace('\\', '/', $class_name);
		include_once $class_name . '.php';
	}


