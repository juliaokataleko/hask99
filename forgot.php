<!DOCTYPE html>
<html lang="pt-pt">
<head>
	<meta charset="utf-8"/>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport">
	<title>Recuperar chave</title>
	<link rel = "stylesheet" type = "text/css" href = "includes/assets/css/style.css" />
	<link rel="icon" href="includes/img/logo.png" sizes="57x57" type="image/png">
</head>
<body>

<div class="content" style="background: rgba(255,255,255, 0.9); text-align: center; padding:3em; 
max-width:400px; border-radius: 6px;">
<a href="index"><img src="includes/img/logo.png" style="width:4em; border: #bbb 1px solid; 
border-radius:4px;  margin-bottom:0.5em;"/></a>
<h2>Recuperar chave</h2>
<?php
	require_once 'core/init.php';
	require_once'functions/functions.php';
	acessLog($absolute_url);
	$user = new User();

	if($user->isLoggedIn()){ 
		Redirect::to('index');
	}
	
	if(Input::exists()) {
		
		if(Token::check(Input::get('token'))){
		
			//echo "Ok!"; se o token é válido
			$validate = new Validate();
			$validation = $validate->check($_POST, array(
				'email' => array('required' => true)
			));
			
			if($validation->passed()) {
				$email 	= Input::get('email');
				$user 	= new User();
				if($user->findEmail($email)) {
					$newPassword = substr(uniqid(), 0, 5);
					$np = $newPassword;
					$salt = Hash::salt(32);
				
				try {
					$user->update(array(
						'password' => Hash::make($newPassword, $salt),
						'salt' => $salt
					), $user->data()->user_id);
					//envia o email ao usuário
					$user->sendnewEmail($email, $np);	
					
					Session::flash("success", "Chave actualizada com sucesso. ($newPassword)... Inicie sessão agora!");
					
					Redirect::to('login');
					
				} catch(Exception $e) {
					die($e->getMessage());
				}
				

				
				}else {
					echo "Email não encontrado...";
				}
				
			}else{
				foreach($validation->errors() as $error){
					$words = ["email"];
					$url_string = explode(" ", $error);
					
					if(!empty(array_intersect($words, array_map("strtolower", $url_string)))){
						echo "O email é obrigatório<br/>";
					}
					//echo $error.'<br/>';
				}
			}
		
		}
	}

?>
<form action="" method="POST" autocomplete="off">

	  <div class="field">
	  <label for="uemail">Email</label>
	  <input autocomplete="off" type="text" name="email" id="email" value="">
	  </div>
	  
	  <input type="hidden" name="token" value="<?php echo Token::generate();?>">
	  <input class="button" type="submit" value="Recuperar">
	  
</form> 
<br/><br/>
<p>
<a href='index'>Voltar no início</a></p>
</div>
</body>
</html>
