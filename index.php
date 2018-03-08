<?php

require_once 'core/init.php';

$user = new User();

?>

<?php include 'header.php'; ?>

	<?php

	if ($user->isLoggedIn()) {
		echo '<body class="member">';
		include 'feed_member.php';
		include 'footer_member.php';

	} else {
		echo '<body class="guest">';
		include 'feed_guest.php';
		include 'footer.php';
	}

	?>

</body>
</html>