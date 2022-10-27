-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 27, 2022 at 01:49 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u19048263`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `uID` int(11) NOT NULL,
  `eID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `eName` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `eDescription` varchar(265) COLLATE utf8mb4_unicode_ci NOT NULL,
  `eDate` date NOT NULL,
  `eTime` time NOT NULL,
  `eLocation` int(11) NOT NULL,
  `eLevel` int(11) NOT NULL,
  `eReward` double NOT NULL,
  `eThumbnail` int(11) NOT NULL,
  `deleted` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `eName`, `eDescription`, `eDate`, `eTime`, `eLocation`, `eLevel`, `eReward`, `eThumbnail`, `deleted`) VALUES
(45, 'Epic Cat Hunt', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', '2022-10-27', '12:40:00', 29, 8, 1, 18, NULL),
(46, 'Spider Extermination', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', '2022-10-28', '13:27:00', 29, 1, 2, 19, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `event_gallery`
--

CREATE TABLE `event_gallery` (
  `id` int(11) NOT NULL,
  `galleryID` int(11) NOT NULL,
  `externID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event_level`
--

CREATE TABLE `event_level` (
  `id` int(11) NOT NULL,
  `levelID` int(11) NOT NULL,
  `eID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event_list`
--

CREATE TABLE `event_list` (
  `id` int(11) NOT NULL,
  `listID` int(11) NOT NULL,
  `eID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event_location`
--

CREATE TABLE `event_location` (
  `id` int(11) NOT NULL,
  `eID` int(11) NOT NULL,
  `locationID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event_monster`
--

CREATE TABLE `event_monster` (
  `id` int(11) NOT NULL,
  `mID` int(11) NOT NULL,
  `eID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `event_monster`
--

INSERT INTO `event_monster` (`id`, `mID`, `eID`) VALUES
(9, 131, 45),
(10, 140, 46);

-- --------------------------------------------------------

--
-- Table structure for table `event_ratings`
--

CREATE TABLE `event_ratings` (
  `id` int(11) NOT NULL,
  `ratingID` int(11) NOT NULL,
  `eID` int(11) NOT NULL,
  `uID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event_reviews`
--

CREATE TABLE `event_reviews` (
  `id` int(11) NOT NULL,
  `reviewID` int(11) NOT NULL,
  `eID` int(11) NOT NULL,
  `uID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `id` int(11) NOT NULL,
  `imagePath` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`id`, `imagePath`) VALUES
(33, '../../../gallery/1666867266.png'),
(34, '../../../gallery/1666870063.png');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `gName` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `group_messages`
--

CREATE TABLE `group_messages` (
  `id` int(11) NOT NULL,
  `messageID` int(11) NOT NULL,
  `uID` int(11) NOT NULL,
  `gID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `group_users`
--

CREATE TABLE `group_users` (
  `id` int(11) NOT NULL,
  `gID` int(11) NOT NULL,
  `uID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `level`
--

CREATE TABLE `level` (
  `id` int(11) NOT NULL,
  `Level` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `level`
--

INSERT INTO `level` (`id`, `Level`) VALUES
(1, 'SS'),
(2, 'S'),
(3, 'A'),
(4, 'B'),
(5, 'C'),
(6, 'D'),
(7, 'E'),
(8, 'F');

-- --------------------------------------------------------

--
-- Table structure for table `level_monsters`
--

CREATE TABLE `level_monsters` (
  `id` int(11) NOT NULL,
  `monsterID` int(11) NOT NULL,
  `levelID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lists`
--

CREATE TABLE `lists` (
  `id` int(11) NOT NULL,
  `lName` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `id` int(11) NOT NULL,
  `cID` int(11) NOT NULL,
  `tID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`id`, `cID`, `tID`) VALUES
(29, 22, 7);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `mText` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mTime` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `monsters`
--

CREATE TABLE `monsters` (
  `id` int(11) NOT NULL,
  `mName` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mLevel` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `monsters`
--

INSERT INTO `monsters` (`id`, `mName`, `mLevel`) VALUES
(1, 'Aboleth', 'SS'),
(2, 'Adult Dragon', 'SS'),
(3, 'Ancient Dragon', 'SS'),
(4, 'Androsphinx', 'SS'),
(5, 'Death Tyrant', 'SS'),
(6, 'Demilich', 'SS'),
(7, 'Empyrean', 'SS'),
(8, 'Gynosphinx', 'SS'),
(9, 'Kraken', 'SS'),
(10, 'Lich', 'SS'),
(11, 'Mummy Lord', 'SS'),
(12, 'Solar', 'SS'),
(13, 'Tarrasque', 'SS'),
(14, 'Unicorn', 'SS'),
(15, 'Vampire', 'SS'),
(16, 'Abominable Yeti', 'S'),
(17, 'Ankylosaurus', 'S'),
(18, 'Awakened Tree', 'S'),
(19, 'Balor', 'S'),
(20, 'Behir', 'S'),
(21, 'Cloud Giant', 'S'),
(22, 'Cyclops', 'S'),
(23, 'Elephant', 'S'),
(24, 'Fire Giant', 'S'),
(25, 'Fomorian', 'S'),
(26, 'Frost Giant', 'S'),
(27, 'Giant Ape', 'S'),
(28, 'Giant Constrictor Snake', 'S'),
(29, 'Giant Crocodile', 'S'),
(30, 'Giant Elk', 'S'),
(31, 'Giant Shark', 'S'),
(32, 'Goristro', 'S'),
(33, 'Hill Giant', 'S'),
(34, 'Hydra', 'S'),
(35, 'Killer Whale', 'S'),
(36, 'Mammoth', 'S'),
(37, 'Remorhaz', 'S'),
(38, 'Stone Giant', 'S'),
(39, 'Storm Giant', 'S'),
(40, 'Treant', 'S'),
(41, 'Triceratops', 'S'),
(42, 'Tyrannosaurus Rex', 'S'),
(43, 'Ankheg', 'S'),
(44, 'Axe Beak', 'A'),
(45, 'Barlgura', 'A'),
(46, 'Beholder Zombie', 'A'),
(47, 'Black Pudding', 'A'),
(48, 'Blue Slaad', 'A'),
(49, 'Bone Devil', 'A'),
(50, 'Bulette', 'A'),
(51, 'Carrion Crawler', 'A'),
(52, 'Centaur', 'A'),
(53, 'Chasme', 'A'),
(54, 'Chimera', 'A'),
(55, 'Dire Wolf', 'A'),
(56, 'Djinni', 'A'),
(57, 'Gelatinous Cube', 'A'),
(58, 'Gorgon', 'A'),
(59, 'Half-Ogre', 'A'),
(60, 'Minotaur Skeleton', 'A'),
(61, 'Ogre Zombie', 'A'),
(62, 'Troll', 'A'),
(63, 'Young Dragon', 'A'),
(64, 'Animated Armor', 'A'),
(65, 'Assassin', 'B'),
(66, 'Bandit Captain', 'B'),
(67, 'Banshee', 'B'),
(68, 'Basilisk', 'B'),
(69, 'Berserker', 'B'),
(70, 'Dragon Wyrmling', 'B'),
(71, 'Bugbear Chief', 'B'),
(72, 'Cultist', 'B'),
(73, 'Death Knight', 'B'),
(74, 'Devil', 'B'),
(75, 'Gargoyle', 'B'),
(76, 'Ghost', 'B'),
(77, 'Giant Wolf Spider', 'B'),
(78, 'Hag', 'B'),
(79, 'Hell Hound', 'B'),
(80, 'Hobgoblin Warlord', 'B'),
(81, 'Medusa', 'B'),
(82, 'Mummy', 'B'),
(83, 'Orc', 'B'),
(84, 'Revenant', 'B'),
(85, 'Shadow', 'B'),
(86, 'Shrieker', 'B'),
(87, 'Skeleton', 'B'),
(88, 'Specter', 'B'),
(89, 'Succubus', 'B'),
(90, 'Vampire Spawn', 'B'),
(91, 'Werewolf', 'B'),
(92, 'Wraith', 'B'),
(93, 'Bandit', 'B'),
(94, 'Bugbear', 'C'),
(95, 'Cult Fanatic', 'C'),
(96, 'Goblin Boss', 'C'),
(97, 'Hobgoblin', 'C'),
(98, 'Spined Devil', 'C'),
(99, 'Wolf', 'C'),
(100, 'Zombie', 'C'),
(101, 'Darkmantle', 'C'),
(102, 'Dust Mephit', 'D'),
(103, 'Dretch', 'D'),
(104, 'Flameskull', 'D'),
(105, 'Flying Snake', 'D'),
(106, 'Flying Sword', 'D'),
(107, 'Giant Centipede', 'D'),
(108, 'Giant Fire Beetle', 'D'),
(109, 'Giant Rat', 'D'),
(110, 'Goblin', 'D'),
(111, 'Imp', 'D'),
(112, 'Octopus', 'D'),
(113, 'Pseudodragon', 'D'),
(114, 'Twig Blight', 'D'),
(115, 'Baboon', 'D'),
(116, 'Blood Hawk', 'E'),
(117, 'Dragon Turtle', 'E'),
(118, 'Eagle', 'E'),
(119, 'Faerie Dragon', 'E'),
(120, 'Frog', 'E'),
(121, 'Hawk', 'E'),
(122, 'Intellect Devourer', 'E'),
(123, 'Jackal', 'E'),
(124, 'Kobold', 'E'),
(125, 'Pixie', 'E'),
(126, 'Poisonous Snake', 'E'),
(127, 'Sprite', 'E'),
(128, 'Awakened Shrub', 'E'),
(129, 'Badger', 'F'),
(130, 'Bat', 'F'),
(131, 'Cat', 'F'),
(132, 'Crab', 'F'),
(133, 'Crawling Claw', 'F'),
(134, 'Lizard', 'F'),
(135, 'Owl', 'F'),
(136, 'Rat', 'F'),
(137, 'Raven', 'F'),
(138, 'Scorpion', 'F'),
(139, 'Tadpole', 'F'),
(140, 'Spider', 'F'),
(141, 'Weasel', 'F'),
(142, 'Will-o-Wisp', 'F');

-- --------------------------------------------------------

--
-- Table structure for table `personal_messages`
--

CREATE TABLE `personal_messages` (
  `id` int(11) NOT NULL,
  `senderID` int(11) NOT NULL,
  `receiverID` int(11) NOT NULL,
  `messageID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `profile_gallery`
--

CREATE TABLE `profile_gallery` (
  `id` int(11) NOT NULL,
  `galleryID` int(11) NOT NULL,
  `externID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `id` int(11) NOT NULL,
  `rating` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ratings`
--

INSERT INTO `ratings` (`id`, `rating`) VALUES
(1, 0),
(2, 0.5),
(3, 1),
(4, 1.5),
(5, 2),
(6, 2.5),
(7, 3),
(8, 3.5),
(9, 4),
(10, 4.5),
(11, 5);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `rText` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `thumbnail_gallery`
--

CREATE TABLE `thumbnail_gallery` (
  `id` int(11) NOT NULL,
  `galleryID` int(11) NOT NULL,
  `externID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `thumbnail_gallery`
--

INSERT INTO `thumbnail_gallery` (`id`, `galleryID`, `externID`) VALUES
(18, 33, 45),
(19, 34, 46);

-- --------------------------------------------------------

--
-- Table structure for table `town`
--

CREATE TABLE `town` (
  `id` int(11) NOT NULL,
  `tName` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `town`
--

INSERT INTO `town` (`id`, `tName`) VALUES
(1, 'Romsey'),
(2, 'Doveport'),
(3, 'Snake Canyon'),
(4, 'Kilmarnock'),
(5, 'Nancledra'),
(6, 'Langdale'),
(7, 'Mournstead'),
(8, 'Runswick'),
(9, 'Northpass'),
(10, 'Ballachulish'),
(11, 'Sutton'),
(12, 'Ashbourne'),
(13, 'Porthaethwidge'),
(14, 'Harnsey'),
(15, 'Nearon'),
(16, 'Kameeraska'),
(17, 'Bury'),
(18, 'Berkton'),
(19, 'Ularee'),
(20, 'Stanmore'),
(21, 'Woolhope'),
(22, 'Rutherglen'),
(23, 'Rutherglen'),
(24, 'Ballaeter'),
(25, 'Middlesborough'),
(26, 'Merton'),
(27, 'Lewes'),
(28, 'Langdale'),
(29, 'Caerfyrddin'),
(30, 'Aramoor'),
(31, 'Middlesborough'),
(32, 'Craydon'),
(33, 'Blaenau'),
(34, 'Rutherglen'),
(35, 'Haedleigh'),
(36, 'Monmouth'),
(37, 'Romsey'),
(38, 'Thralkeld'),
(39, 'Narthwich'),
(40, 'Auchendinny'),
(41, 'Broken Shield'),
(42, 'Garthram'),
(43, 'Warlington'),
(44, 'Garigill'),
(45, 'Llanybydder'),
(46, 'Braedon'),
(47, 'Falkirk'),
(48, 'Begger Hole'),
(49, 'Ballachulish'),
(50, 'Cromerth'),
(51, 'Urmkirkey'),
(52, 'Pella Wish'),
(53, 'Alryne'),
(54, 'Romsey'),
(55, 'Harnsey'),
(56, 'Merton'),
(57, 'Strongfair'),
(58, 'Arkala'),
(59, 'Lunaris'),
(60, 'Bamborourgh'),
(61, 'Auchendinny'),
(62, 'Woolhope'),
(63, 'Porthaethwidge'),
(64, 'Aramoor'),
(65, 'Harnsey'),
(66, 'Ballachulish'),
(67, 'Monmouth'),
(68, 'Caelfall'),
(69, 'Ashbourne'),
(70, 'Ballaeter'),
(71, 'Sutton'),
(72, 'Saker Keep'),
(73, 'Alryne'),
(74, 'Ilfracombe'),
(75, 'Craydon'),
(76, 'Alryne'),
(77, 'Sutton'),
(78, 'Lybster'),
(79, 'Auchendinny'),
(80, 'Auchendinny'),
(81, 'Harnsey'),
(82, 'Ballaeter'),
(83, 'Tillydrone'),
(84, 'Wanborne'),
(85, 'Falkirk'),
(86, 'Rutherglen'),
(87, 'Strongfair'),
(88, 'Tillydrone'),
(89, 'Burnsley'),
(90, 'Doveport'),
(91, 'Snake Canyon'),
(92, 'Broken Shield'),
(93, 'Alryne'),
(94, 'Alnwick'),
(95, 'Lewes'),
(96, 'Pirn'),
(97, 'Gormsey'),
(98, 'Ulatree'),
(99, 'Auchendinny'),
(100, 'Nearon');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `uName` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uPass` varchar(265) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uSalt` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uLevel` int(11) NOT NULL,
  `uGold` double NOT NULL,
  `uProfile` int(11) NOT NULL,
  `uLocation` int(11) NOT NULL,
  `deleted` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `uName`, `uPass`, `uSalt`, `uLevel`, `uGold`, `uProfile`, `uLocation`, `deleted`) VALUES
(17, 'Admin', 'ff391134a6b25f790e97f86d7393d8a3aaec6a780d94ffd2e764880024e3bbae', 'WGmpin', 8, 0, 1, 29, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_event`
--

CREATE TABLE `user_event` (
  `id` int(11) NOT NULL,
  `uID` int(11) NOT NULL,
  `eID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_event`
--

INSERT INTO `user_event` (`id`, `uID`, `eID`) VALUES
(39, 17, 45),
(40, 17, 46);

-- --------------------------------------------------------

--
-- Table structure for table `user_level`
--

CREATE TABLE `user_level` (
  `id` int(11) NOT NULL,
  `levelID` int(11) NOT NULL,
  `uID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_lists`
--

CREATE TABLE `user_lists` (
  `id` int(11) NOT NULL,
  `listID` int(11) NOT NULL,
  `uID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_location`
--

CREATE TABLE `user_location` (
  `id` int(11) NOT NULL,
  `uID` int(11) NOT NULL,
  `locationID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `world`
--

CREATE TABLE `world` (
  `id` int(11) NOT NULL,
  `wName` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `world`
--

INSERT INTO `world` (`id`, `wName`) VALUES
(1, 'Qaipend'),
(2, 'Sevrend'),
(3, 'Striurinor'),
(4, 'Ohux'),
(5, 'Ohux'),
(6, 'Niowadone'),
(7, 'Treruth'),
(8, 'Cuageon'),
(9, 'Qaestroth'),
(10, 'Cauchall'),
(11, 'Klaicotia'),
(12, 'Unari'),
(13, ''),
(14, 'Uagros'),
(15, 'Uguin'),
(16, 'Ocax'),
(17, 'Deopax'),
(18, 'Eotul'),
(19, 'Breifezera'),
(20, 'Vliuhunax'),
(21, 'Treogitane'),
(22, 'Sevrend'),
(23, 'Qagroris'),
(24, 'Cauchall'),
(25, 'Airohish'),
(26, 'Eocevoya'),
(27, 'Blehura'),
(28, 'Vliuhunax'),
(29, 'Niowadone'),
(30, 'Dauholaes'),
(31, 'Eikogos'),
(32, 'Cuageon'),
(33, 'Uguin'),
(34, 'Sheacezia'),
(35, 'Wrudend'),
(36, 'Eikogos'),
(37, 'Qaestroth'),
(38, 'Eotul'),
(39, 'Gleuzitoa'),
(40, 'Deopax'),
(41, 'Airohish'),
(42, 'Airohish'),
(43, 'Sevrend'),
(44, 'Klaicotia'),
(45, 'Qagroris'),
(46, 'Qaipend'),
(47, 'Ocax'),
(48, 'Breifezera'),
(49, 'Pebren'),
(50, 'Treogitane');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_gallery`
--
ALTER TABLE `event_gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_level`
--
ALTER TABLE `event_level`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_list`
--
ALTER TABLE `event_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_location`
--
ALTER TABLE `event_location`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_monster`
--
ALTER TABLE `event_monster`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_ratings`
--
ALTER TABLE `event_ratings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_reviews`
--
ALTER TABLE `event_reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `group_messages`
--
ALTER TABLE `group_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `group_users`
--
ALTER TABLE `group_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `level`
--
ALTER TABLE `level`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `level_monsters`
--
ALTER TABLE `level_monsters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lists`
--
ALTER TABLE `lists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `monsters`
--
ALTER TABLE `monsters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_messages`
--
ALTER TABLE `personal_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `profile_gallery`
--
ALTER TABLE `profile_gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `thumbnail_gallery`
--
ALTER TABLE `thumbnail_gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `town`
--
ALTER TABLE `town`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uName` (`uName`);

--
-- Indexes for table `user_event`
--
ALTER TABLE `user_event`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_level`
--
ALTER TABLE `user_level`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_lists`
--
ALTER TABLE `user_lists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_location`
--
ALTER TABLE `user_location`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `world`
--
ALTER TABLE `world`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `event_gallery`
--
ALTER TABLE `event_gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `event_level`
--
ALTER TABLE `event_level`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `event_list`
--
ALTER TABLE `event_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `event_location`
--
ALTER TABLE `event_location`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `event_monster`
--
ALTER TABLE `event_monster`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `event_ratings`
--
ALTER TABLE `event_ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `event_reviews`
--
ALTER TABLE `event_reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `group_messages`
--
ALTER TABLE `group_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `group_users`
--
ALTER TABLE `group_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `level`
--
ALTER TABLE `level`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `level_monsters`
--
ALTER TABLE `level_monsters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lists`
--
ALTER TABLE `lists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `monsters`
--
ALTER TABLE `monsters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=143;

--
-- AUTO_INCREMENT for table `personal_messages`
--
ALTER TABLE `personal_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `profile_gallery`
--
ALTER TABLE `profile_gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `thumbnail_gallery`
--
ALTER TABLE `thumbnail_gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `town`
--
ALTER TABLE `town`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `user_event`
--
ALTER TABLE `user_event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `user_level`
--
ALTER TABLE `user_level`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_lists`
--
ALTER TABLE `user_lists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_location`
--
ALTER TABLE `user_location`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `world`
--
ALTER TABLE `world`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
