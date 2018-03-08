<?php
require_once 'core/init.php';

if (!$username = Input::get('user')) {
	Redirect::to('index');
} else {
	$userProfile = new User($username);
	if (!$userProfile->exists()) {
		Redirect::to(404);
	} else {
		$data = $userProfile->data();
	}
	
	$userFollowNobody = $feed->userFollowNobody($userProfile->data()->id); //boolean
	
}
?>

<body class="member">
  <!-- Navbar goes here -->
  <div class="navbar-fixed">
    <nav class="member-nav" role="navigation">
      <div class="nav-wrapper container">
				
				<!-- Desktop Version -->
				<a id="logo-container" href="<?php echo HOME_ADDRESS; ?>" class="brand-logo">watchify</a>
        
				
				
				<ul class="right hide-on-med-and-down">
          <li><a href="https://www.watchify.io/search.php"><i class="material-icons">search</i></a></li>
          <li <?php echo $data->id == $myID ? 'class="active"' : ''; ?>><a href="https://www.watchify.io/profile/<?php echo escape($user->data()->username); ?>"><i class="material-icons right">perm_identity</i><?php echo escape($user->data()->name); ?></a></li>
          <li><a href="https://www.watchify.io/settings.php"><i class="material-icons">settings</i></a></li>
          <?php
          if ($user->hasPermission('admin')) {
            echo '<li><a href="https://www.watchify.io/admin.php"><i class="material-icons">lock</i></a></li>';
          }
          ?>
          <li><a href="https://www.watchify.io/logout.php"><i class="material-icons">power_settings_new</i></a></li>
        </ul>

				<!-- Mobile Version -->
        <ul id="nav-mobile" class="side-nav">
          <?php
          if (!$userFollowNobody) {
            foreach (getFollowings($feed, $myID, 'array') as $key) {
              echo '<li><a href="https://www.watchify.io/channel/' . $feed->getYoutuberInfos($key, 'username') . '/1">' . $feed->getYoutuberInfos($key, 'name') . '</a></li>';
            }
            echo '<div class="divider"></div>';
          }
          ?>
          <li><a href="https://www.watchify.io/profile/<?php echo escape($user->data()->username); ?>"><?php echo escape($user->data()->name); ?></a></li>
          <li><a href="https://www.watchify.io/settings.php">Settings</a></li>
          <?php
          if ($user->hasPermission('admin')) {
            echo '<li><a href="https://www.watchify.io/admin.php">Admin</a></li>';
          }
          ?>
          <li><a href="https://www.watchify.io/logout.php">Logout</a></li>
        </ul>
        <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons">menu</i></a>
        <a href="https://www.watchify.io/search.php" class="nav-button-search right"><i class="material-icons">search</i></a>
      </div>
    </nav>
  </div>

  <div class="container">
    <div class="section-profile">

			<div class="row">
			  <div class="col s12">
			    
           <div class="card">
            <div class="card-image waves-effect waves-block waves-light">
              <!-- <img class="activator" src="<?php echo escape($data->coverIMG); ?>"> -->
              <img src="<?php echo escape($data->coverIMG); ?>">
            </div>
            <div class="card-content">
              <!-- <span class="card-title activator grey-text text-darken-4"> -->
              <span class="card-title grey-text text-darken-4">
                <?php echo escape($data->name); ?>
                <!-- <i class="material-icons right">more_vert</i> -->
              </span>
              <p><a href="<?php echo escape($data->username); ?>">@<?php echo escape($data->username); ?></a></p>
            </div>
            <div class="card-reveal">
              <span class="card-title grey-text text-darken-4">About me<i class="material-icons right">close</i></span>
              <p>Here is some more information about this product that is only revealed once clicked on.</p>
            </div>
          </div>
          
		      <ul class="collection with-header">
          	<li class="collection-header"><h4>Followings</h4></li>
        		<?php
        		  	function getFollowingsWithFollow($instance, $myID, $userID) {
              	  $followingsArray = array();
              	  $i = 0;
              	  
              	  foreach ($instance->getFollowingsWithFollow($myID, $userID) as $youtuber) {
              	    $followingsArray[$i]['id'] = $youtuber->id;
              	    $followingsArray[$i]['name'] = $youtuber->name;
              	    $followingsArray[$i]['profileIMG'] = $youtuber->profileIMG;
              	    $followingsArray[$i]['followed'] = $youtuber->followed;
              	    $i++;
              	  }
              	  
              	  return $followingsArray;
              	}
        		  ?>
        		  
        		  
        		  <?php
        			if (!$userFollowNobody) { 
        			  foreach (getFollowingsWithFollow($feed, $myID, $data->id) as $youtuber) {
        			?>
              
              <li class="collection-item collection-profile avatar search">
                
        		    <img src="<?php echo $feed->getYoutuberInfos($youtuber['id'], 'profileIMG'); ?>" alt="" class="circle">
        		    <span class="title"><?php echo $feed->getYoutuberInfos($youtuber['id'], 'name'); ?></span>

                <?php if ($youtuber['followed'] == 1) { ?>
                  <button type="submit" class="tooltipped hover-del-button-<?php echo $youtuber['id']; ?>" data-position="left" data-delay="10" data-tooltip="Unfollow" onclick="followAction(<?php echo $myID; ?>, <?php echo $youtuber['id']; ?>, '<?php echo addslashes($feed->getYoutuberInfos($youtuber['id'], 'name')); ?>', 2, event);">
                    <i class="material-icons">close</i>
                  </button>
                <?php } else { ?>
                  <button type="submit" class="tooltipped hover-add-button-<?php echo $youtuber['id']; ?>" data-position="left" data-delay="10" data-tooltip="Follow" onclick="followAction(<?php echo $myID; ?>, <?php echo $youtuber['id']; ?>, '<?php echo addslashes($feed->getYoutuberInfos($youtuber['id'], 'name')); ?>', 1, event);">
                    <i class="material-icons">add</i>
                  </button>
                <?php } ?>
        		    </li>
        		    <?php } ?>
        			<?php } else { ?>
        				<li class="collection-item collection-profile search">
        				<span class="title"><?php echo escape($data->username); ?> follow nobody!</span>
        				</li>
        			<?php } ?>

          </ul>
			    
			  </div>
			  
			</div>


    </div> <!-- .section -->
  </div><!-- .container -->