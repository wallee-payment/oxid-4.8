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
/**
 * Wallee
 *
 * This module allows you to interact with the Wallee payment service using OXID eshop.
 * Using this module requires a Wallee account (https://app-wallee.com/user/signup)
 *
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @category module
 * @package Wallee
 * @author customweb GmbH
 * @link commercialWebsiteUrl
 * @copyright (C) customweb GmbH 2018
 */
namespace Wle\Wallee\Core\Exception;
require_once(OX_BASE_PATH . 'modules/wle/Wallee/autoload.php');

class OptimisticLockingException extends \Exception {
	private $query;

	public function __construct($id, $table, $query){
		$this->query = $query;
		parent::__construct("Optimistic locking failed for $table with id $id.");
	}

	public function getQueryString(){
		return $this->query;
	}
}