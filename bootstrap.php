<?php
require 'vendor/autoload.php';

$pages = array(
	array(
		'pageName' => 'registration',
		'loginRequired' => false,
	),
	array(
		'pageName' => 'secret',
		'loginRequired' => true,
	),
);

checkIfRestricted($pages, 'secret'); //pass filename

function checkIfRestricted($pages, $currentPage){
	//if logged in and restricted - redicrect
	//if not logged in and restricted - show message

	foreach($pages as $page){
		if($page['pageName'] == $page){
			if($page['loginRequired'] && loggedIn()){
				header('Location: index.php');
			}else{
				die('Restricted access.');
			}
		}
	}
}