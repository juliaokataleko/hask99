<!DOCTYPE html>
<html lang="pt-pt">
<head>
	<meta charset="utf-8"/>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport">
	<title>Criar conta nova</title>
	<link rel = "stylesheet" type = "text/css" href = "includes/assets/css/style.css" />
	<link rel = "stylesheet" type = "text/css" href = "includes/assets/css/all.css" />
	<link rel="icon" href="includes/img/logo.png" sizes="57x57" type="image/png">
</head>
<body>
<div class="content" style="background: rgba(255,255,255, 0.9); text-align: center; padding:3em; 
max-width:400px; border-radius: 6px;">
<a href="index"><img src="includes/img/logo.png" style="width:4em; border: #bbb 1px solid; 
border-radius:4px;  margin-bottom:0.5em;"/></a>
<h2>Crie uma conta</h2>
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
				'name' => array(
					'required' => true,
					'min' => 2,
					'max' => 30
				),
				'username' => array(
					'required' => true,
					'min' => 4,
					'max' => 20,
					'unique' => 'table_users'
				),
				'email' => array(
					'required' => true,
					'unique' => 'table_users'
				),
				'password' => array(
					'required' => true,
					'min' => 5
				),
				'repeat_password' => array(
					'matches' => 'password',
					'required' => true,
					'min' => 5
				),
			));
			
			if($validation->passed()) {
	
				$user = new User();
				$salt = Hash::salt(32);
				
				$confirmation_code = substr(uniqid(), 0, 4);
				
				try {
					$user->create(array(
						'name' => Input::get('name'),
						'password' => Hash::make(Input::get('password'), $salt),
						'email' => Input::get('email'),
						'username' => Input::get('username'),
						'salt' => $salt,
						'confirmation_code' => $confirmation_code,
						'grupo' => 1
					));
					
					//envia o email com o cógido de confirmação
					$user->send_confirmation_code($email, $confirmation_code);	
					
					Session::flash('success', 'Registo efectuado com sucesso... Inicie sessão agora!');
					Redirect::to('login');
					
				} catch(Exception $e) {
					die($e->getMessage());
				}
			}else{
				echo "<div align='left' style='border: 1px solid red; padding: 10px;'>";
				foreach($validation->errors() as $error){
					
					$words = ["username"];
					$words2 = ["password"];
					$words3 = ["email"];
					$words4 = ["name"];
					$words5 = ["repeat_password"];
					
					$url_string = explode(" ", $error);
					
					if(!empty(array_intersect($words, array_map("strtolower", $url_string)))){
						echo "O nome de usuário é obrigatório<br/>";
					}else if(!empty(array_intersect($words2, array_map("strtolower", $url_string)))){
						echo "A chave de acesso é obrigatória<br/>";
					}else if(!empty(array_intersect($words3, array_map("strtolower", $url_string)))){
						echo "O email é obrigatório<br/>";
					}else if(!empty(array_intersect($words4, array_map("strtolower", $url_string)))){
						echo "O nome é obrigatório<br/>";
					}else if(!empty(array_intersect($words5, array_map("strtolower", $url_string)))){
						echo "Digite sua chave duas vezes para confirmar.<br/>";
					}
					//echo $error.'<br/>';
				}
				echo '</div><br/>';
			}
		
		}
	}

?>


<form action="" method="POST" autocomplete="off">

	  <div class="field">
	  <label for="name">Nome</label>
	  <input autocomplete="off" type="text" name="name" id="name" value="<?php echo escape(Input::get('name'));?>">
	  </div>
	  
	  <div class="field">
	  <label for="username">Username</label>
	  <input autocomplete="off" type="text" name="username" id="username" value="<?php echo escape(Input::get('username'));?>">
	  </div>
	  
	  <div class="field">
	   <label for="email">E-mail </label>
	  <input type="text" name="email" id="email" value="<?php echo escape(Input::get('email'));?>">
	  </div>
	  
	  <div class="field">
	   <label for="password">Definir chave</label>
	  <input type="text" name="password" id="password" value="">
	  </div>
	  
	  <div class="field">
	   <label for="repeat_password">Repetir chave</label>
	  <input type="text" name="repeat_password" id="repeat_password" value="">
	  </div>
	  <span style="font-size:11pt; margin:1em 0;">Ao clicar em registar, você concorda com a nossa <a target="_blank" href='privacypolicy'>Política de Privacidade</a></span>
	  <input type="hidden" name="token" value="<?php echo Token::generate();?>">
	  <button type="submit" class="button" style="width:100%;"><i class='fa fa-user-plus'></i> Registar</button>
	  
</form> 
<br/><br/>
<p>
Já tens uma conta? 
<a href='login'>inicie sessão</a>
</p>
</div>
</body>
</html>
