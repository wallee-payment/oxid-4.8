ALTER TABLE `wleWallee_transaction`
	MODIFY `OXID` char(32) CHARSET latin1 COLLATE latin1_general_ci DEFAULT '',
	MODIFY `OXORDERID` char(32) CHARSET latin1 COLLATE latin1_general_ci DEFAULT '',
	MODIFY `WLEUPDATED` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	MODIFY `WLEVERSION` int(11) DEFAULT '0';
	
ALTER TABLE `wleWallee_completionjob`
	MODIFY `OXID` char(32) CHARSET latin1 COLLATE latin1_general_ci DEFAULT '',
	MODIFY `OXORDERID` char(32) CHARSET latin1 COLLATE latin1_general_ci DEFAULT '',
	MODIFY `WLEUPDATED` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;
	
ALTER TABLE `wleWallee_voidjob`
	MODIFY `OXID` char(32) CHARSET latin1 COLLATE latin1_general_ci DEFAULT '',
	MODIFY `OXORDERID` char(32) CHARSET latin1 COLLATE latin1_general_ci DEFAULT '',
	MODIFY `WLEUPDATED` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;
	
ALTER TABLE `wleWallee_cron`
	MODIFY `OXID` char(32) CHARSET latin1 COLLATE latin1_general_ci DEFAULT '';

ALTER TABLE `wleWallee_refundjob`
	MODIFY `OXID` char(32) CHARSET latin1 COLLATE latin1_general_ci DEFAULT '',
	MODIFY `OXORDERID` char(32) CHARSET latin1 COLLATE latin1_general_ci DEFAULT '',
	MODIFY `WLEUPDATED` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;

ALTER TABLE `wleWallee_alert`
	MODIFY `WLEUPDATED` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;

CREATE TABLE IF NOT EXISTS `wleWallee_token` (
  `WLETOKENID` bigint(20) unsigned NOT NULL,
  `WLESTATE` varchar(255) NOT NULL,
  `WLESPACEID` bigint(20) unsigned NOT NULL,
  `WLENAME` longtext,
  `WLECUSTOMERID` bigint(20) unsigned NOT NULL,
  `WLEPAYMENTMETHODID` bigint(20) unsigned NOT NULL,
  `WLECONNECTORID` bigint(20) unsigned NOT NULL,
  `WLEUPDATED` TIMESTAMP NOT NULL DEFAULT now() ON UPDATE now(),
  PRIMARY KEY (`WLETOKENID`),
  INDEX (`WLETOKENID`, `WLESPACEID`),
) ENGINE=InnoDB DEFAULT CHARSET=utf8;