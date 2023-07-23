<?
	include_once '../prolog.php';
	include_once 'cities.php';
	include_once 'game.php';
	include_once '../header.php';

?>
<div class="city-wrap">
    <div class="city">
        <div class="board">
            <div class="wrap">
				<? if (isset($sayGame)): ?>
                    <div class="comp"><?= $sayGame; ?></div>
				<? endif; ?>
				<? if ($_SESSION['newGame'] && isset($cityGame)): ?>
                    <div class="comp"><?= $cityGame; ?></div>
				<? endif; ?>
            </div>

            <div class="player wrap">
				<? if ($_SESSION['newGame']): ?>
                    <form class="player__city" action="" method="POST">
                        <div>
                            <label class="player__city-label">Твой город</label>
                            <input autofocus type="text" name="city" placeholder="Введи свой город">
                        </div>
                        <button class="btn" type="submit">Отправить город</button>
                    </form>


                    <form class="player__city" action="" method="POST">
                        <input class="player__city-check" name="luzer" type="hidden" value="Y">
                        <button class="btn" type="submit">Cдаюсь</button>
                    </form>
				<? endif; ?>

				<? if (!$_SESSION['newGame']): ?>
                    <form class="player__city" action="" method="POST">
                        <input class="player__city-check" name="endGame" type="hidden" value="Y">
                        <button class="btn" type="submit" style="margin-bottom: 0;">Новая игра</button>
                    </form>
				<? endif; ?>
            </div>

            <div class="wrap">
                <div class="player__city-label">Счет</div>
                <div class="score">
                    <span class="score__left">Игрок</span>
                    <span class="score__right">Компьютер</span>
                    <div class="score__point"><?= $_SESSION['winnerUser']; ?></div>
                    <span>:</span>
                    <div class="score__point"><?= $_SESSION['winnerGame']; ?></div>
                    <div class="score-wrap">
						<? switch ($_SESSION['winnerGame']) {
							case 0:
								$imgUser = '/img/vis1.jpg';
								break;
							case 1:
								$imgUser = '/img/vis2.jpg';
								break;
							case 2:
								$imgUser = '/img/vis3.jpg';
								break;
							case 3:
								$imgUser = '/img/vis4.jpg';
								break;
						} ?>
						<? switch ($_SESSION['winnerUser']) {
							case 0:
								$imgGame = '/img/vis1.jpg';
								break;
							case 1:
								$imgGame = '/img/vis2.jpg';
								break;
							case 2:
								$imgGame = '/img/vis3.jpg';
								break;
							case 3:
								$imgGame = '/img/vis4.jpg';
								break;
						} ?>
                        <img src="<?= $imgUser ?>" alt="">
                        <img src="<?= $imgGame ?>" alt="">


                    </div>
                </div>
            </div>
        </div>

        <div class="history-wrap">


            <div class="history wrap">
                <div class="history__title">История игры</div>
				<? if (isset($_SESSION['citiesUse'])): ?>

					<? foreach ($_SESSION['citiesUse'] as $key => $item): ?>
                        <span class="<?= ($key % 2 == 0) ? 'history__comp' : 'history__user'; ?>"><?= $item ?></span>
					<? endforeach; ?>
				<? endif; ?>
            </div>
        </div>
    </div>
</div>

<? include_once '../footer.php'; ?>




