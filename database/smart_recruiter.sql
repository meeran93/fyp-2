-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 28, 2016 at 11:31 AM
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
  `score_education` float NOT NULL DEFAULT '0',
  `score_skills` float NOT NULL DEFAULT '0',
  `score_experience` float NOT NULL DEFAULT '0',
  `score_certification` float NOT NULL DEFAULT '0',
  `status` varchar(255) NOT NULL DEFAULT 'PENDING',
  `date_applied` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `candidate`
--

INSERT INTO `candidate` (`id`, `form_id`, `name`, `resume`, `nationality`, `address`, `contact`, `email`, `score_education`, `score_skills`, `score_experience`, `score_certification`, `status`, `date_applied`) VALUES
(22, 11, 'Meeran Khan', 'CV - Muhammad Meeran Khan.pdf', 'Pakistani', 'Gulshan-e-Iqbal Block-16', '03212863308', 'meeran@gmail.com', 0, 0, 0, 0, 'SHORTLIST', '2016-03-28');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `candidate_certification`
--

INSERT INTO `candidate_certification` (`id`, `candidate_id`, `certificate_id`, `date_awarded`) VALUES
(10, 22, 2, '2014-09-30');

-- --------------------------------------------------------

--
-- Table structure for table `candidate_education`
--

CREATE TABLE IF NOT EXISTS `candidate_education` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `candidate_id` int(11) NOT NULL,
  `school` varchar(255) DEFAULT NULL,
  `degree_id` int(11) NOT NULL,
  `field_id` int(11) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `candidate_id` (`candidate_id`),
  KEY `degree_id` (`degree_id`),
  KEY `field_id` (`field_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `candidate_education`
--

INSERT INTO `candidate_education` (`id`, `candidate_id`, `school`, `degree_id`, `field_id`, `start_date`, `end_date`) VALUES
(11, 22, 'IBA', 4, 1, '2012-08-15', '2016-06-20');

-- --------------------------------------------------------

--
-- Table structure for table `candidate_experience`
--

CREATE TABLE IF NOT EXISTS `candidate_experience` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `candidate_id` int(11) NOT NULL,
  `title_id` int(11) NOT NULL,
  `company` varchar(32) DEFAULT NULL,
  `description` longtext,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `candidate_id` (`candidate_id`),
  KEY `title_id` (`title_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `candidate_experience`
--

INSERT INTO `candidate_experience` (`id`, `candidate_id`, `title_id`, `company`, `description`, `start_date`, `end_date`) VALUES
(26, 22, 1, 'Studio Binary', 'Used Laravel to develop a web app for managing shipments', '2015-10-01', '2015-11-01');

-- --------------------------------------------------------

--
-- Table structure for table `candidate_experience_required`
--

CREATE TABLE IF NOT EXISTS `candidate_experience_required` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `candidate_id` int(11) NOT NULL,
  `title_id` int(11) NOT NULL,
  `experience_years` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `candidate_id` (`candidate_id`),
  KEY `title_id` (`title_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `candidate_experience_required`
--

INSERT INTO `candidate_experience_required` (`id`, `candidate_id`, `title_id`, `experience_years`) VALUES
(3, 22, 16, 4),
(4, 22, 17, 2);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=101 ;

--
-- Dumping data for table `candidate_skills`
--

INSERT INTO `candidate_skills` (`id`, `candidate_id`, `skill_id`, `level_of_expertise`) VALUES
(98, 22, 28, 8),
(99, 22, 29, 9),
(100, 22, 30, 4);

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
  `order` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `degree`
--

INSERT INTO `degree` (`id`, `degree_name`, `order`) VALUES
(2, 'O Levels / Matriculatin', 0),
(3, 'A Levels / Intermediate', 0),
(4, 'Bachelors', 1),
(5, 'Masters', 2),
(6, 'Ph.D', 3),
(7, 'Diploma', 0);

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
  `expiry_date` date DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `forms`
--

INSERT INTO `forms` (`id`, `user_id`, `date_created`, `description`, `responses`, `status`, `expiry_date`, `deleted`) VALUES
(1, 1, '2016-01-06', 'Php & MySql Developer', 0, 'ENABLED', '2016-03-31', 0),
(11, 1, '2016-03-06', 'Senior Manager Information Systems/Technology', 1, 'ENABLED', '2016-03-30', 0);

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
-- Constraints for table `candidate_experience_required`
--
ALTER TABLE `candidate_experience_required`
  ADD CONSTRAINT `candidate_experience_required_ibfk_1` FOREIGN KEY (`candidate_id`) REFERENCES `candidate` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `candidate_experience_required_ibfk_2` FOREIGN KEY (`title_id`) REFERENCES `work_titles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
