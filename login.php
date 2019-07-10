<!DOCTYPE html>
<html lang="pt-pt">
<head>
	<meta charset="utf-8"/>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport">
	<title>Iniciar sessão</title>
	<link rel = "stylesheet" type = "text/css" href = "includes/assets/css/style.css" />
	<link rel = "stylesheet" type = "text/css" href = "includes/assets/css/all.css" />
	<link rel="icon" href="includes/img/logo.png" sizes="57x57" type="image/png">
</head>
<body>

<div class="content" style="background: rgba(255,255,255, 0.9); text-align: center; padding:3em; max-width:400px; border-radius: 6px;">
<a href="index"><img src="includes/img/logo.png" style="width:4em; border: #bbb 1px solid; 
border-radius:4px; margin-bottom:0.5em;"/></a>
<h2>Iniciar sessão</h2>
<?php
	require_once 'core/init.php';
	require_once'functions/functions.php';
	acessLog($absolute_url);
	$user = new User();

	if($user->isLoggedIn()){ 
		Redirect::to('index');
	}
	
	if(Session::exists('success')){
	echo "<div class='alert-success'>" . Session::flash('success') . "</div>";
	}

	if(Session::exists('error')){
		echo "<div class='alert-error'>" . Session::flash('error') . "</div>";
	}
	
	if(Input::exists()) {
		
		if(Token::check(Input::get('token'))){
		
			//echo "Ok!"; se o token é válido
			$validate = new Validate();
			$validation = $validate->check($_POST, array(
				'username' => array('required' => true),
				'password' => array('required' => true)
			));
			
			if($validation->passed()) {
	
				$user = new User();
				$remember = (Input::get('remember') === 'on') ? true : false;
				$login = $user->login(Input::get('username'),Input::get('password'), $remember);
				
				if($login) {
					$user->isLoggedIn();
					Redirect::to('index');
				}else{
					echo "<div class='alert-error'>Usuário ou senha incorrecto!</div>";
				}
				
				
			}else{
				echo "<div align='left' style='border: 1px solid red; padding: 10px;'>";
				foreach($validation->errors() as $error){
					$words = ["username"];
					$words2 = ["password"];
					$url_string = explode(" ", $error);
					
					if(!empty(array_intersect($words, array_map("strtolower", $url_string)))){
						echo "O nome de usuário é obrigatório<br/>";
					}else if(!empty(array_intersect($words2, array_map("strtolower", $url_string)))){
						echo "A chave de acesso é obrigatória<br/>";
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
	  <label for="username">Username</label>
	  <input autocomplete="off" type="text" name="username" id="username" value="<?php echo escape(Input::get('username'));?>">
	  </div>
	  
	  <div class="field">
	   <label for="password">Chave</label>
	  <input type="password" name="password" id="password" value="">
	  </div>
	  <br/>
	  <div class="field">
	  <label for="remember">
	  <input type="checkbox" name="remember" id="remember">
	  Guardar sessão
	  </label>
	  </div>
	  
	  <input type="hidden" name="token" value="<?php echo Token::generate();?>">
	  <button class="button" style="background:#1595d6; color: #fff; width:100%;" type="submit">
	  <i class='fa fa-sign-in-alt'></i> Iniciar sessão</button>
	  
</form> 
<br/>
<p>Esqueceu a chave? 
<a href='forgot'>Recupera agora</a></p>
<br/>
<p>Ainda não tens uma conta? 
<a href='register' >Regista-te já</a></p>
<br/>
<p>
<a href='help' >Centro de ajuda</a></p>
</div>
</body>
</html>
