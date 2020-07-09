CREATE TABLE `users` ( 
	`id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY, 
	`username` varchar(100) NOT NULL, 
	`email` varchar(100) NOT NULL, 
	`initial_lat` float(13,10) NOT NULL, 
	`initial_lng` float(13,10) NOT NULL, 
	`api1` varchar(100) NOT NULL, 
	`api2` varchar(100) NOT NULL, 
	`password` varchar(100) NOT NULL
) 
