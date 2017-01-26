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
				<li>Profile
				   <ol>
					   <li>profileId(PK)</li>
					   <li>profileOAuthId(FK?)</li>
					   <li>profileUserName</li>
					   <li>profileLocation</li>
					   <li>profileBio</li>
					   <li>profileUrl</li>
					   <li>profileSoundCloudUser</li>
						<li>profileImageCloudinaryId</li>
						<li>profileType</li>
				   </ol>
				</li>
				<li>OAuth
				   <ol>
					   <li>oAuthId(PK)</li>
					   <li>oAuthProfileId(FK)</li>
					   <li>oAuthFacebookId</li>
					   <li>oAuthTwitterId</li>
				   </ol>
				</li>
				<li>Post
					<ol>
						<li>postId(PK)</li>
						<li>postProfileId(FK)</li>
						<li>postTitle</li>
						<li>postLocation</li>
						<li>postContent</li>
						<!-- postGoogleMap is still not decided -->
						<li>postGoogleMap</li>
						<li>postEventDate</li>
						<li>postCreatedDate</li>
						<li>postImageCloudinaryId</li>
					</ol>
				</li>
				<li>Tag
					<ol>
						<li>tagId(PK)</li>
						<li>tagContent</li>
					</ol>
				</li>
				<li>Post Tag
					<ol>
						<li>postTagTagId(FK)</li>
						<li>postTagPostId(FK)</li>
					</ol>
				</li>
				<li>Profile Tag
					<ol>
						<li>profileTagTagId(FK)</li>
						<li>profileTagProfileId(FK)</li>
					</ol>
				</li>
<!--				<li>Profile Image-->
<!--					<ol>-->
<!--						<li>profileImageId(PK)</li>-->
<!--						<li>profileImageProfileId(FK)</li>-->
<!--						<li>profileImageUploadFileName</li>-->
<!--						<li>profileImageUrl</li>-->
<!--					</ol>-->
<!--				</li>-->
			</ul>
		</main>
	</body>
</html>