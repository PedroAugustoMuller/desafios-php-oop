CREATE DATABASE clima;
USE DATABASE clima;

CREATE TABLE weather(
	id INT NOT NULL AUTO_INCREMENT,
	city_info VARCHAR(65),
	description VARCHAR(50),
	icon VARCHAR(10),
	temp DECIMAL(10,2),
	feels_like DECIMAL(10,2),
	wind_speed DECIMAL(10,2),
	humidity INT,
	unixTime int(11),
	PRIMARY KEY (id)
);

INSERT INTO weather(city_info,description,icon,temp,feels_like,wind_speed,humidity,unixTime) VALUES
	:city_info,
	:description,
	:icon,
	:temp,
	:feels_like,
	:wind_speed,
	:humidity,
	:unixTime);

select * from weather 
WHERE city_info LIKE 'Santa Cruz do Sul%' AND UNIX_TIMESTAMP() - unixTime < 3600 
ORDER BY id 
DESC LIMIT 1;  