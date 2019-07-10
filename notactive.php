<!DOCTYPE html>
<html lang="pt-pt">
<head>
	<meta charset="utf-8"/>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport">
	<title>Thinkhub.com</title>
	<link rel = "stylesheet" type = "text/css" href = "includes/assets/css/style.css" />
	<link rel="icon" href="includes/img/logo.png" sizes="57x57" type="image/png">
</head>
<body>

<div class="content">
<h2><a href="index">Pennsub.com</a></h2>
<h2>Activa a tua conta</h2>
<?php
require_once 'core/init.php';
require_once'functions/functions.php';
acessLog($absolute_url);

$user = new User();
if(!$user->isLoggedIn()){ 
	Redirect::to('index');
}
if($user->data()->active == 0) {
}else{
	Redirect::to('index');
}

if(Input::exists()) {
		
		if(Token::check(Input::get('token'))){
		
			//echo "Ok!"; se o token é válido
			$validate = new Validate();
			$validation = $validate->check($_POST, array(
				'confirmation_code' => array('required' => true)
			));
			
			if($validation->passed()) {
				$confirmation_code 	= Input::get('confirmation_code');
				$email 	= Input::get('email');
				$user 	= new User();
				if($user->findEmail($email)) { 
					
					if($user->data()->confirmation_code == Input::get('confirmation_code')) {
						$user->update('user_id', array(
						'active' => 1
						));
						Session::flash('success', 'Conta activada com sucesso! Seja Bemvido(a) à nossa comunidade');
						$redirect = new Redirect();
						$redirect->to('index');

					}else {
						echo "Código inválido...<br/><br/>";
					}
				}
			}
			
		}
}




?>

<form action="" method="POST" autocomplete="off">

	  <div class="field">
	   <label for="confirmation_code">Cógigo de activação</label>
	  <input type="text" name="confirmation_code" id="confirmation_code" value="<?php echo escape(Input::get('confirmation_code'));?>">
	  </div>
	  <input type="hidden" name="email" value="<?php echo $user->data()->email;?>">
	  <input type="hidden" name="token" value="<?php echo Token::generate();?>">
	  <input type="submit" class="button" value="Actualizar senha">
	  
</form> 
<br/><br/>
<a href="logout">Terminar sessão</a>
</div>
</body>
</html>