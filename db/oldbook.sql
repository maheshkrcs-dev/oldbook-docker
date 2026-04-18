-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 09, 2026 at 06:32 AM
-- Server version: 8.0.45-0ubuntu0.24.04.1
-- PHP Version: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `oldbook`
--

-- --------------------------------------------------------

--
-- Table structure for table `bdata`
--

CREATE TABLE `bdata` (
  `id` int NOT NULL,
  `cat_id` int DEFAULT NULL,
  `B_name` varchar(255) DEFAULT NULL,
  `B_img1` varchar(255) DEFAULT NULL,
  `B_price` decimal(10,2) DEFAULT NULL,
  `B_writer` varchar(255) DEFAULT NULL,
  `B_pub` varchar(255) DEFAULT NULL,
  `B_des` text,
  `date` datetime DEFAULT NULL,
  `keyword` varchar(255) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `dist` varchar(100) DEFAULT NULL,
  `pincode` varchar(20) DEFAULT NULL,
  `seller_number` varchar(15) DEFAULT NULL,
  `show_phone` varchar(10) DEFAULT NULL,
  `user_id` int NOT NULL,
  `status` tinyint DEFAULT '0',
  `condition` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `bdata`
--

INSERT INTO `bdata` (`id`, `cat_id`, `B_name`, `B_img1`, `B_price`, `B_writer`, `B_pub`, `B_des`, `date`, `keyword`, `state`, `dist`, `pincode`, `seller_number`, `show_phone`, `user_id`, `status`, `condition`) VALUES
(1, 3, 'The Art Of Being Alone', '1775614853-automobile2.jpeg', 299.00, 'Renuka Gavrani', 'AMARYLLIS', 'This book is based on awareness of loneliness, aloneness and solitude.', '2026-04-08 07:50:53', 'Loneliness, Solitude, ALone', 'Bihar', 'Sitamarhi', '843327', '8210038549', 'on', 0, 2, NULL),
(8, 2, 'Automobile Engineering Vol. 1', 'cc210f2453601a735731e3535847517a.jpeg', 399.00, 'Dr. Kirpal Singh', '', 'Covers fundamentals of automobile engineering and vehicle systems.', '2026-04-09 00:47:50', 'automobile, mechanical, vehicles', 'Bihar', 'Sitamarhi', '843327', '8210038549', 'on', 1, 1, NULL),
(13, 1, 'Python Programming: Basic to Advanced', '38a5c6246e5210b502d0415ff0d25350.jpeg', 160.00, 'Puja S. Gholap', '', 'Document from the year 2025 in the subject Engineering - Computer Engineering, grade: A, Savitribai Phule Pune University, formerly University of Pune (Savitribai Phule Pune University), course: B.E, language: English, abstract: Welcome to a comprehensive journey through the world of Python programm', '2026-04-09 01:43:43', 'Python Programming: Basic to Advanced', 'Bihar', 'Sitamarhi', '843327', '8210038549', 'on', 1, 1, NULL),
(14, 6, 'The Art Of Being Alone', 'de6b6e06b3d3c468e103b0462b9eaf86.jpeg', 123.00, 'Mark Manson', '', 'gh', '2026-04-09 02:12:21', 'Loneliness, Solitude, ALone', 'Bihar', 'Sitamarhi', '843327', '8210038549', 'on', 1, 2, 'New'),
(15, 7, 'The Art Of Being Alone', 'b6b76e847d3aa20171cb825f19f0970d.jpeg', 200.00, 'Renuka Gavrani', '', 'Self help book', '2026-04-09 02:13:44', 'Loneliness, Solitude, ALone', 'Bihar', 'Sitamarhi', '843327', '8210038549', 'on', 1, 1, 'New');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `category_id` int DEFAULT NULL,
  `name` varchar(150) DEFAULT NULL,
  `author` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text,
  `status` enum('active','sold') DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `book_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `book_id`) VALUES
(2, 2, 6),
(9, 1, 5);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int NOT NULL,
  `name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Programming'),
(2, 'Engineering'),
(3, 'Fiction'),
(6, 'Fiction'),
(7, 'Self Help'),
(8, 'Business'),
(9, 'Mathematics'),
(10, 'Science'),
(11, 'Electronics'),
(12, 'Mechanical'),
(13, 'Civil'),
(14, 'Computer Science'),
(15, 'History'),
(16, 'Non-Fiction'),
(17, 'Fantasy'),
(18, 'Mystery & Crime'),
(19, 'Science Fiction (Sci-Fi)'),
(20, 'Romance'),
(21, 'Horror'),
(22, 'Lifestyles'),
(23, 'Cookbooks'),
(24, 'Health & Fitness');

-- --------------------------------------------------------

--
-- Table structure for table `conversations`
--

CREATE TABLE `conversations` (
  `id` int NOT NULL,
  `book_id` int DEFAULT NULL,
  `sender_id` int DEFAULT NULL,
  `receiver_id` int DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `conversations`
--

INSERT INTO `conversations` (`id`, `book_id`, `sender_id`, `receiver_id`, `created_at`) VALUES
(1, 15, 1, 1, '2026-04-09 02:35:05'),
(2, 15, 2, 1, '2026-04-09 02:46:14'),
(3, 13, 2, 1, '2026-04-09 03:31:18'),
(4, 13, 1, 1, '2026-04-09 03:32:10');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` int NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `is_verified` tinyint DEFAULT '0',
  `otp` varchar(10) DEFAULT NULL,
  `otp_expiry` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `name`, `email`, `password`, `profile_image`, `is_verified`, `otp`, `otp_expiry`) VALUES
(1, 'Pintu', 'maheshkr.cs@gmail.com', '$2y$10$uiocXsznZRlaXcjHIRLZLO.kKFZw0HUK/yZNdMnXNTM62pc6BerI2', 'user_1_1775573850.jpg', 0, '897530', '2026-04-07 15:16:32'),
(2, 'Ganesh', 'gk74140@gmail.com', '$2y$10$Jj9NpF2vyuortm.cK9uUUuOw4ZKkWSQ8xA0.ugU0RfkJl4G6VByhO', NULL, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int NOT NULL,
  `conversation_id` int DEFAULT NULL,
  `sender_id` int DEFAULT NULL,
  `message` text,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `is_read` tinyint DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `conversation_id`, `sender_id`, `message`, `created_at`, `is_read`) VALUES
(1, 1, 1, 'hi', '2026-04-09 02:35:19', 0),
(2, 1, 1, 'hello', '2026-04-09 02:41:28', 0),
(3, 2, 2, 'Price kam hoga kya?', '2026-04-09 02:46:28', 0),
(4, 2, 2, '150 me doge?', '2026-04-09 02:46:38', 0),
(5, 1, 1, 'hello', '2026-04-09 02:47:28', 0),
(6, 3, 2, 'kitne me doge bhai', '2026-04-09 03:31:27', 0),
(7, 2, 2, 'kitne me doge bhai', '2026-04-09 03:37:41', 0);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `book_id` int DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `order_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `book_id` int DEFAULT NULL,
  `rating` int DEFAULT NULL,
  `review` text,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `book_id`, `rating`, `review`, `created_at`) VALUES
(1, 1, 6, 4, '', '2026-04-08 10:55:41'),
(2, 1, 5, 5, 'Awesome Book, Recommended hai.', '2026-04-08 10:56:17'),
(3, 2, 6, 5, '', '2026-04-08 11:00:26');

-- --------------------------------------------------------

--
-- Table structure for table `typing_status`
--

CREATE TABLE `typing_status` (
  `conversation_id` int NOT NULL,
  `user_id` int NOT NULL,
  `is_typing` tinyint DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `typing_status`
--

INSERT INTO `typing_status` (`conversation_id`, `user_id`, `is_typing`) VALUES
(2, 2, 0),
(3, 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `last_seen` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `book_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`id`, `user_id`, `book_id`) VALUES
(10, 1, 6);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bdata`
--
ALTER TABLE `bdata`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `conversations`
--
ALTER TABLE `conversations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `typing_status`
--
ALTER TABLE `typing_status`
  ADD PRIMARY KEY (`conversation_id`,`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bdata`
--
ALTER TABLE `bdata`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `conversations`
--
ALTER TABLE `conversations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
