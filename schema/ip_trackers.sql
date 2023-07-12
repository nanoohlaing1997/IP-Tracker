--
-- Table structure for table `ip_trackers`
--

DROP TABLE IF EXISTS `ip_trackers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ip_trackers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ip` varchar(255) NOT NULL,
  `user_id` int(10) NOT NULL DEFAULT -1,
  `city` varchar(255) NOT NULL,
  `region` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `country_code` varchar(20) NOT NULL,
  `latitude` float(10,6) NOT NULL,
  `longitude` float(10,6) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=innodb AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */

CREATE INDEX user_id ON ip_trackers (user_id);
CREATE INDEX city ON ip_trackers (city);
CREATE INDEX country ON ip_trackers (country);
CREATE INDEX country_code ON ip_trackers (country_code);
CREATE INDEX latitude ON ip_trackers (latitude);
CREATE INDEX longitude ON ip_trackers (longitude);
CREATE INDEX latitude_longitude ON ip_trackers (latitude_longitude);
