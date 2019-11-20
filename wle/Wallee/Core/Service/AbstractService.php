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


namespace Wle\Wallee\Core\Service;
require_once(OX_BASE_PATH . 'modules/wle/Wallee/autoload.php');

use Wallee\Sdk\Model\CriteriaOperator;
use Wallee\Sdk\Model\EntityQueryFilter;
use Wallee\Sdk\Model\EntityQueryFilterType;

/**
 * Class PaymentService
 * Handles api interactions regarding payment methods.
 *
 * @codeCoverageIgnore
 */
abstract class AbstractService
{
    private static $instances = array();

    /**
     * @return static
     */
    public static function instance() {
        $class = get_called_class();
        if(!isset(self::$instances[$class])) {
            self::$instances[$class] = new $class();
        }
        return self::$instances[$class];
    }

    /**
     * Creates and returns a new entity filter.
     *
     * @param string $fieldName
     * @param mixed $value
     * @param string $operator
     * @return EntityQueryFilter
     */
    protected function createEntityFilter($fieldName, $value, $operator = CriteriaOperator::EQUALS)
    {
        $filter = new EntityQueryFilter();
        /** @noinspection PhpParamsInspection */
        $filter->setType(EntityQueryFilterType::LEAF);
        /** @noinspection PhpParamsInspection */
        $filter->setOperator($operator);
        $filter->setFieldName($fieldName);
        $filter->setValue($value);
        return $filter;
    }
}