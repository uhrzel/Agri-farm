-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:8111
-- Generation Time: Sep 16, 2024 at 04:19 PM
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
-- Database: `store`
--

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` int(30) NOT NULL,
  `name` varchar(250) NOT NULL,
  `description` text DEFAULT NULL,
  `image_path` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name`, `description`, `image_path`, `status`, `delete_flag`, `date_created`) VALUES
(23, 'Farm Harvest Vegetables', 'Fresh harvest from the from vegtables', 'uploads/brands/23.jpg?v=1725941647', 1, 0, '2024-05-20 18:59:03'),
(25, 'Farm Harvest Fruits', 'Fresh from the farm fruits', 'uploads/brands/25.jpg?v=1726469390', 1, 0, '2024-09-16 14:49:50');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(30) NOT NULL,
  `client_id` int(30) NOT NULL,
  `inventory_id` int(30) NOT NULL,
  `price` double NOT NULL,
  `quantity` int(30) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(30) NOT NULL,
  `category` varchar(250) NOT NULL,
  `description` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category`, `description`, `status`, `delete_flag`, `date_created`) VALUES
(1, 'Melon Fruits', 'Melons are refreshing, juicy fruits known for their high water content and sweet flavors. Popular varieties include watermelons, cantaloupes, and honeydew. ', 1, 0, '2022-02-17 11:27:11'),
(12, 'Root Vegetables', 'Root vegetables are nutrient-dense plants that grow underground, absorbing essential minerals and vitamins from the soil.', 1, 0, '2024-05-20 18:55:57'),
(15, 'Leafy Vegetables', 'Leafy vegetables are nutrient-rich greens that are essential to a healthy diet. They are packed with vitamins, minerals, and antioxidants, supporting overall wellness. ', 1, 0, '2024-09-16 14:43:37'),
(16, 'Tropical Fruits', 'Tropical fruits are grown in warm, humid climates and are known for their vibrant flavors, juicy textures, and exotic appeal. Common tropical fruits include mangoes, pineapples, bananas, papayas, and coconuts. ', 1, 0, '2024-09-16 14:51:06');

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` int(30) NOT NULL,
  `firstname` varchar(250) NOT NULL,
  `lastname` varchar(250) NOT NULL,
  `gender` varchar(20) NOT NULL,
  `contact` varchar(15) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` text NOT NULL,
  `default_delivery_address` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `firstname`, `lastname`, `gender`, `contact`, `email`, `password`, `default_delivery_address`, `status`, `delete_flag`, `date_created`) VALUES
(2, 'Samantha Jane', 'Miller', 'Female', '09123456789', 'sam23@sample.com', '91ec1f9324753048c0096d036a694f86', 'Sample Address', 1, 0, '2022-02-17 14:24:00'),
(3, 'Arzel John', 'Zolina', 'Male', '09090937257', 'arzeljrz17@gmail.com', '91ec1f9324753048c0096d036a694f86', 'PMCO Village', 1, 0, '2024-05-17 11:22:55'),
(4, 'Reynald', 'Agustin', 'Male', '09090937257', 'ajmixrhyme@gmail.com', '91ec1f9324753048c0096d036a694f86', 'Davao City Diversion Rd', 1, 0, '2024-09-14 15:57:32');

-- --------------------------------------------------------

--
-- Table structure for table `inorganic_fertilizers`
--

CREATE TABLE `inorganic_fertilizers` (
  `id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `brand` varchar(255) NOT NULL,
  `supplier` varchar(255) NOT NULL,
  `crops_applied` varchar(255) NOT NULL,
  `frequency` varchar(255) NOT NULL,
  `expiry_date` date NOT NULL,
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inorganic_fertilizers`
--

INSERT INTO `inorganic_fertilizers` (`id`, `type`, `brand`, `supplier`, `crops_applied`, `frequency`, `expiry_date`, `delete_flag`) VALUES
(1, 'Single Fertilizers-Duofos', 'Sagrez', 'D\'Farmers', 'All Crops', 'First Dose up to fruiting stage', '2024-09-21', 0),
(2, 'Completed Fertilizers-Unik 16', 'Yara', 'D\'Farmers', 'All Crops', 'First Dose up to fruiting', '2024-09-19', 0);

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` int(30) NOT NULL,
  `user_id` int(11) UNSIGNED DEFAULT NULL,
  `variant` text NOT NULL,
  `product_id` int(30) NOT NULL,
  `quantity` double NOT NULL,
  `price` float NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `user_id`, `variant`, `product_id`, `quantity`, `price`, `date_created`, `date_updated`) VALUES
(13, 2, 'sa', 21, 21, 21, '2024-09-16 22:05:45', '2024-09-16 22:05:57');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(30) NOT NULL,
  `ref_code` varchar(100) NOT NULL,
  `client_id` int(30) NOT NULL,
  `delivery_address` text NOT NULL,
  `payment_method` varchar(100) NOT NULL,
  `order_type` tinyint(1) NOT NULL COMMENT '1= pickup,2= deliver',
  `amount` double NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT 0 COMMENT '0 = pending,\r\n1= Packed,\r\n2 = Out for Delivery,\r\n3=Delivered,\r\n4=cancelled',
  `paid` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_list`
--

CREATE TABLE `order_list` (
  `id` int(30) NOT NULL,
  `order_id` int(30) NOT NULL,
  `inventory_id` int(30) NOT NULL,
  `quantity` int(30) NOT NULL,
  `price` double NOT NULL,
  `total` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `organic_fertilizers`
--

CREATE TABLE `organic_fertilizers` (
  `id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `brand` varchar(255) NOT NULL,
  `supplier` varchar(255) NOT NULL,
  `crops_applied` varchar(255) NOT NULL,
  `frequency` varchar(255) NOT NULL,
  `expiry_date` date NOT NULL,
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `organic_fertilizers`
--

INSERT INTO `organic_fertilizers` (`id`, `type`, `brand`, `supplier`, `crops_applied`, `frequency`, `expiry_date`, `delete_flag`) VALUES
(1, 'Bio-organic ', 'Kael', 'LGU Baybay', 'All Crops', 'for soil media (Seed germination)', '2024-09-18', 0),
(2, 'Vermicast', '-', 'Own produced', 'All Crops', 'for soil media (Seed germination)', '2024-10-05', 0);

-- --------------------------------------------------------

--
-- Table structure for table `pesticides`
--

CREATE TABLE `pesticides` (
  `id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `active_ingredient` varchar(255) NOT NULL,
  `brand_name` varchar(255) NOT NULL,
  `supplier` varchar(255) NOT NULL,
  `crops_applied` varchar(255) NOT NULL,
  `target_pest` varchar(255) NOT NULL,
  `frequency` varchar(255) NOT NULL,
  `expiry_date` date NOT NULL,
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pesticides`
--

INSERT INTO `pesticides` (`id`, `type`, `active_ingredient`, `brand_name`, `supplier`, `crops_applied`, `target_pest`, `frequency`, `expiry_date`, `delete_flag`) VALUES
(1, 'Fungicide-Ortiva top', 'Azoxystrobin/Difenoconazde', 'Syngenta', 'D\'Farmers', 'Corn, Tomato', 'Leaf blight, Late blight', 'As the need arises', '2023-09-14', 0),
(2, 'test data', 'test ingredient', 'test brand', 'tes supplier', 'test crops applied', 'test target pest', 'test frequency ', '2024-10-05', 0);

-- --------------------------------------------------------

--
-- Table structure for table `production_harvesting`
--

CREATE TABLE `production_harvesting` (
  `id` int(11) NOT NULL,
  `crops` varchar(255) NOT NULL,
  `crop_cycle` varchar(255) NOT NULL,
  `date_planted` date NOT NULL,
  `date_harvest` date NOT NULL,
  `hectarage` varchar(255) NOT NULL,
  `harvest_kg` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `production_harvesting`
--

INSERT INTO `production_harvesting` (`id`, `crops`, `crop_cycle`, `date_planted`, `date_harvest`, `hectarage`, `harvest_kg`, `location`, `delete_flag`) VALUES
(1, 'Sweet Pepper(Emperor F1)', '4 Months', '2021-07-21', '2021-12-18', '2,100 sqm', '3,500 kg', 'Tunnel 6 - 10', 0),
(2, 'Ampalaya(Galaxy F1)', '3 Months', '2021-08-02', '2021-11-13', '420 sqm', '900 kg', 'Tunnel 3', 0),
(3, 'Hot Pepper(Vulcan F1)', '4 Months', '2024-10-03', '2024-09-26', '420 sqm', '21', 'Tunnel 3', 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(30) NOT NULL,
  `brand_id` int(30) NOT NULL,
  `category_id` int(30) NOT NULL,
  `name` varchar(250) NOT NULL,
  `specs` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `user_id` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `brand_id`, `category_id`, `name`, `specs`, `status`, `delete_flag`, `date_created`, `user_id`) VALUES
(20, 23, 12, 'Potatoes', '&lt;ul&gt;&lt;li&gt;&lt;li&gt;&lt;strong&gt;Sizes&lt;/strong&gt;: Small (2-3&quot;), Medium (3-4&quot;), Large (4-5&quot;)&lt;/li&gt;&lt;li&gt;&lt;strong&gt;Color&lt;/strong&gt;: Skin: Brown, Red, Yellow, Purple | Flesh: White, Yellow, Orange&lt;/li&gt;&lt;li&gt;&lt;strong&gt;Texture&lt;/strong&gt;: Starchy (fluffy) or Waxy (firm)&lt;/li&gt;&lt;li&gt;&lt;strong&gt;Nutritional Info (per 100g)&lt;/strong&gt;:&lt;ul&gt;&lt;li&gt;Calories: 77 kcal&lt;/li&gt;&lt;li&gt;Carbs: 17g&lt;/li&gt;&lt;li&gt;Protein: 2g&lt;/li&gt;&lt;li&gt;Vitamin C: 19.7mg&lt;/li&gt;&lt;li&gt;Potassium: 425mg&lt;/li&gt;&lt;/ul&gt;&lt;/li&gt;&lt;li&gt;&lt;strong&gt;Shelf Life&lt;/strong&gt;: 1-2 months in a cool, dark place.&lt;/li&gt;&lt;/li&gt;&lt;/ul&gt;', 1, 0, '2024-09-16 14:41:50', 2),
(21, 23, 15, 'Celery', '&lt;div&gt;&lt;br&gt;&lt;/div&gt;&lt;ul&gt;&lt;li&gt;**Celery Specs:**&lt;/li&gt;&lt;li&gt; **Type**: Leafy, stalk vegetable&lt;/li&gt;&lt;li&gt;**Color**: Light green stems with darker green leaves&lt;/li&gt;&lt;li&gt;&amp;nbsp;**Texture**: Crisp and crunchy&lt;/li&gt;&lt;li&gt;&amp;nbsp;**Flavor**: Mild, slightly peppery with a refreshing taste&lt;/li&gt;&lt;li&gt;&amp;nbsp;**Nutritional Info (per 100g)**:&amp;nbsp;&amp;nbsp;&lt;/li&gt;&lt;li&gt;&amp;nbsp;**Common Uses**: Raw in salads, snacks, soups, stews, and stir-fries&lt;/li&gt;&lt;li&gt;**Storage**: Refrigerate in a sealed container, lasts up to 1-2 weeks&lt;/li&gt;&lt;li&gt;&amp;nbsp;**Health Benefits**: High in fiber, supports digestion, low-calorie, good for hydration due to high water content.&lt;/li&gt;&lt;li&gt;Calories: 16 kcal&amp;nbsp; &amp;nbsp; - Carbs: 3g&amp;nbsp;&amp;nbsp;&lt;/li&gt;&lt;li&gt;&amp;nbsp; - Protein: 0.7g&amp;nbsp;&amp;nbsp;&lt;/li&gt;&lt;li&gt;&amp;nbsp; - Fiber: 1.6g&amp;nbsp;&amp;nbsp;&lt;/li&gt;&lt;li&gt;&amp;nbsp; - Vitamin C: 3.1mg&amp;nbsp;&amp;nbsp;&lt;/li&gt;&lt;li&gt;&amp;nbsp; - Potassium: 260mg&lt;/li&gt;&lt;/ul&gt;', 1, 0, '2024-09-16 14:47:10', 2),
(22, 25, 1, 'Watermelon', '&lt;li&gt;&lt;strong&gt;Type&lt;/strong&gt;: Watermelon&lt;/li&gt;&lt;li&gt;&lt;strong&gt;Color&lt;/strong&gt;: Green rind with a pink to red interior, sometimes yellow or orange&lt;/li&gt;&lt;li&gt;&lt;strong&gt;Texture&lt;/strong&gt;: Crisp and juicy&lt;/li&gt;&lt;li&gt;&lt;strong&gt;Flavor&lt;/strong&gt;: Sweet and refreshing&lt;/li&gt;&lt;li&gt;&lt;strong&gt;Nutritional Info (per 100g)&lt;/strong&gt;:&lt;ul&gt;&lt;li&gt;Calories: 30 kcal&lt;/li&gt;&lt;li&gt;Carbs: 8g&lt;/li&gt;&lt;li&gt;Protein: 0.6g&lt;/li&gt;&lt;li&gt;Fiber: 0.4g&lt;/li&gt;&lt;li&gt;Vitamin C: 8.1mg&lt;/li&gt;&lt;li&gt;Potassium: 112mg&lt;/li&gt;&lt;/ul&gt;&lt;/li&gt;&lt;li&gt;&lt;strong&gt;Common Uses&lt;/strong&gt;: Fresh slices, fruit salads, smoothies, juices, and sorbets&lt;/li&gt;&lt;li&gt;&lt;strong&gt;Storage&lt;/strong&gt;: Refrigerate cut watermelon, lasts up to 1 week; whole watermelon can be stored at room temperature or in the fridge for longer freshness&lt;/li&gt;&lt;li&gt;&lt;strong&gt;Health Benefits&lt;/strong&gt;: Hydrating due to high water content (about 92%), contains antioxidants like lycopene, supports heart health, and provides vitamins and minerals.&lt;/li&gt;', 1, 0, '2024-09-16 14:53:52', 2),
(23, 25, 16, 'Pineapple', '&lt;p&gt;&lt;strong&gt;Pineapple Specs:&lt;/strong&gt;&lt;/p&gt;&lt;ul&gt;&lt;li&gt;&lt;strong&gt;Type&lt;/strong&gt;: Tropical Fruit&lt;/li&gt;&lt;li&gt;&lt;strong&gt;Color&lt;/strong&gt;: Brownish-green rind with yellow flesh&lt;/li&gt;&lt;li&gt;&lt;strong&gt;Texture&lt;/strong&gt;: Juicy and fibrous&lt;/li&gt;&lt;li&gt;&lt;strong&gt;Flavor&lt;/strong&gt;: Sweet and tangy&lt;/li&gt;&lt;li&gt;&lt;strong&gt;Nutritional Info (per 100g)&lt;/strong&gt;:&lt;ul&gt;&lt;li&gt;Calories: 50 kcal&lt;/li&gt;&lt;li&gt;Carbs: 13g&lt;/li&gt;&lt;li&gt;Protein: 0.5g&lt;/li&gt;&lt;li&gt;Fiber: 1.4g&lt;/li&gt;&lt;li&gt;Vitamin C: 47.8mg&lt;/li&gt;&lt;li&gt;Potassium: 109mg&lt;/li&gt;&lt;/ul&gt;&lt;/li&gt;&lt;li&gt;&lt;strong&gt;Common Uses&lt;/strong&gt;: Fresh slices, fruit salads, smoothies, juices, cooking, and grilling&lt;/li&gt;&lt;li&gt;&lt;strong&gt;Storage&lt;/strong&gt;: Refrigerate cut pineapple, lasts up to 5-7 days; whole pineapple can be stored at room temperature until ripe, then refrigerate for longer freshness&lt;/li&gt;&lt;li&gt;&lt;strong&gt;Health Benefits&lt;/strong&gt;: Rich in vitamin C and bromelain, which aids digestion and has anti-inflammatory properties, supports immune function, and provides hydration.&lt;/li&gt;&lt;/ul&gt;', 1, 0, '2024-09-16 14:55:08', 2),
(30, 25, 1, 'sa', '&lt;p&gt;sa&lt;/p&gt;', 1, 1, '2024-09-16 20:37:09', 2),
(31, 23, 1, 'wow', '&lt;p&gt;sa&lt;/p&gt;', 1, 0, '2024-09-16 20:38:06', 3),
(32, 25, 12, '21', '&lt;p&gt;sa&lt;/p&gt;', 1, 0, '2024-09-16 21:55:55', 3),
(33, 23, 1, 'Social Worker', '&lt;p&gt;sayooote&lt;/p&gt;', 1, 1, '2024-09-16 21:56:29', 2);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(30) NOT NULL,
  `order_id` int(30) NOT NULL,
  `total_amount` double NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sanitizers`
--

CREATE TABLE `sanitizers` (
  `id` int(11) NOT NULL,
  `sanitizer_name` varchar(255) NOT NULL,
  `active_ingredient` varchar(255) NOT NULL,
  `brand_name` varchar(255) NOT NULL,
  `intended_use` varchar(255) NOT NULL,
  `frequency` varchar(255) NOT NULL,
  `expiry_date` date NOT NULL,
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sanitizers`
--

INSERT INTO `sanitizers` (`id`, `sanitizer_name`, `active_ingredient`, `brand_name`, `intended_use`, `frequency`, `expiry_date`, `delete_flag`) VALUES
(4, 'Power Detergent', '-', 'Ariel', 'Cleaning', 'As the need arises', '2024-09-24', 0),
(5, 'Bleach', 'Chloring', 'Zonrox', 'Disinfectant', 'As the need arises', '2024-09-19', 0);

-- --------------------------------------------------------

--
-- Table structure for table `system_info`
--

CREATE TABLE `system_info` (
  `id` int(30) NOT NULL,
  `meta_field` text NOT NULL,
  `meta_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system_info`
--

INSERT INTO `system_info` (`id`, `meta_field`, `meta_value`) VALUES
(1, 'name', 'Agri Farm'),
(6, 'short_name', 'Agri Farm'),
(11, 'logo', 'uploads/logo-1725941904.jpeg'),
(13, 'user_avatar', 'uploads/user_avatar.jpg'),
(14, 'cover', 'uploads/cover-1725941904.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(50) NOT NULL,
  `firstname` varchar(250) NOT NULL,
  `lastname` varchar(250) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `avatar` text DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 0,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `username`, `password`, `avatar`, `last_login`, `type`, `date_added`, `date_updated`) VALUES
(1, 'Admin', 'Admin1', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'uploads/avatars/1.png?v=1645064505', NULL, 1, '2021-01-20 14:02:37', '2024-09-16 16:12:48'),
(2, 'Farmer', 'farmer', 'farmer', '97f974881b3726d9a77014b5f3b4d795', 'uploads/avatars/2.png?v=1726475276', NULL, 2, '2021-01-20 14:02:37', '2024-09-16 17:29:39'),
(3, 'arzel', 'zolina', 'farmer 2', '202cb962ac59075b964b07152d234b70', 'uploads/avatars/3.png?v=1726475208', NULL, 2, '2024-09-16 16:26:29', '2024-09-16 16:27:35');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inventory_id` (`inventory_id`),
  ADD KEY `client_id` (`client_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inorganic_fertilizers`
--
ALTER TABLE `inorganic_fertilizers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`);

--
-- Indexes for table `order_list`
--
ALTER TABLE `order_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inventory_id` (`inventory_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `organic_fertilizers`
--
ALTER TABLE `organic_fertilizers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pesticides`
--
ALTER TABLE `pesticides`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `production_harvesting`
--
ALTER TABLE `production_harvesting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `brand_id` (`brand_id`,`category_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `sanitizers`
--
ALTER TABLE `sanitizers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_info`
--
ALTER TABLE `system_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `inorganic_fertilizers`
--
ALTER TABLE `inorganic_fertilizers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `order_list`
--
ALTER TABLE `order_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `organic_fertilizers`
--
ALTER TABLE `organic_fertilizers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pesticides`
--
ALTER TABLE `pesticides`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `production_harvesting`
--
ALTER TABLE `production_harvesting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `sanitizers`
--
ALTER TABLE `sanitizers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `system_info`
--
ALTER TABLE `system_info`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`inventory_id`) REFERENCES `inventory` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `inventory_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_list`
--
ALTER TABLE `order_list`
  ADD CONSTRAINT `order_list_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_list_ibfk_2` FOREIGN KEY (`inventory_id`) REFERENCES `inventory` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
