# OXID 4.8

v1.0.2, 2018-5

## Prerequisites
1. If you don't already have one, link:https://app-wallee.com/user/signup[create a wallee account], set up a space and sign up for an OXID account.
2. Create an application user that is allowed to access the space you want to link to the OXID store. Navigate to your wallee account > application user and create your application user. The user ID and the authentication key will be shown to you. Make sure to write this information down.
3. Make sure that you grant the application users the necessary rights (Account Admin) in order to configure the webhooks, payment methods etc. out of your OXID store.
4. Setup at least one processor, one payment method and a connector configuration. You can manually do this or step throught the wizard. More information about the processor concept can be found in the link:https://app-wallee.com/doc/payment/processor-concept[documentation].

## Installation

1. Upload the extension files to your store's modules directory using FTP/SSH.
	* If you are using OXID 6.x you can install the plugin using composer as an alternative: `composer require wallee/oxid-4.8`
2. Login to the backend of your OXID store.

## Configuration

1. Navigate to Extensions > Modules > WLE :: wallee in your Oxid backend and activate the module.
2. Switch to the settings of the activated module and enter your previously created wallee credentials.
3. If you are using EE with multistore, the settings under 'Global Settings' are shared over all stores. You may use different spaces to configure different behaviours.
4. After saving the configuration, the payment methods settings are synchronized between wallee and your OXID store, including webhooks and payment methods.
NOTE: Payment methods will not be immediately available in your store, see [Activate Payment Methods](#activate-payment-methods)
5. Optionally disable downloading invoice and packing slip. These settings enable customers to download the documents from their order overview in the OXID frontend.
6. Optionally change the debug level which increases what information is logged in your /logs folder.

### Payment Method Configuration

All settings configured in wallee will be synchronized to the store. This includes translations, provided the languages are supported by the OXID store. These settings may be overwritten, which will affect the OXID store but not the wallee configurations. 

#### Activate Payment Methods

1. Navigate to Shop Settings > Shipping Methods and select the shipping method where the payment method(s) should be available.
2. Switch to the 'Payment' tab, and select 'Assign Payment Methods'
3. Drag the wallee payment methods which should be available into the right column.

## Features

Here we will list the features which merchants may interact with in their OXID store.

### Transaction overview
From the OXID backend order list you can view different information regarding the transaction. This includes standard information such as the current transaction state, the amount, the used payment method and a link to the transaction in the wallee backend.
Additionally, you are able to download transaction relevant documents such as the invoice or packing slip.

### Completion
Depending on the payment connector configuration the transaction must be completed manually. This button will appear in the transaction overview if the transaction is in the correct state.

### Void
Depending on the payment connector configuration the transaction must be completed manually. If for some reason you wish not to complete the transaction (fraud, stock management, etc.), you may initiate a void instead of a completion. This button will appear in the transaction overview if the transaction is in the correct state.

### Refund
Once a transaction has been completed you may wish to refund part of or the whole transaction.

The refunds work using reductions. You may either refund line items by quantity, or reduce the amount paid.

### Manual Tasks

wallee can be configured so that certain actions or states result in 'Manual Tasks'. If any such 'Manual Tasks' occur, you will generally be notified by email. Additionally, we will display the number of open 'Manual Tasks' in your OXID backend in the header area.

### Transaction Documents

Depending on the configurations customers are able to download their invoice and packing slips from the order overview. As a merchant you can access these through the transaction overview.