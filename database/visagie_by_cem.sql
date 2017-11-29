-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Machine: 127.0.0.1
-- Gegenereerd op: 23 nov 2017 om 12:41
-- Serverversie: 5.6.21
-- PHP-versie: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databank: `visagie_by_cem`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `address`
--

CREATE TABLE IF NOT EXISTS `address` (
`id` int(4) NOT NULL,
  `zip` varchar(16) NOT NULL,
  `housenumber` int(8) NOT NULL,
  `extension` varchar(4) DEFAULT NULL,
  `city` varchar(64) NOT NULL,
  `street` varchar(64) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `address`
--

INSERT INTO `address` (`id`, `zip`, `housenumber`, `extension`, `city`, `street`) VALUES
(1, '7897GR', 23, 'B', 'Dronten', 'straatnaam');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `category`
--

CREATE TABLE IF NOT EXISTS `category` (
`id` int(2) NOT NULL,
  `name` varchar(32) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'kiss');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `customer`
--

CREATE TABLE IF NOT EXISTS `customer` (
`id` int(4) NOT NULL,
  `firstname` varchar(64) NOT NULL,
  `insertion` varchar(32) DEFAULT NULL,
  `lastname` varchar(64) NOT NULL,
  `email` varchar(64) NOT NULL,
  `password` varchar(128) NOT NULL,
  `phone` varchar(32) NOT NULL,
  `address` int(4) NOT NULL,
  `birthdate` date NOT NULL,
  `active` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `customer`
--

INSERT INTO `customer` (`id`, `firstname`, `insertion`, `lastname`, `email`, `password`, `phone`, `address`, `birthdate`, `active`) VALUES
(1, 'nick', '', 'smeding', 'nicksmeding95@gmail.com', 'f6783a6675d27be87f589edf8e98fc3a3a9b58b309fa8f091f85337b5e49ab44', '', 1, '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `employee`
--

CREATE TABLE IF NOT EXISTS `employee` (
`id` int(4) NOT NULL,
  `firstname` varchar(64) NOT NULL,
  `insertion` varchar(32) DEFAULT NULL,
  `lastname` varchar(64) NOT NULL,
  `email` varchar(64) NOT NULL,
  `password` varchar(128) NOT NULL,
  `clearance` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `image`
--

CREATE TABLE IF NOT EXISTS `image` (
`id` int(8) NOT NULL,
  `path` varchar(64) NOT NULL,
  `date` date NOT NULL,
  `filename` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `invoice`
--

CREATE TABLE IF NOT EXISTS `invoice` (
`id` int(8) NOT NULL,
  `date` date NOT NULL,
  `customer` int(4) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `btw` int(4) NOT NULL,
  `employee` int(4) NOT NULL,
  `shipping` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `invoice_line`
--

CREATE TABLE IF NOT EXISTS `invoice_line` (
  `invoice` int(8) NOT NULL,
  `product` int(8) NOT NULL,
  `price_unit` float NOT NULL,
  `quantity` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `post`
--

CREATE TABLE IF NOT EXISTS `post` (
`id` int(8) NOT NULL,
  `title` varchar(64) NOT NULL,
  `content` varchar(128) NOT NULL,
  `img` int(8) DEFAULT NULL,
  `author` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `product`
--

CREATE TABLE IF NOT EXISTS `product` (
`id` int(8) NOT NULL,
  `img` int(8) DEFAULT NULL,
  `description` varchar(128) NOT NULL,
  `category` int(2) DEFAULT NULL,
  `stock` int(4) NOT NULL,
  `name` varchar(64) NOT NULL,
  `price` float NOT NULL,
  `active` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `product`
--

INSERT INTO `product` (`id`, `img`, `description`, `category`, `stock`, `name`, `price`, `active`) VALUES
(1, NULL, 'beste verf voor je haar', 1, 20, 'haar verf', 5.75, 1),
(2, NULL, 'een mooie haar strik', 1, 420, 'haar strikje', 12.44, 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `shipping`
--

CREATE TABLE IF NOT EXISTS `shipping` (
  `method` varchar(32) NOT NULL,
  `fee` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `shipping`
--

INSERT INTO `shipping` (`method`, `fee`) VALUES
('dhl', 5),
('ophalen', 0);

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `address`
--
ALTER TABLE `address`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `zip` (`zip`,`housenumber`,`extension`);

--
-- Indexen voor tabel `category`
--
ALTER TABLE `category`
 ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `customer`
--
ALTER TABLE `customer`
 ADD PRIMARY KEY (`id`), ADD KEY `address` (`address`);

--
-- Indexen voor tabel `employee`
--
ALTER TABLE `employee`
 ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `image`
--
ALTER TABLE `image`
 ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `invoice`
--
ALTER TABLE `invoice`
 ADD PRIMARY KEY (`id`), ADD KEY `customer` (`customer`), ADD KEY `employee` (`employee`), ADD KEY `shipping` (`shipping`);

--
-- Indexen voor tabel `invoice_line`
--
ALTER TABLE `invoice_line`
 ADD PRIMARY KEY (`invoice`,`product`), ADD KEY `product` (`product`);

--
-- Indexen voor tabel `post`
--
ALTER TABLE `post`
 ADD PRIMARY KEY (`id`), ADD KEY `employee` (`author`), ADD KEY `img` (`img`);

--
-- Indexen voor tabel `product`
--
ALTER TABLE `product`
 ADD PRIMARY KEY (`id`), ADD KEY `category` (`category`), ADD KEY `img` (`img`);

--
-- Indexen voor tabel `shipping`
--
ALTER TABLE `shipping`
 ADD PRIMARY KEY (`method`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `address`
--
ALTER TABLE `address`
MODIFY `id` int(4) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT voor een tabel `category`
--
ALTER TABLE `category`
MODIFY `id` int(2) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT voor een tabel `customer`
--
ALTER TABLE `customer`
MODIFY `id` int(4) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT voor een tabel `employee`
--
ALTER TABLE `employee`
MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT voor een tabel `image`
--
ALTER TABLE `image`
MODIFY `id` int(8) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT voor een tabel `invoice`
--
ALTER TABLE `invoice`
MODIFY `id` int(8) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT voor een tabel `post`
--
ALTER TABLE `post`
MODIFY `id` int(8) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT voor een tabel `product`
--
ALTER TABLE `product`
MODIFY `id` int(8) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `customer`
--
ALTER TABLE `customer`
ADD CONSTRAINT `customer_ibfk_1` FOREIGN KEY (`address`) REFERENCES `address` (`id`) ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `invoice`
--
ALTER TABLE `invoice`
ADD CONSTRAINT `invoice_ibfk_1` FOREIGN KEY (`customer`) REFERENCES `customer` (`id`) ON UPDATE CASCADE,
ADD CONSTRAINT `invoice_ibfk_2` FOREIGN KEY (`employee`) REFERENCES `employee` (`id`) ON UPDATE CASCADE,
ADD CONSTRAINT `invoice_ibfk_3` FOREIGN KEY (`shipping`) REFERENCES `shipping` (`method`) ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `invoice_line`
--
ALTER TABLE `invoice_line`
ADD CONSTRAINT `invoice_line_ibfk_1` FOREIGN KEY (`invoice`) REFERENCES `invoice` (`id`) ON UPDATE CASCADE,
ADD CONSTRAINT `invoice_line_ibfk_2` FOREIGN KEY (`product`) REFERENCES `product` (`id`) ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `post`
--
ALTER TABLE `post`
ADD CONSTRAINT `post_ibfk_2` FOREIGN KEY (`img`) REFERENCES `image` (`id`) ON UPDATE CASCADE,
ADD CONSTRAINT `post_ibfk_3` FOREIGN KEY (`author`) REFERENCES `employee` (`id`) ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `product`
--
ALTER TABLE `product`
ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`category`) REFERENCES `category` (`id`) ON UPDATE CASCADE,
ADD CONSTRAINT `product_ibfk_2` FOREIGN KEY (`img`) REFERENCES `image` (`id`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
