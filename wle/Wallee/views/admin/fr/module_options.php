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
$sLangName = 'Français';

$aLang = array(
    'charset' => 'UTF-8',
    'wleWallee' => 'WLE Wallee',
	
	'SHOP_MODULE_GROUP_wleWalleewalleeSettings' => 'wallee Réglages',
	'SHOP_MODULE_GROUP_wleWalleeShopSettings' => 'Paramètres de la boutique',
	'SHOP_MODULE_GROUP_wleWalleeSpaceViewSettings' => 'Options d\'affichage de l\'espace',
	'SHOP_MODULE_wleWalleeAppKey' => 'Authentication Key',
	'SHOP_MODULE_wleWalleeUserId' => 'User Id',
    'SHOP_MODULE_wleWalleeSpaceId' => 'Space Id',
	'SHOP_MODULE_wleWalleeSpaceViewId' => 'Space View Id',
	'SHOP_MODULE_wleWalleeEmailConfirm' => 'E-mail de confirmation',
	'SHOP_MODULE_wleWalleeInvoiceDoc' => 'Document de facturation',
	'SHOP_MODULE_wleWalleePackingDoc' => 'Document d\'emballage',
	'SHOP_MODULE_wleWalleeEnforceConsistency' => 'Appliquer la cohérence',
    'SHOP_MODULE_wleWalleeLogLevel' => 'Log Level',
    'SHOP_MODULE_wleWalleeLogLevel_' => ' - ',
    'SHOP_MODULE_wleWalleeLogLevel_Error' => 'Error',
    'SHOP_MODULE_wleWalleeLogLevel_Debug' => 'Debug',
	'SHOP_MODULE_wleWalleeLogLevel_Info' => 'Info',
	
	'HELP_SHOP_MODULE_wleWalleeUserId' => 'L\'utilisateur a besoin d\'une autorisation complète dans l\'espace auquel la boutique est liée.',
	'HELP_SHOP_MODULE_wleWalleeSpaceViewId' => 'L\'ID de vue de l\'espace permet de contrôler le style du formulaire de paiement et de la page de paiement dans l\'espace. Dans les configurations multi-boutiques, cela permet d\'adapter le formulaire de paiement à différents styles par sous-magasin sans nécessiter d\'espace dédié.',
	'HELP_SHOP_MODULE_wleWalleeEmailConfirm' => 'Vous pouvez désactiver l\'e-mail de confirmation de commande OXID pour les transactions wallee.',
	'HELP_SHOP_MODULE_wleWalleeInvoiceDoc' => 'Vous pouvez autoriser les clients à télécharger des factures dans leur espace de compte.',
	'HELP_SHOP_MODULE_wleWalleePackingDoc' => 'Vous pouvez autoriser les clients à télécharger les bordereaux d\'expédition dans leur espace de compte.',
	'HELP_SHOP_MODULE_wleWalleeEnforceConsistency' => 'Exiger que les rubriques de la transaction correspondent à celles du bon de commande dans Magento. Il peut en résulter que les méthodes de paiement wallee ne sont pas disponibles pour le client dans certains cas. En retour, il est garanti que seules des données correctes sont transmises à wallee.',
	
	'wle_wallee_Settings saved successfully.' => 'Paramètres enregistrés avec succès.',
	'wle_wallee_Payment methods successfully synchronized.' => 'Modes de paiement synchronisés avec succès.',
	'wle_wallee_Webhook URL updated.' => 'URL du webhook mise à jour.',
	//TODO remove uneeded
	
	'wle_wallee_Download Invoice' => 'Télécharger la facture',
	'wle_wallee_Download Packing Slip' => 'Télécharger le bordereau d\'expédition',
	'wle_wallee_Delivery Fee' => 'Frais de livraison',
	'wle_wallee_Payment Fee' => 'Frais de paiement',
	'wle_wallee_Gift Card' => 'Carte cadeau',
	'wle_wallee_Wrapping Fee' => 'Frais d\'emballage',
	'wle_wallee_Total Discount' => 'Remise totale',
	'wle_wallee_VAT' => 'VAT',
	'wle_wallee_Order already exists. Please check if you have already received a confirmation, then try again.' => 'La commande existe déjà. Veuillez vérifier si vous avez déjà reçu une confirmation, puis réessayez.',
	'wle_wallee_Unable to load transaction !id in space !space.' => 'Impossible de charger la transaction !id dans l\'espace !space',
	'wle_wallee_Manual Tasks (!count)' => 'Tâches manuelles (!count)',
	'wle_wallee_Unable to confirm order in state !state.' => 'Impossible de confirmer la commande dans l\'état !state.',
	'wle_wallee_Not a wallee order.' => 'Pas une commande wallee.',
	'wle_wallee_An unknown error occurred, and the order could not be loaded.' => 'Une erreur inconnue s\'est produite et la commande n\'a pas pu être chargée.',
	'wle_wallee_Successfully created and sent completion job !id.' => 'Tâche d\'achèvement créée et envoyée avec succès !id.',
	'wle_wallee_Successfully created and sent void job !id.' => 'Travail annulé créé et envoyé avec succès !id.',
	'wle_wallee_Successfully created and sent refund job !id.' => 'La tâche de remboursement a bien été créée et envoyée !id.',
	'wle_wallee_Unable to load transaction for order !id.' => 'Impossible de charger la transaction pour la commande !id.',
	'wle_wallee_Completions' => 'Achèvements',
	'wle_wallee_Completion' => 'Achèvement',
	'wle_wallee_Refunds' => 'Remboursements',
	'wle_wallee_Voids' => 'Vides',
	'wle_wallee_Completion #!id' => 'Achèvement #!id',
	'wle_wallee_Refund #!id' => 'Rembourser #!id',
	'wle_wallee_Void #!id' => 'Vide #!id',
	'wle_wallee_Transaction information' => 'Informations sur les transactions',
	'wle_wallee_Authorization amount' => 'Montant de l\'autorisation',
	'wle_wallee_The amount which was authorized with the wallee transaction.' => 'Le montant qui a été autorisé avec la transaction wallee.',
	'wle_wallee_Transaction #!id' => 'Transaction #!id',
	'wle_wallee_Status' => 'Statut',
	'wle_wallee_Status in the wallee system.' => 'Statut dans le système wallee.',
	'wle_wallee_Payment method' => 'Mode de paiement',
	'wle_wallee_Open in your wallee backend.' => 'Ouvrir dans votre backend wallee.',
	'wle_wallee_Open' => 'Ouvrir',
	'wle_wallee_wallee Link' => 'Lien wallee',
	
	// tpl translations
	'wle_wallee_Restock' => 'Réapprovisionner',
	'wle_wallee_Total' => 'Total',
	'wle_wallee_Reset' => 'Réinitialiser',
	'wle_wallee_Full' => 'Plein',
	'wle_wallee_Empty refund not permitted' => 'Remboursement vide non autorisé.',
	'wle_wallee_Void' => 'Vide',
	'wle_wallee_Complete' => 'Complet',
	'wle_wallee_Refund' => 'Rembourser',
	'wle_wallee_Name' => 'Nom',
	'wle_wallee_SKU' => 'SKU',
	'wle_wallee_Quantity' => 'Quantité',
	'wle_wallee_Reduction' => 'Réduction',
	'wle_wallee_Refund amount' => 'Montant du remboursement',
	
	// menu
	'wle_wallee_transaction_title' => 'wallee Transaction'
);