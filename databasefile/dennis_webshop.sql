-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Gegenereerd op: 04 feb 2022 om 13:24
-- Serverversie: 10.4.22-MariaDB
-- PHP-versie: 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dennis_webshop`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `bestelde_items`
--

CREATE TABLE `bestelde_items` (
  `bestellingid` int(11) NOT NULL,
  `productid` int(11) NOT NULL,
  `productaantal` int(11) NOT NULL,
  `productprijs` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `bestelde_items`
--

INSERT INTO `bestelde_items` (`bestellingid`, `productid`, `productaantal`, `productprijs`) VALUES
(2, 1, 3, '11.00'),
(2, 2, 2, '2.50'),
(2, 4, 1, '17.50'),
(3, 1, 5, '11.00'),
(3, 3, 2, '3.50'),
(3, 2, 2, '2.50'),
(4, 1, 1, '11.00'),
(5, 4, 1, '17.50'),
(7, 2, 1, '2.50'),
(7, 1, 1, '11.00'),
(8, 1, 1, '11.00'),
(8, 4, 1, '17.50'),
(8, 3, 1, '3.50'),
(8, 2, 1, '2.50'),
(9, 1, 1, '11.00'),
(9, 2, 1, '2.50'),
(11, 1, 1, '11.00'),
(12, 1, 1, '11.00'),
(13, 1, 1, '11.00'),
(14, 1, 1, '11.00'),
(15, 4, 1, '17.50'),
(16, 4, 1, '17.50'),
(17, 4, 1, '17.50'),
(18, 2, 4, '2.50'),
(19, 2, 4, '2.50'),
(21, 1, 1, '11.00'),
(21, 2, 1, '2.50'),
(22, 4, 5, '17.50');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `bestelling`
--

CREATE TABLE `bestelling` (
  `bestellingid` int(11) NOT NULL,
  `gebruikerid` int(11) NOT NULL,
  `bestellingdatum` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `bestelling`
--

INSERT INTO `bestelling` (`bestellingid`, `gebruikerid`, `bestellingdatum`) VALUES
(2, 4, '2022-02-02 15:39:23'),
(3, 4, '2022-02-02 16:19:35'),
(4, 4, '2022-02-02 16:30:41'),
(5, 4, '2022-02-02 16:31:09'),
(6, 4, '2022-02-02 16:31:56'),
(7, 4, '2022-02-02 16:32:07'),
(8, 4, '2022-02-03 14:01:15'),
(9, 4, '2022-02-03 14:14:38'),
(10, 4, '2022-02-03 14:15:02'),
(11, 4, '2022-02-03 14:17:33'),
(12, 4, '2022-02-03 14:18:46'),
(13, 4, '2022-02-03 14:19:20'),
(14, 4, '2022-02-03 14:19:33'),
(15, 4, '2022-02-04 10:49:05'),
(16, 4, '2022-02-04 10:49:34'),
(17, 4, '2022-02-04 10:50:01'),
(18, 4, '2022-02-04 11:00:22'),
(19, 4, '2022-02-04 11:00:53'),
(20, 4, '2022-02-04 11:02:38'),
(21, 4, '2022-02-04 11:02:48'),
(22, 4, '2022-02-04 11:28:33');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `contact_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_message` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `contact`
--

INSERT INTO `contact` (`id`, `contact_name`, `contact_email`, `contact_message`) VALUES
(1, 'Dennis', 'dennis.vanwilligen@gmail.com', 'This is a test'),
(2, 'Dennis', 'dennis.vanwilligen@gmail.com', 'Dit is een nieuwe test, nu met commit en rollback'),
(3, 'Dennis', 'dennis.vanwilligen@gmail.com', 'De volgende test!'),
(4, 'Dennis', 'dennis.vanwilligen@gmail.com', 'De volgende test!'),
(5, 'Dennis', 'dennis.vanwilligen@gmail.com', 'De volgende test!'),
(6, 'Dennis', 'dennis.vanwilligen@gmail.com', 'Test voor database'),
(7, 'Dennis', 'dennis.vanwilligen@gmail.com', 'Test validated data'),
(8, 'Dennis', 'dennis.vanwilligen@gmail.com', 'Validated data test'),
(9, 'Dennis', 'dennis.vanwilligen@gmail.com', 'Nog een validatie test'),
(10, 'Dennis', 'dennis.vanwilligen@gmail.com', 'Test met nieuwe check'),
(11, 'Dennis', 'dennis.vanwilligen@gmail.com', 'Bootstrap test'),
(12, 'Dennis', 'dennis.vanwilligen@gmail.com', 'Bootstrap test'),
(13, 'Dennis', 'dennis.vanwilligen@gmail.com', 'Bootstrap test'),
(14, 'Dennis', 'dennis.vanwilligen@gmail.com', 'Bootstrap test'),
(15, 'Dennis', 'dennis.vanwilligen@gmail.com', 'Bootstrap test'),
(16, 'Dennis', 'dennis.vanwilligen@gmail.com', 'Bootstrap test'),
(17, 'Dennis', 'dennis.vanwilligen@gmail.com', 'Bootstrap test'),
(18, 'Dennis', 'dennis.vanwilligen@gmail.com', 'Bootstrap test'),
(19, 'Dennis', 'dennis.vanwilligen@gmail.com', 'Bootstrap test');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `gebruikers`
--

CREATE TABLE `gebruikers` (
  `id` int(11) NOT NULL,
  `naam` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `wachtwoord` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `gebruikers`
--

INSERT INTO `gebruikers` (`id`, `naam`, `email`, `wachtwoord`) VALUES
(4, 'Dennis', 'dennis.vanwilligen@gmail.com', '$2y$10$OR0T33xOfbF9Eatar.MPOOcYrJTkYRepCo1bC0LHi2oQKvrseo/7S');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `producten`
--

CREATE TABLE `producten` (
  `productid` int(11) NOT NULL,
  `productnaam` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `productprijs` decimal(5,2) NOT NULL,
  `productomschrijving` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `producten`
--

INSERT INTO `producten` (`productid`, `productnaam`, `productprijs`, `productomschrijving`) VALUES
(1, 'sjaal', '11.00', 'Een De Dolle Instuivers sjaal ter ere van het 66 jarig bestaan van de vereniging.'),
(2, 'pin', '2.50', 'Een pin van het 66 jarig jubileum logo van De Dolle Instuivers.'),
(3, 'strijkembleem', '3.50', 'Een strijkembleem van het 66 jarig jubileum logo van De Dolle Instuivers.'),
(4, 'paraplu', '17.50', 'Een limited edition De Dolle Instuivers paraplu!');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `bestelde_items`
--
ALTER TABLE `bestelde_items`
  ADD KEY `bestellingid` (`bestellingid`),
  ADD KEY `productid` (`productid`);

--
-- Indexen voor tabel `bestelling`
--
ALTER TABLE `bestelling`
  ADD PRIMARY KEY (`bestellingid`),
  ADD KEY `gebruikerid` (`gebruikerid`) USING BTREE,
  ADD KEY `bestellingid` (`bestellingid`);

--
-- Indexen voor tabel `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `gebruikers`
--
ALTER TABLE `gebruikers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexen voor tabel `producten`
--
ALTER TABLE `producten`
  ADD PRIMARY KEY (`productid`),
  ADD KEY `productid` (`productid`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `bestelling`
--
ALTER TABLE `bestelling`
  MODIFY `bestellingid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT voor een tabel `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT voor een tabel `gebruikers`
--
ALTER TABLE `gebruikers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT voor een tabel `producten`
--
ALTER TABLE `producten`
  MODIFY `productid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `bestelde_items`
--
ALTER TABLE `bestelde_items`
  ADD CONSTRAINT `bestelde_items_ibfk_1` FOREIGN KEY (`productid`) REFERENCES `producten` (`productid`),
  ADD CONSTRAINT `bestelde_items_ibfk_2` FOREIGN KEY (`bestellingid`) REFERENCES `bestelling` (`bestellingid`);

--
-- Beperkingen voor tabel `bestelling`
--
ALTER TABLE `bestelling`
  ADD CONSTRAINT `bestelling_ibfk_1` FOREIGN KEY (`gebruikerid`) REFERENCES `gebruikers` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
