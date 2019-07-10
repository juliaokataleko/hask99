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

if(isset($_GET['id'])){
            $post_id = Input::get('id');
			$post = new Post();
			$post->findPost($post_id);
			$userPost = $post->data()->user_id;
			
	
				$newUser = new User();
				$userLike = $user->data()->user_id;
				
				
				if($newUser->find($userLike) && $userLike == $user->data()->user_id) {
					try {
						
						$like = new Like();
						
						$like->postLike(array(
							'post_id' => htmlspecialchars($_GET['id']),
							'user_id' => $userLike
						));
						
						
						if($userLike != $userPost) {
						$notification = new Notification();
						
						$notification->insertNotification(array(
							'object_id' => $post_id,
							'user_id_action' => $userLike,
							'type_alert' => 2,
							'user_id_receive' => $userPost,
							'readState' => 0
							
						));
						}
						
						//Session::flash('success', 'Comentaste com sucesso.');
						Redirect::to($_SERVER['HTTP_REFERER']);
					
					} catch(Exception $e) {
						die($e->getMessage());
					}
					
				} else {
					echo "Este usuário não existe...";
				}
            }				
?>