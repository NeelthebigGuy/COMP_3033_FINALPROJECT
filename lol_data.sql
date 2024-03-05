-- Checking for already made datebase
DROP DATABASE IF EXISTS lol_champs_db;

-- Checking for already made user
DROP USER IF EXISTS 'lol_user'@'localhost';

-- Creating database
CREATE DATABASE IF NOT EXISTS lol_champs_db;

-- Creating user
CREATE USER IF NOT EXISTS 'lol_user'@'localhost' IDENTIFIED BY 'IFeedBotLane';

-- Granting permissions
GRANT SELECT, UPDATE, FILE ON *.* TO 'lol_user'@'localhost';

-- Switching to our database
USE lol_champs_db;

-- Creating table for games
CREATE TABLE IF NOT EXISTS lol_champs (
    champname VARCHAR(50) NOT NULL,
    buildtype VARCHAR(15),
    lane VARCHAR(1) NOT NULL,
    tier VARCHAR(2) NOT NULL
);

-- inserting data
INSERT INTO lol_champs (champname, buildtype, lane, tier) VALUES
('Ahri', 'Mage', 'M', 'S+'),
('Annie', 'Mage', 'M', 'A'),
('Bard', 'Tank/Mage', 'S', 'S+'),
('Twitch', 'Marksman', 'B', 'S'),
('Jhin', 'Marksman', 'B', 'C'),
('Urgot', 'Fighter', 'T', 'S'),
('Garen', 'Tank/Fighter', 'T', 'F-'),
('Jax', 'Fighter', 'T', 'D'),
('Fiddlesticks', 'Mage', 'J', 'B'),
('Ezreal', 'Marksman', 'B', 'D'),
('Thresh', 'Tank', 'S', 'A');

-- showing data as a debugger
SELECT * FROM lol_champs;

-- showing databases as debugger
SHOW DATABASES;
