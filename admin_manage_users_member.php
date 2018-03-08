<?php

if (!$user->isLoggedIn()) {
	Redirect::to('index');
}


if (Input::exists()) {

			try {
			  /*$youtuber = new Youtuber();
		    $youtuber->add(Input::get('username'), Input::get('name'), Input::get('channelID'), Input::get('profileIMG'));
        
				Session::flash('add_youtuber', '
				<div class="card-panel teal lighten-2">
				  <i class="material-icons white-text left">done</i>
				  <span class="white-text">Youtuber added with success!</span>
				</div>');
				Redirect::to('add_youtuber');*/

			} catch (Exception $e) {
				die($e->getMessage());
			}
			
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
							
								<h5 class="settings-title">Manage Users</h5>
										
								<div class="divider"></div>

								<div class="collection-content">

										<table class="highlight">
                      
                      <thead>
                        <tr>
                            <th data-field="username">Username</th>
                            <th data-field="name">Name</th>
                            <th data-field="email">Email</th>
                            <th data-field="last_seen">Last seen</th>
                            <th data-field="action">Action</th>
                        </tr>
                      </thead>
                      
                      <tbody>
                        
                        <?php foreach ($user->getUsers(0, 49) as $userItem) {
                          echo '<tr>';
                            echo '<td>' . $userItem->username . '</td>';
                            echo '<td>' . $userItem->name . '</td>';
                            echo '<td>' . $userItem->email . '</td>';
                            echo '<td>' . getRelativeTime($userItem->last_seen) . '</td>';
                            echo '<td>
                            
                              <center>
                                <a class="waves-effect waves-light btn" href="https://www.watchify.io/profile/' . $userItem->username . '">
                                  <i class="small material-icons">perm_identity</i>
                                </a>
                                <a class="waves-effect waves-light btn" onclick="openModal(' . $userItem->id . ');">
                                  <i class="small material-icons">delete</i>
                                </a>
                              </center>
                              
                              <div id="modal' . $userItem->id . '" class="modal">
                                <div class="modal-content">
                                  <h4>Delete</h4>
                                  <p>' . $userItem->username . '</p>
                                </div>
                                <div class="modal-footer">
                                  <a onclick="closeModal(' . $userItem->id . ');" class="waves-effect waves-light btn-flat">
                                    <i class="material-icons">close</i>
                                  </a>
                                  <a onclick="closeModal(' . $userItem->id . ');" class="waves-effect waves-light btn-flat">
                                    <i class="material-icons">delete</i>
                                  </a>
                                </div>
                              </div>
                              
                              </td>';
                          echo '</tr>';
                        }
                        ?>
                      </tbody>
                      
                      <script>
                      var openModal = function(id){
                        $("#modal" + id).openModal();
                      };
                      var closeModal = function(id){
                        $("#modal" + id).closeModal();
                      };
                      </script>
                      
                    </table>

								</div>		    

              </li>
            
            </ul>
          

        </div><!-- .col s12 m8 l9 -->

      </div> <!-- .row -->

    </div> <!-- .section -->
  </div><!-- .container -->