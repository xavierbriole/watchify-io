<?php
	
	require_once 'core/init.php';
	
	if (isset($_POST['userID']) && isset($_POST['youtuberID']) && isset($_POST['action']) && !empty($_POST['userID']) && !empty($_POST['youtuberID']) && !empty($_POST['action'])) {
		$user = new User();
		$youtuber = new Youtuber();
		
		$user->followAction($_POST['userID'], $_POST['youtuberID'], $_POST['action']);
		
		if ($_POST['action'] == '1') {
			foreach ($youtuber->getAllVideosID($_POST['youtuberID']) as $videos) {
				$user->addBadge($_POST['userID'], $_POST['youtuberID'], $videos->videoID);
			}
		} elseif ($_POST['action'] == '2') {
			foreach ($youtuber->getAllVideosID($_POST['youtuberID']) as $videos) {
				$user->removeBadge($_POST['userID'], $_POST['youtuberID'], $videos->videoID);
			}
		}

	}
	
	
?>
