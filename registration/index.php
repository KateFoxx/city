<? include_once '../prolog.php'; ?>
<? include_once '../header.php'; ?>
<?
	//проверяем авторизован ли пользователь, если да то отправляем га страницу игры
	if (isset($_SESSION['message']['auth']) && $_SESSION['message']['auth'] == 'Y') {
		header('Location:/game/');
	}
?>

<? //форма регистрации?>
<div class="form-wrap">
    <form method="post" class="form bg" action="/handler/registration_handler.php">

        <div class="input-wrap">
            <label for="login">Введите логин</label>
            <input id="login" name="login" type="text" placeholder="login">
        </div>
        <div class="input-wrap">
            <label for="password">Введите пароль</label>
            <input id="password" name="password" type="password" placeholder="******">
        </div>
        <div class="input-wrap">
            <label for="repassword">Повторите пароль</label>
            <input id="'repassword" name="repassword" type="password" placeholder="******">
        </div>
		<? if (isset($_SESSION['message']['error'])): ?>
            <span class="error"><?= $_SESSION['message']['error']; ?></span>
		<? endif; ?>
        <input type="submit" value="Зарегестрироваться" class="btn">

        <a href="/" class="btn">Авторизация</a><br><br>
    </form>
</div>

<? include_once '../footer.php'; ?>



