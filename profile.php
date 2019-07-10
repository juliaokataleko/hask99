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
	<link rel = "stylesheet" type = "text/css" href = "includes/assets/css/home.css" />
	<link rel="icon" href="includes/img/logo.png" sizes="57x57" type="image/png">
</head>
<body>

<?php include 'includes/html/header.html';?>


<div class="content">
<?php

if(!$username = Input::get('user')){
	Redirect::to('index');
}else{
	$userId = new User($username);
	if(!$userId->exists()){
		Redirect::to(404);
	}else{
		$data = $userId->data();
	}

?>
<h2><?php echo ucwords(escape($userId->data()->name));?></h2>
<hr/>
<div>
<?php 



echo "<b>Username</b>: @". escape($userId->data()->username);
echo "<br/><b>Email</b>: ".escape($userId->data()->email)."";
echo "<div><b>Nome</b>: ". ucwords(escape($userId->data()->name)). " </div>"; 

if($user->data()->user_id == $userId->data()->user_id) {
?>
<p style="padding:10px; margin-top:10px; border: 1px solid #ddd;">
<a class='nav-link' href='update'>Actualizar conta</a>
<a class='nav-link' href='changepassword'>Alterar chave</a>
<a class='btn form-control btn-danger' href='logout'><i class="fas fa-sign-out-alt"></i> Terminar sessão</a>
</p>

<?php } ?>
</div>
<br/>Lista de ideias publicadas por <?php echo "<a href=''>" . ucwords($userId->data()->name) . "</a>";?><br/><br/>
<?php

$post = new Post();
$where = array('user_id', '=', $userId->data()->user_id);
$posts = $post->postsList('table_posts', $where);
$array = json_decode(json_encode($posts), True);


if($posts) {

$pag = new Pagination();
$data = array_reverse($array);
$numbers = $pag->paginate($data, 5);
$result = $pag->fetchResult();


foreach($result as $postsingle): 
	$userPost = new User($postsingle['user_id']);
	$post_id = $postsingle['post_id'];
	?>
	 <!-- Project One -->
		  <div class="row">
			<div class="col-md-12">
			  <div><a href="profile?user=<?php echo $userPost->data()->username;?>">
			  <?php echo ucwords($userPost->data()->name); ?></a></div>
			  <p>
			  <?php
			  if(null !== $postsingle['file'] && $postsingle['file'] != "" && file_exists("uploads/" . $postsingle['file'])){
				echo "<a href='single-post?id=$post_id'><img src='uploads/" . $postsingle['file'] . "' 
				style='display:block; max-width:400px; width:100%;'/></a>";
				}
					
				$string = $postsingle['question'];
			  echo convertLink($string);
				?>
			  
			  </p>
			  
			  <p style="font-size:12pt; border:1px solid #ddd; padding:8px;">
			  <?php
		 $user_me = $user->data()->user_id;
		 $likeState = DB::getInstance()->query('select * from table_like where user_id = ? and post_id = ?', array($user_me, $post_id));
		 $likeTotal = DB::getInstance()->query('select * from table_like where 
		 post_id = ?', array($post_id));
		 
		 if(!$likeState->count()) {
			echo "<a href='like?id=$post_id>' class='margin-right 
			color-green'><i class='far fa-thumbs-up'></i> " .$likeTotal->count(). "</a>
			";
		 }else {
			echo "<a class='margin-right' 
			style='color: #f4bb02'><i class='far fa-thumbs-up'>
			</i> " .$likeTotal->count(). "</a>
			";
		 }
		 ?>
			  <a href="like?id=<?=$post_id;?>" class="margin-right color-green">
				  
		
			  
			  <?php
				$read = new Read();
				$read -> findReads($postsingle['post_id']);
				echo $read->_db->count() . " leituras, ";
				
				$comment = new Comment();
				$comment->findComment($postsingle['post_id']);
				echo $comment->_db->count() . " Resposta/s ";
			  
			  if($user->data()->user_id == $userPost->data()->user_id)
				  echo " - <a href='delete?delete_post=$post_id'><i class='fa fa-trash'></i></a>";
			  ?>
			</div>
		  </div>
		  <!-- /.row -->
	 <hr>
 <?php endforeach; ?>
 <ul class="pagination justify-content-center">
 <?php
 foreach($numbers as $num) {
	echo"<li class='page-item'><a class='page-link' href='profile?user=$username&page=$num'>" . $num . "</a><li>";
}
 ?>
</ul>

<?php } else {
	echo "Parece que ainda publicou nenhuma ideia.";
}















}
?>


</div>
<?php include 'includes/html/footer.html';?>