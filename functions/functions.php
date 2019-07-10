<?php
//para as hashtags
function convertLink($string) {
	
	$expression = "/#+([a-zA-Z0-9_]+)/";
	$string = preg_replace($expression, '<a href="hashtag?tag=$1">$0</a>', htmlspecialchars($string));
	return $string;
	
}

//pegando o url original
function url_origin( $s, $use_forwarded_host = false )
{
    $ssl      = ( ! empty( $s['HTTPS'] ) && $s['HTTPS'] == 'on' );
    $sp       = strtolower( $s['SERVER_PROTOCOL'] );
    $protocol = substr( $sp, 0, strpos( $sp, '/' ) ) . ( ( $ssl ) ? 's' : '' );
    $port     = $s['SERVER_PORT'];
    $port     = ( ( ! $ssl && $port=='80' ) || ( $ssl && $port=='443' ) ) ? '' : ':'.$port;
    $host     = ( $use_forwarded_host && isset( $s['HTTP_X_FORWARDED_HOST'] ) ) ? $s['HTTP_X_FORWARDED_HOST'] : ( isset( $s['HTTP_HOST'] ) ? $s['HTTP_HOST'] : null );
    $host     = isset( $host ) ? $host : $s['SERVER_NAME'] . $port;
    return $protocol . '://' . $host;
}

//pegando a url completa
function full_url( $s, $use_forwarded_host = false )
{
    return url_origin( $s, $use_forwarded_host ) . $s['REQUEST_URI'];
}

//registando a actividade do usuário
$absolute_url = full_url($_SERVER);
function acessLog($absolute_url) { 
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
	} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
		$ip = $_SERVER['REMOTE_ADDR'];
}
$query = DB::getInstance();
$query->insert('table_acessLog', array(
	'ip' => $ip,
	'url' => $absolute_url
));

}

function uniqueAlfa($length=16)
{
 $salt = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
 $len = strlen($salt);
 $pass = '';
 mt_srand(10000000*(double)microtime());
 for ($i = 0; $i < $length; $i++)
 {
   $pass .= $salt[mt_rand(0,$len - 1)];
 }
 return $pass;
}