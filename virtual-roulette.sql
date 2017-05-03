--
-- Скрипт сгенерирован Devart dbForge Studio for MySQL, Версия 7.2.53.0
-- Домашняя страница продукта: http://www.devart.com/ru/dbforge/mysql/studio
-- Дата скрипта: 03.05.2017 10:26:31
-- Версия сервера: 5.6.31
-- Версия клиента: 4.1
--


-- 
-- Отключение внешних ключей
-- 
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;

-- 
-- Установить режим SQL (SQL mode)
-- 
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- 
-- Установка кодировки, с использованием которой клиент будет посылать запросы на сервер
--
SET NAMES 'utf8';

-- 
-- Установка базы данных по умолчанию
--
USE `virtual-roulette`;

--
-- Описание для таблицы bets
--
DROP TABLE IF EXISTS bets;
CREATE TABLE bets (
  spinID INT(11) NOT NULL AUTO_INCREMENT,
  betAmount INT(11) NOT NULL,
  wonAmount BIGINT(20) DEFAULT 0,
  dateAdd TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  number INT(11) DEFAULT NULL,
  userID INT(11) NOT NULL,
  PRIMARY KEY (spinID),
  CONSTRAINT FK_bets_userID FOREIGN KEY (userID)
    REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE
)
ENGINE = INNODB
AUTO_INCREMENT = 64
CHARACTER SET utf8
COLLATE utf8_general_ci;

--
-- Описание для таблицы users
--
DROP TABLE IF EXISTS users;
CREATE TABLE users (
  id INT(11) NOT NULL AUTO_INCREMENT,
  username VARCHAR(100) NOT NULL,
  password VARCHAR(100) NOT NULL,
  salt VARCHAR(100) DEFAULT NULL,
  userbalance BIGINT(20) NOT NULL DEFAULT 500000,
  PRIMARY KEY (id)
)
ENGINE = INNODB
AUTO_INCREMENT = 3
AVG_ROW_LENGTH = 16384
CHARACTER SET utf8
COLLATE utf8_general_ci;

-- 
-- Вывод данных для таблицы bets
--

-- Таблица `virtual-roulette`.bets не содержит данных

-- 
-- Вывод данных для таблицы users
--
INSERT INTO users VALUES
(2, 'admin', '80d16ab3ca84098e325d548227202027', '590742e5261a5', 46200);

-- 
-- Восстановить предыдущий режим SQL (SQL mode)
-- 
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;

-- 
-- Включение внешних ключей
-- 
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;