-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 28, 2024 at 04:11 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `im2_school_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins_table`
--

CREATE TABLE `admins_table` (
  `admin_id` int(11) NOT NULL,
  `admin_email` varchar(150) NOT NULL,
  `admin_password` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins_table`
--

INSERT INTO `admins_table` (`admin_id`, `admin_email`, `admin_password`) VALUES
(4, 'admin1@gmail.com', 'admin1password');

--
-- Triggers `admins_table`
--
DELIMITER $$
CREATE TRIGGER `after_admin_insert` AFTER INSERT ON `admins_table` FOR EACH ROW BEGIN
   INSERT INTO users_table(user_id, user_email, user_password, user_type) 
   VALUES (NEW.admin_id, NEW.admin_email, NEW.admin_password, 'admin');
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `courses_table`
--

CREATE TABLE `courses_table` (
  `course_id` int(11) NOT NULL,
  `course_name` varchar(150) NOT NULL,
  `credits` int(11) NOT NULL,
  `department_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses_table`
--

INSERT INTO `courses_table` (`course_id`, `course_name`, `credits`, `department_id`) VALUES
(7, 'Bachelor of Science in Accountancy', 190, 23),
(11, 'Bachelor of Science in Information Technology', 183, 22),
(12, 'Bachelor of Science in Financial Management', 180, 23),
(13, 'Bachelor of Science in Elementary Education', 150, 25),
(16, 'aaa', 123, 25);

-- --------------------------------------------------------

--
-- Table structure for table `departments_table`
--

CREATE TABLE `departments_table` (
  `department_id` int(11) NOT NULL,
  `department_name` varchar(150) NOT NULL,
  `department_logo` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departments_table`
--

INSERT INTO `departments_table` (`department_id`, `department_name`, `department_logo`) VALUES
(22, 'College of Computer Studies', '658bddd57fdfd.jpg'),
(23, 'College of Commerce', '658bdde65e24c.jpg'),
(24, 'College of Criminal Justice', '658bddfcd2547.png'),
(25, 'College of Education', '658bde0a6f15f.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `facultysubjects_table`
--

CREATE TABLE `facultysubjects_table` (
  `subject_id` int(11) NOT NULL,
  `subject_name` varchar(150) NOT NULL,
  `subject_description` varchar(150) NOT NULL,
  `teacher_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `facultysubjects_table`
--

INSERT INTO `facultysubjects_table` (`subject_id`, `subject_name`, `subject_description`, `teacher_id`) VALUES
(0, 'asd', 'asd', 4),
(8, 'Meth', 'Mental Abuse', 4),
(9, 'adf', 'adfasdf', 7),
(10, 'dsaf', 'adsf', 7),
(11, 'trialsub', 'trial', 13),
(12, 'Information Management 2', 'This subject is hard', 4);

-- --------------------------------------------------------

--
-- Table structure for table `grades_table`
--

CREATE TABLE `grades_table` (
  `grade_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `prelim_grade` int(11) NOT NULL,
  `midterm_grade` int(11) NOT NULL,
  `semi_finals_grade` int(11) NOT NULL,
  `finals_grade` int(11) NOT NULL,
  `facultysubject_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `grades_table`
--

INSERT INTO `grades_table` (`grade_id`, `student_id`, `subject_id`, `prelim_grade`, `midterm_grade`, `semi_finals_grade`, `finals_grade`, `facultysubject_id`) VALUES
(1, 1, 8, 95, 75, 75, 90, 9),
(2, 2, 9, 0, 85, 100, 80, 12),
(3, 3, 11, 70, 100, 90, 95, 0),
(4, 4, 10, 85, 90, 95, 75, 12),
(5, 5, 0, 75, 0, 90, 0, 11),
(6, 6, 0, 90, 90, 0, 75, 8),
(7, 7, 8, 70, 0, 90, 100, 11),
(8, 8, 12, 90, 80, 90, 70, 11),
(9, 9, 9, 100, 90, 95, 75, 8),
(10, 10, 10, 90, 95, 85, 70, 11),
(11, 11, 12, 100, 95, 75, 95, 0),
(12, 12, 12, 95, 70, 90, 75, 0),
(13, 13, 12, 100, 90, 100, 75, 9),
(14, 14, 9, 80, 85, 0, 95, 12),
(15, 15, 9, 95, 75, 75, 70, 10),
(16, 16, 9, 70, 75, 90, 85, 12),
(17, 17, 12, 0, 70, 80, 75, 0),
(18, 18, 12, 100, 85, 75, 70, 10),
(19, 19, 8, 80, 0, 100, 70, 0),
(20, 20, 12, 90, 80, 75, 100, 9),
(21, 21, 0, 100, 100, 95, 95, 9),
(22, 22, 10, 100, 0, 0, 95, 8),
(23, 23, 11, 100, 85, 95, 95, 12),
(24, 24, 9, 95, 0, 80, 100, 12),
(25, 25, 12, 90, 95, 100, 100, 0),
(26, 26, 11, 85, 80, 95, 70, 12),
(27, 27, 12, 75, 95, 0, 90, 0),
(28, 28, 9, 0, 95, 100, 85, 0),
(29, 29, 10, 70, 85, 95, 70, 12),
(30, 30, 11, 90, 95, 75, 100, 8),
(31, 31, 11, 85, 100, 70, 95, 0),
(32, 32, 10, 75, 0, 100, 90, 11),
(33, 33, 11, 90, 75, 75, 85, 12),
(34, 34, 12, 75, 85, 85, 0, 8),
(35, 35, 11, 80, 90, 80, 70, 0),
(36, 36, 8, 95, 90, 90, 75, 10),
(37, 37, 8, 80, 0, 100, 100, 11),
(38, 38, 0, 70, 90, 90, 0, 9),
(39, 39, 11, 100, 85, 100, 85, 0),
(40, 40, 11, 100, 90, 100, 75, 11),
(41, 41, 9, 100, 80, 100, 70, 10),
(42, 42, 9, 95, 85, 70, 80, 10),
(43, 43, 10, 90, 80, 0, 0, 8),
(44, 44, 10, 90, 80, 80, 80, 9),
(45, 45, 8, 90, 95, 95, 80, 9),
(46, 46, 10, 70, 75, 90, 85, 12),
(47, 47, 11, 95, 85, 70, 70, 8),
(48, 48, 0, 70, 80, 0, 85, 8),
(49, 49, 0, 85, 80, 100, 80, 8),
(50, 50, 8, 100, 80, 95, 90, 9),
(51, 51, 12, 90, 70, 100, 75, 10),
(52, 52, 10, 95, 80, 85, 90, 9),
(53, 53, 9, 85, 70, 95, 0, 10),
(54, 54, 9, 85, 90, 95, 90, 0),
(55, 55, 0, 95, 85, 90, 80, 12),
(56, 56, 8, 85, 100, 70, 100, 0),
(57, 57, 11, 75, 0, 90, 100, 12),
(58, 58, 8, 80, 90, 90, 85, 12),
(59, 59, 0, 70, 90, 100, 95, 12),
(60, 60, 0, 90, 70, 75, 85, 10),
(61, 61, 9, 100, 85, 95, 100, 0),
(62, 62, 9, 100, 70, 95, 90, 11),
(63, 63, 9, 75, 85, 100, 0, 10),
(64, 64, 10, 90, 75, 90, 85, 10),
(65, 65, 9, 80, 70, 85, 70, 8),
(66, 66, 8, 100, 75, 75, 100, 8),
(67, 67, 11, 90, 75, 80, 70, 10),
(68, 68, 11, 100, 70, 85, 85, 8),
(69, 69, 10, 90, 100, 85, 0, 0),
(70, 70, 12, 0, 85, 95, 100, 8),
(71, 71, 10, 95, 85, 95, 90, 8),
(72, 72, 10, 80, 75, 90, 0, 10),
(73, 73, 12, 70, 70, 90, 95, 11),
(74, 74, 12, 80, 85, 75, 80, 11),
(75, 75, 9, 75, 85, 75, 75, 11),
(76, 76, 12, 100, 75, 0, 95, 0),
(77, 77, 12, 75, 70, 70, 80, 12),
(78, 78, 10, 80, 85, 0, 75, 9),
(79, 79, 9, 95, 100, 95, 95, 10),
(80, 80, 0, 85, 100, 95, 80, 9),
(81, 81, 12, 95, 95, 100, 80, 9),
(82, 82, 11, 80, 75, 95, 0, 9),
(83, 83, 8, 100, 95, 100, 95, 8),
(84, 84, 0, 100, 85, 100, 90, 11),
(85, 85, 11, 70, 0, 75, 70, 8),
(86, 86, 8, 70, 90, 0, 85, 8),
(87, 87, 0, 80, 70, 95, 75, 0),
(88, 88, 8, 0, 0, 70, 70, 11),
(89, 89, 10, 75, 75, 90, 95, 11),
(90, 90, 12, 0, 80, 70, 80, 12),
(91, 91, 11, 0, 75, 85, 95, 9),
(92, 92, 11, 100, 95, 0, 95, 10),
(93, 93, 11, 70, 70, 75, 95, 10),
(94, 94, 12, 90, 70, 70, 75, 0),
(95, 95, 11, 0, 85, 70, 70, 10),
(96, 96, 8, 80, 70, 95, 90, 12),
(97, 97, 12, 95, 75, 85, 85, 11),
(98, 98, 12, 80, 85, 85, 100, 11),
(99, 99, 0, 70, 95, 0, 0, 8),
(100, 100, 9, 75, 80, 95, 100, 12);

-- --------------------------------------------------------

--
-- Table structure for table `grades_table2`
--

CREATE TABLE `grades_table2` (
  `grade_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `prelim_grade` int(11) NOT NULL,
  `midterm_grade` int(11) NOT NULL,
  `semi_finals_grade` int(11) NOT NULL,
  `finals_grade` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `semesters_table`
--

CREATE TABLE `semesters_table` (
  `semester_id` int(11) NOT NULL,
  `semester_year` varchar(100) NOT NULL,
  `year_level` varchar(100) NOT NULL,
  `subject_name` varchar(110) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `semesters_table`
--

INSERT INTO `semesters_table` (`semester_id`, `semester_year`, `year_level`, `subject_name`) VALUES
(6, '4th', '4th Year', 'Meth'),
(7, '1st', 'Year 1', 'trialsub'),
(8, '2nd', '1st Year', 'trialsub'),
(9, '3rd', 'Year 3', 'dsaf'),
(10, '2nd', '1st Year', 'Information Management 2');

-- --------------------------------------------------------

--
-- Table structure for table `students_table`
--

CREATE TABLE `students_table` (
  `student_id` int(11) NOT NULL,
  `student_fname` varchar(150) NOT NULL,
  `student_lname` varchar(150) NOT NULL,
  `student_email` varchar(100) NOT NULL,
  `department_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `year_level` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students_table`
--

INSERT INTO `students_table` (`student_id`, `student_fname`, `student_lname`, `student_email`, `department_id`, `course_id`, `year_level`) VALUES
(1, 'Touko', 'Namami', '0', 25, 13, 2),
(2, 'Rae', 'Taylor', '0', 22, 11, 1),
(3, 'Virginia', 'Quantrill', 'vquantrill2@t.co', 24, 11, 1),
(4, 'Claire', 'Francois', 'claire@gmail.com', 23, 12, 4),
(5, 'Yuu', 'Koito', 'yuu@gmail.com', 25, 13, 1),
(6, 'Fair', 'Yurlov', 'fyurlov5@ihg.com', 22, 16, 2),
(7, 'rina', 'reyna', 'rina@gmail.com', 23, 11, 4),
(8, 'Rina Mae', 'Romero', 'rinamaeromero@gmail.com', 22, 11, 3),
(9, 'Brien', 'Harle', 'bharle8@youtu.be', 24, 12, 2),
(10, 'Binky', 'Filippazzo', 'bfilippazzo9@wordpress.org', 22, 11, 2),
(14, 'Nathanil', 'Mattevi', 'nmattevid@apple.com', 25, 13, 4),
(15, 'Cristen', 'Caruth', 'ccaruthe@kickstarter.com', 24, 7, 1),
(16, 'Caz', 'Beneyto', 'cbeneytof@biglobe.ne.jp', 22, 16, 3),
(17, 'Berti', 'Benza', 'bbenzag@vkontakte.ru', 25, 11, 1),
(18, 'Merla', 'Chanson', 'mchansonh@hud.gov', 22, 12, 3),
(19, 'Horacio', 'Bew', 'hbewi@narod.ru', 25, 12, 4),
(20, 'Selena', 'Cuss', 'scussj@4shared.com', 25, 12, 2),
(21, 'Hyacintha', 'Kobierra', 'hkobierrak@army.mil', 23, 12, 2),
(22, 'Ossie', 'Fibbit', 'ofibbitl@skype.com', 25, 7, 1),
(23, 'Lucy', 'McShea', 'lmcsheam@pen.io', 24, 11, 4),
(24, 'Ernesto', 'Ege', 'eegen@typepad.com', 22, 13, 2),
(25, 'Charley', 'Bartoloma', 'cbartolomao@mozilla.com', 24, 13, 1),
(26, 'Dion', 'Gainor', 'dgainorp@parallels.com', 22, 7, 3),
(27, 'Cornie', 'Freeburn', 'cfreeburnq@netlog.com', 23, 11, 3),
(28, 'Dulcea', 'Bilam', 'dbilamr@acquirethisname.com', 23, 16, 4),
(29, 'Jeni', 'Methingam', 'jmethingams@miibeian.gov.cn', 23, 11, 2),
(30, 'Gwyneth', 'Normandale', 'gnormandalet@admin.ch', 25, 16, 2),
(31, 'Betty', 'Chmarny', 'bchmarnyu@diigo.com', 22, 7, 3),
(32, 'Rodie', 'Sharpless', 'rsharplessv@ftc.gov', 22, 12, 2),
(33, 'Yankee', 'Fulep', 'yfulepw@elegantthemes.com', 22, 7, 2),
(34, 'Doloritas', 'Markus', 'dmarkusx@tmall.com', 25, 12, 2),
(35, 'Lissie', 'Gerrell', 'lgerrelly@wunderground.com', 22, 7, 1),
(36, 'Belita', 'Reiling', 'breilingz@scribd.com', 24, 13, 4),
(37, 'Lin', 'Scare', 'lscare10@meetup.com', 23, 13, 2),
(38, 'Gwenni', 'Woodley', 'gwoodley11@yale.edu', 23, 12, 2),
(39, 'Roby', 'Staines', 'rstaines12@ebay.com', 24, 13, 2),
(40, 'Pat', 'Pulver', 'ppulver13@pinterest.com', 24, 11, 3),
(41, 'Isak', 'Kunzel', 'ikunzel14@facebook.com', 25, 11, 4),
(42, 'Beatrisa', 'Mabone', 'bmabone15@rambler.ru', 22, 7, 3),
(43, 'Crissie', 'Thaxton', 'cthaxton16@wikia.com', 22, 7, 4),
(44, 'Bradney', 'Prisley', 'bprisley17@google.com.hk', 25, 11, 4),
(45, 'Meggy', 'Alphonso', 'malphonso18@mysql.com', 25, 13, 1),
(46, 'Casi', 'Saltwell', 'csaltwell19@jiathis.com', 23, 7, 1),
(47, 'Emmaline', 'Boards', 'eboards1a@mtv.com', 23, 11, 4),
(48, 'Dar', 'Desvignes', 'ddesvignes1b@hao123.com', 25, 16, 4),
(49, 'Viviene', 'Sullly', 'vsullly1c@discuz.net', 22, 13, 1),
(50, 'Penrod', 'Knibbs', 'pknibbs1d@blog.com', 22, 11, 4),
(51, 'Willis', 'Giamelli', 'wgiamelli1e@umich.edu', 25, 13, 4);

--
-- Triggers `students_table`
--
DELIMITER $$
CREATE TRIGGER `after_student_insert` AFTER INSERT ON `students_table` FOR EACH ROW BEGIN
   INSERT INTO users_table(user_id, user_email, user_password, user_type) 
   VALUES (NEW.student_id, NEW.student_email, 'default_password', 'student');
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `subjects_table`
--

CREATE TABLE `subjects_table` (
  `subject_id` int(11) NOT NULL,
  `subject_name` varchar(150) NOT NULL,
  `subject_description` varchar(150) NOT NULL,
  `course_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subjects_table`
--

INSERT INTO `subjects_table` (`subject_id`, `subject_name`, `subject_description`, `course_id`) VALUES
(8, 'Meth', 'Mental Abuse', 16),
(9, 'adf', 'adfasdf', 16),
(10, 'dsaf', 'adsf', 7),
(11, 'trialsub', 'trial', 12),
(12, 'Information Management 2', 'This subject is hard', 11);

--
-- Triggers `subjects_table`
--
DELIMITER $$
CREATE TRIGGER `subjects_after_delete` AFTER DELETE ON `subjects_table` FOR EACH ROW BEGIN
    DELETE FROM facultysubjects_table
    WHERE subject_id = OLD.subject_id;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `subjects_after_insert` AFTER INSERT ON `subjects_table` FOR EACH ROW BEGIN
    INSERT INTO facultySubjects_table(subject_id, subject_name, subject_description)
    VALUES (NEW.subject_id, NEW.subject_name, NEW.subject_description);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `subjects_after_update` AFTER UPDATE ON `subjects_table` FOR EACH ROW BEGIN
    UPDATE facultysubjects_table
    SET subject_name = NEW.subject_name, subject_description = NEW.subject_description
    WHERE subject_id = NEW.subject_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `teachers_table`
--

CREATE TABLE `teachers_table` (
  `teacher_id` int(11) NOT NULL,
  `teacher_fname` varchar(150) NOT NULL,
  `teacher_lname` varchar(150) NOT NULL,
  `teacher_email` varchar(150) NOT NULL,
  `teacher_password` varchar(150) NOT NULL,
  `teacher_picture` varchar(150) NOT NULL,
  `department_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teachers_table`
--

INSERT INTO `teachers_table` (`teacher_id`, `teacher_fname`, `teacher_lname`, `teacher_email`, `teacher_password`, `teacher_picture`, `department_id`) VALUES
(4, 'Goldi', 'Creepy', 'goldfish@gmail.com', 'catisakiddiemeal', '658c61b07f1d2.png', 23),
(5, 'Unifast', 'Goldfish', 'unifastgoldfish@gmail.com', 'iloveath', '658c627d1c7f9.png', 25),
(6, 'Victoria', 'Kobayashi', 'victoriakobayashi553@gmail.com', '1234567890', '658c62b14198b.jpg', 22),
(7, 'Terakomari', 'Gandesblood', 'komari@gmail.com', 'ilovevillhave', '658f160b3fd82.png', 24),
(9, '123', '123', '123@gmail.com', '123', '6593ddccf3c9d.png', 25),
(11, 'Cat', 'Win', 'cat@gmail.com', 'catwin', '6593f69235694.png', 22),
(13, 'adsf', 'asdf', 'brunomars@gmail.com', 'bruno', '65998798cc7f0.png', 22);

--
-- Triggers `teachers_table`
--
DELIMITER $$
CREATE TRIGGER `after_teacher_insert` AFTER INSERT ON `teachers_table` FOR EACH ROW BEGIN
   INSERT INTO users_table(user_id, user_email, user_password, user_type) 
   VALUES (NEW.teacher_id, NEW.teacher_email, NEW.teacher_password, 'teacher');
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `users_table`
--

CREATE TABLE `users_table` (
  `user_id` int(11) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_password` varchar(100) NOT NULL,
  `user_type` varchar(50) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users_table`
--

INSERT INTO `users_table` (`user_id`, `user_email`, `user_password`, `user_type`) VALUES
(3, 'vquantrill2@t.co', 'default_password', 'student'),
(4, 'admin1@gmail.com', 'admin1password', 'admin'),
(6, 'fyurlov5@ihg.com', 'default_password', 'student'),
(9, 'bharle8@youtu.be', 'default_password', 'student'),
(10, 'bfilippazzo9@wordpress.org', 'default_password', 'student'),
(12, 'goldfish@gmail.com', 'catisakiddiemeal', 'teacher'),
(13, 'brunomars@gmail.com', 'bruno', 'teacher'),
(14, 'nmattevid@apple.com', 'default_password', 'student'),
(15, 'ccaruthe@kickstarter.com', 'default_password', 'student'),
(16, 'cbeneytof@biglobe.ne.jp', 'default_password', 'student'),
(17, 'bbenzag@vkontakte.ru', 'default_password', 'student'),
(18, 'mchansonh@hud.gov', 'default_password', 'student'),
(19, 'hbewi@narod.ru', 'default_password', 'student'),
(20, 'scussj@4shared.com', 'default_password', 'student'),
(21, 'hkobierrak@army.mil', 'default_password', 'student'),
(22, 'ofibbitl@skype.com', 'default_password', 'student'),
(23, 'lmcsheam@pen.io', 'default_password', 'student'),
(24, 'eegen@typepad.com', 'default_password', 'student'),
(25, 'cbartolomao@mozilla.com', 'default_password', 'student'),
(26, 'dgainorp@parallels.com', 'default_password', 'student'),
(27, 'cfreeburnq@netlog.com', 'default_password', 'student'),
(28, 'dbilamr@acquirethisname.com', 'default_password', 'student'),
(29, 'jmethingams@miibeian.gov.cn', 'default_password', 'student'),
(30, 'gnormandalet@admin.ch', 'default_password', 'student'),
(31, 'bchmarnyu@diigo.com', 'default_password', 'student'),
(32, 'rsharplessv@ftc.gov', 'default_password', 'student'),
(33, 'yfulepw@elegantthemes.com', 'default_password', 'student'),
(34, 'dmarkusx@tmall.com', 'default_password', 'student'),
(35, 'lgerrelly@wunderground.com', 'default_password', 'student'),
(36, 'breilingz@scribd.com', 'default_password', 'student'),
(37, 'lscare10@meetup.com', 'default_password', 'student'),
(38, 'gwoodley11@yale.edu', 'default_password', 'student'),
(39, 'rstaines12@ebay.com', 'default_password', 'student'),
(40, 'ppulver13@pinterest.com', 'default_password', 'student'),
(41, 'ikunzel14@facebook.com', 'default_password', 'student'),
(42, 'bmabone15@rambler.ru', 'default_password', 'student'),
(43, 'cthaxton16@wikia.com', 'default_password', 'student'),
(44, 'bprisley17@google.com.hk', 'default_password', 'student'),
(45, 'malphonso18@mysql.com', 'default_password', 'student'),
(46, 'csaltwell19@jiathis.com', 'default_password', 'student'),
(47, 'eboards1a@mtv.com', 'default_password', 'student'),
(48, 'ddesvignes1b@hao123.com', 'default_password', 'student'),
(49, 'vsullly1c@discuz.net', 'default_password', 'student'),
(50, 'pknibbs1d@blog.com', 'default_password', 'student'),
(51, 'wgiamelli1e@umich.edu', 'default_password', 'student');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins_table`
--
ALTER TABLE `admins_table`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `courses_table`
--
ALTER TABLE `courses_table`
  ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `departments_table`
--
ALTER TABLE `departments_table`
  ADD PRIMARY KEY (`department_id`);

--
-- Indexes for table `grades_table`
--
ALTER TABLE `grades_table`
  ADD PRIMARY KEY (`grade_id`);

--
-- Indexes for table `grades_table2`
--
ALTER TABLE `grades_table2`
  ADD PRIMARY KEY (`grade_id`),
  ADD KEY `grades_to_student` (`student_id`);

--
-- Indexes for table `semesters_table`
--
ALTER TABLE `semesters_table`
  ADD PRIMARY KEY (`semester_id`);

--
-- Indexes for table `students_table`
--
ALTER TABLE `students_table`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `subjects_table`
--
ALTER TABLE `subjects_table`
  ADD PRIMARY KEY (`subject_id`);

--
-- Indexes for table `teachers_table`
--
ALTER TABLE `teachers_table`
  ADD PRIMARY KEY (`teacher_id`);

--
-- Indexes for table `users_table`
--
ALTER TABLE `users_table`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins_table`
--
ALTER TABLE `admins_table`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `courses_table`
--
ALTER TABLE `courses_table`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `departments_table`
--
ALTER TABLE `departments_table`
  MODIFY `department_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `grades_table`
--
ALTER TABLE `grades_table`
  MODIFY `grade_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `grades_table2`
--
ALTER TABLE `grades_table2`
  MODIFY `grade_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `semesters_table`
--
ALTER TABLE `semesters_table`
  MODIFY `semester_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `students_table`
--
ALTER TABLE `students_table`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `subjects_table`
--
ALTER TABLE `subjects_table`
  MODIFY `subject_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `teachers_table`
--
ALTER TABLE `teachers_table`
  MODIFY `teacher_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users_table`
--
ALTER TABLE `users_table`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `facultysubjects_table`
--
ALTER TABLE `facultysubjects_table`
  ADD CONSTRAINT `facultySubjects_to_teachers` FOREIGN KEY (`teacher_id`) REFERENCES `teachers_table` (`teacher_id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `grades_table2`
--
ALTER TABLE `grades_table2`
  ADD CONSTRAINT `grades_to_student` FOREIGN KEY (`student_id`) REFERENCES `students_table` (`student_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `students_table`
--
ALTER TABLE `students_table`
  ADD CONSTRAINT `students_to_course` FOREIGN KEY (`course_id`) REFERENCES `courses_table` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `students_to_department` FOREIGN KEY (`department_id`) REFERENCES `departments_table` (`department_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `teachers_table`
--
ALTER TABLE `teachers_table`
  ADD CONSTRAINT `teacher_to_department` FOREIGN KEY (`department_id`) REFERENCES `departments_table` (`department_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
