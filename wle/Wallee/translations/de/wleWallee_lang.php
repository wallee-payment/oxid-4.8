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
	
	'wle_wallee_Downloads' => 'Dokumente herunterladen',
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
	'wle_wallee_transaction_title' => 'wallee Transaktion'
);