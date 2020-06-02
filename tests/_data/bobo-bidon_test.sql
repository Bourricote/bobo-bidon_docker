-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : mysql:3306
-- Généré le : mar. 02 juin 2020 à 09:48
-- Version du serveur :  8.0.20
-- Version de PHP : 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Base de données : `bobo-bidon_test`
--

-- --------------------------------------------------------

--
-- Structure de la table `user_symptom`
--

DROP TABLE IF EXISTS `user_symptom`;
CREATE TABLE `user_symptom` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `symptom_id` int NOT NULL,
  `time` time DEFAULT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user_symptom`
--

INSERT INTO `user_symptom` (`id`, `user_id`, `symptom_id`, `time`, `date`) VALUES
(7, 3, 2, '14:30:00', '2020-02-10'),
(8, 3, 2, '16:30:00', '2020-02-10'),
(9, 3, 2, '18:30:00', '2020-02-10'),
(10, 3, 5, '14:30:00', '2020-02-10'),
(11, 3, 1, '14:30:00', '2020-02-10'),
(12, 3, 1, '16:30:00', '2020-02-10'),
(13, 3, 1, '18:30:00', '2020-02-10'),
(14, 3, 5, '18:30:00', '2020-02-10'),
(15, 3, 2, '13:00:00', '2020-02-13'),
(16, 3, 3, '18:00:00', '2020-02-13'),
(17, 3, 1, '13:00:00', '2020-02-13'),
(18, 3, 1, '15:00:00', '2020-02-13'),
(19, 3, 1, '17:00:00', '2020-02-13'),
(20, 3, 1, '20:00:00', '2020-02-15'),
(21, 3, 8, '11:00:00', '2020-02-19'),
(22, 3, 5, '11:00:00', '2020-02-19'),
(23, 3, 2, '19:00:00', '2020-02-19'),
(24, 3, 5, '19:00:00', '2020-02-19'),
(26, 3, 2, '22:00:00', '2020-02-22'),
(27, 3, 5, '22:00:00', '2020-02-22'),
(28, 3, 1, '22:00:00', '2020-02-22'),
(29, 3, 8, '15:00:00', '2020-02-26'),
(31, 3, 1, '19:00:00', '2020-02-28'),
(32, 3, 1, '17:00:00', '2020-03-02'),
(33, 3, 2, '17:00:00', '2020-03-02'),
(34, 3, 5, '17:00:00', '2020-03-02'),
(35, 3, 8, '14:00:00', '2020-03-09'),
(36, 3, 8, '17:00:00', '2020-03-09'),
(37, 3, 5, '17:00:00', '2020-03-09'),
(38, 3, 1, '18:00:00', '2020-03-09'),
(39, 3, 1, '16:00:00', '2020-03-10'),
(40, 3, 2, '16:00:00', '2020-03-10'),
(44, 3, 1, '18:00:00', '2020-03-10'),
(45, 3, 2, '18:00:00', '2020-03-10'),
(46, 3, 5, '18:00:00', '2020-03-10'),
(50, 3, 1, '20:00:00', '2020-03-10'),
(51, 3, 4, '09:30:00', '2020-03-11'),
(52, 3, 1, '18:00:00', '2020-03-11'),
(53, 3, 5, '18:00:00', '2020-03-11'),
(54, 3, 1, '16:00:00', '2020-03-12'),
(55, 3, 8, '16:00:00', '2020-03-12'),
(56, 3, 1, '18:00:00', '2020-03-12'),
(57, 3, 5, '18:00:00', '2020-03-12'),
(58, 3, 1, '20:00:00', '2020-03-12'),
(59, 3, 8, '15:00:00', '2020-03-13'),
(60, 3, 2, '20:00:00', '2020-03-13'),
(61, 3, 8, '10:00:00', '2020-03-14'),
(62, 3, 1, '20:00:00', '2020-03-15'),
(63, 3, 5, '18:00:00', '2020-03-18'),
(64, 3, 5, '08:00:00', '2020-03-19'),
(65, 3, 8, '08:00:00', '2020-03-19'),
(66, 3, 5, '21:00:00', '2020-03-20'),
(67, 3, 8, '21:00:00', '2020-03-20'),
(68, 3, 4, '08:00:00', '2020-03-23'),
(69, 3, 4, '08:00:00', '2020-03-24'),
(70, 3, 8, '16:00:00', '2020-03-25'),
(71, 3, 8, '00:00:00', '2020-03-27'),
(72, 3, 1, '17:00:00', '2020-03-30');

-- --------------------------------------------------------
--
-- Structure de la table `user_food`
--

DROP TABLE IF EXISTS `user_food`;
CREATE TABLE `user_food` (
  `id` int NOT NULL,
  `food_id` int NOT NULL,
  `user_id` int NOT NULL,
  `time` time DEFAULT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
--
-- Structure de la table `food`
--

DROP TABLE IF EXISTS `food`;
CREATE TABLE `food` (
  `id` int NOT NULL,
  `category_id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fodmap` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `oligos` int NOT NULL,
  `fructose` int NOT NULL,
  `polyols` int NOT NULL,
  `lactose` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `food`
--

INSERT INTO `food` (`id`, `category_id`, `name`, `fodmap`, `oligos`, `fructose`, `polyols`, `lactose`) VALUES
(1, 3, 'Polenta', 'low', 0, 0, 0, 0),
(2, 4, 'Fennel', 'low', 0, 0, 0, 0),
(3, 8, 'Vegetable oil', 'low', 0, 0, 0, 0),
(4, 8, 'Peanut oil', 'low', 0, 0, 0, 0),
(5, 8, 'Cocoa powder', 'low', 0, 0, 0, 0),
(6, 5, 'Pineapple', 'low', 0, 0, 0, 0),
(7, 8, 'Hummus / houmous', 'high', 2, 0, 0, 0),
(8, 7, 'Instant coffee (only if not made with lactose or other FODMAPS)', 'low', 0, 0, 0, 0),
(9, 7, 'Coffee (regular or decaf)', 'low', 0, 0, 0, 0),
(10, 7, 'Tofu (drained or firm)', 'low', 0, 0, 0, 0),
(11, 8, 'Canola oil', 'low', 0, 0, 0, 0),
(12, 4, 'Brussel sprouts', 'low', 0, 0, 0, 0),
(13, 8, 'Peanut butter', 'low', 0, 0, 0, 0),
(14, 8, 'Almond butter', 'low', 0, 0, 0, 0),
(15, 4, 'Seaweed / nori', 'low', 0, 0, 0, 0),
(16, 9, 'Pine nuts', 'low', 0, 0, 0, 0),
(17, 8, 'Lime juice', 'low', 0, 0, 0, 0),
(18, 5, 'Lime', 'low', 0, 0, 0, 0),
(19, 5, 'Figs, dried', 'high', 2, 0, 0, 0),
(20, 4, 'Silverbeet / chard', 'low', 0, 0, 0, 0),
(21, 4, 'Ginger', 'low', 0, 0, 0, 0),
(22, 8, 'Coconut oil', 'low', 0, 0, 0, 0),
(23, 7, 'Scallop', 'low', 0, 0, 0, 0),
(24, 9, 'Flax seeds/lineseed', 'low', 0, 0, 0, 0),
(25, 4, 'Leeks', 'high', 2, 0, 0, 0),
(26, 4, 'Kholrabi', 'low', 0, 0, 0, 0),
(27, 5, 'Cherries', 'high', 0, 2, 1, 0),
(28, 8, 'Baking soda', 'low', 0, 0, 0, 0),
(29, 8, 'Turmeric', 'low', 0, 0, 0, 0),
(30, 8, 'Baking powder', 'low', 0, 0, 0, 0),
(31, 9, 'Pumpkin seeds', 'low', 0, 0, 0, 0),
(32, 5, 'Pomegranate', 'high', 2, 0, 0, 0),
(33, 4, 'Pinto beans', 'high', 2, 0, 0, 0),
(34, 5, 'Dates', 'high', 2, 0, 0, 0),
(35, 8, 'Curry powder', 'low', 0, 0, 0, 0),
(37, 1, 'Coconut cream', 'low', 0, 0, 0, 0),
(38, 8, 'Vinegar', 'low', 0, 0, 0, 0),
(39, 7, 'Bacon', 'low', 0, 0, 0, 0),
(41, 5, 'Prune', 'high', 2, 0, 2, 0),
(46, 7, 'Ground beef', 'low', 0, 0, 0, 0),
(48, 3, 'Croissants', 'high', 0, 0, 0, 0),
(49, 3, 'Crumpets', 'high', 0, 0, 0, 0),
(51, 1, 'Margarine', 'low', 0, 0, 0, 0),
(52, 8, 'Ketchup (USA)', 'low', 0, 0, 0, 0),
(53, 4, 'Lentils, boiled', 'low', 0, 0, 0, 0),
(54, 4, 'Shallot', 'high', 2, 0, 0, 0),
(55, 5, 'Nectarine', 'high', 2, 0, 2, 0),
(56, 5, 'Mandarin', 'low', 0, 0, 0, 0),
(57, 7, 'Whiskey', 'low', 0, 0, 0, 0),
(58, 7, 'Vodka', 'low', 0, 0, 0, 0),
(59, 4, 'Yam', 'low', 0, 0, 0, 0),
(60, 4, 'Rutabaga/Swede', 'low', 0, 0, 0, 0),
(61, 4, 'Radish', 'low', 0, 0, 0, 0),
(62, 4, 'Olives', 'low', 0, 0, 0, 0),
(63, 4, 'Chives', 'low', 0, 0, 0, 0),
(64, 4, 'Bell pepper', 'low', 0, 0, 0, 0),
(65, 4, 'Arugula', 'low', 0, 0, 0, 0),
(66, 4, 'Bok choy', 'low', 0, 0, 0, 0),
(67, 4, 'Taro', 'high', 2, 0, 0, 0),
(68, 4, 'Soy beans, boiled', 'high', 2, 0, 0, 0),
(69, 4, 'Mung beans, boiled', 'high', 2, 0, 0, 0),
(70, 4, 'Lima beans, boiled', 'high', 2, 0, 0, 0),
(71, 4, 'Haricot beans, boiled', 'high', 2, 0, 0, 0),
(72, 4, 'Sauerkraut', 'high', 0, 0, 2, 0),
(73, 4, 'Falafel', 'high', 2, 0, 0, 0),
(74, 4, 'Chayote / choko', 'high', 2, 0, 0, 0),
(75, 4, 'Cho Cho', 'high', 2, 0, 0, 0),
(76, 4, 'Cassava', 'high', 2, 0, 0, 0),
(77, 4, 'Butter beans, canned', 'high', 2, 0, 0, 0),
(78, 4, 'Broad beans', 'high', 0, 2, 0, 0),
(79, 4, 'Kidney beans, boiled', 'high', 2, 0, 0, 0),
(80, 4, 'Black eyed peas', 'high', 0, 0, 0, 0),
(81, 4, 'Black beans, boiled', 'high', 2, 0, 0, 0),
(82, 4, 'Beetroots/Beets', 'high', 2, 0, 0, 0),
(83, 4, 'Baked beans', 'high', 2, 2, 0, 0),
(84, 4, 'Artichoke, globe', 'high', 2, 0, 0, 0),
(85, 1, 'Kefir', 'high', 0, 0, 0, 2),
(86, 7, 'White tea', 'low', 0, 0, 0, 0),
(87, 7, 'Green tea', 'low', 0, 0, 0, 0),
(88, 7, 'Black tea, weak', 'low', 0, 0, 0, 0),
(89, 7, 'Black tea, strong', 'high', 1, 0, 0, 0),
(90, 7, 'Chai tea, weak', 'low', 0, 0, 0, 0),
(91, 7, 'Oolong tea', 'high', 2, 0, 0, 0),
(92, 7, 'Dandelion tea, strong', 'high', 2, 0, 0, 0),
(93, 7, 'Chai tea, strong', 'high', 2, 0, 0, 0),
(94, 7, 'Chamomile tea', 'high', 2, 0, 0, 0),
(96, 7, 'Rum', 'high', 0, 2, 0, 0),
(97, 7, 'Cold cuts / deli meat / cold meats such as ham', 'low', 0, 0, 0, 0),
(98, 7, 'Turkey', 'low', 0, 0, 0, 0),
(99, 7, 'Prosciutto', 'low', 0, 0, 0, 0),
(100, 8, 'Thyme', 'low', 0, 0, 0, 0),
(101, 8, 'Tarragon', 'low', 0, 0, 0, 0),
(102, 8, 'Rosemary', 'low', 0, 0, 0, 0),
(103, 8, 'Rampa / pandan leaves', 'low', 0, 0, 0, 0),
(105, 8, 'Oregano', 'low', 0, 0, 0, 0),
(106, 8, 'Mint', 'low', 0, 0, 0, 0),
(107, 8, 'Lemongrass', 'low', 0, 0, 0, 0),
(108, 8, 'Gotukala', 'low', 0, 0, 0, 0),
(109, 8, 'Fenugreek leaves, dried', 'low', 0, 0, 0, 0),
(110, 8, 'Curry leaves', 'low', 0, 0, 0, 0),
(111, 8, 'Coriander', 'low', 0, 0, 0, 0),
(112, 8, 'Cilantro', 'low', 0, 0, 0, 0),
(113, 8, 'Basil', 'low', 0, 0, 0, 0),
(114, 8, 'Parsley', 'low', 0, 0, 0, 0),
(115, 8, 'Cinnamon', 'low', 0, 0, 0, 0),
(118, 1, 'Almond milk', 'low', 0, 0, 0, 0),
(119, 9, 'Almonds', 'low', 0, 0, 0, 0),
(120, 7, 'Apple juice', 'high', 0, 2, 2, 0),
(121, 5, 'Apples', 'high', 0, 2, 2, 0),
(122, 5, 'Apricot', 'high', 1, 0, 2, 0),
(123, 4, 'Asparagus', 'high', 0, 2, 0, 0),
(125, 5, 'Avocado', 'high', 0, 0, 2, 0),
(126, 4, 'Bamboo shoots', 'low', 0, 0, 0, 0),
(127, 5, 'Bananas, ripe', 'high', 2, 0, 0, 0),
(128, 8, 'Barbeque sauce', 'low', 0, 0, 0, 0),
(129, 3, 'Barley, pearl', 'high', 2, 0, 0, 0),
(130, 4, 'Bean sprouts', 'low', 0, 0, 0, 0),
(131, 7, 'Beef', 'low', 0, 0, 0, 0),
(132, 1, 'Eggs', 'low', 0, 0, 0, 0),
(133, 7, 'Beer', 'low', 0, 0, 0, 0),
(134, 5, 'Blackberry', 'high', 0, 0, 2, 0),
(135, 5, 'Blueberry', 'low', 0, 0, 0, 0),
(136, 3, 'Wheat bran, pellets', 'high', 2, 1, 0, 0),
(137, 9, 'Brazil Nuts', 'low', 0, 0, 0, 0),
(138, 1, 'Brie cheese', 'low', 0, 0, 0, 0),
(139, 4, 'Broccoli', 'low', 0, 0, 0, 0),
(140, 3, 'Buckwheat, flour', 'low', 0, 0, 0, 0),
(141, 1, 'Butter', 'low', 0, 0, 0, 0),
(142, 1, 'Buttermilk', 'high', 0, 0, 0, 2),
(143, 4, 'Cabbage, common', 'low', 0, 0, 0, 0),
(144, 4, 'Cabbage, savoy', 'high', 2, 0, 0, 0),
(145, 1, 'Camembert cheese', 'low', 0, 0, 0, 0),
(146, 5, 'Cantaloupe', 'low', 0, 0, 0, 0),
(147, 4, 'Carrots', 'low', 0, 0, 0, 0),
(148, 9, 'Cashews', 'high', 2, 0, 0, 0),
(149, 4, 'Cauliflower', 'high', 0, 0, 2, 0),
(150, 4, 'Celery', 'low', 0, 0, 0, 0),
(151, 1, 'Cheddar cheese', 'low', 0, 0, 0, 0),
(152, 9, 'Chestnuts', 'low', 0, 0, 0, 0),
(153, 9, 'Chia seeds', 'low', 0, 0, 0, 0),
(154, 4, 'Chickpeas, canned', 'low', 0, 0, 0, 0),
(155, 7, 'Chicken', 'low', 0, 0, 0, 0),
(156, 3, 'Chips, potato crisps (plain)', 'low', 0, 0, 0, 0),
(157, 7, 'Chorizo', 'high', 0, 0, 0, 0),
(158, 8, 'Chutney', 'low', 0, 0, 0, 0),
(159, 5, 'Clementine', 'low', 0, 0, 0, 0),
(160, 5, 'Coconut (fresh or dried)', 'low', 0, 0, 0, 0),
(161, 1, 'Coconut milk, canned', 'low', 0, 0, 0, 0),
(162, 7, 'Coconut water', 'high', 1, 0, 2, 0),
(163, 7, 'Coffee, black', 'low', 0, 0, 0, 0),
(164, 1, 'Colby cheese', 'low', 0, 0, 0, 0),
(165, 4, 'Corn / Sweet corn', 'low', 0, 0, 0, 0),
(166, 3, 'Cornflour', 'low', 0, 0, 0, 0),
(167, 1, 'Cottage cheese', 'low', 0, 0, 0, 0),
(169, 3, 'Cous cous, wheat', 'high', 2, 0, 0, 0),
(170, 1, 'Cow milk', 'high', 0, 0, 0, 2),
(171, 5, 'Cranberry', 'low', 0, 0, 0, 0),
(172, 1, 'Cream, regular fat', 'high', 0, 0, 0, 1),
(173, 1, 'Cream cheese', 'high', 0, 0, 0, 1),
(174, 4, 'Cucumber', 'low', 0, 0, 0, 0),
(175, 1, 'Custard', 'high', 0, 0, 0, 2),
(177, 5, 'Dragon Fruit', 'low', 0, 0, 0, 0),
(178, 7, 'Drinking chocolate powder (any % cocoa)', 'low', 0, 0, 0, 0),
(179, 5, 'Durian', 'low', 0, 0, 0, 0),
(180, 4, 'Eggplant/Aubergine', 'low', 0, 0, 0, 0),
(181, 7, 'Fennel tea', 'high', 2, 0, 0, 0),
(182, 1, 'Feta cheese', 'low', 0, 0, 0, 0),
(183, 4, 'Garlic', 'high', 2, 0, 0, 0),
(184, 8, 'Garlic infused oil', 'low', 0, 0, 0, 0),
(186, 3, 'Gluten free wheat products (e.g. breads, cereals, pasta) made without high fodmap ingredients like honey or garlic', 'low', 0, 0, 0, 0),
(187, 3, 'Gnocchi, wheat', 'high', 2, 0, 0, 0),
(188, 1, 'Goat cheese', 'low', 0, 0, 0, 0),
(189, 1, 'Goat milk', 'high', 0, 0, 0, 2),
(190, 8, 'Golden syrup / light tracle', 'low', 0, 0, 0, 0),
(191, 3, 'Granola', 'high', 0, 0, 0, 0),
(192, 5, 'Grapefruit', 'high', 2, 0, 0, 0),
(193, 5, 'Grapes (Red, Green and Black)', 'low', 0, 0, 0, 0),
(194, 1, 'Greek yogurt', 'low', 0, 0, 0, 0),
(195, 1, 'Goat yogurt', 'low', 0, 0, 0, 0),
(196, 1, 'Lactose free yogurt', 'low', 0, 0, 0, 0),
(197, 1, 'Yogurt', 'high', 0, 0, 0, 2),
(198, 4, 'Green Beans', 'low', 0, 0, 0, 0),
(199, 4, 'Green Pepper', 'low', 0, 0, 0, 0),
(200, 1, 'Havarti cheese', 'low', 0, 0, 0, 0),
(201, 9, 'Hazelnuts', 'low', 0, 0, 0, 0),
(202, 1, 'Hemp milk', 'low', 0, 0, 0, 0),
(203, 3, 'Oats', 'low', 0, 0, 0, 0),
(204, 7, 'Herbal tea (strong)', 'high', 2, 0, 0, 0),
(205, 7, 'Herbal tea (weak)', 'low', 1, 0, 0, 0),
(207, 8, 'Hommus dip', 'high', 2, 0, 0, 0),
(209, 1, 'Ice cream', 'high', 0, 0, 0, 1),
(212, 8, 'Jam (mixed berries)', 'high', 0, 0, 2, 0),
(213, 4, 'Kale', 'low', 0, 0, 0, 0),
(214, 5, 'Kiwifruit', 'low', 0, 0, 0, 0),
(215, 5, 'Kumquat', 'low', 0, 0, 0, 0),
(216, 1, 'Lactose free milk', 'low', 0, 0, 0, 0),
(217, 7, 'Lamb', 'low', 0, 0, 0, 0),
(218, 5, 'Lemon', 'low', 0, 0, 0, 0),
(219, 4, 'Lettuce (e.g. rocket, butter, iceberg, radicchio, red coral, romaine)', 'low', 0, 0, 0, 0),
(220, 9, 'Macadamia nuts', 'low', 0, 0, 0, 0),
(223, 5, 'Mango', 'high', 0, 2, 0, 0),
(224, 7, 'Mango juice', 'high', 0, 2, 2, 0),
(226, 8, 'Mayonnaise', 'low', 0, 0, 0, 0),
(227, 5, 'Melons e.g. Honeydew, galia', 'low', 0, 0, 0, 0),
(228, 1, 'Milk chocolate', 'low', 0, 0, 0, 0),
(229, 1, 'Mozzarella cheese', 'low', 0, 0, 0, 0),
(230, 3, 'Muesli', 'high', 2, 0, 0, 0),
(231, 3, 'Muffins', 'high', 0, 0, 0, 0),
(232, 4, 'Mushrooms', 'high', 1, 0, 2, 0),
(233, 8, 'Mustard', 'low', 0, 0, 0, 0),
(234, 1, 'Oat milk', 'low', 0, 0, 0, 0),
(235, 3, 'Oatmeal', 'low', 0, 0, 0, 0),
(236, 4, 'Onions', 'high', 2, 0, 0, 0),
(237, 5, 'Orange', 'low', 0, 0, 0, 0),
(238, 7, 'Orange juice', 'high', 0, 2, 0, 0),
(239, 5, 'Papaya', 'low', 0, 0, 0, 0),
(240, 1, 'Parmesan cheese', 'low', 0, 0, 0, 0),
(241, 4, 'Parsnip', 'low', 0, 0, 0, 0),
(242, 5, 'Passion Fruit', 'low', 0, 0, 0, 0),
(243, 8, 'Pasta sauce (cream based)', 'high', 2, 0, 0, 1),
(244, 5, 'Peaches', 'high', 0, 0, 2, 0),
(245, 9, 'Peanuts', 'low', 0, 0, 0, 0),
(246, 7, 'Pear juice', 'high', 0, 2, 2, 0),
(247, 5, 'Pears', 'high', 0, 2, 2, 0),
(248, 4, 'Peas', 'high', 2, 0, 0, 0),
(249, 9, 'Pecans', 'low', 0, 0, 0, 0),
(250, 1, 'Pecorino cheese', 'low', 0, 0, 0, 0),
(251, 7, 'Peppermint tea', 'low', 0, 0, 0, 0),
(252, 5, 'Pineapple', 'low', 0, 0, 0, 0),
(253, 9, 'Pistachio', 'high', 2, 0, 0, 0),
(254, 5, 'Plums', 'high', 2, 0, 2, 0),
(255, 3, 'Popcorn', 'low', 0, 0, 0, 0),
(256, 9, 'Poppy seeds', 'low', 0, 0, 0, 0),
(257, 7, 'Pork', 'low', 0, 0, 0, 0),
(258, 4, 'Potato', 'low', 0, 0, 0, 0),
(259, 3, 'Pretzels', 'low', 0, 0, 0, 0),
(260, 4, 'Pumpkin', 'low', 0, 0, 0, 0),
(261, 9, 'Pumpkin seeds', 'low', 0, 0, 0, 0),
(262, 3, 'Quinoa', 'low', 0, 0, 0, 0),
(263, 7, 'Quorn mince', 'low', 0, 0, 0, 0),
(264, 5, 'Raisins', 'high', 2, 0, 0, 0),
(265, 5, 'Raspberry', 'low', 0, 0, 0, 0),
(266, 4, 'Red Peppers', 'low', 0, 0, 0, 0),
(267, 8, 'Relish', 'high', 2, 0, 0, 0),
(268, 5, 'Rhubarb', 'low', 0, 0, 0, 0),
(269, 3, 'Brown rice', 'low', 0, 0, 0, 0),
(270, 3, 'White rice', 'low', 0, 0, 0, 0),
(271, 3, 'Basmati rice', 'low', 0, 0, 0, 0),
(272, 1, 'Rice milk', 'low', 0, 0, 0, 0),
(273, 1, 'Ricotta cheese', 'high', 0, 0, 0, 1),
(274, 3, 'Rye', 'high', 2, 2, 0, 0),
(276, 7, 'Sausages', 'high', 2, 0, 0, 0),
(277, 3, 'Savory biscuits', 'low', 0, 0, 0, 0),
(278, 4, 'Scallions / Spring onions / Green onions (green part)', 'low', 0, 0, 0, 0),
(279, 4, 'Scallions / Spring onions / Green onions (white part)', 'high', 2, 0, 0, 0),
(280, 3, 'Semolina', 'high', 0, 0, 0, 0),
(281, 9, 'Sesame seeds', 'low', 0, 0, 0, 0),
(282, 1, 'Sheep\'s milk', 'high', 0, 0, 0, 0),
(283, 7, 'Sodas with HFCS', 'high', 0, 0, 0, 0),
(285, 1, 'Sour cream', 'high', 0, 0, 0, 2),
(286, 1, 'Soy milk made with soy beans', 'high', 2, 0, 0, 0),
(287, 8, 'Soy sauce', 'low', 0, 0, 0, 0),
(288, 1, 'Soya milk made with soy protein', 'low', 0, 0, 0, 0),
(289, 3, 'Spelt flakes', 'high', 2, 0, 0, 0),
(290, 3, 'Spelt bread (non-sourdough)', 'high', 0, 0, 0, 0),
(291, 3, 'Spelt bread (sourdough)', 'low', 0, 0, 0, 0),
(292, 3, 'Spelt pasta', 'low', 0, 0, 0, 0),
(293, 4, 'Butternut squash', 'low', 0, 0, 0, 0),
(294, 5, 'Star Fruit', 'low', 0, 0, 0, 0),
(296, 5, 'Strawberry', 'low', 0, 0, 0, 0),
(297, 8, 'Strawberry jam / jelly (without HFCS)', 'low', 0, 0, 0, 0),
(300, 5, 'Sultanas', 'high', 0, 0, 0, 0),
(301, 9, 'Sunflower seeds', 'low', 0, 0, 0, 0),
(303, 1, 'Swiss cheese', 'low', 0, 0, 0, 0),
(304, 5, 'Tamarind', 'low', 0, 0, 0, 0),
(305, 5, 'Tangelo', 'low', 0, 0, 0, 0),
(306, 8, 'Tomato sauce', 'low', 0, 0, 0, 0),
(307, 4, 'Tomatoes', 'low', 0, 0, 0, 0),
(308, 3, 'Chips, tortilla', 'low', 0, 0, 0, 0),
(309, 4, 'Turnip', 'low', 0, 0, 0, 0),
(310, 8, 'Tzatziki dip', 'high', 2, 2, 0, 0),
(311, 9, 'Walnuts', 'low', 0, 0, 0, 0),
(312, 7, 'Water', 'low', 0, 0, 0, 0),
(313, 5, 'Watermelon', 'high', 2, 2, 2, 0),
(314, 3, 'Wheat foods e.g. Bread, cereal, pasta', 'high', 2, 0, 0, 0),
(315, 1, 'White chocolate', 'low', 0, 0, 0, 0),
(316, 7, 'Wine', 'low', 0, 0, 0, 0),
(318, 4, 'Zucchini / courgette', 'low', 0, 0, 0, 0),
(319, 8, 'Tahini', 'high', 2, 0, 0, 0),
(320, 4, 'Spinach', 'low', 0, 0, 0, 0),
(321, 7, 'Shrimp', 'low', 0, 0, 0, 0),
(322, 7, 'Prawns', 'low', 0, 0, 0, 0),
(323, 7, 'Oysters', 'low', 0, 0, 0, 0),
(324, 7, 'Mussels', 'low', 0, 0, 0, 0),
(325, 7, 'Lobster', 'low', 0, 0, 0, 0),
(326, 7, 'Crab', 'low', 0, 0, 0, 0),
(327, 7, 'Tuna', 'low', 0, 0, 0, 0),
(328, 7, 'Trout', 'low', 0, 0, 0, 0),
(329, 7, 'Salmon', 'low', 0, 0, 0, 0),
(330, 7, 'Cod', 'low', 0, 0, 0, 0),
(331, 7, 'Haddock', 'low', 0, 0, 0, 0),
(332, 8, 'Olive Oil', 'low', 0, 0, 0, 0),
(333, 5, 'Goji Berries', 'high', 2, 0, 0, 0),
(334, 3, 'Rice Crackers', 'low', 0, 0, 0, 0),
(335, 3, 'Rice Cakes', 'low', 0, 0, 0, 0),
(336, 4, 'Edamame', 'low', 0, 0, 0, 0),
(337, 4, 'Acorn Squash', 'low', 0, 0, 0, 0),
(338, 8, 'Balsamic Vinegar', 'low', 0, 0, 0, 0),
(339, 8, 'Apple Cider Vinegar', 'low', 0, 0, 0, 0),
(340, 4, 'Split Peas', 'high', 2, 0, 0, 0),
(341, 1, 'Blue Cheese', 'low', 0, 0, 0, 0),
(342, 3, 'Tapioca', 'low', 0, 0, 0, 0),
(343, 8, 'Sesame Oil', 'low', 0, 0, 0, 0),
(344, 4, 'Spaghetti squash', 'low', 0, 0, 0, 0),
(345, 4, 'Okra', 'low', 0, 0, 0, 0),
(346, 8, 'Capers', 'low', 0, 0, 0, 0),
(347, 7, 'Gin', 'low', 0, 0, 0, 0),
(348, 3, 'Jasmine rice', 'low', 0, 0, 0, 0),
(349, 7, 'Kombucha', 'high', 2, 0, 0, 0),
(350, 8, 'Molasses', 'high', 0, 0, 0, 0),
(351, 3, 'Sorghum', 'low', 0, 0, 0, 0),
(352, 3, 'Almond flour', 'low', 0, 0, 0, 0),
(353, 3, 'Coconut flour', 'high', 2, 2, 2, 0),
(354, 8, 'Cumin', 'low', 0, 0, 0, 0),
(355, 4, 'Endive', 'low', 0, 0, 0, 0),
(356, 8, 'Garlic powder', 'high', 2, 0, 0, 0),
(357, 8, 'Garlic salt', 'high', 2, 0, 0, 0),
(358, 3, 'Millet flour', 'low', 0, 0, 0, 0),
(359, 1, 'Halloumi / Hellim', 'low', 0, 0, 0, 0),
(360, 3, 'Rice noodles', 'low', 0, 0, 0, 0),
(361, 4, 'Watercress', 'low', 0, 0, 0, 0),
(362, 4, 'Celeriac', 'low', 0, 0, 0, 0),
(363, 8, 'Salt', 'low', 0, 0, 0, 0),
(364, 8, 'Pepper, black', 'low', 0, 0, 0, 0),
(365, 4, 'Jicama', 'low', 0, 0, 0, 0),
(366, 8, 'Paprika', 'low', 0, 0, 0, 0),
(367, 1, 'Asiago cheese', 'low', 0, 0, 0, 0),
(368, 8, 'Miso paste', 'low', 0, 0, 0, 0),
(369, 8, 'Tomato paste', 'low', 0, 0, 0, 0),
(370, 4, 'Baby spinach', 'low', 0, 0, 0, 0),
(371, 5, 'Apricots, dried', 'high', 1, 0, 2, 0),
(372, 5, 'Guava, ripe', 'low', 0, 0, 0, 0),
(373, 5, 'Guava, unripe', 'high', 0, 2, 0, 0),
(374, 5, 'Banana, dried', 'low', 0, 0, 0, 0),
(375, 4, 'Yucca root', 'high', 2, 0, 0, 0),
(376, 5, 'Feijoa', 'high', 0, 2, 0, 0),
(377, 3, 'Chips, corn (plain)', 'low', 0, 0, 0, 0),
(378, 8, 'Nutritional Yeast', 'low', 0, 0, 0, 0),
(379, 4, 'Tempeh', 'low', 0, 0, 0, 0),
(380, 4, 'Snow peas', 'low', 0, 0, 0, 0),
(381, 4, 'Capsicum', 'low', 0, 0, 0, 0),
(382, 4, 'Collard greens', 'low', 0, 0, 0, 0),
(383, 7, 'Lemonade', 'low', 0, 0, 0, 0),
(384, 8, 'Nutmeg', 'low', 0, 0, 0, 0),
(385, 5, 'Persimmon', 'high', 2, 0, 0, 0),
(386, 4, 'Tumeric', 'low', 0, 0, 0, 0),
(387, 3, 'Wheat flour', 'high', 2, 0, 0, 0),
(388, 3, 'Wild rice', 'low', 0, 0, 0, 0),
(389, 4, 'Alfalfa sprouts', 'low', 0, 0, 0, 0),
(390, 3, 'Amaranth flour', 'high', 0, 0, 0, 0),
(391, 3, 'Amaranth, puffed grain', 'low', 0, 0, 0, 0),
(392, 8, 'Cardamom', 'low', 0, 0, 0, 0),
(393, 4, 'Carob powder', 'high', 2, 0, 0, 0),
(394, 4, 'Chicory leaves', 'low', 0, 0, 0, 0),
(395, 4, 'Garbanzo beans, canned', 'low', 0, 0, 0, 0),
(396, 4, 'Gherkins in vinegar', 'low', 0, 0, 0, 0),
(397, 5, 'Lychee', 'high', 0, 0, 2, 0),
(399, 8, 'Pesto sauce', 'low', 0, 0, 0, 0),
(400, 8, 'Sunflower oil', 'low', 0, 0, 0, 0),
(401, 3, 'Grits', 'low', 0, 0, 0, 0),
(402, 8, 'Horseradish', 'low', 0, 0, 0, 0),
(403, 5, 'Plantains', 'low', 0, 0, 0, 0),
(404, 8, 'Ghee', 'low', 0, 0, 0, 0),
(405, 3, 'Oatcake', 'low', 0, 0, 0, 0),
(406, 5, 'Dried Cranberries', 'low', 0, 0, 0, 0),
(407, 5, 'Currants', 'high', 2, 0, 0, 0),
(408, 8, 'Vegemite', 'low', 0, 0, 0, 0),
(409, 8, 'Marmite', 'low', 0, 0, 0, 0),
(410, 8, 'Onion Powder', 'high', 2, 0, 0, 0),
(411, 8, 'Garlic Powder', 'high', 2, 0, 0, 0),
(412, 5, 'Rambutan', 'low', 0, 0, 0, 0),
(413, 3, 'Soba noodles', 'low', 0, 0, 0, 0),
(414, 8, 'Wasabi powder', 'low', 0, 0, 0, 0),
(415, 5, 'Figs, fresh', 'high', 0, 2, 0, 0),
(416, 7, 'Dandelion tea, weak', 'low', 0, 0, 0, 0),
(417, 4, 'Lentils, canned', 'low', 0, 0, 0, 0),
(418, 4, 'Mung beans, sprouted', 'low', 0, 0, 0, 0),
(419, 4, 'Kidney beans, sprouted', 'high', 2, 0, 0, 0),
(420, 4, 'Black beans, canned', 'high', 2, 0, 0, 0),
(421, 5, 'Bananas, unripe', 'low', 0, 0, 0, 0),
(422, 3, 'Barley, sprouted', 'low', 0, 0, 0, 0),
(423, 3, 'Barley, flour', 'high', 2, 0, 0, 0),
(424, 4, 'Chickpeas, sprouted', 'high', 0, 0, 0, 0),
(425, 5, 'Cranberry, dried', 'low', 0, 0, 0, 0),
(426, 4, 'Cabbage, red', 'low', 0, 0, 0, 0),
(427, 8, 'Cacao powder', 'low', 0, 0, 0, 0),
(428, 7, 'Cranberry Juice', 'low', 0, 0, 0, 0),
(429, 8, 'Dill, fresh', 'low', 0, 0, 0, 0),
(430, 8, 'Avocado Oil', 'low', 0, 0, 0, 0),
(431, 7, 'Sardines, canned in oil', 'low', 0, 0, 0, 0),
(432, 4, 'Sugar snap peas', 'high', 0, 2, 0, 0),
(433, 4, 'Red onion', 'high', 2, 0, 0, 0),
(434, 3, 'Corn starch', 'low', 0, 0, 0, 0),
(435, 3, 'Teff flour', 'low', 0, 0, 0, 0),
(436, 8, 'Chili powder', 'low', 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `diet_week` int NOT NULL,
  `sugar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`id`, `name`, `diet_week`, `sugar`) VALUES
(1, 'Produits laitiers', 3, 'Disaccharides'),
(2, 'Autres', 4, ''),
(3, 'Produits céréaliers', 5, 'Oligosaccharides'),
(4, 'Légumes verts', 6, 'Oligosaccharides'),
(5, 'Fruits', 7, 'Monosaccharides'),
(6, 'Divers', 8, 'Polyols'),
(7, 'Boissons', 0, ''),
(8, 'Condiments / Herbes / Epices', 0, ''),
(9, 'Noix / Graines', 0, '');

-- --------------------------------------------------------


--
-- Structure de la table `symptom`
--

DROP TABLE IF EXISTS `symptom`;
CREATE TABLE `symptom` (
  `id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `symptom`
--

INSERT INTO `symptom` (`id`, `name`) VALUES
(1, 'Douleurs abdominales'),
(2, 'Ballonnements'),
(3, 'Constipation'),
(4, 'Diarrhée'),
(5, 'Flatulences'),
(6, 'Mucus dans les selles'),
(7, 'Evacuation non complète'),
(8, 'Borborygmes'),
(9, 'Nausée');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int NOT NULL,
  `email` varchar(180) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `picture_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `age` int DEFAULT NULL,
  `weight` double DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `firstname`, `lastname`, `created_at`, `updated_at`, `picture_name`, `age`, `weight`, `start_date`, `end_date`) VALUES
(3, 'anne.quiedeville@orange.fr', '[\"ROLE_ADMIN\"]', '$argon2i$v=19$m=65536,t=4,p=1$V2ZlTUVhL1p5RWVydUxPNw$W+icMjO1NlcG3C/g7v7eIwYxZb2IPhlPo/aJ/DzoNus', 'Anne', 'Quiedeville', '2020-05-26 16:47:20', '2020-05-28 15:59:54', 'myAvatar.png', 30, 62, '2020-02-10', '2020-04-05'),
(7, 'céline.godichon@hotmail.fr', '[\"ROLE_ADMIN\"]', '$argon2i$v=19$m=65536,t=4,p=1$UFJyM2VOZW9keUVXNVIvaA$OLWgmyuxU93w3lPn12O9yGq+haKSK52yc3t0OZtq6+c', 'Céline', 'Godichon', '2020-05-26 16:47:20', NULL, NULL, NULL, NULL, NULL, NULL),
(9, 'anne@anne.fr', '[\"ROLE_USER\"]', '$argon2i$v=19$m=65536,t=4,p=1$MWNFWS9oVnlBU3NpcjltUg$heM9tAaqldBs8Q58twvWQgpGeveyrsXsnXn+629busI', 'Anne', 'Anne', '2020-05-27 17:29:06', NULL, NULL, 33, NULL, '2020-01-01', '2020-02-26'),
(10, 'anne.quiedeville@dotsafe.fr', '[\"ROLE_USER\"]', '$argon2i$v=19$m=65536,t=4,p=1$WTRBZ2wuNUlucDFxaXIzUA$XTD+rnx1tt50ite/eG5Fc8T94XFqqcDS89CF3p0KfNo', 'Anne', 'Dotsafe', '2020-05-27 17:36:26', '2020-05-28 17:35:57', NULL, NULL, NULL, '2020-05-25', '2020-07-20'),
(11, 'coucou@truc.fr', '[\"ROLE_USER\"]', '$argon2i$v=19$m=65536,t=4,p=1$VnlnMThUNzRzYWU5MlM5YQ$9IaLmF5o0+ZCcj8yTQB8tzjhfVm4qopFYiJKNUzmko4', 'Cou', 'COU', '2020-05-29 15:36:14', '2020-05-29 17:30:01', 'Capture d’écran (59).png', NULL, 60, '2020-06-01', '2020-07-27');


--
-- Index pour les tables déchargées
--

--
-- Index pour la table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `food`
--
ALTER TABLE `food`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_D43829F712469DE2` (`category_id`);

--
-- Index pour la table `symptom`
--
ALTER TABLE `symptom`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`);

--
-- Index pour la table `user_food`
--
ALTER TABLE `user_food`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_AEB9653EBA8E87C4` (`food_id`),
  ADD KEY `IDX_AEB9653EA76ED395` (`user_id`);

--
-- Index pour la table `user_symptom`
--
ALTER TABLE `user_symptom`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_BCCFEEAAA76ED395` (`user_id`),
  ADD KEY `IDX_BCCFEEAADEEFDA95` (`symptom_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `category`
--
ALTER TABLE `category`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `food`
--
ALTER TABLE `food`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=437;

--
-- AUTO_INCREMENT pour la table `symptom`
--
ALTER TABLE `symptom`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `user_food`
--
ALTER TABLE `user_food`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `user_symptom`
--
ALTER TABLE `user_symptom`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `food`
--
ALTER TABLE `food`
  ADD CONSTRAINT `FK_D43829F712469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);

--
-- Contraintes pour la table `user_food`
--
ALTER TABLE `user_food`
  ADD CONSTRAINT `FK_AEB9653EA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_AEB9653EBA8E87C4` FOREIGN KEY (`food_id`) REFERENCES `food` (`id`);

--
-- Contraintes pour la table `user_symptom`
--
ALTER TABLE `user_symptom`
  ADD CONSTRAINT `FK_BCCFEEAAA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_BCCFEEAADEEFDA95` FOREIGN KEY (`symptom_id`) REFERENCES `symptom` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
