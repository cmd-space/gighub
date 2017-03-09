DROP TABLE IF EXISTS postTag;
DROP TABLE IF EXISTS profileTag;
DROP TABLE IF EXISTS tag;
DROP TABLE IF EXISTS post;
DROP TABLE IF EXISTS venue;
DROP TABLE IF EXISTS profile;
DROP TABLE IF EXISTS profileType;
DROP TABLE IF EXISTS oAuth;

-- the CREATE TABLE function is a function that takes tons of arguments to layout the table's schema

-- create the oAuth entity
CREATE TABLE oAuth (
	oAuthId          INT UNSIGNED AUTO_INCREMENT NOT NULL,
	oAuthServiceName VARCHAR(32)                 NOT NULL,
	PRIMARY KEY (oAuthId)
);

-- create the profileType entity
CREATE TABLE profileType (
	profileTypeId   INT UNSIGNED AUTO_INCREMENT NOT NULL,
	profileTypeName VARCHAR(64)                 NOT NULL,
	PRIMARY KEY (profileTypeId)
);

-- create the profile entity
CREATE TABLE profile (
	-- this creates the attribute for the primary key
	-- auto_increment tells mySQL to number them {1, 2, 3, ...}
	-- not null means the attribute is required!
	profileId                INT UNSIGNED AUTO_INCREMENT NOT NULL,
	profileOAuthId           INT UNSIGNED                NOT NULL,
	profileTypeId            INT UNSIGNED                NOT NULL,
	profileBio               VARCHAR(669),
	profileImageCloudinaryId VARCHAR(32),
	profileLocation
									 CHAR(128),
	profileOAuthToken        VARCHAR(200),
	profileSoundCloudUser    VARCHAR(32),
	profileUserName          VARCHAR(64),z
	-- to make something optional, exclude the not null
	-- to make sure duplicate data cannot exist, create a unique index
	INDEX (profileLocation),
	INDEX (profileOAuthId),
	INDEX (profileSoundCloudUser),
	INDEX (profileTypeId),
	UNIQUE (profileUserName),
	FOREIGN KEY (profileOAuthId) REFERENCES oAuth (oAuthId),
	FOREIGN KEY (profileTypeId) REFERENCES profileType (profileTypeId),
	-- this officiates the primary key for the entity
	PRIMARY KEY (profileId)
);

-- create the venue entity
CREATE TABLE venue (
	venueId        INT UNSIGNED AUTO_INCREMENT NOT NULL,
	venueProfileId INT UNSIGNED                NOT NULL,
	venueCity      VARCHAR(100)                NOT NULL,
	venueName      VARCHAR(64)                 NOT NULL,
	venueState     CHAR(2)                     NOT NULL,
	venueStreet1   VARCHAR(64)                 NOT NULL,
	venueStreet2   VARCHAR(64),
	venueZip       VARCHAR(10)                 NOT NULL,
	INDEX (venueCity),
	INDEX (venueName),
	INDEX (venueProfileId),
	INDEX (venueZip),
	FOREIGN KEY (venueProfileId) REFERENCES profile (profileId),
	PRIMARY KEY (venueId)
);

-- create the post entity
CREATE TABLE post (
	-- this is for yet another primary key...
	postId                INT UNSIGNED AUTO_INCREMENT         NOT NULL,
	-- this is for a foreign key; auto_increment is omitted by design
	postProfileId         INT UNSIGNED                        NOT NULL,
	postVenueId           INT UNSIGNED                        NOT NULL,
	postContent           VARCHAR(255)                        NOT NULL,
	postCreatedDate       TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
	postEventDate         DATETIME                            NOT NULL,
	postImageCloudinaryId VARCHAR(32),
	postTitle             VARCHAR(64),
	INDEX (postContent),
	INDEX (postEventDate),
	INDEX (postProfileId),
	INDEX (postVenueId),
	INDEX (postTitle),
	UNIQUE (postImageCloudinaryId),
	FOREIGN KEY (postProfileId) REFERENCES profile (profileId),
	FOREIGN KEY (postVenueId) REFERENCES venue (venueId),
	-- and finally create the primary key
	PRIMARY KEY (postId)
);

-- create the tag entity
CREATE TABLE tag (
	tagId      INT UNSIGNED AUTO_INCREMENT NOT NULL,
	tagContent VARCHAR(64),
	UNIQUE (tagContent),
	PRIMARY KEY (tagId)
);

-- create the profileTag entity
CREATE TABLE profileTag (
	profileTagProfileId INT UNSIGNED NOT NULL,
	profileTagTagId     INT UNSIGNED NOT NULL,
	INDEX (profileTagProfileId),
	INDEX (profileTagTagId),
	FOREIGN KEY (profileTagProfileId) REFERENCES profile (profileId),
	FOREIGN KEY (profileTagTagId) REFERENCES tag (tagId),
	PRIMARY KEY (profileTagProfileId, profileTagTagId)
);

-- create the postTag entity
CREATE TABLE postTag (
	postTagPostId INT UNSIGNED NOT NULL,
	postTagTagId  INT UNSIGNED NOT NULL,
	INDEX (postTagPostId),
	INDEX (postTagTagId),
	FOREIGN KEY (postTagPostId) REFERENCES post (postId),
	FOREIGN KEY (postTagTagId) REFERENCES tag (tagId),
	PRIMARY KEY (postTagPostId, postTagTagId)
);