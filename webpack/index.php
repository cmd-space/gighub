<?php
if ( session_status() !== PHP_SESSION_ACTIVE ) {
	session_start();
}
//setXsrfCookie();
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8"/>
		<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
		<meta name="viewport" content="width=device-width, initial-scale=1"/>

		<!-- Google Fonts -->
		<link
			href='https://fonts.googleapis.com/css?family=Roboto:400,400italic,300,700italic,700|Playfair+Display:400,400italic'
			rel='stylesheet' type='text/css'>

		<link rel="stylesheet" href="../public_html/css/style.css">

		<base href="<?php echo dirname( $_SERVER["PHP_SELF"] ) . "/"; ?>"/>

		<title>GigHub</title>
	</head>
	<body class="sfooter">
		<!-- This custom tag much match your Angular @Component selector name in app/app.component.ts -->
		<gighub-app>Loading&hellip;</gighub-app>
	</body>
</html>