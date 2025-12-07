-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 07, 2025 at 06:15 AM
-- Server version: 8.4.7
-- PHP Version: 8.4.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `impactguru_crm`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
CREATE TABLE IF NOT EXISTS `customers` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `profile_image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `customers_email_unique` (`email`),
  KEY `customers_created_by_foreign` (`created_by`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `email`, `phone`, `address`, `created_by`, `profile_image`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'test', 'test11@impactguru.com', '9878475865', 'Pune, Maharashtra India', NULL, 'customers/ILqHcDzEH0W4re6enwT8lhVejhYdIxujQIPUZDYr.jpg', '2025-12-06 07:47:07', '2025-12-06 09:11:10', '2025-12-06 09:11:10'),
(2, 'jfj', 'nfjndsj@gmail.com', '8754854745', 'mmfsmdfmdfmsd', 5, NULL, '2025-12-06 10:11:55', '2025-12-06 10:11:55', NULL),
(3, 'harsh', 'harsh@gmail.com', '9874785745', 'Five gardern plaza, near jagtap dairy pune', 4, 'profile_images/z28BQH5CaIMY9w73X9RnHoeB1bOoRKa1xi0aG4SP.jpg', '2025-12-06 23:19:59', '2025-12-06 23:19:59', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `failed_jobs`
--

INSERT INTO `failed_jobs` (`id`, `uuid`, `connection`, `queue`, `payload`, `exception`, `failed_at`) VALUES
(4, 'cb1a36be-c49f-47a5-8b7d-7bf97bebc10f', 'database', 'default', '{\"uuid\":\"cb1a36be-c49f-47a5-8b7d-7bf97bebc10f\",\"displayName\":\"App\\\\Notifications\\\\NewOrderNotification\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":3,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":10,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\",\"command\":\"O:48:\\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\\":5:{s:11:\\\"notifiables\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:15:\\\"App\\\\Models\\\\User\\\";s:2:\\\"id\\\";a:1:{i:0;i:7;}s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:12:\\\"notification\\\";O:38:\\\"App\\\\Notifications\\\\NewOrderNotification\\\":3:{s:5:\\\"order\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":5:{s:5:\\\"class\\\";s:16:\\\"App\\\\Models\\\\Order\\\";s:2:\\\"id\\\";i:13;s:9:\\\"relations\\\";a:0:{}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";s:15:\\\"collectionClass\\\";N;}s:9:\\\"sendEmail\\\";b:1;s:2:\\\"id\\\";s:36:\\\"94b01d1c-ee9c-473d-afbc-cbd4a58f545b\\\";}s:8:\\\"channels\\\";a:1:{i:0;s:4:\\\"mail\\\";}s:5:\\\"tries\\\";i:3;s:7:\\\"timeout\\\";i:10;}\"},\"createdAt\":1765085365,\"delay\":null}', 'Symfony\\Component\\Mailer\\Exception\\TransportException: Failed to authenticate on SMTP server with username \"sandipdeore1664@gmail.com\" using the following authenticators: \"LOGIN\", \"PLAIN\", \"XOAUTH2\". Authenticator \"LOGIN\" returned \"Expected response code \"235\" but got code \"535\", with message \"535-5.7.8 Username and Password not accepted. For more information, go to\r\n535 5.7.8  https://support.google.com/mail/?p=BadCredentials d9443c01a7336-29daeaabf8asm87932665ad.85 - gsmtp\".\". Authenticator \"PLAIN\" returned \"Expected response code \"235\" but got code \"535\", with message \"535-5.7.8 Username and Password not accepted. For more information, go to\r\n535 5.7.8  https://support.google.com/mail/?p=BadCredentials d9443c01a7336-29daeaabf8asm87932665ad.85 - gsmtp\".\". Authenticator \"XOAUTH2\" returned \"Expected response code \"235\" but got code \"334\", with message \"334 eyJzdGF0dXMiOiI0MDAiLCJzY2hlbWVzIjoiQmVhcmVyIiwic2NvcGUiOiJodHRwczovL21haWwuZ29vZ2xlLmNvbS8ifQ==\".\". in C:\\wamp64\\www\\impactguru-crm\\vendor\\symfony\\mailer\\Transport\\Smtp\\EsmtpTransport.php:269\nStack trace:\n#0 C:\\wamp64\\www\\impactguru-crm\\vendor\\symfony\\mailer\\Transport\\Smtp\\EsmtpTransport.php(199): Symfony\\Component\\Mailer\\Transport\\Smtp\\EsmtpTransport->handleAuth()\n#1 C:\\wamp64\\www\\impactguru-crm\\vendor\\symfony\\mailer\\Transport\\Smtp\\EsmtpTransport.php(150): Symfony\\Component\\Mailer\\Transport\\Smtp\\EsmtpTransport->doEhloCommand()\n#2 C:\\wamp64\\www\\impactguru-crm\\vendor\\symfony\\mailer\\Transport\\Smtp\\SmtpTransport.php(244): Symfony\\Component\\Mailer\\Transport\\Smtp\\EsmtpTransport->executeCommand()\n#3 C:\\wamp64\\www\\impactguru-crm\\vendor\\symfony\\mailer\\Transport\\Smtp\\SmtpTransport.php(270): Symfony\\Component\\Mailer\\Transport\\Smtp\\SmtpTransport->doHeloCommand()\n#4 C:\\wamp64\\www\\impactguru-crm\\vendor\\symfony\\mailer\\Transport\\Smtp\\SmtpTransport.php(200): Symfony\\Component\\Mailer\\Transport\\Smtp\\SmtpTransport->start()\n#5 C:\\wamp64\\www\\impactguru-crm\\vendor\\symfony\\mailer\\Transport\\AbstractTransport.php(69): Symfony\\Component\\Mailer\\Transport\\Smtp\\SmtpTransport->doSend()\n#6 C:\\wamp64\\www\\impactguru-crm\\vendor\\symfony\\mailer\\Transport\\Smtp\\SmtpTransport.php(138): Symfony\\Component\\Mailer\\Transport\\AbstractTransport->send()\n#7 C:\\wamp64\\www\\impactguru-crm\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(584): Symfony\\Component\\Mailer\\Transport\\Smtp\\SmtpTransport->send()\n#8 C:\\wamp64\\www\\impactguru-crm\\vendor\\laravel\\framework\\src\\Illuminate\\Mail\\Mailer.php(331): Illuminate\\Mail\\Mailer->sendSymfonyMessage()\n#9 C:\\wamp64\\www\\impactguru-crm\\vendor\\laravel\\framework\\src\\Illuminate\\Notifications\\Channels\\MailChannel.php(66): Illuminate\\Mail\\Mailer->send()\n#10 C:\\wamp64\\www\\impactguru-crm\\vendor\\laravel\\framework\\src\\Illuminate\\Notifications\\NotificationSender.php(163): Illuminate\\Notifications\\Channels\\MailChannel->send()\n#11 C:\\wamp64\\www\\impactguru-crm\\vendor\\laravel\\framework\\src\\Illuminate\\Notifications\\NotificationSender.php(118): Illuminate\\Notifications\\NotificationSender->sendToNotifiable()\n#12 C:\\wamp64\\www\\impactguru-crm\\vendor\\laravel\\framework\\src\\Illuminate\\Support\\Traits\\Localizable.php(19): Illuminate\\Notifications\\NotificationSender->{closure:Illuminate\\Notifications\\NotificationSender::sendNow():113}()\n#13 C:\\wamp64\\www\\impactguru-crm\\vendor\\laravel\\framework\\src\\Illuminate\\Notifications\\NotificationSender.php(113): Illuminate\\Notifications\\NotificationSender->withLocale()\n#14 C:\\wamp64\\www\\impactguru-crm\\vendor\\laravel\\framework\\src\\Illuminate\\Notifications\\ChannelManager.php(54): Illuminate\\Notifications\\NotificationSender->sendNow()\n#15 C:\\wamp64\\www\\impactguru-crm\\vendor\\laravel\\framework\\src\\Illuminate\\Notifications\\SendQueuedNotifications.php(118): Illuminate\\Notifications\\ChannelManager->sendNow()\n#16 C:\\wamp64\\www\\impactguru-crm\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Notifications\\SendQueuedNotifications->handle()\n#17 C:\\wamp64\\www\\impactguru-crm\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::{closure:Illuminate\\Container\\BoundMethod::call():35}()\n#18 C:\\wamp64\\www\\impactguru-crm\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure()\n#19 C:\\wamp64\\www\\impactguru-crm\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod()\n#20 C:\\wamp64\\www\\impactguru-crm\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(807): Illuminate\\Container\\BoundMethod::call()\n#21 C:\\wamp64\\www\\impactguru-crm\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(129): Illuminate\\Container\\Container->call()\n#22 C:\\wamp64\\www\\impactguru-crm\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(180): Illuminate\\Bus\\Dispatcher->{closure:Illuminate\\Bus\\Dispatcher::dispatchNow():126}()\n#23 C:\\wamp64\\www\\impactguru-crm\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(137): Illuminate\\Pipeline\\Pipeline->{closure:Illuminate\\Pipeline\\Pipeline::prepareDestination():178}()\n#24 C:\\wamp64\\www\\impactguru-crm\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(133): Illuminate\\Pipeline\\Pipeline->then()\n#25 C:\\wamp64\\www\\impactguru-crm\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(134): Illuminate\\Bus\\Dispatcher->dispatchNow()\n#26 C:\\wamp64\\www\\impactguru-crm\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(180): Illuminate\\Queue\\CallQueuedHandler->{closure:Illuminate\\Queue\\CallQueuedHandler::dispatchThroughMiddleware():127}()\n#27 C:\\wamp64\\www\\impactguru-crm\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(137): Illuminate\\Pipeline\\Pipeline->{closure:Illuminate\\Pipeline\\Pipeline::prepareDestination():178}()\n#28 C:\\wamp64\\www\\impactguru-crm\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(127): Illuminate\\Pipeline\\Pipeline->then()\n#29 C:\\wamp64\\www\\impactguru-crm\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(68): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware()\n#30 C:\\wamp64\\www\\impactguru-crm\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(102): Illuminate\\Queue\\CallQueuedHandler->call()\n#31 C:\\wamp64\\www\\impactguru-crm\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(487): Illuminate\\Queue\\Jobs\\Job->fire()\n#32 C:\\wamp64\\www\\impactguru-crm\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(437): Illuminate\\Queue\\Worker->process()\n#33 C:\\wamp64\\www\\impactguru-crm\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(201): Illuminate\\Queue\\Worker->runJob()\n#34 C:\\wamp64\\www\\impactguru-crm\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(148): Illuminate\\Queue\\Worker->daemon()\n#35 C:\\wamp64\\www\\impactguru-crm\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(131): Illuminate\\Queue\\Console\\WorkCommand->runWorker()\n#36 C:\\wamp64\\www\\impactguru-crm\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#37 C:\\wamp64\\www\\impactguru-crm\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::{closure:Illuminate\\Container\\BoundMethod::call():35}()\n#38 C:\\wamp64\\www\\impactguru-crm\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure()\n#39 C:\\wamp64\\www\\impactguru-crm\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod()\n#40 C:\\wamp64\\www\\impactguru-crm\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(807): Illuminate\\Container\\BoundMethod::call()\n#41 C:\\wamp64\\www\\impactguru-crm\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(211): Illuminate\\Container\\Container->call()\n#42 C:\\wamp64\\www\\impactguru-crm\\vendor\\symfony\\console\\Command\\Command.php(335): Illuminate\\Console\\Command->execute()\n#43 C:\\wamp64\\www\\impactguru-crm\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(180): Symfony\\Component\\Console\\Command\\Command->run()\n#44 C:\\wamp64\\www\\impactguru-crm\\vendor\\symfony\\console\\Application.php(1103): Illuminate\\Console\\Command->run()\n#45 C:\\wamp64\\www\\impactguru-crm\\vendor\\symfony\\console\\Application.php(356): Symfony\\Component\\Console\\Application->doRunCommand()\n#46 C:\\wamp64\\www\\impactguru-crm\\vendor\\symfony\\console\\Application.php(195): Symfony\\Component\\Console\\Application->doRun()\n#47 C:\\wamp64\\www\\impactguru-crm\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(197): Symfony\\Component\\Console\\Application->run()\n#48 C:\\wamp64\\www\\impactguru-crm\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Application.php(1235): Illuminate\\Foundation\\Console\\Kernel->handle()\n#49 C:\\wamp64\\www\\impactguru-crm\\artisan(16): Illuminate\\Foundation\\Application->handleCommand()\n#50 {main}', '2025-12-06 23:59:44');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_12_06_105319_add_role_to_users_table', 2),
(5, '2025_12_06_130433_create_customers_table', 3),
(6, '2025_12_06_132213_create_orders_table', 4),
(7, '2025_12_06_153511_add_created_by_to_customers_table', 5),
(8, '2025_12_07_024759_create_personal_access_tokens_table', 6),
(9, '2025_12_07_044623_create_notifications_table', 7);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint UNSIGNED NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('c897cbd6-2430-4b00-b948-578a0a38a595', 'App\\Notifications\\NewOrderNotification', 'App\\Models\\User', 4, '{\"order_id\":4,\"order_number\":\"ORD-202512070002\",\"customer_name\":\"harsh\",\"amount\":\"200.00\",\"status\":\"processing\",\"message\":\"New order #ORD-202512070002 has been created.\",\"url\":\"\\/orders\\/4\",\"type\":\"new_order\"}', NULL, '2025-12-06 23:20:42', '2025-12-06 23:20:42'),
('e85e9934-a31e-4cb5-b109-a9f0c13ebbcc', 'App\\Notifications\\NewOrderNotification', 'App\\Models\\User', 4, '{\"order_id\":5,\"order_number\":\"ORD-202512070003\",\"customer_name\":\"harsh\",\"amount\":\"5474.00\",\"status\":\"pending\",\"message\":\"New order #ORD-202512070003 has been created.\",\"url\":\"\\/orders\\/5\",\"type\":\"new_order\"}', NULL, '2025-12-06 23:23:02', '2025-12-06 23:23:02'),
('306421bd-4927-4c40-86b4-2297af4cd208', 'App\\Notifications\\NewOrderNotification', 'App\\Models\\User', 4, '{\"order_id\":11,\"order_number\":\"ORD-202512070009\",\"customer_name\":\"harsh\",\"customer_id\":\"3\",\"amount\":\"22.00\",\"status\":\"completed\",\"order_date\":\"2025-12-04\",\"message\":\"New order #ORD-202512070009 has been created.\",\"url\":\"\\/orders\\/11\",\"type\":\"new_order\",\"icon\":\"fas fa-shopping-cart\",\"color\":\"bg-blue-500\",\"created_at\":\"2025-12-07 05:05:50\"}', NULL, '2025-12-06 23:35:50', '2025-12-06 23:35:50'),
('df758ce1-c8af-41d3-9967-25098802910b', 'App\\Notifications\\NewOrderNotification', 'App\\Models\\User', 7, '{\"order_id\":3,\"order_number\":\"ORD-202512070001\",\"customer_name\":\"jfj\",\"customer_id\":2,\"amount\":\"4584.00\",\"status\":\"pending\",\"order_date\":\"2025-12-07\",\"message\":\"New order #ORD-202512070001 has been created.\",\"url\":\"\\/orders\\/3\",\"type\":\"new_order\",\"icon\":\"fas fa-shopping-cart\",\"color\":\"bg-blue-500\",\"created_at\":\"2025-12-07 05:21:15\"}', NULL, '2025-12-06 23:51:15', '2025-12-06 23:51:15'),
('09238e04-647e-4ac1-82eb-2e1c3cc577d1', 'SimpleTestNotification', 'App\\Models\\User', 7, '{\"message\":\"Simple test notification\"}', NULL, '2025-12-06 23:52:10', '2025-12-06 23:52:10'),
('3392124a-561f-496c-b329-ab1f5f2202f1', 'Illuminate\\Notifications\\Notification@anonymous\0C:\\wamp64\\www\\impactguru-crm\\vendor\\psy\\psysh\\src\\ExecutionLoopClosure.php(55) : eval()\'d code:1$17f', 'App\\Models\\User', 7, '{\"order_number\":\"ORD-202512070001\",\"message\":\"Temp test notification\",\"type\":\"test\"}', NULL, '2025-12-06 23:52:10', '2025-12-06 23:52:10'),
('31cb1927-c6f6-4249-8ca0-e860fd7af06d', 'App\\Notifications\\NewOrderNotification', 'App\\Models\\User', 7, '{\"order_id\":3,\"order_number\":\"ORD-202512070001\",\"customer_name\":\"jfj\",\"customer_id\":2,\"amount\":\"4584.00\",\"status\":\"pending\",\"order_date\":\"2025-12-07\",\"message\":\"New order #ORD-202512070001 has been created.\",\"url\":\"\\/orders\\/3\",\"type\":\"new_order\",\"icon\":\"fas fa-shopping-cart\",\"color\":\"bg-blue-500\",\"created_at\":\"2025-12-07 05:23:41\"}', NULL, '2025-12-06 23:53:41', '2025-12-06 23:53:41'),
('dc7bca1e-6385-4b2f-bc13-b0ebd88c687c', 'App\\Notifications\\NewOrderNotification', 'App\\Models\\User', 7, '{\"order_id\":3,\"order_number\":\"ORD-202512070001\",\"customer_name\":\"jfj\",\"customer_id\":2,\"amount\":\"4584.00\",\"status\":\"pending\",\"order_date\":\"2025-12-07\",\"message\":\"New order #ORD-202512070001 has been created.\",\"url\":\"\\/orders\\/3\",\"type\":\"new_order\",\"icon\":\"fas fa-shopping-cart\",\"color\":\"bg-blue-500\",\"created_at\":\"2025-12-07 05:23:41\"}', NULL, '2025-12-06 23:53:41', '2025-12-06 23:53:41'),
('aa162576-4d68-4973-81a2-8f68aa86679d', 'App\\Notifications\\NewOrderNotification', 'App\\Models\\User', 7, '{\"order_id\":3,\"order_number\":\"ORD-202512070001\",\"customer_name\":\"jfj\",\"customer_id\":2,\"amount\":\"4584.00\",\"status\":\"pending\",\"order_date\":\"2025-12-07\",\"message\":\"New order #ORD-202512070001 has been created.\",\"url\":\"\\/orders\\/3\",\"type\":\"new_order\",\"icon\":\"fas fa-shopping-cart\",\"color\":\"bg-blue-500\",\"created_at\":\"2025-12-07 05:23:45\"}', NULL, '2025-12-06 23:53:45', '2025-12-06 23:53:45'),
('1e8d0161-3f21-47de-a593-474dde44d5f8', 'App\\Notifications\\NewOrderNotification', 'App\\Models\\User', 4, '{\"order_id\":12,\"order_number\":\"ORD-202512070010\",\"customer_name\":\"harsh\",\"customer_id\":3,\"amount\":\"55.00\",\"status\":\"cancelled\",\"order_date\":\"2025-12-07\",\"message\":\"New order #ORD-202512070010 has been created.\",\"url\":\"\\/orders\\/12\",\"type\":\"new_order\",\"icon\":\"fas fa-shopping-cart\",\"color\":\"bg-blue-500\",\"created_at\":\"2025-12-07 05:27:20\"}', NULL, '2025-12-06 23:57:20', '2025-12-06 23:57:20'),
('0130805d-bd43-4e75-bf92-3fb5f04cdc70', 'App\\Notifications\\NewOrderNotification', 'App\\Models\\User', 7, '{\"order_id\":12,\"order_number\":\"ORD-202512070010\",\"customer_name\":\"harsh\",\"customer_id\":3,\"amount\":\"55.00\",\"status\":\"cancelled\",\"order_date\":\"2025-12-07\",\"message\":\"New order #ORD-202512070010 has been created.\",\"url\":\"\\/orders\\/12\",\"type\":\"new_order\",\"icon\":\"fas fa-shopping-cart\",\"color\":\"bg-blue-500\",\"created_at\":\"2025-12-07 05:27:24\"}', NULL, '2025-12-06 23:57:24', '2025-12-06 23:57:24'),
('672b3a24-32c8-40e7-a9a7-84b390512511', 'App\\Notifications\\NewOrderNotification', 'App\\Models\\User', 4, '{\"order_id\":13,\"order_number\":\"ORD-202512070011\",\"customer_name\":\"harsh\",\"customer_id\":3,\"amount\":\"455.00\",\"status\":\"cancelled\",\"order_date\":\"2025-12-18\",\"message\":\"New order #ORD-202512070011 has been created.\",\"url\":\"\\/orders\\/13\",\"type\":\"new_order\",\"icon\":\"fas fa-shopping-cart\",\"color\":\"bg-blue-500\",\"created_at\":\"2025-12-07 05:29:27\"}', NULL, '2025-12-06 23:59:27', '2025-12-06 23:59:27'),
('94b01d1c-ee9c-473d-afbc-cbd4a58f545b', 'App\\Notifications\\NewOrderNotification', 'App\\Models\\User', 7, '{\"order_id\":13,\"order_number\":\"ORD-202512070011\",\"customer_name\":\"harsh\",\"customer_id\":3,\"amount\":\"455.00\",\"status\":\"cancelled\",\"order_date\":\"2025-12-18\",\"message\":\"New order #ORD-202512070011 has been created.\",\"url\":\"\\/orders\\/13\",\"type\":\"new_order\",\"icon\":\"fas fa-shopping-cart\",\"color\":\"bg-blue-500\",\"created_at\":\"2025-12-07 05:29:27\"}', NULL, '2025-12-06 23:59:27', '2025-12-06 23:59:27'),
('9683ed09-73ea-43a7-bf1c-3652d8c5ed79', 'App\\Notifications\\NewOrderNotification', 'App\\Models\\User', 4, '{\"order_id\":13,\"order_number\":\"ORD-202512070011\",\"customer_name\":\"harsh\",\"customer_id\":3,\"amount\":\"455.00\",\"status\":\"cancelled\",\"order_date\":\"2025-12-18\",\"message\":\"New order #ORD-202512070011 has been created.\",\"url\":\"\\/orders\\/13\",\"type\":\"new_order\",\"icon\":\"fas fa-shopping-cart\",\"color\":\"bg-blue-500\",\"created_at\":\"2025-12-07 05:29:44\"}', NULL, '2025-12-06 23:59:44', '2025-12-06 23:59:44'),
('c2f9de56-6b08-40ba-b1d6-7ef58efff773', 'App\\Notifications\\NewOrderNotification', 'App\\Models\\User', 7, '{\"order_id\":13,\"order_number\":\"ORD-202512070011\",\"customer_name\":\"harsh\",\"customer_id\":3,\"amount\":\"455.00\",\"status\":\"cancelled\",\"order_date\":\"2025-12-18\",\"message\":\"New order #ORD-202512070011 has been created.\",\"url\":\"\\/orders\\/13\",\"type\":\"new_order\",\"icon\":\"fas fa-shopping-cart\",\"color\":\"bg-blue-500\",\"created_at\":\"2025-12-07 05:29:44\"}', NULL, '2025-12-06 23:59:44', '2025-12-06 23:59:44');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `customer_id` bigint UNSIGNED NOT NULL,
  `order_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` enum('pending','processing','completed','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `order_date` date NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `orders_order_number_unique` (`order_number`),
  KEY `orders_customer_id_foreign` (`customer_id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `order_number`, `amount`, `status`, `order_date`, `notes`, `created_at`, `updated_at`) VALUES
(3, 2, 'ORD-202512070001', 4584.00, 'pending', '2025-12-07', 'order is good', '2025-12-06 22:52:25', '2025-12-06 22:52:25'),
(2, 1, 'ORD-20251206-0002', 111.50, 'processing', '2025-10-21', 'Test order 2 for test', '2025-12-06 07:57:40', '2025-12-06 07:57:40'),
(4, 3, 'ORD-202512070002', 200.00, 'processing', '2025-11-12', 'The order is one month older and to be processed at priority.', '2025-12-06 23:20:42', '2025-12-06 23:20:42'),
(5, 3, 'ORD-202512070003', 5474.00, 'pending', '2025-12-07', 'the new order', '2025-12-06 23:23:02', '2025-12-06 23:23:02'),
(6, 2, 'ORD-202512070004', 100.00, 'completed', '2025-12-05', 'mail testing order', '2025-12-06 23:26:16', '2025-12-06 23:26:16'),
(7, 2, 'ORD-202512070005', 100.00, 'completed', '2025-12-05', 'mail testing order', '2025-12-06 23:26:31', '2025-12-06 23:26:31'),
(8, 3, 'ORD-202512070006', 22.00, 'completed', '2025-12-04', 'mail test order', '2025-12-06 23:27:15', '2025-12-06 23:27:15'),
(9, 3, 'ORD-202512070007', 22.00, 'completed', '2025-12-04', 'mail test order', '2025-12-06 23:32:43', '2025-12-06 23:32:43'),
(10, 3, 'ORD-202512070008', 22.00, 'completed', '2025-12-04', 'mail test order', '2025-12-06 23:32:53', '2025-12-06 23:32:53'),
(11, 3, 'ORD-202512070009', 22.00, 'completed', '2025-12-04', 'mail test order', '2025-12-06 23:35:50', '2025-12-06 23:35:50'),
(12, 3, 'ORD-202512070010', 55.00, 'cancelled', '2025-12-07', 'test tinker', '2025-12-06 23:57:18', '2025-12-06 23:57:18'),
(13, 3, 'ORD-202512070011', 455.00, 'cancelled', '2025-12-18', 'order new', '2025-12-06 23:59:25', '2025-12-06 23:59:25');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  KEY `personal_access_tokens_expires_at_index` (`expires_at`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('ug3CmOTCiFnPKXCWef1nPb1p7W1bW2mdPHnK5HDq', 4, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoibDhudG5rZW85UGpra0Frc2d1UjlXM3N4SzRQMmpYSVRlSFBtOEJENSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDY6Imh0dHA6Ly9sb2NhbGhvc3QvaW1wYWN0Z3VydS1jcm0vcHVibGljL3Byb2ZpbGUiO3M6NToicm91dGUiO3M6MTI6InByb2ZpbGUuZWRpdCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjQ7fQ==', 1765087780);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` enum('admin','staff') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'staff',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`) VALUES
(1, 'Pramod Mothabhau Deore', 'pramoddeore1626@gmail.com', NULL, '$2y$12$RwXAw694I/GXpdt2.mXpv..nzh4/4TXOtt7sK4mOGiUcvSViU3Xh.', NULL, '2025-12-06 05:20:47', '2025-12-06 05:20:47', 'staff'),
(5, 'Staff User', 'staff@impactguru.com', '2025-12-06 05:30:51', '$2y$12$mKD7Yoz8CWbwcfX7fRcfdeWjAS639x22MnR3Y7BV6bapGlBKxTjr6', NULL, '2025-12-06 05:30:51', '2025-12-06 05:30:51', 'staff'),
(4, 'Admin User', 'admin@impactguru.com', '2025-12-06 05:30:50', '$2y$12$CHGWqXxfRE88FteG1Oa4juiOpCA/P95I/c01h/Uy5pNibOTVNAcqW', 'DZHLSbLvHCTKipcK0mIQyuhSSmSEiRaB4JnNZAMcQzF9B31S05BjGVdi0rMU', '2025-12-06 05:30:50', '2025-12-06 05:30:50', 'admin'),
(6, 'test1', 'test@impactguru.com', NULL, '$2y$12$uUdCJ8k6M7rKjs6DhJJ2ou0jfIIMKr6nFIU3UGr6x2tJu5xEBeZWq', NULL, '2025-12-06 07:04:46', '2025-12-06 07:04:46', 'staff'),
(7, 'Sandip Deore', 'sandipdeore1664@gmail.com', NULL, '$2y$12$FvKuUIwBqlj/HmvytoO3OeOHZf5RH9oEXfV5TlSYMzdXeFnAyQkQe', NULL, '2025-12-06 23:46:11', '2025-12-06 23:46:11', 'admin');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
