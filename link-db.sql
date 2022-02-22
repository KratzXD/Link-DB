-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 15, 2022 at 04:29 PM
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
-- Database: `link-db`
--

-- --------------------------------------------------------

--
-- Table structure for table `file_type`
--

CREATE TABLE `file_type` (
  `file_type_id` int(11) NOT NULL,
  `file_type` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `file_type`
--

INSERT INTO `file_type` (`file_type_id`, `file_type`) VALUES
(1, 'picture'),
(2, 'video'),
(3, 'gif');

-- --------------------------------------------------------

--
-- Table structure for table `folder_date`
--

CREATE TABLE `folder_date` (
  `folder_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `folder_date`
--

INSERT INTO `folder_date` (`folder_date`) VALUES
('2022-02-15');

-- --------------------------------------------------------

--
-- Table structure for table `links`
--

CREATE TABLE `links` (
  `link_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `artist` varchar(50) NOT NULL,
  `tags_id` text NOT NULL,
  `link` text NOT NULL,
  `img_amount` int(11) NOT NULL,
  `file_type_id` int(11) NOT NULL,
  `input_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `links`
--

INSERT INTO `links` (`link_id`, `type_id`, `artist`, `tags_id`, `link`, `img_amount`, `file_type_id`, `input_date`) VALUES
(46, 1, '@amaneyuz13', '[\"6\"]', 'https://twitter.com/amaneyuz13/status/1242076432248893442?s=20', 1, 1, '2020-03-26'),
(47, 1, '@mtk_n6', '[\"6\"]', 'https://twitter.com/mtk_n6/status/1242444518974042112?s=20', 1, 1, '2020-03-26'),
(48, 1, '@meito_renharm', '[\"4\"]', 'https://twitter.com/meito_renharm/status/1243014799878811648?s=20', 1, 1, '2020-03-26'),
(49, 1, '@Gosh_Gosh_Gosh', '[\"6\"]', 'https://twitter.com/Gosh_Gosh_Gosh/status/1242759511107989507?s=20', 1, 1, '2020-03-26'),
(50, 1, '@zero_0w0', '[\"6\"]', 'https://twitter.com/zero_0w0/status/1242866251900153856?s=20', 1, 1, '2020-03-26'),
(51, 1, '@zero_0w0', '[\"6\"]', 'https://twitter.com/zero_0w0/status/1243000362635677696?s=20', 1, 1, '2020-03-26'),
(52, 1, '@GaRaSi888', '[\"6\"]', 'https://twitter.com/GaRaSi888/status/1243002407690199041?s=20', 1, 1, '2020-03-26'),
(53, 1, '@maro_3ku', '[\"6\"]', 'https://twitter.com/maro_3ku/status/1242066363532734464?s=20', 1, 1, '2020-03-26'),
(54, 1, '@dEi_pft', '[\"6\"]', 'https://twitter.com/dEi_pft/status/1242109799753367553?s=20', 1, 1, '2020-03-26'),
(55, 1, '@sonoko_neko', '[\"2\"]', 'https://twitter.com/sonoko_neko/status/1241855534824697856?s=20', 1, 1, '2020-03-26'),
(56, 1, '@kireha0731', '[\"2\"]', 'https://twitter.com/kireha0731/status/1241770665998352389?s=20', 1, 1, '2020-03-26'),
(57, 1, '@iooo666', '[\"6\"]', 'https://twitter.com/iooo666/status/1241394525970432000?s=20', 1, 1, '2020-03-26'),
(58, 1, '@pp_bk', '[\"2\"]', 'https://twitter.com/pp_bk/status/1241422877489954816?s=20', 1, 1, '2020-03-26'),
(59, 1, '@87nohana', '[\"6\"]', 'https://twitter.com/87nohana/status/1241598556886073345?s=20', 1, 1, '2020-03-26'),
(60, 1, '@Nya_mooon', '[\"6\"]', 'https://twitter.com/Nya_mooon/status/1241340139198017537?s=20', 1, 1, '2020-03-26'),
(61, 1, '@7_yco', '[\"2\"]', 'https://twitter.com/7_yco_/status/1241620460602683392?s=20', 2, 1, '2020-03-26'),
(62, 1, '@niwabuki2020', '[\"6\"]', 'https://twitter.com/niwabuki2020/status/1240501772508151813?s=20', 3, 1, '2020-03-26'),
(63, 1, '@0w0_jomu', '[\"6\"]', 'https://twitter.com/0w0_jomu/status/1240528783314046976?s=20', 3, 1, '2020-03-26'),
(64, 1, '@heyimpuu', '[\"2\"]', 'https://twitter.com/heyimpuu/status/1239045099645857792?s=20', 1, 1, '2020-03-26'),
(77, 1, '@_Since2019_', '[\"4\"]', 'https://twitter.com/_Since2019_/status/1238855664039944199?s=20', 1, 1, '2020-03-26'),
(78, 1, '@kireha0731', '[\"2\"]', 'https://twitter.com/kireha0731/status/1238841525938749440?s=20', 1, 1, '2020-03-26'),
(79, 1, '@kuromoriya3', '[\"6\"]', 'https://twitter.com/kuromoriya3/status/1238007678170886144?s=20', 1, 1, '2020-03-26'),
(80, 1, '@hak_you_3', '[\"2\"]', 'https://twitter.com/hak_you_3/status/1238109230755794944?s=20', 1, 1, '2020-03-26'),
(81, 1, '@buzzy0914', '[\"2\"]', 'https://twitter.com/buzzy0914/status/1238115773530247168?s=20', 4, 1, '2020-03-26'),
(82, 1, '@zero_0w0', '[\"6\"]', 'https://twitter.com/zero_0w0/status/1237926620196794368?s=20', 1, 1, '2020-03-26'),
(83, 1, '@rsktter', '[\"6\"]', 'https://twitter.com/rsktter/status/1237877999669637120?s=20', 1, 1, '2020-03-26'),
(84, 1, '@JunHakase', '[\"5\"]', 'https://twitter.com/JunHakase/status/1237727113047707649?s=20', 1, 1, '2020-03-26'),
(85, 1, '@airmisuzu0920', '[\"6\"]', 'https://twitter.com/airmisuzu0920/status/1237885920507916290?s=20', 1, 1, '2020-03-26'),
(86, 1, '@Merryweatherey', '[\"6\"]', 'https://twitter.com/Merryweatherey/status/1237888368760913920?s=20', 1, 1, '2020-03-26'),
(87, 1, '@Nya_mooon', '[\"6\"]', 'https://twitter.com/Nya_mooon/status/1237678170431578112?s=20', 1, 1, '2020-03-26'),
(88, 1, '@iconosuke', '[\"4\"]', 'https://twitter.com/iconosuke/status/1237376004181471232?s=20', 1, 1, '2020-03-26'),
(90, 1, '@muotou', '[\"4\"]', 'https://twitter.com/muotou/status/1237518850150653952?s=20', 1, 1, '2020-03-26'),
(93, 1, '@alumican_al', '[\"4\"]', 'https://twitter.com/alumican_al/status/1237337078909698049?s=20', 2, 1, '2020-03-26'),
(94, 1, '@araco_o', '[\"6\"]', 'https://twitter.com/araco_o/status/1237006113607806981?s=20', 1, 1, '2020-03-26'),
(95, 1, '@panoji3', '[\"6\"]', 'https://twitter.com/panoji3/status/1236956954527854594?s=20', 1, 1, '2020-03-26'),
(96, 1, '@emeraldgreen_05', '[\"6\"]', 'https://twitter.com/emeraldgreen_05/status/1237096444005199873?s=20', 2, 1, '2020-03-26'),
(97, 1, '@5Agoe', '[\"6\"]', 'https://twitter.com/5Agoe/status/1237191158402445314?s=20', 1, 1, '2020-03-26'),
(98, 1, '@heyimpuu', '[\"1\"]', 'https://twitter.com/heyimpuu/status/1237315528923828230?s=20', 1, 1, '2020-03-26'),
(99, 1, '@magicaljumbo', '[\"6\"]', 'https://twitter.com/magicaljumbo/status/1237184454436605952?s=20', 1, 1, '2020-03-26'),
(100, 1, '@AnimeHentaiFans', '[\"4\"]', 'https://twitter.com/AnimeHentaiFans/status/1236371624217194497?s=20', 1, 1, '2020-03-26'),
(101, 1, '@CUNA_UJB', '[\"6\"]', 'https://twitter.com/CUNA_UJB/status/1236996836415565826?s=20', 1, 1, '2020-03-26'),
(102, 1, '@hak_you_3', '[\"2\"]', 'https://twitter.com/hak_you_3/status/1236993734849388544?s=20', 1, 1, '2020-03-26'),
(103, 1, '@Nton1263', '[\"6\"]', 'https://twitter.com/Nton1263/status/1237042955526868992?s=20', 1, 1, '2020-03-26'),
(104, 1, '@Tigiri_BBB', '[\"6\"]', 'https://twitter.com/Tigiri_BBB/status/1236669401165737985?s=20', 1, 2, '2020-03-26'),
(105, 1, '@wakiobake', '[\"6\"]', 'https://twitter.com/wakiobake/status/1236688965132079106?s=20', 1, 1, '2020-03-26'),
(106, 1, '@mamy6o6', '[\"6\"]', 'https://twitter.com/mamy6o6/status/1236668573600251904?s=20', 2, 1, '2020-03-26'),
(107, 1, '@hitokotocc', '[\"6\"]', 'https://twitter.com/hitokotocc/status/1236675047357476864?s=20', 1, 1, '2020-03-26'),
(108, 1, '@kuttariborokke', '[\"6\"]', 'https://twitter.com/kuttariborokke/status/1236656138059264000?s=20', 1, 1, '2020-03-26'),
(109, 1, '@wataire01', '[\"2\"]', 'https://twitter.com/wataire01/status/1236593942348460032?s=20', 1, 1, '2020-03-26'),
(110, 1, '@nasuno42', '[\"4\"]', 'https://twitter.com/nasuno42/status/1236850411169964034?s=20', 1, 1, '2020-03-26'),
(111, 1, '@pochimoto_cat', '[\"6\"]', 'https://twitter.com/pochimoto_cat/status/1236632776901677056?s=20', 1, 1, '2020-03-26'),
(112, 1, '@nokachoco114', '[\"6\"]', 'https://twitter.com/nokachoco114/status/1236712264167591937?s=20', 1, 1, '2020-03-26'),
(113, 1, '@14__gom', '[\"6\"]', 'https://twitter.com/14__gom/status/1236284565552939008?s=20', 2, 1, '2020-03-26'),
(114, 1, '@kuromoriya3', '[\"4\"]', 'https://twitter.com/kuromoriya3/status/1235585596581498881?s=20', 1, 1, '2020-03-26'),
(115, 1, '@aroma42enola', '[\"6\"]', 'https://twitter.com/aroma42enola/status/1220172455051812865?s=20', 1, 1, '2020-03-26'),
(116, 1, '@KEPY94', '[\"6\"]', 'https://twitter.com/KEPY94/status/1235582515605311488?s=20', 1, 1, '2020-03-26'),
(117, 1, '@sironnsironn', '[\"4\"]', 'https://twitter.com/sironnsironn/status/1235409999871897602?s=20', 1, 1, '2020-03-26'),
(118, 1, '@kireha0731', '[\"2\"]', 'https://twitter.com/kireha0731/status/1235606450963013632?s=20', 1, 1, '2020-03-26'),
(119, 1, '@honorin_megumin', '[\"6\"]', 'https://twitter.com/honorin_megumin/status/1235205637304287233?s=20', 1, 1, '2020-03-26'),
(120, 1, '@hak_you_3', '[\"2\"]', 'https://twitter.com/hak_you_3/status/1235179582539497472?s=20', 1, 1, '2020-03-26'),
(121, 1, '@genesis1556', '[\"6\"]', 'https://twitter.com/genesis1556/status/1234840283864416258?s=20', 1, 1, '2020-03-26'),
(122, 1, '@relaxmakoto', '[\"6\"]', 'https://twitter.com/relaxmakoto/status/1235018295234818048?s=20', 2, 1, '2020-03-26'),
(123, 1, '@yuyu_d', '[\"4\"]', 'https://twitter.com/yuyu_d/status/1234674965229666311?s=20', 1, 1, '2020-03-26'),
(124, 1, '@kuromoriya3', '[\"6\"]', 'https://twitter.com/kuromoriya3/status/1233706483662999553?s=20', 1, 1, '2020-03-26'),
(125, 1, '@kuromoriya3', '[\"6\"]', 'https://twitter.com/kuromoriya3/status/1234398685032673280?s=20', 1, 1, '2020-03-26'),
(126, 1, '@naarann_', '[\"6\"]', 'https://twitter.com/naarann_/status/1234446799634452486?s=20', 1, 1, '2020-03-26'),
(127, 1, '@maro_chick', '[\"6\"]', 'https://twitter.com/maro_chick/status/1234514076522311680?s=20', 1, 1, '2020-03-26'),
(128, 1, '@Nakoto_Sun_Dros', '[\"6\"]', 'https://twitter.com/Nakoto_Sun_Dros/status/1234450336103849984?s=20', 1, 1, '2020-03-26'),
(129, 1, '@nokachoco114', '[\"6\"]', 'https://twitter.com/nokachoco114/status/1234215565910130688?s=20', 2, 1, '2020-03-26'),
(130, 1, '@hasuroot', '[\"4\"]', 'https://twitter.com/hasuroot/status/1233735936346710022?s=20', 1, 1, '2020-03-26'),
(131, 1, '@3ok', '[\"6\"]', 'https://twitter.com/3ok/status/1234131449625735168?s=20', 1, 1, '2020-03-26'),
(132, 1, '@mygod55555', '[\"2\"]', 'https://twitter.com/mygod55555/status/1234132351229124609?s=20', 1, 1, '2020-03-26'),
(133, 1, '@ktk_er18', '[\"2\"]', 'https://twitter.com/ktk_er18/status/1234090113283457025?s=20', 0, 1, '2020-03-26'),
(134, 1, '@Tatsu3Tatsu3', '[\"6\"]', 'https://twitter.com/Tatsu3Tatsu3/status/1233396784249966593?s=20', 1, 1, '2020-03-26'),
(135, 1, '@nabe_1336', '[\"2\"]', 'https://twitter.com/nabe_1336/status/1232987559350820865?s=20', 1, 1, '2020-03-26'),
(136, 1, '@hak_you_3', '[\"2\"]', 'https://twitter.com/hak_you_3/status/1232988966975967234?s=20', 1, 1, '2020-03-26'),
(137, 1, '@pito_sh', '[\"2\"]', 'https://twitter.com/pito_sh/status/1232754087780737024?s=20', 1, 1, '2020-03-26'),
(138, 1, '@kur0r0', '[\"6\"]', 'https://twitter.com/kur0r0/status/1232294759277846529?s=20', 1, 1, '2020-03-26'),
(139, 1, '@Adan_iMas', '[\"6\"]', 'https://twitter.com/Adan_iMas/status/1232319425069453313?s=20', 1, 1, '2020-03-26'),
(140, 1, '@fu_sk', '[\"1\"]', 'https://twitter.com/fu_sk/status/1232276543931441152?s=20', 1, 1, '2020-03-26'),
(141, 1, '@omisocha', '[\"6\"]', 'https://twitter.com/omisocha/status/1232273730698539015?s=20', 1, 1, '2020-03-26'),
(142, 1, '@Narita_Tamezou', '[\"6\"]', 'https://twitter.com/Narita_Tamezou/status/1231911938432495616?s=20', 1, 1, '2020-03-26'),
(143, 1, '@dekonakayubi', '[\"6\"]', 'https://twitter.com/dekonakayubi/status/1231936047371542534?s=20', 1, 1, '2020-03-26'),
(144, 1, '@yamasonson1', '[\"6\"]', 'https://twitter.com/yamasonson1/status/1231918717212053505?s=20', 1, 1, '2020-03-26'),
(145, 1, '@Hanasa_Criin', '[\"6\"]', 'https://twitter.com/Hanasa_Criin/status/1231135242804592643?s=20', 1, 1, '2020-03-26'),
(146, 1, '@oekaki_tako', '[\"6\"]', 'https://twitter.com/oekaki_tako/status/1231229320615514113?s=20', 1, 1, '2020-03-26'),
(147, 1, '@senchat', '[\"6\"]', 'https://twitter.com/senchat/status/1231549521462620164?s=20', 1, 1, '2020-03-26'),
(148, 1, '@mahu3mahu', '[\"6\"]', 'https://twitter.com/mahu3mahu/status/1231418067210518528?s=20', 1, 1, '2020-03-26'),
(149, 1, '@SOLar_Bim', '[\"4\"]', 'https://twitter.com/SOLar_Bim/status/1231574961967386627?s=20', 1, 1, '2020-03-26'),
(150, 1, '@sazao2130', '[\"6\"]', 'https://twitter.com/sazao2130/status/1231603679460904960?s=20', 1, 1, '2020-03-26'),
(151, 1, '@kireha0731', '[\"2\"]', 'https://twitter.com/kireha0731/status/1231276381532647424?s=20', 1, 1, '2020-03-26'),
(152, 1, '@kuromoriya3', '[\"6\"]', 'https://twitter.com/kuromoriya3/status/1230184917423669250?s=20', 1, 1, '2020-03-26'),
(153, 1, '@relaxmakoto', '[\"6\"]', 'https://twitter.com/relaxmakoto/status/1231027026313658368?s=20', 3, 1, '2020-03-26'),
(154, 1, '@xephyrks', '[\"6\"]', 'https://twitter.com/xephyrks/status/1230870095234248708?s=20', 1, 1, '2020-03-26'),
(158, 1, '@kireha0731', '[\"2\"]', 'https://twitter.com/kireha0731/status/1243380411389988865?s=20', 1, 1, '2020-03-27'),
(174, 2, '4270952', '[\"7\",\"8\",\"5\"]', 'https://www.pixiv.net/en/artworks/80403582', 56, 1, '2020-03-29');

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `tags_id` int(11) NOT NULL,
  `tags_name` varchar(50) NOT NULL,
  `total_tags` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`tags_id`, `tags_name`, `total_tags`) VALUES
(1, 'Doujin-YouRiko', 0),
(2, 'Image-YouRiko', 0),
(3, 'Doujin-NSFW', 0),
(4, 'Image-NSFW', 0),
(5, 'Doujin', 0),
(6, 'Image', 0),
(7, 'Yuri', 0),
(8, 'You x Riko', 0);

-- --------------------------------------------------------

--
-- Table structure for table `type`
--

CREATE TABLE `type` (
  `type_id` int(11) NOT NULL,
  `type_name` varchar(50) NOT NULL,
  `type_link` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `type`
--

INSERT INTO `type` (`type_id`, `type_name`, `type_link`) VALUES
(1, 'Twitter', 'https://twitter.com'),
(2, 'Pixiv', 'https://pixiv.net'),
(3, 'Nhentai', 'https://nhentai.net');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `file_type`
--
ALTER TABLE `file_type`
  ADD PRIMARY KEY (`file_type_id`);

--
-- Indexes for table `links`
--
ALTER TABLE `links`
  ADD PRIMARY KEY (`link_id`),
  ADD KEY `type_id` (`type_id`),
  ADD KEY `tags_id` (`tags_id`(768)),
  ADD KEY `file_type_id` (`file_type_id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`tags_id`);

--
-- Indexes for table `type`
--
ALTER TABLE `type`
  ADD PRIMARY KEY (`type_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `file_type`
--
ALTER TABLE `file_type`
  MODIFY `file_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `links`
--
ALTER TABLE `links`
  MODIFY `link_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=175;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `tags_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `type`
--
ALTER TABLE `type`
  MODIFY `type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `links`
--
ALTER TABLE `links`
  ADD CONSTRAINT `links_ibfk_2` FOREIGN KEY (`type_id`) REFERENCES `type` (`type_id`),
  ADD CONSTRAINT `links_ibfk_3` FOREIGN KEY (`file_type_id`) REFERENCES `file_type` (`file_type_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
