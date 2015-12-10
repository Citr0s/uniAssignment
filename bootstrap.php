<?php
require 'vendor/autoload.php';
require 'config.php';

session_start();

use Assignment\User;

$db = new mysqli(host, username, password);
$db->query("CREATE DATABASE IF NOT EXISTS " . database);
$db = new mysqli(host, username, password, database);
$db->query("CREATE TABLE IF NOT EXISTS `sessions` (
									id int NOT NULL AUTO_INCREMENT,
									session_id varchar(26),
									data varchar(255),
									modified varchar(255),
									PRIMARY KEY (id))"
								);
$db->query("CREATE TABLE IF NOT EXISTS `userdetails` (
									id int NOT NULL AUTO_INCREMENT,
									username varchar(20),
									password varchar(40),
									email varchar(50),
									url varchar(150),
									dob varchar(20),
									PRIMARY KEY (id))"
								);

$pages = array(
	array(
		'pageName' => 'registration',
		'loginRequired' => false,
	),
	array(
		'pageName' => 'secure',
		'loginRequired' => true,
	),
);

$currentPage = basename($_SERVER['REQUEST_URI'], '.php');
$user = new User();

foreach($pages as $page){
	if($page['pageName'] === $currentPage){
		if($page['loginRequired'] && !$user->isLoggedIn()){
			die('Unauthorised');
		}
	}
}