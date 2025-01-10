-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 06, 2025 at 08:08 AM
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
-- Database: `navratna`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `id` int(11) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `address_line_1` varchar(255) DEFAULT NULL,
  `address_line_2` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) NOT NULL,
  `postal_code` varchar(255) DEFAULT NULL,
  `landmark` varchar(255) DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`id`, `user_id`, `address_line_1`, `address_line_2`, `country`, `city`, `state`, `postal_code`, `landmark`, `phone_number`, `created_at`) VALUES
(1, '4', 'Ranchi', 'Jharkhand', 'India', 'Ranchi', 'Jharkhand', '834001', '', '1234567890', '2024-12-04 11:06:16'),
(4, '8', 'Ranchi, Jharkhand', '', 'India', 'Ranchi', 'Jharkhand', '834001', '', '9204780758', '2024-12-05 11:05:40'),
(12, '676559113fe83', 'Ranchi, Jharkhand', '', 'India', 'Ranchi', 'Jharkhand', '834001', '', '1234567890', '2024-12-20 11:47:35'),
(13, '676e8f899908c', 'Ranchi, Jharkhand', 'Jharkhand', 'India', 'Ranchi', 'Jharkhand', '834001', '', '1234567890', '2024-12-27 11:30:41');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gold_price`
--

CREATE TABLE `gold_price` (
  `id` int(11) DEFAULT NULL,
  `price_1_gram_24K` int(11) NOT NULL,
  `price_1_gram_22K` int(11) DEFAULT NULL,
  `price_1_gram_18K` int(11) NOT NULL,
  `price_1_gram_24K_s` int(11) NOT NULL DEFAULT 99,
  `making_charge_gold` decimal(10,2) NOT NULL DEFAULT 0.08,
  `making_charge_silver` int(11) NOT NULL DEFAULT 20,
  `gst_gold` decimal(10,2) NOT NULL DEFAULT 0.03
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gold_price`
--

INSERT INTO `gold_price` (`id`, `price_1_gram_24K`, `price_1_gram_22K`, `price_1_gram_18K`, `price_1_gram_24K_s`, `making_charge_gold`, `making_charge_silver`, `gst_gold`) VALUES
(1, 7892, 7195, 5887, 99, 0.08, 20, 0.03);

-- --------------------------------------------------------

--
-- Table structure for table `nav_admin`
--

CREATE TABLE `nav_admin` (
  `ad_id` varchar(255) NOT NULL,
  `ad_name` varchar(255) NOT NULL,
  `ad_email` varchar(255) NOT NULL,
  `ad_password` varchar(255) NOT NULL,
  `ad_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `ad_updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nav_admin`
--

INSERT INTO `nav_admin` (`ad_id`, `ad_name`, `ad_email`, `ad_password`, `ad_created_at`, `ad_updated_at`) VALUES
('132556', 'admin', 'admin@gmail.com', '$2y$10$gHHYyCt79wf0tPWQFM3Y7u6oGREjjPJ9OS2hk3PwAI6aWWXo1Symq', '2024-12-19 07:48:23', '2024-12-19 13:41:49'),
('6763', 'admin2', 'admin2@gmail.com', '$2y$10$HIt/Az8KrZ/7jOXrhUUO1Or6jVq7GzeE6ljnVajz1XuG1n9KzKEPi', '2024-12-19 09:46:56', '2024-12-23 14:32:07'),
('6763f229d6966', 'admin3', 'admin3@gmail.com', '$2y$10$0qzmxCRJ9LsvC9eDjm0qMuJXSIcT4BWm0ZU95XhlrpnH5kz65qTSS', '2024-12-19 10:15:06', '2024-12-19 15:45:06');

-- --------------------------------------------------------

--
-- Table structure for table `nav_version`
--

CREATE TABLE `nav_version` (
  `id` int(11) NOT NULL,
  `version` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nav_version`
--

INSERT INTO `nav_version` (`id`, `version`, `created_at`, `updated_at`) VALUES
(5465347, 1.08, '2024-12-30 09:15:35', '2025-01-04 18:33:24');

-- --------------------------------------------------------

--
-- Table structure for table `offline_cart`
--

CREATE TABLE `offline_cart` (
  `id` int(11) NOT NULL,
  `local_user_id` varchar(255) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` varchar(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `order_date` datetime DEFAULT current_timestamp(),
  `order_updateAt` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` varchar(50) DEFAULT 'pending',
  `payment_method` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id_oi` varchar(255) DEFAULT NULL,
  `product_id_oi` int(11) NOT NULL,
  `quantity_oi` int(11) NOT NULL,
  `price_oi` decimal(10,2) NOT NULL,
  `delivery_status` varchar(255) NOT NULL DEFAULT 'processing',
  `created_at_oi` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at_oi` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_details`
--

CREATE TABLE `payment_details` (
  `pd_id` int(11) NOT NULL,
  `pd_order_id` varchar(255) NOT NULL,
  `pd_payment_id` varchar(255) NOT NULL,
  `pd_verify_signature` varchar(255) NOT NULL,
  `pd_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `pd_updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `metal_type` varchar(255) NOT NULL,
  `karat` varchar(255) NOT NULL,
  `weight` decimal(10,1) NOT NULL,
  `weight_type` varchar(255) NOT NULL DEFAULT 'GRAM',
  `color` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `product_img1` varchar(255) DEFAULT NULL,
  `product_img2` varchar(255) DEFAULT NULL,
  `product_img3` varchar(255) DEFAULT NULL,
  `product_category` varchar(255) NOT NULL,
  `p_stock` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `name`, `metal_type`, `karat`, `weight`, `weight_type`, `color`, `description`, `product_img1`, `product_img2`, `product_img3`, `product_category`, `p_stock`) VALUES
(1, 'Lotus Ingot (Certipamp) 24K 1 Gram Gold Coin', 'Gold', '24K', 1.0, 'GRAM', 'Yellow', 'The Navratna Jewellers presents 999.9 purity 1g Lotus bar. Lotus flower has its roots in mud waters, the flower gets submerged into the water at night and re-blooms the next morning, sparkling clean. This stands out as a shining symbol of its incorruptible purity and longevity. It symbolizes rebirth, harmony and prosperity. The Lotus flower has significant cultural symbolism in Hinduism as well as other Eastern religions.', '/images/1gm-lotus-ingot-b.png', '/images/lotus_bar_1.webp', '/images/lotus-bar-gold-2.jpg', 'gold-coin', 1),
(9, 'Banyan Tree Ingot 10 Gram Silver Coin', 'Silver', '24K', 10.0, 'GRAM', 'Metallic Grey', 'This 10 gm silver bar symbolizes longevity and fulfillment through the depiction of Indian’s national tree, the Banyan. The banyan tree, also called ‘kalapatru’, has been a divine tree of wish-fulfilment which makes this silver coin a perfect gift to convey best wishes.', '/images/banyan-tree-purity-10-gm-silver-bar_1.webp', '/images/banyan-tree-purity-10-gm-silver-bar_2.webp', '/images/banyan-tree-purity-10-gm-silver-bar_3.webp', 'silver-coin', 1),
(12, 'Banyan Tree Ingot-Qr 50 Gram Silver Coin', 'Silver', '24K', 50.0, 'GRAM', 'Metallic Grey', 'This 50 gm silver bar symbolizes longevity and fulfillment through the depiction of Indian’s national tree, the Banyan. The banyan tree, also called ‘kalapatru’, has been a divine tree of wish-fulfilment which makes this silver coin a perfect gift to convey best wishes.', '/images/mmtc-pamp-banyan-tree-silver-ingot-bar-of-50-gram-in-9999-purity-fineness-in-certi-card.jpeg', '/images/banyan-tree-purity-10-gm-silver-bar_1.webp', '/images/banyan-tree-purity-10-gm-silver-bar_3.webp', 'silver-coin', 1),
(13, 'Ganesh Laxmi Coin Card 100 Gram Silver', 'Silver', '24K', 100.0, 'GRAM', 'Metallic Grey', 'Get 100g pure silver Lakshmi and Ganesha coin. Goddess Lakshmi on the coin represents the divine incarnation of physical beauty, fertility, luxury, and prosperity while Lord Ganesha is widely revered as the remover of obstacles and thought to bring good luck. He is also the patron of arts and sciences; and also represents intellect and wisdom. The \'Shubh-Labh\' is a prayer for good luck and the swastika being the sign of well-bringing and prosperity. ', '/images/silver_coin.jpeg', '/images/ganesh-lakshmi-ji-9999-purity-100-gm-silver-coins_1.webp', '/images/ganesh-lakshmi-ji-9999-purity-100-gm-silver-coins_5.webp', 'silver-coin', 1),
(14, 'Lotus Ingot (Certipamp) 5 Gram 24K Gold Coin', 'Gold', '24K', 5.0, 'GRAM', 'Yellow', 'The 5g gold bar is a unique piece with lotus engraved on it. This Lotus bar is ideal for gifting or for long term investments, as this one-of-a-kind design of lotus flower on an ingot bar symbolizes cosmic perfection and indicates the flowering of inner potential along with humankind’s ability to harness the flow of energy through the chakras.', '/images/lotus-gold-ingot-5-gm-front.png', '/images/lotus-gold-ingot-5-gm.png', '/images/lotus-gold-ingot-5-gm-front.png', 'gold-coin', 1),
(16, 'Lotus Bar Certicard(923) 24K 10 Gram Gold', 'Gold', '24K', 10.0, 'GRAM', 'Yellow', 'The Lotus flower symbolizes long life, honour, good fortune, triumph and purity of heart and mind and is beautifully represented in our pure gold bar. MMTC-PAMP India’s distinctive Lotus motif depicts a pair of hands holding a Lotus flower. With its clean lines, fine aesthetics, and unparalleled finish, this iconic design portrays MMTC-PAMP India’s quality and authenticity assurance. MMTC-PAMP is proud of the uniquely symbolic motifs and designs minted upon its 999.9 purest gold and silver ingots and coins. In Hinduism, the lotus flower holds special significance. For example, as per Hindu mythology, in the representation of Lord Vishnu (the Preserver) as Padmanabha), lotus issues from his navel with the Brahma (the Creator) on it.', '/images/lotus_bar_1.webp', '/images/lotus-bar-gold-2.jpg', '/images/lotus-24k-gold-bar.webp', 'gold-coin', 1),
(20, 'Lotus Round (Certipamp) 0.5 Gram Gold Coin', 'Gold', '24K', 0.5, 'GRAM', 'Yellow', 'The Lotus 0.5 g purest Gold Coin represents the divinity and symbolises cosmic perfection. Lotus flowers are roots padlocked in mud, the flower gets submerged into the water at night and re-blooms the next morning, sparkling clean. This is evident of its incorruptible purity and longevity. The powerfully emblematic Lotus also indicates the flowering of inner potential and humankind’s ability to harness the flow of energy through the chakras, which are often depicted as wheel-like Lotuses.', '/images/0-5-gm-lotus-yellow-gold-coin-mmtc-pamp.jpeg', '/images/gold-mmtc-pamp.png', '/images/0.5gm-lotus-ingot-certicard-f.png', 'gold-coin', 1),
(21, 'Lotus Bar Certicard (723) 24K 20 Gram Gold', 'Gold', '24K', 20.0, 'GRAM', 'Yellow', 'As the National Flower of India, the Lotus has been revered and beloved for millennia as a symbol of purity, health, rebirth, and spiritual enlightenment. The elegantly designed Lotus 20g gold bar offers 24 K, 999.9 purity of gold guaranteed by MMTC-PAMP.\r\n\r\nThe unmistakably elegant shape of its petals, whether coloured white or pink, give the flower its iconic form, and its associations with many divinities are renowned throughout India thanks to countless examples of beautifully rendered iconography. Even across the world, the flower is intrinsically linked to the culture and philosophy especially in Eastern religions including Jainism and Buddhism.  MMTC-PAMP Lotus 20 g gold bar design is exceptionally minted on 999.9 pure gold. Invest in this pure gold bar for securing your future or surprise a loved one with a gift that they will cherish!', '/images/lotus_bar_1.webp', '/images/lotus-24k-gold-bar.webp', '/images/lotus-bar-gold-2.jpg', 'gold-coin', 1),
(22, 'Shankh Laxmi Coin Certi-Qr 24K 20 Gram Gold Coin', 'Gold', '24K', 20.0, 'GRAM', 'Yellow', 'This symbolically rich 24k, 999.9 purest gold Shankh is precision-minted with finely etched portrayal of Goddess Lakshmi on first-of-its-kind Shankh design. From ancient times, Goddess Lakshmi has been regarded as the everlasting symbol of prosperity and well-being.  This uniquely stylised coin comes with MMTC-PAMP’s stamp of authenticity that serves as a guarantee of the highest purity and finest craftsmanship available in the world. Each gold stylized 20 gm coin comes with the promise of positive weight tolerance which is MMTC-PAMP’s commitment to all its customers that every piece of gold that you buy from us will weigh more than what is mentioned on the pack. Always.', '/images/shankh-laxmi-coin-20-gm-gold-1.png', '/images/shankh-laxmi-coin-20-gm-gold-2.jpg', '/images/shankh-laxmi-coin-20-gm-gold-1.png', 'gold-coin', 1),
(23, 'Lotus Ingot (Certipamp) 31.1 Gram Gold Coin', 'Gold', '24K', 31.1, 'GRAM', 'Yellow', 'The 1 ounce (31.1 gram) gold Lotus bar has MMTC-PAMP’s distinctive Lotus motif and is exceptionally minted on 24K, 999.9 purest gold, making it an ideal choice for investment. MMTC-PAMP products are crafted from 24K, 999.9 purest gold. Every MMTC-PAMP gold bar, including this first of its kind 31.1 gram gold bar, goes through rigorous refining and purification process so that you get the purest piece of metal, always. We strive to go beyond 999.9 to give you 999.9+ purity.', '/images/lotus-ingot-31-1-front.png', '/images/lotus-ingot-31-1.jpeg', '/images/lotus-ingot-31-1-front.png', 'gold-coin', 1),
(24, 'Lotus Minted Bar Certicard (923) 24K 100 Gram Gold', 'Gold', '24K', 100.0, 'GRAM', 'Yellow', 'The Lotus 100gram bar indicates the flowering of inner potential and humankind’s ability to harness the flow of energy through the chakras, which are often depicted as wheel-like Lotuses. Intricate designs manufactured using world’s most advanced state-of-the-art Swiss technology and unmatched craftsmanship makes MMTC-PAMP Gold beyond compare.', '/images/lotus-100g-rev-500x500.webp', '/images/lotus-24k-gold-bar.webp', '/images/lotus-bar-gold-2.jpg', 'gold-coin', 1),
(25, 'Laxmi Ganesh Round-Qr 10 Gram Silver Coin', 'Silver', '24K', 10.0, 'GRAM', 'Metallic Grey', 'MMTC-PAMP 10 Grams Lakshmi Ganesh silver coin is in 24 Karat 999.9 Purity. As the Divine Incarnation of physical beauty, fertility, luxury, and prosperity, Lakshmi is portrayed with Her four arms that together represent Cosmic Omnipotence, as well as perfection and freedom from limitations.\r\n\r\nWe see two hands hold the Lotus flowers, reflecting beauty, perfection, and rebirth, while another offers silver coins as an affirmation of enduring wealth, and finally, one open palm assures safety and protection. Ganesha bestows blessings of prosperity upon His devotees, but also, represents His power to remove obstacles from the paths of humankind.', '/images/silver_coin.jpeg', '/images/ganesh-lakshmi-ji-9999-purity-100-gm-silver-coins_1.webp', '/images/ganesh-lakshmi-ji-9999-purity-100-gm-silver-coins_5.webp', 'silver-coin', 1),
(26, 'Banyan Tree Ingot 20 Gram Silver Coin', 'Silver', '24K', 20.0, 'GRAM', 'Metallic Grey', 'This 20 gram silver bar symbolizes longevity and fulfillment through the depiction of Indian’s national tree, the Banyan. The banyan tree, also called ‘kalapatru’, has been a divine tree of wish-fulfilment which makes this silver coin a perfect gift to convey best wishes.', '/images/mmtc-pamp-banyan-tree-silver-ingot-bar-of-20-gram-in-9999-purity-fineness-in-certi-card.jpeg', '/images/banyan-tree-purity-10-gm-silver-bar_1.webp', '/images/banyan-tree-purity-10-gm-silver-bar_2.webp', 'silver-coin', 1),
(27, 'Laxmi Ganesh Round-Qr 20 Gram Silver Coin', 'Silver', '24K', 20.0, 'GRAM', 'Metallic Grey', 'Get the beautiful and auspicious Ganesh Lakshmi 20g pure silver coin to bring home purest blessings from these venerated deities from Hindu mythology. As the divine incarnation of physical beauty, fertility, luxury, and prosperity, Goddess Lakshmi is portrayed with her four arms that together represent Cosmic Omnipotence, as well as perfection and freedom from limitations.', '/images/silver_coin.jpeg', '/images/ganesh-lakshmi-ji-9999-purity-100-gm-silver-coins_1.webp', '/images/ganesh-lakshmi-ji-9999-purity-100-gm-silver-coins_5.webp', 'silver-coin', 1),
(28, 'Ganesh Laxmi Coin Card 50 Gram Silver', 'Silver', '24K', 50.0, 'GRAM', 'Metallic Grey', 'This symbolically rich 50g Ganesh Lakshmi 999.9 purity silver coin is minted with portrayals of Lakshmi and Ganesha on one side. The Swastika refers to ‘conducive to well-being’ and represents the constant rising and setting of the Sun is also minted on the coin. It is an affirmation of the start of life, particularly honoured during observances of Navagraha Pooja.', '/images/ganesh-lakshmi-ji-9999-purity-100-gm-silver-coins_1.webp', '/images/ganesh-lakshmi-ji-9999-purity-100-gm-silver-coins_5.webp', '/images/ganesh-lakshmi-ji-purity-50-gm-silver_4.webp', 'silver-coin', 1),
(29, 'Banyan Tree Ingot 100 Gram Silver', 'Silver', '24K', 100.0, 'GRAM', 'Metallic Grey', 'Get 100g pure silver Lakshmi and Ganesha coin. Goddess Lakshmi on the coin represents the divine incarnation of physical beauty, fertility, luxury, and prosperity while Lord Ganesha is widely revered as the remover of obstacles and thought to bring good luck. He is also the patron of arts and sciences; and also represents intellect and wisdom. The \'Shubh-Labh\' is a prayer for good luck and the swastika being the sign of well-bringing and prosperity. ', '/images/lotus-100g-rev-500x500.webp', '/images/ganesh-lakshmi-ji-9999-purity-100-gm-silver-coins_5.webp', '/images/ganesh-lakshmi-ji-purity-50-gm-silver_4.webp', 'silver-coin', 1),
(30, 'Banyan Tree Bar 250 Gram Silver', 'Silver', '24K', 250.0, 'GRAM', 'Metallic Grey', 'This 250 gm silver bar symbolizes longevity and fulfillment through the depiction of Indian’s national tree, the Banyan. The banyan tree, also called ‘kalapatru’, has been a divine tree of wish-fulfilment which makes this silver coin a perfect gift to convey best wishes.', '/images/mmtc-pamp-banyan-tree-silver-bar-of-250-gram-in-9999-purity-fineness.jpeg', '/images/banyan-tree-purity-10-gm-silver-bar_1.webp', '/images/banyan-tree-purity-10-gm-silver-bar_2.webp', 'silver-coin', 1),
(31, 'Casted Bar 500 Gram Silver', 'Silver', '24K', 500.0, 'GRAM', 'Metallic Grey', 'MMTC-PAMP silver cast bars come with 999 purity and with a weight of 500 g+ as we assure positive weight tolerance on each of our minted products. This is an MMTC-PAMP guarantee that every minted product will offer more than the listed weight, ensuring you always get the best value for your money.\r\n\r\nThe rectangular silver cast is beautifully designed, and it can be presented as a token of blessings to someone special or purchased as a safe investment. Crafted using world-class refining technology from our partner PAMP, every 500 g MMTC-PAMP Silver cast bar is encased in an elegant Blue buttoned box making it ideal for gifting. As an investment, pure silver is considered as a safe option by most financial experts across the globe. Our 500 g silver cast bar is precisely minted with decorative details and comes with its own certificate. The global standard for the highest purities of both gold and silver products is designated as 999 fine. MMTC-PAMP products are made using the world’s most state-of-the-art Swiss technology that gives you guaranteed quality.', '/images/500gm-cast-bars.webp', '/images/500gm-casted-bar-box.webp', '/images/500gm-cast-bars.webp', 'silver-coin', 1),
(32, 'Casted Bar 1000 Gram Silver', 'Silver', '24K', 1000.0, 'GRAM', 'Metallic Grey', 'MMTC-PAMP 1kg silver cast bars come with 999 purity and with a weight of 1000 g+ as we assure positive weight tolerance on each of our minted products. This is an MMTC-PAMP guarantee that every minted product will offer more than the listed weight, ensuring you always get the best value for your money.', '/images/1kg-silver-bar-new-3-1.webp', '/images/1kg-cast-bar-box-2.webp', '/images/1kg-silver-bar-new-3-1.webp', 'silver-coin', 1),
(33, 'Ram Lalla Bar Colored Certicard (Box) 50 Gram Silver', 'Silver', '24K', 50.0, 'GRAM', 'Metallic Grey', 'Lord Ram holds immense significance for millions of devotees worldwide. Revered as the seventh incarnation of Lord Vishnu, Lord Ram is celebrated for righteousness, justice, and moral integrity. His epic journey, as chronicled in the revered scripture Ramayana, serves as a timeless testament to the triumph of good over evil and the enduring power of faith and devotion.\r\n\r\nMMTC-PAMP\'s Ram Lalla Silver bar embodies the essence of this sacred occasion, offering devotees a tangible symbol of their faith and devotion. Meticulously crafted to the highest standards on purest silver with 99.99+% purity, customers can cherish the authenticity and value of each bar. The Ram Lalla Silver Bar is a timeless symbol of devotion and spirituality, making it an ideal and cherished memento which can be passed down generations.', '/images/ram-lalla-9999-purity-50-gm-silver-bars_1.webp', '/images/ram-lalla-purity-50-gm-silver-bars_3-1.webp', '/images/ram-lalla-purity-50-gm-silver-bars_5-1.webp', 'silver-coin', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL DEFAULT 'NOT NULL',
  `password` varchar(255) NOT NULL DEFAULT 'NOT NULL',
  `email` varchar(255) NOT NULL DEFAULT 'NOT NULL',
  `session_id` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `session_id`, `created_at`, `updated_at`) VALUES
('1', 'san', '$2y$10$tMiYyJ.MB1.60vrE.NMx8.cux5iMtkzWwvkBrxbF7lGuugW.qhgHG', 'NOT NULL', NULL, '2024-11-25 08:12:33', '2024-11-25 13:42:33'),
('2', 'admin', 'admin', 'admin@gmail.com', NULL, '2024-11-25 08:12:33', '2024-11-25 13:42:33'),
('3', 'new admin', '$2y$10$HcPH9aMC.Zf1mNvaBO9iCu0gKYQUmD6PpNkJntiPWY1Bjcdvn.niS', 'adm@gmail.com', '5ef2529231099fa39cabcb46f8b6769381794bf8ff25a5641a7f86f94e9d5d74', '2024-11-25 08:12:33', '2024-12-11 12:36:07'),
('4', 'demo', '$2y$10$gHHYyCt79wf0tPWQFM3Y7u6oGREjjPJ9OS2hk3PwAI6aWWXo1Symq', 'demo@gmail.com', '87fe72d4ecf1d031f3b717936f9944e99ceb6740e81245c1c49dd1af3e60f3ea', '2024-11-25 08:12:33', '2025-01-03 12:34:30'),
('6759445', 'Raj Singh', '$2y$10$wQ7q2jno/P2QXbBAxKNGhOknznwVoIQ8tltm4BCa/gyzUVQ7nEzuK', 'raj@gmail.com', '15a9b080b1e470c9529eaf8730f554e7a8f3273e53f969ac0264052b0fc40191', '2024-12-11 07:50:53', '2024-12-11 13:21:30'),
('676559113fe83', 'demo 4', '$2y$10$UYHRP2CahIYrU5A6TH2UkuH12pe7KTZJza5OVWYD0a1dTL3xkOIOq', 'demo4@gmail.com', '96bc1a2b7ad3496e95938fbd1afa063ae72880f71e9bf82d34ae52f0272fe49f', '2024-12-20 11:46:25', '2024-12-23 16:50:32'),
('676e8f899908c', 'navratna', '$2y$10$TwMVQsRM0d7P0HfY8khWB.Pxv3apFpa3HA.PBezi646YQVSCML3Ge', 'navratnajewellers0@gmail.com', '9f81c5b02341b6840a8715d42ca39c8aa51d88caaed8411fe9b05d9980786bd0', '2024-12-27 11:29:13', '2024-12-28 14:54:15'),
('8', 'demo', '$2y$10$sh2GKimjHUhd5dcYVOi9Aud2LBNsElq4wrNDryjf4WyuLIAxq0JPC', 'demo1@gmail.com', 'bfb0af304bcfdcd1de5dfd6ab885ae520e6ad6b7cfaa8a44c234c8c10827ef87', '2024-11-25 09:08:55', '2024-12-05 16:34:35');

-- --------------------------------------------------------

--
-- Table structure for table `website_update`
--

CREATE TABLE `website_update` (
  `id` int(11) NOT NULL,
  `update_status` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `website_update`
--

INSERT INTO `website_update` (`id`, `update_status`) VALUES
(1, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id_2` (`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `gold_price`
--
ALTER TABLE `gold_price`
  ADD PRIMARY KEY (`price_1_gram_24K`);

--
-- Indexes for table `nav_admin`
--
ALTER TABLE `nav_admin`
  ADD PRIMARY KEY (`ad_id`),
  ADD UNIQUE KEY `ad_email` (`ad_email`);

--
-- Indexes for table `nav_version`
--
ALTER TABLE `nav_version`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offline_cart`
--
ALTER TABLE `offline_cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `local_user_id` (`local_user_id`) USING BTREE;

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id_oi` (`order_id_oi`),
  ADD KEY `product_id_oi` (`product_id_oi`);

--
-- Indexes for table `payment_details`
--
ALTER TABLE `payment_details`
  ADD PRIMARY KEY (`pd_id`),
  ADD KEY `pd_order_id` (`pd_order_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `website_update`
--
ALTER TABLE `website_update`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `offline_cart`
--
ALTER TABLE `offline_cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `payment_details`
--
ALTER TABLE `payment_details`
  MODIFY `pd_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `website_update`
--
ALTER TABLE `website_update`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`);

--
-- Constraints for table `offline_cart`
--
ALTER TABLE `offline_cart`
  ADD CONSTRAINT `offline_cart_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id_oi`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id_oi`) REFERENCES `product` (`product_id`);

--
-- Constraints for table `payment_details`
--
ALTER TABLE `payment_details`
  ADD CONSTRAINT `payment_details_ibfk_1` FOREIGN KEY (`pd_order_id`) REFERENCES `orders` (`order_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
