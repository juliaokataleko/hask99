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

if(Input::exists()) {
		
		if(Token::check(Input::get('token'))){
			
			$post_id = Input::get('post_id');
			$post = new Post();
			$post->findPost($post_id);
			$userPost = $post->data()->user_id;
			//echo "Ok!"; se o token é válido
			$validate = new Validate();
			$validation = $validate->check($_POST, array(
				'comment' => array(
					'required' => true,
					'min' => 3
				)
			));
			
			if($validation->passed()) {
	
				$newUser = new User();
				$userComment = Input::get('user_id');
				
				
				if($newUser->find($userComment)) {
					try {
						
						$comment = new Comment();
						
						$comment->postComment(array(
							'comment' => Input::get('comment'),
							'post_id' => Input::get('post_id'),
							'user_id' => Input::get('user_id')
						));
						$userIdAction = Input::get('user_id');
						
						if($userIdAction != $userPost) {
						$notification = new Notification();
						
						$notification->insertNotification(array(
							'object_id' => $post_id,
							'user_id_action' => $userIdAction,
							'type_alert' => 1,
							'user_id_receive' => $userPost,
							'readState' => 0
							
						));
						}
						
						Session::flash('success', 'Comentaste com sucesso.');
						Redirect::to($_SERVER['HTTP_REFERER']);
					
					} catch(Exception $e) {
						die($e->getMessage());
					}
					
				} else {
					echo "Este usuário não existe...";
				}
				
				
			} else {
				
				Session::flash('error', 'Escreva alguma coisa no comentário.');
				Redirect::to($_SERVER['HTTP_REFERER']);
				/*foreach($validation->errors() as $error){
					echo $error.'<br/>';
				}
				echo '<br/><br/>';*/
			}
		
		}
	}

?>