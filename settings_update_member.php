<?php

if (!$user->isLoggedIn()) {
	Redirect::to('index');
}


if (Input::exists()) {
	if (Token::check(Input::get('token'))) {

		$validate = new Validate();
		$validation = $validate->check($_POST, array(
      'name' => array(
				'required' => true,
				'min' => 2,
				'max' => 50
			),
			'username' => array(
				'min' => 2,
				'max' => 20,
				'unique' => 'watchify_users'
			),
			'email' => array(
				'required' => true
			)
		));

		if ($validation->passed()) {
			
			try {
			  
		    	$user->update(array(
	      	'name' => (Input::get('name') == $user->data()->username ? $user->data()->username : Input::get('name')),
					'email' => (Input::get('email') == $user->data()->email ? $user->data()->email : Input::get('email'))
				));
        
				Session::flash('update', '
				<div class="card-panel teal lighten-2">
				  <i class="material-icons white-text left">done</i>
				  <span class="white-text">Your profile have been updated !</span>
				</div>');
				Redirect::to('update');

			} catch (Exception $e) {
				die($e->getMessage());
			}

		} else {
			foreach ($validation->errors() as $error) {
				Session::flash('update', '
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
        if (Session::exists('update')) {
        	echo '<p>' . Session::flash('update') . '</p>';
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
							
								<h5 class="settings-title">Update Profile</h5>
										
								<div class="divider"></div>

								<div class="collection-content">
      							
      							<div class="col s12">
											<div class="row">
												
										    <form action="" method="post" class="col s12" id="profileForm" novalidate="novalidate">
										    	
										      <div class="row">
										        <div class="input-field col s12">
										          <input name="username" id="username" value="<?php echo escape($user->data()->username); ?>" type="text" disabled>
										          <label for="username">Username</label>
										        </div>
										      </div>
										    	
										      <div class="row">
										        <div class="input-field col s12">
										          <input name="name" id="name" placeholder="Full name" value="<?php echo escape($user->data()->name); ?>" type="text" autocomplete="off" required="" aria-required="true">
										          <!--<label for="name">Name</label>-->
										        </div>
										      </div>
										      
										      <div class="row">
										        <div class="input-field col s12">
										          <input name="email" id="email" placeholder="E-mail" value="<?php echo escape($user->data()->email); ?>" type="email" autocomplete="off" required="" aria-required="true">
										          <!--<label for="email">Email</label>-->
										        </div>
										      </div>

										  </div> <!-- .row -->
      							</div> <!-- .col s6 -->
      						</div> <!-- .collection-content -->

							</li> <!-- .collection-item -->
						</ul> <!-- .collection -->

						  
						  <button class="btn waves-effect waves-light right" type="submit" id="changeProfile" name="changeProfile">Save
			                <i class="material-icons left">done</i>
			              </button>
						  
							<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
					
					</form> <!-- .col s12 -->

        </div><!-- .col s12 m8 l9 -->

      </div> <!-- .row -->

    </div> <!-- .section -->
  </div><!-- .container -->