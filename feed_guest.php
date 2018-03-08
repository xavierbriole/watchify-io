<?php

require_once 'core/init.php';


if (!empty($_POST['login'])) {

	if (Input::exists()) {
	// 	if (Token::check(Input::get('token'))) {
	
			$validate = new Validate();
			$validation = $validate->check($_POST, array(
				'username' => array('required' => true),
				'password' => array('required' => true)
			));
	
			if ($validation->passed()) {
				$user = new User();
	
				$remember = (Input::get('remember') === 'on') ? true : false;
				$login = $user->login(Input::get('username'), Input::get('password'), $remember);
	
				if ($login) {
					Redirect::to('index');
				} else {
					Session::flash('login', '
					<script>$(document).ready(function(){ $("#login").openModal(); });</script>
					<div class="card-panel red darken-1">
					  <i class="material-icons white-text left">error</i>
					  <span class="white-text">Sorry, login failed !</span>
					</div>');
				}
	
			} else {
				foreach ($validation->errors() as $error) {
					Session::flash('login', '
					<script>$(document).ready(function(){ $("#login").openModal(); });</script>
					<div class="card-panel red darken-1">
					  <i class="material-icons white-text left">error</i>
					  <span class="white-text">' . $error . '</span>
					</div>');
				}
			}
	// 	}
	}

}

if (!empty($_POST['register'])) {
	
	if (Input::exists()) {
// 		if (Token::check(Input::get('token'))) {
					
			$validate = new Validate();
			$validation = $validate->check($_POST, array(
				'username' => array(
					'required' => true,
					'min' => 2,
					'max' => 20,
					'unique' => 'watchify_users'
				),
				'choose_password' => array(
					'required' => true,
					'min' => 6
				),
				'password_again' => array(
					'required' => true,
					'matches' => 'choose_password'
				),
				'name' => array(
					'required' => true,
					'min' => 2,
					'max' => 50
				),
				'email' => array(
					'required' => true
				),
			));
			
			if ($validation->passed()) {
				$user = new User();
				
				$salt = Hash::salt(32);
				
				try {
					
					$user->create(array(
						'username' => Input::get('username'),
						'password' => Hash::make(Input::get('choose_password'), $salt),
						'salt' => $salt,
						'name' => Input::get('name'),
						'email' => Input::get('email'),
						'coverIMG' => 'https://www.watchify.io/img/cover.png',
						'joined' => date('Y-m-d H:i:s'),
						'last_seen' => date('Y-m-d H:i:s'),
						'group_id' => 1
					));
					
					Session::flash('login', '
					<script>$(document).ready(function(){ $("#login").openModal(); });</script>
					<div class="card-panel teal lighten-2">
					  <i class="material-icons white-text left">done</i>
					  <span class="white-text">You have been registered and now can login !</span>
					</div>');
					
				} catch (Exception $e) {
					die($e->getMessage());
				}
			} else {
				foreach ($validation->errors() as $error) {
					Session::flash('register', '
					<script>$(document).ready(function(){ $("#register").openModal(); });</script>
					<div class="card-panel red darken-1">
					  <i class="material-icons white-text left">error</i>
					  <span class="white-text">' . $error . '</span>
					</div>');
				}
			}
	
// 		}
	}
	
}
?>
  <nav class="guest-nav-trans" role="navigation" id="navbar-guest">
    <div class="nav-wrapper container"><a id="logo-container" href="<?php echo HOME_ADDRESS; ?>" class="brand-logo">watchify</a>
      <ul class="right hide-on-med-and-down">
        <li><a class="modal-trigger white-text" href="#login">Login</a></li>
        <li><a class="modal-trigger white-text" href="#register">Register</a></li>
      </ul>

      <ul id="nav-mobile" class="side-nav">
        <li><a class="modal-trigger mobile" href="#login">Login</a></li>
        <li><a class="modal-trigger mobile" href="#register">Register</a></li>
      </ul>
      <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons">menu</i></a>
    </div>
  </nav>
  
  <div class="section no-pad-bot" id="index-banner">
	
		<div id="login" class="modal bottom-sheet">
		    <div class="modal-content">
		    	<div class="row">

				  <?php
			      if (Session::exists('login')) {
			      	echo '<p>' . Session::flash('login') . '</p>';
			      }
			      ?>

					<form action="" method="post" class="col s12" id="loginForm" novalidate="novalidate">
						<div class="row">
							<div class="input-field col s12">
								<input type="text" name="username" id="username" placeholder="Username" autocomplete="off" required="" aria-required="true">
								<!--<label for="username">Username</label>-->
							</div>
							
							<div class="input-field col s12">
								<input type="password" name="password" id="password" placeholder="Password" autocomplete="off" required="" aria-required="true">
								<!--<label for="password">Password</label>-->
							</div>
							
							<div class="row center">
						    	<input type="checkbox" name="remember" id="remember" />
						    	<label for="remember">Remember me</label>
							</div>

							<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
							
							<div class="row center">
								<input type="submit" id="loginButton" name="login" value="Login" class="btn-large waves-effect waves-light red accent-3" />
							</div>
						</div> <!-- .row -->
					</form>

				</div> <!-- .row -->
		    </div> <!-- .modal-content -->
		</div> <!--#login -->

		<div id="register" class="modal bottom-sheet">
		    <div class="modal-content">
			    <div class="row">
				
    			  <?php
			      if (Session::exists('register')) {
			      	echo '<p>' . Session::flash('register') . '</p>';
			      }
			      ?>

					<form action="" method="post" class="col s12" id="registerForm" novalidate="novalidate">
						<div class="row">
							<div class="input-field col s12">
								<input type="text" name="username" id="username" placeholder="Username" value="<?php echo escape(Input::get('username')); ?>" autocomplete="off" required="" aria-required="true">
								<!--<label for="username">Username</label>-->
							</div>
							
							<div class="input-field col s12">
								<input type="password" name="choose_password" id="choose_password" placeholder="Password" required="" aria-required="true">
								<!--<label for="choose_password">Password</label>-->
							</div>
						
							<div class="input-field col s12">
								<input type="password" name="password_again" id="password_again" placeholder="Repeat password" required="" aria-required="true">
								<!--<label for="password_again">Repeat password</label>-->
							</div>
						
							<div class="input-field col s12">
								<input type="text" name="name" id="name" placeholder="Full name" value="<?php echo escape(Input::get('name')); ?>" autocomplete="off" required="" aria-required="true">
								<!--<label for="name">Full name</label>-->
							</div>

							<div class="input-field col s12">
								<input type="email" name="email" id="email" placeholder="E-mail" value="<?php echo escape(Input::get('email')); ?>" autocomplete="off" required="" aria-required="true">
								<!--<label for="email">Email</label>-->
							</div>
						
							<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
						
							<div class="row center">
								<input type="submit" id="registerButton" name="register" value="Register" class="btn-large waves-effect waves-light red accent-3" />
							</div>
						</div> <!-- .row -->
					</form>
				
		    	</div> <!-- .row -->
		    </div> <!-- .modal-content -->
		</div> <!--#register -->

		<div class="row center">
			<br>
			<h1 class="header center white-text">Follow your favorites YouTube channels</h1>
			<h5 class="header col s12 light">Take a seat and watch the last videos from the most popular YouTubers</h5>
		</div> <!-- .row center -->
	
	  
		<div class="row center">
			<img src="img/preview.png" class="responsive-img">
		</div>

  </div> <!-- .section no-pad-bot #index-banner -->