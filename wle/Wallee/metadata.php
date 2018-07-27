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
require_once('wallee-sdk/autoload.php');



/**
 * Metadata version
 */
$sMetadataVersion = '1.1';

/**
 * Module information
 */
$aModule = array(
    'id' => 'wleWallee',
    'title' => array(
        'de' => 'WLE :: Wallee',
        'en' => 'WLE :: Wallee'
    ),
    'description' => array(
        'de' => 'WLE Wallee Module',
        'en' => 'WLE Wallee Module'
    ),
    'thumbnail' => 'out/pictures/picture.png',
    'version' => '1.0.8',
    'author' => 'customweb GmbH',
    'url' => 'https://www.customweb.com',
    'email' => 'info@customweb.com',
    'extend' => array(
    	'oxorder' => 'wle/Wallee/Extend/Application/Model/wlewallee_oxorder',
    	'oxpaymentlist' => 'wle/Wallee/Extend/Application/Model/wlewallee_payment_list',
    	'oxbasketitem' => 'wle/Wallee/Extend/Application/Model/wlewallee_oxbasketitem',
    	'oxstart' => 'wle/Wallee/Extend/Application/Controller/wlewallee_start',
    	'basket' => 'wle/Wallee/Extend/Application/Controller/wlewallee_basket',
    	'order' => 'wle/Wallee/Extend/Application/Controller/wlewallee_order',
    	'login' => 'wle/Wallee/Extend/Application/Controller/Admin/wlewallee_login',
    	'module_config' => 'wle/Wallee/Extend/Application/Controller/Admin/wlewallee_module_config',
    	'navigation' => 'wle/Wallee/Extend/Application/Controller/Admin/wlewallee_navigation',
    	'order_list' => 'wle/Wallee/Extend/Application/Controller/Admin/wlewallee_order_list',
    ),
	'files' => array(
		'WleWalleeSetup' => 'wle/Wallee/Core/WleWalleeSetup.php',
		'wle_wallee_Webhook' => 'wle/Wallee/Application/Controller/wle_wallee_Webhook.php',
		'wle_wallee_Pdf' => 'wle/Wallee/Application/Controller/wle_wallee_Pdf.php',
		'wle_wallee_Alert' => 'wle/Wallee/Application/Controller/Admin/wle_wallee_Alert.php',
		'wle_wallee_RefundJob' => 'wle/Wallee/Application/Controller/Admin/wle_wallee_RefundJob.php',
		'wle_wallee_Transaction' => 'wle/Wallee/Application/Controller/Admin/wle_wallee_Transaction.php',
    ),
    'templates' => array(
    	'wleWalleeCheckoutBasket.tpl' => 'wle/Wallee/Application/views/pages/wleWalleeCheckoutBasket.tpl',
        'wleWalleeCheckoutBasket.tpl' => 'wle/Wallee/Application/views/pages/wleWalleeCheckoutBasket.tpl',
        'wleWalleeCron.tpl' => 'wle/Wallee/Application/views/pages/wleWalleeCron.tpl',
        'wleWalleeError.tpl' => 'wle/Wallee/Application/views/pages/wleWalleeError.tpl',
        'wleWalleeTransaction.tpl' => 'wle/Wallee/Application/views/admin/tpl/wleWalleeTransaction.tpl',
        'wleWalleeRefundJob.tpl' => 'wle/Wallee/Application/views/admin/tpl/wleWalleeRefundJob.tpl',
    	'wleWalleeOrderList.tpl' => 'wle/Wallee/Application/views/admin/tpl/wleWalleeOrderList.tpl',
    	'wleWalleeHeader.tpl' => 'wle/Wallee/Application/views/admin/tpl/wleWalleeHeader.tpl',
    ),
    'blocks' => array(
        array(	
            'template' => 'page/checkout/order.tpl',
            'block' => 'checkout_order_btn_confirm_bottom',
            'file' => 'Application/views/blocks/wleWallee_checkout_order_btn_confirm_bottom.tpl'
        ),
        array(
            'template' => 'layout/base.tpl',
            'block' => 'base_js',
            'file' => 'Application/views/blocks/wleWallee_include_cron.tpl'
        ),
        array(
            'template' => 'login.tpl',
            'block' => 'admin_login_form',
            'file' => 'Application/views/blocks/wleWallee_include_cron.tpl'
        ),
        array(
            'template' => 'wleWalleeHeader.tpl',
            'block' => 'admin_header_links',
            'file' => 'Application/views/blocks/wleWallee_admin_header_links.tpl'
        ),
    	array(
    		'template' => 'page/account/order.tpl',
    		'block' => 'account_order_history',
    		'file' => 'Application/views/blocks/wleWallee_account_order_history.tpl'
    	),
    ),
    'settings' => array(
    	array(
    		'group' => 'wleWalleewalleeSettings',
    		'name' => 'wleWalleeSpaceId',
    		'type' => 'str',
    		'value' => ''
    	),
        array(
            'group' => 'wleWalleewalleeSettings',
            'name' => 'wleWalleeUserId',
            'type' => 'str',
            'value' => ''
        ),
    	array(
    		'group' => 'wleWalleewalleeSettings',
    		'name' => 'wleWalleeAppKey',
    		'type' => 'str',
    		'value' => ''
    	),
        array(
            'group' => 'wleWalleewalleeSettings',
            'name' => 'wleWalleeSpaceViewId',
            'type' => 'str',
            'value' => ''
        ),
        array(
            'group' => 'wleWalleeShopSettings',
            'name' => 'wleWalleeEmailConfirm',
            'type' => 'bool',
            'value' => true
        ),
        array(
            'group' => 'wleWalleeShopSettings',
            'name' => 'wleWalleeInvoiceDoc',
            'type' => 'bool',
            'value' => true
        ),
        array(
            'group' => 'wleWalleeShopSettings',
            'name' => 'wleWalleePackingDoc',
            'type' => 'bool',
            'value' => true
        ),
        array(
            'group' => 'wleWalleeShopSettings',
            'name' => 'wleWalleeLogLevel',
            'type' => 'select',
            'value' => 'Error',
            'constrains' => 'Error|Info|Debug'
        )
    ),
    'events' => array(
        'onActivate' => 'WleWalleeSetup::onActivate',
        'onDeactivate' => 'WleWalleeSetup::onDeactivate'
    ),
    'transaction_states' => array(
        'WALLEE_' . \Wallee\Sdk\Model\TransactionState::DECLINE,
        'WALLEE_' . \Wallee\Sdk\Model\TransactionState::FULFILL,
        'WALLEE_' . \Wallee\Sdk\Model\TransactionState::COMPLETED,
        'WALLEE_' . \Wallee\Sdk\Model\TransactionState::PENDING,
        'WALLEE_' . \Wallee\Sdk\Model\TransactionState::FAILED,
        'WALLEE_' . \Wallee\Sdk\Model\TransactionState::AUTHORIZED,
        'WALLEE_' . \Wallee\Sdk\Model\TransactionState::CONFIRMED,
        'WALLEE_' . \Wallee\Sdk\Model\TransactionState::VOIDED,
        'WALLEE_' . \Wallee\Sdk\Model\TransactionState::PROCESSING
    )
);