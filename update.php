<?php
require_once 'core/init.php';
require_once'functions/functions.php';
acessLog($absolute_url);

$user = new User();

if($user->isLoggedIn()){
	
	if($user->data()->active == 0) {
	Redirect::to('notactive');
	}
	$username = $user->data()->username;
}else {
	Redirect::to('login');
}
?>
<!DOCTYPE html>
<html lang="pt-pt">
<head>
	<meta charset="utf-8"/>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport">
	<title>Hask99</title>
	<link href="includes/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link rel = "stylesheet" type = "text/css" href = "includes/assets/css/style.css" />
	<link rel="icon" href="includes/img/logo.png" sizes="57x57" type="image/png">
</head>
<body>
<?php include 'includes/html/header.html';?>
<div class="content">
<h2>Actualizar conta</h2>
<hr/>
<?php

if(Input::exists()) {
		
	if(Token::check(Input::get('token'))){
		
		//echo "Ok!"; se o token é válido
		$validate = new Validate();
		$validation = $validate->check($_POST, array(
			'name' => array(
				'required' => true,
				'min' => 2,
				'max' => 30
			),
			'username' => array(
				'required' => true,
				'min' => 2,
				'max' => 30
			)
		));
		echo "<div align='left' style='border: 1px solid red; padding: 10px;'>";
			
		if($validation->passed()) {
			$user3 = new User();
			if(Input::get('username') == $user->data()->username || !$user3->find(Input::get('username'))) {
			
			try {
				$user->update('user_id', array(
				'name' => Input::get('name'),
				'username' => Input::get('username')
				));
				
				Session::flash('success', 'conta actualizada com sucesso.');
				Redirect::to('index');
				
			} catch(Exception $e) {
				die($e->getMessage());
			}
			
			}else {
				echo "este nome de usuário já existe";
			}
				
		}else{
			foreach($validation->errors() as $error){
				echo $error.'<br/>';
			}
		}
		echo "</div align='left' style='border: 1px solid red; padding: 10px;'>";
		
	}
}
?>
<form action="" method="POST" autocomplete="off">

	  <div class="field">
	  <label for="name">Nome</label>
	  <input autocomplete="off" type="text" name="name" id="name" value="<?php echo escape($user->data()->name);?>">
	  </div>
	  <div class="field">
	  <label for="username">Nome de usuário</label>
	  <input autocomplete="off" type="text" name="username" id="username" value="<?php echo escape($user->data()->username);?>">
	  </div>
	  
	  <input type="hidden" name="token" value="<?php echo Token::generate();?>">
	  <input class="button" type="submit" value="Actualizar">
	  
</form> 
</div>
<?php include 'includes/html/footer.html';?>	