-- SQL Table structure

CREATE TABLE paMembrs (
  pmId INT NOT NULL PRIMARY KEY AUTO_INCREMENT, 
  pmClub INT NULL,
  pmName VARCHAR(60) NULL,
  pmUnit INT NULL,
  pmMail VARCHAR(120) NULL,
  pmActive bit DEFAULT 0,
  pmRole INT DEFAULT 14, 
  pmPwd VARCHAR(120) NOT NULL,
  pmPwdDt TIMESTAMP DEFAULT NOW(),
  pmFamily INT NULL,
  pmLastLogin TIMESTAMP NULL);
  
  CREATE TABLE paClubs (
	pcId INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	pcName VARCHAR(60) NULL,
	pcAddress VARCHAR(60) NULL);
INSERT INTO paClubs (pcName, pcAddress) VALUES ('Twilight Club',NULL);
INSERT INTO paClubs (pcName, pcAddress) VALUES ('Durham Trailblazers','Oshawa');
  
  CREATE TABLE paRoles (
	prId INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	prName VARCHAR(20) NULL,
	prMultiClub BIT DEFAULT 0,
	prMultiUnit BIT DEFAULT 0,
	prMultiCampers BIT DEFAULT 0,
	prEditUsers BIT DEFAULT 0);
INSERT INTO paRoles (prName, prMultiClub, prMultiUnit, prMultiCampers, prEditUsers) VALUES ('Super',1,1,1,1);
INSERT INTO paRoles (prName, prMultiClub, prMultiUnit, prMultiCampers, prEditUsers) VALUES ('Admin',1,1,1,1);
INSERT INTO paRoles (prName, prMultiClub, prMultiUnit, prMultiCampers, prEditUsers) VALUES ('Regional Director',1,1,1,0);
INSERT INTO paRoles (prName, prMultiClub, prMultiUnit, prMultiCampers, prEditUsers) VALUES ('Director',0,1,1,1);
INSERT INTO paRoles (prName, prMultiClub, prMultiUnit, prMultiCampers, prEditUsers) VALUES ('Secretary',0,1,1,1);
INSERT INTO paRoles (prName, prMultiClub, prMultiUnit, prMultiCampers, prEditUsers) VALUES ('Exec',0,1,1,1);
INSERT INTO paRoles (prName, prMultiClub, prMultiUnit, prMultiCampers, prEditUsers) VALUES ('Advisor',0,1,1,0);
INSERT INTO paRoles (prName, prMultiClub, prMultiUnit, prMultiCampers, prEditUsers) VALUES ('Counselor',0,0,1,1);
INSERT INTO paRoles (prName, prMultiClub, prMultiUnit, prMultiCampers, prEditUsers) VALUES ('Assistant',0,0,1,1);
INSERT INTO paRoles (prName, prMultiClub, prMultiUnit, prMultiCampers, prEditUsers) VALUES ('Unit Admin',0,0,1,1);
INSERT INTO paRoles (prName, prMultiClub, prMultiUnit, prMultiCampers, prEditUsers) VALUES ('Parent',0,0,0,1);
INSERT INTO paRoles (prName, prMultiClub, prMultiUnit, prMultiCampers, prEditUsers) VALUES ('Pathfinder',0,0,0,1);
INSERT INTO paRoles (prName, prMultiClub, prMultiUnit, prMultiCampers, prEditUsers) VALUES ('Viewer',0,0,0,0);
INSERT INTO paRoles (prName, prMultiClub, prMultiUnit, prMultiCampers, prEditUsers) VALUES ('None',0,0,0,0);

  CREATE TABLE paFamily (
	pfId INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	pfName VARCHAR(60) NULL);
	
CREATE TABLE pmLevels (
	plId INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	plName VARCHAR(23) NULL,
	plGrade VARCHAR(12) NULL);
INSERT INTO pmLevels (plName, plGrade) VALUES ('Friend', ' 5');
INSERT INTO pmLevels (plName, plGrade) VALUES ('Companion', ' 6');
INSERT INTO pmLevels (plName, plGrade) VALUES ('Explorer', ' 7');
INSERT INTO pmLevels (plName, plGrade) VALUES ('Ranger', ' 8');
INSERT INTO pmLevels (plName, plGrade) VALUES ('Staff', '8+');
INSERT INTO pmLevels (plName, plGrade) VALUES ('Guide', '9');
INSERT INTO pmLevels (plName, plGrade) VALUES ('MIT', '10');
INSERT INTO pmLevels (plName, plGrade) VALUES ('Master Guide', '10+');

CREATE TABLE paUnits (
	puId INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	puClub INT NOT NULL,
	puLevel INT NULL,
	puBoys BIT NULL,
	puComment VARCHAR(20) NULL);

-------------------------------------------------------------------------------	
-- After you Register yourself (you will have ID = 1) run the following line --
-------------------------------------------------------------------------------
-- UPDATE `paMembrs` SET `pmActive`=1,`pmRole`=6 WHERE pmId = 1
--------------------------------------------------------------------------------
-- This will make you active (you can login) and role = 6 - Exec     -----------
--------------------------------------------------------------------------------