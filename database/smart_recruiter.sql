-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 17, 2016 at 06:46 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `smart_recruiter`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteFormRequirements`(formID INT)
BEGIN
START TRANSACTION;
	DELETE FROM form_education WHERE form_id = formID;
	DELETE FROM form_skills WHERE form_id = formID;
    DELETE FROM form_experience WHERE form_id = formID;
    DELETE FROM form_certification WHERE form_id = formID;
COMMIT;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertCertification`(
	IN formID INT, IN certID INT, IN prior INT
)
    NO SQL
INSERT INTO form_certification(
	form_id, certificate_id, priority
) 
VALUES 
	(formID, certID, prior)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertEducation`(IN `formID` INT, IN `degreeID` INT, IN `fieldID` INT, IN `prior` INT)
    NO SQL
INSERT INTO form_education(
	form_id, degree_id, field_of_study_id, 
	priority
) 
VALUES 
	(formID, degreeID, fieldID, prior)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertExperience`(
	IN formID INT, IN titleID INT, IN yoe INT, 
	IN prior INT
)
    NO SQL
INSERT INTO form_experience (
	form_id, title_id, years_of_experience, 
	priority
) 
VALUES 
	(formID, titleID, yoe, prior)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertSkills`(
	IN formID INT, IN skillID INT, IN prior INT
)
    NO SQL
INSERT INTO form_skills(form_id, skill_id, priority) 
VALUES 
	(formID, skillID, prior)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertToForm`(IN `userID` INT, IN `Ddate` DATE, IN `descr` VARCHAR(255))
    NO SQL
INSERT INTO forms(
	user_id, date_created, description
) 
VALUES 
	(userID, Ddate, descr)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updateResponse`(IN `form_id` INT)
    NO SQL
UPDATE forms SET RESPONSES=RESPONSES+1 WHERE id=form_id$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `candidate`
--

CREATE TABLE IF NOT EXISTS `candidate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `form_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `resume` varchar(255) DEFAULT NULL,
  `nationality` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `contact` varchar(13) NOT NULL,
  `email` varchar(255) NOT NULL,
  `score` int(11) NOT NULL DEFAULT '0',
  `date_applied` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `candidate`
--

INSERT INTO `candidate` (`id`, `form_id`, `name`, `resume`, `nationality`, `address`, `contact`, `email`, `score`, `date_applied`) VALUES
(7, 1, 'Muhammad Meeran ', 'CV - Muhammad Meeran Khan.pdf', 'Pakistani', 'Gulshan', '03212863308', 'meeran93@hotmail.com', 55, '2016-02-11'),
(11, 1, 'maaz', 'CV - Muhammad Meeran Khan.pdf', 'Russian', '43 saddlemead green n.e', '0321', 'maaz@maaz.com', 0, '2016-02-11'),
(12, 1, 'maaz', 'CV - Muhammad Meeran Khan.pdf', 'Pakistani', '43 saddlemead green n.e', '03212863308', 'maaz@maaz.com', 0, '2016-02-11'),
(13, 1, 'maaz', 'CV - Muhammad Meeran Khan.pdf', 'Russian', '43 saddlemead green n.e', '00321286', 'maaz@maaz.com', 0, '2016-02-11'),
(14, 1, 'Haseeb Hussain', 'HASEEB-HUSSAIN-CV.pdf', 'Pakistani', 'Flat 420, very Nobel Heights, purani subzi mandi k peechay', '03212863307', 'haseeb@gmail.com', 0, '2016-02-14'),
(17, 11, 'Shams', 'shamsnaveed_profile.pdf', 'Pakistani', 'aABc', '0321', 'shams@gamil.com', 0, '2016-03-06'),
(18, 1, 'Meeran Khan', 'CV - Muhammad Meeran Khan.pdf', 'Pakistani', 'B-307, Block ', '03212863308', 'meeran@gmail.com', 0, '2016-03-09'),
(19, 1, 'Meeran Khan', 'CV - Muhammad Meeran Khan.pdf', 'Pakistani', '43 saddlemead green n.e', '03212863308', 'meeran@gmail.com', 0, '2016-03-09'),
(20, 1, 'Terminator', 'CV - Muhammad Meeran Khan.pdf', 'Russian', 'Mahattan, New York, USA', '0', 'terminator@terminate.com', 0, '2016-03-09');

-- --------------------------------------------------------

--
-- Table structure for table `candidate_certification`
--

CREATE TABLE IF NOT EXISTS `candidate_certification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `candidate_id` int(11) NOT NULL,
  `certificate_id` int(11) NOT NULL,
  `date_awarded` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `certificate_id` (`certificate_id`),
  KEY `certificate_id_2` (`certificate_id`),
  KEY `candidate_id` (`candidate_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `candidate_certification`
--

INSERT INTO `candidate_certification` (`id`, `candidate_id`, `certificate_id`, `date_awarded`) VALUES
(1, 7, 2, '2015-01-05'),
(3, 18, 3, '2013-02-02'),
(4, 18, 2, '2014-02-02'),
(5, 18, 5, '2015-02-02'),
(6, 20, 3, '2050-03-28'),
(7, 20, 2, '2076-04-06'),
(8, 20, 5, '2122-12-01');

-- --------------------------------------------------------

--
-- Table structure for table `candidate_education`
--

CREATE TABLE IF NOT EXISTS `candidate_education` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `candidate_id` int(11) NOT NULL,
  `degree_id` int(11) NOT NULL,
  `field_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `candidate_id` (`candidate_id`),
  KEY `degree_id` (`degree_id`),
  KEY `field_id` (`field_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `candidate_education`
--

INSERT INTO `candidate_education` (`id`, `candidate_id`, `degree_id`, `field_id`) VALUES
(4, 7, 4, 2),
(5, 14, 3, 1),
(6, 14, 4, 1),
(9, 17, 5, 5);

-- --------------------------------------------------------

--
-- Table structure for table `candidate_experience`
--

CREATE TABLE IF NOT EXISTS `candidate_experience` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `candidate_id` int(11) NOT NULL,
  `title_id` int(11) NOT NULL,
  `experience_years` int(11) NOT NULL,
  `company` varchar(32) DEFAULT NULL,
  `responsibilities` longtext,
  PRIMARY KEY (`id`),
  KEY `candidate_id` (`candidate_id`),
  KEY `title_id` (`title_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `candidate_experience`
--

INSERT INTO `candidate_experience` (`id`, `candidate_id`, `title_id`, `experience_years`, `company`, `responsibilities`) VALUES
(7, 7, 1, 8, '10 Pearls', '- Worked on python backend<br>- Worked on Angular JS<br>- Helped write functional tests<br>- Wrote JavaScript Migrations for MBO database'),
(14, 7, 2, 2, 'Ibex Global', '- Implemented Agile development process for the development of Tameer International Web Portal<br>- Managed Software Development of MBO Access (An oursourcing web app used by MBO Partners)'),
(15, 14, 1, 1, 'Oxford University Press', '- Develop the whole web app for managing books'),
(17, 17, 16, 10, 'State Bank, Hino Pak, Millenium ', ''),
(18, 17, 17, 8, 'Hino Pak', ''),
(19, 18, 1, 1, '10 Pearls', ''),
(20, 18, 2, 1, 'Studio Binary', ''),
(21, 19, 1, 0, '', ''),
(22, 19, 2, 0, '', ''),
(23, 20, 1, 67, 'Future Inc.', 'Take care of John Conor'),
(24, 20, 2, -25, 'Present Inc.', 'Kill everyone else except for John Conor');

-- --------------------------------------------------------

--
-- Table structure for table `candidate_skills`
--

CREATE TABLE IF NOT EXISTS `candidate_skills` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `candidate_id` int(11) NOT NULL,
  `skill_id` int(11) NOT NULL,
  `level_of_expertise` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `candidate_id` (`candidate_id`),
  KEY `skill_id` (`skill_id`),
  KEY `skill_id_2` (`skill_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=93 ;

--
-- Dumping data for table `candidate_skills`
--

INSERT INTO `candidate_skills` (`id`, `candidate_id`, `skill_id`, `level_of_expertise`) VALUES
(34, 7, 7, 10),
(35, 7, 8, 10),
(36, 7, 5, 10),
(37, 7, 9, 10),
(50, 11, 7, 5),
(51, 11, 8, 5),
(52, 11, 5, 5),
(53, 11, 9, 5),
(54, 12, 7, 5),
(55, 12, 8, 5),
(56, 12, 5, 5),
(57, 12, 9, 5),
(58, 13, 7, 5),
(59, 13, 8, 5),
(60, 13, 5, 5),
(61, 13, 9, 5),
(62, 14, 2, 3),
(63, 14, 8, 7),
(64, 14, 5, 5),
(65, 14, 9, 6),
(66, 14, 24, 5),
(67, 14, 17, 5),
(69, 17, 28, 8),
(70, 17, 29, 10),
(71, 17, 30, 10),
(72, 18, 2, 9),
(73, 18, 8, 4),
(74, 18, 5, 3),
(75, 18, 9, 7),
(76, 18, 24, 6),
(77, 18, 3, 9),
(78, 18, 4, 9),
(79, 19, 2, 9),
(80, 19, 8, 10),
(81, 19, 5, 3),
(82, 19, 9, 7),
(83, 19, 24, 6),
(84, 19, 3, 9),
(85, 19, 4, 6),
(86, 20, 2, 10),
(87, 20, 8, 10),
(88, 20, 5, 10),
(89, 20, 9, 10),
(90, 20, 24, 10),
(91, 20, 3, 10),
(92, 20, 4, 10);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `category`) VALUES
(1, 'Computer Science'),
(2, 'Data Science'),
(3, 'Marketing'),
(4, 'IT'),
(5, 'Business Administration'),
(6, 'Marketing'),
(7, 'Finance'),
(8, 'Engineering'),
(9, 'Arts'),
(10, 'Sociology');

-- --------------------------------------------------------

--
-- Table structure for table `certificate`
--

CREATE TABLE IF NOT EXISTS `certificate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `certificate_name` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `certificate`
--

INSERT INTO `certificate` (`id`, `certificate_name`, `user_id`, `category_id`) VALUES
(1, 'CCNA', 1, 1),
(2, 'PMP', 1, 1),
(3, 'MCCP', 1, 1),
(4, 'ACCA', 1, 1),
(5, 'Linux+', 1, 1),
(6, 'Oracle DB2', 1, 2),
(7, 'Inbound Marketing', 1, 3),
(8, 'Oracle Certified Database Administrator', 1, 1),
(9, 'Oracle Certified Cloud Specialist', 1, 1),
(10, 'BCNE', 1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `degree`
--

CREATE TABLE IF NOT EXISTS `degree` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `degree_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `degree`
--

INSERT INTO `degree` (`id`, `degree_name`) VALUES
(2, 'O Levels / Matriculatin'),
(3, 'A Levels / Intermediate'),
(4, 'Bachelors'),
(5, 'Masters'),
(6, 'Ph.D'),
(7, 'Diploma');

-- --------------------------------------------------------

--
-- Table structure for table `field_of_study`
--

CREATE TABLE IF NOT EXISTS `field_of_study` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `field_name` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `field_of_study`
--

INSERT INTO `field_of_study` (`id`, `field_name`, `category_id`, `user_id`) VALUES
(1, 'Computer Science', 1, 1),
(2, 'Business Administration', 5, 1),
(3, 'Arts', 9, 1),
(4, 'Urban Engineering', 8, 1),
(5, 'Information Systems', 1, 1),
(6, 'Electrical Engineering', 8, 1),
(7, 'Mechanical Engineering', 8, 1),
(8, 'Electronics Engineering', 8, 1),
(9, 'Bioinformatics', 1, 1),
(10, 'Political Science', 10, 1),
(11, 'Sociolingustics', 10, 1);

-- --------------------------------------------------------

--
-- Table structure for table `forms`
--

CREATE TABLE IF NOT EXISTS `forms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `date_created` date NOT NULL,
  `description` varchar(255) NOT NULL,
  `responses` int(11) NOT NULL DEFAULT '0',
  `status` varchar(255) NOT NULL DEFAULT 'ENABLED',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `forms`
--

INSERT INTO `forms` (`id`, `user_id`, `date_created`, `description`, `responses`, `status`, `deleted`) VALUES
(1, 1, '2016-01-06', 'Php & MySql Developer', 8, 'ENABLED', 0),
(11, 1, '2016-03-06', 'Senior Manager Information Systems/Technology', 1, 'ENABLED', 0);

-- --------------------------------------------------------

--
-- Table structure for table `form_certification`
--

CREATE TABLE IF NOT EXISTS `form_certification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `form_id` int(11) NOT NULL,
  `certificate_id` int(11) NOT NULL,
  `priority` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `form_id` (`form_id`),
  KEY `certificate_id` (`certificate_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=84 ;

--
-- Dumping data for table `form_certification`
--

INSERT INTO `form_certification` (`id`, `form_id`, `certificate_id`, `priority`) VALUES
(52, 11, 2, 7),
(81, 1, 3, 8),
(82, 1, 2, 4),
(83, 1, 5, 3);

-- --------------------------------------------------------

--
-- Table structure for table `form_education`
--

CREATE TABLE IF NOT EXISTS `form_education` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `form_id` int(11) NOT NULL,
  `degree_id` int(11) NOT NULL,
  `field_of_study_id` int(11) NOT NULL,
  `priority` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `form_id` (`form_id`),
  KEY `degree_id` (`degree_id`),
  KEY `field_of_study_id` (`field_of_study_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=71 ;

--
-- Dumping data for table `form_education`
--

INSERT INTO `form_education` (`id`, `form_id`, `degree_id`, `field_of_study_id`, `priority`) VALUES
(43, 11, 5, 1, 9),
(69, 1, 4, 1, 10),
(70, 1, 5, 2, 6);

-- --------------------------------------------------------

--
-- Table structure for table `form_experience`
--

CREATE TABLE IF NOT EXISTS `form_experience` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `form_id` int(11) NOT NULL,
  `title_id` int(11) NOT NULL,
  `years_of_experience` int(11) NOT NULL,
  `priority` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `form_id` (`form_id`),
  KEY `title_id` (`title_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=55 ;

--
-- Dumping data for table `form_experience`
--

INSERT INTO `form_experience` (`id`, `form_id`, `title_id`, `years_of_experience`, `priority`) VALUES
(24, 11, 16, 9, 8),
(25, 11, 17, 5, 9),
(52, 1, 1, 2, 5),
(53, 1, 2, 2, 5),
(54, 1, 21, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `form_skills`
--

CREATE TABLE IF NOT EXISTS `form_skills` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `form_id` int(11) NOT NULL,
  `skill_id` int(11) NOT NULL,
  `priority` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `skill_id` (`skill_id`),
  KEY `form_id` (`form_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=184 ;

--
-- Dumping data for table `form_skills`
--

INSERT INTO `form_skills` (`id`, `form_id`, `skill_id`, `priority`) VALUES
(97, 11, 28, 9),
(98, 11, 29, 10),
(99, 11, 30, 7),
(177, 1, 2, 8),
(178, 1, 8, 9),
(179, 1, 5, 3),
(180, 1, 9, 8),
(181, 1, 24, 3),
(182, 1, 3, 9),
(183, 1, 4, 7);

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

CREATE TABLE IF NOT EXISTS `skills` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `skill` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;

--
-- Dumping data for table `skills`
--

INSERT INTO `skills` (`id`, `skill`, `user_id`, `category_id`) VALUES
(2, 'HTML', 1, 1),
(3, 'CSS', 1, 1),
(4, 'JQuery', 1, 1),
(5, 'C', 1, 1),
(6, 'C#', 1, 1),
(7, 'C++', 1, 1),
(8, 'Java', 1, 1),
(9, 'SQL', 1, 1),
(10, 'JPA2', 1, 1),
(11, 'Hibernate', 1, 1),
(12, 'JSF', 1, 1),
(13, 'Wicket', 1, 1),
(14, 'GWT', 1, 1),
(15, 'Spring MVC', 1, 1),
(16, 'AngularJS', 1, 1),
(17, 'MongoDB', 1, 1),
(18, 'ExpressJS', 1, 1),
(19, 'Node.js', 1, 1),
(20, 'MEAN.IO', 1, 1),
(21, 'JavaScript', 1, 1),
(22, 'ReactJS', 1, 1),
(23, 'Hadoop', 1, 2),
(24, 'Map Reduce', 1, 2),
(25, 'Excel', 1, 2),
(26, 'Inbound Marketing', 1, 3),
(27, 'Research Marketing', 1, 3),
(28, 'IT Strategy', 1, 4),
(29, 'Oracle EBS', 1, 4),
(30, 'IT Outsource Management', 1, 4),
(31, 'Python', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `password`) VALUES
(1, 'Admin', 'admin@admin.com', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `work_titles`
--

CREATE TABLE IF NOT EXISTS `work_titles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `work_titles`
--

INSERT INTO `work_titles` (`id`, `title`, `user_id`) VALUES
(1, 'Software Developer', 1),
(2, 'Software Project Manager', 1),
(3, 'System Architect', 1),
(4, 'Financial Analyst', 1),
(5, 'System Analyst', 1),
(6, 'Supply Chain Manager', 1),
(7, 'Office Administrator', 1),
(8, 'Project Manager', 1),
(9, 'Account Manager', 1),
(10, 'Account Executive', 1),
(11, 'Mechanical Engineer', 1),
(12, 'Network Engineer', 1),
(13, 'Sales Executive', 1),
(14, 'Software Engineer', 1),
(15, 'Design Engineer', 1),
(16, 'IT', 1),
(17, 'Senior IT Manager', 1),
(19, 'Angular JS', 1),
(20, 'N-tier applications', 1),
(21, 'Offshore software development environment', 1);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `candidate_certification`
--
ALTER TABLE `candidate_certification`
  ADD CONSTRAINT `candidate_certification_ibfk_1` FOREIGN KEY (`certificate_id`) REFERENCES `certificate` (`id`),
  ADD CONSTRAINT `candidate_certification_ibfk_2` FOREIGN KEY (`candidate_id`) REFERENCES `candidate` (`id`);

--
-- Constraints for table `candidate_education`
--
ALTER TABLE `candidate_education`
  ADD CONSTRAINT `candidate_education_ibfk_1` FOREIGN KEY (`candidate_id`) REFERENCES `candidate` (`id`),
  ADD CONSTRAINT `candidate_education_ibfk_2` FOREIGN KEY (`degree_id`) REFERENCES `degree` (`id`),
  ADD CONSTRAINT `candidate_education_ibfk_3` FOREIGN KEY (`field_id`) REFERENCES `field_of_study` (`id`);

--
-- Constraints for table `candidate_experience`
--
ALTER TABLE `candidate_experience`
  ADD CONSTRAINT `candidate_experience_ibfk_1` FOREIGN KEY (`candidate_id`) REFERENCES `candidate` (`id`),
  ADD CONSTRAINT `candidate_experience_ibfk_2` FOREIGN KEY (`title_id`) REFERENCES `work_titles` (`id`);

--
-- Constraints for table `candidate_skills`
--
ALTER TABLE `candidate_skills`
  ADD CONSTRAINT `candidate_skills_ibfk_1` FOREIGN KEY (`candidate_id`) REFERENCES `candidate` (`id`),
  ADD CONSTRAINT `candidate_skills_ibfk_2` FOREIGN KEY (`skill_id`) REFERENCES `skills` (`id`);

--
-- Constraints for table `certificate`
--
ALTER TABLE `certificate`
  ADD CONSTRAINT `certificate_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `certificate_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);

--
-- Constraints for table `field_of_study`
--
ALTER TABLE `field_of_study`
  ADD CONSTRAINT `field_of_study_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
  ADD CONSTRAINT `field_of_study_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `forms`
--
ALTER TABLE `forms`
  ADD CONSTRAINT `forms_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `form_certification`
--
ALTER TABLE `form_certification`
  ADD CONSTRAINT `form_certification_ibfk_1` FOREIGN KEY (`form_id`) REFERENCES `forms` (`id`),
  ADD CONSTRAINT `form_certification_ibfk_2` FOREIGN KEY (`certificate_id`) REFERENCES `certificate` (`id`);

--
-- Constraints for table `form_education`
--
ALTER TABLE `form_education`
  ADD CONSTRAINT `form_education_ibfk_1` FOREIGN KEY (`form_id`) REFERENCES `forms` (`id`),
  ADD CONSTRAINT `form_education_ibfk_2` FOREIGN KEY (`degree_id`) REFERENCES `degree` (`id`),
  ADD CONSTRAINT `form_education_ibfk_3` FOREIGN KEY (`field_of_study_id`) REFERENCES `field_of_study` (`id`);

--
-- Constraints for table `form_experience`
--
ALTER TABLE `form_experience`
  ADD CONSTRAINT `form_experience_ibfk_1` FOREIGN KEY (`form_id`) REFERENCES `forms` (`id`),
  ADD CONSTRAINT `form_experience_ibfk_2` FOREIGN KEY (`title_id`) REFERENCES `work_titles` (`id`);

--
-- Constraints for table `form_skills`
--
ALTER TABLE `form_skills`
  ADD CONSTRAINT `form_skills_ibfk_1` FOREIGN KEY (`skill_id`) REFERENCES `skills` (`id`),
  ADD CONSTRAINT `form_skills_ibfk_2` FOREIGN KEY (`form_id`) REFERENCES `forms` (`id`);

--
-- Constraints for table `skills`
--
ALTER TABLE `skills`
  ADD CONSTRAINT `skills_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
  ADD CONSTRAINT `skills_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `work_titles`
--
ALTER TABLE `work_titles`
  ADD CONSTRAINT `work_titles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
