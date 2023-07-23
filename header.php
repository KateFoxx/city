<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Game</title>
    <link rel="stylesheet" href="/css/null.css">
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>

<header class="bg">
	<? if (!isset($_SESSION['message']['auth'])): ?>
        <h1>Игра в города</h1>
	<? endif; ?>
	<? if (isset($_SESSION['message']['auth'])): ?>
        <div class="header__inner">
            <span class="header__item">Логин:&nbsp;<?= $_SESSION['user']['login'] ?></span>
            <span class="header__item">Победы:&nbsp;<?= ($_SESSION['user']['winner']) ? $_SESSION['user']['winner']
					: 0; ?></span>
            <span class="header__item">Поражения:&nbsp;<?= ($_SESSION['user']['loss']) ? $_SESSION['user']['loss']
					: 0; ?></span>
            <span class="header__item">Лучший результат:&nbsp;<?= $_SESSION['user']['point']; ?></span>
            <span class="header__item">Очки:&nbsp;<?= $_SESSION['point']; ?></span>
            <a href="/exit.php" class="header__item">Выход</a>
        </div>
	<? endif; ?>
</header>
<div class="bg-body active"></div>
<div class="bg-body_next"></div>
<div class="container">