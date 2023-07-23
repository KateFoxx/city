<?

	use \dataBase\Mysql;

	//проверяем авторизован ли пользователь, если нет то отправляем на страницу игры
	if (!isset($_SESSION['message']['auth']) && $_SESSION['message']['auth'] != 'Y') {
		header('Location:/');
	}

	//кол-во раундов
	$countGame = 3;
	$point     = 10;
	//если начало игры устанавливаенм счет по нулям
	if (!isset($_SESSION['winnerGame'])) {
		$_SESSION['winnerGame'] = 0;
	}
	if (!isset($_SESSION['winnerUser'])) {
		$_SESSION['winnerUser'] = 0;
	}
	if (!isset($_SESSION['newGame'])) {
		//флаг новой игры
		$_SESSION['newGame'] = true;
	}

	if ($_SESSION['user']['point'] == null) {
		//если первая игра то null устанавливаем 0
		$_SESSION['user']['point'] = 0;
	}


	//заканчиваем текущий счет и начинаем следущую часть при отправе endGame
	if (isset($_POST['endGame'])) {
		$_SESSION['winnerGame'] = 0;
		$_SESSION['winnerUser'] = 0;
		$_SESSION['newGame']    = true;
		$sayGame                = 'Ну что ж приступим';
		$_SESSION['point']      = 0;
	}


	//проверяем пропускает ли игрок ход(отмеченый чекбокс)
	if (isset($_POST['luzer']) && $_SESSION['winnerGame'] < $countGame) {
		//обнуляем массив городов
		$_SESSION['citiesUse'] = [];
		//обработка счета $arrCities
		$_SESSION['winnerGame']++;
		//если набрал больше очков то обновляем очки в бд
		if ($_SESSION['user']['point'] < $_SESSION['point']) {
			userUpdatePoint($_SESSION['point'], new Mysql(HOST, LOGIN, PASSWORD, DB_NAME));
		}
		//победа игры
		if ($_SESSION['winnerGame'] == $countGame) {
			//флаг новой игры
			$_SESSION['newGame']   = false;
			$_SESSION['citiesUse'] = [];
			$sayGame               = 'Возможно тебе повезет в следующий раз))';


			$db                       = new Mysql(HOST, LOGIN, PASSWORD, DB_NAME);
			$_SESSION['user']['loss'] = ($_SESSION['user']['loss'] != null) ? $_SESSION['user']['loss'] + 1 : '1';
			$db->updateSql('user', ['loss' => $_SESSION['user']['loss']], ['login' => $_SESSION['user']['login']]);
		}

	}


	//старт новой игры или после нажатия endGame
	if (!empty($_SESSION['citiesUse'])) {

		//проверка приходит ли значение поля город либо отмеченый чекбокс
		if (!empty($_POST['city'])) {

			//обработка города
			//проверяем существует ли город игрока в масивее использованых городов
			$cityUser = trim($_POST['city']);
			//делаем первую букву заглавной
			$cityUser    = $arrLetter = mb_str_split($cityUser);
			$cityUser[0] = mb_strtoupper($cityUser[0]);
			$cityUser    = implode($cityUser);

			//проверка на повтор слова
			if (in_array($cityUser, $_SESSION['citiesUse'])) {
				//если да то просим ввести другое занчение
				$cityGame = 'Этот город уже был.';
			} else {
				//последний элемент вмассиве(тот который ввыыел компьютер)
				$lastCityInArray
					= $_SESSION['citiesUse'][count($_SESSION['citiesUse']) - 1];
				//делаем запрос на яндекс
				$ch
					= curl_init('https://geocode-maps.yandex.ru/1.x/?apikey=e0e7127e-0b84-4b55-8f2b-f83683898471&format=json&geocode=' . urlencode($_POST['city']));
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($ch, CURLOPT_HEADER, false);
				$res = curl_exec($ch);
				curl_close($ch);

				$res = json_decode($res, true);
				//проверяем существует ли такой город
				if ($res["response"]["GeoObjectCollection"]["metaDataProperty"]["GeocoderResponseMetaData"]["found"] != 0) {
					//проверка на правильность город юзера
					if (compareString($lastCityInArray, $_POST['city'])) {
						//сохраняем город игрока в массив $_SESSION['citiesUse']
						$_SESSION['citiesUse'][] = $cityUser;
						$_SESSION['point']       = $_SESSION['point'] + $point;
						//логика выбора города для game
						$countArrBefore = count($_SESSION['citiesUse']);
						//проходим по массиву городов
						foreach ($arrCities as $item) {
							if (compareString($_POST['city'], $item)) {
								//если есть город в $_SESSION['citiesUse'] то пропустить эту итерацию
								if (in_array($item, $_SESSION['citiesUse'])) {
									continue;
								} else {
									//если нет то сохраняем в массив $_SESSION['citiesUse']
									$cityGame                = $item;
									$_SESSION['citiesUse'][] = $item;
									break;//прекращаем проход по массиву
								}
							}
						}
						//если кол-во элементов массива до цикла равно кол-ву после то Game не нашел подходяшийи город и он проиграл
						if ($countArrBefore == count($_SESSION['citiesUse'])) {
							//обнуляем массив городов
							$_SESSION['citiesUse'] = [];
							//обработка счета $arrCities
							$_SESSION['winnerUser']++;
							$sayGame = 'Этот раунд я проиграл';
							if ($_SESSION['winnerUser'] == 2) {
								$sayGame = 'Что-то не везёт сегодня';
							}
							//если набрал больше очков то обновляем очки в бд
							if ($_SESSION['user']['point'] < $_SESSION['point']) {
								userUpdatePoint($_SESSION['point'], new Mysql(HOST, LOGIN, PASSWORD, DB_NAME));
							}
							$cityGame                = $arrCities[rand(0, count($arrCities) - 1)];
							$_SESSION['citiesUse'][] = $cityGame;
							//проигрыш игры окнчательный
							if ($_SESSION['winnerUser'] >= $countGame) {
								//флаг новой игры
								$_SESSION['newGame']        = false;
								$cityGame                   = '';
								$_SESSION['citiesUse']      = [];
								$sayGame                    = 'Ё-моё я проиграл(((';
								$cityGame                   = "(((^:^)))";
								$db                         = new Mysql(HOST, LOGIN, PASSWORD, DB_NAME);
								$_SESSION['user']['winner'] = ($_SESSION['user']['winner'] != null)
									? $_SESSION['user']['winner'] + 1 : '1';
								$db->updateSql('user', ['winner' => $_SESSION['user']['winner']], ['login' => $_SESSION['user']['login']]);
							}
						}

					} else {
						$sayGame = 'Город введен не верно';
					}
				} else {
					$sayGame = '^:^ Такого города не существует ^:^';
				}


			}


		} else {
			//если ничего не пришло с формы
			$sayGame = 'Введите город';
		}
	} elseif ($_SESSION['winnerUser'] == $countGame || $_SESSION['winnerGame'] == $countGame) {
		$sayGame = 'Нажми кнопку "Новая игра"';
	} else {
		$cityGame                = $arrCities[rand(0, count($arrCities) - 1)];
		$_SESSION['citiesUse'][] = $cityGame;
		$sayGame                 = (isset($_POST['luzer'])) ? 'Никогда не сдавайся' : 'Ну что ж приступим';

	}
?>