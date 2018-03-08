<?php

require_once 'core/init.php';
$feed = new Feed();


if ($feed->videoExist('-10puJTUZBc')) {
	echo $feed->getVideoInfos('-10puJTUZBc', 'youtuberID');
} else {
	echo 'dont exist';
}

?>