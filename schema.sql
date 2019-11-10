CREATE DATABASE yeticave
   DEFAULT CHARACTER SET utf8
   DEFAULT COLLATE utf8_general_ci;
   
USE yeticave;

CREATE TABLE categories (
id INT AUTO_INCREMENT PRIMARY KEY,
name CHAR(128),
symbol_code CHAR(64)
);

CREATE TABLE lots (
id INT AUTO_INCREMENT PRIMARY KEY,
date_create DATETIME,
name CHAR(128) NOT NULL,
description TEXT(1000),
picture CHAR(128),
start_price CHAR(10),
date_finish DATETIME,
bet_step INT,
author_id INT,
winner_id INT,
category_name CHAR(128) 
);

CREATE TABLE bets (
id INT AUTO_INCREMENT PRIMARY KEY,
bet_date DATETIME,
bet_sum INT,
user_id INT,
lot_id INT
);

CREATE TABLE users (
id INT AUTO_INCREMENT PRIMARY KEY,
registration_date DATETIME,
email CHAR(20) UNIQUE,
name CHAR(50) NOT NULL UNIQUE,
password CHAR(255) NOT NULL UNIQUE,
contacts CHAR(255)
);

CREATE INDEX c_name ON categories(name);
CREATE INDEX l_name ON lots(name);
CREATE INDEX b_bet_date ON bets(bet_date);