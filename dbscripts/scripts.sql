CREATE DATABASE IF NOT EXISTS gateway1_social;
CREATE USER 'gateway1_socuser'@'localhost' IDENTIFIED BY 'socuser123';
GRANT ALL ON gateway1_social.* TO 'gateway1_socuser'@'localhost';

CREATE TABLE IF NOT EXISTS `socialclub` (
  `ID` varchar(50) NOT NULL DEFAULT '00000000-0000-0000-0000-000000000000',
  `Name` varchar(100) NOT NULL,
  `CreationDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
);

CREATE TABLE IF NOT EXISTS `members` (
  `ID` varchar(50) NOT NULL DEFAULT '00000000-0000-0000-0000-000000000000',
  `Name` varchar(50) NOT NULL,
  `Surname` varchar(50) NOT NULL,
  `SocialClubID` varchar(50) NOT NULL,
  `CreationDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
);

ALTER TABLE Members ADD CONSTRAINT FK_MemberSocialClubID FOREIGN KEY (SocialClubID) REFERENCES SocialClub(ID);

-- Dummy data
-- SET @UUID = UUID();
-- INSERT INTO SocialClub (ID, Name) VALUES (@UUID, 'My Club');
-- INSERT INTO Members (ID, Name, Surname, SocialClubId)
-- VALUES (UUID(), 'KG', 'Molema', @UUID);						
