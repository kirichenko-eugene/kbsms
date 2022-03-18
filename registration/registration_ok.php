<?php
    session_start();
    require_once $_SERVER['DOCUMENT_ROOT']."/includes/config.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/includes/functions.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
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
                <div class="text-center m-2">
                    <?php
                    $findCard = findCard($_SESSION['card']);
                    $findPhone = findPhone($_SESSION['phone']);

                    $token = TOKEN;
                    $card = $_SESSION['card'];
                    $action = "card_info";
                    $searchAction = "card_code";
                    $findCardInCrm = curlCrm($token, $action, $searchAction, $card);
                    if(isset($findCardInCrm->Cards)) {
                        if($findCard) { ?>
                            <div class="text-center m-2">
                                <p>Данная карта уже используется</p>
                            </div>
                        <?php } elseif ($findPhone) { ?>
                            <div class="text-center m-2">
                                <p>Данный номер телефона уже используется</p>
                            </div>
                        <?php } else {
                            if(isset($_POST['registrationOK'])) {
                                $codeNumber = $_SESSION['codenumber'];
                                $userCode = htmlspecialchars($_POST['code'], ENT_QUOTES);
                                if($codeNumber == $userCode) { 
                                    $card = $_SESSION['card'];
                                    $surname = $_SESSION['surname'];
                                    $name = $_SESSION['name'];
                                    $patronymic = $_SESSION['patronymic'];
                                    $age = $_SESSION['birth'];
                                    $sex = $_SESSION['sex'];
                                    $marrital = $_SESSION['marrital'];
                                    $phone = $_SESSION['phone'];
                                // Записываю в бд
                                    $query = "INSERT INTO `users` (`card`, `phone`) 
                                    VALUES (:card, :phone)";
                                    $params = [
                                        ':card' => $_SESSION['card'],
                                        ':phone' => $_SESSION['phone']
                                    ];
                                    $stmt = $pdo->prepare($query);
                                    $stmt->execute($params);
                                //файл с записью данных в CRM
                                    require_once("edit_curl.php");

                                    ?>
                                    <p>Вы приобрели бонусную накопительную карту Kimbao.</p>
                                    <p>Поздравляем, каждая 10я лапша теперь в подарок!</p>
                                    <p>Ваш Бонус - булочка  Bao! Заберите при любом заказе.</p>
                                    <p>Предъявляйте, пожалуйста, карту при каждой покупке.</p>

                                <?php } else { ?>
                                    <p>Код не совпадает. Вы не зарегистрированы</p>
                                <?php }
                            } 
                        }
                    } else { ?>
                        <div class="text-center m-2">
                            <p>Карта введена ошибочно</p>
                        </div> 
                    <?php }?>
        <button type="button" class="btn btn-secondary" onClick='location.href="<?=SITE?>enter_cabinet/enter.php"'>Вернуться</button>
    </div>
</body>
</html>