create database googlemaps;

use googlemaps;
CREATE TABLE locations (  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, 
						  name VARCHAR(50), 
						  address VARCHAR(50),
						  city VARCHAR(20),
						  state VARCHAR(4),
						  zip VARCHAR(6),
						  latitude DECIMAL(15,10),
						  longitude DECIMAL(15,10)
					   );

CREATE TABLE trips (  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, 
						  name VARCHAR(50), 
						  location_id INT,
						  is_start BOOLEAN,
						  is_end BOOLEAN,
						  FOREIGN KEY (location_id)
						  REFERENCES locations(id)
						  ON DELETE CASCADE
					   );


use googlemaps;
Select * from locations;

