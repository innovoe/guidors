-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Oct 14, 2025 at 09:00 AM
-- Server version: 5.7.39
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mentors_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `email_templates`
--

CREATE TABLE `email_templates` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT '0',
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `subject` text,
  `body` text,
  `variables` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `email_templates`
--

INSERT INTO `email_templates` (`id`, `user_id`, `title`, `slug`, `subject`, `body`, `variables`) VALUES
(1, 0, 'Verification', 'verification', 'Email verification', '<p>Hello {{user_name}},</p>\r\n\r\n<p>Welcome to {{site_name}}. Your verification code is: {{verify_code}}</p>\r\n', '{{user_name}},{{site_name}}, {{verify_code}}'),
(2, 0, 'Forgot Password', 'forgot-password', 'Recover password', '<p>Hello {{user_name}},</p>\r\n\r\n<p>We have reset your password, Please use this  {{recovery_password}}  code to login your account</p>\r\n', '{{user_name}}, {{recovery_password}}'),
(3, 0, 'Session Booking Confirmation Mentor', 'session-booking-confirmation-mentor', 'Session Booking confirmation', '<p>{{mentee_name}} recently booked a session {{session_name}} on  {{date}} at {{time}}</p><p>{{booking_number}}</p><p><br></p>\r\n', '{{mentee_name}}, {{session_name}},{{date}},{{time}}, {{booking_number}}'),
(4, 0, 'Session Booking Confirmation Mentee', 'session-booking-confirmation-mentee', 'Session Booking confirmation', '<p><span xss=removed>You have booked a session - {{session_name}} of {{mentor_name}} on {{date}} at {{time}}</span></p><p>{{booking_number}}</p>\r\n\r\n<p> </p>\r\n\r\n<p> </p>\r\n', '{{session_name}}, {{mentor_name}},{{date}}, {{time}},{{booking_number}}'),
(5, 0, 'Session Booking Update Mentee', 'session-booking-update-mentee', 'Session Booking Update Confirmation', '<p>Hello {{mentee_name}} ,</p><p> Your  booked session -    {{session_name}} on {{date}} at {{time}} has been {{status_text}}</p><p><br></p>\r\n', '{{mentee_name}},{{session_name}}, {{date}},{{time}},{{status_text}}'),
(6, 0, 'Mentors Profile Approve Confirmation', 'mentors-profile-approved-confirmatio', 'Profile approve confirmation', '<p>{{name}},{{site_name}},{{admin_email}}</p><p>Hello {{name}},</p><p>Congratulation and welcome to {{site_name}}. Your accunt in {{site_name}} has been approved.</p><p>-Admin ( {{admin_email}} )</p>', '{{name}},{{site_name}}, {{admin_email}}'),
(7, 0, 'Contact Submit Admin', 'contact-submit-admin', 'Contact Message ', '<p>{{message}}</p><p>Email sent by  {{sender_email}}</p>', '{{message}},{{sender_name}},{{sender_email}}'),
(23, 0, 'Sent message Notification', 'sent-message-notification', 'Sent message Notification', '<p>{{sender_name}} sent you a message</p><p>{{sender_email}}</p>', '{{sender_name}},{{sender_email}}');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `email_templates`
--
ALTER TABLE `email_templates`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `email_templates`
--
ALTER TABLE `email_templates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
