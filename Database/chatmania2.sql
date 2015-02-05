-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 27, 2014 at 09:53 PM
-- Server version: 5.5.32
-- PHP Version: 5.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--


-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL,
  `Username` varchar(200) DEFAULT NULL,
  `Email` varchar(100) NOT NULL,
  `Password` varchar(200) DEFAULT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `Username`, `Email`, `Password`) VALUES
(0, 'admin', 'admin100@yahoo.com', 'admin100');

-- --------------------------------------------------------

--
-- Table structure for table `chatrooms`
--

CREATE TABLE IF NOT EXISTS `chatrooms` (
  `id` int(11) NOT NULL,
  `Name` varchar(200) DEFAULT NULL,
  `Description` text,
  `ImgSmall` varchar(100) DEFAULT NULL,
  `ImgLarge` varchar(100) DEFAULT NULL,
  UNIQUE KEY `Name` (`Name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `chatrooms`
--

INSERT INTO `chatrooms` (`id`, `Name`, `Description`, `ImgSmall`, `ImgLarge`) VALUES
(111, 'Business / Politics', 'Chat with other entrepreneurs and get great business ideas. If you have a great business idea or experience why not share it with others.', 'Images/SmallBackgrounds/business-313592_640.jpg', 'Images/LargeBackgrounds/business-313592_1280.jpg'),
(112, 'Football', 'Chat with other football fans. Make friends that share the same interests in football as you do.', 'Images/SmallBackgrounds/soccer-349821_640.jpg', 'Images/LargeBackgrounds/soccer-349821_1280.jpg'),
(113, 'Science & Tech', 'Chat with others about the latest technologies and gadgets meet others that share the same interests in science as you do.', 'Images/SmallBackgrounds/flash-113310_640.jpg', 'Images/LargeBackgrounds/flash-113310_1280.jpg'),
(114, 'Teen Chat', 'Meet other teens in this chat room. Join the conversation or just share whatever is on your mind.', 'Images/SmallBackgrounds/freedom-307791_640.png', 'Images/LargeBackgrounds/freedom-307791_1280.png'),
(116, 'Jesus Chat', 'Chat with friends about God and Christian living.', 'Images/SmallBackgrounds/sky-49520_640.jpg', 'Images/LargeBackgrounds/sky-49520_1280.jpg'),
(117, 'Food', 'Have any dishes that you want to share with others? Well this is a great place to start.', 'Images/SmallBackgrounds/peas-2686_640.jpg', 'Images/LargeBackgrounds/peas-2686_1280.jpg'),
(118, 'Life', 'Chat with others about nature.', 'Images/SmallBackgrounds/horse-301257_640.jpg', 'Images/LargeBackgrounds/horse-301257_1280.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `chatroom_messages`
--

CREATE TABLE IF NOT EXISTS `chatroom_messages` (
  `id` int(11) NOT NULL,
  `User` varchar(100) DEFAULT NULL,
  `chatroom` varchar(200) DEFAULT NULL,
  `Message` varchar(100) DEFAULT NULL,
  `Time` datetime DEFAULT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `chatroom_messages`
--

INSERT INTO `chatroom_messages` (`id`, `User`, `chatroom`, `Message`, `Time`) VALUES
(0, 'winner', '112', 'hello', '2014-08-06 03:02:19'),
(30, 'mikey', '111', 'heh', '2014-06-26 16:56:38'),
(83252, 'wobbly', '114', 'ha im first', '2014-08-17 06:08:30'),
(95337, 'marcus garvey', '112', 'heyy im margus the garvey', '2014-08-08 18:01:25'),
(115173, 'BoyJosh', '113', ' try a what happen to you', '2014-06-26 03:25:59'),
(117920, 'shrillex', '112', 'tessssstttttttttttinggggggg', '2014-08-06 06:18:48'),
(136657, 'micky', '113', 'hi everyone', '2014-06-30 22:08:44'),
(137359, 'hola', '113', 'fail', '2014-07-20 23:35:21'),
(140533, 'josh', '111', 'more what', '2014-08-02 17:32:32'),
(142852, 'micro', '112', 'finally it works', '2014-08-06 08:04:09'),
(146820, 'john123', '111', 'hello world', '2014-08-17 05:44:11'),
(185821, 'winner', '114', 'yep', '2014-08-06 03:01:11'),
(190887, 'nina', '112', 'ok then', '2014-07-16 05:27:23'),
(198456, 'BoyJosh', '113', ' try a what happen to you', '2014-06-26 03:24:44'),
(198517, 'BoyJosh', '113', 'easy nuh cheesy u nuh si seh mi a try a what happen to you', '2014-06-26 03:13:38'),
(199707, 'boby', '112', 'see the rhyme', '2014-08-10 02:41:07'),
(200409, 'marco', '111', 'woooow', '2014-08-02 16:13:50'),
(208893, 'sjusnsh', '113', 'hehe', '2014-06-26 02:09:20'),
(222656, 'BoyJosh', '113', 'ha', '2014-06-26 03:30:45'),
(252441, 'joker', '111', 'mikey get a life', '2014-07-06 21:40:39'),
(261719, 'marco', '111', 'i think we need more', '2014-08-02 17:32:14'),
(273590, 'john123', '111', 'ha', '2014-08-17 06:06:53'),
(315674, 'tomlinson', '113', 'yrp', '2014-06-26 03:18:05'),
(326019, 'john123', '112', 'im here', '2014-08-16 20:43:27'),
(387085, 'micky', '113', 'yeh i know my image is weird', '2014-06-30 23:38:52'),
(391235, 'sjusnsh', '113', 'hehe', '2014-06-26 02:08:12'),
(404480, 'mojojojo:)', '113', 'hello', '2014-07-12 02:15:24'),
(424225, 'feedo', '111', 'me too', '2014-08-21 23:10:00'),
(426453, 'wobbly', '111', 'hi im new here', '2014-08-17 06:26:05'),
(432312, 'shrillex', '112', 'but first', '2014-08-06 06:51:49'),
(442047, 'nina', '112', 'yea im the first', '2014-07-14 23:17:52'),
(444672, 'micro', '112', 'whats my name', '2014-08-07 03:50:25'),
(446472, 'wite', '113', 'nuero', '2014-06-26 03:23:53'),
(449188, 'hola', '111', 'tessssssss', '2014-07-20 19:44:50'),
(453369, 'mojojojo:)', '113', 'hello', '2014-07-12 02:14:15'),
(466858, 'nico', '111', 'me too', '2014-06-26 16:56:15'),
(486328, 'BoyJosh', '113', 'tes5', '2014-06-26 02:13:58'),
(488983, 'shrillex', '112', 'floyd u there?', '2014-08-07 03:47:49'),
(492981, 'shrillex', '112', 'yep it does', '2014-08-06 08:04:27'),
(502319, 'mow', '113', 'yep', '2014-07-14 00:21:56'),
(513245, 'BoyJosh', '113', 'ha', '2014-06-26 03:30:23'),
(514618, 'nina', '112', 'hola espaniol', '2014-07-16 00:40:25'),
(521942, 'mona', '111', 'he', '2014-09-27 21:37:21'),
(549713, 'mojojojo:)', '113', 'mojo in da buildin!!!!', '2014-07-12 02:11:06'),
(564087, 'mojojojo:)', '113', 'mojo in da buildin!!!!', '2014-07-12 02:10:54'),
(587555, 'BoyJosh', '111', 'yep', '2014-06-26 04:37:09'),
(602295, 'mojojojo:)', '113', 'mojo in da buildin!!!!', '2014-07-12 02:11:32'),
(625397, 'nila', '111', 'yep jus testing', '2014-06-26 16:55:54'),
(646271, 'tomlinson', '113', '...', '2014-06-26 03:36:18'),
(658600, 'BoyJosh', '113', 'haha', '2014-06-26 02:09:13'),
(668976, 'mojojojo:)', '113', 'hello', '2014-07-12 02:14:57'),
(686127, 'jayd', '112', 'its joyd', '2014-08-07 03:48:20'),
(692383, 'mona', '112', 'futbul', '2014-09-27 21:50:02'),
(697602, 'joker', '113', 'teee', '2014-07-06 21:57:29'),
(698944, 'hola', '113', 'ha im a beer', '2014-07-18 23:38:42'),
(728882, 'hola', '113', 'fail', '2014-07-20 23:34:53'),
(731232, 'nina', '113', 'yellow', '2014-07-17 05:16:20'),
(734284, 'marcus garvey', '113', 'hhhheeeeeyyyy', '2014-08-08 22:01:33'),
(734467, 'josh', '111', 'I am goin anyone else', '2014-08-02 17:31:51'),
(747223, 'tim''s', '111', 'tst', '2014-08-30 06:47:13'),
(756531, 'joker', '113', 'just testing how long my comment can be yep u heard me right hahaha i got dis hahaha', '2014-07-07 18:32:34'),
(768402, 'mow', '111', 'hey mo in da buildin!!', '2014-07-14 00:00:08'),
(774048, 'wite', '113', 'nueronio', '2014-06-26 03:25:27'),
(789154, 'BoyJosh', '113', 'ha', '2014-06-26 03:30:25'),
(825013, 'blobber', '112', 'hola', '2014-08-16 18:46:03'),
(826325, 'shrillex', '112', 'yep', '2014-08-06 03:18:46'),
(846283, 'boby', '112', 'go ahead dummy', '2014-08-10 02:40:54'),
(855011, 'shrillex', '112', 'but first', '2014-08-06 06:51:47'),
(866761, 'marco', '111', 'people ofcourse!', '2014-08-02 17:32:47'),
(872467, 'shrillex', '112', 'yesss', '2014-08-06 07:50:36'),
(882477, 'mojojojo:)', '111', 'yellpppp', '2014-07-12 02:17:14'),
(894806, 'boby', '112', 'ENTER TEXT', '2014-08-10 02:41:30'),
(904999, 'shrillex', '112', 'shlet me take a selfierillex', '2014-08-06 06:53:14'),
(914734, 'winner', '112', 'heeeee', '2014-08-06 03:10:08'),
(920014, 'ben', '113', 'what', '2014-06-26 02:13:37'),
(932068, 'joker', '113', 'esdr', '2014-07-06 22:22:30'),
(934845, 'BoyJosh', '113', 're', '2014-06-26 03:59:41'),
(935456, 'wite', '113', 'clip', '2014-06-26 03:26:18'),
(948609, 'BoyJosh', '111', 'test', '2014-06-26 04:36:53'),
(955414, 'jayd', '112', 'not for me though', '2014-08-06 08:05:04'),
(967347, 'mojojojo:)', '113', 'aw', '2014-07-12 02:11:58'),
(977234, 'joshh', '112', 'yep', '2014-08-17 06:49:25'),
(986939, 'marco', '111', 'game of thrones will be out soon so who is going to the movies this weekend?', '2014-08-02 17:29:19'),
(999451, 'BoyJosh', '113', 'easy nuh cheesy u nuh si seh mi a try a what happen to you', '2014-06-26 03:16:04');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `From` varchar(100) NOT NULL,
  `Subject` varchar(500) NOT NULL,
  `Body` text NOT NULL,
  `Date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `Name`, `From`, `Subject`, `Body`, `Date`) VALUES
(8, 'John Thomas', 'Johnthomas@hotmail.com', 'Request', 'Hi,\r\n  I am John from john''s palace.com and I was just wondering if you would like to engage in a link exchange with me.\r\n\r\nSincerely,\r\nJ.Thomas', '2014-08-15 00:00:00'),
(11, 'John Thomas', 'Johnthomas@hotmail.com', 'Request', 'Hi,\r\n  I am John from john''s palace.com and I was just wondering if you would like to engage in a link exchange with me.\r\n\r\nSincerely,\r\nJ.Thomas', '2014-08-15 03:47:21');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL,
  `SiteTitle` varchar(100) DEFAULT NULL,
  `SiteDescription` text,
  `SiteBackground` varchar(200) DEFAULT NULL,
  `About` text,
  `Contact` text,
  `AdsCode` text NOT NULL,
  `AdsCodeH` text NOT NULL,
  UNIQUE KEY `SiteTitle` (`SiteTitle`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `SiteTitle`, `SiteDescription`, `SiteBackground`, `About`, `Contact`, `AdsCode`, `AdsCodeH`) VALUES
(0, 'Chat#Mania', 'Chat Free No Signup Required', 'Images/LargeBackgrounds/vertical_cloth.png', 'Chat mania is a website where you can chat with friends online free. No signup is required, just select a chatroom enter your name and start chatting. It is that simple. You can also meet others with similar interests and start a conversation. You can start by visiting the homepage and choosing a chatroom.', 'You can use the form below to #contact us or via email myemail[at]yahoo.com', '<script async="" src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>\r\n<!-- ChatMania -->\r\n<ins class="adsbygoogle" style="display:inline-block;width:160px;height:600px" data-ad-client="ca-pub-0683450570603821" data-ad-slot="8658039109"></ins>\r\n<script>\r\n(adsbygoogle = window.adsbygoogle || []).push({});\r\n</script>', '');

-- --------------------------------------------------------

--
-- Table structure for table `stats`
--

CREATE TABLE IF NOT EXISTS `stats` (
  `Date` date NOT NULL,
  `Count` int(11) NOT NULL,
  UNIQUE KEY `Date` (`Date`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stats`
--

INSERT INTO `stats` (`Date`, `Count`) VALUES
('2014-05-03', 2),
('2014-06-05', 9),
('2014-07-02', 4),
('2014-07-16', 5),
('2014-08-01', 2),
('2014-08-04', 3),
('2014-08-07', 7),
('2014-08-08', 23),
('2014-08-09', 14),
('2014-08-10', 3),
('2014-08-12', 1),
('2014-08-15', 4),
('2014-08-16', 44),
('2014-08-17', 30),
('2014-08-19', 12),
('2014-08-20', 52),
('2014-08-21', 13),
('2014-08-22', 6),
('2014-08-23', 4),
('2014-08-24', 12),
('2014-08-25', 8),
('2014-08-27', 1),
('2014-08-30', 3),
('2014-09-26', 5),
('2014-09-27', 86);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `Name` varchar(100) DEFAULT NULL,
  `Password` varchar(100) NOT NULL,
  `Sex` varchar(2) NOT NULL,
  `LoginDate` datetime NOT NULL,
  `lastDetected` datetime DEFAULT NULL,
  `Image` varchar(100) DEFAULT NULL,
  `CurrentRoom` int(11) NOT NULL,
  UNIQUE KEY `Name` (`Name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`Name`, `Password`, `Sex`, `LoginDate`, `lastDetected`, `Image`, `CurrentRoom`) VALUES
('kevoy', 'sdf675sa', 'M', '0000-00-00 00:00:00', '2014-06-24 04:32:05', 'chef-icon.png', 111),
('Thompson', 'sdf675sa', 'F', '0000-00-00 00:00:00', '2014-06-24 04:40:16', 'cowboy-icon.png', 112),
('Satchel', 'sdf675sa', 'M', '0000-00-00 00:00:00', '2014-06-24 04:41:03', 'cop-icon.png', 112),
('Antwon', 'sdf675sa', 'M', '0000-00-00 00:00:00', '2014-06-24 04:43:44', 'cowboy-icon.png', 112),
('Antonio', 'sdf675sa', 'M', '0000-00-00 00:00:00', '2014-06-25 03:05:56', 'chef-icon.png', 112),
('sashabell', 'sdf675sa', 'M', '0000-00-00 00:00:00', '2014-06-25 03:06:56', 'cowboy-icon.png', 112),
('Montey', 'sdf675sa', 'F', '0000-00-00 00:00:00', '2014-06-25 03:08:47', 'cowboy-icon.png', 112),
('kenieta', 'sdf675sa', 'F', '0000-00-00 00:00:00', '2014-06-25 03:47:42', 'cowboy-icon.png', 112),
('thetst', 'sdf675sa', 'M', '0000-00-00 00:00:00', '2014-06-25 20:23:35', 'cowboy-icon.png', 112),
('oj', 'sdf675sa', 'M', '0000-00-00 00:00:00', '2014-06-26 00:10:36', 'cowboy-icon.png', 112),
('BoyJosh', 'sdf675sa', 'M', '0000-00-00 00:00:00', '2014-06-26 01:33:30', 'chef-icon.png', 112),
('sjusnsh', 'sdf675sa', 'M', '0000-00-00 00:00:00', '2014-06-26 02:04:02', 'cop-icon.png', 112),
('ben', 'sdf675sa', 'M', '0000-00-00 00:00:00', '2014-06-26 02:13:12', 'cop-icon.png', 112),
('nicky', 'sdf675sa', 'M', '0000-00-00 00:00:00', '2014-06-26 02:17:04', 'cop-icon.png', 112),
('tomlinson', 'sdf675sa', 'M', '0000-00-00 00:00:00', '2014-06-26 03:16:33', 'cop-icon.png', 112),
('money', 'sdf675sa', 'M', '0000-00-00 00:00:00', '2014-06-26 03:21:50', 'cop-icon.png', 112),
('wite', 'sdf675sa', 'M', '0000-00-00 00:00:00', '2014-06-26 03:23:18', 'doctor-icon.png', 112),
('mikey', 'sdf675sa', 'M', '0000-00-00 00:00:00', '2014-06-26 07:44:23', 'Asian boss.png', 112),
('nico', 'sdf675sa', 'M', '0000-00-00 00:00:00', '2014-06-26 16:54:43', 'Khrushchev_256x256.png', 112),
('nila', 'sdf675sa', 'F', '0000-00-00 00:00:00', '2014-06-26 16:55:25', 'serduchka128.png', 112),
('mconell', 'sdf675sa', 'M', '0000-00-00 00:00:00', '2014-06-28 04:17:23', 'Judge.png', 112),
('micky', 'sdf675sa', 'F', '0000-00-00 00:00:00', '2014-06-30 22:07:57', 'clown_64x64.png', 112),
('joker', 'sdf675sa', 'M', '0000-00-00 00:00:00', '2014-07-06 21:26:22', 'nurse_128.png', 112),
('mow', 'sdf675sa', 'M', '2014-07-13 23:57:23', '2014-07-13 23:57:23', 'dandy_128.png', 111),
('nina', 'sdf675sa', 'F', '2014-07-14 23:17:14', '2014-07-14 23:17:14', 'displeased_64x64.png', 113),
('hola', 'sdf675sa', 'M', '2014-07-18 23:38:20', '2014-07-18 23:38:20', 'Panda_128x128.png', 113),
('marco', 'sdf675sa', 'M', '2014-08-02 16:13:21', '2014-08-02 16:13:21', 'nun_128.png', 111),
('josh', 'sdf675sa', 'M', '2014-08-02 17:30:24', '2014-08-02 17:30:24', 'fitness.png', 111),
('shrillex', 'sdf675sa', 'M', '2014-08-06 03:10:44', '2014-08-06 03:10:44', 'bows.png', 112),
('jayd', 'sdf675sa', 'M', '2014-08-06 07:56:08', '2014-08-06 07:56:08', 'Elephant_128x128.png', 112),
('micro', 'sdf675sa', 'M', '2014-08-06 07:56:43', '2014-08-06 07:56:43', 'happy_64x64.png', 112),
('marcus garvey', 'sdf675sa', 'M', '2014-08-08 17:55:03', '2014-08-08 17:55:03', 'Security guard.png', 113),
('boby', 'sdf675sa', 'M', '2014-08-10 01:57:18', '2014-08-10 01:57:18', 'displeased_64x64.png', 112),
('blobber', 'sdf675sa', 'M', '2014-08-16 18:37:43', '2014-08-16 18:46:03', 'Army officer.png', 112),
('john', 'sdf675sa', 'M', '2014-08-16 20:38:14', '2014-08-16 20:38:14', 'Global manager.png', 116),
('john123', 'sdf675sa', 'F', '2014-08-16 20:40:32', '2014-08-17 06:06:53', 'holmes128.png', 111),
('wobbly', 'sdf675sa', 'M', '2014-08-17 06:08:15', '2014-08-17 06:26:05', 'monroe128.png', 111),
('joshh', 'sdf675sa', 'M', '2014-08-17 06:48:34', '2014-08-17 06:49:25', 'displeased_64x64.png', 112),
('mikey2', 'sdf675sa', 'M', '2014-08-17 06:54:53', '2014-08-17 06:54:53', 'poodle.png', 112),
('feedo', 'sdf675sa', 'M', '2014-08-21 23:09:44', '2014-08-21 23:10:00', 'aphrodite_128.png', 111),
('clippers', 'sdf675sa', 'M', '2014-08-22 01:48:06', '2014-08-22 01:48:06', 'terminator_64x64.png', 112),
('mona', 'garbagecollecter', 'F', '2014-09-27 21:37:08', '2014-09-27 21:50:02', 'cool_64x64.png', 112);

-- --------------------------------------------------------

--
-- Table structure for table `user_messages`
--

CREATE TABLE IF NOT EXISTS `user_messages` (
  `Sender` varchar(100) DEFAULT NULL,
  `Receiver` varchar(100) DEFAULT NULL,
  `Message` varchar(100) DEFAULT NULL,
  `Time` datetime DEFAULT NULL,
  `MessageRead` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
