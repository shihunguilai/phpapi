CREATE TABLE if not exists `shihunguilai_session` (												
   session_id varchar(255) NOT NULL,
     session_expire int(11) NOT NULL,
       session_data blob,
       UNIQUE KEY `session_id` (`session_id`)									
	) ENGINE=InnoDB DEFAULT CHARSET=utf8; 