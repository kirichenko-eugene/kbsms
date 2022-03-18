<?php
if(isset($_GET['do'])) {
	if($_GET['do'] == 'logout'){
		$_SESSION['welcome'] == false;
		unset($_SESSION['welcome']);
		session_destroy();
	}
}

if(!isset($_SESSION['welcome'])) {
	header("Location: /enter_cabinet/enter.php");
}

?>
