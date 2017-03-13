<?php require_once("lib/head-utils.php"); ?>

<body>

	<!-------Make the login buttons work---->
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if(d.getElementById(id)) return;
			js = d.createElement(s);
			js.id = id;
			js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.8&appId=1878867439052171";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));</script>

	<div class="container center-splash">
		<!-------GigHub Logo------->
		<img src="../../public_html/images/GigHubWhite.png" class="img-responsive center-block">

		<!-------Button for desktop (FB login)------->
		<div class="fb-login-button visible-md-inline visible-lg-inline" data-max-rows="1" data-size="xlarge"
			  data-show-faces="false" data-auto-logout-link="false"></div><br>

		<!-------Button for tablet (FB login)------->
		<div class="fb-login-button visible-sm-inline" data-max-rows="1" data-size="large"
			  data-show-faces="false" data-auto-logout-link="false"></div>

		<!-------Button for mobile (FB login)------->
		<div class="fb-login-button visible-xs-inline" data-max-rows="1" data-size="medium"
			  data-show-faces="false" data-auto-logout-link="false"></div>
	</div>

</body>

</html>