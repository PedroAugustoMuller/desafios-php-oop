CREATE DATABASE clima;
USE DATABASE clima;

CREATE TABLE weather(
	id INT NOT NULL AUTO_INCREMENT,
	city_name VARCHAR(40),
	description VARCHAR(50),
	icon VARCHAR(10),
	temp DECIMAL(10,2),
	feels_like DECIMAL(10,2),
	humidity INT,
	validation int(11),
	PRIMARY KEY (id)
);