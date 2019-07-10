<?php
require_once 'core/init.php';
require_once'functions/functions.php';
acessLog($absolute_url);
$user = new User();

?>
<!DOCTYPE html>
<html lang="pt-pt">
<head>
	<meta charset="utf-8"/>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport">
	<meta name="description" content="Site para encontrar e partilhar ideias de negócio inovadores.">
	<meta name="keywords" content="Desenvolvimento web, desenvolvimento móvel, android, ios, desktop, agronegócios, energias renováveis
	Desenvolvimento sustentável, angola, negócios locais, emprego, empreendedorismo. Ideias de empreendedorismo,
	Startups angolanas, Negócios digitais, informática e negócios.
	"/>
	<meta name="author" content="Julião F. Kataleko"/>
	<title>Pennsub - Home</title>
	<link href="includes/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link rel = "stylesheet" type = "text/css" href = "includes/assets/css/home.css" />
	<link rel="icon" href="includes/img/logo.png" sizes="57x57" type="image/png">
	
</head>
<body>


<?php include 'includes/html/header.html';?>


<div class="content">
<form method="get" action="">
	<div class="input-group mb-3" style="border-bottom:1px solid #ddd;">
	  <input type="text" name="query" class="form-control" style="border-radius:0; border:0; outline:none;" 
	  placeholder="Pesquisar tópicos" aria-label="Pesquisar tópicos" 
	  aria-describedby="basic-addon2" name="query" value="<?php echo escape(Input::get('query'));?>"/>
	  <div class="input-group-append">
	    <button class="btn btn-primary" style="border-radius:0;" type="submit"> <i class="fa fa-search"></i> </button>
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

?>

<?php 

if(isset($_GET['query'])) {
	$query = $_GET['query'];
	$where = array('idea', 'like', '%'.$query.'%');
	echo "<div style='padding:10px; background:#cee5e5; margin-bottom: 10px;'>" . Input::get('query')."</div>";
}else {
	$where = array('post_id', '>=', 0);
}


$post = new Post();
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
				<?php echo $userPost->data()->name; ?></a></div>
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
			 $likeState = DB::getInstance()->query('select * from table_like 
			 where post_id = ?', array($post_id));
			
				echo "<a class='margin-right' 
				style='color: #f4bb02'><i class='far fa-thumbs-up'>
				</i> " .$likeState->count(). "</a>
				";
			 
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
				
						
				</p><br/>
				<a class="" href="single-post?id=<?=$postsingle['post_id']; ?>"><i class="fa fa-plus"></i> Ler mais</a>
			
					</div>
				</div>
				<!-- /.row -->
	 <hr>
 <?php endforeach; ?>
 <ul class="pagination justify-content-center">
 <?php
 foreach($numbers as $num) {
	echo"<li class='page-item'><a class='page-link' href='home?page=$num'>" . $num . "</a><li>";
}
 ?>
</ul>

<?php } else {
	echo "Sem resultados para sua pesquisa.";
}

?>
</div>

<?php include 'includes/html/footer.html';?>
