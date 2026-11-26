SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS `eduresource_managerdb`
	DEFAULT CHARACTER SET utf8mb4
	COLLATE utf8mb4_unicode_ci;
USE `eduresource_managerdb`;

CREATE TABLE `uzytkownicy` (
	`ID` INT(11) NOT NULL AUTO_INCREMENT,
	`Imie` VARCHAR(100) NOT NULL,
	`Nazwisko` VARCHAR(100) NOT NULL,
	`Stanowisko` VARCHAR(100) NOT NULL,
	`Dostep` INT(11) NOT NULL DEFAULT 1,
	`Login` VARCHAR(64) NOT NULL,
	`Email` VARCHAR(190) NOT NULL,
	`Haslo` VARCHAR(255) NOT NULL,
	`ilosc_wypozyczen` INT(11) NOT NULL DEFAULT 0,
	PRIMARY KEY (`ID`),
	UNIQUE KEY `uq_uzytkownicy_login` (`Login`),
	UNIQUE KEY `uq_uzytkownicy_email` (`Email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `zasoby_szkolne` (
	`ID` INT(11) NOT NULL AUTO_INCREMENT,
	`Nazwa` VARCHAR(150) NOT NULL,
	`Numer` VARCHAR(64) NOT NULL,
	`Kategoria` VARCHAR(64) NOT NULL,
	`Budynek` INT(11) NOT NULL,
	`Pietro` INT(11) NOT NULL,
	`Sala` INT(11) NOT NULL,
	`Stan` VARCHAR(32) NOT NULL DEFAULT 'sprawny',
	`Status` VARCHAR(32) NOT NULL DEFAULT 'dostepny',
	PRIMARY KEY (`ID`),
	UNIQUE KEY `uq_zasoby_numer` (`Numer`),
	KEY `idx_zasoby_kategoria` (`Kategoria`),
	KEY `idx_zasoby_lokalizacja` (`Budynek`, `Pietro`, `Sala`),
	KEY `idx_zasoby_stan_status` (`Stan`, `Status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `wyporzyczenia` (
	`ID` INT(11) NOT NULL AUTO_INCREMENT,
	`Zasob_ID` INT(11) NOT NULL,
	`Uzytkownik_ID` INT(11) NOT NULL,
	`Data_Wypozyczenia` DATE NOT NULL,
	`Przewidywana_data_zwrotu` DATE NOT NULL,
	`Data_Zwrotu` DATE DEFAULT NULL,
	`Status_Wypozyczenia` VARCHAR(32) NOT NULL DEFAULT 'aktywne',
	PRIMARY KEY (`ID`),
	KEY `idx_wyp_zasob` (`Zasob_ID`),
	KEY `idx_wyp_uzytkownik` (`Uzytkownik_ID`),
	KEY `idx_wyp_status` (`Status_Wypozyczenia`),
	CONSTRAINT `fk_wyp_zasob` FOREIGN KEY (`Zasob_ID`)
		REFERENCES `zasoby_szkolne` (`ID`) ON UPDATE CASCADE ON DELETE RESTRICT,
	CONSTRAINT `fk_wyp_uzytkownik` FOREIGN KEY (`Uzytkownik_ID`)
		REFERENCES `uzytkownicy` (`ID`) ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `tickety` (
	`ID` INT(11) NOT NULL AUTO_INCREMENT,
	`Zasob_ID` INT(11) NOT NULL,
	`Autor_ID` INT(11) NOT NULL,
	`Typ_Problemu` VARCHAR(32) NOT NULL DEFAULT 'nie_wiem',
	`Opis` TEXT NOT NULL,
	`Status_Ticketu` VARCHAR(32) NOT NULL DEFAULT 'otwarty',
	`Budynek` INT(11) NOT NULL,
	`Pietro` INT(11) NOT NULL,
	`Sala` INT(11) NOT NULL,
	`Data_Utworzenia` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`Data_Zamkniecia` DATETIME DEFAULT NULL,
	PRIMARY KEY (`ID`),
	KEY `idx_tickety_zasob` (`Zasob_ID`),
	KEY `idx_tickety_autor` (`Autor_ID`),
	KEY `idx_tickety_status` (`Status_Ticketu`),
	CONSTRAINT `fk_tickety_zasob` FOREIGN KEY (`Zasob_ID`)
		REFERENCES `zasoby_szkolne` (`ID`) ON UPDATE CASCADE ON DELETE RESTRICT,
	CONSTRAINT `fk_tickety_autor` FOREIGN KEY (`Autor_ID`)
		REFERENCES `uzytkownicy` (`ID`) ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

WITH RECURSIVE `seq` AS (
	SELECT 1 AS `n`
	UNION ALL
	SELECT `n` + 1 FROM `seq` WHERE `n` < 31
)
INSERT INTO `zasoby_szkolne` (`Nazwa`, `Numer`, `Kategoria`, `Budynek`, `Pietro`, `Sala`, `Stan`, `Status`)
SELECT
	CONCAT('Komputer stacjonarny #', LPAD(`n`, 2, '0')),
	CONCAT('B1-P1-S107-PC-', LPAD(`n`, 2, '0')),
	'komputer',
	1, 1, 107,
	'sprawny', 'dostepny'
FROM `seq`
UNION ALL
SELECT
	CONCAT('Monitor #', LPAD(`n`, 2, '0')),
	CONCAT('B1-P1-S107-MON-', LPAD(`n`, 2, '0')),
	'monitor',
	1, 1, 107,
	'sprawny', 'dostepny'
FROM `seq`
UNION ALL
SELECT
	CONCAT('Klawiatura #', LPAD(`n`, 2, '0')),
	CONCAT('B1-P1-S107-KBD-', LPAD(`n`, 2, '0')),
	'klawiatura',
	1, 1, 107,
	'sprawny', 'dostepny'
FROM `seq`
UNION ALL
SELECT
	CONCAT('Mysz #', LPAD(`n`, 2, '0')),
	CONCAT('B1-P1-S107-MSE-', LPAD(`n`, 2, '0')),
	'mysz',
	1, 1, 107,
	'sprawny', 'dostepny'
FROM `seq`
UNION ALL
SELECT
	'Projektor multimedialny',
	'B1-P1-S107-PRJ-01',
	'projektor',
	1, 1, 107,
	'sprawny', 'dostepny'
UNION ALL
SELECT
	CONCAT('Laptop szkolny #', LPAD(`n`, 2, '0')),
	CONCAT('B2-P2-S205-NB-', LPAD(`n`, 2, '0')),
	'laptop',
	2, 2, 5,
	'sprawny', 'dostepny'
FROM `seq`
UNION ALL
SELECT
	'Projektor multimedialny',
	'B2-P2-S205-PRJ-01',
	'projektor',
	2, 2, 5,
	'sprawny', 'dostepny'
UNION ALL
SELECT
	CONCAT('Komputer stacjonarny #', LPAD(`n`, 2, '0')),
	CONCAT('B2-P2-S206-PC-', LPAD(`n`, 2, '0')),
	'komputer',
	2, 2, 6,
	'sprawny', 'dostepny'
FROM `seq`
UNION ALL
SELECT
	'Projektor multimedialny',
	'B2-P2-S206-PRJ-01',
	'projektor',
	2, 2, 6,
	'sprawny', 'dostepny'
UNION ALL
SELECT
	CONCAT('Komputer stacjonarny #', LPAD(`n`, 2, '0')),
	CONCAT('B2-P2-S207-PC-', LPAD(`n`, 2, '0')),
	'komputer',
	2, 2, 7,
	'sprawny', 'dostepny'
FROM `seq`
UNION ALL
SELECT
	'Projektor multimedialny',
	'B2-P2-S207-PRJ-01',
	'projektor',
	2, 2, 7,
	'sprawny', 'dostepny';

INSERT IGNORE INTO `uzytkownicy`
	(`Imie`, `Nazwisko`, `Stanowisko`, `Dostep`, `Login`, `Email`, `Haslo`)
VALUES
	('Admin', 'Systemu', 'Administrator', 9, 'admin', 'admin@eduresource.local',
	 '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi'),
	('Jan', 'Uczen', 'Uczen', 1, 'jan', 'jan@eduresource.local',
	 '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi');

COMMIT;
