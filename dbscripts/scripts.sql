CREATE DATABASE IF NOT EXISTS gateway1_social;
CREATE USER 'gateway1_socuser'@'localhost' IDENTIFIED BY 'socuser123';
GRANT ALL ON gateway1_social.* TO 'gateway1_socuser'@'localhost';

CREATE TABLE IF NOT EXISTS `socialclub` (
  `ID` varchar(50) NOT NULL DEFAULT '00000000-0000-0000-0000-000000000000',
  `Name` varchar(100) NOT NULL,
  `CreationDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
);

CREATE TABLE IF NOT EXISTS ClubMetaData (
    ID varchar(50) NOT NULL,
	SocialClubID varchar(50) NOT NULL,
	MonthlyMembershipTarget smallint,
    CreationDate datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`ID`)
);

ALTER TABLE ClubMetaData ADD CONSTRAINT FK_MetaDataSocialClubID FOREIGN KEY (SocialClubID) REFERENCES SocialClub(ID);
-- Dummy data
-- INSERT INTO `clubmetadata`(`SocialClubID`, `MonthlyMembershipTarget`) VALUES ('107da39a-e681-11e7-9439-70f395f16141',5)

CREATE TABLE IF NOT EXISTS `members` (
  `ID` varchar(50) NOT NULL DEFAULT '00000000-0000-0000-0000-000000000000',
  `Name` varchar(50) NOT NULL,
  `Surname` varchar(50) NOT NULL,
  `SocialClubID` varchar(50) NOT NULL,
  `CreationDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
);

ALTER TABLE Members ADD CONSTRAINT FK_MemberSocialClubID FOREIGN KEY (SocialClubID) REFERENCES SocialClub(ID);

CREATE VIEW `socialclubstats` AS 
select `s`.`ID` AS `ID`,`s`.`Name` AS `Name`,
	(select count(0) from `members` 
	where (`members`.`SocialClubID` = `s`.`ID`)) AS `Actual`,
	(
		select `clubmetadata`.`MonthlyMembershipTarget` from `clubmetadata` 
		where ((`clubmetadata`.`SocialClubID` = `s`.`ID`) 
		and (`clubmetadata`.`CreationDate` = 
				(
					select max(`clubmetadata`.`CreationDate`) 
					from `clubmetadata` where (`clubmetadata`.`SocialClubID` = `s`.`ID`))
				)				
			)
	) AS `Target` 
from `socialclub` `s`;
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