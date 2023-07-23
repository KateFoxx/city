<? include_once 'prolog.php'; ?>
<? include_once 'header.php'; ?>
<?
	//проверяем авторизован ли пользователь, если да то отправляем га страницу игры
	if (isset($_SESSION['message']['auth']) && $_SESSION['message']['auth'] == 'Y') {
		header('Location:/game/');
	}
?>

<?
	//если регистрация успешна выводим сообщение
	if (isset($_SESSION['message']['ok'])): ?>
        <h1><?= $_SESSION['message']['ok']; ?></h1>
	<? endif; ?>

<? //форма автооризации?>
<div class="form-wrap">
    <form method="post" class="form bg" action="/handler/auth_handler.php">
        <div class="input-wrap">
            <label for="login">Введите логин</label>
            <input id="login" name="login" type="text" placeholder="login">
        </div>
        <div class="input-wrap">
            <label for="password">Введите пароль</label>
            <input id="password" name="password" type="password" placeholder="password">
        </div>
        	<? //если регистрация не успешна выводим сообщение
			if (isset($_SESSION['message']['error'])): ?>
                <span class="error"><?= $_SESSION['message']['error']; ?></span>
			<? endif; ?>
        <input type="submit" class="btn" value="Авторизоваться">

        <a href="/registration" class="btn">Регистрация</a>
    </form>
</div>


<? include_once 'footer.php'; ?>



