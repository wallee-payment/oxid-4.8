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
$sLangName = 'Italiano';

$aLang = array(
    'charset' => 'UTF-8',
    'wleWallee' => 'WLE Wallee',
	
	'SHOP_MODULE_GROUP_wleWalleewalleeSettings' => 'wallee Impostazioni',
	'SHOP_MODULE_GROUP_wleWalleeShopSettings' => 'Impostazioni del negozio',
	'SHOP_MODULE_GROUP_wleWalleeSpaceViewSettings' => 'Opzioni di visualizzazione dello spazio',
	'SHOP_MODULE_wleWalleeAppKey' => 'Authentication Key',
	'SHOP_MODULE_wleWalleeUserId' => 'User Id',
    'SHOP_MODULE_wleWalleeSpaceId' => 'Space Id',
	'SHOP_MODULE_wleWalleeSpaceViewId' => 'Space View Id',
	'SHOP_MODULE_wleWalleeEmailConfirm' => 'E-mail di conferma',
	'SHOP_MODULE_wleWalleeInvoiceDoc' => 'Fattura doc',
	'SHOP_MODULE_wleWalleePackingDoc' => 'Imballaggio Doc',
	'SHOP_MODULE_wleWalleeEnforceConsistency' => 'Imponi la coerenza',
    'SHOP_MODULE_wleWalleeLogLevel' => 'Log Level',
    'SHOP_MODULE_wleWalleeLogLevel_' => ' - ',
    'SHOP_MODULE_wleWalleeLogLevel_Error' => 'Error',
    'SHOP_MODULE_wleWalleeLogLevel_Debug' => 'Debug',
	'SHOP_MODULE_wleWalleeLogLevel_Info' => 'Info',
	
	'HELP_SHOP_MODULE_wleWalleeUserId' => 'L\'utente richiede l\'autorizzazione completa nello spazio a cui è collegato il negozio.',
	'HELP_SHOP_MODULE_wleWalleeSpaceViewId' => 'L\'ID vista spazio consente di controllare lo stile del modulo di pagamento e della pagina di pagamento all\'interno dello spazio. Nelle configurazioni multi negozio permette di adattare il modulo di pagamento a stili differenti per sub store senza richiedere uno spazio dedicato..',
	'HELP_SHOP_MODULE_wleWalleeEmailConfirm' => 'È possibile disattivare l\'e-mail di conferma dell\'ordine OXID per le transazioni wallee.',
	'HELP_SHOP_MODULE_wleWalleeInvoiceDoc' => 'Puoi consentire ai clienti di scaricare le fatture nella loro area account.',
	'HELP_SHOP_MODULE_wleWalleePackingDoc' => 'Puoi consentire ai clienti di scaricare i documenti di trasporto nell\'area del loro account.',
	'HELP_SHOP_MODULE_wleWalleeEnforceConsistency' => 'Richiedi che le voci della transazione corrispondano a quelle dell\'ordine di acquisto in Magento. Ciò potrebbe comportare che i metodi di pagamento wallee non siano disponibili per il cliente in alcuni casi. In cambio, è garantito che solo i dati corretti vengano trasmessi a wallee..',
	
	'wle_wallee_Settings saved successfully.' => 'Impostazioni salvate correttamente.',
	'wle_wallee_Payment methods successfully synchronized.' => 'Metodi di pagamento sincronizzati con successo.',
	'wle_wallee_Webhook URL updated.' => 'URL webhook aggiornato.',
	//TODO remove uneeded
	
	'wle_wallee_Download Invoice' => 'Scarica fattura',
	'wle_wallee_Download Packing Slip' => 'Scarica fattura',
	'wle_wallee_Delivery Fee' => 'Tassa di consegna',
	'wle_wallee_Payment Fee' => 'Commissione di pagamento',
	'wle_wallee_Gift Card' => 'Commissione di pagamento',
	'wle_wallee_Wrapping Fee' => 'Spese di confezionamento',
	'wle_wallee_Total Discount' => 'Sconto totale',
	'wle_wallee_VAT' => 'VAT',
	'wle_wallee_Order already exists. Please check if you have already received a confirmation, then try again.' => 'L\'ordine esiste già. Verifica di aver già ricevuto una conferma, quindi riprova.',
	'wle_wallee_Unable to load transaction !id in space !space.' => 'Impossibile caricare la transazione !id nello spazio !space',
	'wle_wallee_Manual Tasks (!count)' => 'Compiti manuali (!count)',
	'wle_wallee_Unable to confirm order in state !state.' => 'Impossibile confermare l\'ordine nello stato !state.',
	'wle_wallee_Not a wallee order.' => 'Non un ordine wallee.',
	'wle_wallee_An unknown error occurred, and the order could not be loaded.' => 'Si è verificato un errore sconosciuto e non è stato possibile caricare l\'ordine.',
	'wle_wallee_Successfully created and sent completion job !id.' => 'Lavoro di completamento creato e inviato con successo !id.',
	'wle_wallee_Successfully created and sent void job !id.' => 'Lavoro annullato creato e inviato con successo !id.',
	'wle_wallee_Successfully created and sent refund job !id.' => 'Lavoro di rimborso creato e inviato con successo !id.',
	'wle_wallee_Unable to load transaction for order !id.' => 'Impossibile caricare la transazione per l\'ordine !id.',
	'wle_wallee_Completions' => 'Completamenti',
	'wle_wallee_Completion' => 'Completamento',
	'wle_wallee_Refunds' => 'Refunds',
	'wle_wallee_Voids' => 'Rimborsi',
	'wle_wallee_Completion #!id' => 'Completamento #!id',
	'wle_wallee_Refund #!id' => 'Refund #!id',
	'wle_wallee_Void #!id' => 'Vuoto #!id',
	'wle_wallee_Transaction information' => 'Informazioni sulla transazione',
	'wle_wallee_Authorization amount' => 'Authorization amount',
	'wle_wallee_The amount which was authorized with the wallee transaction.' => 'L\'importo autorizzato con la transazione wallee.',
	'wle_wallee_Transaction #!id' => 'Transazione #!id',
	'wle_wallee_Status' => 'Stato',
	'wle_wallee_Status in the wallee system.' => 'Stato nel sistema wallee.',
	'wle_wallee_Payment method' => 'Metodo di pagamento',
	'wle_wallee_Open in your wallee backend.' => 'Apri nel tuo back-end wallee.',
	'wle_wallee_Open' => 'Aprire',
	'wle_wallee_wallee Link' => 'wallee Collegamento',
	
	// tpl translations
	'wle_wallee_Restock' => 'Rifornire',
	'wle_wallee_Total' => 'Totale',
	'wle_wallee_Reset' => 'Ripristina',
	'wle_wallee_Full' => 'Pieno',
	'wle_wallee_Empty refund not permitted' => 'Rimborso vuoto non consentito.',
	'wle_wallee_Void' => 'Vuoto',
	'wle_wallee_Complete' => 'Completare',
	'wle_wallee_Refund' => 'Rimborso',
	'wle_wallee_Name' => 'Nome',
	'wle_wallee_SKU' => 'SKU',
	'wle_wallee_Quantity' => 'Quantità',
	'wle_wallee_Reduction' => 'Riduzione',
	'wle_wallee_Refund amount' => 'Importo rimborsato',
	
	// menu
	'wle_wallee_transaction_title' => 'wallee Transazione'
);