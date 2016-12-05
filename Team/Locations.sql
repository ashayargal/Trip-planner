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

CREATE TABLE provider_estimate ( id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, 
						  name VARCHAR(50),
						  trip_id INT,
						  total_costs_by_cheapest_car_type DECIMAL(10,4),
						  currency_code VARCHAR(6),
						  total_duration INT,
						  duration_unit VARCHAR(10),
						  total_distance INT,
						  distance_unit VARCHAR(10),
						  FOREIGN KEY (trip_id)
						  REFERENCES trips(id)
						  ON DELETE CASCADE
					   );



use googlemaps;
Select * from locations;

