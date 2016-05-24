-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 24, 2016 at 03:07 PM
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `updateFormStatus`(IN `userID` INT)
BEGIN
START TRANSACTION;
  UPDATE forms SET status='EXPIRED' WHERE status='ENABLED' AND expiry_date<=CURDATE() AND user_id = userID;
  UPDATE forms SET status='ENABLED' WHERE status='EXPIRED' AND expiry_date>CURDATE() AND user_id= userID;
COMMIT;
END$$

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
  `nationality` varchar(255) NOT NULL DEFAULT 'Pakistani',
  `address` varchar(255) NOT NULL,
  `contact` varchar(13) NOT NULL,
  `email` varchar(255) NOT NULL,
  `expected_salary` int(11) NOT NULL,
  `expected_salary_within_range` varchar(3) NOT NULL DEFAULT 'YES',
  `score_education` float NOT NULL DEFAULT '0',
  `score_skills` float NOT NULL DEFAULT '0',
  `score_experience` float NOT NULL DEFAULT '0',
  `score_certification` float NOT NULL DEFAULT '0',
  `status` varchar(255) NOT NULL DEFAULT 'PENDING',
  `date_applied` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `candidate`
--

INSERT INTO `candidate` (`id`, `form_id`, `name`, `resume`, `nationality`, `address`, `contact`, `email`, `expected_salary`, `expected_salary_within_range`, `score_education`, `score_skills`, `score_experience`, `score_certification`, `status`, `date_applied`) VALUES
(22, 11, 'Meeran Khan', 'CV - Muhammad Meeran Khan.pdf', 'Pakistani', 'Gulshan-e-Iqbal Block-16', '03212863308', 'meeran@gmail.com', 0, 'YES', 0, 0, 0, 0, 'REJECTED', '2016-03-28'),
(23, 12, 'Meeran Khan', 'CV - Muhammad Meeran Khan.pdf', 'Pakistani', 'Gulshan Iqbal town', '03212863308', 'meeran@gmail.com', 0, 'YES', 10, 120, 10, 0, 'SHORTLISTED', '2016-03-30'),
(24, 12, 'Meeran Khan', 'CV - Muhammad Meeran Khan.pdf', 'Pakistani', 'Gulshan Iqbal town', '03212863308', 'meeran@gmail.com', 0, 'YES', 17, 300, 14, 3, 'REJECTED', '2016-03-30'),
(25, 12, 'Meeran Khan', 'CV - Muhammad Meeran Khan.pdf', 'Pakistani', 'Gulshan Iqbal town', '03212863308', 'meeran@gmail.com', 0, 'YES', 22, 300, 44, 3, 'SHORTLISTED', '2016-03-30'),
(26, 13, 'Uzair Siddiqui', 'CV - Muhammad Meeran Khan.pdf', '', 'Gulistan-e-Johar', '03008529631', 'uzair@gmail.com', 50000, 'YES', 10, 719, 3.33333, 0, 'PENDING', '2016-05-05');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `candidate_certification`
--

INSERT INTO `candidate_certification` (`id`, `candidate_id`, `certificate_id`, `date_awarded`) VALUES
(10, 22, 2, '2014-09-30'),
(11, 24, 6, '2016-10-02'),
(12, 25, 6, '2016-10-02');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `candidate_education`
--

INSERT INTO `candidate_education` (`id`, `candidate_id`, `school`, `degree_id`, `field_id`, `start_date`, `end_date`) VALUES
(11, 22, 'IBA', 4, 1, '2012-08-15', '2016-06-20'),
(12, 23, 'IBA', 4, 1, '2015-10-30', '2015-12-28'),
(13, 24, 'IBA', 4, 1, '2012-12-31', '2014-12-31'),
(14, 24, 'Yales', 5, 2, '2012-12-29', '2016-01-29'),
(15, 25, 'IBA', 4, 1, '2015-07-29', '2016-11-28'),
(16, 25, 'Yales', 5, 2, '2013-07-30', '2015-12-28'),
(17, 25, 'MIT', 6, 1, '2015-09-29', '2015-10-29'),
(18, 26, 'Institute of Business Administration - Karachi', 4, 1, '2012-08-01', '2016-06-01');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

--
-- Dumping data for table `candidate_experience`
--

INSERT INTO `candidate_experience` (`id`, `candidate_id`, `title_id`, `company`, `description`, `start_date`, `end_date`) VALUES
(26, 22, 1, 'Studio Binary', 'Used Laravel to develop a web app for managing shipments', '2015-10-01', '2015-11-01'),
(27, 24, 1, '10 Pearls', 'MBO App', '2015-02-03', '2016-10-28'),
(28, 26, 1, 'Createch', 'Was responsible for developing a web app', '2015-09-01', '2016-09-30');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `candidate_experience_required`
--

INSERT INTO `candidate_experience_required` (`id`, `candidate_id`, `title_id`, `experience_years`) VALUES
(3, 22, 16, 4),
(4, 22, 17, 2),
(5, 23, 1, 1),
(6, 23, 21, 1),
(7, 24, 1, 2),
(8, 24, 21, 1),
(9, 25, 1, 5),
(10, 25, 21, 4),
(11, 26, 1, 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=141 ;

--
-- Dumping data for table `candidate_skills`
--

INSERT INTO `candidate_skills` (`id`, `candidate_id`, `skill_id`, `level_of_expertise`) VALUES
(98, 22, 28, 8),
(99, 22, 29, 9),
(100, 22, 30, 4),
(101, 23, 8, 5),
(102, 23, 7, 2),
(103, 23, 9, 7),
(104, 23, 30, 0),
(105, 23, 2, 10),
(106, 24, 8, 10),
(107, 24, 7, 10),
(108, 24, 9, 10),
(109, 24, 30, 10),
(110, 24, 4, 8),
(111, 25, 8, 10),
(112, 25, 7, 10),
(113, 25, 9, 10),
(114, 25, 30, 10),
(115, 26, 39, 8),
(116, 26, 46, 5),
(117, 26, 41, 7),
(118, 26, 43, 6),
(119, 26, 21, 8),
(120, 26, 42, 0),
(121, 26, 8, 5),
(122, 26, 44, 0),
(123, 26, 45, 0),
(124, 26, 47, 0),
(125, 26, 49, 0),
(126, 26, 48, 0),
(127, 26, 38, 6),
(128, 26, 52, 0),
(129, 26, 51, 8),
(130, 26, 53, 0),
(131, 26, 4, 8),
(132, 26, 55, 3),
(133, 26, 54, 0),
(134, 26, 57, 0),
(135, 26, 56, 7),
(136, 26, 58, 0),
(137, 26, 59, 0),
(138, 26, 60, 0),
(139, 26, 61, 8),
(140, 26, 62, 5);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

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
(10, 'Sociology'),
(11, 'Science'),
(12, 'Medicine');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

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
(10, 'BCNE', 1, 4),
(11, 'AWS Certified Solutions Architect - Associate', 1, 1),
(12, 'Certified Information Security Manager (CISM)', 1, 4),
(13, 'Certified Information Systems Auditor (CISA)', 1, 4),
(14, 'Cisco Certified Design Professional (CCDP)', 1, 4);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

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
(11, 'Sociolingustics', 10, 1),
(12, 'Mechatronics', 8, 1),
(13, 'Earth Sciences', 11, 1),
(14, 'Anthropology', 9, 1),
(15, 'Astronomy', 11, 1),
(16, 'Biological Engineering', 8, 1),
(17, 'Chemical Engineering', 8, 1),
(18, 'Fine Arts', 9, 1),
(19, 'Engineering Physics', 8, 1),
(20, 'Development Sociology', 10, 1),
(21, 'Animal Science', 11, 1),
(22, 'Civil Engineering', 8, 1),
(23, 'Atmospheric Sciences', 11, 1),
(24, 'Biological Science', 11, 1),
(25, 'Agricultural Sciences', 11, 1),
(26, 'Accounting & Finance', 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `forms`
--

CREATE TABLE IF NOT EXISTS `forms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `date_created` date NOT NULL,
  `job_title` varchar(255) NOT NULL,
  `job_description` text,
  `responses` int(11) NOT NULL DEFAULT '0',
  `status` varchar(255) NOT NULL DEFAULT 'ENABLED',
  `expiry_date` date DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `score_education_max` float NOT NULL DEFAULT '0',
  `score_skills_max` float NOT NULL DEFAULT '0',
  `score_experience_max` float NOT NULL DEFAULT '0',
  `score_certification_max` float NOT NULL DEFAULT '0',
  `preferred_max_salary` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `forms`
--

INSERT INTO `forms` (`id`, `user_id`, `date_created`, `job_title`, `job_description`, `responses`, `status`, `expiry_date`, `deleted`, `score_education_max`, `score_skills_max`, `score_experience_max`, `score_certification_max`, `preferred_max_salary`) VALUES
(1, 1, '2016-01-06', 'Php & MySql Developer', NULL, 0, 'EXPIRED', '2016-04-13', 0, 16, 530, 11, 15, 20000),
(11, 1, '2016-03-06', 'Senior Manager Information Systems/Technology', NULL, 1, 'EXPIRED', '2016-04-27', 0, 9, 260, 17, 7, 25000),
(12, 1, '2016-03-30', 'Business Analyst', NULL, 3, 'EXPIRED', '2016-04-17', 0, 22, 390, 44, 3, 40000),
(13, 2, '2016-05-05', 'Sr. Software Engineer (PHP)', 'PHP and Android (native) Developer Required.\r\n\r\nExperience with CodeIgniter, Laravel, Wordpress, Magento, Joomla will be preferred. Must have excellent SQL skills.\r\n\r\nShould have ability to lead the team and take charge of the project.', 1, 'ENABLED', '2016-05-31', 0, 10, 1970, 10, 0, 90000);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=196 ;

--
-- Dumping data for table `form_certification`
--

INSERT INTO `form_certification` (`id`, `form_id`, `certificate_id`, `priority`) VALUES
(183, 1, 3, 8),
(184, 1, 2, 4),
(185, 1, 5, 3),
(194, 12, 6, 3),
(195, 11, 2, 7);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=159 ;

--
-- Dumping data for table `form_education`
--

INSERT INTO `form_education` (`id`, `form_id`, `degree_id`, `field_of_study_id`, `priority`) VALUES
(145, 1, 4, 1, 10),
(146, 1, 5, 2, 6),
(155, 12, 4, 1, 10),
(156, 12, 5, 2, 7),
(157, 11, 5, 1, 9),
(158, 13, 4, 1, 10);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=187 ;

--
-- Dumping data for table `form_experience`
--

INSERT INTO `form_experience` (`id`, `form_id`, `title_id`, `years_of_experience`, `priority`) VALUES
(163, 1, 1, 2, 5),
(164, 1, 2, 2, 5),
(165, 1, 21, 1, 1),
(182, 12, 1, 2, 8),
(183, 12, 21, 1, 6),
(184, 11, 16, 9, 8),
(185, 11, 17, 5, 9),
(186, 13, 1, 3, 10);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=518 ;

--
-- Dumping data for table `form_skills`
--

INSERT INTO `form_skills` (`id`, `form_id`, `skill_id`, `priority`) VALUES
(452, 1, 2, 8),
(453, 1, 8, 9),
(454, 1, 5, 3),
(455, 1, 9, 8),
(456, 1, 24, 3),
(457, 1, 3, 9),
(458, 1, 4, 7),
(459, 1, 35, 6),
(484, 12, 8, 8),
(485, 12, 7, 5),
(486, 12, 9, 10),
(487, 12, 30, 7),
(488, 12, 36, 9),
(489, 11, 28, 9),
(490, 11, 29, 10),
(491, 11, 30, 7),
(492, 13, 39, 10),
(493, 13, 46, 9),
(494, 13, 41, 8),
(495, 13, 43, 8),
(496, 13, 21, 9),
(497, 13, 42, 6),
(498, 13, 8, 8),
(499, 13, 44, 8),
(500, 13, 45, 8),
(501, 13, 47, 7),
(502, 13, 49, 6),
(503, 13, 48, 8),
(504, 13, 38, 10),
(505, 13, 52, 7),
(506, 13, 51, 9),
(507, 13, 53, 6),
(508, 13, 4, 8),
(509, 13, 55, 6),
(510, 13, 54, 5),
(511, 13, 57, 5),
(512, 13, 56, 7),
(513, 13, 58, 6),
(514, 13, 59, 9),
(515, 13, 60, 7),
(516, 13, 61, 10),
(517, 13, 62, 7);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=63 ;

--
-- Dumping data for table `skills`
--

INSERT INTO `skills` (`id`, `skill`, `user_id`, `category_id`) VALUES
(1, 'NumPy', 1, 2),
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
(31, 'Python', 1, 1),
(32, 'Portfolio Management', 1, 7),
(33, 'Financial Reporting', 1, 7),
(34, 'Financial Modelling', 1, 7),
(35, 'Apache Spark', 1, 2),
(36, 'Data Management', 1, 4),
(37, 'Accounting', 1, 5),
(38, 'Git', 1, 1),
(39, 'PHP', 1, 1),
(40, 'Advanced CSS', 1, 1),
(41, 'HTML5', 1, 1),
(42, 'CURL', 1, 1),
(43, 'CSS3', 1, 1),
(44, 'Custom CMS Development', 1, 1),
(45, 'Wordpress', 1, 1),
(46, 'Android', 1, 1),
(47, 'Joomla', 1, 1),
(48, 'LAMP', 1, 1),
(49, 'Magento', 1, 1),
(50, 'Drupal', 1, 1),
(51, 'MySQL', 1, 1),
(52, 'MariaDB', 1, 1),
(53, 'J2ME', 1, 1),
(54, 'PayPal Integration', 1, 1),
(55, 'Web Services', 1, 1),
(56, 'JSON', 1, 1),
(57, 'PDO', 1, 1),
(58, 'Yii', 1, 1),
(59, 'CodeIgniter', 1, 1),
(60, 'Zend Framework', 1, 1),
(61, 'OOP', 1, 1),
(62, 'Software Engineering Practices', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `company_name` varchar(100) NOT NULL,
  `company_website` varchar(255) DEFAULT NULL,
  `contact` varchar(15) DEFAULT NULL,
  `company_fb_page` varchar(255) DEFAULT NULL,
  `company_twitter_handle` varchar(255) DEFAULT NULL,
  `company_linkedin_page` varchar(255) DEFAULT NULL,
  `email_default_subject` varchar(255) DEFAULT NULL,
  `email_default_message` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `password`, `company_name`, `company_website`, `contact`, `company_fb_page`, `company_twitter_handle`, `company_linkedin_page`, `email_default_subject`, `email_default_message`) VALUES
(1, 'Admin', 'admin@admin.com', 'admin', 'Smart Recruiter', 'http://google.com', '03212863308', NULL, NULL, NULL, 'Thank you for application', 'Hi Muhammad,\n\nThank you for your interest. We wanted to let you know we received your application and we are delighted that you would consider joining our team.\n\nOur team will review your application and will be in touch if your qualifications match our needs for the role. If you are not selected for this position, keep an eye on our jobs page as we''re growing and adding openings.\n\nBest,\nThe SmartRecruit Team'),
(2, 'Rayan Taqdees', 'rayan.taqdees@objectsynergy.com', 'objectsynergy', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

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
(21, 'Offshore software development environment', 1),
(22, 'Investment Banking', 1),
(23, 'Corporate Finance', 1);

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
