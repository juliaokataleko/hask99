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
	<title>Perguntar</title>
	<link href="includes/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link rel = "stylesheet" type = "text/css" href = "includes/assets/css/home.css" />
	<link rel="icon" href="includes/img/logo.png" sizes="57x57" type="image/png">
</head>
<body>

<?php include 'includes/html/header.html';?>

<div class="content">
<h2>faça uma pergunta</h2>
<hr/>
<?php
	
	if(Input::exists()) {
		
		if(Token::check(Input::get('token'))){
		
			//echo "Ok!"; se o token é válido
			$validate = new Validate();
			$validation = $validate->check($_POST, array(
				'question' => array(
					'required' => true,
					'min' => 10
				),
				'details' => array(),
				'category' => array(),
				'user_id' => array(
					'required' => true,
				),
			));
			
			if($validation->passed()) {
	
				$newUser = new User();
				$userPost = Input::get('user_id');
				
				
				if($newUser->find($userPost)){
					if(isset($_FILES['file']['name']) && $_FILES['file']['name'] != ""){
						$upload = new File();
						$uploadFile = $_FILES['file'];
						$uniq = uniqueAlfa(6);
						$upload ->upload($uploadFile, $uniq);
					}
					$file = $uniq.$_FILES['file']['name'];
					try {
						
						$post = new Post();
						
						$post->postIdea(array(
							'question' => Input::get('question'),
							'details' => Input::get('details'),
							'user_id' => Input::get('user_id'),
							'category' => Input::get('category'),
							'file' => $file
						));
						Session::flash('success', "Publicação efectuada com sucesso.");
						Redirect::to('index');
					
					} catch(Exception $e) {
						die($e->getMessage());
					}
					
				}else {
					echo "este usuário não existe...";
				}
				
				
			}else{
				echo "<div align='left' style='border: 1px solid red; padding: 10px;'>";
				foreach($validation->errors() as $error){
					
					$words = ["question"];
					$url_string = explode(" ", $error);
					
					if(!empty(array_intersect($words, array_map("strtolower", $url_string)))){
						echo "Por favor faça uma pergunta.<br/>";
					}
					
					
					//echo str_replace("idea","Uma ideia ", $error).'<br/>';
				}
				echo '</div><br/>';
			}
		
		}
	}

?>


<form action="" method="POST" autocomplete="off" enctype="multipart/form-data">

	  
	  <div class="form-group">
    <label for="question">Pergunta</label>
	  <textarea  maxlength="200" style="
	border:1px solid #ddd; 
	resize: none; " name="question" class="form-control" id="question"><?php echo escape(Input::get('idea'));?></textarea>
	  </div>
	  
	  <div class="form-group">
    <label for="details">Descrição(Opcional)</label>
	  <textarea maxlength="800" style="border:1px solid #ddd; 
	resize: none; " name="details" class="form-control" id="details"><?php echo escape(Input::get('details'));?></textarea>
	  </div>
	  <br/>
	  
	  <input type="hidden" name="user_id" value="<?php echo $user->data()->user_id;?>">
	  <input type="hidden" name="token" value="<?php echo Token::generate();?>">
<br/>
<label class="btn btn-secondary form-control" for="my-file-selector">
    <input id="my-file-selector" name="file" type="file" class="d-none">
    <i class="far fa-image"></i> Carregar imagem(Opcional)
</label>


	  <input type="submit" class="btn btn-primary" value="Publicar">
	  
</form> 
<br/><br/>
<p>
Início 
<a href='index'>Página inicial</a>
</p>
</div>
<?php include 'includes/html/footer.html';?>