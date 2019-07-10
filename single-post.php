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
	<title>Comentários</title>
	<link href="includes/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link rel = "stylesheet" type = "text/css" href = "includes/assets/css/home.css" />
	<link rel="icon" href="includes/img/logo.png" sizes="57x57" type="image/png">
</head>
<body>


<?php include 'includes/html/header.html';?>

<div class="content">
<?php
	if(isset($_GET['id'])) {
		$post_id = $_GET['id'];
		
		$newPost = new Post();
		if($newPost->findPost($post_id)){ 
		$posts = $newPost->findPost($post_id);
		$array = json_decode(json_encode($posts), True);
		
		$newUser = new User();
		$newUser -> find($newPost->data()->user_id);
		
		$read = new Read();
		
		$read_array = array('post_id' => $newPost->data()->post_id);
		
		$read -> countRead($read_array);
		
		$read -> findReads($post_id);
		
		$string = $newPost->data()->question;
		
		?>
		<div style="margin-bottom:10px; border-radius:4px;">
		<p><?php 
		
		if(null !== $newPost->data()->file && $newPost->data()->file != "" && file_exists("uploads/" . $newPost->data()->file)){
			echo "<a href='single-post?id=$post_id'><img src='uploads/" . $newPost->data()->file . "' 
			style='display:block; max-width:400px; width:100%;'/></a>";
			}
		
		echo convertLink($string);?></p>
		<p><a href="profile?user=<?php echo $newUser->data()->user_id;?>"><?php echo ucwords($newUser->data()->name);?></a></p>
		
		<?php if($newPost->data()->details !== "") { ?>
		<p style="border:1px solid #ddd; padding:10px;"><?php echo $newPost->data()->details;?></p><hr/>
		<?php } 
		
		 $user_me = $newUser->data()->user_id;
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
		
		</div>
		<form action="postComent" method="POST" autocomplete="off">
		<div class="input-group mb-3">
		  <input type="text" class="form-control" name="comment" id="comment" placeholder="Deixe um comentário..." aria-label="Pesquisar tópicos" aria-describedby="basic-addon2">
		  <div class="input-group-append">
			<input type="hidden" name="user_id" value="<?php echo $user->data()->user_id;?>">
			<input type="hidden" name="post_id" value="<?php echo $newPost->data()->post_id;?>">
			<input type="hidden" name="token" value="<?php echo Token::generate();?>">
			<button class="btn btn-primary" type="submit">Comentar</button>
		  </div>
		</div>
		</form>
		
		<?php
		
		if(Session::exists('success')){
			echo "<div class='alert-success'>" . Session::flash('success') . "</div>";
		}

		if(Session::exists('error')){
			echo "<div class='alert-error'>" . Session::flash('error') . "</div>";
		}
		echo $read->_db->count() . " leituras, ";
		
		$comment = new Comment();
		if($comment->findComment($post_id)){
			echo $comment->_db->count()." Comentários<hr>";
			
			$where 	= array('post_id', '=', $newPost->data()->post_id);
			$comments 	= $comment->commentsList('tbl_comments', $where);
			$array 		= json_decode(json_encode($comments), True);
				
			$pag 		= new Pagination();
			$data 		= array_reverse($array);
			$numbers 	= $pag->paginate($data, 5);
			$result 	= $pag->fetchResult();
			
			foreach($result as $r): 
			
			$commentUser = new User($r['user_id']);
			$commentUser -> find($r['user_id']);
			
			?>
				<a href="profile?user=<?php echo $commentUser->data()->username;?>">
				<?php echo ucwords($commentUser->data()->name); ?></a><br/> 
			<?php	
			
			$string = $r['comment'];
			$comment_id = $r['comment_id'];
			echo convertLink($string) . "";
			if($user->data()->user_id === $commentUser->data()->user_id)
			  echo "<br/><a href='delete?delete_comment=$comment_id'>Eliminar comentário</a>";
			echo "<hr/>";
			endforeach; ?>
				
				
			 <ul class="pagination justify-content-center">
			 <?php
			 foreach($numbers as $num) {
				echo"<li class='page-item'><a class='page-link' href='idea?id=$post_id&page=$num'>" . $num . "</a><li>";
			}
			 ?>
			</ul>
			
			<?php	
			} else {
					echo "Ainda não há comentários. seja o primeiro";
			}
			
			
			
			
	} else{
		echo "nenhuma publicação encontrada.";
	}
}
?>
</div>
</body>
</html>