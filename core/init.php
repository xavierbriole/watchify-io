<?php

session_start();

/*
	DEFINES: A few consts which can be used everywhere in every page
*/
define("HOME_ADDRESS", 'http://'.$_SERVER['SERVER_NAME']);

/*
	CONFIGURATION VARS: Provide rules for database and session configuration
*/
$GLOBALS['config'] = array(
	'mysql' => array(
		'host' => 'localhost',
		'username' => 'watchifydb',
		'password' => 'Pa5wpFJfAt8XXHHc4xHg5hbQgZwauQJy4FXp9HfJns9XwQcHVS3WtKuBrcevct8BsTmazu',
		'db' => 'watchify'
	),
	'remember' => array(
		'cookie_name' => 'hash',
		'cookie_expiry' => 604800
	),
	'session' => array(
		'session_name' => 'user',
		'token_name' => 'token'
	)
);

/*
	LOAD CLASSES: Auto-load all classes
*/
spl_autoload_register(function($class) {
	require_once 'classes/' . $class . '.php';
});

/*
	FUNCTIONS
*/
require_once 'functions/sanitize.php';

/*
	COOKIE VERIFICATION
*/
if (Cookie::exists(Config::get('remember/cookie_name')) && !Session::exists(Config::get('session/session_name'))) {
	$hash = Cookie::get(Config::get('remember/cookie_name'));
	$hashCheck = DB::getInstance()->get('watchify_sessions', array('hash', '=', $hash));
	
	if ($hashCheck->count()) {
		$user = new User($hashCheck->first()->user_id);
		$user->login();
	}
}