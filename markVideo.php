<?php
	
	require_once 'core/init.php';
	
	if (isset($_POST['userID']) && isset($_POST['youtuberID']) && isset($_POST['videoID']) && isset($_POST['action']) && !empty($_POST['userID']) && !empty($_POST['youtuberID']) && !empty($_POST['videoID']) && !empty($_POST['action'])) {
		$user = new User();
		$user->markVideo($_POST['userID'], $_POST['youtuberID'], $_POST['videoID'], $_POST['action']);
	}
	
	
?>
