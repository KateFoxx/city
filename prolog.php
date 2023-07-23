<?
	session_start();
	//вывод ошибок
	ini_set('display_errors', 1);
	error_reporting(E_ALL);


	//подключаем файл с функциями
	include_once 'functions.php';
	//подключаем файл с константами бд
	include_once 'dataBase/db_conn_define.php';

	spl_autoload_register('autoloadMainClasses');

