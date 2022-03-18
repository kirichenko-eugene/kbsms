<?php
session_start();
unset($_SESSION['welcome']);
unset($_SESSION['codenumber']);
$codeNumber = random_int(1000, 9999);
$_SESSION['codenumber'] = $codeNumber;
require_once  $_SERVER['DOCUMENT_ROOT']."/includes/config.php";
require_once $_SERVER['DOCUMENT_ROOT']."/includes/functions.php";

if(isset($_POST['enter'])) {
	$_SESSION['card'] = htmlspecialchars($_POST['card']);
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Войти в личный кабинет</title>
	<link rel="stylesheet" href="<?=SITE?>css/bootstrap.min.css">
</head>
<body>
	<div class="container">
		<div class="row align-self-center m-1">
			<div class="btn-group-vertical m-2 ml-auto mr-auto w-100">
					<img class="img-fluid ml-auto mr-auto" src="<?=SITE?>img\logo.png" alt="logo">
				</div>
			<div class="col text-center w-100">
				<h3><span class="badge badge-primary">Личный кабинет</span></h3>
			</div>
		</div>
		<div class="row align-self-center m-1">
			<div class="col-12 mx-auto">
				<?php
				$findCard = findCard($_SESSION['card']);
				if(!$findCard) { ?>
					<div class="text-center m-2">
						<p>Данная карта не зарегистрирована</p>
						<button type="button" class="btn btn-secondary" onClick='location.href="<?=SITE?>enter_cabinet/enter.php"'>Вернуться</button>
					</div>
				<?php } else {
					if(isset($_POST['enter'])) {
						// получаем телефон по карте пользователя
						$findCard = findCard($_SESSION['card']);
						foreach ($findCard as $value) {
							$_SESSION['phone'] = $value['phone'];
						}
						// отправляем смс
						if(isset($_SESSION['codenumber'])){
							if(!$_SESSION['verify']) {
								$codeNumber = $_SESSION['codenumber'];
								$Phone = $_SESSION['phone'];
								$Text = "$codeNumber - введите этот код для входа в личный кабинет";
								sendSms($Phone, $Text);
							}
						}
						$_SESSION['verify'] = 1;
					} ?>
					<form id="countdown" method="POST" action="<?=SITE?>enter_cabinet/login_ok.php">
						<h4 class="text-center">Ожидайте <span class="display">60</span> секунд</h4>
						<div class="form-group">
							<label for="code">Введите код из сообщения</label>
							<input type="number" class="form-control" id="code" name="code" placeholder="Код из сообщения" required>
						</div>
						<div class="text-center m-2">
							<button type="button" class="btn btn-secondary" onClick='location.href="<?=SITE?>enter_cabinet/enter.php"'>Вернуться</button>
							<button type="submit" class="btn btn-primary" id="loginOK" name="loginOK">Подтвердить</button>
						</div>
					</form>
				<?php } ?>
			</div>
		</div>
	</div>
	<script>
    (function(d){
        var display = d.querySelector('#countdown .display')
	    var timeLeft = parseInt(display.innerHTML) 
  
        var timer = setInterval(function(){
            if (--timeLeft > 0) { 
                display.innerHTML = timeLeft
            } else {
                d.querySelector('#countdown h4').style.display = 'none' 
                d.querySelector('#countdown .form-group').style.display = 'none' 
                d.querySelector('#countdown #code').style.display = 'none'
                d.querySelector('#loginOK').style.display = 'none' 
                clearInterval(timer) 
            }
        }, 1000)  
    })(document)
</script>
</body>
</html>