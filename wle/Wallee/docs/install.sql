CREATE TABLE IF NOT EXISTS `wleWallee_transaction` (
  `OXID` char(32) NOT NULL,
  `OXORDERID` char(32) NOT NULL,
  `WLETRANSACTIONID` bigint(20) unsigned NOT NULL,
  `WLESTATE` varchar(255) NOT NULL,
  `WLESPACEID` bigint(20) unsigned NOT NULL,
  `WLESPACEVIEWID` bigint(20) unsigned DEFAULT NULL,
  `WLEFAILUREREASON` longtext,
  `WLETEMPBASKET` longtext,
  `WLEVERSION` int(11) NOT NULL DEFAULT 0,
  `WLEUPDATED` TIMESTAMP NOT NULL DEFAULT now() ON UPDATE now(),
  PRIMARY KEY (`OXID`),
  UNIQUE KEY `unq_transaction_id_space_id` (`WLETRANSACTIONID`,`WLESPACEID`),
  UNIQUE KEY `unq_order_id` (`OXORDERID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `wleWallee_completionjob` (
  `OXID` char(32) NOT NULL,
  `OXORDERID` char(32) NOT NULL,
  `WLETRANSACTIONID` bigint(20) unsigned NOT NULL,
  `WLEJOBID` bigint(20) unsigned,
  `WLESTATE` varchar(255) NOT NULL,
  `WLESPACEID` bigint(20) unsigned NOT NULL,
  `WLEFAILUREREASON` longtext,
  `WLEUPDATED` TIMESTAMP NOT NULL DEFAULT now() ON UPDATE now(),
  PRIMARY KEY (`OXID`),
  INDEX `unq_job_id_space_id` (`WLEJOBID`,`WLESPACEID`),
  INDEX `idx_order_id` (`OXORDERID`),
  INDEX `idx_state` (`WLESTATE`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `wleWallee_voidjob` (
  `OXID` char(32) NOT NULL,
  `OXORDERID` char(32) NOT NULL,
  `WLETRANSACTIONID` bigint(20) unsigned NOT NULL,
  `WLEJOBID` bigint(20) unsigned,
  `WLESTATE` varchar(255) NOT NULL,
  `WLESPACEID` bigint(20) unsigned NOT NULL,
  `WLEFAILUREREASON` longtext,
  `WLEUPDATED` TIMESTAMP NOT NULL DEFAULT now() ON UPDATE now(),
  PRIMARY KEY (`OXID`),
  INDEX `unq_job_id_space_id` (`WLEJOBID`,`WLESPACEID`),
  INDEX `idx_order_id` (`OXORDERID`),
  INDEX `idx_state` (`WLESTATE`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `wleWallee_refundjob` (
  `OXID` char(32) NOT NULL,
  `OXORDERID` char(32) NOT NULL,
  `WLETRANSACTIONID` bigint(20) unsigned NOT NULL,
  `WLEJOBID` bigint(20) unsigned,
  `WLESTATE` varchar(255) NOT NULL,
  `WLESPACEID` bigint(20) unsigned NOT NULL,
  `FORMREDUCTIONS` longtext,
  `WLERESTOCK` bool NOT NULL,
  `WLEFAILUREREASON` longtext,
  `WLEUPDATED` TIMESTAMP NOT NULL DEFAULT now() ON UPDATE now(),
  PRIMARY KEY (`OXID`),
  INDEX `unq_job_id_space_id` (`WLEJOBID`,`WLESPACEID`),
  INDEX `idx_order_id` (`OXORDERID`),
  INDEX `idx_state` (`WLESTATE`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `wleWallee_cron` (
  `OXID` char(32) NOT NULL,
  `WLEFAILUREREASON` longtext,
  `WLESTATE` char(7),
  `WLESCHEDULED` DATETIME NOT NULL,
  `WLESTARTED` DATETIME,
  `WLECOMPLETED` DATETIME,
  `WLECONSTRAINT` SMALLINT,
  PRIMARY KEY (`OXID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `wleWallee_alert` (
  `WLEKEY` varchar(11) NOT NULL,
  `WLEFUNC` varchar(20) NOT NULL,
  `WLETARGET` varchar(20) NOT NULL,
  `WLECOUNT` int unsigned DEFAULT NULL,
  `WLEUPDATED` TIMESTAMP NOT NULL DEFAULT now() ON UPDATE now(),
  PRIMARY KEY (`WLEKEY`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO `wleWallee_alert` (`WLEKEY`, `WLEFUNC`, `WLETARGET`, `WLECOUNT`) VALUES ('manual_task', 'manualtask', '_parent', 0);

CREATE INDEX idx_oxorder_oxtransstatus ON `oxorder` (`OXTRANSSTATUS`);