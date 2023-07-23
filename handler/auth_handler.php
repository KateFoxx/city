<?php
	include_once '../prolog.php';

	use  \handler\Auth;
	use \dataBase\Mysql;

	// если нет логина
	if (empty($_POST['login'])) {
		redirect(['error' => 'Введите логин']);
	}
	// если нет пароля
	if (empty($_POST['password'])) {
		redirect(['error' => 'Введите пароль']);
	}

	//щбъект автоизации
	$db = new Mysql(HOST, LOGIN, PASSWORD, DB_NAME);
	//объект авторизации
	$new_user = new Auth();

	if ($new_user->authenticate($db)) {
		//удачная аутентификация
		//устагнавливаемв  сессию 'auth' => 'Y' и пренаправляем на игру
		$_SESSION['user']=$new_user->authenticate($db)[0];
		$_SESSION['point']=0;
		redirect(['auth' => 'Y'], 'game/');
	} else {
		//неудачная аутентификация
		//устагнавливаем в сессию ошибку и пренаправляем на эту же страницу
		redirect(['error' => 'Не верный логин или пароль']);
	}