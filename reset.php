<?php

/*
	Executed everyday at 10pm
*/

require_once 'core/init.php';

$parser = new Parser();

$parser->dropColumn();
$parser->setAutoIncrement();
$parser->reInsertVideos();


?>