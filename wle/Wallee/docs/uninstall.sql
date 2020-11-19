DROP INDEX idx_wle_oxorder_oxtransstatus ON `oxorder`;

-- not required to persist following tables after uninstall
DROP TABLE `wleWallee_alert`;
DROP TABLE `wleWallee_cron`;