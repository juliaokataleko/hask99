<?php

function convertLink($string) {
	
	$expression = "/#+([a-zA-Z0-9_]+)/";
	$string = preg_replace($expression, '<a href="hashtag?tag=$1">$0</a>', htmlspecialchars($string));
	return $string;
	
}