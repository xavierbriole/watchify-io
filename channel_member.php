<?php

$user->updateLastConnection($myID);

$userFollowNobody = $feed->userFollowNobody($myID); //boolean

$videosPerPage = 7;
if (!$userFollowNobody) {
	$videosCount = $feed->countVideos(getFollowings($feed, $myID, 'list'));
}
$pagesCount = ceil($videosCount / $videosPerPage);

function getSuggestions($instance, $myID, $type) {
  $noneFollowingsArray = array();
  
  foreach ($instance->getSuggestions($myID) as $userID) {
    array_push($noneFollowingsArray, $userID->id);
  }

  $noneFollowingsList = implode(',', $noneFollowingsArray);

  return ($type === 'array') ? $noneFollowingsArray : $noneFollowingsList;
}

function getRelativeTime($date) {
  $date_a_comparer = new DateTime($date);
  $date_actuelle = new DateTime("now");

  $intervalle = $date_a_comparer->diff($date_actuelle);

  if ($date_a_comparer < $date_actuelle) {
    $suffixe = ' ago';
  }

  $ans = $intervalle->format('%y');
  $mois = $intervalle->format('%m');
  $jours = $intervalle->format('%d');
  $heures = $intervalle->format('%h');
  $minutes = $intervalle->format('%i');
  $secondes = $intervalle->format('%s');

  if ($ans != 0) {
    $relative_date = $ans . ' year' . (($ans > 1) ? 's ' : '') . $suffixe;
  } elseif ($mois != 0) {
    $relative_date = $mois . ' months' . $suffixe;
  } elseif ($jours != 0) {
    $relative_date = $jours . ' day' . (($jours > 1) ? 's' : '') . $suffixe;
  } elseif ($heures != 0) {
    $relative_date = $heures . ' hour' . (($heures > 1) ? 's' : '') . $suffixe;
  } elseif ($minutes != 0) {
    $relative_date = $minutes . ' minute' . (($minutes > 1) ? 's' : '') . $suffixe;
  } else {
    $relative_date = ' a few seconds ' . $suffixe;
  }

  return $relative_date;
}


if (isset($_GET['page']) && !empty($_GET['page']) && $_GET['page'] > 0) {
  $_GET['page'] = intval($_GET['page']);
  $currentPage = $_GET['page'];
} else {
  $currentPage = 1;
}

$start = ($currentPage - 1) * $videosPerPage;

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
          <li><a href="https://www.watchify.io/profile/<?php echo escape($user->data()->username); ?>"><i class="material-icons right">perm_identity</i><?php echo escape($user->data()->name); ?></a></li>
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
    <div class="section-feed">
			
      <!-- Page Layout here -->
      <div class="row">

        <div class="col s12 m4 l3"> <!-- Note that "m4 l3" was added -->
      
          <?php if (!$userFollowNobody) { ?>
              <ul class="collection with-header followings">
                  <a href="<?php echo HOME_ADDRESS; ?>">
                    <li class="collection-item">
                      <i class="material-icons list">list</i>
                      <span class="youtuber-username">All channels</span>
                      <span class="new badge red" data-badge-caption=""><?php echo $feed->getAllBadges($myID); ?></span>
                    </li>
                  </a>
                  <?php
                    foreach (getFollowings($feed, $myID, 'array') as $followingID) {
                      $youtuberUsername = $feed->getYoutuberInfos($followingID, 'username');
                      $youtuberName = $feed->getYoutuberInfos($followingID, 'name');
                      echo '<div class="divider"></div>';
                      echo '<a href="https://www.watchify.io/channel/' . $youtuberUsername . '/1">
                              <li class="collection-item ' . (($_SERVER['REQUEST_URI'] === '/channel/' . $youtuberUsername . '/1') ? 'active' : '') . '">
                                <img src="' . $feed->getYoutuberInfos($followingID, 'profileIMG') . '" class="youtuber-avatar-thumb" />
                                <span class="youtuber-username">' . $youtuberName . '</span>';
                                if ($feed->displayBadge($myID, $followingID) > 0) {
                                  echo '<span class="new badge red" data-badge-caption="">' . $feed->displayBadge($myID, $followingID) . '</span>';
                                }
                        echo '</li>';
                      echo '</a>';
                    }
                  ?>
              </ul>
          <?php } ?>


        	<?php if ($feed->countFollowings($myID) < 5) { ?>
            <ul class="collection with-header suggestions">
              <li class="collection-header"><h4>Suggestions</h4></li> 
              <form method="post" name="form" style="display: inline;">               
                <?php
                  foreach (getSuggestions($feed, $myID, 'array') as $suggestionID) { ?>
                    <li class="collection-item suggestion">
                    	<div style="display: inline;">
	                    	<?php echo $feed->getYoutuberInfos($suggestionID, 'name'); ?> 
                      </div>
												
											<button type="submit" class="tooltipped add-button-<?php echo $suggestionID; ?>" data-position="left" data-delay="10" data-tooltip="Follow" onclick="followAction(<?php echo $myID; ?>, <?php echo $suggestionID; ?>, '<?php echo addslashes($feed->getYoutuberInfos($suggestionID, 'name')); ?>', 1, event);">
												<i class="material-icons">add</i>
											</button>

											<span class="del-button-<?php echo $suggestionID; ?>" style="display: none; margin-right: 5px;">
												<i class="material-icons">done</i>
											</span>
                    </li>
        		  <?php } ?>
			  </form>
            </ul>
          <?php } ?>

        </div> <!-- .col s12 m4 l3 -->



        <div class="col s12 m8 l9"> <!-- Note that "m8 l9" was added -->

        <?php if (!$userFollowNobody) { //if user follow someone ?>
		    <?php if (!empty($feed->getFeed(Input::get('username'), 1, $start, $videosPerPage))) { ?>
	            
              <div id="videos-content">

  	            <?php foreach ($feed->getFeed(Input::get('username'), 1, $start, $videosPerPage) as $video) { //display each videos ?>
  	              
                <div class="video-item">
                  
                  <ul class="collection">
  	                <li class="collection-item avatar feed-item ">
  	                  
                      <div class="feed-item-infos">
  	                    <div class="feed-item-infos-avatar" style="float: left;">
  	                      <img src="<?php echo $feed->getYoutuberInfos($video->youtuberID, 'profileIMG'); ?>" class="youtuber-avatar" />
  	                    </div>

  	                    <div class="feed-item-infos-details" style="float:left;">
  	                      <p class="video-title">
  	                        <?php echo $video->title; ?>
  	                      </p>
  	                      <p class="video-details">
  	                        <a href="https://www.watchify.io/channel/<?php echo $feed->getYoutuberInfos($video->youtuberID, 'username'); ?>/1" class="author"><?php echo $feed->getYoutuberInfos($video->youtuberID, 'name'); ?></a>
  	                        • 
  	                        <?php echo number_format($feed->getVideoViews($video->videoID), 0, '', ' '); ?> views
  	                        • 
  	                        <?php echo getRelativeTime($video->uploaded); ?>
  	                      </p>
  	                    </div>
  	                  </div>
  	                  
	                    <a class="dropdown-button menu-button" href="#" data-hover="true" data-constrainwidth="false" data-activates="dropdown-<?php echo $video->id; ?>">
	                      <i class="material-icons right">more_vert</i>
	                    </a>
	                    
	                    <ul id="dropdown-<?php echo $video->id; ?>" class="dropdown-content">
                        <li><a id="link-mark-id-<?php echo $video->id; ?>" onclick="markVideo(<?php echo $video->id; ?>,<?php echo $myID; ?>,<?php echo $video->youtuberID; ?>, '<?php echo $video->videoID; ?>', <?php echo ($feed->videoStatut($myID, $video->youtuberID, $video->videoID) >= 1) ? '1' : '2'; ?>, event)"><?php echo ($feed->videoStatut($myID, $video->youtuberID, $video->videoID) >= 1) ? 'Mark video as read' : 'Mark video as unread'; ?></a></li>
                        <li><a id="link-flag-id-<?php echo $video->id; ?>" onclick="flagVideo(<?php echo $video->id; ?>,<?php echo $myID; ?>,<?php echo $video->youtuberID; ?>, '<?php echo $video->videoID; ?>', <?php echo ($feed->flagStatut($myID, $video->youtuberID, $video->videoID) >= 1) ? '1' : '2'; ?>, event)"><?php echo ($feed->flagStatut($myID, $video->youtuberID, $video->videoID) >= 1) ? 'Unflag video' : 'Flag video'; ?></a></li>
                        <li><a onclick="Materialize.toast('Soon available!', 3000)">Watch video later</a></li>
                      </ul>

  	                  <div class="divider"></div>
  	  			            
  	                  <div class="iframe-responsive-wrapper">
    	                    <img class="iframe-ratio" src="data:image/gif;base64,R0lGODlhEAAJAIAAAP///wAAACH5BAEAAAAALAAAAAAQAAkAAAIKhI+py+0Po5yUFQA7"/>
    	                    <iframe src="https://www.youtube.com/embed/<?php echo $video->videoID; ?>?modestbranding=1&autohide=1&showinfo=0" width="640" height="360" frameborder="0" id="iframe-id-<?php echo $video->id; ?>" style="<?php echo ($feed->videoStatut($myID, $video->youtuberID, $video->videoID) >= 1) ? 'opacity: 1;' : 'opacity: 0.1;' //left: 1 - right 0.1 ?>" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
  	                  </div>

  	                </li>
  	              </ul>
                </div> <!-- .video-item -->
  	            
                <?php } ?>

              </div><!-- #video-content -->

              <div id="pagination">

                <?php

                  for ($i = 1; $i <= $pagesCount; $i++) { 
                    if ($i == $currentPage) {
                      echo $i . ' ';
                    } elseif ($i == $currentPage + 1) {
                      echo '<a href="https://www.watchify.io/channel/' . Input::get('username') . '/' . $i . '" class="next">' . $i . '</a> ';
                    }
                    else {
                      echo '<a href="https://www.watchify.io/channel/' . Input::get('username') . '/' . $i . '">' . $i . '</a> ';
                    }
                  }

                ?>

              </div>
	            
	        <?php } else { //if NO VIDEO even if user follow someone ?>
	          <ul class="collection">
              <li class="collection-item">
                <p class="row center no-feed"><i class="grande material-icons">thumb_down</i></p>
                <p class="row center no-feed"><?php echo $feed->getNameFromUsername(Input::get('username')) ?> hasn't released any video yet</p>
              </li>
            </ul>
          <?php }
	      
	      } else { //if user follow nobody ?>
	          <ul class="collection">
              <li class="collection-item">
                <p class="row center no-feed"><i class="grande material-icons">search</i></p>
                <p class="row center no-feed">Click on the search icon to start !</p>
              </li>
            </ul>
          <?php } ?>

        </div><!-- .col s12 m8 l9 -->

      </div> <!-- .row -->

    </div> <!-- .section -->
  </div><!-- .container -->