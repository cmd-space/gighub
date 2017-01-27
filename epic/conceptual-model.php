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
						<li>profileOAuthToken</li>
					   <li>profileUserName</li>
					   <li>profileLocation</li>
					   <li>profileBio</li>
					   <li>profileUrl</li>
					   <li>profileSoundCloudUser</li>
						<li>profileImageCloudinaryId</li>
						<li>profileTypeId(FK)</li>
				   </ol>
				</li>
				<li>OAuth
				   <ol>
					   <li>oAuthId(PK)</li>
					   <li>oAuthServiceName</li>
				   </ol>
				</li>
				<li>Post
					<ol>
						<li>postId(PK)</li>
						<li>postProfileId(FK)</li>
						<li>postTitle</li>
						<li>postLocationAddress</li>
						<li>postVenueId(FK)</li>
						<li>postContent</li>
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
				<li>Venue
					<ol>
						<li>venueId(PK)</li>
						<li>venueProfileId(FK)</li>
						<li>venueName</li>
						<li>venueStreet1</li>
						<li>venueStreet2</li>
						<li>venueCity</li>
						<li>venueState</li>
						<li>venueZip</li>
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
				<li>Profile Type
					<ol>
						<li>profileTypeId(PK)</li>
						<li>profileTypeName</li>
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