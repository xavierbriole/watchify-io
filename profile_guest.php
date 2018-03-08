<?php
require_once 'core/init.php';

if (!$username = Input::get('user')) {
	Redirect::to('index');
} else {
	$user = new User($username);
	if (!$user->exists()) {
		Redirect::to(404);
	} else {
		$data = $user->data();
	}
}
?>

<body class="member">
  <!-- Navbar goes here -->
  <div class="navbar-fixed">
    <nav class="member-nav" role="navigation" id="navbar">
      <div class="nav-wrapper container"><a id="logo-container" href="<?php echo HOME_ADDRESS; ?>" class="brand-logo center">watchify</a>
      </div>
    </nav>
  </div>

<div class="container">
    <div class="section-profile">

			<div class="row">
			  <div class="col s12 m4 l2"></div>
			  
			  <div class="col s12 m6">
			    
			    <div class="card">
            <div class="profile-image">
              <img src="<?php echo escape($data->coverIMG); ?>" alt="" />
              <h3>
                <span class="profile-name"><?php echo escape($data->name); ?></span>
                <br>
                <span class="profile-username"><a href="<?php echo escape($data->username); ?>">@<?php echo escape($data->username); ?></a></span>
              <h3>
            </div>
          </div>
			    
		      <ul class="collection with-header collection-profile">
          	<li class="collection-header"><h4>Followings</h4></li>
          	
      			<li class="collection-item">
      			  <span class="title">Register to see who <?php echo escape($data->username); ?> is following !</span>
      			</li>
        			
        </ul>
			    
			  </div>
			  
			  <div class="col s12 m4 l2"></div>
			</div>


    </div> <!-- .section -->
  </div><!-- .container -->