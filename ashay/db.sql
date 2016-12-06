CREATE TABLE `provider_estimate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `uber_cost` decimal(5,2) DEFAULT NULL,
  `uber_duration` int(11) DEFAULT NULL,
  `lyft_duration` int(11) DEFAULT NULL,
  `uber_distance` decimal(5,2) DEFAULT NULL,
  `lyft_distance` decimal(5,2) DEFAULT NULL,
  `lyft_cost` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;


CREATE TABLE `locations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `address` varchar(50) DEFAULT NULL,
  `city` varchar(20) DEFAULT NULL,
  `state` varchar(4) DEFAULT NULL,
  `zip` varchar(6) DEFAULT NULL,
  `latitude` decimal(15,10) DEFAULT NULL,
  `longitude` decimal(15,10) DEFAULT NULL,
  `trip_id` int(11) DEFAULT NULL,
  `trip_order` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk1_idx` (`trip_id`),
  CONSTRAINT `fk` FOREIGN KEY (`trip_id`) REFERENCES `provider_estimate` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
