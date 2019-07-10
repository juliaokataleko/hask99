<?php
if(!isset($_GET['tag'])){
	Redirect::to('index');
}else {
	$tag = $_GET['tag'];
}

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
	<title>Mostrando perguntas com a tag <?=$tag;?> Thinkhub.com</title>
	<link href="includes/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link rel = "stylesheet" type = "text/css" href = "includes/assets/css/home.css" />
	<link rel="icon" href="includes/img/logo.png" sizes="57x57" type="image/png">
</head>
<body>


<?php include 'includes/html/header.html';?>

<div class="content">
<?php
$post = new Post();
$where = array('question', 'like', '%'.$tag.'%');
$posts = $post->postsList('table_posts', $where);
$array = json_decode(json_encode($posts), True);
?>


<?php
if(Session::exists('success')){
	echo "<div class='alert-success'>" . Session::flash('success') . "</div>";
}

if(Session::exists('error')){
	echo "<div class='alert-error'>" . Session::flash('error') . "</div>";
}

$pag = new Pagination();
$data = array_reverse($array);
$numbers = $pag->paginate($data, 5);
$result = $pag->fetchResult();
?>
Mostrando ideias com a tag <a href="hashtag?tag=<?=$tag;?>"><?=$tag;?></a><hr/>

<?php foreach($result as $postsingle): 
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
		  ?>
		  <?php 
		  if($user->data()->user_id == $userPost->data()->user_id)
			  echo " - <a href='delete?delete_post=$post_id'><i class='fa fa-trash'></i></a>";
		  ?>
          
		  </p>
        </div>
      </div>
      <!-- /.row -->
 <hr>
 <?php endforeach; ?>
 <ul class="pagination justify-content-center">
 <?php
 foreach($numbers as $num) {
	echo"<li class='page-item'><a class='page-link' href='hashtag?tag=$tag&page=$num'>" . $num . "</a><li>";
}
 ?>
</ul>


</div>

<?php include 'includes/html/footer.html';?>