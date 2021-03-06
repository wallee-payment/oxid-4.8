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
$sLangName = 'English';

$aLang = array(
    'charset' => 'UTF-8',
    'wleWallee' => 'WLE Wallee',
	
	'SHOP_MODULE_GROUP_wleWalleewalleeSettings' => 'wallee Settings',
	'SHOP_MODULE_GROUP_wleWalleeShopSettings' => 'Shop Settings',
	'SHOP_MODULE_GROUP_wleWalleeSpaceViewSettings' => 'Space View Options',
	'SHOP_MODULE_wleWalleeAppKey' => 'Authentication Key',
	'SHOP_MODULE_wleWalleeUserId' => 'User Id',
    'SHOP_MODULE_wleWalleeSpaceId' => 'Space Id',
	'SHOP_MODULE_wleWalleeSpaceViewId' => 'Space View Id',
	'SHOP_MODULE_wleWalleeEmailConfirm' => 'Email Confirm',
	'SHOP_MODULE_wleWalleeInvoiceDoc' => 'Invoice Doc',
	'SHOP_MODULE_wleWalleePackingDoc' => 'Packing Doc',
	'SHOP_MODULE_wleWalleeEnforceConsistency' => 'Enforce consistency',
    'SHOP_MODULE_wleWalleeLogLevel' => 'Log Level',
    'SHOP_MODULE_wleWalleeLogLevel_' => ' - ',
    'SHOP_MODULE_wleWalleeLogLevel_Error' => 'Error',
    'SHOP_MODULE_wleWalleeLogLevel_Debug' => 'Debug',
	'SHOP_MODULE_wleWalleeLogLevel_Info' => 'Info',
	
	'HELP_SHOP_MODULE_wleWalleeUserId' => 'The user requires full permission in the space the shop is linked to.',
	'HELP_SHOP_MODULE_wleWalleeSpaceViewId' => 'The space view ID allows to control the styling of the payment form and the payment page within the space. In multi shop setups it allows to adapt the payment form to different styling per sub store without requiring a dedicated space.',
	'HELP_SHOP_MODULE_wleWalleeEmailConfirm' => 'You may deactivate the OXID order confirmation email for wallee transactions.',
	'HELP_SHOP_MODULE_wleWalleeInvoiceDoc' => 'You may allow customers to download invoices in their account area.',
	'HELP_SHOP_MODULE_wleWalleePackingDoc' => 'You may allow customers to download packing slips in their account area.',
	'HELP_SHOP_MODULE_wleWalleeEnforceConsistency' => 'Require that the line items of the transaction correspond to those of the purchase order in Magento. This may result in the wallee payment methods not being available to the customer in certain cases. In return, it is ensured that only correct data is transmitted to wallee.',
	
	'wle_wallee_Settings saved successfully.' => 'Settings saved successfully.',
	'wle_wallee_Payment methods successfully synchronized.' => 'Payment methods successfully synchronized.',
	'wle_wallee_Webhook URL updated.' => 'Webhook URL updated.',
	//TODO remove uneeded
	
	'wle_wallee_Download Invoice' => 'Download Invoice',
	'wle_wallee_Download Packing Slip' => 'Download Packing Slip',
	'wle_wallee_Delivery Fee' => 'Delivery Fee',
	'wle_wallee_Payment Fee' => 'Payment Fee',
	'wle_wallee_Gift Card' => 'Gift Card',
	'wle_wallee_Wrapping Fee' => 'Wrapping Fee',
	'wle_wallee_Total Discount' => 'Total Discount',
	'wle_wallee_VAT' => 'VAT',
	'wle_wallee_Order already exists. Please check if you have already received a confirmation, then try again.' => 'Order already exists. Please check if you have already received a confirmation, then try again.',
	'wle_wallee_Unable to load transaction !id in space !space.' => 'Unable to load transaction !id in space !space',
	'wle_wallee_Manual Tasks (!count)' => 'Manual Tasks (!count)',
	'wle_wallee_Unable to confirm order in state !state.' => 'Unable to confirm order in state !state.',
	'wle_wallee_Not a wallee order.' => 'Not a wallee order.',
	'wle_wallee_An unknown error occurred, and the order could not be loaded.' => 'An unknown error occurred, and the order could not be loaded.',
	'wle_wallee_Successfully created and sent completion job !id.' => 'Successfully created and sent completion job !id.',
	'wle_wallee_Successfully created and sent void job !id.' => 'Successfully created and sent void job !id.',
	'wle_wallee_Successfully created and sent refund job !id.' => 'Successfully created and sent refund job !id.',
	'wle_wallee_Unable to load transaction for order !id.' => 'Unable to load transaction for order !id.',
	'wle_wallee_Completions' => 'Completions',
	'wle_wallee_Completion' => 'Completion',
	'wle_wallee_Refunds' => 'Refunds',
	'wle_wallee_Voids' => 'Voids',
	'wle_wallee_Completion #!id' => 'Completion #!id',
	'wle_wallee_Refund #!id' => 'Refund #!id',
	'wle_wallee_Void #!id' => 'Void #!id',
	'wle_wallee_Transaction information' => 'Transaction information',
	'wle_wallee_Authorization amount' => 'Authorization amount',
	'wle_wallee_The amount which was authorized with the wallee transaction.' => 'The amount which was authorized with the wallee transaction.',
	'wle_wallee_Transaction #!id' => 'Transaction #!id',
	'wle_wallee_Status' => 'Status',
	'wle_wallee_Status in the wallee system.' => 'Status in the wallee system.',
	'wle_wallee_Payment method' => 'Payment method',
	'wle_wallee_Open in your wallee backend.' => 'Open in your wallee backend.',
	'wle_wallee_Open' => 'Open',
	'wle_wallee_wallee Link' => 'wallee Link',
	
	// tpl translations
	'wle_wallee_Restock' => 'Restock',
	'wle_wallee_Total' => 'Total',
	'wle_wallee_Reset' => 'Reset',
	'wle_wallee_Full' => 'Full',
	'wle_wallee_Empty refund not permitted' => 'Empty refund not permitted.',
	'wle_wallee_Void' => 'Void',
	'wle_wallee_Complete' => 'Complete',
	'wle_wallee_Refund' => 'Refund',
	'wle_wallee_Name' => 'Name',
	'wle_wallee_SKU' => 'SKU',
	'wle_wallee_Quantity' => 'Quantity',
	'wle_wallee_Reduction' => 'Reduction',
	'wle_wallee_Refund amount' => 'Refund amount',
	
	// menu
	'wle_wallee_transaction_title' => 'wallee Transaction'
);