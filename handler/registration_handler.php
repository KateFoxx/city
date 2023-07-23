<?php
	include_once '../prolog.php';

	use handler\Registration;
	use dataBase\Mysql;

	// если нет логина
	if (empty($_POST['login'])) {
		redirect(['error' => 'Введите логин'], 'registration');
	}
	// если нет логина
	if (empty($_POST['password'])) {
		redirect(['error' => 'Введите пароль'], 'registration');
	}
	if (empty($_POST['repassword'])) {
		redirect(['error' => 'Повторите пароль'], 'registration');
	}
	//если пароль не равен повтору пароля
	if ($_POST['password'] != $_POST['repassword']) {
		redirect(['error' => 'Пароли не совпадают'], 'registration');
	}
	//объект бд
	$db = new Mysql(HOST, LOGIN, PASSWORD, DB_NAME);
	//объект регистрации
	$new_user = new Registration();

	//если существует такой пользователь то вывести сообщение
	if ($new_user->checkUserLogin($db)) {
		//устагнавливаем в сессию ошибку и пренаправляем на эту же страницу
		redirect(['error' => 'Такой пользователь уже существует'], 'registration');
	}
	//сохранение пользователя
	if ($new_user->save($db)) {
		//устагнавливаем в сессию ОК и пренаправляем на авторизацию
		redirect(['ok' => 'Ура! Регистрация прошла успешно, теперь авторизуйся)))']);
	} else {
		//ошибка сохранения
		//устагнавливаем в сессию ошибку и пренаправляем на эту же страницу
		redirect(['error' => 'Что-то пошло не так((('], 'registration');
	}
