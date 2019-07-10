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
<h2>notificações</h2><hr/>
<?php

if(Session::exists('success')){
	echo "<div class='alert-success'>" . Session::flash('success') . "</div>";
}

if(Session::exists('error')){
	echo "<div class='alert-error'>" . Session::flash('error') . "</div>";
}

$where = array('user_id_receive', '=', $user->data()->user_id);
$notification = new Notification();
$notifications = $notification->notificationList('tbl_alerts', $where);
$array = json_decode(json_encode($notifications), True);


if($notifications) {

$pag = new Pagination();
$data = array_reverse($array);
$numbers = $pag->paginate($data, 10);
$result = $pag->fetchResult();


foreach($result as $r): 
$userAction = new User($r['user_id_action']);
$post_id = $r['object_id'];
$type = $r['type_alert'];
$alertId = $r['alertId'];
$readState = $r['readState'];
$date_created = $r['dateCreated'];
if($type == 1) {
	$message = "comentou a sua <a href='idea?id=$post_id'>pergunta</a>";
}else if($type == 2) {
	$message = "gostou da sua  <a href='idea?id=$post_id'>pergunta</a>";
}
?>
 <!-- Project One -->
      <div class="row" <?php if($readState == 0){ echo "style='background:#eee;'"; 
	  $newNotification = new Notification();
	  $newNotification->updateNotification($alertId, array(
		'readState' => 1
	  ));
	  
	  }?>>
        <div class="col-md-12" >
          <div>
		  
		  <a href="profile?user=<?php echo $userAction->data()->username;?>">
		  <?php echo ucwords($userAction->data()->name); ?></a> <?=" " . $message . " - " . $date_created;?></div>
          <hr/>
        </div>
      </div>

 <?php endforeach; ?>
 <ul class="pagination justify-content-center">
 <?php
 foreach($numbers as $num) {
	echo"<li class='page-item'><a class='page-link' href='index?page=$num'>" . $num . "</a><li>";
}
 ?>
</ul>

<?php } else {
	echo "Sem notificações de momento.";
}

?>
</div>

<?php include 'includes/html/footer.html';?>
