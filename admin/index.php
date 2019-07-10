<?php
require_once'core/init.php';
require_once'functions/functions.php';
$user = new User();

if($user->isLoggedIn() && $user->hasPermission('admin')){
	
	if($user->data()->active == 0) {
	Redirect::to('../notactive');
	}
	$username = $user->data()->username;
}else {
	Redirect::to('../login');
}
?>
<!doctype html>
<html lang='pt'>
<!--<![endif]-->
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Administração</title>
<link href="boilerplate.css" rel="stylesheet" type="text/css">

<link href="css/boot.css" rel="stylesheet" type="text/css">
<link href="css/style.css" rel="stylesheet" type="text/css">

<script src="respond.min.js"></script>
</head>
<body>
<div class="gridContainer clearfix">
  <div id="LayoutDiv1">
  
  
  <div class="header"><div class="container">
  <a href="index"><img src="../includes/img/logow.png" style="width:1.5em; border: #fff 1px solid; 
  border-radius:4px;"/></a> <span style="margin: 0 1em;">Administração</span><?php echo $user->data()->name;?>
    <!-- end .header --></div></div> 
    
  <div class="container1">
 
  <div class="sidebar1">
    <ul class="nav">
	  <li ><a style='background-color: #555; color: #fff;' href="index">Página inicial</a></li>
	  <li ><a href="../" target="_blank">Ver site</a></li>
      <li><a href="index?users">Lista de usuários</a></li>
      <li><a href="index?ideas">Lista de Perguntas</a></li>
	  <li><a href="index?acess">Visitas Diárias</a></li>
      <li><a href="index?tasks">Tarefas a realizar</a></li>	  
    </ul>
    </div>
  <div class="content">
	<div class="container" style="padding-top:12px;">

	<?php 
	if(isset($_GET['users'])) { 
	$where = array('user_id', '>=', 0);
	$user2 = DB::getInstance()->get('table_users', $where);


	if(!$user2->count()) {
		echo "Nenhum usuário";
	}else { ?>
	<h4 align="center">Lista de usuários(<?php echo $user2->count();?>)</h4>
	 <table class="table">
	  <thead class="thead-light">
		<tr>
		  <th scope="col">ID</th>
		  <th scope="col">Nome</th>
		  <th scope="col">Registou-se</th>
		  <th scope="col">Email</th>
		  <th scope="col">Excluir</th>
		  <th scope="col">Ativo?</th>
		</tr>
	  </thead>
	  <tbody>
	<?php
		foreach($user2->results() as $user3) {
			?>
			 <tr>
      <th scope="row"><?php echo $user3->user_id; ?></th>
      <td><?php echo $user3->name; ?></td>
      <td><?php echo $user3->joined; ?></td>
      <td><?php echo $user3->email; ?></td>
	  <td><?php echo "<a href='deleteuser=". $user3->user_id ."'>Deletar</a>"; ?></td>
	  <td><?php $active = $user3->active; 
	  if($active == 1) {
		  echo "<a href=''>Sim</a>";
	  } else {
		  echo "<a href=''>Não</a>";
	  }
	  
	  ?></td>
    </tr>
	<?php } ?>
		</tbody>
	</table>
	
	<?php } ?>
     

	<?php }else if(isset($_GET['ideas'])){
		
		
		$where = array('post_id', '>=', 0);
	$questions = DB::getInstance()->get('table_posts', $where);


	if(!$questions->count()) {
		echo "Nenhum usuário";
	}else { ?>
	<h4 align="center">Lista de Perguntas postadas (<?php echo $questions->count();?>)</h4>
	 <table class="table">
	  <thead class="thead-light">
		<tr>
		  <th scope="col">ID</th>
		  <th scope="col">Pergunta</th>
		</tr>
	  </thead>
	  <tbody>
	<?php
		foreach($questions->results() as $question) {
			?>
			 <tr>
      <th scope="row"><?php echo $question->post_id; ?></th>
      <td><?php echo $question->idea . "<hr>" . $question->details . $question->dataCreated; ?></td>
    </tr>
	<?php } ?>
		</tbody>
	</table>
	
	<?php } 
	
	}else if(isset($_GET['acess'])){
		
		$where = array('acesslog_id', '>=', 0);
	$acess = DB::getInstance()->get('table_acesslog', $where);


	if(!$acess->count()) {
		echo "Nenhum usuário";
	}else { ?>
	<h4 align="center">Lista de acessos no site (<?php echo $acess->count();?>)</h4>

	 <table class="table">
	  <thead class="thead-light">
		<tr>
		  <th scope="col">ID</th>
		  <th scope="col">url</th>
		  <th scope="col">Data</th>
		  <th scope="col">ip</th>
		</tr>
	  </thead>
	  <tbody>
	<?php
	$array = json_decode(json_encode($acess->results()), True);
	$pag = new Pagination();
	$data = array_reverse($array);
	$numbers = $pag->paginate($data, 20);
	$result = $pag->fetchResult();
	
	
		foreach($result as $acess) {
			?>
			 <tr>
      <th scope="row"><?php 
	  
	  
	  echo $acess['acesslog_id']; ?></th>
      <td><?php echo $acess['url']; ?></td>
	  <td><?php echo $acess['dateCreated']; ?></td>
	  <td><?php echo $acess['ip']; ?></td>
    </tr>
	<?php } 
	
	
	?>
		</tbody>
	</table>
<DIV STYLE="max-widt:400px;">
	<ul class="pagination justify-content-center">
 <?php
 $numb = 0;
 foreach($numbers as $num) {
	if($numb < 7)
		echo"<li class='page-item'><a class='page-link' href='index?page=$num&acess'>" . $num . "</a><li>";
	else
		break;
	$numb++;
}
 ?>
</ul></div>
	<?php } 
		
		
		
	}else if(isset($_GET['tasks'])){
		
		
		echo "Lista de tarefas a realizar...";
		
	} else {
		
		echo "<h1>Página inicial</h1>";
		
	}
	?>

</div>

	
<!-- end .content --></div>

  <!-- end .container --></div>
  
  
  
  
  
  
  
  
   </div>
</div>
</body>
</html>