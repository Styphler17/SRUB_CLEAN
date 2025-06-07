-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 07, 2025 at 02:39 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `scrubhub`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'admin',
  `picture` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`, `email`, `role`, `picture`, `created_at`, `updated_at`) VALUES
(1, 'super_admin', '$2y$10$yXulwyokJ9.86pDdEVjhM.JP4lehkrLWUJ1tXmcdqYeXZysJfKPjO', 'salo.aseidua34@gmail.com', 'admin', '../assets/images/admins/684078684d9fa_cleanesta-logo.png', '2025-06-04 07:16:20', '2025-06-06 22:29:57');

-- --------------------------------------------------------

--
-- Table structure for table `admin_activity_log`
--

CREATE TABLE `admin_activity_log` (
  `id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `action` varchar(255) NOT NULL,
  `details` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_activity_log`
--

INSERT INTO `admin_activity_log` (`id`, `admin_id`, `action`, `details`, `created_at`) VALUES
(1, 1, 'Updated service', 'Service ID: 13', '2025-06-07 00:56:37'),
(2, 1, 'Logged in', NULL, '2025-06-07 00:57:45'),
(3, 1, 'Updated general settings', NULL, '2025-06-07 09:16:59'),
(4, 1, 'Updated general settings', NULL, '2025-06-07 09:17:11'),
(5, 1, 'Updated general settings', NULL, '2025-06-07 09:18:32'),
(6, 1, 'Updated general settings', NULL, '2025-06-07 09:18:57'),
(7, 1, 'Updated general settings', NULL, '2025-06-07 09:23:24'),
(8, 1, 'Updated general settings', NULL, '2025-06-07 09:23:41'),
(9, 1, 'Updated general settings', NULL, '2025-06-07 09:23:51'),
(10, 1, 'Updated general settings', NULL, '2025-06-07 09:24:07'),
(11, 1, 'Updated general settings', NULL, '2025-06-07 09:24:24'),
(12, 1, 'Updated general settings', NULL, '2025-06-07 09:26:32');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `booking_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `status` enum('pending','confirmed','completed','cancelled') DEFAULT 'pending',
  `total_price` decimal(10,2) NOT NULL,
  `special_instructions` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `business_hours`
--

CREATE TABLE `business_hours` (
  `id` int(11) NOT NULL,
  `day` varchar(20) NOT NULL,
  `open_time` time DEFAULT NULL,
  `close_time` time DEFAULT NULL,
  `is_closed` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `business_hours`
--

INSERT INTO `business_hours` (`id`, `day`, `open_time`, `close_time`, `is_closed`, `created_at`, `updated_at`) VALUES
(1, 'Monday', '08:00:00', '18:00:00', 0, '2025-06-04 10:33:47', '2025-06-04 10:33:47'),
(2, 'Tuesday', '08:00:00', '18:00:00', 0, '2025-06-04 10:33:47', '2025-06-04 10:33:47'),
(3, 'Wednesday', '08:00:00', '18:00:00', 0, '2025-06-04 10:33:47', '2025-06-04 10:33:47'),
(4, 'Thursday', '08:00:00', '18:00:00', 0, '2025-06-04 10:33:47', '2025-06-04 10:33:47'),
(5, 'Friday', '08:00:00', '18:00:00', 0, '2025-06-04 10:33:47', '2025-06-04 10:33:47'),
(6, 'Saturday', '09:00:00', '16:00:00', 0, '2025-06-04 10:33:47', '2025-06-04 10:33:47'),
(7, 'Sunday', NULL, NULL, 1, '2025-06-04 10:33:47', '2025-06-04 10:33:47');

-- --------------------------------------------------------

--
-- Table structure for table `contact_info`
--

CREATE TABLE `contact_info` (
  `id` int(11) NOT NULL,
  `whatsapp_link` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `phone_numbers` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`phone_numbers`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_info`
--

INSERT INTO `contact_info` (`id`, `whatsapp_link`, `email`, `created_at`, `updated_at`, `phone_numbers`) VALUES
(1, 'https://wa.me/447359129002', 'salo.aseidua34@gmail.com', '2025-06-04 10:33:10', '2025-06-06 20:08:41', '[\"+44 735 912 9002\", \"+44 740 363 8555\"]');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `booking_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL CHECK (`rating` >= 1 and `rating` <= 5),
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_by_admin` int(11) DEFAULT NULL,
  `updated_by_admin` int(11) DEFAULT NULL,
  `deleted_by_admin` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `name`, `admin_id`, `booking_id`, `rating`, `comment`, `created_at`, `updated_at`, `created_by_admin`, `updated_by_admin`, `deleted_by_admin`) VALUES
(1, NULL, NULL, 1, 5, 'Excellent service! Very thorough and professional.', '2025-05-31 10:46:47', '2025-05-31 10:46:47', NULL, NULL, NULL),
(2, NULL, NULL, 2, 4, 'Good deep cleaning service. Would recommend.', '2025-05-31 10:46:47', '2025-05-31 10:46:47', NULL, NULL, NULL),
(3, 'cole', NULL, 0, 4, 'great', '2025-06-04 09:16:38', '2025-06-04 09:16:38', NULL, NULL, NULL),
(4, 'test', NULL, 0, 3, 'test', '2025-06-04 19:11:10', '2025-06-04 19:11:10', NULL, NULL, NULL),
(5, 'test', NULL, 0, 3, 'testjjb', '2025-06-05 10:43:08', '2025-06-06 22:44:20', NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `base_price` decimal(10,2) NOT NULL,
  `duration_minutes` int(11) NOT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_by_admin` int(11) DEFAULT NULL,
  `updated_by_admin` int(11) DEFAULT NULL,
  `deleted_by_admin` int(11) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `duration` varchar(255) NOT NULL,
  `features` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`features`)),
  `benefits` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `name`, `description`, `base_price`, `duration_minutes`, `is_active`, `created_at`, `updated_at`, `created_by_admin`, `updated_by_admin`, `deleted_by_admin`, `image`, `price`, `duration`, `features`, `benefits`) VALUES
(1, 'Regular House Cleaning', 'Standard cleaning service for your home including dusting, vacuuming, and bathroom cleaning', 89.99, 120, 1, '2025-05-31 10:46:47', '2025-06-06 13:21:16', NULL, 1, NULL, '', 0.00, '', '[]', '[]'),
(2, 'Office Cleaning', 'Professional cleaning service for office spaces and commercial properties', 129.99, 180, 1, '2025-05-31 10:46:47', '2025-06-04 06:17:26', NULL, NULL, NULL, '', 0.00, '', '[]', ''),
(3, 'End Of Tenancy Cleaning', 'A comprehensive cleaning service designed for tenants, landlords, and letting agents. Our End Of Tenancy Cleaning ensures every corner of the property is spotless, helping you secure your deposit or prepare for new tenants. Includes deep cleaning of kitchens, bathrooms, living areas, appliances, and all surfaces.', 199.99, 300, 1, '2025-06-04 05:53:56', '2025-06-04 06:17:26', NULL, NULL, NULL, '', 0.00, '', '[]', '[]'),
(4, 'After Events Cleaning', 'Restore your venue to pristine condition after any event! Our After Events Cleaning service handles post-party mess, including trash removal, stain treatment, floor and surface cleaning, and resetting the space for regular use. Perfect for private parties, corporate events, and celebrations.', 179.99, 240, 1, '2025-06-04 05:53:56', '2025-06-04 06:17:26', NULL, NULL, NULL, '', 0.00, '', '[]', '[]'),
(5, 'Vacuuming', 'A focused cleaning service dedicated to thorough vacuuming of all carpets, rugs, and floors. Ideal for removing dust, dirt, pet hair, and allergens, leaving your home or office fresh and spotless.', 49.99, 60, 1, '2025-06-04 06:02:40', '2025-06-04 06:17:26', NULL, NULL, NULL, '', 0.00, '', '[]', '[]'),
(6, 'School Cleaning', 'A specialized cleaning service tailored for educational environments. Our School Cleaning ensures classrooms, hallways, restrooms, and common areas are thoroughly cleaned and sanitized, providing a safe and healthy space for students and staff.', 299.99, 360, 1, '2025-06-04 06:08:10', '2025-06-04 06:17:26', NULL, NULL, NULL, '', 0.00, '', '[]', '[]'),
(13, 'Football Knews', 'uigilj', 85.00, 45, 1, '2025-06-06 22:44:07', '2025-06-06 22:56:37', 1, 1, NULL, '', 0.00, '', '[]', '[]');

-- --------------------------------------------------------

--
-- Table structure for table `service_areas`
--

CREATE TABLE `service_areas` (
  `id` int(11) NOT NULL,
  `area_name` varchar(100) NOT NULL,
  `zip_code` varchar(20) NOT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_by_admin` int(11) DEFAULT NULL,
  `updated_by_admin` int(11) DEFAULT NULL,
  `deleted_by_admin` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `sid` varchar(36) NOT NULL,
  `expires` datetime DEFAULT NULL,
  `data` text DEFAULT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `setting_key`, `setting_value`, `created_at`, `updated_at`) VALUES
(1, 'cleanesta-logo', '../assets/images/logo/cleanesta-services-logo.png', '2025-06-04 10:34:03', '2025-06-07 07:18:32'),
(2, 'favicon', '../assets/images/logo/cleanesta-services-logo.png', '2025-06-04 10:34:03', '2025-06-07 07:18:32'),
(3, 'cleanesta-description', 'Say goodbye to dirt and grime with our expert cleaning solutions.', '2025-06-04 10:34:03', '2025-06-06 18:55:21'),
(4, 'social-media-links', '{\"facebook\":\"\",\"twitter\":\"\",\"instagram\":\"\"}', '2025-06-04 10:34:03', '2025-06-06 16:54:40'),
(5, 'terms-of-service', 'test test test test', '2025-06-04 10:34:03', '2025-06-06 16:54:40'),
(6, 'privacy-policy', 'test tes test', '2025-06-04 10:34:03', '2025-06-06 16:54:40');

-- --------------------------------------------------------

--
-- Table structure for table `staff_availability`
--

CREATE TABLE `staff_availability` (
  `id` int(11) NOT NULL,
  `day_of_week` enum('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday') NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `is_available` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_by_admin` int(11) DEFAULT NULL,
  `updated_by_admin` int(11) DEFAULT NULL,
  `deleted_by_admin` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff_availability`
--

INSERT INTO `staff_availability` (`id`, `day_of_week`, `start_time`, `end_time`, `is_available`, `created_at`, `updated_at`, `created_by_admin`, `updated_by_admin`, `deleted_by_admin`) VALUES
(1, 'Monday', '09:00:00', '17:00:00', 1, '2025-05-31 10:46:47', '2025-05-31 10:46:47', NULL, NULL, NULL),
(2, 'Tuesday', '09:00:00', '17:00:00', 1, '2025-05-31 10:46:47', '2025-06-04 13:36:35', NULL, 1, NULL),
(3, 'Wednesday', '09:00:00', '17:00:00', 1, '2025-05-31 10:46:47', '2025-05-31 10:46:47', NULL, NULL, NULL),
(4, 'Monday', '10:00:00', '18:00:00', 1, '2025-05-31 10:46:47', '2025-05-31 10:46:47', NULL, NULL, NULL),
(5, 'Tuesday', '10:00:00', '18:00:00', 1, '2025-05-31 10:46:47', '2025-05-31 10:46:47', NULL, NULL, NULL),
(6, 'Wednesday', '10:00:00', '18:00:00', 1, '2025-05-31 10:46:47', '2025-05-31 10:46:47', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `theme_settings`
--

CREATE TABLE `theme_settings` (
  `id` int(11) NOT NULL,
  `setting_key` varchar(50) NOT NULL,
  `setting_value` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `theme_settings`
--

INSERT INTO `theme_settings` (`id`, `setting_key`, `setting_value`, `created_at`, `updated_at`) VALUES
(1, 'color_primary', '#f34d26', '2025-06-06 16:14:18', '2025-06-06 19:07:15'),
(2, 'color_secondary', '#00bda4', '2025-06-06 16:14:18', '2025-06-06 16:38:39'),
(3, 'color_accent', '#7d2ea8', '2025-06-06 16:14:18', '2025-06-06 16:14:18'),
(4, 'color_neutral', '#ffffff', '2025-06-06 16:14:18', '2025-06-06 16:14:18'),
(5, 'color_dark', '#1f1f1f', '2025-06-06 16:14:18', '2025-06-06 16:14:18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `admin_activity_log`
--
ALTER TABLE `admin_activity_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_id` (`service_id`);

--
-- Indexes for table `business_hours`
--
ALTER TABLE `business_hours`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_info`
--
ALTER TABLE `contact_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_id` (`booking_id`),
  ADD KEY `fk_reviews_admin` (`admin_id`),
  ADD KEY `fk_reviews_created_by_admin` (`created_by_admin`),
  ADD KEY `fk_reviews_updated_by_admin` (`updated_by_admin`),
  ADD KEY `fk_reviews_deleted_by_admin` (`deleted_by_admin`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_services_created_by_admin` (`created_by_admin`),
  ADD KEY `fk_services_updated_by_admin` (`updated_by_admin`),
  ADD KEY `fk_services_deleted_by_admin` (`deleted_by_admin`);

--
-- Indexes for table `service_areas`
--
ALTER TABLE `service_areas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_service_areas_created_by_admin` (`created_by_admin`),
  ADD KEY `fk_service_areas_updated_by_admin` (`updated_by_admin`),
  ADD KEY `fk_service_areas_deleted_by_admin` (`deleted_by_admin`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `setting_key` (`setting_key`);

--
-- Indexes for table `staff_availability`
--
ALTER TABLE `staff_availability`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_staff_availability_created_by_admin` (`created_by_admin`),
  ADD KEY `fk_staff_availability_updated_by_admin` (`updated_by_admin`),
  ADD KEY `fk_staff_availability_deleted_by_admin` (`deleted_by_admin`);

--
-- Indexes for table `theme_settings`
--
ALTER TABLE `theme_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `setting_key` (`setting_key`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admin_activity_log`
--
ALTER TABLE `admin_activity_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `business_hours`
--
ALTER TABLE `business_hours`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `contact_info`
--
ALTER TABLE `contact_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `service_areas`
--
ALTER TABLE `service_areas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `staff_availability`
--
ALTER TABLE `staff_availability`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `theme_settings`
--
ALTER TABLE `theme_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin_activity_log`
--
ALTER TABLE `admin_activity_log`
  ADD CONSTRAINT `admin_activity_log_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `fk_reviews_admin` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_reviews_created_by_admin` FOREIGN KEY (`created_by_admin`) REFERENCES `admins` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_reviews_deleted_by_admin` FOREIGN KEY (`deleted_by_admin`) REFERENCES `admins` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_reviews_updated_by_admin` FOREIGN KEY (`updated_by_admin`) REFERENCES `admins` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `fk_services_created_by_admin` FOREIGN KEY (`created_by_admin`) REFERENCES `admins` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_services_deleted_by_admin` FOREIGN KEY (`deleted_by_admin`) REFERENCES `admins` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_services_updated_by_admin` FOREIGN KEY (`updated_by_admin`) REFERENCES `admins` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `service_areas`
--
ALTER TABLE `service_areas`
  ADD CONSTRAINT `fk_service_areas_created_by_admin` FOREIGN KEY (`created_by_admin`) REFERENCES `admins` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_service_areas_deleted_by_admin` FOREIGN KEY (`deleted_by_admin`) REFERENCES `admins` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_service_areas_updated_by_admin` FOREIGN KEY (`updated_by_admin`) REFERENCES `admins` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `staff_availability`
--
ALTER TABLE `staff_availability`
  ADD CONSTRAINT `fk_staff_availability_created_by_admin` FOREIGN KEY (`created_by_admin`) REFERENCES `admins` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_staff_availability_deleted_by_admin` FOREIGN KEY (`deleted_by_admin`) REFERENCES `admins` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_staff_availability_updated_by_admin` FOREIGN KEY (`updated_by_admin`) REFERENCES `admins` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
