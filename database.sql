-- --------------------------------------------------------
-- Host:                         localhost
-- Server Version:               8.0.28 - MySQL Community Server - GPL
-- Server Betriebssystem:        Win64
-- HeidiSQL Version:             12.3.0.6589
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Exportiere Datenbank Struktur für school_tinder
CREATE DATABASE IF NOT EXISTS `school_tinder` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `school_tinder`;

-- Exportiere Struktur von Tabelle school_tinder.json_codes
CREATE TABLE IF NOT EXISTS `json_codes` (
  `id` smallint NOT NULL AUTO_INCREMENT,
  `code` varchar(42) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `status` smallint DEFAULT NULL,
  `message` text,
  KEY `error_id` (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Exportiere Daten aus Tabelle school_tinder.json_codes: ~30 rows (ungefähr)
DELETE FROM `json_codes`;
INSERT INTO `json_codes` (`id`, `code`, `status`, `message`) VALUES
	(-1, 'unknown_error', 500, 'Es ist ein unbekannter Fehler aufgetreten'),
	(0, 'missing_fields', 400, 'Bitte alle Felder angeben'),
	(1, 'wrong_login', 403, 'Falscher Nutzername oder Passwort'),
	(2, 'password_to_long', 400, 'Password muss unter 256 Charaktere lang sein'),
	(3, 'unmatching_passwords', 400, 'Passwörter sind nicht gleich'),
	(4, 'registration_success', 200, 'Account wurde erstellt'),
	(5, 'login_successfull_redirect', 202, 'Erfolgreich angemeldet. Weiterleitung...'),
	(6, 'not_signed_in', 401, 'Du bist nicht angemeldet'),
	(7, 'wrong_data_type', 400, '%param% muss %type% sein'),
	(8, 'var_must_be_above', 400, '%var% muss über %min% sein'),
	(9, 'illegal_characters_password', 400, 'Dein Password enthält ungültige Zeichen'),
	(10, 'already_logged_out', 400, 'Du bist bereits abgemeldet'),
	(11, 'logged_out', 200, 'Erfolgreich abgemeldet'),
	(12, 'nothing_changed', 202, 'Es hat sich nichts geändert'),
	(13, 'bad_number_exception', 418, 'HEEEEEEEEEELLLLL NAH'),
	(14, 'field_to_short', 400, '%field% muss mindestens %length% Charaktere lang sein'),
	(15, 'field_to_long', 400, '%field% kann nur maximal %length% Charaktere lang sein'),
	(16, 'account_settings_updated', 200, 'Deine Account Informationen wurden geändert'),
	(17, 'updated_password', 200, 'Dein Passwort wurde erfolgreich geändert'),
	(18, 'new_and_old_passwords_match', 400, 'Dein altes und neues Passwort sind gleich'),
	(19, 'already_smash', 400, 'Du scheinst die Person ja sehr zu mögen. Du hast sie schon markiert'),
	(20, 'smash_limit_reached', 400, 'Du kannst nur 5 Personen als SMASH markieren, du, du, du....'),
	(21, 'added_smash', 200, 'Erfolgreich als SMASH markiert'),
	(22, 'cant_mark_yourself_as_smash', 400, 'Wie kann man so selbstverliebt sein...'),
	(23, 'not_marked_as_smash', 400, 'Du hast diese Person nie als SMASH markiert'),
	(24, 'removed_smash', 200, 'Ok, Meinung geändert'),
	(25, 'not_enough_permissions', 403, 'Du hast nicht genügend Berechtigungen'),
	(26, 'created_account', 200, 'Account wurde erstellt'),
	(27, 'username_taken', 400, 'Es gibt bereits einen Account mit diesem Namen'),
	(28, 'changed_phase', 200, 'Phase wurde geändert');

-- Exportiere Struktur von Tabelle school_tinder.permissions
CREATE TABLE IF NOT EXISTS `permissions` (
  `bit` bigint NOT NULL DEFAULT '0',
  `name` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`bit`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Exportiere Daten aus Tabelle school_tinder.permissions: ~4 rows (ungefähr)
DELETE FROM `permissions`;
INSERT INTO `permissions` (`bit`, `name`) VALUES
	(1, 'add-users'),
	(2, 'change-phase'),
	(4, 'reset-password'),
	(8, 'admin-panel');

-- Exportiere Struktur von Tabelle school_tinder.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int DEFAULT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `permissions` bigint DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Exportiere Daten aus Tabelle school_tinder.roles: ~1 rows (ungefähr)
DELETE FROM `roles`;
INSERT INTO `roles` (`id`, `name`, `permissions`) VALUES
	(1, 'admin', 15);

-- Exportiere Struktur von Tabelle school_tinder.sessions
CREATE TABLE IF NOT EXISTS `sessions` (
  `uid` int DEFAULT NULL,
  `token` varchar(84) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Exportiere Daten aus Tabelle school_tinder.sessions: ~0 rows (ungefähr)
DELETE FROM `sessions`;

-- Exportiere Struktur von Tabelle school_tinder.settings
CREATE TABLE IF NOT EXISTS `settings` (
  `id` smallint DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `val` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Exportiere Daten aus Tabelle school_tinder.settings: ~1 rows (ungefähr)
DELETE FROM `settings`;
INSERT INTO `settings` (`id`, `name`, `val`) VALUES
	(1, 'phase', 'results');

-- Exportiere Struktur von Tabelle school_tinder.smash
CREATE TABLE IF NOT EXISTS `smash` (
  `uid` int DEFAULT NULL,
  `target` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Exportiere Daten aus Tabelle school_tinder.smash: ~0 rows (ungefähr)
DELETE FROM `smash`;

-- Exportiere Struktur von Tabelle school_tinder.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(24) DEFAULT NULL,
  `first_name` varchar(30) DEFAULT NULL,
  `last_name` varchar(30) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `permissions` smallint DEFAULT NULL,
  `role` smallint DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Exportiere Daten aus Tabelle school_tinder.users: ~1 rows (ungefähr)
DELETE FROM `users`;
INSERT INTO `users` (`id`, `username`, `first_name`, `last_name`, `password`, `permissions`, `role`) VALUES
	(1, 'admin', '', '', '1cf66a81a124fbbc8ad4', 0, 1);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
