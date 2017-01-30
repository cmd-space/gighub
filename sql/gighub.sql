DROP TABLE IF EXISTS postTag;
DROP TABLE IF EXISTS profileTag;
DROP TABLE IF EXISTS profileType;
DROP TABLE IF EXISTS tag;
DROP TABLE IF EXISTS venue;
DROP TABLE IF EXISTS post;
DROP TABLE IF EXISTS profile;
DROP TABLE IF EXISTS oAuth;

-- the CREATE TABLE function is a function that takes tons of arguments to layout the table's schema

-- create the oAuth entity
CREATE TABLE oAuth (
	oAuthId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	oAuthServiceName VARCHAR(128) NOT NULL,
	INDEX(oAuthServiceName),
	PRIMARY KEY(oAuthId)
);

-- create the profile entity
CREATE TABLE profile (
	-- this creates the attribute for the primary key
	-- auto_increment tells mySQL to number them {1, 2, 3, ...}
	-- not null means the attribute is required!
	profileId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	profileOAuthId INT UNSIGNED NOT NULL,
	profileTypeId INT UNSIGNED NOT NULL,
	profileBio VARCHAR(669),
	profileImageCloudinaryId VARCHAR(128),
	profileLocation VARCHAR(128),
	profileOAuthToken VARCHAR(256),
	profileSoundCloudUser VARCHAR(128),
	profileUrl VARCHAR(512) NOT NULL,
	profileUserName VARCHAR(64),
	-- to make something optional, exclude the not null
	-- to make sure duplicate data cannot exist, create a unique index
	INDEX(profileBio),
	INDEX(profileImageCloudinaryId),
	INDEX(profileLocation),
	INDEX(profileSoundCloudUser),
	UNIQUE(profileUserName),
	UNIQUE(profileOAuthToken),
	UNIQUE(profileUrl),
	FOREIGN KEY(profileOAuthId) REFERENCES oAuth(oAuthId),
	FOREIGN KEY(profileTypeId) REFERENCES profileType(profileTypeId),
	-- this officiates the primary key for the entity
	PRIMARY KEY(profileId)
);

-- create the tweet entity
CREATE TABLE post (
	-- this is for yet another primary key...
	postId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	-- this is for a foreign key; auto_increment is omitted by design
	postProfileId INT UNSIGNED NOT NULL,

	-- and finally create the primary key
	PRIMARY KEY(postId)
);