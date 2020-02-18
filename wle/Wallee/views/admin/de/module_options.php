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


$sLangName = 'Deutsch';

$aLang = array(
    'charset' => 'UTF-8',
    'wleWallee' => 'WLE Wallee',

    'SHOP_MODULE_GROUP_wleWalleewalleeSettings' => 'wallee Einstellungen',
	'SHOP_MODULE_GROUP_wleWalleeShopSettings' => 'Shop Einstellungen',
	'SHOP_MODULE_GROUP_wleWalleeSpaceSettings' => 'Space View Id',
    'SHOP_MODULE_wleWalleeAppKey' => 'Authentication Key',
	'SHOP_MODULE_wleWalleeUserId' => 'Benutzer Id',
    'SHOP_MODULE_wleWalleeSpaceId' => 'Space Id',
	'SHOP_MODULE_wleWalleeSpaceViewViewId' => 'Space View Optionen',
    'SHOP_MODULE_wleWalleeEmailConfirm' => 'Email Bestätigung',
    'SHOP_MODULE_wleWalleeInvoiceDoc' => 'Rechnung',
    'SHOP_MODULE_wleWalleePackingDoc' => 'Lieferschein',
	'SHOP_MODULE_wleWalleeEnforceConsistency' => 'Konsistenz sicherstellen',
    'SHOP_MODULE_wleWalleeLogLevel' => 'Log Level',
    'SHOP_MODULE_wleWalleeLogLevel_' => ' - ',
    'SHOP_MODULE_wleWalleeLogLevel_Error' => 'Error',
    'SHOP_MODULE_wleWalleeLogLevel_Debug' => 'Debug',
    'SHOP_MODULE_wleWalleeLogLevel_Info' => 'Info',
	
	
	'HELP_SHOP_MODULE_wleWalleeUserId' => 'Der Benutzer benötigt volle Berechtigungen auf dem verbundenen space.',
	'HELP_SHOP_MODULE_wleWalleeSpaceViewId' => 'Die Space View ID lässt das Gestalten der Zahlungsformulare und -seiten innerhalb eines Spaces. Dies kann u.A. für Multishopsysteme die unterschiedliche Aussehen haben sollten verwendet werden.',	'HELP_SHOP_MODULE_wleWalleeEmailConfirm' => 'You may deactivate the OXID order confirmation email for wallee transactions.',
	'HELP_SHOP_MODULE_wleWalleeInvoiceDoc' => 'Sie können ihren Kunden erlauben Rechnungen für Ihre Bestellungen im Frontend-Bereich herunterzuladen.',
	'HELP_SHOP_MODULE_wleWalleePackingDoc' => 'Sie können ihren Kunden erlauben Lieferscheine für Ihre Bestellungen im Frontend-Bereich herunterzuladen.',
	'HELP_SHOP_MODULE_wleWalleeEmailConfirm' => 'Sie können OXID Bestellbestätigungen für wallee Transaktionen unterbinden.',
	'HELP_SHOP_MODULE_wleWalleeEnforceConsistency' => 'Erfordere, dass die Einzelposten der Transaktion denen der Bestellung in Magento entsprechen. Dies kann dazu führen, dass die Zahlungsmethoden von wallee dem Kunden in bestimmten Fällen nicht zur Verfügung stehen. Im Gegenzug wird sichergestellt, dass nur korrekte Daten an wallee übertragen werden.',
	
	'wle_wallee_Settings saved successfully.' => 'Die Einstellungen wurden erfolgreich gespeichert.',
	'wle_wallee_Payment methods successfully synchronized.' => 'Die Zahlarten wurden synchronisiert.',
	'wle_wallee_Webhook URL updated.' => 'Webhook URL wurde aktualisiert.',
	//TODO remove unneeded
	
	'wle_wallee_Download Invoice' => 'Rechnung herunterladen',
	'wle_wallee_Download Packing Slip' => 'Lieferschein herunterladen',
	'wle_wallee_Delivery Fee' => 'Liefergebühr',
	'wle_wallee_Payment Fee' => 'Zahlartgebühr',
	'wle_wallee_Gift Card' => 'Geschenkkarte',
	'wle_wallee_Wrapping Fee' => 'Packgebühr',
	'wle_wallee_Total Discount' => 'Gesamte Rabatte',
	'wle_wallee_VAT' => 'MwSt.',
	'wle_wallee_Order already exists. Please check if you have already received a confirmation, then try again.' => 'Die Bestellung existiert bereits. Bitte prüfen Sie ob sie eine Bestätigung erhalten haben, und versuchen Sie es erneut wenn nicht.',
	'wle_wallee_Unable to load transaction !id in space !space.' => 'Transaktion konnte nicht geladen werden (Transaktion: !id. Space: !space)',
	'wle_wallee_Manual Tasks (!count)' => 'Manuelle Aufgaben (!count)',
	'wle_wallee_Unable to confirm order in state !state.' => 'Bestellung im status !state kann nicht bestätigt werden.',
	'wle_wallee_Not a wallee order.' => 'Nicht eine wallee Bestellung.',
	'wle_wallee_An unknown error occurred, and the order could not be loaded.' => 'Ein unbekannter Fehler ist aufgetreten und die Bestellung konnte nicht geladen werden.',
	'wle_wallee_Successfully created and sent completion job !id.' => 'Bestätigung (!id) erfolgreich erstellt und versandt.',
	'wle_wallee_Successfully created and sent void job !id.' => 'Storno (!id) erfolgreich erstellt und versandt.',
	'wle_wallee_Successfully created and sent refund job !id.' => 'Rückerstattung (!id) erfolgreich erstellt und versandt.',
	'wle_wallee_Unable to load transaction for order !id.' => 'Transaktion für die Bestellung !id konnte nicht geladen werden.',
	'wle_wallee_Completions' => 'Bestätigungen',
	'wle_wallee_Completion #!id' => 'Bestätigung #!id',
	'wle_wallee_Refunds' => 'Rückerstattungen',
	'wle_wallee_Refund #!id' => 'Rückerstattung #!id',
	'wle_wallee_Voids' => 'Stornos',
	'wle_wallee_Void #!id' => 'Storno #!id',
	'wle_wallee_Transaction information' => 'Transaktionsinformation',
	'wle_wallee_Authorization amount' => 'Authorisierter Betrag',
	'wle_wallee_The amount which was authorized with the wallee transaction.' => 'Der Betrag der durch die wallee transaktion authorisiert wurde.',
	'wle_wallee_Transaction #!id' => 'Transaktion #!id',
	'wle_wallee_Status' => 'Status',
	'wle_wallee_Status in the wallee system.' => 'Status in dem wallee system.',
	'wle_wallee_Payment method' => 'Payment method',
	'wle_wallee_Open in your wallee backend.' => 'Öffne im wallee backend.',
	'wle_wallee_Open' => 'Öffnen',
	'wle_wallee_wallee Link' => 'wallee Link',
	
	// tpl translations
	'wle_wallee_Restock' => 'Lagerbestand wiederherstellen',
	'wle_wallee_Total' => 'Total',
	'wle_wallee_Reset' => 'Zurücksetzen',
	'wle_wallee_Full' => 'Volle Rückerstattung',
	'wle_wallee_Empty refund not permitted' => 'Eine leere Rückerstattung kann nicht erstellt werden.',
	'wle_wallee_Void' => 'Storno',
	'wle_wallee_Complete' => 'Bestätigen',
	'wle_wallee_Refund' => 'Rückerstatten',
	'wle_wallee_Name' => 'Name',
	'wle_wallee_SKU' => 'SKU',
	'wle_wallee_Quantity' => 'Quantität',
	'wle_wallee_Reduction' => 'Reduktion',
	'wle_wallee_Refund amount' => 'Rückerstattungsbetrag',
	
	// menu
	'wle_wallee_transaction_title' => 'wallee Transaktion');