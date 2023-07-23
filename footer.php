</div>
<footer class="bg">
    <div class="container">
        Итоговая работа Лепёшкиной Екатерины
    </div>
</footer>
<script>
    var bgIndex = 0;
    var bgElement = document.querySelector('.bg-body ');
    var bgElementNext = document.querySelector('.bg-body_next');

    function bgChange() {
        bgIndex++;
        if (bgIndex > 10) {
            bgIndex = 1;
        }
        if (bgIndex % 2 != 0) {
            bgElement.classList.add('active');
            bgElementNext.classList.remove('active');
            /*    bgElement.style.backgroundImage = `url(../img/bg_${bgIndex}.jpg)`;*/
            setTimeout(function () {
                if (bgIndex > 10) {
                    bgElementNext.style.backgroundImage = `url(../img/bg_1.jpg)`;
                } else {
                    bgElementNext.style.backgroundImage = `url(../img/bg_${bgIndex + 1}.jpg)`;
                }
            }, 1000)

        }
        if (bgIndex % 2 == 0) {
            bgElementNext.classList.add('active');
            bgElement.classList.remove('active');
            /*   bgElementNext.style.backgroundImage = `url(../img/bg_${bgIndex}.jpg)`;*/
            setTimeout(function () {
                if (bgIndex > 10) {
                    bgElement.style.backgroundImage = `url(../img/bg_1.jpg)`;
                } else {
                    bgElement.style.backgroundImage = `url(../img/bg_${bgIndex + 1}.jpg)`;
                }
            }, 1000)
        }

    }

    bgChange();
    window.setInterval(bgChange, 10000);
</script>
</body>

</html>
