DROP TABLE IF EXISTS review;
DROP TABLE IF EXISTS product;
DROP TABLE IF EXISTS profile;


CREATE TABLE profile (
	profileId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	profileName VARCHAR(32) NOT NULL,
	profileEmail VARCHAR(254) NOT NULL,
	profilePicture INT UNSIGNED NOT NULL,
	PRIMARY KEY (profileId)

);

CREATE TABLE review (
	reviewProfileId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	reviewDate DATETIME NOT NULL,
	reviewContent VARCHAR (1000) NOT NULL,
	reviewAuthorId INT UNSIGNED NOT NULL,
	INDEX (reviewProfileId) ,
	FOREIGN KEY (reviewProfileId) REFERENCES profile(profileId),
	PRIMARY KEY (reviewProfileId)

);

CREATE TABLE product (
	productId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	productPrice INT UNSIGNED NOT NULL,
	PRIMARY KEY (productId)

);
-- kill the children first >;^(