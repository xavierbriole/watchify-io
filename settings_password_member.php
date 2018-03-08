<?php

if (!$user->isLoggedIn()) {
	Redirect::to('index');
}


if (Input::exists()) {
	if (Token::check(Input::get('token'))) {

		$validate = new Validate();
		$validation = $validate->check($_POST, array(
			'password_current' => array(
				'required' => true
			),
			'password_new' => array(
				'required' => true,
				'min' => 6
			),
			'password_new_again' => array(
				'required' => true,
				'min' => 6,
				'matches' => 'password_new'
			)
		));

		if ($validation->passed()) {

			if (Hash::make(Input::get('password_current'), $user->data()->salt) !== $user->data()->password) {
				Session::flash('password', '
				<div class="card-panel red darken-1">
				  <i class="material-icons white-text left">error</i>
				  <span class="white-text">Your current password is wrong</span>
				</div>');
			} else {
				$salt = Hash::salt(32);
				$user->update(array(
					'password' => Hash::make(Input::get('password_new'), $salt),
					'salt' => $salt
				));

				Session::flash('password', '
				<div class="card-panel teal lighten-2">
				  <i class="material-icons white-text left">done</i>
				  <span class="white-text">Your password have been changed !</span>
				</div>');
				Redirect::to('password');
			}

		} else {
			foreach ($validation->errors() as $error) {
				Session::flash('password', '
				<div class="card-panel red darken-1">
				  <i class="material-icons white-text left">error</i>
				  <span class="white-text">' . $error . '</span>
				</div>');
			}
		}

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
          <li class="active"><a href="https://www.watchify.io/settings.php"><i class="material-icons">settings</i></a></li>
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
    <div class="section-settings">
			
			
      <!-- Page Layout here -->
      <div class="row">
        
        
        <?php
        if (Session::exists('password')) {
        	echo '<p>' . Session::flash('password') . '</p>';
        }
        ?>

        <div class="col s12 m4 l3"> <!-- Note that "m4 l3" was added -->
              <ul class="collection with-header">
                <li class="collection-header"><h4>Settings</h4></li>
                  <a href="update.php"><li class="collection-item"><div>Update Profile</div></li></a>
                  <a href="password.php"><li class="collection-item"><div>Change Password</div></li></a>
              </ul>
        </div> <!-- .col s12 m4 l3 -->


        <div class="col s12 m8 l9"> <!-- Note that "m8 l9" was added -->

						<ul id="profile" class="collection">
							<li class="collection-item setting">
							
								<h5 class="settings-title">Change Password</h5>
										
								<div class="divider"></div>

								<div class="collection-content">
      							
      							<div class="col s12">
											<div class="row">
												
										    <form action="" method="post" class="col s12" id="passwordForm" novalidate="novalidate">
										    	
										      <div class="row">
										        <div class="input-field col s12">
										        	<input type="password" name="password_current" id="password_current" placeholder="Current password" required="" aria-required="true">
										          <!--<label for="password_current">Current password</label>-->
										        </div>
										      </div>
										      
										      <div class="row">
										        <div class="input-field col s12">
										        	<input type="password" name="password_new" id="password_new" placeholder="New password" required="" aria-required="true">
										          <!--<label for="password_new">New password</label>-->
										        </div>
										      </div>
										      
										      <div class="row">
										        <div class="input-field col s12">
										        	<input type="password" name="password_new_again" id="password_new_again" placeholder="Repeat new password" required="" aria-required="true">
										          <!--<label for="password_new_again">New password again</label>-->
										        </div>
										      </div>

										  </div> <!-- .row -->
      							</div> <!-- .col s6 -->
      						</div> <!-- .collection-content -->

							</li> <!-- .collection-item -->
						</ul> <!-- .collection -->

							<!--<button class="btn waves-effect waves-light right" type="submit" name="action">Save-->
							<!--   <i class="material-icons right">done</i>-->
						 	<!-- </button>-->
						  
						  <!--<input type="submit" value="Update" class="btn waves-effect waves-light right">-->
						  
						  <button class="btn waves-effect waves-light right" type="submit" id="changePassword" name="changePassword">Save
                <i class="material-icons left">done</i>
              </button>
						  
							<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
					
					</form> <!-- .col s12 -->

        </div><!-- .col s12 m8 l9 -->

      </div> <!-- .row -->

    </div> <!-- .section -->
  </div><!-- .container -->