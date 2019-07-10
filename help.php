<?php
require_once 'core/init.php';
require_once'functions/functions.php';
acessLog($absolute_url);
$user = new User();
if($user->isLoggedIn()){
	
	$username = $user->data()->username;
}
if(isset($user) && $user->isLoggedIn()){
	$notification = new Notification();
	$notification->findNotification($user->data()->user_id);
	$total = $notification->_db->count();
}
?>
<!DOCTYPE html>
<html lang="pt-pt">
<head>
	<meta charset="utf-8"/>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport">
	<title>Centro de ajuda - Pennsub.com</title>
	<link href="includes/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link rel = "stylesheet" type = "text/css" href = "includes/assets/css/home.css" />
	<link rel="icon" href="includes/img/logo.png" sizes="57x57" type="image/png">
	
</head>
<body style="margin-top:0;">


<link rel = "stylesheet" type = "text/css" href = "includes/assets/css/all.css" />

<?php include 'includes/html/header.html';?>

<div class="content" style="">
<h1>Centro de ajuda</h1><hr/>
<a href="#"><i class='fa fa-edit'></i> Como se cadastrar</a>
<hr>
<a href="#"><i class='fa fa-edit'></i> Como iniciar sessão</a>
<hr>
<a href="#"><i class='fa fa-edit'></i> Como activar minha conta</a>
<hr>
<a href="#"><i class='fa fa-edit'></i> Como publica uma ideia</a>
<hr>
<a href="#"><i class='fa fa-edit'></i> As ideias que eu posto podem ser usadas por todos</a>
<hr>
<section id="registo">
<h3>Como se cadastrar</h3>
<div> conteudo</div>
</section>

</div>

<?php include 'includes/html/footer.html';?>
