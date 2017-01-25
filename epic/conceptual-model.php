<!doctype html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport"
				content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title>GigHub Conceptual Model</title>
	</head>
	<body>
		<header>
			<h1>Conceptual Model</h1>
		</header>
		<main>
			<ul>
				<li>Profile</li>
				<ul>
					<li>profileId(PK)</li>
					<!--	would a FK go here to connect to oAuth entity, since oAuth technically happens before a profile is created?-->
					<li>profileUser</li>
					<li>profileLocation</li>
					<li>profileBio</li>
					<li>profileUrl</li>
					<li>profileSoundcloudUser</li>
				</ul>
				<li>oAuth</li>
				<ul>
					<li>oAuthId(PK)</li>
					<li>oAuthProfileId(FK)</li>
					<li>oAuthFacebookId</li>
					<li>oAuthTwitterId</li>
				</ul>
			</ul>
		</main>
	</body>
</html>