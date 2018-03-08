<?php

require_once 'core/init.php';

$user = new User();

if (!$user->isLoggedIn()) {
	Redirect::to('index');
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
}

?>

<?php include 'header.php'; ?>
<?php include 'search_member.php'; ?>
<?php include 'footer_member.php'; ?>

</body>
</html>