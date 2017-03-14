<?php
require_once(dirname(__DIR__, 2) . "/php/classes/autoload.php");
require_once(dirname(__DIR__, 2) . "/php/lib/xsrf.php");
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
?>
<main-nav></main-nav>
<h1>{{ venue.venueName }}</h1>
