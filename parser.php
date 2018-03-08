<?php

/*
	Executed every 1min
*/

require_once 'core/init.php';
$parser = new Parser();
$user = new User();

$count = $parser->youtubersCount();


for ($youtuberID = 1; $youtuberID <= $count; $youtuberID++) {

	$channelID = $parser->getYoutuberInfos($youtuberID, 'channelID');
	//echo '[#' . $youtuberID . '] Checking channelID : ' . $channelID . ' .......<br>';

	//NEW INFORMATIONS
	$modulo = $youtuberID % 10;
	$JSON = $parser->getJSON($channelID, $modulo);
	
	if ($JSON != false) {

		$newVideoID = json_decode($JSON, true)['items'][0]['id']['videoId'];

		if (!isset($newVideoID)) continue;

		//NEW INFORMATIONS
		$newVideoTitle = json_decode($JSON, true)['items'][0]['snippet']['title'];
		$newVideoDate = json_decode($JSON, true)['items'][0]['snippet']['publishedAt'];
		$newVideoDateFormated = substr(str_replace('T', ' ', $newVideoDate), 0, -5);
		
		//OLD INFORMATIONS
		$oldVideoID = $parser->getVideoInfos($youtuberID, 'videoID');
		$oldVideoTitle = $parser->getVideoInfos($youtuberID, 'title');
		$oldVideoDate = $parser->getVideoInfos($youtuberID, 'uploaded');
		
		//COMPARAISON
		if ($newVideoID != $oldVideoID) {
			
				$parser->addVideo($youtuberID, 'https://www.youtube.com/watch?v=' . $newVideoID, $newVideoID, $newVideoTitle, $newVideoDateFormated);
				
				$userID = $user->getUserIDwhoFollowYoutuberID($youtuberID);
				
				if (is_array($userID) || is_object($userID)) {
					foreach ($userID as $results) {
						//echo 'addBadge(userID -> ' . $results->userID . ', youtuberID -> ' . $youtuberID . ', newVideoID -> ' . $newVideoID . ')<br>';
						$user->addBadge($results->userID, $youtuberID, $newVideoID);
					}
				}
				
		}
		
		$parser->removeVideosWithoutVideoID();
		$parser->removeDuplicatesByVideoID();
		$parser->removeDuplicatesByTitle();
		$parser->removeDuplicatesBadges();
		
		//echo '<br><br>';
	
	} else {
		
		//echo 'Error';
		break;
		
	}

}

?>