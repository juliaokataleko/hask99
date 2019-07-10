<?php
//este ficheiro deve rodar antes do session_start nos ficheiros pretendidos
ini_set('session.auto_start','0');
ini_set('session.use_cookies','1');
ini_set('session.use_only_cookies','1');
ini_set('session.use_trans_sid','0');
ini_set('session.cache_limiter','nocache');
ini_set('session.use_strict_mode','1');
ini_set('session.name','PP');
ini_set('session.cookie_domain','');
ini_set('session.cookie_path','');
ini_set('session.cookie_lifetime','0');
ini_set('session.cookie_httponly','1');
ini_set('session.cookie_secure','1');

ini_set('session.gc_maxlifetime','1440');
?>