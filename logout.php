<?php
require_once 'core/init.php';
require_once'functions/functions.php';
acessLog($absolute_url);

$user = new User();
$user->logout();

Redirect::to('index');