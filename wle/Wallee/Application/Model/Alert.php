<?php
/**
 * Wallee OXID
 *
 * This OXID module enables to process payments with Wallee (https://www.wallee.com/).
 *
 * @package Whitelabelshortcut\Wallee
 * @author customweb GmbH (http://www.customweb.com/)
 * @license http://www.apache.org/licenses/LICENSE-2.0  Apache Software License (ASL 2.0)
 */

namespace Wle\Wallee\Application\Model;
require_once(OX_BASE_PATH . 'modules/wle/Wallee/autoload.php');


/**
 * Class Alert.
 */
class Alert
{
    const KEY_MANUAL_TASK = 'manual_task';

    protected static function getTableName()
    {
        return 'wleWallee_alert';
    }

    public static function setCount($key, $count) {
        $count = (int)$count;
        $key = \oxdb::getDb()->quote($key);
        $query = "UPDATE `wleWallee_alert` SET `wlecount`=$count WHERE `wlekey`=$key;";
        return \oxdb::getDb()->execute($query) === 1;
    }

    public static function modifyCount($key, $countModifier = 1) {
        $countModifier = (int)$countModifier;
        $key = \oxdb::getDb()->quote($key);
        $query = "UPDATE `wleWallee_alert` SET `WLECOUNT`=`WLECOUNT`+$countModifier WHERE `wlekey`=$key;";
        return \oxdb::getDb()->execute($query) === 1;
    }

    public static function loadAll() {
        $query = "SELECT `WLEKEY`, `WLECOUNT`, `WLEFUNC`, `WLETARGET` FROM `wleWallee_alert`";
        return \oxdb::getDb()->getAll($query);
    }
}