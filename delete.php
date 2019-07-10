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
	<title>Thinkhub.com</title>
	<link href="includes/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link rel = "stylesheet" type = "text/css" href = "includes/assets/css/home.css" />
	<link rel="icon" href="includes/img/logo.png" sizes="57x57" type="image/png">
</head>
<body>

<?php include 'includes/html/header.html';?>


<div class="content">

<?php

if(isset($_GET['delete_comment'])) {
	$comment_id = (int)$_GET['delete_comment'];
	$comment = new Comment();
	
	if($comment->findCommentDel($comment_id)){
		
		if($comment->data()->user_id == $user->data()->user_id){
			echo "<a href='delete?delete_commentyes=$comment_id'>Deseja realmente deletar este comentário?</a>";
			
		} else {
			echo "Não tens permissão para eliminar este comentário.";
		}
	} else {
			echo "Parece que este comentário não existe...";
		}  
		
}


if(isset($_GET['delete_post'])) {
	$post_id = $_GET['delete_post'];
	$post = new Post();
	
	if($post->findPost($post_id)){
		
		if($post->data()->user_id == $user->data()->user_id){
	
			echo "<a href='delete?delete_postyes=$post_id'>Deseja realmente deletar esta ideia?</a>";
	
		} else {
			echo "Não tens permissão para eliminar esta ideia.";
		}
		
	} else {
			echo "Ideia não encontrada.";
		}
}


if(isset($_GET['delete_postyes'])) {
	$post_id = $_GET['delete_postyes'];
	$post = new Post();
	
	if($post->findPost($post_id)){
		
		if($post->data()->user_id == $user->data()->user_id){
	
			if($post -> _db->delete('table_posts', array('post_id', '=', $post_id))){
				$comment = new Comment();
				$comment -> _db->delete('tbl_comments', array('post_id', '=', $post_id));
				
				$alert = new Notification();
				$alert -> _db->delete('tbl_alerts', array('object_id', '=', $post_id));
				
				Session::flash('success', 'Poste eliminado...!');
				Redirect::to('index');
			}
	
		}
		
	}
}


if(isset($_GET['delete_commentyes'])) {
	$comment_id = $_GET['delete_commentyes'];
	$comment = new Comment();
	
	if($comment->findCommentDel($comment_id)){
		
		if($comment->data()->user_id == $user->data()->user_id){
			if($comment -> _db->delete('tbl_comments', array('comment_id', '=', $comment_id))){
				Session::flash('success', 'Comentário eliminado...!');
			}
		}
		
	}
	
}

?>


</div>
<?php include 'includes/html/footer.html';?>