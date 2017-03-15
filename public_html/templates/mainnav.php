<?php
require_once(dirname(__DIR__, 2) . "/php/classes/autoload.php");
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
?>
<nav class="navbar navbar-inverse">
	<div class="container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
		</div>
<!--		<div class="logo">-->
<!--			<div class="col-xs-12 text-center">-->
				<img class="logo-image logo center-block" src="images/logowhitehorizontal.png"/>
<!--			</div>-->
<!--		</div>-->
		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="navbar-collapse">
			<ul class="nav navbar-nav">

				<?php if(empty($_SESSION["profile"]) === false) { ?>
				<li class="active links"><a href="https://bootcamp-coders.cnm.edu/~mcrane2/gighub/public_html/profile/<?php echo $_SESSION['profile']->getProfileId(); ?>">Profile</a></li>
				<?php } ?>
				<li class="active links"><a href="https://bootcamp-coders.cnm.edu/~mcrane2/gighub/public_html/feed">Feed</a></li>
				<li class="active links"><a href="https://bootcamp-coders.cnm.edu/~mcrane2/gighub/public_html/post">post</a></li>


			</ul>

			<div class="formandsignout">
				<ul class="nav navbar-nav navbar-right">
					<li class="active links"><a href="#">Sign Out</a></li>
				</ul>
			</div>
		</div><!-- /.navbar-collapse -->
	</div><!-- /.container-fluid -->
</nav>
