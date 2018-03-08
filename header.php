<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
  <?php
  	if ($user->isLoggedIn()) {
	  	echo '<title>watchify</title>';
		} else {
			echo '<title>Sign up or Login | watchify</title>';
		}
  ?>
  
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
  <link href="https://www.watchify.io/css/sanfrancisco-font.css" type="text/css" rel="stylesheet">
  
  <!-- CSS  -->
  <link href="https://www.watchify.io/css/materialize.min.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="https://www.watchify.io/css/app.min.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  
  <!-- JQuery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  
  <!-- Scripts -->
  <script type="text/javascript">window.$crisp=[];window.CRISP_WEBSITE_ID="dd41c838-d24a-409b-8c92-f1e50b446995";(function(){d=document;s=d.createElement("script");s.src="https://client.crisp.im/l.js";s.async=1;d.getElementsByTagName("head")[0].appendChild(s);})();</script>
</head>