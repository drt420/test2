-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 24, 2013 at 11:50 PM
-- Server version: 5.5.25
-- PHP Version: 5.4.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `watch-movies`
--

-- --------------------------------------------------------

--
-- Table structure for table `ads`
--

CREATE TABLE `ads` (
  `ads` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ads`
--

INSERT INTO `ads` (`ads`) VALUES
('<a href="">ad code to show before links</a> - admin panel updateableaa');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `commID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `commUser` int(11) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `comm_date` int(11) NOT NULL,
  `movID` int(11) NOT NULL,
  PRIMARY KEY (`commID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `film_links`
--

CREATE TABLE `film_links` (
  `linkID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `linkBy` int(11) NOT NULL,
  `link_tab` varchar(255) NOT NULL,
  `link_title` varchar(255) NOT NULL,
  `link_destination` text NOT NULL,
  `link_ok` int(11) NOT NULL,
  `link_broken` int(11) NOT NULL,
  `status` enum('approved','pending') NOT NULL DEFAULT 'pending',
  `mID` int(11) NOT NULL,
  `link_type` enum('External','Embed') NOT NULL DEFAULT 'External',
  PRIMARY KEY (`linkID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

-- --------------------------------------------------------

--
-- Table structure for table `genres`
--

CREATE TABLE `genres` (
  `genreID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `genre` varchar(255) NOT NULL,
  PRIMARY KEY (`genreID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `genres`
--

INSERT INTO `genres` (`genreID`, `genre`) VALUES
(1, 'Animation'),
(2, 'Comedy'),
(3, 'Action'),
(4, 'Crime'),
(5, 'Drama'),
(6, 'Mystery'),
(7, 'Thriller'),
(8, 'Sci-Fi'),
(9, 'Horror'),
(10, 'Family'),
(11, 'History'),
(12, 'Fantasy'),
(14, 'News'),
(15, 'Sport'),
(16, 'War'),
(17, 'Musical'),
(19, 'Romance'),
(20, 'Documentary'),
(22, 'Adventures');

-- --------------------------------------------------------

--
-- Table structure for table `movies`
--

CREATE TABLE `movies` (
  `filmID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `film_title` varchar(255) NOT NULL,
  `release_date` int(11) NOT NULL,
  `genres` varchar(255) NOT NULL,
  `runtime` varchar(25) NOT NULL,
  `submited_by` int(11) NOT NULL,
  `description` text NOT NULL,
  `thumbnail` varchar(255) NOT NULL,
  `tags` varchar(255) NOT NULL,
  `actors` text NOT NULL,
  `is_featured` enum('n','y') NOT NULL,
  `film_type` enum('movie','tv-show') NOT NULL,
  `views` int(11) NOT NULL,
  `rating` varchar(10) NOT NULL DEFAULT '0',
  `imdb_link` varchar(255) NOT NULL,
  PRIMARY KEY (`filmID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=33 ;

--
-- Dumping data for table `movies`
--

INSERT INTO `movies` (`filmID`, `film_title`, `release_date`, `genres`, `runtime`, `submited_by`, `description`, `thumbnail`, `tags`, `actors`, `is_featured`, `film_type`, `views`, `rating`, `imdb_link`) VALUES
(19, 'Argo', 1349989200, '5,7,11', '120 mins', 0, 'A dramatization of the 1980 joint CIA-Canadian secret operation to extract six fugitive American diplomatic personnel out of revolutionary Iran.In 1979, the American embassy in Iran was invaded by Iranian revolutionaries and several Americans are taken hostage. However, six manage to escape to the official residence of the Canadian Ambassador and the CIA is eventually ordered to get them out of the country. With few options, exfiltration expert Tony Mendez devises a daring plan: to create a phony Canadian film project looking to shoot in Iran and smuggle the Americans out as its production crew. With the help of some trusted Hollywood contacts, Mendez creates the ruse and proceeds to Iran as its associate producer. However, time is running out with the Iranian security forces closing in on the truth while both his charges and the White House have grave doubts about the operation themselves.', 'Argo.jpg', '', 'Ben Affleck,Bryan Cranston,Alan Arkin,John Goodman,Victor Garber,Tate Donovan,Clea DuVall,Scoot McNairy,Rory Cochrane,Christopher Denham,Kerry Bish&eacute;,Kyle Chandler,Chris Messina,Zeljko Ivanek,Titus Welliver', 'y', 'movie', 0, '0', 'http://www.imdb.com/title/tt1024648/'),
(21, 'Hotel Transylvania', 1348779600, '1,2,10', '91 mins', 0, 'Dracula, who operates a high-end resort away from the human world, goes into overprotective mode when a boy discovers the resort and falls for the count&#x27;s teen-aged daughter.Welcome to the Hotel Transylvania, Dracula&#x27;s lavish five-stake resort, where monsters and their families can live it up, free to be the monsters they are without humans to bother them. On one special weekend, Dracula has invited some of the world&#x27;s most famous monsters - Frankenstein and his wife, the Mummy, the Invisible Man, a family of werewolves, and more - to celebrate his daughter Mavis&#x27; 118th birthday. For Drac, catering to all of these legendary monsters is no problem - but his world could come crashing down when a human stumbles on the hotel for the first time and takes a shine to Mavis.', 'Hotel-Transylvania.jpg', '', 'Adam Sandler,Andy Samberg,Selena Gomez,Kevin James,Fran Drescher,Steve Buscemi,Molly Shannon,David Spade,CeeLo Green,Jon Lovitz,Brian George,Luenell,Brian Stack,Chris Parnell,Jackie Sandler', 'y', 'movie', 0, '0', 'http://www.imdb.com/title/tt0837562/'),
(22, 'Paranormal Activity 4', 1350594000, '9', '88 mins', 0, 'It has been five years since the disappearance of Katie and Hunter, and a suburban family witness strange events in their neighborhood when a woman and a mysterious child move in.The story takes place in 2011, five years after Katie killed her boyfriend Micah, sister Kristi, her husband Daniel and took their baby, Hunter. Story focuses on Alex and her mom, experiencing weird stuff since the new neighbors moved in the town.', 'Paranormal-Activity-4.jpg', '', 'Katie Featherston,Kathryn Newton,Matt Shively,Sprague Grayden,Brady Allen,Stephen Dunham,Alexondra Lee,Aiden Lovekamp,William Juan Prieto,Brian Boland', 'y', 'movie', 0, '0', 'http://www.imdb.com/title/tt2109184/'),
(23, 'Silent Hill: Revelation 3D', 1351807200, '6,7', '94 mins', 0, 'When her father disappears, Heather Mason is drawn into a strange and terrifying alternate reality that holds answers to the horrific nightmares that have plagued her since childhood.Heather Mason and her father have been on the run, always one step ahead of dangerous forces that she doesn&#x27;t fully understand, Now on the eve of her 18th birthday, plagued by horrific nightmares and the disappearance of her father, Heather discovers she&#x27;s not who she thinks she is. The revelation leads her deeper into a demonic world that threatens to trap her forever.', 'Silent-Hill-Revelation-3D.jpg', '', 'Adelaide Clemens,Kit Harington,Carrie-Anne Moss,Sean Bean,Radha Mitchell,Malcolm McDowell,Martin Donovan,Deborah Kara Unger,Roberto Campanella,Erin Pitt,Peter Outerbridge,Jefferson Brown,Milton Barnes,Heather Marks,Rachel Sellan', 'y', 'movie', 0, '5', 'http://www.imdb.com/title/tt0938330/'),
(24, 'Taken 2', 1349384400, '3,4', '92 mins', 0, 'In Istanbul, retired CIA operative Bryan Mills and his wife are taken hostage by the father of a kidnapper Mills killed while rescuing his daughter.Bryan Mills, the former CIA man who rescued his daughter Kim from some Albanian human traffickers, is being targeted by the families of the men he killed. When he goes to Istanbul on a job, he invites Kim and her mother, Leonor, whose marriage is on the rocks to join him. When the Albanians learn of this they try to grab them. They get Bryan and Leonor, he warns Kim and she evades them. Later he calls Kim to tell her to go to the Embassy but she insists that he let her help them. Bryan tells her to get his case which is filled with weapons and with that, she finds them and gives him a weapon. He escapes and plans to come back for Leonor but they are too many and is unable to save Leonor. So he relies on his memory to find her.', 'Taken-2.jpg', '', 'Liam Neeson,Maggie Grace,Famke Janssen,Leland Orser,Jon Gries,D.B. Sweeney,Luke Grimes,Rade Serbedzija,Kevork Malikyan,Alain Figlarz,Frank Alvarez,Murat Tuncelli,Ali Yildirim,Ergun Kuyucu,Cengiz Bozkurt', 'y', 'movie', 0, '0', 'http://www.imdb.com/title/tt1397280/'),
(25, 'Here Comes the Boom', 1349989200, '2,3', '105 mins', 0, 'A high school biology teacher looks to become a successful mixed-martial arts fighter in an effort to raise money to prevent extra-curricular activities from being axed at his cash-strapped school.A high school biology teacher looks to become a successful mixed-martial arts fighter in an effort to raise money to prevent extra-curricular activities from being axed at his cash-strapped school.', 'Here-Comes-the-Boom.jpg', '', 'Kevin James,Salma Hayek,Henry Winkler,Greg Germann,Joe Rogan,Gary Valentine,Charice,Bas Rutten,Reggie Lee,Mark DellaGrotte,Mookie Barker,Jackie Flynn,Nikki Tyler-Flynn,Melissa Peterman,Thomas C. Gallagher', 'y', 'movie', 0, '0', 'http://www.imdb.com/title/tt1648179/'),
(26, 'Alex Cross', 1350594000, '3,4,6,7', '101 mins', 0, 'A homicide detective is pushed to the brink of his moral and physical limits as he tangles with a ferociously skilled serial killer who specializes in torture and pain.Detective and Forensic Psychologist Alex Cross investigates a gruesome murder and while his partner thinks it&#x27;s the work of a psycho, Cross thinks it&#x27;s an organized person. He eventually discovers he has another target and Cross figures out who it is and stops the killer before he gets him. The killer feeling as if Cross slighted him, calls him while he&#x27;s out with his wife and taunts him. It&#x27;s while talking to him that Cross figures out the man has a gun trained on his wife and tries to save her but fails. He calls Cross again and Cross vows to get him. And Cross decides to break all the rules to get him.', 'Alex-Cross.jpg', '', 'Tyler Perry,Matthew Fox,Rachel Nichols,Giancarlo Esposito,Jean Reno,Edward Burns,John C. McGinley,Carmen Ejogo,Chad Lindberg,Cicely Tyson,Stephanie Jacobsen,Yara Shahidi,Jessalyn Wanlim,Christopher Stadulis,Sayeed Shahidi', 'y', 'movie', 0, '0', 'http://www.imdb.com/title/tt1712170/'),
(27, 'Fun Size', 1351198800, '2', '86 mins', 0, 'Wren&#x27;s Halloween plans go awry when she&#x27;s made to babysit her brother, who disappears into a sea of trick-or-treaters. With her best friend and two nerds at her side, she needs to find her brother before her mom finds out he&#x27;s missing.Wren&#x27;s Halloween plans go awry when she&#x27;s made to babysit her brother, who disappears into a sea of trick-or-treaters. With her best friend and two nerds at her side, she needs to find her brother before her mom finds out he&#x27;s missing.', 'Fun-Size.jpg', '', 'Victoria Justice,Jackson Nicoll,Chelsea Handler,Josh Pence,Jane Levy,Thomas Mann,Thomas McDonell,Carrie Clifford,Barry Livingston,Ele Bardha,Osric Chau,Zamani Munashe,Bobby Thomas,James Pumphrey,Thomas Middleditch', 'y', 'movie', 0, '0', 'http://www.imdb.com/title/tt1663143/'),
(28, 'Sinister', 1349989200, '6,9', '110 mins', 0, 'Found footage helps a true-crime author realize how and why a family was murdered in his new home, though his discoveries put his entire family in the path of a supernatural entity.Found footage helps a true-crime author realize how and why a family was murdered in his new home, though his discoveries put his entire family in the path of a supernatural entity.', 'Sinister.jpg', '', 'Ethan Hawke,Juliet Rylance,Fred Dalton Thompson,James Ransone,Michael Hall D&#39;Addario,Clare Foley,Rob Riley,Tavis Smiley,Janet Zappala,Victoria Leigh,Cameron Ocasio,Ethan Haberfield,Danielle Kotch,Blake Mizrahi,Nicholas King', 'y', 'movie', 0, '0', 'http://www.imdb.com/title/tt1922777/'),
(29, 'Dancing with the Stars', 1117573200, '10', '60 mins', 0, 'U.S. reality show based on the British series &#x22;Strictly Come Dancing,&#x22; where celebrities partner up with professional dancers and compete against each other in weekly elimination rounds to determine a winner.U.S. reality show based on the British series &#x22;Strictly Come Dancing,&#x22; where celebrities partner up with professional dancers and compete against each other in weekly elimination rounds to determine a winner.', 'Dancing-with-the-Stars.jpg', '', 'Bruno Tonioli,Tom Bergeron,Carrie Ann Inaba,Len Goodman,Cheryl Burke,Maksim Chmerkovskiy,Driton &#39;Tony&#39; Dovolani,Derek Hough,Karina Smirnoff,Samantha Harris,Mark Ballas,Kym Johnson,Harold Wheeler,Brooke Burke Charvet,Louis van Amstel,Edyta Sliwinska,Anna Trebunskaya', 'y', 'tv-show', 0, '0', 'http://www.imdb.com/title/tt0463398/'),
(31, 'Parker', 1362092400, '3,4,7', '118 mins', 0, 'A thief with a unique code of professional ethics is double-crossed by his crew and left for dead. Assuming a new disguise and forming an unlikely alliance with a woman on the inside, he looks to hijack the score of the crew&#x27;s latest heist.Parker is a thief who has an unusual code. He doesn&#x27;t steal from the poor and hurt innocent people. He is asked to join 4 other guys one of whom is related to a known mobster. They pull off the job flawlessly and Parker wants to part ways with them. But because he refused to join them for another job they try to kill him. They dispose of his body but someone finds him and he is still alive and takes him to the hospital. After recovering he sets out to get back at the ones who tried to kill him, another one of his codes. He learns where they are and poses as a wealthy Texan looking to buy a house. So he hires a Realtor, Leslie Rogers to show him around. He is actually trying to find out where they&#x27;re holed up. And when he finds it, he sets out on his plan to get them. But when they learn he is alive, they contact the mobster to take care of him. So he sends a killer to take care of him.', 'Parker.jpg', '', 'Jason Statham,Jennifer Lopez,Michael Chiklis,Wendell Pierce,Clifton Collins Jr.,Bobby Cannavale,Patti LuPone,Carlos Carrasco,Micah A. Hauptman,Emma Booth,Nick Nolte,Daniel Bernhardt,Billy Slaughter,John Eyes,Carl J. Walker,Sala Baker,Rio Hackford,Kirk Baltz,Earl Maddox,James Carraway,Sharon Landry,Charleigh Harmon,Rebecca Marks,Alyshia Ochse,Madeline Marks,Kip Gilman,Travers Mackel,Randy Rousseau,Eamon Sheehan,Chuck Picerni Jr.,', 'y', 'movie', 0, '0', 'http://www.imdb.com/title/tt1904996/'),
(32, 'Mizerabilii', 1359068400, '5,17,19', '158 mins', 0, 'In 19th-century France, Jean Valjean, who for decades has been hunted by the ruthless policeman Javert after he breaks parole, agrees to care for factory worker Fantine&#x27;s daughter, Cosette. The fateful decision changes their lives forever.Jean Valjean, known as Prisoner 24601, is released from prison and breaks parole to create a new life for himself while evading the grip of the persistent Inspector Javert. Set in post-revolutionary France, the story reaches resolution against the background of the June Rebellion.', 'Mizerabilii.jpg', '', 'Hugh Jackman,Russell Crowe,Anne Hathaway,Amanda Seyfried,Sacha Baron Cohen,Helena Bonham Carter,Eddie Redmayne,Aaron Tveit,Samantha Barks,Daniel Huttlestone,Cavin Cornwall,Josef Altin,Dave Hawley,Adam Jones,John Barr,Tony Rohr,Richard Dixon,Andy Beckwith,Stephen Bent,Colm Wilkinson,Georgie Glen,Heather Chasen,Paul Thornley,Paul Howell,Stephen Tate,Michael Jibson,Kate Fleetwood,Hannah Waddingham,Clare Foster,Kirsty Hoiles,', 'y', 'movie', 0, '5', 'http://www.imdb.com/title/tt1707386/');

-- --------------------------------------------------------

--
-- Table structure for table `playlists`
--

CREATE TABLE `playlists` (
  `listID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fID` int(11) NOT NULL,
  `uID` int(11) NOT NULL,
  `date` int(11) NOT NULL,
  PRIMARY KEY (`listID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `tos`
--

CREATE TABLE `tos` (
  `tos` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tos`
--

INSERT INTO `tos` (`tos`) VALUES
('You can put here your Terms and conditionsaa\n\n<strong>Accept''s HTML tags</strong> as <em>well</em>');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(32) NOT NULL,
  `about` varchar(255) NOT NULL,
  `role` enum('user','moderator') NOT NULL DEFAULT 'user',
  PRIMARY KEY (`userID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
