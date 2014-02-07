-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 19, 2014 at 03:38 AM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `icsls`
--

-- --------------------------------------------------------

--
-- Table structure for table `reference_material`
--

CREATE TABLE IF NOT EXISTS `reference_material` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(500) NOT NULL,
  `author` tinytext NOT NULL,
  `isbn` varchar(13) DEFAULT NULL,
  `category` char(1) NOT NULL,
  `description` text,
  `publisher` varchar(100) DEFAULT NULL,
  `publication_year` int(4) DEFAULT NULL,
  `access_type` char(1) NOT NULL,
  `course_code` varchar(6) NOT NULL,
  `total_available` int(2) NOT NULL,
  `total_stock` int(2) NOT NULL,
  `times_borrowed` int(5) DEFAULT '0',
  `for_deletion` char(1) DEFAULT 'F',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `reference_material`
--

INSERT INTO `reference_material` (`id`, `title`, `author`, `isbn`, `category`, `description`, `publisher`, `publication_year`, `access_type`, `course_code`, `total_available`, `total_stock`, `times_borrowed`, `for_deletion`) VALUES
(1, 'The C Programming Language', 'Dennis Ritchie', NULL, 'B', 'Learn the basics of the C programming language from its creator, Dennis Ritchie.', 'McGraw-Hill', 1987, 'S', 'cs 21', 4, 4, 0, 'F'),
(2, 'Learn Java Programming', 'Carlo Husmillo, James Gosling', NULL, 'B', 'Learn Java programming in 30 days. The most extensive and well documented reference in learning java.', 'Rex Publishing Inc.', 2008, 'S', 'cs 22', 3, 3, 0, 'F'),
(3, 'Installing Ubuntu', 'Ubuntu Dev Team', NULL, 'C', 'Install ubuntu with this dvd and easy step-by-step video.', 'Ubuntu', 2012, 'S', 'cs 11', 1, 1, 2, 'F'),
(4, 'Advanced Database Systems', 'Tim Berners-Lee, Mike Myers', '101-212-331-1', 'B', 'Detailed discussion about Database concepts, UML diagrams, and SQL queries', 'McGraw-Hill', 2006, 'F', 'cs 127', 2, 2, 5, 'F'),
(5, 'Detecting Junctions in Photographs of Objects', 'Hyunho Richard Lee', NULL, 'T', 'Line drawings are inherently simple, yet retain most of the information of a full\r\nimage.', NULL, 2011, 'S', 'cs 200', 1, 1, 1, 'F'),
(6, 'InProv: Visualizing Provenance Graphs with Radial Layouts and Time-Based Hierarchical Grouping', 'Madelaine Boyd', NULL, 'T', 'In provenance research, the large scale of data sets often complicates analysis and\r\nunderstanding.', NULL, 2011, 'S', 'cs 190', 1, 1, 0, 'F'),
(7, 'Optimal Envy-Free Cake-Cutting', 'Yuga Cohler', NULL, 'S', 'Cake-cutting refers to the allocation of continuous resources to agents with heterogeneous preferences.', NULL, 2012, 'S', 'cs 190', 1, 1, 2, 'F'),
(8, 'Introduction to VHDL', 'Lee Min Ho', '992-213-221-3', 'B', 'Learning VHDL and combinational circuits.', NULL, 2009, 'F', 'cs 132', 2, 2, 0, 'F'),
(9, 'Software Engineering', 'Reginald Recario, Kim Samaniego', '912-331-213-1', 'B', 'Basic concepts about Software engineering, different models used for the software life cycle.', 'Ibon Publishing Inc.', 2010, 'F', 'cs 128', 3, 3, 10, 'F'),
(10, 'Software Engineering', 'Kassem Saleh', '978-233-982-1', 'B', 'Software engineering concepts. Documentation, SRS, stakeholders.', 'Cengage Learning Asia, Ltd.', 2009, 'F', 'cs 128', 2, 2, 3, 'F'),
(11, 'Introduction to WebGL', 'James Plaras', '490-231-233-0', 'B', 'Easy way to learn WebGL with the comprehensive and thorough discussions in this book.', 'Pearson Asia', 2011, 'S', 'cs 161', 1, 1, 0, 'F'),
(12, 'Artificial Intelligence: A Modern Approach', 'S.J. Russell and P. Norvig', NULL, 'B', 'A book that teaches artificial intelligence concepts, probability, and its application in real world.', 'Prentice Hall', 2010, 'S', 'cs 170', 2, 2, 2, 'F'),
(13, 'Data Structures and Algorithm Analysis in C', 'Mark Allen Weiss', '122-422-341-1', 'B', 'Comprehensive discussion about stacks, queues, heaps, trees, hash tables, and all other data structures with their running time analysis.', 'Pearson Asia', 1994, 'S', 'cs 123', 1, 1, 7, 'F'),
(14, 'Data Structures and Algorithm Analysis', 'Nicklaus Wirth, Alfred Aho', '923-532-227-0', 'B', 'Detailed discussion about data structures with run time analysis of sorting techniques and other basic algorithms used in computer science.', 'Stanford University', 1990, 'S', 'cs 123', 1, 1, 3, 'F'),
(15, 'Structural Programming in C', 'Jose Carlo Husmillo', '901-221-365-1', 'B', 'Modular approach in C programming with concepts in parameter passing and dynamic memory allocation.', 'Prentice Hall', 2006, 'S', 'cs 21', 2, 2, 16, 'F'),
(16, 'Learn the C programming language', 'Jan Claudette Quevedo, Khemberly Cumal, Alyssa Bianca Cos', '344-232-235-0', 'B', 'Learn the C programming language in 30 days.', 'Rex Publishing House', 2009, 'S', 'cs 11', 4, 4, 11, 'F'),
(17, 'Object Oriented Programming and C++', 'Bjourne Stroustrup', '436-432-235-0', 'B', 'Learn Object Oriented Programming using C++', 'McGraw-Hill', 1997, 'F', 'cs 22', 2, 2, 8, 'F'),
(18, 'The Internet and Web Programming', 'Mark Zuckerberg, Eric Schmidt, Larry Page', '634-323-323-1', 'B', 'History of the internet, advanced web programming, packets, network connections and emerging web technologies.', 'Prentice Hall', 2008, 'S', 'cs 100', 1, 1, 7, 'F'),
(19, 'C: How to program', 'P.J. Deitel, H.M. Deitel', '923-322-232-1', 'B', 'Build up your skill as a C programmer. Basic C tutorial.', 'Pearson Asia', 2005, 'S', 'cs 11', 1, 1, 0, 'F'),
(20, 'Artificial Intelligence', 'Donald E. Knuth', '923-920-233-1', 'B', 'Artificial intelligence concepts, probability, and applications in real life.', 'Pearson Asia', 2003, 'F', 'cs 170', 2, 2, 4, 'F');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
