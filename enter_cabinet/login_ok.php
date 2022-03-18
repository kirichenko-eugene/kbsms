<?php
    session_start();
    require_once $_SERVER['DOCUMENT_ROOT']."/includes/config.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/includes/functions.php";
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход в личный кабинет</title>
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
                <div class="text-center m-2">
                <?php
                if(isset($_POST['loginOK'])) {
                    $codeNumber = $_SESSION['codenumber'];
                    $userCode = htmlspecialchars($_POST['code'], ENT_QUOTES);
                    if($codeNumber == $userCode) { 
                        $_SESSION['welcome'] = "ok";
                        header("Location:" . SITE . "index.php");
                                exit;
                        ?>
                    <?php } else { ?>
                        <p>Код не совпадает. Вход не выполнен</p>
                    <?php }
                } ?>
        <button type="button" class="btn btn-secondary" onClick='location.href="<?=SITE?>enter_cabinet/enter.php"'>Вернуться</button>
    </div>
</body>
</html>