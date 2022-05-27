

CREATE TABLE `drive_files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `google_drive_file_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


INSERT INTO drive_files VALUES
("1","about_img.webp","","2022-05-26 10:22:26"),
("2","about_img.webp","","2022-05-26 11:32:04");




CREATE TABLE `table1` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `phone` bigint(15) NOT NULL,
  `Date-Time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;






CREATE TABLE `table2` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `place` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `order_no` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




