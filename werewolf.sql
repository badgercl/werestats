SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Table structure for table `achievements`
--

CREATE TABLE `achievements` (
  `id` int(11) NOT NULL,
  `name` text COLLATE utf8mb4_bin NOT NULL,
  `description` text COLLATE utf8mb4_bin NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `achievements`
--

INSERT INTO `achievements` (`id`, `name`, `description`, `created_at`, `modified_on`) VALUES
(1, 'None', 'You haven\'t played a game yet!', '2017-05-26 10:29:06', '2017-05-26 10:29:06'),
(2, 'Welcome to Hell', 'Play a game', '2017-05-26 10:29:06', '2017-05-26 10:29:06'),
(3, 'Welcome to the Asylum', 'Play a chaos game', '2017-05-26 10:29:06', '2017-05-26 10:29:06'),
(4, 'Alzheimer\'s Patient', 'Play a game with an amnesia language pack', '2017-05-26 10:29:06', '2017-05-26 10:29:06'),
(5, 'O HAI DER!', 'Play a game with Para\'s secret account (not @para949)', '2017-05-26 10:29:06', '2017-05-26 10:29:06'),
(6, 'Spy vs Spy', 'Play a game in secret mode (no role reveal)', '2017-05-26 10:29:06', '2017-05-26 10:29:06'),
(7, 'Explorer', 'Play at least 2 games each in 10 different groups', '2017-05-26 10:29:06', '2017-05-26 10:29:06'),
(8, 'Linguist', 'Play at least 2 games each in 10 different language packs', '2017-05-26 10:29:06', '2017-05-26 10:29:06'),
(9, 'I Have No Idea What I\'m Doing', 'Play a game in secret amnesia mode', '2017-05-26 10:29:06', '2017-05-26 10:29:06'),
(10, 'Enochlophobia', 'Play a 35 player game', '2017-05-26 10:29:06', '2017-05-26 10:29:06'),
(11, 'Introvert', 'Play a 5 player game', '2017-05-26 10:29:06', '2017-05-26 10:29:06'),
(12, 'Naughty!', 'Play a game using any NSFW language pack', '2017-05-26 10:29:06', '2017-05-26 10:29:06'),
(13, 'Dedicated', 'Play 100 games', '2017-05-26 10:29:06', '2017-05-26 10:29:06'),
(14, 'Obsessed', 'Play 1000 games', '2017-05-26 10:29:06', '2017-05-26 10:29:06'),
(15, 'Here\'s Johnny!', 'Get 50 kills as the serial killer', '2017-05-26 10:29:06', '2017-05-26 10:29:06'),
(16, 'I\'ve Got Your Back', 'Save 50 people as the Guardian Angel', '2017-05-26 10:29:06', '2017-05-26 10:29:06'),
(17, 'Masochist', 'Win a game as the Tanner', '2017-05-26 10:29:06', '2017-05-26 10:29:06'),
(18, 'Wobble Wobble', 'Survive a game as the drunk (at least 10 players)', '2017-05-26 10:29:06', '2017-05-26 10:29:06'),
(19, 'Inconspicuous', 'In a game of 20 or more people, do not get a single lynch vote against you (and survive)', '2017-05-26 10:29:06', '2017-05-26 10:29:06'),
(20, 'Survivalist', 'Survive 100 games', '2017-05-26 10:29:06', '2017-05-26 10:29:06'),
(21, 'Black Sheep', 'Get lynched first 3 games in a row', '2017-05-26 10:29:06', '2017-05-26 10:29:06'),
(22, 'Promiscuous', 'As the harlot, survive a 5+ night game without staying home or visiting the same person more than once', '2017-05-26 10:29:06', '2017-05-26 10:29:06'),
(23, 'Mason Brother', 'Be one of at least two surviving masons in a game', '2017-05-26 10:29:06', '2017-05-26 10:29:06'),
(24, 'Double Shifter', 'Change roles twice in one game (cult conversion does not count)', '2017-05-26 10:29:06', '2017-05-26 10:29:06'),
(25, 'Hey Man, Nice Shot', 'As the hunter, use your dying shot to kill a wolf or serial killer', '2017-05-26 10:29:06', '2017-05-26 10:29:06'),
(26, 'That\'s Why You Don\'t Stay Home', 'As a wolf or cultist, kill or convert a harlot that stayed home', '2017-05-26 10:29:06', '2017-05-26 10:29:06'),
(27, 'Double Vision', 'Be one of two seers at the same time', '2017-05-26 10:29:06', '2017-05-26 10:29:06'),
(28, 'Double Kill', 'Be part of the Serial Killer / Hunter ending', '2017-05-26 10:29:06', '2017-05-26 10:29:06'),
(29, 'Should Have Known', 'As the Seer, reveal the Beholder', '2017-05-26 10:29:06', '2017-05-26 10:29:06'),
(30, 'I See a Lack of Trust', 'As the Seer, get lynched on the first day', '2017-05-26 10:29:06', '2017-05-26 10:29:06'),
(31, 'Sunday Bloody Sunday', 'Be one of at least 4 victims to die in a single night', '2017-05-26 10:29:06', '2017-05-26 10:29:06'),
(32, 'Change Sides Works', 'Change roles in a game, and win', '2017-05-26 10:29:06', '2017-05-26 10:29:06'),
(33, 'Forbidden Love', 'Win as a wolf / villager couple (villager, not village team)', '2017-05-26 10:29:06', '2017-05-26 10:29:06'),
(34, 'Developer', 'Have a pull request merged into the repo', '2017-05-26 10:29:06', '2017-05-26 10:29:06'),
(35, 'The First Stone', 'Be the first to cast a lynch vote 5 times in a single game', '2017-05-26 10:29:06', '2017-05-26 10:29:06'),
(36, 'Smart Gunner', 'As the Gunner, both of your bullets hit a wolf, serial killer, or cultist', '2017-05-26 10:29:06', '2017-05-26 10:29:06'),
(37, 'Streetwise', 'Find a different wolf, serial killer, or cultist 4 nights in a row as the detective', '2017-05-26 10:29:06', '2017-05-26 10:29:06'),
(38, 'Speed Dating', 'Have the bot select you as a lover (cupid failed to choose)', '2017-05-26 10:29:06', '2017-05-26 10:29:06'),
(39, 'Even a Stopped Clock is Right Twice a Day', 'As the Fool, have at least two of your visions be correct by the end of the game', '2017-05-26 10:29:06', '2017-05-26 10:29:06'),
(40, 'So Close!', 'As the Tanner, be tied for the most lynch votes', '2017-05-26 10:29:06', '2017-05-26 10:29:06'),
(41, 'Cultist Convention', 'Be one of 10 or more cultists alive at the end of a game', '2017-05-26 10:29:06', '2017-05-26 10:29:06'),
(42, 'Self Loving', 'As cupid, pick yourself as one of the lovers', '2017-05-26 10:29:06', '2017-05-26 10:29:06'),
(43, 'Should\'ve Said Something', 'As a wolf, your pack eats your lover (first night does not count)', '2017-05-26 10:29:06', '2017-05-26 10:29:06'),
(44, 'Tanner Overkill', 'As the Tanner, have everyone (but yourself) vote to lynch you', '2017-05-26 10:29:06', '2017-05-26 10:29:06'),
(45, 'Serial Samaritan', 'As the Serial Killer, kill at least 3 wolves in single game', '2017-05-26 10:29:06', '2017-05-26 10:29:06'),
(46, 'Cultist Fodder', 'Be the cultist that is sent to attempt to convert the Cult Hunter', '2017-05-26 10:29:06', '2017-05-26 10:29:06'),
(47, 'Lone Wolf', 'In a chaos game of 10 or more people, be the only wolf - and win', '2017-05-26 10:29:06', '2017-05-26 10:29:06'),
(48, 'Pack Hunter', 'Be one of 7 living wolves at one time', '2017-05-26 10:29:06', '2017-05-26 10:29:06'),
(49, 'Saved by the Bull(et)', 'As a villager, the wolves match the number of villagers, but the game does not end because the gunner has a bullet', '2017-05-26 10:29:06', '2017-05-26 10:29:06'),
(50, 'In for the Long Haul', 'Survive for at least an hour in a single game', '2017-05-26 10:29:06', '2017-05-26 10:29:06'),
(51, 'OH SHI-', 'Kill your lover on the first night', '2017-05-26 10:29:06', '2017-05-26 10:29:06'),
(52, 'Veteran', 'Play 500 games.  You can now join @werewolfvets', '2017-05-26 10:29:06', '2017-05-26 10:29:06'),
(53, 'No Sorcery!', 'As a wolf, kill your sorcerer', '2017-05-26 10:29:06', '2017-05-26 10:29:06'),
(54, 'Cultist Tracker', 'As the cultist hunter, kill at least 3 cultists in one game', '2017-05-26 10:29:06', '2017-05-26 10:29:06'),
(55, 'I\'M NOT DRUN-- *BURPPP*', 'As the clumsy guy, have at least 3 correct lynches by the end of the game', '2017-05-26 10:29:06', '2017-05-26 10:29:06'),
(56, 'Wuffie-Cult', 'As the alpha wolf, successfully convert at least 3 victims into wolves', '2017-05-26 10:29:06', '2017-05-26 10:29:06'),
(57, 'Did you guard yourself?', 'As the guardian angel, survive after 3 tries guarding an unattacked wolf', '2017-05-26 10:29:06', '2017-05-26 10:29:06'),
(58, 'Spoiled Rich Brat', 'As the prince, still gets lynched even after revealing your identity', '2017-05-26 10:29:06', '2017-05-26 10:29:06'),
(59, 'Three Little Wolves and a Big Bad Pig', 'As the sorcerer, survive a game with three or more alive wolves', '2017-05-26 10:29:06', '2017-05-26 10:29:06'),
(60, 'President', 'As the mayor, successfully cast 3 lynch votes after revealing', '2017-05-26 10:29:06', '2017-05-26 10:29:06'),
(61, 'I Helped!', 'As a wolf cub, the alive pack has 2 successful eat attempts after you die', '2017-05-26 10:29:06', '2017-05-26 10:29:06'),
(62, 'It Was a Busy Night!', 'During the same night, got visited by 3 or more different visiting roles', '2017-05-26 10:29:06', '2017-05-26 10:29:06');

-- --------------------------------------------------------

--
-- Table structure for table `players`
--

CREATE TABLE `players` (
  `id` int(11) NOT NULL,
  `uid` int(10) UNSIGNED NOT NULL,
  `name` mediumtext COLLATE utf8mb4_bin NOT NULL,
  `username` text COLLATE utf8mb4_bin,
  `updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Table structure for table `players_achievements`
--

CREATE TABLE `players_achievements` (
  `player_id` int(11) NOT NULL,
  `achievement_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Table structure for table `player_stats`
--

CREATE TABLE `player_stats` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `played` int(11) NOT NULL,
  `won` int(11) NOT NULL,
  `lost` int(11) NOT NULL,
  `survived` int(11) NOT NULL,
  `most_common_role_id` int(11) NOT NULL,
  `most_killed` int(11) NOT NULL,
  `most_killed_name` varchar(255) NOT NULL,
  `most_killed_by` int(11) NOT NULL,
  `most_killed_by_name` varchar(255) NOT NULL,
  `updated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `player_stats_delta`
--

CREATE TABLE `player_stats_delta` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `played` int(11) NOT NULL,
  `won` int(11) NOT NULL,
  `lost` int(11) NOT NULL,
  `survived` int(11) NOT NULL,
  `most_common_role_id` int(11) NOT NULL,
  `most_killed` int(11) NOT NULL,
  `most_killed_name` varchar(255) NOT NULL,
  `most_killed_by` int(11) NOT NULL,
  `most_killed_by_name` varchar(255) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `created_on`) VALUES
(1, 'mason', '2017-04-23 00:35:20'),
(2, 'villager', '2017-04-23 00:35:20'),
(3, 'beholder', '2017-04-23 00:35:20'),
(4, 'serialkiller', '2017-04-23 00:35:20'),
(5, 'drunk', '2017-04-23 00:35:20'),
(6, 'prince', '2017-04-23 00:35:20'),
(7, 'wildchild', '2017-04-23 00:35:20'),
(8, 'alphawolf', '2017-04-23 00:35:20'),
(9, 'blacksmith', '2017-07-27 00:00:48'),
(10, 'gunner', '2017-07-30 00:00:47'),
(11, 'cursed', '2017-08-02 00:00:48'),
(12, 'tanner', '2017-08-08 12:00:30'),
(13, 'hunter', '2017-08-17 12:00:23'),
(14, 'clumsyguy', '2017-08-24 12:01:17'),
(15, 'harlot', '2017-08-25 00:01:11'),
(16, 'seer', '2017-08-31 00:01:05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `achievements`
--
ALTER TABLE `achievements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `players`
--
ALTER TABLE `players`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uid` (`uid`);

--
-- Indexes for table `players_achievements`
--
ALTER TABLE `players_achievements`
  ADD PRIMARY KEY (`player_id`,`achievement_id`);

--
-- Indexes for table `player_stats`
--
ALTER TABLE `player_stats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `player_stats_delta`
--
ALTER TABLE `player_stats_delta`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `achievements`
--
ALTER TABLE `achievements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;
--
-- AUTO_INCREMENT for table `players`
--
ALTER TABLE `players`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;
--
-- AUTO_INCREMENT for table `player_stats`
--
ALTER TABLE `player_stats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28155;
--
-- AUTO_INCREMENT for table `player_stats_delta`
--
ALTER TABLE `player_stats_delta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30219;
--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
