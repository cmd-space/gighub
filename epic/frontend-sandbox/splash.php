<!DOCTYPE html>
<html lang="en">

<?php require_once("lib/head-utils.php");?>

<body>

	<div id="fb-root"></div>
	<script>(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.8&appId=1878867439052171";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));</script>


<div class="container">
	<img src="../images/GigHubWhite.png">
</div>
	<div class="container">
		<div class="fb-login-button" data-max-rows="1" data-size="medium" data-show-faces="false" data-auto-logout-link="false"></div>
	</div>

</body>

</html>x