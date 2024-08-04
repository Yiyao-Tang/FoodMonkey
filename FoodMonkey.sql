-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2022-11-11 13:27:02
-- 服务器版本： 10.4.21-MariaDB
-- PHP 版本： 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `FoodMonkey`
--

-- --------------------------------------------------------

--
-- 表的结构 `card`
--

CREATE TABLE `card` (
  `card_number` char(16) NOT NULL,
  `CVV` int(3) DEFAULT NULL,
  `quantity` decimal(6,2) NOT NULL,
  `expiry_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `card`
--

INSERT INTO `card` (`card_number`, `CVV`, `quantity`, `expiry_date`) VALUES
('1234123412341234', 999, '1000.00', '2023-08-24');

-- --------------------------------------------------------

--
-- 表的结构 `food_item`
--

CREATE TABLE `food_item` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `rest_id` int(11) NOT NULL,
  `price` double NOT NULL,
  `stock` int(11) NOT NULL,
  `image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `food_item`
--

INSERT INTO `food_item` (`id`, `name`, `rest_id`, `price`, `stock`, `image`) VALUES
(1, 'Colonel Nuggets', 1, 8, 59, 'colonel-nugget.jpg'),
(2, 'Chicken Wings', 6, 5, 85, 'chicken-wings.jpeg'),
(4, 'Mashed Potato', 1, 4, 17, 'mashed-potato.jpeg\r\n'),
(5, 'French Fries', 1, 5, 14, 'french-fries.jpeg'),
(6, 'Tomato Pasta', 4, 8, 17, 'tomato-pasta.jpg'),
(7, 'Chicken Cutlet', 5, 8, 31, 'chicken-cutlet.jpg'),
(9, 'Chicken Chop', 5, 9, 14, 'chicken-chop.jpeg'),
(10, 'Hawaiian Pizza', 5, 24, 11, 'hawaiian-pizza.jpg'),
(11, 'Chicken Mole', 6, 9, 22, 'chicken-mole.jpg'),
(12, 'Asado de Puerco', 6, 10, 24, 'Asado-de-puerco.jpg'),
(13, 'Chicken Fried Stick', 6, 8, 27, 'chicken-fried-stick.jpeg'),
(14, 'Chipotle', 6, 12, 18, 'chipotle.jpg'),
(15, 'Grilled Ribeye', 6, 19, 17, 'grilled-ribeye.jpg'),
(16, 'Sichuan Noodles', 7, 5, 33, 'sichuan-noodles.jpg'),
(17, 'Claypot Tofu', 7, 6, 26, 'Claypot-Tofu.jpg'),
(18, 'Beef Spring Onion', 7, 6, 28, 'beef-spring-onion.jpg'),
(19, 'Sweet & Sour Pork', 7, 5, 23, 'Sweet-and-Sour-Pork.jpg'),
(20, '1 Meat 2 Veg Rice', 9, 3, 26, '1-meat-2-veg-rice.png'),
(21, '2 Meat 1 Veg Rice', 9, 4, 27, '2-meat-1-veg-rice.jpg'),
(22, '2 Meat 2 Veg Rice', 9, 5, 24, '2-meat-2-veg-rice.jpg'),
(23, 'Chicken Biryani', 10, 6, 27, 'chicken-biryani.jpg'),
(24, 'Chicken Tikka', 10, 6, 25, 'chicken-tikka.jpg'),
(25, 'Chapati Meal', 10, 8, 26, 'chapati-meal.jpg'),
(26, 'Pratta', 10, 3, 38, 'pratta.jpg'),
(27, 'Tonkatsu Black Ramen', 11, 10, 33, 'tonkatsu-black-ramen.jpg'),
(28, 'Spec Tonkatsu Ram', 11, 11, 31, 'spec-tonkatsu-ramen.jpg'),
(29, 'Beef Curry Rice', 11, 8, 37, 'beef-curry-rice.jpg'),
(30, 'Spicy Tuna Roll', 12, 4, 74, 'spicy-tuna-roll.jpg'),
(31, 'Shrimp Tempura Roll', 12, 3, 78, 'shrimp-tempura-roll.jpg'),
(32, 'Scallop Sushi', 12, 3, 76, 'Scallop-Sushi.jpg'),
(33, 'Spicy Bibim Noodles', 13, 7, 43, 'spicy-bibim-noodles.jpg'),
(34, 'Beef Bulgogi', 13, 8, 42, 'beef-bulgogi.jpg'),
(35, 'Korean Bibimbap', 13, 9, 40, 'korean-bibimbap.jpg'),
(36, 'Ken Fried Chicken', 1, 5, 20, 'Ken-fried-chicken.jpg'),
(37, 'Cheeseburger', 1, 6, 25, 'cheeseburger.jpg'),
(38, 'Carbonara', 4, 7, 23, 'carbonara.jpg'),
(39, 'Aglio Olio', 4, 8, 27, 'aglio-olio.jpeg');

-- --------------------------------------------------------

--
-- 表的结构 `food_order`
--

CREATE TABLE `food_order` (
  `id` int(11) NOT NULL,
  `food_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_quantity` int(11) NOT NULL,
  `order_time` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `food_order`
--

INSERT INTO `food_order` (`id`, `food_id`, `user_id`, `order_quantity`, `order_time`) VALUES
(24, 33, 10, 2, '2022-11-11 15:19:30'),
(25, 1, 10, 2, '2022-11-11 15:19:48'),
(26, 37, 4, 1, '2022-11-11 15:57:31'),
(27, 6, 4, 2, '2022-11-11 15:57:48'),
(28, 1, 4, 2, '2022-11-11 19:35:54'),
(29, 1, 4, 2, '2022-11-11 20:10:54'),
(30, 2, 4, 10, '2022-11-11 20:20:17'),
(31, 5, 4, 10, '2022-11-11 20:21:33');

-- --------------------------------------------------------

--
-- 表的结构 `restaurant`
--

CREATE TABLE `restaurant` (
  `id` int(11) NOT NULL,
  `rest_name` varchar(20) NOT NULL,
  `category` varchar(20) NOT NULL,
  `rating` double NOT NULL,
  `canteen` varchar(20) NOT NULL,
  `rest_image` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `restaurant`
--

INSERT INTO `restaurant` (`id`, `rest_name`, `category`, `rating`, `canteen`, `rest_image`) VALUES
(1, 'KFC', 'Western', 5, 'North Spine', 'kfc.png'),
(4, 'Pasta Express', 'Western', 5, 'South Spine', 'pasta-express.jpg'),
(5, 'Western Delight', 'Western', 5, 'North Hill', 'western-delight.jpg'),
(6, 'Route 35', 'Western', 0, 'Canteen 2', 'route-35.jpg'),
(7, 'Sichuan Zichar', 'Chinese', 0, 'Canteen 2', 'sichuan-zichar.jpg'),
(9, 'TianYiDian', 'Chinese', 0, 'North Hill', 'Tian-yi-dian.png'),
(10, 'Ananda Taj', 'Indian', 0, 'North Hill', 'Ananda-taj.png'),
(11, 'Menya Takashi', 'Japanese', 0, 'South Spine', 'Menya-Takashi.jpg'),
(12, 'GenkiSushi', 'JK', 0, 'North Spine', 'genki-sushi.jpg'),
(13, 'Paiks Bibim', 'JK', 5, 'North Spine', 'paiks-bibim.jpg');

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE `user` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `first_name` char(40) DEFAULT NULL,
  `last_name` char(40) DEFAULT NULL,
  `user_name` varchar(20) NOT NULL,
  `email` varchar(40) NOT NULL,
  `password` varchar(40) NOT NULL,
  `wallet` double NOT NULL,
  `phone` char(8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`user_id`, `first_name`, `last_name`, `user_name`, `email`, `password`, `wallet`, `phone`) VALUES
(1, 'Yiyao', 'Tang', 'tyy614401719', 'tyy614401719@gmail.com', '123456', 1000, NULL),
(2, 'Yiyao', 'Tang', 'tyy614401719', 'tyy614401719@gmail.com', '123456', 1000, NULL),
(3, 'Yiyao', 'Tang', 'tyy614401719', 'tyy614401719@gmail.com', '123456', 1000, NULL),
(4, 'Yiyao', 'Tang', 'tyy614401719', 'tyy614401719@gmail.com', '12345678', 200, NULL),
(8, 'Yiyao', 'Tang', 'tyy614401719', 'tyy614401719@gmail.com', '123456788', 38, NULL),
(10, 'yy', 'xx', 'test', 'e190', '12345678', 172, NULL);

--
-- 转储表的索引
--

--
-- 表的索引 `card`
--
ALTER TABLE `card`
  ADD PRIMARY KEY (`card_number`);

--
-- 表的索引 `food_item`
--
ALTER TABLE `food_item`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `food_order`
--
ALTER TABLE `food_order`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `restaurant`
--
ALTER TABLE `restaurant`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `food_order`
--
ALTER TABLE `food_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- 使用表AUTO_INCREMENT `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
