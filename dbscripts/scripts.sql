CREATE DATABASE IF NOT EXISTS gateway1_social;
CREATE USER 'gateway1_socuser'@'localhost' IDENTIFIED BY 'socuser123';
GRANT ALL ON gateway1_social.* TO 'gateway1_socuser'@'localhost';

CREATE TABLE IF NOT EXISTS socialclub (
  ID varchar(50) NOT NULL DEFAULT '00000000-0000-0000-0000-000000000000',
  Name varchar(100) NOT NULL,
  CreationDate datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (ID)
);

CREATE TABLE IF NOT EXISTS ClubMetaData (
    ID varchar(50) NOT NULL,
	SocialClubID varchar(50) NOT NULL,
	MonthlyMembershipTarget smallint,
    CreationDate datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (ID)
);

ALTER TABLE ClubMetaData ADD CONSTRAINT FK_MetaDataSocialClubID FOREIGN KEY (SocialClubID) REFERENCES SocialClub(ID);
-- Dummy data
-- INSERT INTO clubmetadata(SocialClubID, MonthlyMembershipTarget) VALUES ('107da39a-e681-11e7-9439-70f395f16141',5)

CREATE TABLE IF NOT EXISTS members (
  ID varchar(50) NOT NULL DEFAULT '00000000-0000-0000-0000-000000000000',
  Name varchar(50) NOT NULL,
  Surname varchar(50) NOT NULL,
  SocialClubID varchar(50) NOT NULL,
  CreationDate datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (ID)
);

ALTER TABLE Members ADD CONSTRAINT FK_MemberSocialClubID FOREIGN KEY (SocialClubID) REFERENCES SocialClub(ID);

CREATE VIEW socialclubstats AS 
select s.ID AS ID,s.Name AS Name,
	(
		select count(*) from members 
		where (SocialClubID = s.ID)
	) AS Actual,
	(
		select MonthlyMembershipTarget from clubmetadata 
		where ((SocialClubID = s.ID) 
		and (CreationDate = 
				(
					select max(CreationDate) 
					from clubmetadata where (SocialClubID = s.ID))
				)				
			)
	) AS Target,
	(
		select MonthlyMembershipFee from clubmetadata 
		where ((SocialClubID = s.ID) 
		and (CreationDate = 
				(
					select max(CreationDate) 
					from clubmetadata where (SocialClubID = s.ID))
				)				
			)
	) AS Fee,
	(
		SELECT SUM(c.Contribution)
		FROM socialclub s1
		LEFT JOIN members m ON s1.ID = m.SocialClubID
		LEFT JOIN clubfees c ON m.ID = c.MemberID
		WHERE (s1.ID = s.ID)
	) AS Contributions
from socialclub s;

ALTER TABLE clubmetadata  ADD MonthlyMembershipFee DECIMAL(6,2) NULL  AFTER MonthlyMembershipTarget;

CREATE TABLE IF NOT EXISTS `clubfees` (
  `ID` varchar(50) NOT NULL DEFAULT '00000000-0000-0000-0000-000000000000',
  `SocialClubID` varchar(50) NOT NULL,
  `MemberID` varchar(50) NOT NULL,
  `Contribution` decimal(6,2) NOT NULL,
  Details varchar(100) NOT NULL DEFAULT 'Joining Fee',
  `CreationDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
);

ALTER TABLE clubfees ADD CONSTRAINT FK_SocialClubFeeID FOREIGN KEY (SocialClubID) REFERENCES SocialClub(ID);
ALTER TABLE clubfees ADD CONSTRAINT FK_MemberFeeID FOREIGN KEY (MemberID) REFERENCES Members(ID);

CREATE TABLE IF NOT EXISTS clubmedia (
  ID varchar(50) NOT NULL PRIMARY KEY,
  Name varchar(200) NOT NULL,
  FileLocation varchar(200) NOT NULL,
  FileType varchar(50) NOT NULL,
  SocialClubID varchar(50) NOT NULL,
  CreationDate datetime NOT NULL DEFAULT CURRENT_TIMESTAMP 
);

ALTER TABLE clubmedia ADD CONSTRAINT FK_SocialClubMediaID FOREIGN KEY (SocialClubID) REFERENCES SocialClub(ID);

/*
-- Dummy data
-- SET @UUID = UUID();
-- INSERT INTO SocialClub (ID, Name) VALUES (@UUID, 'My Club');
-- INSERT INTO Members (ID, Name, Surname, SocialClubId)
-- VALUES (UUID(), 'KG', 'Molema', @UUID);						

-- SELECT s.Name, COUNT(*) FROM SocialClub s
-- JOIN Members m ON m.SocialClubID = s.ID
-- GROUP BY s.Name

SELECT s.Name, (SELECT COUNT(*) FROM Members WHERE SocialClubID = s.ID) "Actual",
(SELECT MonthlyMembershipTarget FROM clubmetadata WHERE SocialClubID = s.ID
AND CreationDate = (SELECT MAX(CreationDate) FROM clubmetadata WHERE SocialClubID = s.ID)) "Target"
FROM SocialClub s


SELECT s.Name, COUNT(*), 
(SELECT MonthlyMembershipTarget FROM clubmetadata WHERE SocialClubID = s.ID
AND CreationDate = (SELECT MAX(CreationDate) FROM clubmetadata WHERE SocialClubID = s.ID)) "Target"
FROM SocialClub s
LEFT JOIN Members m ON s.ID = m.SocialClubID 
GROUP BY s.Name


SET @ClubName = 'Test1';
DELETE FROM clubfees WHERE 
MemberID IN ( SELECT ID FROM members WHERE 
				SocialClubID IN (SELECT ID FROM socialclub WHERE Name = @ClubName)
			);
DELETE FROM members WHERE
  SocialClubID IN ( SELECT ID FROM socialclub WHERE Name = @ClubName);	
DELETE FROM clubmetadata WHERE SocialClubID IN (SELECT ID FROM socialclub WHERE Name = @ClubName);
DELETE FROM socialclub WHERE Name = @ClubName;

SELECT s.Name, m.Name, c.Details, c.Contribution 
FROM socialclub s
LEFT JOIN members m ON s.ID = m.SocialClubID
LEFT JOIN clubfees c ON m.ID = c.MemberID
ORDER BY m.Name
*/