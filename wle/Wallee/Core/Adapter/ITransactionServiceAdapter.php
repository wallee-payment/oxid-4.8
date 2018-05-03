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

namespace Wle\Wallee\Core\Adapter;
require_once(OX_BASE_PATH . 'modules/wle/Wallee/autoload.php');

use \Wle\Wallee\Application\Model\Transaction;

/**
 * Interface ITransactionServiceAdapter
 * Defines which methods must be implemented to be consumed with Wallee SDK.
 *
 * @codeCoverageIgnore
 */
interface ITransactionServiceAdapter {

	function getCreateData();

	function getUpdateData(Transaction $transaction);
}