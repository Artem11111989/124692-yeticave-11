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
bet_step TINYINT(10) 
);

CREATE TABLE bets (
id INT AUTO_INCREMENT PRIMARY KEY,
bet_date DATETIME,
bet_sum INT(10)
);

CREATE TABLE users (
id INT AUTO_INCREMENT PRIMARY KEY,
registration_date DATETIME,
email CHAR(20) UNIQUE,
name CHAR(50) NOT NULL UNIQUE,
password CHAR NOT NULL UNIQUE,
contacts CHAR
);

CREATE INDEX c_name ON categories(name);
CREATE INDEX l_name ON lots(name);
CREATE INDEX b_bet_date ON bets(bet_date);