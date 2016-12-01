create database googlemaps;

use googlemaps;
CREATE TABLE locations (  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, 
						  name VARCHAR(50), 
						  address VARCHAR(50),
						  city VARCHAR(20),
						  state VARCHAR(4),
						  zip VARCHAR(6)
                       );

INSERT INTO `locations` (`name`, `address`, `city`, `state`,`zip`) 
VALUES ('Home2','939 W El Camino Real, Mountain View, CA','San Jose','CA','94040');

INSERT INTO `locations` (`name`, `address`, `city`, `state`,`zip`) 
VALUES ('Home','754, The Alameda','San Jose','CA','95126');

Select * from locations;

