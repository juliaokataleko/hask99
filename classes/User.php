<?php
class User {
	private $_db, $_data, $_sessionName, 
			$_isLoggedIn,
			$_cookieName;
	
	public function __construct($user = null) {
		$this->_db = DB::getInstance();
		$this->_sessionName = Config::get('session/session_name');
		$this->_cookieName = Config::get('remember/cookie_name');
		
		if(!$user) {
			if(Session::exists($this->_sessionName)) {
				$user = Session::get($this->_sessionName);
				
				if($this->find($user)) {
					$this->_isLoggedIn = true;
				}else{
					$this->logout();
				}
				
			}
		}else {
			$this->find($user);
		}
	}
	
	public function create($fields = array()) {
		if(!$this->_db->insert('table_users', $fields)) {
			throw new Exception('Algo correu mal ao tentar criar a sua conta. tente de novo!');
		}
	}
	
	public function update($type, $fields = array(), $user_id = null) {
		
		if(!$user_id && $this->isLoggedIn()) {
			$id = $this->data()->user_id;
		}
		
		if(!$this->_db->update('table_users', $type,  $id, $fields)) {
			throw new Exception('Algo correu mal ao tentar criar a sua conta. tente de novo!');
		}
	}
	
	public function find($user = null) {
		if($user) {
			$field = (is_numeric($user)) ? 'user_id' : 'username';
			$data = $this->_db->get('table_users', array($field, '=', $user));
			
			if($data->count()) {
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}
	
	
	public function findEmail($email) {
		if($email) {
			$field = 'email';
			$data = $this->_db->get('table_users', array($field, '=', $email));
			
			if($data->count()) {
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}
	
	public function login($username = null, $password = null, $remember = false) {
		
		if(!$username && !$password && $this->exists()) {
			// log user
			Session::put($this->_sessionName, $this->data()->user_id);
		} else {
		
			$user = $this->find($username);
			if($user) {
				if($this->data()->password === Hash::make($password, $this->data()->salt)) {
					Session::put($this->_sessionName, $this->data()->user_id);
					
					if($remember) {
						$hash 		= Hash::unique();
						$hashCheck 	= $this->_db->get('table_users_session', array('user_id', '=', $this->data()->user_id));
						
						if(!$hashCheck->count()) {
							$this->_db->insert('table_users_session', array(
								'user_id' 	=> $this->data()->user_id,
								'hash'		=> $hash
							));
						}else {
							$hash = $hashCheck->first()->hash;
						}
						
						Cookie::put($this->_cookieName, $hash, Config::get('remember/cookie_expiry'));
						
					}
					return true;
				}
			}
		
		} //end of the else
		
		return false;
	}
	
	public function exists() {
		return (!empty($this->_data)) ? true : false;
	}
	
	public function hasPermission($key) {
		$group = $this->_db->get('table_groups', array('group_id', '=', $this->data()->grupo));
		
		if($group->count()) {
			$permissions = json_decode($group->first()->permissions, true);
			
			if($permissions[$key] == true) {
				return true;
			}
			
		}
	}
	
	public function logout() {
		$this->_db->delete('table_users_session', array('user_id', '=', $this->data()->user_id));
		Session::delete($this->_sessionName);
		Cookie::delete($this->_cookieName);
	}
	
	public function data() {
		return $this->_data;
	}
	
	public function isLoggedIn() {
		return $this->_isLoggedIn;
	}
	
	public function sendnewEmail($email, $np) {
		
		$to      = $email;
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $subject = 'Recuperação da conta';
        $message =  '
		<!DOCTYPE html>
		<html lang="pt">
		<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>Recuperar Conta</title>
        <style type="text/css">
        body{
            background: #107265;
            font-family: "Titillium Web", sans-serif;
            }
        a{
            text-decoration: none;
            color: #0066cc;
             -webkit-transition: .5s ease;
            transition: .5s ease;
        }
        a:hover {
           color: #0088cc;
        }
        h1{
            font-size: 18px;
            text-align: center;
            color: #444;
            font-weight: 300;
        }
        h2{
            text-align: center;
            color: #1ab188;
            font-weight: 1000;
        }
        span{
            color: #1ab188;
            font-weight: bold;
        }
        p{
            text-align: center;
            color: #444;
            margin: 0px 0px 50px 0px;
            padding-top: 2px;
        }
        .form{
            background: white; 
            padding: 40px;
            max-width: 600px;
            margin: 40px auto;
        }
        .button{
            font-family: "Titillium Web", sans-serif;
            border: 0;
            outline: none;
            border-radius: 0;
            padding: 15px 0;
            margin-top: 30px;
            font-size: 2rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .1em;
            background: #333;
            color: #ffffff;
            -webkit-transition: all 0.5s ease;
            transition: all 0.5s ease;
            -webkit-appearance: none;
        }
        .button:hover, .button:focus{
            background: #0088cc;
        }
        .button-block{
            display: block;
            width: 100%;
        }
        </style>
    </head>
    <body>
    <div class="form">
    <h1 style="font-size: 20px; text-align: left;">Olá <a>$email</a></h1>,<br>
    <h1>Esqueceu a sua palavra-passe?<br>
	Use esta em substituição: $np<br/>
	Considere alterar esta senha assim que entrares<br/>
    Clica no botão abaixo para iniciar sessão:<br></h1>
    <a href="http://cinkhub.com/login"><button class="button button-block">Iniciar sessão</button></a>
    </div>
    </body>
    </html>';
    mail( $to, $subject, $message, $headers );
		
	}
	
	public function send_confirmation_code($email, $confirmation_code) {
		
		$to      = $email;
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $subject = 'Recuperação da conta';
        $message =  '
		<!DOCTYPE html>
		<html lang="pt">
		<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>Recuperar Conta</title>
        <style type="text/css">
        body{
            background: #107265;
            font-family: "Titillium Web", sans-serif;
            }
        a{
            text-decoration: none;
            color: #0066cc;
             -webkit-transition: .5s ease;
            transition: .5s ease;
        }
        a:hover {
           color: #0088cc;
        }
        h1{
            font-size: 18px;
            text-align: center;
            color: #444;
            font-weight: 300;
        }
        h2{
            text-align: center;
            color: #1ab188;
            font-weight: 1000;
        }
        span{
            color: #1ab188;
            font-weight: bold;
        }
        p{
            text-align: center;
            color: #444;
            margin: 0px 0px 50px 0px;
            padding-top: 2px;
        }
        .form{
            background: white; 
            padding: 40px;
            max-width: 600px;
            margin: 40px auto;
        }
        .button{
            font-family: "Titillium Web", sans-serif;
            border: 0;
            outline: none;
            border-radius: 0;
            padding: 15px 0;
            margin-top: 30px;
            font-size: 2rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .1em;
            background: #333;
            color: #ffffff;
            -webkit-transition: all 0.5s ease;
            transition: all 0.5s ease;
            -webkit-appearance: none;
        }
        .button:hover, .button:focus{
            background: #0088cc;
        }
        .button-block{
            display: block;
            width: 100%;
        }
        </style>
    </head>
    <body>
    <div class="form">
    <h1 style="font-size: 20px; text-align: left;">Olá <a>$email</a></h1>,<br>
    <h1>Obrigado por se registar no nosso site e seja Bemvindo<br>
	Use este código para confirmar a sua conta: $confirmation_code<br/>
	Considere alterar a sua chave de acesso periodicamente para manter sua conta segura<br/>
    Clica no botão abaixo para iniciar sessão:<br></h1>
    <a href="http://cinkhub.com/login"><button class="button button-block">Iniciar sessão</button></a>
    </div>
    </body>
    </html>';
    mail( $to, $subject, $message, $headers );
		
	}
	
}