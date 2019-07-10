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
<h2>Actualizar senha</h2>
<hr/>
<?php

if(Input::exists()) {
		
	if(Token::check(Input::get('token'))){
		
		$validate = new Validate();
		$validation = $validate->check($_POST, array(
			'password_current' => array(
				'required' => true,
				'min' => 5
			),
			'new_password' => array(
				'required' => true,
				'min' => 5
			),
			'repeat_new_password' => array(
				'required' => true,
				'min' => 5,
				'matches' => 'new_password'
			)
		));
		
		if($validation->passed()) {
	
			if(Hash::make(Input::get('password_current'), $user->data()->salt) !== $user->data()->password) {
				echo "A tua senha actual está errada.";
			}else{
				$salt = Hash::salt(32);
				$user->update('user_id', array(
					'password' => Hash::make(Input::get('new_password'), $salt),
					'salt' => $salt
				));
				Session::flash('success', 'Senha alterada com sucesso.');
				Redirect::to('index');
			}
				
		}else{
			echo "<div align='left' style='border: 1px solid red; padding: 10px;'>";
			foreach($validation->errors() as $error){
				
				$words = ["password_current"];
				$words2 = ["new_password"];
				$words3 = ["repeat_new_password"];
					
				$url_string = explode(" ", $error);
					
				if(!empty(array_intersect($words, array_map("strtolower", $url_string)))){
					echo "A chave de acesso actual é obrigatória<br/>";
				}else if(!empty(array_intersect($words2, array_map("strtolower", $url_string)))){
					echo "Digita uma nova chave de acesso<br/>";
				}else if(!empty(array_intersect($words3, array_map("strtolower", $url_string)))){
					echo "Tens que confirmar a sua chave<br/>";
				}
				
				
				//echo str_replace("password_current","A chave actual", $error). "<br/>";
			}
			echo '</div><br/>';
		}
		
	}
}
?>
<form action="" method="POST" autocomplete="off">

	  <div class="field">
	   <label for="password_current">Chave actual</label>
	  <input type="text" name="password_current" id="password_current" value="">
	  </div>
	  
	  <div class="field">
	   <label for="new_password">Nova chave</label>
	  <input type="text" name="new_password" id="new_password" value="">
	  </div>
	  
	  <div class="field">
	   <label for="repeat_new_password">Repetir nova chave</label>
	  <input type="text" name="repeat_new_password" id="repeat_new_password" value="">
	  </div>
	  
	  <input type="hidden" name="token" value="<?php echo Token::generate();?>">
	  <input type="submit" class="button" value="Actualizar senha">
	  
</form> 

</div>
<?php include 'includes/html/footer.html';?>