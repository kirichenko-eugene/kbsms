<?php
session_start();
unset($_SESSION['codenumber']);
$codeNumber = random_int(1000, 9999);
$_SESSION['codenumber'] = $codeNumber;
require_once $_SERVER['DOCUMENT_ROOT']."/includes/config.php";
require_once $_SERVER['DOCUMENT_ROOT']."/includes/functions.php";

if(isset($_POST['registration'])) {
	$_SESSION['card'] = htmlspecialchars($_POST['card']);
	$_SESSION['surname'] = htmlspecialchars($_POST['surname']);
	$_SESSION['name'] = htmlspecialchars($_POST['name']);
	$_SESSION['patronymic'] = htmlspecialchars($_POST['patronymic']);
	$_SESSION['birth'] = htmlspecialchars($_POST['birth']);
	$_SESSION['sex'] = htmlspecialchars($_POST['sex']);
	$_SESSION['marrital'] = htmlspecialchars($_POST['marrital']);

	$preparePhone = maskPhone(htmlspecialchars($_POST['phone']));
	if($preparePhone) {
		$_SESSION['phone'] = $preparePhone;
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Подтверждение регистрации</title>
	<link rel="stylesheet" href="<?=SITE?>css/bootstrap.min.css">
</head>
<body>
	<div class="container">
		<div class="row align-self-center m-1">
			<div class="btn-group-vertical m-2 ml-auto mr-auto w-100">
					<img class="img-fluid ml-auto mr-auto" src="<?=SITE?>img\logo.png" alt="logo">
				</div>
			<div class="col text-center w-100">
				<h3><span class="badge badge-primary">Регистрация</span></h3>
			</div>
		</div>
		<div class="row align-self-center m-1">
			<div class="col-12 mx-auto">
				<?php
				$findCard = findCard($_SESSION['card']);
				$findPhone = findPhone($_SESSION['phone']);
				if($findCard) { ?>
					<div class="text-center m-2">
						<p>Данная карта уже используется</p>
						<button type="button" class="btn btn-secondary" onClick='location.href="<?=SITE?>enter_cabinet/enter.php"'>Вернуться</button>
					</div>
				<?php } elseif ($findPhone) { ?>
					<div class="text-center m-2">
						<p>Данный номер телефона уже используется</p>
						<button type="button" class="btn btn-secondary" onClick='location.href="<?=SITE?>enter_cabinet/enter.php"'>Вернуться</button>
					</div>
				<?php } elseif (!$_SESSION['phone']) { ?>
					<div class="text-center m-2">
						<p>Телефон имеет неверный формат</p>
						<button type="button" class="btn btn-secondary" onClick='location.href="<?=SITE?>enter_cabinet/enter.php"'>Вернуться</button>
					</div>
				<?php } else {
					if(isset($_POST['registration'])) {
						if(isset($_SESSION['codenumber'])){
							if($_SESSION['verify'] != 1) {
								$codeNumber = $_SESSION['codenumber'];
								$Phone = $_SESSION['phone'];
								$Text = "$codeNumber - введите этот код для подтверждения регистрации";
								sendSms($Phone, $Text);
							}
						}
						$_SESSION['verify'] = 1;
					} ?>
					<form id="countdown" method="POST" action="<?=SITE?>registration/registration_ok.php">
						<h4 class="text-center">Ожидайте <span class="display">60</span> секунд</h4>
						<div class="form-group">
							<label for="code">Введите код из сообщения</label>
							<input type="number" class="form-control" id="code" name="code" placeholder="Код из сообщения" required>
						</div>

						<div class="text-center m-2">
							<button type="button" class="btn btn-secondary" onClick='location.href="<?=SITE?>enter_cabinet/enter.php"'>Вернуться</button>
							<button type="submit" class="btn btn-primary" id="registrationOK" name="registrationOK">Подтвердить</button>
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
                d.querySelector('#registrationOK').style.display = 'none' 
                clearInterval(timer) 
            }
        }, 1000)  
    })(document)
</script>
</body>
</html>