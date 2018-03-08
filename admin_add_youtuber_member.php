<?php

if (!$user->isLoggedIn()) {
	Redirect::to('index');
}


if (Input::exists()) {

			try {
			  $youtuber = new Youtuber();

		    if (substr(Input::get('username'), 0, 2 ) === "UC") {
		      
		      $usernameStrLower = str_replace(str_split('\' '), '', strtolower(substr(Input::get('name'), strrpos(Input::get('name'), '/'))));
		      $channelID = Input::get('username'); //(username input when channelID setted)
		      
 		      $youtuber->add(
    		      $usernameStrLower, //username
    		      Input::get('name'), //name
    		      $channelID, //channelID
    		      $youtuber->getYoutuberProfileIMG($channelID) //profileIMG
  		    );
		    } else {
		      
		      $usernameStrLower = str_replace(str_split('\' '), ' ', strtolower(substr(Input::get('username'), strrpos(Input::get('username'), '/'))));
		      $channelID = $youtuber->getChannelID($usernameStrLower);
          
          $youtuber->add(
    		      $usernameStrLower, //username
    		      Input::get('name'), //name
    		      $channelID, //channelID
    		      $youtuber->getYoutuberProfileIMG($channelID) //profileIMG
  		    );
		    }
        
				Session::flash('add_youtuber', '
				<div class="card-panel teal lighten-2">
				  <i class="material-icons white-text left">done</i>
				  <span class="white-text">Youtuber added with success!</span>
				</div>');
				Redirect::to('add_youtuber');

			} catch (Exception $e) {
				die($e->getMessage());
			}
			
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
          <li><a href="https://www.watchify.io/profile/<?php echo escape($user->data()->username); ?>"><i class="material-icons right">perm_identity</i><?php echo escape($user->data()->name); ?></a></li>
          <li><a href="https://www.watchify.io/settings.php"><i class="material-icons">settings</i></a></li>
          <?php
          if ($user->hasPermission('admin')) {
            echo '<li class="active"><a href="https://www.watchify.io/admin.php"><i class="material-icons">lock</i></a></li>';
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
    <div class="section-settings">
			
			
      <!-- Page Layout here -->
      <div class="row">
        
        
        <?php
        if (Session::exists('add_youtuber')) {
        	echo '<p>' . Session::flash('add_youtuber') . '</p>';
        }
        ?>

        <div class="col s12 m4 l3"> <!-- Note that "m4 l3" was added -->
              <ul class="collection with-header">
                <li class="collection-header"><h4>Admin</h4></li>
                  <a href="add_youtuber.php"><li class="collection-item"><div>Add Youtuber</div></li></a>
                  <a href="manage_videos.php"><li class="collection-item"><div>Manage Videos</div></li></a>
                  <a href="manage_users.php"><li class="collection-item"><div>Manage Users</div></li></a>
              </ul>
        </div> <!-- .col s12 m4 l3 -->


        <div class="col s12 m8 l9"> <!-- Note that "m8 l9" was added -->

						<ul id="profile" class="collection">
							<li class="collection-item setting">
							
								<h5 class="settings-title">Add Youtuber</h5>
										
								<div class="divider"></div>

								<div class="collection-content">
      							
      							<div class="col s12">
											<div class="row">
												
										    <form action="" method="post" class="col s12" id="youtuberForm" novalidate="novalidate">
										    	
										      <div class="row">
										        <div class="input-field col s12">
										          <input name="username" id="username" placeholder="Username on YouTube or ChannelID" value="" type="text" autocomplete="off" required="" aria-required="true">
										          <!--<label for="username">Username</label>-->
										        </div>
										      </div>
										    	
										      <div class="row">
										        <div class="input-field col s12">
										          <input name="name" id="name" placeholder="Display name" value="" type="text" autocomplete="off" required="" aria-required="true">
										          <!--<label for="name">Name</label>-->
										        </div>
										      </div>

										  </div> <!-- .row -->
      							</div> <!-- .col s6 -->
      						</div> <!-- .collection-content -->

							</li> <!-- .collection-item -->
						</ul> <!-- .collection -->

						  
						  <button class="btn waves-effect waves-light right" type="submit" id="addYoutuber" name="addYoutuber">Add
			                <i class="material-icons left">done</i>
			              </button>
						  
					</form> <!-- .col s12 -->

        </div><!-- .col s12 m8 l9 -->

      </div> <!-- .row -->

    </div> <!-- .section -->
  </div><!-- .container -->