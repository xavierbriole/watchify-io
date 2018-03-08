<?php

require_once 'core/init.php';

$user = new User();

if (!$user->isLoggedIn()) {
	Redirect::to('index');
} else {
	$feed = new Feed();
	$myID = $user->data()->id;
	
	function getFollowings($instance, $myID, $type) {
	  $followingsArray = array();
	  
	  foreach ($instance->getFollowings($myID) as $userID) {
	    array_push($followingsArray, $userID->youtuberID);
	  }
	
	  $followingsList = implode(',', $followingsArray);
	
	  return ($type === 'array') ? $followingsArray : $followingsList;
	}
	
	function getAllYoutuber() {
		$allYoutubersArray = array();

		for ($i = 1; $i < $feed->countYoutubers(); $i++) {
			array_push($allYoutubersArray, $i);
		}
		
		$allYoutubersList = implode(",", $monArray);
		
		return $allYoutubersList;
	}
}

?>

<?php include 'header.php'; ?>
<?php include 'admin_manage_flags_member.php'; ?>
<?php	include 'footer_member.php'; ?>

</body>
</html>