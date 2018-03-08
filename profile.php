<?php

require_once 'core/init.php';

$user = new User();

include 'header.php';

if (!$user->isLoggedIn()) {
	include 'profile_guest.php';
	include 'footer.php';
} else {
	$feed = new Feed();
	$myID = $user->data()->id;
	$userFollowNobody = $feed->userFollowNobody($myID); //boolean
	
	function getFollowings($instance, $myID, $type) {
	  $followingsArray = array();
	  
	  foreach ($instance->getFollowings($myID) as $userID) {
	    array_push($followingsArray, $userID->youtuberID);
	  }
	
	  $followingsList = implode(',', $followingsArray);
	
	  return ($type === 'array') ? $followingsArray : $followingsList;
	}
	
	include 'profile_member.php';
	include 'footer_member.php';
}



?>

</body>
</html>